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
echo $userid;
$SORGU = $DB->prepare("SELECT * FROM announcements WHERE receiverid=:roleid");
$SORGU->bindParam(':roleid', $roleid);
$SORGU->execute();
$announcements = $SORGU->fetchAll(PDO::FETCH_ASSOC);
/* echo '<pre>';
print_r($announcements);
die(); */
foreach ($announcements as $announcement) {
    $announcementid = "accordionflush{$announcement['announcementid']}";
    ?>
      <div class="accordion-item">
        <h2 class="accordion-header" id="headingOne">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#<?php echo $announcementid ?>" aria-expanded="false" aria-controls="<?php echo $announcementid ?>">
          <?php echo $announcement['announcementtitle']; ?>
      </button>
        </h2>
        <div id="<?php echo $announcementid ?>" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
      <div class="accordion-body">
      <?php echo $announcement['announcement']; ?>
      </div>
    </div>
      </div>
      <?php }?>
    </div>
  </div>
</div>
</div>


<?php require 'down.html.php';?>
