<?php
require_once 'Models/StudentModel.php';
require_once 'Models/StudentAccountModel.php';
require_once 'Models/AuthModel.php';
class StudentController {
    public function showDashboard() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    if (!isset($_SESSION['user_id']) || $_SESSION['vai_tro'] !== 'sinh_vien') {
        header("Location: Index.php?action=login");
        exit();
    }

    $userId = $_SESSION['user_id'];
    $model = new StudentModel();   
    
    $studentProfile = $model->getStudentProfileByUserId($userId);
    
    if ($studentProfile) {
        $studentId = $studentProfile['id'];
        
        $enrolledCourses = $model->getStudentEnrolledCourses($studentId);
        $hasUnpaidFees = $model->checkUnpaidFees($studentId);
        
        $totalCredits = 0;
        foreach ($enrolledCourses as $course) {
            $totalCredits += $course['so_tin_chi'] ?? 0;
        }

        require_once 'Views/StudentDashboard.php';
    } else {
        echo "Lỗi: Không tìm thấy hồ sơ sinh viên!";
    }
}
    // Hàm hiển thị trang Đăng ký môn học của Sinh viên
    public function showCourseRegistration() {
        session_start();
        if (!isset($_SESSION['user_id']) || $_SESSION['vai_tro'] !== 'sinh_vien') {
            header("Location: Index.php?action=login");
            exit();
        }

        $userId = $_SESSION['user_id'];
        $model = new CourseModel();
        $studentProfile = $model->getStudentProfileByUserId($userId);
        
        if ($studentProfile) {
            $studentId = $studentProfile['id'];
            
            // Lấy danh sách lớp học và trạng thái đăng ký
            $classes = $model->getClassesForRegistration($studentId);
            
            // Tính toán thống kê trên cùng (Registered, Credits, Remaining)
            $registeredCount = 0;
            $totalCredits = 0;
            $maxCredits = 18; // Giả sử giới hạn là 18 tín chỉ/kỳ
            
            foreach ($classes as $class) {
                if ($class['trang_thai_dang_ky'] === 'Thành công') {
                    $registeredCount++;
                    $totalCredits += $class['so_tin_chi'];
                }
            }
            $remainingCredits = max(0, $maxCredits - $totalCredits);

            require_once 'Views/StudentCourseRegistration.php';
        }
    }
    // Hàm hiển thị trang Lịch học của Sinh viên
    public function showSchedule() {
    if (!isset($_SESSION['user_id']) || $_SESSION['vai_tro'] !== 'sinh_vien') {
        header("Location: Index.php?action=login");
        exit();
    }

    $userId = $_SESSION['user_id'];
    $model = new StudentModel();
    $studentProfile = $model->getStudentProfileByUserId($userId);

    if (!$studentProfile) {
        echo "Lỗi: Không tìm thấy hồ sơ sinh viên!";
        exit();
    }

    $studentId = $studentProfile['id'];
    $enrolledCourses = $model->getStudentEnrolledCourses($studentId); // Lấy danh sách môn đã đăng ký

    // ====================== TÍNH 3 CHỈ SỐ ======================
    $totalCourses = count($enrolledCourses);           // Số buổi học (Total Sessions)

    $daysActive = [];
    $totalHours = 0;

    foreach ($enrolledCourses as $course) {
        // Giả sử bạn đã join thêm lich_hoc trong Model
        if (!empty($course['thu'])) {
            $days = explode(', ', $course['thu']);     // Ví dụ: "Thứ 2, Thứ 4"
            foreach ($days as $day) {
                $day = trim($day);
                if ($day !== '') $daysActive[] = $day;
            }
        }

        // Tính số giờ nếu có gio_vao_hoc và gio_ra_ve
        if (!empty($course['gio_vao_hoc']) && !empty($course['gio_ra_ve'])) {
            $start = strtotime($course['gio_vao_hoc']);
            $end   = strtotime($course['gio_ra_ve']);
            $hours = ($end - $start) / 3600;           // Chuyển ra giờ
            $totalHours += $hours;
        }
    }

    $uniqueDaysCount = count(array_unique($daysActive));   // Số ngày đi học

    // ====================== Truyền sang View ======================
    require_once 'Views/StudentSchedule.php';
}
    // Hàm hiển thị trang Chương trình học (Study Program)
    public function showStudyProgram() {
    if (session_status() === PHP_SESSION_NONE) session_start();
    
    if (!isset($_SESSION['user_id']) || $_SESSION['vai_tro'] !== 'sinh_vien') {
        header("Location: Index.php?action=login");
        exit();
    }

    $userId = $_SESSION['user_id'];
    $model = new StudentModel();
    
    // 1. Lấy thông tin sinh viên để hiện ở Sidebar
    $studentProfile = $model->getStudentProfileByUserId($userId);

    // 2. Lấy danh sách các chương trình học có trong DB để đổ vào Dropdown lọc
    $allPrograms = $model->getDistinctPrograms();

    // Lấy dữ liệu từ URL thông qua $_GET
    $selectedProgram = $_GET['program'] ?? 'all';
    $searchTerm = $_GET['search'] ?? null;

    // Lấy danh sách chương trình để đổ vào dropdown
    $allPrograms = $model->getDistinctPrograms();

    // Lấy danh sách môn học theo bộ lọc và tìm kiếm
    $courses = $model->getAllCourses($selectedProgram, $searchTerm);

    require_once 'Views/StudentStudyProgram.php';
}
    // Hàm hiển thị trang Học phí & Lệ phí
    public function showTuitionFees() {
        session_start();
        if (!isset($_SESSION['user_id']) || $_SESSION['vai_tro'] !== 'sinh_vien') {
            header("Location: Index.php?action=login");
            exit();
        }

        $userId = $_SESSION['user_id'];
        $model = new StudentModel();
        $studentProfile = $model->getStudentProfileByUserId($userId);
        
        if ($studentProfile) {
            $studentId = $studentProfile['id'];
            $fees = $model->getStudentFees($studentId);
            
            // Khởi tạo các biến thống kê
            $totalPaid = 0;
            $pendingPayment = 0;
            $overdue = 0;
            $unpaidItemsCount = 0;
            $groupedFees = [];
            
            // Phân loại và tính toán
            foreach ($fees as $fee) {
                // Nhóm theo kỳ học
                $term = $fee['ky_hoc'];
                if (!isset($groupedFees[$term])) {
                    $groupedFees[$term] = [];
                }
                $groupedFees[$term][] = $fee;
                
                // Cộng dồn tiền theo trạng thái
                if ($fee['trang_thai'] == 'Paid') {
                    $totalPaid += $fee['so_tien'];
                } elseif ($fee['trang_thai'] == 'Pending') {
                    $pendingPayment += $fee['so_tien'];
                    $unpaidItemsCount++;
                } elseif ($fee['trang_thai'] == 'Overdue') {
                    $overdue += $fee['so_tien'];
                    $unpaidItemsCount++;
                }
            }
            
            $outstandingBalance = $pendingPayment + $overdue;

            require_once 'Views/StudentTuition.php';
        }
    }
  // Hàm hiển thị trang Cài đặt tài khoản
    public function showAccountSettings() {
       
        if (!isset($_SESSION['user_id']) || $_SESSION['vai_tro'] !== 'sinh_vien') {
            header("Location: Index.php?action=login");
            exit();
        }

        $userId = $_SESSION['user_id'];
        $model = new StudentModel();
        $studentProfile = $model->getStudentProfileByUserId($userId);
        
        if ($studentProfile) {
            $studentId = $studentProfile['id'];
            $program = $model->getStudentProgram($studentId);

            require_once 'Views/StudentSettings.php';
        }
    }

    public function updateProfile() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $userId = $_SESSION['user_id'];
        
        // Lấy dữ liệu từ FORM gửi lên
        $phone = $_POST['phone'] ?? ''; // Chú ý: 'phone' phải khớp với thuộc tính name="..." của thẻ input
        $address = $_POST['address'] ?? '';
        $dob = $_POST['dob'] ?? '';

        $model = new StudentModel();
        
        // Gọi hàm update trong Model (bạn cần viết hàm này trong StudentModel)
        $result = $model->updateStudentProfile($userId, $phone, $address, $dob);

        if ($result) {
            $_SESSION['success_message'] = "Cập nhật thông tin thành công!";
        } else {
            $_SESSION['error_message'] = "Có lỗi xảy ra khi cập nhật.";
        }

        // Quay lại trang cài đặt
        header("Location: Index.php?action=account_settings");
        exit();
    }
}

}
?>