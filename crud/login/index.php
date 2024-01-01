<?php
include("../dbconn.php");


session_start();
// Fungsi Login
if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['uname']);
    $password = mysqli_real_escape_string($conn, $_POST['psw']);

    // Gunakan prepared statements untuk mencegah SQL injection
    $query = "SELECT * FROM user WHERE username=?";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $user_data = mysqli_fetch_assoc($result);

        if ($user_data && $password === $user_data['password']) {
            // Data ditemukan
            $role = $user_data['role'];

            // Set sesi
            $_SESSION['log'] = 'Logged';
            $_SESSION['role'] = $role;
            $_SESSION['username'] = $username;

            // Redirect berdasarkan peran
            if ($role == 'admin') {
                header('location:../admin/user/');
            } else {
                header('location:../beranda/');
            }
        } else {
            // Data tidak ditemukan
            echo "<script> alert('Username atau password salah.');</script>";
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
    <title>Login</title>
  </head>
  <body>
<div class="form-container"> 
<div class="banner">LOGIN</div>

<form method="post"> 
<div class="form-group"> 
<label for="uname">Username</label> 
<input type="text" id="username" name="uname"  placeholder="username" required> 
</div> 
<div class="form-group"> 
<label for="psw">Password</label> 
<input type="password" id="password" name="psw" placeholder="password" required> </div> 

<div class="form-group"> 
  <button type="submit" name="login">Masuk</button> 
</div> 
</form>
<br>
<p>belum punya akun?<a href="../registrasi/" style="text-decoration: none; padding: 0 10px;">Daftar</a></p>
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
  background-color: #000;
}

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
  border-radius: 15px;
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
  font-size: 16px;
}
.form-group input:hover {
  border: 4px solid #00adb5;
}

.form-group button {
  padding: 10px 20px;
  font-size: 16px;
  cursor: pointer;
  background-color: #00adb5;
  color: white;
  border: none;
  border-radius: 4px;
}

.form-group button:hover {
  background-color: #393e46;
}
@media screen and (max-width: 500px) {
  .form-container {
    margin: 10px;
  }
}

</style>
  </body>
</html>
