<?php
session_start();
include '../backend/koneksi.php';

if($_SESSION['role'] != 'admin'){
    header("Location: login.php");
}

// STATISTIK
$produk = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) as total FROM produk"))['total'];
$customer = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) as total FROM users WHERE role='customer'"))['total'];
$transaksi = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) as total FROM penjualan"))['total'];
$omzet = mysqli_fetch_assoc(mysqli_query($conn,"SELECT SUM(total) as total FROM penjualan"))['total'];

// GRAFIK PRODUK
$q1 = mysqli_query($conn,"SELECT nama_produk, SUM(total) as total FROM penjualan GROUP BY nama_produk");
$produk_label=[]; $produk_total=[];
while($r=mysqli_fetch_assoc($q1)){
    $produk_label[]=$r['nama_produk'];
    $produk_total[]=$r['total'];
}

// GRAFIK HARIAN
$q2 = mysqli_query($conn,"SELECT DATE(created_at) as tanggal, SUM(total) as total FROM penjualan GROUP BY DATE(created_at)");
$tanggal=[]; $total_harian=[];
while($r=mysqli_fetch_assoc($q2)){
    $tanggal[]=$r['tanggal'];
    $total_harian[]=$r['total'];
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
    transform: scale(1.03);
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
    <a href="sales.php">💰 Sales</a>
    <a href="logout.php">🚪 Logout</a>
</div>

<!-- CONTENT -->
<div class="content">

    <h2>👋 Dashboard Admin - <?= $_SESSION['user'] ?></h2>

    <!-- STATISTIK -->
    <div class="row text-white mt-4">

        <div class="col-md-3 mb-3">
            <div class="card p-3 bg-primary">
                <h5>📦 Produk</h5>
                <h3><?= $produk ?></h3>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card p-3 bg-success">
                <h5>👥 Customer</h5>
                <h3><?= $customer ?></h3>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card p-3 bg-warning">
                <h5>🧾 Transaksi</h5>
                <h3><?= $transaksi ?></h3>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card p-3 bg-danger">
                <h5>💰 Omzet</h5>
                <h3>Rp <?= number_format($omzet) ?></h3>
            </div>
        </div>

    </div>

    <!-- GRAFIK -->
    <div class="row mt-4">

        <div class="col-md-6 mb-4">
            <div class="card p-4">
                <h5>📊 Penjualan per Produk</h5>
                <canvas id="chartProduk"></canvas>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card p-4">
                <h5>📈 Penjualan Harian</h5>
                <canvas id="chartHarian"></canvas>
            </div>
        </div>

    </div>

</div>

<script>
new Chart(document.getElementById('chartProduk'), {
    type: 'bar',
    data: {
        labels: <?= json_encode($produk_label) ?>,
        datasets: [{
            label: 'Penjualan',
            data: <?= json_encode($produk_total) ?>
        }]
    }
});

new Chart(document.getElementById('chartHarian'), {
    type: 'line',
    data: {
        labels: <?= json_encode($tanggal) ?>,
        datasets: [{
            label: 'Harian',
            data: <?= json_encode($total_harian) ?>
        }]
    }
});
</script>

</body>
</html>
```
