<?php
namespace App\Controllers;

use App\Models\BookingCustomerModel;
use App\Models\BookingModel;
use App\Models\TourModel;

class BookingCustomerController extends BaseController
{
    protected $bookingCustomer;

    public function __construct()
    {
        $this->bookingCustomer = new BookingCustomerModel();
    }

    // 1. Danh sách khách trong booking
    public function listBookingCustomers()
    {
        $booking_id = $_GET['booking_id'] ?? null;
        
        $filter_tour_id   = $_GET['filter_tour_id'] ?? null;
        $filter_start_date = $_GET['filter_start_date'] ?? null;
        $filter_end_date   = $_GET['filter_end_date'] ?? null;

        if ($booking_id) {
            $customers = $this->bookingCustomer->getCustomersByBooking($booking_id);
        } else {
            $customers = $this->bookingCustomer->getAllBookingCustomers($filter_tour_id, $filter_start_date, $filter_end_date);
        }

        $tours = (new TourModel())->getAllTours();

        return $this->render('admin.bookingCus.listBookCus', [
            'customers' => $customers, 
            'booking_id' => $booking_id,
            'tours' => $tours,
            'filter_tour_id' => $filter_tour_id,
            'filter_start_date' => $filter_start_date,
            'filter_end_date' => $filter_end_date
        ]);
    }

    // 2. Form thêm khách
    public function createBookingCustomer()
    {
        $bookings  = (new BookingModel())->getAllBookings();

        return $this->render('admin.bookingCus.addBookCus', [
            'bookings'  => $bookings
        ]);
    }

    // 3. Xử lý thêm khách
    public function postBookingCustomer()
    {
        $error = [];

        $booking_id  = $_POST['booking_id'] ?? '';
        $fullname    = $_POST['fullname'] ?? '';
        $phone       = $_POST['phone'] ?? '';
        $id_card     = $_POST['id_card'] ?? '';
        $gender      = $_POST['gender'] ?? '';
        $dob         = $_POST['dob'] ?? '';
        $note        = $_POST['note'] ?? null;

        // Validate
        if (empty($booking_id)) {
            $error['booking_id'] = "Booking không được bỏ trống.";
        }
        if (empty($fullname)) {
            $error['fullname'] = "Tên khách hàng không được bỏ trống.";
        }
        if (empty($gender) || !in_array($gender, ['male','female','other'])) {
            $error['gender'] = "Giới tính không hợp lệ.";
        }
        if (empty($dob)) {
            $error['dob'] = "Ngày sinh không được bỏ trống.";
        }

        // Validate Limit Check
        if (!empty($booking_id)) {
            $currentCustomers = $this->bookingCustomer->getCustomersByBooking($booking_id);
            $booking = (new BookingModel())->getBookingById($booking_id);
            
            if ($booking && count($currentCustomers) >= $booking->num_people) {
                 redirect('errors', "Số lượng khách đã đạt giới hạn ({$booking->num_people} người).", 'add-booking-customer');
            }
        }

        if (!empty($error)) {
            redirect('errors', $error, 'add-booking-customer');
        }

        $check = $this->bookingCustomer->addBookingCustomer([
            'booking_id'  => $booking_id,
            'fullname'    => $fullname,
            'phone'       => $phone,
            'id_card'     => $id_card,
            'gender'      => $gender,
            'dob'         => $dob,
            'note'        => $note,
            'created_at'  => date("Y-m-d H:i:s"),
            'updated_at'  => date("Y-m-d H:i:s")
        ]);

        if ($check) {
            redirect('success', "Thêm khách vào booking thành công", 'list-booking-customer');
        } else {
            redirect('errors', "Thêm khách thất bại", 'add-booking-customer');
        }
    }

    // 4. Chi tiết khách để sửa
    public function detailBookingCustomer($id)
    {
        $detail    = $this->bookingCustomer->getBookingCustomerById($id);
        $bookings  = (new BookingModel())->getAllBookings();

        return $this->render('admin.bookingCus.editBookCus', [
            'detail'    => $detail,
            'bookings'  => $bookings
        ]);
    }

    // 5. Xử lý sửa khách
    public function editBookingCustomer($id)
    {
        if (!isset($_POST['btn-submit'])) return;

        $error = [];

        $booking_id  = $_POST['booking_id'] ?? '';
        $fullname    = $_POST['fullname'] ?? '';
        $gender      = $_POST['gender'] ?? '';
        $dob         = $_POST['dob'] ?? '';
        $note        = $_POST['note'] ?? null;

        // Validate
        if (empty($booking_id)) {
            $error['booking_id'] = "Booking không được bỏ trống.";
        }
        if (empty($fullname)) {
            $error['fullname'] = "Tên khách hàng không được bỏ trống.";
        }
        if (empty($gender) || !in_array($gender, ['male','female','other'])) {
            $error['gender'] = "Giới tính không hợp lệ.";
        }
        if (empty($dob)) {
            $error['dob'] = "Ngày sinh không được bỏ trống.";
        }

        $route = 'detail-booking-customer/' . $id;
        if (!empty($error)) {
            redirect('errors', $error, $route);
        }

        $check = $this->bookingCustomer->updateBookingCustomer($id, [
            'booking_id'  => $booking_id,
            'fullname'    => $fullname,
            'gender'      => $gender,
            'dob'         => $dob,
            'note'        => $note,
            'updated_at'  => date("Y-m-d H:i:s")
        ]);

        if ($check) {
            redirect('success', "Cập nhật khách thành công", 'list-booking-customer');
        } else {
            redirect('errors', "Cập nhật khách thất bại", $route);
        }
    }

    // 6. Xóa khách
    public function deleteBookingCustomer($id)
    {
        $check = $this->bookingCustomer->deleteBookingCustomer($id);

        if ($check) {
            redirect('success', "Xóa khách thành công", 'list-booking-customer');
        } else {
            redirect('errors', "Xóa khách thất bại", 'list-booking-customer');
        }
    }
    // 7. Import CSV
    public function importBookingCustomer()
    {
        $booking_id = $_POST['booking_id'] ?? '';
        $file = $_FILES['csv_file'] ?? null;

        if (empty($booking_id)) {
            redirect('errors', "Vui lòng chọn Booking.", 'add-booking-customer');
        }

        if (!$file || $file['error'] != 0) {
            redirect('errors', "Lỗi khi upload file.", 'add-booking-customer');
        }

        $filename = $file['tmp_name'];
        if ($_FILES['csv_file']['size'] > 0) {
            $file = fopen($filename, "r");
            
            // Skip header row
            fgetcsv($file);

            $count = 0;
            $errors = [];

            while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {
                // Expected format: Name, Phone, ID Card, Gender, DOB, Note
                // Map indices: 0->Name, 1->Phone, 2->ID, 3->Gender, 4->DOB, 5->Note
                
                $fullname = trim($data[0] ?? '');
                $phone    = trim($data[1] ?? '');
                $id_card  = trim($data[2] ?? '');
                $gender   = strtolower(trim($data[3] ?? ''));
                $dob      = trim($data[4] ?? '');
                $note     = trim($data[5] ?? '');

                if (empty($fullname)) continue;

                // Handle Date Format (support d/m/Y and convert to Y-m-d)
                if (!empty($dob)) {
                    // Try to parse basic formats
                    $timestamp = strtotime(str_replace('/', '-', $dob));
                    if ($timestamp) {
                        $dob = date('Y-m-d', $timestamp);
                    } else {
                        $dob = null; // Invalid date
                    }
                }

                // Basic validation for gender
                if (!in_array($gender, ['male', 'female', 'other', 'nam', 'nu', 'khac'])) {
                    $gender = 'other';
                }
                // Convert nam/nu to male/female
                if ($gender == 'nam') $gender = 'male';
                if ($gender == 'nu' || $gender == 'nữ') $gender = 'female';
                if ($gender == 'khac' || $gender == 'khác') $gender = 'other';

                // Insert
                $this->bookingCustomer->addBookingCustomer([
                    'booking_id' => $booking_id,
                    'fullname'   => $fullname,
                    'phone'      => $phone,
                    'id_card'    => $id_card,
                    'gender'     => $gender,
                    'dob'        => $dob ?: null,
                    'note'       => $note,
                    'created_at' => date("Y-m-d H:i:s")
                ]);
                $count++;
            }
            
            fclose($file);
            
            if ($count > 0) {
                redirect('success', "Đã import thành công $count khách hàng.", 'list-booking-customer?booking_id=' . $booking_id);
            } else {
                redirect('errors', "Không đọc được dữ liệu nào từ file.", 'add-booking-customer');
            }

        } else {
            redirect('errors', "File trống.", 'add-booking-customer');
        }
    }
}
?>
