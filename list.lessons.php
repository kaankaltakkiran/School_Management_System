<?php
session_start();
$activeTitle = "Lessons List";
$activePage = "lesson.list";
require 'up.html.php';
require 'login.control.php';
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
     Add New Lesson <i class="bi bi-send"></i> </a>
  </p>
</div>
</div>
   <!-- tablo ile lesson listeleme -->
   <table id="example" class="table table-bordered table-striped " style="width:100%">
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
if (isset($_GET['removeLessonid'])) {
    require 'db.php';
    $remove_id = $_GET['removeLessonid'];

    $sql = "DELETE FROM lessons WHERE lessonid = :removeLessonid";
    $SORGU = $DB->prepare($sql);

    $SORGU->bindParam(':removeLessonid', $remove_id);

    $SORGU->execute();
    echo "<script>
alert('Lesson has been deleted. You are redirected to the Lesson List page...!');
window.location.href = 'list.lessons.php';
</script>";
}

foreach ($lessons as $lesson) {
    echo "
    <tr>
      <th>{$lesson['lessonid']}</th>
      <td><a href='list.student.lesson.php?lessonName={$lesson['lessonname']}' class=''>{$lesson['lessonname']}</a></td>
      <td>{$lesson['createdate']}</td>
      <td><a href='update.lesson.php?lessonid={$lesson['lessonid']}' class='btn btn-success btn-sm'>Update <i class='bi bi-arrow-clockwise'></i></a></td>
      <td><a href='list.lessons.php?removeLessonid={$lesson['lessonid']}'onclick='return confirm(\"Are you sure you want to delete {$lesson['lessonname']}?\")' class='btn btn-danger btn-sm'>Delete <i class='bi bi-trash'></i></a></td>
   </tr>
  ";
}
?>

  </tbody>
</table>
</div>
<?php require 'down.html.php';?>