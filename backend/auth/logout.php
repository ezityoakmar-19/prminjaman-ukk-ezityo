<?php
// 1. Mulai session agar bisa mengakses data yang ingin dihapus
session_start();

// 2. Hapus semua variabel session
session_unset();

// 3. Hancurkan/Hapus session secara permanen dari server
session_destroy();

// 4. Redirect (lempar) user kembali ke halaman utama (index.php)
// Kita gunakan ../../ karena file ini berada di dalam folder backend/auth/
echo "<script>
        alert('Anda telah berhasil keluar.');
        window.location.href = '../../index.php';
      </script>";
exit;
?>