<?php

if (isset($_GET['delete'])) {  
    $id_user = $_GET['delete'];
    $queryDelete = mysqli_query($config,"DELETE FROM menus WHERE id = '$id_user'");
    if ($queryDelete) {
        header('location:?page=menu&hapus=berhasil');
    } else {
        header('location:?page=menu&hapus=gagal');
    }
}

if (!isset($_GET['edit'])) {
    $ht = "Add";
    if (isset($_POST['name'])) {
        $name = $_POST['name'];
        $parent_id = $_POST['parent_id'];
        $icon = $_POST['icon'];
        $url = $_POST['url'];
        $urutan = $_POST['urutan'];
        $id_user = isset($_GET['edit']) ? $_GET['edit'] : '';
        $insert = mysqli_query($config,"INSERT INTO menus (name, parent_id, icon, url, urutan) VALUES ('$name', '$parent_id', '$icon', '$url', '$urutan')");
        header("location:?page=menu&tambah=berhasil");
    } 
    
} else {
    $ht = "Edit";
    $query = mysqli_query($config,"SELECT * FROM menus WHERE id={$_GET['edit']}");
    $row = mysqli_fetch_assoc($query);
    if (isset($_POST['name'])) {
        $name = $_POST['name'];
        $parent_id = $_POST['parent_id'];
        $icon = $_POST['icon'];
        $url = $_POST['url'];
        $urutan = $_POST['urutan'];
        $id_user = isset($_GET['edit']) ? $_GET['edit'] : '';
        $update = mysqli_query($config,"UPDATE menus SET name='$name', parent_id='$parent_id', icon='$icon', url='$url', urutan='$urutan'  WHERE id='$id_user'");
        header("location:?page=menu&ubah=berhasil");
    } 
}

$queryParentId = mysqli_query($config,"SELECT * FROM menus WHERE parent_id = 0 OR parent_id=''");
$rowParentId = mysqli_fetch_all($queryParentId, MYSQLI_ASSOC);

?>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?php echo $ht; ?> Role</h5>
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="" class="form-label"> Name <span class="text-danger">*</span></label>
                        <input required type="text" name="name" placeholder="Enter your menu" class="form-control" value="<?php echo isset($_GET['edit']) ? $row['name'] : ''; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label"> Parent Id </label>
                        <select name="parent_id" id="" class="form-control">
                            <option value="">Select One</option>
                            <?php foreach ($rowParentId as $key => $data) { ?>
                                <option value="<?php echo $data['id']; ?>"><?php echo $data['name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label"> Icon <span class="text-danger">*</span></label>
                        <input required type="text" name="icon" placeholder="Enter your icon" class="form-control" value="<?php echo isset($_GET['edit']) ? $row['icon'] : ''; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label"> Url </label>
                        <input type="text" name="url" placeholder="Enter your url" class="form-control" value="<?php echo isset($_GET['edit']) ? $row['url'] : ''; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label"> Order </label>
                        <input type="number" name="urutan" placeholder="Enter your order" class="form-control" value="<?php echo isset($_GET['edit']) ? $row['urutan'] : ''; ?>">
                    </div>
                    <div class="mb-3">
                        <button type="submit" name="save" class="btn btn-success"><?php echo $ht; ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>