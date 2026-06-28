<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa lịch học</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', sans-serif; }
        body { background-color: #f4f7fe; color: #2b3674; display: flex; justify-content: center; align-items: center; min-height: 100vh; padding: 20px; }
        
        .container { background: white; width: 100%; max-width: 600px; padding: 30px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
        .header { display: flex; align-items: center; gap: 15px; margin-bottom: 25px; border-bottom: 2px solid #f4f7fe; padding-bottom: 15px; }
        .header i { font-size: 1.5rem; color: #4318ff; background: #f4f7fe; padding: 12px; border-radius: 12px; }
        .header h2 { font-size: 1.4rem; color: #1b2559; }

        .form-group { margin-bottom: 18px; }
        .form-group label { display: block; font-size: 0.9rem; font-weight: 600; margin-bottom: 8px; color: #a3aed0; }
        .form-control { 
            width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #d1d9e6; 
            font-size: 0.95rem; color: #2b3674; transition: 0.3s; 
        }
        .form-control:focus { outline: none; border-color: #4318ff; box-shadow: 0 0 0 3px rgba(67, 24, 255, 0.1); }
        
        .row { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
        
        .btn-container { display: flex; gap: 10px; margin-top: 25px; }
        .btn { flex: 1; padding: 12px; border-radius: 12px; font-weight: 600; cursor: pointer; border: none; transition: 0.3s; text-decoration: none; text-align: center; font-size: 0.95rem; }
        .btn-save { background: #4318ff; color: white; }
        .btn-save:hover { background: #3311cc; }
        .btn-cancel { background: #f4f7fe; color: #a3aed0; }
        .btn-cancel:hover { background: #e2e8f0; color: #2b3674; }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <i class="fa-solid fa-calendar-check"></i>
        <h2>Chỉnh sửa lịch học</h2>
    </div>

    <form action="Index.php?action=process_update_schedule" method="POST">
        
        <input type="hidden" name="id_lich_hoc" value="<?= $schedule['id_lich_hoc'] ?>">

        <div class="form-group">
            <label>Lớp học & Môn học</label>
            <select name="id_lop_hoc" id="classSelect" class="form-control" required>
                <?php foreach ($all_classes as $class): ?>
                    <option value="<?= $class['id_lop_hoc'] ?>" 
                            data-mon="<?= $class['id_mon_hoc'] ?>"
                            <?= $class['id_lop_hoc'] == $schedule['id_lop_hoc'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($class['ma_lop_hoc']) ?> - <?= htmlspecialchars($class['ten_mon_hoc']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <input type="hidden" name="id_mon_hoc" id="id_mon_hoc" value="<?= $schedule['id_mon_hoc'] ?>">

        <div class="form-group">
            <label>Thứ trong tuần</label>
            <select name="thu" class="form-control" required>
                <?php 
                $days = ['Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7', 'Chủ Nhật'];
                foreach ($days as $day): 
                ?>
                    <option value="<?= $day ?>" <?= $day == $schedule['thu'] ? 'selected' : '' ?>><?= $day ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="row">
            <div class="form-group">
                <label>Giờ vào học</label>
                <input type="time" name="gio_vao_hoc" class="form-control" value="<?= $schedule['gio_vao_hoc'] ?>" required>
            </div>
            <div class="form-group">
                <label>Giờ ra về</label>
                <input type="time" name="gio_ra_ve" class="form-control" value="<?= $schedule['gio_ra_ve'] ?>" required>
            </div>
        </div>

        <div class="row">
            <div class="form-group">
                <label>Ngày bắt đầu áp dụng</label>
                <input type="date" name="ngay_bat_dau" class="form-control" value="<?= $schedule['ngay_bat_dau'] ?>" required>
            </div>
            <div class="form-group">
                <label>Ngày kết thúc dự kiến</label>
                <input type="date" name="ngay_ket_thuc" class="form-control" value="<?= $schedule['ngay_ket_thuc'] ?>" required>
            </div>
        </div>

        <div class="btn-container">
            <a href="Index.php?action=schedules" class="btn btn-cancel">Hủy bỏ</a>
            <button type="submit" class="btn btn-save">Cập nhật thay đổi</button>
        </div>
    </form>
</div>

<script>
    // Tự động cập nhật id_mon_hoc khi thay đổi lớp học
    const classSelect = document.getElementById('classSelect');
    const monInput = document.getElementById('id_mon_hoc');

    classSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        monInput.value = selectedOption.getAttribute('data-mon');
    });
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