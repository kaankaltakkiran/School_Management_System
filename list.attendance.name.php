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
<?php
//!Tüm Attendance  silme
if (isset($_POST['removeAllAttendance'])) {
    $approves = array();
    require 'db.php';
    $teacherid = $_SESSION['id'];
    $formStudentid = $_POST['form_selected_student'];
    $sql = "DELETE FROM attendances WHERE studentid=:form_selected_student AND studentclassname LIKE '%$get_class_name%' AND addedteacherid = :id";

    // Eğer tarih seçildiyse, sorguyu tarihe göre de filtrele
    if (isset($_POST['form_attendance_date']) && !empty($_POST['form_attendance_date'])) {
        $sql .= " AND createdate = :form_attendance_date";
    }

    $SORGU = $DB->prepare($sql);
    $SORGU->bindParam(':id', $teacherid);
    $SORGU->bindParam(':form_selected_student', $formStudentid);

    // Eğer tarih seçildiyse, tarihi bağla
    if (isset($_POST['form_attendance_date']) && !empty($_POST['form_attendance_date'])) {
        $SORGU->bindParam(':form_attendance_date', $_POST['form_attendance_date']);
    }

    $SORGU->execute();
    $approves[] = "All Attendance Deleted Successfully...";
}
?>
<?php
//! Rol idsi 3 olan kayıt birimi sınıf listesini görebilir
if ($_SESSION['role'] != 3) {
    header("location: authorizationcontrol.php");
    die();
}
?>
<?php require 'navbar.php'?>
    <div class="container">
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
  <?php
//! Formdan gelen tarih bilgisine göre sorgu yapılıyor
if (isset($_POST['list_attendance_student'])) {
    $errors = array();
    require_once 'db.php';
//!Eğer tarih seçilmişse
    $formDate = isset($_POST['form_attendance_date']) ? $_POST['form_attendance_date'] : null;
    $formStudentid = $_POST['form_selected_student'];
    $teacherid = $_SESSION['id'];
//!Eğer tarih seçilmişse
    if (!empty($formDate)) {
        // Hem tarih hem öğrenci seçilmişse
        $SORGU = $DB->prepare("SELECT * FROM attendances WHERE createdate=:form_attendance_date AND studentid=:form_selected_student AND studentclassname LIKE '%$get_class_name%' AND addedteacherid =:id");
        $SORGU->bindParam(':form_attendance_date', $formDate);
        //!Eğer tarih seçilmediyse öğrenci ismine göre sorgu yapılıyor
    } else {
        // Sadece öğrenci seçilmişse
        $SORGU = $DB->prepare("SELECT * FROM attendances WHERE studentid=:form_selected_student AND studentclassname LIKE '%$get_class_name%' AND addedteacherid =:id");
    }

    $SORGU->bindParam(':form_selected_student', $formStudentid);
    $SORGU->bindParam(':id', $teacherid);
    $SORGU->execute();
    $students = $SORGU->fetchAll(PDO::FETCH_ASSOC);
    /*   echo '<pre>';
    print_r($students);
    die(); */

    // Sorguyu başlatıyoruz
    if (!empty($formDate)) {
        // Hem tarih hem öğrenci seçilmişse
        $SORGU = $DB->prepare("SELECT COUNT(*) as total_records, SUM(ishere = 1) as here_count, SUM(ishere = 0) as not_here_count FROM attendances WHERE createdate=:form_attendance_date AND studentid=:form_selected_student AND studentclassname LIKE '%$get_class_name%' AND addedteacherid =:id");
        $SORGU->bindParam(':form_attendance_date', $formDate);
    } else {
        // Sadece öğrenci seçilmişse
        $SORGU = $DB->prepare("SELECT COUNT(*) as total_records, SUM(ishere = 1) as here_count, SUM(ishere = 0) as not_here_count FROM attendances WHERE studentid=:form_selected_student AND studentclassname LIKE '%$get_class_name%' AND addedteacherid =:id");
    }

    $SORGU->bindParam(':form_selected_student', $formStudentid);
    $SORGU->bindParam(':id', $teacherid);
    $SORGU->execute();
    $attendanceCounts = $SORGU->fetch(PDO::FETCH_ASSOC);

// Toplam kayıt sayısı
    $totalAttendance = $attendanceCounts['total_records'];

// Burada 'ishere' değeri 1 olan kayıtların sayısı
    $hereCount = $attendanceCounts['here_count'];

// Burada 'ishere' değeri 0 olan kayıtların sayısı
    $notHereCount = $attendanceCounts['not_here_count'];
}
if (isset($_POST['clear_selection'])) {
    // Seçili değerleri temizle
    unset($_POST['form_attendance_date']);
    unset($_POST['form_selected_student']);

}
?>
      <div class="row mt-3">
      <div class='row justify-content-center text-center'>
        <div class="col-sm-4 col-md-6 col-lg-8">
  <h1 class='alert alert-primary mt-2'>Attendance By Student Name</h1>
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
$SORGU = $DB->prepare("SELECT * FROM students WHERE  classname LIKE '%$get_class_name%'");
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
    $selected = ($student['userid'] == $_POST['form_selected_student']) ? 'selected' : '';
    echo "<option value='{$student['userid']}' $selected>{$student['username']}</option>";
}
?>
  </select>
  <label for="floatingSelect">Select Student</label>
  <div class="invalid-feedback fw-bold">
      Please Select Student !
    </div>
</div>
<div class="row justify-content-end ">
  <div class="col-6">
    <?php if (count($students) > 0) {?>
    <button type="sumbit" name="removeAllAttendance" onclick="return confirm('Are you sure you want to delete all attendance ?')" class="btn btn-danger float-end mt-2 ">Delete All Attendance <i class="bi bi-trash"></i> </button>
    <?php }?>
    </div>
</div>
  <button type="submit" name="list_attendance_student" class="btn btn-outline-primary m-3 ">List Attendance <i class="bi bi-send"></i> </button>
  <button type="submit" class="btn btn-outline-danger m-3 " name="clear_selection">Clear Selections <i class="bi bi-x-circle"></i></button>
</form>
  </div>
</div>
<?php if (count($students) > 0) {?>
<div class='row justify-content-center text-center'>
        <div class="col-sm-4 col-md-6">
  <div class="alert alert-primary mt-2" role="alert">
   <p></p>Total Attendance : <?php echo $totalAttendance ?></p>
    <p></p>Here : <?php echo $hereCount ?></p>
    <p></p>Not Here : <?php echo $notHereCount ?></p>
    <p></p></p>Attendance Continuity Rate : <?php echo round(($hereCount / $totalAttendance) * 100, 2) ?>%</p>
    <p>More detailed attendance information is listed in the table below !</p>
  </div>
  </div>
</div>
<?php }?>
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