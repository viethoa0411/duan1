<?php

require_once 'core/Database.php';
require_once 'controllers/CategoryController.php';

$controller = new CategoryController($pdo);
$act = isset($_GET['act']) ? $_GET['act'] : 'index';
$controller->$act();
