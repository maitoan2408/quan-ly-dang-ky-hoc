<?php
require_once 'Database.php';

class StudentModel extends Database {

     
// 1. Lấy thông tin hồ sơ sinh viên dựa vào ID tài khoản đăng nhập
    public function getStudentProfileByUserId($userId) {
        $conn = $this->getConnection();
        if($conn) {
            $query = "SELECT sv.*, tk.email, tk.mat_khau
                      FROM sinh_vien sv
                      JOIN tai_khoan tk ON sv.id_tai_khoan = tk.id
                      WHERE tk.id = :user_id";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':user_id', $userId);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }

    public function getStudentProgram($studentId) {
        $conn = $this->getConnection();
        if($conn) {
            $query = "SELECT DISTINCT mh.chuong_trinh_hoc
                      FROM dang_ky_hoc dkh
                      JOIN lop_hoc lh ON lh.id_lop_hoc = dkh.id_lop_hoc
                      JOIN mon_hoc mh ON mh.id_mon_hoc = lh.id_mon_hoc
                      WHERE dkh.id_sinh_vien = :student_id
                      LIMIT 1";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':student_id', $studentId);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? $result['chuong_trinh_hoc'] : 'Chưa xác định';
        }
        return 'Chưa xác định';
    }


    public function getStudentEnrolledCourses($studentId) {
    $conn = $this->getConnection();
    if (!$conn) return [];

    $query = "SELECT 
                mh.ma_mon_hoc, 
                mh.ten_mon_hoc, 
                mh.so_tin_chi,
                lh.ten_giang_vien, 
                lh.phong_hoc,
                GROUP_CONCAT(DISTINCT lic.thu) as thu,
                MIN(lic.gio_vao_hoc) as gio_vao_hoc,
                MAX(lic.gio_ra_ve) as gio_ra_ve
              FROM dang_ky_hoc dkh
              JOIN lop_hoc lh ON dkh.id_lop_hoc = lh.id_lop_hoc
              JOIN mon_hoc mh ON lh.id_mon_hoc = mh.id_mon_hoc
              LEFT JOIN lich_hoc lic ON lh.id_lop_hoc = lic.id_lop_hoc
              WHERE dkh.id_sinh_vien = :student_id 
                AND dkh.trang_thai = 'Thành công'
              GROUP BY lh.id_lop_hoc";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(':student_id', $studentId);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

 public function getClassesForRegistration($studentId, $programFilter = null) {
    $conn = $this->getConnection();
    if (!$conn) return [];

    $stmtSem = $conn->prepare("SELECT id_ky_hoc FROM ky_hoc WHERE trang_thai_dang_ky = 'Đang mở' LIMIT 1");
    $stmtSem->execute();
    $current = $stmtSem->fetch(PDO::FETCH_ASSOC);

    if (!$current) return [];

    $sql = "SELECT 
            lh.id_lop_hoc AS id_lop, 
            lh.ma_lop_hoc,
            lh.ten_giang_vien, 
            lh.phong_hoc,
            lh.si_so_toi_da,
            lh.si_so_da_dang_ky,
            mh.ma_mon_hoc,
            mh.ten_mon_hoc, 
            mh.so_tin_chi,
            GROUP_CONCAT(lic.thu ORDER BY lic.thu SEPARATOR ', ') as cac_thu,
            MIN(lic.gio_vao_hoc) as gio_bat_dau,
            MAX(lic.gio_ra_ve) as gio_ket_thuc,
            MIN(lic.ngay_bat_dau) as ngay_mo_dau,
            MAX(lic.ngay_ket_thuc) as ngay_be_mac,
            
            -- SỬA Ở ĐÂY: Ép kiểu rõ ràng và dùng COALESCE
            COALESCE(
                (SELECT trang_thai 
                 FROM dang_ky_hoc 
                 WHERE id_lop_hoc = lh.id_lop_hoc 
                   AND id_sinh_vien = :student_id 
                 LIMIT 1), 
                'Chua_dang_ky'
            ) AS trang_thai_dang_ky

        FROM lop_hoc lh
        JOIN mon_hoc mh ON lh.id_mon_hoc = mh.id_mon_hoc
        LEFT JOIN lich_hoc lic ON lh.id_lop_hoc = lic.id_lop_hoc
        WHERE 1=1";

    $params = [':student_id' => $studentId];

    if ($programFilter) {
        $sql .= " AND mh.chuong_trinh_hoc = :program";
        $params[':program'] = $programFilter;
    }

    $sql .= " GROUP BY lh.id_lop_hoc ORDER BY mh.ten_mon_hoc ASC";

    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    public function checkUnpaidFees($studentId) {
        // ... (giữ nguyên hàm của bạn)
        $conn = $this->getConnection();
        if (!$conn) return false;

        $query = "SELECT SUM(mh.so_tin_chi * 540000) as unpaid_total 
                  FROM hoc_phi hp
                  JOIN dang_ky_hoc dkh ON hp.id_sinh_vien = dkh.id_sinh_vien 
                  JOIN lop_hoc lh ON dkh.id_lop_hoc = lh.id_lop_hoc
                  JOIN mon_hoc mh ON lh.id_mon_hoc = mh.id_mon_hoc
                  WHERE hp.id_sinh_vien = :student_id 
                  AND hp.da_thanh_toan = 0 
                  AND dkh.trang_thai = 'Thành công'";
        
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':student_id', $studentId);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return ($result['unpaid_total'] ?? 0) > 0;
    }
    public function getAllCourses($programFilter = 'all', $searchTerm = null) {
    $conn = $this->getConnection();
    if (!$conn) return [];

    $sql = "SELECT ma_mon_hoc, ten_mon_hoc, so_tin_chi, chuong_trinh_hoc 
            FROM mon_hoc WHERE 1=1";
    $params = [];

    // Lọc theo chương trình
    if ($programFilter !== 'all' && !empty($programFilter)) {
        $sql .= " AND chuong_trinh_hoc = :program";
        $params[':program'] = $programFilter;
    }

    // Lọc theo từ khóa tìm kiếm
    if (!empty($searchTerm)) {
        $sql .= " AND (ten_mon_hoc LIKE :search OR ma_mon_hoc LIKE :search)";
        $params[':search'] = "%" . $searchTerm . "%";
    }

    $sql .= " ORDER BY ten_mon_hoc ASC";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
public function getDistinctPrograms() {
    $conn = $this->getConnection();
    if ($conn) {
        // Lấy các giá trị không trùng lặp từ cột chuong_trinh_hoc
        $query = "SELECT DISTINCT chuong_trinh_hoc FROM mon_hoc WHERE chuong_trinh_hoc IS NOT NULL";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
    return [];
}
  


}
?>