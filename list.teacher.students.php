<?php
@session_start();
$activeTitle = "Student Lessons List";
$activePage = "student.lesson.list";
require 'up.html.php';
require 'login.control.php';
?>
<?php
require_once 'db.php';
$teacher_id = $_GET['teacherid'];
$SORGU = $DB->prepare("SELECT * FROM teachers WHERE userid=:teacherid");
$SORGU->bindParam(':teacherid', $teacher_id);
$SORGU->execute();
$teacher = $SORGU->fetchAll(PDO::FETCH_ASSOC);
/* echo '<pre>';
print_r($teacher);
die(); */
//! Rol idsi 2 ve 3 olan register unit ve teacher sadece student listeyebilir
if ($_SESSION['role'] != 2 && $_SESSION['role'] != 3) {
    header("location: authorizationcontrol.php");
    die();
}
if ($teacher[0]['addedunitid'] != $_SESSION['id']) {
    header("location: authorizationcontrol.php");
    die();
}
?>
<?php require 'navbar.php'?>
    <div class="container">
      <div class="row mt-3">
      <div class='row justify-content-center text-center'>
        <div class="col-sm-4 col-md-6 col-lg-8">
  <h1 class='alert alert-primary mt-2'><?php echo $teacher[0]['username'] ?>'s Students</h1>
  </div>
</div>
   <table id="example" class="table table-bordered table-striped " style="width:100%">
  <thead>
    <tr>
      <th>Student Id</th>
      <th>Student Image</th>
      <th>Student Name</th>
      <th>Student Email</th>
      <th>Student Class Name</th>
      <th>Student Lesson Name</th>
      <th>Student Gender</th>
      <th>Student Birthdate</th>
    </tr>
  </thead>
  <tbody>
  </div>
  <?php
require_once 'db.php';
$teacher_id = $_GET['teacherid'];
//!FIND_IN_SET() fonksiyonu: Bu fonksiyon, bir dize içinde belirtilen bir alt dizenin bulunup bulunmadığını kontrol eder.
$SORGU = $DB->prepare("SELECT t.*, s.*
FROM teachers t
INNER JOIN students s ON FIND_IN_SET(t.lessonid, s.lessonid) WHERE t.userid=:teacherid");
$SORGU->bindParam(':teacherid', $teacher_id);
$SORGU->execute();
$teacher_students = $SORGU->fetchAll(PDO::FETCH_ASSOC);
/* echo '<pre>';
print_r($teacher_students);
die(); */
foreach ($teacher_students as $teacher_student) {
    $gender = $teacher_student['usergender'];
    $gender = ($gender == 'M') ? 'Male' : 'Famale';
    $userBirthdate = $teacher_student['birthdate'];
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
    <th>{$teacher_student['userid']}</th>
    <td><img src='student_images/{$teacher_student['userimg']}' class='rounded-circle' width='100' height='100'></td>
    <td>{$teacher_student['username']}</td>
    <td>{$teacher_student['useremail']}</td>
    <td>{$teacher_student['classname']}</td>
    <td>{$teacher_student['lessonname']}</td>
    <td>$gender</td>
    <td>$formattedDate</td>
   </tr>
  ";
}
?>
  </tbody>
</table>
</div>
<?php require 'down.html.php';?>











<!-- SELECT DISTINCT  *
FROM students
INNER JOIN teachers
ON teachers.classid
LIKE CONCAT('%', teachers.classid, '%') WHERE students.userid=1 -->
