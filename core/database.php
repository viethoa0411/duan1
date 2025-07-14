<?php 

class database{
    private static $instance = null;
     
    public static function getConnection(){
        if(self::$instance === null) {
            try {
                $host = 'localhost';
                $db = 'duan1';
                $usename = 'root';
                $password = '';

                self::$instance = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $usename, $password);

                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch(PDOException $e) {
                die("Kết nối thất bại: " . $e->getMessage());
            }
        }

        return self::$instance;
    }
}