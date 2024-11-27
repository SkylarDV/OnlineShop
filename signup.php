<?php 
ini_set('display_errors', 1);
error_reporting(E_ALL);
    include_once(__DIR__ . "/User.php"); 

    session_start();
    if (isset($_SESSION["email"])) {
        header("Location: index.php");
        exit();
    }

    if (!empty($_POST)) {
        if (isset($_POST['tos']) && $_POST['tos'] == "on") {
            try {
                $user = new User();
                $user->setEmail($_POST["email"]);
                $user->setAdmin(0);
                $user->setUsername($_POST["username"]);
                $user->setCurrency(1000);
                if ($_POST["password"] == $_POST["c_password"]) {
                    $options = [
                        "cost" => 15,
                    ];
                    $password = password_hash($_POST["password"], PASSWORD_DEFAULT, $options);
                    $user->setPassword($password);
                } else {
                    throw new InvalidArgumentException("Passwords do not match!");
                }
                $user->save();

            } catch (InvalidArgumentException $e) {
                echo "Error: " . $e->getMessage();
            }
        } else {
            $error = "You must agree to the Terms of Service";
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

    <?php if(isset($error)): ?>
        <div class="font-bold text-red-500"><?php echo $error ?></div>
    <?php endif; ?>

    <form action="" method="post">
        <label for="email">Email Address</label>
        <br>
        <input type="text" name="email" id="email">

        <br>

        <label for="username">Display Name</label>
        <br>
        <input type="text" name="username" id="username">

        <br>

        <label for="password">Password</label>
        <br>
        <input type="password" name="password" id="password">

        <br>

        <label for="c_password">Confirm Password</label>
        <br>
        <input type="password" name="c_password" id="c_password">

        <br>

        <input class="check" type="checkbox" name="newsletter">
        <label class="label" for="newsletter">I would like to receive notifications through email about updates or discounts on the platform</label>

        <br>

        <input class="check" type="checkbox" name="tos">
        <label class="label" for="tos">I agree with the Terms of Service and the Privacy Policy.</label>

        <br>

        <input type="submit" value="Create Account" class="btn">
    </form>
</body>
</html>
