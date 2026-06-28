<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cài đặt tài khoản - Sinh viên</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', sans-serif; }
        body { display: flex; background-color: #f8f9fa; color: #1a1a2e; min-height: 100vh; }
        
        /* --- SIDEBAR THỦ CÔNG --- */
        .sidebar { width: 260px; background-color: #111c44; color: #fff; display: flex; flex-direction: column; padding: 20px; position: fixed; height: 100vh; z-index: 100;}
        .logo { font-size: 1.1rem; font-weight: bold; display: flex; align-items: center; gap: 10px; margin-bottom: 30px; }
        .logo i { background: rgba(255,255,255,0.1); padding: 8px; border-radius: 8px; }
        .student-profile-mini { display: flex; align-items: center; gap: 12px; background: rgba(255,255,255,0.05); padding: 12px; border-radius: 12px; margin-bottom: 25px; }
        .avatar-mini { width: 40px; height: 40px; background: #6d28d9; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; }
        .info-mini h4 { font-size: 0.9rem; } .info-mini p { font-size: 0.75rem; color: #a0aec0; }
        .menu-section { font-size: 0.75rem; color: #a0aec0; font-weight: bold; margin: 15px 0 10px; text-transform: uppercase; letter-spacing: 1px; }
        .menu-item { padding: 10px 15px; border-radius: 8px; color: #a0aec0; text-decoration: none; display: flex; align-items: center; gap: 15px; margin-bottom: 5px; transition: 0.3s; font-size: 0.9rem; }
        .menu-item:hover, .menu-item.active { background-color: rgba(255,255,255,0.05); color: #fff; }
        .menu-item.active { background: #1a1b41; border-left: 4px solid #6d28d9; border-radius: 0 8px 8px 0; }
        .sign-out { margin-top: auto; padding: 15px; color: #a0aec0; text-decoration: none; display: flex; align-items: center; gap: 15px; font-size: 0.9rem; }

        /* --- MAIN CONTENT --- */
        .main-content { margin-left: 260px; flex: 1; padding: 20px 30px; max-width: 1000px; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
        .header h1 { font-size: 1.5rem; font-weight: 600; color: #1a1a2e; }

        /* --- TABS --- */
        .tabs-container { display: flex; gap: 10px; margin-bottom: 25px; background: white; padding: 5px; border-radius: 12px; width: fit-content; box-shadow: 0 2px 5px rgba(0,0,0,0.02); border: 1px solid #f1f5f9; }
        .tab-btn { padding: 10px 20px; border: none; background: transparent; border-radius: 8px; font-weight: 600; color: #64748b; cursor: pointer; display: flex; align-items: center; gap: 8px; font-size: 0.9rem; transition: 0.2s; }
        .tab-btn:hover { background: #f8fafc; }
        .tab-btn.active { background: #fff; box-shadow: 0 2px 10px rgba(0,0,0,0.05); color: #1a1a2e; border: 1px solid #e2e8f0; }

        /* --- CARDS & FORMS --- */
        .settings-card { background: white; border-radius: 16px; padding: 30px; border: 1px solid #e2e8f0; box-shadow: 0 4px 15px rgba(0,0,0,0.02); margin-bottom: 25px; }
        .card-title { font-size: 1.1rem; font-weight: 600; color: #1a1a2e; margin-bottom: 20px; }
        
        /* Profile Photo Section */
        .photo-section { display: flex; align-items: center; gap: 25px; }
        .photo-avatar { width: 80px; height: 80px; background: #8b5cf6; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2rem; font-weight: bold; }
        .photo-actions { display: flex; flex-direction: column; gap: 8px; }
        .btn-outline { border: 1px solid #cbd5e1; background: white; padding: 8px 16px; border-radius: 8px; font-weight: 600; color: #4a5568; cursor: pointer; font-size: 0.85rem; width: fit-content; }
        .photo-hint { font-size: 0.75rem; color: #94a3b8; }

        /* Form Grid */
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 15px; }
        .form-group { display: flex; flex-direction: column; gap: 8px; }
        .form-group.full-width { grid-column: span 2; }
        .form-label { font-size: 0.85rem; color: #64748b; font-weight: 500; }
        
        .input-wrapper { position: relative; }
        .input-wrapper i { position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #a0aec0; }
        .form-input { width: 100%; padding: 12px 15px 12px 40px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 0.95rem; color: #1a1a2e; outline: none; transition: 0.2s; }
        .form-input:focus { border-color: #6d28d9; box-shadow: 0 0 0 3px rgba(109, 40, 217, 0.1); }
        
        /* Readonly Inputs */
        .form-input:disabled, .form-input[readonly] { background-color: #f8fafc; color: #64748b; cursor: not-allowed; border-color: #e2e8f0; }
        .readonly-hint { font-size: 0.8rem; color: #94a3b8; margin-top: -5px; }

        /* Save Button */
        .actions-footer { display: flex; justify-content: flex-end; margin-top: 10px; padding-bottom: 40px; }
        .btn-save { background: #6d28d9; color: white; border: none; padding: 12px 25px; border-radius: 8px; font-weight: 600; cursor: pointer; font-size: 0.95rem; display: flex; align-items: center; gap: 8px; transition: 0.3s; }
        .btn-save:hover { background: #5b21b6; }
    </style>
</head>
<body>

    <div class="sidebar">
       <div class="logo">
            <i class="fa-solid fa-graduation-cap"></i>
            <span>Cổng Sinh viên</span>
        </div>
        
        <div class="student-profile-mini">
            <div class="avatar-mini"><?php echo substr(htmlspecialchars($studentProfile['ho_ten']), 0, 1); ?></div>
            <div class="info-mini">
                <h4><?php echo htmlspecialchars($studentProfile['ho_ten']); ?></h4>
                <p><?php echo htmlspecialchars($studentProfile['ma_sinh_vien']); ?></p>
            </div>
        </div>
        
        <div class="menu-section">Tổng quan</div>
        <a href="Index.php?action=student_dashboard" class="menu-item"><i class="fa-solid fa-border-all"></i> Bảng điều khiển</a>
        
        <div class="menu-section">Học tập</div>
        <a href="Index.php?action=student_course_registration" class="menu-item"><i class="fa-regular fa-square-plus"></i> Đăng ký môn học</a>
        <a href="Index.php?action=student_schedule" class="menu-item"><i class="fa-regular fa-calendar-days"></i> Lịch học của tôi</a>
        <a href="Index.php?action=student_study_program" class="menu-item"><i class="fa-solid fa-graduation-cap"></i> Chương trình học</a>

        <div class="menu-section">Tài chính</div>
        <a href="Index.php?action=student_tuition" class="menu-item"><i class="fa-solid fa-wallet"></i> Học phí & Lệ phí</a>

        <div class="menu-section">Tài khoản</div>
        <a href="Index.php?action=student_settings" class="menu-item"><i class="fa-solid fa-gear"></i> Cài đặt tài khoản</a>
        
        <a href="Index.php?action=logout" class="sign-out">
            <i class="fa-solid fa-arrow-right-from-bracket"></i> Đăng xuất
        </a>
    
    </div> <div class="main-content">

    <div class="main-content">
        <div class="header">
            <h1>Cài đặt tài khoản </h1>
            <div style="display: flex; gap: 15px; font-size: 1.2rem; color: #a0aec0; align-items: center;">
                <i class="fa-regular fa-bell"></i>
                <div style="width: 35px; height: 35px; background: #6d28d9; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1rem;">
                    <?php echo substr(htmlspecialchars($studentProfile['ho_ten']), 0, 1); ?>
                </div>
            </div>
        </div>

        <?php if (isset($_SESSION['flash_success_student'])): ?>
            <div style="background:#dcfce7;color:#16a34a;padding:12px 20px;border-radius:8px;margin-bottom:20px;font-weight:600;font-size:0.9rem;">
                <i class="fa-solid fa-check-circle"></i> <?= $_SESSION['flash_success_student']; unset($_SESSION['flash_success_student']); ?>
            </div>
        <?php endif; ?>
        <?php if (isset($_SESSION['flash_error_student'])): ?>
            <div style="background:#fee2e2;color:#ef4444;padding:12px 20px;border-radius:8px;margin-bottom:20px;font-weight:600;font-size:0.9rem;">
                <i class="fa-solid fa-exclamation-circle"></i> <?= $_SESSION['flash_error_student']; unset($_SESSION['flash_error_student']); ?>
            </div>
        <?php endif; ?>

        <div class="tabs-container">
            <button class="tab-btn active" onclick="switchTab('profile')"><i class="fa-regular fa-user"></i> Profile</button>
            <button class="tab-btn" onclick="switchTab('password')"><i class="fa-solid fa-lock"></i> Password</button>
        </div>

        <!-- PROFILE TAB -->
        <div id="profile-tab">
        <form action="Index.php?action=student_update_profile" method="POST">
            <div class="settings-card">
                <h3 class="card-title">Thông tin cá nhân </h3>
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Họ và Tên </label>
                        <div class="input-wrapper">
                            <i class="fa-regular fa-user"></i>
                            <input type="text" class="form-input" name="ho_ten" value="<?php echo htmlspecialchars($studentProfile['ho_ten'] !== 'Chưa cập nhật' ? $studentProfile['ho_ten'] : ''); ?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Địa chỉ Email </label>
                        <div class="input-wrapper">
                            <i class="fa-regular fa-envelope"></i>
                            <input type="email" class="form-input" value="<?php echo htmlspecialchars($studentProfile['email']); ?>" readonly>
                        </div>
                        <p class="readonly-hint">Email không thể thay đổi.</p>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Giới tính </label>
                        <div class="input-wrapper">
                            <i class="fa-solid fa-venus-mars"></i>
                            <select name="gioi_tinh" class="form-input" style="padding-left:40px;">
                                <?php if (empty($studentProfile['gioi_tinh'])): ?>
                                    <option value="" disabled selected>Chưa xác định</option>
                                <?php endif; ?>
                                <option value="Nam" <?php echo ($studentProfile['gioi_tinh'] ?? '') === 'Nam' ? 'selected' : ''; ?>>Nam</option>
                                <option value="Nữ" <?php echo ($studentProfile['gioi_tinh'] ?? '') === 'Nữ' ? 'selected' : ''; ?>>Nữ</option>
                                <option value="Khác" <?php echo ($studentProfile['gioi_tinh'] ?? '') === 'Khác' ? 'selected' : ''; ?>>Khác</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Số điện thoại</label>
                        <div class="input-wrapper">
                            <i class="fa-solid fa-phone"></i>
                            <input type="text" class="form-input" name="so_dien_thoai" value="<?php echo htmlspecialchars($studentProfile['so_dien_thoai'] ?? ''); ?>" pattern="[0-9]{10}" maxlength="10" placeholder="Nhập đúng 10 chữ số" title="Số điện thoại phải đúng 10 chữ số" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Ngày sinh </label>
                        <div class="input-wrapper">
                            <i class="fa-regular fa-calendar"></i>
                            <input type="date" class="form-input" name="ngay_sinh" value="<?php echo htmlspecialchars($studentProfile['ngay_sinh'] ?? ''); ?>" style="padding-left: 40px;">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Địa chỉ </label>
                        <div class="input-wrapper">
                            <i class="fa-solid fa-location-dot"></i>
                            <input type="text" class="form-input" name="dia_chi" value="<?php echo htmlspecialchars($studentProfile['dia_chi'] ?? ''); ?>">
                        </div>
                    </div>
                </div>
            </div>

            <div class="settings-card">
                <h3 class="card-title">Thông tin học thuật </h3>
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Mã sinh viên </label>
                        <div class="input-wrapper">
                            <input type="text" class="form-input" value="<?php echo htmlspecialchars($studentProfile['ma_sinh_vien']); ?>" disabled style="padding-left: 15px;">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Chương trình đào tạo </label>
                        <div class="input-wrapper">
                            <i class="fa-solid fa-graduation-cap"></i>
                            <input type="text" class="form-input" value="<?php echo htmlspecialchars($program); ?>" disabled>
                        </div>
                    </div>
                </div>
                <p class="readonly-hint">Thông tin học thuật chỉ có thể được thay đổi bởi Quản trị viên.</p>
            </div>

            <div class="actions-footer">
                <button type="submit" class="btn-save"><i class="fa-regular fa-floppy-disk"></i> Lưu thay đổi </button>
            </div>
        </form>
        </div>

        <!-- PASSWORD TAB -->
        <div id="password-tab" style="display:none;">
        <form action="Index.php?action=student_change_password" method="POST">
            <div class="settings-card">
                <h3 class="card-title">Đổi mật khẩu </h3>
                <div class="form-grid" style="grid-template-columns: 1fr;">
                    <div class="form-group">
                        <label class="form-label">Mật khẩu hiện tại</label>
                        <div class="input-wrapper">
                            <i class="fa-solid fa-key"></i>
                            <input type="text" class="form-input" name="old_password" placeholder="Mật khẩu hiện tại" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Mật khẩu mới</label>
                        <div class="input-wrapper">
                            <i class="fa-solid fa-lock"></i>
                            <input type="text" class="form-input" name="new_password" placeholder="Nhập mật khẩu mới" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Xác nhận mật khẩu</label>
                        <div class="input-wrapper">
                            <i class="fa-solid fa-lock"></i>
                            <input type="text" class="form-input" name="confirm_password" placeholder="Nhập lại mật khẩu mới" required>
                        </div>
                    </div>
                </div>
            </div>

            <div class="actions-footer">
                <button type="submit" class="btn-save"><i class="fa-solid fa-key"></i> Đổi mật khẩu</button>
            </div>
        </form>
        </div>

    </div>

    <script>
        function switchTab(tab) {
            var tabs = document.querySelectorAll('.tab-btn');
            tabs.forEach(function(t) { t.classList.remove('active'); });

            document.getElementById('profile-tab').style.display = 'none';
            document.getElementById('password-tab').style.display = 'none';

            if (tab === 'profile') {
                tabs[0].classList.add('active');
                document.getElementById('profile-tab').style.display = 'block';
            } else {
                tabs[1].classList.add('active');
                document.getElementById('password-tab').style.display = 'block';
            }
        }
    </script>
</body>
</html>