<?php
require_once __DIR__ . '/../../app.php';

$nama     = escapeString($koneksi, $_POST['nama']);
$username = escapeString($koneksi, $_POST['username']);
$password = escapeString($koneksi, $_POST['password']);
$id_role  = escapeString($koneksi, $_POST['id_role']);

// CEK USERNAME
$cek = mysqli_query(
    $koneksi,
    "SELECT * FROM users WHERE username='$username'"
);

if (mysqli_num_rows($cek) > 0) {
    echo "<script>
        alert('Username sudah digunakan!');
        window.location='tambah.php';
    </script>";
    exit;
}

// INSERT DATA
$query = "
    INSERT INTO users (nama, username, password, id_role)
    VALUES ('$nama', '$username', '$password', '$id_role')
";

mysqli_query($koneksi, $query);

header("Location: index.php");
exit;
