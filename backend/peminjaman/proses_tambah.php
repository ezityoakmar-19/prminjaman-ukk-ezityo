<?php
// MENGATASI ERROR PATH: Cek di mana app.php berada secara otomatis
if (file_exists(__DIR__ . '/../../app.php')) {
    require_once __DIR__ . '/../../app.php'; // Jika app.php ada di root 'ukk'
} elseif (file_exists(__DIR__ . '/../app.php')) {
    require_once __DIR__ . '/../app.php';    // Jika app.php ada di dalam 'backend'
} else {
    die("Error: File app.php tidak ditemukan! Periksa lokasi file koneksi Anda.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Menghindari error "Undefined array key" dengan isset
    $id_user        = $_POST['id_user'] ?? '';
    $id_barang      = $_POST['id_barang'] ?? '';
    $jumlah         = $_POST['jumlah'] ?? 0;
    $tgl_pinjam     = $_POST['tanggal_pinjam'] ?? '';
    $tgl_kembali    = $_POST['tanggal_kembali'] ?? '';
    $ket            = $_POST['keterangan'] ?? ''; // Jika kosong, diisi string kosong

    // 1. Cek stok barang (Gunakan variable $koneksi dari app.php)
    $query_stok = mysqli_query($koneksi, "SELECT jumlah FROM barang WHERE id_barang = '$id_barang'");
    $data_barang = mysqli_fetch_assoc($query_stok);

    if (!$data_barang) {
        die("Barang tidak ditemukan!");
    }

    if ($jumlah > $data_barang['jumlah']) {
        echo "<script>alert('Gagal! Stok tidak mencukupi.'); window.history.back();</script>";
        exit;
    }

    // 2. Insert ke database (Sesuai kolom yang kamu minta)
    $query_insert = "INSERT INTO peminjaman (id_user, id_barang, tanggal_pinjam, tanggal_kembali, jumlah, keterangan) 
                     VALUES ('$id_user', '$id_barang', '$tgl_pinjam', '$tgl_kembali', '$jumlah', '$ket')";

    if (mysqli_query($koneksi, $query_insert)) {
        // Ambil ID peminjaman yang baru saja dibuat
        $id_baru = mysqli_insert_id($koneksi);

        // Update stok barang
        mysqli_query($koneksi, "UPDATE barang SET jumlah = jumlah - $jumlah WHERE id_barang = '$id_barang'");

        // Redirect ke halaman bukti pinjam (Sesuaikan path folder Anda)
        echo "<script>
                alert('Peminjaman Berhasil!');
                window.location.href = 'bukti_pinjam.php?id=$id_baru';
              </script>";
    }
}
?>