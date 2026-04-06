<?php
// config/connection.php

$host     = "localhost";
$user     = "root";
$password = ""; // sesuaikan (misal: angga123)
$database = "ukk"; // ganti sesuai nama DB kamu

$koneksi = mysqli_connect($host, $user, $password, $database);

// Cek koneksi
if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
