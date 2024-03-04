<?php
@session_start();
$activeTitle = "Teacher User List";
$activePage = "teacher.list";
require 'up.html.php';
require 'login.control.php';
?>
<?php
if (isset($_GET['removeTeacherid'])) {
    $approves = array();
    require 'db.php';
    $remove_id = $_GET['removeTeacherid'];
    $sql = "DELETE FROM teachers WHERE userid = :removeTeacherid";
    $SORGU = $DB->prepare($sql);
    $SORGU->bindParam(':removeTeacherid', $remove_id);
    $SORGU->execute();
    $approves[] = "Teacher Deleted Successfully...";
}
?>
<?php
//! Rol idsi 3 olan teacher sadece teacher listeyebilir
if ($_SESSION['role'] != 2) {
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
  <h1 class='alert alert-primary mt-2'>Teacher User List</h1>
  </div>
  <div class='row text-end'>
  <p>
    <a href='add.teacher.php' class="btn btn-warning btn-sm ">
     Add New Teacher User <i class="bi bi-send"></i> </a>
  </p>
</div>
</div>
<!-- table table-bordered table-striped -->
   <!-- tablo ile teacher listeleme -->
<table id="example" class="table table-bordered table-striped " style="width:100%">
  <thead>
    <tr>
      <th>Teacher Id</th>
      <th>Teacher Image</th>
      <th>Teacher Name</th>
      <th>Email</th>
      <th>Class</th>
      <th>Lessons</th>
      <th>Gender</th>
      <th>Address</th>
      <th>Phone Number</th>
      <th>BirthDate</th>
      <th>Update</th>
      <th>Delete</th>
    </tr>
  </thead>
  <tbody>
  </div>

    <?php
require_once 'db.php';
$SORGU = $DB->prepare("SELECT * FROM teachers");
$SORGU->execute();
$teachers = $SORGU->fetchAll(PDO::FETCH_ASSOC);
//echo '<pre>'; print_r($teachers);
foreach ($teachers as $teacher) {
    if ($teacher['addedunitid'] == $_SESSION['id']) {

        $gender = $teacher['usergender'];
        $gender = ($gender == 'M') ? 'Male' : 'Famale';
        //!Kullanıcının doğum tarihini alma
        $userBirthdate = $teacher['birthdate'];
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
      <th>{$teacher['userid']}</th>
      <td><img src='teacher_images/{$teacher['userimg']}' class='rounded-circle' width='100' height='100'></td>
      <td><a href='list.teacher.students.php?teacherid={$teacher['userid']}' class='link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover'>{$teacher['username']}</a></td>
      <td>{$teacher['useremail']}</td>
      <td>{$teacher['classname']}</td>
      <td>{$teacher['lessonname']}</td>
      <td>$gender</td>
      <td>{$teacher['useraddress']}</td>
      <td>{$teacher['phonenumber']}</td>
      <td>$formattedDate</td>
      <td><a href='update.teacher.php?idTeacher={$teacher['userid']}' class='btn btn-success btn-sm'>Update <i class='bi bi-arrow-clockwise'></i></a></td>
      <td><a href='list.teacher.php?removeTeacherid={$teacher['userid']}' onclick='return confirm(\"Are you sure you want to delete {$teacher['username']}?\")' class='btn btn-danger btn-sm'>Delete <i class='bi bi-trash'></i></a></td>
   </tr>
  ";
    }
}
?>
  </tbody>
</table>
</div>
<?php require 'down.html.php';?>

<!-- <td><a href='view.teacher.php?idTeacher={$teacher['userid']}' class=''>{$teacher['username']}</a></td> -->