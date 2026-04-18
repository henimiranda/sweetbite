<?php
session_start();
include '../backend/koneksi.php';

if($_SESSION['role'] != 'admin'){
    header("Location: login.php");
}

// TOTAL OMZET
$total_query = mysqli_query($conn,"SELECT SUM(total) as omzet FROM penjualan");
$total_data = mysqli_fetch_assoc($total_query);
$omzet = $total_data['omzet'];

// DATA PENJUALAN (JOIN)
$data = mysqli_query($conn,"
    SELECT penjualan.*, produk.nama_produk, users.nama_lengkap 
    FROM penjualan
    JOIN produk ON penjualan.id_produk = produk.id
    JOIN users ON penjualan.id_pelanggan = users.id
    ORDER BY penjualan.id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Sales</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    margin:0;
    font-family: Arial;
}

/* SIDEBAR */
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

/* CONTENT */
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
    <a href="scm_bahan.php">📦 bahan baku</a>
    <a href="manufacturing.php">🏭 Manufacturing</a>
    <a href="sales.php" class="active">💰 Sales</a>
    <a href="logout.php">🚪 Logout</a>
</div>

<!-- CONTENT -->
<div class="content">

    <h2>💰 Laporan Penjualan</h2>

    <!-- OMZET -->
    <div class="card p-3 mt-3 mb-4 bg-success text-white">
        <h4>Total Omzet: Rp <?= number_format($omzet) ?></h4>
    </div>

    <!-- TABEL -->
    <div class="card p-4">
        <h5>📊 Data Penjualan</h5>

        <table class="table table-bordered table-hover mt-3">

            <tr class="table-success">
                <th>No</th>
                <th>Produk</th>
                <th>Pelanggan</th>
                <th>Jumlah</th>
                <th>Total</th>
            </tr>

            <?php 
            $no=1;
            while($d=mysqli_fetch_array($data)){
            ?>

            <tr>
                <td><?= $no++ ?></td>
                <td><?= $d['nama_produk'] ?></td>
                <td><?= $d['nama_lengkap'] ?></td>
                <td><?= $d['jumlah'] ?? '-' ?></td>
                <td><b>Rp <?= number_format($d['total']) ?></b></td>
            </tr>

            <?php } ?>

        </table>
    </div>

</div>

</body>
</html>
```
