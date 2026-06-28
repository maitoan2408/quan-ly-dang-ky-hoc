<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bảng điều khiển - Sinh viên</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', sans-serif; }
        body { display: flex; background-color: #f8f9fa; color: #1a1a2e; min-height: 100vh; }
        
        /* --- SIDEBAR --- */
        .sidebar { width: 260px; background-color: #111c44; color: #fff; display: flex; flex-direction: column; padding: 20px; position: fixed; height: 100vh; }
        .logo { font-size: 1.1rem; font-weight: bold; display: flex; align-items: center; gap: 10px; margin-bottom: 30px; }
        .logo i { background: rgba(255,255,255,0.1); padding: 8px; border-radius: 8px; }
        
        .student-profile-mini { display: flex; align-items: center; gap: 12px; background: rgba(255,255,255,0.05); padding: 12px; border-radius: 12px; margin-bottom: 25px; }
        .avatar-mini { width: 40px; height: 40px; background: #6d28d9; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; }
        .info-mini h4 { font-size: 0.9rem; }
        .info-mini p { font-size: 0.75rem; color: #a0aec0; }

        .menu-section { font-size: 0.75rem; color: #a0aec0; font-weight: bold; margin: 15px 0 10px; text-transform: uppercase; letter-spacing: 1px; }
        .menu-item { padding: 10px 15px; border-radius: 8px; color: #a0aec0; text-decoration: none; display: flex; align-items: center; gap: 15px; margin-bottom: 5px; transition: 0.3s; font-size: 0.9rem; }
        .menu-item:hover, .menu-item.active { background-color: rgba(255,255,255,0.05); color: #fff; }
        .menu-item.active { background: #1a1b41; border-left: 4px solid #6d28d9; border-radius: 0 8px 8px 0; }
        
        .sign-out { margin-top: auto; padding: 15px; color: #a0aec0; text-decoration: none; display: flex; align-items: center; gap: 15px; font-size: 0.9rem; }
        
        /* --- MAIN CONTENT --- */
        .main-content { margin-left: 260px; flex: 1; padding: 20px 30px; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
        .header h1 { font-size: 1.5rem; font-weight: 600; color: #1a1a2e; }
        
        /* --- ALERT BANNER --- */
        .alert-banner { background: #fff8e1; border-left: 4px solid #ffb300; padding: 15px 20px; border-radius: 8px; display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; box-shadow: 0 2px 5px rgba(0,0,0,0.02); }
        .alert-content { display: flex; gap: 15px; align-items: flex-start; }
        .alert-icon { color: #ffb300; font-size: 1.2rem; margin-top: 2px; }
        .alert-text h4 { color: #d84315; font-size: 0.95rem; margin-bottom: 3px; }
        .alert-text p { color: #d84315; font-size: 0.85rem; }
        .btn-link { color: #d84315; text-decoration: none; font-size: 0.85rem; font-weight: 600; display: flex; align-items: center; gap: 5px; }

        /* --- DASHBOARD LAYOUT --- */
        .dashboard-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 25px; }
        
        /* Cột trái (Môn học) */
        .section-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; }
        .section-header h3 { font-size: 1.1rem; color: #1a1a2e; }
        .view-all { color: #6d28d9; text-decoration: none; font-size: 0.85rem; font-weight: 600; }

        .course-list { display: flex; flex-direction: column; gap: 15px; margin-bottom: 25px; }
        .course-item { background: white; border: 1px solid #f1f5f9; padding: 15px 20px; border-radius: 12px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 8px rgba(0,0,0,0.02); }
        .course-info { display: flex; align-items: center; gap: 15px; }
        .course-icon { width: 40px; height: 40px; background: #f3f4ff; color: #6d28d9; border-radius: 8px; display: flex; align-items: center; justify-content: center; }
        .course-text h4 { font-size: 1rem; color: #1a1a2e; margin-bottom: 3px; }
        .course-text p { font-size: 0.8rem; color: #64748b; }
        
        .course-schedule { text-align: right; }
        .course-schedule h4 { font-size: 0.9rem; color: #1a1a2e; margin-bottom: 3px; font-weight: 500; }
        .course-schedule p { font-size: 0.8rem; color: #64748b; }
        .credit-badge { background: #f3f4ff; color: #6d28d9; padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; margin-left: 15px; }

        .quick-actions { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
        .action-card { background: white; border: 1px solid #f1f5f9; padding: 15px; border-radius: 12px; display: flex; align-items: center; gap: 15px; cursor: pointer; transition: 0.3s; font-weight: 500; font-size: 0.9rem; color: #1a1a2e; }
        .action-card:hover { border-color: #6d28d9; }
        .action-icon-sm { width: 35px; height: 35px; border-radius: 8px; display: flex; align-items: center; justify-content: center; }
        .bg-purple { background: #f3f4ff; color: #6d28d9; }
        .bg-green { background: #e6ffed; color: #05cd99; }
        .bg-orange { background: #fff8e1; color: #ffb300; }

        /* Cột phải (Hồ sơ) */
        .profile-card { background: white; border: 1px solid #f1f5f9; padding: 25px; border-radius: 16px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); margin-bottom: 25px; }
        .profile-header { display: flex; align-items: center; gap: 15px; margin-bottom: 20px; border-bottom: 1px solid #f1f5f9; padding-bottom: 20px; }
        .profile-avatar { width: 50px; height: 50px; background: #8b5cf6; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; font-weight: bold; }
        .profile-header h3 { font-size: 1.2rem; margin-bottom: 3px; }
        .profile-header p { font-size: 0.8rem; color: #64748b; }
        
        .profile-detail { display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 0.9rem; }
        .detail-lbl { color: #64748b; }
        .detail-val { font-weight: 500; color: #1a1a2e; }
        
        .progress-section { margin-top: 20px; }
        .progress-label { display: flex; justify-content: space-between; font-size: 0.8rem; margin-bottom: 8px; color: #64748b; }
        .progress-bar { width: 100%; height: 6px; background: #e2e8f0; border-radius: 3px; overflow: hidden; }
        .progress-fill { height: 100%; background: #8b5cf6; border-radius: 3px; }

        .today-card { background: white; border: 1px solid #f1f5f9; padding: 20px; border-radius: 16px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); }
        .today-card h3 { font-size: 1rem; margin-bottom: 15px; display: flex; justify-content: space-between; }
        .class-slot { background: #f3f4ff; padding: 15px; border-radius: 12px; border-left: 4px solid #8b5cf6; }
        .class-slot h4 { font-size: 0.95rem; color: #1a1a2e; margin-bottom: 5px; }
        .class-slot p { font-size: 0.8rem; color: #64748b; }
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
</div> 

<div class="main-content">
    <div class="header">
        <h1>Bảng điều khiển của tôi</h1>
            <div style="display: flex; gap: 15px; font-size: 1.2rem; color: #a0aec0; align-items: center;">
                <i class="fa-regular fa-bell"></i>
                <div style="width: 35px; height: 35px; background: #8b5cf6; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1rem;">
                    <?php echo substr(htmlspecialchars($studentProfile['ho_ten']), 0, 1); ?>
                </div>
            </div>
        </div>

        <?php if ($hasUnpaidFees): ?>
        <div class="alert-banner">
            <div class="alert-content">
                <i class="fa-solid fa-circle-exclamation alert-icon"></i>
                <div class="alert-text">
                    <h4>Học phí chưa thanh toán</h4>
                    <p>Bạn có khoản học phí chưa thanh toán. Vui lòng kiểm tra số dư của bạn.</p>
                </div>
            </div>
            <a href="#" class="btn-link">Xem học phí <i class="fa-solid fa-arrow-right"></i></a>
        </div>
        <?php endif; ?>

        <div class="dashboard-grid">
            <div>
                <div class="section-header">
                    <h3>Các môn đã đăng ký (Kỳ hiện tại)</h3>
                    <a href="#" class="view-all">Xem tất cả <i class="fa-solid fa-arrow-right"></i></a>
                </div>

                <div class="course-list">
                    <?php if (empty($enrolledCourses)): ?>
                        <div class="course-item">
                            <p>Bạn chưa đăng ký môn học nào trong học kỳ này.</p>
                        </div>
                    <?php else: ?>
                        <?php foreach ($enrolledCourses as $course): ?>
                        <div class="course-item">
                            <div class="course-info">
                                <div class="course-icon"><i class="fa-solid fa-book-open"></i></div>
                                <div class="course-text">
                                    <h4><?php echo htmlspecialchars($course['ten_mon_hoc']); ?></h4>
                                    <p><?php echo htmlspecialchars($course['ma_mon_hoc']); ?> • <?php echo htmlspecialchars($course['ten_giang_vien']); ?></p>
                                </div>
                            </div>
                            <div style="display: flex; align-items: center;">
                                <div class="course-schedule">
                                   
                                    
                                    <p>Phòng <?php echo htmlspecialchars($course['phong_hoc']); ?></p>
                                </div>
                                <div class="credit-badge"><?php echo $course['so_tin_chi']; ?> TC</div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <div class="quick-actions">
                    <a href="Index.php?action=student_schedule" class="action-card" style="text-decoration:none;color:inherit;cursor:pointer;">
                        <div class="action-icon-sm bg-purple"><i class="fa-regular fa-calendar"></i></div>
                        Xem thời khóa biểu
                    </a>
                    <a href="Index.php?action=student_study_program" class="action-card" style="text-decoration:none;color:inherit;cursor:pointer;">
                        <div class="action-icon-sm bg-green"><i class="fa-solid fa-graduation-cap"></i></div>
                        Chương trình đào tạo
                    </a>
                    <a href="Index.php?action=student_tuition" class="action-card" style="text-decoration:none;color:inherit;cursor:pointer;">
                        <div class="action-icon-sm bg-orange"><i class="fa-solid fa-wallet"></i></div>
                        Thanh toán học phí
                    </a>
                    <a href="Index.php?action=student_course_registration" class="action-card" style="text-decoration:none;color:inherit;cursor:pointer;">
                        <div class="action-icon-sm bg-purple"><i class="fa-solid fa-plus"></i></div>
                        Đăng ký thêm môn
                    </a>
                </div>
            </div>

            <div>
                <div class="profile-card">
                    <div class="profile-header">
                        <div class="profile-avatar"><?php echo substr(htmlspecialchars($studentProfile['ho_ten']), 0, 1); ?></div>
                        <div>
                            <h3><?php echo htmlspecialchars($studentProfile['ho_ten']); ?></h3>
                            <p><?php echo htmlspecialchars($studentProfile['ma_sinh_vien']); ?></p>
                        </div>
                    </div>
                    
                    <div class="profile-detail">
                        <span class="detail-lbl">Chuyên ngành</span>
                        <span class="detail-val">Công nghệ thông tin</span>
                    </div>
                    <div class="profile-detail">
                        <span class="detail-lbl">Năm học</span>
                        <span class="detail-val">Năm 3</span>
                    </div>
                    <div class="profile-detail">
                        <span class="detail-lbl">Tín chỉ kỳ này</span>
                        <span class="detail-val"><?php echo $totalCredits; ?> / 20</span>
                    </div>
                    <div class="profile-detail">
                        <span class="detail-lbl">GPA Tích lũy</span>
                        <span class="detail-val">3.2</span>
                    </div>

                    <div class="progress-section">
                        <div class="progress-label">
                            <span>Tiến độ tín chỉ (Kỳ này)</span>
                            <span><?php echo $totalCredits; ?>/20</span>
                        </div>
                        <div class="progress-bar">
                            <?php $percent = ($totalCredits / 20) * 100; ?>
                            <div class="progress-fill" style="width: <?php echo min($percent, 100); ?>%;"></div>
                        </div>
                    </div>
                </div>

                <div class="today-card">
                    <h3>Lớp học hôm nay <i class="fa-regular fa-clock" style="color: #a0aec0;"></i></h3>
                    <?php if (!empty($enrolledCourses)): ?>
                        <div class="class-slot">
                            <h4><?php echo htmlspecialchars($enrolledCourses[0]['ma_mon_hoc']); ?> - <?php echo htmlspecialchars($enrolledCourses[0]['ten_mon_hoc']); ?></h4>
                            <p>Phòng <?php echo htmlspecialchars($enrolledCourses[0]['phong_hoc']); ?></p>
                        </div>
                    <?php else: ?>
                        <p style="font-size: 0.85rem; color: #64748b;">Hôm nay bạn không có lịch học.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>