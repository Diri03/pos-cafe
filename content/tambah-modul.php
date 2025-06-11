<?php

if (isset($_GET['delete'])) {  
    $id_user = $_GET['delete'];

    $queryModulsDetails = mysqli_query($config, "SELECT file FROM moduls_details WHERE id_modul='$id'");
    $rowModulsdetails = mysqli_fetch_assoc($queryModulsDetails);
    unlink("uploads/" . $rowModulsdetails["file"]);
    $queryDelete = mysqli_query($config,"DELETE FROM moduls_details WHERE id_modul = '$id_user'");
    $queryDelete = mysqli_query($config,"DELETE FROM moduls WHERE id = '$id_user'");
    if ($queryDelete) {
        header('location:?page=moduls&hapus=berhasil');
    } else {
        header('location:?page=moduls&hapus=gagal');
    }
}


if (isset($_POST['save'])) {
    $id_instructor = $_POST['id_instructor'];
    $id_major = $_POST['id_major'];
    $name = $_POST['name'];
    $id_user = isset($_GET['edit']) ? $_GET['edit'] : '';
    $insert = mysqli_query($config,"INSERT INTO moduls (id_major, id_instructor, name) VALUES ('$id_major', '$id_instructor', '$name')");
    if ($insert) {
        $id_modul = mysqli_insert_id($config);
        foreach ($_FILES['file']['name'] as $key => $file) {
            
            if ($_FILES['file']['error'][$key] == 0) {
                $name = basename($_FILES['file']['name'][$key]);
                $filename = uniqid() . "-" . $name;
                $path = "uploads/";
                $targetPath = $path . $filename;

                if (move_uploaded_file($_FILES["file"]["tmp_name"][$key], $targetPath)) {
                    $insertModulDetail = mysqli_query($config,"INSERT INTO moduls_details (id_modul, file) VALUES ('$id_modul', '$filename')");
                }

            }
        }
        header("location:?page=moduls&tambah=berhasil");
    }
    header("location:?page=moduls&tambah=berhasil");
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

$id_modul = isset($_GET['detail']) ? $_GET['detail'] : '';
$queryModul = mysqli_query($config,"SELECT mj.name major, i.name instructor, md.*  FROM moduls md
    LEFT JOIN majors mj ON md.id_major = mj.id
    LEFT JOIN instructors i ON md.id_instructor = i.id WHERE md.id = '$id_modul'");
$rowModul = mysqli_fetch_assoc($queryModul);

$queryDetailModul = mysqli_query($config,"SELECT * FROM moduls_details WHERE id_modul = '$id_modul'");
$rowDetailModul = mysqli_fetch_all($queryDetailModul, MYSQLI_ASSOC);

if (isset($_GET['download'])) {
    $download = $_GET['download'];
    $filePath = "uploads/" . $download;

    if (file_exists($filePath)) {
        header("Content-Description: File Transfer");
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment; filename=" . basename($filePath));
        header("Expires:0");
        header("Cache-Control: -must-revalidate");
        header("Pragma:public");
        header("Content-Length:" . filesize($filePath));
        ob_clean();
        readfile($filePath);
        exit;
    }
}

?>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?php echo isset($_GET['detail']) ? 'Detail' : 'Add'; ?> Modul</h5>

                <?php if (isset($_GET['detail'])) { ?>
                    <table class="table table-stripped">
                        <tr>
                            <th>Modul Name</th>
                            <td>:</t>
                            <td><?php echo $rowModul['name']; ?></td>
                            <th>Major</th>
                            <td>:</td>
                            <td><?php echo $rowModul['major']; ?></td>
                        </tr>
                        <tr>
                            <th>Instructor Name</th>
                            <td>:</td>
                            <td><?php echo $rowModul['instructor']; ?></td>
                        </tr>
                    </table>
                    <br><br>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>File</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rowDetailModul as $key => $data) { ?>
                                <tr>
                                    <td><?php echo $key + 1; ?></td>
                                    <td><a target="_blank" href="?page=tambah-modul&download=<?php echo urlencode($data['file']); ?>"><?php echo $data['file']; ?> <i class="bi bi-download"></iclass></a></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                <?php } else {?>
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="" class="form-label"> Instructor <span class="text-danger">*</span></label>
                                    <input readonly type="text" class="form-control" value="<?php echo $_SESSION['NAME']; ?>">
                                    <input type="hidden" name="id_instructor" value="<?php echo $_SESSION['ID_USER']; ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label"> Modul Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" value="" placeholder="Enter Modul Name" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="" class="form-label"> Major <span class="text-danger">*</span></label>
                                    <select name="id_major" id="" class="form-control" required>
                                        <option value="">Select One</option>
                                        <?php foreach ($rowInstructorMajors as $key => $data) { ?>
                                            <option value="<?php echo $data['id_major']; ?>"><?php echo $data['major']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
    
                        <div class="mb-3" align="right">
                            <button type="button" class="btn btn-primary addRow" id="addRow">Add Row</button>
                        </div>
                        <table class="table" id="myTable">
                            <thead>
                                <tr>
                                    <th>File</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                        
                        <div class="mb-3">
                            <button type="submit" name="save" class="btn btn-success">Save</button>
                        </div>
                    </form>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<script>
    const button = document.querySelector('#addRow');
    const tbody = document.querySelector('#myTable tbody');

    button.addEventListener("click", function(){

        const tr = document.createElement('tr');
        tr.innerHTML = `
        <td><input type="file" class="form-control" name="file[]"></td>
        <td><button type="button" class="btn btn-danger" id="delRow">Delete</button></td>
        `;
        tbody.appendChild(tr);

    })
</script>