<?php
// 1. Cấu hình hệ thống & Session
if (session_status() === PHP_SESSION_NONE) session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 2. Import Model dùng chung
require_once 'Models/Database.php';

// 3. Import các Controller
require_once 'Controller/LoginController.php';
require_once 'Controller/StudentController.php'; 
require_once 'Controller/RegistrationController.php'; 
require_once 'Controller/CourseRegistrationController.php'; 
require_once 'Controller/ReportController.php';
require_once 'Controller/TuitionController.php';
require_once 'Controller/AdminAccountController.php';
require_once 'Controller/StudentAccountController.php';
require_once 'Controller/ScheduleController.php';
require_once 'Controller/DashboardController.php';
require_once 'Controller/CourseController.php';
require_once 'Controller/ClassController.php';
// 4. Khởi tạo đối tượng
$action = $_GET['action'] ?? 'login';

$loginController         = new LoginController();
$studentController       = new StudentController(); 
$registrationController  = new RegistrationController();
$courseRegController     = new CourseRegistrationController();
$reportController        = new ReportController();
$adminAccountController  = new AdminAccountController();
$studentAccountController = new StudentAccountController();
$scheduleController      = new ScheduleController();
$dashboardController     = new DashboardController();
$courseController        = new CourseController();
$classController         = new ClassController();
// 5. Điều hướng Action
switch ($action) {

    // ====================== SYSTEM ======================
    case 'login':
        $loginController->showLogin();
        break;
    case 'process_login':
        $loginController->processLogin();
        break;
    case 'logout':
        $loginController->logout();
        break;

    // ====================== ADMIN - QUẢN LÝ ======================
    case 'admin_dashboard':
        $dashboardController->showDashboard(); 
        break;

    // --- Quản lý Môn học ---
    case 'courses':
        $courseController->showCourses();
        break;
    case 'add_course':
        $courseController->addCourse();
        break;
    case 'store_course':
        $courseController->storeCourse();
        break;
    case 'edit_course':
        $id = $_GET['id'] ?? null;
        $id ? $courseController->editCourse($id) : header("Location: Index.php?action=courses");
        break;
    case 'update_course':
        $courseController->updateCourse();
        break;
    case 'delete_course':
        $id = $_GET['id'] ?? null;
        $id ? $courseController->deleteCourse($id) : header("Location: Index.php?action=courses");
        break;

    // --- Quản lý Lớp học ---
    case 'classes':
        $classController->showClasses();
        break;
    case 'add_class':                            
        $classController->showAddClassForm();
        break;
    case 'store_class':
        $classController->storeClass();
        break;
    case 'edit_class':
        $classController->showEditClassForm();
        break;
    case 'update_class':
        $classController->updateClass();
        break;
    case 'delete_class':
        $classController->deleteClass();
        break;

    // --- Quản lý Lịch học (ĐÃ THÊM) ---
    case 'schedules':
        $scheduleController->showSchedules();
        break;
    case 'add_schedule':                          // ← DÒNG MỚI
        $scheduleController->add();          // ← DÒNG MỚI
        break;
        case 'process_add_schedule': // THÊM DÒNG NÀY
    $scheduleController->processAddSchedule(); 
    break;
    case 'delete_schedule': 
    $scheduleController->delete(); 
    break;
case 'edit_schedule': 
    $scheduleController->edit(); 
    break;
case 'process_update_schedule': 
    $scheduleController->processUpdateSchedule(); 
    break;

    // ====================== ADMIN - HÀNH CHÍNH ======================
    // Kỳ đăng ký
    case 'registration_periods':
        $registrationController->showRegistrationPeriods(); 
        break;
    case 'create_registration_period':
        $registrationController->showCreateForm();
        break;
    case 'process_create_period':
        $registrationController->store();
        break;
    case 'edit_period':
    case 'process_update_period':
    case 'delete_period':
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($id > 0) {
            if ($action === 'edit_period')           $registrationController->edit($id);
            if ($action === 'process_update_period') $registrationController->update($id);
            if ($action === 'delete_period')         $registrationController->delete($id);
        } else {
            header("Location: Index.php?action=registration_periods");
        }
        break;

    // Báo cáo & Thống kê
    case 'reports':
        $reportController->showReports();
        break;
    case 'export_report':
        $controller = new ReportController();
        $controller->exportReport();
        break;

    // ====================== QUẢN LÝ TÀI KHOẢN SINH VIÊN (ADMIN) ======================
    case 'admin_accounts':
        $adminAccountController->manageAccounts();
        break;
    case 'admin_add_account':
        $adminAccountController->addStudentAccount();
        break;
    case 'admin_edit_account':
        $adminAccountController->editAccount();
        break;
    case 'admin_process_edit_account':
        $adminAccountController->processEditAccount();
        break;
    case 'admin_delete_account':
        $adminAccountController->deleteStudentAccount();
        break;
    case 'admin_view_student':
        $adminAccountController->viewStudentDetail();
        break;

    // ====================== STUDENT ======================
    case 'student_dashboard':
        $studentController->showDashboard(); 
        break;
    case 'student_course_registration':
        $courseRegController->showRegistrationPage(); 
        break;
    case 'register_course':
        $courseRegController->processRegistration();
        break;
    case 'cancel_course':
        $courseRegController->processCancellation();
        break;
    case 'student_schedule':
        $studentController->showSchedule();
        break;
    case 'student_study_program':
        $studentController->showStudyProgram();
        break;
    case 'student_settings':
        $studentController->showAccountSettings();
        break;
    case 'student_tuition':
        $controller = new TuitionController();
        $controller->index();
        break;
    case 'student_update_profile':
        $studentAccountController->updateProfile();
        break;
    case 'student_change_password':
        $studentAccountController->changePassword();
        break;

    // ====================== DEFAULT ======================
    default:
        $loginController->showLogin();
        break;
}
?>