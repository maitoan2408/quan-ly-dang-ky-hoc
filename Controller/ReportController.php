<?php
// Controller/ReportController.php

require_once 'Models/AdminModel.php';
require_once 'Models/SemesterModel.php';
require_once 'Models/CourseModel.php';        // ← Thêm dòng này
require_once 'Controller/BaseAdminController.php';
class ReportController extends BaseAdminController{
    
    private $adminModel;
    private $semesterModel;
    private $courseModel;

    public function __construct() {
        $this->adminModel    = new AdminModel();
        $this->semesterModel = new SemesterModel();
        $this->courseModel   = new CourseModel();
    }

    

    public function showReports() {
        $this->checkAdminAuth();

        // 1. Thống kê từ AdminModel
        $stats          = $this->adminModel->getQuickStats();
        $deptStats      = $this->adminModel->getEnrollmentByDepartment();
        $regStats       = $this->adminModel->getRegistrationStatusStats();
        $courseSummary  = $this->adminModel->getCourseEnrollmentSummary();

        // 2. Dữ liệu từ SemesterModel
        $openingSemester = $this->semesterModel->getOpeningSemester();
        $semesters       = $this->semesterModel->getAllSemesters();

        // 3. Dữ liệu từ CourseModel
        $studyPrograms   = $this->courseModel->getAllStudyPrograms();

        // Xử lý dữ liệu cho biểu đồ
        $deptLabels = [];
        $deptStudents = [];
        $deptCourses = [];

        foreach ($deptStats as $row) {
            $deptLabels[]   = $row['chuong_trinh_hoc'];
            $deptStudents[] = (int)$row['total_students'];
            $deptCourses[]  = (int)$row['total_courses'];
        }

        // Nạp View
        require_once 'Views/Reports.php';
    }

    public function exportReport() {
        $this->checkAdminAuth();

        // Dùng AdminModel vì hàm này đã có trong đó
        $data = $this->adminModel->getCourseEnrollmentSummary();

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=BaoCao_DangKyHoc_' . date('d-m-Y') . '.csv');

        $output = fopen('php://output', 'w');
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF)); // BOM cho tiếng Việt

        fputcsv($output, ['Mã môn', 'Tên môn học', 'CT Học', 'Giảng viên', 'Sĩ số', 'Đã đăng ký']);

        foreach ($data as $row) {
            fputcsv($output, [
                $row['ma_mon_hoc'],
                $row['ten_mon_hoc'],
                $row['chuong_trinh_hoc'],
                $row['ten_giang_vien'],
                $row['si_so_toi_da'],
                $row['si_so_da_dang_ky']
            ]);
        }

        fclose($output);
        exit();
    }
}
?> 
