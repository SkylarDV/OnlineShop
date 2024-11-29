<?php
include_once(__DIR__."/Db.php");
class Review {
    private int $id;
    private int $user_id;
    private int $product_id;
    private int $rating;
    private string $text;

    public function getId() {
        return $this->id;
    }

    public function getUserId() {
        return $this->user_id;
    }

    public function setUserId($user_id) {
        $this->user_id = $user_id;
    }

    public function getProductId() {
        return $this->product_id;
    }

    public function setProductId($product_id) {
        $this->product_id = $product_id;
    }

    public function getRating() {
        return $this->rating;
    }

    public function setRating($rating) {
        // Will always be between 1-5 because of the radio select, so no need for error message
            $this->rating = $rating;
    }

    public function getText() {
        return $this->text;
    }

    public function setText($text) {
        $this->text = $text;
    }

    // Method to save the review to the database
    public function save() {
        $conn = Db::getConnection();

        $query = $conn->prepare("INSERT INTO reviews (user_id, product_id, rating, text) VALUES (:user_id, :product_id, :rating, :text)");
        
        $user_id = $this->getUserId();
        $product_id = $this->getProductId();
        $rating = $this->getRating();
        $text = $this->getText();

        
        $query->bindValue(':user_id', $user_id);
        $query->bindValue(':product_id', $product_id);
        $query->bindValue(':rating', $rating);
        $query->bindValue(':text', $text);

        $result =$query->execute();
        return $result;
    }

    public static function getByProduct($product_id) {
        $conn = Db::getConnection();

        $query = $conn->prepare("SELECT * FROM reviews WHERE product_id = :product_id");
        $query->bindParam(':product_id', $product_id);
        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC); 
    }
}
?>
