<?php
session_start();
$activeTitle = "Register Unit List";
$activePage = "register.unit.list";
require 'up.html.php';
require 'login.control.php';
?>
<?php
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
  <h1 class='alert alert-primary mt-2'>Register Unit List</h1>
  </div>
  <div class='row text-end'>
  <p>
    <a href='add.register.unit.php' class="btn btn-warning btn-sm ">
     Add New Register Unit User <i class="bi bi-send"></i> </a>
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

if (isset($_GET['removeRegisterUnitid'])) {
    require 'db.php';
    $remove_id = $_GET['removeRegisterUnitid'];

    $sql = "DELETE FROM registerunits WHERE userid = :removeRegisterUnitid";
    $SORGU = $DB->prepare($sql);

    $SORGU->bindParam(':removeRegisterUnitid', $remove_id);

    $SORGU->execute();
    echo "<script>
alert('The Register Unit User has been deleted. You are redirected to the Register Unit List page...!');
window.location.href = 'list.register.unit.php';
</script>";
}

foreach ($registerunits as $registerunit) {
    $gender = $registerunit['usergender'];
    $gender = ($gender == 'M') ? 'Male' : 'Famale';
    //!Kullanıcının doğum tarihini alma
    $userBirthdate = $registerunit['birthdate'];
    //!Tarihi parçalara ayırma
    /* explode() fonksiyonu: Bu fonksiyon, bir metni belirli bir ayraç karakterine göre böler ve bir diziye dönüştürür.  */
    $dateParts = explode('-', $userBirthdate);

    //? Yıl, ay ve gün bilgilerini alıyoruz
    $year = $dateParts[0];
    $month = $dateParts[1];
    $day = $dateParts[2];

    //?Ay ismini bulmak için date() ve strtotime() fonksiyonlarını kullanıyoruz
    //!F tam ay ismini alıyor.
    $monthName = date("F", strtotime($userBirthdate));

    // Sonucu ekrana yazdırma
    $formattedDate = "$day $monthName $year";

    echo "
    <tr>
      <th>{$registerunit['userid']}</th>
      <td><img src='register_unit_images/{$registerunit['userimg']}' class='rounded-circle' width='100' height='100'></td>
      <td><a class='link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover' href='view.register.unit.php?idregisterunit={$registerunit['userid']}'>{$registerunit['username']}</a></td>
      <td>{$registerunit['useremail']}</td>
      <td>$gender</td>
      <td>{$registerunit['createdate']}</td>
      <td>{$registerunit['useraddress']}</td>
      <td>{$registerunit['phonenumber']}</td>
      <td>$formattedDate</td>
      <td><a href='update.register.unit.php?idRegisterUnit={$registerunit['userid']}' class='btn btn-success btn-sm'>Update <i class='bi bi-arrow-clockwise'></i></a></td>
      <td><a href='update.register.unit.php?idRegisterUnit={$registerunit['userid']}' onclick='return confirm(\"Are you sure you want to delete {$registerunit['username']}?\")' class='btn btn-danger btn-sm'>Delete <i class='bi bi-trash'></i></a></td>
   </tr>
  ";
}
?>

  </tbody>
</table>
</div>
<?php require 'down.html.php';?>