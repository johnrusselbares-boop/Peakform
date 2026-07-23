<?php
session_start();
include "db.php";

$message = "";

if (isset($_POST['login'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = mysqli_query($conn, "
SELECT *
FROM admin
WHERE username='$username'
");

    if (mysqli_num_rows($query) > 0) {

        $admin = mysqli_fetch_assoc($query);

        if ($password == $admin['password']) {

            $_SESSION['admin_id'] = $admin['id'];

            header("Location: admin_dashboard.php");
            exit();
        } else {

            $message = "Incorrect Password.";
        }
    } else {

        $message = "Admin not found.";
    }
}
?>

<!DOCTYPE html>
<html>

<head>

    <title>Admin Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-dark">

    <div class="container">

        <div class="row justify-content-center">

            <div class="col-md-5">

                <div class="card mt-5">

                    <div class="card-body">

                        <h2 class="text-center mb-4">

                            Admin Login

                        </h2>

                        <?php if ($message != "") { ?>

                            <div class="alert alert-danger">

                                <?= $message ?>

                            </div>

                        <?php } ?>

                        <form method="POST">

                            <div class="mb-3">

                                <label>Username</label>

                                <input
                                    type="text"
                                    name="username"
                                    class="form-control"
                                    required>

                            </div>

                            <div class="mb-3">

                                <label>Password</label>

                                <input
                                    type="password"
                                    name="password"
                                    class="form-control"
                                    required>

                            </div>

                            <button
                                name="login"
                                class="btn btn-dark w-100">

                                Login

                            </button>

                        </form>

                        <br>

                        <a href="login.php" class="btn btn-secondary w-100">

                            Back to User Login

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</body>

</html>