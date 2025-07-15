<?php 

require_once 'Models/Category.php';

class CategoryController {
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function index()
    {
        $categoryModel = new Category($this->db);
        $categories = $categoryModel->getAllCategories();

        // Gửi dữ liệu sang view
        require './views/admin/dashboard.php';
    }
}