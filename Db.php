<?php
    class Db {
        private static $conn;

        private string $user = getenv("user");
        private string $password = getenv("password");
        private string $host = getenv("host");
        private string $db = getenv("db");

        
        const SETTINGS = [
            "user" => $user, 
            "password" => $password, 
            "host" => $host, 
            "db" => $db,
            "ssl_ca" => __DIR__ . "/cacert.pem"
        ];


        public static function getConnection(){
            if (self::$conn === null) {
                $options[PDO::MYSQL_ATTR_SSL_CA] = self::SETTINGS['ssl_ca'];
                self::$conn = new PDO("mysql:host=".self::SETTINGS["host"].";dbname=".self::SETTINGS["db"]."",self::SETTINGS["user"],self::SETTINGS["password"], $options);
                // [PDO::MYSQL_ATTR_SSL_CA => __DIR__."/CA.pem"]
                return self::$conn;
            }
            else {return self::$conn;}
        }
    }
?>