<?php
// Controller/TuitionController.php

require_once 'Models/Database.php';
require_once 'Models/StudentModel.php';
require_once 'Models/SemesterModel.php';
require_once 'Models/RegistrationModel.php';

class TuitionController {
    
    public function index() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['user_id']) || $_SESSION['vai_tro'] !== 'sinh_vien') {
        header("Location: Index.php?action=login");
        exit();
    }

    $userId = $_SESSION['user_id'];

    $studentModel      = new StudentModel();
    $registrationModel = new RegistrationModel();

    $studentProfile = $studentModel->getStudentProfileByUserId($userId);

    if (!$studentProfile) {
        die("Không tìm thấy thông tin sinh viên.");
    }

    $studentId = $studentProfile['id'];

    // Cập nhật học phí tự động
    $registrationModel->updateStudentTuitionAuto($studentId);

    // Lấy danh sách học phí
    $fees = $registrationModel->getStudentFees($studentId) ?? [];

    // Tính toán thống kê
    $totalPaid = 0;
    $totalUnpaid = 0;
    $totalExempted = 0;
    $unpaidItemsCount = 0;
    $groupedFees = [];

    foreach ($fees as $fee) {
        $term = $fee['ky_hoc'] ?? 'Học kỳ hiện tại';
        if (!isset($groupedFees[$term])) {
            $groupedFees[$term] = [];
        }
        $groupedFees[$term][] = $fee;

        $tongTien = $fee['tong_tien'] ?? 0;
        $mienGiam = $fee['mien_giam'] ?? 0;
        $daThanhToan = $fee['da_thanh_toan'] ?? 0;

        $actualAmount = $tongTien - $mienGiam;

        if ($daThanhToan == 1) {
            $totalPaid += $actualAmount;
        } else {
            $totalUnpaid += $actualAmount;
            $unpaidItemsCount++;
        }
        
        $totalExempted += $mienGiam;
    }

    $outstandingBalance = $totalUnpaid;

    // Load View
    require_once 'Views/StudentTuition.php';
}
}
?>