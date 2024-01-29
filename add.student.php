<?php
@session_start();
$activeTitle = "Add Student User";
require 'up.html.php';
?>
<?php
if (isset($_POST['submit']) && isset($_FILES['form_image'])) {
    //!Hata mesajlarını göstermek için boş bir dizi
    $errors = array();
    require_once 'db.php';
    $name = $_POST['form_username'];
    $email = $_POST['form_email'];
    //! Sınıfı seçme
    //! explode() fonksiyonu, bir dizedeki karakterleri bir dizeye ayırır.
    $selectClass = explode('-', $_POST['form_class']); // Sınıfı parçala
    $selectedClassId = $selectClass[0];
    $selectedClassName = $selectClass[1];

    $parentName = $_POST['form_parentname'];
    $parentNumber = $_POST['form_parentnumber'];
    $gender = $_POST['form_gender'];
    $address = $_POST['form_adress'];
    $phoneNumber = $_POST['form_phonenumber'];
    $birthDate = $_POST['form_birthdate'];

    //!Chatgpt çözümü
    $lessonIds = array(); // lessonid'leri tutacak dizi
    $lessonNames = array(); // lessonname'leri tutacak dizi

    foreach ($_POST['lessons'] as $selectedLesson) {
        $selectedValues = explode('-', $selectedLesson);
        $lessonIds[] = $selectedValues[0];
        $lessonNames[] = $selectedValues[1];
    }

    // Virgülle ayrılmış bir şekilde lessonid ve lessonname'leri oluştur
    $studentLessonid = implode(',', $lessonIds);
    $studentLessonName = implode(',', $lessonNames);

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
    $sql = "SELECT * FROM students WHERE useremail = :form_email";
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
                $img_upload_path = 'student_images/' . $new_img_name;
                move_uploaded_file($tmp_name, $img_upload_path);

                // Insert into Database
                $sql = "INSERT INTO students(username,useremail,usergender,useraddress,phonenumber,birthdate,userpassword,userimg,classid,classname,parentname,parentnumber,lessonid,lessonname) VALUES (:form_username,:form_email,:form_gender,:form_adress,:form_phonenumber,:form_birthdate,'$password','$new_img_name',:classid,:classname,:form_parentname,:form_parentnumber,:lessonid,:lessonname)";
                $SORGU = $DB->prepare($sql);
                $SORGU->bindParam(':form_username', $name);
                $SORGU->bindParam(':form_email', $email);
                $SORGU->bindParam(':form_gender', $gender);
                $SORGU->bindParam(':form_adress', $address);
                $SORGU->bindParam(':form_phonenumber', $phoneNumber);
                $SORGU->bindParam(':form_birthdate', $birthDate);
                $SORGU->bindParam(':classid', $selectedClassId);
                $SORGU->bindParam(':classname', $selectedClassName);
                $SORGU->bindParam(':form_parentname', $parentName);
                $SORGU->bindParam(':form_parentnumber', $parentNumber);
                $SORGU->bindParam(':lessonid', $studentLessonid);
                $SORGU->bindParam(':lessonname', $studentLessonName);

                $SORGU->execute();
                $approves[] = "Student User Added Successfully...";
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
<h1 class="alert alert-info text-center">Add Student User Form</h1>
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
<div class="input-group mb-3  input-group-lg">
  <input type="password"  name="form_password" class="form-control" id="password" placeholder="Password"required>
  <span class="input-group-text bg-transparent"><i id="togglePassword" class="bi bi-eye-slash"></i></span>
</div>
<?php
require_once 'db.php';
$sql = "SELECT classid,classname FROM classes";
$SORGU = $DB->prepare($sql);
$SORGU->execute();
$classes = $SORGU->fetchAll(PDO::FETCH_ASSOC);
/*
var_dump($classes);
die(); */

$optionClasses = "";
foreach ($classes as $class) {
    $optionClasses .= "<option value='{$class['classid']}-{$class['classname']}'>{$class['classname']}</option>";
}

?>


<div class="form-floating mb-3">
<select class="form-select" name="form_class"required>
<option disabled selected>Select Class</option>
      <?php echo $optionClasses; ?>
    </select>
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
<div class="form-floating mb-3">
  <select class="form-select" id="floatingSelect" name="form_gender"  required aria-label="Floating label select example" >
    <option selected disabled>Select Gender</option>
    <option value="M">Male</option>
    <option value="F">Female</option>
  </select>
  <label for="floatingSelect">Gender</label>
</div>

<div class="form-floating mb-3">
  <input type="text"  class="form-control" name="form_parentname" required>
  <label>Parent Name</label>
</div>
<div class="form-floating mb-3">
  <input type="tel"  class="form-control" maxlength="11" name="form_parentnumber" required>
  <label>Parent Phone Number</label>
</div>
<div class="input-group mb-3">
  <input type="file"  name='form_image' class="form-control" id="inputGroupFile02"required>
  <label class="input-group-text" for="inputGroupFile02">Upload Student Image</label>
</div>

                  <button type="submit" name="submit" class="btn btn-primary mt-3 ">Add Student User</button>
     </form>
     </div>
</div>

</div>
<?php require 'footer.php'?>
<?php require 'down.html.php';?>