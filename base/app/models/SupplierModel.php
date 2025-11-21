<?php 
namespace App\Models;

/**
 * Class SupplierModel
 * Quản lý các thao tác CRUD với bảng 'suppliers' (Nhà cung cấp)
 */
class SupplierModel extends BaseModel
{
    // Đặt tên bảng cơ sở dữ liệu
    protected $table = "suppliers";

    /**
     * Lấy danh sách tất cả Nhà cung cấp
     * @return array Danh sách các đối tượng Nhà cung cấp
     */
    public function getListSuppliers()
    {
        // Giả định các trường: id, name, contact_name, phone, email, status
        $sql = "SELECT * FROM $this->table";
        $this->setQuery($sql);
        return $this->loadAllRows();
    }

    /**
     * Lấy thông tin chi tiết của một Nhà cung cấp bằng ID
     * @param int $id ID của Nhà cung cấp
     * @return object|bool Thông tin chi tiết Nhà cung cấp hoặc false nếu không tìm thấy
     */
    public function getSupplierById($id)
    {
        $sql = "SELECT * FROM $this->table WHERE id = ?";
        $this->setQuery($sql);
        return $this->loadRow([$id]);
    }

    /**
     * Thêm mới một Nhà cung cấp
     * @param string $name Tên nhà cung cấp (bắt buộc)
     * @param string $contact_name Tên người liên hệ
     * @param string $phone Số điện thoại
     * @param string $email Email
     * @param int $status Trạng thái (Ví dụ: 1-Hoạt động, 0-Ngừng hợp tác)
     * @return bool Trả về kết quả thực thi (true/false)
     */
    public function addSupplier($name, $type, $phone)
    {
        // id là AUTO_INCREMENT nên không cần truyền vào
        $sql = "INSERT INTO $this->table (`name`, `type`, `phone`) VALUES (?, ?, ?)";
        $this->setQuery($sql);
        // Lưu ý: Đảm bảo thứ tự các tham số khớp với thứ tự trong câu SQL
        return $this->execute([$name, $type, $phone]);
    }

    /**
     * Cập nhật thông tin Nhà cung cấp
     * @param int $id ID của Nhà cung cấp cần chỉnh sửa
     * @param string $name Tên nhà cung cấp
     * @param string $contact_name Tên người liên hệ
     * @param string $phone Số điện thoại
     * @param string $email Email
     * @param int $status Trạng thái
     * @return bool Trả về kết quả thực thi (true/false)
     */
    public function editSupplier($id, $name, $type, $phone)
    {
        $sql = "UPDATE $this->table SET 
            `name` = ?,
            `type` = ?,
            `phone` = ?
            WHERE id = ? ";
        $this->setQuery($sql);
        // Lưu ý: Tham số cuối cùng là $id để xác định bản ghi cần UPDATE
        return $this->execute([$name, $type, $phone, $id]);
    }

    /**
     * Xóa một Nhà cung cấp bằng ID
     * Lưu ý: Trong hệ thống thực tế nên dùng UPDATE status=0 thay vì DELETE
     * @param int $id ID của Nhà cung cấp cần xóa
     * @return bool Trả về kết quả thực thi (true/false)
     */
    public function deleteSupplier($id)
    {
        $sql = "DELETE FROM $this->table WHERE id = ?";
        $this->setQuery($sql);
        return $this->execute([$id]);
    }
}