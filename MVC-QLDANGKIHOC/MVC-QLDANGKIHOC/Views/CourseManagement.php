<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý môn học - Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* --- CSS GIỮ NGUYÊN TỪ DASHBOARD ĐỂ ĐỒNG BỘ --- */
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', sans-serif; }
        body { display: flex; background-color: #f4f7fe; color: #2b3674; min-height: 100vh; }
        
        /* SIDEBAR (Giữ nguyên y hệt) */
        .sidebar { width: 260px; background-color: #111c44; color: #fff; display: flex; flex-direction: column; padding: 20px; position: fixed; height: 100vh; }
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
        /* MAIN CONTENT */
        .main-content { margin-left: 260px; flex: 1; padding: 20px 30px; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
        .header h1 { font-size: 1.8rem; }
        .header-icons { display: flex; gap: 15px; font-size: 1.2rem; color: #a0aec0; }
        
        /* TOOLBAR (Tìm kiếm & Lọc) */
        .toolbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .course-count { color: #a0aec0; font-size: 0.9rem; }
        .btn-add { background: #4318ff; color: white; border: none; padding: 10px 20px; border-radius: 8px; cursor: pointer; font-weight: 600; display: flex; align-items: center; gap: 8px; }
        
        .filters { background: white; padding: 15px; border-radius: 12px; display: flex; gap: 15px; margin-bottom: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.02); }
        .search-box { flex: 1; position: relative; }
        .search-box i { position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #a0aec0; }
        .search-box input { width: 100%; padding: 10px 15px 10px 40px; border: 1px solid #e2e8f0; border-radius: 8px; outline: none; }
        .filter-select { padding: 10px 15px; border: 1px solid #e2e8f0; border-radius: 8px; outline: none; background: white; color: #2b3674; }

        /* BẢNG DỮ LIỆU */
        .table-container { background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.02); }
        table { width: 100%; border-collapse: collapse; }
        th { background: #f8f9fa; padding: 15px; text-align: left; font-size: 0.75rem; color: #a0aec0; font-weight: 600; text-transform: uppercase; border-bottom: 1px solid #e2e8f0; }
        td { padding: 15px; border-bottom: 1px solid #e2e8f0; font-size: 0.9rem; vertical-align: middle; }
        
        .course-info { display: flex; align-items: center; gap: 15px; }
        .course-icon { width: 40px; height: 40px; background: #f4f7fe; color: #4318ff; border-radius: 8px; display: flex; align-items: center; justify-content: center; }
        .course-name { font-weight: 600; color: #2b3674; margin-bottom: 3px; }
        .course-meta { font-size: 0.8rem; color: #a0aec0; }
        
        .schedule-time { font-weight: 500; margin-bottom: 3px; }
        .schedule-room { font-size: 0.8rem; color: #a0aec0; }

        /* THANH TIẾN TRÌNH SĨ SỐ */
        .capacity-text { font-weight: 600; text-align: center; margin-bottom: 5px; }
        .progress-bar { width: 100%; height: 4px; background: #e2e8f0; border-radius: 2px; overflow: hidden; }
        .progress-fill { height: 100%; background: #ff9800; }
        .progress-fill.full { background: #ee5d50; }
        .progress-fill.available { background: #05cd99; }

        /* BADGE TRẠNG THÁI */
        .status { padding: 4px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; display: inline-block; }
        .status.available { background: #e6ffed; color: #05cd99; border: 1px solid #b7f4db; }
        .status.full { background: #ffe5e5; color: #ee5d50; border: 1px solid #ffcaca; }

        /* MODAL THÊM MÔN HỌC */
        .modal-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); z-index: 1000; justify-content: center; align-items: center; }
        .modal-content { background: white; width: 500px; border-radius: 16px; padding: 25px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
        .modal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid #e2e8f0; padding-bottom: 15px; }
        .modal-title { display: flex; align-items: center; gap: 10px; font-size: 1.2rem; font-weight: 600; }
        .modal-title i { background: #f4f7fe; color: #4318ff; padding: 8px; border-radius: 8px; }
        .close-btn { background: none; border: none; font-size: 1.2rem; color: #a0aec0; cursor: pointer; }
        
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px; }
        .form-group label { display: block; font-size: 0.85rem; font-weight: 600; color: #2b3674; margin-bottom: 5px; }
        .form-group input, .form-group select { width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px; outline: none; }
        .form-group.full-width { grid-column: span 2; }
        .form-group textarea { width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px; outline: none; resize: vertical; min-height: 80px; }
        
        .modal-actions { display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px; }
        .btn-cancel { padding: 10px 20px; border: 1px solid #e2e8f0; background: white; border-radius: 8px; cursor: pointer; font-weight: 600; color: #2b3674; }
        .btn-submit { padding: 10px 20px; border: none; background: #4318ff; color: white; border-radius: 8px; cursor: pointer; font-weight: 600; }
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
        <h1><i class="fa-solid fa-users-rectangle" style="color: #4318ff;"></i> Quản lý môn học</h1>
        <div style="display: flex; gap: 15px; font-size: 1.2rem; color: #a0aec0;">
            <i class="fa-regular fa-bell"></i>
            <i class="fa-solid fa-shield-halved" style="color: #4318ff;"></i>
        </div>
    </div>

        <div class="toolbar">
    <div class="course-count">Tổng cộng <?php echo count($mon_hocs); ?> môn học</div>
    
    <a href="Index.php?action=add_course" class="btn-add" style="text-decoration: none; display: inline-flex; align-items: center; justify-content: center;">
        <i class="fa-solid fa-plus"></i> Thêm môn học
    </a>
</div>

        <div class="filters">
            <div class="search-box">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" id="searchInput" placeholder="Tìm kiếm theo tên hoặc mã môn...">
            </div>

            <select class="filter-select" id="programFilter">
                <option value="all">Tất cả các khoa</option>
                <?php if(!empty($programs)): ?>
                    <?php foreach($programs as $prog): ?>
                        <option value="<?php echo htmlspecialchars($prog['chuong_trinh_hoc']); ?>">
                            <?php echo htmlspecialchars($prog['chuong_trinh_hoc']); ?>
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Mã môn học</th>
                        <th>Tên môn học</th>
                        <th>Chương trình đào tạo</th>
                        <th style="text-align: center;">Số tín chỉ</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody id="courseTableBody">
                    <?php if(!empty($mon_hocs)): ?>
                        <?php foreach ($mon_hocs as $mon): ?>
                        <tr class="course-item" 
                            data-name="<?php echo htmlspecialchars($mon['ten_mon_hoc']); ?>" 
                            data-code="<?php echo htmlspecialchars($mon['ma_mon_hoc']); ?>" 
                            data-program="<?php echo htmlspecialchars($mon['chuong_trinh_hoc']); ?>">
                            
                            <td style="font-weight: bold; color: #4318ff;">
                                <?php echo htmlspecialchars($mon['ma_mon_hoc']); ?>
                            </td>

                            <td>
                                <div class="course-info">
                                    <div class="course-icon"><i class="fa-solid fa-book-bookmark"></i></div>
                                    <div>
                                        <div class="course-name"><?php echo htmlspecialchars($mon['ten_mon_hoc']); ?></div>
                                        <div class="course-meta">Học phần bắt buộc</div> 
                                    </div>
                                </div>
                            </td>

                            <td>
                                <span class="status available" style="background: #f4f7fe; color: #4318ff; border-color: #e2e8f0;">
                                    <?php echo htmlspecialchars($mon['chuong_trinh_hoc']); ?>
                                </span>
                            </td>

                            <td style="font-weight: 600; color: #2b3674; text-align: center;">
                                <?php echo $mon['so_tin_chi']; ?>
                            </td>
                            
                           <td>
    <div style="display: flex; gap: 10px;">
        <a href="Index.php?action=edit_course&id=<?php echo urlencode($mon['ma_mon_hoc']); ?>" 
           class="btn-icon-action" style="color: #4318ff; font-size: 1.2rem;">
            <i class="fa-solid fa-pen-to-square"></i>
        </a>
        
        <a href="Index.php?action=delete_course&id=<?php echo urlencode($mon['ma_mon_hoc']); ?>" 
           class="btn-icon-action" style="color: #ee5d50; font-size: 1.2rem;" 
           onclick="return confirm('Bạn có chắc chắn muốn xóa môn [<?php echo htmlspecialchars($mon['ten_mon_hoc']); ?>] không?')">
            <i class="fa-solid fa-trash"></i>
        </a>
    </div>
</td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 20px; color: #666;">Chưa có môn học nào trong hệ thống.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

<script>
// JS Xử lý Tìm kiếm và Lọc môn học
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const programFilter = document.getElementById('programFilter');
    const rows = document.querySelectorAll('.course-item');

    function filterData() {
        // Chuyển từ khóa tìm kiếm về chữ thường để so sánh không phân biệt hoa/thường
        const searchTerm = searchInput.value.toLowerCase().trim();
        const selectedProgram = programFilter.value;

        rows.forEach(row => {
            // Lấy dữ liệu từ các thuộc tính data- và chuyển về chữ thường
            const courseName = row.getAttribute('data-name').toLowerCase();
            const courseCode = row.getAttribute('data-code').toLowerCase();
            const courseProgram = row.getAttribute('data-program');

            // Điều kiện 1: Khớp từ khóa tìm kiếm (tên hoặc mã)
            const matchesSearch = courseName.includes(searchTerm) || courseCode.includes(searchTerm);
            
            // Điều kiện 2: Khớp khoa đã chọn
            const matchesProgram = (selectedProgram === 'all' || courseProgram === selectedProgram);

            // Hiển thị nếu thỏa mãn cả 2 điều kiện
            if (matchesSearch && matchesProgram) {
                row.style.display = ""; // Hiện dòng
            } else {
                row.style.display = "none"; // Ẩn dòng
            }
        });
    }

    // Lắng nghe sự kiện khi người dùng gõ vào ô tìm kiếm
    searchInput.addEventListener('input', filterData);

    // Lắng nghe sự kiện khi người dùng chọn một khoa khác
    programFilter.addEventListener('change', filterData);
});
</script>
</body>
</html>