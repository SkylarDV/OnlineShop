<?php
    class Db {
        private static $conn;
        const SETTINGS = [
            "user" => "root", //r1003207
            "password" => "root", //e5s1b8#ZeftS
            "host" => "localhost", //onlinestore.mysql.database.azure.com
            "db" => "onlinestore"
        ];

        public static function getConnection(){
            if (self::$conn === null) {
                self::$conn = new PDO("mysql:host=".self::SETTINGS["host"].";dbname=".self::SETTINGS["db"]."",self::SETTINGS["user"],self::SETTINGS["password"]);
                // [PDO::MYSQL_ATTR_SSL_CA => __DIR__."/CA.pem"]
                return self::$conn;
            }
            else {return self::$conn;}
        }
    }
?>
