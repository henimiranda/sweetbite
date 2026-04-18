<?php
session_start();
include '../backend/koneksi.php';

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'customer'){
    header("Location: login.php");
    exit;
}

/* USER */
$user = mysqli_fetch_assoc(mysqli_query($conn,"
    SELECT * FROM users WHERE username='{$_SESSION['user']}'
"));
$id_user = $user['id'];

/* KERANJANG */
if(isset($_POST['cart'])){
    $id_produk = $_POST['id_produk'];
    $jumlah = $_POST['jumlah'];

    mysqli_query($conn,"
        INSERT INTO keranjang (id_user, id_produk, jumlah)
        VALUES ('$id_user','$id_produk','$jumlah')
    ");

    echo "<script>alert('Masuk keranjang!');window.location='customer.php';</script>";
}

/* PRODUK */
$produk = mysqli_query($conn,"SELECT * FROM produk");
?>

<!DOCTYPE html>
<html>
<head>
<title>Customer Shop</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    margin:0;
    font-family:Arial;
    background:#f4f6f9;
}

/* SIDEBAR (TETAP ASLI) */
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

.sidebar a:hover{
    background:#495057;
}

.active{
    background:#28a745;
}

/* CONTENT (TIDAK DIUBAH STRUKTUR) */
.content{
    margin-left:220px;
    padding:20px;
}

.content h2{
    font-weight:bold;
    margin-bottom:15px;
}

/* CARD (DIPERHALUS SAJA, TIDAK DIROMBAK) */
.product-card{
    border:none;
    border-radius:14px;
    box-shadow:0 4px 12px rgba(0,0,0,0.08);
    transition:0.2s;
    background:white;
}

.product-card:hover{
    transform:translateY(-4px);
    box-shadow:0 8px 18px rgba(0,0,0,0.12);
}

/* IMAGE (lebih smooth tapi tetap sama layout) */
.product-img{
    width:100%;
    height:160px;
    object-fit:cover;
    border-radius:10px;
}

/* PRICE */
.price{
    color:#28a745;
    font-weight:bold;
}

/* BUTTON (lebih halus saja) */
.btn-cart{
    background:#ffc107;
    border:none;
    border-radius:8px;
    font-weight:600;
}

.btn-cart:hover{
    background:#e0a800;
}
</style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h4 class="text-white text-center">🛍️ SweetBite</h4>
    <a href="customer.php" class="active">🏠 Produk</a>
    <a href="cart.php">🛒 Keranjang</a>
    <a href="riwayat.php">🧾 Riwayat</a>
    <a href="profil.php">👤 Profil</a>
    <a href="logout.php">🚪 Logout</a>
</div>

<!-- CONTENT -->
<div class="content">

<h2>🛍️ Produk Kami</h2>

<div class="row mt-3">

<?php while($p = mysqli_fetch_array($produk)){ ?>

<div class="col-md-3 mb-4">

    <div class="card product-card p-3 text-center">

        <?php
        $fotoPath = "../uploads/" . $p['foto'];

        if (!empty($p['foto']) && file_exists($fotoPath)) {
            $foto = $fotoPath;
        } else {
            $foto = "https://via.placeholder.com/300x200?text=No+Image";
        }
        ?>

        <img src="<?= $foto ?>" class="product-img mb-2"
             onerror="this.src='https://via.placeholder.com/300x200?text=No+Image'">

        <h5><?= $p['nama_produk'] ?></h5>

        <p class="price">Rp <?= number_format($p['harga']) ?></p>

        <form method="POST">
            <input type="hidden" name="id_produk" value="<?= $p['id'] ?>">

            <input type="number" name="jumlah"
                   class="form-control mb-2"
                   min="1" value="1" required>

            <button type="submit" name="cart" class="btn btn-cart w-100">
                🛒 Masukkan Keranjang
            </button>
        </form>

    </div>

</div>

<?php } ?>

</div>

</div>

</body>
</html>