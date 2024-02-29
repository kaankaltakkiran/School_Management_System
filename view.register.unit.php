<?php
@session_start();
$activeTitle = "School Management System";
$activePage = "view.register.unit";
require 'up.html.php';
require 'login.control.php';
?>
<?php
require_once 'db.php';
$id = $_GET['idregisterunit'];
$sql = "SELECT * FROM registerunits where userid = :idregisterunit";
$SORGU = $DB->prepare($sql);
$SORGU->bindParam(':idregisterunit', $id);
$SORGU->execute();
$registerunits = $SORGU->fetchAll(PDO::FETCH_ASSOC);
/* echo '<pre>';
print_r($registerunits);
die(); */
?>
  <?php
//! Rol idsi 1 olan admin register userları listeyebilir
if ($_SESSION['role'] != 1 || $registerunits[0]['adedadminid'] != $_SESSION['id']) {
    header("location: authorizationcontrol.php");
    die();
}
?>
<?php require 'navbar.php'?>
<?php
$gender = $registerunits[0]['usergender'];
$gender = ($gender == 'M') ? 'Male' : 'Famale';
//!Kullanıcının doğum tarihini alma
$userBirthdate = $registerunits[0]['birthdate'];
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
?>
<div class="container ">
  <div class="row justify-content-center mt-3 ">
 <div class="col-6">
 <div class="card" style="width: 18rem;">
  <img src="register_unit_images/<?php echo $registerunits[0]['userimg'] ?>" class='card-img-top'  alt="Student İmage">
  <div class="card-body">
    <h5 class="card-title"><?php echo "Register Unit" ?></h5>
    <p class="card-text"><?php echo $registerunits[0]['username'] ?></p>
  </div>
  <ul class="list-group list-group-flush">
    <li class="list-group-item">
      <span class="text-danger fw-bolder">User Name:</span>
      <?php echo $registerunits[0]['username'] ?>
    </li>
    <li class="list-group-item">
      <span class="text-danger fw-bolder">Email:</span>
      <?php echo $registerunits[0]['useremail'] ?>
    </li>
    <li class="list-group-item">
      <span class="text-danger fw-bolder">Gender:</span>
      <?php echo $gender ?>
    </li>
    <li class="list-group-item">
      <span class="text-danger fw-bolder">Create Date:</span>
      <?php echo $registerunits[0]['createdate'] ?>
    </li>
    <li class="list-group-item">
      <span class="text-danger fw-bolder">Adress:</span>
      <?php echo $registerunits[0]['useraddress'] ?>
    </li>
    <li class="list-group-item">
      <span class="text-danger fw-bolder">Phone Number:</span>
      <?php echo $registerunits[0]['phonenumber'] ?>
    </li>
    <li class="list-group-item">
      <span class="text-danger fw-bolder">BirthDate:</span>
      <?php echo $formattedDate ?>
    </li>
  </ul>
  <div class="card-body">
    <a href="list.register.unit.php" class="btn btn-warning">Go To List
    <i class="bi bi-backspace"></i>
    </a>
  </div>
</div>
 </div>
</div>
</div>

<?php require 'down.html.php';?>