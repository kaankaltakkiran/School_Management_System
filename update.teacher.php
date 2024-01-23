<?php
session_start();
$activeTitle = "Teacher User Update";
$activePage = "index";
require 'up.html.php';
?>
    <?php include 'navbar.php';?>
  <div class="container">
  <div class="row justify-content-center mt-3">
  <div class="col-6">

<form method="POST"enctype="multipart/form-data">
<h1 class="alert alert-info text-center">Teacher User Update</h1>
<?php
require_once 'db.php';

$id = $_GET['idTeacher'];
//! Teacherın seçtiği sınıfları çekme
//! joinle clases tablosundaki classid ile teachers tablosundaki classid'yi içeren classidleri eşleşenleri getir
$sql = "SELECT DISTINCT classes.*,teachers.*
FROM classes
JOIN teachers ON teachers.classid LIKE CONCAT('%', classes.classid, '%')
WHERE userid = :idTeacher";
$SORGU = $DB->prepare($sql);

$SORGU->bindParam(':idTeacher', $id);

$SORGU->execute();

$teachers = $SORGU->fetchAll(PDO::FETCH_ASSOC);
$selectGender = $teachers[0]['usergender'];
//! Teacherın seçtiği sınıfları çekme
$selectClasses = $teachers[0]['classid'];
//!Virgülle ayrılmış classid'leri diziye çevir
$selectClassesArray = explode(",", $selectClasses);
/* echo "<pre>";
print_r($teachers);
die(); */

if (isset($_POST['form_submit'])) {

    //!Form elemanları
    $name = $_POST['form_username'];
    $email = $_POST['form_email'];
    $gender = $_POST['form_gender'];
    $address = $_POST['form_adress'];
    $phoneNumber = $_POST['form_phonenumber'];
    $birthDate = $_POST['form_birthdate'];
    //?Sınıfları forech ile alma
    $selectClasses = $_POST['class'];
    $teacherClass = "";
    foreach ($selectClasses as $selectClass) {
        $teacherClass .= $selectClass . ",";
    }
    //!İmage elemanları
    $img_name = $_FILES['form_image']['name'];
    $img_size = $_FILES['form_image']['size'];
    $tmp_name = $_FILES['form_image']['tmp_name'];
    $error = $_FILES['form_image']['error'];

    // Hata kontrolü
    $errors = array();
    //!Eski fotoğraf adını al
    $old_img_name = $teachers[0]['userimg'];

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
                $img_upload_path = 'teacher_images/' . $new_img_name;
                move_uploaded_file($tmp_name, $img_upload_path);
                //? Eğer yeni fotoğraf yüklendiyse eski fotoğrafı sil
                //?unlink dosya silmek için kullanılır
                unlink('teacher_images/' . $old_img_name);
                //!Foto güncellediyse veritabanına yeni fotoğraf adını kaydet
                $sql = "UPDATE teachers SET username = :form_username, useremail	 = :form_email, usergender=:form_gender,useraddress=:form_adress,phonenumber=:form_phonenumber,birthdate=:form_birthdate,userimg = '$new_img_name',classid='$teacherClass' WHERE userid = :idTeacher";

            } else {
                $errors[] = "You can't upload files of this type";
            }
        }
    } else {
        //!Foto güncellemediysen eski fotoğrafı kullan
        $sql = "UPDATE teachers SET username = :form_username, useremail	 = :form_email, usergender=:form_gender,useraddress=:form_adress,phonenumber=:form_phonenumber,birthdate=:form_birthdate,classid='$teacherClass' WHERE userid = :idTeacher";
    }
    //! Hata yoksa veritabanına kaydet
    if (empty($errors)) {
        $SORGU = $DB->prepare($sql);
        $SORGU->bindParam(':form_username', $name);
        $SORGU->bindParam(':form_email', $email);
        $SORGU->bindParam(':form_gender', $gender);
        $SORGU->bindParam(':form_adress', $address);
        $SORGU->bindParam(':form_phonenumber', $phoneNumber);
        $SORGU->bindParam(':form_birthdate', $birthDate);

        $SORGU->bindParam(':idTeacher', $id);
        $SORGU->execute();
        echo '<script>';
        echo 'alert("Teacher User Update Successful!");';
        echo 'window.location.href = "update.teacher.php?idTeacher=' . $teachers[0]['userid'] . '";';
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
  <input type="text"  class="form-control" value="<?php echo $teachers[0]['username'] ?>" name="form_username">
  <label>User Name</label>
</div>
  <div class="form-floating mb-3">
  <input type="email" name="form_email" value="<?php echo $teachers[0]['useremail'] ?>" class="form-control">
  <label>Email</label>
</div>
<div class="form-floating mb-3">
  <textarea class="form-control text-break"  style="height: 100px" placeholder="Adress" id="floatingTextarea"name="form_adress"><?php echo $teachers[0]['useraddress'] ?>
</textarea>
  <label for="floatingTextarea">Address</label>
</div>
<div class="form-floating mb-3">
  <input type="tel"  class="form-control" value="<?php echo $teachers[0]['phonenumber'] ?>" maxlength="11" name="form_phonenumber" >
  <label>Phone Number</label>
</div>
<div class="form-floating mb-3">
<div class="mb-3">
  <label for="exampleFormControlInput1" class="form-label">Birthdate</label>
  <input type="date" name="form_birthdate" value="<?php echo $teachers[0]['birthdate'] ?>" class="form-control" id="exampleFormControlInput1" />
</div>
</div>
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
<div class="form-floating mb-3">
  <div class="row">
  <?php
$SORGU = $DB->prepare("SELECT * FROM classes");
$SORGU->execute();
$classes = $SORGU->fetchAll(PDO::FETCH_ASSOC);
/* echo '<pre>';
print_r($classes);
die(); */
//! chatgpt ile sınıfları listeleme
echo '<label class="mb-1">Select Classes</label>';
foreach ($classes as $class) {
    //! classes tablosunda yer alan classidler ile seçilen classidleri eşleşenler varsa checked yap
    $classId = $class['classid'];
    $isChecked = in_array($classId, $selectClassesArray); // Seçili olup olmadığını kontrol et

    echo '<div class="col-md-3">';
    echo '<div class="form-check form-check-inline">';
    echo '<input class="form-check-input" type="checkbox" name="class[]" value="' . $classId . '" id="check-' . $classId . '" ' . ($isChecked ? 'checked' : '') . '>';
    echo '<label class="form-check-label" for="check-' . $classId . '">' . $class['classname'] . '</label>';
    echo '</div>';
    echo '</div>';
}
?>
</div>
</div>

<label>Teacher User Image</label>
                        <img src="teacher_images/<?php echo $teachers[0]['userimg']; ?>" alt="User Image" class="img-thumbnail">
<div class="input-group mb-3">
  <input type="file"  name='form_image' class="form-control" id="inputGroupFile02">
  <label class="input-group-text" for="inputGroupFile02">Upload Teacher User Image</label>
</div>

                  <button type="submit" name="form_submit" class="btn btn-primary mt-3 ">Update Teacher User</button>
     </form>
     </div>

</div>

</div>
<?php require 'down.html.php';?>