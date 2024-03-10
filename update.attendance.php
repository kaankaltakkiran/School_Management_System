<?php
session_start();
$activeTitle = "Attendance Update";
$activePage = "attendance.update";
require 'up.html.php';
require 'login.control.php';
?>
<?php
//!GET ile gelen sınıf adını alıyoruz.
$get_class_name = $_GET['className'];
$today = date("Y-m-d");
?>
<?php
//! Rol idsi 3 olan teacher sadece kendi derslerine ait öğrenci listesini görebilir
if ($_SESSION['role'] != 3) {
    header("location: authorizationcontrol.php");
    die();
}
?>
<?php
require_once 'db.php';
$teacherid = $_SESSION['id'];
$SORGU = $DB->prepare("SELECT * FROM teachers WHERE userid=:id AND classname LIKE '%$get_class_name%'");
$SORGU->bindParam(':id', $teacherid);
$SORGU->execute();
$teachers = $SORGU->fetchAll(PDO::FETCH_ASSOC);
/* echo '<pre>';
print_r($teachers);
die(); */
//! Rol idsi 3 olan teacher sadece kendi derslerine ait öğrenci listesini görebilir
if (count($teachers) == 0) {
    header("location: authorizationcontrol.php");
    die();
}
?>
    <?php include 'navbar.php';?>
  <div class="container">
  <div class="row justify-content-center mt-3">
  <form method="post">
<h1 class="alert alert-info text-center"><?php echo $get_class_name ?> Class Attendance Update</h1>
<div class='row justify-content-center text-center'>
        <div class="col-sm-4 col-md-6 col-lg-8">
        <div class="form-floating mb-3">
<div class="mb-3">
  <label for="exampleFormControlInput1" class="form-label">Select Attendance Date</label>
  <input type="date" name="form_attendance_date" value="<?php echo $_POST['form_attendance_date'] ?>" class="form-control" id="exampleFormControlInput1" required />
</div>
</div>
  <button type="submit" class="btn btn-outline-primary m-3 ">List Attendance <i class="bi bi-send"></i> </button>
  </div>
</div>
<h4 class="text-danger">Today Date: <?php echo $today ?></h4>
  <p class="text-danger text-end fw-bold ">Note: You can update the attendance by clicking on the checkbox.</p>
<?php
if (isset($_POST['form_submit'])) {
    //!Hata kontrolü
    $errors = array();
    //!Onay mesajları
    $approves = array();
    //?checkobx içinde studentid de var
    $attendance_values = $_POST['isHere'];

    require_once 'db.php';
    $formDate = $_POST['form_attendance_date'];
    $teacherid = $_SESSION['id'];
    $SORGU = $DB->prepare("SELECT *,attendances.createdate AS attendance_date FROM attendances JOIN students ON attendances.studentid= students.userid WHERE attendances.createdate=:form_attendance_date AND attendances.studentclassname LIKE '%$get_class_name%' AND attendances.addedteacherid=:teacherid");
    $SORGU->bindParam(':form_attendance_date', $formDate);
    $SORGU->bindParam(':teacherid', $teacherid);
    $SORGU->execute();
    $students = $SORGU->fetchAll(PDO::FETCH_ASSOC);
/*   echo '<pre>';
print_r($students);
die();
 */
    foreach ($students as $student) {
        // Her öğrenci için varsayılan olarak 0 atanır
        $attendance_status = 0;

        // Eğer öğrenci işaretlenmişse, durumu 1 olarak ayarla
        if (isset($_POST['isHere'][$student['userid']])) {
            $attendance_status = 1;
        }

        $student_name = $student['userid'];

        $sql = "UPDATE attendances SET ishere = :isHere,lastupdate = CURRENT_TIMESTAMP() WHERE studentid = :studentid AND DATE(createdate) = :form_attendance_date AND addedteacherid = :teacherid";
        $SORGU = $DB->prepare($sql);
        $SORGU->bindParam(':studentid', $student_name);
        $SORGU->bindParam(':isHere', $attendance_status);
        $SORGU->bindParam(':form_attendance_date', $formDate);
        $SORGU->bindParam(':teacherid', $teacherid);
        $SORGU->execute();
        $approves[] = "Attendance Update Successful...";
        header("location: update.attendance.php?className=$get_class_name");

    }
}
?>
  <?php
//! Hata mesajlarını göster
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
        //!4 saniye sonra sayfayı yenilemek için yönlendirme
        /*  echo "<meta http-equiv='refresh' content='3'>"; */

    }
}
?>
<div class="row">
 <table id="example" class="table table-bordered table-striped " style="width:100%">
  <thead>
    <tr>
      <th>Student Id</th>
      <th>Student Image</th>
      <th>Student Name</th>
      <th>Student Class Name</th>
      <th>Student Lesson Name</th>
      <th>Selected Date</th>
      <th>Attendance</th>
    </tr>
  </thead>
  <tbody>
  </div>
    <?php
require_once 'db.php';
$formDate = $_POST['form_attendance_date'];
$teacherid = $_SESSION['id'];
$SORGU = $DB->prepare(" SELECT *,attendances.createdate AS attendance_date FROM attendances JOIN students ON attendances.studentid= students.userid WHERE attendances.createdate=:form_attendance_date AND attendances.studentclassname LIKE '%$get_class_name%' AND attendances.addedteacherid=:teacherid");
$SORGU->bindParam(':form_attendance_date', $formDate);
$SORGU->bindParam(':teacherid', $teacherid);
$SORGU->execute();
$studentss = $SORGU->fetchAll(PDO::FETCH_ASSOC);
/* printf("<pre>%s</pre>", var_export($studentss, true));
die(); */

foreach ($studentss as $student) {
    $checked = ($student['ishere'] == 1) ? 'checked' : '';
    echo "
    <tr>
      <th>{$student['userid']}</th>
      <td><img src='student_images/{$student['userimg']}' class='rounded-circle' width='100' height='100'></td>
      <td>{$student['username']}</td>
      <td>{$student['classname']}</td>
      <td>{$student['studentlessonname']}</td>
      <td>{$student['attendance_date']}</td>
      <td>
      <input class='form-check-input' $checked name='isHere[{$student['userid']}]' value='1' type='checkbox' id='flexCheckDefault{$student['userid']}'>
      <label class='form-check-label' for='flexCheckDefault{$student['userid']}'>
          Here
      </label>
  </td>
   </tr>
  ";
}
?>
  </tbody>
</table>
<div class="row">
  <div class="col-6">
  <?php if (count($studentss) > 0) {?>
  <button type="submit" name="form_submit" class="btn btn-outline-primary m-3 ">Update Attendance <i class="bi bi-send"></i> </button>
  <?php }?>
  </div>
  </form>
</div>
</div>
<?php require 'down.html.php';?>