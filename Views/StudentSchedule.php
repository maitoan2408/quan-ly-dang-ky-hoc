<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thời khóa biểu - Sinh viên</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', sans-serif; }
        body { display: flex; background-color: #f8f9fa; color: #1a1a2e; min-height: 100vh; }

        /* Sidebar */
        .sidebar { width: 260px; background-color: #111c44; color: #fff; display: flex; flex-direction: column; padding: 20px; position: fixed; height: 100vh; z-index: 100; }
        .logo { font-size: 1.1rem; font-weight: bold; display: flex; align-items: center; gap: 10px; margin-bottom: 30px; }
        .logo i { background: rgba(255,255,255,0.1); padding: 8px; border-radius: 8px; }
        .student-profile-mini { display: flex; align-items: center; gap: 12px; background: rgba(255,255,255,0.05); padding: 12px; border-radius: 12px; margin-bottom: 25px; }
        .avatar-mini { width: 40px; height: 40px; background: #6d28d9; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; }
        .info-mini h4 { font-size: 0.9rem; }
        .info-mini p { font-size: 0.75rem; color: #a0aec0; }
        .menu-section { font-size: 0.75rem; color: #a0aec0; font-weight: bold; margin: 20px 0 10px; text-transform: uppercase; letter-spacing: 1px; }
        .menu-item { padding: 10px 15px; border-radius: 8px; color: #a0aec0; text-decoration: none; display: flex; align-items: center; gap: 15px; margin-bottom: 5px; transition: 0.3s; font-size: 0.9rem; }
        .menu-item:hover, .menu-item.active { background-color: rgba(255,255,255,0.05); color: #fff; }
        .menu-item.active { background: #1a1b41; border-left: 4px solid #6d28d9; }
        .sign-out { margin-top: auto; padding: 15px; color: #a0aec0; text-decoration: none; display: flex; align-items: center; gap: 15px; font-size: 0.9rem; }

        /* Main Content */
        .main-content { margin-left: 260px; flex: 1; padding: 25px 30px; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
        .header h1 { font-size: 1.6rem; font-weight: 600; }

        /* Stats */
        .stats-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 35px; }
        .stat-card { background: white; padding: 25px; border-radius: 16px; text-align: center; box-shadow: 0 4px 15px rgba(0,0,0,0.03); }
        .stat-icon { width: 55px; height: 55px; margin: 0 auto 15px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.6rem; }
        .stat-value { font-size: 2.4rem; font-weight: 700; color: #1a1a2e; }
        .stat-label { font-size: 0.9rem; color: #64748b; }

        /* Weekly Timetable Grid */
        .timetable { background: white; border-radius: 16px; padding: 25px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); margin-bottom: 35px; }
        .timetable-grid {
            display: grid;
            grid-template-columns: 90px repeat(6, 1fr);
            gap: 2px;
            background: #e2e8f0;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            overflow: hidden;
        }
        .grid-header { background: #f8fafc; padding: 15px 10px; text-align: center; font-weight: 600; color: #334155; }
        .time-col { background: #f8fafc; padding: 20px 8px; text-align: center; font-size: 0.85rem; color: #64748b; font-weight: 500; }
        .grid-cell { background: white; padding: 10px; min-height: 130px; position: relative; }

        .schedule-block {
            padding: 12px;
            border-radius: 10px;
            font-size: 0.85rem;
            box-shadow: 0 3px 8px rgba(0,0,0,0.06);
            margin-bottom: 8px;
        }
        .block-purple { background: #f3f0ff; border-left: 5px solid #6d28d9; }
        .block-green  { background: #ecfdf5; border-left: 5px solid #10b981; }
        .block-orange { background: #fffbeb; border-left: 5px solid #f59e0b; }

        .block-title { font-weight: 700; font-size: 0.95rem; }
        .block-subtitle { font-size: 0.8rem; opacity: 0.85; margin-top: 4px; }
    </style>
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <div class="logo">
        <i class="fa-solid fa-graduation-cap"></i>
        <span>Cổng Sinh viên</span>
    </div>
    <div class="student-profile-mini">
        <div class="avatar-mini"><?= substr(htmlspecialchars($studentProfile['ho_ten']), 0, 1); ?></div>
        <div class="info-mini">
            <h4><?= htmlspecialchars($studentProfile['ho_ten']); ?></h4>
            <p><?= htmlspecialchars($studentProfile['ma_sinh_vien']); ?></p>
        </div>
    </div>

    <div class="menu-section">TỔNG QUAN</div>
    <a href="Index.php?action=student_dashboard" class="menu-item"><i class="fa-solid fa-border-all"></i> Bảng điều khiển</a>

    <div class="menu-section">HỌC TẬP</div>
    <a href="Index.php?action=student_course_registration" class="menu-item"><i class="fa-regular fa-square-plus"></i> Đăng ký môn học</a>
    <a href="Index.php?action=student_schedule" class="menu-item active"><i class="fa-regular fa-calendar-days"></i> Lịch học của tôi</a>
    <a href="Index.php?action=student_study_program" class="menu-item"><i class="fa-solid fa-graduation-cap"></i> Chương trình học</a>

    <div class="menu-section">TÀI CHÍNH</div>
    <a href="Index.php?action=student_tuition" class="menu-item"><i class="fa-solid fa-wallet"></i> Học phí & Lệ phí</a>

    <div class="menu-section">TÀI KHOẢN</div>
    <a href="Index.php?action=student_settings" class="menu-item"><i class="fa-solid fa-gear"></i> Cài đặt tài khoản</a>

    <a href="Index.php?action=logout" class="sign-out">
        <i class="fa-solid fa-arrow-right-from-bracket"></i> Đăng xuất
    </a>
</div>

<!-- MAIN CONTENT -->
<div class="main-content">
    <div class="header">
        <h1>Thời khóa biểu của tôi</h1>
    </div>

    <!-- 3 Stats -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon" style="background:#f3f0ff;color:#6d28d9;"><i class="fa-solid fa-book-open"></i></div>
            <div class="stat-value"><?= $totalCourses ?></div>
            <div class="stat-label">Số buổi học</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#ecfdf5;color:#10b981;"><i class="fa-solid fa-clock"></i></div>
            <div class="stat-value"><?= number_format($totalHours, 1) ?></div>
            <div class="stat-label">Số giờ/tuần</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#fffbeb;color:#f59e0b;"><i class="fa-solid fa-calendar"></i></div>
            <div class="stat-value"><?= $uniqueDaysCount ?></div>
            <div class="stat-label">Số ngày đi học</div>
        </div>
    </div>

    <!-- Weekly Timetable Grid -->
    <div class="timetable">
        <div class="timetable-grid">
            <div class="grid-header" style="background:#f8fafc;">Thời gian</div>
            <div class="grid-header">Thứ 2</div>
            <div class="grid-header">Thứ 3</div>
            <div class="grid-header">Thứ 4</div>
            <div class="grid-header">Thứ 5</div>
            <div class="grid-header">Thứ 6</div>
            <div class="grid-header">Thứ 7</div>

            <!-- Ca 1: 07:30 - 10:00 -->
            <div class="time-col">07:30 - 10:00</div>
            <?php for($i = 2; $i <= 7; $i++): ?>
                <div class="grid-cell" id="slot-<?= $i ?>-1"></div>
            <?php endfor; ?>

            <!-- Ca 2: 13:30 - 16:00 -->
            <div class="time-col">13:30 - 16:00</div>
            <?php for($i = 2; $i <= 7; $i++): ?>
                <div class="grid-cell" id="slot-<?= $i ?>-2"></div>
            <?php endfor; ?>
        </div>
    </div>

    <script>
        // Dữ liệu từ PHP
        const courses = <?= json_encode($enrolledCourses) ?>;

        courses.forEach(course => {
            if (!course.thu) return;
            const days = course.thu.split(',').map(d => d.trim());
            const startTime = course.gio_vao_hoc ? course.gio_vao_hoc.substring(0,5) : '';

            days.forEach(day => {
                let col = 0;
                if (day === 'Thứ 2') col = 2;
                else if (day === 'Thứ 3') col = 3;
                else if (day === 'Thứ 4') col = 4;
                else if (day === 'Thứ 5') col = 5;
                else if (day === 'Thứ 6') col = 6;
                else if (day === 'Thứ 7') col = 7;

                if (col === 0) return;

                // Xác định ca học
                let slot = (startTime >= '13:30') ? 2 : 1;
                const cellId = `slot-${col}-${slot}`;
                const cell = document.getElementById(cellId);

                if (cell) {
                    const block = document.createElement('div');
                    block.className = `schedule-block ${slot === 1 ? 'block-purple' : 'block-green'}`;
                    block.innerHTML = `
                        <div class="block-title">${course.ma_mon_hoc}</div>
                        <div class="block-subtitle">${course.ten_mon_hoc}<br>
                        <small>${course.ten_giang_vien} • ${course.phong_hoc}</small></div>
                    `;
                    cell.appendChild(block);
                }
            });
        });
    </script>
</div>
</body>
</html>