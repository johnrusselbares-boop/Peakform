<?php

include 'db.php';

$id = (int)$_GET['id'];

mysqli_query($conn, "
DELETE FROM cart
WHERE id='$id'
");

header("Location: cart.php");
