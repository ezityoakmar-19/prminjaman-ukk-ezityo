<?php
require_once __DIR__ . '/../../app.php';
$data = mysqli_query($koneksi, "SELECT * FROM barang ORDER BY id_barang DESC");
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
    <div class="nxl-content"  style="padding-left: 230px; padding-top: 100px">

        <a href="tambah.php" class="btn btn-primary mb-3">
            + Tambah Barang
        </a>

        <div class="card">
            <div class="card-body">

                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th width="50">No</th>
                            <th>Foto</th>
                            <th>Nama Barang</th>
                            <th>Jumlah</th>
                            <th>Kondisi</th>
                            <th>Keterangan</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $no=1; while($b=mysqli_fetch_assoc($data)): ?>
                        <tr>
                            <td><?= $no++ ?></td>

                            <!-- FOTO -->
                            <td>
                                <?php if(!empty($b['foto'])): ?>
                                    <img src="../../../storage/barang/<?= $b['foto'] ?>"
                                         width="60" height="60"
                                         style="object-fit:cover;border-radius:5px;">
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>

                            <td><?= $b['nama_barang'] ?></td>
                            <td><?= $b['jumlah'] ?></td>
                            <td><?= $b['kondisi'] ?></td>
                            <td><?= $b['keterangan'] ?></td>

                            <td>
                                <a href="edit.php?id=<?= $b['id_barang'] ?>"
                                   class="btn btn-warning btn-sm">
                                    Edit
                                </a>

                                <a href="hapus.php?id=<?= $b['id_barang'] ?>"
                                   onclick="return confirm('Hapus barang?')"
                                   class="btn btn-danger btn-sm">
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

    <?php include '../../partials/footer.php'; ?>
</main>

<?php include '../../partials/script.php'; ?>
</body>
</html>     