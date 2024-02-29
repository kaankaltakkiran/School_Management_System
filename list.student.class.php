<?php
@session_start();
$activeTitle = "Class Student  List";
$activePage = "class.student.list";
require 'up.html.php';
require 'login.control.php';
?>
  <?php
//! Rol idsi 2 ve 3 olan register unit ve teacher sadece class student listeyebilir
if ($_SESSION['role'] != 2 && $_SESSION['role'] != 3) {
    header("location: authorizationcontrol.php");
    die();
}
?>
<?php
//!GET ile gelen sınıf adını alıyoruz.
$get_class_name = $_GET['className'];
?>
<?php require 'navbar.php'?>
    <div class="container">
      <div class="row mt-3">
      <div class='row justify-content-center text-center'>
        <div class="col-sm-4 col-md-6 col-lg-8">
  <h1 class='alert alert-primary mt-2'> <?php echo $get_class_name ?> Grade Students</h1>
  </div>
</div>
   <table id="example" class="table table-bordered table-striped " style="width:100%">
  <thead>
    <tr>
      <th>Student Id</th>
      <th>Student Image</th>
      <th>Student Name</th>
      <th>Student Gender</th>
      <th>Student Phone Number</th>
      <th>Student Class Name</th>
      <th>Student Birthdate</th>
    </tr>
  </thead>
  <tbody>
  </div>
    <?php
require_once 'db.php';
$SORGU = $DB->prepare("SELECT * FROM students WHERE classname LIKE '%$get_class_name%'");
$SORGU->execute();
$classStudents = $SORGU->fetchAll(PDO::FETCH_ASSOC);
/* echo '<pre>';
print_r($classStudents);
die() */;
$gender = $classStudents[0]['usergender'];
$gender = ($gender == 'M') ? 'Male' : 'Famale';
foreach ($classStudents as $classStudent) {
    $userBirthdate = $classStudent['birthdate'];
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
    echo "
    <tr>
      <th>{$classStudent['userid']}</th>
      <td><img src='student_images/{$classStudent['userimg']}' class='rounded-circle' width='100' height='100'></td>
      <td>{$classStudent['username']}</td>
      <td>$gender</td>
      <td>{$classStudent['phonenumber']}</td>
      <td>{$classStudent['classname']}</td>
      <td>$formattedDate</td>
   </tr>
  ";
}
?>
  </tbody>
</table>
</div>
<?php require 'down.html.php';?>