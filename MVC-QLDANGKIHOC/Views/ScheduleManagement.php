<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý lịch học - Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', sans-serif; }
        body { display: flex; background-color: #f4f7fe; color: #2b3674; min-height: 100vh; }
        
        /* --- SIDEBAR GIỮ NGUYÊN --- */
        .sidebar { width: 260px; background-color: #111c44; color: #fff; display: flex; flex-direction: column; padding: 20px; position: fixed; height: 100vh; z-index: 100;}
        .logo { font-size: 1.2rem; font-weight: bold; display: flex; align-items: center; gap: 10px; margin-bottom: 30px; }
        .logo i { background: rgba(255,255,255,0.1); padding: 8px; border-radius: 8px; }
        .logo span { font-size: 0.75rem; color: #a0aec0; display: block; font-weight: normal; }
        .menu-section { font-size: 0.75rem; color: #a0aec0; font-weight: bold; margin: 20px 0 10px; text-transform: uppercase; letter-spacing: 1px; }
        .menu-item { padding: 12px 15px; border-radius: 8px; color: #a0aec0; text-decoration: none; display: flex; align-items: center; gap: 15px; margin-bottom: 5px; transition: 0.3s; cursor: pointer; }
        .menu-item:hover, .menu-item.active { background-color: #313860; color: #fff; }
        .menu-item.active { background: linear-gradient(135deg, #868cff 0%, #4318ff 100%); }
        .user-profile { margin-top: auto; display: flex; align-items: center; gap: 10px; padding: 15px; background: rgba(255,255,255,0.05); border-radius: 12px; }

        .main-content { margin-left: 260px; flex: 1; padding: 20px 30px; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
        .header h1 { font-size: 1.8rem; }

        .btn-add { 
            background: #05cd99; color: white; border: none; padding: 10px 20px; border-radius: 8px; 
            cursor: pointer; font-weight: 600; display: inline-flex; align-items: center; gap: 8px; text-decoration: none;
        }
        .btn-add:hover { background: #04b88a; }

        /* --- PHONG CÁCH CARD DANH SÁCH --- */
        .schedule-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 20px;
            padding: 20px 0;
        }

        .schedule-card {
            background: white; border-radius: 16px; padding: 20px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05); transition: 0.3s;
            border: 1px solid #e2e8f0; position: relative;
        }

        .schedule-card:hover { transform: translateY(-5px); box-shadow: 0 10px 25px rgba(67, 24, 255, 0.1); }

        .card-top { display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; padding-bottom: 10px; border-bottom: 1px solid #f1f4f9; }
        .class-badge { background: #e7e9ff; color: #4318ff; padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; }

        .action-icons { display: flex; gap: 8px; }
        .icon-btn { width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; cursor: pointer; border: none; transition: 0.2s; }
        .edit-btn { background: #f4f7fe; color: #4318ff; }
        .delete-btn { background: #fff5f5; color: #ff5b5b; }

        .course-title { font-size: 1.1rem; font-weight: 700; color: #1b2559; margin-bottom: 15px; line-height: 1.4; }

        .info-group { display: flex; flex-direction: column; gap: 10px; }
        .info-item { display: flex; justify-content: space-between; font-size: 0.9rem; }
        .label { color: #a0aec0; }
        .value { color: #2b3674; font-weight: 600; text-align: right; }
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
        <i class="fa-solid fa-arrow-right-from-bracket"></i> 
        <span>Đăng xuất</span>
    </a>
</div>
    </div>

    <div class="main-content">
        <div class="header">
            <h1><i class="fa-regular fa-calendar-days" style="color: #4318ff;"></i> Quản lý lịch học</h1>
            <div style="display: flex; gap: 15px; font-size: 1.2rem; color: #a0aec0;">
                <i class="fa-regular fa-bell"></i>
                <i class="fa-solid fa-shield-halved" style="color: #4318ff;"></i>
            </div>
        </div>

        <div class="schedule-toolbar">
            <a href="Index.php?action=add_schedule" class="btn-add">
                <i class="fa-solid fa-plus"></i> Thêm lịch học
            </a>
            <div class="search-box" style="position: relative; flex: 1; max-width: 400px;">
        <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #a3aed0;"></i>
        <input type="text" id="searchInput" placeholder="Tìm tên môn, mã lớp hoặc giảng viên..." 
               style="width: 100%; padding: 10px 15px 10px 45px; border-radius: 12px; border: 1px solid #e2e8f0; outline: none; transition: 0.3s;">
    </div>
        </div>

        <div class="schedule-list">
            <?php if (!empty($all_schedules)): ?>
                <?php foreach ($all_schedules as $sch): ?>
                    <div class="schedule-card">
                        <div class="card-top">
                            <span class="class-badge">Mã lớp: <?= htmlspecialchars($sch['ma_lop_hoc']) ?></span>
                            <div class="action-icons">
                                <a href="Index.php?action=edit_schedule&id=<?= $sch['id_lich_hoc'] ?>" class="icon-btn edit-btn"><i class="fa-solid fa-pen-to-square"></i></a>
                                <a href="Index.php?action=delete_schedule&id=<?= $sch['id_lich_hoc'] ?>" class="icon-btn delete-btn" onclick="return confirm('Xác nhận xóa lịch này?')"><i class="fa-solid fa-trash"></i></a>
                            </div>
                        </div>

                        <div class="course-title">
                            <?= htmlspecialchars($sch['ten_mon_hoc']) ?>
                        </div>

                        <div class="info-group">
                            <div class="info-item">
                                <span class="label">Thứ</span>
                                <span class="value" style="color: #05cd99;"><?= htmlspecialchars($sch['thu']) ?></span>
                            </div>
                            <div class="info-item">
                                <span class="label">Giảng viên</span>
                                <span class="value"><?= htmlspecialchars($sch['ten_giang_vien']) ?></span>
                            </div>
                            <div class="info-item">
                                <span class="label">Phòng học</span>
                                <span class="value"><?= htmlspecialchars($sch['phong_hoc']) ?></span>
                            </div>
                            <div class="info-item">
                                <span class="label">Thời gian</span>
                                <span class="value" style="color: #4318ff;">
                                    <?= date('H:i', strtotime($sch['gio_vao_hoc'])) ?> - <?= date('H:i', strtotime($sch['gio_ra_ve'])) ?>
                                </span>
                            </div>
                            <div class="info-item">
                                <span class="label">Ngày bắt đầu</span>
                                <span class="value"><?= date('d/m/Y', strtotime($sch['ngay_bat_dau'])) ?></span>
                        
                            </div>
                            <div class="info-item">
                                <span class="label">Ngày kết thúc</span>
                                <span class="value"><?= date('d/m/Y', strtotime($sch['ngay_ket_thuc'])) ?></span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div style="grid-column: 1/-1; text-align: center; padding: 60px; background: white; border-radius: 16px;">
                    <i class="fa-regular fa-calendar-xmark" style="font-size: 3.5rem; color: #e2e8f0; margin-bottom: 15px; display: block;"></i>
                    <p style="color: #a0aec0; font-size: 1.1rem;">Chưa có lịch học nào được tạo.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <script>
    document.getElementById('searchInput').addEventListener('keyup', function() {
        // Lấy giá trị tìm kiếm và chuyển về chữ thường
        const searchTerm = this.value.toLowerCase();
        // Lấy tất cả các Card lịch học
        const cards = document.querySelectorAll('.schedule-card');

        cards.forEach(card => {
            // Lấy nội dung text trong Card (Tên môn, mã lớp, giảng viên...)
            const text = card.innerText.toLowerCase();
            
            // Nếu tìm thấy từ khóa thì hiện, không thì ẩn
            if (text.includes(searchTerm)) {
                card.style.display = "block";
            } else {
                card.style.display = "none";
            }
        });

        // Xử lý hiển thị thông báo "Không tìm thấy" nếu tất cả card bị ẩn
        const visibleCards = document.querySelectorAll('.schedule-card[style="display: block;"]').length;
        // (Tùy chọn: Bạn có thể thêm một div thông báo kết quả trống ở đây)
    });

    // Thêm hiệu ứng focus cho ô tìm kiếm
    const searchInput = document.getElementById('searchInput');
    searchInput.addEventListener('focus', () => searchInput.style.borderColor = '#4318ff');
    searchInput.addEventListener('blur', () => searchInput.style.borderColor = '#e2e8f0');
</script>
</body>
</html>