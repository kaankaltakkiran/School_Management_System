<?php
@session_start();
$activeTitle = "Add Questions";
$activePage = "add.questions";
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
require_once 'db.php';
$id = $_GET['idExam'];
$sql = "SELECT * FROM exams WHERE  examid=:idExam";
$SORGU = $DB->prepare($sql);
$SORGU->bindParam(':idExam', $id);
$SORGU->execute();
$exams = $SORGU->fetchAll(PDO::FETCH_ASSOC);
/* echo '<pre>';
print_r($exams);
die(); */
$selectedExamTime = $exams[0]['examtime'];
$isPublis = $exams[0]['ispublish'];
//!Database'den gelen seçili classid
$examClassid = $exams[0]['classid'];
?>
<?php
if ($_SESSION['userName'] != $exams[0]['addedname']) {
    header("location: authorizationcontrol.php");
    die();
}
?>
<?php require 'navbar.php'?>
<div class="container">
  <div class="row justify-content-center  ">
    <div class="col-6">
  <h1 class="alert alert-success mt-4 text-center ">Exam</h1>
  </div>
  <div class="row">
    <div class="col-6">
     <!--  Teacharın oluşturduğu sınav bilgileri -->
    <h3 class="alert alert-primary mt-2 text-center ">Exam İnformation</h3>
    <form>
<div class="form-floating mb-3">
  <input type="text"  class="form-control" value="<?php echo $_SESSION['userName'] ?>"disabled readonly>
  <label>Update By Teacher Name</label>
</div>
<?php
require_once 'db.php';
$addedid = $_SESSION['id'];
$sql = "SELECT * FROM teachers WHERE  userid=:addedid";
$SORGU = $DB->prepare($sql);
$SORGU->bindParam(':addedid', $addedid);
$SORGU->execute();
$teachers = $SORGU->fetchAll(PDO::FETCH_ASSOC);
/* var_dump($teachers);
die(); */
?>
<div class="form-floating mb-3">
  <input type="text"  class="form-control" value="<?php echo $teachers[0]['lessonname']; ?>"disabled readonly>
  <label>Lesson Name</label>
</div>
<div class="form-floating mb-3">
  <input type="text"  class="form-control" value="<?php echo $exams[0]['examtitle'] ?>" name="form_examtitle"disabled readonly>
  <label>Exam Title Name</label>
</div>
<div class="form-floating mb-3">
  <input type="text"  class="form-control" value="<?php echo $exams[0]['examdescription'] ?>" name="form_examdescription"disabled readonly>
  <label>Exam Description</label>
</div>

<?php
//! Öğretmenin girdiği sınıfların idsi
$selectedClassId = $teachers[0]['classid'];
//! Öğretmenin girdiği sınıfların ismi
$selectedClassName = $teachers[0]['classname'];

//! Öğretmenin girdiği sınıfların ismi
$classArrayId = explode(",", $selectedClassId);
$classArrayName = explode(",", $selectedClassName);
?>
<div class="form-floating mb-3">
<select class="form-select" disabled readonly name="form_class[]" required>
<option disabled selected value="">Select Class Name</option>
<?php
// Her bir değeri bir seçenek olarak ekle
foreach ($classArrayName as $key => $value) {
    $classid = $classArrayId[$key];
    $classname = $value;
    $selected = ($classid == $examClassid) ? 'selected' : '';
    echo "<option $selected  value=$classid-$classname>$value</option>";
}
?>
    </select>
</div>
<div class="form-floating mb-3">
<div class="mb-3">
  <label for="exampleFormControlInput1" class="form-label">Start Exam Date</label>
  <input type="date"name="form_examstartdate" class="form-control" id="exampleFormControlInput1" disabled readonly value="<?php echo $exams[0]['examstartdate'] ?>"  min="<?php echo date('Y-m-d'); ?>" />
</div>
</div>
<div class="form-floating mb-3">
<div class="mb-3">
  <label for="exampleFormControlInput1" class="form-label">End Exam Date</label>
  <input type="date"name="form_examenddate" disabled readonly class="form-control" id="exampleFormControlInput1" value="<?php echo $exams[0]['examenddate'] ?>"  min="<?php echo date('Y-m-d'); ?>" />
</div>
</div>

<div class="form-floating mb-3">
<select class="form-select" disabled readonly name="form_examtime">
<option selected disabled value="">Select Exam Time</option>
        <option  value="10" <?php if ($selectedExamTime === '10') {
    echo 'selected';
}
?>>10 minutes</option>
        <option  value="30" <?php if ($selectedExamTime === '30') {
    echo 'selected';
}
?>>30 minutes</option>
        <option  value="45" <?php if ($selectedExamTime === '45') {
    echo 'selected';
}
?>>45 minutes</option>
        <option  value="60" <?php if ($selectedExamTime === '60') {
    echo 'selected';
}
?>>60 minutes</option>
    </select>
</div>
<div class="form-check form-switch mb-3">
  <input class="form-check-input" disabled readonly type="checkbox" <?php echo ($isPublis == 1) ? 'checked' : ''; ?> name='form_ispublish'  role="switch" id="flexSwitchCheckDefault">
  <label class="form-check-label" for="flexSwitchCheckDefault">Publish Exam</label>
</div>
<div class="row">
    <div class="col-6">
    <span>Current Image</span>
                    <img src="exam_images/<?php echo $exams[0]['examimg']; ?>" alt="Exam Image"  class="img-thumbnail m-3 ">
                    </div>
</div>
     </form>
    </div>
    <?php
//!Tüm soruları silme
if (isset($_POST['removeAllQuestions'])) {
    require 'db.php';
    $remove_id = $_GET['idExam'];
    $sql = "DELETE FROM questions WHERE examid = :idExam";
    $SORGU = $DB->prepare($sql);
    $SORGU->bindParam(':idExam', $remove_id);
    $SORGU->execute();
    $errors[] = "All Questions Deleted Successfully...";
}
?>
<?php
//!Tekil soru silme
if (isset($_POST['removeQuestion'])) {
    require 'db.php';
    $remove_id = $_POST['removeQuestion'];
    $sql = "DELETE FROM questions WHERE questionid = :removeQuestion";
    $SORGU = $DB->prepare($sql);
    $SORGU->bindParam(':removeQuestion', $remove_id);
    $SORGU->execute();
    $errors[] = "Question Deleted Successfully...";
}
?>
    <?php
require_once 'db.php';
$id = $_GET['idExam'];
$sql = "SELECT * FROM questions WHERE  examid=:idExam";
$SORGU = $DB->prepare($sql);
$SORGU->bindParam(':idExam', $id);
$SORGU->execute();
$questions = $SORGU->fetchAll(PDO::FETCH_ASSOC);
/* var_dump($questions);
die(); */
?>
    <div class="col-6">
    <h3 class="alert alert-primary mt-2 text-center ">Exam Questions</h3>
    <form method="post">
    <a data-bs-toggle="modal" data-bs-target="#addmodal" class="btn btn-success mb-3 ">Add Questions <i class="bi bi-send-plus"></i></a>
    <?php if (count($questions) > 0) {?>
    <button type="sumbit" name="removeAllQuestions" onclick="return confirm('Are you sure you want to delete ?')" class="btn btn-danger float-end">Delete All Questions <i class="bi bi-trash"></i> </button>
    <?php }?>
    </form>
<span class="badge rounded-pill text-bg-secondary">Total Questions: <?php echo count($questions) ?></span>
    <h2 class="text-center text-danger ">Questions</h2>
    <div class="accordion accordion-flush" id="accordionFlushExample">
<?php
// Başlangıç sayacı
$questionNumber = 1;
//!Soruları listele
foreach ($questions as $question) {
    //!Accordion id için unique id oluştur
    $questiontid = "accordionflush{$question['questionid']}";
    //!Radio button id için unique id oluştur
    $answerLabelid = "flexRadioDefault{$question['questionid']}";
    //!Modal id için unique id oluştur
    $modalid = "exampleModal{$question['questionid']}";
    ?>
   <!--  Update Modal -->
    <div class="modal fade" id="<?php echo $modalid ?>" tabindex="-1" aria-labelledby="exampleModalLabel<?php echo $question['questionid']; ?>" aria-hidden="true">
<div class="modal-dialog modal-lg modal-dialog-scrollable">
  <div class="modal-content">
    <div class="modal-header">
      <h1 class="modal-title fs-5" id="exampleModalLabel3">Update Question</h1>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
    </div>
    <div class="modal-body">
      <form method="post">
<div class="form-floating mb-3">
<textarea class="form-control" placeholder="Question Title" id="floatingTextarea2" name="form_title" style="height: 100px"><?php echo $question['questiontitle'] ?></textarea>
<label for="floatingTextarea2">Question Title</label>
</div>
<div class="form-check">
<input class="form-check-input" type="radio"  id="flexRadioDefault1"> (A)
<div class="form-floating mb-3">
<textarea class="form-control" placeholder="Answer(A)" id="floatingTextarea2" name="form_answer1" style="height: 100px"><?php echo $question['answera'] ?></textarea>
<label for="floatingTextarea2">Answer(A)</label>
</div>
</div>
<div class="form-check">
<input class="form-check-input" type="radio"  id="flexRadioDefault1"> (B)
<div class="form-floating mb-3">
<textarea class="form-control" placeholder="Answer(B)" id="floatingTextarea2" name="form_answer2" style="height: 100px"><?php echo $question['answerb'] ?></textarea>
<label for="floatingTextarea2">Answer(B)</label>
</div>
</div>
<div class="form-check">
<input class="form-check-input" type="radio"  id="flexRadioDefault1"> (C)
<div class="form-floating mb-3">
<textarea class="form-control" placeholder="Answer(C)" id="floatingTextarea2" name="form_answer3" style="height: 100px"><?php echo $question['answerc'] ?></textarea>
<label for="floatingTextarea2">Answer(C)</label>
</div>
</div>
<div class="form-check">
<input class="form-check-input" type="radio"  id="flexRadioDefault1"> (D)
<div class="form-floating mb-3">
<textarea class="form-control" placeholder="Answer(D)" id="floatingTextarea2" name="form_answer4" style="height: 100px"><?php echo $question['answerd'] ?></textarea>
<label for="floatingTextarea2">Answer(D)</label>
</div>
</div>
<div class="form-floating mt-3 ">
<select class="form-select" name="form_true_answer" id="floatingSelect" aria-label="Floating label select example">
  <option selected disabled value="">Select True Answer</option>
  <option value="A"<?php echo ($question['answera'] === $question['trueanswer']) ? ' selected' : ''; ?>
    ?>(A)</option>
    <option value="B"<?php echo ($question['answerb'] === $question['trueanswer']) ? ' selected' : ''; ?>
    ?>(B)</option>
    <option value="C"<?php echo ($question['answerc'] === $question['trueanswer']) ? ' selected' : ''; ?>
    ?>(C)</option>
    <option value="D"<?php echo ($question['answerd'] === $question['trueanswer']) ? ' selected' : ''; ?>
    ?>(D)</option>
</select>
<label for="floatingTextarea2">True Answer</label>
<div class="invalid-feedback fw-bold">
    Please Select True Answer !
  </div>
</div>
<input type="hidden" name="idquestion" value="<?php echo $question['questionid'] ?>">
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close <i class="bi bi-x-circle"></i></button>
      <button type="submit"   name="update_form" class="btn btn-success">Update  Question  <i class="bi bi-send"></i></button>
    </div>
    </form>
  </div>
</div>
</div>
    <!--  End Update Modal  -->
    <?php
//!form update edilmişse
    if (isset($_POST['update_form'])) {
        require_once 'db.php';
        //!htmlspecialchars() kullanıcıdan alınan veriyi güvenli hale getirir
        //! eğer kullanıcı zararlı bir kod gönderirse bunu html etiketlerine dönüştürür
        require_once 'db.php';
        $idQuestion = $_POST['idquestion'];
        $questionTitle = htmlspecialchars($_POST['form_title']);
        $answer1 = htmlspecialchars($_POST['form_answer1']);
        $answer2 = htmlspecialchars($_POST['form_answer2']);
        $answer3 = htmlspecialchars($_POST['form_answer3']);
        $answer4 = htmlspecialchars($_POST['form_answer4']);
        $optionAnswer = htmlspecialchars($_POST['form_true_answer']);

        //!Chatgpt ile doğru cevabı kontrol etme
        // Doğru cevabı belirleme
        $trueAnswer = ''; // Doğru cevabı tutacak değişken

        switch ($optionAnswer) {
            case 'A':
                $trueAnswer = $answer1;
                break;
            case 'B':
                $trueAnswer = $answer2;
                break;
            case 'C':
                $trueAnswer = $answer3;
                break;
            case 'D':
                $trueAnswer = $answer4;
                break;
            default:
                $trueAnswer = "Invalid";
        }
        $sql = "UPDATE questions SET questiontitle = :form_title, answera = :form_answer1, answerb = :form_answer2, answerc = :form_answer3, answerd = :form_answer4, trueanswer = :true_answer WHERE questionid = :idquestion";
        $SORGU = $DB->prepare($sql);
        $SORGU->bindParam(':form_title', $questionTitle);
        $SORGU->bindParam(':form_answer1', $answer1);
        $SORGU->bindParam(':form_answer2', $answer2);
        $SORGU->bindParam(':form_answer3', $answer3);
        $SORGU->bindParam(':form_answer4', $answer4);
        $SORGU->bindParam(':true_answer', $trueAnswer);
        $SORGU->bindParam(':idquestion', $idQuestion);
        $SORGU->execute();
        $approves[] = "Question Updated Successfully...";
    }
    ?>
  <div class="accordion-item">
    <h2 class="accordion-header">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#<?php echo $questiontid ?>" aria-expanded="false" aria-controls="<?php echo $questiontid ?>">
      <?php echo $questionNumber . ") " . $question['questiontitle'] ?>
      </button>
    </h2>
    <div id="<?php echo $questiontid ?>" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
      <div class="accordion-body">
      <div class="form-check">
  <input class="form-check-input" <?php echo ($question['answera'] === $question['trueanswer']) ? 'checked' : ''; ?> type="radio" name="<?php echo $answerLabelid ?>" id="<?php echo $answerLabelid ?>">
  <label class="form-check-label <?php echo ($question['answera'] === $question['trueanswer']) ? 'text-success' : ''; ?>" for="<?php echo $answerLabelid ?>">
  <?php echo $question['answera'] ?>
  </label>
</div>
<div class="form-check">
  <input class="form-check-input" <?php echo ($question['answerb'] === $question['trueanswer']) ? 'checked' : ''; ?>  type="radio" name="<?php echo $answerLabelid ?>" id="<?php echo $answerLabelid ?>">
  <label class="form-check-label <?php echo ($question['answerb'] === $question['trueanswer']) ? 'text-success' : ''; ?>" for="<?php echo $answerLabelid ?>">
  <?php echo $question['answerb'] ?>
  </label>
</div>
<div class="form-check">
  <input class="form-check-input" <?php echo ($question['answerc'] === $question['trueanswer']) ? 'checked' : ''; ?> type="radio" name="<?php echo $answerLabelid ?>" id="<?php echo $answerLabelid ?>">
  <label class="form-check-label <?php echo ($question['answerc'] === $question['trueanswer']) ? 'text-success' : ''; ?>" for="<?php echo $answerLabelid ?>">
  <?php echo $question['answerc'] ?>
  </label>
</div>
<div class="form-check">
  <input class="form-check-input" <?php echo ($question['answerd'] === $question['trueanswer']) ? 'checked' : ''; ?> type="radio" name="<?php echo $answerLabelid ?>" id="<?php echo $answerLabelid ?>">
  <label class="form-check-label <?php echo ($question['answerd'] === $question['trueanswer']) ? 'text-success' : ''; ?>" for="<?php echo $answerLabelid ?>">
  <?php echo $question['answerd'] ?>
  </label>
</div>
<form method="post">
    <div class="text-end">
    <a data-bs-toggle="modal" data-bs-target="#<?php echo $modalid ?>" class="btn btn-success me-3 mb-3 ">Update <i class='bi bi-arrow-clockwise'></i></a>
        <button  type="submit" value="<?php echo $question['questionid'] ?>" name="removeQuestion" onclick="return confirm('Are you sure you want to delete ?')" class="btn btn-danger float-end">Delete Question <i class="bi bi-trash"></i> </button>
    </div>
</form>
            </div>
      </div>
    </div>

<?php
// Her döngüde soru sayacını artır
    $questionNumber++;
}
?>
</div>
</div>
  </div>
</div>
</div>
<!-- Soru Ekleme Modal -->
<div class="modal fade" id="addmodal" tabindex="-1" aria-labelledby="exampleModalLabel2" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel2">Add Question</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
      </div>
      <div class="modal-body">
        <form method="post" class="needs-validation" novalidate>
<div class="form-floating mb-3">
  <textarea class="form-control" placeholder="Question Title" id="floatingTextarea2" name="form_title" style="height: 100px"required></textarea>
  <label for="floatingTextarea2">Question Title</label>
  <div class="invalid-feedback fw-bold">
      Please Write Question Title !
    </div>
</div>
  <div class="form-check">
  <input class="form-check-input" type="radio"  id="flexRadioDefault1"> (A)
  <div class="form-floating mb-3">
  <textarea class="form-control" placeholder="Answer(A)" id="floatingTextarea2" name="form_answer1" style="height: 100px" required></textarea>
  <label for="floatingTextarea2">Answer(A)</label>
  <div class="invalid-feedback fw-bold">
      Please Write Answer(A) !
    </div>
</div>
</div>
<div class="form-check">
  <input class="form-check-input" type="radio"  id="flexRadioDefault1"> (B)
  <div class="form-floating mb-3">
  <textarea class="form-control" placeholder="Answer(B)" id="floatingTextarea2" name="form_answer2" style="height: 100px" required></textarea>
  <label for="floatingTextarea2">Answer(B)</label>
  <div class="invalid-feedback fw-bold">
      Please Write Answer(B) !
    </div>
</div>
</div>
<div class="form-check">
  <input class="form-check-input" type="radio"  id="flexRadioDefault1"> (C)
  <div class="form-floating mb-3">
  <textarea class="form-control" placeholder="Answer(C)" id="floatingTextarea2" name="form_answer3" style="height: 100px" required></textarea>
  <label for="floatingTextarea2">Answer(C)</label>
  <div class="invalid-feedback fw-bold">
      Please Write Answer(C) !
    </div>
</div>
</div>
<div class="form-check">
  <input class="form-check-input" type="radio"  id="flexRadioDefault1"> (D)
  <div class="form-floating mb-3">
  <textarea class="form-control" placeholder="Answer(D)" id="floatingTextarea2" name="form_answer4" style="height: 100px" required></textarea>
  <label for="floatingTextarea2">Answer(D)</label>
  <div class="invalid-feedback fw-bold">
      Please Write Answer(D) !
    </div>
</div>
</div>
<div class="form-floating mt-3 ">
  <select class="form-select" name="form_true_answer" id="floatingSelect" aria-label="Floating label select example" required>
    <option selected disabled value="">Select True Answer</option>
    <option value="A">(A)</option>
    <option value="B">(B)</option>
    <option value="C">(C)</option>
    <option value="D">(D)</option>
  </select>
  <label for="floatingTextarea2">True Answer</label>
  <div class="invalid-feedback fw-bold">
      Please Select True Answer !
    </div>
</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close <i class="bi bi-x-circle"></i></button>
        <button type="submit"   name="submit_form" class="btn btn-success">Add  Question  <i class="bi bi-send"></i></button>
      </div>
      </form>
    </div>
  </div>
</div>
<!--  End Soru Ekleme Modal  -->
<?php
$id = $_GET['idExam'];
//!form submit edilmişse
//!Soruları ekleme
if (isset($_POST['submit_form'])) {
    //!Hata mesajlarını göstermek için boş bir dizi
    $errors = array();
    //!htmlspecialchars() kullanıcıdan alınan veriyi güvenli hale getirir
    //! eğer kullanıcı zararlı bir kod gönderirse bunu html etiketlerine dönüştürür
    require_once 'db.php';
    $questionTitle = htmlspecialchars($_POST['form_title']);
    $answer1 = htmlspecialchars($_POST['form_answer1']);
    $answer2 = htmlspecialchars($_POST['form_answer2']);
    $answer3 = htmlspecialchars($_POST['form_answer3']);
    $answer4 = htmlspecialchars($_POST['form_answer4']);
    $optionAnswer = htmlspecialchars($_POST['form_true_answer']);
    $addedid = $_SESSION['id'];
    $addedName = $_SESSION['userName'];

    //!Chatgpt ile doğru cevabı kontrol etme
    // Doğru cevabı belirleme
    $trueAnswer = ''; // Doğru cevabı tutacak değişken

    switch ($optionAnswer) {
        case 'A':
            $trueAnswer = $answer1;
            break;
        case 'B':
            $trueAnswer = $answer2;
            break;
        case 'C':
            $trueAnswer = $answer3;
            break;
        case 'D':
            $trueAnswer = $answer4;
            break;
        default:
            $trueAnswer = "Invalid";
    }

    // Insert into Database
    $sql = "INSERT INTO questions (questiontitle,answera,answerb,answerc,answerd,trueanswer,examid,addedid,addedname) VALUES (:form_title,:form_answer1,:form_answer2,:form_answer3,:form_answer4,:true_answer,:idExam,:addedid,:addedname)";
    $SORGU = $DB->prepare($sql);
    $SORGU->bindParam(':form_title', $questionTitle);
    $SORGU->bindParam(':form_answer1', $answer1);
    $SORGU->bindParam(':form_answer2', $answer2);
    $SORGU->bindParam(':form_answer3', $answer3);
    $SORGU->bindParam(':form_answer4', $answer4);
    $SORGU->bindParam(':true_answer', $trueAnswer);
    $SORGU->bindParam(':idExam', $id);
    $SORGU->bindParam(':addedid', $addedid);
    $SORGU->bindParam(':addedname', $addedName);

    $SORGU->execute();
    $approves[] = "Question Added Successfully...";
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
        // 4 saniye sonra sayfayı yenilemek için yönlendirme
        echo "<meta http-equiv='refresh' content='4'>";

    }
}
?>
<?php require 'footer.php'?>
<?php require 'down.html.php';?>
