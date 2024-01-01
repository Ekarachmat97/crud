<?php
$server = "localhost";
$user = "root";
$password = "";
$db = "gocai_db";
$conn = mysqli_connect($server, $user, $password, $db);

if (!$conn) {
    die('Database connection error: ' . mysqli_connect_error());
}
?>