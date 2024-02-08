<?php
session_start();
$activeTitle = "Announcement";
$activePage = "announcement";
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
if ($roleid == 1 || $roleid == 2) {
    $SORGU = $DB->prepare("SELECT * FROM announcements");
} else {
    $SORGU = $DB->prepare("SELECT * FROM announcements WHERE receiverid=:roleid AND ispublish=1 AND CURDATE() BETWEEN startdate AND lastdate");
}
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
foreach ($announcements as $announcement) {
    $announcementid = "accordionflush{$announcement['announcementid']}";
    $datetime = new DateTime($announcement["createdate"]);

    // Tarih ve saat formatını ayarlayın
    $formatted_datetime = date_format($datetime, 'd.m.Y H:i');
    ?>
      <div class="accordion-item">
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
                    <div class="text-end">
                    <a href="update.announcement.php?idannouncement=<?php echo $announcement['announcementid']; ?>" class="btn btn-success me-2">Update</a>
                    <a href="list.announcement.php?removeannouncementid=<?php echo $announcement['announcementid']; ?>" onclick="return confirm('Are you sure you want to delete <?php echo $announcement['announcementtitle']; ?>?')" class="btn btn-danger">Delete</a>

                </div>
                </div>
      </div>
    </div>
      </div>
      <?php }?>
    </div>
  </div>
</div>
</div>
<?php require 'down.html.php';?>
