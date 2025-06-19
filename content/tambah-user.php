<?php

$queryRole = mysqli_query($config, "SELECT * FROM roles ORDER BY id DESC");
$rowRoles = mysqli_fetch_all($queryRole, MYSQLI_ASSOC);

$id_user = isset($_GET['add-user-role']) ? $_GET['add-user-role'] : '';
$queryUserRole = mysqli_query($config, "SELECT roles.name as name_role, users.name as name_user, user_roles.* FROM user_roles
LEFT JOIN roles ON user_roles.id_role = roles.id
LEFT JOIN users ON user_roles.id_user = users.id 
WHERE id_user = '$id_user'
ORDER BY user_roles.id DESC");
$rowUserRoles = mysqli_fetch_all($queryUserRole, MYSQLI_ASSOC);

// print_r($rowUserRoles); die;

if (isset($_GET['delete'])) {  
    $id_user = $_GET['delete'];
    $queryDelete = mysqli_query($config,"DELETE FROM users WHERE id = '$id_user'");
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

if (isset($_POST['simpan'])) {
    $id_role = $_POST['id_role'];
    $id_user = $_GET['add-user-role'];
    mysqli_query($config,"INSERT INTO user_roles (id_user, id_role) VALUES ('$id_user', '$id_role')");
    header("location:?page=tambah-user&add-user-role=" . $id_user . "&done");
}

?>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <?php
                    if (isset($_GET['add-user-role'])) {
                        $title = 'Add User Role : ' . $rowUserRoles[0]['name_user'];
                    } elseif(isset($_GET['edit'])) {
                        $title = 'Edit User';
                    } else {
                        $title = 'Add User';
                    }
                ?>

                <h5 class="card-title"><?php echo $title; ?></h5>
                <?php if (isset($_GET['add-user-role'])) { ?>
                    <div class="table-responsive">
                        <div class="mb-3" align="right">
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                Add Role
                            </button>
                        </div>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Role Name</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($rowUserRoles as $key => $userRoles) { ?>
                                    <tr>
                                        <td><?php echo $key + 1; ?></td>
                                        <td><?php echo $userRoles['name_role']; ?></td>
                                        <td>
                                            <a href="" class="btn btn-success btn-sm">Edit</a>
                                            <a onclick="return alert('Are you Sure?')" href="" class="btn btn-danger btn-sm">Delete</a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                <?php } else { ?>
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
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add New Role</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="" class="form-label"></label>
                        <select name="id_role" id="" class="form-control" required>
                            <option value="">Select One</option>
                            <?php foreach ($rowRoles as $role) { ?>
                                <option value="<?php echo $role['id']; ?>"><?php echo $role['name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="simpan">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>