<?php
    $id_instructor = $_GET['id_instructor'];
    $queryInstructorMajors = mysqli_query($config,"SELECT m.name major, im.* FROM instructor_majors im
    LEFT JOIN majors m ON im.id_major = m.id
    WHERE id_instructor = {$id_instructor} ORDER BY im.id DESC");
    $rowInstructorMajors = mysqli_fetch_all($queryInstructorMajors, MYSQLI_ASSOC);

    $queryMajors = mysqli_query($config,"SELECT * FROM majors ORDER BY id DESC");
    $rowMajors = mysqli_fetch_all($queryMajors, MYSQLI_ASSOC);

    $queryInstructor = mysqli_query($config,"SELECT name FROM instructors WHERE id = {$id_instructor}");
    $rowInstructor = mysqli_fetch_assoc($queryInstructor);

    if (!empty($_POST['id_major'])) {
        $id_edit = isset($_GET["edit"]) ? $_GET["edit"] : "";
        if (isset($_GET['edit'])) {
            $update = mysqli_query($config,"UPDATE instructor_majors SET id_major='{$_POST['id_major']}', id_instructor='{$_GET['id_instructor']}' WHERE id='$id_edit'");
            header("location:?page=tambah-instructor-major&id_instructor={$_GET['id_instructor']}&ubah=berhasil");
        } else {      
            $insert = mysqli_query($config, "INSERT INTO instructor_majors (id_instructor, id_major) VALUES ('{$id_instructor}', '{$_POST['id_major']}')");
            header('location:?page=tambah-instructor-major&id_instructor=' . $id_instructor . '&tambah=berhasil');
        }

    }

    if (isset($_GET['delete'])) {  
        $id = $_GET['delete'];
        $queryDelete = mysqli_query($config,"DELETE FROM instructor_majors WHERE id = '$id'");
        if ($queryDelete) {
            header("location:?page=tambah-instructor-major&id_instructor={$id_instructor}&hapus=berhasil");
        } else {
            header("location:?page=tambah-instructor-major&id_instructor={$id_instructor}&hapus=gagal");
        }
    }


    if (isset($_GET["edit"])) {
        $id_edit = $_GET["edit"];
        $select = mysqli_query($config,"SELECT * FROM instructor_majors WHERE id='$id_edit'");
        $row = mysqli_fetch_array($select, MYSQLI_ASSOC);
    }

?>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <!-- start form edit -->
                <?php if (isset($_GET['edit'])) { ?>
                    <h5 class="card-title">Edit Instructor Major : <?php echo $rowInstructor['name']; ?></h5>
                    <form action="" method="post" class="mt-3">
                        <div class="mb-3">
                            <label for="" class="form-label">Major</label>
                            <select name="id_major" id="" class="form-control" required>
                                <option value="">Select One</option>
                                <?php foreach ($rowMajors as $major) { ?>
                                    <option <?php echo isset($_GET['edit']) ? ( $row['id_major'] == $major['id']) ? "selected" : "" : "" ?> value="<?php echo $major['id']; ?>"><?php echo $major['name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <button name="save" type="submit" class="btn btn-primary">Ubah</button>
                        </div>
                    </form>
                    <!-- end form edit -->
                <?php } else {?>

                    <!-- listing Table -->
                    <h5 class="card-title">Add Instructor Major : <?php echo $rowInstructor['name']; ?></h5>
                    <div class="mb-3" align="right">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            Add Major
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered datatable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Major</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($rowInstructorMajors as $key => $data) { ?> 
                                    <tr>
                                        <td><?php echo $key += 1; ?></td>
                                        <td><?php echo $data['major']; ?></td>
                                        <td>
                                            <a href="?page=tambah-instructor-major&id_instructor=<?php echo $_GET['id_instructor'] ?>&edit=<?php echo $data['id']; ?>" class="btn btn-success">Edit</a>
                                            <a onclick="return confirm('Are you sure?')" href="?page=tambah-instructor-major&id_instructor=<?php echo $_GET['id_instructor'] ?>&delete=<?php echo $data['id'] ?>" class="btn btn-danger">Delete</a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
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
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add New Instructor Major</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="" class="form-label"></label>
                        <select name="id_major" id="" class="form-control" required>
                            <option value="">Select One</option>
                            <?php foreach ($rowMajors as $major) { ?>
                                <option value="<?php echo $major['id']; ?>"><?php echo $major['name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>