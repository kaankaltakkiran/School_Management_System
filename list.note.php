<?php
@session_start();
$activeTitle = "Teacher List Note Class List";
$activePage = "teacher.list.note.class.list";
require 'up.html.php';
require 'login.control.php';
?>
  <?php
//! Rol idsi 2 ve 3 olan register unit ve teacher sadece class student listeyebilir
if ($_SESSION['role'] != 3) {
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
  <h1 class='alert alert-primary mt-2'> <?php echo $get_class_name ?> Class Students List Note</h1>
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
require_once 'db.php';
$teacherId = $_SESSION['id'];
$SORGU = $DB->prepare("SELECT * FROM students
JOIN results ON students.userid= results.userid
JOIN exams ON results .examid= exams.examid WHERE students.classname LIKE '%$get_class_name%' AND exams.addedid=:userid");
$SORGU->bindParam(':userid', $teacherId);
$SORGU->execute();
$classStudents = $SORGU->fetchAll(PDO::FETCH_ASSOC);
/* echo '<pre>';
print_r($classStudents);
die(); */
foreach ($classStudents as $classStudent) {
    $examResult = $classStudent['examresult'];
    echo "
    <tr>
      <th>{$classStudent['userid']}</th>
      <td><img src='student_images/{$classStudent['userimg']}' class='rounded-circle' width='100' height='100'></td>
      <td>{$classStudent['username']}</td>
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
