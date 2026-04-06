<?php
session_start(); // Pastikan session aktif
require_once __DIR__ . '/backend/app.php';

if (!isset($_SESSION['login'])) {
    header("Location: backend/auth/login.php");
    exit;
}


// 1. Ambil ID Barang dari URL
$id = isset($_GET['id']) ? mysqli_real_escape_string($koneksi, $_GET['id']) : '';
$query = mysqli_query($koneksi, "SELECT * FROM barang WHERE id_barang = '$id'");
$b = mysqli_fetch_assoc($query);

// Jika barang tidak ditemukan
if (!$b) {
    echo "<script>alert('Barang tidak ditemukan!'); window.location='index.php';</script>";
    exit;
}

// Data diri kita dari session
$my_id   = $_SESSION['id_user'];
$my_nama = $_SESSION['nama'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sewa <?= $b['nama_barang'] ?> - JuraganRebana</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
</head>
<body class="bg-slate-50 font-['Plus_Jakarta_Sans'] text-slate-800">

    <nav class="bg-white border-b border-slate-200 py-4 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 flex justify-between items-center">
            <a href="index.php" class="text-emerald-600 font-bold flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                Kembali
            </a>
            <span class="font-bold text-slate-900">Form Penyewaan</span>
        </div>
    </nav>

    <main class="max-w-5xl mx-auto px-4 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <div class="lg:col-span-5">
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden sticky top-24">
                    <img src="storage/barang/<?= $b['foto'] ?>" class="w-full h-64 object-cover bg-slate-100">
                    <div class="p-6">
                        <h1 class="text-2xl font-extrabold text-slate-900 mb-2"><?= $b['nama_barang'] ?></h1>
                        <p class="text-slate-600 text-sm"><?= nl2br($b['keterangan']) ?></p>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-7">
                <div class="bg-white rounded-3xl shadow-lg border border-slate-200 p-8">
                    <form action="backend/peminjaman/proses_tambah.php" method="POST" class="space-y-5">
                        <input type="hidden" name="id_barang" value="<?= $b['id_barang'] ?>">

                       <div>
    <label class="block text-sm font-bold mb-2 text-slate-500">Peminjam Atas Nama</label>
    <div class="relative">
        <input type="text" 
               value="<?= $my_nama ?>" 
               class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-100 text-slate-500 cursor-not-allowed outline-none" 
               readonly>
        
        <input type="hidden" name="id_user" value="<?= $my_id ?>">
        
        <span class="absolute right-4 top-3 text-emerald-600">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"/></svg>
        </span>
    </div>
    <p class="text-[10px] text-slate-400 mt-1">*Akun terverifikasi otomatis</p>
</div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-bold mb-2">Tanggal Pinjam</label>
                                <input type="date" name="tanggal_pinjam" id="tgl_pinjam" value="<?= date('Y-m-d') ?>" class="w-full px-4 py-3 rounded-xl border border-slate-200 outline-none focus:ring-2 focus:ring-emerald-500" required>
                            </div>
                            <div>
                                <label class="block text-sm font-bold mb-2">Tanggal Kembali</label>
                                <input type="date" name="tanggal_kembali" id="tgl_kembali" class="w-full px-4 py-3 rounded-xl border border-slate-200 outline-none focus:ring-2 focus:ring-emerald-500" required>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold mb-2">Jumlah Unit</label>
                            <input type="number" name="jumlah" min="1" max="<?= $b['jumlah'] ?>" class="w-full px-4 py-3 rounded-xl border border-slate-200 outline-none focus:ring-2 focus:ring-emerald-500" placeholder="Stok: <?= $b['jumlah'] ?>" required>
                        </div>

                        <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-4 rounded-2xl transition shadow-xl shadow-emerald-200">
                            Konfirmasi Pinjaman Sekarang
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <script>
        // Otomatis set minimal tanggal kembali = tanggal pinjam
        const tglPinjam = document.getElementById('tgl_pinjam');
        const tglKembali = document.getElementById('tgl_kembali');
        
        tglPinjam.addEventListener('change', function() {
            tglKembali.min = this.value;
        });
    </script>
</body>
</html>