<?php

class DB
{
    private static $instance;

    public static function get()
    {
        if (!self::$instance) {
            try {
                $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME;
                self::$instance = new PDO($dsn, DB_USER, DB_PASS);
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("DB Connection Failed: " . $e->getMessage());
            }
        }

        return self::$instance;
    }
}
