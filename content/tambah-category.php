<?php

if (isset($_GET['delete'])) {  
    $id_user = $_GET['delete'];
    $queryDelete = mysqli_query($config,"DELETE FROM categories WHERE id = '$id_user'");
    if ($queryDelete) {
        header('location:?page=categories&hapus=berhasil');
    } else {
        header('location:?page=categories&hapus=gagal');
    }
}

if (!isset($_GET['edit'])) {
    $ht = "Add";
    if (isset($_POST['name'])) {
        $name = $_POST['name'];
        $id_user = isset($_GET['edit']) ? $_GET['edit'] : '';
        $insert = mysqli_query($config,"INSERT INTO categories (name) VALUES ('$name')");
        header("location:?page=categories&tambah=berhasil");
    } 
    
} else {
    $ht = "Edit";
    $query = mysqli_query($config,"SELECT * FROM categories WHERE id={$_GET['edit']}");
    $row = mysqli_fetch_assoc($query);
    if (isset($_POST['name'])) {
        $name = $_POST['name'];
        $id_user = isset($_GET['edit']) ? $_GET['edit'] : '';
        $update = mysqli_query($config,"UPDATE categories SET name='$name' WHERE id='$id_user'");
        header("location:?page=categories&ubah=berhasil");
    } 
}

?>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?php echo $ht; ?> Category</h5>

                <form action="" method="post">
                    <div class="mb-3">
                        <label for="" class="form-label"> Name <span class="text-danger">*</span></label>
                        <input required type="text" name="name" placeholder="Enter your category" class="form-control" value="<?php echo isset($_GET['edit']) ? $row['name'] : ''; ?>">
                    </div>
                    <div class="mb-3">
                        <button type="submit" name="save" class="btn btn-success"><?php echo $ht; ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>