<?php
@session_start();
$activeTitle = "Class Parent List";
$activePage = "class.parent.list";
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
  <h1 class='alert alert-primary mt-2'> <?php echo $get_class_name ?> Class Parent's</h1>
  </div>
</div>
   <table id="example" class="table table-bordered table-striped " style="width:100%">
  <thead>
    <tr>
      <th>Parent Id</th>
      <th>Parent Image</th>
      <th>Parent Name</th>
      <th>Parent Gender</th>
      <th>Parent Phone Number</th>
      <th>Parent Birthdate</th>
      <th>Student Name</th>
      <th>Student Class Name</th>
    </tr>
  </thead>
  <tbody>
  </div>
    <?php
require_once 'db.php';
$SORGU = $DB->prepare("SELECT students.username AS student_name,students.classname AS student_classname,parents.userid AS parent_id,parents.username AS parent_name,parents.userimg AS parent_img,parents.phonenumber AS parent_number,parents.birthdate AS parent_birthdate
FROM students
JOIN parents ON students.userid= parents.studentid WHERE students.classname LIKE '%$get_class_name%'");

$SORGU->execute();
$parents = $SORGU->fetchAll(PDO::FETCH_ASSOC);
/* echo '<pre>';
print_r($parents);
die(); */
$gender = $parents[0]['usergender'];
$gender = ($gender == 'M') ? 'Male' : 'Famale';
foreach ($parents as $parent) {
    $userBirthdate = $parent['birthdate'];
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
      <th>{$parent['parent_id']}</th>
      <td><img src='parent_images/{$parent['parent_img']}' class='rounded-circle' width='100' height='100'></td>
      <td>{$parent['parent_name']}</td>
      <td>$gender</td>
      <td>{$parent['parent_number']}</td>
      <td>$formattedDate</td>
      <td>{$parent['student_name']}</td>
      <td>{$parent['student_classname']}</td>
   </tr>
  ";
}
?>
  </tbody>
</table>
</div>
<?php require 'down.html.php';?>