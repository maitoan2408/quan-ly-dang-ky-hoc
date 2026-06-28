<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý lớp học - Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', sans-serif; }
        body { display: flex; background-color: #f4f7fe; color: #2b3674; min-height: 100vh; }
        
        /* --- SIDEBAR --- */
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

        /* --- MAIN CONTENT --- */
        .main-content { margin-left: 260px; flex: 1; padding: 20px 30px; }
       .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
        .header h1 { font-size: 1.8rem; }
        .header-icons { display: flex; gap: 15px; font-size: 1.2rem; color: #a0aec0; }
        
        /* --- STATS CARDS --- */
        .stats-row { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 25px; }
        .stat-box { background: white; padding: 20px; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.02); }
        .stat-box h4 { font-size: 0.85rem; color: #a0aec0; font-weight: normal; margin-bottom: 5px; }
        .stat-box h2 { font-size: 1.8rem; color: #2b3674; }

        /* --- TOOLBAR CẬP NHẬT (THÊM LỌC KHOA) --- */
        .toolbar { display: flex; justify-content: space-between; align-items: center; background: white; padding: 15px; border-radius: 12px; margin-bottom: 25px; box-shadow: 0 2px 10px rgba(0,0,0,0.02); }
        .search-box { position: relative; flex: 1; margin-right: 20px; }
        .search-box i { position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #a0aec0; }
        .search-box input { width: 100%; padding: 10px 15px 10px 40px; border: 1px solid #e2e8f0; border-radius: 8px; outline: none; background: #f8f9fa;}
        .toolbar-actions { display: flex; gap: 15px; align-items: center; }
        .filter-select { padding: 10px 15px; border: 1px solid #e2e8f0; border-radius: 8px; outline: none; background: white; min-width: 180px; color: #2b3674; cursor: pointer; }
        .btn-add { background: #8b5cf6; color: white; border: none; padding: 10px 20px; border-radius: 8px; cursor: pointer; font-weight: 600; display: flex; align-items: center; gap: 8px; transition: 0.3s; }
        .btn-add:hover { opacity: 0.9; }

        /* --- CLASS GRID --- */
        .class-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
        .class-card { background: white; border-radius: 16px; padding: 20px; box-shadow: 0 2px 15px rgba(0,0,0,0.03); border: 1px solid transparent; transition: 0.3s; }
        .class-card:hover { border-color: #8b5cf6; box-shadow: 0 5px 20px rgba(139, 92, 246, 0.1); }
        .card-header { display: flex; align-items: center; gap: 15px; margin-bottom: 20px; }
        .card-icon { width: 45px; height: 45px; background: #f4f7fe; color: #8b5cf6; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; }
        .card-title h3 { font-size: 1.1rem; color: #2b3674; }
        .card-title p { font-size: 0.8rem; color: #a0aec0; }
        
        .card-details { display: flex; flex-direction: column; gap: 10px; margin-bottom: 20px; border-bottom: 1px solid #e2e8f0; padding-bottom: 20px; }
        .detail-row { display: flex; justify-content: space-between; font-size: 0.85rem; }
        .detail-label { color: #a0aec0; }
        .detail-value { font-weight: 500; color: #2b3674; text-align: right; max-width: 65%; }

        .enrollment-info { display: flex; justify-content: space-between; font-size: 0.85rem; margin-bottom: 8px; font-weight: 600; }
        .progress-bar { width: 100%; height: 6px; background: #e2e8f0; border-radius: 3px; overflow: hidden; }
        .progress-fill { height: 100%; border-radius: 3px;}
        
        .status-available { color: #05cd99; } .bg-available { background: #05cd99; }
        .status-warning { color: #ff9800; } .bg-warning { background: #ff9800; }
        .status-full { color: #ee5d50; } .bg-full { background: #ee5d50; }

        /* --- MODAL THÊM LỚP HỌC MỚI --- */
        .modal-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); z-index: 1000; justify-content: center; align-items: center; }
        .modal-content { background: white; width: 550px; border-radius: 16px; padding: 25px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
        .modal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid #e2e8f0; padding-bottom: 15px; }
        .modal-title { display: flex; align-items: center; gap: 10px; font-size: 1.2rem; font-weight: 600; color: #2b3674; }
        .modal-title i { background: #f4f7fe; color: #8b5cf6; padding: 8px; border-radius: 8px; }
        .close-btn { background: none; border: none; font-size: 1.2rem; color: #a0aec0; cursor: pointer; }
        
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px; }
        .form-group label { display: block; font-size: 0.85rem; font-weight: 600; color: #4a5568; margin-bottom: 8px; }
        .form-group input, .form-group select { width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px; outline: none; color: #2d3748; }
        .form-group.full-width { grid-column: span 2; }
        
        .modal-actions { display: flex; justify-content: flex-end; gap: 10px; margin-top: 25px; }
        .btn-cancel { padding: 10px 20px; border: 1px solid #e2e8f0; background: white; border-radius: 8px; cursor: pointer; font-weight: 600; color: #4a5568; }
        .btn-submit { padding: 10px 20px; border: none; background: #8b5cf6; color: white; border-radius: 8px; cursor: pointer; font-weight: 600; }
        /* Container chứa 2 nút */
.card-actions {
    position: absolute;
    top: 15px;
    right: 15px;
    display: flex;
    gap: 8px;
    z-index: 10;
}

/* Định dạng chung cho nút */
.card-actions a {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.85rem;
    transition: all 0.2s ease;
    text-decoration: none;
    background: #f4f7fe; /* Màu nền nhạt để tiệp với card */
}

/* Nút Sửa (Màu xanh/tím nhạt) */
.btn-edit {
    color: #8b5cf6;
}
.btn-edit:hover {
    background: #8b5cf6;
    color: white;
    transform: scale(1.1);
}

/* Nút Xóa (Màu đỏ nhạt) */
.btn-delete {
    color: #ef4444;
}
.btn-delete:hover {
    background: #ef4444;
    color: white;
    transform: scale(1.1);
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
        <i class="fa-solid fa-arrow-right-from-bracket"></i> 
        <span>Đăng xuất</span>
    </a>
</div>
    </div>

    <div class="main-content">
    <div class="header">
        <h1><i class="fa-solid fa-users-rectangle" style="color: #4318ff;"></i> Quản lý lớp học</h1>
        <div style="display: flex; gap: 15px; font-size: 1.2rem; color: #a0aec0;">
            <i class="fa-regular fa-bell"></i>
            <i class="fa-solid fa-shield-halved" style="color: #4318ff;"></i>
        </div>
    </div>

    <div class="stats-row">
        <div class="stat-box">
            <h4>Tổng số lớp</h4>
            <h2><?php echo isset($stats['total_classes']) ? $stats['total_classes'] : 0; ?></h2>
        </div>
        <div class="stat-box">
            <h4>Tổng sức chứa</h4>
            <h2><?php echo isset($stats['total_capacity']) ? $stats['total_capacity'] : 0; ?></h2>
        </div>
        <div class="stat-box">
            <h4>Tổng đã đăng ký</h4>
            <h2><?php echo isset($stats['total_enrolled']) ? $stats['total_enrolled'] : 0; ?></h2>
        </div>
        <div class="stat-box">
            <h4>Tỷ lệ lấp đầy TB</h4>
            <h2><?php echo isset($stats['avg_fill_rate']) ? $stats['avg_fill_rate'] : 0; ?>%</h2>
        </div>
    </div>

    <div class="toolbar-actions" style="display: flex; gap: 15px; align-items: center; flex-wrap: wrap;">
    <div class="search-box" style="position: relative; flex: 2; ">
    <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #a0aec0;"></i>
    <input type="text" id="searchInput" placeholder="Tìm kiếm theo tên hoặc mã môn..." 
           style="width: 100%; padding: 12px 15px 12px 45px; border: 1px solid #e2e8f0; border-radius: 10px; outline: none; background: #f8f9fa; transition: 0.3s;">
</div>

    <div class="filter-group" style="display: flex; align-items: center; gap: 8px;">
        <label for="programFilter" style="font-size: 0.85rem; color: #a0aec0;">Ngành:</label>
        <select class="filter-select" id="programFilter" onchange="applyFilters()" style="padding: 8px; border-radius: 8px; border: 1px solid #e2e8f0;">
            <option value="all" <?php echo (($selectedProgram ?? 'all') === 'all') ? 'selected' : ''; ?>>Tất cả chương trình</option>
            <?php if(!empty($programs)): ?>
                <?php foreach ($programs as $prog): ?>
                    <option value="<?php echo htmlspecialchars($prog['chuong_trinh_hoc']); ?>" 
                        <?php echo (($selectedProgram ?? 'all') === $prog['chuong_trinh_hoc']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($prog['chuong_trinh_hoc']); ?>
                    </option>
                <?php endforeach; ?>
            <?php endif; ?>
        </select>
    </div>
    
    <button class="btn-add" onclick="window.location.href='Index.php?action=add_class'" style="margin-left: auto;">
        <i class="fa-solid fa-plus"></i> Thêm lớp học
    </button>
</div>

    <div class="class-grid">
        <?php if(isset($classes) && !empty($classes)): ?>
            <?php foreach ($classes as $class): 
                $percent = ($class['si_so_toi_da'] > 0) ? round(($class['si_so_da_dang_ky'] / $class['si_so_toi_da']) * 100) : 0;
                $colorClass = 'status-available';
                $bgClass = 'bg-available';
                
                if ($percent >= 100) { $colorClass = 'status-full'; $bgClass = 'bg-full'; } 
                elseif ($percent >= 75) { $colorClass = 'status-warning'; $bgClass = 'bg-warning'; }
            ?>
                <div class="class-card" style="position: relative;"> <div class="card-actions">
        <a href="Index.php?action=edit_class&id=<?php echo $class['ma_lop_hoc']; ?>" class="btn-edit" title="Sửa">
            <i class="fa-solid fa-pen-to-square"></i>
        </a>
        <a href="javascript:void(0)" onclick="confirmDelete('<?php echo $class['ma_lop_hoc']; ?>')" class="btn-delete" title="Xóa">
            <i class="fa-solid fa-trash-can"></i>
        </a>
    </div>

    <div class="card-header">
        <div class="icon-box"><i class="fa-solid fa-users"></i></div>
        <h3>Mã lớp: <?php echo $class['ma_lop_hoc']; ?></h3>
    </div>
                    
                    <div class="card-details">
                        <div class="detail-row">
                            <span class="detail-label">Môn học</span>
                            <span class="detail-value"><?php echo htmlspecialchars($class['ten_mon_hoc']); ?></span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Giảng viên</span>
                            <span class="detail-value"><?php echo htmlspecialchars($class['ten_giang_vien']); ?></span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Phòng</span>
                            <span class="detail-value"><?php echo htmlspecialchars($class['phong_hoc']); ?></span>
                        </div>
                    </div>

                    <div class="enrollment-section">
                        <div class="enrollment-info">
                            <span class="detail-label">Đăng ký</span>
                            <span class="<?php echo $colorClass; ?>">
                                <?php echo $class['si_so_da_dang_ky']; ?>/<?php echo $class['si_so_toi_da']; ?> (<?php echo $percent; ?>%)
                            </span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill <?php echo $bgClass; ?>" style="width: <?php echo $percent; ?>%;"></div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="grid-column: 1/-1; text-align: center; color: #a0aec0; padding: 40px;">
                Không tìm thấy lớp học nào thuộc chương trình này.
            </p>
        <?php endif; ?>
    </div> </div> <script>
function applyFilters() {
    const program = document.getElementById('programFilter').value;
    const search = document.getElementById('searchInput').value.trim();
    
    const urlParams = new URLSearchParams(window.location.search);
    const currentAction = urlParams.get('action') || 'classes';
    
    let newUrl = `Index.php?action=${currentAction}`;
    
    // Thêm tham số ngành nếu khác "Tất cả"
    if (program !== 'all') {
        newUrl += `&program=${encodeURIComponent(program)}`;
    }
    
    // Giữ lại từ khóa tìm kiếm trên URL nếu có
    if (search !== '') {
        newUrl += `&search=${encodeURIComponent(search)}`;
    }
    
    window.location.href = newUrl;
}
function confirmDelete(classId) {
    if (confirm("Bạn có chắc chắn muốn xóa lớp học " + classId + " không?")) {
        // Đảm bảo action là 'delete_class' và id là 'ma_lop_hoc'
        window.location.href = "Index.php?action=delete_class&id=" + classId;
    }
}
// Lắng nghe sự kiện người dùng nhập liệu (Auto search)
document.getElementById('searchInput').addEventListener('input', function () {
    const filter = this.value.toLowerCase().trim(); // Lấy từ khóa, chuyển về chữ thường
    const cards = document.querySelectorAll('.class-card'); // Lấy tất cả các Card lớp học
    let hasResults = false;

    cards.forEach(card => {
        // Lấy thông tin cần tìm trong Card (Mã lớp, Tên môn, Giảng viên)
        const classCode = card.querySelector('.card-title h3').textContent.toLowerCase();
        const details = card.querySelectorAll('.detail-value');
        const courseName = details[0].textContent.toLowerCase(); // Môn học
        const lecturer = details[1].textContent.toLowerCase();  // Giảng viên

        // Kiểm tra xem từ khóa có xuất hiện trong bất kỳ trường nào không
        if (classCode.includes(filter) || courseName.includes(filter) || lecturer.includes(filter)) {
            card.style.display = ""; // Hiển thị Card
            hasResults = true;
        } else {
            card.style.display = "none"; // Ẩn Card
        }
    });

    // Xử lý hiển thị thông báo nếu không tìm thấy kết quả
    let noResultMsg = document.getElementById('noResultMsg');
    if (!hasResults) {
        if (!noResultMsg) {
            noResultMsg = document.createElement('p');
            noResultMsg.id = 'noResultMsg';
            noResultMsg.style.cssText = "grid-column: 1/-1; text-align: center; color: #a0aec0; padding: 40px;";
            noResultMsg.textContent = "Không tìm thấy dữ liệu khớp với từ khóa...";
            document.querySelector('.class-grid').appendChild(noResultMsg);
        }
    } else if (noResultMsg) {
        noResultMsg.remove();
    }
});

</script>
</body>
</html>
