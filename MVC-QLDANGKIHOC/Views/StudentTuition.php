<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Học phí & Lệ phí - Sinh viên</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', sans-serif; }
        body { display: flex; background-color: #f8f9fa; color: #1a1a2e; min-height: 100vh; }

        /* SIDEBAR */
        .sidebar { 
            width: 260px; background-color: #111c44; color: #fff; 
            display: flex; flex-direction: column; padding: 20px; 
            position: fixed; height: 100vh; z-index: 100;
        }
        .logo { font-size: 1.1rem; font-weight: bold; display: flex; align-items: center; gap: 10px; margin-bottom: 30px; }
        .logo i { background: rgba(255,255,255,0.1); padding: 8px; border-radius: 8px; }
        .student-profile-mini { 
            display: flex; align-items: center; gap: 12px; 
            background: rgba(255,255,255,0.05); padding: 12px; border-radius: 12px; margin-bottom: 25px; 
        }
        .avatar-mini { 
            width: 40px; height: 40px; background: #6d28d9; border-radius: 50%; 
            display: flex; align-items: center; justify-content: center; font-weight: bold; 
        }
        .info-mini h4 { font-size: 0.9rem; }
        .info-mini p { font-size: 0.75rem; color: #a0aec0; }

        .menu-section { 
            font-size: 0.75rem; color: #a0aec0; font-weight: bold; 
            margin: 20px 0 10px; text-transform: uppercase; letter-spacing: 1px; 
        }
        .menu-item { 
            padding: 10px 15px; border-radius: 8px; color: #a0aec0; text-decoration: none; 
            display: flex; align-items: center; gap: 15px; margin-bottom: 5px; 
            transition: 0.3s; font-size: 0.9rem; 
        }
        .menu-item:hover, .menu-item.active { 
            background-color: rgba(255,255,255,0.05); color: #fff; 
        }
        .menu-item.active { 
            background: #1a1b41; border-left: 4px solid #6d28d9; 
        }
        .sign-out { 
            margin-top: auto; padding: 15px; color: #a0aec0; text-decoration: none; 
            display: flex; align-items: center; gap: 15px; font-size: 0.9rem; 
        }

        /* MAIN CONTENT */
        .main-content { margin-left: 260px; flex: 1; padding: 25px 30px; }

        .header { 
            display: flex; justify-content: space-between; align-items: center; 
            margin-bottom: 25px; 
        }
        .header h1 { font-size: 1.6rem; font-weight: 600; }

        /* Top Cards */
        .top-cards { 
            display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; 
            margin-bottom: 30px; 
        }
        .finance-card { 
            background: white; padding: 25px; border-radius: 16px; 
            box-shadow: 0 4px 15px rgba(0,0,0,0.05); position: relative; 
        }
        .card-icon { 
            width: 50px; height: 50px; border-radius: 50%; 
            display: flex; align-items: center; justify-content: center; 
            font-size: 1.3rem; margin-bottom: 15px; 
        }
        .finance-card h2 { font-size: 2rem; margin-bottom: 8px; font-weight: 700; }
        .finance-card p { color: #64748b; font-size: 0.9rem; }

        .card-green .card-icon { background: #ecfdf5; color: #10b981; }
        .card-red .card-icon { background: #fef2f2; color: #ef4444; }
        .card-blue .card-icon { background: #eff6ff; color: #3b82f6; }

        /* Outstanding Banner */
        .outstanding-banner { 
            background: #1e1b4b; color: white; border-radius: 16px; 
            padding: 30px; display: flex; justify-content: space-between; 
            align-items: center; margin-bottom: 35px; 
        }
        .banner-info h1 { font-size: 2.8rem; margin: 8px 0; }
        .btn-pay { 
            background: white; color: #1e1b4b; padding: 14px 28px; 
            border-radius: 12px; font-weight: 700; cursor: pointer; 
            display: flex; align-items: center; gap: 10px; 
        }

        /* Fee List */
        .term-section { 
            background: white; border-radius: 16px; margin-bottom: 25px; 
            box-shadow: 0 4px 15px rgba(0,0,0,0.05); overflow: hidden; 
        }
        .term-header { 
            padding: 18px 25px; background: #f8fafc; 
            display: flex; justify-content: space-between; align-items: center; 
        }
        .fee-item { 
            padding: 20px 25px; border-bottom: 1px solid #f1f5f9; 
            display: flex; justify-content: space-between; align-items: center; 
        }
        .fee-icon { 
            width: 48px; height: 48px; border-radius: 50%; 
            display: flex; align-items: center; justify-content: center; 
            font-size: 1.2rem; margin-right: 15px; 
        }
        .status-badge { 
            padding: 6px 14px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; 
        }
        .fee-amount { font-size: 1.25rem; font-weight: 700; }

        .status-paid { background: #ecfdf5; color: #10b981; }
        .status-unpaid { background: #fef2f2; color: #ef4444; }
    </style>
</head>
<body>

    <!-- SIDEBAR -->
    <div class="sidebar">
        <div class="logo">
            <i class="fa-solid fa-graduation-cap"></i>
            <span>Cổng Sinh viên</span>
        </div>
        <div class="student-profile-mini">
            <div class="avatar-mini"><?= substr(htmlspecialchars($studentProfile['ho_ten'] ?? 'S'), 0, 1); ?></div>
            <div class="info-mini">
                <h4><?= htmlspecialchars($studentProfile['ho_ten'] ?? 'Sinh viên'); ?></h4>
                <p><?= htmlspecialchars($studentProfile['ma_sinh_vien'] ?? ''); ?></p>
            </div>
        </div>

        <div class="menu-section">Tổng quan</div>
        <a href="Index.php?action=student_dashboard" class="menu-item"><i class="fa-solid fa-border-all"></i> Bảng điều khiển</a>

        <div class="menu-section">Học tập</div>
        <a href="Index.php?action=student_course_registration" class="menu-item"><i class="fa-regular fa-square-plus"></i> Đăng ký môn học</a>
        <a href="Index.php?action=student_schedule" class="menu-item"><i class="fa-regular fa-calendar-days"></i> Lịch học của tôi</a>
        <a href="Index.php?action=student_study_program" class="menu-item"><i class="fa-solid fa-graduation-cap"></i> Chương trình học</a>

        <div class="menu-section">Tài chính</div>
        <a href="Index.php?action=student_tuition" class="menu-item "><i class="fa-solid fa-wallet"></i> Học phí & Lệ phí</a>

        <div class="menu-section">Tài khoản</div>
        <a href="Index.php?action=student_settings" class="menu-item"><i class="fa-solid fa-gear"></i> Cài đặt tài khoản</a>
        
        <a href="Index.php?action=logout" class="sign-out">
            <i class="fa-solid fa-arrow-right-from-bracket"></i> Đăng xuất
        </a>
    </div>

    <!-- MAIN CONTENT -->
    <div class="main-content">
        <div class="header">
            <h1>Học phí & Lệ phí</h1>
            <div style="display:flex; gap:15px; font-size:1.2rem; color:#a0aec0;">
                <i class="fa-regular fa-bell"></i>
                <div style="width:35px;height:35px;background:#6d28d9;color:white;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                    <?= substr(htmlspecialchars($studentProfile['ho_ten'] ?? 'S'), 0, 1); ?>
                </div>
            </div>
        </div>

        <!-- Top Cards -->
        <div class="top-cards">
            <div class="finance-card card-green">
                <div class="card-icon"><i class="fa-regular fa-circle-check"></i></div>
                <h2><?= number_format($totalPaid ?? 0, 0, ',', '.') ?> ₫</h2>
                <p>Khoản đã nộp</p>
            </div>

            <div class="finance-card card-red">
                <?php if(($totalUnpaid ?? 0) > 0): ?>
                    <span class="action-needed">Cần thanh toán</span>
                <?php endif; ?>
                <div class="card-icon"><i class="fa-solid fa-circle-exclamation"></i></div>
                <h2><?= number_format($totalUnpaid ?? 0, 0, ',', '.') ?> ₫</h2>
                <p>Khoản chưa nộp</p>
            </div>

            <div class="finance-card card-blue">
                <div class="card-icon" style="background:#eff6ff;color:#3b82f6;">
                    <i class="fa-solid fa-hand-holding-dollar"></i>
                </div>
                <h2 style="color:#1d4ed8;"><?= number_format($totalExempted ?? 0, 0, ',', '.') ?> ₫</h2>
                <p>Khoản được miễn</p>
            </div>
        </div>

        <!-- Outstanding Banner -->
        <div class="outstanding-banner">
            <div class="banner-info">
                <p>Tổng dư nợ hiện tại</p>
                <h1><?= number_format($outstandingBalance ?? 0, 0, ',', '.') ?> ₫</h1>
                <small><?= $unpaidItemsCount ?? 0 ?> khoản chưa thanh toán</small>
            </div>
            <button class="btn-pay" onclick="showQR('<?= number_format($outstandingBalance ?? 0, 0, ',', '.') ?>đ', '<?= htmlspecialchars($studentProfile['ma_sinh_vien'] ?? '') ?>')">
                <i class="fa-regular fa-credit-card"></i> Thanh toán ngay
            </button>
        </div>

        <!-- Danh sách học phí -->
        <?php if (empty($groupedFees)): ?>
            <div style="text-align:center; padding:60px 20px; color:#64748b; background:white; border-radius:16px; box-shadow:0 4px 15px rgba(0,0,0,0.05);">
                <p>Chưa có dữ liệu học phí.</p>
                <p style="font-size:0.9rem; margin-top:10px;">Hãy đăng ký môn học để hệ thống tính học phí tự động.</p>
            </div>
        <?php else: ?>
            <?php foreach($groupedFees as $term => $termFees): 
                $termTotal = array_sum(array_map(fn($f) => ($f['tong_tien'] ?? 0) - ($f['mien_giam'] ?? 0), $termFees));
            ?>
            <div class="term-section">
                <div class="term-header">
                    <h3><?= htmlspecialchars($term) ?></h3>
                    <span>Tổng cộng: <?= number_format($termTotal, 0, ',', '.') ?> ₫</span>
                </div>
                <?php foreach($termFees as $fee): 
                    $actual = ($fee['tong_tien'] ?? 0) - ($fee['mien_giam'] ?? 0);
                    $isPaid = (int)($fee['da_thanh_toan'] ?? 0) === 1;
                ?>
                <div class="fee-item">
                    <div class="fee-info">
                        <div class="fee-icon <?= $isPaid ? '' : 'red' ?>"><i class="fa-solid fa-dollar-sign"></i></div>
                        <div class="fee-details">
                            <h4>Học phí <?= htmlspecialchars($fee['ky_hoc'] ?? 'Học kỳ hiện tại') ?></h4>
                            <p>Giảm trừ: <?= number_format($fee['mien_giam'] ?? 0, 0, ',', '.') ?> ₫</p>
                        </div>
                    </div>
                    <div class="fee-actions">
                        <span class="status-badge <?= $isPaid ? 'status-paid' : 'status-unpaid' ?>">
                            <?= $isPaid ? '<i class="fa-solid fa-check"></i> Đã nộp' : '<i class="fa-solid fa-circle-exclamation"></i> Chưa nộp' ?>
                        </span>
                        <span class="fee-amount"><?= number_format($actual, 0, ',', '.') ?> ₫</span>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- QR Modal -->
    <div id="qrModal" style="display:none;position:fixed;z-index:1000;left:0;top:0;width:100%;height:100%;background:rgba(0,0,0,0.7);align-items:center;justify-content:center;">
        <div style="background:white;padding:30px;border-radius:16px;width:420px;text-align:center;box-shadow:0 10px 30px rgba(0,0,0,0.3);">
            <span onclick="closeQR()" style="float:right;font-size:28px;cursor:pointer;color:#64748b;">×</span>
            <h3>Quét mã QR để thanh toán</h3>
            <p style="margin:15px 0;">Số tiền: <strong id="qrAmount" style="color:#dc2626;"></strong></p>
            <img id="qrImage" src="assets/imgs/qr_payment.jpg" alt="QR" style="width:280px;">
            <div style="margin-top:20px;font-size:0.9rem;background:#f8fafc;padding:15px;border-radius:8px;text-align:left;">
                <p><strong>Chủ TK:</strong> ĐH Công nghệ GTVT</p>
                <p><strong>STK:</strong> 0366828304</p>
                <p><strong>Nội dung:</strong> Hoc phi <span id="qrStudentCode"></span></p>
            </div>
        </div>
    </div>

    <script>
    function showQR(amount, code) {
        document.getElementById('qrAmount').innerText = amount;
        document.getElementById('qrStudentCode').innerText = code;
        document.getElementById('qrModal').style.display = 'flex';
    }
    function closeQR() {
        document.getElementById('qrModal').style.display = 'none';
    }
    </script>
</body>
</html>