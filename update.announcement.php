<?php
@session_start();
$activeTitle = "Announcement Update";
$activePage = "index";
require 'up.html.php';
require 'login.control.php';
?>
<?php
if ($_SESSION['role'] != 1 and $_SESSION['role'] != 2) {
    header("location: authorizationcontrol.php");
    die();
}
?>
    <?php include 'navbar.php';?>
  <div class="container">
  <div class="row justify-content-center mt-3">
  <div class="col-6">
<form method="POST">
<h1 class="alert alert-info text-center">Announcement Update</h1>
<?php
require_once 'db.php';
$id = $_GET['idannouncement'];
$sql = "SELECT * FROM announcements WHERE announcementid = :idannouncement";
$SORGU = $DB->prepare($sql);

$SORGU->bindParam(':idannouncement', $id);

$SORGU->execute();

$announcements = $SORGU->fetchAll(PDO::FETCH_ASSOC);
/* var_dump($announcements);
die(); */
$isPublis = $announcements[0]['ispublish'];
if (isset($_POST['form_submit'])) {
    //!htmlspecialchars() kullanıcıdan alınan veriyi güvenli hale getirir
    //! eğer kullanıcı zararlı bir kod gönderirse bunu html etiketlerine dönüştürür
    //?Kullanıcıdan alınan veriler
    $announcementTitle = htmlspecialchars($_POST['form_title']);
    $announcementStartDate = $_POST['form_startdate'];
    $announcementLastDate = $_POST['form_lastdate'];
//!Checkbox değeri kontrolü
    //?checkbox işaretli ise 1 değilse 0
    $isPublish = isset($_POST['form_ispublish']) ? 1 : 0;
    $announcementContent = htmlspecialchars($_POST['form_announcement']);

    $sql = "UPDATE announcements SET announcementtitle = :form_title, startdate = :form_startdate, lastdate=:form_lastdate,ispublish=:form_ispublish,announcement=:form_announcement WHERE announcementid = :idannouncement";
    $SORGU = $DB->prepare($sql);
    $SORGU->bindParam(':form_title', $announcementTitle);
    $SORGU->bindParam(':form_startdate', $announcementStartDate);
    $SORGU->bindParam(':form_lastdate', $announcementLastDate);
    $SORGU->bindParam(':form_ispublish', $isPublish);
    $SORGU->bindParam(':form_announcement', $announcementContent);
    $SORGU->bindParam(':idannouncement', $id);
    $SORGU->execute();
    echo '<script>';
    echo 'alert("Announcement  Update Successful!");';
    echo 'window.location.href = "update.announcement.php?idannouncement=' . $announcements[0]['announcementid'] . '";';
    echo '</script>';
}
?>
<div class="form-floating mb-3">
  <input type="text"  class="form-control" value="<?php echo $_SESSION['userName'] ?>"disabled readonly>
  <label>Update By Register Unit Name</label>
</div>
<div class="form-floating mb-3">
  <input type="text"  class="form-control" value="<?php echo $announcements[0]['announcementtitle'] ?>" name="form_title">
  <label>Announcement Title</label>
</div>
<div class="form-floating mb-3">
<div class="mb-3">
  <label for="exampleFormControlInput1" class="form-label">Start Publish Date</label>
  <input type="date" name="form_startdate" value="<?php echo $announcements[0]['startdate']; ?>" class="form-control" id="exampleFormControlInput1"  />
</div>
</div>
<div class="form-floating mb-3">
<div class="mb-3">
  <label for="exampleFormControlInput2" class="form-label">Last Published Date</label>
  <input type="date" name="form_lastdate" value="<?php echo $announcements[0]['lastdate']; ?>" class="form-control" id="exampleFormControlInput2"  min="<?php echo date('Y-m-d'); ?>" />
</div>
<div class="mb-3">
<div class="form-check">
  <input class="form-check-input" <?php echo ($isPublis == 1) ? 'checked' : ''; ?>  name='form_ispublish' type="checkbox"  id="flexCheckChecked">
  <label class="form-check-label" for="flexCheckChecked">Publish Announcement</label>
</div>
</div>
<div class="mb-3">
<label for="exampleFormControlInput2" class="form-label">Announcement</label>
  <textarea id="exampleFormControlInput2"  rows="5" cols="85"  name="form_announcement" id="floatingTextarea"required>
  <?php echo nl2br($announcements[0]['announcement']) ?>
  </textarea>
</div>
                  <button type="submit" name="form_submit" class="btn btn-primary mt-3 ">Update Announcement</button>
     </form>
     </div>

</div>

</div>
<?php require 'down.html.php';?>