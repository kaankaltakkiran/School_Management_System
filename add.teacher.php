<?php
@session_start();
$activeTitle = "Add Teacher User";
require 'up.html.php';
?>
<?php
if (isset($_POST['submit']) && isset($_FILES['form_image'])) {
    //!Hata mesajlarını göstermek için boş bir dizi
    $errors = array();
    require_once 'db.php';
    $name = $_POST['form_username'];
    $email = $_POST['form_email'];
    $gender = $_POST['form_gender'];
    $address = $_POST['form_adress'];
    $phoneNumber = $_POST['form_phonenumber'];
    $birthDate = $_POST['form_birthdate'];
    $addedUnitid = $_SESSION['id'];
    $addedUnitName = $_SESSION['userName'];
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

    $password = $_POST['form_password'];
/*  Şifrele hashleme */
    $password = password_hash($password, PASSWORD_DEFAULT);

    //!Resim yükleme
    $img_name = $_FILES['form_image']['name'];
    $img_size = $_FILES['form_image']['size'];
    $tmp_name = $_FILES['form_image']['tmp_name'];
    $error = $_FILES['form_image']['error'];
    // Hata kontrolü
    $errors = array();

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
                $img_upload_path = 'teacher_images/' . $new_img_name;
                move_uploaded_file($tmp_name, $img_upload_path);

                // Insert into Database
                $sql = "INSERT INTO teachers (username,useremail,usergender,useraddress,phonenumber,birthdate,userpassword,userimg,classid,lessonid,lessonname,addedunitid,addedunitname) VALUES (:form_username,:form_email,:form_gender,:form_adress,:form_phonenumber,:form_birthdate,'$password','$new_img_name','$teacherClass',:lessonid,:lessonname,:unitid,:unitname)";
                $SORGU = $DB->prepare($sql);

                $SORGU->bindParam(':form_username', $name);
                $SORGU->bindParam(':form_email', $email);
                $SORGU->bindParam(':form_gender', $gender);
                $SORGU->bindParam(':form_adress', $address);
                $SORGU->bindParam(':form_phonenumber', $phoneNumber);
                $SORGU->bindParam(':form_birthdate', $birthDate);
                $SORGU->bindParam(':lessonid', $teacherLessonid);
                $SORGU->bindParam(':lessonname', $teacherLessonName);
                $SORGU->bindParam(':unitid', $addedUnitid);
                $SORGU->bindParam(':unitname', $addedUnitName);

                $SORGU->execute();
                $approves[] = "Teacher User Added Successfully...";
            } else {
                $errors[] = "You can't upload files of this type";
            }
        }
    } else {
        /*     $errors[] = "unknown error occurred!"; */
        $errors[] = "Image Not Selected";
    }

}
?>
    <?php include 'navbar.php';?>
  <div class="container">
  <div class="row justify-content-center mt-3">
  <div class="col-6">

<form method="POST"enctype="multipart/form-data">
<h1 class="alert alert-info text-center">Add Teacher User Form</h1>
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
<?php
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
  <label>Added By Admin Name</label>
</div>
<div class="form-floating mb-3">
  <input type="text"  class="form-control" name="form_username" required>
  <label>User Name</label>
</div>
  <div class="form-floating mb-3">
  <input type="email" name="form_email"class="form-control"required>
  <label>Email</label>
</div>
<?php
require_once 'db.php';

$SORGU = $DB->prepare("SELECT * FROM classes");
$SORGU->execute();
$classes = $SORGU->fetchAll(PDO::FETCH_ASSOC);
//echo '<pre>'; print_r($users);

?>
<div class="form-floating mb-3">
  <div class="row">
  <?php
//! chatgpt ile sınıfları listeleme
echo '<label class="mb-1">Select Classes</label>';
foreach ($classes as $class) {
    echo '<div class="col-md-3">'; // Dört sütunlu (veya istediğiniz sayıda sütun) bir düzen
    echo '<div class="form-check form-check-inline">';
    echo '<input class="form-check-input" type="checkbox" name="class[]" value="' . $class['classid'] . '" id="check-' . $class['classid'] . '">';
    echo '<label class="form-check-label" for="check-' . $class['classid'] . '">' . $class['classname'] . '</label>';
    echo '</div>';
    echo '</div>';
}
?>
</div>
</div>
<?php
require_once 'db.php';

$SORGU = $DB->prepare("SELECT * FROM lessons");
$SORGU->execute();
$lessons = $SORGU->fetchAll(PDO::FETCH_ASSOC);
//echo '<pre>'; print_r($lessons);

?>
<div class="form-floating mb-3">
  <div class="row">
  <?php
//! chatgpt ile sınıfları listeleme
echo '<label class="mb-1">Select Lessons</label>';
foreach ($lessons as $lesson) {
    $checkbox_value = $lesson['lessonid'] . '-' . $lesson['lessonname'];
    echo '<div class="col-md-3">';
    echo '<div class="form-check form-check-inline">';
    echo '<input class="form-check-input" type="checkbox" name="lessons[]" value="' . $checkbox_value . '" id="check-' . $lesson['lessonid'] . '">';
    echo '<label class="form-check-label" for="check-' . $lesson['lessonid'] . '">' . $lesson['lessonname'] . '</label>';
    echo '</div>';
    echo '</div>';
}
?>
</div>
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
<div class="form-check mb-3">
  <input class="form-check-input" type="radio" name="form_gender" value="F" required>
  <label class="form-check-label" >
  Female
  </label>
</div>
<div class="input-group mb-3">
  <input type="file"  name='form_image' class="form-control" id="inputGroupFile02"required>
  <label class="input-group-text" for="inputGroupFile02">Upload Teacher Image</label>
</div>

                  <button type="submit" name="submit" class="btn btn-primary mt-3 ">Add Teacher User</button>
     </form>
     </div>
</div>

</div>
<?php require 'footer.php'?>
<?php require 'down.html.php';?>
<!-- Öğretmenin sahip olduğu sınıfları gösterme -->
<!-- SELECT DISTINCT classes.*
FROM classes
JOIN teachers ON teachers.classid LIKE CONCAT('%', classes.classid, '%'); -->