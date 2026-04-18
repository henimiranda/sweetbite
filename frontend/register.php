<?php
include '../backend/koneksi.php';

if(isset($_POST['register'])){
    $user = $_POST['username'];
    $pass = $_POST['password'];

    mysqli_query($conn, "INSERT INTO users (username, password) VALUES ('$user','$pass')");
    echo "<script>alert('Registrasi berhasil'); window.location='login.php';</script>";
}
?>

<h2>Register</h2>
<form method="POST">
    Username: <input type="text" name="username"><br><br>
    Password: <input type="password" name="password"><br><br>
    <button name="register">Daftar</button>
</form>

<a href="login.php">Login disini</a>