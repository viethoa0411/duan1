<?php

class AdminCategory
{
    private $conn;
    public function __construct()
    {
        $this->conn = connectDB();
    }
public function getAllCategory($keyword = '')
{
    try {
        $sql = "SELECT * FROM categories WHERE 1";

        if (!empty($keyword)) {
            $sql .= " AND name LIKE :keyword";
        }

        $sql .= " ORDER BY updated_at DESC";

        $stmt = $this->conn->prepare($sql);

        if (!empty($keyword)) {
            $stmt->bindValue(':keyword', '%' . $keyword . '%');
        }

        $stmt->execute();
        return $stmt->fetchAll();
    } catch (Exception $e) {
        echo "Lỗi truy vấn danh mục: " . $e->getMessage();
        return false;
    }
}


    public function addCategory($name, $description, $created_at, $updated_at)
    {
        try {
        $stmt = $this->conn->prepare("INSERT INTO categories (`name`, `description`,`created_at`, `updated_at`) VALUES (:name, :description, :created_at, :updated_at)");
        $stmt->execute([
            ':name' => $name,
            ':description' => $description,
            ':created_at' => $created_at,
            ':updated_at' => $updated_at
        ]);
         return $this->conn->lastInsertId();
        } catch (Exception $e) {
            echo "Lỗi truy vấn bị sai: " . $e->getMessage();
            return false;
        }
    }

    public function getCategoryById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM categories WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateCategory($id, $name, $description,$created_at, $updated_at) {
        try {
            $sql = "UPDATE categories SET 
                        name = :name,
                        description = :description,
                        $created_at = :created_at,
                        $updated_at = :updated_at
                    WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':id' => $id,
                ':name' => $name,
                ':description' => $description,
                ':created_at' => $created_at,
                ':updated_at' => $updated_at
            ]);
            return true;
        } catch (Exception $e) {
            echo "Lỗi truy vấn bị sai: " . $e->getMessage();
            return false;
        }
    }

    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM categories WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
