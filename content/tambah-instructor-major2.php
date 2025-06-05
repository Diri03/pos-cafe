<?php
$id = isset($_GET['id']) ? $_GET['id'] : '';

if (isset($_POST['id_major'])) {
    $id_major = $_POST['id_major'];

    $insert = mysqli_query($config,"INSERT INTO instructor_majors (id_major, id_instructor) VALUES ('$id_major', '$id')");
    header("location:?page=tambah-instructor-major&id=" . $id . "&tambah=berhasil");
}

$queryMajors = mysqli_query($config,"SELECT * FROM majors ORDER BY id DESC");
$rowMajors = mysqli_fetch_all($queryMajors, MYSQLI_ASSOC);

$queryInstructors = mysqli_query($config,"SELECT * FROM instructors WHERE id='$id'");
$rowInstructors = mysqli_fetch_assoc($queryInstructors);

$queryInstructorsMajor = mysqli_query($config,"SELECT instructor_majors.id, majors.name, id_instructor FROM instructor_majors LEFT JOIN majors ON majors.id = instructor_majors.id_major WHERE id_instructor='$id' ORDER BY instructor_majors.id DESC");
$rowInstructorsMajor = mysqli_fetch_all($queryInstructorsMajor, MYSQLI_ASSOC);

if (isset($_GET['delete'])) {  
    $id= $_GET['delete'];
    $id_instructor = $_GET['id_instructor'];

    $queryDelete = mysqli_query($config,"DELETE FROM instructor_majors WHERE id = '$id'");
    if ($queryDelete) {
        header("location:?page=tambah-instructor-major&id=" . $id_instructor . "&hapus=berhasil");
    } else {
        header("location:?page=tambah-instructor-major&id=" . $id_instructor . "&hapus=berhasil");
    }
}

?>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <!-- start form edit -->
                
                <!-- end form edit -->

                <!-- listing Table -->
                <h5 class="card-title">Edit Insturctor Major : <?php echo $rowInstructors['name']; ?></h5>
                <div align="right">
                    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Add Instructor Major
                    </button>
                </div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Major Name</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rowInstructorsMajor as $key => $data) : ?>
                            <tr>
                                <td><?php echo $key + 1 ?></td>
                                <td><?php echo $data['name']; ?></td>
                                <td>
                                    <a href="?page=tambah-instructor-major&id=<?php echo $data['id_instructor'] ?>&edit=<?php echo $data['id']; ?>" class="btn btn-success">Edit</a>
                                    <a onclick="return confirm('Are you sure?')" href="?page=tambah-instructor-major&delete=<?php echo $data['id'] ?> &id_instructor=<?php echo $data['id_instructor'] ?>" class="btn btn-danger">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Button trigger modal -->


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
                <select name="id_major" id="" class="form-control">
                    <option value="">Select One</option>
                    <?php foreach ($rowMajors as $key => $data) { ?>
                        <option value="<?php echo $data['id']; ?>"><?php echo $data['name']; ?></option>
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