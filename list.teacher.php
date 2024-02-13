<?php
session_start();
$activeTitle = "Teacher User List";
$activePage = "teacher.list";
require 'up.html.php';
require 'login.control.php';
?>
<?php
if ($_SESSION['role'] != 2) {
    header("location: authorizationcontrol.php");
    die();
}
?>
<?php require 'navbar.php'?>

    <div class="container">
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
      <th>Create Date</th>
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

if (isset($_GET['removeTeacherid'])) {
    require 'db.php';
    $remove_id = $_GET['removeTeacherid'];

    $sql = "DELETE FROM teachers WHERE userid = :removeTeacherid";
    $SORGU = $DB->prepare($sql);

    $SORGU->bindParam(':removeTeacherid', $remove_id);

    $SORGU->execute();
    echo "<script>
alert('The Teacher User has been deleted. You are redirected to the Teacher User List page...!');
window.location.href = 'list.teacher.php';
</script>";
}

foreach ($teachers as $teacher) {
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
      <td><a href='list.teacher.students.php?teacherid={$teacher['userid']}' class=''>{$teacher['username']}</a></td>
      <td>{$teacher['useremail']}</td>
      <td>{$teacher['classname']}</td>
      <td>{$teacher['lessonname']}</td>
      <td>$gender</td>
      <td>{$teacher['createdate']}</td>
      <td>{$teacher['useraddress']}</td>
      <td>{$teacher['phonenumber']}</td>
      <td>$formattedDate</td>
      <td><a href='update.teacher.php?idTeacher={$teacher['userid']}' class='btn btn-success btn-sm'>Update <i class='bi bi-arrow-clockwise'></i></a></td>
      <td><a href='list.teacher.php?removeTeacherid={$teacher['userid']}' onclick='return confirm(\"Are you sure you want to delete {$teacher['username']}?\")' class='btn btn-danger btn-sm'>Delete <i class='bi bi-trash'></i></a></td>
   </tr>
  ";
}
?>

  </tbody>
</table>
</div>
<?php require 'down.html.php';?>

<!-- <td><a href='view.teacher.php?idTeacher={$teacher['userid']}' class=''>{$teacher['username']}</a></td> -->