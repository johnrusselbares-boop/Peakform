<?php

include 'db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {

    echo json_encode([
        "success" => false
    ]);

    exit();
}

$user = $_SESSION['user_id'];

$product = (int)$_POST['product_id'];

$quantity = isset($_POST['quantity'])
    ? (int)$_POST['quantity']
    : 1;

/* Prevent invalid quantity */
if ($quantity < 1) {
    $quantity = 1;
}

/* Get current stock */
$getProduct = mysqli_query($conn, "
SELECT stock
FROM products
WHERE id='$product'
");

$productData = mysqli_fetch_assoc($getProduct);

$stock = $productData['stock'];

/* Check if product is already in cart */
$check = mysqli_query($conn, "
SELECT quantity
FROM cart
WHERE user_id='$user'
AND product_id='$product'
");

if (mysqli_num_rows($check) > 0) {

    $cart = mysqli_fetch_assoc($check);

    $newQuantity = $cart['quantity'] + $quantity;

    /* Don't exceed stock */
    if ($newQuantity > $stock) {
        $newQuantity = $stock;
    }

    mysqli_query($conn, "
    UPDATE cart
    SET quantity='$newQuantity'
    WHERE user_id='$user'
    AND product_id='$product'
    ");
} else {

    /* Don't exceed stock */
    if ($quantity > $stock) {
        $quantity = $stock;
    }

    mysqli_query($conn, "
    INSERT INTO cart(user_id,product_id,quantity)
    VALUES('$user','$product','$quantity')
    ");
}

/* Update cart badge */
$total = mysqli_query($conn, "
SELECT SUM(quantity) AS total
FROM cart
WHERE user_id='$user'
");

$count = mysqli_fetch_assoc($total);

echo json_encode([

    "success" => true,

    "count" => $count['total']

]);
