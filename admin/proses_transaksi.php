<?php
$title = 'Transaction';
include '../templates/header.php';

$id = $_GET['id'];
$transaksi = query("SELECT * FROM tb_transaksi WHERE id = $id")[0];

if (isset($_POST['update'])) {
    if (updateDataTransaksi($_POST) > 0) {
        $_SESSION['updated'] = true;
        echo "<script>window.location.href = 'transaksi.php'</script>";
    } else {
        $_SESSION['notUpdated'] = true;
    }
}
?>
<?php include '../templates/admin/navbar.php'; ?>
<!-- Begin Page Content -->
<div class="container-fluid">
    <?php
    if (isset($_SESSION['notUpdated'])) {
        echo '<div class="alert alert-danger">Failed to update data!</div>';
        unset($_SESSION['notUpdated']);
    }
    ?>

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Transaction</h1>
        <a class="btn btn-secondary" href="transaksi.php"><i class="fas fa-arrow-left mr-2"></i>Back</a>
    </div>

    <!-- DataTables Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Process Transaction</h6>
        </div>
        <div class="row card-body align-items-center">
            <div class="col-md text-center">
                <img src="../assets/img/undraw_process_re_gws7.svg" alt="" style="width: 350px;">
            </div>
            <div class="col-md">
                <form action="" method="post">
                    <input type="hidden" name="id" value="<?= $transaksi['id']; ?>">
                    <div class="form-floating mb-3">
                        <select class="form-select" id="status" aria-label="Floating label select example" name="status" required>
                            <option disabled>Select status</option>
                            <option value="baru" <?= ($transaksi['status'] == 'baru') ? 'selected' : ''; ?>>New</option>
                            <option value="proses" <?= ($transaksi['status'] == 'proses') ? 'selected' : ''; ?>>In Process</option>
                            <option value="selesai" <?= ($transaksi['status'] == 'selesai') ? 'selected' : ''; ?>>Completed</option>
                            <option value="diambil" <?= ($transaksi['status'] == 'diambil') ? 'selected' : ''; ?>>Picked Up</option>
                        </select>
                        <label for="status">Status</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" id="dibayar" aria-label="Floating label select example" name="dibayar" required>
                            <option disabled>Select payment status</option>
                            <option value="belum dibayar" <?= ($transaksi['dibayar'] == 'belum dibayar') ? 'selected' : ''; ?>>Unpaid</option>
                            <option value="dibayar" <?= ($transaksi['dibayar'] == 'dibayar') ? 'selected' : ''; ?>>Paid</option>
                        </select>
                        <label for="dibayar">Payment Status</label>
                    </div>
                    <button type="submit" class="btn btn-primary float-right" name="update">Update</button>
                </form>
            </div>
        </div>
    </div>


</div>
<!-- /.container-fluid -->
<?php include '../templates/footer.php'; ?>