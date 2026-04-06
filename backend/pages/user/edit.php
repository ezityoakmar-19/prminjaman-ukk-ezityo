<?php
require_once __DIR__ . '/../../app.php';

$id = $_GET['id'];

$user  = mysqli_query($koneksi, "SELECT * FROM users WHERE id_user='$id'");
$data  = mysqli_fetch_assoc($user);
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
                <h5>Edit User</h5>
            </div>

            <div class="card-body">
                <form action="proses_edit.php" method="POST">

                    <input type="hidden" name="id_user" value="<?= $data['id_user'] ?>">

                    <div class="mb-3">
                        <label>Nama</label>
                        <input type="text" name="nama" class="form-control"
                               value="<?= $data['nama'] ?>" required>
                    </div>

                    <div class="mb-3">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control"
                               value="<?= $data['username'] ?>" required>
                    </div>

                    <div class="mb-3">
                        <label>Password (kosongkan jika tidak diubah)</label>
                        <input type="password" name="password" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Role</label>
                        <select name="id_role" class="form-control" required>
                            <?php while ($r = mysqli_fetch_assoc($roles)) : ?>
                                <option value="<?= $r['id_role'] ?>"
                                    <?= $data['id_role'] == $r['id_role'] ? 'selected' : '' ?>>
                                    <?= $r['nama_role'] ?>
                                </option>
                            <?php endwhile ?>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
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
