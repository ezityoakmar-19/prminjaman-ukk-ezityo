<?php
require_once __DIR__ . '/../../app.php';

$nama_barang = escapeString($koneksi, $_POST['nama_barang']);
$jumlah      = escapeString($koneksi, $_POST['jumlah']);
$kondisi     = escapeString($koneksi, $_POST['kondisi']);
$keterangan  = escapeString($koneksi, $_POST['keterangan']);

$folder = "../../../storage/barang/";
$foto = $_FILES['foto']['name'];
$tmp  = $_FILES['foto']['tmp_name'];

$nama_file = NULL;

if($foto != ""){

    // Validasi ekstensi
    $ext = strtolower(pathinfo($foto, PATHINFO_EXTENSION));
    $allowed = ['jpg','jpeg','png'];

    if(!in_array($ext, $allowed)){
        echo "<script>
                alert('Format foto harus JPG, JPEG, atau PNG');
                window.history.back();
              </script>";
        exit;
    }

    // Rename file supaya tidak bentrok
    $nama_file = time().'_'.$foto;

    move_uploaded_file($tmp, $folder.$nama_file);
}

$query = "
    INSERT INTO barang 
    (nama_barang, jumlah, kondisi, keterangan, foto)
    VALUES 
    ('$nama_barang', '$jumlah', '$kondisi', '$keterangan', '$nama_file')
";

mysqli_query($koneksi, $query);

header("Location: index.php");
exit;