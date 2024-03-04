<?php
@session_start();
$activeTitle = "Class List";
$activePage = "class.list";
require 'up.html.php';
require 'login.control.php';
?>
<?php
if (isset($_GET['removeClassid'])) {
    $approves = array();
    require 'db.php';
    $remove_id = $_GET['removeClassid'];
    $sql = "DELETE FROM classes WHERE classid = :removeClassid";
    $SORGU = $DB->prepare($sql);
    $SORGU->bindParam(':removeClassid', $remove_id);
    $SORGU->execute();
    $approves[] = "Class Deleted Successfully...";
}
?>
<?php
//! Rol idsi 2 olan kayıt birimi sınıf listesini görebilir
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
  <h1 class='alert alert-primary mt-2'>Class List</h1>
  </div>
  <div class='row text-end'>
  <p>
    <a href='add.class.php' class="btn btn-warning btn-sm ">
     Add New Class <i class="bi bi-send"></i> </a>
  </p>
</div>
</div>
   <!-- tablo ile Class listeleme -->
   <table id="example" class="table table-bordered table-striped " style="width:100%">
  <thead>
    <tr>
      <th>Class Id</th>
      <th>Class Name</th>
      <th>Update</th>
      <th>Delete</th>
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
foreach ($classes as $class) {
    echo "
    <tr>
      <th>{$class['classid']}</th>
      <td><a href='list.student.class.php?className={$class['classname']}' class='link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover'>{$class['classname']}</a></td>
      <td><a href='update.class.php?idClass={$class['classid']}' class='btn btn-success btn-sm'>Update <i class='bi bi-arrow-clockwise'></i></a></td>
      <td><a href='list.class.php?removeClassid={$class['classid']}'onclick='return confirm(\"Are you sure you want to delete {$class['classname']}?\")' class='btn btn-danger btn-sm'>Delete <i class='bi bi-trash'></i></a></td>
   </tr>
  ";
}
?>
  </tbody>
</table>
</div>
<?php require 'down.html.php';?>