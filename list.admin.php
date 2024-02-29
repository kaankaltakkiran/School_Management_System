<?php
session_start();
$activeTitle = "Admin List";
$activePage = "admin.list";
require 'up.html.php';
require 'login.control.php';
?>
<?php
//! Rol idsi 1 olan admin kullanıcılar listeyebilir
if ($_SESSION['role'] != 1) {
    header("location: authorizationcontrol.php");
    die();
}
?>
<?php require 'navbar.php'?>
    <div class="container">
      <div class="row mt-3">
      <div class='row justify-content-center text-center'>
        <div class="col-sm-4 col-md-6 col-lg-8">
  <h1 class='alert alert-primary mt-2'>Admin User List</h1>
  </div>
  <div class='row text-end'>
  <p>
    <a href='add.admin.php' class="btn btn-warning btn-sm ">
     Add New Admin User <i class="bi bi-send"></i> </a>
  </p>
</div>
</div>
   <!-- tablo ile admin listeleme -->
<table class="table table-bordered table-striped">
  <thead>
    <tr>
      <th>User Id</th>
      <th>Admin Image</th>
      <th>User Name</th>
      <th>Email</th>
      <th>Gender</th>
      <th>Create Date</th>
      <th>Update</th>
      <th>Delete</th>
    </tr>
  </thead>
  <tbody>
  </div>

    <?php
$id = $_SESSION['id'];
require_once 'db.php';
if ($_SESSION['id'] == 1) {
    $SORGU = $DB->prepare("SELECT * FROM admins");
} else {
    $SORGU = $DB->prepare("SELECT * FROM admins WHERE userid =:id");
    $SORGU->bindParam(':id', $id);
}
$SORGU->execute();
$admins = $SORGU->fetchAll(PDO::FETCH_ASSOC);
//echo '<pre>'; print_r($admins);

if (isset($_GET['removeAdminid'])) {
    require 'db.php';
    $remove_id = $_GET['removeAdminid'];
    $sql = "DELETE FROM admins WHERE userid = :removeAdminid";
    $SORGU = $DB->prepare($sql);
    $SORGU->bindParam(':removeAdminid', $remove_id);
    $SORGU->execute();
    echo "<script>
alert('The Admin User has been deleted. You are redirected to the Admin List page...!');
window.location.href = 'list.admin.php';
</script>";
}

foreach ($admins as $admin) {
    $gender = $admin['usergender'];
    $gender = ($gender == 'M') ? 'Male' : 'Famale';
    echo "
    <tr>
      <th>{$admin['userid']}</th>
      <td><img src='admin_images/{$admin['userimg']}' class='rounded-circle' width='100' height='100'></td>
      <td><a class='link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover' href='view.admin.php?idAdmin={$admin['userid']}'>{$admin['username']}</a></td>
      <td>{$admin['useremail']}</td>
      <td>$gender</td>
      <td>{$admin['createdate']}</td>
      <td><a href='update.admin.php?idAdmin={$admin['userid']}' class='btn btn-success btn-sm'>Update <i class='bi bi-arrow-clockwise'></i></a></td>
      <td><a href='list.admin.php?removeAdminid={$admin['userid']}' onclick='return confirm(\"Are you sure you want to delete {$admin['username']}?\")' class='btn btn-danger btn-sm'>Delete <i class='bi bi-trash'></i></a></td>
   </tr>
  ";
}
?>
  </tbody>
</table>
</div>
<?php require 'down.html.php';?>