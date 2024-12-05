<?php 
    session_start();
    if (!isset($_SESSION["email"])) {
        header("Location: login.php");
    }

    include_once(__DIR__."/User.php");

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $nPassword = $_POST["new_password"];
        $cPassword = $_POST["confirm_password"];
        
        if ($nPassword === $cPassword) {
            $email = $_SESSION["email"];
            User::changePassword($email, $nPassword);
            echo "Password successfully updated!";
        } else {
            echo "Passwords do not match.";
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
    <?php include_once("nav.php"); ?>
    
    <h2>Your past orders</h2>

    <form method="POST" action="">
        <h2>Change password</h2>
        <label for="new_password">New Password:</label>
        <input type="password" id="new_password" name="new_password" required>
        
        <br>

        <label for="confirm_password">Confirm Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" required>
        
        <br>

        <button type="submit">Change Password</button>
    </form>

</body>
</html>