<?php
@session_start();
$activeTitle = "Add School İnformation";
$activePage = "add.information";
require 'up.html.php';
require 'login.control.php';
?>
<?php
if ($_SESSION['role'] != 2) {
    header("location: authorizationcontrol.php");
    die();
}
?>
<?php
require 'navbar.php'?>
<?php

//!form submit edilmişse
if (isset($_POST['form_submit'])) {
    //!Hata mesajlarını göstermek için boş bir dizi
    $errors = array();
    //!htmlspecialchars() kullanıcıdan alınan veriyi güvenli hale getirir
    //! eğer kullanıcı zararlı bir kod gönderirse bunu html etiketlerine dönüştürür
    require_once 'db.php';
    $schoolName = htmlspecialchars($_POST['form_name']);
    $schoolYear = htmlspecialchars($_POST['form_year']);
    $schoolTerm = htmlspecialchars($_POST['form_term']);
    $schoolAbout = htmlspecialchars($_POST['form_about']);
    $schoolSummary = htmlspecialchars($_POST['form_summary']);
    $schoolAddress = htmlspecialchars($_POST['form_address']);
    $addedUnitid = $_SESSION['id'];
    $addedUnitName = $_SESSION['userName'];

    //?Aynı Okul isminden  var mı yok mu kontrol etme
    $sql = "SELECT * FROM informations WHERE schoolname = :form_name";
    $SORGU = $DB->prepare($sql);
    $SORGU->bindParam(':form_name', $schoolName);
    $SORGU->execute();
    $isSchoolName = $SORGU->fetch(PDO::FETCH_ASSOC);
    /*  echo '<pre>';
    print_r($isSchoolName);
    die(); */
    //!Eğer aynı isimde ders varsa  hata ver
    if ($isSchoolName) {
        $errors[] = "There is a School with the same name !";

        //!Eğer aynı isimde ders yoksa kaydet
    } else {
        // Insert into Database
        $sql = "INSERT INTO informations (schoolname,schoolyear,schoolterm,schoolabout,schoolsummary,schooladdress,addedunitid,addedunitname) VALUES (:form_name,:form_year,:form_term,:form_about,:form_summary,:form_address,:addedunitid,:addedunitname)";
        $SORGU = $DB->prepare($sql);
        $SORGU->bindParam(':form_name', $schoolName);
        $SORGU->bindParam(':form_year', $schoolYear);
        $SORGU->bindParam(':form_term', $schoolTerm);
        $SORGU->bindParam(':form_about', $schoolAbout);
        $SORGU->bindParam(':form_summary', $schoolSummary);
        $SORGU->bindParam(':form_address', $schoolAddress);
        $SORGU->bindParam(':addedunitid', $addedUnitid);
        $SORGU->bindParam(':addedunitname', $addedUnitName);
        $SORGU->execute();
        $approves[] = "School İnformation Added Successfully...";
    }
}
?>
    <div class="container">
  <div class="row justify-content-center mt-3">
  <div class="col-6">

<form method="POST">
<h1 class="alert alert-info text-center">Add School İnformation</h1>
<?php
//! Hata mesajlarını göster
if (!empty($errors)) {
    foreach ($errors as $error) {
        echo "<div class='position-fixed top-0 end-0 p-3' style='z-index: 5'>
      <div class='toast align-items-center text-white bg-danger border-0' role='alert' aria-live='assertive' aria-atomic='true' data-bs-delay='5000'>
          <div class='d-flex'>
              <div class='toast-body'>
              $error
              </div>
              <button type='button' class='btn-close btn-close-white me-2 m-auto' data-bs-dismiss='toast' aria-label='Close'></button>
          </div>
      </div>
  </div>";
    }
}
?>
<?php
//! Başarılı mesajlarını göster
if (!empty($approves)) {
    foreach ($approves as $approve) {
        echo '
        <div class="container">
    <div class="auto-close alert mt-3 text-center alert-success" role="alert">
    ' . $approve . '
    </div>
    </div>
    ';
    }
}
?>
  <div class="form-floating mb-3">
  <input type="text"  class="form-control" value="<?php echo $_SESSION['userName'] ?>"disabled readonly>
  <label>Added By Register Unit Name</label>
</div>
<div class="form-floating mb-3">
  <input type="text"  class="form-control" name="form_name" required>
  <label>School Name</label>
</div>
<div class="form-floating mb-3">
  <select class="form-select" name="form_year" id="floatingSelect" aria-label="Floating label select example">
  <option selected disabled>Select Year</option>
  <?php
//! 1950'den bugüne kadar yılları seçen bir döngü
for ($i = 1950; $i <= date("Y"); $i++) {
    echo "<option value='$i'>$i</option>";
}
?>
  </select>
  <label for="floatingSelect">School Year</label>
</div>
<div class="form-floating mb-3 ">
  <select class="form-select" name="form_term" id="floatingSelect2" aria-label="Floating label select example 2">
    <option selected disabled>Select Term</option>
    <option value="I">I</option>
    <option value="II">II</option>
  </select>
  <label for="floatingSelect2">School Term</label>
</div>
<div class="form-floating mb-3 ">
  <textarea class="form-control" name="form_about" placeholder="School About" id="floatingTextarea3" style="height: 100px"></textarea>
  <label for="floatingTextarea3">School About</label>
</div>
<div class="form-floating mb-3 ">
  <textarea class="form-control" name="form_summary" placeholder="School About Summary" id="floatingTextarea4" style="height: 100px"></textarea>
  <label for="floatingTextarea4">School About Summary</label>
</div>
<div class="form-floating mb-3 ">
  <textarea class="form-control" name="form_address" placeholder="School Address" id="floatingTextarea2" style="height: 100px"></textarea>
  <label for="floatingTextarea2">School Address</label>
</div>

                  <button type="submit" name="form_submit" class="btn btn-primary mt-3 ">Add School İnformation
                  <i class="bi bi-send"></i>
                  </button>
     </form>
     </div>
</div>
</div>
<?php require 'down.html.php';?>
