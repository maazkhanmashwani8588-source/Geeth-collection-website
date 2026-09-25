<?php


include("../includes/config.php");
include("auth.php");

// SECURITY: only admin access assumed from auth.php
if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

// VALIDATE ID
if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
    die("Invalid Order ID");
}

$id = (int) $_GET['id'];

// GET ORDER
$stmt = $conn->prepare("SELECT * FROM orders WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();

if(!$order){
    die("Order not found");
}
?>

<style>
body{
    font-family:Arial;
    background:#f5f7fb;
    margin:0;
    padding:10px;
}

.container{
    padding:20px;
}

/* CARD */
.card{
    background:#fff;
    padding:20px;
    border-radius:12px;
    box-shadow:0 8px 20px rgba(0,0,0,0.08);
    margin-bottom:20px;
}

/* HEADINGS */
h2{
    margin-bottom:10px;
    font-size:20px;
}

/* BADGES */
.badge{
    padding:5px 10px;
    border-radius:20px;
    color:#fff;
    font-size:12px;
    display:inline-block;
}

.pending{ background:#f59e0b; }
.delivered{ background:#22c55e; }
.cancelled{ background:#ef4444; }

/* TABLE WRAPPER (IMPORTANT FOR MOBILE) */
.table-wrapper{
    width:100%;
    overflow-x:auto;
}

/* TABLE */
table{
    width:100%;
    border-collapse:collapse;
    background:#fff;
    border-radius:10px;
    overflow:hidden;
    min-width:600px; /* enables scroll on mobile */
}

th{
    background:#111827;
    color:#fff;
    padding:12px;
    text-align:left;
    font-size:14px;
}

td{
    padding:12px;
    border-bottom:1px solid #eee;
    font-size:14px;
}

tr:hover{
    background:#f9fafb;
}

/* TABLET */
@media (max-width:768px){

    .container{
        padding:15px;
    }

    h2{
        font-size:18px;
    }

    th, td{
        padding:10px;
        font-size:13px;
    }

    .card{
        padding:15px;
    }
}

/* MOBILE */
@media (max-width:480px){

    body{
        padding:5px;
    }

    .container{
        padding:10px;
    }

    h2{
        font-size:16px;
    }

    th, td{
        padding:8px;
        font-size:12px;
    }

    .badge{
        font-size:11px;
        padding:4px 8px;
    }
}
</style>

<div class="container">

<!-- ORDER INFO -->
<div class="card">
    <h2>Order #<?php echo $order['id']; ?></h2>

    <p><b>Name:</b> <?php echo htmlspecialchars($order['customer_name']); ?></p>
    <p><b>Phone:</b> <?php echo htmlspecialchars($order['phone']); ?></p>
    <p><b>Address:</b> <?php echo htmlspecialchars($order['address']); ?></p>

    <p>
        <b>Status:</b> 
        <span class="badge <?php echo $order['status']; ?>">
            <?php echo ucfirst($order['status']); ?>
        </span>
    </p>

    <p><b>Total:</b> Rs. <?php echo $order['total_price']; ?></p>
</div>

<!-- PRODUCTS -->
<div class="card">

<h3>Order Items</h3>
<div class="table-wrapper">
<table>

<tr>
    <th>Product</th>
    <th>Quantity</th>
    <th>Price</th>
</tr>

<?php
$stmt = $conn->prepare("
SELECT order_items.*, products.name 
FROM order_items 
JOIN products ON order_items.product_id = products.id 
WHERE order_items.order_id=?
");

$stmt->bind_param("i", $id);
$stmt->execute();
$items = $stmt->get_result();

while($row = $items->fetch_assoc()){
?>

<tr>
    <td><?php echo htmlspecialchars($row['name']); ?></td>
    <td><?php echo $row['quantity']; ?></td>
    <td>Rs. <?php echo $row['price']; ?></td>
</tr>

<?php } ?>

</table>
</div>
</div>

</div>