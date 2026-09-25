<?php

include("includes/header.php");
include("includes/config.php");

// INIT CART SAFELY
if(!isset($_SESSION['cart'])){
    $_SESSION['cart'] = [];
}

// REMOVE ITEM (SAFE)
if(isset($_GET['remove'])){
    $id = (int) $_GET['remove'];
    unset($_SESSION['cart'][$id]);
    header("Location: cart.php");
    exit();
}

// REDIRECT IF EMPTY
if(empty($_SESSION['cart'])){
    echo "<h2 style='text-align:center;margin-top:50px;'>Your cart is empty</h2>";
    include("includes/footer.php");
    exit();
}
?>

<h2 style="text-align:center;">Your Cart</h2>

<div class="cart">

<?php
$total = 0;

foreach($_SESSION['cart'] as $product_id => $qty){

    $stmt = $conn->prepare("SELECT * FROM products WHERE id=?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    if(!$product) continue;

    $subtotal = $product['price'] * $qty;
    $total += $subtotal;
?>

<div class="cart-item" style="border:1px solid #ddd;padding:15px;margin:10px;">
    
    <h3><?php echo htmlspecialchars($product['name']); ?></h3>

    <p>Price: Rs. <?php echo $product['price']; ?></p>
    <p>Quantity: <?php echo $qty; ?></p>
    <p><b>Subtotal:</b> Rs. <?php echo $subtotal; ?></p>

    <a href="cart.php?remove=<?php echo $product_id; ?>" 
       style="color:red;">Remove</a>

</div>

<?php } ?>

<hr>

<h3 style="text-align:center;">Total: Rs. <?php echo $total; ?></h3>

<!-- CHECKOUT BUTTON -->
<div style="text-align:center;margin-top:20px;">
    <a href="checkout.php" 
       style="background:#FF4DA6;color:#fff;padding:10px 20px;text-decoration:none;border-radius:6px;">
        Proceed to Checkout
    </a>
</div>

</div>

<?php include("includes/footer.php"); ?>