<?php
@session_start();
$activeTitle = "List Parent";
$activePage = "list.parent";
require 'up.html.php';
require 'login.control.php';
?>
<?php
//!Tekil Lesson silme
//? Mesajtan sonra 3 saniye sonra list.student.php sayfasına yönlendirme yapar.
if (isset($_GET['removeparentid'])) {
    $approves = array();
    require 'db.php';
    $remove_id = $_GET['removeparentid'];
    $sql = "DELETE FROM parents WHERE userid = :removeparentid";
    $SORGU = $DB->prepare($sql);
    $SORGU->bindParam(':removeparentid', $remove_id);
    $SORGU->execute();
    $approves[] = "Student Parent's Deleted Successfully...";
    echo "<script>
    setTimeout(function() {
        window.location.href = 'list.student.php';
    }, 3000);
  </script>";
}
?>
<?php
//! Student id
$get_student_id = $_GET['idStudent'];
require_once 'db.php';
$SORGU = $DB->prepare("SELECT * FROM parents WHERE studentid=:idStudent");
$SORGU->bindParam(':idStudent', $get_student_id);
$SORGU->execute();
$parents = $SORGU->fetchAll(PDO::FETCH_ASSOC);
/* echo '<pre>';
print_r($parents);
die(); */
$gender = $parents[0]['usergender'];
$gender = ($gender == 'M') ? 'Male' : 'Famale';
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
        <?php
//! Student id
$get_student_id = $_GET['idStudent'];
require_once 'db.php';
$SORGU = $DB->prepare("SELECT * FROM students WHERE userid=:idStudent");
$SORGU->bindParam(':idStudent', $get_student_id);
$SORGU->execute();
$students = $SORGU->fetchAll(PDO::FETCH_ASSOC);
/* echo '<pre>';
print_r($students);
die(); */
?>
  <h1 class='alert alert-primary mt-2'><?php echo $students[0]['username'] ?> Parent's</h1>
  </div>
</div>
   <table id="example" class="table table-bordered table-striped " style="width:100%">
  <thead>
    <tr>
      <th>Parent Id</th>
      <th>Parent Image</th>
      <th>Parent Name</th>
      <th>Parent Gender</th>
      <th>Parent Address</th>
      <th>Parent Phone Number</th>
      <th>Parent Birthdate</th>
      <th>Update</th>
      <th>Delete</th>
    </tr>
  </thead>
  <tbody>
  </div>
    <?php
foreach ($parents as $parent) {
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

// Sonucu ekrana yazdırma
    $formattedDate = "$day $monthName $year";
    echo "
    <tr>
      <th>{$parent['userid']}</th>
      <td><img src='parent_images/{$parent['userimg']}' class='rounded-circle' width='100' height='100'></td>
      <td>{$parent['username']}</td>
      <td>$gender</td>
      <td>{$parent['useraddress']}</td>
      <td>{$parent['phonenumber']}</td>
      <td>$formattedDate</td>
      <td><a href='update.parent.php?parentid={$parent['userid']}' class='btn btn-success btn-sm'>Update <i class='bi bi-arrow-clockwise'></i></a></td>
      <td><a href='list.parent.php?removeparentid={$parent['userid']}'onclick='return confirm(\"Are you sure you want to delete {$parent['username']}?\")' class='btn btn-danger btn-sm'>Delete <i class='bi bi-trash'></i></a></td>
   </tr>
  ";
}
?>
  </tbody>
</table>
</div>
<?php require 'down.html.php';?>