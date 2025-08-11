<?php

class AuthController
{
    private $user;
    public function __construct()
    {
        $this->user = new Auth();
    }
    public function formlogin()
    {
        require_once './views/clients/auth/login.php';
    }

    public function postlogin()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $user = $this->user->checklogin($email, $password);
            if (is_array($user)) {
                $_SESSION['user_client'] = $user;
                header('Location: ' . BASE_URL);
                exit();
            } else {
                $_SESSION['error'] = $user;
                $_SESSION['flash'] = true;
                header('Location: ' . BASE_URL . '?act=login');
                exit();
            }
        }
    }
    public function logout()
    {
        session_unset();
        session_destroy();
        header('Location: ' . BASE_URL);
        exit();
    }
    public function showRegisterForm()
    {
        require_once './views/clients/auth/register.php';
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name       = trim($_POST['name'] ?? '');
            $email      = trim($_POST['email'] ?? '');
            $password   = $_POST['password'] ?? '';
            $repassword = $_POST['repassword'] ?? '';
            $phone      = trim($_POST['phone'] ?? '');
            $address    = trim($_POST['address'] ?? '');

            $errors = [];
            if (empty($name) || empty($email) || empty($password) || empty($repassword) || empty($phone) || empty($address)) {
                $errors[] = "Vui lòng điền đầy đủ thông tin!";
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Email không hợp lệ!";
            }

            if ($password !== $repassword) {
                $errors[] = "Mật khẩu nhập lại không khớp!";
            }

            if ($this->user->findEmail($email)) {
                $errors[] = "Email đã tồn tại!";
            }

            if (!empty($errors)) {
                $error = implode("<br>", $errors);
                require_once './views/clients/auth/register.php';
                return;
            }

            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $created_at = date('Y-m-d H:i:s');

            $this->user->createUser($name, $email, $hashedPassword, $phone, $address, $created_at);

            header("Location: index.php?act=register&success=1");
            exit;
        }

        $this->showRegisterForm();
    }


    public function postChangePassword()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userId = $_SESSION['user_client']['id'];
            $oldPassword = $_POST['old_password'];
            $newPassword = $_POST['new_password'];
            $confirmPassword = $_POST['confirm_password'];

            if ($newPassword !== $confirmPassword) {
                $_SESSION['error'] = 'Mật khẩu mới và xác nhận mật khẩu không khớp.';
                header('Location: ' . BASE_URL . '?act=profile');
                exit;
            }

            $result = $this->user->changePassword($userId, $oldPassword, $newPassword);

            if ($result) {
                $_SESSION['success'] = 'Đổi mật khẩu thành công.';
            } else {
                $_SESSION['error'] = 'Mật khẩu cũ không đúng. Vui lòng thử lại.';
            }
            header('Location: ' . BASE_URL . '?act=profile');
            exit;
        }
    }
}
