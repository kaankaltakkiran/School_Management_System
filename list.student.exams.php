<?php
@session_start();
$activeTitle = "List Student Exams";
$activePage = "list.student.exams";
require 'up.html.php';
require 'login.control.php';
?>
  <?php
if ($_SESSION['role'] != 4) {
    header("location: authorizationcontrol.php");
    die();
}
?>

<?php require 'navbar.php'?>
    <div class="container">
      <div class="row mt-3">
      <div class='row justify-content-center text-center'>
        <div class="col-sm-4 col-md-6 col-lg-8">
  <h1 class='alert alert-primary mt-2'>List Student Exam</h1>
  </div>
</div>
   <table id="example" class="table table-bordered table-striped " style="width:100%">
  <thead>
    <tr>
      <th>Exam Id</th>
      <th>Exam Image</th>
      <th>Exam Title</th>
      <th>Exam Description</th>
      <th>Exam Start Date</th>
      <th>Exam End Date</th>
      <th>Exam Time</th>
      <th>Exam Class Name</th>
      <th>Start Exam</th>
    </tr>
  </thead>
  <tbody>
  </div>

    <?php
/* lessonName */
require_once 'db.php';
$studentid = $_SESSION['id'];
$SORGU = $DB->prepare("SELECT *FROM exams JOIN students ON exams.classid= students.classid where userid=:studentid");
$SORGU->bindParam(':studentid', $studentid);
$SORGU->execute();
$exams = $SORGU->fetchAll(PDO::FETCH_ASSOC);
/* echo '<pre>';
print_r($exams);
die(); */

require_once 'db.php';
$studentid = $_SESSION['id'];
$SORGU = $DB->prepare("SELECT * FROM results WHERE userid=:studentid");
$SORGU->bindParam(':studentid', $studentid);
$SORGU->execute();
$results = $SORGU->fetchAll(PDO::FETCH_ASSOC);
/* echo '<pre>';
print_r($results);
die(); */
if (count($results) > 0) {
    $error = "You have already taken the exam";
} else {
    foreach ($exams as $exam) {
        echo "
    <tr>
      <th>{$exam['examid']}</th>
      <td><img src='exam_images/{$exam['examimg']}' class='rounded-circle' width='100' height='100'></td>
      <td>{$exam['examtitle']}</td>
      <td>{$exam['examdescription']}</td>
      <td>{$exam['examstartdate']}</td>
      <td>{$exam['examenddate']}</td>
      <td>{$exam['examtime']} minutes</td>
      <td>{$exam['classname']}</td>
      <td><a href='show.exam.php?idExam={$exam['examid']}' class='btn btn-success'>Start Exam <i class='bi bi-skip-start'></i></a></td>
   </tr>
  ";
    }
}
?>

  </tbody>
</table>
</div>
<?php require 'down.html.php';?>