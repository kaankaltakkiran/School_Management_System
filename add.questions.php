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
<?php require 'navbar.php'?>
<div class="container">
  <div class="row justify-content-center  ">
    <div class="col-6">
  <h1 class="alert alert-success mt-4 text-center ">Exam</h1>
  </div>
  <div class="row">
    <div class="col-6">
    <h3 class="alert alert-primary mt-2">Exam İnformation</h3>
    <form>
    <?php
require_once 'db.php';
$id = $_GET['idExam'];
$sql = "SELECT * FROM exams WHERE  examid=:idExam";
$SORGU = $DB->prepare($sql);
$SORGU->bindParam(':idExam', $id);
$SORGU->execute();
$exams = $SORGU->fetchAll(PDO::FETCH_ASSOC);
/* var_dump($exams);
die(); */
$selectedExamTime = $exams[0]['examtime'];
$isPublis = $exams[0]['ispublish'];
//!Database'den gelen seçili classid
$examClassid = $exams[0]['classid'];
?>
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
    <div class="col-6">
    <h3 class="alert alert-primary mt-2">Exam Questions</h3>
    <a data-bs-toggle="modal" data-bs-target="#exampleModal2" class="btn btn-success mb-3 ">Add Questions <i class="bi bi-send-plus"></i></a>
    <a href="" class="btn btn-danger float-end">Delete All Questions <i class="bi bi-trash"></i> </a>
    <div class="accordion accordion-flush" id="accordionFlushExample">
  <div class="accordion-item">
    <h2 class="accordion-header">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
        Aşağıdakilerden hangisi Türkiye Cumhuriyeti'nin ilk cumhurbaşkanıdır?
      </button>
    </h2>
    <div id="flush-collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
      <div class="accordion-body">
      <div class="form-check">
  <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
  <label class="form-check-label" for="flexRadioDefault1">
    Default radio
  </label>
</div>
<div class="form-check">
  <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
  <label class="form-check-label" for="flexRadioDefault1">
    Default radio
  </label>
</div>
<div class="form-check">
  <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
  <label class="form-check-label" for="flexRadioDefault1">
    Default radio
  </label>
</div>
<div class="form-check">
  <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
  <label class="form-check-label" for="flexRadioDefault1">
    Default radio
  </label>
</div>
      </div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
        Accordion Item #2
      </button>
    </h2>
    <div id="flush-collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
      <div class="accordion-body">Placeholder content for this accordion, which is intended to demonstrate the <code>.accordion-flush</code> class. This is the second item's accordion body. Let's imagine this being filled with some actual content.</div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
        Accordion Item #3
      </button>
    </h2>
    <div id="flush-collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
      <div class="accordion-body">Placeholder content for this accordion, which is intended to demonstrate the <code>.accordion-flush</code> class. This is the third item's accordion body. Nothing more exciting happening here in terms of content, but just filling up the space to make it look, at least at first glance, a bit more representative of how this would look in a real-world application.</div>
    </div>
  </div>
</div>
  </div>
</div>
</div>
<div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel2" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel2">Add Question</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="post">
<div class="form-floating mb-3">
  <textarea class="form-control" placeholder="Question Title" id="floatingTextarea2" name="form_title" style="height: 100px"></textarea>
  <label for="floatingTextarea2">Question Title</label>
</div>
  <div class="form-check">
  <input class="form-check-input" type="radio"  id="flexRadioDefault1"> (A)
  <div class="form-floating mb-3">
  <input type="text" class="form-control" name="form_answer1" placeholder="Answer(A)">
  <label for="floatingInput">Answer(A)</label>
</div>
</div>
<div class="form-check">
  <input class="form-check-input" type="radio"  id="flexRadioDefault1"> (B)
  <div class="form-floating mb-3">
  <input type="text" class="form-control" name="form_answer2" placeholder="Answer(B)">
  <label for="floatingInput">Answer(B)</label>
</div>
</div>
<div class="form-check">
  <input class="form-check-input" type="radio"  id="flexRadioDefault1"> (C)
  <div class="form-floating mb-3">
  <input type="text" class="form-control" name="form_answer3" placeholder="Answer(C)">
  <label for="floatingInput">Answer(C)</label>
</div>
</div>
<div class="form-check">
  <input class="form-check-input" type="radio"  id="flexRadioDefault1"> (D)
  <div class="form-floating mb-3">
  <input type="text" class="form-control" name="form_answer4" placeholder="Answer(D)">
  <label for="floatingInput">Answer(D)</label>
</div>
</div>
<div class="form-floating mt-3 ">
  <select class="form-select" name="form_true_answer" id="floatingSelect" aria-label="Floating label select example">
    <option selected disabled>Select True Answer</option>
    <option value="A">(A)</option>
    <option value="B">(B)</option>
    <option value="C">(C)</option>
    <option value="D">(D)</option>
  </select>
  <label for="floatingSelect">True Answer</label>
</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
        <button type="submit" name="submit_form" class="btn btn-success">Add Question</button>
      </div>
      </form>
    </div>
  </div>
</div>
<?php
$id = $_GET['idExam'];
//!form submit edilmişse
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
    }
}
?>

<?php require 'down.html.php';?>
