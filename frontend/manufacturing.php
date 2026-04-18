<?php
session_start();
include '../backend/koneksi.php';

if($_SESSION['role'] != 'admin'){
    header("Location: login.php");
}

// Ambil produk
$produk = mysqli_query($conn, "SELECT * FROM produk");

// PROSES PRODUKSI
if(isset($_POST['tambah'])){
    $id_produk = $_POST['id_produk'];
    $jumlah_produksi = $_POST['jumlah'];

    if($jumlah_produksi <= 0){
        echo "<script>alert('Jumlah harus lebih dari 0!');</script>";
    } else {

        $resep = mysqli_query($conn, "SELECT * FROM resep WHERE id_produk='$id_produk'");
        $cukup = true;

        // CEK STOK
        while($r = mysqli_fetch_array($resep)){
            $bahan = mysqli_query($conn, "SELECT * FROM bahan_baku WHERE id='".$r['id_bahan']."'");
            $b = mysqli_fetch_array($bahan);

            $butuh = $r['jumlah'] * $jumlah_produksi;

            if($b['stok'] < $butuh){
                $cukup = false;
                echo "<script>alert('Stok ".$b['nama_bahan']." tidak cukup!');</script>";
                break;
            }
        }

        // JIKA CUKUP
        if($cukup){
            $resep2 = mysqli_query($conn, "SELECT * FROM resep WHERE id_produk='$id_produk'");

            while($r2 = mysqli_fetch_array($resep2)){
                $butuh = $r2['jumlah'] * $jumlah_produksi;

                mysqli_query($conn, "
                    UPDATE bahan_baku 
                    SET stok = stok - $butuh 
                    WHERE id='".$r2['id_bahan']."'
                ");
            }

            mysqli_query($conn, "
                INSERT INTO produksi (id_produk, jumlah, status)
                VALUES ('$id_produk','$jumlah_produksi','Selesai')
            ");

            echo "<script>alert('Produksi berhasil!'); window.location='manufacturing.php';</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Manufacturing</title>

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

.list-group-item {
    border-radius:10px;
    margin-bottom:5px;
}
</style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h4 class="text-white text-center">🍰 SweetBite</h4>
    <a href="dashboard.php">📊 Dashboard</a>
    <a href="scm_bahan.php">📦 bahan baku</a>
    <a href="manufacturing.php" class="active">🏭 Manufacturing</a>
    <a href="sales.php">💰 Sales</a>
    <a href="logout.php">🚪 Logout</a>
</div>

<!-- CONTENT -->
<div class="content">

    <h2>🏭 Manufacturing (Produksi)</h2>

    <!-- FORM -->
    <div class="card p-4 mt-3 mb-4">
        <form method="POST">

            <div class="mb-3">
                <label>Produk</label>
                <select name="id_produk" class="form-control" required>
                    <option value="">-- Pilih Produk --</option>
                    <?php while($p=mysqli_fetch_array($produk)){ ?>
                        <option value="<?= $p['id'] ?>">
                            <?= $p['nama_produk'] ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <!-- RESEP -->
            <div class="mb-3">
                <label>Bahan Dibutuhkan:</label>
                <ul id="resepList" class="list-group"></ul>
            </div>

            <div class="mb-3">
                <label>Jumlah Produksi</label>
                <input type="number" name="jumlah" min="1" class="form-control" required>
            </div>

            <button name="tambah" class="btn btn-success w-100">🚀 Mulai Produksi</button>

        </form>
    </div>

    <!-- HISTORY -->
    <div class="card p-4">
        <h5>📊 Riwayat Produksi</h5>

        <table class="table table-bordered mt-3">

            <tr class="table-success">
                <th>No</th>
                <th>Produk</th>
                <th>Jumlah</th>
                <th>Status</th>
            </tr>

            <?php
            $no = 1;
            $data = mysqli_query($conn, "
                SELECT produksi.*, produk.nama_produk
                FROM produksi
                JOIN produk ON produksi.id_produk = produk.id
                ORDER BY produksi.id DESC
            ");

            while($d = mysqli_fetch_array($data)){
            ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $d['nama_produk'] ?></td>
                <td><?= $d['jumlah'] ?></td>
                <td><span class="badge bg-success"><?= $d['status'] ?></span></td>
            </tr>
            <?php } ?>

        </table>
    </div>

</div>

<!-- AJAX RESEP -->
<script>
document.querySelector('[name="id_produk"]').addEventListener('change', function(){
    let id = this.value;

    fetch('get_resep.php?id_produk=' + id)
    .then(res => res.text())
    .then(data => {
        document.getElementById('resepList').innerHTML = data;
    });
});
</script>

</body>
</html>
```
