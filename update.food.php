<?php
session_start();
$activeTitle = "Food Menu Update";
$activePage = "food.update";
require 'up.html.php';
require 'login.control.php';
?>
<?php
if ($_SESSION['role'] != 2) {
    header("location: authorizationcontrol.php");
    die();
}
?>
    <?php include 'navbar.php';?>
  <div class="container">
  <div class="row justify-content-center mt-3">
  <div class="col-12">
<form method="POST"enctype="multipart/form-data">
<h1 class="alert alert-info text-center">Food Menu Update</h1>
<?php
require_once 'db.php';
$addedUnitid = $_SESSION['id'];
$sql = "SELECT * FROM foodlist WHERE addedunitid = :unitid";
$SORGU = $DB->prepare($sql);
$SORGU->bindParam(':unitid', $addedUnitid);
$SORGU->execute();
$foods = $SORGU->fetchAll(PDO::FETCH_ASSOC);
/* var_dump($foods);
die(); */
//!explode ile veritabanında virgülle ayrılmış veriyi parçalayıp diziye atıyoruz
//!Pazartesi Listesi
$foodDay1 = explode(",", $foods[0]['day1']);
$food1 = $foodDay1[0];
$food2 = $foodDay1[1];
$food3 = $foodDay1[2];
$food4 = $foodDay1[3];
//!Salı Listesi
$foodDay2 = explode(",", $foods[0]['day2']);
$food5 = $foodDay2[0];
$food6 = $foodDay2[1];
$food7 = $foodDay2[2];
$food8 = $foodDay2[3];
//!Çarşamba Listesi
$foodDay3 = explode(",", $foods[0]['day3']);
$food9 = $foodDay3[0];
$food10 = $foodDay3[1];
$food11 = $foodDay3[2];
$food12 = $foodDay3[3];
//!Perşembe Listesi
$foodDay4 = explode(",", $foods[0]['day4']);
$food13 = $foodDay4[0];
$food14 = $foodDay4[1];
$food15 = $foodDay4[2];
$food16 = $foodDay4[3];
//!Cuma Listesi
$foodDay5 = explode(",", $foods[0]['day5']);
$food17 = $foodDay5[0];
$food18 = $foodDay5[1];
$food19 = $foodDay5[2];
$food20 = $foodDay5[3];
//!Cumartesi Listesi
$foodDay6 = explode(",", $foods[0]['day6']);
$food21 = $foodDay6[0];
$food22 = $foodDay6[1];
$food23 = $foodDay6[2];
$food24 = $foodDay6[3];
//!Pazar Listesi
$foodDay7 = explode(",", $foods[0]['day7']);
$food25 = $foodDay7[0];
$food26 = $foodDay7[1];
$food27 = $foodDay7[2];
$food28 = $foodDay7[3];

if (isset($_POST['form_submit'])) {
    //!Hata mesajlarını göstermek için boş bir dizi
    $errors = array();
    //!Onay mesajları
    $approves = array();
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
//!Update sorgusu
    if (count($foods) > 1) {
        $errors[] = "An attached record was found. You can only add a list !";
    } else {

        $sql = "UPDATE foodlist SET day1 = :day1Menu, day2 = :day2Menu, day3 = :day3Menu, day4 = :day4Menu, day5 = :day5Menu, day6 = :day6Menu, day7 = :day7Menu,lastupdate = CURRENT_TIMESTAMP() WHERE addedunitid = :unitid";

        $SORGU = $DB->prepare($sql);
        $SORGU->bindParam(':day1Menu', $day1Menu);
        $SORGU->bindParam(':day2Menu', $day2Menu);
        $SORGU->bindParam(':day3Menu', $day3Menu);
        $SORGU->bindParam(':day4Menu', $day4Menu);
        $SORGU->bindParam(':day5Menu', $day5Menu);
        $SORGU->bindParam(':day6Menu', $day6Menu);
        $SORGU->bindParam(':day7Menu', $day7Menu);
        $SORGU->bindParam(':unitid', $addedUnitid);
        $SORGU->execute();
        $approves[] = "Food Menu Update Successful!";

    }
}
?>
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
        //!4 saniye sonra sayfayı yenilemek için yönlendirme
        echo "<meta http-equiv='refresh' content='3'>";
    }
}
?>
<div class="form-floating mb-3">
  <input type="text"  class="form-control" value="<?php echo $_SESSION['userName'] ?>"disabled readonly>
  <label>Update By Register Unit Name</label>
</div>
<div class="input-group mb-3 ">
  <span class="input-group-text">Day 1 Menu</span>
  <input type="text" value="<?php echo $food1 ?>" name="form_day1first" placeholder="First Food" aria-label="First Food" class="form-control">
  <input type="text" value="<?php echo $food2 ?>"  name="form_day1second" placeholder="Second Food" aria-label="Second Food" class="form-control">
  <input type="text" value="<?php echo $food3 ?>"  name="form_day1third" placeholder="Third Food" aria-label="Third Food" class="form-control">
  <input type="text" value="<?php echo $food4 ?>"  name="form_day1fourth" placeholder="Fourth Food" aria-label="Second Food" class="form-control">
</div>
<div class="input-group mb-3 ">
  <span class="input-group-text">Day 2 Menu</span>
  <input type="text" value="<?php echo $food5 ?>" name="form_day2first" placeholder="First Food" aria-label="First Food" class="form-control">
  <input type="text" value="<?php echo $food6 ?>"  name="form_day2second" placeholder="Second Food" aria-label="Second Food" class="form-control">
  <input type="text" value="<?php echo $food7 ?>"  name="form_day2third" placeholder="Third Food" aria-label="Third Food" class="form-control">
  <input type="text" value="<?php echo $food8 ?>"  name="form_day2fourth" placeholder="Fourth Food" aria-label="Second Food" class="form-control">
</div>
<div class="input-group mb-3 ">
  <span class="input-group-text">Day 3 Menu</span>
  <input type="text" value="<?php echo $food9 ?>" name="form_day3first" placeholder="First Food" aria-label="First Food" class="form-control">
  <input type="text" value="<?php echo $food10 ?>"  name="form_day3second" placeholder="Second Food" aria-label="Second Food" class="form-control">
  <input type="text" value="<?php echo $food11 ?>"  name="form_day3third" placeholder="Third Food" aria-label="Third Food" class="form-control">
  <input type="text" value="<?php echo $food12 ?>"  name="form_day3fourth" placeholder="Fourth Food" aria-label="Second Food" class="form-control">
</div>
<div class="input-group mb-3 ">
  <span class="input-group-text">Day 4 Menu</span>
  <input type="text" value="<?php echo $food13 ?>" name="form_day4first" placeholder="First Food" aria-label="First Food" class="form-control">
  <input type="text" value="<?php echo $food14 ?>"  name="form_day4second" placeholder="Second Food" aria-label="Second Food" class="form-control">
  <input type="text" value="<?php echo $food15 ?>"  name="form_day4third" placeholder="Third Food" aria-label="Third Food" class="form-control">
  <input type="text" value="<?php echo $food16 ?>"  name="form_day4fourth" placeholder="Fourth Food" aria-label="Second Food" class="form-control">
</div>
<div class="input-group mb-3 ">
  <span class="input-group-text">Day 5 Menu</span>
  <input type="text" value="<?php echo $food17 ?>" name="form_day5first" placeholder="First Food" aria-label="First Food" class="form-control">
  <input type="text" value="<?php echo $food18 ?>"  name="form_day5second" placeholder="Second Food" aria-label="Second Food" class="form-control">
  <input type="text" value="<?php echo $food19 ?>"  name="form_day5third" placeholder="Third Food" aria-label="Third Food" class="form-control">
  <input type="text" value="<?php echo $food20 ?>"  name="form_day5fourth" placeholder="Fourth Food" aria-label="Second Food" class="form-control">
</div>
<div class="input-group mb-3 ">
  <span class="input-group-text">Day 6 Menu</span>
  <input type="text" value="<?php echo $food21 ?>" name="form_day6first" placeholder="First Food" aria-label="First Food" class="form-control">
  <input type="text" value="<?php echo $food22 ?>"  name="form_day6second" placeholder="Second Food" aria-label="Second Food" class="form-control">
  <input type="text" value="<?php echo $food23 ?>"  name="form_day6third" placeholder="Third Food" aria-label="Third Food" class="form-control">
  <input type="text" value="<?php echo $food24 ?>"  name="form_day6fourth" placeholder="Fourth Food" aria-label="Second Food" class="form-control">
</div>
<div class="input-group mb-3 ">
  <span class="input-group-text">Day 7 Menu</span>
  <input type="text" value="<?php echo $food25 ?>" name="form_day7first" placeholder="First Food" aria-label="First Food" class="form-control">
  <input type="text" value="<?php echo $food26 ?>"  name="form_day7second" placeholder="Second Food" aria-label="Second Food" class="form-control">
  <input type="text" value="<?php echo $food27 ?>"  name="form_day7third" placeholder="Third Food" aria-label="Third Food" class="form-control">
  <input type="text" value="<?php echo $food28 ?>"  name="form_day7fourth" placeholder="Fourth Food" aria-label="Second Food" class="form-control">
</div>
                  <button type="submit" name="form_submit" class="btn btn-primary mt-3 ">Update Food Menu
                  <i class="bi bi-send"></i>
                  </button>
     </form>
     </div>
</div>
</div>
<?php require 'footer.php';?>
<?php require 'down.html.php';?>