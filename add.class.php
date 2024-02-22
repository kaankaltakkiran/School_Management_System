<?php
@session_start();
$activeTitle = "Add Class";
$activePage = "add.class";
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
if (isset($_POST['submit_form'])) {
    //!Hata mesajlarını göstermek için boş bir dizi
    $errors = array();
    //!htmlspecialchars() kullanıcıdan alınan veriyi güvenli hale getirir
    //! eğer kullanıcı zararlı bir kod gönderirse bunu html etiketlerine dönüştürür
    require_once 'db.php';
    $classNumber = htmlspecialchars($_POST['form_classnumber']);
    $classLetter = htmlspecialchars($_POST['form_classletter']);
    $addedUnitid = $_SESSION['id'];
    $addedUnitName = $_SESSION['userName'];

    //!Sınıf Adı Birleştirme
    $className = strtoupper($classNumber . "/" . $classLetter);

    //?Kullanıcı var mı yok mu kontrol etme
    $sql = "SELECT * FROM classes WHERE classname = :classname";
    $SORGU = $DB->prepare($sql);
    $SORGU->bindParam(':classname', $className);
    $SORGU->execute();
    $isClassName = $SORGU->fetch(PDO::FETCH_ASSOC);
    /*  echo '<pre>';
    print_r($isClassName);
    die(); */
    //!Eğer aynı isimde sınıf varsa  hata ver
    if ($isClassName) {
        $errors[] = "There is a class with the same name !";

        //!Eğer aynı isimde sınıf yoksa kaydet
    } else {
        // Insert into Database
        $sql = "INSERT INTO classes (classnumber,classletter,classname,addedunitid,addedunitname) VALUES (:form_classnumber,:form_classletter,:classname,:unitid,:unitname)";
        $SORGU = $DB->prepare($sql);
        $SORGU->bindParam(':form_classnumber', $classNumber);
        $SORGU->bindParam(':form_classletter', $classLetter);
        $SORGU->bindParam(':classname', $className);
        $SORGU->bindParam(':unitid', $addedUnitid);
        $SORGU->bindParam(':unitname', $addedUnitName);

        $SORGU->execute();
        $approves[] = "Class Added Successfully...";
    }
}
?>
    <div class="container">
  <div class="row justify-content-center mt-3">
  <div class="col-6">
<form method="POST"  class="needs-validation"novalidate>
<h1 class="alert alert-info text-center">Add Class</h1>
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
  <div class="form-floating mb-3">
  <input type="text"  class="form-control" value="<?php echo $_SESSION['userName'] ?>"disabled readonly>
  <label>Added By Register Unit Name</label>
</div>
<div class="form-floating mb-3">
  <select class="form-select" name="form_classnumber" id="floatingSelect" aria-label="Floating label select example"required>
    <option selected disabled value="">Select Class Number</option>
    <option value="9">9</option>
    <option value="10">10</option>
    <option value="11">11</option>
    <option value="12">12</option>
  </select>
  <label for="floatingSelect">Class Number</label>
  <div class="invalid-feedback fw-bold">
      Select Class Number !
    </div>
</div>
<!-- Chatgpt ile sınıf harflerini gösterme
ord ascıı karakterine çeviriyor -->
<div class="form-floating mb-3">
  <select class="form-select" name="form_classletter" id="floatingSelect2" aria-label="Floating label select example" required>
    <option selected disabled value="">Select Class Letter</option>
    <?php
for ($i = ord('A'); $i <= ord('Z'); $i++) {
    $letter = chr($i);
    echo "<option value=\"$letter\">$letter</option>";
}
?>
  </select>
  <label for="floatingSelect2">Class Letter</label>
  <div class="invalid-feedback fw-bold">
      Select Class Letter !
    </div>
</div>
                  <button type="submit" name="submit_form" class="btn btn-primary mt-3 ">Add Class
                  <i class="bi bi-send"></i>
                  </button>
     </form>
     </div>
</div>
</div>
<?php require 'down.html.php';?>
