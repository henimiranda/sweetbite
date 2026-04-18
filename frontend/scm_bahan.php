<?php
session_start();
include '../backend/koneksi.php';

if($_SESSION['role'] != 'admin'){
    header("Location: login.php");
}

// TAMBAH DATA
if(isset($_POST['tambah'])){
    $nama = $_POST['nama'];
    $stok = $_POST['stok'];

    mysqli_query($conn,"INSERT INTO bahan_baku (nama_bahan, stok) 
    VALUES ('$nama','$stok')");

    echo "<script>alert('Data berhasil ditambahkan');</script>";
}

// AMBIL DATA
$data = mysqli_query($conn,"SELECT * FROM bahan_baku ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>SCM</title>

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

/* ACTIVE MENU */
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
    <a href="scm_bahan.php" class="active">📦 bahan baku</a>
    <a href="manufacturing.php">🏭 Manufacturing</a>
    <a href="sales.php">💰 Sales</a>
    <a href="logout.php">🚪 Logout</a>
</div>

<!-- CONTENT -->
<div class="content">

    <h2>📦 Manajemen Bahan Baku (SCM)</h2>

    <!-- FORM -->
    <div class="card p-4 mt-3 mb-4">
        <h5>Tambah Bahan</h5>

        <form method="POST">
            <input type="text" name="nama" class="form-control mb-2" placeholder="Nama Bahan" required>
            <input type="number" name="stok" class="form-control mb-2" placeholder="Stok" required>

            <button name="tambah" class="btn btn-success w-100">Tambah</button>
        </form>
    </div>

    <!-- TABEL -->
    <div class="card p-4">
        <h5>Data Bahan Baku</h5>

        <table class="table table-bordered mt-3">

            <tr class="table-success">
                <th>No</th>
                <th>Nama Bahan</th>
                <th>Stok</th>
            </tr>

            <?php $no=1; while($d=mysqli_fetch_array($data)){ ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $d['nama_bahan'] ?></td>
                <td><?= $d['stok'] ?></td>
            </tr>
            <?php } ?>

        </table>
    </div>

</div>

</body>
</html>
```
