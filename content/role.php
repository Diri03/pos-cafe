<?php
    $queryRoles = mysqli_query($config,"SELECT * FROM roles ORDER BY id DESC");
    $rowRoles = mysqli_fetch_all($queryRoles, MYSQLI_ASSOC);
?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Data Roles</h5>
                <div class="mb-3" align="right">
                    <a href="?page=tambah-role" class="btn btn-primary">+</a>
                </div>
                <div class="table-responsive">
                    <table id="table" class="table table-bordered dataTables">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Role</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rowRoles as $key => $data) { ?>   
                                <tr>
                                    <td><?php echo $key + 1; ?></td>
                                    <td><?php echo $data['name']; ?></td>
                                    <td>
                                        <a href="?page=tambah-role&add-role-menu=<?php echo $data['id']; ?>" class="btn btn-primary">Role Menu</a>
                                        <a href="?page=tambah-role&edit=<?php echo $data['id']; ?>" class="btn btn-success">Edit</a>
                                        <a onclick="return confirm('Are you sure?')" href="?page=tambah-role&delete=<?php echo $data['id'] ?>" class="btn btn-danger">Delete</a>
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