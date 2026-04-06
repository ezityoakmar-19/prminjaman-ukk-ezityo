<?php
session_start();
require_once __DIR__ . '/backend/app.php';

// Proteksi: Jika belum login, tendang ke halaman login
if (!isset($_SESSION['id_user'])) {
    header("Location: backend/auth/login.php");
    exit;
}

$id_user = $_SESSION['id_user'];

// Ambil data pinjaman user ini, gabungkan dengan tabel barang
$query = mysqli_query($koneksi, "SELECT peminjaman.*, barang.nama_barang, barang.foto 
    FROM peminjaman 
    JOIN barang ON peminjaman.id_barang = barang.id_barang 
    WHERE peminjaman.id_user = '$id_user' 
    ORDER BY peminjaman.id_peminjaman DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Sewa Saya - JuraganRebana</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800">

    <nav class="bg-white border-b border-slate-200 py-4 sticky top-0 z-50">
        <div class="max-w-5xl mx-auto px-4 flex justify-between items-center">
            <a href="index.php" class="text-emerald-600 font-bold flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                Kembali ke Beranda
            </a>
            <h1 class="font-extrabold text-slate-900">Riwayat Sewa</h1>
        </div>
    </nav>

    <main class="max-w-5xl mx-auto px-4 py-10">
        <div class="mb-8">
            <h2 class="text-2xl font-extrabold text-slate-900">Halo, <?= $_SESSION['nama'] ?>! 👋</h2>
            <p class="text-slate-500 text-sm">Berikut adalah daftar alat yang Anda sewa di JuraganRebana.</p>
        </div>

        <?php if (mysqli_num_rows($query) > 0): ?>
            <div class="grid gap-4">
                <?php while($row = mysqli_fetch_assoc($query)): ?>
                    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex flex-col md:flex-row items-center gap-6 hover:border-emerald-300 transition-all">
                        
                        <div class="w-20 h-20 bg-slate-100 rounded-xl overflow-hidden flex-shrink-0">
                            <?php if(!empty($row['foto'])): ?>
                                <img src="storage/barang/<?= $row['foto'] ?>" class="w-full h-full object-cover">
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center text-[10px] text-slate-400">No Pic</div>
                            <?php endif; ?>
                        </div>

                        <div class="flex-grow text-center md:text-left">
                            <h3 class="font-bold text-slate-900 text-lg"><?= $row['nama_barang'] ?></h3>
                            <p class="text-xs text-slate-400 font-bold mb-2 uppercase tracking-widest">Jumlah: <?= $row['jumlah'] ?> Unit</p>
                            <div class="flex flex-wrap justify-center md:justify-start gap-4 text-sm text-slate-600">
                                <div class="flex items-center gap-1">
                                    <span class="text-slate-400 italic">Mulai:</span>
                                    <span class="font-semibold"><?= date('d M Y', strtotime($row['tanggal_pinjam'])) ?></span>
                                </div>
                                <div class="flex items-center gap-1">
                                    <span class="text-slate-400 italic">Batas:</span>
                                    <span class="font-semibold"><?= date('d M Y', strtotime($row['tanggal_kembali'])) ?></span>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col items-center md:items-end gap-3 w-full md:w-auto">
                            <?php 
                                // Logika Warna Status
                                $status = $row['status'] ?? 'Dipinjam'; 
                                $colorClass = ($status == 'Dipinjam') ? 'bg-amber-100 text-amber-700' : 'bg-emerald-100 text-emerald-700';
                            ?>
                            <span class="px-4 py-1.5 <?= $colorClass ?> text-xs font-black uppercase rounded-full">
                                <?= $status ?>
                            </span>
                            
                            <a href="backend/peminjaman/bukti_pinjam.php?id=<?= $row['id_peminjaman'] ?>" 
                               class="text-xs font-bold text-emerald-600 hover:text-emerald-700 underline flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/><path d="M6 9V2h12v7"/></svg>
                                Lihat Bukti Pinjam
                            </a>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="bg-white p-20 rounded-[3rem] border border-dashed border-slate-300 text-center">
                <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-6 text-slate-400">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M16 16s-1.5-2-4-2-4 2-4 2"/><line x1="9" y1="9" x2="9.01" y2="9"/><line x1="15" y1="9" x2="15.01" y2="9"/></svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900">Belum ada riwayat sewa</h3>
                <p class="text-slate-500 mt-2 mb-8">Sepertinya Anda belum pernah meminjam alat hadroh di sini.</p>
                <a href="index.php#paket" class="bg-emerald-600 text-white px-8 py-3 rounded-full font-bold hover:bg-emerald-700 transition shadow-lg shadow-emerald-200">
                    Cari Alat Sekarang
                </a>
            </div>
        <?php endif; ?>

    </main>

    <footer class="mt-20 py-10 text-center text-slate-400 text-xs border-t border-slate-200">
        &copy; 2026 JuraganRebana. All Rights Reserved.
    </footer>

</body>
</html>