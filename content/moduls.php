<?php
    $id_user = isset($_SESSION['ID_USER']) ? $_SESSION['ID_USER'] : '';
    $id_role = isset($_SESSION['ID_ROLE']) ? $_SESSION['ID_ROLE'] : '';
    
    $rowStudent = mysqli_fetch_assoc(mysqli_query($config, "SELECT * FROM students WHERE id='$id_user'"));
    $id_major = $rowStudent['id_major'];
    // print_r($id_major);
    // die;
    if ($id_role == 6) {
        $where = "WHERE md.id_major='$id_major'";
    } elseif ($id_role == 2) {
        $where = "WHERE md.id_instructor='$id_user'";
    } else {
        $where = "";
    }
    $query = mysqli_query($config,"SELECT mj.name major, i.name instructor, md.*  FROM moduls md
    LEFT JOIN majors mj ON md.id_major = mj.id
    LEFT JOIN instructors i ON md.id_instructor = i.id
    $where
    ORDER BY md.id DESC");
    $rows = mysqli_fetch_all($query, MYSQLI_ASSOC);
?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Data Modul</h5>
                <?php if (canAddModul($id_role)) { ?>    
                    <div class="mb-3" align="right">
                        <a href="?page=tambah-modul" class="btn btn-primary">+</a>
                    </div>
                <?php } ?>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Title</th>
                                <th>Instructor</th>
                                <th>Major</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rows as $key => $data) { ?>   
                                <tr>
                                    <td><?php echo $key + 1; ?></td>
                                    <td><a href="?page=tambah-modul&detail=<?php echo $data['id']; ?>"><i class="bi bi-link"></i> <?php echo $data['name']; ?></a></td>
                                    <td><?php echo $data['instructor']; ?></td>
                                    <td><?php echo $data['major']; ?></td>
                                    <td>
                                        <?php if ($id_role == 1) { ?>
                                            <a href="?page=tambah-modul&edit=<?php echo $data['id']; ?>" class="btn btn-success">Edit</a>
                                            <a onclick="return confirm('Are you sure?')" href="?page=tambah-modul&delete=<?php echo $data['id'] ?>" class="btn btn-danger">Delete</a>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>