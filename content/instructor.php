<?php
    $queryInstructor = mysqli_query($config,"SELECT * FROM instructors ORDER BY id DESC");
    $rowInstructor = mysqli_fetch_all($queryInstructor, MYSQLI_ASSOC);
?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Data Instructor</h5>
                <div class="mb-3" align="right">
                    <a href="?page=tambah-instructor" class="btn btn-primary">+</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Fullname</th>
                                <th>Gender</th>
                                <th>Education</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Address</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rowInstructor as $key => $data) { ?>   
                                <tr>
                                    <td><?php echo $key + 1; ?></td>
                                    <td><?php echo $data['name']; ?></td>
                                    <td><?php echo $data['gender'] == 0 ? 'Male' : 'Female'; ?></td>
                                    <td><?php echo $data['education']; ?></td>
                                    <td><?php echo $data['phone']; ?></td>
                                    <td><?php echo $data['email']; ?></td>
                                    <td><?php echo $data['address']; ?></td>
                                    <td>
                                        <a href="?page=tambah-instructor-major&id=<?php echo $data['id']; ?>" class="btn btn-warning">Add Major</a>
                                        <a href="?page=tambah-instructor&edit=<?php echo $data['id']; ?>" class="btn btn-success">Edit</a>
                                        <a onclick="return confirm('Are you sure?')" href="?page=tambah-instructor&delete=<?php echo $data['id'] ?>" class="btn btn-danger">Delete</a>
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