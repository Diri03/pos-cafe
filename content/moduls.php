<?php
    $query = mysqli_query($config,"SELECT mj.name major, i.name instructor, md.*  FROM moduls md
    LEFT JOIN majors mj ON md.id_major = mj.id
    LEFT JOIN instructors i ON md.id_instructor = i.id
    ORDER BY id DESC");
    $rows = mysqli_fetch_all($query, MYSQLI_ASSOC);
?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Data Modul</h5>
                <div class="mb-3" align="right">
                    <a href="?page=tambah-modul" class="btn btn-primary">+</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Instructor</th>
                                <th>Major</th>
                                <th>Title</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rows as $key => $data) { ?>   
                                <tr>
                                    <td><?php echo $key + 1; ?></td>
                                    <td><?php echo $data['instructor']; ?></td>
                                    <td><?php echo $data['major']; ?></td>
                                    <td><?php echo $data['name']; ?></td>
                                    <td>
                                        <a href="?page=tambah-modul&edit=<?php echo $data['id']; ?>" class="btn btn-success">Edit</a>
                                        <a onclick="return confirm('Are you sure?')" href="?page=tambah-modul&delete=<?php echo $data['id'] ?>" class="btn btn-danger">Delete</a>
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