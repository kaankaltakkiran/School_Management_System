<?php
session_start();
$activeTitle = "Student List";
$activePage = "index";
require 'up.html.php';
require 'login.control.php';
?>
<?php require 'navbar.php'?>

    <div class="container">
      <div class="row mt-3">
      <div class='row justify-content-center text-center'>
        <div class="col-sm-4 col-md-6 col-lg-8">
  <h1 class='alert alert-primary mt-2'>Student List</h1>
  </div>
  <div class='row text-end'>
  <p>
    <a href='add.student.php' class="btn btn-warning btn-sm ">
     Add New Student<i class="bi bi-send"></i> </a>
  </p>
</div>
</div>
   <!-- tablo ile personel listeleme -->
<table class="table table-bordered table-striped">
  <thead>
    <tr>
      <th>Class Id</th>
      <th>Class Name</th>
      <th>Create Date</th>
      <th>List Student</th>
    </tr>
  </thead>
  <tbody>
  </div>

    <?php

require_once 'db.php';

$SORGU = $DB->prepare("SELECT * FROM classes LIMIT 16");
$SORGU->execute();
$classes = $SORGU->fetchAll(PDO::FETCH_ASSOC);
//echo '<pre>'; print_r($classes);
if (isset($_GET['removeClassid'])) {
    require 'db.php';
    $remove_id = $_GET['removeClassid'];

    $sql = "DELETE FROM classes WHERE classid = :removeClassid";
    $SORGU = $DB->prepare($sql);

    $SORGU->bindParam(':removeClassid', $remove_id);

    $SORGU->execute();
    echo "<script>
alert('Class has been deleted. You are redirected to the Class List page...!');
window.location.href = 'list.class.php';
</script>";
}

foreach ($classes as $class) {
    echo "
    <tr>
      <th>{$class['classid']}</th>
      <td>{$class['classname']}</td>
      <td>{$class['createdate']}</td>
      <td><a href='list.class.student.php?idClass={$class['classid']}' class='btn btn-info btn-sm'>List Student</a></td>
   </tr>
  ";
}
?>

  </tbody>
</table>
</div>
<?php require 'down.html.php';?>