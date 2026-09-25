<?php

include("../includes/config.php");
include("auth.php");

$products = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM products"));
$orders = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM orders"));
$contacts_count = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM contacts"));
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Dashboard</title>

<style>
body{
    margin:0;
    font-family:Arial;
    background:#f5f7fb;
}

/* SIDEBAR */
.sidebar{
    width:220px;
    height:100vh;
    background:#0f172a;
    position:fixed;
    padding:20px;
    color:#fff;
    left:0;
    top:0;
    transition:0.3s;
}

.sidebar h2{
    margin-bottom:30px;
}

.sidebar a{
    display:block;
    color:#cbd5e1;
    text-decoration:none;
    margin:12px 0;
    padding:10px;
    border-radius:6px;
    transition:0.3s;
}

.sidebar a:hover{
    background:#1e293b;
    color:#fff;
}

.logout{
    position:absolute;
    bottom:20px;
    width:180px;
    background:#ef4444;
    text-align:center;
    color:#fff !important;
}

/* MAIN CONTENT */
.main{
    margin-left:240px;
    padding:30px;
}

/* CARDS */
.card{
    background:#fff;
    padding:25px;
    margin:15px;
    display:inline-block;
    width:220px;
    border-radius:12px;
    box-shadow:0 8px 20px rgba(0,0,0,0.08);
    transition:0.3s;
    text-align:center;
}

.card:hover{
    transform:translateY(-5px);
}

.card h3{
    margin:0;
    color:#333;
}

.card p{
    font-size:28px;
    font-weight:bold;
    color:#4f46e5;
}

/* TABLET */
@media (max-width:768px){

    .main{
        margin-left:0;
        padding:20px;
    }

    .sidebar{
        width:200px;
    }

    .card{
        width:45%;
        margin:10px;
    }
}

/* MOBILE */
@media (max-width:600px){

    /* SIDEBAR becomes top bar */
    .sidebar{
        width:100%;
        height:auto;
        position:relative;
        display:flex;
        flex-wrap:wrap;
        justify-content:space-around;
        padding:15px;
    }

    .sidebar h2{
        width:100%;
        text-align:center;
        margin-bottom:10px;
    }

    .sidebar a{
        margin:5px;
        padding:8px;
        font-size:14px;
    }

    .logout{
        position:static;
        width:auto;
        margin-top:10px;
    }

    .main{
        margin-left:0;
        padding:15px;
    }

    .card{
        width:100%;
        margin:10px 0;
    }
}
</style>
</head>

<body>

<div class="sidebar">
    <h2>Admin Panel</h2>

    <a href="dashboard.php">Dashboard</a>
    <a href="add-product.php">Add Product</a>
    <a href="manage-products.php">Manage Products</a>
    <a href="orders.php">Orders</a>
    <a href="contacts.php">Contacts</a>

    <a class="logout" href="logout.php">Logout</a>
</div>

<div class="main">

<h1>Welcome Admin 👋</h1>

<div class="card">
    <h3>Products</h3>
    <p><?php echo $products; ?></p>
</div>

<div class="card">
    <h3>Orders</h3>
    <p><?php echo $orders; ?></p>
</div>

<div class="card">
    <h3>Messages</h3>
    <p><?php echo $contacts_count; ?></p>
</div>

</div>

</body>
</html>