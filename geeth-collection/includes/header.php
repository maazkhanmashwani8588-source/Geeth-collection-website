
<!DOCTYPE html>
<html>
<head>
    <title>Geet Collection</title>

    <!-- Font Awesome (icons) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<nav class="navbar">

    <div class="logo">
        <img src="assets/images/logo.jpg" alt="logo">
        <span>Geet Collection</span>
    </div>

    <!-- HAMBURGER MENU -->
    <div class="menu-toggle">
        <i class="fa-solid fa-bars"></i>
    </div>

    <ul class="nav-links">
        <li><a href="index.php">Home</a></li>
        <li><a href="shop.php">Shop</a></li>
        <li><a href="about.php">About</a></li>
        <li><a href="contact.php">Contact</a></li>

        <li>
            <a href="cart.php">
                <i class="fa-solid fa-cart-shopping"></i> Cart
            </a>
        </li>

        <?php if(isset($_SESSION['user_id'])){ ?>
            <li><a href="user/dashboard.php">Dashboard</a></li>
            <li><a href="logout.php">Logout</a></li>
        <?php } else { ?>
            <li><a href="login.php">Login</a></li>
            <li><a href="register.php">Register</a></li>
        <?php } ?>
    </ul>
</nav>