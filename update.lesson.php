<?php
session_start();
$activeTitle = "Lesson Update";
$activePage = "lesson.update";
require 'up.html.php';
require 'login.control.php';
?>
<?php
require_once 'db.php';
$id = $_GET['lessonid'];
$sql = "SELECT * FROM lessons WHERE lessonid = :lessonid";
$SORGU = $DB->prepare($sql);
$SORGU->bindParam(':lessonid', $id);
$SORGU->execute();
$lessons = $SORGU->fetchAll(PDO::FETCH_ASSOC);
/* var_dump($lessons);
die(); */
if ($_SESSION['role'] != 2) {
    header("location: authorizationcontrol.php");
    die();
}
if ($lessons[0]['addedunitid'] != $_SESSION['id']) {
    header("location: authorizationcontrol.php");
    die();
}
?>
    <?php include 'navbar.php';?>
  <div class="container">
  <div class="row justify-content-center mt-3">
  <div class="col-6">
<form method="POST"enctype="multipart/form-data">
<h1 class="alert alert-info text-center">Lesson Update</h1>
<?php
if (isset($_POST['form_submit'])) {
    //!htmlspecialchars() kullanıcıdan alınan veriyi güvenli hale getirir
    //! eğer kullanıcı zararlı bir kod gönderirse bunu html etiketlerine dönüştürür
    $lessonName = htmlspecialchars($_POST['from_lessonname']);

    //!Hata kontrolü
    $errors = array();
    //!Onay mesajları
    $approves = array();

    $sql = "UPDATE lessons SET lessonname = :from_lessonname WHERE lessonid = :lessonid";
    //! Kullanıcı e-posta adresini değiştirdiyse, yeni e-posta adresi için veritabanında mevcut bir kullanıcı olup olmadığını kontrol et
    //? Eğer post edilen email update yapılan kişinin dışında bir kullanıcıda varsa hata mesajı göster
    $checkLessonQuery = $DB->prepare("SELECT * FROM lessons WHERE lessonname = :from_lessonname AND lessonid != :lessonid");
    $checkLessonQuery->bindParam(':from_lessonname', $lessonName);
    $checkLessonQuery->bindParam(':lessonid', $id);
    $checkLessonQuery->execute();
    $existingLesson = $checkLessonQuery->fetch(PDO::FETCH_ASSOC);
    if ($existingLesson) {
        $errors[] = "This Lesson Name is already in use !";
    } else {
        $SORGU = $DB->prepare($sql);
        $SORGU->bindParam(':from_lessonname', $lessonName);
        $SORGU->bindParam(':lessonid', $id);
        $SORGU->execute();
        $approves[] = "Lesson Update Successful!";
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
  <input type="text"  class="form-control" value="<?php echo $lessons[0]['lessonname'] ?>" name="from_lessonname">
  <label>Lesson Name</label>
</div>
                  <button type="submit" name="form_submit" class="btn btn-primary mt-3 ">Update Lesson
                  <i class="bi bi-send"></i>
                  </button>
     </form>
     </div>
</div>
</div>
<?php require 'down.html.php';?>