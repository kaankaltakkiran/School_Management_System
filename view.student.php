<?php
session_start();
$activeTitle = "School Management System";
$activePage = "index";
require 'up.html.php';
?>
<?php require 'navbar.php'?>
<?php
require_once 'db.php';

$id = $_GET['idStudent'];

$sql = "SELECT * FROM students where userid = :idStudent";
$SORGU = $DB->prepare($sql);

$SORGU->bindParam(':idStudent', $id);

$SORGU->execute();

$students = $SORGU->fetchAll(PDO::FETCH_ASSOC);
$gender = $students[0]['usergender'];
$gender = ($gender == 'M') ? 'Male' : 'Famale';
?>
<div class="container ">
  <div class="row justify-content-center mt-3 ">
 <div class="col-6">
 <div class="card" style="width: 18rem;">
  <img src="student_images/<?php echo $students[0]['userimg'] ?>" class='card-img-top'  alt="Student İmage">
  <div class="card-body">
    <h5 class="card-title"><?php echo $students[0]['username'] ?></h5>
    <p class="card-text"><?php echo $students[0]['classname'] ?> is located</p>
  </div>
  <ul class="list-group list-group-flush">
    <li class="list-group-item">
      <span class="text-danger fw-bolder">User Name:</span>
      <?php echo $students[0]['username'] ?>
    </li>
    <li class="list-group-item">
      <span class="text-danger fw-bolder">Address:</span>
      <?php echo $students[0]['useraddress'] ?>
    </li>
    <li class="list-group-item">
      <span class="text-danger fw-bolder">Email:</span>
      <?php echo $students[0]['useremail'] ?>
    </li>
    <li class="list-group-item">
      <span class="text-danger fw-bolder">Gender:</span>
      <?php echo $gender ?>
    </li>
    <li class="list-group-item">
      <span class="text-danger fw-bolder">Created Date:</span>
      <?php echo $students[0]['createdate'] ?>
    </li>
    <li class="list-group-item">
      <span class="text-danger fw-bolder">Class:</span>
      <?php echo $students[0]['classname'] ?>
    </li>
    <li class="list-group-item">
      <span class="text-danger fw-bolder">Class:</span>
      <?php echo $students[0]['phonenumber'] ?>
    </li>
    <li class="list-group-item">
      <span class="text-danger fw-bolder">Class:</span>
      <?php echo $students[0]['birthdate'] ?>
    </li>
    <li class="list-group-item">
      <span class="text-danger fw-bolder">Parent Name:</span>
      <?php echo $students[0]['parentname'] ?>
    </li>
    <li class="list-group-item">
      <span class="text-danger fw-bolder">Class:</span>
      <?php echo $students[0]['parentnumber'] ?>
    </li>
  </ul>
  <div class="card-body">
    <a href="list.class.student.php?idClass=<?php echo $students[0]['classid'] ?>" class="card-link">Go To List</a>
  </div>
</div>
 </div>
</div>
</div>

<?php require 'down.html.php';?>