<?php
include("../includes/config.php");
include("auth.php");


if(isset($_POST['submit'])){

    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $category_id = $_POST['category_id'];

    $image = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];

    move_uploaded_file($tmp, "../assets/images/".$image);

    $stmt = $conn->prepare("INSERT INTO products (category_id, name, price, description, image) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("isdss", $category_id, $name, $price, $description, $image);
    $stmt->execute();

    echo "<script>alert('Product Added Successfully');</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <style>
        /* FORM CONTAINER */
/* FORM BOX */
.box{
    width:90%;
    max-width:500px;
    margin:40px auto;
    background:#fff;
    padding:25px;
    border-radius:12px;
    box-shadow:0 5px 20px rgba(0,0,0,0.1);
}

/* TITLE */
.box h2{
    margin-bottom:20px;
    font-size:28px;
}

/* INPUTS */
.box input,
.box textarea,
.box select{
    width:100%;
    padding:12px;
    margin:10px 0;
    border:1px solid #ccc;
    border-radius:6px;
    font-size:15px;

    /* IMPORTANT FIX */
    box-sizing:border-box;
}

/* TEXTAREA */
.box textarea{
    resize:vertical;
    min-height:100px;
}

/* FILE INPUT */
.box input[type="file"]{
    padding:0;
    border:none;
}

/* BUTTON */
.box button{
    width:100%;
    padding:12px;
    background:#FF4DA6;
    color:#fff;
    border:none;
    border-radius:6px;
    font-size:16px;
    cursor:pointer;
}

.box button:hover{
    background:#e63d91;
}

/* MOBILE */
@media(max-width:768px){

    .box{
        width:95%;
        padding:18px;
    }

    .box h2{
        font-size:24px;
    }
}
    </style>
</head>

<body>

<div class="box">

<h2>Add Product</h2>

<form method="POST" enctype="multipart/form-data">

    <input type="text" name="name" placeholder="Product Name" required>

    <input type="number" name="price" placeholder="Price" required>

    <textarea name="description" placeholder="Description" required></textarea>

    <select name="category_id" required>
        <option value="">Select Category</option>
        <option value="1">Men</option>
        <option value="2">Women</option>
        <option value="3">Winter Wear</option>
        <option value="4">Casual Wear</option>
        <option value="5">Accessories</option>
    </select>

    <input type="file" name="image" required>

    <button type="submit" name="submit">Add Product</button>

</form>

</div>

</body>
</html>