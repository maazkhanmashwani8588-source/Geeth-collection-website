<?php

include("../includes/config.php");
include("auth.php");

// SAFE ID CHECK
if(!isset($_GET['id'])){
    die("Invalid Product ID");
}

$id = $_GET['id'];

// FETCH PRODUCT SAFELY
$stmt = $conn->prepare("SELECT * FROM products WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if(!$product){
    die("Product not found");
}

if(isset($_POST['update'])){

    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    $image = $product['image']; // default old image

    // CHECK IF NEW IMAGE UPLOADED
    if(!empty($_FILES['image']['name'])){
        
        $newImage = $_FILES['image']['name'];
        $tmp = $_FILES['image']['tmp_name'];

        move_uploaded_file($tmp, "../uploads/" . $newImage);

        $image = $newImage;
    }

    $stmt = $conn->prepare("UPDATE products SET name=?, price=?, description=?, image=? WHERE id=?");
    $stmt->bind_param("sdssi", $name, $price, $description, $image, $id);
    $stmt->execute();

    echo "<script>alert('Updated Successfully'); window.location='manage-products.php';</script>";
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
    padding:20px;
}

/* FORM BOX */
.box{
    width:90%;
    max-width:420px;
    margin:50px auto;
    background:#fff;
    padding:25px;
    border-radius:12px;
    box-shadow:0 10px 25px rgba(0,0,0,0.1);
    transition:0.3s;

    /* IMPORTANT */
    box-sizing:border-box;
}

.box:hover{
    transform:translateY(-3px);
}

/* TITLE */
h2{
    text-align:center;
    margin-bottom:20px;
}

/* INPUTS */
input,
textarea{
    width:100%;
    padding:10px;
    margin:10px 0;
    border:1px solid #ddd;
    border-radius:6px;
    font-size:15px;
    outline:none;

    /* MAIN FIX */
    box-sizing:border-box;
}

/* TEXTAREA */
textarea{
    resize:vertical;
    min-height:100px;
}

/* BUTTON */
button{
    width:100%;
    padding:12px;
    background:#ff4da6;
    border:none;
    color:#fff;
    border-radius:6px;
    cursor:pointer;
    transition:0.3s;
    font-size:16px;

    box-sizing:border-box;
}

button:hover{
    background:#e63d91;
}

/* MOBILE */
@media(max-width:768px){

    .box{
        width:95%;
        padding:20px;
    }
}
</style>

</head>

<body>

<div class="box">

<h2>Edit Product</h2>

<form method="POST" enctype="multipart/form-data">

<input type="text" name="name" value="<?php echo $product['name']; ?>" required>

<input type="number" name="price" value="<?php echo $product['price']; ?>" required>

<textarea name="description" required><?php echo $product['description']; ?></textarea>

<p>Current Image:</p>
<img src="../assets/images/<?php echo $product['image']; ?>" width="120" style="border-radius:8px;">

<button type="submit" name="update">Update Product</button>

</form>

</div>

</body>
</html>