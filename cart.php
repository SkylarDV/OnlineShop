<?php 
    session_start();
    include_once(__DIR__."/User.php");
    include_once(__DIR__."/Item.php");
    include_once(__DIR__."/Order.php");
    include_once(__DIR__."/nav.php");

    $user_id = User::getByEmail($_SESSION["email"]);
    $cartItems = Order::getCart($user_id);

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['buy']) && !empty($_POST["address"])) {
        $address = $_POST["address"];
        try {
            Order::buyOrder($user_id, $address);
        } catch (Exception $e) {
            echo $e->getMessage(); // Handle the error appropriately
        }
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
    <h2>Shopping cart</h2>
    <h3><?php echo Order::getTotal($user_id) ?></h3>
    <?php foreach($cartItems as $item): ?>
        <?php $product = Item::getByID($item['product_id']); ?>
        <a href="product.php?id=<?php echo $product["ID"]; ?>">
            <h2> <?php echo $product["title"] ?> <?php echo "€ ".$product["price"] ?> </h2>
            <img src="<?php echo $product["img"] ?>" alt="">
        </a>
    <?php endforeach; ?>

    <form method="POST">
        <label for="address">Your Address</label>
        <input type="text" name="address" id="address">
        <br>
        <button type="submit" name="buy">Buy these items</button>
    </form> 
</body>
</html>