<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý tài khoản - Quản trị viên</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', sans-serif; }
        body { display: flex; background-color: #f4f7fe; color: #2b3674; min-height: 100vh; }
        .sidebar { width: 260px; background-color: #111c44; color: #fff; display: flex; flex-direction: column; padding: 20px; position: fixed; height: 100vh; z-index: 100;}
        .logo { font-size: 1.2rem; font-weight: bold; display: flex; align-items: center; gap: 10px; margin-bottom: 30px; }
        .logo i { background: rgba(255,255,255,0.1); padding: 8px; border-radius: 8px; }
        .logo span { font-size: 0.75rem; font-weight: normal; color: #a0aec0; display: block; }
        .menu-section { font-size: 0.75rem; color: #a0aec0; font-weight: bold; margin: 20px 0 10px; text-transform: uppercase; letter-spacing: 1px; }
        .menu-item { padding: 12px 15px; border-radius: 8px; color: #a0aec0; text-decoration: none; display: flex; align-items: center; gap: 15px; margin-bottom: 5px; transition: 0.3s; cursor: pointer; }
        .menu-item:hover, .menu-item.active { background-color: #313860; color: #fff; }
        .menu-item.active { background: linear-gradient(135deg, #868cff 0%, #4318ff 100%); }
        .user-profile { margin-top: auto; display: flex; align-items: center; gap: 10px; padding: 15px; background: rgba(255,255,255,0.05); border-radius: 12px; }
        .user-avatar { width: 40px; height: 40px; background: #868cff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; }
        .user-info h4 { font-size: 0.9rem; }
        .user-info p { font-size: 0.75rem; color: #a0aec0; }
        .logout-btn { margin-left: auto; color: #a0aec0; text-decoration: none; }
       .main-content { margin-left: 260px; flex: 1; padding: 20px 30px; }
         .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
        .header h1 { font-size: 1.8rem; }
        .header-icons { display: flex; gap: 15px; font-size: 1.2rem; color: #a0aec0; }
        .card { background: white; padding: 25px; border-radius: 16px; box-shadow: 0 4px 15px rgba(0,0,0,0.02); margin-bottom: 25px; }
        .toolbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 10px; }
        .search-box { display: flex; align-items: center; background: #f4f7fe; border-radius: 10px; padding: 8px 15px; gap: 10px; }
        .search-box input { border: none; background: transparent; outline: none; font-size: 0.95rem; width: 250px; color: #2b3674; }
        .search-box i { color: #a0aec0; }
        .btn-add { background: linear-gradient(135deg, #868cff 0%, #4318ff 100%); color: white; border: none; padding: 10px 20px; border-radius: 10px; cursor: pointer; font-size: 0.95rem; font-weight: 600; display: flex; align-items: center; gap: 8px; transition: 0.3s; }
        .btn-add:hover { opacity: 0.9; }
        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; padding: 12px 15px; background: #f4f7fe; color: #a0aec0; font-size: 0.85rem; font-weight: 600; }
        td { padding: 12px 15px; border-bottom: 1px solid #f1f5f9; font-size: 0.9rem; }
        tr:hover td { background: #fafbfd; }
        .btn-view { background: #e0e7ff; color: #4318ff; border: none; padding: 6px 12px; border-radius: 6px; cursor: pointer; font-size: 0.85rem; margin-right: 5px; transition: 0.2s; text-decoration: none; }
        .btn-view:hover { background: #c7d2fe; }
        .btn-delete { background: #fee2e2; color: #ef4444; border: none; padding: 6px 12px; border-radius: 6px; cursor: pointer; font-size: 0.85rem; transition: 0.2s; }
        .btn-delete:hover { background: #fecaca; }
        .modal-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center; }
        .modal-overlay.show { display: flex; }
        .modal { background: white; padding: 30px; border-radius: 16px; width: 400px; max-width: 90%; }
        .modal h3 { margin-bottom: 20px; font-size: 1.2rem; }
        .modal .form-group { margin-bottom: 15px; }
        .modal label { display: block; font-size: 0.85rem; color: #64748b; margin-bottom: 5px; }
        .modal input[type="email"], .modal input[type="password"] { width: 100%; padding: 10px 15px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 0.95rem; outline: none; }
        .modal input:focus { border-color: #4318ff; }
        .modal-actions { display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px; }
        .btn-cancel { background: #f1f5f9; color: #64748b; border: none; padding: 10px 20px; border-radius: 8px; cursor: pointer; font-weight: 600; }
        .btn-submit { background: #4318ff; color: white; border: none; padding: 10px 20px; border-radius: 8px; cursor: pointer; font-weight: 600; }
        .flash-msg { padding: 12px 20px; border-radius: 8px; margin-bottom: 20px; font-weight: 600; font-size: 0.9rem; }
        .flash-success { background: #dcfce7; color: #16a34a; }
        .flash-error { background: #fee2e2; color: #ef4444; }
        .empty-state { text-align: center; padding: 40px; color: #94a3b8; }
        .empty-state i { font-size: 3rem; margin-bottom: 10px; }
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
</a>
        </div>
    </div>
    <div class="main-content">
        <div class="header">
            <h1><i class="fa-solid fa-users" style="color: #4318ff;"></i> Quản lý tài khoản sinh viên</h1>
            <div class="header-icons"><i class="fa-regular fa-bell"></i></div>
        </div>
        <?php if (isset($_SESSION['flash_success'])): ?>
            <div class="flash-msg flash-success"><i class="fa-solid fa-check-circle"></i> <?= $_SESSION['flash_success']; unset($_SESSION['flash_success']); ?></div>
        <?php endif; ?>
        <?php if (isset($_SESSION['flash_error'])): ?>
            <div class="flash-msg flash-error"><i class="fa-solid fa-exclamation-circle"></i> <?= $_SESSION['flash_error']; unset($_SESSION['flash_error']); ?></div>
        <?php endif; ?>
        <div class="card">
            <div class="toolbar">
                <form method="GET" action="Index.php" style="display:flex; gap: 8px;">
                    <input type="hidden" name="action" value="admin_accounts">
                    <div class="search-box">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input type="text" name="search" placeholder="Tìm theo email, tên, mã SV..." value="<?= htmlspecialchars($searchKeyword) ?>">
                    </div>
                    <button type="submit" class="btn-add" style="background:#64748b;">Tìm</button>
                    <?php if (isset($searchKeyword) && $searchKeyword !== ''): ?>
                        <a href="Index.php?action=admin_accounts" class="btn-add" style="background:#94a3b8; text-decoration:none; padding: 10px 15px;">Xóa bộ lọc</a>
                    <?php endif; ?>
                </form>
                <button class="btn-add" onclick="openModal()"><i class="fa-solid fa-plus"></i> Thêm tài khoản</button>
            </div>
            <?php if (empty($accounts)): ?>
                <div class="empty-state">
                    <i class="fa-solid fa-users-slash"></i>
                    <p>Không tìm thấy tài khoản nào.</p>
                </div>
            <?php else: ?>
                <div style="margin-bottom: 15px; font-size: 0.9rem; color: #64748b;">
                    Tổng cộng: <strong><?= count($accounts); ?></strong> tài khoản sinh viên
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Họ tên</th>
                            <th>Vai trò</th>
                            <th>Email</th>
                            <th>Mã SV</th>
                            <th>Ngày tạo</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($accounts as $i => $acc): ?>
                        <tr>
                            <td><?= $i + 1; ?></td>
                            <td>
                                <?php
                                    $displayName = '';
                                    if (!empty($acc['ho_ten'])) {
                                        $displayName = htmlspecialchars($acc['ho_ten']);
                                    } else {
                                        $displayName = '—';
                                    }
                                ?>
                                <strong><?= $displayName; ?></strong>
                            </td>
                            <td>
                                <?php if ($acc['vai_tro'] === 'quan_tri'): ?>
                                    <span style="background:#fef3c7;color:#d97706;padding:4px 10px;border-radius:6px;font-size:0.8rem;font-weight:600;">Quản trị viên</span>
                                <?php else: ?>
                                    <span style="background:#e0e7ff;color:#4318ff;padding:4px 10px;border-radius:6px;font-size:0.8rem;font-weight:600;">Sinh viên</span>
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($acc['email']); ?></td>
                            <td><code><?= !empty($acc['ma_sinh_vien']) ? htmlspecialchars($acc['ma_sinh_vien']) : '—'; ?></code></td>
                            <td><?= date('d/m/Y', strtotime($acc['ngay_tao'])); ?></td>
                            <td>
                                <a href="Index.php?action=admin_view_student&id=<?= $acc['id']; ?>" class="btn-view"><i class="fa-solid fa-eye"></i> Xem</a>
                                <form method="POST" action="Index.php?action=admin_delete_account" style="display:inline;" onsubmit="return confirm('Bạn có chắc muốn xóa tài khoản này?');">
                                    <input type="hidden" name="account_id" value="<?= $acc['id']; ?>">
                                    <button type="submit" class="btn-delete"><i class="fa-solid fa-trash"></i> Xóa</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
    <div class="modal-overlay" id="addModal">
        <div class="modal">
            <h3><i class="fa-solid fa-user-plus" style="color: #4318ff;"></i> Thêm tài khoản</h3>
            <form method="POST" action="Index.php?action=admin_add_account">
                <div class="form-group">
                    <label>Vai trò</label>
                    <select name="vai_tro" id="modal_vaitro" onchange="toggleNameField()" style="width:100%;padding:10px 15px;border:1px solid #e2e8f0;border-radius:8px;font-size:0.95rem;outline:none;">
                        <option value="sinh_vien">Sinh viên</option>
                        <option value="quan_tri">Quản trị viên</option>
                    </select>
                </div>
                <div class="form-group" id="nameField">
                    <label>Họ và tên</label>
                    <input type="text" name="ho_ten" id="modal_hoten" placeholder="Nguyễn Văn A">
                </div>
                <div class="form-group">
                    <label>Email (đăng nhập)</label>
                    <input type="email" name="email" placeholder="sinhvien@student.edu.vn" required>
                </div>
                <div class="form-group">
                    <label>Mật khẩu</label>
                    <input type="password" name="password" placeholder="Mật khẩu đăng nhập" required>
                </div>
                <div class="modal-actions">
                    <button type="button" class="btn-cancel" onclick="closeModal()">Hủy</button>
                    <button type="submit" class="btn-submit">Thêm</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        function openModal() { document.getElementById('addModal').classList.add('show'); }
        function closeModal() { document.getElementById('addModal').classList.remove('show'); }
        function toggleNameField() {
            var role = document.getElementById('modal_vaitro').value;
            var nameField = document.getElementById('nameField');
            var nameInput = document.getElementById('modal_hoten');
            if (role === 'quan_tri') {
                nameField.style.display = 'none';
                nameInput.removeAttribute('required');
                nameInput.value = '';
            } else {
                nameField.style.display = 'block';
                nameInput.setAttribute('required', 'required');
            }
        }
    </script>
</body>
</html>
