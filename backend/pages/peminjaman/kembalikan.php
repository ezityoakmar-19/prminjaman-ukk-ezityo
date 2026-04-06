<?php
require_once __DIR__ . '/../../app.php';

$id = $_GET['id'];

/* Ambil data peminjaman */
$data = mysqli_fetch_assoc(
    mysqli_query($koneksi,"
        SELECT id_barang, jumlah 
        FROM peminjaman 
        WHERE id_peminjaman = $id
    ")
);

$id_barang = $data['id_barang'];
$jumlah = $data['jumlah'];

/* Update status peminjaman */
mysqli_query($koneksi,"
    UPDATE peminjaman 
    SET status = 'dikembalikan',
        tanggal_kembali = NOW()
    WHERE id_peminjaman = $id
");

/* Kembalikan stok barang */
mysqli_query($koneksi,"
    UPDATE barang 
    SET jumlah = jumlah + $jumlah
    WHERE id_barang = $id_barang
");

header("Location: index.php");
