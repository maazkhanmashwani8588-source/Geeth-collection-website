<?php
include("../includes/config.php");

// SECURITY: only logged-in users
if(!isset($_SESSION['user_id'])){
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// GET USER INFO
$stmt = $conn->prepare("SELECT * FROM users WHERE id=?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

// USER ORDERS
$stmt = $conn->prepare("SELECT * FROM orders WHERE user_id=? ORDER BY id DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$orders = $stmt->get_result();

// USER MESSAGES
$stmt = $conn->prepare("SELECT * FROM contacts WHERE user_id=? ORDER BY id DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$messages = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
<title>User Dashboard</title>

<style>
body{
    margin:0;
    font-family:Arial;
    background:#f5f7fb;
}

/* TOP BAR */
.header{
    background:#0f172a;
    color:#fff;
    padding:15px 20px;
}

.container{
    padding:30px;
    max-width:1100px;
    margin:auto;
}

/* CARDS */
.card{
    background:#fff;
    padding:20px;
    border-radius:12px;
    margin-bottom:20px;
    box-shadow:0 5px 15px rgba(0,0,0,0.08);
}

/* TITLES */
h2{
    margin-bottom:10px;
}

h3{
    margin-bottom:15px;
    color:#111;
}

/* ORDER BOX */
.order{
    border-bottom:1px solid #eee;
    padding:10px 0;
}

/* MESSAGE BOX */
.msg{
    border-bottom:1px solid #eee;
    padding:10px 0;
}

.reply{
    color:green;
    font-weight:bold;
}

/* BUTTON */
a.logout{
    float:right;
    color:#fff;
    text-decoration:none;
    background:red;
    padding:6px 10px;
    border-radius:6px;
}
</style>

</head>

<body>

<!-- HEADER -->
<div class="header">
    Welcome, <?php echo $user['name']; ?>

    <!-- BACK TO HOME BUTTON -->
    <a href="../index.php" style="
        background:#FF4DA6;
        color:#fff;
        padding:6px 10px;
        border-radius:6px;
        text-decoration:none;
        margin-left:10px;
    ">
        Home
    </a>

    <a class="logout" href="../logout.php">Logout</a>
</div>

<div class="container">

<!-- PROFILE -->
<div class="card">
    <h2>My Profile</h2>
    <p><b>Name:</b> <?php echo $user['name']; ?></p>
    <p><b>Email:</b> <?php echo $user['email']; ?></p>
</div>

<!-- ORDERS -->
<div class="card">
    <h3>My Orders</h3>

    <?php if($orders->num_rows > 0){ ?>
        <?php while($row = $orders->fetch_assoc()){ ?>
            <div class="order">
                Order #<?php echo $row['id']; ?> —
                Total: Rs. <?php echo $row['total_price']; ?> —
                Date: <?php echo $row['created_at']; ?>
            </div>
        <?php } ?>
    <?php } else { ?>
        <p>No orders yet.</p>
    <?php } ?>

</div>

<!-- MESSAGES -->
<div class="card">
    <h3>My Messages</h3>

    <?php if($messages->num_rows > 0){ ?>
        <?php while($row = $messages->fetch_assoc()){ ?>
            <div class="msg">
                <p><b>Message:</b> <?php echo $row['message']; ?></p>

                <p class="reply">
                    Reply: <?php echo $row['reply'] ? $row['reply'] : "Not replied yet"; ?>
                </p>
            </div>
        <?php } ?>
    <?php } else { ?>
        <p>No messages yet.</p>
    <?php } ?>

</div>

</div>

</body>
</html>