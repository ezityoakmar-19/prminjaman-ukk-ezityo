<?php
require_once __DIR__ . '/../../app.php';

$id = $_GET['id'];
$data = mysqli_query($koneksi, "SELECT * FROM barang WHERE id_barang='$id'");
$b = mysqli_fetch_assoc($data);
?>

<?php include '../../partials/header.php'; ?>
<body>

<?php include '../../partials/navbar.php'; ?>
<?php include '../../partials/sidebar.php'; ?>

<main class="container">
    <div class="nxl-content"  style="padding-left: 230px; padding-top: 100px">

        <div class="card">
            <div class="card-header">
                <h5>Edit Barang</h5>
            </div>

            <div class="card-body">
                <form action="proses_edit.php" method="POST" enctype="multipart/form-data">

                    <input type="hidden" name="id_barang" value="<?= $b['id_barang'] ?>">

                    <div class="mb-3">
                        <label>Nama Barang</label>
                        <input type="text" name="nama_barang"
                               value="<?= $b['nama_barang'] ?>"
                               class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Jumlah</label>
                        <input type="number" name="jumlah"
                               value="<?= $b['jumlah'] ?>"
                               class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Kondisi</label>
                        <select name="kondisi" class="form-control">
                            <option value="Baik" <?= $b['kondisi']=='Baik'?'selected':'' ?>>Baik</option>
                            <option value="Rusak" <?= $b['kondisi']=='Rusak'?'selected':'' ?>>Rusak</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Keterangan</label>
                        <textarea name="keterangan" class="form-control"><?= $b['keterangan'] ?></textarea>
                    </div>

                    <!-- FOTO LAMA -->
                    <div class="mb-3">
                        <label>Foto Saat Ini</label><br>
                        <?php if($b['foto']) : ?>
                            <img src="../../../storage/barang/<?= $b['foto'] ?>"
                                 width="120" class="mb-2">
                        <?php else: ?>
                            <p class="text-muted">Belum ada foto</p>
                        <?php endif; ?>
                    </div>

                    <!-- UPLOAD FOTO BARU -->
                    <div class="mb-3">
                        <label>Ganti Foto</label>
                        <input type="file" name="foto" class="form-control">
                        <small class="text-muted">
                            Kosongkan jika tidak ingin mengganti foto
                        </small>
                    </div>

                    <button class="btn btn-primary">Update</button>
                    <a href="index.php" class="btn btn-secondary">Kembali</a>

                </form>
            </div>
        </div>

    </div>
</main>

<?php include '../../partials/footer.php'; ?>
<?php include '../../partials/script.php'; ?>
</body>
</html>