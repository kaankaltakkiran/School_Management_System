<?php
@session_start();
$activeTitle = "Send Announcement";
$activePage = "send.announcement";
require 'up.html.php';
require 'login.control.php';
?>
  <?php
//! Student role id 4 dir ve studentlerin duyuru ekleme yetkisi yoktur
if ($_SESSION['role'] == 4) {
    header("location: authorizationcontrol.php");
    die();
}
?>
<?php
require 'navbar.php'?>
<?php
//!Veri tabanına duyuru ekleme
if (isset($_POST['submit_form'])) {
    //!Hata mesajlarını göstermek için boş bir dizi
    $errors = array();
    require_once 'db.php';
    //!htmlspecialchars() kullanıcıdan alınan veriyi güvenli hale getirir
    //! eğer kullanıcı zararlı bir kod gönderirse bunu html etiketlerine dönüştürür
    $announcementSenderid = $_SESSION['id'];
    $announcementSenderRole = $_SESSION['role'];
    $announcementSenderName = $_SESSION['userName'];
    $announcementReciverRole = htmlspecialchars($_POST['form_reciverrole']);
    $announcementTitle = htmlspecialchars($_POST['form_title']);
    $announcementStartDate = $_POST['form_startdate'];
    $announcementLastDate = $_POST['form_lastdate'];
//!Checkbox değeri kontrolü
    //?checkbox işaretli ise 1 değilse 0
    $isPublish = isset($_POST['form_ispublish']) ? 1 : 0;
    $announcementContent = htmlspecialchars($_POST['form_announcement']);

    // Insert into Database
    $sql = "INSERT INTO announcements (senderid,sendername,senderrole,receiverrole,announcementtitle,startdate,lastdate,ispublish,announcement) VALUES (:senderid,:sendername,:senderrole,:form_reciverrole,:announcementtitle,:form_startdate,:form_lastdate,:form_ispublish,:announcement)";
    $SORGU = $DB->prepare($sql);
    $SORGU->bindParam(':senderid', $announcementSenderid);
    $SORGU->bindParam(':sendername', $announcementSenderName);
    $SORGU->bindParam(':senderrole', $announcementSenderRole);
    $SORGU->bindParam(':form_reciverrole', $announcementReciverRole);
    $SORGU->bindParam(':announcementtitle', $announcementTitle);
    $SORGU->bindParam(':form_startdate', $announcementStartDate);
    $SORGU->bindParam(':form_lastdate', $announcementLastDate);
    $SORGU->bindParam(':form_ispublish', $isPublish);
    $SORGU->bindParam(':announcement', $announcementContent);

    $SORGU->execute();
    $approves[] = "Announcement Sent Successfully...";
}
?>
    <div class="container">
  <div class="row justify-content-center mt-3">
  <div class="col-6">
<form method="POST" class="needs-validation"novalidate>
<h1 class="alert alert-info text-center">Send Announcement</h1>
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
  <label>Added By</label>
</div>
<div class="form-floating mb-3">
  <input type="text" id="floatingInput" placeholder="Announcement Title"  class="form-control" name="form_title" required>
  <label for="floatingInput">Announcement Title</label>
  <div class="invalid-feedback fw-bold">
      Please Write Announcement Title !
    </div>
</div>
<div class="form-floating mb-3">
  <select class="form-select" id="floatingSelect" name="form_reciverrole"  required aria-label="Floating label select example" >
    <option selected disabled value="">Select Receiver User</option>
    <option value="1">Admin</option>
    <option value="2">Register Unit</option>
    <option value="3">Teacher</option>
    <option value="4">Student</option>
  </select>
  <label for="floatingSelect">Receiver</label>
  <div class="invalid-feedback fw-bold">
      Please Select Receiver !
    </div>
</div>
<div class="form-floating mb-3">
<div class="mb-3">
  <label for="exampleFormControlInput1" class="form-label">Start Publish Date</label>
  <input type="date" name="form_startdate" required class="form-control" id="exampleFormControlInput1"  min="<?php echo date('Y-m-d'); ?>" />
  <div class="invalid-feedback fw-bold">
      Please Select Start Publish Date !
    </div>
</div>
</div>
<div class="form-floating mb-3">
<div class="mb-3">
  <label for="exampleFormControlInput2" class="form-label">Last Published Date</label>
  <input type="date" name="form_lastdate" required class="form-control" id="exampleFormControlInput2"  min="<?php echo date('Y-m-d'); ?>" />
  <div class="invalid-feedback fw-bold">
      Please Select Last Published Date !
    </div>
</div>
</div>
<div class="mb-3">
<div class="form-check">
  <input class="form-check-input" type="checkbox" name='form_ispublish' id="flexCheckChecked" required>
  <label class="form-check-label" for="flexCheckChecked">
  Publish Announcement
  </label>
  <div class="invalid-feedback fw-bold">
      Please Select Publish Announcement !
    </div>
</div>
</div>
<div class="form-floating">
  <textarea class="form-control" placeholder="Leave a Announcement here" id="floatingTextarea2" name="form_announcement" style="height: 100px" required></textarea>
  <label for="floatingTextarea2">Announcement</label>
  <div class="invalid-feedback fw-bold">
      Please Write Announcement !
    </div>
</div>
                  <button type="submit" name="submit_form" class="btn btn-primary mt-3 ">Send Announcement
                  <i class="bi bi-send"></i>
                  </button>
     </form>
     </div>
</div>
</div>
<?php require 'footer.php';?>
<?php require 'down.html.php';?>
