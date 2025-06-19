<?php
    $queryTransactions = mysqli_query($config,"SELECT transactions.*, users.name FROM transactions LEFT JOIN users ON transactions.id_user = users.id ORDER BY id DESC");
    $rowTransactions = mysqli_fetch_all($queryTransactions, MYSQLI_ASSOC);

    if (isset($_GET['delete'])) {  
    $id_user = $_GET['delete'];
    $queryDelete = mysqli_query($config,"DELETE FROM transactions WHERE id = '$id_user'");
    if ($queryDelete) {
        header('location:?page=pos&hapus=berhasil');
    } else {
        header('location:?page=pos&hapus=gagal');
    }
}
?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Data Transaction</h5>
                <div class="mb-3" align="right">
                    <a href="?page=tambah-pos" class="btn btn-primary">Add</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No Transaction</th>
                                <th>Cashier Name</th>
                                <th>Sub Total</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rowTransactions as $key => $data) { ?>   
                                <tr>
                                    <td><?php echo $key + 1; ?></td>
                                    <td><?php echo $data['no_transaction']; ?></td>
                                    <td><?php echo $data['name']; ?></td>
                                    <td><?php echo "Rp. " . $data['sub_total']; ?></td>
                                    <td>
                                        <a href="?page=print-pos&print=<?php echo $data['id']; ?>" class="btn btn-success">Print</a>
                                        <a onclick="return confirm('Are you sure?')" href="?page=pos&delete=<?php echo $data['id'] ?>" class="btn btn-danger">Delete</a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>