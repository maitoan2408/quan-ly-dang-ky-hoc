<?php
require_once 'Database.php';

class AdminModel extends Database {

    public function getQuickStats() {
        $conn = $this->getConnection();
        
        $sqlLop = "SELECT 
                    COUNT(DISTINCT ten_giang_vien) as total_gv, 
                    COUNT(*) as total_classes, 
                    SUM(si_so_da_dang_ky) as total_reg 
                   FROM lop_hoc";
        
        $sqlMon = "SELECT COUNT(*) as total_subjects FROM mon_hoc";

        $resLop = $conn->query($sqlLop)->fetch(PDO::FETCH_ASSOC);
        $resMon = $conn->query($sqlMon)->fetch(PDO::FETCH_ASSOC);

        return [
            'lecturers' => $resLop['total_gv'],
            'classes'   => $resLop['total_classes'],
            'subjects'  => $resMon['total_subjects'],
            'reg_count' => $resLop['total_reg']
        ];
    }

    public function getEnrollmentByDepartment() {
        $conn = $this->getConnection();
        $query = "SELECT 
                    mh.chuong_trinh_hoc, 
                    COUNT(DISTINCT mh.id_mon_hoc) as total_courses, 
                    SUM(lh.si_so_da_dang_ky) as total_students
                  FROM mon_hoc mh
                  LEFT JOIN lop_hoc lh ON mh.id_mon_hoc = lh.id_mon_hoc
                  WHERE mh.chuong_trinh_hoc IS NOT NULL
                  GROUP BY mh.chuong_trinh_hoc";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRegistrationStatusStats() {
        $conn = $this->getConnection();
        $query = "SELECT 
                    SUM(si_so_da_dang_ky) as registered,
                    SUM(si_so_toi_da - si_so_da_dang_ky) as pending
                  FROM lop_hoc";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: ['registered' => 0, 'pending' => 0];
    }

    public function getCourseEnrollmentSummary() {
        $conn = $this->getConnection();
        $query = "SELECT mh.ma_mon_hoc, mh.ten_mon_hoc, mh.chuong_trinh_hoc,
                         lh.ten_giang_vien, lh.si_so_toi_da, lh.si_so_da_dang_ky
                  FROM lop_hoc lh
                  JOIN mon_hoc mh ON mh.id_mon_hoc = lh.id_mon_hoc
                  ORDER BY (lh.si_so_da_dang_ky / lh.si_so_toi_da) DESC";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>