<?php
require_once 'Models/SemesterModel.php';
require_once 'Controller/BaseAdminController.php';
class RegistrationController extends BaseAdminController {

    public function showRegistrationPeriods() {
        $this->checkAdminAuth();
        $model = new SemesterModel();
        $semesters = $model->getAllSemesters();

        $openCount = 0; $closedCount = 0; $upcomingCount = 0;

        foreach ($semesters as $sem) {
            $status = $sem['trang_thai_dang_ky'] ?? ''; 
            if ($status === 'Đang mở' || $status === 'Mở') {
                $openCount++;
            } elseif ($status === 'Đã đóng' || $status === 'Đóng') {
                $closedCount++;
            } elseif ($status === 'Sắp tới') {
                $upcomingCount++;
            }
        }

        $stats = [
            'open_periods'     => $openCount,
            'closed_periods'   => $closedCount,
            'upcoming_periods' => $upcomingCount,
            'total_periods'    => count($semesters)
        ];

        require_once 'Views/RegistrationPeriods.php';
    }

    public function showCreateForm() {
        $this->checkAdminAuth();
        require_once 'Views/CreateRegistrationPeriod.php'; 
    }

    public function store() {
        $this->checkAdminAuth();

        $bat_dau = $_POST['thoi_gian_bat_dau'];
        $ket_thuc = $_POST['thoi_gian_ket_thuc'];

        if (strtotime($ket_thuc) <= strtotime($bat_dau)) {
            header("Location: Index.php?action=create_registration_period&msg=invalid_time");
            exit();
        }

        $model = new SemesterModel();
        $model->closeAllOpeningSemesters();

        $data = [
            'ten_ky_hoc'         => $_POST['ten_ky_hoc'],
            'thoi_gian_bat_dau'  => $bat_dau,
            'thoi_gian_ket_thuc' => $ket_thuc,
            'tin_chi_toi_thieu'  => $_POST['tin_chi_toi_thieu'],
            'tin_chi_toi_da'     => $_POST['tin_chi_toi_da'],
            'trang_thai_dang_ky' => $_POST['trang_thai_dang_ky'] ?? 'Sắp tới'
        ];

        $result = $model->insertRegistrationPeriod($data);

        if ($result) {
            $newId = $model->getLastInsertedId();
            if (isset($_POST['copy_classes_from_old']) && $_POST['copy_classes_from_old'] == '1') {
                $model->updateClassesToNewSemester($newId);
            }
            header("Location: Index.php?action=registration_periods&msg=success");
        } else {
            header("Location: Index.php?action=registration_periods&msg=error");
        }
        exit();
    }

    public function edit($id) {
        $this->checkAdminAuth();
        $model = new SemesterModel();
        $period = $model->getRegistrationPeriodById($id);

        if (!$period) {
            header("Location: Index.php?action=registration_periods&msg=not_found");
            exit();
        }
        require_once 'Views/EditRegistrationPeriod.php'; 
    }

    public function update($id) {
        $this->checkAdminAuth();

        $bat_dau = $_POST['thoi_gian_bat_dau'];
        $ket_thuc = $_POST['thoi_gian_ket_thuc'];

        if (strtotime($ket_thuc) <= strtotime($bat_dau)) {
            header("Location: Index.php?action=edit_period&id=$id&msg=invalid_time");
            exit();
        }

        $model = new SemesterModel();
        $newStatus = $_POST['trang_thai_dang_ky'] ?? 'Sắp tới';

        if ($newStatus === 'Đang mở') {
            $currentPeriod = $model->getRegistrationPeriodById($id);
            if ($currentPeriod && $currentPeriod['trang_thai_dang_ky'] !== 'Đang mở') {
                if ($model->hasOpeningSemester()) {
                    header("Location: Index.php?action=edit_period&id=$id&msg=already_has_open");
                    exit();
                }
            }
            $model->closeAllOpeningSemesters();
        }

        $data = [
            'ten_ky_hoc'         => $_POST['ten_ky_hoc'],
            'thoi_gian_bat_dau'  => $bat_dau,
            'thoi_gian_ket_thuc' => $ket_thuc,
            'tin_chi_toi_thieu'  => $_POST['tin_chi_toi_thieu'],
            'tin_chi_toi_da'     => $_POST['tin_chi_toi_da'],
            'trang_thai_dang_ky' => $newStatus
        ];

        if ($model->updateRegistrationPeriod($id, $data)) {
            header("Location: Index.php?action=registration_periods&msg=update_success");
        } else {
            header("Location: Index.php?action=registration_periods&msg=update_error");
        }
        exit();
    }

    public function delete($id) {
        $this->checkAdminAuth();
        $model = new SemesterModel();

        if ($model->deleteRegistrationPeriod($id)) {
            header("Location: Index.php?action=registration_periods&msg=delete_success");
        } else {
            header("Location: Index.php?action=registration_periods&msg=delete_error");
        }
    }
}