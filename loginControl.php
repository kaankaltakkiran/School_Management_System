<?php
@session_start();
if (isset($_SESSION['isLogin'])) {
  // Oturum açmışsa
} else {
  // Giriş yapmamışsa
  header("location: login.php");
  die();
}