<?php

include "db.php";

$product=$_GET['product'];

$query=mysqli_query($conn,"
SELECT
users.firstname,
reviews.rating,
reviews.review,
reviews.created_at
FROM reviews
INNER JOIN users
ON reviews.user_id=users.id
WHERE product_id='$product'
ORDER BY created_at DESC
");

while($row=mysqli_fetch_assoc($query)){

echo "

<div class='border rounded p-3 mb-3'>

<strong>{$row['firstname']}</strong>

<br>

<span style='color:gold;'>";

for($i=1;$i<=5;$i++){

echo $i<=$row['rating'] ? "★" : "☆";

}

echo "</span>

<p>{$row['review']}</p>

</div>";

}