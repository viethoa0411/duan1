<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

class AdminUser {
    private $conn;

    public function __construct() {
        $this->conn = connectDB();
    }

    public function getAllUsers(){
        try {
            $sql = "SELECT users.*, role.name AS role_name
         FROM users
         LEFT JOIN role ON users.role_id = role.id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }catch (Exception $e) {
            echo "Lỗi truy vấn bị sai: " . $e->getMessage();
            return false;
        }
    }

    function getUserById($id) {
        try {
            $sql = 
            "SELECT users.*, role.name AS role_name 
             FROM users 
             LEFT JOIN role ON users.role_id = role.id 
             WHERE users.id = :id";
    
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo "Lỗi truy vấn bị sai: " . $e->getMessage();
            return false;
        }
    }


    public function checklogin($email, $password) {
        try {
            $sql = "SELECT * FROM users WHERE email = :email";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':email' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if($user && password_verify($password, $user['password'])){
                if($user['role_id'] == 1) {
                    if($user['status'] == 1){
                        return $user['email'];
                    }else{
                        return "Tài khoản này đã bị mất quyền quản trị !!";
                    }
                }
            }else{
                return "Email hoặc mật khẩu không đúng !!";
            }
        } catch (\Exception $e) {
            echo "Lỗi truy vấn bị sai" . $e->getMessage();
            return false;
        }
    }


}