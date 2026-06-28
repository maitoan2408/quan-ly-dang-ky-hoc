<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bảng điều khiển - Quản trị viên</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', sans-serif; }
        body { display: flex; background-color: #f4f7fe; color: #2b3674; min-height: 100vh; overflow-x: hidden; }

        /* --- SIDEBAR (Thanh điều hướng bên trái) --- */
        .sidebar { width: 260px; background-color: #111c44; color: #fff; display: flex; flex-direction: column; padding: 20px; }
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

        /* --- MAIN CONTENT (Nội dung bên phải) --- */
        .main-content { flex: 1; padding: 20px 30px; overflow-y: auto; }
        
       .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
        .header h1 { font-size: 1.8rem; }
        .header-icons { display: flex; gap: 15px; font-size: 1.2rem; color: #a0aec0; }
        
        /* Banner */
        .banner { background: linear-gradient(135deg, #868cff 0%, #4318ff 100%); border-radius: 16px; padding: 25px; color: white; display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
        .banner-icon { width: 45px; height: 45px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 15px; }
        .banner-text h3 { font-size: 1.2rem; margin-bottom: 5px; }
        .banner-text p { font-size: 0.9rem; opacity: 0.8; }
        .btn-manage { background: rgba(255,255,255,0.2); border: none; color: white; padding: 10px 20px; border-radius: 20px; cursor: pointer; transition: 0.3s; }
        .btn-manage:hover { background: rgba(255,255,255,0.3); }

        /* Stats Grid */
        .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 25px; }
        .stat-card { background: white; padding: 20px; border-radius: 16px; display: flex; flex-direction: column; position: relative; box-shadow: 0 4px 15px rgba(0,0,0,0.02); }
        .stat-icon { width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-bottom: 10px; font-size: 1.2rem; }
        .stat-card h4 { font-size: 0.85rem; color: #a0aec0; margin-bottom: 5px; font-weight: normal; }
        .stat-card h2 { font-size: 1.8rem; }
        .badge { position: absolute; top: 20px; right: 20px; font-size: 0.75rem; font-weight: bold; background: #e6ffed; color: #05cd99; padding: 4px 8px; border-radius: 8px; }

        /* Charts Layout */
        .grid-layout { display: grid; grid-template-columns: 2fr 1fr; gap: 20px; margin-bottom: 25px; }
        .card { background: white; padding: 25px; border-radius: 16px; box-shadow: 0 4px 15px rgba(0,0,0,0.02); }
        .card-title { font-size: 1.1rem; font-weight: 600; margin-bottom: 5px; }
        .card-subtitle { font-size: 0.85rem; color: #a0aec0; margin-bottom: 20px; }
        
        /* Canvas Wrapper để giới hạn kích thước biểu đồ */
        .chart-container { position: relative; height: 250px; width: 100%; }

        /* Quick Actions */
        .actions-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px; }
        .action-btn { background: white; border: 1px solid #e2e8f0; padding: 15px; border-radius: 12px; display: flex; align-items: center; gap: 10px; font-weight: 600; cursor: pointer; transition: 0.3s; color: #2b3674; }
        .action-btn:hover { border-color: #4318ff; box-shadow: 0 4px 10px rgba(67, 24, 255, 0.1); }
        .action-btn i { color: #4318ff; background: #f4f7fe; padding: 10px; border-radius: 8px; }
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
        <a href="Index.php?action=admin_dashboard" class="menu-item active"><i class="fa-solid fa-border-all"></i> Bảng điều khiển</a>        
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
        <i class="fa-solid fa-arrow-right-from-bracket"></i> 
        <span>Đăng xuất</span>
    </a>
</div>
        </div>
    </div>

    <div class="main-content">
        <div class="header">
            <h1> <i class="fa-solid fa-border-all" style="color: #4318ff;"></i> Bảng điều khiển</h1>
            <div class="header-icons">
                <i class="fa-regular fa-bell"></i>
                <i class="fa-solid fa-shield-halved" style="color: #4318ff;"></i>
            </div>
        </div>

        <?php if (!empty($stats['open_period'])): ?>
        <div class="banner">
            <div style="display: flex; align-items: center;">
                <div class="banner-icon"><i class="fa-solid fa-wave-square"></i></div>
                <div class="banner-text">
                    <h3>Cổng đăng ký đang mở</h3>
                    <p><?= htmlspecialchars($stats['open_period']['ten_ky_hoc']); ?> • Kết thúc vào <?= date('d/m/Y', strtotime($stats['open_period']['thoi_gian_ket_thuc'])); ?></p>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon" style="background: #f4f7fe; color: #4318ff;"><i class="fa-solid fa-user-group"></i></div>
                <h4>Tổng số sinh viên</h4>
                <h2><?= $stats['total_students'] ?? 0; ?></h2>
                <div class="badge">+12%</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background: #f4f7fe; color: #4318ff;"><i class="fa-solid fa-book-open"></i></div>
                <h4>Môn học đang mở</h4>
                <h2><?= $stats['total_courses'] ?? 0; ?></h2>
                <div class="badge">+3</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background: #f4f7fe; color: #05cd99;"><i class="fa-solid fa-arrow-trend-up"></i></div>
                <h4>Tỷ lệ đăng ký</h4>
                <h2><?= $stats['fill_rate'] ?? 0; ?>%</h2>
                <div class="badge" style="color: #05cd99;">+5.2%</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background: #fff3e0; color: #ff9800;"><i class="fa-regular fa-clipboard"></i></div>
                <h4>Kỳ mở đăng ký</h4>
                <h2><?= $stats['open_periods'] ?? 0; ?></h2>
                <div class="badge" style="background: #fff3e0; color: #ff9800;">Đang hoạt động</div>
            </div>
        </div>
    </div>
</body>
</html>
