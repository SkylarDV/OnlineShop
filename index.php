<?php 
    session_start();
    include_once("nav.php");
    if (isset($_SESSION["email"])) {
        echo "Welcome " . htmlspecialchars($_SESSION["email"]); // htmlspecialchars because of the @ in the email
    } else {
        header("Location: login.php");
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
   

</body>
</html>
