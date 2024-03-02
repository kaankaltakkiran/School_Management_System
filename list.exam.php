<?php
@session_start();
$activeTitle = "List of Exams";
$activePage = "list.exam";
require 'up.html.php';
require 'login.control.php';
?>
  <?php
//! Rol idsi 3 olan teacher sadece exam listesini görebilir
if ($_SESSION['role'] != 3) {
    header("location: authorizationcontrol.php");
    die();
}
?>
<?php require 'navbar.php'?>
    <div class="container">
      <div class="row mt-3">
      <div class='row justify-content-center text-center'>
        <div class="col-sm-4 col-md-6 col-lg-8">
  <h1 class='alert alert-primary mt-2'>List Exam</h1>
  </div>
</div>
   <table id="example" class="table table-bordered table-striped " style="width:100%">
  <thead>
    <tr>
      <th>Exam Id</th>
      <th>Exam Image</th>
      <th>Exam Title</th>
      <th>Exam Description</th>
      <th>Exam Start Date</th>
      <th>Exam End Date</th>
      <th>Exam Time</th>
      <th>Exam Class Name</th>
      <th>Create Questions</th>
      <th>Manage</th>
      <th>Status</th>
    </tr>
  </thead>
  <tbody>
  </div>
    <?php
require_once 'db.php';
$addedid = $_SESSION['id'];
$SORGU = $DB->prepare("SELECT * FROM exams WHERE addedid=:addedid");
$SORGU->bindParam(':addedid', $addedid);
$SORGU->execute();
$exams = $SORGU->fetchAll(PDO::FETCH_ASSOC);
/* echo '<pre>';
print_r($exams);
die(); */
if (isset($_GET['removeExamid'])) {
    require 'db.php';
    $remove_id = $_GET['removeExamid'];
    $sql = "DELETE FROM exams WHERE examid = :removeExamid";
    $SORGU = $DB->prepare($sql);
    $SORGU->bindParam(':removeExamid', $remove_id);
    $SORGU->execute();
    echo "<script>
alert('Exam has been deleted. You are redirected to the Exam List page...!');
window.location.href = 'list.exam.php';
</script>";
}
foreach ($exams as $exam) {
    //! Status belirleme
    $dateControl = "";
    $publishControl = "";
    $status = "";
    $statusCount = 0;
    //! Veritabaında ki publish durumunu kontrol et
    $published = $exam['ispublish'];

    if ($published == 1) {
        $publishControl = "Published";
    } else {
        $publishControl = "Not Published !";
    }
    //!Bugünün tarihini al
    $today = date("Y-m-d");
    //! Veritabanındaki tarihleri al
    $startDate = $exam['examstartdate'];
    $endDate = $exam['examenddate'];
    //!Tarihler arasında olup olmadığını kontrol et
    if ($today >= $startdate && $today <= $endDate) {
        $dateControl = "Dates Available";
    } else {
        $dateControl = "Exam Date Is Not Within Today's Dates !";
    }
    //!Status belirleme
    //? Eğer publish durumu published ve tarihler uygunsa
    if ($publishControl == "Published" && $dateControl == "Dates Available") {
        $status = "Active";
        //? Eğer publish durumu not published ve tarihler uygunsa
    } else if ($publishControl == "Not Published !" && $dateControl == "Dates Available") {
        $status = "Deactive: Selectted Not Published !";
        $statusCount = 1;
        //? Eğer publish durumu published ve tarihler uygun değilse
    } else if ($publishControl == "Published" && $dateControl == "Exam Date Is Not Within Today's Dates !") {
        $status = "Deactive: Date Is Not Within Today's Dates !";
        $statusCount = 1;
        //? Eğer publish durumu not published ve tarihler uygun değilse
    } else if ($publishControl == "Not Published !" && $dateControl == "Exam Date Is Not Within Today's Dates !") {
        $status = "Deactive: Not Published and Date Is Not Within Today's Dates !";
        $statusCount = 1;
    }
    echo "
    <tr>
      <th>{$exam['examid']}</th>
      <td><img src='exam_images/{$exam['examimg']}' class='rounded-circle' width='100' height='100'></td>
      <td>{$exam['examtitle']}</td>
      <td>{$exam['examdescription']}</td>
      <td>{$exam['examstartdate']}</td>
      <td>{$exam['examenddate']}</td>
      <td>{$exam['examtime']} minutes</td>
      <td>{$exam['classname']}</td>
      <td><a href='add.questions.php?idExam={$exam['examid']}' class='btn btn-primary btn-sm'>Create Questions <i class='bi bi-plus-circle'></i></a></td>
      <td>
      <a href='update.exam.php?idExam={$exam['examid']}' class='btn btn-success mb-3  btn-sm'>Update <i class='bi bi-arrow-clockwise'></i></a>
      <a href='list.exam.php?removeExamid={$exam['examid']}'onclick='return confirm(\"Are you sure you want to delete {$exam['examtitle']}?\")' class='btn btn-danger btn-sm'>Delete <i class='bi bi-trash'></i></a>
    </td>
    <td";
    if ($statusCount == 1) {
        echo " class='bg-danger text-white '";
    } else {
        echo " class='bg-success text-white'";
    }
    echo ">$status</td>
   </tr>
  ";
}
?>
  </tbody>
</table>
</div>
<?php require 'down.html.php';?>