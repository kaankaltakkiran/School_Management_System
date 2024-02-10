<?php
@session_start();
?>
<nav class="navbar navbar-expand-lg bg-primary " data-bs-theme="dark">
  <div class="container-fluid ">
    <a class="navbar-brand " href="index.php">School Management System</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
    <ul class="navbar-nav">
    <?php if ($_SESSION['isLogin'] == 1 && $_SESSION['role'] == 1) {?>
    <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle <?=($activePage == 'add.admin' || $activePage == 'admin.list') ? 'active' : '';?>" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Admin
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item <?=($activePage == 'add.admin') ? 'active' : '';?>" href="add.admin.php">Add Admin User</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item <?=($activePage == 'admin.list') ? 'active' : '';?>" href="list.admin.php">List Admin User</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle <?=($activePage == 'register.unit.add' || $activePage == 'register.unit.list') ? 'active' : '';?>" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          Register Unit

          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item <?=($activePage == 'register.unit.add') ? 'active' : '';?>" href="add.register.unit.php">Add Register Unit
 User</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item <?=($activePage == 'register.unit.list') ? 'active' : '';?>" href="list.register.unit.php">List Register Unit
 User</a></li>
          </ul>
        </li>
        <?php }?>
    <?php if ($_SESSION['isLogin'] == 1 && $_SESSION['role'] == 2) {?>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle <?=($activePage == 'add.teacher' || $activePage == 'teacher.list') ? 'active' : '';?>" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Teacher
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item <?=($activePage == 'add.teacher') ? 'active' : '';?>" href="add.teacher.php">Add Teacher User</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item <?=($activePage == 'teacher.list') ? 'active' : '';?>" href="list.teacher.php">List Teacher User</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle <?=($activePage == 'add.student' || $activePage == 'student.list') ? 'active' : '';?>" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Student
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item <?=($activePage == 'add.student') ? 'active' : '';?>" href="add.student.php">Add Student User</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item <?=($activePage == 'student.list') ? 'active' : '';?>" href="list.student.php">List Student User</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle <?=($activePage == 'add.class' || $activePage == 'class.list') ? 'active' : '';?>" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Class
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item <?=($activePage == 'add.class') ? 'active' : '';?>" href="add.class.php">Add Class</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item <?=($activePage == 'class.list') ? 'active' : '';?>" href="list.class.php">List Class</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle <?=($activePage == 'add.lesson' || $activePage == 'lesson.list') ? 'active' : '';?>" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Lesson
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item <?=($activePage == 'add.lesson') ? 'active' : '';?>" href="add.lesson.php">Add Lesson</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item <?=($activePage == 'lesson.list') ? 'active' : '';?>" href="list.lessons.php">List Lesson</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle <?=($activePage == 'send.announcement' || $activePage == 'list.announcement') ? 'active' : '';?>" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          Announcement
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item <?=($activePage == 'send.announcement') ? 'active' : '';?>" href="add.announcement.php">Send  Announcement</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item <?=($activePage == 'list.announcement') ? 'active' : '';?>" href="list.announcement.php">List  Announcement</a></li>
          </ul>
        </li>
        <?php }?>
      </ul>
    </div>

    <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
      <ul class="navbar-nav">
      <?php if ($_SESSION['isLogin'] == 1) {?>
        <li class="nav-item">
          <a class="nav-link  <?=($activePage == 'index') ? 'active' : '';?>" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="logout.php">Logout</a>
        </li>
        <?php
require 'db.php';
    $imageFolder = '';
    if ($_SESSION['role'] == 1) {
        $SORGU = $DB->prepare("SELECT * FROM admins WHERE userid = :idUser");
        $imageFolder = 'admin_images';
    } else if ($_SESSION['role'] == 2) {
        $SORGU = $DB->prepare("SELECT * FROM registerunits WHERE userid = :idUser");
        $imageFolder = 'register_unit_images';
    } else if ($_SESSION['role'] == 3) {
        $SORGU = $DB->prepare("SELECT * FROM teachers WHERE userid = :idUser");
        $imageFolder = 'teacher_images';
    } else if ($_SESSION['role'] == 4) {
        $SORGU = $DB->prepare("SELECT * FROM students WHERE userid = :idUser");
        $imageFolder = 'student_images';
    }
    $SORGU->bindParam(':idUser', $_SESSION['id']);
    $SORGU->execute();
    $users = $SORGU->fetchAll(PDO::FETCH_ASSOC);
    $users = $users[0];
    ?>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">

          <img src='<?php echo "$imageFolder/{$users['userimg']}"; ?>' class='rounded-circle' height="30" width='30'>
          </a>
          <ul class="dropdown-menu  dropdown-menu-end">
            <li><a class="dropdown-item" href="#">Action</a></li>
            <li><a class="dropdown-item" href="#">Another action</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
          </ul>
        </li>
        <?php }?>
        <?php if ($_SESSION['isLogin'] == 0) {?>
        <li class="nav-item">
          <a class="nav-link  <?=($activePage == 'login') ? 'active' : '';?>" href="login.php">Login</a>
        </li>
          <?php }?>
      </ul>
    </div>
  </div>
</nav>
