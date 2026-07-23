<?php
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$query = mysqli_query($conn, "
SELECT *
FROM users
WHERE id='$user_id'
");

$user = mysqli_fetch_assoc($query);

$orderQuery = mysqli_query($conn, "
SELECT
    orders.id,
    orders.fullname,
    orders.address,
    orders.contact,
    orders.payment,
    orders.status,
    orders.created_at,

    products.id AS product_id,
products.name,
products.image,

    order_items.quantity,
    order_items.price

FROM orders

INNER JOIN order_items
ON orders.id = order_items.order_id

INNER JOIN products
ON products.id = order_items.product_id

WHERE orders.user_id='$user_id'

ORDER BY orders.created_at DESC
");
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>My Profile</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        body {

            background: #000;
            color: #fff;
            font-family: Poppins, sans-serif;

        }

        .profile-card {

            width: 100%;

            background: #111;

            border: 1px solid #333;

            border-radius: 20px;

            padding: 35px;

            box-shadow: 0 10px 35px rgba(0, 0, 0, .5);

        }

        .profile-avatar {

            width: 120px;
            height: 120px;

            border-radius: 50%;

            background: #222;

            display: flex;

            justify-content: center;

            align-items: center;

            margin: auto;

            font-size: 55px;

            margin-bottom: 25px;

        }

        .profile-title {

            text-align: center;

            margin-bottom: 35px;

        }

        .info {

            background: #1b1b1b;

            padding: 15px 20px;

            border-radius: 12px;

            margin-bottom: 15px;

        }

        .info label {

            color: #999;

            margin-bottom: 5px;

            display: block;

        }

        .info p {

            margin: 0;

            font-size: 18px;

            font-weight: 600;

        }

        .btn-custom {

            border-radius: 30px;

            padding: 12px;

        }

        .order-card {

            background: #1a1a1a;

            border: 1px solid #333;

            border-radius: 15px;

        }

        .order-card img {

            width: 100%;

            height: 180px;

            object-fit: cover;

            border-radius: 10px;

        }

        .badge {

            font-size: 14px;

        }

        .order-card {

            background: #1a1a1a;

            border: 1px solid #333;

            color: #fff;

        }

        .order-card h4,
        .order-card p,
        .order-card strong {

            color: #fff;

        }

        .orders-container {

            max-height: 700px;

            overflow-y: auto;

            padding-right: 10px;

        }

        .orders-container::-webkit-scrollbar {

            width: 8px;

        }

        .orders-container::-webkit-scrollbar-track {

            background: #111;

            border-radius: 10px;

        }

        .orders-container::-webkit-scrollbar-thumb {

            background: #555;

            border-radius: 10px;

        }

        .orders-container::-webkit-scrollbar-thumb:hover {

            background: #888;

        }
    </style>

</head>

<body>

    <div class="container py-5">

        <div class="row g-4">

            <!-- LEFT PROFILE -->

            <div class="col-lg-5">

                <div class="profile-card">

                    <div class="profile-avatar">

                        <i class="fa-solid fa-user"></i>

                    </div>

                    <h2 class="profile-title">

                        My Profile

                    </h2>

                    <div class="info">

                        <label>First Name</label>

                        <p><?= htmlspecialchars($user['firstname']); ?></p>

                    </div>

                    <div class="info">

                        <label>Last Name</label>

                        <p><?= htmlspecialchars($user['lastname']); ?></p>

                    </div>

                    <div class="info">

                        <label>Email Address</label>

                        <p><?= htmlspecialchars($user['email']); ?></p>

                    </div>

                    <div class="d-grid gap-3 mt-4">

                        <a
                            href="peakform.php"
                            class="btn btn-light btn-custom">

                            <i class="fa-solid fa-house"></i>

                            Back to Home

                        </a>

                        <a
                            href="logout.php"
                            class="btn btn-danger btn-custom">

                            <i class="fa-solid fa-right-from-bracket"></i>

                            Logout

                        </a>

                    </div>

                </div>

            </div>

            <!-- RIGHT ORDERS -->

            <div class="col-lg-7">

                <div class="profile-card">

                    <h2 class="mb-4">

                        <i class="fa-solid fa-box"></i>

                        My Orders

                    </h2>

                    <div class="orders-container">

                        <?php

                        if (mysqli_num_rows($orderQuery) > 0) {

                            while ($order = mysqli_fetch_assoc($orderQuery)) {

                        ?>

                                <div class="card order-card mb-4">

                                    <div class="card-body">

                                        <div class="row align-items-center">

                                            <div class="col-md-4">

                                                <img
                                                    src="<?= $order['image']; ?>"
                                                    alt="">

                                            </div>

                                            <div class="col-md-8">

                                                <h4>

                                                    <?= htmlspecialchars($order['name']); ?>

                                                </h4>

                                                <p>

                                                    Status :

                                                    <span class="badge bg-success">

                                                        <?= htmlspecialchars($order['status']); ?>

                                                    </span>

                                                </p>

                                                <p>

                                                    Quantity :

                                                    <?= $order['quantity']; ?>

                                                </p>

                                                <p>

                                                    Full Name :

                                                    <?= htmlspecialchars($order['fullname']); ?>

                                                </p>

                                                <p>

                                                    Address :

                                                    <?= htmlspecialchars($order['address']); ?>

                                                </p>

                                                <p>

                                                    Contact :

                                                    <?= htmlspecialchars($order['contact']); ?>

                                                </p>

                                                <p>

                                                    Payment :

                                                    <?= htmlspecialchars($order['payment']); ?>

                                                </p>

                                                <p>

    Price :

    ₱<?= number_format($order['price'], 2); ?>

</p>

<a
    href="review.php?product=<?= $order['product_id']; ?>&order=<?= $order['id']; ?>"
    class="btn btn-warning w-100 mt-3">

    ⭐ Write Review

</a>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            <?php

                            }
                        } else {

                            ?>

                            <div class="text-center py-5">

                                <i class="fa-solid fa-box-open fa-5x mb-4"></i>

                                <h4>

                                    No Orders Yet

                                </h4>

                                <p class="text-secondary">

                                    Your purchased products will appear here.

                                </p>

                            </div>

                        <?php

                        }

                        ?>

                    </div>

                </div>

            </div>

        </div>

</body>

</html>