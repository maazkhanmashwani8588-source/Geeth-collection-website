<?php

include("includes/header.php");
include("includes/config.php");

// SECURITY: cart check
if(!isset($_SESSION['cart']) || empty($_SESSION['cart'])){
    echo "<h2 style='text-align:center;'>Cart is empty</h2>";
    include("includes/footer.php");
    exit();
}

// OPTIONAL: require login (recommended)
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

// PLACE ORDER
if(isset($_POST['place_order'])){

    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    $user_id = $_SESSION['user_id'];

    // VALIDATION
    if(empty($name) || empty($phone) || empty($address)){
        die("All fields are required");
    }

    $cart = $_SESSION['cart'];
    $total = 0;

    // CALCULATE TOTAL (OPTIMIZED)
    foreach($cart as $product_id => $qty){

        $stmt = $conn->prepare("SELECT price FROM products WHERE id=?");
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $product = $stmt->get_result()->fetch_assoc();

        if($product){
            $total += $product['price'] * $qty;
        }
    }

    // INSERT ORDER (NOW WITH USER ID)
    $stmt = $conn->prepare("
        INSERT INTO orders (user_id, customer_name, phone, address, total_price, status) 
        VALUES (?, ?, ?, ?, ?, 'pending')
    ");
    $stmt->bind_param("isssd", $user_id, $name, $phone, $address, $total);
    $stmt->execute();

    $order_id = $stmt->insert_id;

    // INSERT ORDER ITEMS
    foreach($cart as $product_id => $qty){

        $stmt = $conn->prepare("SELECT price FROM products WHERE id=?");
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $product = $stmt->get_result()->fetch_assoc();

        if($product){
            $price = $product['price'];

            $stmt2 = $conn->prepare("
                INSERT INTO order_items (order_id, product_id, quantity, price) 
                VALUES (?, ?, ?, ?)
            ");
            $stmt2->bind_param("iiid", $order_id, $product_id, $qty, $price);
            $stmt2->execute();
        }
    }

    // CLEAR CART
    unset($_SESSION['cart']);

    echo "<script>
        alert('Order placed successfully!');
        window.location='index.php';
    </script>";
}
?>


<div class="checkout-page">

<form method="POST" class="checkout-form" style="max-width:400px;margin:auto;">
    <h2 style="text-align:center;">Checkout</h2>

    <input type="text" name="name" placeholder="Full Name" required style="width:100%;padding:10px;margin:10px 0;">
    
    <input type="text" name="phone" placeholder="Phone Number" required style="width:100%;padding:10px;margin:10px 0;">
    
    <textarea name="address" placeholder="Address" required style="width:100%;padding:10px;margin:10px 0;"></textarea>

    <button type="submit" name="place_order" 
        style="width:100%;padding:12px;background:#FF4DA6;color:#fff;border:none;">
        Place Order
    </button>

</form>
</div>

<?php include("includes/footer.php"); ?>