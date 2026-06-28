<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký môn học - Sinh viên</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', sans-serif; }
        body { display: flex; background-color: #f8f9fa; color: #1a1a2e; min-height: 100vh; }

        /* SIDEBAR */
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
         .info-mini h4 { font-size: 0.9rem; }
        .info-mini p { font-size: 0.75rem; color: #a0aec0; }
        
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
        .main-content { margin-left: 260px; flex: 1; padding: 25px 30px; }
        .header { margin-bottom: 25px; }
        .header h1 { font-size: 1.6rem; font-weight: 600; color: #1a1a2e; }

        /* STATS PANEL */
        .stats-panel { 
            background: white; border-radius: 16px; padding: 25px; 
            display: flex; justify-content: space-between; align-items: center; 
            margin-bottom: 25px; box-shadow: 0 2px 10px rgba(0,0,0,0.03); 
        }
        .stats-left { display: flex; gap: 50px; }
        .stat-item h2 { font-size: 1.8rem; color: #1a1a2e; margin-bottom: 4px; }
        .stat-item p { font-size: 0.85rem; color: #64748b; }

        .progress-container { width: 320px; }
        .progress-header { 
            display: flex; justify-content: space-between; font-size: 0.85rem; color: #64748b; margin-bottom: 8px; 
        }
        .progress-bar { 
            width: 100%; height: 8px; background: #f1f5f9; border-radius: 4px; overflow: hidden; 
        }
        .progress-fill { 
            height: 100%; background: #6d28d9; border-radius: 4px; transition: width 0.6s ease; 
        }

        /* TOOLBAR */
        .toolbar { 
            display: flex; justify-content: space-between; align-items: center; 
            background: white; padding: 15px 20px; border-radius: 12px; 
            margin-bottom: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.02); 
        }
        .search-box { position: relative; width: 380px; }
        .search-box i { position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #a0aec0; }
        .search-box input { 
            width: 100%; padding: 10px 15px 10px 45px; border: 1px solid #e2e8f0; 
            border-radius: 8px; outline: none; background: #f8f9fa; 
        }

        .tab-group { display: flex; gap: 8px; }
        .tab-btn { 
            padding: 8px 18px; border-radius: 20px; border: 1px solid #e2e8f0; 
            background: white; color: #64748b; cursor: pointer; font-size: 0.87rem; 
        }
        .tab-btn.active { 
            background: #6d28d9; color: white; border-color: #6d28d9; 
        }

        /* COURSE GRID */
        .course-grid { 
            display: grid; grid-template-columns: repeat(auto-fill, minmax(380px, 1fr)); gap: 20px; 
        }
        .course-card { 
            background: white; border-radius: 16px; padding: 20px; 
            box-shadow: 0 2px 12px rgba(0,0,0,0.03); border: 1px solid #f1f5f9; 
            display: flex; flex-direction: column; 
        }
        .card-top { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 15px; }
        .card-icon-title { display: flex; gap: 12px; }
        .icon-box { 
            width: 42px; height: 42px; background: #f3f4ff; color: #6d28d9; 
            border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; 
        }
        .title-box h3 { font-size: 1.1rem; margin-bottom: 4px; line-height: 1.3; }
        .title-box p { font-size: 0.85rem; color: #64748b; }

        .status-badge { 
            padding: 5px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; 
            display: flex; align-items: center; gap: 5px; 
        }
        .status-available { background: #e6ffed; color: #05cd99; border: 1px solid #b7f4db; }
        .status-full { background: #ffe5e5; color: #ee5d50; border: 1px solid #ffcaca; }

        .card-details { 
            font-size: 0.9rem; color: #4a5568; display: flex; flex-direction: column; gap: 7px; margin: 15px 0; 
        }
        .card-details i { width: 18px; color: #6b7280; }

        .enroll-stats { margin: 15px 0; }
        .enroll-text { 
            display: flex; justify-content: space-between; font-size: 0.85rem; margin-bottom: 6px; font-weight: 500; 
        }
        .enroll-bar-bg { 
            width: 100%; height: 6px; background: #f1f5f9; border-radius: 3px; overflow: hidden; 
        }
        .enroll-bar-fill { height: 100%; border-radius: 3px; }

        .card-footer { 
            margin-top: auto; padding-top: 15px; border-top: 1px solid #f1f5f9; 
            display: flex; justify-content: space-between; align-items: center; 
        }
        .credit-tag { 
            background: #f3f4ff; color: #6d28d9; padding: 5px 12px; border-radius: 12px; 
            font-weight: 600; font-size: 0.9rem; 
        }
        .btn-action { 
            padding: 9px 18px; border-radius: 20px; font-size: 0.9rem; font-weight: 600; 
            cursor: pointer; display: flex; align-items: center; gap: 6px; transition: 0.3s; text-decoration: none; 
        }
        .btn-register { background: #6d28d9; color: white; border: none; }
        .btn-register:hover { opacity: 0.9; }
        .btn-drop { background: white; color: #ee5d50; border: 1px solid #ee5d50; }
        .btn-drop:hover { background: #fff5f5; }
        .btn-disabled { background: #f1f5f9; color: #94a3b8; border: none; cursor: not-allowed; }
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
            <div class="avatar-mini"><?php echo substr(htmlspecialchars($studentProfile['ho_ten']), 0, 1); ?></div>
            <div class="info-mini">
                <h4><?php echo htmlspecialchars($studentProfile['ho_ten']); ?></h4>
                <p><?php echo htmlspecialchars($studentProfile['ma_sinh_vien']); ?></p>
            </div>
        </div>

        <div class="menu-section">Tổng quan</div>
        <a href="Index.php?action=student_dashboard" class="menu-item">
            <i class="fa-solid fa-border-all"></i> Bảng điều khiển
        </a>

        <div class="menu-section">Học tập</div>
        <a href="Index.php?action=student_course_registration" class="menu-item ">
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

    <!-- MAIN CONTENT -->
    <div class="main-content">
        <?php 
            // Tính toán số môn và tín chỉ đã đăng ký (không trùng)
            $registeredCount = 0;
            $totalCredits = 0;
            $seen = [];

            foreach ($classes as $class) {
                if ($class['trang_thai_dang_ky'] === 'Thành công' && !in_array($class['id_lop'], $seen)) {
                    $seen[] = $class['id_lop'];
                    $registeredCount++;
                    $totalCredits += (int)$class['so_tin_chi'];
                }
            }

            $progressPercent = $minCredits > 0 ? min(round(($totalCredits / $minCredits) * 100), 100) : 0;
        ?>

        <div class="header">
            <h1>Đăng ký môn học</h1>
        </div>
        <?php if (isset($_SESSION['flash_error'])): ?>
    <div style="background: #ffe5e5; color: #ee5d50; padding: 12px 20px; border-radius: 12px; margin-bottom: 20px; border: 1px solid #ffcaca;">
        <i class="fa-solid fa-triangle-exclamation"></i> <?= $_SESSION['flash_error']; unset($_SESSION['flash_error']); ?>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['flash_success'])): ?>
    <div style="background: #e6ffed; color: #05cd99; padding: 12px 20px; border-radius: 12px; margin-bottom: 20px; border: 1px solid #b7f4db;">
        <i class="fa-solid fa-circle-check"></i> <?= $_SESSION['flash_success']; unset($_SESSION['flash_success']); ?>
    </div>
<?php endif; ?>
        <!-- Stats Panel -->
        <div class="stats-panel">
            <div class="stats-left">
                <div class="stat-item">
                    <h2><?= $registeredCount ?></h2>
                    <p>Môn đã đăng ký</p>
                </div>
                <div class="stat-item">
                    <h2>
                        <?= $totalCredits ?> 
                        <span style="font-size: 1rem; color: #64748b;">/ <?= $maxCredits ?> TC</span>
                    </h2>
                    <p>Tín chỉ hiện tại</p>
                </div>
            </div>

            <div class="progress-container">
                <div class="progress-header">
                    <span>Tiến độ (Tối thiểu: <b><?= $minCredits ?> TC</b>)</span>
                    <span style="font-weight: bold; color: <?= $totalCredits >= $minCredits ? '#05cd99' : '#6d28d9' ?>;">
                        <?= $progressPercent ?>%
                    </span>
                </div>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: <?= $progressPercent ?>%; background: <?= $totalCredits >= $minCredits ? '#05cd99' : '#6d28d9' ?>;"></div>
                </div>
                <p style="font-size: 0.8rem; margin-top: 8px; color: #64748b;">
                    <?php if ($totalCredits < $minCredits): ?>
                        <i class="fa-solid fa-circle-exclamation" style="color:#ffb300"></i> 
                        Còn thiếu <?= $minCredits - $totalCredits ?> tín chỉ để đạt mức tối thiểu.
                    <?php else: ?>
                        <i class="fa-solid fa-circle-check" style="color:#05cd99"></i> 
                        Đã đạt định mức tín chỉ tối thiểu.
                    <?php endif; ?>
                </p>
            </div>
        </div>

        <!-- Toolbar -->
        <div class="toolbar">
            <div class="search-box">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" id="searchInput" placeholder="Tìm kiếm tên hoặc mã môn học..." onkeyup="filterCourses()">
            </div>
            <div class="tab-group">
                <button class="tab-btn active" onclick="filterByTab(this, 'all')">Tất cả</button>
                <button class="tab-btn" onclick="filterByTab(this, 'registered')">Đã đăng ký</button>
                <button class="tab-btn" onclick="filterByTab(this, 'available')">Còn chỗ</button>
            </div>
        </div>

        <div class="list-header">
            <span>Tìm thấy <strong id="resultCount"><?= count($classes) ?></strong> môn học mở lớp</span>
        </div>

        <!-- Course Grid -->
        <div class="course-grid" id="courseGrid">
            <?php foreach ($classes as $class): 
    $percent = $class['si_so_toi_da'] > 0 
        ? round(($class['si_so_da_dang_ky'] / $class['si_so_toi_da']) * 100) 
        : 0;
    $isRegistered = ($class['trang_thai_dang_ky'] === 'Thành công' || $class['trang_thai_dang_ky'] === 1 || $class['trang_thai_dang_ky'] == '1');
    $isFull = ($percent >= 100);

    $barColor = $isFull ? '#ee5d50' : ($percent >= 80 ? '#ffb300' : '#05cd99');
    $statusHTML = $isFull 
        ? '<span class="status-badge status-full"><i class="fa-regular fa-circle-xmark"></i> Đã đầy</span>' 
        : '<span class="status-badge status-available"><i class="fa-regular fa-circle-check"></i> Còn chỗ</span>';
?>
    <div class="course-card" data-registered="<?= $isRegistered ? '1' : '0' ?>" data-full="<?= $isFull ? '1' : '0' ?>">
        <div class="card-top">
            <div class="card-icon-title">
                <div class="icon-box"><i class="fa-solid fa-book-open"></i></div>
                <div class="title-box">
                    <h3><?= htmlspecialchars($class['ten_mon_hoc']) ?></h3>
                    <p><?= htmlspecialchars($class['ma_mon_hoc']) ?></p>
                </div>
            </div>
            <?= $statusHTML ?>
        </div>

        <div class="card-details">
            <div><i class="fa-regular fa-user"></i> <?= htmlspecialchars($class['ten_giang_vien']) ?></div>
            <div><i class="fa-solid fa-location-dot"></i> Phòng <?= htmlspecialchars($class['phong_hoc']) ?></div>
            
            <?php if (!empty($class['cac_thu'])): ?>
                <div class="schedule-info" style="margin-top: 8px; padding-top: 8px; border-top: 1px dashed #eee;">
                    <div style="color: #666; font-size: 0.9em;">
                        <i class="fa-regular fa-calendar-days"></i> 
                        <strong>Lịch:</strong> <?= htmlspecialchars($class['cac_thu']) ?>
                    </div>
                    <div style="color: #666; font-size: 0.9em;">
                        <i class="fa-regular fa-clock"></i> 
                        <strong>Giờ:</strong> <?= date('H:i', strtotime($class['gio_bat_dau'])) ?> - <?= date('H:i', strtotime($class['gio_ket_thuc'])) ?>
                    </div>
                    <div style="color: #666; font-size: 0.85em; font-style: italic; margin-top: 4px;">
                        <i class="fa-solid fa-arrow-right-long"></i> 
                        <?= date('d/m', strtotime($class['ngay_mo_dau'])) ?> đến <?= date('d/m/y', strtotime($class['ngay_be_mac'])) ?>
                    </div>
                </div>
            <?php else: ?>
                <div style="color: #999; font-size: 0.85em; font-style: italic; margin-top: 5px;">
                    <i class="fa-solid fa-circle-info"></i> Chưa có lịch học cụ thể
                </div>
            <?php endif; ?>
        </div>

        <div class="enroll-stats">
            <div class="enroll-text">
                <span style="color: <?= $barColor ?>"><?= $class['si_so_da_dang_ky'] ?>/<?= $class['si_so_toi_da'] ?> đã đăng ký</span>
                <span style="color: <?= $barColor ?>"><?= $percent ?>%</span>
            </div>
            <div class="enroll-bar-bg">
                <div class="enroll-bar-fill" style="width: <?= min($percent, 100) ?>%; background: <?= $barColor ?>;"></div>
            </div>
        </div>

        <div class="card-footer">
            <div class="credits-dept">
                <span class="credit-tag"><?= $class['so_tin_chi'] ?> tín chỉ</span>
            </div>

            <?php if ($isRegistered): ?>
                <a href="Index.php?action=cancel_course&id_lop=<?= $class['id_lop'] ?>" 
                   class="btn-action btn-drop" 
                   onclick="return confirm('Xác nhận hủy đăng ký môn này?')">
                    <i class="fa-regular fa-circle-xmark"></i> Hủy môn
                </a>
            <?php elseif ($totalCredits >= $maxCredits): ?>
                <button class="btn-action btn-disabled" title="Đã đạt giới hạn tín chỉ tối đa">
                    <i class="fa-solid fa-ban"></i> Đã đủ TC
                </button>
            <?php elseif ($isFull): ?>
                <button class="btn-action btn-disabled">
                    <i class="fa-solid fa-lock"></i> Đã đầy
                </button>
            <?php else: ?>
                <a href="Index.php?action=register_course&id_lop=<?= $class['id_lop'] ?>" 
                   class="btn-action btn-register">
                    <i class="fa-regular fa-circle-check"></i> Đăng ký
                </a>
            <?php endif; ?>
        </div>
    </div>
<?php endforeach; ?>
        </div>
    </div>

    <script>
        function filterCourses() {
            const search = document.getElementById('searchInput').value.toLowerCase();
            const cards = document.querySelectorAll('.course-card');
            let count = 0;

            cards.forEach(card => {
                const title = card.querySelector('h3').textContent.toLowerCase();
                const code = card.querySelector('p').textContent.toLowerCase();
                if (title.includes(search) || code.includes(search)) {
                    card.style.display = 'flex';
                    count++;
                } else {
                    card.style.display = 'none';
                }
            });
            document.getElementById('resultCount').textContent = count;
        }

        function filterByTab(btn, type) {
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            const cards = document.querySelectorAll('.course-card');
            let count = 0;

            cards.forEach(card => {
                const isRegistered = card.dataset.registered === '1';
                const isFull = card.dataset.full === '1';

                if (type === 'all') {
                    card.style.display = 'flex';
                    count++;
                } else if (type === 'registered' && isRegistered) {
                    card.style.display = 'flex';
                    count++;
                } else if (type === 'available' && !isRegistered && !isFull) {
                    card.style.display = 'flex';
                    count++;
                } else {
                    card.style.display = 'none';
                }
            });
            document.getElementById('resultCount').textContent = count;
        }
    </script>
</body>
</html>