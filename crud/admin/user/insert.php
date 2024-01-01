<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../../dbconn.php';

// Check for database connection
if (!$conn) {
    die('Database connection error: ' . mysqli_connect_error());
}

if (isset($_POST['adduser'])) {
    // Sanitize and validate inputs
    $username = mysqli_real_escape_string($conn, $_POST['uname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $password = mysqli_real_escape_string($conn, $_POST['psw']); // Store the password as plain text
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    // Prepare and execute the SQL statement using prepared statements
    $insertquery = "INSERT INTO user (username, email, alamat, password, role) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $insertquery);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssss", $username, $email, $alamat, $password, $role);

        if (mysqli_stmt_execute($stmt)) {
            // Successful insertion
            header("Location: index.php");
            exit();
        } else {
            // Failed insertion
            echo 'Error executing statement: ' . mysqli_stmt_error($stmt);
        }

        mysqli_stmt_close($stmt);
    } else {
        // Error in preparing the statement
        echo 'Statement preparation error: ' . mysqli_error($conn);
    }
} else {
    // Handle case where form is not submitted
    echo 'Form not submitted';
}
?>