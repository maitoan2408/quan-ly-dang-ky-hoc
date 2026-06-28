<?php
require_once 'Database.php';

class CourseModel extends Database {
    // Biến lưu trữ kết nối dùng chung cho toàn bộ Class
    private $db;

    public function __construct() {
        // Khởi tạo kết nối ngay khi Model được tạo
        $this->db = $this->getConnection();
    }

  public function checkCourseExists($ma_mon_hoc) {
    if (!$this->db) return false;
    $sql = "SELECT COUNT(*) FROM mon_hoc WHERE ma_mon_hoc = :ma_mon_hoc";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([':ma_mon_hoc' => $ma_mon_hoc]);
    return $stmt->fetchColumn() > 0;
}

// Cập nhật hàm insertCourse để xử lý an toàn hơn
public function insertCourse($data) {
    if (!$this->db) return false;

    // Nếu mã đã tồn tại, trả về false hoặc một thông báo lỗi cụ thể
    if ($this->checkCourseExists($data['ma_mon_hoc'])) {
        return "duplicate"; 
    }

    $sql = "INSERT INTO mon_hoc (ma_mon_hoc, ten_mon_hoc, so_tin_chi, chuong_trinh_hoc) 
            VALUES (:ma_mon_hoc, :ten_mon_hoc, :so_tin_chi, :chuong_trinh_hoc)";
    
    $stmt = $this->db->prepare($sql);
    return $stmt->execute([
        ':ma_mon_hoc' => $data['ma_mon_hoc'],
        ':ten_mon_hoc' => $data['ten_mon_hoc'],
        ':so_tin_chi'  => $data['so_tin_chi'],
        ':chuong_trinh_hoc' => $data['chuong_trinh_hoc']
    ]);
}

    /**
     * LẤY TẤT CẢ MÔN HỌC (Để hiển thị ở trang Quản lý môn học)
     */
    public function getAllSubjects() {
        if (!$this->db) return [];

        $query = "SELECT * FROM mon_hoc ORDER BY id_mon_hoc DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * LẤY DANH SÁCH CHƯƠNG TRÌNH HỌC (Để làm gợi ý datalist)
     */
    public function getAllStudyPrograms() {
        if (!$this->db) return [];

        $sql = "SELECT DISTINCT chuong_trinh_hoc FROM mon_hoc WHERE chuong_trinh_hoc IS NOT NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * LẤY TẤT CẢ LỚP HỌC KÈM THÔNG TIN MÔN HỌC
     */
    public function getAllClasses() {
        if (!$this->db) return [];

        $query = "SELECT mh.ma_mon_hoc, mh.ten_mon_hoc, mh.so_tin_chi, mh.chuong_trinh_hoc,
                         lh.ten_giang_vien, lh.phong_hoc, 
                         lh.si_so_toi_da, lh.si_so_da_dang_ky
                  FROM mon_hoc mh
                  JOIN lop_hoc lh ON mh.id_mon_hoc = lh.id_mon_hoc";

        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * CHI TIẾT LỚP HỌC (Có mã lớp cụ thể)
     */
    public function getAllClassesWithDetails() {
        if (!$this->db) return [];

        $query = "SELECT lh.ma_lop_hoc, mh.ma_mon_hoc, mh.ten_mon_hoc, mh.chuong_trinh_hoc,
                         lh.ten_giang_vien, lh.phong_hoc, 
                         lh.si_so_toi_da, lh.si_so_da_dang_ky
                  FROM lop_hoc lh
                  JOIN mon_hoc mh ON mh.id_mon_hoc = lh.id_mon_hoc";

        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * THÊM LỚP HỌC MỚI
     */
    public function insertClass($data) {
        if (!$this->db) return false;

        // 1. Tìm ID môn học dựa trên tên môn
        $sql_mh = "SELECT id_mon_hoc FROM mon_hoc WHERE ten_mon_hoc = :ten_mon_hoc LIMIT 1";
        $stmt_mh = $this->db->prepare($sql_mh);
        $stmt_mh->execute([':ten_mon_hoc' => $data['course_name']]);
        $mon_hoc = $stmt_mh->fetch();

        if (!$mon_hoc) return false; 

        // 2. Insert vào bảng lop_hoc
        $query = "INSERT INTO lop_hoc (ma_lop_hoc, id_mon_hoc, ten_giang_vien, phong_hoc, si_so_toi_da, si_so_da_dang_ky) 
                  VALUES (:ma_lop, :id_mh, :giang_vien, :phong, :max_si_so, :da_dang_ky)";
        
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            ':ma_lop'     => $data['class_name'],
            ':id_mh'      => $mon_hoc['id_mon_hoc'],
            ':giang_vien' => $data['instructor'],
            ':phong'      => $data['room'],
            ':max_si_so'  => $data['capacity'],
            ':da_dang_ky' => $data['enrolled']
        ]);
    }
    public function deleteCourseByCode($code) {
    try {
        // Sử dụng $this->db từ class Database đã kết nối
        $sql = "DELETE FROM mon_hoc WHERE ma_mon_hoc = :ma_mon_hoc";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':ma_mon_hoc', $code);
        return $stmt->execute();
    } catch (PDOException $e) {
        // Nếu môn học đang có lớp học tham chiếu (khóa ngoại), sẽ không xóa được
        error_log("Lỗi xóa môn học: " . $e->getMessage());
        return false;
    }
}
public function getCourseByCode($code) {
    if (!$this->db) return false;
    $sql = "SELECT * FROM mon_hoc WHERE ma_mon_hoc = :ma_mon_hoc";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([':ma_mon_hoc' => $code]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
public function updateCourseByCode($data) {
    $sql = "UPDATE mon_hoc 
            SET ten_mon_hoc = :ten, so_tin_chi = :tin_chi, chuong_trinh_hoc = :ct 
            WHERE ma_mon_hoc = :ma";
    $stmt = $this->db->prepare($sql);
    return $stmt->execute([
        ':ten' => $data['ten_mon_hoc'],
        ':tin_chi' => $data['so_tin_chi'],
        ':ct' => $data['chuong_trinh_hoc'],
        ':ma' => $data['ma_mon_hoc']
    ]);
}
public function getClassesByFilter($program, $keyword) {
    $sql = "SELECT lh.*, mh.chuong_trinh_hoc 
            FROM lop_hoc lh 
            JOIN mon_hoc mh ON lh.ma_mon_hoc = mh.ma_mon_hoc 
            WHERE 1=1";
    $params = [];

    if ($program !== 'all') {
        $sql .= " AND mh.chuong_trinh_hoc = :program";
        $params[':program'] = $program;
    }

    if (!empty($keyword)) {
        $sql .= " AND (lh.ma_lop_hoc LIKE :keyword OR mh.ten_mon_hoc LIKE :keyword)";
        $params[':keyword'] = "%$keyword%";
    }

    $stmt = $this->db->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}
/**
     * LẤY DANH SÁCH LỚP HỌC THEO CHƯƠNG TRÌNH HỌC (Dùng cho thanh lọc)
     */
    public function getClassesByProgram($program) {
        if (!$this->db) return [];

        // Câu SQL Join để lấy thông tin ngành từ bảng mon_hoc
        $query = "SELECT lh.ma_lop_hoc, mh.ma_mon_hoc, mh.ten_mon_hoc, mh.chuong_trinh_hoc,
                         lh.ten_giang_vien, lh.phong_hoc, 
                         lh.si_so_toi_da, lh.si_so_da_dang_ky
                  FROM lop_hoc lh
                  JOIN mon_hoc mh ON mh.id_mon_hoc = lh.id_mon_hoc";

        $params = [];

        // Nếu người dùng chọn một ngành cụ thể, thêm điều kiện WHERE
        if ($program !== 'all') {
            $query .= " WHERE mh.chuong_trinh_hoc = :program";
            $params[':program'] = $program;
        }

        $stmt = $this->db->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getCoursesByFilter($program = 'all', $keyword = '') {
    if (!$this->db) return [];

    // 1. Câu lệnh SQL cơ bản lấy từ bảng mon_hoc
    $sql = "SELECT * FROM mon_hoc WHERE 1=1";
    $params = [];

    // 2. Lọc theo chương trình học (Ngành)
    if ($program !== 'all' && !empty($program)) {
        $sql .= " AND chuong_trinh_hoc = :program";
        $params[':program'] = $program;
    }

    // 3. Lọc theo từ khóa tìm kiếm (Mã hoặc Tên môn)
    if (!empty($keyword)) {
        $sql .= " AND (ma_mon_hoc LIKE :keyword OR ten_mon_hoc LIKE :keyword)";
        $params[':keyword'] = '%' . $keyword . '%';
    }

    // 4. Sắp xếp để bản ghi mới nhất hiện lên trên
    $sql .= " ORDER BY id_mon_hoc DESC";

    try {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Lỗi truy vấn lọc môn học: " . $e->getMessage());
        return [];
    }
}
public function checkClassExists($ma_lop_hoc) {
    if (!$this->db) return false;
    $sql = "SELECT COUNT(*) FROM lop_hoc WHERE ma_lop_hoc = :ma_lop_hoc";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([':ma_lop_hoc' => $ma_lop_hoc]);
    return $stmt->fetchColumn() > 0; // Trả về true nếu đã tồn tại
}
// Lấy thông tin 1 lớp học theo Mã lớp
public function getClassByCode($code) {
    $sql = "SELECT * FROM lop_hoc WHERE ma_lop_hoc = :code";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([':code' => $code]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Cập nhật thông tin lớp học
public function updateClassByCode($data) {
    if (!$this->db) return false;
    
    $sql = "UPDATE lop_hoc 
            SET id_mon_hoc = :id_mh,
                ten_giang_vien = :gv, 
                phong_hoc = :phong, 
                si_so_toi_da = :max, 
                si_so_da_dang_ky = :enrolled 
            WHERE ma_lop_hoc = :ma";
            
    $stmt = $this->db->prepare($sql);
    return $stmt->execute([
        ':id_mh'    => (int)$data['id_mon_hoc'],
        ':gv'       => $data['instructor'],
        ':phong'    => $data['room'],
        ':max'      => (int)$data['capacity'],
        ':enrolled' => (int)$data['enrolled'],
        ':ma'       => $data['class_name']
    ]);
}

// Xóa lớp học
public function deleteClassByCode($code) {
    $sql = "DELETE FROM lop_hoc WHERE ma_lop_hoc = :code";
    $stmt = $this->db->prepare($sql);
    return $stmt->execute([':code' => $code]);
}
public function getClassesForSchedule() {
    $conn = $this->getConnection();
    if($conn) {
        // CẬP NHẬT: Đã thêm lh.id_mon_hoc vào danh sách SELECT
        $query = "SELECT lh.id_lop_hoc, 
                         lh.ma_lop_hoc, 
                         lh.id_mon_hoc, 
                         mh.ten_mon_hoc, 
                         lh.ten_giang_vien, 
                         lh.phong_hoc 
                  FROM lop_hoc lh
                  JOIN mon_hoc mh ON lh.id_mon_hoc = mh.id_mon_hoc";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    return [];
}
public function insertSchedule($data) {
    $conn = $this->getConnection();
    $sql = "INSERT INTO lich_hoc (id_lop_hoc, id_mon_hoc, thu, gio_vao_hoc, gio_ra_ve, ngay_bat_dau, ngay_ket_thuc) 
            VALUES (:id_lop_hoc, :id_mon_hoc, :thu, :gio_vao_hoc, :gio_ra_ve, :ngay_bat_dau, :ngay_ket_thuc)";
    
    $stmt = $conn->prepare($sql);
    return $stmt->execute($data);
}
public function getAllSchedules() {
    $conn = $this->getConnection();
    if($conn) {
        // Thêm l.ten_giang_vien vào danh sách SELECT
        $query = "SELECT lh.*, mh.ten_mon_hoc, l.phong_hoc, l.ma_lop_hoc, l.ten_giang_vien 
                  FROM lich_hoc lh
                  JOIN mon_hoc mh ON lh.id_mon_hoc = mh.id_mon_hoc
                  JOIN lop_hoc l ON lh.id_lop_hoc = l.id_lop_hoc";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    return [];
}
public function deleteSchedule($id) {
    $conn = $this->getConnection();
    $sql = "DELETE FROM lich_hoc WHERE id_lich_hoc = :id";
    $stmt = $conn->prepare($sql);
    return $stmt->execute([':id' => $id]);
}
public function getScheduleById($id) {
    $conn = $this->getConnection();
    $sql = "SELECT * FROM lich_hoc WHERE id_lich_hoc = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

public function updateSchedule($data) {
    $conn = $this->getConnection();
    $sql = "UPDATE lich_hoc SET 
            id_lop_hoc = :id_lop_hoc, 
            id_mon_hoc = :id_mon_hoc, 
            thu = :thu, 
            gio_vao_hoc = :gio_vao_hoc, 
            gio_ra_ve = :gio_ra_ve, 
            ngay_bat_dau = :ngay_bat_dau, 
            ngay_ket_thuc = :ngay_ket_thuc 
            WHERE id_lich_hoc = :id_lich_hoc";
    $stmt = $conn->prepare($sql);
    return $stmt->execute($data);
}
}
?>