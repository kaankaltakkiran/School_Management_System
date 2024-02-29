
<?php
@session_start();
$activeTitle = "Show Exam Result";
$activePage = "show.exam.result";
require 'up.html.php';
require 'login.control.php';
?>
<?php
if ($_SESSION['role'] != 4) {
    header("location: authorizationcontrol.php");
    die();
}
?>
<?php
require 'db.php';
$id = $_GET['userid'];
$sql = "SELECT * FROM results WHERE  userid=:userid";
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
$sql = "SELECT DISTINCT * FROM results
JOIN exams ON results.examid= exams.examid WHERE results.examid=:idexam ";
$SORGU = $DB->prepare($sql);
$SORGU->bindParam(':idexam', $examid);
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
  <h1 class="alert alert-primary mt-2 text-center ">Exam Result</h1>
  </div>
  </div>
  <div class="row justify-content-center ">
    <div class="col-6">
      <?php if ($results[0]['result'] == 'Passed') {?>
    <div class="card text-bg-success mb-3" style="max-width: 500rem;">
  <div class="card-header"><?php echo $exams[0]['examdescription'] ?></div>
  <div class="card-body">
    <h5 class="card-title"><?php echo $exams[0]['examtitle'] ?></h5>
    <h1 class="card-text"><?php echo $exams[0]['result'] ?></h1>
    <p class="card-text">Total True Answer: <?php echo $exams[0]['totaltrueanswer'] ?></p>
    <p class="card-text">Total False Answer: <?php echo $exams[0]['totalfalseanswer'] ?></p>
    <p class="card-text">Total Question: <?php echo $exams[0]['totalquestions'] ?></p>
  </div>
    </div>
    <a href="index.php" class="btn btn-primary">Go To İndex Page</a>
    <?php } else {?>
      <div class="card text-bg-danger mb-3" style="max-width: 500rem;">
  <div class="card-header"><?php echo $exams[0]['examdescription'] ?></div>
  <div class="card-body">
    <h5 class="card-title"><?php echo $exams[0]['examtitle'] ?></h5>
    <h1 class="card-text"><?php echo $exams[0]['result'] ?></h1>
    <p class="card-text">Total True Answer: <?php echo $exams[0]['totaltrueanswer'] ?></p>
    <p class="card-text">Total False Answer: <?php echo $exams[0]['totalfalseanswer'] ?></p>
    <p class="card-text">Total Question: <?php echo $exams[0]['totalquestions'] ?></p>
  </div>
    </div>
    <a href="index.php" class="btn btn-primary">Go To İndex Page</a>
    <?php }?>
    </div>
  </div>
</div>
<?php require 'down.html.php';?>