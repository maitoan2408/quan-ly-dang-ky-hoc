<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm lịch học - Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* --- CSS GIỮ NGUYÊN TỪ LAYOUT GỐC --- */
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', sans-serif; }
        body { display: flex; background-color: #f4f7fe; color: #2b3674; min-height: 100vh; }
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

        /* --- CSS CHO FORM THÊM LỊCH HỌC --- */
        .form-container {
            background: #ffffff;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.02);
            max-width: 900px;
        }

        .form-title {
            font-size: 1.2rem;
            color: #2b3674;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        /* Group chiếm trọn 2 cột nếu cần */
        .full-width {
            grid-column: span 2;
        }

        .form-label {
            font-size: 0.9rem;
            font-weight: 600;
            color: #4a5568;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-size: 0.95rem;
            color: #2d3748;
            background-color: #f8fafc;
            transition: all 0.3s ease;
            outline: none;
        }

        .form-control:focus {
            border-color: #4318ff;
            background-color: #ffffff;
            box-shadow: 0 0 0 3px rgba(67, 24, 255, 0.1);
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
        }

        .btn {
            padding: 10px 25px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: 0.3s;
            border: none;
        }

        .btn-cancel {
            background: #edf2f7;
            color: #4a5568;
        }

        .btn-cancel:hover {
            background: #e2e8f0;
        }

        .btn-save {
            background: #4318ff;
            color: white;
        }

        .btn-save:hover {
            background: #3311cc;
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
        <a href="Index.php?action=schedules" class="menu-item active"><i class="fa-regular fa-calendar-days"></i> Lịch học</a>

        <div class="menu-section">Hành chính</div>
        <a href="Index.php?action=registration_periods" class="menu-item"><i class="fa-regular fa-folder-open"></i> Kỳ đăng ký</a>
        <a href="Index.php?action=reports" class="menu-item"><i class="fa-solid fa-chart-line"></i> Báo cáo & Thống kê</a>

        <div class="user-profile">
            <a href="Index.php?action=logout" class="menu-item" style="padding:0; margin:0; width:100%; justify-content:center;">
                <i class="fa-solid fa-arrow-right-from-bracket"></i> Đăng xuất
            </a>
        </div>
    </div>

    <div class="main-content">
        <div class="header">
            <h1><i class="fa-solid fa-calendar-plus" style="color: #4318ff;"></i> Thêm lịch học mới</h1>
            <div style="display: flex; gap: 15px; font-size: 1.2rem; color: #a0aec0;">
                <i class="fa-regular fa-bell"></i>
                <i class="fa-solid fa-shield-halved" style="color: #4318ff;"></i>
            </div>
        </div>

        <div class="form-container">
            <div class="form-title">
                <i class="fa-solid fa-circle-info"></i> Thông tin lịch học chi tiết
            </div>
            
           <form action="Index.php?action=process_add_schedule" method="POST">
    <div class="form-grid">
        <div class="form-group">
            <label class="form-label">Chọn lớp học <span style="color:red">*</span></label>
            <select class="form-control" name="id_lop_hoc" id="class_id" required onchange="updateClassInfo()">
    <option value="">-- Chọn lớp học --</option>
    <?php if (!empty($all_classes)): ?>
        <?php foreach($all_classes as $class): ?>
            <option value="<?php echo $class['id_lop_hoc'] ?? ''; ?>" 
                    data-mid="<?php echo $class['id_mon_hoc'] ?? ''; ?>"
                    data-course="<?php echo htmlspecialchars($class['ten_mon_hoc'] ?? ''); ?>"
                    data-teacher="<?php echo htmlspecialchars($class['ten_giang_vien'] ?? ''); ?>"
                    data-room="<?php echo htmlspecialchars($class['phong_hoc'] ?? ''); ?>">
                <?php echo $class['ma_lop_hoc'] ?? 'N/A'; ?>
            </option>
        <?php endforeach; ?>
    <?php endif; ?>
</select>
        </div>

        <input type="hidden" name="id_mon_hoc" id="id_mon_hoc">

        <div class="form-group">
            <label class="form-label">Môn học</label>
            <input type="text" class="form-control" id="course_name" readonly style="background-color: #eee;">
        </div>
        <div class="form-group">
            <label class="form-label">Giảng viên</label>
            <input type="text" class="form-control" id="teacher_name" readonly style="background-color: #eee;">
        </div>
        <div class="form-group">
            <label class="form-label">Phòng học</label>
            <input type="text" class="form-control" id="room_name" readonly style="background-color: #eee;">
        </div>

        <div class="form-group">
            <label class="form-label">Thứ <span style="color:red">*</span></label>
            <select class="form-control" name="thu" required>
                <option value="Thứ 2">Thứ 2</option>
                <option value="Thứ 3">Thứ 3</option>
                <option value="Thứ 4">Thứ 4</option>
                <option value="Thứ 5">Thứ 5</option>
                <option value="Thứ 6">Thứ 6</option>
                <option value="Thứ 7">Thứ 7</option>
                <option value="Chủ Nhật">Chủ Nhật</option>
            </select>
        </div>

        <div class="form-group" style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
            <div>
                <label class="form-label">Giờ vào</label>
                <input type="time" class="form-control" name="gio_vao_hoc" required>
            </div>
            <div>
                <label class="form-label">Giờ ra</label>
                <input type="time" class="form-control" name="gio_ra_ve" required>
            </div>
        </div>
        <div class="form-group">
            <label class="form-label">Ngày bắt đầu</label>
            <input type="date" class="form-control" name="ngay_bat_dau" required>
        </div>
        <div class="form-group">
            <label class="form-label">Ngày kết thúc</label>
            <input type="date" class="form-control" name="ngay_ket_thuc" required>
        </div>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn btn-save">
            <i class="fa-solid fa-floppy-disk"></i> Lưu lịch học
        </button>
    </div>
</form>

<script>
function updateClassInfo() {
    const select = document.getElementById('class_id');
    const selectedOption = select.options[select.selectedIndex];
    
    if (select.value !== "") {
        // Điền ID môn học vào input ẩn để lưu
        document.getElementById('id_mon_hoc').value = selectedOption.getAttribute('data-mid');
        
        // Điền thông tin vào các ô readonly để Admin nhìn thấy
        document.getElementById('course_name').value = selectedOption.getAttribute('data-course');
        document.getElementById('teacher_name').value = selectedOption.getAttribute('data-teacher');
        document.getElementById('room_name').value = selectedOption.getAttribute('data-room');
    } else {
        document.getElementById('course_name').value = "";
        document.getElementById('teacher_name').value = "";
        document.getElementById('room_name').value = "";
    }
}
</script>
<script>
    const startInput = document.querySelector('input[name="ngay_bat_dau"]');
    const endInput = document.querySelector('input[name="ngay_ket_thuc"]');

    // Khi thay đổi ngày bắt đầu
    startInput.addEventListener('change', function() {
        if (this.value) {
            // Ngày kết thúc không được phép nhỏ hơn ngày bắt đầu
            endInput.min = this.value;
            
            // Nếu ngày kết thúc hiện tại đang nhỏ hơn ngày bắt đầu mới chọn thì xóa nó đi
            if (endInput.value && endInput.value < this.value) {
                endInput.value = this.value;
            }
        }
    });

    // Kiểm tra thêm một lần nữa khi nhấn Submit
    document.querySelector('form').addEventListener('submit', function(e) {
        if (endInput.value < startInput.value) {
            e.preventDefault();
            alert('Ngày kết thúc không được sớm hơn ngày bắt đầu!');
        }
    });
</script>
</body>
</html>