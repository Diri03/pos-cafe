<?php

if (isset($_GET['delete'])) {  
    $id_user = $_GET['delete'];
    $queryDelete = mysqli_query($config,"UPDATE users SET deleted_at = 1 WHERE id = '$id_user'");
    if ($queryDelete) {
        header('location:?page=user&hapus=berhasil');
    } else {
        header('location:?page=user&hapus=gagal');
    }
}

if (!isset($_GET['edit'])) {
    $ht = "Add";
    if (isset($_POST['name'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = sha1($_POST['password']);
        $id_user = isset($_GET['edit']) ? $_GET['edit'] : '';
        $insert = mysqli_query($config,"INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')");
        header("location:?page=user&tambah=berhasil");
    } 
    
} else {
    $ht = "Edit";
    $query = mysqli_query($config,"SELECT * FROM users WHERE id={$_GET['edit']}");
    $row = mysqli_fetch_assoc($query);
    if (isset($_POST['name'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        if (empty($_POST['password'])) {
            $password = $row['password'];
        } else {
            $password = sha1($_POST['password']);
        }
        $id_user = isset($_GET['edit']) ? $_GET['edit'] : '';
        $update = mysqli_query($config,"UPDATE users SET name='$name', email='$email', password='$password' WHERE id='$id_user'");
        header("location:?page=user&ubah=berhasil");
    } 
}

?>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?php echo $ht; ?> User</h5>

                <form action="" method="post">
                    <div class="mb-3">
                        <label for="" class="form-label"> Fullname <span class="text-danger">*</span></label>
                        <input required type="text" name="name" placeholder="Enter your name" class="form-control" value="<?php echo isset($_GET['edit']) ? $row['name'] : ''; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label"> Email <span class="text-danger">*</span></label>
                        <input required type="email" name="email" placeholder="Enter your email" class="form-control" value="<?php echo isset($_GET['edit']) ? $row['email'] : ''; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label"> Password <span class="text-danger"><?php echo isset($_GET['edit']) ? '' : '*'; ?></span></label>
                        <input <?php echo isset($_GET['edit']) ? '' : 'selected'; ?> type="password" name="password" placeholder="Enter your password" class="form-control">
                        <?php echo isset( $_GET['edit']) ? 
                        "<small>
                            )* If you want to change your password, you can fill this field
                        </small>" : ''; ?>
                    </div>
                    <div class="mb-3">
                        <button type="submit" name="save" class="btn btn-success"><?php echo $ht; ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>