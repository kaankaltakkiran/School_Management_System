<?php
session_start();
$activeTitle = "Class Student List";
$activePage = "index";
require 'up.html.php';
?>
<?php require 'navbar.php'?>
<?php

require_once 'db.php';
$classİd = $_GET['idClass'];
$SORGU = $DB->prepare("SELECT * FROM students where classid = :idClass");
$SORGU->bindParam(':idClass', $classİd);
$SORGU->execute();
$classes = $SORGU->fetchAll(PDO::FETCH_ASSOC);
//echo '<pre>'; print_r($classes);
?>
    <div class="container">
      <div class="row mt-3">
      <div class='row justify-content-center text-center'>
        <div class="col-sm-4 col-md-6 col-lg-8">
  <h1 class='alert alert-primary mt-2'><?php echo $classes[0]['classname'] ?> Class </h1>
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
      <td>{$class['username']}</td>
      <td><a href='update.student.php?idStudent={$class['userid']}' class='btn btn-success btn-sm'>Update</a></td>
      <td><a href='list.class.php?removeClassid={$class['classid']}'onclick='return confirm(\"Are you sure you want to delete {$class['classname']}?\")' class='btn btn-danger btn-sm'>Delete</a></td>
   </tr>
  ";
}
?>

  </tbody>
</table>
</div>
<?php require 'down.html.php';?>