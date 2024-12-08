

<?php 
    include_once(__DIR__."/User.php");
    include_once(__DIR__."/Order.php");
    
    if (isset($_SESSION["email"])){$user_id = User::getByEmail($_SESSION["email"]);};

?>

<head>
    <link rel="stylesheet" href="style.css">
</head>

<nav class="navbar">
    <?php if (isset($_SESSION["email"])): ?>
        <div class="navContent">
            <div class="userLinks">
                <img class="icon" src="<?php echo User::getUserPfp($_SESSION["email"])?>"  alt="">
                <h3><a class="user" href="profile.php"><?php echo htmlspecialchars( $_SESSION["email"]); ?></a></h3>                
                <?php if (User::checkIfAdmin($_SESSION["email"])): ?>
                    <a class="newItem" href="newItem.php">Add Item</a>
                <?php endif; ?>
            </div>
            <a href="index.php"><img class="indexRdr" src="https://cdn.shopify.com/s/files/1/0274/1056/3133/files/thumbnail_IMG-20210427-WA0013-PhotoRoom_2.png?v=1666703498" alt=""></a>
            <div class="leftNav">
                <strong>€ <?php echo Order::getTotal($user_id) ?></strong>
                <a href="cart.php"><img class="icon cart" src="https://www.iconpacks.net/icons/2/free-shopping-cart-icon-3045-thumb.png" alt=""></a>
                <a class="logout" href="logout.php">Log Out?</a>
            </div>
        </div>
    <?php else: ?>
        <div class="navContent">
            <img class="icon" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS7mMNz8YCBvYmnr3BQUPX__YsC_WtDuAevwg&s" alt="">
            <h3 class="user">GUEST</h3>
            <a class="logout" href="login.php">Log In</a>    
        </div>
    <?php endif; ?>
</nav>

