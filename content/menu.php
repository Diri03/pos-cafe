<?php
    $queryMenus = mysqli_query($config,"SELECT * FROM menus ORDER BY id DESC");
    $rowMenus = mysqli_fetch_all($queryMenus, MYSQLI_ASSOC);
?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Data Menus</h5>
                <div class="mb-3" align="right">
                    <a href="?page=tambah-menu" class="btn btn-primary">+</a>
                </div>
                <div class="table-responsive">
                    <table id="table" class="table table-bordered dataTables">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Parent Id</th>
                                <th>Icon</th>
                                <th>Url</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rowMenus as $key => $data) { ?>   
                                <tr>
                                    <td><?php echo $key + 1; ?></td>
                                    <td><?php echo $data['name']; ?></td>
                                    <td><?php echo $data['parent_id']; ?></td>
                                    <td><?php echo $data['icon']; ?></td>
                                    <td><?php echo $data['url']; ?></td>
                                    <td>
                                        <a href="?page=tambah-menu&edit=<?php echo $data['id']; ?>" class="btn btn-success">Edit</a>
                                        <a onclick="return confirm('Are you sure?')" href="?page=tambah-menu&delete=<?php echo $data['id'] ?>" class="btn btn-danger">Delete</a>
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