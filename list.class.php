<?php
session_start();
$activeTitle = "Class List";
$activePage = "index";
require 'up.html.php';
?>
<?php require 'navbar.php'?>

    <div class="container">
      <div class="row mt-3">
      <div class='row justify-content-center text-center'>
        <div class="col-sm-4 col-md-6 col-lg-8">
  <h1 class='alert alert-primary mt-2'>Class List</h1>
  </div>
  <div class='row text-end'>
  <p>
    <a href='add.class.php' class="btn btn-warning btn-sm ">
     Add New Class<i class="bi bi-send"></i> </a>
  </p>
</div>
</div>
   <!-- tablo ile personel listeleme -->
<table class="table table-bordered table-striped">
  <thead>
    <tr>
      <th>Class Id</th>
      <th>Class Name</th>
      <th>Create Date</th>
      <th>Update</th>
      <th>Delete</th>
      <th>List Students</th>
    </tr>
  </thead>
  <tbody>
  </div>

    <?php

require_once 'db.php';

$SORGU = $DB->prepare("SELECT * FROM classes LIMIT 16");
$SORGU->execute();
$classes = $SORGU->fetchAll(PDO::FETCH_ASSOC);
//echo '<pre>'; print_r($classes);

foreach ($classes as $class) {
    echo "
    <tr>
      <th>{$class['classid']}</th>
      <td>{$class['classname']}</td>
      <td>{$class['createdate']}</td>
      <td><a href='update.admin.php?idClass={$class['classid']}' class='btn btn-success btn-sm'>Update</a></td>
      <td><a href='update.admin.php?removeClassid={$class['classid']}' class='btn btn-danger btn-sm'>Delete</a></td>
      <td><a href='update.admin.php?idClass={$class['classid']}' class='btn btn-info btn-sm'>list Students</a></td>
   </tr>
  ";
}
?>

  </tbody>
</table>
</div>
<?php require 'down.html.php';?>