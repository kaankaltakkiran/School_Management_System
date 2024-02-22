<?php
@session_start();
$activeTitle = "Add Food List";
$activePage = "add.food";
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
if (isset($_POST['btn_add'])) {
    //!Hata mesajlarını göstermek için boş bir dizi
    $errors = array();
    //!htmlspecialchars() kullanıcıdan alınan veriyi güvenli hale getirir
    //! eğer kullanıcı zararlı bir kod gönderirse bunu html etiketlerine dönüştürür
    require_once 'db.php';
    //!Pazartesi menüsü
    $day1first = htmlspecialchars($_POST['form_day1first']);
    $day1second = htmlspecialchars($_POST['form_day1second']);
    $day1third = htmlspecialchars($_POST['form_day1third']);
    $day1fourth = htmlspecialchars($_POST['form_day1fourth']);
    //!Pazartesi menüsü birleştirme
    $day1Menu = $day1first . ', ' . $day1second . ', ' . $day1third . ', ' . $day1fourth;
//!Salı menüsü
    $day2first = htmlspecialchars($_POST['form_day2first']);
    $day2second = htmlspecialchars($_POST['form_day2second']);
    $day2third = htmlspecialchars($_POST['form_day2third']);
    $day2fourth = htmlspecialchars($_POST['form_day2fourth']);
    //!Salı menüsü birleştirme
    $day2Menu = $day2first . ', ' . $day2second . ', ' . $day2third . ', ' . $day2fourth;
//!Çarşamba menüsü
    $day3first = htmlspecialchars($_POST['form_day3first']);
    $day3second = htmlspecialchars($_POST['form_day3second']);
    $day3third = htmlspecialchars($_POST['form_day3third']);
    $day3fourth = htmlspecialchars($_POST['form_day3fourth']);
    //!Çarşamba menüsü birleştirme
    $day3Menu = $day3first . ', ' . $day3second . ', ' . $day3third . ', ' . $day3fourth;
//!Perşembe menüsü
    $day4first = htmlspecialchars($_POST['form_day4first']);
    $day4second = htmlspecialchars($_POST['form_day4second']);
    $day4third = htmlspecialchars($_POST['form_day4third']);
    $day4fourth = htmlspecialchars($_POST['form_day4fourth']);
    //!Perşembe menüsü birleştirme
    $day4Menu = $day4first . ', ' . $day4second . ', ' . $day4third . ', ' . $day4fourth;
//!Cuma menüsü
    $day5first = htmlspecialchars($_POST['form_day5first']);
    $day5second = htmlspecialchars($_POST['form_day5second']);
    $day5third = htmlspecialchars($_POST['form_day5third']);
    $day5fourth = htmlspecialchars($_POST['form_day5fourth']);
//!Cuma menüsü birleştirme
    $day5Menu = $day5first . ', ' . $day5second . ', ' . $day5third . ', ' . $day5fourth;
//!Cumartesi menüsü
    $day6first = htmlspecialchars($_POST['form_day6first']);
    $day6second = htmlspecialchars($_POST['form_day6second']);
    $day6third = htmlspecialchars($_POST['form_day6third']);
    $day6fourth = htmlspecialchars($_POST['form_day6fourth']);
//!Cumartesi menüsü birleştirme
    $day6Menu = $day6first . ', ' . $day6second . ', ' . $day6third . ', ' . $day6fourth;
//!Pazar menüsü
    $day7first = htmlspecialchars($_POST['form_day7first']);
    $day7second = htmlspecialchars($_POST['form_day7second']);
    $day7third = htmlspecialchars($_POST['form_day7third']);
    $day7fourth = htmlspecialchars($_POST['form_day7fourth']);
//!Pazar menüsü birleştirme
    $day7Menu = $day7first . ', ' . $day7second . ', ' . $day7third . ', ' . $day7fourth;

    $addedUnitid = $_SESSION['id'];
    $addedUnitName = $_SESSION['userName'];
    //?Kullanıcı var mı yok mu kontrol etme
    $sql = "SELECT * FROM foodlist WHERE addedunitid = :unitid";
    $SORGU = $DB->prepare($sql);
    $SORGU->bindParam(':unitid', $addedUnitid);
    $SORGU->execute();
    $isFoodCount = $SORGU->fetchAll(PDO::FETCH_ASSOC);
    /*   echo '<pre>';
    print_r($isFoodCount);
    die(); */
    //!Eğer Kayıtlı bir menü varsa  hata ver
    if (count($isFoodCount) > 0) {
        $errors[] = "An attached record was found. You can only add 1 list !";

        //!Eğer aynı isimde menü yoksa kaydet
    } else {
        // Insert into Database
        $sql = "INSERT INTO foodlist (day1,day2,day3,day4,day5,day6,day7,addedunitid,addedunitname) VALUES (:day1Menu,:day2Menu,:day3Menu,:day4Menu,:day5Menu,:day6Menu,:day7Menu,:unitid,:unitname)";
        $SORGU = $DB->prepare($sql);
        $SORGU->bindParam(':day1Menu', $day1Menu);
        $SORGU->bindParam(':day2Menu', $day2Menu);
        $SORGU->bindParam(':day3Menu', $day3Menu);
        $SORGU->bindParam(':day4Menu', $day4Menu);
        $SORGU->bindParam(':day5Menu', $day5Menu);
        $SORGU->bindParam(':day6Menu', $day6Menu);
        $SORGU->bindParam(':day7Menu', $day7Menu);

        $SORGU->bindParam(':unitid', $addedUnitid);
        $SORGU->bindParam(':unitname', $addedUnitName);

        $SORGU->execute();
        $approves[] = "Food Added Successfully...";
    }
}
?>
    <div class="container">
  <div class="row justify-content-center mt-3">
  <div class="col-12">
<form method="POST" class="needs-validation" novalidate>
<h1 class="alert alert-info text-center">Add Food List</h1>
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
<div class="input-group mb-3 ">
  <span class="input-group-text">Day 1 Menu</span>
  <input type="text" name="form_day1first" placeholder="First Food" aria-label="First Food" class="form-control"required>
  <input type="text"  name="form_day1second" placeholder="Second Food" aria-label="Second Food" class="form-control"required>
  <input type="text"  name="form_day1third" placeholder="Third Food" aria-label="Third Food" class="form-control"required>
  <input type="text"  name="form_day1fourth" placeholder="Fourth Food" aria-label="Second Food" class="form-control"required>
    <div class="invalid-feedback fw-bold">
      Please Write Day 1 Menu !
    </div>
</div>
<div class="input-group mb-3 ">
  <span class="input-group-text">Day 2 Menu</span>
  <input type="text" name="form_day2first" placeholder="First Food" aria-label="First Food" class="form-control"required>
  <input type="text"  name="form_day2second" placeholder="Second Food" aria-label="Second Food" class="form-control"required>
  <input type="text"  name="form_day2third" placeholder="Third Food" aria-label="Third Food" class="form-control"required>
  <input type="text"  name="form_day2fourth" placeholder="Fourth Food" aria-label="Second Food" class="form-control"required>
  <div class="invalid-feedback fw-bold">
      Please Write Day 2 Menu !
    </div>
</div>
<div class="input-group mb-3 ">
  <span class="input-group-text">Day 3 Menu</span>
  <input type="text" name="form_day3first" placeholder="First Food" aria-label="First Food" class="form-control"required>
  <input type="text"  name="form_day3second" placeholder="Second Food" aria-label="Second Food" class="form-control"required>
  <input type="text"  name="form_day3third" placeholder="Third Food" aria-label="Third Food" class="form-control"required>
  <input type="text"  name="form_day3fourth" placeholder="Fourth Food" aria-label="Second Food" class="form-control"required>
  <div class="invalid-feedback fw-bold">
      Please Write Day 3 Menu !
    </div>
</div>
<div class="input-group mb-3 ">
  <span class="input-group-text">Day 4 Menu</span>
  <input type="text" name="form_day4first" placeholder="First Food" aria-label="First Food" class="form-control"required>
  <input type="text"  name="form_day4second" placeholder="Second Food" aria-label="Second Food" class="form-control"required>
  <input type="text"  name="form_day4third" placeholder="Third Food" aria-label="Third Food" class="form-control"required>
  <input type="text"  name="form_day4fourth" placeholder="Fourth Food" aria-label="Second Food" class="form-control"required>
  <div class="invalid-feedback fw-bold">
      Please Write Day 4 Menu !
    </div>
</div>
<div class="input-group mb-3 ">
  <span class="input-group-text">Day 5 Menu</span>
  <input type="text" name="form_day5first" placeholder="First Food" aria-label="First Food" class="form-control"required>
  <input type="text"  name="form_day5second" placeholder="Second Food" aria-label="Second Food" class="form-control"required>
  <input type="text"  name="form_day5third" placeholder="Third Food" aria-label="Third Food" class="form-control"required>
  <input type="text"  name="form_day5fourth" placeholder="Fourth Food" aria-label="Second Food" class="form-control"required>
  <div class="invalid-feedback fw-bold">
      Please Write Day 5 Menu !
    </div>
</div>
<div class="input-group mb-3 ">
  <span class="input-group-text">Day 6 Menu</span>
  <input type="text" name="form_day6first" placeholder="First Food" aria-label="First Food" class="form-control"required>
  <input type="text"  name="form_day6second" placeholder="Second Food" aria-label="Second Food" class="form-control"required>
  <input type="text"  name="form_day6third" placeholder="Third Food" aria-label="Third Food" class="form-control"required>
  <input type="text"  name="form_day6fourth" placeholder="Fourth Food" aria-label="Second Food" class="form-control"required>
  <div class="invalid-feedback fw-bold">
      Please Write Day 6 Menu !
    </div>
</div>
<div class="input-group mb-3 ">
  <span class="input-group-text">Day 7 Menu</span>
  <input type="text" name="form_day7first" placeholder="First Food" aria-label="First Food" class="form-control"required>
  <input type="text"  name="form_day7second" placeholder="Second Food" aria-label="Second Food" class="form-control"required>
  <input type="text"  name="form_day7third" placeholder="Third Food" aria-label="Third Food" class="form-control"required>
  <input type="text"  name="form_day7fourth" placeholder="Fourth Food" aria-label="Second Food" class="form-control"required>
  <div class="invalid-feedback fw-bold">
      Please Write Day 7 Menu !
    </div>
</div>

                  <button type="submit" name="btn_add" class="btn btn-primary mt-3 ">Add Food List
                  <i class="bi bi-send"></i>
                  </button>
     </form>
     </div>
</div>
</div>
<?php require 'footer.php';?>
<?php require 'down.html.php';?>
