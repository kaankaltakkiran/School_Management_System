<?php
@session_start();
$activeTitle = "School Management System";
$activePage = "view.student";
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
<?php require 'navbar.php'?>
<?php
require_once 'db.php';
$id = $_GET['idStudent'];
$sql = "SELECT students.username AS student_name,students.useraddress,students.useremail,students.usergender,students.classname,students.lessonname,students.birthdate,students.userimg,parents.username AS parent_name,parents.phonenumber AS parent_number
FROM students
JOIN parents ON students.userid= parents.studentid where students.userid=:idStudent
";
$SORGU = $DB->prepare($sql);
$SORGU->bindParam(':idStudent', $id);
$SORGU->execute();
$students = $SORGU->fetchAll(PDO::FETCH_ASSOC);
/* printf("<pre>%s</pre>", var_export($students, true)); */
$gender = $students[0]['usergender'];
$gender = ($gender == 'M') ? 'Male' : 'Famale';

//!Kullanıcının doğum tarihini alma
$userBirthdate = $students[0]['birthdate'];
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
  <img src="student_images/<?php echo $students[0]['userimg'] ?>" class='card-img-top'  alt="Student İmage">
  <div class="card-body">
    <h5 class="card-title"><?php echo $students[0]['student_name'] ?></h5>
    <p class="card-text"><?php echo $students[0]['classname'] ?> is located</p>
  </div>
  <ul class="list-group list-group-flush">
    <li class="list-group-item">
      <span class="text-danger fw-bolder">User Name:</span>
      <?php echo $students[0]['student_name'] ?>
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
      <span class="text-danger fw-bolder">Class:</span>
      <?php echo $students[0]['classname'] ?>
    </li>
    <li class="list-group-item">
      <span class="text-danger fw-bolder">Lessons:</span>
      <?php echo $students[0]['lessonname'] ?>
    </li>
    <li class="list-group-item">
      <span class="text-danger fw-bolder">Birthdate:</span>
      <?php echo $formattedDate ?>
    </li>
    <li class="list-group-item">
      <span class="text-danger fw-bolder">Parent Name:</span>
      <?php echo $students[0]['parent_name'] ?>
    </li>
    <li class="list-group-item">
      <span class="text-danger fw-bolder">Parent Number:</span>
      <?php echo $students[0]['parent_number'] ?>
    </li>
  </ul>
  <div class="card-body">
    <a href="list.student.php" class="btn btn-warning">Go To List
    <i class="bi bi-backspace"></i></a>
  </div>
</div>
 </div>
</div>
</div>

<?php require 'down.html.php';?>