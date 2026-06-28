<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Báo cáo & Thống kê - Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', sans-serif; }
        body { display: flex; background-color: #f4f7fe; color: #2b3674; min-height: 100vh; overflow-x: hidden; }
        
        /* --- SIDEBAR --- */
        .sidebar { width: 260px; background-color: #111c44; color: #fff; display: flex; flex-direction: column; padding: 20px; position: fixed; height: 100vh; z-index: 100;}
        .logo { font-size: 1.2rem; font-weight: bold; display: flex; align-items: center; gap: 10px; margin-bottom: 30px; }
        .logo i { background: rgba(255,255,255,0.1); padding: 8px; border-radius: 8px; }
        .logo span { font-size: 0.75rem; color: #a0aec0; display: block; font-weight: normal; }
        .menu-section { font-size: 0.75rem; color: #a0aec0; font-weight: bold; margin: 20px 0 10px; text-transform: uppercase; letter-spacing: 1px; }
        .menu-item { padding: 12px 15px; border-radius: 8px; color: #a0aec0; text-decoration: none; display: flex; align-items: center; gap: 15px; margin-bottom: 5px; transition: 0.3s; cursor: pointer; }
        .menu-item:hover, .menu-item.active { background-color: #313860; color: #fff; }
        .menu-item.active { background: linear-gradient(135deg, #868cff 0%, #4318ff 100%); }
        .user-profile { margin-top: auto; display: flex; align-items: center; gap: 10px; padding: 15px; background: rgba(255,255,255,0.05); border-radius: 12px; }
        .user-avatar { width: 40px; height: 40px; background: #868cff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; }
        .user-info h4 { font-size: 0.9rem; }
        .user-info p { font-size: 0.75rem; color: #a0aec0; }
        .logout-btn { margin-left: auto; color: #a0aec0; text-decoration: none; }

        /* --- MAIN CONTENT --- */
        .main-content { margin-left: 260px; flex: 1; padding: 20px 30px; }
         .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
        .header h1 { font-size: 1.8rem; }
        .header-icons { display: flex; gap: 15px; font-size: 1.2rem; color: #a0aec0; }
        
        .sub-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
        .semester-tag { color: #a0aec0; font-size: 0.95rem; display: flex; align-items: center; gap: 8px; }
        .btn-export { border: 1px solid #e2e8f0; background: white; padding: 8px 16px; border-radius: 8px; cursor: pointer; font-weight: 600; color: #4a5568; display: flex; align-items: center; gap: 8px; }

        /* --- STATS CARDS --- */
        .stats-row { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 25px; }
        .stat-card { background: white; padding: 20px; border-radius: 16px; box-shadow: 0 2px 10px rgba(0,0,0,0.02); position: relative; }
        .stat-icon { width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; margin-bottom: 10px; }
        .stat-card h2 { font-size: 1.8rem; margin-bottom: 5px; color: #2b3674; }
        .stat-card p.title { font-size: 0.85rem; color: #a0aec0; margin-bottom: 5px; }
        .stat-card p.desc { font-size: 0.75rem; color: #a0aec0; }
        .trend-up { position: absolute; top: 20px; right: 20px; color: #05cd99; background: #e6ffed; padding: 4px 8px; border-radius: 20px; font-size: 0.7rem; font-weight: bold; }

        /* --- CHARTS GRID --- */
        .chart-grid { display: grid; grid-template-columns: 1.5fr 1fr; gap: 20px; margin-bottom: 20px; }
        .chart-grid.equal { grid-template-columns: 1fr 1fr; }
        .card { background: white; padding: 25px; border-radius: 16px; box-shadow: 0 2px 10px rgba(0,0,0,0.02); }
        .card-title { font-size: 1.1rem; font-weight: 600; margin-bottom: 5px; color: #2b3674; }
        .card-subtitle { font-size: 0.85rem; color: #a0aec0; margin-bottom: 20px; }
        .chart-container { position: relative; height: 250px; width: 100%; }
        .chart-container.small { height: 200px; }

        /* --- TABLE --- */
        .table-container { background: white; border-radius: 16px; padding: 25px; box-shadow: 0 2px 10px rgba(0,0,0,0.02); overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th { background: #f8f9fa; padding: 12px 15px; text-align: left; font-size: 0.75rem; color: #a0aec0; font-weight: 600; text-transform: uppercase; border-bottom: 1px solid #e2e8f0; }
        td { padding: 15px; border-bottom: 1px solid #e2e8f0; font-size: 0.9rem; vertical-align: middle; }
        .course-meta { font-size: 0.8rem; color: #a0aec0; display: block; margin-top: 3px; }
        
        .progress-wrapper { display: flex; align-items: center; gap: 10px; }
        .progress-bar { width: 100px; height: 6px; background: #e2e8f0; border-radius: 3px; overflow: hidden; }
        .progress-fill { height: 100%; border-radius: 3px; }
        
        .status { padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; }
        .status.available { background: #e6ffed; color: #05cd99; border: 1px solid #b7f4db; }
        .status.full { background: #ffe5e5; color: #ee5d50; border: 1px solid #ffcaca; }
        .bg-available { background: #05cd99; } .bg-warning { background: #ff9800; } .bg-full { background: #ee5d50; }
        .chart-grid {
    display: block; /* Hoặc grid-template-columns: 1fr; */
    width: 100%;
    margin-bottom: 20px;
}

/* Căn giữa và giãn đều bảng */
.report-table {
    width: 100%;
    border-collapse: collapse;
}

.report-table th, .report-table td {
    padding: 12px 15px; /* Tăng padding để bảng trông đầy đặn hơn */
    text-align: left;
}

/* Căn giữa các cột số liệu để cân đối khoảng trắng */
.report-table th:nth-child(5), .report-table td:nth-child(5),
.report-table th:nth-child(6), .report-table td:nth-child(6) {
    text-align: center;
}
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
        <div class="header">
            <h1><i class="fa-solid fa-chart-line" style="color: #4318ff;"></i> Báo cáo & Thống kê </h1>
            
            <div style="display: flex; gap: 15px; font-size: 1.2rem; color: #a0aec0;">
                <i class="fa-regular fa-bell"></i>
                <i class="fa-solid fa-shield-halved" style="color: #4318ff;"></i>
            </div>
        </div>

       <div class="sub-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; flex-wrap: wrap; gap: 20px;">
    <div style="display: flex; align-items: center; gap: 15px;">
        <label for="semester_select" style="font-weight: 600; color: #2b3674;">Kỳ đăng ký đang mở:</label>
        <select id="semester_select" class="btn-export" style="outline: none; min-width: 250px; background-color: #f4f7fe; border: 1px solid #4318ff; height: 45px;">
            <?php 
            $hasOpening = false;
            foreach($semesters as $sem): 
                if($sem['trang_thai_dang_ky'] == 'Đang mở'): 
                    $hasOpening = true;
            ?>
                <option value="<?= $sem['id_ky_hoc'] ?>" selected>
                    <?= htmlspecialchars($sem['ten_ky_hoc']) ?>
                </option>
            <?php 
                endif; 
            endforeach; 

            if (!$hasOpening): 
            ?>
                <option value="">-- Hiện không có kỳ nào mở --</option>
            <?php endif; ?>
        </select>
    </div>

    <div class="actions-header">
        <a href="Index.php?action=export_report" style="text-decoration: none;">
            <button class="btn-export" style="height: 45px; display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-download"></i> Xuất báo cáo
            </button>
        </a>
    </div>
</div>

        <div class="stats-row">
    <div class="stat-card">
        <h2><?= number_format($stats['lecturers']) ?></h2>
        <p class="title">Tổng Giảng viên</p>
    </div>

    <div class="stat-card">
        <h2><?= number_format($stats['classes']) ?></h2>
        <p class="title">Tổng Lớp học</p>
    </div>

    <div class="stat-card">
        <h2><?= number_format($stats['subjects']) ?></h2>
        <p class="title">Tổng Môn học</p>
    </div>

    <div class="stat-card">
        <h2><?= number_format($stats['reg_count']) ?></h2>
        <p class="title">Số lượt đăng ký</p>
    </div>
</div>
            <div class="card" style="margin-bottom: 25px; padding: 15px;">
    <div style="display: flex; gap: 20px; align-items: center;">
        <span style="font-weight: 600;"><i class="fa-solid fa-filter"></i> Bộ lọc Chương trình Học:</span>
        <select id="filter_ct" class="btn-export" style="min-width: 250px;" onchange="filterData()">
            <option value="all">Tất cả chương trình</option>
            <?php foreach($studyPrograms as $program): ?>
                <option value="<?= htmlspecialchars($program['chuong_trinh_hoc']) ?>">
                    <?= htmlspecialchars($program['chuong_trinh_hoc']) ?>
                </option>
            <?php endforeach; ?>
        </select>
       
    </div>
</div>

       

        <div class="chart-grid">
            <div class="card">
                <h3 class="card-title">Đăng ký theo Khoa</h3>
                <p class="card-subtitle">Sinh viên và Môn học mỗi khoa</p>
                <div class="chart-container"><canvas id="deptChart"></canvas></div>
            </div>
            
        </div>

       
        <table class="report-table">
    <thead>
        <tr>
            <th>Mã môn</th>
            <th>Tên môn học</th>
            <th>CT Học</th>
            <th>Giảng viên</th>
            <th>Sĩ số</th>
            <th>Đã đăng ký</th>
            <th>Tỷ lệ</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($courseSummary as $row): ?>
        <tr class="course-row" data-ct="<?= htmlspecialchars($row['chuong_trinh_hoc']) ?>">
    <td><strong><?= $row['ma_mon_hoc'] ?></strong></td>
            <td><?= htmlspecialchars($row['ten_mon_hoc']) ?></td>
            <td><span class="badge-ct"><?= htmlspecialchars($row['chuong_trinh_hoc']) ?></span></td>
            <td><?= htmlspecialchars($row['ten_giang_vien']) ?></td>
            <td><?= $row['si_so_toi_da'] ?></td>
            <td><b style="color: #4318ff;"><?= $row['si_so_da_dang_ky'] ?></b></td>
            <td>
                <?php 
                    $percent = ($row['si_so_toi_da'] > 0) ? ($row['si_so_da_dang_ky'] / $row['si_so_toi_da']) * 100 : 0;
                    $color = $percent >= 90 ? '#ef4444' : ($percent >= 50 ? '#f59e0b' : '#10b981');
                ?>
                <div style="width: 100%; background: #eee; height: 8px; border-radius: 4px;">
                    <div style="width: <?= $percent ?>%; background: <?= $color ?>; height: 100%; border-radius: 4px;"></div>
                </div>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

    <script>
      Chart.defaults.font.family = "'Segoe UI', sans-serif";
Chart.defaults.plugins.tooltip.backgroundColor = 'rgba(17, 28, 68, 0.9)';

// 3. Bar Chart: Enrollment by Department
new Chart(document.getElementById('deptChart').getContext('2d'), {
    type: 'bar',
    data: {
        // Lấy danh sách tên Chương trình học từ PHP
        labels: <?php echo json_encode($deptLabels); ?>, 
        datasets: [
            { 
                label: 'Sinh viên', 
                // Lấy mảng số lượng sinh viên tương ứng
                data: <?php echo json_encode($deptStudents); ?>, 
                backgroundColor: '#4318ff', 
                borderRadius: 4 
            },
            { 
                label: 'Môn học', 
                // Lấy mảng số lượng môn học tương ứng
                data: <?php echo json_encode($deptCourses); ?>, 
                backgroundColor: '#a855f7', 
                borderRadius: 4 
            }
        ]
    },
    options: { 
        responsive: true, 
        maintainAspectRatio: false, 
        plugins: { 
            legend: { 
                position: 'bottom', 
                labels: { usePointStyle: true } 
            } 
        }, 
        scales: { 
            y: { 
                beginAtZero: true, 
                grid: { borderDash: [5, 5] } 
            }, 
            x: { 
                grid: { display: false } 
            } 
        } 
    }
});

            
            function filterData() {
    // 1. Lấy giá trị từ bộ lọc
    const selectedValue = document.getElementById('filter_ct').value;
    
    // 2. Lấy tất cả các dòng của bảng có class là course-row
    const rows = document.querySelectorAll('.course-row');

    rows.forEach(row => {
        // Lấy thông tin chương trình học được lưu ở data-ct của dòng đó
        const rowProgram = row.getAttribute('data-ct');

        // 3. Kiểm tra: Nếu chọn "Tất cả" hoặc khớp với tên chương trình thì hiện, ngược lại thì ẩn
        if (selectedValue === "all" || rowProgram === selectedValue) {
            row.style.display = ""; // Hiển thị dòng
        } else {
            row.style.display = "none"; // Ẩn dòng
        }
    });
}
    
    </script>
</body>
</html>