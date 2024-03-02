<?php
session_start();
$activeTitle = "Class Update";
$activePage = "class.update";
require 'up.html.php';
require 'login.control.php';
?>
<?php
//! Rol idsi 2 olan kayıt birimi class update yapabilir
if ($_SESSION['role'] != 2) {
    header("location: authorizationcontrol.php");
    die();
}
?>
    <?php include 'navbar.php';?>
  <div class="container">
  <div class="row justify-content-center mt-3">
  <div class="col-6">
<form method="POST"enctype="multipart/form-data">
<h1 class="alert alert-info text-center">Class Update</h1>
<?php
require_once 'db.php';
$id = $_GET['idClass'];
$sql = "SELECT * FROM classes WHERE classid = :idClass";
$SORGU = $DB->prepare($sql);
$SORGU->bindParam(':idClass', $id);
$SORGU->execute();
$classes = $SORGU->fetchAll(PDO::FETCH_ASSOC);
/* var_dump($classes);
die(); */
if (isset($_POST['form_submit'])) {
    //!htmlspecialchars() kullanıcıdan alınan veriyi güvenli hale getirir
    //! eğer kullanıcı zararlı bir kod gönderirse bunu html etiketlerine dönüştürür
    $classNumber = htmlspecialchars($_POST['form_classnumber']);
    $classLetter = htmlspecialchars($_POST['form_classletter']);

    //!Hata kontrolü
    $errors = array();
    //!Onay mesajları
    $approves = array();

    //!Sınıf Adı Birleştirme
    $className = strtoupper($classNumber . "/" . $classLetter);

    $sql = "UPDATE classes SET classnumber = :form_classnumber,classletter = :form_classletter,classname = :classname,lastupdate = CURRENT_TIMESTAMP() WHERE classid = :idClass";
    //! Aynı isimde class name var mı kontrol et
    //? Eğer aynı isimde class name varsa hata ver
    $checkClassQuery = $DB->prepare("SELECT * FROM classes WHERE classname = :classname AND classid != :idClass");
    $checkClassQuery->bindParam(':classname', $className);
    $checkClassQuery->bindParam(':idClass', $id);
    $checkClassQuery->execute();
    $existingClass = $checkClassQuery->fetch(PDO::FETCH_ASSOC);
    if ($existingClass) {
        $errors[] = "This Class Name is already in use !";
    } else {
        $SORGU = $DB->prepare($sql);
        $SORGU->bindParam(':form_classnumber', $classNumber);
        $SORGU->bindParam(':form_classletter', $classLetter);
        $SORGU->bindParam(':classname', $className);
        $SORGU->bindParam(':idClass', $id);
        $SORGU->execute();
        $approves[] = "Class Name Update Successful...";
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
  <label>Added By Register Unit Name</label>
</div>
<div class="form-floating mb-3">
  <select class="form-select" name="form_classnumber" id="floatingSelect" aria-label="Floating label select example">
    <option disabled>Select Class Number</option>
    <?php
$selected_class_number = $classes[0]['classnumber'];
for ($number = 9; $number <= 12; $number++) {
    $selected = ($number == $selected_class_number) ? "selected" : "";
    echo "<option value=\"$number\" $selected>$number</option>";
}
?>
  </select>
  <label for="floatingSelect">Class Number</label>
</div>
<div class="form-floating mb-3">
  <select class="form-select" name="form_classletter" id="floatingSelect2" aria-label="Floating label select example">
    <option disabled>Select Class Letter</option>
    <?php
$selected_letter = $classes[0]['classletter'];
for ($i = ord('A'); $i <= ord('Z'); $i++) {
    $letter = chr($i);
    $selected = ($letter == $selected_letter) ? "selected" : "";
    echo "<option value=\"$letter\" $selected>$letter</option>";
}
?>
  </select>
  <label for="floatingSelect2">Class Letter</label>
</div>
                  <button type="submit" name="form_submit" class="btn btn-primary mt-3 ">Update Class Name
                  <i class="bi bi-send"></i>
                  </button>
     </form>
     </div>
</div>
</div>
<?php require 'down.html.php';?>