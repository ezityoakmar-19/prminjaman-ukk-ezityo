<?php
require_once __DIR__ . '/../../app.php';

// FILTER
$tgl_awal  = $_GET['tgl_awal'] ?? '';
$tgl_akhir = $_GET['tgl_akhir'] ?? '';

$query = "SELECT * FROM barang";

if (!empty($tgl_awal) && !empty($tgl_akhir)) {
    $query .= " WHERE tanggal_masuk BETWEEN '$tgl_awal' AND '$tgl_akhir'";
}

$data = mysqli_query($koneksi, $query);
?>

<?php include '../../partials/header.php'; ?>
<body>

<!-- SIDEBAR -->
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

<!-- NAVBAR -->
<?php include '../../partials/navbar.php'; ?>

<main class="nxl-container">
    <div class="nxl-content" style="padding-left: 230px; padding-top: 100px">

        <div class="card">
            <div class="card-body">

                <h3 class="text-center mb-4">LAPORAN DATA BARANG</h3>

                <!-- FILTER -->
                <form method="GET" class="row mb-3 no-print">
                    <div class="col-md-3">
                        <input type="date" name="tgl_awal"
                               value="<?= $tgl_awal ?>"
                               class="form-control">
                    </div>

                    <div class="col-md-3">
                        <input type="date" name="tgl_akhir"
                               value="<?= $tgl_akhir ?>"
                               class="form-control">
                    </div>

                    <div class="col-md-4">
                        <button class="btn btn-primary">
                            <i class="feather-search"></i> Filter
                        </button>

                        <button type="button"
                                onclick="window.print()"
                                class="btn btn-success">
                            <i class="feather-printer"></i> Cetak
                        </button>
                    </div>
                </form>

                <!-- TABEL LAPORAN -->
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th width="50">No</th>
                            <th>Nama Barang</th>
                            <th>Jumlah</th>
                            <th>Kondisi</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1; while($b=mysqli_fetch_assoc($data)): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $b['nama_barang'] ?></td>
                            <td><?= $b['jumlah'] ?></td>
                            <td><?= $b['kondisi'] ?></td>
                            <td><?= $b['keterangan'] ?></td>
                        </tr>
                        <?php endwhile ?>
                    </tbody>
                </table>

                <br><br>
                <div class="text-end">
                    <p><?= date('d F Y') ?></p>
                    <p>Mengetahui,</p>
                    <br><br><br>
                    <p>________________________</p>
                </div>

            </div>
        </div>

    </div>

    <?php include '../../partials/footer.php'; ?>
</main>

<?php include '../../partials/script.php'; ?>

<!-- CSS PRINT -->
<style>
@media print {
    .no-print,
    .nxl-navigation,
    .nxl-header,
    .footer {
        display: none !important;
    }

    .card {
        border: none;
    }
}
</style>

</body>
</html>