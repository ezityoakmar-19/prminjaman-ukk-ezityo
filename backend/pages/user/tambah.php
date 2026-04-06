<?php
require_once __DIR__ . '/../../app.php';

$roles = mysqli_query($koneksi, "SELECT * FROM roles");
?>

<?php include '../../partials/header.php'; ?>
<body>

<?php include '../../partials/navbar.php'; ?>
<?php include '../../partials/sidebar.php'; ?>

<main class="container">
    <div class="nxl-content"  style="padding-left: 230px; padding-top: 100px">

        <div class="card">
            <div class="card-header">
                <h5>Tambah User</h5>
            </div>

            <div class="card-body">
                <form action="proses_tambah.php" method="POST">
                    
                    <div class="mb-3">
                        <label>Nama</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Role</label>
                        <select name="id_role" class="form-control" required>
                            <option value="">-- Pilih Role --</option>
                            <?php while ($r = mysqli_fetch_assoc($roles)) : ?>
                                <option value="<?= $r['id_role'] ?>">
                                    <?= $r['nama_role'] ?>
                                </option>
                            <?php endwhile ?>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
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
