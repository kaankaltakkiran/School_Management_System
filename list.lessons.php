<?php
session_start();
$activeTitle = "Lessons List";
$activePage = "lesson.list";
require 'up.html.php';
require 'login.control.php';
?>
<?php
if (isset($_GET['removeLessonid'])) {
    $approves = array();
    require 'db.php';
    $remove_id = $_GET['removeLessonid'];
    $sql = "DELETE FROM lessons WHERE lessonid = :removeLessonid";
    $SORGU = $DB->prepare($sql);
    $SORGU->bindParam(':removeLessonid', $remove_id);
    $SORGU->execute();
    $approves[] = "Lesson Deleted Successfully...";
}
?>
<?php
//! Rol idsi 2 olan kayıt birimi ders listesini görebilir
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
foreach ($lessons as $lesson) {
    if ($lesson['addedunitid'] == $_SESSION['id']) {
        echo "
    <tr>
      <th>{$lesson['lessonid']}</th>
      <td><a href='list.student.lesson.php?lessonName={$lesson['lessonname']}' class='link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover'>{$lesson['lessonname']}</a></td>
      <td><a href='update.lesson.php?lessonid={$lesson['lessonid']}' class='btn btn-success btn-sm'>Update <i class='bi bi-arrow-clockwise'></i></a></td>
      <td><a href='list.lessons.php?removeLessonid={$lesson['lessonid']}'onclick='return confirm(\"Are you sure you want to delete {$lesson['lessonname']}?\")' class='btn btn-danger btn-sm'>Delete <i class='bi bi-trash'></i></a></td>
   </tr>
  ";
    }
}
?>
  </tbody>
</table>
</div>
<?php require 'down.html.php';?>