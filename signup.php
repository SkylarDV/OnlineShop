<?php 
    session_start();
    if (!isset($_SESSION["email"])) {

    } else {
        header("Location: index.php");
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

    <form action="" method="post">
        <label for="email">Email Address</label>
        <br>
        <input type="text" name="email" id="email">

        <br>

        <label for="password">Password</label>
        <br>
        <input type="password" name="password" id="password">

        <br>

        <label for="c_password">Confirm Password</label>
        <br>
        <input type="password" name="c_password" id="c_password">

        <br>

        <input type="checkbox" name="newsletter">
        <label for="newsletter">I would like to receive notifications through email about updates or discounts on the platform</label>

        <br>

        <input type="checkbox" name="tos">
        <label for="tos">I agree with the Terms of Service and the Privacy Policy.</label>

        <br>

        <input type="submit" value="Create Account" class="btn">
    </form>
</body>
</html>