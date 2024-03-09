<?php
@session_start();
$activeTitle = "Teacher Exam Result";
$activePage = "teacher.exam.result";
require 'up.html.php';
require 'login.control.php';
?>
<?php
if ($_SESSION['role'] != 3) {
    header("location: authorizationcontrol.php");
    die();
}
?>
<?php require 'navbar.php'?>
    <div class="container">
      <div class="row mt-3">
      <div class='row justify-content-center text-center'>
        <div class="col-sm-4 col-md-6 col-lg-8">
  <h1 class='alert alert-primary mt-2'><?php echo $_SESSION['userName'] ?> Students Exam Result</h1>
  </div>
</div>
   <!-- tablo ile Exam Result listeleme -->
   <table id="example" class="table table-bordered table-striped " style="width:100%">
  <thead>
    <tr>
      <th>Class Id</th>
      <th>Student Image</th>
      <th>Student Name</th>
      <th>Student Class</th>
      <th>Exam Title</th>
      <th>Exam Description</th>
      <th>Total True Answer</th>
      <th>Total False Answer</th>
      <th>Total Questions</th>
      <th>Total Score(%)</th>
      <th>Result</th>
    </tr>
  </thead>
  <tbody>
  </div>
    <?php
require_once 'db.php';
$userid = $_SESSION['id'];
$SORGU = $DB->prepare("SELECT *
FROM students
JOIN results ON students.userid =results.userid
JOIN exams ON results.examid = exams.examid WHERE  exams.addedid=:userid ");
$SORGU->bindParam(':userid', $userid);
$SORGU->execute();
$results = $SORGU->fetchAll(PDO::FETCH_ASSOC);
/* echo '<pre>';
print_r($results);
die();
 */
foreach ($results as $result) {
    $examResult = $result['result'];
    echo "
    <tr>
      <th>{$result['classid']}</th>
      <td><img src='student_images/{$result['userimg']}' class='rounded-circle' width='100' height='100'></td>
      <td>{$result['username']}</td>
      <td>{$result['classname']}</td>
      <td>{$result['examtitle']}</td>
      <td>{$result['examdescription']}</td>
      <td>{$result['totaltrueanswer']}</td>
      <td>{$result['totalfalseanswer']}</td>
      <td>{$result['totalquestions']}</td>
      <td>{$result['totalscore']}</td>
      <td>{$result['result']}</td>
   </tr>
  ";
}
?>
  </tbody>
</table>
</div>
<?php require 'down.html.php';?>