<?php
include("../dbconn.php");

// Fungsi registrasi signup
if (isset($_POST['register'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Tetapkan peran sebagai "user"
    $role = "user";

    // Gunakan prepared statement untuk mencegah SQL injection
    $stmt = mysqli_prepare($conn, "INSERT INTO user(username, email, password, role) VALUES (?, ?, ?, ?)");

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssss", $username, $email, $password, $role);
        $addnewuser = mysqli_stmt_execute($stmt);

        if ($addnewuser) {
            echo "<script> alert('Registrasi berhasil. Silakan login.'); window.location.href = '../login/';</script>";
        } else {
            echo "<script> alert('Gagal melakukan registrasi.');</script>";
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        // Kesalahan dalam persiapan statement
        echo 'Kesalahan dalam persiapan statement: ' . mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html>
  <head>
  <meta charset="UTF-8"> <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi</title>
  </head>
  <body>
<div class="form-container"> 
<div class="banner" style="width: 100px; ">DAFTAR</div>
<form method="post"> 
<div class="form-group"> <label for="uname">Username</label> <input type="text" id="username" name="username"  placeholder="username" required> 
</div>
<div class="form-group"> <label for="email">Email</label> <input type="email" id="email" name="email"  placeholder="email" required> 
</div>
<div class="form-group"> <label for="psw">Password</label> 
<input type="password" id="password" name="password" placeholder="password" required> </div> 

<div class="form-group"> 
<button type="submit" name="register">Daftar</button> </div> </form>
<br>
<p>sudah punya akun?<a href="../login/" style="text-decoration: none; padding: 0 10px;">login</a></p>
</div>



<style>
  body { 
  font-family: Arial, sans-serif; 
  margin: 0;
  padding: 0; 
  display: flex; 
  justify-content: center; 
  align-items: center; 
  height: 100vh; 
  background-color: #000; } 

.form-container { 
  display: flex; 
  flex-direction: column; 
  width: 100%; 
  max-width: 500px; 
  margin: 20px; 
  padding: 20px; 
  padding-top: 0px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); 
  background-color: #ffffff; 
  border-radius:15px;
} 

.banner {
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); 
  background-color: #00adb5; 
  width: 80px; 
  padding: 35px; 
  border-radius: 0 0 20px 20px; 
  font-size: 30px;
  font-weight: bold;
  display: flex;
  justify-content: center;
  align-items: center;
  margin-bottom: 50px;
}
  
 .form-group { 
   margin-bottom: 20px; 
 } 
   
 .form-group label { 
   display: block; 
   margin-bottom: 5px; 
 } 
   
 .form-group input { 
   width: 95%; 
   padding: 10px; 
   border-radius: 10px;
   font-size: 16px; } 
 .form-group input:hover{
   border: 4px solid #00adb5;
 }
   
   
 .form-group button { 
   padding: 10px 20px; 
   font-size: 16px; 
   cursor: pointer; 
   background-color: #00adb5; 
   color: white; 
   border: none; 
   border-radius: 4px; } 
   
 .form-group button:hover { 
   background-color: #393e46; } 
 @media screen and (max-width: 500px) 
 { 
   .form-container { margin: 10px; } 
   
 }
</style>
  </body>
</html>
