<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập Nhật Lớp Học - Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* --- CSS Đồng bộ phong cách --- */
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background-color: #f4f7fe; color: #2b3674; display: flex; justify-content: center; align-items: center; min-height: 100vh; padding: 20px; }

        .form-container { background: #ffffff; width: 100%; max-width: 600px; padding: 40px; border-radius: 20px; box-shadow: 0 10px 40px rgba(139, 92, 246, 0.08); border: 1px solid rgba(226, 232, 240, 0.5); }

        .form-header { display: flex; align-items: center; gap: 15px; margin-bottom: 35px; border-bottom: 1px solid #e2e8f0; padding-bottom: 20px; }
        .form-header-icon { width: 50px; height: 50px; background: #f4f7fe; color: #8b5cf6; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; }
        .form-header h2 { font-size: 1.6rem; font-weight: 700; color: #2b3674; }
        .form-header p { font-size: 0.9rem; color: #a0aec0; }

        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px 25px; margin-bottom: 35px; }
        .input-group { display: flex; flex-direction: column; gap: 8px; }
        .input-group.full-width { grid-column: span 2; }

        .input-group label { font-size: 0.85rem; font-weight: 600; color: #4a5568; display: flex; align-items: center; gap: 8px; }
        .input-group label i { color: #8b5cf6; font-size: 0.9rem; opacity: 0.7; }
        
        .input-group input, .input-group select { width: 100%; padding: 14px 18px; border: 1px solid #e2e8f0; border-radius: 12px; outline: none; background: #ffffff; color: #2d3748; font-size: 0.95rem; transition: all 0.2s ease; }

        /* Style cho ô Readonly (Mã lớp không được sửa) */
        .input-group input[readonly] { 
            background-color: #f8fafc; 
            color: #94a3b8; 
            cursor: not-allowed; 
            border-style: dashed;
            border-color: #cbd5e0;
        }

        .input-group input:focus:not([readonly]), .input-group select:focus { 
            border-color: #8b5cf6; 
            box-shadow: 0 0 0 4px rgba(139, 92, 246, 0.1); 
        }

        .form-actions { display: flex; justify-content: flex-end; gap: 15px; border-top: 1px solid #e2e8f0; padding-top: 25px; }
        .btn { padding: 12px 28px; border-radius: 12px; font-weight: 600; font-size: 0.95rem; cursor: pointer; transition: all 0.2s ease; border: none; display: flex; align-items: center; gap: 8px; text-decoration: none; }
        
        .btn-save { background: #8b5cf6; color: #ffffff; box-shadow: 0 4px 15px rgba(139, 92, 246, 0.2); }
        .btn-save:hover { background: #7c3aed; transform: translateY(-1px); }
        
        .btn-cancel { background: #f8f9fa; color: #4a5568; border: 1px solid #e2e8f0; }
        .btn-cancel:hover { background: #edf2f7; }
    </style>
</head>
<body>

    <div class="form-container">
        <div class="form-header">
            <div class="form-header-icon"><i class="fa-solid fa-pen-to-square"></i></div>
            <div>
                <h2>Cập Nhật Lớp Học</h2>
                <p>Chỉnh sửa thông tin lớp: <strong><?php echo htmlspecialchars($class['ma_lop_hoc']); ?></strong></p>
            </div>
        </div>

        <form action="Index.php?action=update_class" method="POST">
            <div class="form-grid">
                
                <div class="input-group full-width">
                    <label><i class="fa-solid fa-lock"></i> Mã lớp học (Khóa hệ thống)</label>
                    <input type="text" name="class_name" value="<?php echo htmlspecialchars($class['ma_lop_hoc']); ?>" readonly>
                </div>

                <div class="input-group">
    <label for="course_id"><i class="fa-solid fa-book"></i> Môn học</label>
    <select id="course_id" name="id_mon_hoc" required>
        <option value="">-- Chọn môn học --</option>
        <?php foreach ($subjects as $s): ?>
            <option value="<?php echo $s['id_mon_hoc']; ?>" 
                <?php echo ($s['id_mon_hoc'] == $class['id_mon_hoc']) ? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($s['ten_mon_hoc']); ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>

                <div class="input-group">
                    <label for="instructor"><i class="fa-solid fa-chalkboard-user"></i> Giảng viên</label>
                    <input type="text" id="instructor" name="instructor" 
                           value="<?php echo htmlspecialchars($class['ten_giang_vien']); ?>" required>
                </div>

                <div class="input-group">
                    <label for="room"><i class="fa-solid fa-location-dot"></i> Phòng học</label>
                    <input type="text" id="room" name="room" 
                           value="<?php echo htmlspecialchars($class['phong_hoc']); ?>" required>
                </div>

                <div class="input-group">
                    <label for="capacity"><i class="fa-solid fa-user-check"></i> Sĩ số tối đa</label>
                    <input type="number" id="capacity" name="capacity" 
                           value="<?php echo htmlspecialchars($class['si_so_toi_da']); ?>" required>
                </div>

                <div class="input-group">
                    <label for="enrolled"><i class="fa-solid fa-users"></i> Đã đăng ký</label>
                    <input type="number" id="enrolled" name="enrolled" 
                           value="<?php echo htmlspecialchars($class['si_so_da_dang_ky']); ?>">
                </div>
            </div>

            <div class="form-actions">
                <a href="Index.php?action=classes" class="btn btn-cancel"><i class="fa-solid fa-xmark"></i> Hủy bỏ</a>
                <button type="submit" class="btn btn-save"><i class="fa-solid fa-floppy-disk"></i> Lưu thay đổi</button>
            </div>
        </form>
    </div>

</body>
</html>