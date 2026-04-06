<?php
require_once __DIR__ . '/../../app.php';

$id_barang   = escapeString($koneksi, $_POST['id_barang']);
$nama_barang = escapeString($koneksi, $_POST['nama_barang']);
$jumlah      = escapeString($koneksi, $_POST['jumlah']);
$kondisi     = escapeString($koneksi, $_POST['kondisi']);
$keterangan  = escapeString($koneksi, $_POST['keterangan']);

// Ambil data lama
$data_lama = mysqli_query($koneksi, "SELECT foto FROM barang WHERE id_barang='$id_barang'");
$row_lama = mysqli_fetch_assoc($data_lama);

$folder = "../../../storage/barang/";
$foto_baru = $_FILES['foto']['name'];
$tmp       = $_FILES['foto']['tmp_name'];

if($foto_baru != ""){

    // Validasi tipe file
    $ext = strtolower(pathinfo($foto_baru, PATHINFO_EXTENSION));
    $allowed = ['jpg','jpeg','png'];

    if(!in_array($ext, $allowed)){
        echo "<script>alert('Format foto harus JPG/JPEG/PNG');window.history.back();</script>";
        exit;
    }

    // Hapus foto lama jika ada
    if($row_lama['foto'] && file_exists($folder.$row_lama['foto'])){
        unlink($folder.$row_lama['foto']);
    }

    // Rename file agar tidak bentrok
    $nama_file = time().'_'.$foto_baru;
    move_uploaded_file($tmp, $folder.$nama_file);

    $query = "
        UPDATE barang SET
            nama_barang='$nama_barang',
            jumlah='$jumlah',
            kondisi='$kondisi',
            keterangan='$keterangan',
            foto='$nama_file'
        WHERE id_barang='$id_barang'
    ";

} else {

    $query = "
        UPDATE barang SET
            nama_barang='$nama_barang',
            jumlah='$jumlah',
            kondisi='$kondisi',
            keterangan='$keterangan'
        WHERE id_barang='$id_barang'
    ";
}

mysqli_query($koneksi, $query);

header("Location: index.php");
exit;