<?php
    class Db {
        private static $conn;
        const SETTINGS = [
            "user" => "r1003207", 
            "password" => "e5s1b8#ZeftS", 
            "host" => "onlinestore.mysql.database.azure.com", 
            "db" => "onlinestore",
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