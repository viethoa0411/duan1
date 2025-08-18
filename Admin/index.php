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
    'add/variant'=>(new AdminProductController()) ->formaddVariant($id = $_GET['id']),
    'variant/add'=>(new AdminProductController()) ->addVariant(),
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
    //route admin
    'accounts' => (new AdminUserController()) -> listadmin(),
    'accounts/detail' => (new AdminUserController()) -> detailadmin($id = $_GET['id']),
    'accounts/toggleStatus' => (new AdminUserController()) -> toggleStatus($_GET['id']),
    'accounts/add' => (new AdminUserController()) -> formAddAdmin(),
    'add/admin' => (new AdminUserController()) -> addAdmin(),

    //route khách hàng
    'users' => (new AdminUserController()) -> listuser(),
    'users/detail' => (new AdminUserController()) -> detailuser($id = $_GET['id']),



    // route cho auth
    'login' => (new AdminAuthController()) -> formlogin(),
    'checklogin' => (new AdminAuthController()) -> login(),
    'logout' => (new AdminAuthController()) -> logout(),


    // route cho order
    'orders' => (new AdminOrderController()) -> list(),
    'orders/detail' => (new AdminOrderController()) -> detail($id = $_GET['id']),
    'orders/update' =>  (new AdminOrderController()) -> updateStatus(),

    
};

