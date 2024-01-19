<?php
session_start();
$activeTitle = "Admin Update";
$activePage = "index";
require 'up.html.php';
?>
    <?php include 'navbar.php';?>
  <div class="container">
  <div class="row justify-content-center mt-3">
  <div class="col-6">

<form method="POST"enctype="multipart/form-data">
<h1 class="alert alert-info text-center">Admin User Update</h1>
<?php
require_once 'db.php';

$id = $_GET['idAdmin'];

$sql = "SELECT * FROM admins WHERE userid = :idAdmin";
$SORGU = $DB->prepare($sql);

$SORGU->bindParam(':idAdmin', $id);

$SORGU->execute();

$admins = $SORGU->fetchAll(PDO::FETCH_ASSOC);
$selectGender = $admins[0]['usergender'];
/* echo "<pre>";
print_r($admins);
die(); */

if (isset($_POST['form_submit'])) {

    //!Form elemanları
    $name = $_POST['form_username'];
    $email = $_POST['form_email'];
    $gender = $_POST['form_gender'];
    //!İmage elemanları
    $img_name = $_FILES['form_image']['name'];
    $img_size = $_FILES['form_image']['size'];
    $tmp_name = $_FILES['form_image']['tmp_name'];
    $error = $_FILES['form_image']['error'];

    // Hata kontrolü
    $errors = array();
    //!Eski fotoğraf adını al
    $old_img_name = $admins[0]['userimg'];

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
                $img_upload_path = 'admin_images/' . $new_img_name;
                move_uploaded_file($tmp_name, $img_upload_path);
                //? Eğer yeni fotoğraf yüklendiyse eski fotoğrafı sil
                //?unlink dosya silmek için kullanılır
                unlink('admin_images/' . $old_img_name);
                //!Foto güncellediyse veritabanına yeni fotoğraf adını kaydet
                $sql = "UPDATE admins SET username = :form_username, useremail	 = :form_email, usergender=:form_gender,userimg = '$new_img_name' WHERE userid = :idAdmin";
            } else {
                $errors[] = "You can't upload files of this type";
            }
        }
    } else {
        //!Foto güncellemediysen eski fotoğrafı kullan
        $sql = "UPDATE admins SET username = :form_username, useremail	 = :form_email, usergender=:form_gender WHERE userid = :idAdmin";
    }
    //! Hata yoksa veritabanına kaydet
    if (empty($errors)) {
        $SORGU = $DB->prepare($sql);

        $SORGU->bindParam(':form_username', $name);
        $SORGU->bindParam(':form_email', $email);
        $SORGU->bindParam(':form_gender', $gender);

        $SORGU->bindParam(':idAdmin', $id);
        $SORGU->execute();
        echo '<script>';
        echo 'alert("Admin User Update Successful!");';
        echo 'window.location.href = "update.admin.php?idAdmin=' . $admins[0]['userid'] . '";';
        echo '</script>';
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
  <input type="text"  class="form-control" value="<?php echo $admins[0]['username'] ?>" name="form_username" >
  <label>User Name</label>
</div>
  <div class="form-floating mb-3">
  <input type="email" name="form_email"  value="<?php echo $admins[0]['useremail'] ?>" class="form-control">
  <label>Email</label>
</div>
<div class="form-check">
  <input class="form-check-input" <?php echo ($selectGender == 'M') ? 'checked' : ''; ?> type="radio" name="form_gender" value="M"  >
  <label class="form-check-label" >
  Male
  </label>
</div>
<div class="form-check mb-3">
  <input class="form-check-input" <?php echo ($selectGender == 'F') ? 'checked' : ''; ?> type="radio" name="form_gender" value="F">
  <label class="form-check-label" >
  Female
  </label>
</div>
<label>Admin Image</label>
                        <img src="admin_images/<?php echo $admins[0]['userimg']; ?>" alt="User Image" class="img-thumbnail">
<div class="input-group mb-3">
  <input type="file"  name='form_image'  class="form-control" id="inputGroupFile02">
  <label class="input-group-text" for="inputGroupFile02">Upload Blog Image</label>
</div>
                  <button type="submit" name="form_submit" class="btn btn-primary mb-3">Update Admin User</button>
     </form>
     </div>

</div>

</div>
<?php require 'down.html.php';?>