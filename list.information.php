<?php
@session_start();
$activeTitle = "School İnformation List";
$activePage = "information.list";
require 'up.html.php';
require 'login.control.php';
?>
<?php
if (isset($_GET['removeSchoolid'])) {
    $approves = array();
    require 'db.php';
    $remove_id = $_GET['removeSchoolid'];
    $sql = "DELETE FROM informations WHERE schoolid = :removeSchoolid";
    $SORGU = $DB->prepare($sql);
    $SORGU->bindParam(':removeSchoolid', $remove_id);
    $SORGU->execute();
    $approves[] = "School İnformation Deleted Successfully...";
}
?>
  <?php
//! Rol idsi 2 olan register unit sadece school information listeyebilir
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
  <h1 class='alert alert-primary mt-2'>School İnformation List</h1>
  </div>
  <div class='row text-end'>
  <p>
    <a href='add.information.php' class="btn btn-warning btn-sm ">
     Add School İnformation <i class="bi bi-send"></i> </a>
  </p>
</div>
</div>
<table id="example" class="table table-bordered table-striped " style="width:100%">
  <thead>
    <tr>
      <th>School Id</th>
      <th>School Name</th>
      <th>School Year</th>
      <th>School Term</th>
      <th>School About</th>
      <th>School Summary</th>
      <th>School Address</th>
      <th>Update</th>
      <th>Delete</th>
    </tr>
  </thead>
  <tbody>
  </div>
    <?php
require_once 'db.php';
$adedid = $_SESSION['id'];
$SORGU = $DB->prepare("SELECT * FROM informations WHERE addedunitid = :id");
$SORGU->bindParam(':id', $adedid);
$SORGU->execute();
$informations = $SORGU->fetchAll(PDO::FETCH_ASSOC);
//echo '<pre>'; print_r($informations);
foreach ($informations as $information) {
    echo "
    <tr>
      <th>{$information['schoolid']}</th>
      <td>{$information['schoolname']}</td>
      <td>{$information['schoolyear']}</td>
      <td>{$information['schoolterm']}</td>
      <td>{$information['schoolabout']}</td>
      <td>{$information['schoolsummary']}</td>
      <td>{$information['schooladdress']}</td>
      <td><a href='update.information.php?schoolid={$information['schoolid']}' class='btn btn-success btn-sm'>Update <i class='bi bi-arrow-clockwise'></i></a></td>
      <td><a href='list.information.php?removeSchoolid={$information['schoolid']}'onclick='return confirm(\"Are you sure you want to delete {$information['schoolname']}?\")' class='btn btn-danger btn-sm'>Delete <i class='bi bi-trash'></i></a></td>
   </tr>
  ";
}
?>
  </tbody>
</table>
</div>
<?php require 'down.html.php';?>