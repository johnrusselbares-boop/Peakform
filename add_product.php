<?php
session_start();
include 'db.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location:admin_login.php');
    exit();
}

$message = '';

if (isset($_POST['add'])) {

    $name        = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price       = mysqli_real_escape_string($conn, $_POST['price']);
    $stock       = mysqli_real_escape_string($conn, $_POST['stock']);

    // IMAGE
    $imageName = $_FILES['image']['name'];
    $tmpName   = $_FILES['image']['tmp_name'];

    // create unique filename
    $newName = time() . '_' . $imageName;

    // save inside uploads folder
    $path = 'uploads/' . $newName;

    move_uploaded_file($tmpName, $path);

    // INSERT
    mysqli_query($conn, "
INSERT INTO products
(name,description,price,stock,image)
VALUES
(
    '$name',
    '$description',
    '$price',
    '$stock',
    '$path'
)
");

    $message = 'Product Added Successfully!';
}
?>

<!DOCTYPE html>
<html>

<head>

    <meta charset='UTF-8'>

    <title>Add Product</title>

    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css' rel='stylesheet'>

    <link rel='stylesheet'
        href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css'>

    <style>
        body {
            background: #f5f5f5;
        }

        .card {
            border: none;
            border-radius: 20px;
        }
    </style>

</head>

<body>

    <div class='container py-5'>

        <div class='row justify-content-center'>

            <div class='col-lg-8'>

                <div class='card shadow'>

                    <div class='card-body p-5'>

                        <h2 class='mb-4 text-center'>
                            <i class='fa fa-plus-circle text-success'></i>
                            Add New Product
                        </h2>

                        <?php if ($message != '') { ?>

                            <div class='alert alert-success'>
                                <?= $message; ?>
                            </div>

                        <?php } ?>

                        <form method='POST' enctype='multipart/form-data'>

                            <div class='mb-3'>

                                <label class='form-label'>Product Image</label>

                                <input
                                    type='file'
                                    name='image'
                                    class='form-control'
                                    accept='image/*'
                                    required>

                            </div>

                            <div class='mb-3'>

                                <label class='form-label'>Product Name</label>

                                <input
                                    type='text'
                                    name='name'
                                    class='form-control'
                                    required>

                            </div>

                            <div class='mb-3'>

                                <label class='form-label'>Description</label>

                                <textarea
                                    name='description'
                                    class='form-control'
                                    rows='4'
                                    required></textarea>

                            </div>

                            <div class='row'>

                                <div class='col-md-6 mb-3'>

                                    <label class='form-label'>Price</label>

                                    <input
                                        type='number'
                                        step='0.01'
                                        name='price'
                                        class='form-control'
                                        required>

                                </div>

                                <div class='col-md-6 mb-3'>

                                    <label class='form-label'>Stock</label>

                                    <input
                                        type='number'
                                        name='stock'
                                        class='form-control'
                                        required>

                                </div>

                            </div>

                            <div class='d-grid gap-2 mt-4'>

                                <button
                                    type='submit'
                                    name='add'
                                    class='btn btn-success btn-lg'>

                                    <i class='fa fa-save'></i>
                                    Add Product

                                </button>

                                <a
                                    href='admin_dashboard.php'
                                    class='btn btn-dark'>

                                    Back to Dashboard

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