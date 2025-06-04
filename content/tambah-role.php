<?php

if (isset($_GET['delete'])) {  
    $id_user = $_GET['delete'];
    $queryDelete = mysqli_query($config,"DELETE FROM roles WHERE id = '$id_user'");
    if ($queryDelete) {
        header('location:?page=role&hapus=berhasil');
    } else {
        header('location:?page=role&hapus=gagal');
    }
}

if (!isset($_GET['edit'])) {
    $ht = "Add";
    if (isset($_POST['name'])) {
        $name = $_POST['name'];
        $id_user = isset($_GET['edit']) ? $_GET['edit'] : '';
        $insert = mysqli_query($config,"INSERT INTO roles (name) VALUES ('$name')");
        header("location:?page=role&tambah=berhasil");
    } 
    
} else {
    $ht = "Edit";
    $query = mysqli_query($config,"SELECT * FROM roles WHERE id={$_GET['edit']}");
    $row = mysqli_fetch_assoc($query);
    if (isset($_POST['name'])) {
        $name = $_POST['name'];
        $id_user = isset($_GET['edit']) ? $_GET['edit'] : '';
        $update = mysqli_query($config,"UPDATE roles SET name='$name' WHERE id='$id_user'");
        header("location:?page=role&ubah=berhasil");
    } 
}

?>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?php echo $ht; ?> Role</h5>
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="" class="form-label"> Role <span class="text-danger">*</span></label>
                        <input required type="text" name="name" placeholder="Enter your role" class="form-control" value="<?php echo isset($_GET['edit']) ? $row['name'] : ''; ?>">
                    </div>
                    <div class="mb-3">
                        <button type="submit" name="save" class="btn btn-success"><?php echo $ht; ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>