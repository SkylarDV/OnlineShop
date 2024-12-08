<?php 
    session_start();
    if (!isset($_SESSION["email"])) {
        header("Location: login.php");
    }
    
    include_once(__DIR__."/Item.php");
    $products = Item::getAll();
    $category = isset($_GET['category']) ? $_GET['category'] : null;
    $subcategory = isset($_GET['subcategory']) ? $_GET['subcategory'] : null;


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
    if ($subcategory) {
        $products = array_filter($products, function($product) use ($subcategory) {
            return $product["subcategory"] === $subcategory;
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

    <div class="indexPage">

        <div class="topText">
            <h1>Welcome to Ichiban</h1>
            <strong> <?php echo "We hope you enjoy your stay, " . htmlspecialchars($_SESSION["email"]); ?></strong>
            <p>Start by searching in the search bar or filtering by category underneath</p>
        </div>

        <div class="searching">
            <form action="" method="POST">
                <input type="text" name="search" id="search"  placeholder="Use 1 word for most effective searching">
            </form>
            <br>
            <div class="categories">
                <a href="?">All Categories</a>
                -
                <a href="?category=Figurines">Figurines</a>
                -
                <a href="?category=Katana">Katana</a>
                -
                <a href="?category=Food%20And%20Drinks">Food and Drinks</a>
                -
                <a href="?category=Goodies">Goodies</a>
            </div>
            <?php if ($category == "Figurines"): ?>
                <div class="subcategories">
                    <a href="?category=Figurines">All Figurines</a>
                    -
                    <a href="?category=Figurines&subcategory=Manga">Manga Figurines</a>
                    -
                    <a href="?category=Figurines&subcategory=TV%20Shows">TV Show Figurines</a>
                </div>
            <?php endif ?>
            <?php if ($category == "Food And Drinks"): ?>
                <div class="subcategories">
                    <a href="?category=Food%20And%20Drinks">All Food & Drinks</a>
                    -
                    <a href="?category=Food%20And%20Drinks&subcategory=Asian">Asian</a>
                    -
                    <a href="?category=Food%20And%20Drinks&subcategory=Drink">Drink</a>
                    -
                    <a href="?category=Food%20And%20Drinks&subcategory=Salty">Salty</a>
                    -
                    <a href="?category=Food%20And%20Drinks&subcategory=Sweet">Sweet</a>
                    -
                    <a href="?category=Food%20And%20Drinks&subcategory=USA">USA</a>
                </div>
            <?php endif ?>
        </div>
   
        
        <div class="productlist">
            <?php foreach($products as $product): ?>
                <div class="productview">
                    <a href="product.php?id=<?php echo $product["ID"]; ?>">
                        <h2><?php echo htmlspecialchars($product["title"])  ?></h2> 
                        <img src="<?php echo htmlspecialchars( $product["img"]) ?>" alt="">
                        <h3> <?php echo "€ ".htmlspecialchars($product["price"])  ?></h3>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    
</body>
</html>
