<?php
include "db.php";

if(!isset($_SESSION['user_id'])){
    header("Location:login.php");
    exit();
}

$product = $_GET['product'];
$order   = $_GET['order'];
?>

<!DOCTYPE html>

<html>

<head>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-dark text-white">

<div class="container py-5">

<h2>Write Review</h2>

<form action="save_review.php" method="POST">

<input type="hidden" name="product" value="<?= $product ?>">

<input type="hidden" name="order" value="<?= $order ?>">

<label>Rating</label>

<select class="form-select mb-3" name="rating">

<option value="5">★★★★★</option>
<option value="4">★★★★☆</option>
<option value="3">★★★☆☆</option>
<option value="2">★★☆☆☆</option>
<option value="1">★☆☆☆☆</option>

</select>

<label>Review</label>

<textarea
class="form-control"
name="review"
rows="5"
required></textarea>

<button class="btn btn-warning mt-4">

Submit Review

</button>

</form>

</div>

</body>

</html>