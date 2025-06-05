<?php

if (isset($_GET['delete'])) {  
    $id_user = $_GET['delete'];
    $queryDelete = mysqli_query($config,"DELETE FROM moduls WHERE id = '$id_user'");
    if ($queryDelete) {
        header('location:?page=moduls&hapus=berhasil');
    } else {
        header('location:?page=moduls&hapus=gagal');
    }
}

if (!isset($_GET['edit'])) {
    $ht = "Save";
    if (isset($_POST['name'])) {
        $name = $_POST['name'];
        $id_user = isset($_GET['edit']) ? $_GET['edit'] : '';
        $insert = mysqli_query($config,"INSERT INTO moduls (name) VALUES ('$name')");
        header("location:?page=moduls&tambah=berhasil");
    } 
    
} else {
    $ht = "Edit";
    $query = mysqli_query($config,"SELECT * FROM moduls WHERE id={$_GET['edit']}");
    $row = mysqli_fetch_assoc($query);
    if (isset($_POST['name'])) {
        $name = $_POST['name'];
        $id_user = isset($_GET['edit']) ? $_GET['edit'] : '';
        $update = mysqli_query($config,"UPDATE moduls SET name='$name' WHERE id='$id_user'");
        header("location:?page=moduls&ubah=berhasil");
    } 
}

// $query = mysqli_query($config,"SELECT mj.name major, i.name instructor, md.*  FROM moduls md
// LEFT JOIN majors mj ON md.id_major = mj.id
// LEFT JOIN instructors i ON md.id_instructor = i.id
// ORDER BY id DESC");
// $rows = mysqli_fetch_all($query, MYSQLI_ASSOC);

$id_instructor = $_SESSION['ID_USER'];
$queryInstructorMajors = mysqli_query($config,"SELECT m.name major, im.* FROM instructor_majors im
LEFT JOIN majors m ON im.id_major = m.id
WHERE im.id_instructor = '$id_instructor'
ORDER BY im.id DESC");
$rowInstructorMajors = mysqli_fetch_all($queryInstructorMajors, MYSQLI_ASSOC);

?>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?php echo $ht; ?> Modul</h5>
                <form action="" method="post">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="" class="form-label"> Instructor <span class="text-danger">*</span></label>
                                <input readonly type="text" class="form-control" value="<?php echo $_SESSION['NAME']; ?>">
                                <input type="hidden" name="id_instructor" value="<?php echo $_SESSION['ID_USER']; ?>">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="" class="form-label"> Major <span class="text-danger">*</span></label>
                                <select name="id_major" id="" class="form-control">
                                    <option value="">Select One</option>
                                    <?php foreach ($rowInstructorMajors as $key => $data) { ?>
                                        <option value="<?php echo $data['id_major']; ?>"><?php echo $data['major']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <button type="submit" name="save" class="btn btn-success"><?php echo $ht; ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>