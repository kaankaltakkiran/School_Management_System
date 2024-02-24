<?php
@session_start();
$activeTitle = "Add Questions";
$activePage = "add.questions";
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
  <div class="row justify-content-center  ">
    <div class="col-6">
  <h1 class="alert alert-success mt-4 text-center ">Exam</h1>
  </div>
  <div class="row">
    <div class="col-6">
    <h3 class="alert alert-primary mt-2">Exam İnformation</h3>
    <form>
    <?php
require_once 'db.php';
$id = $_GET['idExam'];
$sql = "SELECT * FROM exams WHERE  examid=:idExam";
$SORGU = $DB->prepare($sql);
$SORGU->bindParam(':idExam', $id);
$SORGU->execute();
$exams = $SORGU->fetchAll(PDO::FETCH_ASSOC);
/* var_dump($exams);
die(); */
$selectedExamTime = $exams[0]['examtime'];
$isPublis = $exams[0]['ispublish'];
//!Database'den gelen seçili classid
$examClassid = $exams[0]['classid'];
?>
<div class="form-floating mb-3">
  <input type="text"  class="form-control" value="<?php echo $_SESSION['userName'] ?>"disabled readonly>
  <label>Update By Teacher Name</label>
</div>
<?php
require_once 'db.php';
$addedid = $_SESSION['id'];
$sql = "SELECT * FROM teachers WHERE  userid=:addedid";
$SORGU = $DB->prepare($sql);
$SORGU->bindParam(':addedid', $addedid);
$SORGU->execute();
$teachers = $SORGU->fetchAll(PDO::FETCH_ASSOC);
/* var_dump($teachers);
die(); */
?>
<div class="form-floating mb-3">
  <input type="text"  class="form-control" value="<?php echo $teachers[0]['lessonname']; ?>"disabled readonly>
  <label>Lesson Name</label>
</div>
<div class="form-floating mb-3">
  <input type="text"  class="form-control" value="<?php echo $exams[0]['examtitle'] ?>" name="form_examtitle"disabled readonly>
  <label>Exam Title Name</label>
</div>
<div class="form-floating mb-3">
  <input type="text"  class="form-control" value="<?php echo $exams[0]['examdescription'] ?>" name="form_examdescription"disabled readonly>
  <label>Exam Description</label>
</div>

<?php
//! Öğretmenin girdiği sınıfların idsi
$selectedClassId = $teachers[0]['classid'];
//! Öğretmenin girdiği sınıfların ismi
$selectedClassName = $teachers[0]['classname'];

//! Öğretmenin girdiği sınıfların ismi
$classArrayId = explode(",", $selectedClassId);
$classArrayName = explode(",", $selectedClassName);
?>
<div class="form-floating mb-3">
<select class="form-select" name="form_class[]" required>
<option disabled selected value="">Select Class Name</option>
<?php
// Her bir değeri bir seçenek olarak ekle
foreach ($classArrayName as $key => $value) {
    $classid = $classArrayId[$key];
    $classname = $value;
    $selected = ($classid == $examClassid) ? 'selected' : '';
    echo "<option $selected disabled readonly value=$classid-$classname>$value</option>";
}
?>
    </select>
</div>

<div class="form-floating mb-3">
<div class="mb-3">
  <label for="exampleFormControlInput1" class="form-label">Start Exam Date</label>
  <input type="date"name="form_examstartdate" class="form-control" id="exampleFormControlInput1" disabled readonly value="<?php echo $exams[0]['examstartdate'] ?>"  min="<?php echo date('Y-m-d'); ?>" />
</div>
</div>
<div class="form-floating mb-3">
<div class="mb-3">
  <label for="exampleFormControlInput1" class="form-label">End Exam Date</label>
  <input type="date"name="form_examenddate" disabled readonly class="form-control" id="exampleFormControlInput1" value="<?php echo $exams[0]['examenddate'] ?>"  min="<?php echo date('Y-m-d'); ?>" />
</div>
</div>

<div class="form-floating mb-3">
<select class="form-select" name="form_examtime">
<option selected disabled value="">Select Exam Time</option>
        <option disabled readonly value="10" <?php if ($selectedExamTime === '10') {
    echo 'selected';
}
?>>10 minutes</option>
        <option disabled readonly value="30" <?php if ($selectedExamTime === '30') {
    echo 'selected';
}
?>>30 minutes</option>
        <option disabled readonly value="45" <?php if ($selectedExamTime === '45') {
    echo 'selected';
}
?>>45 minutes</option>
        <option disabled readonly value="60" <?php if ($selectedExamTime === '60') {
    echo 'selected';
}
?>>60 minutes</option>
    </select>
</div>
<div class="form-check form-switch mb-3">
  <input class="form-check-input" disabled readonly type="checkbox" <?php echo ($isPublis == 1) ? 'checked' : ''; ?> name='form_ispublish'  role="switch" id="flexSwitchCheckDefault">
  <label class="form-check-label" for="flexSwitchCheckDefault">Publish Exam</label>
</div>
<div class="row">
    <div class="col-6">
    <span>Current Image</span>
                    <img src="exam_images/<?php echo $exams[0]['examimg']; ?>" alt="Exam Image"  class="img-thumbnail m-3 ">
                    </div>
</div>


     </form>
    </div>
    <div class="col-6">
    <h3 class="alert alert-primary mt-2">Exam Questions</h3>
  </div>
</div>
</div>
<?php require 'down.html.php';?>
