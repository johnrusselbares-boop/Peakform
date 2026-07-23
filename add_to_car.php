<?php
include 'db.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Check if a product was submitted
if (!isset($_POST['product_id'])) {
    header("Location: peakform.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$product_id = (int)$_POST['product_id'];

// Check if the product is already in the cart
$check = mysqli_query(
    $conn,
    "SELECT * FROM cart
     WHERE user_id='$user_id'
     AND product_id='$product_id'"
);

if (mysqli_num_rows($check) > 0) {

    // Increase quantity
    mysqli_query(
        $conn,
        "UPDATE cart
         SET quantity = quantity + 1
         WHERE user_id='$user_id'
         AND product_id='$product_id'"
    );
} else {

    // Add new product
    mysqli_query(
        $conn,
        "INSERT INTO cart(user_id, product_id, quantity)
         VALUES('$user_id','$product_id',1)"
    );
}

$return = isset($_POST['return']) ? $_POST['return'] : 'peakform.php';

if (strpos($return, '?') !== false) {
    header("Location: {$return}&added=1");
} else {
    header("Location: {$return}?added=1");
}
exit();
