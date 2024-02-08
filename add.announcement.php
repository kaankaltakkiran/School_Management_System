<?php
@session_start();
$activeTitle = "Send Announcement";
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
if (isset($_POST['form_submit'])) {
    //!Hata mesajlarını göstermek için boş bir dizi
    $errors = array();

    require_once 'db.php';
    $announcementSenderid = $_SESSION['id'];
    $announcementReciverid = $_POST['form_reciverid'];
    $announcementTitle = $_POST['form_title'];
    $announcementContent = $_POST['form_announcement'];

    // Insert into Database
    $sql = "INSERT INTO announcements (senderid,receiverid,announcementtitle,announcement) VALUES (:senderid,:receiverid,:announcementtitle,:announcement)";
    $SORGU = $DB->prepare($sql);
    $SORGU->bindParam(':senderid', $announcementSenderid);
    $SORGU->bindParam(':receiverid', $announcementReciverid);
    $SORGU->bindParam(':announcementtitle', $announcementTitle);
    $SORGU->bindParam(':announcement', $announcementContent);

    $SORGU->execute();
    $approves[] = "Announcement Sent Successfully...";
}
?>
    <div class="container">
  <div class="row justify-content-center mt-3">
  <div class="col-6">

<form method="POST">
<h1 class="alert alert-info text-center">Send Announcement</h1>
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
  <input type="text"  class="form-control" name="form_title" required>
  <label>Announcement Title</label>
</div>
<div class="form-floating mb-3">
  <select class="form-select" id="floatingSelect" name="form_reciverid"  required aria-label="Floating label select example" >
    <option selected disabled>Select Receiver User</option>
    <option value="1">Admin</option>
    <option value="2">Register Unit</option>
    <option value="3">Teacher</option>
    <option value="4">Student</option>
  </select>
  <label for="floatingSelect">Receiver</label>
</div>
<div class="form-floating">
  <textarea class="form-control" placeholder="Leave a Announcement here" id="floatingTextarea2" name="form_announcement" style="height: 100px"></textarea>
  <label for="floatingTextarea2">Announcement</label>
</div>

                  <button type="submit" name="form_submit" class="btn btn-primary mt-3 ">Send Announcement</button>
     </form>
     </div>
</div>
</div>
<?php require 'down.html.php';?>
