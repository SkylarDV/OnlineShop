<?php 
    session_start();
    if (!isset($_SESSION["email"])) {
        header("Location: login.php");
    }

    include_once(__DIR__."/User.php");
    include_once(__DIR__."/Item.php");
    include_once(__DIR__."/Order.php");

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $nPassword = $_POST["new_password"];
        $cPassword = $_POST["confirm_password"];
        
        if ($nPassword === $cPassword) {
            $email = $_SESSION["email"];
            User::changePassword($email, $nPassword);
            $feedback= "Password successfully updated!";
        } else {
            $feedback = "Passwords do not match.";
        }
    }

    $user_id = User::getByEmail($_SESSION["email"]);
    $orderItems = Order::getOrders($user_id);
    
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
        
    <div class="cartPage">
        <div class="top">
            <h2>Your past orders</h2> 
        </div>
        
        <div class="productlist">
            <?php foreach($orderItems as $item): ?>
                <?php $product = Item::getByID($item['product_id']); ?>
                <div class="productview">
                    <a href="product.php?id=<?php echo $product["ID"]; ?>">
                        <h2> <?php echo $product["title"] ?> <?php echo "€ ".$product["price"] ?> </h2>
                        <img src="<?php echo $product["img"] ?>" alt="">
                        <h3><?php echo "€ ".$product["price"] ?></h3>
                    </a>
                </div>
                
            <?php endforeach; ?>
        </div>

        

        <form class="bottom" method="POST" action="">
            <h2>Change password</h2>
            <label for="new_password">New Password:</label>
            <input type="password" id="new_password" name="new_password" required>
            
            <br>

            <label for="confirm_password">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
            
            <br>
            <?php if(isset($feedback)): ?> 
                <strong class="error"><?php echo $feedback?></strong>
                <br>
            <?php endif; ?>

            <button type="submit">Change Password</button>
        </form>
    </div>
</body>
</html>