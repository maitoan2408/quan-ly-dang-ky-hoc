<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết sinh viên - Quản trị viên</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', sans-serif; }
        body { display: flex; background-color: #f4f7fe; color: #2b3674; min-height: 100vh; }
        .sidebar { width: 260px; background-color: #111c44; color: #fff; display: flex; flex-direction: column; padding: 20px; }
        .logo { font-size: 1.2rem; font-weight: bold; display: flex; align-items: center; gap: 10px; margin-bottom: 30px; }
        .logo i { background: rgba(255,255,255,0.1); padding: 8px; border-radius: 8px; }
        .logo span { font-size: 0.75rem; font-weight: normal; color: #a0aec0; display: block; }
        .menu-section { font-size: 0.75rem; color: #a0aec0; font-weight: bold; margin: 20px 0 10px; text-transform: uppercase; letter-spacing: 1px; }
        .menu-item { padding: 12px 15px; border-radius: 8px; color: #a0aec0; text-decoration: none; display: flex; align-items: center; gap: 15px; margin-bottom: 5px; transition: 0.3s; }
        .menu-item:hover { background-color: #313860; color: #fff; }
        .user-profile { margin-top: auto; display: flex; align-items: center; gap: 10px; padding: 15px; background: rgba(255,255,255,0.05); border-radius: 12px; }
        .user-avatar { width: 40px; height: 40px; background: #868cff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; }
        .user-info h4 { font-size: 0.9rem; }
        .user-info p { font-size: 0.75rem; color: #a0aec0; }
        .logout-btn { margin-left: auto; color: #a0aec0; text-decoration: none; }

        .main-content { flex: 1; padding: 20px 30px; overflow-y: auto; }
        
       .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
        .header h1 { font-size: 1.8rem; }
        .header-icons { display: flex; gap: 15px; font-size: 1.2rem; color: #a0aec0; }
        
        .card { background: white; padding: 25px; border-radius: 16px; box-shadow: 0 4px 15px rgba(0,0,0,0.02); margin-bottom: 25px; }
        .card-title { font-size: 1.1rem; font-weight: 600; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; }
        .card-title i { color: #4318ff; }
        .detail-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .detail-item { padding: 15px; background: #f8fafc; border-radius: 10px; }
        .detail-item label { font-size: 0.8rem; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; display: block; margin-bottom: 5px; }
        .detail-item span { font-size: 1rem; color: #2b3674; font-weight: 500; }
        .btn-back { display: inline-flex; align-items: center; gap: 8px; background: #64748b; color: white; border: none; padding: 10px 20px; border-radius: 8px; cursor: pointer; text-decoration: none; font-size: 0.9rem; font-weight: 600; margin-bottom: 20px; }
        .btn-back:hover { background: #475569; }
        .avatar-big { width: 80px; height: 80px; background: linear-gradient(135deg, #868cff, #4318ff); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2rem; color: white; font-weight: bold; }
        .profile-header { display: flex; align-items: center; gap: 20px; margin-bottom: 25px; }
        .profile-header h2 { font-size: 1.5rem; }
        .profile-header p { color: #64748b; font-size: 0.9rem; }
        .flash-msg { padding: 12px 20px; border-radius: 8px; margin-bottom: 20px; font-weight: 600; font-size: 0.9rem; }
        .flash-success { background: #dcfce7; color: #16a34a; }
        .flash-error { background: #fee2e2; color: #ef4444; }
        .edit-form { margin-top: 10px; }
        .edit-form .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px; }
        .edit-form .form-group { display: flex; flex-direction: column; }
        .edit-form label { font-size: 0.8rem; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px; font-weight: 600; }
        .edit-form input, .edit-form select { padding: 10px 15px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 0.95rem; outline: none; color: #2b3674; }
        .edit-form input:focus, .edit-form select:focus { border-color: #4318ff; box-shadow: 0 0 0 3px rgba(67, 24, 255, 0.1); }
        .btn-save { background: linear-gradient(135deg, #868cff 0%, #4318ff 100%); color: white; border: none; padding: 10px 20px; border-radius: 8px; cursor: pointer; font-weight: 600; font-size: 0.9rem; transition: 0.3s; }
        .btn-save:hover { opacity: 0.9; transform: translateY(-2px); }
        .logout-btn {
    color: #868cff !important;   /* Màu tím nhạt hơn một chút */
}
.logout-btn:hover {
    color: #4318ff !important;
}
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="logo">
            <i class="fa-solid fa-graduation-cap"></i>
            <div>EduManage<span>Cổng Quản trị viên</span></div>
        </div>
        <div class="menu-section">Tổng quan</div>
        <a href="Index.php?action=admin_dashboard" class="menu-item"><i class="fa-solid fa-border-all"></i> Bảng điều khiển</a>
        <div class="menu-section">Quản lý</div>
        <a href="Index.php?action=admin_accounts" class="menu-item"><i class="fa-solid fa-users"></i> Quản lý tài khoản</a>
        <a href="Index.php?action=courses" class="menu-item"><i class="fa-solid fa-book"></i> Môn học</a>
        <a href="Index.php?action=classes" class="menu-item"><i class="fa-solid fa-users-rectangle"></i> Lớp học</a>
        <a href="Index.php?action=schedules" class="menu-item"><i class="fa-regular fa-calendar-days"></i> Lịch học</a>
        <div class="menu-section">Hành chính</div>
        <a href="Index.php?action=registration_periods" class="menu-item"><i class="fa-regular fa-folder-open"></i> Kỳ đăng ký</a>
        <a href="Index.php?action=reports" class="menu-item"><i class="fa-solid fa-chart-line"></i> Báo cáo & Thống kê</a>
        
            <div class="user-profile">
            <a href="Index.php?action=logout" class="sign-out">
            <i class="fa-solid fa-arrow-right-from-bracket"></i> Đăng xuất
        </a>
        </div>
    </div>
    <div class="main-content">
        <a href="Index.php?action=admin_accounts" class="btn-back"><i class="fa-solid fa-arrow-left"></i> Quay lại danh sách</a>
        <?php if (isset($_SESSION['flash_success'])): ?>
            <div class="flash-msg flash-success"><i class="fa-solid fa-check-circle"></i> <?= $_SESSION['flash_success']; unset($_SESSION['flash_success']); ?></div>
        <?php endif; ?>
        <?php if (isset($_SESSION['flash_error'])): ?>
            <div class="flash-msg flash-error"><i class="fa-solid fa-exclamation-circle"></i> <?= $_SESSION['flash_error']; unset($_SESSION['flash_error']); ?></div>
        <?php endif; ?>
        <div class="card">
            <div class="profile-header">
                <div class="avatar-big"><?= $student['ho_ten'] ? substr($student['ho_ten'], 0, 1) : 'A'; ?></div>
                <div>
                    <h2><?= htmlspecialchars($student['ho_ten'] && $student['ho_ten'] !== 'Chưa cập nhật' ? $student['ho_ten'] : ($student['vai_tro'] === 'quan_tri' ? 'Quản trị viên' : 'Chưa cập nhật')); ?></h2>
                    <p>
                        <?php if ($student['vai_tro'] === 'sinh_vien' && !empty($student['ma_sinh_vien'])): ?>
                            <i class="fa-solid fa-id-badge"></i> <?= htmlspecialchars($student['ma_sinh_vien']); ?> &nbsp;|&nbsp;
                        <?php endif; ?>
                        <i class="fa-solid fa-envelope"></i> <?= htmlspecialchars($student['email']); ?>
                        &nbsp;|&nbsp;
                        <span style="background: <?= $student['vai_tro'] === 'quan_tri' ? '#fef3c7;color:#d97706' : '#e0e7ff;color:#4318ff'; ?>; padding: 4px 10px; border-radius: 6px; font-size: 0.8rem; font-weight: 600;">
                            <?= $student['vai_tro'] === 'quan_tri' ? 'Quản trị viên' : 'Sinh viên'; ?>
                        </span>
                    </p>
                </div>
            </div>
        </div>
        <?php if ($student['vai_tro'] === 'sinh_vien'): ?>
        <div class="card">
            <h3 class="card-title"><i class="fa-solid fa-user"></i> Thông tin cá nhân</h3>
            <div class="detail-grid">
                <div class="detail-item">
                    <label>Họ và tên</label>
                    <span><?= htmlspecialchars($student['ho_ten'] && $student['ho_ten'] !== 'Chưa cập nhật' ? $student['ho_ten'] : '—'); ?></span>
                </div>
                <div class="detail-item">
                    <label>Mã sinh viên</label>
                    <span><?= htmlspecialchars($student['ma_sinh_vien'] ?? '—'); ?></span>
                </div>
                <div class="detail-item">
                    <label>Ngày sinh</label>
                    <span><?= $student['ngay_sinh'] ? date('d/m/Y', strtotime($student['ngay_sinh'])) : '—'; ?></span>
                </div>
                <div class="detail-item">
                    <label>Giới tính</label>
                    <span><?= $student['gioi_tinh'] ?: '—'; ?></span>
                </div>
                <div class="detail-item">
                    <label>Số điện thoại</label>
                    <span><?= htmlspecialchars($student['so_dien_thoai'] ?? '—'); ?></span>
                </div>
                <div class="detail-item">
                    <label>Địa chỉ</label>
                    <span><?= htmlspecialchars($student['dia_chi'] ?? '—'); ?></span>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <div class="card">
            <h3 class="card-title"><i class="fa-solid fa-lock"></i> Thông tin tài khoản</h3>
            <form method="POST" action="Index.php?action=admin_process_edit_account" class="edit-form">
                <input type="hidden" name="account_id" value="<?= $student['id']; ?>">
                <div class="form-row">
                    <div class="form-group">
                        <label><i class="fa-solid fa-envelope"></i> Email đăng nhập</label>
                        <input type="email" name="email" value="<?= htmlspecialchars($student['email']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label><i class="fa-solid fa-user-tag"></i> Vai trò</label>
                        <select name="vai_tro" required>
                            <option value="sinh_vien" <?= $student['vai_tro'] === 'sinh_vien' ? 'selected' : ''; ?>>Sinh viên</option>
                            <option value="quan_tri" <?= $student['vai_tro'] === 'quan_tri' ? 'selected' : ''; ?>>Quản trị viên</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn-save"><i class="fa-solid fa-save"></i> Lưu thay đổi</button>
            </form>
            <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #e2e8f0;">
                <div class="detail-grid">
                    <div class="detail-item">
                        <label><i class="fa-solid fa-key"></i> Mật khẩu hiện tại</label>
                        <span><?= htmlspecialchars($student['mat_khau'] ?? '—'); ?></span>
                    </div>
                    <div class="detail-item">
                        <label>Ngày tạo</label>
                        <span><?= date('d/m/Y H:i', strtotime($student['ngay_tao'])); ?></span>
                    </div>
                    <div class="detail-item">
                        <label>ID tài khoản</label>
                        <span><?= $student['id']; ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
