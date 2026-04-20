<?php
$conn = mysqli_connect(
    "sql105.infinityfree.com",
    "if0_41695965",
    "Boneka123456789",
    "if0_41695965_sweetbite"
);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>