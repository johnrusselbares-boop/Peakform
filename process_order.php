<?php
include 'db.php';

$user = $_SESSION['user_id'];

$fullname = mysqli_real_escape_string($conn,$_POST['fullname']);
$address  = mysqli_real_escape_string($conn,$_POST['address']);
$contact  = mysqli_real_escape_string($conn,$_POST['contact']);
$payment  = mysqli_real_escape_string($conn,$_POST['payment']);

$total = 0;

/* =========================
   COMPUTE TOTAL
========================= */

if(isset($_SESSION['buy_now_product'])){

    $product_id = $_SESSION['buy_now_product'];
    $qty = $_SESSION['buy_now_qty'];

    $result = mysqli_query($conn,"
    SELECT price
    FROM products
    WHERE id='$product_id'
    ");

    $product = mysqli_fetch_assoc($result);

    $total = $product['price'] * $qty;

}else{

    $cart = mysqli_query($conn,"
    SELECT cart.quantity,products.price
    FROM cart
    INNER JOIN products
    ON cart.product_id=products.id
    WHERE cart.user_id='$user'
    ");

    while($row=mysqli_fetch_assoc($cart)){

        $total += $row['quantity'] * $row['price'];

    }

}

/* =========================
   CREATE ORDER
========================= */

mysqli_query($conn,"
INSERT INTO orders
(user_id,fullname,address,contact,payment,total)
VALUES
('$user','$fullname','$address','$contact','$payment','$total')
");

$order = mysqli_insert_id($conn);

/* =========================
   BUY NOW
========================= */

if(isset($_SESSION['buy_now_product'])){

    $product_id=$_SESSION['buy_now_product'];
    $qty=$_SESSION['buy_now_qty'];

    $result=mysqli_query($conn,"
    SELECT price
    FROM products
    WHERE id='$product_id'
    ");

    $product=mysqli_fetch_assoc($result);

    mysqli_query($conn,"
    INSERT INTO order_items
    (order_id,product_id,quantity,price)
    VALUES
    (
        '$order',
        '$product_id',
        '$qty',
        '".$product['price']."'
    )
    ");

    unset($_SESSION['buy_now_product']);
    unset($_SESSION['buy_now_qty']);

}

/* =========================
   CART CHECKOUT
========================= */

else{

    $cart=mysqli_query($conn,"
    SELECT *
    FROM cart
    WHERE user_id='$user'
    ");

    while($item=mysqli_fetch_assoc($cart)){

        $product=mysqli_query($conn,"
        SELECT price
        FROM products
        WHERE id='".$item['product_id']."'
        ");

        $price=mysqli_fetch_assoc($product);

        mysqli_query($conn,"
        INSERT INTO order_items
        (order_id,product_id,quantity,price)
        VALUES
        (
            '$order',
            '".$item['product_id']."',
            '".$item['quantity']."',
            '".$price['price']."'
        )
        ");

    }

    mysqli_query($conn,"
    DELETE FROM cart
    WHERE user_id='$user'
    ");

}

?>

<!DOCTYPE html>
<html>

<head>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container text-center py-5">

<h1>✅ Order Successful!</h1>

<h3 class="mt-3">

Thank you for shopping at PeakForm.

</h3>

<a href="peakform.php" class="btn btn-dark mt-4">

Continue Shopping

</a>

</div>

</body>

</html>