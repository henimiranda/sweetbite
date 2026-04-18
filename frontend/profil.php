<?php
session_start();
include '../backend/koneksi.php';

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit;
}

$user = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT * FROM users WHERE username='{$_SESSION['user']}'
"));
?>

<!DOCTYPE html>
<html>
<head>
<title>Profil Saya</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    margin:0;
    font-family:'Segoe UI', sans-serif;
    background:linear-gradient(135deg,#f5f6fa,#dfe6e9);
}

/* SIDEBAR */
.sidebar{
    position:fixed;
    width:240px;
    height:100%;
    background:linear-gradient(180deg,#2f3640,#1e272e);
    padding-top:30px;
}

.sidebar h4{
    color:white;
    text-align:center;
    margin-bottom:25px;
    font-weight:bold;
}

.sidebar a{
    display:block;
    color:#dfe6e9;
    padding:14px 20px;
    text-decoration:none;
    transition:0.25s;
    border-left:3px solid transparent;
}

.sidebar a:hover{
    background:#353b48;
    border-left:3px solid #00b894;
    padding-left:28px;
}

.active{
    background:#00b894 !important;
    color:white !important;
    font-weight:bold;
}

/* CONTENT */
.content{
    margin-left:240px;
    padding:40px;
}

/* TITLE */
.title{
    font-size:26px;
    font-weight:800;
    color:#2d3436;
    margin-bottom:25px;
}

/* PROFILE CARD */
.profile-card{
    background:white;
    border-radius:20px;
    box-shadow:0 10px 30px rgba(0,0,0,0.08);
    padding:30px;
    max-width:600px;
    position:relative;
    overflow:hidden;
}

/* HEADER ACCENT */
.profile-card::before{
    content:'';
    position:absolute;
    top:0;
    left:0;
    width:100%;
    height:6px;
    background:linear-gradient(90deg,#00b894,#55efc4);
}

/* AVATAR */
.avatar{
    width:90px;
    height:90px;
    border-radius:50%;
    background:linear-gradient(135deg,#00b894,#55efc4);
    display:flex;
    align-items:center;
    justify-content:center;
    color:white;
    font-size:32px;
    font-weight:bold;
    margin-bottom:20px;
}

/* INFO */
.label{
    font-size:13px;
    color:#636e72;
    margin-bottom:3px;
}

.value{
    font-size:16px;
    font-weight:600;
    color:#2d3436;
    margin-bottom:15px;
}

/* BADGE */
.badge-role{
    display:inline-block;
    background:#d1f2eb;
    color:#00b894;
    padding:5px 12px;
    border-radius:20px;
    font-size:13px;
    font-weight:600;
}
</style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h4>🛍️ SweetBite</h4>
    <a href="customer.php">🏠 Produk</a>
    <a href="riwayat.php">🧾 Riwayat</a>
    <a href="profil.php" class="active">👤 Profil</a>
    <a href="logout.php">🚪 Logout</a>
</div>

<!-- CONTENT -->
<div class="content">

<div class="title">👤 Profil Saya</div>

<div class="profile-card">

    <!-- AVATAR -->
    <div class="avatar">
        <?= strtoupper(substr($user['username'],0,1)) ?>
    </div>

    <!-- INFO -->
    <div class="label">Username</div>
    <div class="value"><?= $user['username'] ?></div>

    <div class="label">Nama Lengkap</div>
    <div class="value"><?= $user['nama_lengkap'] ?? '-' ?></div>

    <div class="label">Role</div>
    <div class="badge-role"><?= $user['role'] ?></div>

</div>

</div>

</body>
</html>