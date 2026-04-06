<?php
require_once __DIR__ . '/../../app.php';

$id = $_GET['id'];
$p = mysqli_fetch_assoc(
    mysqli_query($koneksi, "SELECT * FROM peminjaman WHERE id_peminjaman=$id")
);
?>

<?php include '../../partials/header.php'; ?>
<body>
<?php include '../../partials/navbar.php'; ?>
<?php include '../../partials/sidebar.php'; ?>

<main class="nxl-container">
<div class="nxl-content">

<form action="proses_edit.php" method="POST">
<input type="hidden" name="id" value="<?= $p['id_peminjaman'] ?>">

<div class="mb-3">
    <label>Status</label>
    <select name="status" class="form-control">
        <option value="dipinjam">Dipinjam</option>
        <option value="dikembalikan">Dikembalikan</option>
    </select>
</div>

<button class="btn btn-success">Simpan</button>
</form>

</div>
</main>

<?php include '../../partials/footer.php'; ?>
<?php include '../../partials/script.php'; ?>
</body>
</html>
