<?php
@session_start();
$activeTitle = "Student Lessons List";
$activePage = "student.lesson.list";
require 'up.html.php';
require 'login.control.php';
?>
<?php
/* lessonName */
$get_lesson_name = $_GET['lessonName'];
require_once 'db.php';
$get_lesson_name = $_GET['lessonName'];
$SORGU = $DB->prepare("SELECT * FROM students WHERE lessonname LIKE '%$get_lesson_name%'");
$SORGU->execute();
$studentLessons = $SORGU->fetchAll(PDO::FETCH_ASSOC);
/* echo '<pre>';
print_r($studentLessons);
die(); */
$gender = $studentLessons[0]['usergender'];
$gender = ($gender == 'M') ? 'Male' : 'Famale';
if ($_SESSION['role'] != 2) {
    header("location: authorizationcontrol.php");
    die();
}
if ($studentLessons[0]['addedunitid'] != $_SESSION['id']) {
    header("location: authorizationcontrol.php");
    die();
}
?>
<?php require 'navbar.php'?>

    <div class="container">
      <div class="row mt-3">
      <div class='row justify-content-center text-center'>
        <div class="col-sm-4 col-md-6 col-lg-8">
  <h1 class='alert alert-primary mt-2'>Students Who Choose <?php echo $get_lesson_name ?> Lessons</h1>
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
foreach ($studentLessons as $studentLesson) {
    $userBirthdate = $studentLesson['birthdate'];
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
      <th>{$studentLesson['userid']}</th>
      <td><img src='student_images/{$studentLesson['userimg']}' class='rounded-circle' width='100' height='100'></td>
      <td>{$studentLesson['username']}</td>
      <td>$gender</td>
      <td>{$studentLesson['phonenumber']}</td>
      <td>{$studentLesson['classname']}</td>
      <td>$formattedDate</td>
   </tr>
  ";
}
?>

  </tbody>
</table>
</div>
<?php require 'down.html.php';?>