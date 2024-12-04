<?php
    session_start();
    include_once(__DIR__ ."/Item.php");
    include_once(__DIR__."/User.php");

    if(!User::checkIfAdmin($_SESSION["email"])) {
        header("Location: index.php");
    }

    $ID = (int) $_GET["id"];
    $product = Item::getByID($ID);


    if (!empty($_POST)) {
        try {$product = new Item();
        $product->setName($_POST["title"]);
        $product->setDescription($_POST["desc"]);
        $product->setImage($_POST["img"]);
        $product->setPrice($_POST["price"]);
        $product->setCategory($_POST["category"]);
        $product->setSubcategory($_POST["subcategory"]);
        $product->update($ID);
        header("Location: product.php?id=$ID");
        exit;
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
</head>
<body>
<form action="" method="post">
        <label for="title">Product Name</label>
        <br>
        <p>Was: <?php echo $product["title"] ?></p>
        <br>
        <input type="text" name="title" id="title">

        <br>

        <label for="price">Price</label>
        <br>
        <p>Was: <?php echo $product["price"] ?></p>
        <br>
        <input type="float" name="price" id="price">

        <br>

        <label for="desc">Description</label>
        <br>
        <p>Was: <?php echo $product["description"] ?></p>
        <br>
        <input type="text" name="desc" id="desc">

        <br>

        <label for="img">Image URL</label>
        <br>
        <p>Was: <?php echo $product["img"] ?></p>
        <br>
        <input type="text" name="img" id="img">

        <br>

        <label for="category">Category</label>
        <select name="category" id="category">
            <option value="Foods and Drinks">Foods & Drinks</option>
            <option value="Figurines">Figurines</option>
            <option value="Katana">Katana</option>
            <option value="Goodies">Goodies</option>
        </select>
        <p>Was: <?php echo $product["category"] ?></p>

        <br>

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
        <p>Was: <?php echo $product["subcategory"] ?></p>

        <br>

        <input type="submit" value="Edit Product" class="btn">
    </form>
</body>
</html>