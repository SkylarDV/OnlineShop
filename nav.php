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

<nav class="navbar">
    <?php if (isset($_SESSION["email"])): ?>
        <img src="https://i.pinimg.com/736x/ce/72/97/ce72974ce9966a891c2a363b397b1037.jpg"  alt="">
        <h3 class="user"><?php echo $_SESSION["email"]; ?></h3>
        <a class="logout" href="logout.php">Log Out?</a>
    <?php else: ?>
        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS7mMNz8YCBvYmnr3BQUPX__YsC_WtDuAevwg&s" alt="">
        <h3 class="user">GUEST</h3>
    <?php endif; ?>
</nav>

