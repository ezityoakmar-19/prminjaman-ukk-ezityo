<?php
require_once __DIR__ . '/../../app.php';

$id_user = escapeString($koneksi, $_POST['id_user']);
$nama    = escapeString($koneksi, $_POST['nama']);
$username= escapeString($koneksi, $_POST['username']);
$password= escapeString($koneksi, $_POST['password']);
$id_role = escapeString($koneksi, $_POST['id_role']);

if ($password != "") {
    $query = "
        UPDATE users SET
            nama='$nama',
            username='$username',
            password='$password',
            id_role='$id_role'
        WHERE id_user='$id_user'
    ";
} else {
    $query = "
        UPDATE users SET
            nama='$nama',
            username='$username',
            id_role='$id_role'
        WHERE id_user='$id_user'
    ";
}

mysqli_query($koneksi, $query);

header("Location: index.php");
exit;
