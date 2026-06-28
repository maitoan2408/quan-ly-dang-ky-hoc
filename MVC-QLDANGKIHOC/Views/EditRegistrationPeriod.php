<style>
    /* CSS đồng bộ theo phong cách Dashboard EduManage */
    .main-content { padding: 20px; background: #f8fbff; min-height: 100vh; }
    
    .edit-container {
        max-width: 850px;
        margin: 0 auto;
        background: white;
        padding: 40px;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(112, 144, 176, 0.1);
    }

    .form-header {
        display: flex;
        align-items: center;
        gap: 20px;
        margin-bottom: 35px;
        border-bottom: 2px solid #f4f7fe;
        padding-bottom: 20px;
    }

    .header-icon-box {
        width: 56px;
        height: 56px;
        background: #eef2ff;
        color: #4318ff;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .form-header h2 { color: #1b2559; font-size: 1.5rem; font-weight: 700; margin: 0; }
    .form-header p { color: #a3aed0; font-size: 0.9rem; margin: 5px 0 0 0; }

    .grid-form {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 25px;
    }

    .full-width { grid-column: span 2; }

    .form-group { display: flex; flex-direction: column; gap: 8px; }

    .form-group label {
        font-size: 0.85rem;
        font-weight: 700;
        color: #2b3674;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .form-group label i { color: #4318ff; width: 16px; }

    .form-group input, .form-group select {
        padding: 12px 16px;
        border-radius: 14px;
        border: 1px solid #d1d9e8;
        color: #2b3674;
        font-size: 0.95rem;
        transition: 0.3s;
        outline: none;
    }

    .form-group input:focus {
        border-color: #4318ff;
        box-shadow: 0 0 0 4px rgba(67, 24, 255, 0.1);
    }

    .edit-footer {
        margin-top: 40px;
        display: flex;
        justify-content: flex-end;
        gap: 15px;
    }

    .btn-cancel {
        padding: 12px 25px;
        border-radius: 12px;
        border: none;
        background: #f4f7fe;
        color: #707eae;
        font-weight: 700;
        cursor: pointer;
        transition: 0.3s;
    }

    .btn-submit {
        padding: 12px 30px;
        border-radius: 12px;
        border: none;
        background: linear-gradient(135deg, #868cff 0%, #4318ff 100%);
        color: white;
        font-weight: 700;
        cursor: pointer;
        box-shadow: 0 4px 14px rgba(67, 24, 255, 0.3);
        transition: 0.3s;
    }

    .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(67, 24, 255, 0.4); }

    .alert-error {
        display: none;
        align-items: center;
        gap: 10px;
        background: #fff5f5;
        color: #ff4d4f;
        padding: 15px;
        border-radius: 12px;
        margin-bottom: 25px;
        border: 1px solid #ffccc7;
    }
</style>

<div class="main-content">
    <div class="edit-container">
        <div class="form-header">
            <div class="header-icon-box">
                <i class="fa-solid fa-pen-to-square"></i>
            </div>
            <div>
                <h2>Chỉnh sửa kỳ đăng ký</h2>
                <p>Cập nhật thông tin cho: <strong><?php echo htmlspecialchars($period['ten_ky_hoc']); ?></strong></p>
            </div>
        </div>

        <div id="js-error-box" class="alert-error">
            <i class="fa-solid fa-circle-exclamation"></i> 
            <span id="js-error-text"></span>
        </div>

        <form action="Index.php?action=process_update_period&id=<?php echo $period['id_ky_hoc']; ?>" method="POST" class="grid-form">
            
            <div class="form-group full-width">
                <label><i class="fa-solid fa-file-signature"></i> Tên kỳ học</label>
                <input type="text" name="ten_ky_hoc" value="<?php echo htmlspecialchars($period['ten_ky_hoc']); ?>" required>
            </div>

            <div class="form-group">
                <label><i class="fa-regular fa-clock"></i> Thời gian bắt đầu</label>
                <input type="datetime-local" name="thoi_gian_bat_dau" value="<?php echo date('Y-m-d\TH:i', strtotime($period['thoi_gian_bat_dau'])); ?>" required>
            </div>

            <div class="form-group">
                <label><i class="fa-solid fa-hourglass-end"></i> Thời gian kết thúc</label>
                <input type="datetime-local" name="thoi_gian_ket_thuc" value="<?php echo date('Y-m-d\TH:i', strtotime($period['thoi_gian_ket_thuc'])); ?>" required>
            </div>

            <div class="form-group">
                <label><i class="fa-solid fa-minus-circle"></i> Tín chỉ tối thiểu</label>
                <input type="number" name="tin_chi_toi_thieu" value="<?php echo $period['tin_chi_toi_thieu']; ?>">
            </div>

            <div class="form-group">
                <label><i class="fa-solid fa-plus-circle"></i> Tín chỉ tối đa</label>
                <input type="number" name="tin_chi_toi_da" value="<?php echo $period['tin_chi_toi_da']; ?>">
            </div>

            <div class="form-group full-width">
    <label><i class="fa-solid fa-circle-dot"></i> Trạng thái</label>
    <select name="trang_thai_dang_ky" required>
        <option value="Sắp tới" 
            <?php echo ($period['trang_thai_dang_ky'] == 'Sắp tới') ? 'selected' : ''; ?>>
            Sắp tới
        </option>
        <option value="Đang mở" 
            <?php echo ($period['trang_thai_dang_ky'] == 'Đang mở') ? 'selected' : ''; ?>>
            Đang mở
        </option>
        <option value="Đã đóng" 
            <?php echo ($period['trang_thai_dang_ky'] == 'Đã đóng') ? 'selected' : ''; ?>>
            Đã đóng
        </option>
    </select>
</div>
            <div class="edit-footer full-width">
                <button type="button" class="btn-cancel" onclick="location.href='Index.php?action=registration_periods'">Hủy bỏ</button>
                <button type="submit" class="btn-submit">
                    <i class="fa-solid fa-floppy-disk"></i> Cập nhật thay đổi
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.querySelector('.grid-form').onsubmit = function(e) {
    const batDau = new Date(document.getElementsByName('thoi_gian_bat_dau')[0].value);
    const ketThuc = new Date(document.getElementsByName('thoi_gian_ket_thuc')[0].value);
    const tcMin = parseInt(document.getElementsByName('tin_chi_toi_thieu')[0].value) || 0;
    const tcMax = parseInt(document.getElementsByName('tin_chi_toi_da')[0].value) || 0;
    
    const errorBox = document.getElementById('js-error-box');
    const errorText = document.getElementById('js-error-text');

    // Reset lỗi cũ
    errorBox.style.display = 'none';

    if (ketThuc <= batDau) {
        errorText.innerText = "Lỗi: Thời gian kết thúc phải diễn ra sau thời gian bắt đầu!";
        errorBox.style.display = 'flex';
        e.preventDefault();
        window.scrollTo({ top: 0, behavior: 'smooth' });
        return false;
    }

    if (tcMax < tcMin) {
        errorText.innerText = "Lỗi: Tín chỉ tối đa không được nhỏ hơn tín chỉ tối thiểu!";
        errorBox.style.display = 'flex';
        e.preventDefault();
        return false;
    }
    return true;
};
</script>