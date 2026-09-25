<?php
include("includes/config.php");
include("includes/header.php");

// check login status
$isLoggedIn = isset($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html>
<head>

<style>
body{
    margin:0;
    font-family:Arial;
    background:#f9f9f9;
}

/* ================= NAVBAR ================= */
.navbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:15px 30px;
    background:#111;
    color:white;
    position:sticky;
    top:0;
    z-index:1000;
}

.navbar .logo{
    font-size:20px;
    font-weight:bold;
}

.navbar ul{
    list-style:none;
    display:flex;
    gap:20px;
    margin:0;
    padding:0;
}

.navbar ul li a{
    color:white;
    text-decoration:none;
    transition:0.3s;
}

.navbar ul li a:hover{
    color:#ff4da6;
}

/* MOBILE MENU BUTTON */
.menu-toggle{
    display:none;
    font-size:26px;
    cursor:pointer;
}

/* ================= HERO ================= */
.hero{
    height:80vh;
    background:linear-gradient(rgba(0,0,0,0.5),rgba(0,0,0,0.5)),
    url('assets/images/hero.jpg');
    background-size:cover;
    background-position:center;
    display:flex;
    align-items:center;
    justify-content:center;
    text-align:center;
    color:white;
    padding:20px;
}

.hero h1{
    font-size:50px;
    margin:0;
}

.hero p{
    font-size:18px;
}

.hero button{
    padding:12px 25px;
    background:#ff4da6;
    border:none;
    color:white;
    cursor:pointer;
    margin-top:10px;
    border-radius:5px;
}

/* ================= SECTION TITLE ================= */
.section-title{
    text-align:center;
    margin:40px 0;
}

/* ================= PRODUCTS ================= */
.products{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(200px,1fr));
    gap:20px;
    padding:0 20px;
}

.product{
    background:white;
    padding:10px;
    border-radius:10px;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
    transition:0.3s;
    text-align:center;
}

.product:hover{
    transform:translateY(-5px);
}

.product img{
    width:100%;
    height:220px;
    object-fit:cover;
    border-radius:10px;
}

.product h3{
    font-size:16px;
}

.product a{
    display:block;
    text-align:center;
    padding:8px;
    background:#111;
    color:white;
    text-decoration:none;
    margin-top:10px;
    border-radius:5px;
}

.product a:hover{
    background:#ff4da6;
}

/* ================= FOOTER ================= */
.footer{
    background:#111;
    color:white;
    text-align:center;
    padding:20px;
    margin-top:50px;
}

/* ================= TABLET ================= */
@media (max-width:768px){

    .hero h1{
        font-size:35px;
    }

    .hero p{
        font-size:16px;
    }

    .navbar ul{
        gap:15px;
    }
}

/* ================= MOBILE ================= */
@media (max-width:600px){

    .menu-toggle{
        display:block;
    }

    .navbar ul{
        display:none;
        flex-direction:column;
        background:#111;
        position:absolute;
        top:60px;
        left:0;
        width:100%;
        padding:15px 0;
    }

    .navbar ul.active{
        display:flex;
    }

    .hero{
        height:70vh;
        padding:15px;
    }

    .hero h1{
        font-size:28px;
    }

    .hero p{
        font-size:14px;
    }
}
</style>

</head>

<body>

<!-- HERO -->
<div class="hero">
    <div>
        <h1>GEET COLLECTION</h1>
        <p>Modern Fashion for Everyone — Style that defines you</p>
        <a href="shop.php"><button>Shop Now</button></a>
    </div>
</div>

<!-- OPTIONAL GUEST MESSAGE (NO DESIGN CHANGE) -->
<?php if(!$isLoggedIn){ ?>
<p style="text-align:center; color:#777;">
    You are browsing as guest. Login for full features.
</p>
<?php } ?>

<!-- FEATURED PRODUCTS -->
<h2 class="section-title">Featured Products</h2>

<div class="products">

<?php
$result = mysqli_query($conn,"SELECT * FROM products ORDER BY id DESC LIMIT 8");

while($row = mysqli_fetch_assoc($result)){
?>

<div class="product">
    <img src="assets/images/<?php echo $row['image']; ?>">
    <h3><?php echo $row['name']; ?></h3>
    <p>Rs. <?php echo $row['price']; ?></p>

    <!-- SECURITY FIX: redirect guest users to login -->
    <a href="<?php echo $isLoggedIn ? 'product.php?id='.$row['id'] : 'login.php'; ?>">
        View
    </a>
</div>

<?php } ?>

</div>

<!-- FOOTER -->
<div class="footer">
    <p>© 2026 Geet Collection | All Rights Reserved</p>
</div>
<script type="text/javascript" src="assets/js/main.js"></script>
</body>
</html>