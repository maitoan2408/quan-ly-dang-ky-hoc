<?php
require_once 'Models/StudentAccountModel.php';

class StudentAccountController {
    public function updateProfile() {
        session_start();
        if (!isset($_SESSION['user_id']) || $_SESSION['vai_tro'] !== 'sinh_vien') {
            header("Location: Index.php?action=login");
            exit();
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_SESSION['user_id'];
            $hoTen = trim($_POST['ho_ten'] ?? '');
            $ngaySinh = $_POST['ngay_sinh'] ?? '';
            $gioiTinh = $_POST['gioi_tinh'] ?? '';
            $soDienThoai = trim($_POST['so_dien_thoai'] ?? '');
            $diaChi = trim($_POST['dia_chi'] ?? '');
            $model = new StudentAccountModel();
            if (empty($hoTen)) {
                $_SESSION['flash_error_student'] = 'Vui lòng nhập họ tên!';
            } else {
                if ($model->updateStudentProfile($userId, $hoTen, $ngaySinh, $gioiTinh, $soDienThoai, $diaChi)) {
                    $_SESSION['flash_success_student'] = 'Cập nhật thông tin thành công!';
                } else {
                    $_SESSION['flash_error_student'] = 'Lỗi: Không thể cập nhật thông tin!';
                }
            }
            header("Location: Index.php?action=student_settings");
            exit();
        }
    }

    public function changePassword() {
        session_start();
        if (!isset($_SESSION['user_id']) || $_SESSION['vai_tro'] !== 'sinh_vien') {
            header("Location: Index.php?action=login");
            exit();
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_SESSION['user_id'];
            $oldPassword = trim($_POST['old_password'] ?? '');
            $newPassword = trim($_POST['new_password'] ?? '');
            $confirmPassword = trim($_POST['confirm_password'] ?? '');
            $model = new StudentAccountModel();
            if (empty($oldPassword) || empty($newPassword) || empty($confirmPassword)) {
                $_SESSION['flash_error_student'] = 'Vui lòng nhập đầy đủ mật khẩu!';
            } elseif ($newPassword !== $confirmPassword) {
                $_SESSION['flash_error_student'] = 'Mật khẩu mới không khớp!';
            } else {
                if ($model->changePassword($userId, $oldPassword, $newPassword)) {
                    $_SESSION['flash_success_student'] = 'Đổi mật khẩu thành công!';
                } else {
                    $_SESSION['flash_error_student'] = 'Mật khẩu cũ không đúng!';
                }
            }
            header("Location: Index.php?action=student_settings");
            exit();
        }
    }
}
?>
