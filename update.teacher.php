<?php
session_start();
$activeTitle = "Teacher User Update";
$activePage = "teacher.update";
require 'up.html.php';
require 'login.control.php';
?>
<?php
if ($_SESSION['role'] != 2) {
    header("location: authorizationcontrol.php");
    die();
}
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
$sql = "SELECT * FROM teachers WHERE userid = :idTeacher";
/* SELECT DISTINCT classes.*,teachers.*
FROM classes
JOIN teachers ON teachers.classid LIKE CONCAT('%', classes.classid, '%')
WHERE userid = :idTeacher */
$SORGU = $DB->prepare($sql);

$SORGU->bindParam(':idTeacher', $id);

$SORGU->execute();

$teachers = $SORGU->fetchAll(PDO::FETCH_ASSOC);
//! Veritabandaki cinsiyete göre checked yapma
$selectGender = $teachers[0]['usergender'];

//! Teacherın seçtiği sınıfları çekme
$selectClasses = $teachers[0]['classid'];
//!Virgülle ayrılmış classid'leri diziye çevir
$selectClassesArray = explode(",", $selectClasses);

//! Teacherın seçtiği dersleri çekme
$selectLessons = $teachers[0]['lessonid'];
//!Virgülle ayrılmış dersleri diziye çevir
$selectLesonsArray = explode(",", $selectLessons);
/* echo "<pre>";
print_r($teachers);
die(); */

if (isset($_POST['form_submit'])) {
    //!htmlspecialchars() kullanıcıdan alınan veriyi güvenli hale getirir
    //! eğer kullanıcı zararlı bir kod gönderirse bunu html etiketlerine dönüştürür
    //?Form elemanları
    $name = htmlspecialchars($_POST['form_username']);
    $email = htmlspecialchars($_POST['form_email']);
    $gender = $_POST['form_gender'];
    $address = htmlspecialchars($_POST['form_adress']);
    $phoneNumber = htmlspecialchars($_POST['form_phonenumber']);
    $birthDate = $_POST['form_birthdate'];
    //?Sınıfları forech ile alma
    $selectClasses = $_POST['class'];
    $teacherClass = "";
    foreach ($selectClasses as $selectClass) {
        $teacherClass .= $selectClass . ",";
    }

    //!Chatgpt çözümü
    $lessonIds = array(); // lessonid'leri tutacak dizi
    $lessonNames = array(); // lessonname'leri tutacak dizi

    foreach ($_POST['lessons'] as $selectedLesson) {
        $selectedValues = explode('-', $selectedLesson);
        $lessonIds[] = $selectedValues[0];
        $lessonNames[] = $selectedValues[1];
    }
    // Virgülle ayrılmış bir şekilde lessonid ve lessonname'leri oluştur
    $teacherLessonid = implode(',', $lessonIds);
    $teacherLessonName = implode(',', $lessonNames);

    //!Chatgpt çözümü
    $classIds = array(); // classid'leri tutacak dizi
    $classNames = array(); // classname'leri tutacak dizi

    foreach ($_POST['class'] as $selectedClass) {
        $selectedValues = explode('-', $selectedClass);
        $classIds[] = $selectedValues[0];
        $classNames[] = $selectedValues[1];
    }

    // Virgülle ayrılmış bir şekilde classid ve classname'leri oluştur
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
    $old_img_name = $teachers[0]['userimg'];

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
                $img_upload_path = 'teacher_images/' . $new_img_name;
                move_uploaded_file($tmp_name, $img_upload_path);
                //? Eğer yeni fotoğraf yüklendiyse eski fotoğrafı sil
                //?unlink dosya silmek için kullanılır
                unlink('teacher_images/' . $old_img_name);
                //!Foto güncellediyse veritabanına yeni fotoğraf adını kaydet
                $sql = "UPDATE teachers SET username = :form_username, useremail	 = :form_email, usergender=:form_gender,useraddress=:form_adress,phonenumber=:form_phonenumber,birthdate=:form_birthdate,userimg = '$new_img_name',classid=:classid,classname=:classname,lessonid = :lessonid, lessonname = :lessonname WHERE userid = :idTeacher";

            } else {
                $errors[] = "You can't upload files of this type !";
            }
        }
    } else {
        //!Foto güncellemediysen eski fotoğrafı kullan
        $sql = "UPDATE teachers SET username = :form_username, useremail	 = :form_email, usergender=:form_gender,useraddress=:form_adress,phonenumber=:form_phonenumber,birthdate=:form_birthdate,classid=:classid,classname=:classname,lessonid = :lessonid, lessonname = :lessonname WHERE userid = :idTeacher";
    }
    //! Hata yoksa veritabanına kaydet
    if (empty($errors)) {
        //! Kullanıcı e-posta adresini değiştirdiyse, yeni e-posta adresi için veritabanında mevcut bir kullanıcı olup olmadığını kontrol et
        //? Eğer post edilen email update yapılan kişinin dışında bir kullanıcıda varsa hata mesajı göster
        $checkEmailQuery = $DB->prepare("SELECT * FROM teachers WHERE useremail = :email AND userid != :idTeacher");
        $checkEmailQuery->bindParam(':email', $email);
        $checkEmailQuery->bindParam(':idTeacher', $id);
        $checkEmailQuery->execute();
        $existingUser = $checkEmailQuery->fetch(PDO::FETCH_ASSOC);
        if ($existingUser) {
            $errors[] = "This email is already in use !";
        } else {
            $SORGU = $DB->prepare($sql);
            $SORGU->bindParam(':form_username', $name);
            $SORGU->bindParam(':form_email', $email);
            $SORGU->bindParam(':form_gender', $gender);
            $SORGU->bindParam(':form_adress', $address);
            $SORGU->bindParam(':form_phonenumber', $phoneNumber);
            $SORGU->bindParam(':form_birthdate', $birthDate);
            $SORGU->bindParam(':classid', $studentClassid);
            $SORGU->bindParam(':classname', $studentClassName);
            $SORGU->bindParam(':lessonid', $teacherLessonid);
            $SORGU->bindParam(':lessonname', $teacherLessonName);

            $SORGU->bindParam(':idTeacher', $id);
            $SORGU->execute();
            echo '<script>';
            echo 'alert("Teacher User Update Successful...");';
            echo 'window.location.href = "update.teacher.php?idTeacher=' . $teachers[0]['userid'] . '";';
            echo '</script>';
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
<div class="form-floating mb-3">
  <input type="text"  class="form-control" value="<?php echo $_SESSION['userName'] ?>"disabled readonly>
  <label>Added By Register Unit Name</label>
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
    $classValue = $class['classid'] . '-' . $class['classname'];
    echo '<div class="col-md-3">';
    echo '<div class="form-check form-check-inline">';
    echo '<input class="form-check-input" type="checkbox" name="class[]" value="' . $classValue . '" id="check-' . $classId . '" ' . ($isChecked ? 'checked' : '') . '>';
    echo '<label class="form-check-label" for="check-' . $classId . '">' . $class['classname'] . '</label>';
    echo '</div>';
    echo '</div>';
}
?>
</div>
</div>
<div class="form-floating mb-3">
  <div class="row">
  <?php
$SORGU = $DB->prepare("SELECT * FROM lessons");
$SORGU->execute();
$lessons = $SORGU->fetchAll(PDO::FETCH_ASSOC);
/* echo '<pre>';
print_r($lessons);
die(); */
//! chatgpt ile dersleri listeleme
echo '<label class="mb-1">Selected Lessons</label>';
$selectedCount = count($selectLesonsArray);

foreach ($lessons as $lesson) {
    $lessonId = $lesson['lessonid'];
    $isChecked = in_array($lessonId, $selectLesonsArray);
    $lessonValue = $lesson['lessonid'] . '-' . $lesson['lessonname'];

    echo '<div class="col-md-3">';
    echo '<div class="form-check form-check-inline">';

    // JavaScript kullanarak checkbox kontrolü
    echo '<input class="form-check-input" type="checkbox" name="lessons[]" value="' . $lessonValue . '" id="check-' . $lessonId . '" onmouseout="checkCheckboxLimit(this)" ' . ($isChecked ? 'checked' : '') . '>';

    echo '<label class="form-check-label" for="check-' . $lessonId . '">' . $lesson['lessonname'] . '</label>';
    echo '</div>';
    echo '</div>';
}

// JavaScript fonksiyonu
echo '<script>
    function checkCheckboxLimit(checkbox) {
        var checkboxes = document.querySelectorAll(\'input[name="lessons[]"]\');
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
        document.getElementById("checkbox-message").innerHTML = (checkedCount === 1) ? "Lesson Selected" : "";
    }
</script>';

// Mesajı göster
echo '<span id="checkbox-message" class="text-danger mt-3 fw-bold ">' . (($selectedCount === 1) ? "One Lesson can be selected" : "") . '</span>';
?>
</div>
</div>
<div class="row">
    <div class="col-6">
    <span>Current Image</span>
                    <img src="teacher_images/<?php echo $teachers[0]['userimg']; ?>" alt="User Image"  class="img-thumbnail m-3 ">
                    </div>
</div>
<div class="input-group mb-3">
  <input type="file"  name='form_image' class="form-control" id="inputGroupFile02">
  <label class="input-group-text" for="inputGroupFile02">Upload Teacher User Image &nbsp; <i class="bi bi-upload"></i></label>
</div>

                  <button type="submit" name="form_submit" class="btn btn-primary mt-3 ">Update Teacher User
                  <i class="bi bi-send"></i>
                  </button>
     </form>
     </div>

</div>

</div>
<?php require 'down.html.php';?>