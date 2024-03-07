<?php
@session_start();
$activeTitle = "School Management System";
$activePage = "view.parent";
require 'up.html.php';
require 'login.control.php';
?>
  <?php
//! Rol idsi 2 ve 3 olan register unit ve teacher sadece student listesini görebilir
if ($_SESSION['role'] != 2 && $_SESSION['role'] != 3) {
    header("location: authorizationcontrol.php");
    die();
}
?>
<?php
//!Velinin öğrencisi
require_once 'db.php';
$id = $_GET['idparent'];
$sql = "SELECT * FROM students WHERE userid=:idparent";
$SORGU = $DB->prepare($sql);
$SORGU->bindParam(':idparent', $id);
$SORGU->execute();
$students = $SORGU->fetchAll(PDO::FETCH_ASSOC);
/* printf("<pre>%s</pre>", var_export($students, true)); */
$studentName = $students[0]['username'];
$studentClassNames = $students[0]['classname'];
?>
<?php require 'navbar.php'?>
<?php
require_once 'db.php';
$id = $_GET['idparent'];
$sql = "SELECT * FROM parents WHERE studentid=:idparent";
$SORGU = $DB->prepare($sql);
$SORGU->bindParam(':idparent', $id);
$SORGU->execute();
$parents = $SORGU->fetchAll(PDO::FETCH_ASSOC);
/* printf("<pre>%s</pre>", var_export($parents, true)); */
$gender = $parents[0]['usergender'];
$gender = ($gender == 'M') ? 'Male' : 'Famale';

//!Kullanıcının doğum tarihini alma
$userBirthdate = $parents[0]['birthdate'];
//!Tarihi parçalara ayırma
/* explode() fonksiyonu: Bu fonksiyon, bir metni belirli bir ayraç karakterine göre böler ve bir diziye dönüştürür.  */
$dateParts = explode('-', $userBirthdate);

//? Yıl, ay ve gün bilgilerini alıyoruz
$year = $dateParts[0];
$month = $dateParts[1];
$day = $dateParts[2];

//?Ay ismini bulmak için date() ve strtotime() fonksiyonlarını kullanıyoruz
//!F tam ay ismini alıyor.
$monthName = date("F", strtotime($userBirthdate));

// Sonucu ekrana yazdırma
$formattedDate = "$day $monthName $year";
?>
<div class="container ">
  <div class="row justify-content-center mt-3 ">
 <div class="col-6">
 <div class="card" style="width: 18rem;">
  <img src="parent_images/<?php echo $parents[0]['userimg'] ?>" class='card-img-top'  alt="Parent İmage">
  <div class="card-body">
    <h5 class="card-title"><?php echo $parents[0]['username'] ?></h5>
    <p class="card-text">Parent</p>
  </div>
  <ul class="list-group list-group-flush">
    <li class="list-group-item">
      <span class="text-danger fw-bolder">User Name:</span>
      <?php echo $parents[0]['username'] ?>
    </li>
    <li class="list-group-item">
      <span class="text-danger fw-bolder">Address:</span>
      <?php echo $parents[0]['useraddress'] ?>
    </li>
    <li class="list-group-item">
      <span class="text-danger fw-bolder">Email:</span>
      <?php echo $parents[0]['useremail'] ?>
    </li>
    <li class="list-group-item">
      <span class="text-danger fw-bolder">Phone Number:</span>
      <?php echo $parents[0]['phonenumber'] ?>
    </li>
    <li class="list-group-item">
      <span class="text-danger fw-bolder">Gender:</span>
      <?php echo $gender ?>
    </li>
    <li class="list-group-item">
      <span class="text-danger fw-bolder">Student Name:</span>
      <?php echo $studentName ?>
    </li>
    <li class="list-group-item">
      <span class="text-danger fw-bolder">Student Classname:</span>
      <?php echo $studentClassNames ?>
    </li>
    <li class="list-group-item">
      <span class="text-danger fw-bolder">Birthdate:</span>
      <?php echo $formattedDate ?>
    </li>
  </ul>
  <div class="card-body">
  <?php if ($_SESSION['role'] == 2) {?>
    <a href="list.parent.php" class="btn btn-warning">Go To List
    <i class="bi bi-backspace"></i></a>
    <?php }?>
    <?php if ($_SESSION['role'] == 3) {?>
    <a href="list.teacher.parent.php" class="btn btn-warning">Go To List
    <i class="bi bi-backspace"></i></a>
    <?php }?>
  </div>
</div>
 </div>
</div>
</div>
<?php require 'down.html.php';?>