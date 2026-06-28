<?php
// Models/SemesterModel.php

require_once 'Database.php';

class SemesterModel extends Database {

    public function getAllSemesters() {
        $conn = $this->getConnection();
        $query = "SELECT * FROM ky_hoc ORDER BY id_ky_hoc DESC";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Lấy kỳ học đang mở (chỉ 1 kỳ)
     */
    public function getOpeningSemester() {
        $conn = $this->getConnection();
        $sql = "SELECT * FROM ky_hoc 
                WHERE trang_thai_dang_ky = 'Đang mở' 
                LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getRegistrationPeriodById($id) {
        $conn = $this->getConnection();
        $stmt = $conn->prepare("SELECT * FROM ky_hoc WHERE id_ky_hoc = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insertRegistrationPeriod($data) {
        $conn = $this->getConnection();
        $sql = "INSERT INTO ky_hoc 
                (ten_ky_hoc, thoi_gian_bat_dau, thoi_gian_ket_thuc, 
                 tin_chi_toi_thieu, tin_chi_toi_da, trang_thai_dang_ky) 
                VALUES 
                (:ten_ky_hoc, :thoi_gian_bat_dau, :thoi_gian_ket_thuc, 
                 :tin_chi_toi_thieu, :tin_chi_toi_da, :trang_thai_dang_ky)";

        $stmt = $conn->prepare($sql);
        return $stmt->execute([
            ':ten_ky_hoc'         => $data['ten_ky_hoc'],
            ':thoi_gian_bat_dau'  => $data['thoi_gian_bat_dau'],
            ':thoi_gian_ket_thuc' => $data['thoi_gian_ket_thuc'],
            ':tin_chi_toi_thieu'  => $data['tin_chi_toi_thieu'],
            ':tin_chi_toi_da'     => $data['tin_chi_toi_da'],
            ':trang_thai_dang_ky' => $data['trang_thai_dang_ky'] ?? 'Sắp tới'
        ]);
    }

    public function updateRegistrationPeriod($id, $data) {
        $conn = $this->getConnection();
        $sql = "UPDATE ky_hoc SET 
                ten_ky_hoc = :ten_ky_hoc, 
                thoi_gian_bat_dau = :thoi_gian_bat_dau, 
                thoi_gian_ket_thuc = :thoi_gian_ket_thuc, 
                tin_chi_toi_thieu = :tin_chi_toi_thieu, 
                tin_chi_toi_da = :tin_chi_toi_da, 
                trang_thai_dang_ky = :trang_thai_dang_ky 
                WHERE id_ky_hoc = :id";

        $stmt = $conn->prepare($sql);
        return $stmt->execute([
            ':ten_ky_hoc'         => $data['ten_ky_hoc'],
            ':thoi_gian_bat_dau'  => $data['thoi_gian_bat_dau'],
            ':thoi_gian_ket_thuc' => $data['thoi_gian_ket_thuc'],
            ':tin_chi_toi_thieu'  => $data['tin_chi_toi_thieu'],
            ':tin_chi_toi_da'     => $data['tin_chi_toi_da'],
            ':trang_thai_dang_ky' => $data['trang_thai_dang_ky'],
            ':id'                 => $id
        ]);
    }

    public function deleteRegistrationPeriod($id) {
        $conn = $this->getConnection();
        $stmt = $conn->prepare("DELETE FROM ky_hoc WHERE id_ky_hoc = :id");
        return $stmt->execute([':id' => $id]);
    }
    /**
 * Đóng tất cả các kỳ đang mở trước khi mở kỳ mới
 */
    /**
     * Đóng tất cả các kỳ đang mở trước khi mở kỳ mới
     * Đây là hàm quan trọng cho Cách 1
     */
    public function closeAllOpeningSemesters() {
        $conn = $this->getConnection();
        if (!$conn) return false;

        $sql = "UPDATE ky_hoc 
                SET trang_thai_dang_ky = 'Đã đóng' 
                WHERE trang_thai_dang_ky = 'Đang mở'";
        
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->rowCount() > 0;   // trả về true nếu có kỳ bị đóng
    }
        /**
     * Kiểm tra xem hiện tại có kỳ nào đang mở không
     */
    public function hasOpeningSemester() {
        $conn = $this->getConnection();
        if (!$conn) return false;

        $sql = "SELECT COUNT(*) as total FROM ky_hoc WHERE trang_thai_dang_ky = 'Đang mở'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return ($result['total'] ?? 0) > 0;
    }
        /**
     * Lấy ID của bản ghi vừa insert
     */
    public function getLastInsertedId() {
        $conn = $this->getConnection();
        return $conn->lastInsertId();
    }

    /**
     * Lấy ID của kỳ vừa bị đóng (kỳ cũ)
     */
    public function getPreviousOpenSemesterId() {
        $conn = $this->getConnection();
        $sql = "SELECT id_ky_hoc FROM ky_hoc 
                WHERE trang_thai_dang_ky = 'Đã đóng' 
                ORDER BY thoi_gian_ket_thuc DESC LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['id_ky_hoc'] : null;
    }

         /**
     * Cập nhật tất cả lớp học sang kỳ mới (đồng bộ id_ky_hoc)
     * Dùng khi mở kỳ mới
     */
    public function updateClassesToNewSemester($newKyHocId) {
        $conn = $this->getConnection();
        
        $sql = "UPDATE lop_hoc 
                SET id_ky_hoc = :new_id 
                WHERE id_ky_hoc != :new_id";   // tránh update thừa

        $stmt = $conn->prepare($sql);
        $stmt->execute([':new_id' => (int)$newKyHocId]);

        return $stmt->rowCount(); // trả về số lớp đã được cập nhật
    }
    /**
 * Lấy kỳ học hiện tại (ưu tiên kỳ đang mở, nếu không có thì lấy kỳ mới nhất)
 */
public function getCurrentSemester() {
    $opening = $this->getOpeningSemester();
    if ($opening) {
        return $opening;
    }

    // Nếu không có kỳ đang mở, lấy kỳ mới nhất theo thời gian
    $conn = $this->getConnection();
    $sql = "SELECT * FROM ky_hoc ORDER BY thoi_gian_bat_dau DESC LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
}