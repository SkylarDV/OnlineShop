<?php
    class Db {
        private static $conn;


        public static function getConnection(){
            
            $user = getenv("user");
            $password = getenv("password");
            $host = getenv("host");
            $db = getenv("db");

            $SETTINGS = [
                "user" => $user, 
                "password" => $password, 
                "host" => $host, 
                "db" => $db,
                "ssl_ca" => __DIR__ . "/cacert.pem"
            ];

            if (self::$conn === null) {
                $options[PDO::MYSQL_ATTR_SSL_CA] = $SETTINGS['ssl_ca'];
                self::$conn = new PDO("mysql:host=".$SETTINGS["host"].";dbname=".$SETTINGS["db"]."",$SETTINGS["user"],$SETTINGS["password"], $options);
                // [PDO::MYSQL_ATTR_SSL_CA => __DIR__."/CA.pem"]
                return self::$conn;
            }
            else {return self::$conn;}
        }
    }
?>