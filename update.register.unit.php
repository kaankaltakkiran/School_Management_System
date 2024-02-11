<?php
session_start();
$activeTitle = "Register Unit Update";
$activePage = "index";
require 'up.html.php';
require 'login.control.php';
?>
  <?php
if ($_SESSION['role'] != 1) {
    header("location: authorizationcontrol.php");
    die();
}
?>
    <?php include 'navbar.php';?>
  <div class="container">
  <div class="row justify-content-center mt-3">
  <div class="col-6">

<form method="POST"enctype="multipart/form-data">
<h1 class="alert alert-info text-center">Register Unit User Update</h1>
<?php
require_once 'db.php';

$id = $_GET['idRegisterUnit'];

$sql = "SELECT * FROM registerunits WHERE userid = :idRegisterUnit";
$SORGU = $DB->prepare($sql);

$SORGU->bindParam(':idRegisterUnit', $id);

$SORGU->execute();

$registerunits = $SORGU->fetchAll(PDO::FETCH_ASSOC);
$selectGender = $registerunits[0]['usergender'];
/* echo "<pre>";
print_r($registerunits);
die(); */

if (isset($_POST['form_submit'])) {
    //!htmlspecialchars() kullanıcıdan alınan veriyi güvenli hale getirir
    //! eğer kullanıcı zararlı bir kod gönderirse bunu html etiketlerine dönüştürür
    //?Form elemanları
    $name = htmlspecialchars($_POST['form_username']);
    $email = htmlspecialchars($_POST['form_email']);
    $gender = htmlspecialchars($_POST['form_gender']);
    $address = htmlspecialchars($_POST['form_adress']);
    $phoneNumber = htmlspecialchars($_POST['form_phonenumber']);
    $birthDate = $_POST['form_birthdate'];
    //!İmage elemanları
    $img_name = $_FILES['form_image']['name'];
    $img_size = $_FILES['form_image']['size'];
    $tmp_name = $_FILES['form_image']['tmp_name'];
    $error = $_FILES['form_image']['error'];

    // Hata kontrolü
    $errors = array();
    //!Eski fotoğraf adını al
    $old_img_name = $registerunits[0]['userimg'];

    if ($error === 0) {
        //!Resim boyutlarını gözden geçir
        if ($img_size < 0) {
            $errors[] = "Sorry, your file is too large.";
        } else {
            $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
            $img_ex_lc = strtolower($img_ex);
            //! Resim türü kontrolü
            $allowed_exs = array("jpg", "jpeg", "png");

            if (in_array($img_ex_lc, $allowed_exs)) {
                $new_img_name = uniqid("IMG-", true) . '.' . $img_ex_lc;
                $img_upload_path = 'register_unit_images/' . $new_img_name;
                move_uploaded_file($tmp_name, $img_upload_path);
                //? Eğer yeni fotoğraf yüklendiyse eski fotoğrafı sil
                //?unlink dosya silmek için kullanılır
                unlink('register_unit_images/' . $old_img_name);
                //!Foto güncellediyse veritabanına yeni fotoğraf adını kaydet
                $sql = "UPDATE registerunits SET username = :form_username, useremail	 = :form_email, usergender=:form_gender,useraddress=:form_adress,phonenumber=:form_phonenumber,birthdate=:form_birthdate,userimg = '$new_img_name' WHERE userid = :idRegisterUnit";

            } else {
                $errors[] = "You can't upload files of this type";
            }
        }
    } else {
        //!Foto güncellemediysen eski fotoğrafı kullan
        $sql = "UPDATE registerunits SET username = :form_username, useremail	 = :form_email, usergender=:form_gender,useraddress=:form_adress,phonenumber=:form_phonenumber,birthdate=:form_birthdate WHERE userid = :idRegisterUnit";
    }
    //! Hata yoksa veritabanına kaydet
    if (empty($errors)) {
        //! Kullanıcı e-posta adresini değiştirdiyse, yeni e-posta adresi için veritabanında mevcut bir kullanıcı olup olmadığını kontrol et
        //? Eğer post edilen email update yapılan kişinin dışında bir kullanıcıda varsa hata mesajı göster
        $checkEmailQuery = $DB->prepare("SELECT * FROM registerunits WHERE useremail = :email AND userid != :idRegisterUnit");
        $checkEmailQuery->bindParam(':email', $email);
        $checkEmailQuery->bindParam(':idRegisterUnit', $id);
        $checkEmailQuery->execute();
        $existingUser = $checkEmailQuery->fetch(PDO::FETCH_ASSOC);
        if ($existingUser) {
            $errors[] = "This email is already in use.";
        } else {
            $SORGU = $DB->prepare($sql);
            $SORGU->bindParam(':form_username', $name);
            $SORGU->bindParam(':form_email', $email);
            $SORGU->bindParam(':form_gender', $gender);
            $SORGU->bindParam(':form_adress', $address);
            $SORGU->bindParam(':form_phonenumber', $phoneNumber);
            $SORGU->bindParam(':form_birthdate', $birthDate);

            $SORGU->bindParam(':idRegisterUnit', $id);
            $SORGU->execute();
            echo '<script>';
            echo 'alert("Register Unit User Update Successful!");';
            echo 'window.location.href = "update.register.unit.php?idRegisterUnit=' . $registerunits[0]['userid'] . '";';
            echo '</script>';
        }
    }

}

?>
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
  <input type="text"  class="form-control" value="<?php echo $_SESSION['userName'] ?>"disabled readonly>
  <label>Added By Admin Name</label>
</div>
<div class="form-floating mb-3">
  <input type="text"  class="form-control" value="<?php echo $registerunits[0]['username'] ?>" name="form_username">
  <label>User Name</label>
</div>
  <div class="form-floating mb-3">
  <input type="email" name="form_email" value="<?php echo $registerunits[0]['useremail'] ?>" class="form-control">
  <label>Email</label>
</div>
<div class="form-floating mb-3">
  <textarea class="form-control text-break"  style="height: 100px" placeholder="Adress" id="floatingTextarea"name="form_adress"><?php echo $registerunits[0]['useraddress'] ?>
</textarea>
  <label for="floatingTextarea">Address</label>
</div>
<div class="form-floating mb-3">
  <input type="tel"  class="form-control" value="<?php echo $registerunits[0]['phonenumber'] ?>" maxlength="11" name="form_phonenumber" >
  <label>Phone Number</label>
</div>
<div class="form-floating mb-3">
<div class="mb-3">
  <label for="exampleFormControlInput1" class="form-label">Birthdate</label>
  <input type="date" name="form_birthdate" value="<?php echo $registerunits[0]['birthdate'] ?>" class="form-control" id="exampleFormControlInput1" />
</div>
</div>
<span class="text-danger fw-bold">Selected Gender</span>
<div class="form-check">
  <input class="form-check-input" type="radio" <?php echo ($selectGender == 'M') ? 'checked' : ''; ?> name="form_gender" value="M"  >
  <label class="form-check-label" >
  Male
  </label>
</div>
<div class="form-check mb-3">
  <input class="form-check-input" type="radio" <?php echo ($selectGender == 'F') ? 'checked' : ''; ?> name="form_gender" value="F" >
  <label class="form-check-label" >
  Female
  </label>
</div>

<label>Register Unit Image</label>
                        <img src="register_unit_images/<?php echo $registerunits[0]['userimg']; ?>" alt="User Image" class="img-thumbnail">
<div class="input-group mb-3">
  <input type="file"  name='form_image' class="form-control" id="inputGroupFile02">
  <label class="input-group-text" for="inputGroupFile02">Upload Register Unit Image &nbsp; <i class="bi bi-upload"></i></label>
</div>

                  <button type="submit" name="form_submit" class="btn btn-primary mt-3 ">Add Register Unit User
                  <i class="bi bi-send"></i>
                  </button>
     </form>
     </div>

</div>

</div>
<?php require 'down.html.php';?>