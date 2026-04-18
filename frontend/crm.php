<?php
session_start();
include '../backend/koneksi.php';

if($_SESSION['role'] != 'admin'){
    header("Location: login.php");
    exit;
}

// TAMBAH PELANGGAN
if(isset($_POST['tambah'])){
    $nama = $_POST['nama'];
    mysqli_query($conn, "INSERT INTO pelanggan (nama_pelanggan) VALUES ('$nama')");
}

// DATA PELANGGAN
$data = mysqli_query($conn,"SELECT * FROM pelanggan ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>CRM</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    margin:0;
    font-family: Arial;
}

/* SIDEBAR (SAMA PERSIS SALES) */
.sidebar {
    position: fixed;
    width: 220px;
    height: 100%;
    background: #343a40;
    padding-top:20px;
}

.sidebar a {
    display: block;
    color: white;
    padding: 15px;
    text-decoration: none;
}

.sidebar a:hover {
    background: #495057;
}

.active {
    background: #28a745 !important;
}

/* CONTENT (SAMA PERSIS SALES) */
.content {
    margin-left: 220px;
    padding: 20px;
    background: linear-gradient(to right, #d4fc79, #96e6a1);
    min-height:100vh;
}

/* CARD */
.card {
    border-radius:15px;
    box-shadow:0 5px 15px rgba(0,0,0,0.2);
    transition:0.3s;
}
.card:hover {
    transform: scale(1.02);
}
</style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h4 class="text-white text-center">🍰 SweetBite</h4>
    <a href="dashboard.php">📊 Dashboard</a>
    <a href="scm_bahan.php">📦 SCM</a>
    <a href="manufacturing.php">🏭 Manufacturing</a>
    <a href="sales.php">💰 Sales</a>
    <a href="crm.php" class="active">👥 CRM</a>
    <a href="logout.php">🚪 Logout</a>
</div>

<!-- CONTENT -->
<div class="content">

    <h2>👥 Customer Relationship Management</h2>

    <!-- FORM TAMBAH -->
    <div class="card p-3 mt-3 mb-4">
        <h5>➕ Tambah Pelanggan</h5>

        <form method="POST" class="mt-2">
            <input type="text" name="nama" class="form-control" placeholder="Nama pelanggan..." required>
            <br>
            <button class="btn btn-success" name="tambah">Simpan</button>
        </form>
    </div>

    <!-- TABLE -->
    <div class="card p-4">
        <h5>📋 Data Pelanggan</h5>

        <table class="table table-bordered table-hover mt-3">

            <tr class="table-success">
                <th>No</th>
                <th>Nama Pelanggan</th>
            </tr>

            <?php 
            $no=1;
            while($d=mysqli_fetch_array($data)){
            ?>

            <tr>
                <td><?= $no++ ?></td>
                <td><?= $d['nama_pelanggan'] ?></td>
            </tr>

            <?php } ?>

        </table>
    </div>

</div>

</body>
</html>