<?php
    function canLogIn($user, $password) {
        if ($user === "jenaam@shop.com" && $password === "12345isnotsecure") {
            return true;
        }
        else {return false;}
    }

    if (!empty($_POST)){
        $user = $_POST["email"];
        $password = $_POST["password"];

        if (canLogIn($user, $password)) {
            session_start();
            $_SESSION["email"] = $user;
            header("Location: index.php");
            exit;
        }
        else {$error = true;}
    }
    
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
        <?php if(isset($error)): ?> 
            <strong class="error">That combination of username and password is incorrect. Please try again.</strong>
        <?php endif; ?>
        <br>

        <input type="submit" value="Log In" class="subbtn">
        <br>
        <a href="signup.php">Don't have an account? Sign up</a>
    </form>
</body>
</html>