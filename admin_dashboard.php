<?php
session_start();
include "db.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

$product = mysqli_fetch_assoc(mysqli_query($conn, "
SELECT COUNT(*) AS total
FROM products
"));

$user = mysqli_fetch_assoc(mysqli_query($conn, "
SELECT COUNT(*) AS total
FROM users
"));

$order = mysqli_fetch_assoc(mysqli_query($conn, "
SELECT COUNT(*) AS total
FROM orders
"));

$sales = mysqli_fetch_assoc(mysqli_query($conn, "
SELECT IFNULL(SUM(total),0) AS total
FROM orders
"));
?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">

    <title>Admin Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        body {
            background: #f5f5f5;
        }

        .sidebar {
            width: 260px;
            height: 100vh;
            position: fixed;
            background: #111;
            color: white;
            padding: 30px 20px;
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 40px;
        }

        .sidebar a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 10px;
            transition: .3s;
        }

        .sidebar a:hover {
            background: #222;
        }

        .content {
            margin-left: 280px;
            padding: 40px;
        }

        .card {
            border: none;
            border-radius: 18px;
        }

        .icon {
            font-size: 45px;
            opacity: .3;
        }
    </style>

</head>

<body>

    <div class="sidebar">

        <h2>PeakForm Admin</h2>

        <a href="admin_dashboard.php">
            <i class="fa-solid fa-chart-line"></i>
            Dashboard
        </a>

        <a href="manage_products.php">
            <i class="fa-solid fa-shirt"></i>
            Products
        </a>

        <a href="admin_orders.php">
            <i class="fa-solid fa-box"></i>
            Orders
        </a>

        <a href="manage_users.php">
            <i class="fa-solid fa-users"></i>
            Manage Users
        </a>

        <a href="logout.php">
            <i class="fa-solid fa-right-from-bracket"></i>
            Logout
        </a>


    </div>

    <div class="content">

        <h2 class="mb-4">
            Dashboard
        </h2>

        <div class="row g-4">

            <div class="col-md-6 col-xl-3">

                <div class="card shadow">

                    <div class="card-body">

                        <div class="d-flex justify-content-between">

                            <div>

                                <h6>Total Products</h6>

                                <h2><?= $product['total']; ?></h2>

                            </div>

                            <i class="fa-solid fa-shirt icon"></i>

                        </div>

                    </div>

                </div>

            </div>

            <div class="col-md-6 col-xl-3">

                <div class="card shadow">

                    <div class="card-body">

                        <div class="d-flex justify-content-between">

                            <div>

                                <h6>Total Users</h6>

                                <h2><?= $user['total']; ?></h2>

                            </div>

                            <i class="fa-solid fa-users icon"></i>

                        </div>

                    </div>

                </div>

            </div>

            <div class="col-md-6 col-xl-3">

                <div class="card shadow">

                    <div class="card-body">

                        <div class="d-flex justify-content-between">

                            <div>

                                <h6>Total Orders</h6>

                                <h2><?= $order['total']; ?></h2>

                            </div>

                            <i class="fa-solid fa-cart-shopping icon"></i>

                        </div>

                    </div>

                </div>

            </div>

            <div class="col-md-6 col-xl-3">

                <div class="card shadow">

                    <div class="card-body">

                        <div class="d-flex justify-content-between">

                            <div>

                                <h6>Total Sales</h6>

                                <h2>₱<?= number_format($sales['total'], 2); ?></h2>

                            </div>

                            <i class="fa-solid fa-peso-sign icon"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <hr class="my-5">

        <h3>Quick Actions</h3>

        <div class="mt-4">

            <a href="add_product.php" class="btn btn-success btn-lg me-3">
                <i class="fa-solid fa-plus"></i>
                Add Product
            </a>

            <a href="manage_products.php" class="btn btn-dark btn-lg me-3">
                <i class="fa-solid fa-pen"></i>
                Manage Products
            </a>

            <a href="admin_orders.php" class="btn btn-primary btn-lg">
                <i class="fa-solid fa-box"></i>
                View Orders
            </a>

        </div>

    </div>

</body>

</html>