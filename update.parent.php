<?php
@session_start();
$activeTitle = "Parent Update";
$activePage = "update.parent";
require 'up.html.php';
require 'login.control.php';
?>
  <?php
require_once 'db.php';
//! Parent id
$id = $_GET['parentid'];
$sql = "SELECT * FROM parents WHERE userid = :parentid";
$SORGU = $DB->prepare($sql);
$SORGU->bindParam(':parentid', $id);
$SORGU->execute();
$parents = $SORGU->fetchAll(PDO::FETCH_ASSOC);
$selectGender = $parents[0]['usergender'];
/* echo "<pre>";
print_r($parents);
die(); */
//! Rol idsi 2 olan register unit sadece kendi eklediği student userları güncelleyebilir
if ($_SESSION['role'] != 2) {
    header("location: authorizationcontrol.php");
    die();
}
if ($parents[0]['addedunitid'] != $_SESSION['id']) {
    header("location: authorizationcontrol.php");
    die();
}
?>
    <?php include 'navbar.php';?>
  <div class="container">
  <div class="row justify-content-center mt-3">
  <div class="col-6">
<form method="POST"enctype="multipart/form-data">
<h1 class="alert alert-info text-center">Parent's User Update</h1>
<?php
if (isset($_POST['form_submit'])) {
    //!htmlspecialchars() kullanıcıdan alınan veriyi güvenli hale getirir
    //! eğer kullanıcı zararlı bir kod gönderirse bunu html etiketlerine dönüştürür

    //!Form elemanları
    $name = htmlspecialchars($_POST['form_username']);
    $email = htmlspecialchars($_POST['form_email']);
    $adress = htmlspecialchars($_POST['form_adress']);
    $phonenumber = htmlspecialchars($_POST['form_phonenumber']);
    $birthdate = $_POST['form_birthdate'];
    $gender = $_POST['form_gender'];
    //!İmage elemanları
    $img_name = $_FILES['form_image']['name'];
    $img_size = $_FILES['form_image']['size'];
    $tmp_name = $_FILES['form_image']['tmp_name'];
    $error = $_FILES['form_image']['error'];

    //!Hata kontrolü
    $errors = array();
    //!Onay mesajları
    $approves = array();
    //!Eski fotoğraf adını al
    $old_img_name = $parents[0]['userimg'];

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
                $img_upload_path = 'parent_images/' . $new_img_name;
                move_uploaded_file($tmp_name, $img_upload_path);
                //? Eğer yeni fotoğraf yüklendiyse eski fotoğrafı sil
                //?unlink dosya silmek için kullanılır
                unlink('parent_images/' . $old_img_name);
                //!Foto güncellediyse veritabanına yeni fotoğraf adını kaydet
                $sql = "UPDATE parents SET username = :form_username, useremail	 = :form_email, usergender=:form_gender,useraddress=:form_adress,phonenumber=:form_phonenumber,birthdate=:form_birthdate, userimg = '$new_img_name',lastupdate = CURRENT_TIMESTAMP() WHERE userid = :parentid";
            } else {
                $errors[] = "You can't upload files of this type !";
            }
        }
    } else {
        //!Foto güncellemediysen eski fotoğrafı kullan
        $sql = "UPDATE parents SET username = :form_username, useremail	 = :form_email, usergender=:form_gender,useraddress=:form_adress,phonenumber=:form_phonenumber,birthdate=:form_birthdate,lastupdate = CURRENT_TIMESTAMP() WHERE userid = :parentid";
    }
    //! Hata yoksa veritabanına kaydet
    if (empty($errors)) {
        //! Kullanıcı e-posta adresini değiştirdiyse, yeni e-posta adresi için veritabanında mevcut bir kullanıcı olup olmadığını kontrol et
        //? Eğer post edilen email update yapılan kişinin dışında bir kullanıcıda varsa hata mesajı göster
        $checkEmailQuery = $DB->prepare("SELECT * FROM parents WHERE useremail = :email AND userid != :parentid");
        $checkEmailQuery->bindParam(':email', $email);
        $checkEmailQuery->bindParam(':parentid', $id);
        $checkEmailQuery->execute();
        $existingUser = $checkEmailQuery->fetch(PDO::FETCH_ASSOC);
        if ($existingUser) {
            $errors[] = "This email is already in use !";
        } else {
            $SORGU = $DB->prepare($sql);
            $SORGU->bindParam(':form_username', $name);
            $SORGU->bindParam(':form_email', $email);
            $SORGU->bindParam(':form_gender', $gender);
            $SORGU->bindParam(':form_adress', $adress);
            $SORGU->bindParam(':form_phonenumber', $phonenumber);
            $SORGU->bindParam(':form_birthdate', $birthdate);
            $SORGU->bindParam(':parentid', $id);
            $SORGU->execute();
            $approves[] = "Parent's Update  Successfully...";
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
        //!4 saniye sonra sayfayı yenilemek için yönlendirme
        echo "<meta http-equiv='refresh' content='3'>";

    }
}
?>
<div class="form-floating mb-3">
  <input type="text"  class="form-control" value="<?php echo $_SESSION['userName'] ?>"disabled readonly>
  <label>Update By Admin Name</label>
</div>
<div class="form-floating mb-3">
  <input type="text"  class="form-control" value="<?php echo $parents[0]['username'] ?>" name="form_username" >
  <label>User Name</label>
</div>
  <div class="form-floating mb-3">
  <input type="email" name="form_email"  value="<?php echo $parents[0]['useremail'] ?>" class="form-control">
  <label>Email</label>
</div>
<div class="form-floating mb-3">
  <textarea class="form-control text-break"  style="height: 100px" placeholder="Adress" id="floatingTextarea"name="form_adress"><?php echo $parents[0]['useraddress'] ?>
</textarea>
  <label for="floatingTextarea">Address</label>
</div>
<div class="form-floating mb-3">
  <input type="tel"  class="form-control" value="<?php echo $parents[0]['phonenumber'] ?>" maxlength="11" name="form_phonenumber" >
  <label>Phone Number</label>
</div>
<div class="form-floating mb-3">
<div class="mb-3">
  <label for="exampleFormControlInput1" class="form-label">Birthdate</label>
  <input type="date" name="form_birthdate" value="<?php echo $parents[0]['birthdate'] ?>" class="form-control" id="exampleFormControlInput1" />
</div>
<div class="form-floating mb-3">
<select class="form-select" name="form_gender">
<option selected disabled>Select Gender</option>
        <option value="M" <?php if ($selectGender === 'M') {
    echo 'selected';
}
?>>Male</option>
        <option value="F" <?php if ($selectGender === 'F') {
    echo 'selected';
}
?>>Female</option>
    </select>
</div>
<div class="row">
    <div class="col-6">
    <span>Current Image</span>
                    <img src="parent_images/<?php echo $parents[0]['userimg']; ?>" alt="User Image"  class="img-thumbnail m-3 ">
                    </div>
</div>
<div class="input-group mb-3">
  <input type="file"  name='form_image'  class="form-control" id="inputGroupFile02">
  <label class="input-group-text" for="inputGroupFile02">Upload Parent's Image &nbsp; <i class="bi bi-upload"></i></label>
</div>
                  <button type="submit" name="form_submit" class="btn btn-primary mb-3">Update Parent's User
                  <i class="bi bi-send"></i>
                  </button>
     </form>
     </div>
</div>
</div>
<?php require 'footer.php';?>
<?php require 'down.html.php';?>