<?php 
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
                header("Location: index.php");
                exit();

            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            }
        } else {
            $e = "You must agree to the Terms of Service";
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
    <div class="loginpage">
        
        <form class="login" action="" method="post">
            <h2>Create an account</h2>
            <div>
                <label for="email">Email Address</label>
                <input type="text" name="email" id="email">
            </div>
        
            <br>

            <div>
                <label for="username">Display Name</label>
                <input type="text" name="username" id="username">
            </div>

            <br>

            <div>
                <label for="password">Password</label>
                <input type="password" name="password" id="password">
            </div>
            
            <br>

            <div>
                <label for="c_password">Confirm Password</label>
                <input type="password" name="c_password" id="c_password">
            </div>
            
            <br>

            <div class="agreements">
                <div class="checks">
                    <input class="check" type="checkbox" name="newsletter">
                    <label class="label" for="newsletter">I would like to receive notifications through email about updates or discounts on the platform</label>
                </div>
                
                <br>

                <div class="checks">
                    <input class="check" type="checkbox" name="tos">
                    <label class="label" for="tos">I agree with the Terms of Service and the Privacy Policy.</label>
                </div>   
            </div>
            
            <br>

            <?php if(isset($e)): ?>
                <div class="error"><?php echo $e ?></div>
                <br>
            <?php endif; ?>

            <input class="subbtn" type="submit" value="Create Account" class="btn">
        </form>
    </div>

    
</body>
</html>
