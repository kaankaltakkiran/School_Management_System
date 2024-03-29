<?php
@session_start();
$activeTitle = "Add Lesson";
$activePage = "add.lesson";
require 'up.html.php';
require 'login.control.php';
?>
<?php
//! Rol idsi 2 olan register unit sadece ders ekleyebilir
if ($_SESSION['role'] != 2) {
    header("location: authorizationcontrol.php");
    die();
}
?>
<?php
require 'navbar.php'?>
<?php
//! Veri tabanına ders ekleme
if (isset($_POST['submit_form'])) {
    //!Hata mesajlarını göstermek için boş bir dizi
    $errors = array();
    //!htmlspecialchars() kullanıcıdan alınan veriyi güvenli hale getirir
    //! eğer kullanıcı zararlı bir kod gönderirse bunu html etiketlerine dönüştürür
    require_once 'db.php';
    $lessonName = htmlspecialchars($_POST['form_lesson']);
    $addedUnitid = $_SESSION['id'];
    $addedUnitName = $_SESSION['userName'];

    //?Kullanıcı var mı yok mu kontrol etme
    $sql = "SELECT * FROM lessons WHERE lessonname = :form_lesson";
    $SORGU = $DB->prepare($sql);
    $SORGU->bindParam(':form_lesson', $lessonName);
    $SORGU->execute();
    $isLessonName = $SORGU->fetch(PDO::FETCH_ASSOC);
    /*  echo '<pre>';
    print_r($isLessonName);
    die(); */
    //!Eğer aynı isimde ders varsa  hata ver
    if ($isLessonName) {
        $errors[] = "There is a lesson with the same name !";

        //!Eğer aynı isimde ders yoksa kaydet
    } else {
        // Insert into Database
        $sql = "INSERT INTO lessons (lessonname,addedunitid,addedunitname) VALUES (:form_lesson,:unitid,:unitname)";
        $SORGU = $DB->prepare($sql);
        $SORGU->bindParam(':form_lesson', $lessonName);
        $SORGU->bindParam(':unitid', $addedUnitid);
        $SORGU->bindParam(':unitname', $addedUnitName);
        $SORGU->execute();
        $approves[] = "lesson Added Successfully...";
    }
}
?>
    <div class="container">
  <div class="row justify-content-center mt-3">
  <div class="col-6">
<form method="POST" class="needs-validation" novalidate>
<h1 class="alert alert-info text-center">Add Lesson</h1>
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
  <input type="text" id="floatingInput" placeholder="lesson Name"  class="form-control" name="form_lesson" required>
  <label for="floatingInput">lesson Name</label>
  <div class="invalid-feedback fw-bold">
      Please Write lesson Name !
    </div>
</div>
                  <button type="submit" name="submit_form" class="btn btn-primary mt-3 ">Add Lesson
                  <i class="bi bi-send"></i>
                  </button>
     </form>
     </div>
</div>
</div>
<?php require 'down.html.php';?>
