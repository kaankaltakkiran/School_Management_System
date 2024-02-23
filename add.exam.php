<?php
@session_start();
$activeTitle = "Add Exam";
$activePage = "add.exam";
require 'up.html.php';
require 'login.control.php';
?>
  <?php
if ($_SESSION['role'] != 3) {
    header("location: authorizationcontrol.php");
    die();
}
?>
<?php
if (isset($_POST['submit_form'])) {
    //!Hata mesajlarını göstermek için boş bir dizi
    $errors = array();
    require_once 'db.php';
    //!htmlspecialchars() kullanıcıdan alınan veriyi güvenli hale getirir
    //! eğer kullanıcı zararlı bir kod gönderirse bunu html etiketlerine dönüştürür
    $examtitle = htmlspecialchars($_POST['form_examtitle']);
    $examdescription = htmlspecialchars($_POST['form_examdescription']);
    $examstartdate = $_POST['form_examstartdate'];
    $examenddate = $_POST['form_examenddate'];
    $examtime = $_POST['form_examtime'];
    $addedid = $_SESSION['id'];
    $addedName = $_SESSION['userName'];

    //!Chatgpt çözümü
    $classIds = array(); // lessonid'leri tutacak dizi
    $classNames = array(); // lessonname'leri tutacak dizi

    foreach ($_POST['form_class'] as $selectedClass) {
        $selectedValues = explode('-', $selectedClass);
        $classIds[] = $selectedValues[0];
        $classNames[] = $selectedValues[1];
    }

    // Virgülle ayrılmış bir şekilde lessonid ve lessonname'leri oluştur
    $studentClassid = implode(',', $classIds);
    $studentClassName = implode(',', $classNames);

    $rePassword = $_POST['form_repassword'];
    /*  Şifrele hashleme */
    $password = password_hash($password, PASSWORD_DEFAULT);

    //!Resim yükleme
    $img_name = $_FILES['form_image']['name'];
    $img_size = $_FILES['form_image']['size'];
    $tmp_name = $_FILES['form_image']['tmp_name'];
    $error = $_FILES['form_image']['error'];

    //?Kullanıcı var mı yok mu kontrol etme
    $sql = "SELECT * FROM admins WHERE useremail = :form_email";
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
        //?Şifre kontrolü
    } else if ($_POST['form_password'] != $_POST['form_repassword']) {
        $errors[] = "Passwords Don't Match!";
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
                $img_upload_path = 'exam_images/' . $new_img_name;
                move_uploaded_file($tmp_name, $img_upload_path);

                // Insert into Database
                $sql = "INSERT INTO exams (examtitle,examdescription,examstartdate,examenddate,examtime,classid,classname,addedid,addedname,examimg) VALUES (:examtitle,:examdescription,:examstartdate,:examenddate,:examtime,:classid,:classname,:addedid,:addedname,'$new_img_name')";
                $SORGU = $DB->prepare($sql);
                $SORGU->bindParam(':examtitle', $examtitle);
                $SORGU->bindParam(':examdescription', $examdescription);
                $SORGU->bindParam(':examstartdate', $examstartdate);
                $SORGU->bindParam(':examenddate', $examenddate);
                $SORGU->bindParam(':examtime', $examtime);
                $SORGU->bindParam(':classid', $studentClassid);
                $SORGU->bindParam(':classname', $studentClassName);
                $SORGU->bindParam(':addedid', $addedid);
                $SORGU->bindParam(':addedname', $addedName);
                $SORGU->execute();
                $approves[] = "Exams Added Successfully...";
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
    <?php include 'navbar.php';?>
  <div class="container">
  <div class="row justify-content-center mt-3">
  <div class="col-6">
<form method="POST" class="needs-validation" enctype="multipart/form-data" novalidate>
<h1 class="alert alert-info text-center">Add Exam Form</h1>
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
  <label>Added By Admin Name</label>
</div>
<div class="form-floating mb-3">
  <input type="text"  class="form-control" id="floatingInput" placeholder="Exam Title" name="form_examtitle" required>
  <label for="floatingInput">Exam Title</label>
  <div class="invalid-feedback fw-bold">
      Please Write Exam Title !
    </div>
</div>
<div class="form-floating mb-3">
  <input type="text"  class="form-control" id="floatingInput" placeholder="Exam Description	" name="form_examdescription" required>
  <label for="floatingInput">Exam Description</label>
  <div class="invalid-feedback fw-bold">
      Please Write Exam Description !
    </div>
</div>
<?php
require_once 'db.php';
$sql = "SELECT * FROM classes";
$SORGU = $DB->prepare($sql);
$SORGU->execute();
$classes = $SORGU->fetchAll(PDO::FETCH_ASSOC);

/* var_dump($classes);
die(); */

$optionClassName = "";
foreach ($classes as $class) {
    $optionClassName .= "<option value='" . $class['classid'] . "-" . $class['classname'] . "'>" . $class['classname'] . "</option>";
}

?>
<div class="form-floating mb-3">
<select class="form-select" name="form_class[]" required>
<option disabled selected value="">Select Class Name</option>
      <?php echo $optionClassName; ?>
    </select>
    <div class="invalid-feedback fw-bold">
      Please Select Class Name !
    </div>
</div>
<div class="form-floating mb-3">
<div class="mb-3">
  <label for="exampleFormControlInput1" class="form-label">Start Exam Date</label>
  <input type="date" required name="form_examstartdate" class="form-control" id="exampleFormControlInput1"  min="<?php echo date('Y-m-d'); ?>" />
  <div class="invalid-feedback fw-bold">
      Please Write Start Exam Date !
    </div>
</div>
</div>
<div class="form-floating mb-3">
<div class="mb-3">
  <label for="exampleFormControlInput2" class="form-label">End Exam Date</label>
  <input type="date" required name="form_examenddate" class="form-control" id="exampleFormControlInput2"  min="<?php echo date('Y-m-d'); ?>" />
  <div class="invalid-feedback fw-bold">
      Please Write End Exam Date !
    </div>
</div>
</div>
<div class="form-floating mb-3">
  <select class="form-select" id="floatingSelect" name="form_examtime"  required aria-label="Floating label select example" >
    <option selected disabled value="">Select Exam Time</option>
    <option value="10">10 minutes</option>
    <option value="30">45 minutes</option>
    <option value="45">45 minutes</option>
    <option value="60">60 minutes</option>
  </select>
  <label for="floatingSelect">Exam Time Limit</label>
  <div class="invalid-feedback fw-bold">
      Please Select Exam Time Limit !
    </div>
</div>
<div class="input-group mb-3">
  <input type="file"  name='form_image' class="form-control" id="inputGroupFile02"required>
  <label class="input-group-text" for="inputGroupFile02">Upload Exam Image&nbsp; <i class="bi bi-upload"></i></label>
  <div class="invalid-feedback fw-bold">
      Please Upload Exam Image !
    </div>
</div>
                  <button type="submit" name="submit_form" class="btn btn-primary mb-3">
                    Add Exam
                    <i class="bi bi-send"></i>
                  </button>
     </form>
     </div>
</div>
</div>
<?php require 'footer.php';?>
<?php require 'down.html.php';?>