<?php 
    session_start();
    include_once(__DIR__."/User.php");
    include_once(__DIR__."/Item.php");
    include_once(__DIR__."/Order.php");
    include_once(__DIR__."/nav.php");

    $user_id = User::getByEmail($_SESSION["email"]);
    $cartItems = Order::getCart($user_id);
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
    <?php foreach($cartItems as $item): ?>
        <?php $product = Item::getByID($item['product_id']); ?>
        <a href="product.php?id=<?php echo $product["ID"]; ?>">
            <h2> <?php echo $product["title"] ?> <?php echo "€ ".$product["price"] ?> </h2>
            <img src="<?php echo $product["img"] ?>" alt="">
        </a>
    <?php endforeach; ?>
</body>
</html>