<?php

include("../includes/config.php");
include("auth.php");

$contacts = mysqli_query($conn,"SELECT * FROM contacts ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>Contacts</title>
<style type="text/css">
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:Arial, sans-serif;
    background:#f5f7fb;
    width:100%;
    overflow-x:hidden;
}

/* MAIN PAGE WRAPPER */
.container{
    width:100%;
    padding:40px;
}

/* CENTER CONTENT AREA */
.table-box{
    max-width:1200px;
    margin:0 auto;
}

/* PAGE TITLE */
h2{
    margin-bottom:20px;
    color:#111827;
}

/* TABLE DESIGN */
table{
    width:100%;
    border-collapse:collapse;
    background:#fff;
    border-radius:12px;
    overflow:hidden;
    box-shadow:0 8px 20px rgba(0,0,0,0.08);
}

/* HEADER */
th{
    background:#0f172a;
    color:#fff;
    padding:14px;
    text-align:left;
    font-size:14px;
}

/* TABLE CELLS */
td{
    padding:14px;
    text-align:left;
    border-bottom:1px solid #eee;
    font-size:14px;
    color:#333;
}

/* ROW HOVER */
tr:hover{
    background:#f1f5f9;
}

/* STATUS STYLES */
.status-replied{
    color:#16a34a;
    font-weight:bold;
}

.status-pending{
    color:#f59e0b;
    font-weight:bold;
}

/* BUTTON STYLE */
a{
    display:inline-block;
    text-decoration:none;
    padding:6px 12px;
    border-radius:6px;
    background:#4f46e5;
    color:#fff;
    font-size:13px;
    transition:0.3s;
}

a:hover{
    background:#3730a3;
    transform:scale(1.05);
}

/* SMALL RESPONSIVE FIX */
@media (max-width: 768px){
    .container{
        padding:15px;
    }

    td, th{
        font-size:12px;
        padding:10px;
    }
}
</style>

</head>

<body>

<div class="container">

<h2>Customer Messages</h2>

<table>

<tr>
    <th>Name</th>
    <th>Email</th>
    <th>Message</th>
    <th>Status</th>
    <th>Action</th>
</tr>

<?php while($row = mysqli_fetch_assoc($contacts)){ ?>

<tr>
<td><?php echo $row['name']; ?></td>
<td><?php echo $row['email']; ?></td>
<td><?php echo $row['message']; ?></td>

<td>
<?php echo !empty($row['reply']) ? "Replied" : "Pending"; ?>
</td>

<td>
<a href="reply.php?id=<?php echo $row['id']; ?>">Reply</a>
</td>

</tr>

<?php } ?>

</table>

</div>

</body>
</html>