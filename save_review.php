<?php

include "db.php";

$user=$_SESSION['user_id'];

$product=$_POST['product'];

$order=$_POST['order'];

$rating=$_POST['rating'];

$review=mysqli_real_escape_string($conn,$_POST['review']);

mysqli_query($conn,"
INSERT INTO reviews
(user_id,product_id,order_id,rating,review)
VALUES
('$user','$product','$order','$rating','$review')
");

header("Location:profile.php");

?>