<?php
@session_start();
$activeTitle = "Parent List";
$activePage = "parent.list";
require 'up.html.php';
require 'login.control.php';
?>
<?php
//!Tekil Student silme
if (isset($_GET['removeparentid'])) {
    $approves = array();
    require 'db.php';
    $remove_id = $_GET['removeparentid'];
    $sql = "DELETE FROM parents WHERE userid = :removeparentid";
    $SORGU = $DB->prepare($sql);
    $SORGU->bindParam(':removeparentid', $remove_id);
    $SORGU->execute();
    $approves[] = "Parent Deleted Successfully...";
}
?>
<?php
//!Tüm Studentları  silme
if (isset($_POST['removeAllParents'])) {
    $approves = array();
    require 'db.php';
    $registerUnitid = $_SESSION['id'];
    $sql = "DELETE FROM parents WHERE addedunitid =:id";
    $SORGU = $DB->prepare($sql);
    $SORGU->bindParam(':id', $registerUnitid);
    $SORGU->execute();
    $approves[] = "All Parent Deleted Successfully...";
}
?>
<?php
//! Rol idsi 2 ve 3 olan register unit ve teacher sadece student listeyebilir
if ($_SESSION['role'] != 2 && $_SESSION['role'] != 3) {
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
  <h1 class='alert alert-primary mt-2'>Parent's List</h1>
  </div>
</div>
   <!-- tablo ile Parent listeleme -->
   <table id="example" class="table table-bordered table-striped " style="width:100%">
  <thead>
    <tr>
      <th>Id</th>
      <th>Img</th>
      <th>Parent Name</th>
      <th>Parent Email</th>
      <th>Parent Gender</th>
      <th>Parent Address</th>
      <th>Parent Phone Number</th>
      <th>Parent Birth date</th>
        <th>Manage</th>
    </tr>
  </thead>
  <tbody>
  </div>
    <?php
require_once 'db.php';
$id = $_SESSION['id'];
$SORGU = $DB->prepare("SELECT * FROM parents WHERE addedunitid = :id");
$SORGU->bindParam(':id', $id);
$SORGU->execute();
$parents = $SORGU->fetchAll(PDO::FETCH_ASSOC);
/* echo '<pre>';
print_r($parents);
die(); */
?>
<div class="row justify-content-end ">
  <div class="col-2">
    <form method="post">
    <?php if (count($parents) > 0) {?>
    <button type="sumbit" name="removeAllParents" onclick="return confirm('Are you sure you want to delete all students ?')" class="btn btn-danger float-end">Delete All Parent's <i class="bi bi-trash"></i> </button>
    <?php }?>
    </form>
    </div>
</div>
<?php
foreach ($parents as $parent) {
    $gender = $parent['usergender'];
    $gender = ($gender == 'M') ? 'Male' : 'Famale';
    //!Kullanıcının doğum tarihini alma
    $userBirthdate = $parent['birthdate'];
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
    if ($isRegisterUnit) {

    }
// Sonucu ekrana yazdırma
    $formattedDate = "$day $monthName $year";

    echo "
    <tr>
    <th>{$parent['userid']}</th>
    <td><img src='parent_images/{$parent['userimg']}' class='rounded-circle' width='100' height='100'></td>
    <td><a href='view.parent.php?idparent={$parent['userid']}' class='link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover'>{$parent['username']}</a></td>
    <td>{$parent['useremail']}</td>
    <td>$gender</td>
    <td>{$parent['useraddress']}</td>
    <td>{$parent['phonenumber']}</td>
    <td>$formattedDate</td>
    <td>
    <a href='update.parent.php?parentid={$parent['userid']}' class='btn btn-success mb-3  btn-sm'>Update <i class='bi bi-arrow-clockwise'></i></a>
    <a href='list.parent.php?removeparentid={$parent['userid']}'onclick='return confirm(\"Are you sure you want to delete {$parent['username']}?\")' class='btn btn-danger btn-sm'>Delete <i class='bi bi-trash'></i></a>
  </td>
 </tr>
    ";
}
?>
  </tbody>
</table>
</div>
<?php require 'footer.php';?>
<?php require 'down.html.php';?>