<?php require_once __DIR__ . '/../../app.php'; ?>

<?php include '../../partials/header.php'; ?>
<body>

<?php include '../../partials/navbar.php'; ?>
<?php include '../../partials/sidebar.php'; ?>

<main class="container">
    <div class="nxl-content"  style="padding-left: 230px; padding-top: 100px">

        <div class="card">
            <div class="card-header">
                <h5>Tambah Barang</h5>
            </div>

            <div class="card-body">
                <form action="proses_tambah.php" 
                      method="POST" 
                      enctype="multipart/form-data">

                    <div class="mb-3">
                        <label>Nama Barang</label>
                        <input type="text" name="nama_barang" 
                               class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Jumlah</label>
                        <input type="number" name="jumlah" 
                               class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Kondisi</label>
                        <select name="kondisi" 
                                class="form-control" required>
                            <option value="Baik">Baik</option>
                            <option value="Rusak">Rusak</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Keterangan</label>
                        <textarea name="keterangan" 
                                  class="form-control"></textarea>
                    </div>

                    <!-- FOTO -->
                    <div class="mb-3">
                        <label>Foto Barang</label>
                        <input type="file" name="foto" 
                               class="form-control">
                        <small class="text-muted">
                            Format: JPG, JPEG, PNG
                        </small>
                    </div>

                    <button class="btn btn-primary">Simpan</button>
                    <a href="index.php" 
                       class="btn btn-secondary">Kembali</a>

                </form>
            </div>
        </div>

    </div>
</main>

<?php include '../../partials/footer.php'; ?>
<?php include '../../partials/script.php'; ?>
</body>
</html>