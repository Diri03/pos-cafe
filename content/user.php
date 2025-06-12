<?php
    $queryUsers = mysqli_query($config,"SELECT * FROM users WHERE deleted_at = 0 ORDER BY id DESC");
    $rowUsers = mysqli_fetch_all($queryUsers, MYSQLI_ASSOC);
?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Data User</h5>
                <div class="mb-3 d-flex justify-content-between">
                    <a href="?page=tambah-user" class="btn btn-primary">Add</a>
                    <a href="?page=restore-user" class="btn btn-secondary">Restore</a>
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
                                        <a href="?page=tambah-user&edit=<?php echo $data['id']; ?>" class="btn btn-success">Edit</a>
                                        <a onclick="return confirm('Are you sure?')" href="?page=tambah-user&delete=<?php echo $data['id'] ?>" class="btn btn-danger">Delete</a>
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