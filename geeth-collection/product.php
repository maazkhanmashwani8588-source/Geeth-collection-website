<?php 

include("includes/config.php");
include("includes/header.php");


if(isset($_POST['add_to_cart'])){

    $product_id = $_POST['product_id'];

    if(!isset($_SESSION['cart'])){
        $_SESSION['cart'] = [];
    }

    // If product already exists → increase quantity
    if(isset($_SESSION['cart'][$product_id])){
        $_SESSION['cart'][$product_id]++;
    } else {
        $_SESSION['cart'][$product_id] = 1;
    }

    // redirect to avoid resubmission
    header("Location: cart.php");
    exit();
}


$id = $_GET['id'];

// SECURE QUERY (important)
$stmt = $conn->prepare("SELECT * FROM products WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();
?>

<div class="product-detail">

    <img src="assets/images/<?php echo $product['image']; ?>" alt="">

    <div class="details">
        <h2><?php echo $product['name']; ?></h2>
        <p>Rs. <?php echo $product['price']; ?></p>
        <p><?php echo $product['description']; ?></p>

        <form method="POST">
        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
        <button type="submit" name="add_to_cart">Add to Cart</button>
    </form>
    </div>

</div>

<?php include("includes/footer.php"); ?>