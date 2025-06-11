<?php

if (isset($_GET['delete'])) {  
    $id_user = $_GET['delete'];
    $queryDelete = mysqli_query($config,"DELETE FROM instructors WHERE id = '$id_user'");
    if ($queryDelete) {
        header('location:?page=instructor&hapus=berhasil');
    } else {
        header('location:?page=instructor&hapus=gagal');
    }
}

if (!isset($_GET['edit'])) {
    $ht = "Add";
    if (isset($_POST['name'])) {
        $id_role = 2;
        $name = $_POST['name'];
        $gender = $_POST['gender'];
        $education = $_POST['education'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $password = sha1($_POST['password']);
        $address = $_POST['address'];
        $id_user = isset($_GET['edit']) ? $_GET['edit'] : '';
        $insert = mysqli_query($config,"INSERT INTO instructors (id_role, name, gender, education, phone, email, password, address) VALUES ('$id_role', '$name', '$gender', '$education', '$phone', '$email', '$password', '$address')");
        header("location:?page=instructor&tambah=berhasil");
    } 
    
} else {
    $ht = "Edit";
    $query = mysqli_query($config,"SELECT * FROM instructors WHERE id={$_GET['edit']}");
    $row = mysqli_fetch_assoc($query);
    if (isset($_POST['name'])) {
        $id_role = 2;
        $name = $_POST['name'];
        $gender = $_POST['gender'];
        $education = $_POST['education'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        if (empty($_POST['password'])) {
            $password = $row['password'];
        } else {
            $password = sha1($_POST['password']);
        }
        $address = $_POST['address'];
        $id_user = isset($_GET['edit']) ? $_GET['edit'] : '';
        $update = mysqli_query($config,"UPDATE instructors SET id_role='$id_role', name='$name', gender='$gender', education='$education', phone='$phone', email='$email', password='$password', address='$address' WHERE id='$id_user'");
        header("location:?page=instructor&ubah=berhasil");
    } 
}

?>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?php echo $ht; ?> Insturctor</h5>

                <form action="" method="post">
                    <div class="mb-3">
                        <label for="" class="form-label"> Fullname <span class="text-danger">*</span></label>
                        <input required type="text" name="name" placeholder="Enter your name" class="form-control" value="<?php echo isset($row['name']) ? $row['name'] : ''; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label"> Gender <span class="text-danger">*</span></label>
                        <select required name="gender" id="" class="form-control">
                            <option value="">-- Choose gender --</option>
                            <option <?php echo isset($_GET['edit']) ? ($row['gender'] == 0) ? 'selected' : '' : '' ?> value="0">Male</option>
                            <option <?php echo isset($_GET['edit']) ? ($row['gender'] == 1) ? 'selected' : '' : '' ?> value="1">Female</option>                 
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label"> Education <span class="text-danger">*</span></label>
                        <input required type="text" name="education" placeholder="Enter your education" class="form-control" value="<?php echo isset($_GET['edit']) ? $row['education'] : ''; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label"> Phone <span class="text-danger">*</span></label>
                        <input required type="text" name="phone" placeholder="Enter your phone" class="form-control" value="<?php echo isset($_GET['edit']) ? $row['phone'] : ''; ?>">
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
                        <label for="" class="form-label"> Address <span class="text-danger">*</span></label>
                        <textarea name="address" id="" cols="30" rows="10" class="form-control"><?php echo isset($_GET['edit']) ? $row['address'] : ''; ?></textarea>
                    </div>
                    <div class="mb-3">
                        <button type="submit" name="save" class="btn btn-success"><?php echo $ht; ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>