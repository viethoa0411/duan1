<?php
require_once './Models/Category.php';
require_once './core/database.php';

class CategoryController {
    private $category;
    public function __construct() {
        $this->category = new Category($GLOBALS['pdo']);
    }
    public function index() {
        $categories = $this->category->all();
        $view = './Views/admin/categories/index.php';
        include './Views/layouts/admin_layout.php';
    }
    public function create() {
        $view = './Views/admin/categories/create.php';
    include './Views/layouts/admin_layout.php';
    }
    public function store() {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $this->category->create($name, $description);
        header('Location: ?controller=category&act=index');
    }
    public function edit() {
        $id = $_GET['id'];
        $category = $this->category->find($id);
        $view = './Views/admin/categories/edit.php';
    include './Views/layouts/admin_layout.php';
    }
    public function update() {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $description = $_POST['description'];
        $this->category->update($id, $name, $description);
        header('Location: ?controller=category&act=index');
    }
    public function delete() {
        $id = $_GET['id'];
        $this->category->delete($id);
        header('Location: ?controller=category&act=index');
    }
}
