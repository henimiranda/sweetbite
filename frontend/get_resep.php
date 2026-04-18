<?php
include '../backend/koneksi.php';

// cek jika tidak ada parameter
if(!isset($_GET['id_produk']) || $_GET['id_produk'] == ''){
    echo "<li class='list-group-item text-danger'>Pilih produk terlebih dahulu</li>";
    exit;
}

$id_produk = $_GET['id_produk'];

// ambil data resep + bahan
$data = mysqli_query($conn, "
    SELECT bahan_baku.nama_bahan, resep.jumlah
    FROM resep
    JOIN bahan_baku ON resep.id_bahan = bahan_baku.id
    WHERE resep.id_produk = '$id_produk'
");

// kalau tidak ada resep
if(mysqli_num_rows($data) == 0){
    echo "<li class='list-group-item text-warning'>Resep belum tersedia</li>";
} else {

    while($d = mysqli_fetch_array($data)){
        echo "
        <li class='list-group-item d-flex justify-content-between'>
            <span>".$d['nama_bahan']."</span>
            <span class='badge bg-primary'>".$d['jumlah']."</span>
        </li>";
    }

}
?>
```
