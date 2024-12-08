<?php 
    include_once(__DIR__."/Item.php");
    include_once(__DIR__."/Review.php");
    include_once(__DIR__."/User.php");
    include_once(__DIR__."/Order.php");

    session_start();
    if (!isset($_SESSION["email"])) {
        header("Location: login.php");
    }
    else { $user_id =  User::getByEmail($_SESSION["email"]); }
    $ID = $_GET["id"];
    
    $product = Item::getByID($ID);
    $reviews = Review::getByProduct($ID);

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cart'])) {
        Order::addToCart($user_id, $ID);
    }

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
    <title>Viewing Product</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include_once("nav.php"); ?>

    <div class="productpage">
        <div class="productinfo">
            <h2> <?php echo htmlspecialchars($product["title"])  ?></h2>
            <img src="<?php echo $product["img"] ?>" alt="">
            <h3> <?php echo "€ ".htmlspecialchars($product["price"]) ?> </h3>
            <p> <?php echo htmlspecialchars($product["description"])  ?></p>
            <form method="POST">
                <button class="subbtn" type="submit" name="cart">Add to cart</button>
            </form> 
            <?php if (User::checkIfAdmin($_SESSION["email"])):?>
                ------------------------------------------------------------------------------------------------
                <div class="adminbtns">
                    <form method="POST">
                        <button class="subbtn" type="submit" name="edit_item">Edit Item</button>
                    </form> 
                    <form method="POST">
                        <button class="subbtn" type="submit" name="delete_item">Delete Item</button>
                    </form>
                </div>
                
            <?php endif;?>
        </div>

        <br>

        <div class="reviewMsgs"> 
            <h3>Reviews of this product by others:</h3> 
            <?php foreach($reviews as $review): ?>
                <div class="reviewMsg">
                    <h2> <?php echo htmlspecialchars($review["rating"])  ?>✬</h2>
                    <p><?php echo htmlspecialchars($review["text"])  ?></p>
                </div>
                <br>
            <?php endforeach;?>
        </div> 
        
        <?php if (Review::checkIfBought($user_id, $ID)): ?>
            <div class="review">
                <form action="" method="POST">
                    <h2>It seems you bought this product in the past</h2>
                    <p>Mind telling us your opinion?</p>
                    <label for="score">Your rating of this product out of five</label>
                    <br>
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
                    <input type="text" name="text" id="commentText" size="100">

                    <br>
                    <br>

                    <input class="subbtn" type="button" id="btnAddReview" data-user_id="<?php echo $user_id ?>" data-product_id="<?php echo $ID ?>" value="Post Review" class="btn">
                </form>
            </div>
        <?php endif; ?>
    </div>
  
    

    <script src="reviews.js"></script>

</body>
</html>