<?php 

require_once 'core/Database.php';
require_once 'controllers/CategoryController.php';

$db = Database::getConnection();

$controller = new CategoryController();
$controller->index();


