<?php
namespace App\Models;

/**
 * Class TourSupplierModel
 * Quản lý các thao tác CRUD với bảng 'tour_suppliers'
 */
class TourSupplierModel extends BaseModel
{
    protected $table = "tour_suppliers";

    /**
     * Lấy tất cả bản ghi tour_suppliers (kèm thông tin supplier)
     * @return array
     */
    public function getAll()
    {
        $sql = "SELECT ts.*, s.name AS supplier_name, s.type AS supplier_type, s.phone AS supplier_phone
                FROM $this->table ts
                LEFT JOIN suppliers s ON ts.supplier_id = s.id";
        $this->setQuery($sql);
        return $this->loadAllRows();
    }

    /**
     * Lấy danh sách nhà cung cấp theo tour_id
     * @param int $tour_id
     * @return array
     */
    public function getByTourId($tour_id)
    {
        $sql = "SELECT ts.*, s.name AS supplier_name, s.type AS supplier_type, s.phone AS supplier_phone
                FROM $this->table ts
                JOIN suppliers s ON ts.supplier_id = s.id
                WHERE ts.tour_id = ?";
        $this->setQuery($sql);
        return $this->loadAllRows([$tour_id]);
    }

    /**
     * Lấy 1 bản ghi theo id
     * @param int $id
     * @return object|bool
     */
    public function getById($id)
    {
        $sql = "SELECT ts.*, s.name AS supplier_name, s.type AS supplier_type, s.phone AS supplier_phone
                FROM $this->table ts
                LEFT JOIN suppliers s ON ts.supplier_id = s.id
                WHERE ts.id = ?";
        $this->setQuery($sql);
        return $this->loadRow([$id]);
    }

    /**
     * Kiểm tra xem supplier đã được gán cho tour hay chưa (tránh trùng)
     * @param int $tour_id
     * @param int $supplier_id
     * @return bool
     */
    public function existsAssignment($tour_id, $supplier_id)
    {
        $sql = "SELECT COUNT(*) AS cnt FROM $this->table WHERE tour_id = ? AND supplier_id = ?";
        $this->setQuery($sql);
        $row = $this->loadRow([$tour_id, $supplier_id]);
        return $row && $row->cnt > 0;
    }

    /**
     * Thêm mới gán nhà cung cấp cho tour
     * @param int $tour_id
     * @param int $supplier_id
     * @param string $role
     * @return bool
     */
    public function addTourSupplier($tour_id, $supplier_id, $role)
    {
        $sql = "INSERT INTO $this->table (tour_id, supplier_id, role) VALUES (?, ?, ?);";
        $this->setQuery($sql);
        return $this->execute([$tour_id, $supplier_id, $role]);
    }

    /**
     * Cập nhật vai trò gán nhà cung cấp
     * @param int $id
     * @param string $role
     * @return bool
     */
    public function editTourSupplier($id, $role)
    {
        $sql = "UPDATE $this->table SET role = ? WHERE id = ?";
        $this->setQuery($sql);
        return $this->execute([$role, $id]);
    }

    /**
     * Xóa gán nhà cung cấp (hard delete)
     * @param int $id
     * @return bool
     */
    public function deleteTourSupplier($id)
    {
        $sql = "DELETE FROM $this->table WHERE id = ?";
        $this->setQuery($sql);
        return $this->execute([$id]);
    }

    /**
     * Xóa theo tour_id (dùng khi xóa tour)
     * @param int $tour_id
     * @return bool
     */
    public function deleteByTourId($tour_id)
    {
        $sql = "DELETE FROM $this->table WHERE tour_id = ?";
        $this->setQuery($sql);
        return $this->execute([$tour_id]);
    }
}
