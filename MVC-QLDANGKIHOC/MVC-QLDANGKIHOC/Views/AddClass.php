<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Lớp Học Mới - Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* --- CSS Nền & Font --- */
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background-color: #f4f7fe; color: #2b3674; display: flex; justify-content: center; align-items: center; min-height: 100vh; padding: 20px; }

        /* --- CONTAINER CHÍNH CỦA FORM --- */
        .form-container { background: #ffffff; width: 100%; max-width: 600px; padding: 40px; border-radius: 20px; box-shadow: 0 10px 40px rgba(139, 92, 246, 0.08); border: 1px solid rgba(226, 232, 240, 0.5); }

        /* --- TIÊU ĐỀ FORM --- */
        .form-header { display: flex; align-items: center; gap: 15px; margin-bottom: 35px; border-bottom: 1px solid #e2e8f0; padding-bottom: 20px; }
        .form-header-icon { width: 50px; height: 50px; background: #f4f7fe; color: #8b5cf6; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; }
        .form-header h2 { font-size: 1.6rem; font-weight: 700; color: #2b3674; }
        .form-header p { font-size: 0.9rem; color: #a0aec0; margin-top: 2px; }

        /* --- BỐ CỤC Ô NHẬP LIỆU --- */
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px 25px; margin-bottom: 35px; }
        .input-group { display: flex; flex-direction: column; gap: 8px; }
        
        /* Khi muốn ô nhập kéo dài hết chiều rộng */
        .input-group.full-width { grid-column: span 2; }

        /* --- NHÃN & Ô NHẬP LIỆU --- */
        .input-group label { font-size: 0.85rem; font-weight: 600; color: #4a5568; display: flex; align-items: center; gap: 8px; }
        .input-group label i { color: #8b5cf6; font-size: 0.9rem; opacity: 0.7; }
        
        .input-group input, .input-group select { width: 100%; padding: 14px 18px; border: 1px solid #e2e8f0; border-radius: 12px; outline: none; background: #ffffff; color: #2d3748; font-size: 0.95rem; transition: all 0.2s ease; }

        /* Hiệu ứng khi Click vào ô nhập */
        .input-group input:focus, .input-group select:focus { border-color: #8b5cf6; background: #ffffff; box-shadow: 0 0 0 4px rgba(139, 92, 246, 0.1); }
        
        /* Placeholder màu nhạt hơn */
        .input-group input::placeholder { color: #cbd5e0; font-style: italic; }

        /* Tùy chỉnh Select Box */
        .input-group select { cursor: pointer; appearance: none; -webkit-appearance: none; background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23a0aec0%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat: no-repeat; background-position: right 18px top 50%; background-size: 12px auto; padding-right: 45px; }

        /* --- NÚT BẤM --- */
        .form-actions { display: flex; justify-content: flex-end; gap: 15px; border-top: 1px solid #e2e8f0; padding-top: 25px; }
        
        .btn { padding: 12px 28px; border-radius: 12px; font-weight: 600; font-size: 0.95rem; cursor: pointer; transition: all 0.2s ease; border: none; display: flex; align-items: center; gap: 8px; }
        
        /* Nút Lưu (Màu tím) */
        .btn-save { background: #8b5cf6; color: #ffffff; box-shadow: 0 4px 15px rgba(139, 92, 246, 0.2); }
        .btn-save:hover { background: #7c3aed; transform: translateY(-1px); box-shadow: 0 6px 20px rgba(139, 92, 246, 0.3); }
        
        /* Nút Hủy (Màu trắng xám) */
        .btn-cancel { background: #f8f9fa; color: #4a5568; border: 1px solid #e2e8f0; text-decoration: none; }
        .btn-cancel:hover { background: #edf2f7; color: #2d3748; }

        /* --- RESPONSIVE (Cho điện thoại) --- */
        @media (max-width: 600px) { .form-container { padding: 25px; } .form-grid { grid-template-columns: 1fr; gap: 15px; } .form-actions { flex-direction: column-reverse; } .btn { width: 100%; justify-content: center; } }
        /* Thêm một chút CSS cho trạng thái lỗi của ô nhập */
        .input-error {
            border-color: #e53e3e !important;
            background-color: #fff5f5 !important;
            box-shadow: 0 0 0 4px rgba(229, 62, 62, 0.1) !important;
        }
        .error-text {
            color: #e53e3e;
            font-size: 0.75rem;
            margin-top: 4px;
            display: none; /* Ẩn mặc định */
        }
    </style>
</head>
<body>

    <div class="form-container">
        <div class="form-header">
            <div class="form-header-icon"><i class="fa-solid fa-users-rectangle"></i></div>
            <div>
                <h2>Thêm Lớp Học Mới</h2>
                <p>Vui lòng nhập đầy đủ thông tin bên dưới để tạo lớp học.</p>
            </div>
        </div>

        <?php if (isset($_GET['error']) && $_GET['error'] === 'duplicate_code'): ?>
            <div style="background: #fff5f5; color: #e53e3e; padding: 15px; border-radius: 12px; margin-bottom: 25px; border: 1px solid #feb2b2; display: flex; align-items: center; gap: 10px; font-size: 0.9rem;">
                <i class="fa-solid fa-circle-exclamation"></i>
                <span>Mã lớp <strong><?php echo htmlspecialchars($_GET['code']); ?></strong> đã tồn tại!</span>
            </div>
        <?php endif; ?>

        <form action="Index.php?action=store_class" method="POST" id="addClassForm">
            <div class="form-grid">
                
                <div class="input-group full-width">
                    <label for="class_name"><i class="fa-solid fa-id-card"></i> Mã lớp học</label>
                    <input type="text" id="class_name" name="class_name" required placeholder="Ví dụ: LH1" autocomplete="off">
                    <span id="js_error_msg" class="error-text">Mã lớp này đã có trong danh sách hiển thị!</span>
                </div>

                <div class="input-group">
                    <label for="course_name"><i class="fa-solid fa-book"></i> Môn học</label>
                    <select id="course_name" name="course_name" required>
                        <option value="" disabled selected>-- Chọn môn học --</option>
                        <?php if (isset($subjects) && !empty($subjects)): ?>
                            <?php foreach ($subjects as $s): ?>
                                <option value="<?php echo htmlspecialchars($s['ten_mon_hoc']); ?>">
                                    <?php echo htmlspecialchars($s['ten_mon_hoc']); ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <div class="input-group">
                    <label for="instructor"><i class="fa-solid fa-chalkboard-user"></i> Giảng viên</label>
                    <input type="text" id="instructor" name="instructor" required placeholder="Tên giảng viên">
                </div>

                <div class="input-group">
                    <label for="room"><i class="fa-solid fa-location-dot"></i> Phòng học</label>
                    <input type="text" id="room" name="room" required placeholder="Ví dụ: A3.201">
                </div>

                <div class="input-group">
                    <label for="capacity"><i class="fa-solid fa-user-check"></i> Sĩ số tối đa</label>
                    <input type="number" id="capacity" name="capacity" required placeholder="0">
                </div>

                <div class="input-group">
                    <label for="enrolled"><i class="fa-solid fa-users"></i> Đã đăng ký</label>
                    <input type="number" id="enrolled" name="enrolled" value="0">
                </div>
            </div>

            <div class="form-actions">
                <a href="Index.php?action=classes" class="btn btn-cancel"><i class="fa-solid fa-xmark"></i> Hủy bỏ</a>
                <button type="submit" class="btn btn-save" id="btnSubmit"><i class="fa-solid fa-cloud-arrow-up"></i> Lưu lớp học</button>
            </div>
        </form>
    </div>

    <script>
        // 1. Lấy danh sách các mã lớp hiện có từ dữ liệu đã nạp ở trang quản lý
        // Lưu ý: Controller cần truyền biến $classes sang View này
        const existingCodes = <?php echo isset($classes) ? json_encode(array_column($classes, 'ma_lop_hoc')) : '[]'; ?>;

        const inputCode = document.getElementById('class_name');
        const errorMsg = document.getElementById('js_error_msg');
        const btnSubmit = document.getElementById('btnSubmit');

        // 2. Kiểm tra ngay khi người dùng nhập (Real-time)
        inputCode.addEventListener('input', function() {
            const val = this.value.trim().toUpperCase(); // Chuyển in hoa cho đồng nhất
            
            if (existingCodes.includes(val)) {
                // Hiển thị lỗi
                this.classList.add('input-error');
                errorMsg.style.display = 'block';
                btnSubmit.disabled = true;
                btnSubmit.style.opacity = '0.6';
                btnSubmit.style.cursor = 'not-allowed';
            } else {
                // Xóa lỗi
                this.classList.remove('input-error');
                errorMsg.style.display = 'none';
                btnSubmit.disabled = false;
                btnSubmit.style.opacity = '1';
                btnSubmit.style.cursor = 'pointer';
            }
        });
    </script>
</body>

</html>