<?php
class Auth
{
    private $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }
    public function checklogin($email, $password)
    {
        try {
            $sql = "SELECT * FROM users WHERE email = :email";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':email' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                return $user;
            } else {
                return "Email hoặc mật khẩu không đúng !!";
            }
        } catch (\Exception $e) {
            echo "Lỗi truy vấn: " . $e->getMessage();
            return false;
        }
    }

    public function findEmail($email): mixed
    {
        try {
            // Nếu $email là mảng, cố lấy key 'email'
            if (is_array($email) && isset($email['email'])) {
                $email = $email['email'];
            }

            $sql = "SELECT * FROM users WHERE email = :email";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':email' => $email]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo "Lỗi truy vấn: " . $e->getMessage();
            return false;
        }
    }



    public function createUser($name, $email, $password, $phone, $address, $created_at)
    {
        try {
            $sql = "INSERT INTO users (name, email, password, phone, address, role_id, created_at,updated_at, status)
                    VALUES (:name, :email, :password, :phone, :address, :role_id, :created_at,:updated_at, :status)";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                ':name'       => $name,
                ':email'      => $email,
                ':password'   => $password,
                ':phone'      => $phone,
                ':address'    => $address,
                ':role_id'    => 2,
                ':created_at' => $created_at,
                ':updated_at' => $created_at,
                ':status'     => 1
            ]);
        } catch (Exception $e) {
            echo "Lỗi khi tạo tài khoản: " . $e->getMessage();
            return false;
        }
    }

        public function updateUser($userId, $name, $email, $phone, $address)
    {
        try {
            $sql = "UPDATE users SET name = :name, email = :email, phone = :phone, address = :address WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':name' => $name,
                ':email' => $email,
                ':phone' => $phone,
                ':address' => $address,
                ':id' => $userId
            ]);
            return true;
        } catch (PDOException $e) {
            echo "Lỗi: " . $e->getMessage();
            return false;
        }
    }

        public function changePassword($userId, $oldPassword, $newPassword)
{
    try {
        $sql = "SELECT password FROM users WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $userId]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($oldPassword, $user['password'])) {
            $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $updateSql = "UPDATE users SET password = :password WHERE id = :id";
            $updateStmt = $this->conn->prepare($updateSql);
            $updateStmt->execute([
                ':password' => $hashedNewPassword,
                ':id' => $userId
            ]);
            return true;
        }
        return false;
    } catch (\Exception $e) {
        echo "Lỗi khi đổi mật khẩu: " . $e->getMessage();
        return false;
    }
}
}
