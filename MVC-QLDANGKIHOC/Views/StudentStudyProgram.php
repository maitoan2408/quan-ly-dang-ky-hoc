<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chương trình học - Sinh viên</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', sans-serif; }
        body { display: flex; background-color: #f8f9fa; color: #1a1a2e; min-height: 100vh; }
        
        /* --- SIDEBAR THỦ CÔNG --- */
        .sidebar { width: 260px; background-color: #111c44; color: #fff; display: flex; flex-direction: column; padding: 20px; position: fixed; height: 100vh; z-index: 100;}
        .logo { font-size: 1.1rem; font-weight: bold; display: flex; align-items: center; gap: 10px; margin-bottom: 30px; }
        .logo i { background: rgba(255,255,255,0.1); padding: 8px; border-radius: 8px; }
        .student-profile-mini { display: flex; align-items: center; gap: 12px; background: rgba(255,255,255,0.05); padding: 12px; border-radius: 12px; margin-bottom: 25px; }
        .avatar-mini { width: 40px; height: 40px; background: #6d28d9; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; }
        .info-mini h4 { font-size: 0.9rem; } .info-mini p { font-size: 0.75rem; color: #a0aec0; }
        .menu-section { font-size: 0.75rem; color: #a0aec0; font-weight: bold; margin: 15px 0 10px; text-transform: uppercase; letter-spacing: 1px; }
        .menu-item { padding: 10px 15px; border-radius: 8px; color: #a0aec0; text-decoration: none; display: flex; align-items: center; gap: 15px; margin-bottom: 5px; transition: 0.3s; font-size: 0.9rem; }
        .menu-item:hover, .menu-item.active { background-color: rgba(255,255,255,0.05); color: #fff; }
        .menu-item.active { background: #1a1b41; border-left: 4px solid #6d28d9; border-radius: 0 8px 8px 0; }
        .sign-out { margin-top: auto; padding: 15px; color: #a0aec0; text-decoration: none; display: flex; align-items: center; gap: 15px; font-size: 0.9rem; }

        /* --- MAIN CONTENT --- */
        .main-content { margin-left: 260px; flex: 1; padding: 20px 30px; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
        .header h1 { font-size: 1.5rem; font-weight: 600; color: #1a1a2e; }
        
        /* --- PROGRESS BANNER --- */
        .progress-banner { background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%); color: white; border-radius: 16px; padding: 30px; margin-bottom: 25px; position: relative; overflow: hidden; box-shadow: 0 10px 20px rgba(109, 40, 217, 0.15); }
        .banner-top { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
        .degree-info { display: flex; align-items: center; gap: 15px; }
        .degree-icon { width: 50px; height: 50px; background: rgba(255,255,255,0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; }
        .degree-text h2 { font-size: 1.3rem; margin-bottom: 5px; }
        .degree-text p { font-size: 0.9rem; opacity: 0.9; }
        .percent-box { text-align: right; }
        .percent-box h2 { font-size: 1.8rem; }
        .percent-box p { font-size: 0.85rem; opacity: 0.9; }
        
        .banner-bar-bg { width: 100%; height: 8px; background: rgba(255,255,255,0.2); border-radius: 4px; margin-bottom: 10px; }
        .banner-bar-fill { height: 100%; background: white; border-radius: 4px; }
        .banner-bottom { display: flex; justify-content: space-between; font-size: 0.85rem; opacity: 0.9; }

        /* --- STATS CARDS --- */
        .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 35px; }
        .stat-card { background: white; padding: 20px; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.02); border: 1px solid #f1f5f9; }
        .stat-icon { width: 35px; height: 35px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 1rem; margin-bottom: 15px; }
        .stat-card h3 { font-size: 1.5rem; color: #1a1a2e; margin-bottom: 5px; }
        .stat-card p { font-size: 0.85rem; color: #64748b; }

        /* --- CURRICULUM PLAN --- */
        .section-title { font-size: 1.2rem; font-weight: 600; color: #1a1a2e; margin-bottom: 15px; }
        .curriculum-list { display: flex; flex-direction: column; gap: 15px; margin-bottom: 40px; }
        
        .term-card { background: white; border-radius: 12px; border: 1px solid #f1f5f9; overflow: hidden; }
        .term-header { padding: 20px; display: flex; justify-content: space-between; align-items: center; cursor: pointer; }
        .term-left { display: flex; align-items: center; gap: 15px; }
        .term-icon { width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; }
        .term-title h4 { font-size: 1rem; color: #1a1a2e; margin-bottom: 3px; }
        .term-title p { font-size: 0.85rem; color: #64748b; }
        .term-right { display: flex; align-items: center; gap: 15px; }
        .status-badge { padding: 6px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; }
        
        /* Màu sắc Trạng thái của Lộ trình */
        .completed .term-icon { background: #ecfdf5; color: #10b981; }
        .completed .status-badge { background: #ecfdf5; color: #10b981; border: 1px solid #a7f3d0; }
        
        .inprogress { border-color: #c4b5fd; box-shadow: 0 4px 15px rgba(109, 40, 217, 0.05); }
        .inprogress .term-icon { background: #f3f0ff; color: #6d28d9; }
        .inprogress .status-badge { background: #f3f0ff; color: #6d28d9; border: 1px solid #ddd6fe; }
        
        .upcoming .term-icon { background: #f8fafc; color: #94a3b8; border: 2px solid #e2e8f0; }
        .upcoming .status-badge { background: #f8fafc; color: #64748b; border: 1px solid #e2e8f0; }

        /* Danh sách môn học bên trong Lộ trình */
        .term-body { padding: 0 20px 20px 20px; display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
        .course-item { display: flex; justify-content: space-between; align-items: center; padding: 15px; background: #f8fafc; border-radius: 8px; font-size: 0.9rem; color: #4a5568; }
        .course-item i { color: #10b981; }

        /* --- ACADEMIC STANDING --- */
        .standing-panel { background: white; border-radius: 16px; padding: 25px; box-shadow: 0 2px 10px rgba(0,0,0,0.02); border: 1px solid #f1f5f9; }
        .standing-header { display: flex; align-items: center; gap: 15px; margin-bottom: 20px; }
        .standing-icon { width: 45px; height: 45px; background: #fffbeb; color: #f59e0b; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; }
        
        .standing-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px; }
        .std-box { padding: 20px; border-radius: 12px; }
        .std-box.green { background: #ecfdf5; border: 1px solid #a7f3d0; } .std-box.green h3 { color: #059669; }
        .std-box.blue { background: #eff6ff; border: 1px solid #bfdbfe; } .std-box.blue h3 { color: #2563eb; }
        .std-box.purple { background: #f5f3ff; border: 1px solid #ddd6fe; } .std-box.purple h3 { color: #7c3aed; }
        .std-box.yellow { background: #fffbeb; border: 1px solid #fde68a; } .std-box.yellow h3 { color: #d97706; }
        
        .std-box h3 { font-size: 1.4rem; margin-bottom: 5px; }
        .std-box p { font-size: 0.8rem; color: #64748b; margin-bottom: 2px;}
        .std-box small { font-size: 0.75rem; color: #94a3b8; }
        /* --- PROGRAM SELECTOR --- */
.program-selector-container {    background: white;    padding: 15px 25px;    border-radius: 12px;    display: flex;    align-items: center;    gap: 20px;    margin-bottom: 25px;    box-shadow: 0 2px 10px rgba(0,0,0,0.02);    border: 1px solid #f1f5f9;}
.selector-label {    display: flex    align-items: center;    gap: 10px;    color: #64748b;    font-size: 0.9rem;    font-weight: 500;}
.selector-label i {    color: #6d28d9;}
.program-select {    flex: 1;    padding: 10px 15px;    border-radius: 8px;    border: 1px solid #e2e8f0;    background-color: #f8fafc;    color: #1a1a2e;    font-size: 0.95rem;    outline: none;    cursor: pointer;    transition: all 0.3s ease;}
.program-select:focus {    border-color: #6d28d9;    background-color: #fff;    box-shadow: 0 0 0 3px rgba(109, 40, 217, 0.1);}
@media (max-width: 768px) {    .program-selector-container {        flex-direction: column;        align-items: flex-start;        gap: 10px;    }    .program-select {        width: 100%;    }    }
.filter-search-container {   background: white;   padding: 12px 20px;   border-radius: 12px;    display: flex;   align-items: center;   justify-content: space-between;   gap: 20px;   margin-bottom: 25px;   box-shadow: 0 2px 10px rgba(0,0,0,0.02);    border: 1px solid #f1f5f9;}
.selector-group {    display: flex;   align-items: center;    gap: 12px;    flex: 1;}
.selector-label {    display: flex;    align-items: center;    gap: 8px;    color: #64748b;    font-size: 0.85rem;    white-space: nowrap;}
.search-group {    position: relative;    flex: 1;    max-width: 400px;}
.search-icon {    position: absolute;    left: 15px;    top: 50%;    transform: translateY(-50%);    color: #94a3b8;    font-size: 0.9rem;}
.search-input {    width: 100%;    padding: 10px 15px 10px 40px;    border-radius: 8px;    border: 1px solid #e2e8f0;    background-color: #f8fafc;    color: #1a1a2e;   font-size: 0.9rem;    outline: none;    transition: all 0.3s ease;}
.search-input:focus {    border-color: #6d28d9;    background-color: #fff;    box-shadow: 0 0 0 3px rgba(109, 40, 217, 0.1);}
.program-select {    width: 100%;    padding: 10px;    border-radius: 8px;    border: 1px solid #e2e8f0;    background-color: #f8fafc;    font-size: 0.9rem;    outline: none;    cursor: pointer;}
@media (max-width: 992px) {    .filter-search-container {        flex-direction: column;        align-items: stretch;    }   .search-group {        max-width: 100%;    }}
.table-container {    background: white;    border-radius: 12px;    border: 1px solid #f1f5f9;    box-shadow: 0 2px 10px rgba(0,0,0,0.02);    overflow: hidden; /* Bo góc cho bảng */}
.course-table {    width: 100%;    border-collapse: collapse;    font-size: 0.95rem;}
.course-table th {    background-color: #f8fafc;    color: #64748b;    font-weight: 600;    text-align: left;    padding: 15px 20px;    border-bottom: 2px solid #f1f5f9;    text-transform: uppercase;    font-size: 0.75rem;    letter-spacing: 0.5px;}
.course-table td {    padding: 15px 20px;    border-bottom: 1px solid #f1f5f9;    color: #1a1a2e;}
.course-table tr:last-child td {    border-bottom: none;}
.course-table tr:hover {    background-color: #fbfcfe;}
.text-center { text-align: center !important; }
.text-right { text-align: right !important; }
.code-badge {    background: #f1f5ff;    color: #4338ca;    padding: 4px 8px;    border-radius: 6px;    font-family: 'Courier New', monospace;    font-weight: 600;    font-size: 0.85rem;}
.course-name {    font-weight: 500;    color: #1e293b;}
.btn-view {    background: none;    border: none;    color: #94a3b8;    cursor: pointer;    font-size: 1.1rem;    transition: 0.2s;}
.btn-view:hover {    color: #6d28d9;}
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
            <h1>Chương trình học </h1>
        </div>   
        <div class="filter-search-container">
    <form action="Index.php" method="GET" style="display: flex; width: 100%; gap: 20px;">
        
        <input type="hidden" name="action" value="student_study_program">

        <div class="selector-group">
            <div class="selector-label"><i class="fa-solid fa-filter"></i> <span>Chương trình:</span></div>
            <select class="program-select" name="program" onchange="this.form.submit()">
                <option value="all">Tất cả chương trình</option>
                <?php foreach ($allPrograms as $prog): ?>
                    <option value="<?php echo htmlspecialchars($prog); ?>" 
                        <?php echo (isset($_GET['program']) && $_GET['program'] == $prog) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($prog); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="search-group">
            <i class="fa-solid fa-magnifying-glass search-icon"></i>
            <input type="text" name="search" class="search-input" 
                   placeholder="Tìm kiếm môn học..." 
                   value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">
        </div>
    </form>
</div>
<div class="table-container">
    <table class="course-table">
        <thead>
            <tr>
                <th>Mã môn học</th>
                <th>Tên môn học</th>
                <th class="text-center">Số tín chỉ</th>
                <th>Chương trình đào tạo</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($courses)): ?>
                <?php foreach ($courses as $row): ?>
                <tr>
                    <td><span class="code-badge"><?php echo htmlspecialchars($row['ma_mon_hoc']); ?></span></td>
                    <td class="course-name"><?php echo htmlspecialchars($row['ten_mon_hoc']); ?></td>
                    <td class="text-center"><?php echo $row['so_tin_chi']; ?></td>
                    <td><?php echo htmlspecialchars($row['chuong_trinh_hoc']); ?></td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="4" style="text-align:center; padding: 20px;">Không có dữ liệu phù hợp.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
    </div>

</body>
</html>