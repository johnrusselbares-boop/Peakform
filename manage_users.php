<?php
session_start();
include "db.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location:admin_login.php");
    exit();
}

if (isset($_GET['delete'])) {

    $id = $_GET['delete'];

    mysqli_query($conn, "
    DELETE FROM users
    WHERE id='$id'
    ");

    header("Location:manage_users.php");
    exit();
}

$query = mysqli_query($conn, "
SELECT
users.*,
COUNT(orders.id) AS total_orders

FROM users

LEFT JOIN orders
ON users.id=orders.user_id

GROUP BY users.id

ORDER BY users.id DESC
");
?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">

    <title>Manage Users</title>

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

        table {
            background: white;
        }
    </style>

</head>

<body>

    <div class="container py-5">

        <div class="card shadow">

            <div class="card-body">

                <h2 class="mb-4">

                    <i class="fa-solid fa-users"></i>

                    Manage Users

                </h2>

                <table class="table table-hover align-middle">

                    <thead class="table-dark">

                        <tr>

                            <th>ID</th>

                            <th>Name</th>

                            <th>Email</th>

                            <th>Orders</th>

                            <th>Action</th>

                        </tr>

                    </thead>

                    <tbody>

                        <?php while ($row = mysqli_fetch_assoc($query)) { ?>

                            <tr>

                                <td><?= $row['id']; ?></td>

                                <td><?= $row['firstname'] . " " . $row['lastname']; ?></td>

                                <td><?= $row['email']; ?></td>

                                <td>

                                    <span class="badge bg-primary">

                                        <?= $row['total_orders']; ?>

                                    </span>

                                </td>

                                <td>

                                    <a
                                        href="manage_users.php?delete=<?= $row['id']; ?>"
                                        onclick="return confirm('Delete this user?')"
                                        class="btn btn-danger btn-sm">

                                        <i class="fa-solid fa-trash"></i>

                                        Delete

                                    </a>

                                </td>

                            </tr>

                        <?php } ?>

                    </tbody>

                </table>

                <a
                    href="admin_dashboard.php"
                    class="btn btn-dark">

                    Back Dashboard

                </a>

            </div>

        </div>

    </div>

</body>

</html>