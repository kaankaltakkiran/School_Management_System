<?php
@session_start();
$activeTitle = "School İnformation Update";
$activePage = "update.information";
require 'up.html.php';
require 'login.control.php';
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

    $sql = "UPDATE informations SET schoolname = :form_name,schoolyear=:form_year,schoolterm=:form_term,schoolabout=:form_about,schoolsummary=:form_summary,schooladdress=:form_address WHERE schoolid = :schoolid";
    //! Kullanıcı OKUL ismini değiştirdiyse, yeni okul  ismi için veritabanında mevcut bir kullanıcı olup olmadığını kontrol et
    //? Eğer post edilen ism update yapılan kişinin dışında bir ismi varsa hata mesajı göster
    $checkNameQuery = $DB->prepare("SELECT * FROM informations WHERE schoolname = :form_name AND schoolid != :schoolid");
    $checkNameQuery->bindParam(':form_name', $schoolName);
    $checkNameQuery->bindParam(':schoolid', $id);
    $checkNameQuery->execute();
    $existingName = $checkNameQuery->fetch(PDO::FETCH_ASSOC);
    if ($existingName) {
        echo '<script>';
        echo 'alert("This School Name is already in use.!");';
        echo 'window.location.href = "update.information.php?schoolid=' . $informations[0]['schoolid'] . '";';
        echo '</script>';
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
        echo '<script>';
        echo 'alert("School İnformation  Update Successful!");';
        echo 'window.location.href = "update.information.php?schoolid=' . $informations[0]['schoolid'] . '";';
        echo '</script>';
    }
}
?>
<div class="form-floating mb-3">
  <input type="text"  class="form-control" value="<?php echo $_SESSION['userName'] ?>"disabled readonly>
  <label>Added By Register Unit Name</label>
</div>
<div class="form-floating mb-3">
  <input type="text"  class="form-control" name="form_name" value="<?php echo $informations[0]['schoolname'] ?>">
  <label>School Name</label>
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
<?php require 'down.html.php';?>