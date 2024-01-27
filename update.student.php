<?php
session_start();
$activeTitle = "Student User Update";
$activePage = "index";
require 'up.html.php';
?>
    <?php include 'navbar.php';?>
  <div class="container">
  <div class="row justify-content-center mt-3">
  <div class="col-6">

<form method="POST"enctype="multipart/form-data">
<h1 class="alert alert-info text-center">Student User Update</h1>
<?php
require_once 'db.php';

$id = $_GET['idStudent'];

$sql = "SELECT * FROM students where userid = :idStudent";
$SORGU = $DB->prepare($sql);

$SORGU->bindParam(':idStudent', $id);

$SORGU->execute();

$students = $SORGU->fetchAll(PDO::FETCH_ASSOC);
/* var_dump($students);
die(); */
//! Student gender çekme
$selectGender = $students[0]['usergender'];
//! Student sınıfı çekme
$selectClasses = $students[0]['classid'];
//!Virgülle ayrılmış classid'leri diziye çevir
$selectClassesArray = explode(",", $selectClasses);
/* echo "<pre>";
print_r($students);
die(); */
if (isset($_POST['form_submit'])) {

    //!Form elemanları
    $name = $_POST['form_username'];
    $email = $_POST['form_email'];
    $gender = $_POST['form_gender'];
    $address = $_POST['form_adress'];
    $phoneNumber = $_POST['form_phonenumber'];
    $birthDate = $_POST['form_birthdate'];
    $parentName = $_POST['form_parentname'];
    $parentNumber = $_POST['form_parentnumber'];
    //!Chatgpt çözümü

    $classIds = array(); // Classid'leri tutacak dizi
    $classNames = array(); // Classname'leri tutacak dizi

    foreach ($_POST['class'] as $selectedClass) {
        $selectedValues = explode('-', $selectedClass);
        $classIds[] = $selectedValues[0];
        $classNames[] = $selectedValues[1];
    }
    // Virgülle ayrılmış bir şekilde lessonid ve lessonname'leri oluştur
    $studentClassid = implode(',', $classIds);
    $studentClassName = implode(',', $classNames);

    //!İmage elemanları
    $img_name = $_FILES['form_image']['name'];
    $img_size = $_FILES['form_image']['size'];
    $tmp_name = $_FILES['form_image']['tmp_name'];
    $error = $_FILES['form_image']['error'];

    // Hata kontrolü
    $errors = array();
    //!Eski fotoğraf adını al
    $old_img_name = $students[0]['userimg'];

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
                $img_upload_path = 'student_images/' . $new_img_name;
                move_uploaded_file($tmp_name, $img_upload_path);
                //? Eğer yeni fotoğraf yüklendiyse eski fotoğrafı sil
                //?unlink dosya silmek için kullanılır
                unlink('teacher_images/' . $old_img_name);
                //!Foto güncellediyse veritabanına yeni fotoğraf adını kaydet
                $sql = "UPDATE students SET username = :form_username, useremail	 = :form_email, usergender=:form_gender,useraddress=:form_adress,phonenumber=:form_phonenumber,birthdate=:form_birthdate,userimg = '$new_img_name',parentname=:form_parentname,parentnumber=:form_parentnumber,classid=:classid,classname=:classname WHERE userid = :idStudent";

            } else {
                $errors[] = "You can't upload files of this type";
            }
        }
    } else {
        //!Foto güncellemediysen eski fotoğrafı kullan
        $sql = "UPDATE students SET username = :form_username, useremail	 = :form_email, usergender=:form_gender,useraddress=:form_adress,phonenumber=:form_phonenumber,birthdate=:form_birthdate,parentname=:form_parentname,parentnumber=:form_parentnumber,classid=:classid,classname=:classname WHERE userid = :idStudent";
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
        $SORGU->bindParam(':form_parentname', $parentName);
        $SORGU->bindParam(':form_parentnumber', $parentNumber);
        $SORGU->bindParam(':classid', $studentClassid);
        $SORGU->bindParam(':classname', $studentClassName);

        $SORGU->bindParam(':idStudent', $id);
        $SORGU->execute();
        echo '<script>';
        echo 'alert("Student User Update Successful!");';
        echo 'window.location.href = "update.student.php?idStudent=' . $students[0]['userid'] . '";';
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
  <label>Added By Register Unit Name</label>
</div>
<div class="form-floating mb-3">
  <input type="text"  class="form-control" value="<?php echo $students[0]['username'] ?>" name="form_username">
  <label>User Name</label>
</div>
  <div class="form-floating mb-3">
  <input type="email" name="form_email" value="<?php echo $students[0]['useremail'] ?>" class="form-control">
  <label>Email</label>
</div>
<div class="form-floating mb-3">
  <textarea class="form-control text-break"  style="height: 100px" placeholder="Adress" id="floatingTextarea"name="form_adress"><?php echo $students[0]['useraddress'] ?>
</textarea>
  <label for="floatingTextarea">Address</label>
</div>
<div class="form-floating mb-3">
  <input type="tel"  class="form-control" value="<?php echo $students[0]['phonenumber'] ?>" maxlength="11" name="form_phonenumber" >
  <label>Phone Number</label>
</div>
<div class="form-floating mb-3">
<div class="mb-3">
  <label for="exampleFormControlInput1" class="form-label">Birthdate</label>
  <input type="date" name="form_birthdate" value="<?php echo $students[0]['birthdate'] ?>" class="form-control" id="exampleFormControlInput1" />
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
//!Chatgpt ile tek sınıf seçebilme sınıflandırma
//!onmouseout event sayesinde sadece bir checkbox seçilebilir
$SORGU = $DB->prepare("SELECT * FROM classes");
$SORGU->execute();
$classes = $SORGU->fetchAll(PDO::FETCH_ASSOC);

// Seçili sınıfları al

echo '<label class="mb-1">Select Classes</label>';

// Seçili checkbox sayısını say
$selectedCount = count($selectClassesArray);

foreach ($classes as $class) {
    $classId = $class['classid'];
    $isChecked = in_array($classId, $selectClassesArray);
    $classValue = $class['classid'] . '-' . $class['classname'];

    echo '<div class="col-md-3">';
    echo '<div class="form-check form-check-inline">';

    // JavaScript kullanarak checkbox kontrolü
    echo '<input class="form-check-input" type="checkbox" name="class[]" value="' . $classValue . '" id="check-' . $classId . '" onmouseout="checkCheckboxLimit(this)" ' . ($isChecked ? 'checked' : '') . '>';

    echo '<label class="form-check-label" for="check-' . $classId . '">' . $class['classname'] . '</label>';
    echo '</div>';
    echo '</div>';
}

// JavaScript fonksiyonu
echo '<script>
    function checkCheckboxLimit(checkbox) {
        var checkboxes = document.querySelectorAll(\'input[name="class[]"]\');
        var checkedCount = 0;
        for (var i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i].checked) {
                checkedCount++;
            }
        }
        if (checkedCount === 1) {
            for (var i = 0; i < checkboxes.length; i++) {
                if (!checkboxes[i].checked) {
                    checkboxes[i].disabled = true;
                }
            }
        } else {
            for (var i = 0; i < checkboxes.length; i++) {
                checkboxes[i].disabled = false;
            }
        }
        document.getElementById("checkbox-message").innerHTML = (checkedCount === 1) ? "Class Selected" : "";
    }
</script>';

// Mesajı göster
echo '<span id="checkbox-message" class="text-danger mt-3 fw-bold ">' . (($selectedCount === 1) ? "One class can be selected" : "") . '</span>';
?>


</div>
</div>
<div class="form-floating mb-3">
  <input type="text"  class="form-control" value="<?php echo $students[0]['parentname'] ?>" name="form_parentname" >
  <label>Parent Name</label>
</div>
<div class="form-floating mb-3">
  <input type="tel"  class="form-control" value="<?php echo $students[0]['phonenumber'] ?>" maxlength="11" name="form_parentnumber" >
  <label>Parent Phone Number</label>
</div>
<label>Student User Image</label>
                        <img src="student_images/<?php echo $students[0]['userimg']; ?>" alt="User Image" class="img-thumbnail">
<div class="input-group mb-3">
  <input type="file"  name='form_image' class="form-control" id="inputGroupFile02">
  <label class="input-group-text" for="inputGroupFile02">Upload Student User Image</label>
</div>

                  <button type="submit" name="form_submit" class="btn btn-primary mt-3 ">Update Student User</button>
     </form>
     </div>

</div>

</div>
<?php require 'down.html.php';?>