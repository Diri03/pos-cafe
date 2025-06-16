<?php

$queryC =mysqli_query($config, "SELECT * FROM categories ORDER BY id DESC");
$rowC = mysqli_fetch_all( $queryC, MYSQLI_ASSOC);

if (isset($_GET['delete'])) {  
    $id_user = $_GET['delete'];
    $queryDelete = mysqli_query($config,"DELETE FROM products WHERE id = '$id_user'");
    if ($queryDelete) {
        header('location:?page=products&hapus=berhasil');
    } else {
        header('location:?page=products&hapus=gagal');
    }
}

if (!isset($_GET['edit'])) {
    $ht = "Add";
    if (isset($_POST['name'])) {
        $name = $_POST['name'];
        $id_category = $_POST['id_category'];
        $price = $_POST['price'];
        $qty = $_POST['qty'];
        $description = $_POST['description'];
        $id_user = isset($_GET['edit']) ? $_GET['edit'] : '';
        $insert = mysqli_query($config,"INSERT INTO products (id_category, name, price, qty, description) VALUES ('$id_category', '$name', '$price', '$qty', '$description')");
        header("location:?page=products&tambah=berhasil");
    } 
    
} else {
    $ht = "Edit";
    $query = mysqli_query($config,"SELECT * FROM products WHERE id={$_GET['edit']}");
    $row = mysqli_fetch_assoc($query);
    if (isset($_POST['name'])) {
        $name = $_POST['name'];
        $id_category = $_POST['id_category'];
        $price = $_POST['price'];
        $qty = $_POST['qty'];
        $description = $_POST['description'];
        $id_user = isset($_GET['edit']) ? $_GET['edit'] : '';
        $update = mysqli_query($config,"UPDATE products SET id_category='$id_category', name='$name', price='$price', qty='$qty', description='$description' WHERE id='$id_user'");
        header("location:?page=products&ubah=berhasil");
    } 
}

?>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?php echo $ht; ?> Product</h5>

                <form action="" method="post">
                    <div class="mb-3">
                        <label for="" class="form-label"> Product Name <span class="text-danger">*</span></label>
                        <input required type="text" name="name" placeholder="Enter your name" class="form-control" value="<?php echo isset($row['name']) ? $row['name'] : ''; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label"> Category Product <span class="text-danger">*</span></label>
                        <select required name="id_category" id="" class="form-control" required>
                            <option value="">-- Choose category --</option>
                            <?php foreach ($rowC as $key => $data) { ?>
                                <option <?php echo isset($_GET['edit']) ? ($row['id_category'] == $data['id'] ? 'selected' : '') : '' ?> value="<?php echo $data['id']; ?>"><?php echo $data['name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label"> Price <span class="text-danger">*</span></label>
                        <input required type="number" name="price" placeholder="Enter your price" class="form-control" value="<?php echo isset($_GET['edit']) ? $row['price'] : ''; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label"> Qty <span class="text-danger">*</span></label>
                        <input required type="number" name="qty" placeholder="Enter your quantity" class="form-control" value="<?php echo isset($_GET['edit']) ? $row['qty'] : ''; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label"> Description <span class="text-danger">*</span></label>
                        <textarea name="description" id="" cols="30" rows="10" class="form-control"><?php echo isset($_GET['edit']) ? $row['description'] : ''; ?></textarea>
                    </div>
                    <div class="mb-3">
                        <button type="submit" name="save" class="btn btn-success"><?php echo $ht; ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>