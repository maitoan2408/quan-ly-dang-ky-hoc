<?php
require_once 'Models/CourseModel.php';
require_once 'Controller/BaseAdminController.php';

class CourseController extends BaseAdminController {
    private $model;

    public function __construct() {
        $this->model = new CourseModel();
    }

    public function index() {
        $this->checkAdminAuth();
        $selectedProgram = $_GET['program'] ?? 'all';
        $searchKeyword = $_GET['search'] ?? '';
        $mon_hocs = $this->model->getCoursesByFilter($selectedProgram, $searchKeyword);
        $programs = $this->model->getAllStudyPrograms();
        require_once 'Views/CourseManagement.php';
    }

    public function showCourses() {
        $this->checkAdminAuth();
        $model = new CourseModel();

        // Nhận giá trị từ URL
        $selectedProgram = $_GET['program'] ?? 'all';
        $searchKeyword = $_GET['search'] ?? '';

        // Gọi hàm Model mới với 2 tham số
        $mon_hocs = $model->getCoursesByFilter($selectedProgram, $searchKeyword); 
        
        $programs = $model->getAllStudyPrograms();

        require_once 'Views/CourseManagement.php';
    }
    
    // Hiển thị giao diện trang thêm môn học
    public function addCourse() {
        require_once 'Views/AddCourse.php'; 
    }
    
    // Xử lý dữ liệu từ Form gửi lên (THÊM MỚI)
    public function storeCourse() {
        $this->checkAdminAuth(); // Đảm bảo đã check quyền Admin khi can thiệp DB

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // 1. Loại bỏ khoảng trắng thừa bằng trim()
            $ma_mon_hoc = isset($_POST['ma_mon_hoc']) ? trim($_POST['ma_mon_hoc']) : '';
            $ten_mon_hoc = isset($_POST['ten_mon_hoc']) ? trim($_POST['ten_mon_hoc']) : '';
            $chuong_trinh_hoc = isset($_POST['chuong_trinh_hoc']) ? trim($_POST['chuong_trinh_hoc']) : '';
            $so_tin_chi = isset($_POST['so_tin_chi']) ? trim($_POST['so_tin_chi']) : '';

            // 2. CHẶN KHÔNG CHO PHÉP THÊM nếu thiếu bất kỳ thông tin cốt lõi nào
            if (empty($ma_mon_hoc) || empty($ten_mon_hoc) || empty($chuong_trinh_hoc) || empty($so_tin_chi)) {
                // Trả về giao diện thêm môn học kèm thông báo lỗi missing_fields
                header("Location: Index.php?action=add_course&status=missing_fields");
                exit();
            }

            $model = new CourseModel();
            
            // 3. Kiểm tra trùng mã môn học trước khi insert
            if ($model->checkCourseExists($ma_mon_hoc)) {
                header("Location: Index.php?action=add_course&status=duplicate_code");
                exit();
            }

            // Đóng gói dữ liệu hợp lệ
            $data = [
                'ma_mon_hoc' => $ma_mon_hoc,
                'ten_mon_hoc' => $ten_mon_hoc,
                'so_tin_chi' => (int)$so_tin_chi,
                'chuong_trinh_hoc' => $chuong_trinh_hoc
            ];

            if ($model->insertCourse($data)) {
                header("Location: Index.php?action=courses&status=success");
            } else {
                header("Location: Index.php?action=add_course&status=error");
            }
            exit();
        }
    }

    public function editCourse($id) {
        $this->checkAdminAuth();
        if (!$id) {
            header("Location: Index.php?action=courses");
            exit();
        }
        
        $model = new CourseModel();
        $course = $model->getCourseByCode($id); 
        
        if (!$course) {
            die("Môn học không tồn tại!");
        }

        require_once 'Views/EditCourse.php';
    }

    // Xử lý Cập nhật dữ liệu từ Form gửi lên (SỬA)
    public function updateCourse() {
        $this->checkAdminAuth(); // Đảm bảo đã check quyền Admin khi can thiệp DB

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // 1. Loại bỏ khoảng trắng thừa
            $ma_mon_hoc = isset($_POST['ma_mon_hoc']) ? trim($_POST['ma_mon_hoc']) : '';
            $ten_mon_hoc = isset($_POST['ten_mon_hoc']) ? trim($_POST['ten_mon_hoc']) : '';
            $chuong_trinh_hoc = isset($_POST['chuong_trinh_hoc']) ? trim($_POST['chuong_trinh_hoc']) : '';
            $so_tin_chi = isset($_POST['so_tin_chi']) ? trim($_POST['so_tin_chi']) : '';

            // 2. CHẶN KHÔNG CHO PHÉP SỬA nếu người dùng cố tình xóa trống thông tin trường nào đó
            if (empty($ma_mon_hoc) || empty($ten_mon_hoc) || empty($chuong_trinh_hoc) || empty($so_tin_chi)) {
                // Trả về trang quản lý với mã lỗi chỉnh sửa bị thiếu thông tin
                header("Location: Index.php?action=courses&msg=update_missing_fields");
                exit();
            }

            // Đóng gói dữ liệu hợp lệ để chuẩn bị cập nhật
            $data = [
                'ma_mon_hoc' => $ma_mon_hoc,
                'ten_mon_hoc' => $ten_mon_hoc,
                'so_tin_chi' => (int)$so_tin_chi,
                'chuong_trinh_hoc' => $chuong_trinh_hoc
            ];

            $model = new CourseModel();
            if ($model->updateCourseByCode($data)) {
                header("Location: Index.php?action=courses&msg=update_success");
            } else {
                header("Location: Index.php?action=courses&msg=update_error");
            }
            exit();
        }
    }

    public function deleteCourse($id) {
        $this->checkAdminAuth();
        $courseModel = new CourseModel();
        $result = $courseModel->deleteCourseByCode($id); 
        
        if ($result) {
            header("Location: Index.php?action=courses&msg=success");
        } else {
            header("Location: Index.php?action=courses&msg=error");
        }
        exit();
    }
}