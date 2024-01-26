<?php
session_start();
$activeTitle = "Lesson Update";
$activePage = "index";
require 'up.html.php';
?>
    <?php include 'navbar.php';?>
  <div class="container">
  <div class="row justify-content-center mt-3">
  <div class="col-6">

<form method="POST"enctype="multipart/form-data">
<h1 class="alert alert-info text-center">Lesson Update</h1>
<?php
require_once 'db.php';

$id = $_GET['lessonid'];

$sql = "SELECT * FROM lessons WHERE lessonid = :lessonid";
$SORGU = $DB->prepare($sql);

$SORGU->bindParam(':lessonid', $id);

$SORGU->execute();

$lessons = $SORGU->fetchAll(PDO::FETCH_ASSOC);
/* var_dump($lessons);
die(); */

if (isset($_POST['form_submit'])) {

    $lessonName = $_POST['from_lessonname'];

    $sql = "UPDATE lessons SET lessonname = :from_lessonname WHERE lessonid = :lessonid";
    $SORGU = $DB->prepare($sql);

    $SORGU->bindParam(':from_lessonname', $lessonName);
    $SORGU->bindParam(':lessonid', $id);
    $SORGU->execute();
    echo '<script>';
    echo 'alert("Lesson  Update Successful!");';
    echo 'window.location.href = "update.lesson.php?lessonid=' . $lessons[0]['lessonid'] . '";';
    echo '</script>';
}

?>
<div class="form-floating mb-3">
  <input type="text"  class="form-control" value="<?php echo $_SESSION['userName'] ?>"disabled readonly>
  <label>Added By Admin Name</label>
</div>
<div class="form-floating mb-3">
  <input type="text"  class="form-control" value="<?php echo $lessons[0]['lessonname'] ?>" name="from_lessonname">
  <label>User Name</label>
</div>
                  <button type="submit" name="form_submit" class="btn btn-primary mt-3 ">Update Lesson</button>
     </form>
     </div>

</div>

</div>
<?php require 'down.html.php';?>