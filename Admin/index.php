<?php 

session_start();

require_once '../core/database.php';
require_once '../core/function.php';


// rquire mọi controllers
require_once 'controllers/AdminController.php';
require_once 'controllers/AdminProductController.php';
require_once 'controllers/AdminCategoryController.php';
require_once 'controllers/AdminUserController.php';
require_once 'controllers/AdminAuthController.php';
require_once 'controllers/AdminOrderController.php';

// rquire mọi models
require_once 'models/AdminProduct.php';
require_once 'models/AdminCategory.php';
require_once 'models/AdminUser.php';
require_once 'models/AdminOrder.php';


//Route
$act = $_GET['act'] ?? '/';

if($act !== 'login' && $act !== 'checklogin' && $act !== 'logout') {
    checkLoginadmin();
}

match ($act) {
    
    '/' => (new AdminController()) ->index(),

    // route cho product
    'products' =>(new AdminProductController()) ->list(),
    'formaddproduct'=>(new AdminProductController()) ->formadd(),
    'add/products'=>(new AdminProductController()) ->addProduct(),
    'products/detail'=>(new AdminProductController()) ->detail($id = $_GET['id']),
    'products/edit'=>(new AdminProductController()) ->editProduct($id = $_GET['id']),
    'products/update'=>(new AdminProductController()) ->updateProduct(),
    'products/delete'=>(new AdminProductController()) ->deleteProduct($id= $_GET['id']),



    // route cho category
    'categories' => (new AdminCategoryController()) -> list(),
    'formaddcategory' => (new AdminCategoryController()) -> formAdd(),
    'categories/add' => (new AdminCategoryController()) -> addCategory(),
    'categories/edit'=>(new AdminCategoryController()) ->editCategory($id = $_GET['id']),
    'categories/update'=>(new AdminCategoryController()) ->updateCategory(),
    'categories/delete'=>(new AdminCategoryController()) ->delete($id = $_GET['id']),

    // route cho user
    'users' => (new AdminUserController()) -> list(),
    'users/detail' => (new AdminUserController()) -> detail($id = $_GET['id']),


    // route cho auth
    'login' => (new AdminAuthController()) -> formlogin(),
    'checklogin' => (new AdminAuthController()) -> login(),
    'logout' => (new AdminAuthController()) -> logout(),


    // route cho order
    'orders' => (new AdminOrderController()) -> list(),
};

