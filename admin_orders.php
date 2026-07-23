<?php
session_start();
include "db.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

if (isset($_POST['update'])) {

    $id = $_POST['order_id'];
    $status = $_POST['status'];

    mysqli_query($conn, "
    UPDATE orders
    SET status='$status'
    WHERE id='$id'
    ");
}

$orders = mysqli_query($conn, "
SELECT
orders.*,
products.name,
products.image,
order_items.quantity,
order_items.price

FROM orders

INNER JOIN order_items
ON orders.id=order_items.order_id

INNER JOIN products
ON products.id=order_items.product_id

ORDER BY orders.created_at DESC
");
?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">

    <title>Manage Orders</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        body {
            background: #f5f5f5;
        }

        .card {
            border: none;
            border-radius: 18px;
        }

        img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 12px;
        }
    </style>

</head>

<body>

    <div class="container py-5">

        <h2 class="mb-4">

            <i class="fa-solid fa-box"></i>

            Manage Orders

        </h2>

        <a
            href="admin_dashboard.php"
            class="btn btn-dark">

            Back Dashboard

        </a>

        <?php while ($row = mysqli_fetch_assoc($orders)) { ?>

            <div class="card shadow mb-4">

                <div class="card-body">

                    <div class="row">

                        <div class="col-md-3">

                            <img src="<?= $row['image']; ?>">

                        </div>

                        <div class="col-md-5">

                            <h4><?= $row['name']; ?></h4>

                            <p><b>Customer:</b> <?= $row['fullname']; ?></p>

                            <p><b>Address:</b> <?= $row['address']; ?></p>

                            <p><b>Contact:</b> <?= $row['contact']; ?></p>

                            <p><b>Payment:</b> <?= $row['payment']; ?></p>

                            <p><b>Quantity:</b> <?= $row['quantity']; ?></p>

                            <p><b>Total:</b> ₱<?= number_format($row['price'] * $row['quantity'], 2); ?></p>

                        </div>

                        <div class="col-md-4">

                            <form method="POST">

                                <input
                                    type="hidden"
                                    name="order_id"
                                    value="<?= $row['id']; ?>">

                                <label>Status</label>

                                <select
                                    name="status"
                                    class="form-select mb-3">

                                    <option
                                        <?= $row['status'] == "Pending" ? "selected" : ""; ?>>

                                        Pending

                                    </option>

                                    <option
                                        <?= $row['status'] == "Processing" ? "selected" : ""; ?>>

                                        Processing

                                    </option>

                                    <option
                                        <?= $row['status'] == "Shipped" ? "selected" : ""; ?>>

                                        Shipped

                                    </option>

                                    <option
                                        <?= $row['status'] == "Delivered" ? "selected" : ""; ?>>

                                        Delivered

                                    </option>

                                </select>

                                <button
                                    name="update"
                                    class="btn btn-success w-100">

                                    Update Status

                                </button>

                            </form>

                        </div>

                    </div>

                </div>

            </div>

        <?php } ?>



    </div>

</body>

</html>