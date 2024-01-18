<?php
@session_start();
$activeTitle = "Add Admin";
require 'up.html.php';
?>
<?php require 'navbar.php'?>
<?php
//!form submit edilmişse
if (isset($_POST['submit'])) {
    //!Hata mesajlarını göstermek için boş bir dizi
    $errors = array();
    require_once 'db.php';
    $name = $_POST['form_username'];
    $email = $_POST['form_email'];
    $gender = $_POST['form_gender'];
    $password = $_POST['form_password'];
/*  Şifrele hashleme */
    $password = password_hash($password, PASSWORD_DEFAULT);

    //?Kullanıcı var mı yok mu kontrol etme
    $sql = "SELECT * FROM admins WHERE useremail = :form_email";
    $SORGU = $DB->prepare($sql);
    $SORGU->bindParam(':form_email', $email);
    $SORGU->execute();
    $isUser = $SORGU->fetch(PDO::FETCH_ASSOC);
    /*  echo '<pre>';
    print_r($isUser);
    die(); */
    //!Eğer kullanıcı üye olmuşsa  hata ver
    if ($isUser) {
        $errors[] = "This email is already registered";

        //!Eğer kullanıcı yoksa kaydet
    } else {
        $sql = "INSERT INTO admins (username,useremail,usergender,userpassword) VALUES (:form_username,:form_email,:form_gender,'$password')";
        $SORGU = $DB->prepare($sql);
        $SORGU->bindParam(':form_username', $name);
        $SORGU->bindParam(':form_email', $email);
        $SORGU->bindParam(':form_gender', $gender);

        $SORGU->execute();
        //!Kayıt başarılıysa login sayfasına yönlendir
        /* header("location: login.php"); */
        $approves[] = "Admin Added Successfully...";
    }
}
?>
    <div class="container">
  <div class="row justify-content-center mt-3">
  <div class="col-6">

<form method="POST">
<h1 class="alert alert-info text-center">Add Admin User Form</h1>
<?php
//! Hata mesajlarını göster
if (!empty($errors)) {
    foreach ($errors as $error) {
        echo '
      <div class="container">
  <div class="auto-close alert mt-3 text-center alert-danger" role="alert">
  ' . $error . '
  </div>
  </div>
  ';
    }
}
//! Başarılı mesajlarını göster
if (!empty($approves)) {
    foreach ($approves as $approve) {
        echo '
    <div class="container">
<div class="auto-close alert mt-3 text-center alert-success" role="alert">
' . $approve . '
</div>
</div>
';
    }
}
?>
  <div class="form-floating mb-3">
  <input type="text"  class="form-control" value="<?php echo $_SESSION['userName'] ?>"disabled readonly>
  <label>Added By Admin Name</label>
</div>
<div class="form-floating mb-3">
  <input type="text"  class="form-control" name="form_username" required>
  <label>User Name</label>
</div>
  <div class="form-floating mb-3">
  <input type="email" name="form_email"class="form-control"required>
  <label>Email</label>
</div>
<div class="input-group mb-3  input-group-lg">
  <input type="password"  name="form_password" class="form-control" id="password" placeholder="Password"required>
  <span class="input-group-text bg-transparent"><i id="togglePassword" class="bi bi-eye-slash"></i></span>
</div>
<div class="form-check">
  <input class="form-check-input" type="radio" name="form_gender" value="M" required >
  <label class="form-check-label" >
  Male
  </label>
</div>
<div class="form-check mb-3">
  <input class="form-check-input" type="radio" name="form_gender" value="F" required>
  <label class="form-check-label" >
  Female
  </label>
</div>
<div class="input-group mb-3">
  <input type="file"  name='form_image' class="form-control" id="inputGroupFile02"required>
  <label class="input-group-text" for="inputGroupFile02">Upload Blog Image</label>
</div>

                  <button type="submit" name="submit" class="btn btn-primary mt-3 ">Add Admin</button>
     </form>
     </div>
</div>
</div>
<?php require 'down.html.php';?>
