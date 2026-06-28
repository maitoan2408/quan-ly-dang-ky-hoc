<?php
require_once 'Models/CourseModel.php';
require_once 'Controller/BaseAdminController.php';
class ClassController extends BaseAdminController {
    private $model;

    public function __construct() {
        $this->model = new CourseModel();
    }

    public function index() {
        $this->checkAdminAuth();
        $selectedProgram = $_GET['program'] ?? 'all';
        $classes = $this->model->getClassesByProgram($selectedProgram);
        $programs = $this->model->getAllStudyPrograms();
        
    
        require_once 'Views/ClassManagement.php';
    }
    public function showClasses() {
    $this->checkAdminAuth();

    $model = new CourseModel();
    
    // Lấy chương trình từ URL (mặc định là 'all')
    $selectedProgram = isset($_GET['program']) ? $_GET['program'] : 'all';

    // --- THAY ĐỔI Ở ĐÂY: Gọi hàm có tham số lọc ---
    $classes = $model->getClassesByProgram($selectedProgram); 
    
    $programs = $model->getAllStudyPrograms();
    
    // Tính toán thống kê dựa trên danh sách đã lọc
    $totalClasses = count($classes);
    $totalCapacity = 0;
    $totalEnrolled = 0;

    foreach ($classes as $c) {
        $totalCapacity += $c['si_so_toi_da'];
        $totalEnrolled += $c['si_so_da_dang_ky'];
    }

    $avgFillRate = ($totalCapacity > 0) ? round(($totalEnrolled / $totalCapacity) * 100) : 0;

    $stats = [
        'total_classes' => $totalClasses,
        'total_capacity' => $totalCapacity,
        'total_enrolled' => $totalEnrolled,
        'avg_fill_rate' => $avgFillRate
    ];

    require_once 'Views/ClassManagement.php';
}
    public function showAddClassForm() {
    $this->checkAdminAuth(); // Kiểm tra quyền admin
    
    $model = new CourseModel();
    // Lấy danh sách môn học để đổ vào thẻ <select> trong Form
    $subjects = $model->getAllSubjects();
    
    require_once 'Views/AddClass.php';
}
    public function storeClass() {
    $this->checkAdminAuth();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $model = new CourseModel();
        $class_code = $_POST['class_name'];

        // Kiểm tra trùng mã lớp
        if ($model->checkClassExists($class_code)) {
            header("Location: Index.php?action=add_class&error=duplicate_code&code=" . urlencode($class_code));
            exit();
        }

        $data = [
            'class_name' => $class_code,
            'course_name' => $_POST['course_name'],
            'instructor' => $_POST['instructor'],
            'room' => $_POST['room'],
            'capacity' => (int)$_POST['capacity'],
            'enrolled' => (int)$_POST['enrolled']
        ];

        if ($model->insertClass($data)) {
            header("Location: Index.php?action=classes&msg=success");
            exit();
        }
    }
}
    // Hiển thị Form sửa (Dùng lại giao diện AddClass nhưng đổ dữ liệu cũ vào)
public function showEditClassForm() {
    $code = $_GET['id'] ?? '';
    $model = new CourseModel();
    $class = $model->getClassByCode($code);
    $subjects = $model->getAllSubjects();
    
    require_once 'Views/EditClass.php'; // Bạn có thể copy AddClass sang EditClass
}
    // Xử lý Cập nhật sau khi ấn Lưu ở Form Sửa
public function updateClass() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $model = new CourseModel();
        if ($model->updateClassByCode($_POST)) {
            header("Location: Index.php?action=classes&msg=updated");
        }
    }
}
    // Xử lý Xóa
public function deleteClass() {
    $code = $_GET['id'] ?? '';
    $model = new CourseModel();
    if ($model->deleteClassByCode($code)) {
        header("Location: Index.php?action=classes&msg=deleted");
    }
    exit();
}
}