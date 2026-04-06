<?php
require_once __DIR__ . '/../../app.php';

$id = $_GET['id'];
mysqli_query($koneksi, "DELETE FROM peminjaman WHERE id_peminjaman=$id");
header("Location: index.php");
