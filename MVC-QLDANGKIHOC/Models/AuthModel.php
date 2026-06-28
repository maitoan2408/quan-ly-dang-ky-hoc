<?php
require_once 'Database.php';

class AuthModel extends Database {
    
    public function authenticate($email, $password, $role) {
        $conn = $this->getConnection();
        if (!$conn) return false;

        $query = "SELECT id, email, vai_tro FROM tai_khoan 
                  WHERE email = :email AND mat_khau = :password AND vai_tro = :role";
        
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':role', $role);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }
}
?>