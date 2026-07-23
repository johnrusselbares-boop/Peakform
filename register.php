<?php
include 'db.php';

$message = "";

if (isset($_POST['register'])) {

    $firstname = mysqli_real_escape_string($conn, trim($_POST['firstname']));
    $lastname  = mysqli_real_escape_string($conn, trim($_POST['lastname']));
    $email     = mysqli_real_escape_string($conn, trim($_POST['email']));
    $password  = $_POST['password'];
    $confirm   = $_POST['confirm'];

    // Check if email already exists
    $check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");

    if (mysqli_num_rows($check) > 0) {

        $message = "Email already exists.";
    } elseif ($password != $confirm) {

        $message = "Passwords do not match.";
    } elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W]).{8,}$/', $password)) {

        $message = "Password must contain at least 8 characters, an uppercase letter, a lowercase letter, a number, and a special character.";
    } else {

        $hash = password_hash($password, PASSWORD_DEFAULT);

        $insert = mysqli_query($conn, "
            INSERT INTO users(firstname,lastname,email,password)
            VALUES('$firstname','$lastname','$email','$hash')
        ");

        if ($insert) {

            header("Location: login.php");
            exit();
        } else {

            $message = "Registration failed.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>PeakForm Register</title>

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

        .register-section {
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
            letter-spacing: 2px;
            margin-bottom: 40px;
        }

        label {
            font-size: 18px;
            margin-bottom: 8px;
            display: block;
        }

        .form-control {
            height: 58px;
            border: none;
            border-radius: 0;
            font-size: 18px;
            margin-bottom: 18px;
        }

        .form-control:focus {
            box-shadow: none;
        }

        .password-box {
            position: relative;
        }

        .password-box input {
            padding-right: 55px;
        }

        .toggle-password {
            position: absolute;
            right: 20px;
            top: 45%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #555;
            font-size: 20px;
        }

        .toggle-password:hover {
            color: #000;
        }

        .btn-register {

            width: 100%;
            height: 65px;

            border: none;

            border-radius: 50px;

            background: #fff;

            color: #000;

            font-size: 26px;

            font-weight: 600;

            margin-top: 20px;

            transition: .3s;

        }

        .btn-register:hover {

            background: #ddd;

        }

        .small-text {

            margin-top: 25px;

            text-align: center;

        }

        .small-text a {

            color: #fff;

            text-decoration: none;

        }
    </style>

</head>

<body>

    <section class="register-section">

        <div class="container-fluid">

            <div class="row">

                <!-- LEFT IMAGE -->

                <div class="col-lg-7 left-side">

                    <img src="loginpic.jpg" alt="">

                    <!-- Replace with your own image -->

                </div>

                <!-- RIGHT FORM -->

                <div class="col-lg-5 right-side">

                    <div class="form-box">

                        <div class="logo">

                            PEAKFORM

                        </div>

                        <?php
                        if (isset($message) && !empty($message)) {
                            echo "<div class='alert alert-danger'>$message</div>";
                        }
                        ?>

                        <form method="POST">

                            <label>First Name*</label>

                            <input
                                type="text"
                                name="firstname"
                                class="form-control"
                                required>

                            <label>Last Name*</label>

                            <input
                                type="text"
                                name="lastname"
                                class="form-control"
                                required>

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

                                <span class="toggle-password" onclick="togglePassword('password','eye1')">

                                    <i class="fa-regular fa-eye" id="eye1"></i>

                                </span>

                            </div>

                            <label>Confirm Password*</label>

                            <div class="password-box">

                                <input
                                    type="password"
                                    name="confirm"
                                    id="confirm"
                                    class="form-control"
                                    required>

                                <span class="toggle-password" onclick="togglePassword('confirm','eye2')">

                                    <i class="fa-regular fa-eye" id="eye2"></i>

                                </span>

                            </div>

                            <button
                                type="submit"
                                name="register"
                                class="btn-register">

                                REGISTER

                            </button>

                            <p class="small-text">

                                Already have an account?

                                <a href="login.php">

                                    Login

                                </a>

                            </p>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </section>

    <script>
        function togglePassword(inputId, eyeId) {

            const input = document.getElementById(inputId);
            const eye = document.getElementById(eyeId);

            if (input.type === "password") {

                input.type = "text";

                eye.classList.remove("fa-eye");
                eye.classList.add("fa-eye-slash");

            } else {

                input.type = "password";

                eye.classList.remove("fa-eye-slash");
                eye.classList.add("fa-eye");

            }

        }
    </script>

</body>

</html>