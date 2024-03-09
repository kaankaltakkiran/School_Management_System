<?php
@session_start();
$activeTitle = "Give Note";
$activePage = "give.note";
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
$today = date("Y-m-d");
?>
<?php require 'navbar.php'?>
<?php
require_once 'db.php';

if (isset($_POST['exam_result_btn'])) {
    //!Hata kontrolü
    $errors = array();
    //!Onay mesajları
    $approves = array();
    require_once 'db.php';
    // Formdan gelen verileri al
    $studentId = $_POST['student_id'];
    $examResult = $_POST['exam_result'];

    $sql = "UPDATE results SET examresult = :exam_result,lastupdate = CURRENT_TIMESTAMP() WHERE userid = :student_id";

    $SORGU = $DB->prepare($sql);
    $SORGU->bindParam(':exam_result', $examResult);
    $SORGU->bindParam(':student_id', $studentId);
    $SORGU->execute();
    $approves[] = "Note Added Successful....";
}
?>
    <div class="container">
    <?php
if (!empty($errors)) {
    foreach ($errors as $error) {
        echo "<div class='position-fixed top-0 end-0 p-3' style='z-index: 5'>
      <div class='toast align-items-center text-white bg-danger border-0' role='alert' aria-live='assertive' aria-atomic='true' data-bs-delay='5000'>
          <div class='d-flex'>
              <div class='toast-body'>
              $error
              </div>
              <button type='button' class='btn-close btn-close-white me-2 m-auto' data-bs-dismiss='toast' aria-label='Close'></button>
          </div>
      </div>
  </div>";
    }
}
?>
    <?php
//! Başarılı mesajlarını göster
if (!empty($approves)) {
    foreach ($approves as $approve) {
        echo "<div class='position-fixed top-0 end-0 p-3' style='z-index: 5'>
      <div class='toast align-items-center text-white bg-success border-0' role='alert' aria-live='assertive' aria-atomic='true' data-bs-delay='5000'>
          <div class='d-flex'>
              <div class='toast-body'>
              $approve
              </div>
              <button type='button' class='btn-close btn-close-white me-2 m-auto' data-bs-dismiss='toast' aria-label='Close'></button>
          </div>
      </div>
  </div>";
    }
}
?>
      <div class="row mt-3">
      <div class='row justify-content-center text-center'>
        <div class="col-sm-4 col-md-6 col-lg-8">
  <h1 class='alert alert-primary mt-2'> <?php echo $get_class_name ?> Class Students Give Note</h1>
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
      <th>Total Questions</th>
      <th>Total True Answer</th>
      <th>Total False Answer</th>
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
//? checkbox name ve id uniqe olsun olsun student id ile eklendi
foreach ($classStudents as $classStudent) {
    echo "
    <tr>
      <th>{$classStudent['userid']}</th>
      <td><img src='student_images/{$classStudent['userimg']}' class='rounded-circle' width='100' height='100'></td>
      <td>{$classStudent['username']}</td>
      <td>{$classStudent['classname']}</td>
      <td>{$classStudent['lessonname']}</td>
      <td>{$classStudent['examtitle']}</td>
      <td>{$classStudent['totalquestions']}</td>
      <td>{$classStudent['totaltrueanswer']}</td>
      <td>{$classStudent['totalfalseanswer']}</td>
      <td>{$classStudent['totalscore']}</td>
      <td class='w-100 '>
      <input type='hidden' name='student_id' value='{$classStudent['userid']}'>
        <div class='form-floating'>
          <select class='form-select' name='exam_result' id='floatingSelect' aria-label='Floating label select example'>
            <option selected disabled >Select Exam Result Status</option>
            <option value='Passed'" . ($classStudent['examresult'] == 'Passed' ? ' selected' : '') . ">Passed</option>
            <option value='Failed'" . ($classStudent['examresult'] == 'Failed' ? ' selected' : '') . ">Failed</option>
          </select>
          <label for='floatingSelect'>Give Note</label>
        </div>
      </td>
   </tr>
  ";
}
?>
  </tbody>
</table>
<?php if (count($classStudents) > 0) {?>
    <button type="submit" name="exam_result_btn" class="btn btn-outline-success mb-3 ">Give Note   <i class="bi bi-send"></i></button>
    <?php }?>
    </form>
</div>
<?php require 'down.html.php';?>
