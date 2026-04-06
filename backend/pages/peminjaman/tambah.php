<?php
require_once __DIR__ . '/../../app.php';

$users  = mysqli_query($koneksi, "SELECT * FROM users");
$barang = mysqli_query($koneksi, "SELECT * FROM barang");
?>

<?php include '../../partials/header.php'; ?>
<body>
<?php include '../../partials/navbar.php'; ?>
<?php include '../../partials/sidebar.php'; ?>

<main class="container">
<div class="nxl-content" style="padding-left: 100px; padding-top: 100px">

<div class="card">
<div class="card-body">
<form action="proses_tambah.php" method="POST">
    <div class="mb-3">
        <label>Peminjam</label>
        <select name="id_user" class="form-control" required>
            <option value="">-- Pilih --</option>
            <?php while($u=mysqli_fetch_assoc($users)): ?>
            <option value="<?= $u['id_user'] ?>"><?= $u['nama'] ?></option>
            <?php endwhile ?>
        </select>
    </div>

    <div class="mb-3">
        <label>Barang</label>
        <select name="id_barang" class="form-control" required>
            <option value="">-- Pilih --</option>
            <?php while($b=mysqli_fetch_assoc($barang)): ?>
            <option value="<?= $b['id_barang'] ?>">
                <?= $b['nama_barang'] ?> (stok: <?= $b['jumlah'] ?>)
            </option>
            <?php endwhile ?>
        </select>
    </div>

    <div class="mb-3">
        <label>Jumlah</label>
        <input type="number" name="jumlah" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Tanggal Pinjam</label>
        <input type="date" name="tanggal_pinjam" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Keterangan</label>
        <textarea name="keterangan" class="form-control"></textarea>
    </div>

    <button class="btn btn-primary">Simpan</button>
</form>

</div>
</div>

</div>
</main>

<?php include '../../partials/footer.php'; ?>
<?php include '../../partials/script.php'; ?>
</body>
</html>