<?php
session_start();
$activeTitle = "Class Student List";
$activePage = "index";
require 'up.html.php';
require 'login.control.php';
?>
<?php require 'navbar.php'?>
<?php

require_once 'db.php';
$classİd = $_GET['idClass'];
$SORGU = $DB->prepare("SELECT * FROM students where classid = :idClass");
$SORGU->bindParam(':idClass', $classİd);
$SORGU->execute();
$students = $SORGU->fetchAll(PDO::FETCH_ASSOC);
//echo '<pre>'; print_r($students);
?>
    <div class="container">
      <div class="row mt-3">
      <div class='row justify-content-center text-center'>
        <div class="col-sm-4 col-md-6 col-lg-8">
  <h1 class='alert alert-primary mt-2'><?php echo $students[0]['classname'] ?> Class </h1>
  </div>
  <div class='row text-end'>
  <p>
    <a href='add.class.php' class="btn btn-warning btn-sm ">
     Add New Student<i class="bi bi-send"></i> </a>
  </p>
</div>
</div>
   <!-- tablo ile personel listeleme -->
<table class="table table-bordered table-striped">
  <thead>
    <tr>
      <th>Student Id</th>
      <th>Student Name</th>
      <th>Update</th>
      <th>Delete</th>
    </tr>
  </thead>
  <tbody>
  </div>

    <?php

if (isset($_GET['removestudentid'])) {
    require 'db.php';
    $remove_id = $_GET['removestudentid'];

    $sql = "DELETE FROM students WHERE userid = :removestudentid";
    $SORGU = $DB->prepare($sql);

    $SORGU->bindParam(':removestudentid', $remove_id);

    $SORGU->execute();
    echo "<script>
alert('Student has been deleted. You are redirected to the Student List page...!');
window.location.href = 'list.student.php';
</script>";
}

foreach ($students as $student) {
    echo "
    <tr>
      <th>{$student['classid']}</th>
      <td><a href='view.student.php?idStudent={$student['userid']}' class=''>{$student['username']}</a></td>
      <td><a href='update.student.php?idStudent={$student['userid']}' class='btn btn-success btn-sm'>Update</a></td>
      <td><a href='list.class.student.php?removestudentid={$student['userid']}'onclick='return confirm(\"Are you sure you want to delete {$student['username']}?\")' class='btn btn-danger btn-sm'>Delete</a></td>
   </tr>
  ";
}
?>

  </tbody>
</table>
</div>
<?php require 'down.html.php';?>