<style>
    nav {
        background-color: black;
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: flex-start;
        padding: 0.5em;
        width: 100%;
    }

    nav img {
        margin-right: 20px;
        width: 30px; 
        height: 30px;
        display: inline-block;
    }

    .user {

    }

    .logout {
        font-weight: bold;
        margin-left: auto;
        text-decoration: none;
        color: gray;
    }
</style>

<?php 
    include_once(__DIR__."/User.php");
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
        $search = urlencode($_POST['search']); // URL-encode the input to ensure it's safe for a query string
        header("Location: index.php?search=$search");
    }
?>

<nav class="navbar">
    <?php if (isset($_SESSION["email"])): ?>
        <img src="https://i.pinimg.com/736x/ce/72/97/ce72974ce9966a891c2a363b397b1037.jpg"  alt="">
        <h3 class="user"><a href="profile.php"><?php echo $_SESSION["email"]; ?></a></h3>
        <a href="cart.php"><img src="https://cdn-icons-png.flaticon.com/512/4585/4585350.png" alt=""></a>
        <form action="" method="POST">
            <input type="text" name="search" id="search" size="100" placeholder="Use 1 word for most effective searching">
        </form>
        <?php if (User::checkIfAdmin($_SESSION["email"])): ?>
            <a href="newItem.php">Add Item</a>
        <?php endif; ?>
        <a class="logout" href="logout.php">Log Out?</a>
    <?php else: ?>
        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS7mMNz8YCBvYmnr3BQUPX__YsC_WtDuAevwg&s" alt="">
        <h3 class="user">GUEST</h3>
    <?php endif; ?>
</nav>

