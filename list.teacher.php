<?php
session_start();
$activeTitle = "Teacher User List";
$activePage = "index";
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
     Add New Teacher User<i class="bi bi-send"></i> </a>
  </p>
</div>
</div>
   <!-- tablo ile personel listeleme -->
<table class="table table-bordered table-striped">
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

    echo "
    <tr>
      <th>{$teacher['userid']}</th>
      <td><img src='teacher_images/{$teacher['userimg']}' class='rounded-circle' width='100' height='100'></td>
      <td><a href='view.teacher.php?idTeacher={$teacher['userid']}' class=''>{$teacher['username']}</a></td>
      <td>{$teacher['useremail']}</td>
      <td>{$teacher['classname']}</td>
      <td>{$teacher['lessonname']}</td>
      <td>$gender</td>
      <td>{$teacher['createdate']}</td>
      <td>{$teacher['useraddress']}</td>
      <td>{$teacher['phonenumber']}</td>
      <td>{$teacher['birthdate']}</td>
      <td><a href='update.teacher.php?idTeacher={$teacher['userid']}' class='btn btn-success btn-sm'>Update</a></td>
      <td><a href='list.teacher.php?removeTeacherid={$teacher['userid']}' onclick='return confirm(\"Are you sure you want to delete {$teacher['username']}?\")' class='btn btn-danger btn-sm'>Delete</a></td>
   </tr>
  ";
}
?>

  </tbody>
</table>
</div>
<?php require 'down.html.php';?>