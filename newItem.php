<?php
    session_start();
    include_once(__DIR__ . "/Item.php");
    include_once(__DIR__."/User.php");

    if(!User::checkIfAdmin($_SESSION["email"])) {
        header("Location: index.php");
    }

    if (!empty($_POST)) {
        try {$product = new Item();
        $product->setName($_POST["title"]);
        $product->setDescription($_POST["desc"]);
        $product->setImage($_POST["img"]);
        $product->setPrice($_POST["price"]);
        $product->setCategory($_POST["category"]);
        $product->setSubcategory($_POST["subcategory"]);
        $product->save();
        } catch (InvalidArgumentException $e) {
            echo "Error: " . $e->getMessage();
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
    <div class="loginpage">
        <form class="login wider" action="" method="post">
            
            <div>
                <label for="title">Product Name</label>
                <input type="text" name="title" id="title">
            </div>
            
            <br>

            <div>
                <label for="price">Price</label>
                <input type="float" name="price" id="price">
            </div>
            
            <br>

            <div>
                <label for="desc">Description</label>
                <input type="text" name="desc" id="desc">
            </div>
            
            <br>

            <div>
                <label for="img">Image URL</label>
                <input type="text" name="img" id="img">
            </div>
            
            <br>

            <div>
                <label for="category">Category</label>
                <select name="category" id="category">
                    <option value="Foods and Drinks">Foods & Drinks</option>
                    <option value="Figurines">Figurines</option>
                    <option value="Katana">Katana</option>
                    <option value="Goodies">Goodies</option>
                </select>    
            </div>
            
            <br>

            <div>
                <label for="subcategory">Subcategory</label>
                <select name="subcategory" id="subcategory">
                    <option value=""> </option>
                    <option value="Asian">Asian</option>
                    <option value="USA">USA</option>
                    <option value="Sweet">Sweet</option>
                    <option value="Salty">Salty</option>
                    <option value="Drink">Drink</option>
                    <option value="Manga">Manga</option>
                    <option value="TV Shows">TV Shows</option>
                </select>  
            </div>
            

            <br>

            <input class="subbtn" type="submit" value="Create Product" class="btn">
            <a href="index.php">Go back to all products</a>
        </form>
    </div>
    
</body>
</html>