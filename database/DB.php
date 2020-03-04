<?php
require_once "config.php";

class DB
{
    public static $pdo;

    public function connection()
    {
        if (!isset(self::$pdo)) {
            try {
                self::$pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
        return self::$pdo;
    }
    public static function prepare($sql)
    {
        return self::connection()->prepare($sql);
    }
}

?>