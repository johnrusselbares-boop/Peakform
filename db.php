<?php
$host = "localhost:3307";   // or "localhost" if you're using the default port
$user = "root";
$password = "";
$database = "peakform";

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Database Connection Failed: " . mysqli_connect_error());
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
