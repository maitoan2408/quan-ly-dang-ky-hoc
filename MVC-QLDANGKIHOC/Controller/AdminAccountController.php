<?php
require_once 'Models/StudentAccountModel.php';

class AdminAccountController {
    public function manageAccounts() {
        
        if (!isset($_SESSION['user_id']) || $_SESSION['vai_tro'] !== 'quan_tri') {
            header("Location: Index.php?action=login");
            exit();
        }
        $model = new StudentAccountModel();
        $keyword = isset($_GET['search']) ? trim($_GET['search']) : '';
        if ($keyword !== '') {
            $accounts = $model->searchStudentAccounts($keyword);
        } else {
            $accounts = $model->getAllStudentAccounts();
        }
        $searchKeyword = $keyword;
        require_once 'Views/AdminAccountManagement.php';
    }

    public function addStudentAccount() {
        session_start();
        if (!isset($_SESSION['user_id']) || $_SESSION['vai_tro'] !== 'quan_tri') {
            header("Location: Index.php?action=login");
            exit();
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');
            $hoTen = trim($_POST['ho_ten'] ?? '');
            $vaiTro = trim($_POST['vai_tro'] ?? 'sinh_vien');
            $model = new StudentAccountModel();
            if (empty($email) || empty($password)) {
                $_SESSION['flash_error'] = 'Vui lòng nhập đầy đủ Email và Mật khẩu!';
            } elseif ($model->emailExists($email)) {
                $_SESSION['flash_error'] = 'Email đã tồn tại!';
            } else {
                if ($model->addStudentAccount($email, $password, $hoTen, $vaiTro)) {
                    $_SESSION['flash_success'] = 'Thêm tài khoản thành công!';
                } else {
                    $_SESSION['flash_error'] = 'Lỗi: Không thể thêm tài khoản!';
                }
            }
            header("Location: Index.php?action=admin_accounts");
            exit();
        }
    }

    public function deleteStudentAccount() {
        session_start();
        if (!isset($_SESSION['user_id']) || $_SESSION['vai_tro'] !== 'quan_tri') {
            header("Location: Index.php?action=login");
            exit();
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $accountId = $_POST['account_id'] ?? 0;
            $model = new StudentAccountModel();
            if ($model->deleteStudentAccount($accountId)) {
                $_SESSION['flash_success'] = 'Xóa tài khoản thành công!';
            } else {
                $_SESSION['flash_error'] = 'Lỗi: Không thể xóa tài khoản!';
            }
        }
        header("Location: Index.php?action=admin_accounts");
        exit();
    }

    public function viewStudentDetail() {
        
        if (!isset($_SESSION['user_id']) || $_SESSION['vai_tro'] !== 'quan_tri') {
            header("Location: Index.php?action=login");
            exit();
        }
        $accountId = $_GET['id'] ?? 0;
        $model = new StudentAccountModel();
        $student = $model->getAccountById($accountId);
        if (!$student) {
            $_SESSION['flash_error'] = 'Không tìm thấy thông tin tài khoản!';
            header("Location: Index.php?action=admin_accounts");
            exit();
        }
        require_once 'Views/AdminStudentDetail.php';
    }

    public function editAccount() {
        
        if (!isset($_SESSION['user_id']) || $_SESSION['vai_tro'] !== 'quan_tri') {
            header("Location: Index.php?action=login");
            exit();
        }
        $accountId = $_GET['id'] ?? 0;
        $model = new StudentAccountModel();
        $account = $model->getAccountById($accountId);
        if (!$account) {
            $_SESSION['flash_error'] = 'Không tìm thấy tài khoản!';
            header("Location: Index.php?action=admin_accounts");
            exit();
        }
        require_once 'Views/EditAccount.php';
    }

    public function processEditAccount() {
      
        if (!isset($_SESSION['user_id']) || $_SESSION['vai_tro'] !== 'quan_tri') {
            header("Location: Index.php?action=login");
            exit();
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $accountId = $_POST['account_id'] ?? 0;
            $email = trim($_POST['email'] ?? '');
            $vaiTro = trim($_POST['vai_tro'] ?? 'sinh_vien');
            $model = new StudentAccountModel();
            
            if (empty($email)) {
                $_SESSION['flash_error'] = 'Vui lòng nhập email!';
                header("Location: Index.php?action=admin_view_student&id=" . $accountId);
                exit();
            }
            
            // Kiểm tra email đã tồn tại chưa (trừ tài khoản hiện tại)
            $existingAccount = $model->getAccountByEmail($email);
            if ($existingAccount && $existingAccount['id'] != $accountId) {
                $_SESSION['flash_error'] = 'Email đã tồn tại!';
                header("Location: Index.php?action=admin_view_student&id=" . $accountId);
                exit();
            }
            
            // Cập nhật thông tin tài khoản
            if ($model->updateAccountInfo($accountId, $email, $vaiTro)) {
                $_SESSION['flash_success'] = 'Cập nhật tài khoản thành công!';
            } else {
                $_SESSION['flash_error'] = 'Lỗi: Không thể cập nhật tài khoản!';
            }
            
            header("Location: Index.php?action=admin_view_student&id=" . $accountId);
            exit();
        }
    }
}
?>
