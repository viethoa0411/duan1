<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once 'models/AdminUser.php';
class AdminUserController {
    private $user;
    public function __construct() {
        $this->user = new AdminUser();
    }

    public function list() {
        $users = $this->user->getAllUsers();
        require_once './views/admin/users/list.php';
    }

    function detail($id) {
        $user = $this->user->getUserById($id);
        if (!$user) {
            echo "Không có người dùng này.";
            return;
        }
        require_once './views/admin/users/detail.php';
    }

    
}