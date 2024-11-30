<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");


    include_once(__DIR__."/Review.php");

    if(!empty($_POST)) {
        $r = new Review();
        
        $rating = $_POST['rating'];
        $text = $_POST['text']; 
        $product_id = $_POST['product_id'];
        $user_id = $_POST['user_id'];

        $r = new Review();
        $r->setProductId($product_id);  
        $r->setText($text);              
        $r->setRating($rating);          
        $r->setUserId($user_id);

        $r -> save();

        $response = [
            "status" => "success",
            "message" => "Review saved, thank you",
            "text" => htmlspecialchars($r->getText()),
            "rating" => htmlspecialchars($r->getRating())
        ];

        header("Content-Type: application/json");
        echo json_encode($response);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid request method or empty data']);
            http_response_code(400); 
        }
    
?>
