<?php
session_start();
$activeTitle = "Lessons List";
$activePage = "index";
require 'up.html.php';
?>
<?php require 'navbar.php'?>

    <div class="container">
      <div class="row mt-3">
      <div class='row justify-content-center text-center'>
        <div class="col-sm-4 col-md-6 col-lg-8">
  <h1 class='alert alert-primary mt-2'>Lessons List</h1>
  </div>
  <div class='row text-end'>
  <p>
    <a href='add.lesson.php' class="btn btn-warning btn-sm ">
     Add New Lesson<i class="bi bi-send"></i> </a>
  </p>
</div>
</div>
   <!-- tablo ile personel listeleme -->
<table class="table table-bordered table-striped">
  <thead>
    <tr>
      <th>Lesson Id</th>
      <th>Lesson Name</th>
      <th>Create Date</th>
      <th>Update</th>
      <th>Delete</th>
    </tr>
  </thead>
  <tbody>
  </div>

    <?php

require_once 'db.php';

$SORGU = $DB->prepare("SELECT * FROM lessons LIMIT 16");
$SORGU->execute();
$lessons = $SORGU->fetchAll(PDO::FETCH_ASSOC);
//echo '<pre>'; print_r($lessons);
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

foreach ($lessons as $lesson) {
    echo "
    <tr>
      <th>{$lesson['lessonid']}</th>
      <td>{$lesson['lessonname']}</td>
      <td>{$lesson['createdate']}</td>
      <td><a href='update.lesson.php?lessonid={$lesson['lessonid']}' class='btn btn-success btn-sm'>Update</a></td>
      <td><a href='list.class.php?removeClassid={$lesson['lessonid']}'onclick='return confirm(\"Are you sure you want to delete {$lesson['lessonname']}?\")' class='btn btn-danger btn-sm'>Delete</a></td>
   </tr>
  ";
}
?>

  </tbody>
</table>
</div>
<?php require 'down.html.php';?>