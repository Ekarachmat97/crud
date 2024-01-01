<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../../dbconn.php';

// Check for database connection
if (!$conn) {
    die('Database connection error: ' . mysqli_connect_error());
}

if (isset($_POST['tambahproduk'])) {
    // Sanitize and validate inputs
    $namaproduk = mysqli_real_escape_string($conn, $_POST['namaproduk']);
    $desc = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $harga = mysqli_real_escape_string($conn, $_POST['harga']);
    $stock = mysqli_real_escape_string($conn, $_POST['stock']);

    // File upload handling
    $target_dir = "../../uploads";  // Create a folder named "uploads" in the same directory as your PHP file
    $target_file = $target_dir . basename($_FILES["gambar"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if the image file is a actual image or fake image
    if (isset($_POST["tambahproduk"])) {
        $check = getimagesize($_FILES["gambar"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["gambar"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        // If everything is ok, try to upload file
        if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
            // File uploaded successfully, proceed with database insertion

            // Prepare and execute the SQL statement using prepared statements
            $insertquery = "INSERT INTO produk (namaproduk, deskripsi, harga, stock, gambar) VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $insertquery);

            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "ssiss", $namaproduk, $desc, $harga, $stock, $target_file);

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
            echo "Sorry, there was an error uploading your file.";
        }
    }
} else {
    // Handle case where form is not submitted
    echo 'Form not submitted';
}
?>
