<?php
require_once __DIR__ . '/../../app.php';

$id     = $_POST['id'];
$status = $_POST['status'];

$p = mysqli_fetch_assoc(
    mysqli_query($koneksi, "SELECT * FROM peminjaman WHERE id_peminjaman=$id")
);

if ($status == 'dikembalikan' && $p['status'] == 'dipinjam') {
    mysqli_query($koneksi, "
        UPDATE barang 
        SET jumlah = jumlah + {$p['jumlah']}
        WHERE id_barang={$p['id_barang']}
    ");
}

mysqli_query($koneksi, "
    UPDATE peminjaman SET status='$status' WHERE id_peminjaman=$id
");

header("Location: index.php");
