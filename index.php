<?php
@session_start();
$activeTitle = "School Management System";
$activePage = "index";
require 'up.html.php';
?>
<?php require 'navbar.php'?>
<!-- Siteye son giriş zamanını göstermek ve güncellemek için giriş yapan kullanıcın rolüne göre o tabloyu çağırıyoruz. -->
<?php if ($_SESSION['isLogin'] == 1) {?>
<?php
require_once 'db.php';
    $rol = $_SESSION['role'];
    $userid = $_SESSION['id'];
    //!Welcome mesajındaki Kullanıcı tipini belirlemek için
    $loginUserType = "";
//! user rol 1 ise admins tablosundan sorgula
    if ($rol == 1) {
        $sql = "SELECT * FROM admins  WHERE userid = :iduser";
        $loginUserType = "Admin";
        //! user rol 2 ise registerunits tablosundan sorgula
    } else if ($rol == 2) {
        $sql = "SELECT * FROM registerunits WHERE userid = :iduser";
        $loginUserType = "Register Unit";
        //! user rol 3 ise teachers tablosundan sorgula
    } else if ($rol == 3) {
        $sql = "SELECT * FROM teachers WHERE userid = :iduser";
        $loginUserType = "Teacher";
        //! user rol 4 ise students tablosundan sorgula
    } else if ($rol == 4) {
        $sql = "SELECT * FROM students WHERE userid = :iduser";
        $loginUserType = "Student";

    } else if ($rol == 5) {
        $sql = "SELECT * FROM parents WHERE userid = :iduser";
        $loginUserType = "Parent";

    }
    $SORGU = $DB->prepare($sql);
    $SORGU->bindParam(':iduser', $userid);
    $SORGU->execute();
    $users = $SORGU->fetchAll(PDO::FETCH_ASSOC);
/* echo '<pre>';
print_r($users);
die(); */
//!Kullanıcı son login zamanı
    $usersLastLoginTime = $users[0]['lastlogintime'];
//!Kullanıcı id
    $userId = $users[0]['userid'];
    $loginUserType
    ?>

<div class="container">
    <div class="container my-3 ">
        <div class="row justify-content-center">
            <div class="col-6">
                <h1 class="text-center text-danger mt-3">Welcome</h1>
                <h3 class="text-center text-muted"><?php echo $loginUserType ?>: <?php echo $_SESSION['userName']; ?></h3>
                <h4 class="text-center text-danger fw-bold" id="clock">
                    <?php
//! Veritabanından alınan datetime değerini güncelle
    //! user rol 1 ise admins tablosunu güncelle
    if ($rol == 1) {
        $DB->prepare("UPDATE admins SET lastlogintime = NOW() WHERE userid = :iduser")->execute(['iduser' => $userid]);
        //! user rol 2 ise registerunits tablosunu güncelle
    } else if ($rol == 2) {
        $DB->prepare("UPDATE registerunits SET lastlogintime = NOW() WHERE userid = :iduser")->execute(['iduser' => $userid]);
        //! user rol 3 ise teachers tablosunu güncelle
    } else if ($rol == 3) {
        $DB->prepare("UPDATE teachers SET lastlogintime = NOW() WHERE userid = :iduser")->execute(['iduser' => $userid]);
        //! user rol 4 ise students tablosunu güncelle
    } else if ($rol == 4) {
        $DB->prepare("UPDATE students SET lastlogintime = NOW() WHERE userid = :iduser")->execute(['iduser' => $userid]);

    }

    // Sistem saat dilimini belirle
    date_default_timezone_set('Europe/Istanbul');
    // Veritabanından alınan datetime değeri
    $veritabaniDatetime = $usersLastLoginTime;

    // Şu anki datetime
    $suAnkiDatetime = new DateTime();

    // Veritabanından alınan datetime'ı DateTime nesnesine dönüştür
    $veritabaniDatetimeObj = new DateTime($veritabaniDatetime);

    // İki datetime arasındaki farkı hesapla
    $zamanFarki = $suAnkiDatetime->diff($veritabaniDatetimeObj);

    if ($_SESSION['id'] == $userId) {
        echo "<h5 class='text-primary text-center fw-bold'>";
        // Eğer zaman farkı 365 günü aşıyorsa yıl, gün ve saat olarak ekrana yazdır
        if ($zamanFarki->i < 1) {
            echo " Last Login Time: " . "was active just now";
        } else {
            if ($zamanFarki->days > 365) {
                echo "Last Login Time: " . $zamanFarki->format('%y year, %d day, %h hour');
            } elseif ($zamanFarki->days > 0 || $zamanFarki->h > 24) {
                echo "Last Login Time: " . $zamanFarki->format('%d day, %h hour');
            } else {
                if ($zamanFarki->h >= 1) {
                    echo "Last Login Time: " . $zamanFarki->format('%h hour, %i minute');
                } else {
                    echo "Last Login Time: " . $zamanFarki->format('%i minute');
                }
            }
        }
        echo "</h5>";
    }
    ?>
                </h4>
            </div>
        </div>
    <?php }?>
<?php if ($_SESSION['isLogin'] == 1 && $_SESSION['role'] == 2) {?>
  <?php
require_once 'db.php';
//!Ekleyen kayıt birimine göre çağırma
    $id = $_SESSION['addedid'];
    //!Giriş yapan kayıt birimine göre
    $unitid = $_SESSION['id'];
    if ($_SESSION['role'] == 2) {
        $sql = "SELECT * FROM informations WHERE addedunitid=:unitid";
    } else {
        $sql = "SELECT * FROM informations WHERE addedunitid=:addedid";
    }
    $SORGU = $DB->prepare($sql);
    // Parametreleri bağlayın
    if ($_SESSION['role'] == 2) {
        $SORGU->bindParam(':unitid', $unitid);
    } else {
        $SORGU->bindParam(':addedid', $id);
    }
    $SORGU->execute();
    $informations = $SORGU->fetchAll(PDO::FETCH_ASSOC);
/* echo '<pre>';
print_r($informations);
die(); */
    ?>
  <div class="row justify-content-center mt-3 text-center  ">
  <div class="col-6 ">
    <h1 class="alert alert-info text-center">Welcome <?php echo $informations[0]['schoolname'] ?></h1>
    <h2 class="text-center"><?php echo $informations[0]['schoolname'] ?>, was founded in <?php echo $informations[0]['schoolyear'] ?>.</h2>
    <h3><span class="text-danger">Active Term:</span> <span> <?php echo $informations[0]['schoolterm'] ?>.</span></h3>
    <h4><span class="text-danger">School About Summary:</span> <span> <?php echo $informations[0]['schoolsummary'] ?></span></h4>
  </div>
  <?php require 'info.graphic.php';?>
  </div>
  <?php }?>
  <div class="row justify-content-center">
<div class="row row-cols-1 row-cols-md-5 g-4 mt-4 ">
<?php if ($_SESSION['isLogin'] == 1 && $_SESSION['role'] == 3) {?>
  <a href="list.teacher.class.php" class="col btn btn-secondary m-2 py-3">
               <img width="48" height="48" src="https://img.icons8.com/officel/48/class.png" alt="class"/>
                 <br>
                  Class
               </a>
               <a href="add.exam.php" class="col btn btn-primary m-2 py-3">
               <img width="48" height="48" src="https://img.icons8.com/external-vitaliy-gorbachev-lineal-vitaly-gorbachev/48/external-exam-online-learning-vitaliy-gorbachev-lineal-vitaly-gorbachev.png" alt="external-exam-online-learning-vitaliy-gorbachev-lineal-vitaly-gorbachev"/>
 <br>
Add Exam
</a>
               <a href="list.exam.php" class="col btn btn-success m-2 py-3">
 <img width="48" height="48" src="https://img.icons8.com/ios/48/exam.png" alt="exam"/>
 <br>
Exams List
</a>
<a href="teacher.exam.result.php" class="col btn btn-info m-2 py-3">
<img width="48" height="48" src="https://img.icons8.com/external-dashed-line-kawalan-studio/48/external-exam-result-education-dashed-line-kawalan-studio.png" alt="external-exam-result-education-dashed-line-kawalan-studio"/>
 <br>
Exams Result
</a>
<a href="list.parent.php" class="col btn btn-dark m-2 py-3">
<img width="48" height="48" src="https://img.icons8.com/color/48/family.png" alt="family"/>
                 <br>
                 Parent
               </a>
               <a href="list.announcement.php" class="col btn btn-warning m-2 py-3">
               <img width="48" height="48" src="https://img.icons8.com/color/48/commercial.png" alt="commercial"/>
                 <br>
                 Announcement
               </a>
               <a href="list.food.php" class="col btn btn-danger m-2 py-3">
               <img width="48" height="48" src="https://img.icons8.com/external-vectorslab-flat-vectorslab/48/external-Food-Menu-food-and-drink-vectorslab-flat-vectorslab.png" alt="external-Food-Menu-food-and-drink-vectorslab-flat-vectorslab"/>
                 <br>
                 Food Menu
               </a>
               <?php }?>
               <?php if ($_SESSION['isLogin'] == 1 && $_SESSION['role'] == 1) {?>
<a href="list.admin.php" class="col btn btn-danger  m-2 py-3">
<img width="48" height="48" src="https://img.icons8.com/color/48/admin-settings-male.png" alt="admin-settings-male"/>
<br>
                  Admin
               </a>
               <a href="list.register.unit.php" class="col btn btn-primary  m-2 py-3">
               <img width="48" height="48" src="https://img.icons8.com/doodle/48/conference-call.png" alt="conference-call"/>
                 <br>
                 Register Unit
               </a>
               <?php }?>
               <?php if ($_SESSION['isLogin'] == 1 && $_SESSION['role'] == 2) {?>
  <a href="list.teacher.php" class="col btn btn-secondary  m-2 py-3">
  <img width="48" height="48" src="https://img.icons8.com/color/48/teacher.png" alt="teacher"/>
  <br>
                Teacher
               </a>
               <a href="list.student.php" class="col btn btn-success  m-2 py-3">
               <img width="48" height="48" src="https://img.icons8.com/emoji/48/man-student.png" alt="man-student"/><br>
                  Student
               </a>
               <a href="list.class.php" class="col btn btn-secondary m-2 py-3">
               <img width="48" height="48" src="https://img.icons8.com/officel/48/class.png" alt="class"/>
                 <br>
                  Class
               </a>
               <a href="list.lessons.php" class="col btn btn-info  m-2 py-3">
               <img width="48" height="48" src="https://img.icons8.com/plasticine/48/book.png" alt="book"/>
                 <br>
                  Lesson
               </a>
               </div>
               <div class="row row-cols-1 row-cols-md-5 g-4 mt-4">
               <a href="list.parent.php" class="col btn btn-dark m-2 py-3">
<img width="48" height="48" src="https://img.icons8.com/color/48/family.png" alt="family"/>
                 <br>
                 Parent
               </a>
               <a href="list.announcement.php" class="col btn btn-warning m-2 py-3">
               <img width="48" height="48" src="https://img.icons8.com/color/48/commercial.png" alt="commercial"/>
                 <br>
                 Announcement
               </a>
               <a href="list.information.php" class="col btn btn-dark m-2 py-3">
               <img src="./public/img/icons8-information.gif" alt="icon">
                 <br>
                  School İnformation
               </a>
               <a href="list.food.php" class="col btn btn-danger m-2 py-3">
               <img width="48" height="48" src="https://img.icons8.com/external-vectorslab-flat-vectorslab/48/external-Food-Menu-food-and-drink-vectorslab-flat-vectorslab.png" alt="external-Food-Menu-food-and-drink-vectorslab-flat-vectorslab"/>
                 <br>
                 Food Menu
               </a>

                       <?php }?>
                       </div>
                       </div>
                       <div class="row justify-content-center">
                       <?php if ($_SESSION['isLogin'] == 0) {?>
                        <div class="row justify-content-center ">
                        <div class="col-6">
                        <h1 class=" alert alert-info text-center mt-3"> Welcome School Management System</h1>
                        </div>
                        </div>
                        <div class="d-grid col-4">
                        <a href="login.php" class="btn btn-primary  m-5 py-3">
<img width="48" height="48" src="./public/img/login.gif" alt="Login Gif"/>
<br>
              Login
               </a>
               </div>
               <?php }?>
               </div>
                       <div class="row justify-content-center">
<div class="row row-cols-1 row-cols-md-5 g-4 mt-4 ">
  <?php
require 'db.php';
$id = $_SESSION['id'];
$sql = "SELECT * FROM results WHERE  userid=:id";
$SORGU = $DB->prepare($sql);
$SORGU->bindParam(':id', $id);
$SORGU->execute();
$results = $SORGU->fetchAll(PDO::FETCH_ASSOC);
/* echo '<pre>';
print_r($results);
die(); */
?>
 <?php if ($_SESSION['isLogin'] == 1 && $_SESSION['role'] == 4) {?>
 <a href="list.student.exams.php" class="col btn btn-warning m-2 py-3">
 <img width="48" height="48" src="https://img.icons8.com/ios/48/exam.png" alt="exam"/>
 <br>
Exams List
</a>
<?php if (count($results) > 0) {
    echo '<a href="show.exam.result.php?userid=' . $results[0]['userid'] . '" class="col btn btn-info m-2 py-3">
<img width="50" height="50" src="https://img.icons8.com/ios/50/report-card.png" alt="report-card"/>
 <br>
Exams Result
</a>';
}
    ?>
      <a href="list.announcement.php" class="col btn btn-warning m-2 py-3">
               <img width="48" height="48" src="https://img.icons8.com/color/48/commercial.png" alt="commercial"/>
                 <br>
                 Announcement
               </a>
               <a href="list.food.php" class="col btn btn-danger m-2 py-3">
               <img width="48" height="48" src="https://img.icons8.com/external-vectorslab-flat-vectorslab/48/external-Food-Menu-food-and-drink-vectorslab-flat-vectorslab.png" alt="external-Food-Menu-food-and-drink-vectorslab-flat-vectorslab"/>
                 <br>
                 Food Menu
               </a>
   <?php }?>
   </div>
   </div>

       <?php if ($_SESSION['role'] == 1) {?>
        <div class="row justify-content-center">
          <div class="col-sm-6 col-md-4 col-lg-3 me-md-5">
            <div class="card h-100 " style="width: 18rem;">
              <img src="./public/img/admin.jpg" class="card-img-top" alt="Admin img">
              <div class="card-body">
                <h5 class="card-title">Add Admin User</h5>
                <p class="card-text">Admin Adds Admin User</p>
        <div class="d-grid gap-2">
            <a href="add.admin.php" class="btn btn-danger"> Add Admin
            <i class="bi bi-send-fill"></i>
          </a>
          <a href="list.admin.php" class="btn btn-warning">List Admin User
            <i class="bi bi-send-fill"></i>
            </a>
            </div>
              </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3 me-md-5">
        <div class="card h-100 " style="width: 18rem;">
          <img src="./public/img/office.jpg" class="card-img-top" alt="Register Unit img">
          <div class="card-body">
            <h5 class="card-title">Add Register Unit</h5>
            <p class="card-text">Register Unit Adds  Add Register Unit</p>
        <div class="d-grid gap-2">
            <a href="add.register.unit.php" class="btn btn-danger"> Add Register Unit
            <i class="bi bi-send-fill"></i>
          </a>
          <a href="list.register.unit.php" class="btn btn-warning">List Register Unit
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
                  <div class="d-grid gap-2">
            <a href="add.teacher.php" class="btn btn-danger"> Add Teacher User
            <i class="bi bi-send-fill"></i>
          </a>
          <a href="list.teacher.php" class="btn btn-warning">List Teacher User
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
            <div class="d-grid gap-2">
            <a href="add.student.php" class="btn btn-danger"> Add Student User
            <i class="bi bi-send-fill"></i>
          </a>
          <a href="list.student.php" class="btn btn-warning">List Student User
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
              <div class="d-grid gap-2">
            <a href="add.class.php" class="btn btn-danger"> Add Class
            <i class="bi bi-send-fill"></i>
          </a>
          <a href="list.class.php" class="btn btn-warning">List Class
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
        <div class="d-grid gap-2">
            <a href="add.lesson.php" class="btn btn-danger"> Add lesson
            <i class="bi bi-send-fill"></i>
          </a>
          <a href="list.lessons.php" class="btn btn-warning">List lesson
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
        <div class="d-grid gap-2">
            <a href="add.announcement.php" class="btn btn-danger"> Send Announcement
            <i class="bi bi-send-fill"></i>
          </a>
          <a href="list.announcement.php" class="btn btn-warning">List Announcement
            <i class="bi bi-send-fill"></i>
            </a>
            </div>
            </div>
          </div>
      </div>
      <div class="col-sm-6 col-md-4 col-lg-3">
          <div class="card h-100 " style="width: 18rem;">
            <img src="./public/img/school-building.jpg" class="card-img-top" alt="School img">
            <div class="card-body">
              <h5 class="card-title">Add School İnformation</h5>
              <p class="card-text">Register Unit Add School İnformation</p>
        <div class="d-grid gap-2">
            <a href="add.information.php" class="btn btn-danger"> Add School İnformation
            <i class="bi bi-send-fill"></i>
          </a>
          <a href="list.information.php" class="btn btn-warning">List School İnformation
            <i class="bi bi-send-fill"></i>
            </a>
            </div>
            </div>
          </div>
      </div>
      <div class="col-sm-6 col-md-4 col-lg-3">
    <div class="card h-100" style="width: 18rem;">
        <img src="./public/img/food-Hall.jpg" class="card-img-top" alt="Food Hall img">
        <div class="card-body">
            <h5 class="card-title">Add Food List</h5>
            <p class="card-text">Register Unit Add Food List</p>
            <div class="d-grid gap-2">
            <a href="add.food.php" class="btn btn-danger"> Add Food List
            <i class="bi bi-send-fill"></i>
          </a>
          <a href="list.food.php" class="btn btn-warning">List Food List
            <i class="bi bi-send-fill"></i>
            </a>
            <a href="update.food.php" class="btn btn-success">Update Food Menu
            <i class='bi bi-arrow-clockwise'></i>
            </a>
            </div>
        </div>
    </div>
</div>
      </div>
      <?php }?>
</div>
</div>
<div class="container">
  <div class="row">
  <?php if ($_SESSION['isLogin'] == 1 && $_SESSION['role'] == 3) {?>
      <div class="col-sm-6 col-md-4 col-lg-3">
          <div class="card h-100 " style="width: 18rem;">
            <img src="./public/img/exam.jpg" class="card-img-top" alt="Exam img">
            <div class="card-body">
              <h5 class="card-title">Create Exam</h5>
              <p class="card-text">Teacher Create Exam</p>
        <div class="d-grid gap-2">
            <a href="add.exam.php" class="btn btn-danger"> Create Exam
            <i class="bi bi-send-fill"></i>
          </a>
          <a href="list.exam.php" class="btn btn-warning">List Exam
            <i class="bi bi-send-fill"></i>
            </a>
            </div>
            </div>
          </div>
      </div>
      <div class="col-sm-6 col-md-4 col-lg-3">
          <div class="card h-100 " style="width: 18rem;">
            <img src="./public/img/announcement.jpg" class="card-img-top" alt="announcement img">
            <div class="card-body">
              <h5 class="card-title">Send Announcement</h5>
              <p class="card-text">Register Unit Send Announcement</p>
        <div class="d-grid gap-2">
            <a href="add.announcement.php" class="btn btn-danger"> Send Announcement
            <i class="bi bi-send-fill"></i>
          </a>
          <a href="list.announcement.php" class="btn btn-warning">List Announcement
            <i class="bi bi-send-fill"></i>
            </a>
            </div>
            </div>
          </div>
      </div>
      <?php }?>
  </div>
</div>
<?php if ($_SESSION['isLogin'] == 1 && $_SESSION['role'] != 4) {?>
<footer class="bg-body-tertiary text-center text-lg-start mt-3">
  <!-- Copyright -->
  <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.05);">
    <p style="margin-bottom: 0;">© 2023 Copyright: Kaan Kaltakkıran
    <a href="https://github.com/kaankaltakkiran/School_Management_System" target="_blank" rel="noopener noreferrer"><img width="35" height="35" src="https://img.icons8.com/plasticine/50/github.png" alt="github"/></a>
  </p>

    <hr style="border-top: 1px solid rgba(0, 0, 0, 0.1);">
  icon by <a href="https://icons8.com">Icons8</a>

  </div>
  <!-- Copyright -->
</footer>
<?php }?>
<?php require 'down.html.php';?>
