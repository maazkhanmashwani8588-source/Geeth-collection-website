<?php

include("../includes/config.php");
include("auth.php");

// STATUS UPDATE
if(isset($_GET['status']) && isset($_GET['id'])){

    $id = $_GET['id'];
    $status = $_GET['status'];

    $stmt = $conn->prepare("UPDATE orders SET status=? WHERE id=?");
    $stmt->bind_param("si", $status, $id);
    $stmt->execute();

    header("Location: orders.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>

<style>
body{
    font-family:Arial;
    background:#f4f6f9;
    margin:0;
    padding:15px;
}

h2{
    text-align:center;
    font-size:22px;
}

/* WRAPPER FOR RESPONSIVE TABLE */
.table-container{
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
    min-width:600px; /* important for mobile scroll */
}

th{
    background:#111;
    color:#fff;
    padding:12px;
    font-size:14px;
}

td{
    padding:12px;
    text-align:center;
    font-size:14px;
}

tr:hover{
    background:#f1f1f1;
}

/* STATUS LABELS */
.status{
    padding:5px 10px;
    border-radius:5px;
    color:#fff;
    font-size:12px;
    display:inline-block;
}

.pending{background:orange;}
.confirmed{background:blue;}
.shipped{background:purple;}
.delivered{background:green;}

/* ACTION BUTTONS */
a{
    text-decoration:none;
    padding:5px 8px;
    border-radius:5px;
    color:#fff;
    font-size:12px;
    display:inline-block;
    margin:2px;
}

.view{background:#444;}
.confirm{background:#2196F3;}
.ship{background:#9C27B0;}
.done{background:#4CAF50;}

/* MOBILE IMPROVEMENTS */
@media (max-width:768px){

    h2{
        font-size:18px;
    }

    th, td{
        padding:10px;
        font-size:13px;
    }
}

@media (max-width:480px){

    h2{
        font-size:16px;
    }

    th, td{
        padding:8px;
        font-size:12px;
    }

    a{
        font-size:11px;
        padding:4px 6px;
    }

    .status{
        font-size:11px;
        padding:4px 8px;
    }
}
</style>

</head>

<body>

<h2>All Orders</h2>
<div class="table-container">
<table>

<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Phone</th>
    <th>Total</th>
    <th>Status</th>
    <th>Action</th>
</tr>

<?php
$result = mysqli_query($conn,"SELECT * FROM orders ORDER BY id DESC");

while($row = mysqli_fetch_assoc($result)){
?>

<tr>
    <td><?php echo $row['id']; ?></td>
    <td><?php echo $row['customer_name']; ?></td>
    <td><?php echo $row['phone']; ?></td>
    <td>Rs. <?php echo $row['total_price']; ?></td>

    <td>
        <span class="status <?php echo $row['status']; ?>">
            <?php echo $row['status']; ?>
        </span>
    </td>

    <td>
        <a class="view" href="order-details.php?id=<?php echo $row['id']; ?>">View</a>
        <a class="confirm" href="?id=<?php echo $row['id']; ?>&status=confirmed">Confirm</a>
        <a class="ship" href="?id=<?php echo $row['id']; ?>&status=shipped">Ship</a>
        <a class="done" href="?id=<?php echo $row['id']; ?>&status=delivered">Done</a>
    </td>
</tr>

<?php } ?>

</table>
</div>

</body>
</html>