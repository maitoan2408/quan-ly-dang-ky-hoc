<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - Hệ thống Đăng ký học</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* GIỮ NGUYÊN CSS CŨ CỦA BẠN Ở ĐÂY - Mình lược bớt cho ngắn gọn */
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { display: flex; min-height: 100vh; background-color: #f8f9fa; }
        .hero-section { flex: 1; background: radial-gradient(circle at center, #2e286d 0%, #151336 100%); color: white; padding: 4rem; display: flex; flex-direction: column; justify-content: center; position: relative; overflow: hidden; }
        .hero-section::before { content: ''; position: absolute; top: -10%; right: -10%; width: 600px; height: 600px; background: rgba(255, 255, 255, 0.03); border-radius: 50%; }
        .logo { display: flex; align-items: center; gap: 10px; font-weight: bold; font-size: 1.2rem; margin-bottom: 4rem; z-index: 1;}
        .logo i { background: rgba(255,255,255,0.1); padding: 8px; border-radius: 8px; }
        .logo span { font-size: 0.8rem; font-weight: normal; color: #a5a5c9; display: block; }
        .hero-title { font-size: 3rem; font-weight: 700; line-height: 1.2; margin-bottom: 1.5rem; z-index: 1;}
        .hero-title span { color: #8b85ff; }
        .hero-desc { color: #a5a5c9; font-size: 1.1rem; line-height: 1.6; margin-bottom: 3rem; max-width: 80%; z-index: 1;}
        .feature-list { display: flex; flex-direction: column; gap: 1rem; z-index: 1;}
        .feature-item { background: rgba(255, 255, 255, 0.05); padding: 1rem 1.5rem; border-radius: 12px; display: flex; align-items: center; gap: 1rem; border: 1px solid rgba(255,255,255,0.05); }
        .feature-icon { background: rgba(255, 255, 255, 0.1); width: 40px; height: 40px; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #8b85ff;}
        .feature-text h4 { font-size: 1rem; margin-bottom: 0.2rem; }
        .feature-text p { font-size: 0.85rem; color: #a5a5c9; }
        .copyright { margin-top: 3rem; font-size: 0.8rem; color: #6e6e96; z-index: 1;}
        .login-section { flex: 1; background-color: white; display: flex; align-items: center; justify-content: center; padding: 2rem; }
        .login-box { width: 100%; max-width: 420px; }
        .login-box h2 { font-size: 2rem; font-weight: 700; color: #1a1a2e; margin-bottom: 0.5rem; }
        .login-box > p { color: #6b7280; margin-bottom: 2rem; }
        .role-toggle { display: flex; background: #f3f4f6; border-radius: 10px; padding: 4px; margin-bottom: 2rem; }
        .role-btn { flex: 1; padding: 10px; text-align: center; border: none; background: transparent; font-weight: 600; color: #6b7280; cursor: pointer; border-radius: 8px; transition: 0.3s;}
        .role-btn.active { background: white; color: #1a1a2e; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        .role-btn i { margin-right: 8px; }
        .form-group { margin-bottom: 1.5rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; font-weight: 600; color: #374151; font-size: 0.9rem; }
        .input-wrapper { position: relative; }
        .input-wrapper i { position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #9ca3af; }
        .input-wrapper input { width: 100%; padding: 12px 15px 12px 45px; border: 1px solid #d1d5db; border-radius: 8px; outline: none; font-size: 1rem; transition: border-color 0.3s; }
        .input-wrapper input:focus { border-color: #6d28d9; }
        .input-wrapper .eye-icon { left: auto; right: 15px; cursor: pointer; }
        .btn-submit { width: 100%; padding: 14px; background: #6d28d9; color: white; border: none; border-radius: 8px; font-size: 1rem; font-weight: 600; cursor: pointer; transition: background 0.3s; margin-bottom: 1.5rem; }
        .btn-submit:hover { opacity: 0.9; }
        .demo-credentials { background: #f3f4ff; padding: 1.5rem; border-radius: 8px; border: 1px solid #e0e7ff; }
        .demo-credentials h4 { color: #4f46e5; font-size: 0.9rem; margin-bottom: 0.5rem; }
        .demo-credentials p { font-size: 0.85rem; color: #4b5563; margin-bottom: 0.2rem; }
        .demo-credentials a { display: inline-block; margin-top: 0.5rem; color: #4f46e5; text-decoration: none; font-size: 0.85rem; font-weight: 600; }
        .demo-credentials a:hover { text-decoration: underline; }
        @media (max-width: 900px) { body { flex-direction: column; } .hero-section { display: none; } .login-section { min-height: 100vh; } }
    </style>
</head>
<body>

    <div class="hero-section">
        <div class="logo">
            <i class="fa-solid fa-graduation-cap"></i>
            <div>EduManage<br><span>Hệ thống Đại học</span></div>
        </div>
        <h1 class="hero-title">Hành Trình Học Thuật<br>Bắt Đầu <span>Tại Đây.</span></h1>
        <p class="hero-desc">Quản lý khóa học, thời khóa biểu và đăng ký một cách liền mạch. Một nền tảng duy nhất dành cho sinh viên và quản trị viên.</p>
        <div class="feature-list">
            <div class="feature-item"><div class="feature-icon"><i class="fa-solid fa-book-open"></i></div><div class="feature-text"><h4>Quản Lý Khóa Học</h4><p>Duyệt và đăng ký các môn học dễ dàng</p></div></div>
            <div class="feature-item"><div class="feature-icon"><i class="fa-solid fa-chart-simple"></i></div><div class="feature-text"><h4>Báo Cáo Thông Minh</h4><p>Phân tích số liệu đăng ký theo thời gian thực</p></div></div>
            <div class="feature-item"><div class="feature-icon"><i class="fa-solid fa-users"></i></div><div class="feature-text"><h4>Truy Cập Đa Vai Trò</h4><p>Cổng thông tin cho admin và sinh viên</p></div></div>
        </div>
        <div class="copyright">&copy; 2026 Hệ thống Đại học EduManage. Đã đăng ký bản quyền.</div>
    </div>

    <div class="login-section">
        <div class="login-box">
            <h2>Chào mừng trở lại</h2>
            <p>Đăng nhập vào tài khoản của bạn để tiếp tục</p>

            <div class="role-toggle">
                <button type="button" class="role-btn active" id="btn-student" onclick="switchRole('sinh_vien')"><i class="fa-solid fa-user-graduate"></i> Sinh viên</button>
                <button type="button" class="role-btn" id="btn-admin" onclick="switchRole('quan_tri')"><i class="fa-solid fa-shield-halved"></i> Quản trị viên</button>
            </div>

            <form action="Index.php?action=process_login" method="POST">
                <input type="hidden" id="role_input" name="role" value="sinh_vien">

                <div class="form-group">
                    <label for="email">Địa chỉ Email</label>
                    <div class="input-wrapper">
                        <i class="fa-regular fa-envelope"></i>
                        <input type="email" id="email" name="email" placeholder="sinhvien@student.edu.vn" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Mật khẩu</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" id="password" name="password" placeholder="Nhập mật khẩu của bạn" required>
                        <i class="fa-regular fa-eye eye-icon" onclick="togglePassword()"></i>
                    </div>
                </div>

                <button type="submit" class="btn-submit" id="submit-btn">Đăng nhập (Sinh viên)</button>
            </form>

            <div class="demo-credentials">
                <h4>Thông tin đăng nhập mẫu</h4>
                <p>Email: <code id="demo-email">74dctt10001@student.edu.vn</code></p>
                <p>Mật khẩu: <code id="demo-pass">sinhvien123</code></p>
                <a href="#" onclick="fillDemo(event)">Điền tự động &rarr;</a>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            var passInput = document.getElementById("password");
            if (passInput.type === "password") { passInput.type = "text"; } 
            else { passInput.type = "password"; }
        }

        // Logic chuyển đổi giao diện giữa Admin và Sinh viên
        function switchRole(role) {
            const btnStudent = document.getElementById('btn-student');
            const btnAdmin = document.getElementById('btn-admin');
            const roleInput = document.getElementById('role_input');
            const submitBtn = document.getElementById('submit-btn');
            const demoEmail = document.getElementById('demo-email');
            const demoPass = document.getElementById('demo-pass');

            if (role === 'quan_tri') {
                btnAdmin.classList.add('active');
                btnStudent.classList.remove('active');
                roleInput.value = 'quan_tri';
                submitBtn.textContent = 'Đăng nhập (Quản trị viên)';
                submitBtn.style.backgroundColor = '#2e286d'; // Đổi sang màu tối hơn theo thiết kế
                demoEmail.textContent = 'admin@university.edu.vn';
                demoPass.textContent = 'admin123';
            } else {
                btnStudent.classList.add('active');
                btnAdmin.classList.remove('active');
                roleInput.value = 'sinh_vien';
                submitBtn.textContent = 'Đăng nhập (Sinh viên)';
                submitBtn.style.backgroundColor = '#6d28d9'; // Màu gốc
                demoEmail.textContent = '74dctt10001@student.edu.vn';
                demoPass.textContent = 'sinhvien123';
            }
            // Reset ô input khi đổi tab
            document.getElementById("email").value = "";
            document.getElementById("password").value = "";
        }

        function fillDemo(e) {
            e.preventDefault();
            document.getElementById("email").value = document.getElementById("demo-email").textContent;
            document.getElementById("password").value = document.getElementById("demo-pass").textContent;
        }
    </script>
</body>
</html>