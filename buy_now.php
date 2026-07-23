<?php

include "db.php";

if (!isset($_SESSION['user_id'])) {

    header("Location:login.php");

    exit();
}

$_SESSION['buy_now_product'] = $_POST['product_id'];

$_SESSION['buy_now_qty'] = $_POST['quantity'];

header("Location:checkout.php");
