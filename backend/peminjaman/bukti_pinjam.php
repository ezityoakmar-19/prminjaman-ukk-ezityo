<?php
// MENGATASI ERROR PATH SECARA OTOMATIS
if (file_exists(__DIR__ . '/../../app.php')) {
    require_once __DIR__ . '/../../app.php'; // Jika app.php ada di root 'ukk'
} elseif (file_exists(__DIR__ . '/../app.php')) {
    require_once __DIR__ . '/../app.php';    // Jika app.php ada di dalam 'backend'
} else {
    die("Error: File app.php tidak ditemukan! Periksa lokasi file koneksi Anda.");
}

$id = $_GET['id'] ?? '';

// Join tabel untuk ambil nama user dan nama barang
// Pastikan nama kolom id_peminjaman sesuai dengan yang ada di database kamu
$query = mysqli_query($koneksi, "SELECT peminjaman.*, users.nama, barang.nama_barang 
    FROM peminjaman 
    JOIN users ON peminjaman.id_user = users.id_user 
    JOIN barang ON peminjaman.id_barang = barang.id_barang 
    WHERE peminjaman.id_peminjaman = '$id'");

$d = mysqli_fetch_assoc($query);

if (!$d) { 
    die("Data peminjaman tidak ditemukan! ID: " . htmlspecialchars($id)); 
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Bukti Peminjaman #<?= $d['id_peminjaman'] ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print { display: none; }
            body { background: white; padding: 0; }
            .print-shadow { shadow: none; border: none; }
        }
    </style>
</head>
<body class="bg-slate-100 p-5 md:p-10 font-sans">

    <div class="max-w-2xl mx-auto bg-white p-8 rounded-xl shadow-md print-shadow border border-slate-200">
        <div class="text-center border-b-2 border-dashed pb-5 mb-5">
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">BUKTI PEMINJAMAN ALAT</h1>
            <p class="text-emerald-600 font-semibold uppercase text-sm tracking-widest">Juragan Rebana</p>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-8 text-sm">
            <div>
                <p class="text-slate-400 font-bold uppercase text-[10px]">No. Transaksi</p>
                <p class="font-mono text-lg">#JR-<?= str_pad($d['id_peminjaman'], 5, '0', STR_PAD_LEFT) ?></p>
            </div>
            <div class="text-right">
                <p class="text-slate-400 font-bold uppercase text-[10px]">Tanggal Cetak</p>
                <p><?= date('d/m/Y H:i') ?></p>
            </div>
        </div>

        <div class="space-y-4">
            <div class="flex justify-between items-center bg-slate-50 p-3 rounded-lg">
                <span class="text-slate-500">Nama Peminjam</span>
                <span class="font-bold text-slate-800"><?= $d['nama'] ?></span>
            </div>
            <div class="flex justify-between items-center bg-slate-50 p-3 rounded-lg">
                <span class="text-slate-500">Barang / Alat</span>
                <span class="font-bold text-emerald-700"><?= $d['nama_barang'] ?></span>
            </div>
            <div class="flex justify-between items-center bg-slate-50 p-3 rounded-lg">
                <span class="text-slate-500">Jumlah</span>
                <span class="font-bold"><?= $d['jumlah'] ?> Unit</span>
            </div>
        </div>

        <div class="mt-6 flex items-center gap-4 bg-emerald-50 p-4 rounded-xl border border-emerald-100">
            <div class="flex-1 text-center">
                <p class="text-[10px] font-bold text-emerald-600 uppercase">Mulai Pinjam</p>
                <p class="font-bold"><?= date('d M Y', strtotime($d['tanggal_pinjam'])) ?></p>
            </div>
            <div class="text-emerald-300">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
            </div>
            <div class="flex-1 text-center">
                <p class="text-[10px] font-bold text-emerald-600 uppercase">Batas Kembali</p>
                <p class="font-bold"><?= date('d M Y', strtotime($d['tanggal_kembali'])) ?></p>
            </div>
        </div>

        <div class="mt-6">
            <p class="text-[10px] font-bold text-slate-400 uppercase mb-1">Catatan Keperluan</p>
            <p class="text-sm text-slate-600 italic">"<?= $d['keterangan'] ?: 'Tidak ada catatan tambahan.' ?>"</p>
        </div>

        <div class="mt-12 grid grid-cols-2 gap-8 text-center text-xs">
            <div>
                <p class="mb-16 text-slate-400 uppercase tracking-widest">Peminjam</p>
                <div class="border-b border-slate-300 w-32 mx-auto"></div>
                <p class="mt-2 font-bold uppercase"><?= $d['nama'] ?></p>
            </div>
            <div>
                <p class="mb-16 text-slate-400 uppercase tracking-widest">Petugas Toko</p>
                <div class="border-b border-slate-300 w-32 mx-auto"></div>
                <p class="mt-2 font-bold uppercase">Admin Juragan</p>
            </div>
        </div>

        <div class="mt-10 flex flex-col sm:flex-row gap-3 no-print">
            <button onclick="window.print()" class="flex-1 bg-slate-800 text-white py-3 rounded-xl font-bold hover:bg-slate-900 transition flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
                Cetak Bukti
            </button>
            <a href="../../index.php" class="flex-1 bg-white border border-slate-200 text-slate-600 text-center py-3 rounded-xl font-bold hover:bg-slate-50 transition">
                Kembali ke Beranda
            </a>
        </div>
    </div>

</body>
</html>