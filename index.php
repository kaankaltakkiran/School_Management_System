<?php
session_start();
$activeTitle = "School Management System";
$activePage = "index";
require 'up.html.php';
?>
<?php require 'navbar.php'?>
<div class="container">
  <div class="row justify-content-center mt-3 ">
 <div class="col-6">
<a href="login.php" class="btn btn-primary">Admin Login</a>
</div>
</div>
<!-- Eğer adamin giriş yaparsa aşaığıdaki kısımlar görünür(role=2) -->
<?php if ($_SESSION['role'] == 1) {?>
      <div class="container my-3 ">
      <div class="row justify-content-center">
          <div class="col-6">
          <h1 class="text-center text-danger mt-3">Welcome</h1>
          <h3 class="text-center text-muted">Admin: <?php echo $_SESSION['userName']; ?></h3>
          <h5 class="text-center text-danger fw-bold"><?php
date_default_timezone_set('Europe/Istanbul'); // Türkiye saat dilimine göre tarih ve saat ayarla
    $date_and_time = date("d-m-Y H:i:s"); // Yıl-Ay-Gün Saat:Dakika:Saniye formatında tarih ve saat
    echo "Date And Time: " . $date_and_time;
    ?>
</h5>
       </div>
        <div class="row justify-content-center g-4">
          <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="card h-100 " style="width: 18rem;">
              <img src="./public/img/admin.jpg" class="card-img-top" alt="Admin img">
              <div class="card-body">
                <h5 class="card-title">Add Admin User</h5>
                <p class="card-text">Admin Adds Admin User</p>
                <a href="add.admin.php" class="btn btn-danger mt-3">Add Admin
                <i class="bi bi-send-fill"></i>
                </a>
              </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3">
          <div class="card h-100 " style="width: 18rem;">
            <img src="./public/img/teacher.jpg" class="card-img-top" alt="Writer img">
            <div class="card-body">
              <h5 class="card-title">Add Teacher User</h5>
              <p class="card-text">Admin Adds Teacher User</p>
              <a href="add.teacher.php" class="btn btn-primary mt-3">Add Teacher User
              <i class="bi bi-send-fill"></i>
              </a>
            </div>
          </div>
      </div>
      <div class="col-sm-6 col-md-4 col-lg-3">
        <div class="card h-100 " style="width: 18rem;">
          <img src="./public/img/student.jpg" class="card-img-top" alt="Category img">
          <div class="card-body">
            <h5 class="card-title">Add Student User</h5>
            <p class="card-text">Admin Adds  Student User</p>
            <a href="add.category.php?idUser=<?php echo $users[0]['userid'] ?>" class="btn btn-success mt-3" style="">Add Student User
            <i class="bi bi-send-fill"></i></a>
          </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-4 col-lg-3">
        <div class="card h-100 " style="width: 18rem;">
          <img src="./public/img/office.jpg" class="card-img-top" alt="Category img">
          <div class="card-body">
            <h5 class="card-title">Add Register Unit</h5>
            <p class="card-text">Admin Adds  Add Register Unit</p>
            <a href="add.category.php?idUser=<?php echo $users[0]['userid'] ?>" class="btn btn-info mt-5" style="">Add Register Unit
            <i class="bi bi-send-fill"></i></a>
          </div>
        </div>
    </div>
          </div>
      </div>
      <?php }?>
</div>
<?php require 'down.html.php';?>
