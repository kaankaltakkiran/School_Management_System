<?php
@session_start();
$activeTitle = "Attendance Student Name List";
$activePage = "attendance.student.name.list";
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
if ($_SESSION['role'] != 4 && $_SESSION['role'] != 5) {
    header("location: authorizationcontrol.php");
    die();
}
?>
<?php require 'navbar.php'?>
    <div class="container">

  <?php
//! Formdan gelen tarih bilgisine göre sorgu yapılıyor
if (isset($_POST['list_attendance_student'])) {
    $errors = array();
    require_once 'db.php';
//!Eğer tarih seçilmişse
    $formDate = isset($_POST['form_attendance_date']) ? $_POST['form_attendance_date'] : null;
    $formStudentid = $_POST['form_selected_student'];
//!Eğer tarih seçilmişse
    if (!empty($formDate)) {
        // Hem tarih hem öğrenci seçilmişse
        $SORGU = $DB->prepare("SELECT *
        FROM students
        JOIN attendances ON students.userid= attendances.studentid WHERE attendances.createdate=:form_attendance_date AND attendances.studentid=:form_selected_student");
        $SORGU->bindParam(':form_attendance_date', $formDate);
        //!Eğer tarih seçilmediyse öğrenci ismine göre sorgu yapılıyor
    } else {
        // Sadece öğrenci seçilmişse
        $SORGU = $DB->prepare("SELECT *
        FROM students
        JOIN attendances ON students.userid= attendances.studentid WHERE attendances.studentid=:form_selected_student");
    }

    $SORGU->bindParam(':form_selected_student', $formStudentid);
    $SORGU->execute();
    $students = $SORGU->fetchAll(PDO::FETCH_ASSOC);
    /*   echo '<pre>';
print_r($students);
die(); */

}
?>
      <div class="row mt-3">
      <div class='row justify-content-center text-center'>
        <div class="col-sm-4 col-md-6 col-lg-8">
  <h1 class='alert alert-primary mt-2'>Attendance <?php echo $students[0]['username'] ?></h1>
  </div>
</div>
<div class='row justify-content-center text-center'>
        <div class="col-sm-4 col-md-6 col-lg-8">
        <form method="post" class="needs-validation" novalidate>
        <div class="form-floating mb-3">
<div class="mb-3">
  <label for="exampleFormControlInput1" class="form-label">Select Attendance Date</label>
  <input type="date" name="form_attendance_date" value="<?php echo $_POST['form_attendance_date'] ?>" class="form-control" id="exampleFormControlInput1" />
</div>
</div>
<?php
//!Hata mesajlarını göstermek için boş bir dizi
$errors = array();
require_once 'db.php';
if ($_SESSION['role'] == 4) {
    $studentid = $_SESSION['id'];
    $sql = "SELECT students.*,parents.*,students.userid AS student_id,students.username AS student_name FROM students
  JOIN parents ON students.userid= parents.userid WHERE students.userid=:studentid ";
    $SORGU = $DB->prepare($sql);
    $SORGU->bindParam(':studentid', $studentid);

} else if ($_SESSION['role'] == 5) {
    $parentid = $_SESSION['id'];
    $sql = "SELECT students.*,parents.*,students.userid AS student_id,students.username AS student_name FROM students
  JOIN parents ON students.userid= parents.userid WHERE parents.userid=:id ";
    $SORGU = $DB->prepare($sql);
    $SORGU->bindParam(':id', $parentid);
}
$SORGU->execute();
$optionStudents = $SORGU->fetchAll(PDO::FETCH_ASSOC);
/* echo '<pre>';
print_r($optionStudents);
die() */
?>
<div class="form-floating mb-3">
  <select class="form-select" id="floatingSelect" name="form_selected_student"  required aria-label="Floating label select example" >
  <option disabled selected value="">Select Student</option>
  <?php
foreach ($optionStudents as $student) {
    $selected = ($student['student_id'] == $_POST['form_selected_student']) ? 'selected' : '';
    echo "<option value='{$student['student_id']}' $selected>{$student['student_name']}</option>";
}
?>
  </select>
  <label for="floatingSelect">Select Student</label>
  <div class="invalid-feedback fw-bold">
      Please Select Student !
    </div>
</div>
  <button type="submit" name="list_attendance_student" class="btn btn-outline-primary m-3 ">List Attendance <i class="bi bi-send"></i> </button>
</form>
  </div>
</div>
   <!-- tablo ile Attendance listeleme -->
   <table id="example" class="table table-bordered table-striped " style="width:100%">
  <thead>
    <tr>
      <th>Student Id</th>
      <th>Student Img</th>
      <th>Student Name</th>
      <th>Student Class Name</th>
      <th>Student Lesson Name</th>
      <th>Selected Date</th>
     <th>Student Attendance Status</th>
    </tr>
  </thead>
  <tbody>
  </div>
<?php
foreach ($students as $student) {
    //! Status belirleme
    $hereControl = "";
    $statusCount = 0;
    //! Veritabaında ki publish durumunu kontrol et
    $isHere = $student['ishere'];

    if ($isHere == 1) {
        $hereControl = "Here";
    } else {
        $hereControl = "Not Here !";
    }

    //!Status belirleme
    //? Eğer publish durumu published ve tarihler uygunsa
    if ($hereControl == "Here") {
        $status = "Here";
        $statusCount = 1;
        //? Eğer publish durumu not published ve tarihler uygunsa
    } else {
        $status = "Not Here !";
        $statusCount = 0;
    }
    echo "
    <tr>
      <th>{$student['studentid']}</th>
      <td><img src='student_images/{$student['studentimg']}' class='rounded-circle' width='100' height='100'></td>
      <td>{$student['studentname']}</td>
      <td>{$student['studentclassname']}</td>
      <td>{$student['studentlessonname']}</td>
      <td>{$student['createdate']}</td>
      <td";
    if ($statusCount == 0) {
        echo " class='bg-danger text-white '";
    } else {
        echo " class='bg-success text-white'";
    }
    echo ">$status</td>
   </tr>
  ";
}
?>
  </tbody>
</table>
</div>
<?php require 'down.html.php';?>