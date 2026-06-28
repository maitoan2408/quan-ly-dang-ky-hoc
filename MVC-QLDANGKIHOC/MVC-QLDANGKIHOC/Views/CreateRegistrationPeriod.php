<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tạo kỳ đăng ký mới - Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .registration-form-card {
            background: #ffffff;
            padding: 40px;
            border-radius: 24px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.05);
            max-width: 900px;
            margin: 20px auto;
        }
        .alert-error {
            display: none;
            background: #fff5f5;
            color: #ff4d4f;
            padding: 16px;
            border-radius: 14px;
            border: 1px solid #ffccc7;
            margin-bottom: 25px;
            align-items: center;
            gap: 12px;
            font-weight: 600;
            animation: slideDown 0.3s ease;
        }
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .form-header-box { display: flex; align-items: center; gap: 20px; margin-bottom: 35px; border-bottom: 1px solid #f1f4f9; padding-bottom: 20px; }
        .header-icon { width: 60px; height: 60px; background: #eef2ff; color: #4318ff; display: flex; align-items: center; justify-content: center; border-radius: 16px; font-size: 1.5rem; }
        .header-titles h2 { color: #2b3674; font-size: 1.6rem; margin: 0; }
        .header-titles p { color: #a3aed0; margin: 5px 0 0 0; }
        .form-row { display: flex; gap: 25px; margin-bottom: 25px; }
        .form-group { flex: 1; display: flex; flex-direction: column; }
        .form-group label { font-weight: 700; color: #2b3674; margin-bottom: 10px; font-size: 0.95rem; display: flex; align-items: center; gap: 8px; }
        .form-group input, .form-group select {
            padding: 14px 18px;
            border: 1px solid #e0e5f2;
            border-radius: 14px;
            font-size: 1rem;
            color: #2b3674;
            transition: all 0.2s ease;
        }
        .form-group input:focus, .form-group select:focus {
            outline: none;
            border-color: #4318ff;
            background-color: #f8faff;
            box-shadow: 0 0 0 4px rgba(67, 24, 255, 0.08);
        }
        .form-footer { display: flex; justify-content: flex-end; gap: 15px; margin-top: 40px; padding-top: 25px; border-top: 1px solid #f1f4f9; }
        .btn-save { background: #4318ff; color: white; padding: 14px 35px; border: none; border-radius: 14px; font-weight: 700; cursor: pointer; transition: 0.3s; display: flex; align-items: center; gap: 10px; }
        .btn-save:hover { background: #3311db; transform: translateY(-2px); box-shadow: 0 8px 16px rgba(67, 24, 255, 0.2); }
        .btn-back { background: #f4f7fe; color: #2b3674; padding: 14px 35px; border: none; border-radius: 14px; font-weight: 600; cursor: pointer; }
    </style>
</head>
<body>

<div class="main-content">
    <div class="registration-form-card">
        <div class="form-header-box">
            <div class="header-icon"><i class="fa-solid fa-calendar-plus"></i></div>
            <div class="header-titles">
                <h2>Tạo kỳ đăng ký học mới</h2>
                <p>Thiết lập thời gian và giới hạn tín chỉ cho sinh viên</p>
            </div>
        </div>

        <div id="js-error-box" class="alert-error">
            <i class="fa-solid fa-circle-exclamation"></i>
            <span id="js-error-text"></span>
        </div>

        <form action="Index.php?action=process_create_period" method="POST" id="createForm" class="modern-form">
            
            <div class="form-group full-width" style="margin-bottom: 25px;">
                <label><i class="fa-solid fa-pen-to-square"></i> Tên kỳ học</label>
                <input type="text" name="ten_ky_hoc" placeholder="VD: Học kỳ 1 năm học 2026-2027" required>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label><i class="fa-regular fa-clock"></i> Thời gian bắt đầu</label>
                    <input type="datetime-local" name="thoi_gian_bat_dau" required>
                </div>
                <div class="form-group">
                    <label><i class="fa-solid fa-hourglass-end"></i> Thời gian kết thúc</label>
                    <input type="datetime-local" name="thoi_gian_ket_thuc" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label><i class="fa-solid fa-minus"></i> Tín chỉ tối thiểu</label>
                    <input type="number" name="tin_chi_toi_thieu" value="12" min="1">
                </div>
                <div class="form-group">
                    <label><i class="fa-solid fa-plus"></i> Tín chỉ tối đa</label>
                    <input type="number" name="tin_chi_toi_da" value="25" min="1">
                </div>
                <div class="form-group">
                    <label><i class="fa-solid fa-circle-dot"></i> Trạng thái mặc định</label>
                    <select name="trang_thai_dang_ky" id="statusSelect" style="padding: 14px; border-radius: 14px; border: 1px solid #e0e5f2; color: #2b3674; font-weight: 600;">
                        <option value="Sắp tới">Sắp tới</option>
                        <option value="Đang mở">Đang mở</option>
                        <option value="Đã đóng">Đã đóng</option>
                    </select>
                </div>
            </div>

            <!-- Hidden field gửi quyết định copy lớp -->
            <input type="hidden" name="copy_classes_from_old" id="copyClasses" value="0">

            <div class="form-footer">
                <button type="button" class="btn-back" onclick="history.back()">Quay lại</button>
                <button type="submit" class="btn-save">
                    <i class="fa-solid fa-check"></i> Lưu kỳ học
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Xác nhận copy lớp khi chọn "Đang mở"
document.getElementById('createForm').addEventListener('submit', function(e) {
    const status = document.getElementById('statusSelect').value;

    if (status === 'Đang mở') {
        const confirmMsg = "Bạn có muốn chuyển tất cả lớp học từ kỳ cũ sang kỳ mới không?\n\n" +
                          "(Lớp cũ sẽ được copy sang kỳ mới và reset số sinh viên đăng ký về 0)";

        if (confirm(confirmMsg)) {
            document.getElementById('copyClasses').value = '1';
        } else {
            document.getElementById('copyClasses').value = '0';
        }
    }
});

// Validation thời gian và tín chỉ
document.querySelector('.modern-form').onsubmit = function(e) {
    const batDauVal = document.getElementsByName('thoi_gian_bat_dau')[0].value;
    const ketThucVal = document.getElementsByName('thoi_gian_ket_thuc')[0].value;
    const tcMin = parseInt(document.getElementsByName('tin_chi_toi_thieu')[0].value) || 0;
    const tcMax = parseInt(document.getElementsByName('tin_chi_toi_da')[0].value) || 0;

    const errorBox = document.getElementById('js-error-box');
    const errorText = document.getElementById('js-error-text');

    errorBox.style.display = 'none';

    if (new Date(ketThucVal) <= new Date(batDauVal)) {
        errorText.innerText = "Lỗi: Thời gian kết thúc không thể bé hơn hoặc bằng thời gian bắt đầu!";
        errorBox.style.display = 'flex';
        e.preventDefault();
        window.scrollTo({ top: 0, behavior: 'smooth' });
        return false;
    }

    if (tcMax < tcMin) {
        errorText.innerText = "Lỗi: Tín chỉ tối đa phải lớn hơn hoặc bằng tín chỉ tối thiểu!";
        errorBox.style.display = 'flex';
        e.preventDefault();
        window.scrollTo({ top: 0, behavior: 'smooth' });
        return false;
    }
    return true;
};
</script>
</body>
</html>