<?php
session_start();
$activeTitle = "Register Unit List";
$activePage = "index";
require 'up.html.php';
?>
<?php require 'navbar.php'?>

    <div class="container">
      <div class="row mt-3">
      <div class='row justify-content-center text-center'>
        <div class="col-sm-4 col-md-6 col-lg-8">
  <h1 class='alert alert-primary mt-2'>Register Unit List</h1>
  </div>
  <div class='row text-end'>
  <p>
    <a href='add.admin.php' class="btn btn-warning btn-sm ">
     Add New Register Unit User<i class="bi bi-send"></i> </a>
  </p>
</div>
</div>
   <!-- tablo ile personel listeleme -->
<table class="table table-bordered table-striped">
  <thead>
    <tr>
      <th>User Id</th>
      <th>Register Unit Image</th>
      <th>User Name</th>
      <th>Email</th>
      <th>Gender</th>
      <th>Create Date</th>
      <th>Address</th>
      <th>Phone Number</th>
      <th>BirthDate</th>
      <th>Update</th>
      <th>Delete</th>
    </tr>
  </thead>
  <tbody>
  </div>

    <?php

require_once 'db.php';

$SORGU = $DB->prepare("SELECT * FROM registerunits");
$SORGU->execute();
$registerunits = $SORGU->fetchAll(PDO::FETCH_ASSOC);
//echo '<pre>'; print_r($registerunits);

if (isset($_GET['idAdminRemove'])) {
    require 'db.php';
    $remove_id = $_GET['idAdminRemove'];
    $id = $_SESSION['id'];

    $sql = "DELETE FROM admins WHERE userid = :idAdminRemove";
    $SORGU = $DB->prepare($sql);

    $SORGU->bindParam(':idAdminRemove', $remove_id);

    $SORGU->execute();
    echo "<script>
alert('The Admin User has been deleted. You are redirected to the Admin List page...!');
window.location.href = 'list.admin.php';
</script>";
}

foreach ($registerunits as $registerunit) {
    $gender = $registerunit['usergender'];
    $gender = ($gender == 'M') ? 'Male' : 'Famale';
    //! Eğer $_SESSION içerisindeki id, şu anki adminin id'sine eşit değilse silemesin
    $deleteButton = ($_SESSION['id'] != $registerunit['userid']) ?
    "<a href='list.admin.php?idAdminRemove={$registerunit['userid']}' onclick='return confirm(\"Are you sure you want to delete {$registerunit['username']}?\")' class='btn btn-danger btn-sm'>Delete</a>" :
    "<span class='text-danger fw-bold '>You can't Delete yourself!!!</span>";

    echo "
    <tr>
      <th>{$registerunit['userid']}</th>
      <td><img src='register_unit_images/{$registerunit['userimg']}' class='rounded-circle' width='100' height='100'></td>
      <td>{$registerunit['username']}</td>
      <td>{$registerunit['useremail']}</td>
      <td>$gender</td>
      <td>{$registerunit['createdate']}</td>
      <td>{$registerunit['useraddress']}</td>
      <td>{$registerunit['phonenumber']}</td>
      <td>{$registerunit['birthdate']}</td>
      <td><a href='update.admin.php?idAdmin={$registerunit['userid']}' class='btn btn-success btn-sm'>Update</a></td>
      <td>$deleteButton</td>
   </tr>
  ";
}
?>

  </tbody>
</table>
</div>
<?php require 'down.html.php';?>