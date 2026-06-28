# \#  Hệ Thống Quản Lý Đăng Ký Học

# 

# Ứng dụng web quản lý đăng ký môn học dành cho sinh viên và quản trị viên, được xây dựng theo mô hình MVC và triển khai bằng Docker.

# 

# \##  Thành viên nhóm

# 

# | Họ tên | Mã sinh viên |

# |---|---|

# | Nguyễn Hoàng Sơn | 74DCTT22367 |

# | Phạm Thế Sơn | 74DCTT22227 |

# | Lê Văn Thế Anh | 74DCTT22355 |

# | Lê Nam Sang | 74DCTT22256 |

# | Mai Đức Toàn | 74DCTT22417 |

# 

# \##  Công nghệ sử dụng

# 

# \- \*\*Backend:\*\* PHP 8.1 (MVC)

# \- \*\*Database:\*\* MariaDB 10.6

# \- \*\*Triển khai:\*\* Docker + Docker Compose

# \- \*\*Quản lý code:\*\* Git + GitHub

# 

# \##  Hướng dẫn chạy

# 

# 1\. Clone repo về máy

# 2\. Chạy lệnh: `docker compose up -d --build`

# 3\. Import database: `docker exec -i <db-container> mariadb -u root -proot123 ql\_dangkyhoc < database.sql`

# 4\. Truy cập: `http://localhost:8080`

# 

# \## 🔑 Tài khoản demo

# 

# | Vai trò | Email | Mật khẩu |

# |---|---|---|

# | Quản trị viên | admin@university.edu.vn | admin123 |

# | Sinh viên | 74dctt10001@student.edu.vn | sinhvien123 |

