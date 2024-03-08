<?php
@session_start();
$activeTitle = "Attendance Date List";
$activePage = "attendance.date.list";
require 'up.html.php';
require 'login.control.php';
?>
<?php
//!GET ile gelen sınıf adını alıyoruz.
$get_class_name = $_GET['className'];
$today = date("Y-m-d");
?>
<?php
//!Tüm Attendance  silme
if (isset($_POST['removeAllAttendance'])) {
    $approves = array();
    require 'db.php';
    $teacherid = $_SESSION['id'];
    $sql = "DELETE FROM attendances WHERE createdate=:form_attendance_date AND studentclassname LIKE '%$get_class_name%' AND addedteacherid =:id";
    $SORGU = $DB->prepare($sql);
    $SORGU->bindParam(':id', $teacherid);
    $SORGU->bindParam(':form_attendance_date', $_POST['form_attendance_date']);
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
if (isset($_POST['form_attendance_date'])) {
    //!Hata mesajlarını göstermek için boş bir dizi
    $errors = array();
    require_once 'db.php';
    $formDate = $_POST['form_attendance_date'];
    $teacherid = $_SESSION['id'];
    $SORGU = $DB->prepare("SELECT * FROM attendances WHERE createdate=:form_attendance_date AND studentclassname LIKE '%$get_class_name%' AND addedteacherid =:id");
    $SORGU->bindParam(':form_attendance_date', $formDate);
    $SORGU->bindParam(':id', $teacherid);
    $SORGU->execute();
    $students = $SORGU->fetchAll(PDO::FETCH_ASSOC);
    /*  echo '<pre>';
print_r($students);
die(); */

}
?>
      <div class="row mt-3">
      <div class='row justify-content-center text-center'>
        <div class="col-sm-4 col-md-6 col-lg-8">
  <h1 class='alert alert-primary mt-2'>Attendance By Date</h1>
  </div>
</div>
<div class='row justify-content-center text-center'>
        <div class="col-sm-4 col-md-6 col-lg-8">
        <form method="post" class="needs-validation" novalidate>
        <div class="form-floating mb-3">
<div class="mb-3">
  <label for="exampleFormControlInput1" class="form-label">Select Attendance Date</label>
  <input type="date" name="form_attendance_date" value="<?php echo $_POST['form_attendance_date'] ?>" class="form-control" id="exampleFormControlInput1" required/>
  <div class="invalid-feedback fw-bold">
      Please Select Attendance Date !
    </div>
</div>
</div>
<div class="row justify-content-end ">
  <div class="col-6">
    <?php if (count($students) > 0) {?>
    <button type="sumbit" name="removeAllAttendance" onclick="return confirm('Are you sure you want to delete all attendance ?')" class="btn btn-danger float-end mt-2 ">Delete All Attendance <i class="bi bi-trash"></i> </button>
    <?php }?>
    </div>
</div>
  <button type="submit" class="btn btn-outline-primary m-3 ">List Attendance <i class="bi bi-send"></i> </button>
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
      <td><img src='student_images/{$student['userimg']}' class='rounded-circle' width='100' height='100'></td>
      <td>{$student['studentname']}</td>
      <td>{$student['studentclassname']}</td>
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