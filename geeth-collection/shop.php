<?php 

include("includes/config.php");
include("includes/header.php");

// Fetch products
$query = "
SELECT products.*, categories.name AS category_name 
FROM products 
LEFT JOIN categories ON products.category_id = categories.id
ORDER BY products.id DESC
";
$result = mysqli_query($conn, $query);

 if(mysqli_num_rows($result) == 0){ ?>
    <p style="text-align:center;">No products available</p>
<?php } 

?>

<h2 style="text-align:center; margin-top:30px;">Our Products</h2>

<div class="products">

<?php while($row = mysqli_fetch_assoc($result)) { ?>

   <div class="product-card">
    <img src="assets/images/<?php echo $row['image']; ?>" alt="">

    <h3><?php echo $row['name']; ?></h3>

    <p class="category">
        <?php echo $row['category_name']; ?>
    </p>

    <p>Rs. <?php echo $row['price']; ?></p>

    <a href="product.php?id=<?php echo $row['id']; ?>">View Details</a>
</div>

<?php } ?>

</div>

<?php include("includes/footer.php"); ?>