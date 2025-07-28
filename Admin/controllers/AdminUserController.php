<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once 'models/AdminUser.php';
class AdminUserController
{
    private $account;
    private $user;
    public function __construct()
    {
        $this->account = new AdminUser();
        $this->user = new AdminUser();
    }

    public function listadmin()
    {
        $accounts = $this->account->getAllAccounts(1);
        require_once './views/admin/users/account.php';
    }

    function detailadmin($id)
    {
        $user = $this->account->getUserById($id);
        if (!$user) {
            echo "Không có tài khoản này.";
            return;
        }
        require_once './views/admin/users/detailadmin.php';
    }


    public function toggleStatus($id)
    {
        $result = $this->account->toggleStatus($id);
        if ($result) {
            header("Location: " . BASE_URL_ADMIN . "?act=accounts");
            exit;
        } else {
            echo "Không thể thay đổi trạng thái.";
        }
    }


    public function formAddAdmin()
    {
        require_once './views/admin/users/addadmin.php';
    }
    public function addadmin()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name     = trim($_POST['name'] ?? '');
            $email    = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $phone    = trim($_POST['phone'] ?? '');
            $address  = trim($_POST['address'] ?? '');

            $errors = [];

            // Kiểm tra dữ liệu nhập vào
            if (empty($name) || empty($email) || empty($password) || empty($phone) || empty($address)) {
                $errors[] = "Vui lòng điền đầy đủ thông tin!";
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Email không hợp lệ!";
            }

            if ($this->account->findEmail($email)) {
                $errors[] = "Email đã tồn tại!";
            }

            if (!empty($errors)) {
                $error = implode("<br>", $errors);
                $old = compact('name', 'email', 'phone', 'address');
                require_once './views/admin/users/addadmin.php';
                return;
            }

            // Hash mật khẩu
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $created_at = date('Y-m-d H:i:s');

            // Gọi model để thêm tài khoản
            $result = $this->account->addadmin($name, $email, $hashedPassword, $phone, $address, $created_at, 1);

            if ($result) {
                $_SESSION['success'] = "Tạo tài khoản admin thành công!";
                header('Location: ' . BASE_URL_ADMIN . '?act=accounts');
                exit;
            } else {
                $error = "Thêm tài khoản thất bại. Vui lòng thử lại.";
                $old = compact('name', 'email', 'phone', 'address');
                require_once './views/admin/users/addadmin.php';
                return;
            }
        }

        // Nếu không phải POST thì hiển thị form
        $error = '';
        $old = [];
        require_once './views/admin/users/addadmin.php';
    }



    public function listuser()
    {
        $users = $this->account->getAllUsers(2);
        require_once './views/admin/users/users.php';
    }

public function detailuser($id)
{
    $user = $this->user->getUserById($id);

    if (!$user) {
        echo "Không tìm thấy khách hàng.";
        return;
    }

    // Gọi model AdminOrder
    require_once 'models/AdminOrder.php';
    $orderModel = new AdminOrder();

    // Lấy lịch sử đơn hàng theo user_id
    $orders = $orderModel->getOrdersByUserId($id);

    include './views/admin/users/detailuser.php';
}

}
