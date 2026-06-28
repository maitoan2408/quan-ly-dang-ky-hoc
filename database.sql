CREATE TABLE `dang_ky_hoc` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `id_sinh_vien` INT(11) NOT NULL,
  `id_mon_hoc` INT(11) NOT NULL,
  `id_lop_hoc` INT(11) NOT NULL,
  `thoi_gian_dang_ky` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  `trang_thai` ENUM('Thành công', 'Chờ hủy', 'Đã hủy') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'Thành công',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `dang_ky_hoc` (`id`, `id_sinh_vien`, `id_mon_hoc`, `id_lop_hoc`, `thoi_gian_dang_ky`, `trang_thai`) VALUES
(141, 1, 21, 31, '2026-04-22 14:07:36', 'Thành công'),
(143, 1, 23, 33, '2026-05-08 08:15:14', 'Thành công'),
(144, 1, 2, 2, '2026-05-09 22:39:20', 'Thành công'),
(145, 1, 18, 28, '2026-05-09 22:39:44', 'Thành công'),
(146, 1, 1, 1, '2026-05-09 22:40:25', 'Thành công'),
(147, 1, 22, 32, '2026-05-09 22:40:36', 'Thành công');

CREATE TABLE `hoc_phi` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `id_sinh_vien` INT(11) NOT NULL,
  `tong_tien` DECIMAL(15,2) DEFAULT 0.00,
  `mien_giam` DECIMAL(15,2) DEFAULT 0.00,
  `da_thanh_toan` TINYINT(1) NOT NULL DEFAULT 0,
  `thoi_gian_thanh_toan` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `hoc_phi` (`id`, `id_sinh_vien`, `tong_tien`, `mien_giam`, `da_thanh_toan`, `thoi_gian_thanh_toan`) VALUES
(74, 2, 1500000.00, 0.00, 0, NULL),
(95, 1, 3520000.00, 0.00, 1, NULL),
(129, 1, 7280000.00, 0.00, 0, NULL);

CREATE TABLE `ky_hoc` (
  `id_ky_hoc` INT(11) NOT NULL AUTO_INCREMENT,
  `ten_ky_hoc` VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `thoi_gian_bat_dau` DATETIME NOT NULL,
  `thoi_gian_ket_thuc` DATETIME NOT NULL,
  `tin_chi_toi_thieu` INT(11) DEFAULT 10,
  `tin_chi_toi_da` INT(11) DEFAULT 25,
  `trang_thai_dang_ky` VARCHAR(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_ky_hoc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `ky_hoc` (`id_ky_hoc`, `ten_ky_hoc`, `thoi_gian_bat_dau`, `thoi_gian_ket_thuc`, `tin_chi_toi_thieu`, `tin_chi_toi_da`, `trang_thai_dang_ky`) VALUES
(1, 'Học kỳ 1 - 2025', '2025-09-01 00:00:00', '2026-01-15 23:59:00', 10, 25, 'Đã đóng'),
(2, 'Học kỳ 2 - 2025', '2026-02-15 00:00:00', '2026-06-30 23:59:00', 10, 25, 'Sắp tới'),
(33, 'Học kỳ 1 năm học 2026', '2026-04-20 17:30:00', '2026-06-20 17:30:00', 12, 25, 'Đã đóng'),
(34, 'Học kỳ 1 năm học 2026', '2026-05-15 22:37:00', '2026-05-22 22:37:00', 12, 30, 'Đang mở');

CREATE TABLE `lich_hoc` (
  `id_lich_hoc` INT(11) NOT NULL AUTO_INCREMENT,
  `id_lop_hoc` INT(11) NOT NULL,
  `id_mon_hoc` INT(11) NOT NULL,
  `thu` VARCHAR(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `gio_vao_hoc` TIME NOT NULL,
  `gio_ra_ve` TIME NOT NULL,
  `ngay_bat_dau` DATE NOT NULL,
  `ngay_ket_thuc` DATE NOT NULL,
  PRIMARY KEY (`id_lich_hoc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `lich_hoc` (`id_lich_hoc`, `id_lop_hoc`, `id_mon_hoc`, `thu`, `gio_vao_hoc`, `gio_ra_ve`, `ngay_bat_dau`, `ngay_ket_thuc`) VALUES
(5, 1, 1, 'Thứ 2', '07:30:00', '10:00:00', '2025-09-08', '2025-12-20'),
(6, 1, 1, 'Thứ 4', '07:30:00', '10:00:00', '2025-09-08', '2025-12-20'),
(7, 2, 2, 'Thứ 6', '01:30:00', '05:00:00', '2025-09-09', '2025-12-21'),
(9, 3, 3, 'Thứ 2', '07:30:00', '10:00:00', '2025-09-08', '2025-12-20'),
(10, 28, 18, 'Thứ 5', '07:30:00', '11:50:00', '2026-04-21', '2026-05-21'),
(11, 29, 19, 'Thứ 2', '07:30:00', '11:30:00', '2026-04-25', '2026-06-25'),
(13, 31, 21, 'Thứ 7', '10:00:00', '07:00:00', '2026-04-19', '2026-06-19'),
(14, 32, 22, 'Thứ 5', '19:00:00', '23:00:00', '2026-04-22', '2026-06-22'),
(15, 33, 23, 'Thứ 3', '08:15:00', '11:15:00', '2026-04-22', '2026-06-22'),
(21, 31, 21, 'Thứ 7', '08:30:00', '11:00:00', '2026-06-22', '2026-09-15');

CREATE TABLE `lop_hoc` (
  `id_lop_hoc` INT(11) NOT NULL AUTO_INCREMENT,
  `ma_lop_hoc` VARCHAR(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_mon_hoc` INT(11) NOT NULL,
  `id_ky_hoc` INT(11) NOT NULL,
  `ten_giang_vien` VARCHAR(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phong_hoc` VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `si_so_toi_da` INT(11) NOT NULL,
  `si_so_da_dang_ky` INT(11) DEFAULT 0,
  PRIMARY KEY (`id_lop_hoc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `lop_hoc` (`id_lop_hoc`, `ma_lop_hoc`, `id_mon_hoc`, `id_ky_hoc`, `ten_giang_vien`, `phong_hoc`, `si_so_toi_da`, `si_so_da_dang_ky`) VALUES
(1, 'L01_LTC', 19, 0, 'Thầy Nguyễn Trí Tuệ', 'Phòng 402-A2', 40, 1),
(2, 'L02_CTDL', 2, 0, 'Cô Lê Thị Giải Thuật', 'Phòng 105-B2', 35, 1),
(3, 'L01_TOAN', 3, 0, 'Thầy Trần Đại Số', 'Phòng 201-C1', 60, 0),
(28, 'LH4', 18, 0, 'Chiến Thắng', 'A8.102', 50, 1),
(29, 'LH5', 19, 0, 'Trung Quân', 'Phòng 301-A1', 40, 0),
(31, 'Lh10', 21, 0, 'Hoàng Sơn', 'A4.202', 40, 1),
(32, 'LH12', 22, 0, 'Thế Sơn', 'A8.202', 40, 1),
(33, 'LH14', 23, 0, 'Đức Toàn - Đại kiện tướng Thách Đấu', 'A3.405', 40, 1);

-- Cấu trúc bảng mon_hoc
CREATE TABLE `mon_hoc` (
  `id_mon_hoc` INT(11) NOT NULL AUTO_INCREMENT,
  `ma_mon_hoc` VARCHAR(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ten_mon_hoc` VARCHAR(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `so_tin_chi` INT(11) NOT NULL,
  `chuong_trinh_hoc` VARCHAR(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_mon_hoc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dữ liệu bảng mon_hoc
INSERT INTO `mon_hoc` (`id_mon_hoc`, `ma_mon_hoc`, `ten_mon_hoc`, `so_tin_chi`, `chuong_trinh_hoc`) VALUES
(1, 'IT101', 'Lập trình C cơ bản', 3, 'Công nghệ thông tin'),
(2, 'IT202', 'Cấu trúc dữ liệu và Giải thuật', 4, 'Công nghệ thông tin'),
(3, 'MA101', 'Toán cao cấp A1', 3, 'Đại cương'),
(18, 'EN1010', 'Tiếng Nga Chất', 3, 'Ngoại ngữ'),
(19, 'IT4567', 'Vận Hành Logistics', 3, 'Quản lý công nghiệp'),
(21, 'AE1010', 'Valorant nhập môn', 3, 'Điện Tử'),
(22, 'A12021', 'Kiến trúc Mincraft', 3, 'Kiến trúc không gian'),
(23, 'CT4040', 'Liên Quân', 4, 'Điện Tử');

-- Cấu trúc bảng sinh_vien
CREATE TABLE `sinh_vien` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `id_tai_khoan` INT(11) NOT NULL,
  `ma_sinh_vien` VARCHAR(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ho_ten` VARCHAR(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ngay_sinh` DATE DEFAULT NULL,
  `gioi_tinh` ENUM('Nam', 'Nữ', 'Khác') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `so_dien_thoai` VARCHAR(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dia_chi` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dữ liệu bảng sinh_vien
INSERT INTO `sinh_vien` (`id`, `id_tai_khoan`, `ma_sinh_vien`, `ho_ten`, `ngay_sinh`, `gioi_tinh`, `so_dien_thoai`, `dia_chi`) VALUES
(1, 2, 'SV001', 'Nguyễn Văn Lam', '2004-05-15', 'Nam', '0912345532', 'Hà Nội'),
(2, 3, 'SV002', 'Trần Thị B', '2004-10-20', 'Nữ', '0987654321', 'Đà Nẵng'),
(11, 12, '74DCTT51467', 'Nguyen Van A', NULL, NULL, NULL, NULL);

CREATE TABLE `tai_khoan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `mat_khau` varchar(255) NOT NULL,
  `vai_tro` enum('quan_tri','sinh_vien') NOT NULL,
  `ngay_tao` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `tai_khoan` (`id`, `email`, `mat_khau`, `vai_tro`, `ngay_tao`) VALUES
(1, 'admin@university.edu.vn', 'admin123', 'quan_tri', '2026-04-20 02:22:50'),
(2, '74dctt10001@student.edu.vn', 'sinhvien123', 'sinh_vien', '2026-04-20 02:22:50'),
(3, 'sinhvien2@school.edu.vn', '123456', 'sinh_vien', '2026-04-20 02:22:50'),
(12, 'new_sv@edu.vn', '123', 'sinh_vien', '2026-04-20 19:06:18');

