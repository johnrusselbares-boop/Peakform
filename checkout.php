<?php

include 'db.php';

if (!isset($_SESSION['user_id'])) {

    header("Location: login.php");

    exit();
}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Checkout</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-dark text-white">

    <div class="container py-5">

        <h2 class="text-center mb-4">

            Checkout

        </h2>

        <form action="process_order.php" method="POST">

            <div class="mb-3">

                <label>Full Name</label>

                <input
                    type="text"
                    name="fullname"
                    class="form-control"
                    required>

            </div>

            <div class="mb-3">

                <label>Address</label>

                <textarea
                    name="address"
                    class="form-control"
                    required></textarea>

            </div>

            <div class="mb-3">

                <label>Contact Number</label>

                <input
                    type="text"
                    name="contact"
                    class="form-control"
                    required>

            </div>

            <div class="mb-4">

                <label>Mode of Payment</label>

                <select
                    name="payment"
                    class="form-select"
                    required>

                    <option value="">Select Payment</option>

                    <option>Cash on Delivery</option>

                    <option>GCash</option>

                    <option>Maya</option>

                    <option>Credit Card</option>

                    <option>Debit Card</option>

                </select>

            </div>

            <button
                type="submit"
                class="btn btn-light w-100 mb-3">

                Place Order

            </button>

            <a
                href="peakform.php"
                class="btn btn-outline-light w-100">

                <i class="fa-solid fa-house"></i>

                Back to Home

            </a>

        </form>

    </div>

</body>

</html>