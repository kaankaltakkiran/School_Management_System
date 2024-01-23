<?php
@session_start();
$activeTitle = "Login";
$activePage = "login";
require 'up.html.php';
?>
<?php
require_once 'db.php';

require 'navbar.php';

//! Eğer zaten giriş yapmışsa, index.php'ye yönlendir
if (isset($_SESSION['isLogin'])) {
    // Oturum açmış
    header("location: index.php");
    die();
}
//!form_email post edilmişse
if (isset($_POST['form_email'])) {
    // Form gönderildi
    // 1.DB'na bağlan
    // 2.SQL hazırla ve çalıştır
    // 3.Gelen sonuç 1 satırsa GİRİŞ BAŞARILI değilse, BAŞARISIZ

    //!Form dan gelen login tipi
    $rol = $_POST['form_selectrol'];

    // Hata kontrolü
    $errors = array();

    //! Eğer boş alan varsa uyarı mesajı
    if (empty($_POST["form_email"]) || empty($_POST["form_password"])) {

        $errors[] = "Both Fields are required";
    }
    //! Boş alan yoksa
    else {
        //! Post edilen verileri değişkenlere atama
        $useremail = $_POST['form_email'];
        $userpassword = $_POST['form_password'];
        //! SQL hazırlama ve çalıştırma
        //! formdan gelen email ile db de varsa

        //! user rol 1 ise admin tablosundan sorgula
        if ($rol == 1) {
            $sql = "SELECT * FROM admins  WHERE useremail = :form_email";
            //! user rol 2 ise registerunits tablosundan sorgula
        } else if ($rol == 2) {
            $sql = "SELECT * FROM registerunits  WHERE useremail = :form_email";
            //! user rol 3 ise teacher tablosundan sorgula
        } else if ($rol == 3) {
            $sql = "SELECT * FROM teachers  WHERE useremail = :form_email";
        } else if ($rol == 4) {
            $sql = "SELECT * FROM students  WHERE useremail = :form_email";

        }

        $SORGU = $DB->prepare($sql);

        $SORGU->bindParam(':form_email', $useremail);

        $SORGU->execute();

        $CEVAP = $SORGU->fetchAll(PDO::FETCH_ASSOC);
        /* var_dump($CEVAP);
        echo "Gelen cevap " .  count($CEVAP) . " adet satırdan oluşuyor";
        die(); */
        //! Gelen sonuç 1 satırsa db de kullanıcı var olduğunu anlarız
        if (count($CEVAP) == 1) {
            //! Kullanıcının şifresini doğrulama
            //? posttan gelen ile db den gelen karşılaştırma
            //? password_verify() fonksiyonu ile
            if (password_verify($userpassword, $CEVAP[0]['userpassword'])) {
                //return true;
                @session_start();
                $_SESSION['isLogin'] = 1; // Kullanıcı giriş yapmışsa 1 yap
                $_SESSION['userName'] = $CEVAP[0]['username']; // Kullanıcının adını al
                $_SESSION['id'] = $CEVAP[0]['userid']; // Kullanıcının ID'sini al
                $_SESSION['role'] = $CEVAP[0]['roleuser']; // Kullanıcının ROL'ünü al
                header("location: index.php");
                die();
            } else {
                //return false;
                //!Şifreler Eşleşmiyorsa
                $errors[] = "INCORRECT EMAIL OR PASSWORD MATCH!...";

            }
        } else {
            //! Kullanıcı yoksa
            $errors[] = "INCORRECT EMAIL OR PASSWORD!...";
        }
    }

}
?>
    <div class="container">
  <div class="row justify-content-center mt-3">
  <div class="col-6">

<form method="POST">
<h1 class="alert alert-info text-center">Login Page</h1>
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
?>
  <div class="form-floating mb-3">
  <input type="email" name="form_email" value="<?php echo $_POST['form_email'] ?>" class="form-control">
  <label>Email</label>
</div>
<div class="input-group mb-3  input-group-lg">
  <input type="password"  name="form_password" class="form-control" id="password" placeholder="Password">
  <span class="input-group-text bg-transparent"><i id="togglePassword" class="bi bi-eye-slash"></i></span>
</div>
<div class="form-floating mb-3">
  <select class="form-select" id="floatingSelect" name="form_selectrol"  required aria-label="Floating label select example" >
    <option selected disabled>Select Login Type</option>
    <option value="1">Admin</option>
    <option value="2">Register Unit</option>
    <option value="3">Teacher</option>
    <option value="4">Student</option>
  </select>
  <label for="floatingSelect">Login Type</label>
</div>

                  <button type="submit" name="submit" class="btn btn-primary">Login</button>
     </form>
     </div>
</div>
<div class="row justify-content-end ">
  <div class="col-6 ">
  <h3 class="text-center text-info">User İnformation</h3>
<table class="table  table-striped">
  <thead>
    <tr>
    <th scope="col">#</th>
      <th scope="col">Email</th>
      <th scope="col">Password</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">1</th>
      <td>admin@gmail.com</td>
      <td>admin</td>
    </tr>
    <tr>
      <th scope="row">2</th>
      <td>kaan_fb_aslan@hotmail.com</td>
      <td>123</td>
    </tr>
  </tbody>
</table>
</div>
</div>
</div>
<?php require 'down.html.php';?>