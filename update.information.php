<?php
@session_start();
$activeTitle = "School İnformation Update";
$activePage = "update.information";
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
//! Ekleyen kayıt birimi ile güncelleyen kayıt birimi aynı olmalıdır
require_once 'db.php';
$id = $_GET['schoolid'];
$sql = "SELECT * FROM informations WHERE schoolid = :schoolid";
$SORGU = $DB->prepare($sql);
$SORGU->bindParam(':schoolid', $id);
$SORGU->execute();
$informationsControl = $SORGU->fetchAll(PDO::FETCH_ASSOC);
/* var_dump($informations);
die(); */
$control_information = $informationsControl[0]['addedunitid'] != $_SESSION['id'];
if ($control_information == true || $_SESSION['role'] != 2) {
    header("location: authorizationcontrol.php");
    die();
}
?>
    <?php include 'navbar.php';?>
  <div class="container">
  <div class="row justify-content-center mt-3">
  <div class="col-6">
<form method="POST"enctype="multipart/form-data">
<h1 class="alert alert-info text-center">School İnformation Update</h1>
<?php
require_once 'db.php';
$id = $_GET['schoolid'];
$sql = "SELECT * FROM informations WHERE schoolid = :schoolid";
$SORGU = $DB->prepare($sql);
$SORGU->bindParam(':schoolid', $id);
$SORGU->execute();
$informations = $SORGU->fetchAll(PDO::FETCH_ASSOC);
/* var_dump($informations);
die(); */

//!Seçili yıl
$selectedYear = $informations[0]['schoolyear'];
//!Seçili dönem
$selectedTerm = $informations[0]['schoolterm'];
if (isset($_POST['form_submit'])) {
    //!htmlspecialchars() kullanıcıdan alınan veriyi güvenli hale getirir
    //! eğer kullanıcı zararlı bir kod gönderirse bunu html etiketlerine dönüştürür
    require_once 'db.php';
    $schoolName = htmlspecialchars($_POST['form_name']);
    $schoolYear = htmlspecialchars($_POST['form_year']);
    $schoolTerm = htmlspecialchars($_POST['form_term']);
    $schoolAbout = htmlspecialchars($_POST['form_about']);
    $schoolSummary = htmlspecialchars($_POST['form_summary']);
    $schoolAddress = htmlspecialchars($_POST['form_address']);

    //!Hata kontrolü
    $errors = array();
    //!Onay mesajları
    $approves = array();

    $sql = "UPDATE informations SET schoolname = :form_name,schoolyear=:form_year,schoolterm=:form_term,schoolabout=:form_about,schoolsummary=:form_summary,schooladdress=:form_address,lastupdate = CURRENT_TIMESTAMP() WHERE schoolid = :schoolid";
    //! Kullanıcı OKUL ismini değiştirdiyse, yeni okul  ismi için veritabanında mevcut bir kullanıcı olup olmadığını kontrol et
    //? Eğer post edilen ism update yapılan kişinin dışında bir ismi varsa hata mesajı göster
    $checkNameQuery = $DB->prepare("SELECT * FROM informations WHERE schoolname = :form_name AND schoolid != :schoolid");
    $checkNameQuery->bindParam(':form_name', $schoolName);
    $checkNameQuery->bindParam(':schoolid', $id);
    $checkNameQuery->execute();
    $existingName = $checkNameQuery->fetch(PDO::FETCH_ASSOC);
    if ($existingName) {
        $errors[] = "This School Name is already in use !";
    } else {
        $SORGU = $DB->prepare($sql);
        $SORGU->bindParam(':form_name', $schoolName);
        $SORGU->bindParam(':form_year', $schoolYear);
        $SORGU->bindParam(':form_term', $schoolTerm);
        $SORGU->bindParam(':form_about', $schoolAbout);
        $SORGU->bindParam(':form_summary', $schoolSummary);
        $SORGU->bindParam(':form_address', $schoolAddress);
        $SORGU->bindParam(':schoolid', $id);
        $SORGU->execute();
        $approves[] = "School İnformation Update Successful!";
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
  <input type="text"  class="form-control" value="<?php echo $informations[0]['schoolname'] ?>" id="floatingInput" placeholder="School Name" name="form_name" required>
  <label for="floatingInput">School Name</label>
</div>
<div class="form-floating mb-3">
<select class="form-select" name="form_year" id="floatingSelect" aria-label="Floating label select example">
        <option disabled value="">Select Year</option>
        <!-- Chatgpt çözümü seçili YILI getirme ve listeleme -->
        <?php
// Başlangıç yılı (1950)
$startYear = 1950;
// Mevcut yıl
$currentYear = date("Y");
foreach ($informations as $information) {
    for ($year = $startYear; $year <= $currentYear; $year++) {
        $selected = ($year == $selectedYear) ? 'selected' : '';
        echo "<option value='{$year}' $selected>{$year}</option>";
    }

}
?>
    </select>
    <label for="floatingSelect">School Year</label>
</div>
<div class="form-floating mb-3">
<select class="form-select" name="form_term" id="floatingSelect1" aria-label="Floating label select example1">
        <option disabled value="">Select Term</option>
        <!-- Chatgpt çözümü seçili TERM getirme ve listeleme -->
        <?php
$sql = "SELECT * FROM informations";
$SORGU = $DB->prepare($sql);
$SORGU->execute();
$schoolinformations = $SORGU->fetchAll(PDO::FETCH_ASSOC);
foreach ($schoolinformations as $information) {
    $selected = ($information['schoolterm'] == $selectedTerm) ? 'selected' : '';
    echo "<option value='{$information['schoolterm']}' $selected>{$information['schoolterm']}</option>";
}
?>
    </select>
    <label for="floatingSelect1">School Term</label>
</div>
<div class="mb-3">
<label for="exampleFormControlInput2" class="form-label">School About</label>
  <textarea id="exampleFormControlInput2"  rows="3" cols="85" name="form_about" id="floatingTextarea">
  <?php echo nl2br($informations[0]['schoolabout']); ?>
  </textarea>
</div>
<div class="mb-3">
<label for="exampleFormControlInput2" class="form-label">School About Summary</label>
  <textarea id="exampleFormControlInput2"  rows="3" cols="85" name="form_summary" id="floatingTextarea">
  <?php echo nl2br($informations[0]['schoolsummary']); ?>
  </textarea>
</div>
<div class="mb-3">
<label for="exampleFormControlInput3" class="form-label">School Address</label>
  <textarea id="exampleFormControlInput3"  rows="3" cols="85" name="form_address" id="floatingTextarea">
  <?php echo nl2br($informations[0]['schooladdress']); ?>
  </textarea>
</div>
                  <button type="submit" name="form_submit" class="btn btn-primary mt-3 ">Update School İnformation
                  <i class="bi bi-send"></i>
                  </button>
     </form>
     </div>
</div>
</div>
<?php require 'footer.php';?>
<?php require 'down.html.php';?>