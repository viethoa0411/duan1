<?php 

require_once '../core/database.php';
require_once '../core/env.php';


// rquire mọi controllers
require_once 'controllers/AdminController.php';
require_once 'controllers/AdminProductController.php';

// rquire mọi models
require_once 'models/AdminProduct.php';
require_once 'models/AdminCategory.php';


//Route
$act = $_GET['act'] ?? '/';

match ($act) {
    
    '/' => (new AdminController()) ->index(),

    // route cho product
    'products' =>(new AdminProductController()) ->list(),
    'formadd'=>(new AdminProductController()) ->formadd(),
    'products/add'=>(new AdminProductController()) ->addProduct(),
    'products/edit'=>(new AdminProductController()) ->editProduct($id = $_GET['id']),
    'products/update'=>(new AdminProductController()) ->updateProduct(),
    'products/delete'=>(new AdminProductController()) ->deleteProduct($id= $_GET['id']),

};

