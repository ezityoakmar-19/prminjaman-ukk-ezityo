<?php
require_once __DIR__ . '/../../app.php';

$query = "
    SELECT users.*, roles.nama_role 
    FROM users 
    JOIN roles ON users.id_role = roles.id_role
";
$result = mysqli_query($koneksi, $query);
?>

<?php include '../../partials/header.php' ?>
<body>

<nav class="nxl-navigation">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="#" class="b-brand">
                <img src="../../template/assets/images/logo-full.png" class="logo logo-lg" />
                <img src="../../template/assets/images/logo-abbr.png" class="logo logo-sm" />
            </a>
        </div>
        <?php include '../../partials/sidebar.php' ?>
    </div>
</nav>

<?php include '../../partials/navbar.php' ?>

<main class="container">
    <div class="content" style="padding-left: 230px; padding-top: 100px">

        <div class="card pt-5 pl-5" >
            <div class="card-header d-flex justify-content-between">
                <h5>Data User</h5>
                <a href="tambah.php" class="btn btn-primary btn-sm">Tambah User</a>
            </div>

            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Role</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; while ($row = mysqli_fetch_assoc($result)) : ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $row['nama'] ?></td>
                            <td><?= $row['username'] ?></td>
                            <td><?= $row['nama_role'] ?></td>
                            <td>
                                <a href="edit.php?id=<?= $row['id_user'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="hapus.php?id=<?= $row['id_user'] ?>" 
                                   class="btn btn-danger btn-sm"
                                   onclick="return confirm('Hapus data?')">Hapus</a>
                            </td>
                        </tr>
                        <?php endwhile ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
    <?php include '../../partials/footer.php' ?>
</main>

<?php include '../../partials/script.php' ?>
</body>
</html>
