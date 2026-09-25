<?php

include("../includes/config.php");
include("auth.php");

if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    mysqli_query($conn,"DELETE FROM products WHERE id=$id");
    header("Location: manage-products.php");
}
?>

<!DOCTYPE html>
<html>
<head>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:Arial;
    background:#f4f6f9;
    padding:20px;
}

/* TABLE WRAPPER */
.table-wrapper{
    width:100%;
    overflow-x:auto;
}

/* TABLE */
table{
    width:100%;
    min-width:600px;

    border-collapse:collapse;
    background:#fff;

    border-radius:10px;
    overflow:hidden;

    box-shadow:0 5px 15px rgba(0,0,0,0.05);
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
    transition:0.3s;
}

/* ACTION BUTTONS */
a{
    text-decoration:none;
    padding:6px 10px;
    border-radius:5px;
    margin:0 3px;

    display:inline-block;

    font-size:13px;
    transition:0.3s;
}

.edit{
    background:#4CAF50;
    color:#fff;
}

.delete{
    background:#ff4d4d;
    color:#fff;
}

.edit:hover{
    background:#3e8e41;
}

.delete:hover{
    background:#d60000;
}

/* TABLET */
@media(max-width:768px){

    body{
        padding:15px;
    }

    th,
    td{
        padding:10px;
        font-size:13px;
    }
}

/* MOBILE */
@media(max-width:480px){

    body{
        padding:10px;
    }

    th,
    td{
        padding:8px;
        font-size:12px;
    }

    a{
        padding:5px 8px;
        font-size:11px;
    }
}
</style>

</head>

<body>

<h2>Manage Products</h2>
<div class="table-wrapper">
<table>

<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Price</th>
    <th>Image</th>
    <th>Actions</th>
</tr>

<?php
$result = mysqli_query($conn,"SELECT * FROM products");

while($row = mysqli_fetch_assoc($result)){
?>

<tr>
    <td><?php echo $row['id']; ?></td>
    <td><?php echo $row['name']; ?></td>
    <td><?php echo $row['price']; ?></td>
    <td><img src="../assets/images/<?php echo $row['image']; ?>" width="50"></td>

    <td>
        <a class="edit" href="edit-product.php?id=<?php echo $row['id']; ?>">Edit</a>
        <a class="delete" href="?delete=<?php echo $row['id']; ?>">Delete</a>
    </td>
</tr>

<?php } ?>

</table>
</div>
</body>
</html>