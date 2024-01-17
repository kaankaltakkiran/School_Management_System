<?php
@session_start(); // Oturumu aç
@session_destroy(); // Oturumu sonlandır
?>

<?php
@session_start();
if (!isset($_SESSION['isLogin'])) {
    // Oturum açmış
    header("location: index.php");
    die();
}
?>


