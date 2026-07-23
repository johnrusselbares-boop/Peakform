<?php
include 'db.php';

$message = "";

if (isset($_POST['login'])) {

    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $password = $_POST['password'];

    $query = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");

    if (mysqli_num_rows($query) == 1) {

        $user = mysqli_fetch_assoc($query);

        if (password_verify($password, $user['password'])) {

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['firstname'] = $user['firstname'];
            $_SESSION['lastname'] = $user['lastname'];
            $_SESSION['email'] = $user['email'];

            header("Location: peakform.php");
            exit();
        } else {

            $message = "Incorrect password.";
        }
    } else {

        $message = "Email not found.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>PeakForm Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        * {

            margin: 0;
            padding: 0;
            box-sizing: border-box;

        }

        body {

            background: #000;
            font-family: 'Oswald', sans-serif;
            color: #fff;

        }

        .login-section {

            min-height: 100vh;

        }

        .left-side {

            display: flex;
            justify-content: center;
            align-items: center;

            height: 100vh;

        }

        .left-side img {

            width: 80%;
            max-width: 700px;

        }

        .right-side {

            display: flex;
            justify-content: center;
            align-items: center;

            height: 100vh;

        }

        .form-box {

            width: 100%;
            max-width: 520px;

        }

        .logo {

            text-align: center;

            font-size: 45px;

            font-weight: 500;

            letter-spacing: 2px;

            margin-bottom: 50px;

        }

        label {

            font-size: 18px;

            margin-bottom: 10px;

            display: block;

        }

        .form-control {

            height: 60px;

            border-radius: 0;

            border: none;

            font-size: 18px;

            margin-bottom: 25px;

        }

        .form-control:focus {

            box-shadow: none;

        }

        .btn-login {

            width: 100%;

            height: 65px;

            border: none;

            border-radius: 50px;

            background: #fff;

            color: #000;

            font-size: 28px;

            font-weight: 600;

            margin-top: 30px;

            transition: .3s;

        }

        .btn-login:hover {

            background: #d9d9d9;

        }

        .small-text {

            font-size: 18px;

            color: #ccc;

            line-height: 1.7;

            margin-top: 20px;

        }

        .small-text a {

            color: #fff;

            text-decoration: none;

        }

        .message {

            margin-bottom: 20px;

        }

        .password-box {

            position: relative;

        }

        .password-box .form-control {

            height: 60px;

            padding-right: 55px;

        }

        .toggle-password {

            position: absolute;

            top: 50%;

            right: 20px;

            transform: translateY(-50%);

            cursor: pointer;

            color: #555;

            font-size: 20px;

        }

        .toggle-password:hover {

            color: #000;

        }

        .logo {

            position: relative;

            z-index: 9999;

        }

        .admin-link {

            color: #fff;

            text-decoration: none;

            display: inline-block;

            cursor: pointer;

        }

        .admin-link:hover {

            color: #ddd;

        }
    </style>

</head>

<body>

    <section class="login-section">

        <div class="container-fluid">

            <div class="row">

                <!-- LEFT IMAGE -->

                <div class="col-lg-7 left-side">

                    <img src="loginpic.jpg" alt="">

                    <!-- Put your image filename here -->

                </div>

                <!-- RIGHT LOGIN -->

                <div class="col-lg-5 right-side">

                    <div class="form-box">

                        <h1 class="logo">

                            <a href="admin_login.php" class="admin-link">

                                PeakForm

                            </a>

                        </h1>

                        <?php

                        if (isset($message) && $message != "") {

                            echo "<div class='alert alert-danger message'>$message</div>";
                        }

                        ?>

                        <form method="POST">

                            <label>Email Address*</label>

                            <input
                                type="email"
                                name="email"
                                class="form-control"
                                required>

                            <label>Password*</label>

                            <div class="password-box">

                                <input
                                    type="password"
                                    name="password"
                                    id="password"
                                    class="form-control"
                                    required>

                                <span class="toggle-password" onclick="togglePassword()">

                                    <i class="fa-regular fa-eye" id="eyeIcon"></i>

                                </span>

                            </div>

                            <button
                                type="submit"
                                name="login"
                                class="btn-login">

                                LOGIN

                            </button>

                            <p class="text-center mt-4">

                                Don't have an account?

                                <a href="register.php">

                                    Register

                                </a>

                            </p>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </section>
    <script>
        function togglePassword() {

            const password = document.getElementById("password");
            const eye = document.getElementById("eyeIcon");

            if (password.type === "password") {

                password.type = "text";

                eye.classList.remove("fa-eye");
                eye.classList.add("fa-eye-slash");

            } else {

                password.type = "password";

                eye.classList.remove("fa-eye-slash");
                eye.classList.add("fa-eye");

            }

        }
    </script>
</body>

</html>