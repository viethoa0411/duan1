<?php

class AdminCategoryController
{

    private $modelCategory;

    public function __construct()
    {
        $this->modelCategory = new AdminCategory();
    }

    public function list()
    {
          $keyword = $_GET['keyword'] ?? '';
        $categories = $this->modelCategory->getAllCategory($keyword);
        require_once './views/admin/categories/list.php';
    }

    public function formAdd()
    {
        require_once './views/admin/categories/add.php';
    }

    public function addCategory()
    {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $created_at = date('Y-m-d H:i:s');
        $updated_at = date('Y-m-d H:i:s');
        $this->modelCategory->addCategory($name, $description, $created_at, $updated_at);
        header('Location: ' . BASE_URL_ADMIN . '?act=categories');
    }

    public function editCategory($id)
    {
        $category = $this->modelCategory->getCategoryById($id);
        require_once './views/admin/categories/edit.php';
    }

    public function updateCategory()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_category'])) {
            $id = $_POST['id'];
            $name = trim($_POST['name']);
            $description = trim($_POST['description']);
            $created_at = date('Y-m-d H:i:s');
            $updated_at = date('Y-m-d H:i:s');
            $result = $this->modelCategory->updateCategory($id, $name, $description,$created_at, $updated_at);
            if ($result) {
                echo '<script>alert("Cập nhật danh mục thành công!");</script>';
                header('Location: ' . BASE_URL_ADMIN . '?act=categories');
                exit();
            } else {
                $error = "Có lỗi xảy ra khi cập nhật danh mục!";
                $category = $this->modelCategory->getCategoryById($id);
                require './Views/admin/categories/edit.php';
            }
        }
    }


        public function delete($id) {
        $result = $this->modelCategory->delete($id);
        if ($result) {
            echo '<script>alert("Xóa sản phẩm thành công!");</script>';
            header('Location: ' . BASE_URL_ADMIN . '?act=categories');
            exit();
        } else {
            echo '<script>alert("Có lỗi khi xóa sản phẩm!");</script>';
            header('Location: ' . BASE_URL_ADMIN . '?act=categories');
            exit();
        }
    }
}
