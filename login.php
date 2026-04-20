<?php
ob_start();
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'backend/koneksi.php';

// CEK KONEKSI
if(!$conn){
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// LOGIN
if(isset($_POST['login'])){
    $u = $_POST['username'];
    $p = $_POST['password'];

    $cek = mysqli_query($conn,"SELECT * FROM users WHERE username='$u' AND password='$p'");

    if(!$cek){
        die("Query error: " . mysqli_error($conn));
    }

    $data = mysqli_fetch_assoc($cek);

    if(mysqli_num_rows($cek)>0){
        $_SESSION['user']=$data['username'];
        $_SESSION['role']=$data['role'];

        if($data['role']=='admin'){
            header("Location: frontend/dashboard.php");
            exit;
        }else{
            header("Location: frontend/customer.php");
            exit;
        }
    }else{
        echo "<script>alert('Login gagal');</script>";
    }
}

// REGISTER
if(isset($_POST['register'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $nama     = $_POST['nama'];
    $email    = $_POST['email'];
    $no_hp    = $_POST['no_hp'];
    $alamat   = $_POST['alamat'];

    $insert = mysqli_query($conn,"INSERT INTO users 
    (username,password,role,nama_lengkap,email,no_hp,alamat) 
    VALUES 
    ('$username','$password','customer','$nama','$email','$no_hp','$alamat')");

    if(!$insert){
        die("Register error: " . mysqli_error($conn));
    }

    echo "<script>alert('Registrasi berhasil! Silakan login');</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Login SweetBite</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    margin:0;
    height:100vh;
    overflow:hidden;
    font-family:Arial;
}

/* BACKGROUND IMAGE (SUDAH DIPERBAIKI) */
.bg {
    position: fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background: url('uploads/bg.jpg') no-repeat center center;
    background-size: cover;
    z-index: -2;
}

/* OVERLAY */
.overlay {
    position: fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background: rgba(0,0,0,0.55);
    z-index: -1;
}

/* LOGIN BOX */
.box {
    position:absolute;
    top:50%;
    left:50%;
    transform:translate(-50%,-50%);
    width:380px;
    padding:30px;
    border-radius:18px;
    background: rgba(255,255,255,0.15);
    backdrop-filter: blur(12px);
    color:white;
    box-shadow:0 8px 25px rgba(0,0,0,0.3);
}

/* TITLE */
.box h3 {
    text-align:center;
    font-weight:bold;
    margin-bottom:15px;
}

/* INPUT */
.form-control {
    background: rgba(255,255,255,0.9);
    border:none;
}

/* BUTTON */
.btn-primary {
    background:#00b894;
    border:none;
}

.btn-primary:hover {
    background:#00a383;
}

.btn-success {
    background:#f1c40f;
    border:none;
    color:black;
}

.btn-success:hover {
    background:#d4ac0d;
}

/* TAB */
.nav-tabs .nav-link {
    color:white;
}

.nav-tabs .nav-link.active {
    background:#00b894;
    border:none;
    color:white;
}
</style>
</head>

<body>

<div class="bg"></div>
<div class="overlay"></div>

<div class="box">

    <h3>🍰 SweetBite</h3>

    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" href="#login">Login</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#register">Daftar</a>
        </li>
    </ul>

    <div class="tab-content mt-3">

        <div class="tab-pane fade show active" id="login">
            <form method="POST">
                <input type="text" name="username" class="form-control mb-2" placeholder="Username" required>
                <input type="password" name="password" class="form-control mb-2" placeholder="Password" required>

                <button name="login" class="btn btn-primary w-100">Login</button>
            </form>
        </div>

        <div class="tab-pane fade" id="register">
            <form method="POST">
                <input type="text" name="nama" class="form-control mb-2" placeholder="Nama Lengkap" required>
                <input type="text" name="username" class="form-control mb-2" placeholder="Username" required>
                <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>
                <input type="text" name="no_hp" class="form-control mb-2" placeholder="No HP" required>
                <textarea name="alamat" class="form-control mb-2" placeholder="Alamat" required></textarea>
                <input type="password" name="password" class="form-control mb-2" placeholder="Password" required>

                <button name="register" class="btn btn-success w-100">Daftar</button>
            </form>
        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>