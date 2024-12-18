<?php
    include_once(__DIR__."/Db.php");
   class Order {
        public static function getCart(int $user) {
            $conn = Db::getConnection();
            $query = $conn->prepare("SELECT `product-orders`.product_id FROM `product-orders` JOIN orders ON `product-orders`.order_id = orders.ID WHERE orders.status = 'cart' AND orders.user_id = :user");
            $query->bindValue(":user", $user);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC); 
        }

        public static function getOrders(int $user) {
            $conn = Db::getConnection();
            $query = $conn->prepare("SELECT `product-orders`.product_id FROM `product-orders` JOIN orders ON `product-orders`.order_id = orders.ID WHERE orders.status = 'complete' AND orders.user_id = :user");
            $query->bindValue(":user", $user);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC); 
        }
        
        public static function addToCart(int $user, int $item) {
            $conn = Db::getConnection();
            $query = $conn->prepare("SELECT ID FROM orders WHERE status = 'cart' AND user_id = :user");
            $query->bindValue(":user", $user);
            $query->execute();
            $order =  $query->fetch(PDO::FETCH_ASSOC); 

            if (empty($order)) {
                $query = $conn->prepare("INSERT INTO orders (user_id, time, address, status) VALUES (:user, NOW(), 'TBD', 'cart')");
                $query->bindValue(":user", $user);
                $query->execute();
            } 

            $query = $conn->prepare("INSERT INTO `product-orders` (product_id, order_id) VALUES (:item, (SELECT ID FROM orders WHERE user_id = :user AND status = 'cart' LIMIT 1));");
            $query->bindValue(":user", $user);
            $query->bindValue(":item", $item);
            $query->execute();
            
            $query = $conn->prepare("SELECT price FROM products WHERE ID = :item");
            $query->bindValue(":item", $item);
            $query->execute();
            $price = $query->fetch(PDO::FETCH_ASSOC);

            $query = $conn->prepare("UPDATE orders SET price = price + :price WHERE user_id = :user AND status = 'cart'");
            $query->bindValue(":user", $user);
            $query->bindValue(":price", $price["price"]);
            $query->execute();
        }

        public static function getTotal($user) {
            $conn = Db::getConnection();
            $query = $conn->prepare("SELECT price FROM orders WHERE user_id = :user AND status = 'cart'");
            $query->bindValue(":user", $user);
            $query->execute();
            $result = $query->fetch(PDO::FETCH_ASSOC);
        
            // Check if cart is empty and say the total is 0 then
            if (empty($result) || !isset($result["price"])) {
                return 0.00; 
            }
        
            $result = (float)$result["price"];
            $result = round($result, 2);
            return $result;
        }
        

        public static function buyOrder(int $user, $address) {
            $conn = Db::getConnection();
            $query = $conn->prepare("SELECT ID FROM orders WHERE user_id = :user AND status = 'cart'");
            $query->bindValue(":user", $user);
            $query->execute();
            $order = $query->fetch(PDO::FETCH_ASSOC);
            $order = $order["ID"];

            $price = self::getTotal($user);

            // Fetch the user's current currency
            $query = $conn->prepare("SELECT currency FROM users WHERE ID = :user");
            $query->bindValue(":user", $user);
            $query->execute();
            $userData = $query->fetch(PDO::FETCH_ASSOC);
            $currentCurrency = $userData['currency'];

            // Check if the user has enough currency
            if ($currentCurrency < $price) {
                throw new Exception("Insufficient funds to complete the purchase.");
            }

            $query = $conn->prepare("UPDATE users SET currency = currency - :price WHERE ID = :user;");
            $query->bindValue(":user", $user);
            $query->bindValue(":price", $price);
            $query->execute();

            $query = $conn->prepare("UPDATE orders SET address = :address, status = 'complete' WHERE ID = :order");
            $query->bindValue(":order", $order);
            $query->bindValue(":address", $address);
            $query->execute();
        }

        public static function removeFromCart(int $user, int $item) {
            $conn = Db::getConnection();
            $query = $conn->prepare("SELECT ID FROM orders WHERE status = 'cart' AND user_id = :user");
            $query->bindValue(":user", $user);
            $query->execute();
            $order =  $query->fetch(PDO::FETCH_ASSOC); 
    
    
            $query = $conn->prepare("DELETE FROM `product-orders` WHERE id = ( SELECT id FROM ( SELECT id FROM `product-orders` WHERE product_id = :item AND order_id = (SELECT ID FROM orders WHERE user_id = :user AND status = 'cart' LIMIT 1) LIMIT 1 ) AS temp );");
            $query->bindValue(":user", $user);
            $query->bindValue(":item", $item);
            $query->execute();
            
            $query = $conn->prepare("SELECT price FROM products WHERE ID = :item");
            $query->bindValue(":item", $item);
            $query->execute();
            $price = $query->fetch(PDO::FETCH_ASSOC);
    
            $query = $conn->prepare("UPDATE orders SET price = price - :price WHERE user_id = :user AND status = 'cart'");
            $query->bindValue(":user", $user);
            $query->bindValue(":price", $price["price"]);
            $query->execute();
        }
    }

   
?>