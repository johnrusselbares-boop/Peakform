<?php

include 'db.php';

if (!isset($_SESSION['user_id'])) {

    echo "<script>

        alert('Please login or register first.');

        window.location='login.php';

    </script>";

    exit();
}

$user = $_SESSION['user_id'];

$query = mysqli_query($conn, "
SELECT
cart.id,
cart.quantity,
products.name,
products.price,
products.image
FROM cart
INNER JOIN products
ON cart.product_id = products.id
WHERE cart.user_id='$user'
");
?>

<!DOCTYPE html>

<html>

<head>

    <meta charset="UTF-8">

    <title>Shopping Cart</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        body {

            background: #f5f5f5;

        }

        .cart-card {

            border-radius: 15px;

        }

        .cart-image {

            width: 120px;
            height: 120px;

            object-fit: cover;

        }

        .qty-btn {

            width: 40px;

        }
    </style>

</head>

<body>

    <div class="container py-5">

        <h1 class="fw-bold mb-4">

            Shopping Cart

        </h1>

        <table class="table table-bordered bg-white align-middle">

            <thead>

                <tr>

                    <th>Image</th>

                    <th>Product</th>

                    <th>Price</th>

                    <th>Quantity</th>

                    <th>Subtotal</th>

                    <th>Remove</th>

                </tr>

            </thead>

            <tbody>

                <?php

                $total = 0;

                while ($row = mysqli_fetch_assoc($query)) {

                    $subtotal = $row['price'] * $row['quantity'];

                    $total += $subtotal;

                ?>

                    <tr>

                        <td>

                            <img
                                src="<?php echo $row['image']; ?>"
                                class="cart-image">

                        </td>

                        <td>

                            <?php echo $row['name']; ?>

                        </td>

                        <td>

                            ₱<?php echo number_format($row['price'], 2); ?>

                        </td>

                        <td>

                            <div class="d-flex">

                                <a
                                    href="update_cart.php?id=<?php echo $row['id']; ?>&action=minus"
                                    class="btn btn-dark qty-btn">

                                    -

                                </a>

                                <input
                                    class="form-control text-center"
                                    style="width:70px"
                                    value="<?php echo $row['quantity']; ?>"
                                    readonly>

                                <a
                                    href="update_cart.php?id=<?php echo $row['id']; ?>&action=plus"
                                    class="btn btn-dark qty-btn">

                                    +

                                </a>

                            </div>

                        </td>

                        <td>

                            ₱<?php echo number_format($subtotal, 2); ?>

                        </td>

                        <td>

                            <a
                                href="remove_cart.php?id=<?php echo $row['id']; ?>"
                                class="btn btn-danger">

                                <i class="fa fa-trash"></i>

                            </a>

                        </td>

                    </tr>

                <?php } ?>

            </tbody>

        </table>

        <div class="text-end">

            <h2>

                Grand Total

                <strong>

                    ₱<?php echo number_format($total, 2); ?>

                </strong>

            </h2>

            <a
                href="checkout.php"
                class="btn btn-dark btn-lg mt-3">

                Checkout

            </a>

            <a
                href="peakform.php"
                class="btn btn-secondary btn-lg mt-3">

                Continue Shopping

            </a>

        </div>

    </div>

</body>

</html>