<?php
@session_start();
$activeTitle = "Add Class";
require 'up.html.php';
?>
<?php
require 'navbar.php'?>
<?php

//!form submit edilmişse
if (isset($_POST['form_classnumber'], $_POST['form_classletter'])) {
    //!Hata mesajlarını göstermek için boş bir dizi
    $errors = array();

    require_once 'db.php';
    $classNumber = $_POST['form_classnumber'];
    $classLetter = $_POST['form_classletter'];
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
        $errors[] = "There is a class with the same name";

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

<form method="POST">
<h1 class="alert alert-info text-center">Add Class</h1>
<?php
//! Hata mesajlarını göster
if (!empty($errors)) {
    foreach ($errors as $error) {
        echo '
        <div class="container">
    <div class="auto-close alert mt-3 text-center alert-danger" role="alert">
    ' . $error . '
    </div>
    </div>
    ';
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
  <select class="form-select" name="form_classnumber" id="floatingSelect" aria-label="Floating label select example">
    <option selected disabled>Select Class Number</option>
    <option value="9">9</option>
    <option value="10">10</option>
    <option value="11">11</option>
    <option value="12">12</option>
  </select>
  <label for="floatingSelect">Class</label>
</div>
<!-- Chatgpt ile sınıf harflerini gösterme
ord ascıı karakterine çeviriyor -->
<div class="form-floating mb-3">
  <select class="form-select" name="form_classletter" id="floatingSelect2" aria-label="Floating label select example">
    <option selected disabled>Select Class Letter</option>
    <?php
for ($i = ord('A'); $i <= ord('Z'); $i++) {
    $letter = chr($i);
    echo "<option value=\"$letter\">$letter</option>";
}
?>
  </select>
  <label for="floatingSelect2">Class Letter</label>
</div>
                  <button type="submit" name="form_submit" class="btn btn-primary mt-3 ">Add Class</button>
     </form>
     </div>
</div>
</div>
<?php require 'down.html.php';?>
