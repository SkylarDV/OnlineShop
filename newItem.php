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
</head>
<body>
<form action="" method="post">
        <label for="title">Product Name</label>
        <br>
        <input type="text" name="title" id="title">

        <br>

        <label for="price">Price</label>
        <br>
        <input type="float" name="price" id="price">

        <br>

        <label for="desc">Description</label>
        <br>
        <input type="text" name="desc" id="desc">

        <br>

        <label for="img">Image URL</label>
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

        <br>

        <input type="submit" value="Create Product" class="btn">
        <a href="index.php">Go back to all products</a>
    </form>
</body>
</html>