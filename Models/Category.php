<?php
class Category {
    private $pdo;
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    public function all() {
        $stmt = $this->pdo->prepare("SELECT * FROM categories ORDER BY id DESC");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function find($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM categories WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    public function create($name, $description) {
        $stmt = $this->pdo->prepare("INSERT INTO categories (name, description) VALUES (?, ?)");
        return $stmt->execute([$name, $description]);
    }
    public function update($id, $name, $description) {
        $stmt = $this->pdo->prepare("UPDATE categories SET name = ?, description = ? WHERE id = ?");
        return $stmt->execute([$name, $description, $id]);
    }
    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM categories WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
