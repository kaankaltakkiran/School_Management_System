<?php
@session_start();
$activeTitle = "Student List Note";
$activePage = "list.student.note";
require 'up.html.php';
require 'login.control.php';
?>
<?php
//! Rol idsi 3 olan teacher sadece kendi  ait öğrenci listesini görebilir
if ($_SESSION['role'] != 4 && $_SESSION['role'] != 5) {
    header("location: authorizationcontrol.php");
    die();
}
?>
<?php
require 'db.php';
if ($_SESSION['role'] == 4) {
    $studentid = $_SESSION['id'];
    $sql = "SELECT results.*,parents.*,exams.*, students.username as student_name,students.userimg as student_img, parents.* FROM results
JOIN students ON results.userid= students.userid
JOIN parents ON students.userid= parents.userid
JOIN exams ON results.examid= exams.examid  WHERE students.userid=:id ";
    $SORGU = $DB->prepare($sql);
    $SORGU->bindParam(':id', $studentid);

} else if ($_SESSION['role'] == 5) {
    $parentid = $_SESSION['id'];
    $sql = "SELECT results.*,parents.*,exams.*, students.username as student_name,students.userimg as student_img, parents.* FROM results
JOIN students ON results.userid= students.userid
JOIN parents ON students.userid= parents.userid
JOIN exams ON results.examid= exams.examid  WHERE parents.userid=:id ";
    $SORGU = $DB->prepare($sql);
    $SORGU->bindParam(':id', $parentid);
}
$SORGU->execute();
$classStudents = $SORGU->fetchAll(PDO::FETCH_ASSOC);
/* echo '<pre>';
print_r($classStudents);
die(); */
?>
<?php require 'navbar.php'?>
    <div class="container">
      <div class="row mt-3">
      <div class='row justify-content-center text-center'>
        <div class="col-sm-4 col-md-6 col-lg-8">
  <h1 class='alert alert-primary mt-2'> <?php echo $classStudents[0]['student_name'] ?> List Note</h1>
  </div>
</div>
<form method="post">
   <table id="example" class="table table-bordered table-striped " style="width:100%">
  <thead>
    <tr>
      <th>Student Id</th>
      <th>Student Image</th>
      <th>Student Name</th>
      <th>Student Class Name</th>
      <th>Lesson Name</th>
      <th>Exam Name</th>
      <th>Total True Answer</th>
      <th>Total False Answer</th>
      <th>Total Questions</th>
      <th>Total Score(%)</th>
      <th>Note</th>
    </tr>
  </thead>
  <tbody>
  </div>
<?php
foreach ($classStudents as $classStudent) {
    $examResult = $classStudent['examresult'];
    echo "
    <tr>
      <th>{$classStudent['userid']}</th>
      <td><img src='student_images/{$classStudent['student_img']}' class='rounded-circle' width='100' height='100'></td>
      <td>{$classStudent['student_name']}</td>
      <td>{$classStudent['classname']}</td>
      <td>{$classStudent['lessonname']}</td>
      <td>{$classStudent['examtitle']}</td>
      <td>{$classStudent['totaltrueanswer']}</td>
      <td>{$classStudent['totalfalseanswer']}</td>
      <td>{$classStudent['totalquestions']}</td>
      <td>{$classStudent['totalscore']}</td>
      <td " . (!empty($examResult) ? "class='" . ($examResult == 'Passed' ? 'bg-success text-white' : 'bg-danger text-white') . "'" : '') . ">
      " . (!empty($examResult) ? $classStudent['examresult'] : '') . "
  </td>
   </tr>
  ";
}
?>
  </tbody>
</table>
</div>
<?php require 'down.html.php';?>
