<?php
@session_start();
$activeTitle = "Food List Menu";
$activePage = "food.list";
require 'up.html.php';
require 'login.control.php';
?>
<?php require 'navbar.php'?>
    <div class="container">
      <div class="row mt-3">
      <div class='row justify-content-center text-center'>
        <div class="col-sm-4 col-md-6 col-lg-8">
  <h1 class='alert alert-primary mt-2'>Food List Menu</h1>
  </div>
</div>
<?php $GUN = date("N"); // 1-7 arası değer alır. Pazartesi için 1 vb. ?>
   <!-- tablo ile Food listeleme -->
   <table id="example" class="table table-bordered table-striped " style="width:100%">
  <thead>
    <tr>
      <th>Food List Id</th>
      <th <?php if ($GUN == 1) {
    echo " class='bg-info' ";
}
?>>Monday</th>
      <th <?php if ($GUN == 2) {
    echo " class='bg-info' ";
}
?>>Tuesday</th>
      <th <?php if ($GUN == 3) {
    echo " class='bg-info' ";
}
?>>Wednesday</th>
      <th <?php if ($GUN == 4) {
    echo " class='bg-info' ";
}
?>>Thursday</th>
      <th <?php if ($GUN == 5) {
    echo " class='bg-info' ";
}
?>>Friday</th>
      <th <?php if ($GUN == 6) {
    echo " class='bg-info' ";
}
?>>Saturday</th>
      <th <?php if ($GUN == 7) {
    echo " class='bg-info' ";
}
?>>Sunday</th>
    </tr>
  </thead>
  <tbody>
  </div>

    <?php

require_once 'db.php';
$addedUnitid = $_SESSION['id'];
$SORGU = $DB->prepare("SELECT * FROM foodlist WHERE addedunitid = :unitid");
$SORGU->bindParam(':unitid', $addedUnitid);
$SORGU->execute();
$foods = $SORGU->fetchAll(PDO::FETCH_ASSOC);
//echo '<pre>'; print_r($foods);

foreach ($foods as $food) {
    echo "
    <tr>
      <th>{$food['id']}</th>
      <td>" . nl2br($food['day1']) . "</td>
      <td>" . nl2br($food['day2']) . "</td>
      <td>" . nl2br($food['day3']) . "</td>
      <td>" . nl2br($food['day4']) . "</td>
      <td>" . nl2br($food['day5']) . "</td>
      <td>" . nl2br($food['day6']) . "</td>
      <td>" . nl2br($food['day7']) . "</td>
    </tr>
  ";
}
?>
  </tbody>
</table>
</div>
<?php require 'down.html.php';?>