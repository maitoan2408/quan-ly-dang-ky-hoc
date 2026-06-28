<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm môn học mới</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Tận dụng lại Style của bạn */
        body { background-color: #f4f7fe; color: #2b3674; font-family: 'Segoe UI', sans-serif; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }
        .main-content { width: 100%; max-width: 700px; padding: 20px; }
        .header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; }
        .header h1 { font-size: 1.8rem; font-weight: 700; }
        .btn-back { background: #f4f7fe; color: #4318ff; padding: 10px 15px; border-radius: 8px; display: flex; align-items: center; gap: 5px; }
        .btn-back:hover { background: #e2e8f0; }
    </style>
</head>
<body>
<div class="main-content">
    <div class="header">
        <h1>Thêm Môn Học Mới</h1>
        <a href="Index.php?action=courses" class="btn-back" style="text-decoration: none; color: #4318ff;">
            <i class="fa-solid fa-arrow-left"></i> Quay lại danh sách
        </a>
    </div>

    <div class="form-container" style="background: white; padding: 30px; border-radius: 16px; margin-top: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); max-width: 600px;">
        <form action="Index.php?action=store_course" method="POST">
            <div style="margin-bottom: 20px;">
                <label style="display:block; margin-bottom:8px; font-weight:600;">Mã môn học</label>
                <input type="text" name="ma_mon_hoc" required placeholder="VD: IT3010" style="width:100%; padding:12px; border:1px solid #e2e8f0; border-radius:8px;">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display:block; margin-bottom:8px; font-weight:600;">Tên môn học</label>
                <input type="text" name="ten_mon_hoc" required placeholder="VD: Lập trình Web" style="width:100%; padding:12px; border:1px solid #e2e8f0; border-radius:8px;">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display:block; margin-bottom:8px; font-weight:600;">Số tín chỉ</label>
                <input type="number" name="so_tin_chi" required min="1" max="10" style="width:100%; padding:12px; border:1px solid #e2e8f0; border-radius:8px;">
            </div>

            <div style="margin-bottom: 25px;">
                <label style="display:block; margin-bottom:8px; font-weight:600;">Chương trình đào tạo</label>
                <input type="text" name="chuong_trinh_hoc" list="list_chuong_trinh" required placeholder="Nhập hoặc chọn chương trình học" style="width:100%; padding:12px; border:1px solid #e2e8f0; border-radius:8px;">
                
                <datalist id="list_chuong_trinh">
                    <option value="Kỹ thuật phần mềm">
                    <option value="Hệ thống thông tin">
                    <option value="Khoa học máy tính">
                    <option value="Ngoại ngữ">
                    <option value="Kinh tế đầu tư">
                </datalist>
            </div>

            <div style="display: flex; gap: 10px;">
                <button type="submit" style="background:#4318ff; color:white; padding:12px 25px; border:none; border-radius:8px; font-weight:600; cursor:pointer;">
                    Lưu môn học
                </button>
                <a href="Index.php?action=courses" style="background:#f4f7fe; color:#2b3674; padding:12px 25px; border-radius:8px; text-decoration:none; font-weight:600;">Hủy bỏ</a>
            </div>
        </form>
    </div>
</div>
</body>
</html>