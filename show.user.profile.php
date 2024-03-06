<?php
@session_start();
$activeTitle = "User Profile Page";
$activePage = "user.profile";
require 'up.html.php';
require 'login.control.php';
?>
<?php
if ($_SESSION['role'] != 3 && $_SESSION['role'] != 4) {
    header("location: authorizationcontrol.php");
    die();
}
?>
<?php
require_once 'db.php';
$userid = $_SESSION['id'];
$userrole = $_SESSION['role'];
//! user rol 1 ise admins tablosundan sorgula
if ($userrole == 1) {
    $sql = "SELECT * FROM admins  WHERE userid = :userid";
    //! user rol 2 ise registerunits tablosundan sorgula
} else if ($userrole == 2) {
    $sql = "SELECT * FROM registerunits  WHERE userid = :userid";
    //! user rol 3 ise teacher tablosundan sorgula
} else if ($userrole == 3) {
    $sql = "SELECT * FROM teachers  WHERE userid = :userid";
    //! user rol 4 ise students tablosundan sorgula
} else if ($userrole == 4) {
    $sql = "SELECT * FROM students  WHERE userid = :userid";

}
$SORGU = $DB->prepare($sql);
$SORGU->bindParam(':userid', $userid);
$SORGU->execute();
$users = $SORGU->fetchAll(PDO::FETCH_ASSOC);
/* echo '<pre>';
print_r($users);
die(); */
?>
<?php
if (isset($_POST['submit_form'])) {
    require_once 'db.php';
    //!htmlspecialchars() kullanıcıdan alınan veriyi güvenli hale getirir
    //! eğer kullanıcı zararlı bir kod gönderirse bunu html etiketlerine dönüştürür
    //?Form elemanları
    $name = htmlspecialchars($_POST['form_username']);
    $email = htmlspecialchars($_POST['form_email']);
    $address = htmlspecialchars($_POST['form_adress']);
    $phoneNumber = htmlspecialchars($_POST['form_phonenumber']);

    //!İmage elemanları
    $img_name = $_FILES['form_image']['name'];
    $img_size = $_FILES['form_image']['size'];
    $tmp_name = $_FILES['form_image']['tmp_name'];
    $error = $_FILES['form_image']['error'];

    // Hata kontrolü
    $errors = array();
    //!Eski fotoğraf adını al
    $old_img_name = $users[0]['userimg'];

    if ($error === 0) {
        //!Resim boyutlarını gözden geçir
        if ($img_size < 0) {
            $errors[] = "Sorry, your file is too large !";
        } else {
            $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
            $img_ex_lc = strtolower($img_ex);
            //! Resim türü kontrolü
            $allowed_exs = array("jpg", "jpeg", "png");

            if (in_array($img_ex_lc, $allowed_exs)) {
                $new_img_name = uniqid("IMG-", true) . '.' . $img_ex_lc;
                $img_upload_path = $_SESSION['imageFolderName'] . '/' . $new_img_name;
                move_uploaded_file($tmp_name, $img_upload_path);
                //? Eğer yeni fotoğraf yüklendiyse eski fotoğrafı sil
                //?unlink dosya silmek için kullanılır
                unlink($_SESSION['imageFolderName'] . '/' . $old_img_name);
                if ($userrole == 3) {
                    //!Foto güncellediyse veritabanına yeni fotoğraf adını kaydet
                    $sql = "UPDATE teachers SET username = :form_username, useremail	 = :form_email, useraddress=:form_adress,phonenumber=:form_phonenumber,userimg = '$new_img_name',lastupdate = CURRENT_TIMESTAMP() WHERE userid = :userid";
                } else if ($userrole == 4) {
                    //!Foto güncellediyse veritabanına yeni fotoğraf adını kaydet
                    $sql = "UPDATE students SET username = :form_username, useremail= :form_email,useraddress=:form_adress,phonenumber=:form_phonenumber,userimg = '$new_img_name',lastupdate = CURRENT_TIMESTAMP() WHERE userid = :userid";
                }

            } else {
                $errors[] = "You can't upload files of this type !";
            }
        }
    } else {
        if ($userrole == 3) {
            //!Foto güncellemediysen eski fotoğrafı kullan
            $sql = "UPDATE teachers SET username = :form_username, useremail	 = :form_email, useraddress=:form_adress,phonenumber=:form_phonenumber WHERE userid = :userid";
        } else if ($userrole == 4) {
            //!Foto güncellemediysen eski fotoğrafı kullan
            $sql = "UPDATE students SET username = :form_username, useremail	 = :form_email,useraddress=:form_adress,phonenumber=:form_phonenumber WHERE userid = :userid";
        }
    }
    //! Hata yoksa veritabanına kaydet
    if (empty($errors)) {
        //! Kullanıcı e-posta adresini değiştirdiyse, yeni e-posta adresi için veritabanında mevcut bir kullanıcı olup olmadığını kontrol et
        //? Eğer post edilen email update yapılan kişinin dışında bir kullanıcıda varsa hata mesajı göster
        if ($userrole == 3) {
            $checkEmailQuery = $DB->prepare("SELECT * FROM teachers WHERE useremail = :email AND userid != :userid");
        } else if ($userrole == 4) {
            $checkEmailQuery = $DB->prepare("SELECT * FROM students WHERE useremail = :email AND userid != :userid");
        }
        $checkEmailQuery->bindParam(':email', $email);
        $checkEmailQuery->bindParam(':userid', $userid);
        $checkEmailQuery->execute();
        $existingUser = $checkEmailQuery->fetch(PDO::FETCH_ASSOC);
        if ($existingUser) {
            $errors[] = "This email is already in use !";
        } else {
            if ($userrole == 3) {
                //!Eğer hata yoksa veritabanına kaydet
                $SORGU = $DB->prepare($sql);
                $SORGU->bindParam(':form_username', $name);
                $SORGU->bindParam(':form_email', $email);
                $SORGU->bindParam(':form_adress', $address);
                $SORGU->bindParam(':form_phonenumber', $phoneNumber);
                $SORGU->bindParam(':userid', $userid);
                $SORGU->execute();
                $approves[] = "User Updated Successfully...";
            } else if ($userrole == 4) {
                //!Eğer hata yoksa veritabanına kaydet
                $SORGU = $DB->prepare($sql);
                $SORGU->bindParam(':form_username', $name);
                $SORGU->bindParam(':form_email', $email);
                $SORGU->bindParam(':form_adress', $address);
                $SORGU->bindParam(':form_phonenumber', $phoneNumber);
                $SORGU->bindParam(':userid', $userid);
                $SORGU->execute();
                $approves[] = "User Updated Successfully...";

            }
        }
    }

}
?>
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
<?php require 'navbar.php'?>
<?php
require_once 'db.php';
$userid = $_SESSION['id'];
$userrole = $_SESSION['role'];
//! user rol 1 ise admins tablosundan sorgula
if ($userrole == 1) {
    $sql = "SELECT * FROM admins  WHERE userid = :userid";
    //! user rol 2 ise registerunits tablosundan sorgula
} else if ($userrole == 2) {
    $sql = "SELECT * FROM registerunits  WHERE userid = :userid";
    //! user rol 3 ise teacher tablosundan sorgula
} else if ($userrole == 3) {
    $sql = "SELECT * FROM teachers  WHERE userid = :userid";
    //! user rol 4 ise students tablosundan sorgula
} else if ($userrole == 4) {
    $sql = "SELECT * FROM students  WHERE userid = :userid";

}
$SORGU = $DB->prepare($sql);
$SORGU->bindParam(':userid', $userid);
$SORGU->execute();
$users = $SORGU->fetchAll(PDO::FETCH_ASSOC);
/* echo '<pre>';
print_r($users);
die(); */
?>
<div class="container">
  <div class="row justify-content-center ">
    <div class="col-10">
  <h1 class="alert alert-info text-center mt-3">User Profile</h1>
  </div>
  </div>
  <div class="row justify-content-center ">
<div class="col-4">
<form method="POST"enctype="multipart/form-data">
<img src='<?php echo $_SESSION['imageFolderName'] ?>/<?php echo $users[0]['userimg']; ?>' class=' rounded-circle' height="300" width='350'>
          </a>
          <div class="input-group mt-3">
  <input type="file"  name='form_image' class="form-control" id="inputGroupFile02">
  <label class="input-group-text" for="inputGroupFile02">Update Image &nbsp; <i class="bi bi-upload"></i></label>
</div>
</div>
<div class="col-6">
<div class="form-floating mb-3">
  <input type="text"  class="form-control" value="<?php echo $users[0]['username'] ?>" name="form_username">
  <label>User Name</label>
</div>
  <div class="form-floating mb-3">
  <input type="email" name="form_email" value="<?php echo $users[0]['useremail'] ?>" class="form-control">
  <label>Email</label>
</div>
<div class="form-floating mb-3">
  <textarea class="form-control text-break"  style="height: 100px" placeholder="Adress" id="floatingTextarea"name="form_adress"><?php echo $users[0]['useraddress'] ?>
</textarea>
  <label for="floatingTextarea">Address</label>
</div>
<div class="form-floating mb-3">
  <input type="tel"  class="form-control" value="<?php echo $users[0]['phonenumber'] ?>" maxlength="11" name="form_phonenumber" >
  <label>Phone Number</label>
</div>
<div class="row">
                  <button type="submit" name="submit_form" class="btn btn-primary m-3 ">Update User
                  <i class="bi bi-send"></i>
                  </button>
     </form>
</div>
  </div>
</div>
<?php require 'down.html.php';?>