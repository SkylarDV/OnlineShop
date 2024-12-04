<?php 
    include_once(__DIR__."/Item.php");
    include_once(__DIR__."/Review.php");
    include_once(__DIR__."/User.php");

    session_start();
    if (!isset($_SESSION["email"])) {
        header("Location: login.php");
    }
    else { $user_id =  User::getByEmail($_SESSION["email"]); }
    $ID = $_GET["id"];
    
    $product = Item::getByID($ID);
    $reviews = Review::getByProduct($ID);

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_item'])) {
        header("Location:editItem.php?id=$ID");
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_item'])) {
        Item::deleteItem($ID);
        header("Location:index.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include_once("nav.php"); ?>
  
        <div>
            <h2> <?php echo $product["title"] ?></h2>
            <img src="<?php echo $product["img"] ?>" alt="">
            <h3> <?php echo "€ ".$product["price"] ?> </h3>
            <p> <?php echo $product["description"] ?></p>
        </div>
  

    <?php if (User::checkIfAdmin($_SESSION["email"])) {
    echo '<form method="POST">
        <button type="submit" name="edit_item">Edit Item</button>
    </form> 
    <br> 
    <form method="POST">
        <button type="submit" name="delete_item">Delete Item</button>
    </form>';
    } 
    ?>

    <div class="reviewMsgs"></div>  
        <?php foreach($reviews as $review): ?>
            <div class="reviewMsg">
                <h2> <?php echo $review["rating"] ?></h2>
                <p><?php echo $review["text"] ?></p>
            </div>
        <?php endforeach;?>
    </div> 

    <form action="" method="POST">
        <label for="score">Your rating of this product out of five</label>
        <br>
        
        <div class="labels">
            <label for="star1">1</label>
            <label for="star2">2</label>
            <label for="star3">3</label>
            <label for="star4">4</label>
            <label for="star5">5</label>
        </div>
        

        <br>

        <div class="radio">
            <input type="radio" id="star1" name="rating" value="1" required>
            <input type="radio" id="star2" name="rating" value="2">
            <input type="radio" id="star3" name="rating" value="3">
            <input type="radio" id="star4" name="rating" value="4">
            <input type="radio" id="star5" name="rating" value="5">
        </div>
        

        <br>

        <label for="text">Your Review</label>
        <br>
        <input type="text" name="text" id="commentText" size="200">

        <br>

        <input type="button" id="btnAddReview" data-user_id="<?php echo $user_id ?>" data-product_id="<?php echo $ID ?>" value="Post Review" class="btn">
    </form>

    <script src="reviews.js"></script>

</body>
</html>