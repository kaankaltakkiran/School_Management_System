<?php
@session_start();
$activeTitle = "Student List";
$activePage = "student.list";
require 'up.html.php';
require 'login.control.php';
?>
<?php
if (isset($_GET['removestudentid'])) {
    $approves = array();
    require 'db.php';
    $remove_id = $_GET['removestudentid'];
    $sql = "DELETE FROM students WHERE userid = :removestudentid";
    $SORGU = $DB->prepare($sql);
    $SORGU->bindParam(':removestudentid', $remove_id);
    $SORGU->execute();
    $approves[] = "Student Deleted Successfully...";
}
?>
<?php
//! Rol idsi 2 ve 3 olan register unit ve teacher sadece student listeyebilir
if ($_SESSION['role'] != 2 && $_SESSION['role'] != 3) {
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
      <div class="row mt-3">
      <div class='row justify-content-center text-center'>
        <div class="col-sm-4 col-md-6 col-lg-8">
  <h1 class='alert alert-primary mt-2'>Student List</h1>
  </div>
  <div class='row text-end'>
  <p>
    <a href='add.student.php' class="btn btn-warning btn-sm ">
     Add New Student <i class="bi bi-send"></i> </a>
  </p>
</div>
</div>
   <!-- tablo ile Student listeleme -->
   <table id="example" class="table table-bordered table-striped " style="width:100%">
  <thead>
    <tr>
      <th>Id</th>
      <th>Img</th>
      <th>Name</th>
      <th>Class Name</th>
      <th>Lessonn Name</th>
      <th>Email</th>
      <th>Gender</th>
      <th>Address</th>
      <th>Phone Number</th>
      <th>Birth date</th>
      <th>Parent Name</th>
      <th>Parent Number</th>
        <th>Manage</th>
    </tr>
  </thead>
  <tbody>
  </div>
    <?php
require_once 'db.php';
$id = $_SESSION['id'];
$SORGU = $DB->prepare("SELECT * FROM students WHERE addedunitid = :id");
$SORGU->bindParam(':id', $id);
$SORGU->execute();
$students = $SORGU->fetchAll(PDO::FETCH_ASSOC);
/* echo '<pre>';
print_r($students);
die(); */
foreach ($students as $student) {
    $gender = $student['usergender'];
    $gender = ($gender == 'M') ? 'Male' : 'Famale';
    //!Kullanıcının doğum tarihini alma
    $userBirthdate = $student['birthdate'];
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
    if ($isRegisterUnit) {

    }
// Sonucu ekrana yazdırma
    $formattedDate = "$day $monthName $year";

    //!Sadece Register unit öğrencileri için güncelleme ve silme butonlarını göster
    $isRegisterUnit = $student['addedunitid'] == $_SESSION['id'] && $_SESSION['role'] == 2;
    echo "
    <tr>
    <th>{$student['userid']}</th>
    <td><img src='student_images/{$student['userimg']}' class='rounded-circle' width='100' height='100'></td>
    <td><a href='view.student.php?idStudent={$student['userid']}' class='link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover'>{$student['username']}</a></td>
    <td>{$student['classname']}</td>
    <td>{$student['lessonname']}</td>
    <td>{$student['useremail']}</td>
    <td>$gender</td>
    <td>{$student['useraddress']}</td>
    <td>{$student['phonenumber']}</td>
    <td>$formattedDate</td>
    <td>{$student['parentname']}</td>
    <td>{$student['parentnumber']}</td>
    <td>
    <a href='update.student.php?idStudent={$student['userid']}' class='btn btn-success mb-3  btn-sm'>Update <i class='bi bi-arrow-clockwise'></i></a>
    <a href='list.student.php?removestudentid={$student['userid']}'onclick='return confirm(\"Are you sure you want to delete {$student['username']}?\")' class='btn btn-danger btn-sm'>Delete <i class='bi bi-trash'></i></a>
  </td>
 </tr>
    ";
}
?>
  </tbody>
</table>
</div>
<?php require 'down.html.php';?>