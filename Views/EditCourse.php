<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chỉnh sửa môn học</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Tận dụng lại Style của bạn */
        body { background-color: #f4f7fe; color: #2b3674; font-family: 'Segoe UI', sans-serif; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }
        .edit-container { background: white; padding: 30px; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); width: 100%; max-width: 500px; }
        .header { display: flex; align-items: center; gap: 15px; margin-bottom: 25px; border-bottom: 1px solid #e2e8f0; padding-bottom: 15px; }
        .header i { background: #f4f7fe; color: #4318ff; padding: 10px; border-radius: 10px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; font-size: 0.9rem; font-weight: 600; margin-bottom: 8px; }
        .form-group input, .form-group select { width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 10px; outline: none; box-sizing: border-box; }
        .form-group input:read-only { background-color: #f8f9fa; color: #a0aec0; cursor: not-allowed; }
        .actions { display: flex; justify-content: flex-end; gap: 12px; margin-top: 25px; }
        .btn { padding: 12px 25px; border-radius: 10px; font-weight: 600; cursor: pointer; border: none; text-decoration: none; font-size: 0.9rem; }
        .btn-cancel { background: #f4f7fe; color: #2b3674; }
        .btn-submit { background: #4318ff; color: white; }
    </style>
</head>
<body>

<div class="edit-container">
    <div class="header">
        <i class="fa-solid fa-pen-to-square"></i>
        <h2>Chỉnh sửa môn học</h2>
    </div>

    <form action="Index.php?action=update_course" method="POST">
        <div class="form-group">
            <label>Mã môn học (Không được sửa)</label>
            <input type="text" name="ma_mon_hoc" value="<?php echo htmlspecialchars($course['ma_mon_hoc']); ?>" readonly>
        </div>

        <div class="form-group">
            <label>Tên môn học</label>
            <input type="text" name="ten_mon_hoc" value="<?php echo htmlspecialchars($course['ten_mon_hoc']); ?>" required>
        </div>

        <div class="form-group">
            <label>Số tín chỉ</label>
            <input type="number" name="so_tin_chi" value="<?php echo $course['so_tin_chi']; ?>" min="1" max="10" required>
        </div>

        <div class="form-group">
            <label>Chương trình đào tạo</label>
            <input type="text" name="chuong_trinh_hoc" value="<?php echo htmlspecialchars($course['chuong_trinh_hoc']); ?>" required>
        </div>

        <div class="actions">
            <a href="Index.php?action=courses" class="btn btn-cancel">Hủy bỏ</a>
            <button type="submit" class="btn btn-submit">Cập nhật thay đổi</button>
        </div>
    </form>
</div>

</body>
</html>