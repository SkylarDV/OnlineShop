<?php
    include_once(__DIR__."/Db.php");
   class Order {
        private int $user_id;
        private DateTime $time;
        private string $address;
        private string $status;
    
        // Getter and Setter for $user_id
        public function getUserId(): int {
            return $this->user_id;
        }
    
        public function setUserId(int $user_id): void {
            $this->user_id = $user_id;
        }
    
        // Getter and Setter for $time
        public function getTime(): DateTime  {
            return $this->time;
        }
    
        public function setTime(DateTime $time): void {
            $this->time = $time;
        }
    
        // Getter and Setter for $address
        public function getAddress(): string {
            return $this->address;
        }
    
        public function setAddress(string $address): void {
            $this->address = $address;
        }
    
        // Getter and Setter for $status
        public function getStatus(): string {
            return $this->status;
        }
    
        public function setStatus(string $status): void {
            $this->status = $status;
        }

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


            $query = $conn->prepare("INSERT INTO `product-orders` (product_id, order_id) VALUES (:item, (SELECT ID FROM orders WHERE user_id = :user AND status = 'cart' AND address = 'TBD' LIMIT 1));");
            $query->bindValue(":user", $user);
            $query->bindValue(":item", $item);
            $query->execute();
        }
    }

?>