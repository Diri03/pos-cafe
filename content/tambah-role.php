<?php

if (isset($_GET['delete'])) {  
    $id_user = $_GET['delete'];
    $queryDelete = mysqli_query($config,"DELETE FROM roles WHERE id = '$id_user'");
    if ($queryDelete) {
        header('location:?page=role&hapus=berhasil');
    } else {
        header('location:?page=role&hapus=gagal');
    }
}

if (isset($_GET['add-role-menu'])) {
    $id_role = $_GET['add-role-menu'];

    $edit = [];
    $rowEditRoleMenu = [];
    $editRoleMenu = mysqli_query($config,"SELECT * FROM menu_roles WHERE id_role = '$id_role'");
    while ($editMenu = mysqli_fetch_assoc($editRoleMenu)) {
        $rowEditRoleMenu[] = $editMenu['id_menu'];
    }

    $menus = mysqli_query($config,"SELECT * FROM menus ORDER BY parent_id, urutan");
    $rowMenu = [];
    while ($m = mysqli_fetch_assoc($menus)) {
        $rowMenu[] = $m;
    }
}

if (!isset($_GET['edit'])) {
    $ht = "Add";
    if (isset($_POST['name'])) {
        $name = $_POST['name'];
        $id_user = isset($_GET['edit']) ? $_GET['edit'] : '';
        $insert = mysqli_query($config,"INSERT INTO roles (name) VALUES ('$name')");
        header("location:?page=role&tambah=berhasil");
    } 
    
} else {
    $ht = "Edit";
    $query = mysqli_query($config,"SELECT * FROM roles WHERE id={$_GET['edit']}");
    $row = mysqli_fetch_assoc($query);
    if (isset($_POST['name'])) {
        $name = $_POST['name'];
        $id_user = isset($_GET['edit']) ? $_GET['edit'] : '';
        $update = mysqli_query($config,"UPDATE roles SET name='$name' WHERE id='$id_user'");
        header("location:?page=role&ubah=berhasil");
    } 
}

if (isset($_POST['simpan'])) {
    $id_role = $_GET['add-role-menu'];
    $id_menus = $_POST['id_menus'] ?? [];

    mysqli_query($config,"DELETE FROM menu_roles WHERE id_role='$id_role'");
    foreach ($id_menus as $data) {
        $id_menu = $data;
        mysqli_query($config,"INSERT INTO menu_roles (id_role, id_menu) VALUES ('$id_role', '$id_menu')");

    }

    header("location:?page=tambah-role&add-role-menu=" . $id_role . "&tambah=berhasil");
}

?>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?php echo $ht; ?> Role</h5>
                <?php if (isset($_GET['add-role-menu'])) { ?>
                    <form action="" method="post">
                        <div class="mb-3">
                            <ul>
                                <?php foreach ($rowMenu as $mainMenu) { ?>
                                    <?php if ($mainMenu['parent_id'] == 0 || $mainMenu['parent_id'] == "") { ?>
                                        <li>
                                            <label for="" class="form-label">
                                                <input class="menu-check" <?php echo in_array($mainMenu['id'], $rowEditRoleMenu) ? 'checked' : ''; ?> type="checkbox" name="id_menus[]" value="<?php echo $mainMenu['id']; ?>">
                                                <?php echo $mainMenu['name']; ?>
                                            </label>
                                            <ul>
                                                <?php foreach ($rowMenu as $subMenu) { ?>
                                                    <?php if ($subMenu['parent_id'] == $mainMenu['id']) { ?>
                                                        <li>
                                                            <label for="" class="form-label">
                                                                <input class="menu-check" <?php echo in_array($subMenu['id'], $rowEditRoleMenu) ? 'checked' : ''; ?> type="checkbox" name="id_menus[]" value="<?php echo $subMenu['id']; ?>">
                                                                <?php echo $subMenu['name']; ?>
                                                            </label>
                                                        </li>
                                                    <?php } ?>
                                                <?php } ?>
                                            </ul>
                                        </li>
                                    <?php } ?>
                                <?php } ?>
                            </ul>

                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary" name="simpan">Save</button>
                        </div>
                    </form>
                <?php } else {?>
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="" class="form-label"> Role <span class="text-danger">*</span></label>
                            <input required type="text" name="name" placeholder="Enter your role" class="form-control" value="<?php echo isset($_GET['edit']) ? $row['name'] : ''; ?>">
                        </div>
                        <div class="mb-3">
                            <button type="submit" name="save" class="btn btn-success"><?php echo $ht; ?></button>
                        </div>
                    </form>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const checkboxes = document.querySelectorAll('input[type="checkbox"][name="id_menus[]"]');

    checkboxes.forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
            const li = checkbox.closest('li');
            if (!li) return;

            // === 1. Handle parent → children
            const childCheckboxes = li.querySelectorAll('ul input[type="checkbox"][name="id_menus[]"]');
            childCheckboxes.forEach(function (child) {
                child.checked = checkbox.checked;
            });

            // === 2. Handle children → parent
            updateParentCheckbox(li);
        });
    });

    function updateParentCheckbox(childLi) {
        const parentUl = childLi.parentElement.closest('ul');
        const parentLi = parentUl ? parentUl.closest('li') : null;

        if (!parentLi) return;

        const parentCheckbox = parentLi.querySelector('input[type="checkbox"][name="id_menus[]"]');

        if (!parentCheckbox) return;

        // Ambil semua anak dalam parent <ul>
        const allChildCheckboxes = parentLi.querySelectorAll('ul > li > label > input[type="checkbox"][name="id_menus[]"]');
        const anyChecked = Array.from(allChildCheckboxes).some(cb => cb.checked);
        const allUnchecked = Array.from(allChildCheckboxes).every(cb => !cb.checked);

        // Jika ada satu anak dicentang, parent harus dicentang
        if (anyChecked) {
            parentCheckbox.checked = true;
        }

        // Jika semua anak tidak dicentang, parent juga harus uncheck
        if (allUnchecked) {
            parentCheckbox.checked = false;
        }

        // Rekursif naik ke atas jika perlu
        updateParentCheckbox(parentLi);
    }
});
</script>