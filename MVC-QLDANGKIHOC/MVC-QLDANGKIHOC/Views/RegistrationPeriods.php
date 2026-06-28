<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kỳ đăng ký - Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* === SIDEBAR ĐÃ ĐỒNG BỘ GIỐNG HỆT TRANG BÁO CÁO === */
        * { 
            box-sizing: border-box; 
            margin: 0; 
            padding: 0; 
            font-family: 'Segoe UI', sans-serif; 
        }
        body { 
            display: flex; 
            background-color: #f4f7fe; 
            color: #2b3674; 
            min-height: 100vh; 
            overflow-x: hidden; 
        }
        
        /* Sidebar style từ trang Báo cáo & Thống kê */
        .sidebar { 
            width: 260px; 
            background-color: #111c44; 
            color: #fff; 
            display: flex; 
            flex-direction: column; 
            padding: 20px; 
            position: fixed; 
            height: 100vh; 
            z-index: 100; 
        }
        .logo { 
            font-size: 1.2rem; 
            font-weight: bold; 
            display: flex; 
            align-items: center; 
            gap: 10px; 
            margin-bottom: 30px; 
        }
        .logo i { 
            background: rgba(255,255,255,0.1); 
            padding: 8px; 
            border-radius: 8px; 
        }
        .logo span { 
            font-size: 0.75rem; 
            color: #a0aec0; 
            display: block; 
            font-weight: normal; 
        }
        .menu-section { 
            font-size: 0.75rem; 
            color: #a0aec0; 
            font-weight: bold; 
            margin: 20px 0 10px; 
            text-transform: uppercase; 
            letter-spacing: 1px; 
        }
        .menu-item { 
            padding: 12px 15px; 
            border-radius: 8px; 
            color: #a0aec0; 
            text-decoration: none; 
            display: flex; 
            align-items: center; 
            gap: 15px; 
            margin-bottom: 5px; 
            transition: 0.3s; 
            cursor: pointer; 
        }
        .menu-item:hover, 
        .menu-item.active { 
            background-color: #313860; 
            color: #fff; 
        }
        .menu-item.active { 
            background: linear-gradient(135deg, #868cff 0%, #4318ff 100%); 
        }
        .user-profile { 
            margin-top: auto; 
            display: flex; 
            align-items: center; 
            gap: 10px; 
            padding: 15px; 
            background: rgba(255,255,255,0.05); 
            border-radius: 12px; 
        }
        .user-avatar { 
            width: 40px; 
            height: 40px; 
            background: #868cff; 
            border-radius: 50%; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            font-weight: bold; 
        }
        .user-info h4 { 
            font-size: 0.9rem; 
        }
        .user-info p { 
            font-size: 0.75rem; 
            color: #a0aec0; 
        }
        .logout-btn { margin-left: auto; color: #a0aec0; text-decoration: none; }

        /* === PHẦN NỘI DUNG CHÍNH (giữ nguyên từ file Kỳ đăng ký của bạn) === */
        .main-content { 
            margin-left: 260px; 
            flex: 1; 
            padding: 30px 40px; 
            min-width: 0; 
        }
        
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
        .header h1 { font-size: 1.8rem; }
        .header-icons { display: flex; gap: 15px; font-size: 1.2rem; color: #a0aec0; }

        /* Stats Cards */
        .stats-row { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); 
            gap: 20px; 
            margin-bottom: 35px; 
        }
        .stat-card { 
            background: white; 
            padding: 25px; 
            border-radius: 20px; 
            box-shadow: 0 10px 30px rgba(112, 144, 176, 0.08); 
        }
        .stat-icon { 
            width: 48px; 
            height: 48px; 
            border-radius: 12px; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            font-size: 1.3rem; 
            margin-bottom: 20px; 
        }
        .stat-card h2 { 
            font-size: 2rem; 
            font-weight: 700; 
            color: #1b2559; 
            margin-bottom: 5px; 
        }
        .stat-card p { 
            font-size: 0.9rem; 
            color: #a3aed0; 
            font-weight: 500; 
        }

        /* List Area */
        .list-container { 
            background: white; 
            border-radius: 20px; 
            padding: 25px; 
            box-shadow: 0 10px 30px rgba(112, 144, 176, 0.05); 
        }
        .list-header { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            margin-bottom: 25px; 
        }
        .btn-new-period { 
            background: #4318ff; 
            color: white; 
            border: none; 
            padding: 12px 24px; 
            border-radius: 12px; 
            font-weight: 700; 
            cursor: pointer; 
            transition: 0.3s; 
            box-shadow: 0 4px 14px rgba(67, 24, 255, 0.3); 
        }
        .btn-new-period:hover { 
            transform: translateY(-2px); 
            box-shadow: 0 6px 18px rgba(67, 24, 255, 0.4); 
        }

        /* Period Item */
        .period-item { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            padding: 20px; 
            border: 1px solid #f1f5f9; 
            border-radius: 15px; 
            margin-bottom: 15px; 
            transition: 0.2s;
        }
        .period-item:hover { 
            border-color: #e2e8f0; 
            background: #fcfdfe; 
        }
        
        .period-left { 
            display: flex; 
            align-items: center; 
            gap: 20px; 
        }
        .period-icon-box { 
            width: 50px; 
            height: 50px; 
            border-radius: 12px; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            font-size: 1.4rem; 
        }
        
        .period-info h4 { 
            font-size: 1.1rem; 
            font-weight: 700; 
            margin-bottom: 6px; 
            display: flex; 
            align-items: center; 
            gap: 10px; 
        }
        .period-info .meta { 
            display: flex; 
            gap: 20px; 
            font-size: 0.85rem; 
            color: #707eae; 
            margin-bottom: 8px; 
        }
        .period-info .meta b { 
            color: #4318ff; 
        }
        .period-info .times { 
            display: flex; 
            gap: 15px; 
            font-size: 0.8rem; 
            background: #f4f7fe; 
            padding: 6px 12px; 
            border-radius: 8px; 
            width: fit-content; 
        }

        /* Badges & Actions */
        .badge { 
            padding: 4px 12px; 
            border-radius: 30px; 
            font-size: 0.75rem; 
            font-weight: 700; 
        }
        .badge-open { background: #e6ffed; color: #05cd99; }
        .badge-upcoming { background: #fff9e6; color: #ffb800; }
        
        .period-actions { 
            display: flex; 
            align-items: center; 
            gap: 15px; 
        }
        .action-link { 
            font-size: 0.85rem; 
            font-weight: 700; 
            color: #4318ff; 
            cursor: pointer; 
            text-decoration: none; 
        }
        .btn-icon { 
            width: 35px; 
            height: 35px; 
            border-radius: 10px; 
            border: none; 
            background: #f4f7fe; 
            color: #a3aed0; 
            cursor: pointer; 
            transition: 0.2s; 
        }
        .btn-icon:hover { 
            background: #e2e8f0; 
            color: #1b2559; 
        }
        .btn-icon.delete:hover { 
            background: #fee2e2; 
            color: #ee5d50; 
        }

        /* List controls */
        .list-controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: white;
            padding: 15px 20px;
            border-radius: 16px;
            margin-bottom: 20px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.03);
        }
        .search-box {
            position: relative;
            width: 400px;
        }
        .search-box i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #a0aec0;
        }
        .search-box input {
            width: 100%;
            padding: 12px 15px 12px 45px;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            background-color: #f8fafc;
            font-size: 0.9rem;
            outline: none;
            transition: 0.3s;
        }
        .search-box input:focus {
            border-color: #4318ff;
            background-color: #fff;
            box-shadow: 0 0 0 4px rgba(67, 24, 255, 0.1);
        }
        .filter-group {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .filter-group label {
            font-size: 0.85rem;
            font-weight: 600;
            color: #707eae;
        }
        .filter-group select {
            padding: 10px 15px;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
            color: #2b3674;
            font-weight: 600;
            outline: none;
            cursor: pointer;
        }

        /* Trạng thái bổ sung (từ file Kỳ đăng ký) */
        .status-open { 
            color: #05cd99; 
            background: #e6ffed; 
            padding: 4px 12px; 
            border-radius: 20px; 
            font-size: 0.8rem; 
            font-weight: 700; 
        }
        .status-closed { 
            color: #ee5d50; 
            background: #fee2e2; 
            padding: 4px 12px; 
            border-radius: 20px; 
            font-size: 0.8rem; 
            font-weight: 700; 
        }
        .status-upcoming { 
            color: #ffb800; 
            background: #fff9e6; 
            padding: 4px 12px; 
            border-radius: 20px; 
            font-size: 0.8rem; 
            font-weight: 700; 
        }
        
        .period-icon { 
            width: 50px; 
            height: 50px; 
            border-radius: 12px; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            font-size: 1.4rem; 
        }
        .icon-open { background: #e6ffed; color: #05cd99; }
        .icon-closed { background: #fee2e2; color: #ee5d50; }
        .icon-upcoming { background: #fff9e6; color: #ffb800; }

        .period-item { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            padding: 20px; 
            background: #fff; 
            border: 1px solid #f1f5f9; 
            border-radius: 15px; 
            margin-bottom: 15px; 
        }
        .action-btn-text { 
            font-size: 0.85rem; 
            font-weight: 700; 
            padding: 8px 15px; 
            border-radius: 10px; 
            cursor: pointer; 
        }
        .text-open { color: #ee5d50; background: #fee2e2; }
        .text-closed { color: #4318ff; background: #f4f7fe; }
        .text-upcoming { color: #4318ff; background: #f4f7fe; }
        .logout-btn {
    color: #868cff !important;   /* Màu tím nhạt hơn một chút */
}
.logout-btn:hover {
    color: #4318ff !important;
}
    </style>
</head>
<body>

    <!-- SIDEBAR ĐÃ ĐỒNG BỘ (giống 100% trang Báo cáo & Thống kê) -->
    <div class="sidebar">
        <div class="logo">
            <i class="fa-solid fa-graduation-cap"></i>
            <div>EduManage<span>Cổng Quản trị viên</span></div>
        </div>
        
        <div class="menu-section">TỔNG QUAN</div>
        <a href="Index.php?action=admin_dashboard" class="menu-item">
            <i class="fa-solid fa-border-all"></i> Bảng điều khiển
        </a>
        
        <div class="menu-section">QUẢN LÝ</div>
        <a href="Index.php?action=admin_accounts" class="menu-item"><i class="fa-solid fa-users"></i> Quản lý tài khoản</a>
        <a href="Index.php?action=courses" class="menu-item">
            <i class="fa-solid fa-book"></i> Môn học
        </a>
        <a href="Index.php?action=classes" class="menu-item">
            <i class="fa-solid fa-users-rectangle"></i> Lớp học
        </a>
        <a href="Index.php?action=schedules" class="menu-item">
            <i class="fa-regular fa-calendar-days"></i> Lịch học
        </a>

        <div class="menu-section">HÀNH CHÍNH</div>
        <a href="Index.php?action=registration_periods" class="menu-item active">
            <i class="fa-regular fa-folder-open"></i> Kỳ đăng ký
        </a>
        <a href="Index.php?action=reports" class="menu-item">
            <i class="fa-solid fa-chart-line"></i> Báo cáo & Thống kê
        </a>

       <div class="user-profile">
            <a href="Index.php?action=logout" class="sign-out">
            <i class="fa-solid fa-arrow-right-from-bracket"></i> Đăng xuất
        </a>
        </div>
    </div>
  <div class="main-content">
    <div class="header">
        <h1><i class="fa-regular fa-folder-open" style="color: #4318ff;"></i> Kỳ đăng ký </h1>
        <div style="display: flex; gap: 15px; font-size: 1.2rem; color: #a0aec0;">
            <i class="fa-regular fa-bell"></i>
            <i class="fa-solid fa-shield-halved" style="color: #4318ff;"></i>
        </div>
    </div>

    <?php 
        // Tìm kỳ đang mở (đã sửa đúng)
        $openPeriod = null;
        foreach($semesters as $sem) {
            if (trim($sem['trang_thai_dang_ky'] ?? '') === 'Đang mở') {
                $openPeriod = $sem;
                break;
            }
        }
    ?>

    <?php if ($openPeriod): ?>
    <div class="status-banner" style="background:#ecfdf5; padding:20px; border-radius:16px; margin-bottom:30px; display:flex; align-items:center; gap:20px;">
        <div class="banner-icon" style="font-size:2.4rem;">📅</div>
        <div class="banner-text" style="flex:1;">
            <h2 style="margin:0; color:#10b981;">Đăng ký đang mở</h2>
            <p style="margin:6px 0 0 0; color:#0f766e;">
                <?= htmlspecialchars($openPeriod['ten_ky_hoc']) ?> • 
                Kết thúc vào <?= date('d/m/Y H:i', strtotime($openPeriod['thoi_gian_ket_thuc'] ?? $openPeriod['ngay_ket_thuc'])) ?>
            </p>
        </div>
      
    </div>
    <?php endif; ?>

    <!-- Stats Row -->
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-icon" style="background: #dcfce7; color: #05cd99;"><i class="fa-solid fa-toggle-on"></i></div>
            <h2><?= $stats['open_periods'] ?? 0 ?></h2>
            <p>Kỳ đăng ký đang mở</p>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: #fee2e2; color: #ee5d50;"><i class="fa-solid fa-lock"></i></div>
            <h2><?= $stats['closed_periods'] ?? 0 ?></h2>
            <p>Kỳ đăng ký đã đóng</p>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: #fff9e6; color: #ffb800;"><i class="fa-solid fa-calendar-plus"></i></div>
            <h2><?= $stats['upcoming_periods'] ?? 0 ?></h2>
            <p>Kỳ đăng ký sắp tới</p>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: #eef2ff; color: #4318ff;"><i class="fa-solid fa-folder-tree"></i></div>
            <h2><?= count($semesters) ?></h2>
            <p>Tổng số kỳ đã tạo</p>
        </div>
    </div>

    <div class="list-header">
        <div>
            <h3>Danh sách Kỳ đăng ký</h3>
            <p>Đã cấu hình <?= count($semesters) ?> kỳ học</p>
        </div>
        <button class="btn-new-period" onclick="location.href='Index.php?action=create_registration_period'">
            <i class="fa-solid fa-plus"></i> Tạo kỳ mới
        </button>
    </div>

    <!-- Search + Filter -->
    <div class="list-controls">
        <div class="search-box">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" id="searchInput" placeholder="Tìm kiếm tên kỳ học..." onkeyup="filterTable()">
        </div>
        <div class="filter-group">
            <label style="margin-right:8px; font-weight:600;">Trạng thái:</label>
            <select id="statusFilter" onchange="filterTable()">
                <option value="">Tất cả</option>
                <option value="Đang mở">Đang mở</option>
                <option value="Sắp tới">Sắp tới</option>
                <option value="Đã đóng">Đã đóng</option>
            </select>
        </div>
    </div>

    <!-- Danh sách kỳ -->
    <div class="period-list">
        <?php foreach ($semesters as $sem): 
            $status = trim($sem['trang_thai_dang_ky'] ?? 'Sắp tới'); 

            if ($status === 'Đang mở') {
                $statusBadge = '<span class="status-open">Đang mở</span>';
                $iconClass   = 'icon-open';
                $actionBtn   = '<span class="action-btn-text text-open" onclick="closeRegistration('.$sem['id_ky_hoc'].')">Đóng đăng ký</span>';
            } 
            elseif ($status === 'Sắp tới') {
                $statusBadge = '<span class="status-upcoming">Sắp tới</span>';
                $iconClass   = 'icon-upcoming';
                $actionBtn   = '<span class="action-btn-text text-upcoming">Mở sớm</span>';
            } 
            else {
                $statusBadge = '<span class="status-closed">Đã đóng</span>';
                $iconClass   = 'icon-closed';
                $actionBtn   = '<span class="action-btn-text text-closed">Mở lại</span>';
            }
        ?>
        <div class="period-item">
            <div class="period-left">
                <div class="period-icon <?= $iconClass ?>">
                    <i class="fa-regular fa-calendar-days"></i>
                </div>
                <div class="period-info">
                    <h4><?= htmlspecialchars($sem['ten_ky_hoc']) ?> <?= $statusBadge ?></h4>
                    <p class="desc">Tín chỉ: <?= $sem['tin_chi_toi_thieu'] ?> - <?= $sem['tin_chi_toi_da'] ?></p>
                </div>
            </div>
            <div class="period-actions">
                <?= $actionBtn ?>
                <a href="Index.php?action=edit_period&id=<?= $sem['id_ky_hoc'] ?>" title="Sửa"><i class="fa-solid fa-pen"></i></a>
                <a href="Index.php?action=delete_period&id=<?= $sem['id_ky_hoc'] ?>" 
                   style="color:red;" onclick="return confirm('Bạn có chắc muốn xóa kỳ đăng ký này không?')">
                    <i class="fa-solid fa-trash-can"></i>
                </a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
function filterTable() {
    const searchValue = document.getElementById("searchInput").value.toLowerCase().trim();
    const filterValue = document.getElementById("statusFilter").value;
    const periods = document.querySelectorAll(".period-item");

    periods.forEach(item => {
        const title = item.querySelector("h4").innerText.toLowerCase();
        const statusSpan = item.querySelector("span[class*='status-']");
        const statusText = statusSpan ? statusSpan.innerText : "";

        const matchesSearch = title.includes(searchValue);
        const matchesFilter = !filterValue || statusText.includes(filterValue);

        item.style.display = (matchesSearch && matchesFilter) ? "flex" : "none";
    });
}

</script>
</body>
</html>