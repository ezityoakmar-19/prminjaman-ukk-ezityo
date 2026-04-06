<?php
require_once __DIR__ . '/../../app.php';

$id_user  = $_POST['id_user'];
$id_barang = $_POST['id_barang'];
$jumlah   = $_POST['jumlah'];
$tgl      = $_POST['tanggal_pinjam'];
$ket      = $_POST['keterangan'];

$cek = mysqli_fetch_assoc(
    mysqli_query($koneksi, "SELECT jumlah FROM barang WHERE id_barang=$id_barang")
);

if ($jumlah > $cek['jumlah']) {
    die("Stok tidak cukup!");
}

mysqli_query($koneksi, "
    INSERT INTO peminjaman 
    (id_user,id_barang,tanggal_pinjam,jumlah,keterangan)
    VALUES ('$id_user','$id_barang','$tgl','$jumlah','$ket')
");

mysqli_query($koneksi, "
    UPDATE barang SET jumlah = jumlah - $jumlah WHERE id_barang=$id_barang
");

header("Location: index.php");
