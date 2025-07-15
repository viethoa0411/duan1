<?php

$host = 'localhost';
$dbname = 'duan1';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
} catch (PDOException $e) {
    die("Kết nối thất bại: " . $e->getMessage());
}
