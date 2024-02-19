<?php
session_start();
$activeTitle = "School Management System";
$activePage = "index";
require 'up.html.php';
require 'login.control.php';
?>
  <?php
if ($_SESSION['role'] != 2 && $_SESSION['role'] != 3) {
    header("location: authorizationcontrol.php");
    die();
}
?>
<?php require 'navbar.php'?>
<?php
require_once 'db.php';
$id = $_GET['idTeacher'];
$sql = " SELECT *FROM teachers JOIN lessons ON teachers.lessonid = lessons.lessonid WHERE userid = :idTeacher";
$SORGU = $DB->prepare($sql);
$SORGU->bindParam(':idTeacher', $id);
$SORGU->execute();
$teachers = $SORGU->fetchAll(PDO::FETCH_ASSOC);
/* echo '<pre>';
print_r($teachers);
die(); */
$gender = $teachers[0]['usergender'];
$gender = ($gender == 'M') ? 'Male' : 'Famale';
?>
<div class="container ">
  <div class="row justify-content-center mt-3 ">
 <div class="col-6">
 <div class="card" style="width: 18rem;">
  <img src="teacher_images/<?php echo $teachers[0]['userimg'] ?>" class='card-img-top'  alt="Student İmage">
  <div class="card-body">
    <h5 class="card-title"><?php echo $teachers[0]['username'] ?></h5>
    <p class="card-text"><?php echo $teachers[0]['classname'] ?> is located</p>
  </div>
  <ul class="list-group list-group-flush">
    <li class="list-group-item">
      <span class="text-danger fw-bolder">User Name:</span>
      <?php echo $teachers[0]['username'] ?>
    </li>
    <li class="list-group-item">
      <span class="text-danger fw-bolder">Address:</span>
      <?php echo $teachers[0]['useraddress'] ?>
    </li>
    <li class="list-group-item">
      <span class="text-danger fw-bolder">Email:</span>
      <?php echo $teachers[0]['useremail'] ?>
    </li>
    <li class="list-group-item">
      <span class="text-danger fw-bolder">Gender:</span>
      <?php echo $gender ?>
    </li>
    <li class="list-group-item">
      <span class="text-danger fw-bolder">Created Date:</span>
      <?php echo $teachers[0]['createdate'] ?>
    </li>
    <li class="list-group-item">
      <span class="text-danger fw-bolder">Class:</span>
      <?php echo $teachers[0]['classname'] ?>
    </li>
    <li class="list-group-item">
      <span class="text-danger fw-bolder">Lessons:</span>
      <?php echo $teachers[0]['lessonname'] ?>
    </li>
    <li class="list-group-item">
      <span class="text-danger fw-bolder">Birthdate:</span>
      <?php echo $teachers[0]['birthdate'] ?>
    </li>
  </ul>
  <div class="card-body">
    <a href="list.teacher.php" class="btn btn-warning">Go To List
    <i class="bi bi-backspace"></i>
    </a>
  </div>
</div>
 </div>
</div>
</div>

<?php require 'down.html.php';?>