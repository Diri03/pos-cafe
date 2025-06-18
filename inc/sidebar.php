<?php
  $id_user = $_SESSION['ID_USER'];
  $queryMainMenu = mysqli_query($config, "SELECT DISTINCT m.* FROM menus m
  JOIN menu_roles mr ON m.id = mr.id_menu
  JOIN user_roles ur ON ur.id_role = mr.id_role
  WHERE ur.id_user = '$id_user' 
  AND parent_id = 0 OR parent_id = '' ORDER BY urutan");
  $rowMainMenu = mysqli_fetch_all($queryMainMenu, MYSQLI_ASSOC);
?>

<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <?php foreach ($rowMainMenu as $mainMenu): ?>
        <?php
          $id_menu = $mainMenu["id"];
          $querySubMenu = mysqli_query($config, "SELECT DISTINCT m.* FROM menus m
          JOIN menu_roles mr ON m.id = mr.id_menu
          JOIN user_roles ur ON ur.id_role = mr.id_role
          WHERE ur.id_user = '$id_user' AND parent_id = '$id_menu' ORDER BY urutan");
        ?>
        <?php if (mysqli_num_rows($querySubMenu) > 0): ?>   
          <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#menu-<?php echo $mainMenu['id']; ?>" data-bs-toggle="collapse" href="#">
              <i class="<?php echo $mainMenu['icon']; ?>"></i><span><?php echo $mainMenu['name']; ?></span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="menu-<?php echo $mainMenu['id']; ?>" class="nav-content collapse " data-bs-parent="#sidebar-nav">
              <?php while($rowSubMenu = mysqli_fetch_assoc($querySubMenu)): ?>
                <li>
                  <a href="?page=<?php echo $rowSubMenu['url']; ?>">
                    <i class="<?php echo $rowSubMenu['icon']; ?>"></i><span><?php echo $rowSubMenu['name']; ?></span>
                  </a>
                </li>
              <?php endwhile ?>
            </ul>
          </li><!-- End Components Nav -->
          <!-- <li class="nav-heading">Transaction</li> -->
        <?php elseif (!empty($mainMenu['url'])):  ?>
          <?php $url = $mainMenu['url'];?>

          <li class="nav-item">
            <a class="nav-link collapsed" href="<?php echo strpos($mainMenu['url'], '.php') !== false ? $url : "?page=$url"; ?>">
              <i class="<?php echo $mainMenu['icon']; ?>"></i>
              <span><?php echo $mainMenu['name']; ?></span>
            </a>
          </li>
        <?php endif ?>
      <?php endforeach ?>


      <!-- <li class="nav-heading">Transaction</li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="?page=moduls">
          <i class="bi bi-book"></i>
          <span>Moduls</span>
        </a>
      </li> -->

    </ul>

  </aside><!-- End Sidebar-->