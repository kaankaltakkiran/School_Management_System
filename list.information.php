<?php
session_start();
$activeTitle = "School İnformation List";
$activePage = "information.list";
require 'up.html.php';
require 'login.control.php';
?>
<?php require 'navbar.php'?>

    <div class="container">
      <div class="row mt-3">
      <div class='row justify-content-center text-center'>
        <div class="col-sm-4 col-md-6 col-lg-8">
  <h1 class='alert alert-primary mt-2'>School İnformation List</h1>
  </div>
  <div class='row text-end'>
  <p>
    <a href='add.information.php' class="btn btn-warning btn-sm ">
     Add School İnformation<i class="bi bi-send"></i> </a>
  </p>
</div>
</div>
<table class="table table-bordered table-striped">
  <thead>
    <tr>
      <th>School Id</th>
      <th>School Name</th>
      <th>School Year</th>
      <th>School Term</th>
      <th>School About</th>
      <th>School Summary</th>
      <th>School Address</th>
      <th>Create Date</th>
      <th>Update</th>
      <th>Delete</th>
    </tr>
  </thead>
  <tbody>
  </div>
    <?php
require_once 'db.php';
$SORGU = $DB->prepare("SELECT * FROM informations");
$SORGU->execute();
$informations = $SORGU->fetchAll(PDO::FETCH_ASSOC);
//echo '<pre>'; print_r($informations);
if (isset($_GET['removeSchoolid'])) {
    require 'db.php';
    $remove_id = $_GET['removeSchoolid'];

    $sql = "DELETE FROM informations WHERE schoolid = :removeSchoolid";
    $SORGU = $DB->prepare($sql);

    $SORGU->bindParam(':removeSchoolid', $remove_id);

    $SORGU->execute();
    echo "<script>
alert('School İnformation has been deleted. You are redirected to the School İnformation List page...!');
window.location.href = 'list.information.php';
</script>";
}

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
      <td>{$information['createdate']}</td>
      <td>{$information['createdate']}</td>
      <td><a href='list.information.php?removeSchoolid={$information['schoolid']}'onclick='return confirm(\"Are you sure you want to delete {$information['schoolname']}?\")' class='btn btn-danger btn-sm'>Delete</a></td>
   </tr>
  ";
}
?>
  </tbody>
</table>
</div>
<?php require 'down.html.php';?>