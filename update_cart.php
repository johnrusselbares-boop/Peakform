<?php

include 'db.php';

$id = (int)$_GET['id'];

$action = $_GET['action'];

if ($action == "plus") {

    mysqli_query($conn, "
UPDATE cart
SET quantity=quantity+1
WHERE id='$id'
");
} else {

    $get = mysqli_query($conn, "
SELECT quantity
FROM cart
WHERE id='$id'
");

    $row = mysqli_fetch_assoc($get);

    if ($row['quantity'] > 1) {

        mysqli_query($conn, "
UPDATE cart
SET quantity=quantity-1
WHERE id='$id'
");
    }
}

header("Location: cart.php");
