<?php 

require_once 'models/AdminUser.php';

class AdminAuthController {

    private $user;
    public function __construct() {
        $this->user = new AdminUser() ;
    }
    public function formlogin(){
        require_once './views/admin/auth/login.php';

        
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $user = $this->user->checklogin($email, $password);

            if($user == $email) {
                $_SESSION['user_admin'] = $user;
                header('Location: ' . BASE_URL_ADMIN);
                exit();
            }else{
                $_SESSION['error'] = $user;

                $_SESSION['flash'] = true;

                header('Location: ' . BASE_URL_ADMIN . '?act=login');
                exit();

            }
        }
    }
public function logout()
{
    unset($_SESSION['user_admin']);
    // Chuyển về trang đăng nhập
    header('Location: ' . BASE_URL_ADMIN . '?act=login');
    exit();
}




}