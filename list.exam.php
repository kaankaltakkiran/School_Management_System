<?php
@session_start();
$activeTitle = "List of Exams";
$activePage = "list.exam";
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
  <h1 class='alert alert-primary mt-2'>List Exam</h1>
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
      <th>Manage</th>
    </tr>
  </thead>
  <tbody>
  </div>

    <?php
/* lessonName */
require_once 'db.php';
$addedid = $_SESSION['id'];
$SORGU = $DB->prepare("SELECT * FROM exams WHERE addedid=:addedid");
$SORGU->bindParam(':addedid', $addedid);
$SORGU->execute();
$exams = $SORGU->fetchAll(PDO::FETCH_ASSOC);
/* echo '<pre>';
print_r($exams);
die(); */
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
      <td>
      <a href='update.lesson.php?lessonid={$lesson['lessonid']}' class='btn btn-success btn-sm'>Update <i class='bi bi-arrow-clockwise'></i></a>
      <a href='list.lessons.php?removeLessonid={$lesson['lessonid']}'onclick='return confirm(\"Are you sure you want to delete {$lesson['lessonname']}?\")' class='btn btn-danger btn-sm'>Delete <i class='bi bi-trash'></i></a>
    </td>
   </tr>
  ";
}
?>

  </tbody>
</table>
</div>
<?php require 'down.html.php';?>