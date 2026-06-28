<?php
require_once 'Models/SemesterModel.php';
require_once 'Controller/BaseAdminController.php';
class DashboardController extends BaseAdminController {
    public function showDashboard() {
        $this->checkAdminAuth();
        $model = new SemesterModel();
        $semesters = $model->getAllSemesters();
        
        $dashboardStats = [
            'open_periods' => 0, 
            'total_semesters' => count($semesters)
        ];
        require_once 'Views/AdminDashboard.php';
    }
}