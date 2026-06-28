<?php
require_once 'Models/CourseModel.php';
require_once 'Controller/BaseAdminController.php';
class ScheduleController extends BaseAdminController {
    public function index() {
        $this->checkAdminAuth();
        $model = new CourseModel();
        $classes = $model->getAllClassesWithDetails();
        require_once 'Views/ScheduleManagement.php';
    }

    public function add() {
    $this->checkAdminAuth();
    $model = new CourseModel();
    // Lấy danh sách lớp học thực tế từ DB
    $all_classes = $model->getClassesForSchedule(); 
    require_once 'Views/AddSchedule.php';
}
     public function showSchedules() {
    $this->checkAdminAuth();
    $model = new CourseModel();
    
    // Lấy dữ liệu thô từ database (hàm này bạn đã viết rất tốt, có đầy đủ JOIN rồi)
    $all_schedules = $model->getAllSchedules(); 

    // Không cần dùng vòng lặp foreach để nhóm theo giờ nữa
    // Truyền thẳng $all_schedules sang View
    require_once 'Views/ScheduleManagement.php';
}
    public function processAddSchedule() {
    $this->checkAdminAuth(); // Đảm bảo vẫn còn quyền Admin
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $model = new CourseModel();
        
        // Thu thập dữ liệu từ Form (Khớp với các thuộc tính 'name' trong thẻ input)
        $data = [
            'id_lop_hoc'    => $_POST['id_lop_hoc'],
            'id_mon_hoc'    => $_POST['id_mon_hoc'],
            'thu'           => $_POST['thu'],
            'gio_vao_hoc'   => $_POST['gio_vao_hoc'],
            'gio_ra_ve'     => $_POST['gio_ra_ve'],
            'ngay_bat_dau'  => $_POST['ngay_bat_dau'],
            'ngay_ket_thuc' => $_POST['ngay_ket_thuc']
        ];

        if ($model->insertSchedule($data)) {
            // Lưu thành công thì về trang danh sách lịch học
            header("Location: Index.php?action=schedules&msg=success");
        } else {
            // Thất bại thì báo lỗi
            echo "Có lỗi xảy ra khi lưu lịch học!";
        }
    }
}
public function delete() {
    $this->checkAdminAuth();
    $id = $_GET['id'] ?? null;
    if ($id) {
        $model = new CourseModel();
        if ($model->deleteSchedule($id)) {
            header("Location: Index.php?action=schedules&msg=deleted");
        } else {
            echo "Lỗi khi xóa lịch học!";
        }
    }
}
public function edit() {
    $this->checkAdminAuth();
    $id = $_GET['id'] ?? null;
    $model = new CourseModel();
    
    $schedule = $model->getScheduleById($id);
    $all_classes = $model->getClassesForSchedule(); // Để đổ lại danh sách lớp vào dropdown
    
    if ($schedule) {
        require_once 'Views/EditSchedule.php'; // Bạn cần tạo file View này (copy từ AddSchedule)
    } else {
        echo "Không tìm thấy lịch học!";
    }
}

public function processUpdateSchedule() {
    $this->checkAdminAuth();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $model = new CourseModel();
        $data = [
            'id_lich_hoc'   => $_POST['id_lich_hoc'],
            'id_lop_hoc'    => $_POST['id_lop_hoc'],
            'id_mon_hoc'    => $_POST['id_mon_hoc'],
            'thu'           => $_POST['thu'],
            'gio_vao_hoc'   => $_POST['gio_vao_hoc'],
            'gio_ra_ve'     => $_POST['gio_ra_ve'],
            'ngay_bat_dau'  => $_POST['ngay_bat_dau'],
            'ngay_ket_thuc' => $_POST['ngay_ket_thuc']
        ];

        if ($model->updateSchedule($data)) {
            header("Location: Index.php?action=schedules&msg=updated");
        } else {
            echo "Lỗi khi cập nhật!";
        }
    }
}
} 
