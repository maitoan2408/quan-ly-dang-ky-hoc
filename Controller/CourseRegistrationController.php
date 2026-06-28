<?php
// Controller/CourseRegistrationController.php

require_once 'Models/Database.php';
require_once 'Models/StudentModel.php';
require_once 'Models/SemesterModel.php';
require_once 'Models/RegistrationModel.php';
class CourseRegistrationController {

    private $studentModel;
    private $semesterModel;

    public function __construct() {
        $this->studentModel  = new StudentModel();
        $this->semesterModel = new SemesterModel();
    }

    private function checkAccess() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user_id']) || $_SESSION['vai_tro'] !== 'sinh_vien') {
            header("Location: Index.php?action=login");
            exit();
        }
        return $_SESSION['user_id'];
    }

    public function showRegistrationPage() {
    $userId = $this->checkAccess();
    $studentProfile = $this->studentModel->getStudentProfileByUserId($userId);
    if (!$studentProfile) {
        header("Location: Index.php?action=login"); 
        exit();
    }

    $studentId = $studentProfile['id'];
    $currentSemester = $this->semesterModel->getOpeningSemester();
    
    if (!$currentSemester || $currentSemester['trang_thai_dang_ky'] !== 'Đang mở') {
        require_once 'Views/StudentCourseRegistrationClosed.php';
        exit();
    }

    // === QUAN TRỌNG: Buộc refresh dữ liệu ===
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Pragma: no-cache");
    header("Expires: 0");

    $classes = $this->studentModel->getClassesForRegistration($studentId);

    $minCredits = (int)($currentSemester['tin_chi_toi_thieu'] ?? 12);
    $maxCredits = (int)($currentSemester['tin_chi_toi_da'] ?? 30);
  
    require_once 'Views/StudentCourseRegistration.php';
}
    // Xử lý đăng ký môn học
    public function processRegistration() {
        $userId = $this->checkAccess(); // Kiểm tra đã đăng nhập và là sinh viên
        $studentProfile = $this->studentModel->getStudentProfileByUserId($userId);
        if (!$studentProfile) {
            header("Location: Index.php?action=login");
            exit();
        }
        $studentId = $studentProfile['id'];

        $classId = $_GET['id_lop'] ?? $_POST['id_lop'] ?? 0;

        if (!$classId) {
            $_SESSION['flash_error'] = 'Không tìm thấy lớp học!';
            header("Location: Index.php?action=student_course_registration");
            exit();
        }
        
        $registrationModel = new RegistrationModel(); // Bạn cần require ở đầu file nếu chưa có

        if ($registrationModel->isScheduleConflicting($studentId, $classId)) {
        $_SESSION['flash_error'] = 'Lỗi: Lịch học của lớp này bị trùng với các môn bạn đã đăng ký!';
        header("Location: Index.php?action=student_course_registration");
        exit();
    }

    // Nếu không trùng thì tiến hành đăng ký như cũ
    if ($registrationModel->registerCourse($studentId, $classId)) {
        // Cập nhật học phí tự động luôn
        $registrationModel->updateStudentTuitionAuto($studentId); 
        $_SESSION['flash_success'] = 'Đăng ký môn học thành công!';
    } else {
        $_SESSION['flash_error'] = 'Đăng ký thất bại! Lớp đã đầy hoặc bạn đã đăng ký môn này.';
    }

    header("Location: Index.php?action=student_course_registration");
    exit();
    }

    // Xử lý hủy đăng ký môn học
    public function processCancellation() {
        $userId = $this->checkAccess();
        $studentProfile = $this->studentModel->getStudentProfileByUserId($userId);
        if (!$studentProfile) {
            header("Location: Index.php?action=login");
            exit();
        }
        $studentId = $studentProfile['id'];

        $classId = $_GET['id_lop'] ?? $_POST['id_lop'] ?? 0;

        if (!$classId) {
            $_SESSION['flash_error'] = 'Không tìm thấy lớp học!';
            header("Location: Index.php?action=student_course_registration");
            exit();
        }

        $registrationModel = new RegistrationModel();

        if ($registrationModel->cancelCourse($studentId, $classId)) {
            $_SESSION['flash_success'] = 'Hủy đăng ký thành công!';
        } else {
            $_SESSION['flash_error'] = 'Hủy đăng ký thất bại!';
        }

        header("Location: Index.php?action=student_course_registration");
        exit();
    }
}