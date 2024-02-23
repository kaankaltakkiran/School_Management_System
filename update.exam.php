
<?php
@session_start();
$activeTitle = "Update Exam";
$activePage = "update.exam";
require 'up.html.php';
require 'login.control.php';
?>
<?php
require_once 'db.php';
$id = $_GET['idExam'];
$addedid = $_SESSION['id'];
$sql = "SELECT * FROM exams where examid = :idExam AND addedid = :addedid";
$SORGU = $DB->prepare($sql);
$SORGU->bindParam(':idExam', $id);
$SORGU->bindParam(':addedid', $addedid);
$SORGU->execute();
$exams = $SORGU->fetchAll(PDO::FETCH_ASSOC);
/* var_dump($exams);
die(); */
//!Database'den gelen seçili classid
$selectedClassId = $exams[0]['classid'];
//!Database'den gelen seçili exam time
$selectedExamTime = $exams[0]['examtime'];
//!Veritabanından publish announcement değerini al
$isPublis = $exams[0]['ispublish'];

if ($_SESSION['role'] != 3) {
    header("location: authorizationcontrol.php");
    die();
}
?>
    <?php include 'navbar.php';?>
  <div class="container">
  <div class="row justify-content-center mt-3">
  <div class="col-6">
<form method="POST"enctype="multipart/form-data">
<h1 class="alert alert-info text-center"><?php echo $exams[0]['examtitle'] ?> Update</h1>
<?php
if (isset($_POST['form_submit'])) {
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
    //!Checkbox değeri kontrolü
    //?checkbox işaretli ise 1 değilse 0
    $isPublish = isset($_POST['form_ispublish']) ? 1 : 0;

    //!Resim yükleme
    $img_name = $_FILES['form_image']['name'];
    $img_size = $_FILES['form_image']['size'];
    $tmp_name = $_FILES['form_image']['tmp_name'];
    $error = $_FILES['form_image']['error'];

    //!Eski fotoğraf adını al
    $old_img_name = $exams[0]['examimg'];

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
                $img_upload_path = 'exam_images/' . $new_img_name;
                move_uploaded_file($tmp_name, $img_upload_path);
                //? Eğer yeni fotoğraf yüklendiyse eski fotoğrafı sil
                //?unlink dosya silmek için kullanılır
                unlink('exam_images/' . $old_img_name);
                //!Foto güncellediyse veritabanına yeni fotoğraf adını kaydet
                $sql = "UPDATE exams SET examtitle = :form_examtitle, examdescription = :form_examdescription, examstartdate = :form_examstartdate, examenddate = :form_examenddate, examtime = :form_examtime,ispublish=:form_ispublish, examimg = '$new_img_name', classid=:classid,classname=:classname WHERE examid = :idExam";

            } else {
                $errors[] = "You can't upload files of this type !";
            }
        }
    } else {
        //!Foto güncellemediysen eski fotoğrafı kullan
        $sql = "UPDATE exams SET examtitle = :form_examtitle, examdescription = :form_examdescription, examstartdate = :form_examstartdate, examenddate = :form_examenddate, examtime = :form_examtime,ispublish=:form_ispublish, classid=:classid,classname=:classname WHERE examid = :idExam";
    }
    //! Hata yoksa veritabanına kaydet
    if (empty($errors)) {
        //! Kullanıcı eğer aynı sınav varsa hata mesajı göster
        $checkExamQuery = $DB->prepare("SELECT * FROM exams WHERE examtitle = :examtitle AND addedid = :addedid");
        $checkExamQuery->bindParam(':examtitle', $examtitle);
        $checkExamQuery->bindParam(':addedid', $addedid);
        $checkExamQuery->execute();
        $existingExam = $checkExamQuery->fetch(PDO::FETCH_ASSOC);
        if (0) {
            $errors[] = "This Exam is already in use !";
        } else {
            $SORGU = $DB->prepare($sql);
            $SORGU->bindParam(':form_examtitle', $examtitle);
            $SORGU->bindParam(':form_examdescription', $examdescription);
            $SORGU->bindParam(':form_examstartdate', $examstartdate);
            $SORGU->bindParam(':form_examenddate', $examenddate);
            $SORGU->bindParam(':form_examtime', $examtime);
            $SORGU->bindParam(':form_ispublish', $isPublish);
            $SORGU->bindParam(':classid', $studentClassid);
            $SORGU->bindParam(':classname', $studentClassName);
            $SORGU->bindParam(':idExam', $id);
            $SORGU->execute();
            echo '<script>';
            echo 'alert("Exam Update Successful...");';
            echo 'window.location.href = "update.exam.php?idExam=' . $exams[0]['examid'] . '";';
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
  <label>Update By Teacher Name</label>
</div>
<div class="form-floating mb-3">
  <input type="text"  class="form-control" value="<?php echo $exams[0]['examtitle'] ?>" name="form_examtitle">
  <label>Exam Title Name</label>
</div>
<div class="form-floating mb-3">
  <input type="text"  class="form-control" value="<?php echo $exams[0]['examdescription'] ?>" name="form_examdescription">
  <label>Exam Description</label>
</div>
<?php
require_once 'db.php';
$sql = "SELECT * FROM classes";
$SORGU = $DB->prepare($sql);
$SORGU->execute();
$classes = $SORGU->fetchAll(PDO::FETCH_ASSOC);
/* var_dump($classes);
die(); */
?>
<div class="form-floating mb-3">
<select class="form-select" name="form_class[]" required>
        <option disabled value="">Select Class Name</option>
        <!-- Chatgpt çözümü seçili categoriyi getirme ve listeleme -->
        <?php
foreach ($classes as $class) {
    $selected = ($class['classid'] == $selectedClassId) ? 'selected' : '';
    echo "<option value='" . $class['classid'] . "-" . $class['classname'] . "' $selected>{$class['classname']}</option>";
}
?>
    </select>
</div>
<div class="form-floating mb-3">
<div class="mb-3">
  <label for="exampleFormControlInput1" class="form-label">Start Exam Date</label>
  <input type="date"name="form_examstartdate" class="form-control" id="exampleFormControlInput1" value="<?php echo $exams[0]['examstartdate'] ?>"  min="<?php echo date('Y-m-d'); ?>" />
</div>
</div>
<div class="form-floating mb-3">
<div class="mb-3">
  <label for="exampleFormControlInput1" class="form-label">End Exam Date</label>
  <input type="date"name="form_examenddate" class="form-control" id="exampleFormControlInput1" value="<?php echo $exams[0]['examenddate'] ?>"  min="<?php echo date('Y-m-d'); ?>" />
</div>
</div>

<div class="form-floating mb-3">
<select class="form-select" name="form_examtime">
<option selected disabled value="">Select Exam Time</option>
        <option value="10" <?php if ($selectedExamTime === '10') {
    echo 'selected';
}
?>>10 minutes</option>
        <option value="30" <?php if ($selectedExamTime === '30') {
    echo 'selected';
}
?>>30 minutes</option>
        <option value="45" <?php if ($selectedExamTime === '45') {
    echo 'selected';
}
?>>45 minutes</option>
        <option value="60" <?php if ($selectedExamTime === '60') {
    echo 'selected';
}
?>>60 minutes</option>
    </select>
</div>
<div class="form-check form-switch mb-3">
  <input class="form-check-input" type="checkbox" <?php echo ($isPublis == 1) ? 'checked' : ''; ?> name='form_ispublish'  role="switch" id="flexSwitchCheckDefault">
  <label class="form-check-label" for="flexSwitchCheckDefault">Publish Exam</label>
</div>
<div class="row">
    <div class="col-6">
    <span>Current Image</span>
                    <img src="exam_images/<?php echo $exams[0]['examimg']; ?>" alt="Exam Image"  class="img-thumbnail m-3 ">
                    </div>
</div>
<div class="input-group mb-3">
  <input type="file"  name='form_image' class="form-control" id="inputGroupFile02">
  <label class="input-group-text" for="inputGroupFile02">Upload Exam Image &nbsp; <i class="bi bi-upload"></i></label>
</div>

                  <button type="submit" name="form_submit" class="btn btn-primary mt-3 ">Update Exam
                  <i class="bi bi-send"></i>
                  </button>
     </form>
     </div>
</div>
</div>
<?php require 'footer.php';?>
<?php require 'down.html.php';?>