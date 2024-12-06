<?php 
    session_start();
    if (!isset($_SESSION["email"])) {
        header("Location: login.php");
    }
    
    include_once(__DIR__."/Item.php");
    $products = Item::getAll();
    $category = isset($_GET['category']) ? $_GET['category'] : null;

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
        $search = urlencode($_POST['search']);
        header("Location: index.php?search=$search");  
    }
    $search = isset($_GET['search']) ? $_GET['search'] : null;


    if ($category) {
        $products = array_filter($products, function($product) use ($category) {
            return $product["category"] === $category;
        });
    }
    if ($search) {
        $s = $_GET['search'];
        $products = Item::searchProduct($s);
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
    <h1>Webshop XD</h1>
    <?php echo "Welcome " . htmlspecialchars($_SESSION["email"]); // htmlspecialchars because of the @ in the email ?>
    
    <form action="" method="POST">
            <input type="text" name="search" id="search" size="100" placeholder="Use 1 word for most effective searching">
    </form>
    
    <div class="categories">
        <a href="?">All Categories</a>
        <a href="?category=Figurines">Figurines</a>
        <a href="?category=Katana">Katana</a>
        <a href="?category=Food%20And%20Drinks">Food and Drinks</a>
        <a href="?category=Goodies">Goodies</a>
    </div>
    
    <?php foreach($products as $product): ?>
        <a href="product.php?id=<?php echo $product["ID"]; ?>">
            <h2> <?php echo $product["title"] ?> <?php echo "€ ".$product["price"] ?> </h2>
            <img src="<?php echo $product["img"] ?>" alt="">
        </a>
    <?php endforeach; ?>
</body>
</html>
