<?php
@session_start();
require 'up.html.php';
?>
  <?php
echo "<h1 class='text-center text-danger mt-5'>Time Is Up!</h1>";
echo '
  <div class="row text-center">
  <p><a href="index.php" class="btn btn-warning btn-sm mt-3 "> Return Home Page </a></p>
  </div>
  ';
die();
?>
<?php require 'down.html.php';?>