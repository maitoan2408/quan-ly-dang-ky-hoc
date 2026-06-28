<?php
require_once 'Database.php';

class RegistrationModel extends Database {

    public function registerCourse($studentId, $classId) {
    $conn = $this->getConnection();
    try {
        // Kiểm tra đã đăng ký chưa
        $check = $conn->prepare("SELECT id FROM dang_ky_hoc WHERE id_sinh_vien = :sid AND id_lop_hoc = :lid");
        $check->execute(['sid' => $studentId, 'lid' => $classId]);
        if ($check->rowCount() > 0) return false;

        // Lấy id_mon_hoc từ bảng lop_hoc
        $getMon = $conn->prepare("SELECT id_mon_hoc FROM lop_hoc WHERE id_lop_hoc = :lid");
        $getMon->execute(['lid' => $classId]);
        $monHoc = $getMon->fetch(PDO::FETCH_ASSOC);

        if (!$monHoc || !$monHoc['id_mon_hoc']) {
            return false; // Không tìm thấy môn học
        }

        $conn->beginTransaction();

        // INSERT đầy đủ các cột
        $sql1 = "INSERT INTO dang_ky_hoc 
                (id_sinh_vien, id_mon_hoc, id_lop_hoc, thoi_gian_dang_ky, trang_thai) 
                VALUES (:sid, :mid, :lid, NOW(), 'Thành công')";

        $stmt1 = $conn->prepare($sql1);
        $stmt1->execute([
            ':sid' => $studentId,
            ':mid' => $monHoc['id_mon_hoc'],
            ':lid' => $classId
        ]);

        // Tăng sĩ số
        $sql2 = "UPDATE lop_hoc SET si_so_da_dang_ky = si_so_da_dang_ky + 1 WHERE id_lop_hoc = :lid";
        $conn->prepare($sql2)->execute(['lid' => $classId]);

        $conn->commit();
        return true;

    } catch (Exception $e) {
        if ($conn->inTransaction()) $conn->rollBack();
        error_log("Lỗi đăng ký: " . $e->getMessage()); // Ghi log để debug
        return false;
    }
}

    public function cancelCourse($studentId, $classId) {
        $conn = $this->getConnection();
        try {
            $conn->beginTransaction();

            $sql1 = "DELETE FROM dang_ky_hoc WHERE id_sinh_vien = :sid AND id_lop_hoc = :lid";
            $conn->prepare($sql1)->execute(['sid' => $studentId, 'lid' => $classId]);

            $sql2 = "UPDATE lop_hoc SET si_so_da_dang_ky = si_so_da_dang_ky - 1 WHERE id_lop_hoc = :lid";
            $conn->prepare($sql2)->execute(['lid' => $classId]);

            $conn->commit();
            return true;
        } catch (Exception $e) {
            $conn->rollBack();
            return false;
        }
    }

    public function getTotalRegisteredCredits($studentId) {
        $conn = $this->getConnection();
        $sql = "SELECT SUM(mh.so_tin_chi) as total 
                FROM dang_ky_hoc dk
                JOIN lop_hoc lh ON dk.id_lop_hoc = lh.id_lop_hoc
                JOIN mon_hoc mh ON lh.id_mon_hoc = mh.id_mon_hoc
                WHERE dk.id_sinh_vien = :sid AND dk.trang_thai = 'Thành công'";
        
        $stmt = $conn->prepare($sql);
        $stmt->execute(['sid' => $studentId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result['total'] ?? 0;
    }

    public function getClassDetailById($classId) {
        $conn = $this->getConnection();
        $sql = "SELECT lh.*, mh.so_tin_chi 
                FROM lop_hoc lh 
                JOIN mon_hoc mh ON lh.id_mon_hoc = mh.id_mon_hoc 
                WHERE lh.id_lop_hoc = :lid";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['lid' => $classId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

        /**
     * Lấy danh sách học phí của sinh viên
     * Tính theo công thức: Tổng tín chỉ đăng ký × 540.000đ
     */
        /**
     * Lấy danh sách học phí của sinh viên
     */
        /**
     * Lấy danh sách học phí của sinh viên
     */
    public function getStudentFees($studentId) {
        $conn = $this->getConnection();
        if (!$conn) return [];

        $sql = "SELECT 
                    id,
                    tong_tien,
                    mien_giam,
                    da_thanh_toan,
                    thoi_gian_thanh_toan,
                    'Học kỳ hiện tại' AS ky_hoc
                FROM hoc_phi 
                WHERE id_sinh_vien = :student_id 
                ORDER BY id DESC";

        $stmt = $conn->prepare($sql);
        $stmt->execute([':student_id' => $studentId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    /**
     * Cập nhật học phí tự động = Tổng tín chỉ đã đăng ký thành công × 540.000 đ
     * Không sử dụng id_ky_hoc
     */
    public function updateStudentTuitionAuto($studentId) {
    $conn = $this->getConnection();
    if (!$conn) return false;

    try {
        $conn->beginTransaction();

        // 1. Tính TỔNG TIỀN PHẢI NỘP dựa trên tất cả môn đã đăng ký thành công
        $sqlCredits = "SELECT SUM(mh.so_tin_chi) as total_credits 
                       FROM dang_ky_hoc dkh 
                       JOIN lop_hoc lh ON dkh.id_lop_hoc = lh.id_lop_hoc 
                       JOIN mon_hoc mh ON lh.id_mon_hoc = mh.id_mon_hoc 
                       WHERE dkh.id_sinh_vien = ? AND dkh.trang_thai = 'Thành công'";
        $stmt = $conn->prepare($sqlCredits);
        $stmt->execute([$studentId]);
        $totalCredits = (int)($stmt->fetchColumn() ?? 0);
        $totalNeedToPay = $totalCredits * 540000;

        // 2. Tính TỔNG TIỀN SINH VIÊN ĐÃ NỘP (Các hóa đơn có da_thanh_toan = 1)
        $sqlPaid = "SELECT SUM(tong_tien - mien_giam) FROM hoc_phi WHERE id_sinh_vien = ? AND da_thanh_toan = 1";
        $stmtPaid = $conn->prepare($sqlPaid);
        $stmtPaid->execute([$studentId]);
        $amountAlreadyPaid = (float)($stmtPaid->fetchColumn() ?? 0);

        // 3. Tính số tiền chênh lệch (Nợ mới)
        $debt = $totalNeedToPay - $amountAlreadyPaid;

        // 4. Cập nhật hóa đơn nợ
        // Luôn xóa các khoản nợ cũ (chưa nộp) để ghi đè bằng con số nợ mới nhất
        $conn->prepare("DELETE FROM hoc_phi WHERE id_sinh_vien = ? AND da_thanh_toan = 0")->execute([$studentId]);

        if ($debt > 0) {
            // Nếu vẫn còn nợ, tạo một hóa đơn nợ mới với số tiền chênh lệch
            $insertSql = "INSERT INTO hoc_phi (id_sinh_vien, tong_tien, mien_giam, da_thanh_toan) 
                         VALUES (?, ?, 0, 0)";
            $conn->prepare($insertSql)->execute([$studentId, $debt]);
        }

        $conn->commit();
        return true;
    } catch (Exception $e) {
        if ($conn->inTransaction()) $conn->rollBack();
        error_log("Lỗi cập nhật học phí: " . $e->getMessage());
        return false;
    }
}
public function isScheduleConflicting($studentId, $classId) {
    $conn = $this->getConnection();
    
    // 1. Lấy tất cả các buổi học của lớp đang muốn đăng ký
    $sqlNewClass = "SELECT thu, gio_vao_hoc, gio_ra_ve, ngay_bat_dau, ngay_ket_thuc 
                    FROM lich_hoc WHERE id_lop_hoc = :class_id";
    $stmt1 = $conn->prepare($sqlNewClass);
    $stmt1->execute([':class_id' => $classId]);
    $newSchedules = $stmt1->fetchAll(PDO::FETCH_ASSOC);

    // 2. Lấy tất cả các buổi học của các lớp sinh viên ĐÃ đăng ký thành công
    $sqlRegistered = "SELECT lh.thu, lh.gio_vao_hoc, lh.gio_ra_ve, lh.ngay_bat_dau, lh.ngay_ket_thuc 
                      FROM lich_hoc lh
                      JOIN dang_ky_hoc dkh ON lh.id_lop_hoc = dkh.id_lop_hoc
                      WHERE dkh.id_sinh_vien = :student_id AND dkh.trang_thai = 'Thành công'";
    $stmt2 = $conn->prepare($sqlRegistered);
    $stmt2->execute([':student_id' => $studentId]);
    $registeredSchedules = $stmt2->fetchAll(PDO::FETCH_ASSOC);

    // 3. So sánh vòng lặp để tìm điểm giao thoa
    foreach ($newSchedules as $new) {
        foreach ($registeredSchedules as $reg) {
            // Nếu cùng thứ
            if ($new['thu'] === $reg['thu']) {
                
                // Kiểm tra giao thoa ngày (Ngày A bắt đầu trước khi ngày B kết thúc và ngược lại)
                $dateOverlap = ($new['ngay_bat_dau'] <= $reg['ngay_ket_thuc'] && $new['ngay_ket_thuc'] >= $reg['ngay_bat_dau']);
                
                // Kiểm tra giao thoa giờ (Giờ A bắt đầu trước khi giờ B kết thúc và ngược lại)
                $timeOverlap = ($new['gio_vao_hoc'] < $reg['gio_ra_ve'] && $new['gio_ra_ve'] > $reg['gio_vao_hoc']);

                if ($dateOverlap && $timeOverlap) {
                    return true; // Tìm thấy sự trùng lặp
                }
            }
        }
    }
    return false; // Không trùng
}
}
?>