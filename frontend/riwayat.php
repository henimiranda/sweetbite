<?php
session_start();
include '../backend/koneksi.php';

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit;
}

$user = $_SESSION['user'];

$data = mysqli_query($conn,"
SELECT * FROM penjualan 
WHERE nama_pelanggan='$user'
ORDER BY id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Riwayat Pembelian</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    margin:0;
    font-family:'Segoe UI', sans-serif;
    background:linear-gradient(135deg,#f5f6fa,#dfe6e9);
}

/* SIDEBAR PREMIUM */
.sidebar{
    position:fixed;
    width:240px;
    height:100%;
    background:linear-gradient(180deg,#2f3640,#1e272e);
    padding-top:30px;
    box-shadow:4px 0 12px rgba(0,0,0,0.15);
}

.sidebar h4{
    color:white;
    text-align:center;
    font-weight:700;
    margin-bottom:25px;
    letter-spacing:1px;
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
    padding:30px;
}

.title{
    font-size:26px;
    font-weight:800;
    color:#2d3436;
    margin-bottom:25px;
}

/* CARD HISTORY PREMIUM */
.history-card{
    background:white;
    border-radius:18px;
    padding:18px 20px;
    margin-bottom:18px;
    box-shadow:0 8px 25px rgba(0,0,0,0.08);
    transition:0.3s;
    position:relative;
    overflow:hidden;
}

.history-card:hover{
    transform:translateY(-5px);
    box-shadow:0 12px 30px rgba(0,0,0,0.12);
}

/* ACCENT LINE */
.history-card::before{
    content:'';
    position:absolute;
    left:0;
    top:0;
    width:6px;
    height:100%;
    background:linear-gradient(180deg,#00b894,#55efc4);
}

/* TEXT */
.product-name{
    font-size:17px;
    font-weight:700;
    color:#2d3436;
}

.meta{
    font-size:13px;
    color:#636e72;
    margin-top:3px;
}

/* TOTAL */
.total{
    font-size:18px;
    font-weight:800;
    color:#00b894;
}

/* BADGE */
.badge-soft{
    background:#d1f2eb;
    color:#00b894;
    font-size:12px;
    padding:5px 10px;
    border-radius:20px;
    font-weight:600;
}

/* EMPTY */
.empty{
    background:white;
    padding:40px;
    border-radius:18px;
    text-align:center;
    color:#636e72;
    box-shadow:0 8px 25px rgba(0,0,0,0.06);
}
</style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h4>🛍️ SweetBite</h4>
    <a href="customer.php">🏠 Produk</a>
    <a href="riwayat.php" class="active">🧾 Riwayat</a>
    <a href="profil.php">👤 Profil</a>
    <a href="logout.php">🚪 Logout</a>
</div>

<!-- CONTENT -->
<div class="content">

<div class="title">🧾 Riwayat Pembelian</div>

<?php if(mysqli_num_rows($data) == 0){ ?>
    <div class="empty">
        😢 Belum ada transaksi<br>
        <small>Yuk belanja dulu di SweetBite 🛍️</small>
    </div>
<?php } ?>

<?php while($d = mysqli_fetch_array($data)){ ?>

<div class="history-card">

    <div class="d-flex justify-content-between align-items-center">

        <div>
            <div class="product-name"><?= $d['nama_produk'] ?></div>
            <div class="meta">🛒 Transaksi ID: #<?= $d['id'] ?></div>
        </div>

        <div class="text-end">
            <div class="badge-soft mb-1">Selesai</div>
            <div class="total">Rp <?= number_format($d['total']) ?></div>
        </div>

    </div>

</div>

<?php } ?>

</div>

</body>
</html>