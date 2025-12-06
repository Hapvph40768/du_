<?php
namespace App\Controllers;

use App\Models\AttendanceModel;

class AttendanceController extends BaseController
{
    protected $attendance;

    public function __construct()
    {
        $this->attendance = new AttendanceModel();
    }

    // Hiển thị danh sách điểm danh theo departure
    public function listByDeparture($departure_id)
    {
        $sql = "
            SELECT a.*, bc.fullname
            FROM attendance a
            JOIN booking_customers bc ON a.customer_id = bc.id
            WHERE a.departure_id = ?
        ";
        $this->attendance->setQuery($sql);
        $attendances = $this->attendance->loadAllRows([$departure_id]);

        $this->render("attendance.listAttendance", [
            'attendances' => $attendances,
            'departureId' => $departure_id
        ]);
    }

    // Hiển thị form thêm attendance
    public function createAttendance($departure_id)
{
    $customers = $this->attendance->getCustomersByDeparture($departure_id); // lấy khách theo departure
    $this->render('attendance.addAttendance', [
        'departureId' => $departure_id,
        'customers' => $customers
    ]);
}

    // Xử lý lưu attendance mới
    public function postAttendance($departure_id)
{
    // Lấy dữ liệu từ POST
    $customer_id = $_POST['customer_id'];
    $status = $_POST['status'] ?? 'pending';

    $this->attendance->addAttendance([
        'departure_id' => $departure_id,
        'customer_id' => $customer_id,
        'status' => $status,
        'created_at' => date("Y-m-d H:i:s"),
        'updated_at' => date("Y-m-d H:i:s")
    ]);

    redirect('success', 'Thêm điểm danh thành công', "list-attendance/$departure_id");
}


    // Hiển thị chi tiết / sửa attendance
    public function detailAttendance($id)
    {
        $detail = $this->attendance->getAttendanceById($id);
        return $this->render("attendance.editAttendance", [
            'detail' => $detail
        ]);
    }

    // Xử lý cập nhật attendance
    public function editAttendance($id)
    {
        if (isset($_POST['btn-submit'])) {
            $error = [];

            $validStatus = ['present', 'absent', 'late'];
            $status = $_POST['status'] ?? 'present';
            if (!in_array($status, $validStatus)) {
                $error['status'] = "Trạng thái không hợp lệ";
            }

            if (!empty($error)) {
                redirect('error', $error, "detail-attendance/" . $id);
            } else {
                $check = $this->attendance->updateAttendance($id, [
                    'departure_id' => $_POST['departure_id'],
                    'customer_id' => $_POST['customer_id'],
                    'status' => $status,
                    'updated_at' => date("Y-m-d H:i:s")
                ]);
                if ($check) {
                    redirect('success', "Cập nhật thành công", "list-attendance/" . $_POST['departure_id']);
                } else {
                    redirect('error', "Cập nhật thất bại", "detail-attendance/" . $id);
                }
            }
        }
    }

    // Xóa attendance
    public function deleteAttendance($id)
    {
        $attendance = $this->attendance->getAttendanceById($id);
        $departure_id = $attendance['departure_id'] ?? 0;

        $check = $this->attendance->deleteAttendance($id);
        if ($check) {
            redirect('success', "Xóa thành công", "list-attendance/" . $departure_id);
        } else {
            redirect('error', "Xóa thất bại", "list-attendance/" . $departure_id);
        }
    }

    // Lưu điểm danh nhiều khách cùng lúc
    public function save()
    {
        $error = [];
        $validStatus = ['present', 'absent', 'late'];

        foreach ($_POST['attendance'] as $id => $status) {
            if (!in_array($status, $validStatus)) {
                $error[$id] = "Trạng thái không hợp lệ cho khách $id";
            }
        }

        if (!empty($error)) {
            redirect('error', $error, "list-attendance/" . $_POST['departure_id']);
        }

        foreach ($_POST['attendance'] as $id => $status) {
            $this->attendance->updateAttendance($id, [
                'departure_id' => $_POST['departure_id'],
                'customer_id' => $_POST['customer'][$id],
                'status' => $status,
                'updated_at' => date("Y-m-d H:i:s")
            ]);
        }

        redirect('success', "Điểm danh thành công!", "list-attendance/" . $_POST['departure_id']);
    }
}
