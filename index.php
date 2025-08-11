<?php
session_start();

// Autoload hoặc require các thành phần chính
require_once './core/database.php';
require_once './core/function.php';

// Models
require_once './models/Product.php';
require_once './models/Review.php';
require_once './models/Variant.php';
require_once './models/Auth.php';
require_once './models/Cart.php';
require_once './models/Order.php';

// Controllers
require_once './controllers/ClientController.php';
require_once './controllers/AuthController.php';
require_once './controllers/CartController.php';
require_once './controllers/OrderController.php';

// Lấy hành động từ URL
$act = $_GET['act'] ?? '/';

// Các hành động không yêu cầu đăng nhập
$public_actions = ['/', 'detail', 'login', 'check-login', 'register', 'register_form'];

// Kiểm tra quyền truy cập
if (!isset($_SESSION['user_client']) && !in_array($act, $public_actions)) {
    $_SESSION['error'] = "Vui lòng đăng nhập để sử dụng chức năng này!";
    header('Location: ' . BASE_URL . '?act=login');
    exit();
}

// Nếu đã đăng nhập thì không cho vào trang login/register nữa
if (isset($_SESSION['user_client']) && in_array($act, ['login', 'register_form'])) {
    header('Location: ' . BASE_URL);
    exit();
}

// Định tuyến và gọi controller/method tương ứng
$routes = match ($act) {
    '/'                  => (new ClientController())->index(),
    'detail'             => (new ClientController())->detail($_GET['id'] ?? null),
    'search'             => (new ClientController())->search(),


    'category_female'   => (new CategoryController($db))->showFemaleCategories(),
    'category_male'     => (new CategoryController($db))->showMaleCategories(),

    // Auth
    'register'           => (new AuthController())->register(),
    'register_form'      => (new AuthController())->showRegisterForm(),
    'login'              => (new AuthController())->formlogin(),
    'check-login'        => (new AuthController())->postlogin(),
    'logout'             => (new AuthController())->logout(),

    // Đơn hàng
    'history'            => (new OrderController())->history(),
    'remote-order'      => (new OrderController())->removeOrder($_GET['id']),

    // Giỏ hàng
    'cart'               => (new CartController())->list(),
    'cart_add'           => (new CartController())->add(),
    'update-cart'      => (new CartController())->update(),

    'remove-from-cart'   => (new CartController())->remove(),

    // Thanh toán
    'cart-to-checkout'   => (new CartController())->checkout(),
    'checkout'           => (new OrderController())->checkout(),
    'place-order'        => (new OrderController())->placeOrder(),
    'order-success'      => (new OrderController())->showOrderSuccessPage(),
    'detailorder'   => (new OrderController())->orderDetail($id = $_GET['id']),


    'profile'      => (new ClientController())->userProfile(),
    'post_update_profile' => (new ClientController())->postUpdateProfile(),
    'change_password'   => (new ClientController())->userProfile(),
    'post_change_password' => (new AuthController())->postChangePassword(),
    // Mặc định: trả về 404 nếu không tìm thấy route
    default              => include './views/clients/errors/404.php',
};
