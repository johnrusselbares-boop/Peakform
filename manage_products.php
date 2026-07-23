<?php

session_start();
include "db.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location:admin_login.php");
    exit();
}

$product = mysqli_query($conn, "
SELECT *
FROM products
ORDER BY id DESC
");

?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">

    <title>Manage Products</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        body {

            background: #f5f5f5;

        }

        .container {

            margin-top: 40px;

        }

        img {

            width: 80px;

            height: 80px;

            object-fit: cover;

            border-radius: 10px;

        }
    </style>

</head>

<body>

    <div class="container">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <h2>Manage Products</h2>

            <?php if (isset($_GET['deleted'])) { ?>

                <div class="alert alert-success alert-dismissible fade show" role="alert">

                    <i class="fa-solid fa-circle-check"></i>

                    Product deleted successfully!

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="alert">
                    </button>

                </div>

            <?php } ?>



            <a href="add_product.php" class="btn btn-success">

                <i class="fa fa-plus"></i>

                Add Product

            </a>

            <a href="admin_dashboard.php" class="btn btn-dark">

                Back Dashboard

            </a>

        </div>

        <table class="table table-bordered table-hover bg-white">

            <thead class="table-dark">

                <tr>

                    <th>ID</th>

                    <th>Image</th>

                    <th>Name</th>

                    <th>Price</th>

                    <th>Stock</th>

                    <th>Action</th>

                </tr>

            </thead>

            <tbody>

                <?php while ($row = mysqli_fetch_assoc($product)) { ?>

                    <tr>

                        <td><?= $row['id']; ?></td>

                        <td>

                            <img src="<?= $row['image']; ?>">

                        </td>

                        <td><?= $row['name']; ?></td>

                        <td>

                            ₱<?= number_format($row['price'], 2); ?>

                        </td>

                        <td><?= $row['stock']; ?></td>

                        <td>

                            <a href="edit_product.php?id=<?= $row['id']; ?>" class="btn btn-primary btn-sm">

                                Edit

                            </a>

                            <a href="delete_product.php?id=<?= $row['id']; ?>"
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('Delete this product?')">

                                Delete

                            </a>

                        </td>

                    </tr>

                <?php } ?>

            </tbody>

        </table>



    </div>

    <script>
        setTimeout(function() {

            let alert = document.querySelector(".alert");

            if (alert) {

                let bsAlert = bootstrap.Alert.getOrCreateInstance(alert);

                bsAlert.close();

            }

        }, 2500);
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>