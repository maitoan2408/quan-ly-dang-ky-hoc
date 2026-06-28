<?php
require_once 'Models/AuthModel.php';

class LoginController {
    public function showLogin() {
        require_once 'Views/Login.php';
    }

    public function processLogin() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');
            $role = $_POST['role'] ?? 'sinh_vien'; // Nhận vai trò từ form

            $userModel = new AuthModel();
            // Gọi hàm xác thực từ Database
            $user = $userModel->authenticate($email, $password, $role);

            if ($user) {
                
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['vai_tro'] = $user['vai_tro'];
                
                // Điều hướng dựa trên vai trò
                if ($user['vai_tro'] == 'quan_tri') {
                    echo "<script>alert('Xin chào Quản trị viên!'); window.location.href='Index.php?action=admin_dashboard';</script>";
                } else {
                    echo "<script>alert('Đăng nhập thành công!'); window.location.href='Index.php?action=student_dashboard';</script>";
                }
            } else {
                // Đăng nhập thất bại (sai pass hoặc chọn nhầm tab sinh viên/admin)
                echo "<script>alert('Đăng nhập thất bại! Vui lòng kiểm tra lại Email, Mật khẩu hoặc Vai trò.'); window.history.back();</script>";
            }
        }
    }

    public function logout() {
        // Bắt đầu session nếu chưa có
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Xóa hết mọi dữ liệu session
        $_SESSION = array();
        unset($_SESSION['user_id']);
unset($_SESSION['vai_tro']);
        // Xóa session trên server
        session_destroy();

        // Xóa cookie session trên trình duyệt
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        // === HEADER CHỐNG CACHE QUAN TRỌNG ===
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Expires: Thu, 01 Jan 1970 00:00:00 GMT");

        // Chuyển hướng về trang login
        header("Location: Index.php?action=login");
        exit();   // Dừng ngay lập tức
    }
}

?>