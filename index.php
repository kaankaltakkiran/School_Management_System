<?php
session_start();
$activeTitle = "School Management System";
$activePage = "index";
require 'up.html.php';
?>
<?php require 'navbar.php'?>
<div class="container">
  <div class="row justify-content-center mt-3">
</div>
<!-- Eğer adamin giriş yaparsa aşaığıdaki kısımlar görünür(role=2) -->
<?php if ($_SESSION['role'] == 1 || $_SESSION['role'] == 2) {?>
      <div class="container my-3 ">
      <div class="row justify-content-center">
          <div class="col-6">
          <h1 class="text-center text-danger mt-3">Welcome</h1>
          <h3 class="text-center text-muted">Admin: <?php echo $_SESSION['userName']; ?></h3>
          <h4 class="text-center text-danger fw-bold" id="clock">
</h4>
       </div>
        </div>
       <?php }?>
       <?php if ($_SESSION['role'] == 1) {?>
        <div class="row justify-content-center g-4">
          <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="card h-100 " style="width: 18rem;">
              <img src="./public/img/admin.jpg" class="card-img-top" alt="Admin img">
              <div class="card-body">
                <h5 class="card-title">Add Admin User</h5>
                <p class="card-text">Admin Adds Admin User</p>
                      <div class="d-flex justify-content-between">
          <a href="add.admin.php" class="btn me-2  btn-danger mt-5">Add Admin
            <i class="bi bi-send-fill"></i>
          </a>
          <a href="list.admin.php" class="btn btn-warning  mt-5">List Admin User
            <i class="bi bi-send-fill"></i>
          </a>
        </div>
              </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3">
        <div class="card h-100 " style="width: 18rem;">
          <img src="./public/img/office.jpg" class="card-img-top" alt="Register Unit img">
          <div class="card-body">
            <h5 class="card-title">Add Register Unit</h5>
            <p class="card-text">Register Unit Adds  Add Register Unit</p>
            <div class="d-flex justify-content-between">
          <a href="add.register.unit.php" class="btn me-2  btn-danger mt-5">Add Register Unit
            <i class="bi bi-send-fill"></i>
          </a>
          <a href="list.register.unit.php" class="btn btn-warning  mt-5">List Register Unit
            <i class="bi bi-send-fill"></i>
          </a>
        </div>
          </div>
        </div>
    </div>
        </div>
        <?php }?>
        <?php if ($_SESSION['role'] == 2) {?>
          <div class="row justify-content-center g-4">
        <div class="col-sm-6 col-md-4 col-lg-3">
          <div class="card h-100 " style="width: 18rem;">
            <img src="./public/img/teacher.jpg" class="card-img-top" alt="Teacher img">
            <div class="card-body">
              <h5 class="card-title">Add Teacher User</h5>
              <p class="card-text">Register Unit Adds Teacher User</p>
              <div class="d-flex justify-content-between">
          <a href="add.teacher.php" class="btn me-2  btn-danger mt-5">Add Teacher User
            <i class="bi bi-send-fill"></i>
          </a>
          <a href="list.teacher.php" class="btn btn-warning  mt-5">List Teacher User
            <i class="bi bi-send-fill"></i>
          </a>
        </div>
            </div>
          </div>
      </div>
      <div class="col-sm-6 col-md-4 col-lg-3">
        <div class="card h-100 " style="width: 18rem;">
          <img src="./public/img/student.jpg" class="card-img-top" alt="Student img">
          <div class="card-body">
            <h5 class="card-title">Add Student User</h5>
            <p class="card-text">Register Unit Adds  Student User</p>
            <div class="d-flex justify-content-between">
          <a href="add.student.php" class="btn me-2  btn-danger mt-5">Add Student User
            <i class="bi bi-send-fill"></i>
          </a>
          <a href="list.student.php" class="btn btn-warning  mt-5">List Student User
            <i class="bi bi-send-fill"></i>
          </a>
        </div>
          </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-4 col-lg-3">
          <div class="card h-100 " style="width: 18rem;">
            <img src="./public/img/teacher.jpg" class="card-img-top" alt="Class img">
            <div class="card-body">
              <h5 class="card-title">Add Class</h5>
              <p class="card-text">Register Unit Adds Class</p>
              <div class="d-flex justify-content-between">
          <a href="add.class.php" class="btn me-2  btn-danger mt-5">Add Class
            <i class="bi bi-send-fill"></i>
          </a>
          <a href="list.class.php" class="btn btn-warning mt-5">List Class
            <i class="bi bi-send-fill"></i>
          </a>
        </div>
            </div>
          </div>
      </div>
      <div class="col-sm-6 col-md-4 col-lg-3">
          <div class="card h-100 " style="width: 18rem;">
            <img src="./public/img/books.jpg" class="card-img-top" alt="lesson img">
            <div class="card-body">
              <h5 class="card-title">Add lesson</h5>
              <p class="card-text">Register Unit Adds lesson</p>
              <div class="d-flex justify-content-between">
          <a href="add.lesson.php" class="btn me-2  btn-danger mt-5">Add lesson
            <i class="bi bi-send-fill"></i>
          </a>
          <a href="list.lessons.php" class="btn btn-warning mt-5">List lesson
            <i class="bi bi-send-fill"></i>
          </a>
        </div>
            </div>
          </div>
      </div>
      </div>
      <div class="row mt-3">
      <div class="col-sm-6 col-md-4 col-lg-3">
          <div class="card h-100 " style="width: 18rem;">
            <img src="./public/img/announcement.jpg" class="card-img-top" alt="announcement img">
            <div class="card-body">
              <h5 class="card-title">Send Announcement</h5>
              <p class="card-text">Register Unit Send Announcement</p>
              <div class="d-flex justify-content-between">
          <a href="add.announcement.php" class="btn btn-sm me-2  btn-danger mt-5">Send Announcement
            <i class="bi bi-send-fill"></i>
          </a>
          <a href="list.announcement.php" class="btn btn-sm btn-warning mt-5">List Announcement
            <i class="bi bi-send-fill"></i>
          </a>
        </div>
            </div>
          </div>
      </div>
      </div>
      <?php }?>
</div>
<?php require 'down.html.php';?>
