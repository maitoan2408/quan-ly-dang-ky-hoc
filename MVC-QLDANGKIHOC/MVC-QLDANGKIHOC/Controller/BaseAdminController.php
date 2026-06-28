<?php

class BaseAdminController {
    protected function checkAdminAuth() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user_id']) || $_SESSION['vai_tro'] !== 'quan_tri') {
            header("Location: Index.php?action=login");
            exit();
        }
    }
}
?>