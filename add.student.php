<?php
@session_start();
$activeTitle = "Add Student User";
$activePage = "add.student";
require 'up.html.php';
require 'login.control.php';
?>
<?php
//! Rol idsi 2 olan register unit sadece öğrenci ekleyebilir
if ($_SESSION['role'] != 2) {
    header("location: authorizationcontrol.php");
    die();
}
?>
<?php
//! Veri tabanına öğrenci ekleme
if (isset($_POST['submit']) && isset($_FILES['form_image'])) {
    //!Hata mesajlarını göstermek için boş bir dizi
    $errors = array();
    require_once 'db.php';
    //!htmlspecialchars() kullanıcıdan alınan veriyi güvenli hale getirir
    //! eğer kullanıcı zararlı bir kod gönderirse bunu html etiketlerine dönüştürür
    $name = htmlspecialchars($_POST['form_username']);
    $email = htmlspecialchars($_POST['form_email']);
    //! Sınıfı seçme
    //! explode() fonksiyonu, bir dizedeki karakterleri bir dizeye ayırır.
    $selectClass = explode('-', $_POST['form_class']); // Sınıfı parçala
    $selectedClassId = $selectClass[0];
    $selectedClassName = $selectClass[1];

    $gender = $_POST['form_gender'];
    $address = htmlspecialchars($_POST['form_adress']);
    $phoneNumber = htmlspecialchars($_POST['form_phonenumber']);
    $birthDate = $_POST['form_birthdate'];
    $addedUnitid = $_SESSION['id'];
    $addedUnitName = $_SESSION['userName'];

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

    $rePassword = $_POST['form_repassword'];
    $password = ($_POST['form_password']);
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
        $errors[] = "This email is already registered !";

        //!Eğer kullanıcı yoksa kaydet
    } else if ($_POST['form_password'] != $_POST['form_repassword']) {
        $errors[] = "Passwords Do Not Match !";
    } else if ($error === 0) {
        //!Resim boyutu kontrolü gözden geçmeli
        if ($img_size < 0) {
            $errors[] = "Sorry, your file is too large !";
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
                $sql = "INSERT INTO students(username,useremail,usergender,useraddress,phonenumber,birthdate,userpassword,userimg,classid,classname,lessonid,lessonname,addedunitid,addedunitname) VALUES (:form_username,:form_email,:form_gender,:form_adress,:form_phonenumber,:form_birthdate,'$password','$new_img_name',:classid,:classname,:lessonid,:lessonname,:unitid,:unitname)";
                $SORGU = $DB->prepare($sql);
                $SORGU->bindParam(':form_username', $name);
                $SORGU->bindParam(':form_email', $email);
                $SORGU->bindParam(':form_gender', $gender);
                $SORGU->bindParam(':form_adress', $address);
                $SORGU->bindParam(':form_phonenumber', $phoneNumber);
                $SORGU->bindParam(':form_birthdate', $birthDate);
                $SORGU->bindParam(':classid', $selectedClassId);
                $SORGU->bindParam(':classname', $selectedClassName);
                $SORGU->bindParam(':lessonid', $studentLessonid);
                $SORGU->bindParam(':lessonname', $studentLessonName);
                $SORGU->bindParam(':unitid', $addedUnitid);
                $SORGU->bindParam(':unitname', $addedUnitName);
                $SORGU->execute();
                $approves[] = "Student User Added Successfully...";
                echo '<script>';
                echo 'document.addEventListener("DOMContentLoaded", function() {';
                echo 'var myModal = new bootstrap.Modal(document.getElementById("parentModal"));';
                echo 'myModal.show();';
                echo '});';
                echo '</script>';
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
<?php require 'add.parent.php';?>
    <?php include 'navbar.php';?>
  <div class="container">
  <div class="row justify-content-center mt-3">
  <div class="col-6">
<form method="POST" class="needs-validation" enctype="multipart/form-data" novalidate>
<h1 class="alert alert-info text-center">Add Student User Form</h1>
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
  <label>Added By Register Unit Name</label>
</div>
<div class="form-floating mb-3">
  <input type="text"  class="form-control" id="floatingInput" placeholder="User Name" name="form_username" required>
  <label for="floatingInput">User Name</label>
  <div class="invalid-feedback fw-bold">
      Please Write Your Name !
    </div>
</div>
  <div class="form-floating mb-3">
  <input type="email" name="form_email"id="floatingInput" placeholder="Email"class="form-control"required>
  <label for="floatingInput">Email</label>
  <div class="invalid-feedback fw-bold">
      Please Write Email !
    </div>
</div>
<div class="input-group mb-3  input-group-lg">
  <input type="password"  name="form_password" class="form-control" id="oldPassword" placeholder="Password"required>
  <span class="input-group-text bg-transparent"><i id="toggleOldPassword" class="bi bi-eye-slash"></i></span>
  <div class="invalid-feedback fw-bold">
      Please Write Password !
    </div>
</div>
<div class="input-group mb-3  input-group-lg">
  <input type="password"  name="form_repassword" class="form-control" id="oldRePassword" placeholder="Please Enter Your Password Again"required>
  <span class="input-group-text bg-transparent"><i id="toggleOldRePassword" class="bi bi-eye-slash"></i></span>
  <div class="invalid-feedback fw-bold">
      Please Write Password Again !
    </div>
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
<option disabled selected value="">Select Class</option>
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
//! chatgpt ile Sınıfları listeleme
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
  <input type="tel" id="floatingInput" placeholder="Phone Number"  class="form-control" maxlength="11" name="form_phonenumber" required>
  <label for="floatingInput">Phone Number</label>
  <div class="invalid-feedback fw-bold">
      Please Write Phone Number !
    </div>
</div>
<div class="form-floating mb-3">
<div class="mb-3">
  <label for="exampleFormControlInput1" class="form-label">Birthdate</label>
  <input type="date" name="form_birthdate" class="form-control" id="exampleFormControlInput1" required/>
  <div class="invalid-feedback fw-bold">
      Please Select Birthdate !
    </div>
</div>
</div>
<div class="form-floating mb-3">
  <select class="form-select" id="floatingSelect" name="form_gender"  required aria-label="Floating label select example" >
    <option selected disabled value="">Select Gender</option>
    <option value="M">Male</option>
    <option value="F">Female</option>
  </select>
  <label for="floatingSelect">Gender</label>
  <div class="invalid-feedback fw-bold">
      Please Select Gender !
    </div>
</div>
<div class="input-group mb-3">
  <input type="file"  name='form_image' class="form-control" id="inputGroupFile02"required>
  <label class="input-group-text" for="inputGroupFile02">Upload Student Image &nbsp; <i class="bi bi-upload"></i></label>
  <div class="invalid-feedback fw-bold">
      Please Upload Student Image !
    </div>
</div>
                  <button type="submit" name="submit" class="btn btn-primary mt-3 ">Add Student User
                  <i class="bi bi-send"></i>
                  </button>
     </form>
     </div>
</div>
</div>
<!-- Parent Ekleme Modal -->
<div class="modal fade" id="parentModal" tabindex="-1" aria-labelledby="parentModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="parentModalLabel">Add Student Parent's</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="post" class="needs-validation" enctype="multipart/form-data" novalidate>
        <div class="form-floating mb-3">
  <input type="text"  class="form-control" value="<?php echo $_SESSION['userName'] ?>"disabled readonly>
  <label>Added By Register Unit Name</label>
</div>
<div class="form-floating mb-3">
  <input type="text"  class="form-control" id="floatingInput" placeholder="Parent's Name" name="form_parentName" required>
  <label for="floatingInput">Parent's Name</label>
  <div class="invalid-feedback fw-bold">
      Please Write Student Parent's Name !
    </div>
</div>
  <div class="form-floating mb-3">
  <input type="email" name="form_parentEmail"id="floatingInput" placeholder="Email"class="form-control"required>
  <label for="floatingInput">Parent's Email</label>
  <div class="invalid-feedback fw-bold">
      Please Write Parent's Email !
    </div>
</div>
<div class="input-group mb-3  input-group-lg">
  <input type="password"  name="form_parentPassword" class="form-control" id="parentOldPasswordBtn" placeholder="Password"required>
  <span class="input-group-text bg-transparent"><i id="parentOldPassword" class="bi bi-eye-slash"></i></span>
  <div class="invalid-feedback fw-bold">
      Please Write Parent's Password !
    </div>
</div>
<div class="input-group mb-3  input-group-lg">
  <input type="password"  name="form_parentRepassword" class="form-control" id="reparentOldPasswordBtn" placeholder="Please Enter Your Password Again"required>
  <span class="input-group-text bg-transparent"><i id="reParentOldPassword" class="bi bi-eye-slash"></i></span>
  <div class="invalid-feedback fw-bold">
      Please Write Parent's Password Again !
    </div>
</div>
<div class="form-floating mb-3">
  <textarea class="form-control text-break" style="height: 100px" placeholder="Parent's Adress" id="floatingTextarea"name="form_parentAdress"  required></textarea>
  <label for="floatingTextarea">Parent's Address</label>
</div>
<div class="form-floating mb-3">
  <input type="tel" id="floatingInput" placeholder="Parent's Phone Number"  class="form-control" maxlength="11" name="form_parentPhonenumber" required>
  <label for="floatingInput">Parent's Phone Number</label>
  <div class="invalid-feedback fw-bold">
      Please Write Parent's Phone Number !
    </div>
</div>
<div class="form-floating mb-3">
<div class="mb-3">
  <label for="exampleFormControlInput1" class="form-label">Parent's Birthdate</label>
  <input type="date" name="form_parentBirthdate" class="form-control" id="exampleFormControlInput1" required/>
  <div class="invalid-feedback fw-bold">
      Please Select Parent's Birthdate !
    </div>
</div>
</div>
<div class="form-floating mb-3">
  <select class="form-select" id="floatingSelect" name="form_parentGender"  required aria-label="Floating label select example" >
    <option selected disabled value="">Select Parent's Gender</option>
    <option value="M">Male</option>
    <option value="F">Female</option>
  </select>
  <label for="floatingSelect">Gender</label>
  <div class="invalid-feedback fw-bold">
      Please Select Parent's Gender !
    </div>
</div>
<div class="input-group mb-3">
  <input type="file"  name='form_parentImage' class="form-control" id="inputGroupFile02"required>
  <label class="input-group-text" for="inputGroupFile02">Upload Parent's Image &nbsp; <i class="bi bi-upload"></i></label>
  <div class="invalid-feedback fw-bold">
      Please Upload Parent's Image !
    </div>
</div>
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Close <i class="bi bi-x-circle"></i></button>
        <button type="submit" name="add_parent" class="btn btn-outline-success">Add Student Parent's  <i class="bi bi-send"></i> </button>
      </div>
      </form>
    </div>
  </div>
</div>
<?php require 'footer.php'?>
<?php require 'down.html.php';?>