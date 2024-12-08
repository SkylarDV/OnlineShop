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
        $imgURL = Item::processImage();
        try {$product = new Item();
        $product->setName($_POST["title"]);
        $product->setDescription($_POST["desc"]);
        $product->setImage($imgURL);
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
    <title>Editing Item...</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="loginpage">
        <form class="login wider" action="" method="post"  enctype="multipart/form-data">
            <h2>Edit the product</h2>
            <div>
                <label for="title">Product Name</label>
                <p>Was: <?php echo htmlspecialchars($product["title"])  ?></p>
                <input type="text" name="title" id="title">
            </div>
        
            <br>

            <div>
                <label for="price">Price</label>
                <p>Was: <?php echo htmlspecialchars($product["price"])  ?></p>
                <input type="float" name="price" id="price">
            </div>
           
            <br>

            <div>
                <label for="desc">Description</label>
                <p>Was: <?php echo htmlspecialchars($product["description"])  ?></p>
                <input type="text" name="desc" id="desc">
            </div>
            
            <br>


            <div>
                <p>Was: </p> <img src="<?php echo htmlspecialchars($product["img"])  ?>" alt="">
                <label for="img">Upload Image</label>
                <input type="file" name="img" id="img" required>
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
                <p>Was: <?php echo htmlspecialchars($product["category"])  ?></p>
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
                <p>Was: <?php echo htmlspecialchars($product["subcategory"])  ?></p>
            </div>
            
            <br>

            <input class="subbtn" type="submit" value="Edit Product" class="btn">
        </form>
    </div>
</body>
</html>