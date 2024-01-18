<?php
@session_start();
$activeTitle = "Add Teacher";
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
    $address = $_POST['form_adress'];
    $phoneNumber = $_POST['form_phonenumber'];
    $birthDate = $_POST['form_birthdate'];

    $password = $_POST['form_password'];
/*  Şifrele hashleme */
    $password = password_hash($password, PASSWORD_DEFAULT);

    //?Kullanıcı var mı yok mu kontrol etme
    $sql = "SELECT * FROM teachers WHERE useremail = :form_email";
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
        $sql = "INSERT INTO teachers (username,useremail,usergender,useraddress,phonenumber,birthdate,userpassword) VALUES (:form_username,:form_email,:form_gender,:form_adress,:form_phonenumber,:form_birthdate,'$password')";
        $SORGU = $DB->prepare($sql);
        $SORGU->bindParam(':form_username', $name);
        $SORGU->bindParam(':form_email', $email);
        $SORGU->bindParam(':form_gender', $gender);
        $SORGU->bindParam(':form_adress', $address);
        $SORGU->bindParam(':form_phonenumber', $phoneNumber);
        $SORGU->bindParam(':form_birthdate', $birthDate);

        $SORGU->execute();
        //!Kayıt başarılıysa login sayfasına yönlendir
        /* header("location: login.php"); */
        $approves[] = "Teacher User Added Successfully...";
    }
}
?>
    <div class="container">
  <div class="row justify-content-center mt-3">
  <div class="col-6">

<form method="POST">
<h1 class="alert alert-info text-center">Add Teacher User Form </h1>
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
  <label>Added By Register Unit Name</label>
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
<div class="form-floating mb-3">
  <textarea class="form-control text-break" style="height: 100px" placeholder="Adress" id="floatingTextarea"name="form_adress"  required></textarea>
  <label for="floatingTextarea">Address</label>
</div>
<div class="form-floating mb-3">
  <input type="tel"  class="form-control" maxlength="11" name="form_phonenumber" required>
  <label>Phone Number</label>
</div>
<div class="form-floating mb-3">
<div class="mb-3">
  <label for="exampleFormControlInput1" class="form-label">Birthdate</label>
  <input type="date" name="form_birthdate" class="form-control" id="exampleFormControlInput1" required/>
</div>
</div>
<div class="form-check">
  <input class="form-check-input" type="radio" name="form_gender" value="M" required >
  <label class="form-check-label" >
  Male
  </label>
</div>
<div class="form-check">
  <input class="form-check-input" type="radio" name="form_gender" value="F" required>
  <label class="form-check-label" >
  Female
  </label>
</div>

                  <button type="submit" name="submit" class="btn btn-primary mt-3 ">Add Teacher User</button>
     </form>
     </div>
</div>
</div>
<?php require 'footer.php'?>
<?php require 'down.html.php';?>
