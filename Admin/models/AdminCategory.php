<?php

class AdminCategory
{
    private $conn;
    public function __construct()
    {
        $this->conn = connectDB();
    }
    public function getAllCategory()
    {
        try {
            $sql = "SELECT * FROM categories";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo "Lỗi truy vấn bị sai: " . $e->getMessage();
            return false;
        }
    }

    public function addCategory($name, $description)
    {
        $stmt = $this->conn->prepare("INSERT INTO categories (name, description) VALUES (?, ?)");
        return $stmt->execute([$name, $description]);
    }

    public function getCategoryById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM categories WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateCategory($id, $name, $description) {
        try {
            $sql = "UPDATE categories SET 
                        name = :name,
                        description = :description
                    WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':id' => $id,
                ':name' => $name,
                ':description' => $description
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
