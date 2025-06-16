<?php
    $queryProduct = mysqli_query($config,"SELECT p.*, c.name category FROM products p LEFT JOIN categories c ON p.id_category = c.id ORDER BY id DESC");
    $rowProduct = mysqli_fetch_all($queryProduct, MYSQLI_ASSOC);
?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Data Product</h5>
                <div class="mb-3" align="right">
                    <a href="?page=tambah-product" class="btn btn-primary">+</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Category</th>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Qty</th>
                                <th>Description</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rowProduct as $key => $data) { ?>   
                                <tr>
                                    <td><?php echo $key + 1; ?></td>
                                    <td><?php echo $data['category']; ?></td>
                                    <td><?php echo $data['name']; ?></td>
                                    <td><?php echo $data['price']; ?></td>
                                    <td><?php echo $data['qty']; ?></td>
                                    <td><?php echo $data['description']; ?></td>
                                    <td>
                                        <a href="?page=tambah-product&edit=<?php echo $data['id']; ?>" class="btn btn-success btn-sm">Edit</a>
                                        <a onclick="return confirm('Are you sure?')" href="?page=tambah-product&delete=<?php echo $data['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
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