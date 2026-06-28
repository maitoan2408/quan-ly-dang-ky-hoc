<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký môn học - Chưa mở</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', sans-serif; }
        body { display: flex; background-color: #f8f9fa; color: #1a1a2e; min-height: 100vh; }

        /* SIDEBAR - Copy nguyên từ file cũ */
        .sidebar { 
            width: 260px; background-color: #111c44; color: #fff; 
            display: flex; flex-direction: column; padding: 20px; 
            position: fixed; height: 100vh; 
        }
        .logo { 
            font-size: 1.1rem; font-weight: bold; display: flex; align-items: center; gap: 10px; margin-bottom: 30px; 
        }
        .logo i { background: rgba(255,255,255,0.1); padding: 8px; border-radius: 8px; }
        .student-profile-mini { 
            display: flex; align-items: center; gap: 12px; 
            background: rgba(255,255,255,0.05); padding: 12px; border-radius: 12px; margin-bottom: 25px; 
        }
        .avatar-mini { 
            width: 40px; height: 40px; background: #6d28d9; border-radius: 50%; 
            display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 1.1rem;
        }
        .info-mini h4 { font-size: 0.95rem; margin-bottom: 2px; }
        .info-mini p { font-size: 0.8rem; color: #a0aec0; }
        
        .menu-section { 
            font-size: 0.75rem; color: #a0aec0; font-weight: bold; 
            margin: 20px 0 10px; text-transform: uppercase; letter-spacing: 1px; 
        }
        .menu-item { 
            padding: 10px 15px; border-radius: 8px; color: #a0aec0; text-decoration: none; 
            display: flex; align-items: center; gap: 15px; margin-bottom: 5px; 
            transition: 0.3s; font-size: 0.9rem; 
        }
        .menu-item:hover, .menu-item.active { 
            background-color: rgba(255,255,255,0.05); color: #fff; 
        }
        .menu-item.active { 
            background: #1a1b41; border-left: 4px solid #6d28d9; border-radius: 0 8px 8px 0; 
        }
        .sign-out { 
            margin-top: auto; padding: 15px; color: #a0aec0; text-decoration: none; 
            display: flex; align-items: center; gap: 15px; font-size: 0.9rem; 
        }

        /* MAIN CONTENT */
        .main-content { 
            margin-left: 260px; flex: 1; padding: 40px 30px; text-align: center; 
        }

        .closed-box {
            max-width: 620px;
            margin: 80px auto;
            background: white;
            padding: 60px 40px;
            border-radius: 16px;
            box-shadow: 0 4px 25px rgba(0,0,0,0.06);
        }
        .icon-big { 
            font-size: 5.5rem; 
            color: #f59e0b; 
            margin-bottom: 25px; 
        }
        h1 { 
            font-size: 1.85rem; 
            color: #1e2937; 
            margin-bottom: 16px; 
        }
        p { 
            color: #64748b; 
            font-size: 1.05rem; 
            line-height: 1.7; 
        }
        .status { 
            color: #f59e0b; 
            font-weight: 600; 
        }
        .btn-back {
            margin-top: 35px;
            display: inline-block;
            padding: 13px 32px;
            background: #6d28d9;
            color: white;
            border-radius: 8px;
            text-decoration: none;
            font-size: 1rem;
            transition: 0.3s;
        }
        .btn-back:hover {
            background: #5b21b6;
            transform: translateY(-2px);
        }
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
            <div class="avatar-mini">
                <?= substr(htmlspecialchars($studentProfile['ho_ten'] ?? 'N'), 0, 1) ?>
            </div>
            <div class="info-mini">
                <h4><?= htmlspecialchars($studentProfile['ho_ten'] ?? 'Nguyễn Văn Hải') ?></h4>
                <p><?= htmlspecialchars($studentProfile['ma_sinh_vien'] ?? '74DCTT1001') ?></p>
            </div>
        </div>

        <div class="menu-section">Tổng quan</div>
        <a href="Index.php?action=student_dashboard" class="menu-item">
            <i class="fa-solid fa-border-all"></i> Bảng điều khiển
        </a>

        <div class="menu-section">Học tập</div>
        <a href="Index.php?action=student_course_registration" class="menu-item active">
            <i class="fa-regular fa-square-plus"></i> Đăng ký môn học
        </a>
        <a href="Index.php?action=student_schedule" class="menu-item">
            <i class="fa-regular fa-calendar-days"></i> Lịch học của tôi
        </a>
        <a href="Index.php?action=student_study_program" class="menu-item">
            <i class="fa-solid fa-graduation-cap"></i> Chương trình học
        </a>

        <div class="menu-section">Tài chính</div>
        <a href="Index.php?action=student_tuition" class="menu-item">
            <i class="fa-solid fa-wallet"></i> Học phí & Lệ phí
        </a>

        <div class="menu-section">Tài khoản</div>
        <a href="Index.php?action=student_settings" class="menu-item">
            <i class="fa-solid fa-gear"></i> Cài đặt tài khoản
        </a>

        <a href="Index.php?action=logout" class="sign-out">
            <i class="fa-solid fa-arrow-right-from-bracket"></i> Đăng xuất
        </a>
    </div>

    <!-- MAIN CONTENT - THÔNG BÁO CHƯA MỞ ĐĂNG KÝ -->
    <div class="main-content">
        <div class="closed-box">
            <i class="fa-solid fa-clock icon-big"></i>
            <h1>Chưa mở đăng ký môn học</h1>
            <p>
                Hiện tại nhà trường <strong>chưa mở</strong> kỳ đăng ký môn học cho học kỳ này.<br><br>
                <strong>Kỳ học:</strong> <?= htmlspecialchars($semesterName ?? 'Học kỳ hiện tại') ?><br>
                <strong>Trạng thái:</strong> <span class="status"><?= htmlspecialchars($status ?? 'Chưa mở') ?></span>
            </p>
            <p style="margin-top: 25px;">
                Vui lòng quay lại sau khi nhà trường công bố mở đăng ký.
            </p>
            <a href="Index.php?action=student_dashboard" class="btn-back">
                ← Về Trang chủ
            </a>
        </div>
    </div>

</body>
</html>