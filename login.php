<?php
    include_once("User.php");
    function canLogIn($user, $password) {
        $all = User::getAll();
        foreach ($all as $u) {
            if (isset($u['email']) && $u['email'] === $user) {
                $hash = $u["password"];
                if (password_verify($password, $hash)) {
                    return true;
                }
                return false; 
            }
        }
        return false; 
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

    <div class="loginpage">
        
        <form class="login" action="" method="post">
        <h2>Log in</h2>
        <div>
            <label for="email">Email Address</label>
            <input type="text" name="email" id="email">
        </div>
        
        <br>

        <div>
            <label for="password">Password</label>
            <input type="password" name="password" id="password">
        </div>
        
        <br>
        <?php if(isset($error)): ?> 
            <strong class="error">That combination of username and password is incorrect. Please try again.</strong>
            <br>
        <?php endif; ?>
        
        <input type="submit" value="Log In" class="subbtn">
        <br>
        <a href="signup.php">Don't have an account? Sign up</a>
    </form>

    <div class="pic">
        <img src="https://cdn.shopify.com/s/files/1/0274/1056/3133/files/thumbnail_IMG-20210427-WA0013-PhotoRoom_2.png?v=1666703498" alt="">
    </div>
    </div>
    
</body>
</html>