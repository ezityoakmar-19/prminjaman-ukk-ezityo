<?php
require_once __DIR__ . '/../../app.php';

$query = "
    SELECT p.*, u.nama, b.nama_barang
    FROM peminjaman p
    JOIN users u ON p.id_user = u.id_user
    JOIN barang b ON p.id_barang = b.id_barang
";


$data = mysqli_query($koneksi, $query);
?>

<?php include '../../partials/header.php'; ?>
<body>

<nav class="nxl-navigation">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="#" class="b-brand">
                <img src="../../template/assets/images/logo-full.png" class="logo logo-lg" />
                <img src="../../template/assets/images/logo-abbr.png" class="logo logo-sm" />
            </a>
        </div>
        <?php include '../../partials/sidebar.php'; ?>
    </div>
</nav>

<?php include '../../partials/navbar.php'; ?>

<main class="container">
<div class="content"  style="padding-left: 230px; padding-top: 100px">

<a href="tambah.php" class="btn btn-primary mb-3">+ Tambah Peminjaman</a>

<div class="card">
<div class="card-body">
<table class="table table-bordered">
<thead>
<tr>
    <th>No</th>
    <th>Peminjam</th>
    <th>Barang</th>
    <th>Jumlah</th>
    <th>Tgl Pinjam</th>
    <th>Status</th>
    <th>Aksi</th>
</tr>
</thead>
<tbody>
<?php $no=1; while($p=mysqli_fetch_assoc($data)): ?>
<tr>
    <td><?= $no++ ?></td>
    <td><?= $p['nama'] ?></td>
    <td><?= $p['nama_barang'] ?></td>
    <td><?= $p['jumlah'] ?></td>
    <td><?= $p['tanggal_pinjam'] ?></td>
    <td>
        <span class="badge bg-<?= $p['status']=='dipinjam'?'warning':'success' ?>">
            <?= $p['status'] ?>
        </span>
    </td>
    <td>
    <?php if($p['status'] == 'dipinjam'): ?>
        <a href="kembalikan.php?id=<?= $p['id_peminjaman'] ?>"
           class="btn btn-success btn-sm"
           onclick="return confirm('Kembalikan barang?')">
           Kembalikan
        </a>
    <?php else: ?>
        <span class="badge bg-secondary">Selesai</span>
    <?php endif; ?>

    <a href="hapus.php?id=<?= $p['id_peminjaman'] ?>"
       class="btn btn-danger btn-sm"
       onclick="return confirm('Hapus data?')">
       Hapus
    </a>
</td>

</tr>
<?php endwhile ?>
</tbody>
</table>
</div>
</div>

</div>
</main>

<?php include '../../partials/footer.php'; ?>
<?php include '../../partials/script.php'; ?>
</body>
</html>
