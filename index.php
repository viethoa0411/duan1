<?php 

require_once './core/database.php';
require_once './core/function.php';


// rquire mọi controllers
require_once './controllers/ClientController.php';
// rquire mọi models



//Route
$act = $_GET['act'] ?? '/';

match ($act) {
    '/' => (new ClientController())->index(),
    


};

