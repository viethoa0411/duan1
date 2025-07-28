<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

class AdminUser
{
    private $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }


    public function getAllAccounts($role_id)
    {
        try {
            $sql = 'SELECT * FROM users WHERE role_id = :role_id';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':role_id' => $role_id]);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo "Lỗi truy vấn bị sai: " . $e->getMessage();
            return [];
        }
    }

    public function getAllUsers($role_id)
    {
        try {
            $sql = 'SELECT * FROM users WHERE role_id = :role_id';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':role_id' => $role_id]);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo "Lỗi truy vấn bị sai: " . $e->getMessage();
            return [];
        }
    }

    function getUserById($id)
    {
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

    public function getOrdersByUserId($user_id) {
    try {
        $sql = "SELECT orders.*, status.name AS status_name, payment_methods.name AS payment_method_name
                FROM orders
                LEFT JOIN status ON orders.status_id = status.id
                LEFT JOIN payment_methods ON orders.payment_method = payment_methods.id
                WHERE orders.user_id = :user_id
                ORDER BY orders.order_date DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        echo "Lỗi truy vấn lịch sử đơn hàng: " . $e->getMessage();
        return [];
    }
}


    public function toggleStatus($id)
    {
        try {
            // Lấy trạng thái hiện tại
            $user = $this->getUserById($id);
            if (!$user) return false;

            $newStatus = $user['status'] == 1 ? 0 : 1;

            $sql = "UPDATE users SET status = :status WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':status', $newStatus, PDO::PARAM_INT);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (Exception $e) {
            echo "Lỗi cập nhật trạng thái: " . $e->getMessage();
            return false;
        }
    }

public function addadmin($name, $email, $password, $phone, $address, $created_at, $status = 1)
{
    try {
        $check = $this->conn->prepare("SELECT id FROM users WHERE email = :email");
        $check->execute([':email' => $email]);
        if ($check->rowCount() > 0) {
            echo "Email đã tồn tại!";
            return false;
        }

        $sql = "INSERT INTO users (name, email, password, phone, address, role_id, created_at, status)
                VALUES (:name, :email, :password, :phone, :address, :role_id, :created_at, :status)";
        $stmt = $this->conn->prepare($sql);

        $result = $stmt->execute([
            ':name'       => $name,
            ':email'      => $email,
            ':password'   => $password,
            ':phone'      => $phone,
            ':address'    => $address,
            ':role_id'    => 1,
            ':created_at' => $created_at,
            ':status'     => $status
        ]);

        if (!$result) {
            $error = $stmt->errorInfo();
            echo "<pre>Lỗi SQL: " . print_r($error, true) . "</pre>"; // ✅ IN RA TOÀN BỘ LỖI
        }

        return $result;

    } catch (Exception $e) {
        echo "<pre>Lỗi Exception: " . $e->getMessage() . "</pre>";
        return false;
    }
}





    public function findEmail($email)
    {
        $sql = "SELECT id FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function checklogin($email, $password)
    {
        try {
            $sql = "SELECT * FROM users WHERE email = :email";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':email' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                if ($user['role_id'] == 1) {
                    if ($user['status'] == 1) {
                        return $user['email'];
                    } else {
                        return "Tài khoản này đã bị mất quyền quản trị !!";
                    }
                }
            } else {
                return "Email hoặc mật khẩu không đúng !!";
            }
        } catch (\Exception $e) {
            echo "Lỗi truy vấn bị sai" . $e->getMessage();
            return false;
        }
    }
}
