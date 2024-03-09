<?php
@session_start();
$activeTitle = "Teacher List Class List";
$activePage = "teacher.list.class.list";
require 'up.html.php';
require 'login.control.php';
?>
<?php
//! Rol idsi 3 olan teacher sadece kendi sınıf listesini görebilir
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
  <h1 class='alert alert-primary mt-2'>Teacher List Note Class List</h1>
  </div>
</div>
</div>
   <!-- tablo ile Class listeleme -->
   <table id="example" class="table table-bordered table-striped " style="width:100%">
  <thead>
    <tr>
      <th>Class Id</th>
      <th>Class Name</th>
    </tr>
  </thead>
  <tbody>
  </div>
    <?php
require_once 'db.php';
$teacher_id = $_SESSION['id'];
$SORGU = $DB->prepare("SELECT * FROM teachers WHERE userid=:teacherid");
$SORGU->bindParam(':teacherid', $teacher_id);
$SORGU->execute();
$teachers = $SORGU->fetchAll(PDO::FETCH_ASSOC);
echo '<pre>';
/* print_r($teachers);
die();
 */
//!Teacher tablosundan classid ve classname alanlarını alırız
$haveClassId = $teachers[0]['classid'];
$haveClassName = $teachers[0]['classname'];
//!classid ve classname alanlarını virgülle ayırarak diziye çeviririz
$haveClassIdArray = explode(",", $haveClassId);
$haveClassNameArray = explode(",", $haveClassName);
foreach ($haveClassIdArray as $index => $classId) {
    //! $haveClassNameArray[$index] ile eşleşen sınıf adını alırız
    $className = $haveClassNameArray[$index];
    echo "
    <tr>
        <th>{$classId}</th>
        <td><a href='list.note.php?className={$className}' class='link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover'>{$className}</a></td>
    </tr>
    ";
}
?>
  </tbody>
</table>
</div>
<?php require 'down.html.php';?>