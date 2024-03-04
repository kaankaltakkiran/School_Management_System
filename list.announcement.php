<?php
@session_start();
$activeTitle = "Announcement";
$activePage = "list.announcement";
require 'up.html.php';
require 'login.control.php';
?>
<?php
if (isset($_GET['removeannouncementid'])) {
    $approves = array();
    require 'db.php';
    $remove_id = $_GET['removeannouncementid'];
    $sql = "DELETE FROM announcements WHERE announcementid = :removeannouncementid";
    $SORGU = $DB->prepare($sql);
    $SORGU->bindParam(':removeannouncementid', $remove_id);
    $SORGU->execute();
    $approves[] = "Announcement Deleted Successfully...";
}
?>
<?php require 'navbar.php'?>
<div class="container">
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
    <div class="row justify-content-center ">
    <div class="col-sm-4 col-md-6 col-lg-8">
    <!--   Mesaj başlığı -->
    <h1 class='alert alert-primary mt-2 text-center'>Announcement</h1>
<!--     Mesaj bölümü -->
<div class="accordion accordion-flush" id="accordionFlushExample">
      <?php
require_once 'db.php';
$roleid = $_SESSION['role'];
$userid = $_SESSION['id'];
$SORGU = $DB->prepare("SELECT * FROM announcements WHERE receiverrole=:roleid AND ispublish=1 AND CURDATE() BETWEEN startdate AND lastdate");
$SORGU->bindParam(':roleid', $roleid);
$SORGU->execute();
$announcements = $SORGU->fetchAll(PDO::FETCH_ASSOC);
/* echo '<pre>';
print_r($announcements);
die(); */

require_once 'db.php';
$SORGU = $DB->prepare("SELECT * FROM announcements WHERE senderid=:userid AND senderrole=:roleid");
$SORGU->bindParam(':userid', $userid);
$SORGU->bindParam(':roleid', $roleid);
$SORGU->execute();
$fullAnnouncements = $SORGU->fetchAll(PDO::FETCH_ASSOC);
/* echo '<pre>';
print_r($fullAnnouncements);
die(); */
$sql = "UPDATE announcements SET readcount =readcount + 1 WHERE senderid=:userid AND senderrole=:roleid";
$SORGU = $DB->prepare($sql);
$SORGU->bindParam(':userid', $userid);
$SORGU->bindParam(':roleid', $roleid);
$SORGU->execute();
if ($userid == $fullAnnouncements[0]['senderid']) {
    foreach ($fullAnnouncements as $fullAnnouncement) {
        //! Status belirleme
        $dateControl = "";
        $publishControl = "";
        $status = "";
        $statusCount = 0;
        //! Veritabaında ki publish durumunu kontrol et
        $published = $fullAnnouncement['ispublish'];

        if ($published == 1) {
            $publishControl = "Published";
        } else {
            $publishControl = "Not Published !";
        }
        //!Bugünün tarihini al
        $today = date("Y-m-d");
        //! Veritabanındaki tarihleri al
        $startDate = $fullAnnouncement['startdate'];
        $endDate = $fullAnnouncement['lastdate'];
        //!Tarihler arasında olup olmadığını kontrol et
        if ($today >= $startdate && $today <= $endDate) {
            $dateControl = "Dates Available";
        } else {
            $dateControl = "Announcement Date Is Not Within Today's Dates !";
        }
        //!Status belirleme
        //? Eğer publish durumu published ve tarihler uygunsa
        if ($publishControl == "Published" && $dateControl == "Dates Available") {
            $status = "<span class='badge rounded-pill text-bg-success float-end'>Active</span> ";
            //? Eğer publish durumu not published ve tarihler uygunsa
        } else if ($publishControl == "Not Published !" && $dateControl == "Dates Available") {
            $status = "<span class='badge rounded-pill text-bg-danger float-end'>Deactive: Selectted Not Published !</span>";
            $statusCount = 1;
            //? Eğer publish durumu published ve tarihler uygun değilse
        } else if ($publishControl == "Published" && $dateControl == "Announcement Date Is Not Within Today's Dates !") {
            $status = "<span class='badge rounded-pill text-bg-danger float-end'>Deactive: Date Is Not Within Today's Dates !</span>";
            $statusCount = 1;
            //? Eğer publish durumu not published ve tarihler uygun değilse
        } else if ($publishControl == "Not Published !" && $dateControl == "Announcement Date Is Not Within Today's Dates !") {
            $status = "<span class='badge rounded-pill text-bg-danger float-end'>Deactive: Not Published and Date Is Not Within Today's Dates !</span>";
            $statusCount = 1;
        }

        //!Kullanıcı role id sine göre role adını belirleme
        $senderRole = "";
        if ($fullAnnouncement['senderrole'] == 1) {
            $senderRole = "Admin";
        } else if ($fullAnnouncement['senderrole'] == 2) {
            $senderRole = "Register Unit";
        } else if ($fullAnnouncement['senderrole'] == 3) {
            $senderRole = "Teacher";
        } else if ($fullAnnouncement['senderrole'] == 4) {
            $senderRole = "Student";
        } else if ($fullAnnouncement['senderrole'] == 5) {
            $senderRole = "Parent";
        } else if ($fullAnnouncement['senderrole'] == 6) {
            $senderRole = "Other";
        }

        $update_button = '<a href="update.announcement.php?idannouncement=' . $fullAnnouncement['announcementid'] . '" class="btn btn-success me-2">Update <i class="bi bi-arrow-clockwise"></i></a>';

        $delete_button = '<a href="list.announcement.php?removeannouncementid=' . $fullAnnouncement['announcementid'] . '" onclick="return confirm(\'Are you sure you want to delete ' . $fullAnnouncement['announcementtitle'] . '?\')" class="btn btn-danger">Delete <i class="bi bi-trash"></i></a>';

        $announcementid = "accordionflush{$fullAnnouncement['announcementid']}";
        $datetime = new DateTime($fullAnnouncement["createdate"]);

        // Tarih ve saat formatını ayarlayın
        $formatted_datetime = date_format($datetime, 'd.m.Y H:i');
        ?>
    <div class="accordion-item mt-4 ">
    <span class="badge bg-danger">Sender Name: <?php echo $fullAnnouncement['sendername']; ?></span>
    <span class="badge bg-success float-end ">Sender Role: <?php echo $senderRole ?></span>
      <h2 class="accordion-header" id="headingOne">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#<?php echo $announcementid ?>" aria-expanded="false" aria-controls="<?php echo $announcementid ?>">
          <?php echo $fullAnnouncement['announcementtitle']; ?>
        </button>
      </h2>
      <div id="<?php echo $announcementid ?>" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
        <div class="accordion-body">
          <div class="d-flex mb-3">
            <div class="p-2">
              <?php echo nl2br($fullAnnouncement['announcement']) ?>
            </div>
            <div class="ms-auto p-2"></div>
            <div class="text-end">
              <?php echo $update_button; ?>
              <?php echo $delete_button; ?>
            </div>
          </div>
          <?php echo $status; ?>
          <span class="badge bg-primary float-end me-2  "><?php echo $fullAnnouncement['createdate'] ?> / Read <?php echo $fullAnnouncement['readcount'] ?> times. </span>
        </div>
      </div>
    </div>
<?php }
} else {
    $sql = "UPDATE announcements SET readcount =readcount + 1 WHERE receiverrole=:roleid";
    $SORGU = $DB->prepare($sql);
    $SORGU->bindParam(':roleid', $roleid);
    $SORGU->execute();
    foreach ($announcements as $announcement) {
        //!Kullanıcı role id sine göre role adını belirleme
        $senderRole = "";
        if ($announcement['senderrole'] == 1) {
            $senderRole = "Admin";
        } else if ($announcement['senderrole'] == 2) {
            $senderRole = "Register Unit";
        } else if ($announcement['senderrole'] == 3) {
            $senderRole = "Teacher";
        } else if ($announcement['senderrole'] == 4) {
            $senderRole = "Student";
        } else if ($announcement['senderrole'] == 5) {
            $senderRole = "Parent";
        } else if ($announcement['senderrole'] == 6) {
            $senderRole = "Other";
        }
        $announcementid = "accordionflush{$announcement['announcementid']}";
        $datetime = new DateTime($announcement["createdate"]);

        // Tarih ve saat formatını ayarlayın
        $formatted_datetime = date_format($datetime, 'd.m.Y H:i');
        ?>
      <div class="accordion-item mt-4 ">
      <span class="badge bg-danger">Sender Name: <?php echo $announcement['sendername']; ?></span>
    <span class="badge bg-success float-end ">Sender Role: <?php echo $senderRole ?></span>
        <h2 class="accordion-header" id="headingOne">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#<?php echo $announcementid ?>" aria-expanded="false" aria-controls="<?php echo $announcementid ?>">
          <?php echo $announcement['announcementtitle']; ?>
      </button>
        </h2>
        <div id="<?php echo $announcementid ?>" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
      <div class="accordion-body">
      <div class="d-flex">
                    <div class="p-2">
                    <?php echo $announcement['announcement']; ?>
                    </div>
                    <div class="ms-auto"></div>
                </div>
                <span class="badge bg-primary float-end me-2  "><?php echo $announcement['createdate'] ?> / Read <?php echo $announcement['readcount'] ?> times. </span>
      </div>
    </div>
      </div>
      <?php }
}
?>
    </div>
  </div>
</div>
</div>
<?php require 'down.html.php';?>
