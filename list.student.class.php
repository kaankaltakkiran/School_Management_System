<?php
@session_start();
$activeTitle = "Class Student  List";
$activePage = "class.student.list";
require 'up.html.php';
require 'login.control.php';
?>
  <?php
//! Rol idsi 2 ve 3 olan register unit ve teacher sadece class student listeyebilir
if ($_SESSION['role'] != 2 && $_SESSION['role'] != 3) {
    header("location: authorizationcontrol.php");
    die();
}
?>
<?php
//!GET ile gelen sınıf adını alıyoruz.
$get_class_name = $_GET['className'];
?>
<?php require 'navbar.php'?>
<?php
require_once 'db.php';

if (isset($_POST['attendance_btn'])) {
    //! Checkbox işaretlenmişse, durumu 1 olarak ayarla dizi olarak alıyoruz.
    //?checkobx içinde studentid de var
    $attendance_values = $_POST['isHere'];

    $teacher_id = $_SESSION['id'];
    $SORGU = $DB->prepare("SELECT t.*, t.userid as teacher_userid,t.username as teacher_username,t.lessonid as teacher_lessonid,t.lessonname as teacher_lessonname, s.* FROM teachers t INNER JOIN students s ON  FIND_IN_SET(t.lessonid, s.lessonid) WHERE t.userid=:teacherid AND s.classname LIKE '%$get_class_name%'");
    $SORGU->bindParam(':teacherid', $teacher_id);
    $SORGU->execute();
    $teacher_students = $SORGU->fetchAll(PDO::FETCH_ASSOC);

    /*    printf("<pre>%s</pre>", var_export($teacher_students, true));
    die(); */
    foreach ($teacher_students as $teacher_student) {
        //!Her öğrenci için varsayılan olarak 0 atanır
        $attendance_status = 0;

        // Eğer öğrenci işaretlenmişse, durumu 1 olarak ayarla
        if (isset($_POST['isHere'][$teacher_student['userid']])) {
            $attendance_status = 1;
        }
        // Öğrenci adını al
        $student_name = $teacher_student['username'];
        $student_classid = $teacher_student['classid'];
        $student_classname = $teacher_student['classname'];
        $student_lessonid = $teacher_student['teacher_lessonid'];
        $student_lessonname = $teacher_student['teacher_lessonname'];
        $added_teacherid = $teacher_student['teacher_userid'];
        $added_teachername = $teacher_student['teacher_username'];

        // Insert into Database
        $sql = "INSERT INTO attendances (studentid,ishere,studentname,studentclassid,studentclassname,studentlessonid,studentlessonname,addedteacherid,addedteachername) VALUES (:form_studentid,:isHere,:studentname,:studentclassid,:studentclassname,:studentlessonid,:studentlessonname,:addedteacherid,:addedteachername)";
        $SORGU = $DB->prepare($sql);
        $SORGU->bindParam(':form_studentid', $teacher_student['userid']);
        $SORGU->bindParam(':isHere', $attendance_status);
        $SORGU->bindParam(':studentname', $student_name);
        $SORGU->bindParam(':studentclassid', $student_classid);
        $SORGU->bindParam(':studentclassname', $student_classname);
        $SORGU->bindParam(':studentlessonid', $student_lessonid);
        $SORGU->bindParam(':studentlessonname', $student_lessonname);
        $SORGU->bindParam(':addedteacherid', $added_teacherid);
        $SORGU->bindParam(':addedteachername', $added_teachername);
        $SORGU->execute();
        $approves[] = "Attendance Added Successfully...";
    }
}
?>
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
      <div class="row mt-3">
      <div class='row justify-content-center text-center'>
        <div class="col-sm-4 col-md-6 col-lg-8">
  <h1 class='alert alert-primary mt-2'> <?php echo $get_class_name ?> Class Students</h1>
  </div>
</div>
<form method="post">
   <table id="example" class="table table-bordered table-striped " style="width:100%">
  <thead>
    <tr>
      <th>Student Id</th>
      <th>Student Image</th>
      <th>Student Name</th>
      <th>Student Gender</th>
      <th>Student Phone Number</th>
      <th>Student Class Name</th>
      <th>Student Birthdate</th>
      <th>Attendance</th>
    </tr>
  </thead>
  <tbody>
  </div>
    <?php
require_once 'db.php';
$SORGU = $DB->prepare("SELECT * FROM students WHERE classname LIKE '%$get_class_name%'");
$SORGU->execute();
$classStudents = $SORGU->fetchAll(PDO::FETCH_ASSOC);
/* echo '<pre>';
print_r($classStudents);
die(); */
//? checkbox name ve id uniqe olsun olsun student id ile eklendi
foreach ($classStudents as $classStudent) {
    $gender = $classStudent['usergender'];
    $gender = ($gender == 'M') ? 'Male' : 'Famale';
    $userBirthdate = $classStudent['birthdate'];
    //!Tarihi parçalara ayırma
    /* explode() fonksiyonu: Bu fonksiyon, bir metni belirli bir ayraç karakterine göre böler ve bir diziye dönüştürür.  */
    $dateParts = explode('-', $userBirthdate);

//? Yıl, ay ve gün bilgilerini alıyoruz
    $year = $dateParts[0];
    $month = $dateParts[1];
    $day = $dateParts[2];

//?Ay ismini bulmak için date() ve strtotime() fonksiyonlarını kullanıyoruz
    //!F tam ay ismini alıyor.
    $monthName = date("F", strtotime($userBirthdate));

// Sonucu ekrana yazdırma
    $formattedDate = "$day $monthName $year";
    echo "
    <tr>
      <th>{$classStudent['userid']}</th>
      <td><img src='student_images/{$classStudent['userimg']}' class='rounded-circle' width='100' height='100'></td>
      <td>{$classStudent['username']}</td>
      <td>$gender</td>
      <td>{$classStudent['phonenumber']}</td>
      <td>{$classStudent['classname']}</td>
      <td>$formattedDate</td>
      <td>
      <input class='form-check-input' name='isHere[{$classStudent['userid']}]' value='1' type='checkbox' id='flexCheckDefault{$classStudent['userid']}'>
      <label class='form-check-label' for='flexCheckDefault{$classStudent['userid']}'>
          Here
      </label>
  </td>
   </tr>
  ";
}
?>
  </tbody>
</table>
<?php if (count($classStudents) > 0) {?>
    <button type="submit" name="attendance_btn" class="btn btn-outline-success mb-3 ">Add Attendance   <i class="bi bi-send"></i></button>
    <?php }?>
    </form>
</div>
<?php require 'down.html.php';?>
