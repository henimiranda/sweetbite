<?php
session_start();
include '../backend/koneksi.php';

$user = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT * FROM users WHERE username='{$_SESSION['user']}'
"));
$id_user = $user['id'];

/* HAPUS ITEM */
if(isset($_GET['hapus'])){
    $id = $_GET['hapus'];
    mysqli_query($conn,"DELETE FROM keranjang WHERE id='$id'");
}

/* CHECKOUT */
if(isset($_POST['checkout'])){

    $cart = mysqli_query($conn,"
        SELECT k.*, p.nama_produk, p.harga 
        FROM keranjang k
        JOIN produk p ON k.id_produk = p.id
        WHERE k.id_user='$id_user'
    ");

    while($c = mysqli_fetch_array($cart)){
        $nama_produk = $c['nama_produk'];
        $jumlah = $c['jumlah'];
        $total = $c['harga'] * $jumlah;

        mysqli_query($conn,"INSERT INTO penjualan 
        (nama_produk, nama_pelanggan, total, id_produk, id_pelanggan)
        VALUES 
        ('$nama_produk','{$_SESSION['user']}','$total','$c[id_produk]','$id_user')");
    }

    // kosongkan keranjang
    mysqli_query($conn,"DELETE FROM keranjang WHERE id_user='$id_user'");

    echo "<script>alert('Checkout berhasil!');window.location='riwayat.php';</script>";
}

/* AMBIL DATA KERANJANG */
$data = mysqli_query($conn,"
SELECT k.*, p.nama_produk, p.harga, p.foto
FROM keranjang k
JOIN produk p ON k.id_produk = p.id
WHERE k.id_user='$id_user'
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Keranjang</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    margin:0;
    font-family:Arial;
    background:#f4f6f9;
}
.sidebar{
    position:fixed;
    width:220px;
    height:100%;
    background:#343a40;
    padding-top:20px;
}
.sidebar a{
    display:block;
    color:white;
    padding:15px;
    text-decoration:none;
}
.content{
    margin-left:220px;
    padding:20px;
}
.card{
    border-radius:15px;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
}
img{
    width:60px;
    border-radius:10px;
}
</style>
</head>

<body>

<div class="sidebar">
    <h4 class="text-white text-center">🛍️ SweetBite</h4>
    <a href="customer.php">🏠 Produk</a>
    <a href="cart.php" class="active">🛒 Keranjang</a>
    <a href="riwayat.php">🧾 Riwayat</a>
    <a href="profil.php">👤 Profil</a>
</div>

<div class="content">

<h2>🛒 Keranjang Saya</h2>

<div class="card p-3 mt-3">

<table class="table table-bordered">

<tr class="table-success">
    <th>Produk</th>
    <th>Harga</th>
    <th>Jumlah</th>
    <th>Subtotal</th>
    <th>Aksi</th>
</tr>

<?php 
$total_semua = 0;

while($d=mysqli_fetch_array($data)){

$subtotal = $d['harga'] * $d['jumlah'];
$total_semua += $subtotal;
?>

<tr>
    <td><?= $d['nama_produk'] ?></td>
    <td>Rp <?= number_format($d['harga']) ?></td>
    <td><?= $d['jumlah'] ?></td>
    <td><b>Rp <?= number_format($subtotal) ?></b></td>
    <td>
        <a href="?hapus=<?= $d['id'] ?>" class="btn btn-danger btn-sm">Hapus</a>
    </td>
</tr>

<?php } ?>

<tr>
    <td colspan="3"><b>Total</b></td>
    <td colspan="2"><b>Rp <?= number_format($total_semua) ?></b></td>
</tr>

</table>

<form method="POST">
    <button name="checkout" class="btn btn-success w-100">
        💳 Checkout Sekarang
    </button>
</form>

</div>

</div>

</body>
</html>