<?php
@session_start();
$activeTitle = "School Management System";
$activePage = "view.admin";
require 'up.html.php';
require 'login.control.php';
?>
<?php
if ($_SESSION['role'] == 1) {
    $role = "Admin";
}
?>
<?php require 'navbar.php'?>
<?php
require_once 'db.php';
$id = $_GET['idAdmin'];
$sql = "SELECT * FROM admins where userid = :idAdmin";
$SORGU = $DB->prepare($sql);
$SORGU->bindParam(':idAdmin', $id);
$SORGU->execute();
$admins = $SORGU->fetchAll(PDO::FETCH_ASSOC);
/* echo '<pre>';
print_r($admins);
die(); */
$gender = $admins[0]['usergender'];
$gender = ($gender == 'M') ? 'Male' : 'Famale';
?>
<div class="container ">
  <div class="row justify-content-center mt-3 ">
 <div class="col-6">
 <div class="card" style="width: 18rem;">
  <img src="admin_images/<?php echo $admins[0]['userimg'] ?>" class='card-img-top'  alt="Student İmage">
  <div class="card-body">
    <h5 class="card-title"><?php echo $role ?></h5>
    <p class="card-text"><?php echo $admins[0]['username'] ?></p>
  </div>
  <ul class="list-group list-group-flush">
    <li class="list-group-item">
      <span class="text-danger fw-bolder">User Name:</span>
      <?php echo $admins[0]['username'] ?>
    </li>
    <li class="list-group-item">
      <span class="text-danger fw-bolder">Email:</span>
      <?php echo $admins[0]['useremail'] ?>
    </li>
    <li class="list-group-item">
      <span class="text-danger fw-bolder">Gender:</span>
      <?php echo $gender ?>
    </li>
  </ul>
  <div class="card-body">
    <a href="list.admin.php" class="btn btn-warning">Go To List
    <i class="bi bi-backspace"></i>
    </a>
  </div>
</div>
 </div>
</div>
</div>

<?php require 'down.html.php';?>