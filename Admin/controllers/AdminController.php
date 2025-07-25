<?php 

class AdminController {
    public function index(){
        require_once './views/admin/dashboard.php';
    }

    private function checkLogin()
    {
        session_start();
        
        if (!isset($_SESSION['user_admin'])) {
            header('Location: ' . BASE_URL_ADMIN . '?act=login');
            exit();
        }
    }
}