<?php
    $queryUsers = mysqli_query($config,"SELECT * FROM users WHERE deleted_at = 1 ORDER BY id DESC");
    $rowUsers = mysqli_fetch_all($queryUsers, MYSQLI_ASSOC);

    if (isset($_GET['restore'])) {
        $restore = $_GET['restore'];
        $qrestore = mysqli_query($config,"UPDATE users SET deleted_at = 0 WHERE id = $restore");
        if ($qrestore) {
            header("location:?page=restore-user&backup=success");
        }
    }

    if (isset($_GET['delete'])) {
        $delete = $_GET['delete'];
        $qremove = mysqli_query($config,"DELETE FROM users WHERE id = $delete");
        if ($qremove) {
            header("location:?page=restore-user&remove=success");
        }
    }
?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Data User</h5>
                <div class="mb-3" align="right">
                    <a href="?page=user" class="btn btn-secondary">Back</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Fullname</th>
                                <th>Email</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rowUsers as $key => $data) { ?>   
                                <tr>
                                    <td><?php echo $key + 1; ?></td>
                                    <td><?php echo $data['name']; ?></td>
                                    <td><?php echo $data['email']; ?></td>
                                    <td>
                                        <a href="?page=restore-user&restore=<?php echo $data['id']; ?>" class="btn btn-success">Restore</a>
                                        <a onclick="return confirm('Are you sure?')" href="?page=restore-user&delete=<?php echo $data['id'] ?>" class="btn btn-danger">Delete</a>
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