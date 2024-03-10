
<?php
@session_start();
$activeTitle = "Show Exam Result";
$activePage = "show.exam.result";
require 'up.html.php';
require 'login.control.php';
?>
<?php
if ($_SESSION['role'] != 4 && $_SESSION['role'] != 5) {
    header("location: authorizationcontrol.php");
    die();
}
?>
<?php
require 'db.php';
$id = $_GET['userid'];
$sql = "SELECT * FROM results JOIN students ON results.userid = students.userid WHERE  students.userid=:userid";
$SORGU = $DB->prepare($sql);
$SORGU->bindParam(':userid', $id);
$SORGU->execute();
$results = $SORGU->fetchAll(PDO::FETCH_ASSOC);
/* echo '<pre>';
print_r($results);
die(); */
$examid = $results[0]['examid'];
?>
<?php
if ($results[0]['userid'] != $_SESSION['id']) {
    header("location: authorizationcontrol.php");
    die();
}
?>
<?php
require 'db.php';
if ($_SESSION['role'] == 4) {
    $studentid = $_SESSION['id'];
    $sql = "SELECT results.*,parents.*,exams.*, students.username as student_name, parents.* FROM results
JOIN students ON results.userid= students.userid
JOIN parents ON students.userid= parents.userid
JOIN exams ON results.examid= exams.examid  WHERE students.userid=:id ";
    $SORGU = $DB->prepare($sql);
    $SORGU->bindParam(':id', $studentid);

} else if ($_SESSION['role'] == 5) {
    $parentid = $_SESSION['id'];
    $sql = "SELECT results.*,parents.*,exams.*, students.username as student_name, parents.* FROM results
  JOIN students ON results.userid= students.userid
  JOIN parents ON students.userid= parents.userid
  JOIN exams ON results.examid= exams.examid  WHERE parents.userid=:id ";
    $SORGU = $DB->prepare($sql);
    $SORGU->bindParam(':id', $parentid);
}
$SORGU->execute();
$exams = $SORGU->fetchAll(PDO::FETCH_ASSOC);
/* echo '<pre>';
print_r($exams);
die(); */
?>
<?php require 'navbar.php'?>
<div class="container">
  <div class="row justify-content-center ">
    <div class="col-6">
  <h1 class="alert alert-primary mt-2 text-center "><?php echo $exams[0]['student_name'] ?> <?php echo $exams[0]['lessonname'] ?> Exam Result</h1>
  </div>
  </div>
  <div class="row justify-content-center ">
    <div class="col-6">
    <?php if ($results[0]['examresult'] == '') {?>
    <div class="card text-bg-primary text-white fw-bold   mb-3" style="max-width: 500rem;">
  <div class="card-header"><?php echo $exams[0]['examdescription'] ?></div>
  <div class="card-body">
    <h5 class="card-title"><?php echo $exams[0]['examtitle'] ?></h5>
    <h1 class="card-text"><?php echo $exams[0]['result'] ?></h1>
    <p class="card-text">Total True Answer: <?php echo $exams[0]['totaltrueanswer'] ?></p>
    <p class="card-text">Total False Answer: <?php echo $exams[0]['totalfalseanswer'] ?></p>
    <p class="card-text">Total Question: <?php echo $exams[0]['totalquestions'] ?></p>
    <p class="card-text">Total Score: <?php echo $exams[0]['totalscore'] ?></p>
  </div>
    </div>
    <a href="index.php" class="btn btn-primary">Go To İndex Page <i class="bi bi-backspace"></i></a>
    </div>
    <?php }?>
    <?php if ($results[0]['examresult'] == 'Passed') {?>
      <div class="card text-bg-success text-white fw-bold   mb-3" style="max-width: 500rem;">
  <div class="card-header"><?php echo $exams[0]['examdescription'] ?></div>
  <div class="card-body">
    <h5 class="card-title"><?php echo $exams[0]['examtitle'] ?></h5>
    <h1 class="card-text"><?php echo $exams[0]['result'] ?></h1>
    <p class="card-text">Total True Answer: <?php echo $exams[0]['totaltrueanswer'] ?></p>
    <p class="card-text">Total False Answer: <?php echo $exams[0]['totalfalseanswer'] ?></p>
    <p class="card-text">Total Question: <?php echo $exams[0]['totalquestions'] ?></p>
    <p class="card-text">Total Score: <?php echo $exams[0]['totalscore'] ?></p>
    <p class="card-text">Exam Status: <?php echo $exams[0]['examresult'] ?></p>
  </div>
    </div>
    <a href="index.php" class="btn btn-primary">Go To İndex Page <i class="bi bi-backspace"></i></a>
    </div>
      <?php }?>
      <?php if ($results[0]['examresult'] == 'Failed') {?>
      <div class="card text-bg-danger text-white fw-bold   mb-3" style="max-width: 500rem;">
  <div class="card-header"><?php echo $exams[0]['examdescription'] ?></div>
  <div class="card-body">
    <h5 class="card-title"><?php echo $exams[0]['examtitle'] ?></h5>
    <h1 class="card-text"><?php echo $exams[0]['result'] ?></h1>
    <p class="card-text">Total True Answer: <?php echo $exams[0]['totaltrueanswer'] ?></p>
    <p class="card-text">Total False Answer: <?php echo $exams[0]['totalfalseanswer'] ?></p>
    <p class="card-text">Total Question: <?php echo $exams[0]['totalquestions'] ?></p>
    <p class="card-text">Total Score: <?php echo $exams[0]['totalscore'] ?></p>
    <p class="card-text">Exam Status: <?php echo $exams[0]['examresult'] ?></p>
  </div>
    </div>
    <a href="index.php" class="btn btn-primary">Go To İndex Page <i class="bi bi-backspace"></i></a>
    </div>
      <?php }?>
  </div>
</div>
<?php require 'down.html.php';?>