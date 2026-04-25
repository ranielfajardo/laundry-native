<?php
$title = 'Dashboard';
include '../templates/header.php';

$baru = mysqli_query($conn, "SELECT * FROM tb_transaksi WHERE status = 'baru'");
$jumlahBaru = mysqli_num_rows($baru);

$proses = mysqli_query($conn, "SELECT * FROM tb_transaksi WHERE status = 'proses'");
$jumlahProses = mysqli_num_rows($proses);

$selesai = mysqli_query($conn, "SELECT * FROM tb_transaksi WHERE status = 'selesai'");
$jumlahSelesai = mysqli_num_rows($selesai);

$diambil = mysqli_query($conn, "SELECT * FROM tb_transaksi WHERE status = 'diambil'");
$jumlahDiambil = mysqli_num_rows($diambil);

$transaksi = query("SELECT * FROM tb_transaksi ORDER BY id DESC");
?>

<?php include '../templates/admin/navbar.php'; ?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- New Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                New
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $jumlahBaru; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-file fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- In Process Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                In Process
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $jumlahProses; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-sync fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Completed Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Completed
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $jumlahSelesai; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Picked Up Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Picked Up
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $jumlahDiambil; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-hand-holding fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Transaction History -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Transaction History</h6>
        </div>

        <div class="card-body">
            <?php foreach ($transaksi as $t) : ?>
                <div class="d-flex align-items-center justify-content-between pr-5 border-bottom mb-3">
                    <div>
                        <h5 class="mb-0">Invoice</h5>
                        <p><?= $t['kode_invoice']; ?></p>
                    </div>

                    <?php
                    if ($t['status'] == 'baru') {
                        echo '<span class="badge badge-primary">New</span>';
                    } elseif ($t['status'] == 'proses') {
                        echo '<span class="badge badge-warning">In Process</span>';
                    } elseif ($t['status'] == 'selesai') {
                        echo '<span class="badge badge-info">Completed</span>';
                    } elseif ($t['status'] == 'diambil') {
                        echo '<span class="badge badge-success">Picked Up</span>';
                    }
                    ?>

                    <?php
                    if ($t['dibayar'] == 'dibayar') {
                        echo '<span class="badge badge-success">Paid</span>';
                    } elseif ($t['dibayar'] == 'belum dibayar') {
                        echo '<span class="badge badge-danger">Unpaid</span>';
                    }
                    ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<?php include '../templates/footer.php'; ?>