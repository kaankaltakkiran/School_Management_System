<?php
session_start();
$activeTitle = "Admin List";
$activePage = "admin.list";
require 'up.html.php';
require 'login.control.php';
?>
<?php
if (isset($_GET['removeAdminid'])) {
    $approves = array();
    require 'db.php';
    $remove_id = $_GET['removeAdminid'];
    $sql = "DELETE FROM admins WHERE userid = :removeAdminid";
    $SORGU = $DB->prepare($sql);
    $SORGU->bindParam(':removeAdminid', $remove_id);
    $SORGU->execute();
    $approves[] = "Admin Deleted Successfully...";
}
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

foreach ($admins as $admin) {
    $gender = $admin['usergender'];
    $gender = ($gender == 'M') ? 'Male' : 'Famale';
    //! Kendi kullanıcısını silemez
    if ($admin['userid'] == $_SESSION['id']) {
        $deleteButton = "<span class='badge text-bg-danger fw-bold'>You Can't Delete Yourself !</span>";
    } else {
        $deleteButton = "<a href='list.admin.php?removeAdminid={$admin['userid']}' onclick='return confirm(\"Are you sure you want to delete {$admin['username']}?\")' class='btn btn-danger btn-sm'>Delete <i class='bi bi-trash'></i></a>";
    }
    echo "
    <tr>
      <th>{$admin['userid']}</th>
      <td><img src='admin_images/{$admin['userimg']}' class='rounded-circle' width='100' height='100'></td>
      <td><a class='link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover' href='view.admin.php?idAdmin={$admin['userid']}'>{$admin['username']}</a></td>
      <td>{$admin['useremail']}</td>
      <td>$gender</td>
      <td>{$admin['createdate']}</td>
      <td><a href='update.admin.php?idAdmin={$admin['userid']}' class='btn btn-success btn-sm'>Update <i class='bi bi-arrow-clockwise'></i></a></td>
      <td>{$deleteButton}</td>
   </tr>
  ";
}
?>
  </tbody>
</table>
</div>
<?php require 'down.html.php';?>