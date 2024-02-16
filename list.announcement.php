<?php
@session_start();
$activeTitle = "Announcement";
$activePage = "list.announcement";
require 'up.html.php';
require 'login.control.php';
?>
<?php require 'navbar.php'?>
<div class="container">
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
if (isset($_GET['removeannouncementid'])) {
    require 'db.php';
    $remove_id = $_GET['removeannouncementid'];

    $sql = "DELETE FROM announcements WHERE announcementid = :removeannouncementid";
    $SORGU = $DB->prepare($sql);

    $SORGU->bindParam(':removeannouncementid', $remove_id);

    $SORGU->execute();
    echo "<script>
alert('Announcement has been deleted. You are redirected to the Announcements List page...!');
window.location.href = 'list.announcement.php';
</script>";
}
require_once 'db.php';
$SORGU = $DB->prepare("SELECT * FROM announcements WHERE senderid=:userid AND senderrole=:roleid");
$SORGU->bindParam(':userid', $userid);
$SORGU->bindParam(':roleid', $roleid);
$SORGU->execute();
$fullAnnouncements = $SORGU->fetchAll(PDO::FETCH_ASSOC);
/* echo '<pre>';
print_r($fullAnnouncements);
die(); */
/* $fullAnnouncement['ispublish'] == 0 || $kaan == 0 */
if ($userid == $fullAnnouncements[0]['senderid']) {
    foreach ($fullAnnouncements as $fullAnnouncement) {
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

        $dateControl = strtotime($fullAnnouncement['startdate']) <= time() && strtotime($fullAnnouncement['lastdate']) >= time();
        $publishAlert = ''; // Her döngü adımında publishAlert sıfırlanıyor.
        //? Eğer ispublish 0 ise veya tarih kontrolü false ise
        if ($fullAnnouncement['ispublish'] == 0 || $dateControl == false) {
            $publishAlert = "<span style='float: right;' class='badge bg-danger fw-bolder fs-6 '>Not Published !!!</span>";
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
            <div class="ms-auto p-2">Date: <?php echo $formatted_datetime ?></div>
            <div class="text-end">
              <?php echo $update_button; ?>
              <?php echo $delete_button; ?>
            </div>
          </div>
          <?php echo $publishAlert; ?>
        </div>
      </div>
    </div>
<?php }
} else {
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
      <div class="d-flex mb-3">
                    <div class="p-2">
                    <?php echo $announcement['announcement']; ?>
                    </div>
                    <div class="ms-auto p-2">Date: <?php echo $formatted_datetime ?></div>
                </div>
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
