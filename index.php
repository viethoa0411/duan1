<?php 

require_once 'core/Database.php';
require_once 'controllers/CategoryController.php';

$controller = new CategoryController($pdo);
$controller->index();




