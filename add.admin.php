<?php
@session_start();
$activeTitle = "Add Admin";
$activePage = "add.admin";
require 'up.html.php';
require 'login.control.php';
?>
  <?php
if ($_SESSION['role'] != 1) {
    header("location: authorizationcontrol.php");
    die();
}
?>
<?php
if (isset($_POST['submit_form'])) {
    //!Hata mesajlarını göstermek için boş bir dizi
    $errors = array();
    require_once 'db.php';
    //!htmlspecialchars() kullanıcıdan alınan veriyi güvenli hale getirir
    //! eğer kullanıcı zararlı bir kod gönderirse bunu html etiketlerine dönüştürür
    $name = htmlspecialchars($_POST['form_username']);
    $email = htmlspecialchars($_POST['form_email']);
    $gender = $_POST['form_gender'];
    $password = $_POST['form_password'];
    $addedAdminid = $_SESSION['id'];
    $addedAdminName = $_SESSION['userName'];
    $rePassword = $_POST['form_repassword'];
    /*  Şifrele hashleme */
    $password = password_hash($password, PASSWORD_DEFAULT);

    //!Resim yükleme
    $img_name = $_FILES['form_image']['name'];
    $img_size = $_FILES['form_image']['size'];
    $tmp_name = $_FILES['form_image']['tmp_name'];
    $error = $_FILES['form_image']['error'];

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
        $errors[] = "This email is already registered !";

        //!Eğer kullanıcı yoksa kaydet
        //?Şifre kontrolü
    } else if ($_POST['form_password'] != $_POST['form_repassword']) {
        $errors[] = "Passwords Don't Match!";
    } else if ($error === 0) {
        //!Resim boyutu kontrolü gözden geçmeli
        if ($img_size < 0) {
            $errors[] = "Sorry, your file is too large.";
        } else {
            $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
            $img_ex_lc = strtolower($img_ex);
            //! Resim türü kontrolü
            $allowed_exs = array("jpg", "jpeg", "png");

            if (in_array($img_ex_lc, $allowed_exs)) {
                $new_img_name = uniqid("IMG-", true) . '.' . $img_ex_lc;
                $img_upload_path = 'admin_images/' . $new_img_name;
                move_uploaded_file($tmp_name, $img_upload_path);

                // Insert into Database
                $sql = "INSERT INTO admins (username,useremail,usergender,userpassword,userimg,adedadminid,adedadminname) VALUES (:form_username,:form_email,:form_gender,'$password','$new_img_name',:adedid,:adedname)";
                $SORGU = $DB->prepare($sql);

                $SORGU->bindParam(':form_username', $name);
                $SORGU->bindParam(':form_email', $email);
                $SORGU->bindParam(':form_gender', $gender);
                $SORGU->bindParam(':adedid', $addedAdminid);
                $SORGU->bindParam(':adedname', $addedAdminName);
                $SORGU->execute();
                $approves[] = "Admin Added Successfully...";
            } else {
                $errors[] = "You can't upload files of this type !";
            }
        }
    } else {
        /*     $errors[] = "unknown error occurred!"; */
        $errors[] = "Image Not Selected !";
    }

}
?>
    <?php include 'navbar.php';?>
  <div class="container">
  <div class="row justify-content-center mt-3">
  <div class="col-6">
<form method="POST" class="needs-validation" enctype="multipart/form-data" novalidate>
<h1 class="alert alert-info text-center">Add Admin User Form</h1>
<?php
//! Hata mesajlarını göster
if (!empty($errors)) {
    foreach ($errors as $error) {
        echo "<div class='position-fixed top-0 end-0 p-3' style='z-index: 5'>
      <div class='toast align-items-center text-white bg-danger border-0' role='alert' aria-live='assertive' aria-atomic='true' data-bs-delay='5000'>
          <div class='d-flex'>
              <div class='toast-body'>
              $error
              </div>
              <button type='button' class='btn-close btn-close-white me-2 m-auto' data-bs-dismiss='toast' aria-label='Close'></button>
          </div>
      </div>
  </div>";
    }
}
?>
<?php
//! Başarılı mesajlarını göster
if (!empty($approves)) {
    foreach ($approves as $approve) {
        echo "<div class='position-fixed top-0 end-0 p-3' style='z-index: 5'>
      <div class='toast align-items-center text-white bg-success border-0' role='alert' aria-live='assertive' aria-atomic='true' data-bs-delay='5000'>
          <div class='d-flex'>
              <div class='toast-body'>
              $approve
              </div>
              <button type='button' class='btn-close btn-close-white me-2 m-auto' data-bs-dismiss='toast' aria-label='Close'></button>
          </div>
      </div>
  </div>";
    }
}
?>
<div class="form-floating mb-3">
  <input type="text"  class="form-control" value="<?php echo $_SESSION['userName'] ?>"disabled readonly>
  <label>Added By Admin Name</label>
</div>
<div class="form-floating mb-3">
  <input type="text"  class="form-control" id="floatingInput" placeholder="User Name" name="form_username" required>
  <label for="floatingInput">User Name</label>
  <div class="invalid-feedback fw-bold">
      Please Write Your Name !
    </div>
</div>
  <div class="form-floating mb-3">
  <input type="email" name="form_email"class="form-control" id="floatingInput" placeholder="Email"required>
  <label for="floatingInput">Email</label>
  <div class="invalid-feedback fw-bold">
      Please Write Your Email !
    </div>
</div>
<div class="input-group mb-3  input-group-lg">
  <input type="password"  name="form_password" class="form-control" id="oldPassword" placeholder="Password"required>
  <span class="input-group-text bg-transparent"><i id="toggleOldPassword" class="bi bi-eye-slash"></i></span>
  <div class="invalid-feedback fw-bold">
      Please Write Your Password !
    </div>
</div>
<div class="input-group mb-3  input-group-lg">
  <input type="password"  name="form_repassword" class="form-control" id="oldRePassword" placeholder="Please Enter Your Password Again"required>
  <span class="input-group-text bg-transparent"><i id="toggleOldRePassword" class="bi bi-eye-slash"></i></span>
  <div class="invalid-feedback fw-bold">
      Please Write Your Password Again !
    </div>
</div>
<div class="form-floating mb-3">
  <select class="form-select" id="floatingSelect" name="form_gender"  required aria-label="Floating label select example" >
    <option selected disabled>Select Gender</option>
    <option value="M">Male</option>
    <option value="F">Female</option>
  </select>
  <label for="floatingSelect">Gender</label>
  <div class="invalid-feedback fw-bold">
      Please Select Your Gender !
    </div>
</div>
<div class="input-group mb-3">
  <input type="file"  name='form_image' class="form-control" id="inputGroupFile02"required>
  <label class="input-group-text" for="inputGroupFile02">Upload Admin Image&nbsp; <i class="bi bi-upload"></i></label>
  <div class="invalid-feedback fw-bold">
      Please Upload Your Image !
    </div>
</div>
                  <button type="submit" name="submit_form" class="btn btn-primary mb-3">
                    Add Admin User
                    <i class="bi bi-send"></i>
                  </button>
     </form>
     </div>
</div>
</div>
<?php require 'footer.php';?>
<?php require 'down.html.php';?>