<?php
require_once __DIR__ . '/../../app.php';

$id = $_GET['id'];

mysqli_query($koneksi, "DELETE FROM users WHERE id_user='$id'");

header("Location: index.php");
exit;
