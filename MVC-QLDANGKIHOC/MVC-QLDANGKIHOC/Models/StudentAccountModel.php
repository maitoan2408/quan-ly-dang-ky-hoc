<?php
class StudentAccountModel {
    private $host = 'localhost';
    private $db_name = 'ql_dangkyhoc';
    private $username = 'root';
    private $password = '';
    private $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8mb4", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            echo "Lỗi kết nối Cơ sở dữ liệu: " . $exception->getMessage();
        }
        return $this->conn;
    }

    public function getAllStudentAccounts() {
        $conn = $this->getConnection();
        if($conn) {
            $query = "SELECT tk.id, tk.email, tk.mat_khau, tk.vai_tro, tk.ngay_tao,
                             sv.ho_ten, sv.ma_sinh_vien, sv.so_dien_thoai
                      FROM tai_khoan tk
                      LEFT JOIN sinh_vien sv ON tk.id = sv.id_tai_khoan
                      ORDER BY tk.id DESC";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return [];
    }

    public function searchStudentAccounts($keyword) {
        $conn = $this->getConnection();
        if($conn) {
            $query = "SELECT tk.id, tk.email, tk.mat_khau, tk.vai_tro, tk.ngay_tao,
                             sv.ho_ten, sv.ma_sinh_vien, sv.so_dien_thoai
                      FROM tai_khoan tk
                      LEFT JOIN sinh_vien sv ON tk.id = sv.id_tai_khoan
                      WHERE tk.email LIKE :keyword OR sv.ho_ten LIKE :keyword OR sv.ma_sinh_vien LIKE :keyword
                      ORDER BY tk.id DESC";
            $stmt = $conn->prepare($query);
            $keyword = "%$keyword%";
            $stmt->bindParam(':keyword', $keyword);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return [];
    }

    public function getStudentDetailByAccountId($accountId) {
        $conn = $this->getConnection();
        if($conn) {
            $query = "SELECT tk.id, tk.email, tk.vai_tro, tk.ngay_tao,
                             sv.ho_ten, sv.ma_sinh_vien, sv.ngay_sinh, sv.gioi_tinh,
                             sv.so_dien_thoai, sv.dia_chi
                      FROM tai_khoan tk
                      LEFT JOIN sinh_vien sv ON tk.id = sv.id_tai_khoan
                      WHERE tk.id = :account_id AND tk.vai_tro = 'sinh_vien'";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':account_id', $accountId);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }

    public function addStudentAccount($email, $password, $hoTen, $vaiTro) {
        $conn = $this->getConnection();
        if($conn) {
            try {
                $conn->beginTransaction();
                $query = "INSERT INTO tai_khoan (email, mat_khau, vai_tro) VALUES (:email, :password, :vai_tro)";
                $stmt = $conn->prepare($query);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':password', $password);
                $stmt->bindParam(':vai_tro', $vaiTro);
                $stmt->execute();
                $accountId = $conn->lastInsertId();
                if ($vaiTro === 'sinh_vien') {
                    $maSV = '74DCTT' . str_pad(rand(10000, 99999), 5, '0', STR_PAD_LEFT);
                    $query2 = "INSERT INTO sinh_vien (id_tai_khoan, ma_sinh_vien, ho_ten) VALUES (:id_tai_khoan, :ma_sinh_vien, :ho_ten)";
                    $stmt2 = $conn->prepare($query2);
                    $stmt2->bindParam(':id_tai_khoan', $accountId);
                    $stmt2->bindParam(':ma_sinh_vien', $maSV);
                    $stmt2->bindParam(':ho_ten', $hoTen);
                    $stmt2->execute();
                }
                $conn->commit();
                return true;
            } catch (Exception $e) {
                $conn->rollBack();
                return false;
            }
        }
        return false;
    }

    public function deleteStudentAccount($accountId) {
        $conn = $this->getConnection();
        if($conn) {
            try {
                $conn->beginTransaction();
                $query0 = "SELECT sv.id FROM sinh_vien sv WHERE sv.id_tai_khoan = :account_id";
                $stmt0 = $conn->prepare($query0);
                $stmt0->bindParam(':account_id', $accountId);
                $stmt0->execute();
                $svId = $stmt0->fetchColumn();
                if ($svId) {
                    $query1 = "DELETE FROM hoc_phi WHERE id_sinh_vien = :sv_id";
                    $stmt1 = $conn->prepare($query1);
                    $stmt1->bindParam(':sv_id', $svId);
                    $stmt1->execute();
                    $query2 = "DELETE FROM dang_ky_hoc WHERE id_sinh_vien = :sv_id";
                    $stmt2 = $conn->prepare($query2);
                    $stmt2->bindParam(':sv_id', $svId);
                    $stmt2->execute();
                    $query3 = "DELETE FROM sinh_vien WHERE id_tai_khoan = :account_id";
                    $stmt3 = $conn->prepare($query3);
                    $stmt3->bindParam(':account_id', $accountId);
                    $stmt3->execute();
                }
                $query4 = "DELETE FROM tai_khoan WHERE id = :account_id";
                $stmt4 = $conn->prepare($query4);
                $stmt4->bindParam(':account_id', $accountId);
                $stmt4->execute();
                $conn->commit();
                return true;
            } catch (Exception $e) {
                $conn->rollBack();
                return false;
            }
        }
        return false;
    }

    public function updateStudentProfile($accountId, $hoTen, $ngaySinh, $gioiTinh, $soDienThoai, $diaChi) {
        $conn = $this->getConnection();
        if($conn) {
            $query = "UPDATE sinh_vien
                      SET ho_ten = :ho_ten, ngay_sinh = :ngay_sinh, gioi_tinh = :gioi_tinh,
                          so_dien_thoai = :so_dien_thoai, dia_chi = :dia_chi
                      WHERE id_tai_khoan = :id_tai_khoan";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':ho_ten', $hoTen);
            $stmt->bindParam(':ngay_sinh', $ngaySinh);
            $stmt->bindParam(':gioi_tinh', $gioiTinh);
            $stmt->bindParam(':so_dien_thoai', $soDienThoai);
            $stmt->bindParam(':dia_chi', $diaChi);
            $stmt->bindParam(':id_tai_khoan', $accountId);
            return $stmt->execute();
        }
        return false;
    }

    public function changePassword($accountId, $oldPassword, $newPassword) {
        $conn = $this->getConnection();
        if($conn) {
            $query = "SELECT mat_khau FROM tai_khoan WHERE id = :id AND vai_tro = 'sinh_vien'";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':id', $accountId);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($user && $user['mat_khau'] === $oldPassword) {
                $update = "UPDATE tai_khoan SET mat_khau = :new_password WHERE id = :id";
                $stmt2 = $conn->prepare($update);
                $stmt2->bindParam(':new_password', $newPassword);
                $stmt2->bindParam(':id', $accountId);
                return $stmt2->execute();
            }
            return false;
        }
        return false;
    }

    public function emailExists($email) {
        $conn = $this->getConnection();
        if($conn) {
            $query = "SELECT COUNT(*) FROM tai_khoan WHERE email = :email";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            return $stmt->fetchColumn() > 0;
        }
        return false;
    }

    public function getAccountById($accountId) {
        $conn = $this->getConnection();
        if($conn) {
            $query = "SELECT tk.id, tk.email, tk.mat_khau, tk.vai_tro, tk.ngay_tao,
                             sv.ho_ten, sv.ma_sinh_vien, sv.ngay_sinh, sv.gioi_tinh,
                             sv.so_dien_thoai, sv.dia_chi
                      FROM tai_khoan tk
                      LEFT JOIN sinh_vien sv ON tk.id = sv.id_tai_khoan
                      WHERE tk.id = :account_id";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':account_id', $accountId);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }

    public function getAccountByEmail($email) {
        $conn = $this->getConnection();
        if($conn) {
            $query = "SELECT id, email, vai_tro FROM tai_khoan WHERE email = :email";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }

    public function updateAccountInfo($accountId, $email, $vaiTro) {
        $conn = $this->getConnection();
        if($conn) {
            try {
                $conn->beginTransaction();
                
                // Lấy thông tin tài khoản hiện tại
                $query = "SELECT vai_tro FROM tai_khoan WHERE id = :account_id";
                $stmt = $conn->prepare($query);
                $stmt->bindParam(':account_id', $accountId);
                $stmt->execute();
                $currentAccount = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if (!$currentAccount) {
                    $conn->rollBack();
                    return false;
                }
                
                $oldRole = $currentAccount['vai_tro'];
                
                // Cập nhật thông tin tài khoản
                $updateQuery = "UPDATE tai_khoan SET email = :email, vai_tro = :vai_tro WHERE id = :account_id";
                $stmt = $conn->prepare($updateQuery);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':vai_tro', $vaiTro);
                $stmt->bindParam(':account_id', $accountId);
                $stmt->execute();
                
                // Nếu chuyển từ sinh_vien sang vai trò khác, xóa bản ghi trong sinh_vien
                if ($oldRole === 'sinh_vien' && $vaiTro !== 'sinh_vien') {
                    $deleteQuery = "DELETE FROM sinh_vien WHERE id_tai_khoan = :account_id";
                    $stmt = $conn->prepare($deleteQuery);
                    $stmt->bindParam(':account_id', $accountId);
                    $stmt->execute();
                }
                
                // Nếu chuyển sang sinh_vien từ vai trò khác, thêm bản ghi vào sinh_vien
                if ($oldRole !== 'sinh_vien' && $vaiTro === 'sinh_vien') {
                    // Kiểm tra đã tồn tại trong sinh_vien chưa
                    $checkQuery = "SELECT COUNT(*) FROM sinh_vien WHERE id_tai_khoan = :account_id";
                    $stmt = $conn->prepare($checkQuery);
                    $stmt->bindParam(':account_id', $accountId);
                    $stmt->execute();
                    $exists = $stmt->fetchColumn() > 0;
                    
                    if (!$exists) {
                        $maSV = '74DCTT' . str_pad(rand(10000, 99999), 5, '0', STR_PAD_LEFT);
                        $insertQuery = "INSERT INTO sinh_vien (id_tai_khoan, ma_sinh_vien, ho_ten) 
                                       VALUES (:id_tai_khoan, :ma_sinh_vien, :ho_ten)";
                        $stmt = $conn->prepare($insertQuery);
                        $stmt->bindParam(':id_tai_khoan', $accountId);
                        $stmt->bindParam(':ma_sinh_vien', $maSV);
                        $hoTen = 'Chưa cập nhật';
                        $stmt->bindParam(':ho_ten', $hoTen);
                        $stmt->execute();
                    }
                }
                
                $conn->commit();
                return true;
            } catch (Exception $e) {
                $conn->rollBack();
                return false;
            }
        }
        return false;
    }

    public function adminChangePassword($accountId, $newPassword) {
        $conn = $this->getConnection();
        if($conn) {
            $query = "UPDATE tai_khoan SET mat_khau = :new_password WHERE id = :id";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':new_password', $newPassword);
            $stmt->bindParam(':id', $accountId);
            return $stmt->execute();
        }
        return false;
    }
    
}
?>
