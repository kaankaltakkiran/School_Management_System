<?php
@session_start();
$activeTitle = "Teacher Claas Student Exam Result";
$activePage = "teacher.class.student.exam.result";
require 'up.html.php';
require 'login.control.php';
?>
  <?php
//! Rol idsi 3 olan teacher sadece kendi sınıf listesini görebilir
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
  <h1 class='alert alert-primary mt-2'> <?php echo $get_class_name ?> Class Students Exam Result</h1>
  </div>
  </div>
   <table id="example" class="table table-bordered table-striped " style="width:100%">
  <thead>
    <tr>
    <th>Student Id</th>
      <th>Student Image</th>
      <th>Student Name</th>
      <th>Student Class</th>
      <th>Exam Title</th>
      <th>Exam Description</th>
      <th>Total True Answer</th>
      <th>Total False Answer</th>
      <th>Total Questions</th>
      <th>Total Score(%)</th>
    </tr>
  </thead>
  <tbody>
  </div>
    <?php
require_once 'db.php';
$teacher_id = $_SESSION['id'];
/* SELECT t.*, t.userid as teacher_userid,t.username as teacher_username,t.lessonid as teacher_lessonid,t.lessonname as teacher_lessonname, s.* FROM teachers t INNER JOIN students s ON  FIND_IN_SET(t.lessonid, s.lessonid) WHERE t.userid=:teacherid AND s.classname LIKE '%$get_class_name%' AND t.classname LIKE '%$get_class_name%' */
$SORGU = $DB->prepare("SELECT * FROM students
JOIN results ON students.userid =results.userid
JOIN exams ON results.examid = exams.examid WHERE exams.addedid=:teacherid AND students.classname LIKE '%$get_class_name%' ");
$SORGU->bindParam(':teacherid', $teacher_id);
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
            <td>{$classStudent['examtitle']}</td>
            <td>{$classStudent['examdescription']}</td>
            <td>{$classStudent['totaltrueanswer']}</td>
            <td>{$classStudent['totalfalseanswer']}</td>
            <td>{$classStudent['totalquestions']}</td>
            <td>{$classStudent['totalscore']}</td>
        </tr>";
}
?>
  </tbody>
</table>
</div>
<?php require 'down.html.php';?>
