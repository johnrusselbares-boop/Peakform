<?php
session_start();
include "db.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

$id = $_GET['id'];

$product = mysqli_query($conn, "
SELECT *
FROM products
WHERE id='$id'
");

$row = mysqli_fetch_assoc($product);

$message = "";

if (isset($_POST['update'])) {

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $stock = mysqli_real_escape_string($conn, $_POST['stock']);

    $image = $row['image'];

    if ($_FILES['image']['name'] != "") {

        $newName = time() . "_" . $_FILES['image']['name'];

        $path = "uploads/" . $newName;

        move_uploaded_file($_FILES['image']['tmp_name'], $path);

        $image = $path;
    }

    mysqli_query($conn, "
    UPDATE products
    SET
    name='$name',
    description='$description',
    price='$price',
    stock='$stock',
    image='$image'
    WHERE id='$id'
    ");

    $message = "Product Updated Successfully!";

    $product = mysqli_query($conn, "
    SELECT *
    FROM products
    WHERE id='$id'
    ");

    $row = mysqli_fetch_assoc($product);
}
?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">

    <title>Edit Product</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        body {
            background: #f5f5f5;
        }

        .card {
            border: none;
            border-radius: 20px;
        }

        .preview {
            width: 220px;
            height: 220px;
            object-fit: cover;
            border-radius: 15px;
        }
    </style>

</head>

<body>

    <div class="container py-5">

        <div class="row justify-content-center">

            <div class="col-lg-8">

                <div class="card shadow">

                    <div class="card-body p-5">

                        <h2 class="text-center mb-4">

                            <i class="fa-solid fa-pen-to-square text-primary"></i>

                            Edit Product

                        </h2>

                        <?php if ($message != "") { ?>

                            <div class="alert alert-success">

                                <?= $message; ?>

                            </div>

                        <?php } ?>

                        <form method="POST" enctype="multipart/form-data">

                            <div class="text-center mb-4">

                                <img
                                    src="<?= $row['image']; ?>"
                                    class="preview mb-3">

                            </div>

                            <div class="mb-3">

                                <label>Change Image</label>

                                <input
                                    type="file"
                                    name="image"
                                    class="form-control">

                            </div>

                            <div class="mb-3">

                                <label>Product Name</label>

                                <input
                                    type="text"
                                    name="name"
                                    class="form-control"
                                    value="<?= htmlspecialchars($row['name']); ?>"
                                    required>

                            </div>

                            <div class="mb-3">

                                <label>Description</label>

                                <textarea
                                    name="description"
                                    rows="4"
                                    class="form-control"
                                    required><?= htmlspecialchars($row['description']); ?></textarea>

                            </div>

                            <div class="row">

                                <div class="col-md-6">

                                    <label>Price</label>

                                    <input
                                        type="number"
                                        step="0.01"
                                        name="price"
                                        class="form-control"
                                        value="<?= $row['price']; ?>"
                                        required>

                                </div>

                                <div class="col-md-6">

                                    <label>Stock</label>

                                    <input
                                        type="number"
                                        name="stock"
                                        class="form-control"
                                        value="<?= $row['stock']; ?>"
                                        required>

                                </div>

                            </div>

                            <div class="d-grid gap-2 mt-4">

                                <button
                                    type="submit"
                                    name="update"
                                    class="btn btn-primary btn-lg">

                                    <i class="fa-solid fa-floppy-disk"></i>

                                    Update Product

                                </button>

                                <a
                                    href="manage_products.php"
                                    class="btn btn-dark">

                                    Back to Products

                                </a>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

</body>

</html>