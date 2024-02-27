
<?php
@session_start();
$activeTitle = "Show Exam";
$activePage = "show.exam";
require 'up.html.php';
require 'login.control.php';
?>
<?php
if ($_SESSION['role'] != 4) {
    header("location: authorizationcontrol.php");
    die();
}
?>
<?php
require 'db.php';
$id = $_SESSION['id'];
$sql = "SELECT * FROM results WHERE  userid=:userid";
$SORGU = $DB->prepare($sql);
$SORGU->bindParam(':userid', $id);
$SORGU->execute();
$results = $SORGU->fetchAll(PDO::FETCH_ASSOC);
/* echo '<pre>';
print_r($results);
die(); */
?>
<?php
if (count($results) > 0) {
    header("location: authorizationcontrol.php");
    die();
}
?>
<?php
require 'db.php';
$id = $_GET['idExam'];
$sql = "SELECT * FROM exams WHERE  examid=:idExam";
$SORGU = $DB->prepare($sql);
$SORGU->bindParam(':idExam', $id);
$SORGU->execute();
$exams = $SORGU->fetchAll(PDO::FETCH_ASSOC);
/* echo '<pre>';
print_r($exams);
die(); */
//!Sınav bilgilerini al
//?Sınav id
$examid = $exams[0]['examid'];
//!Sınav süresi
$totalExamTime = $exams[0]['examtime'];
//!Chatgpt ile sınav süresini sayaç için dakikaya çevirme
// Dakikaya çevirme işlemi
$totalExamTimeMinute = $totalExamTime * 60; // Saniyeyi dakikaya çeviriyoruz
?>
<?php
require 'db.php';
$id = $_SESSION['id'];
$sql = "SELECT * FROM students WHERE  userid=:id";
$SORGU = $DB->prepare($sql);
$SORGU->bindParam(':id', $id);
$SORGU->execute();
$students = $SORGU->fetchAll(PDO::FETCH_ASSOC);
/* echo '<pre>';
print_r($students);
die(); */
?>
<?php
if ($exams[0]['classname'] != $students[0]['classname']) {
    header("location: authorizationcontrol.php");
    die();
}
?>
<?php require 'navbar.php';?>
<div class="container">
  <div class="row justify-content-end ">
<div class="col-2">
    <p id="sayaç" class="alert alert-danger mt-2 text-center"></p>
  </div>
  </div>
  <div class="row justify-content-center mt-4 ">
  <div class="col-6">
     <!--  Teacharın oluşturduğu sınav bilgileri -->
    <h1 class="alert alert-success mt-2 text-center ">Exam Questions</h1>
  </div>
</div>
<?php
$id = $_GET['idExam'];
$sql = "SELECT * FROM questions WHERE  examid=:idExam";
$SORGU = $DB->prepare($sql);
$SORGU->bindParam(':idExam', $id);
$SORGU->execute();
$questions = $SORGU->fetchAll(PDO::FETCH_ASSOC);
/* echo '<pre>';
print_r($questions);
die(); */
?>
<?php
// Başlangıç sayacı
$questionNumber = 1;
$totalquestions = 0; // Her form gönderiminde sıfırlanır
$totalTrue = 0; // Her form gönderiminde sıfırlanır
$totalFalse = 0; // Her form gönderiminde sıfırlanır
// Form gönderildiğinde işlenecek kod
if (isset($_POST['form_result'])) {
    $userid = $_SESSION['id'];

    foreach ($questions as $question) {

        $soru_id = $question['questionid'];
        $cevap = $_POST["form_answer_$soru_id"]; // Her soru için farklı bir input name'i olacak
        $true_answer = $question['trueanswer'];
        // Kullanıcının cevabını doğru cevapla karşılaştırma
        if ($cevap == $true_answer) {
            $totalTrue++;

        } else {
            $totalFalse++;
        }
        $totalquestions = $totalTrue + $totalFalse;
        if ($totalTrue > $totalFalse) {
            $result = "Passed";
        } else {
            $result = "Failed";
        }
    }
// Insert into Database
    $sql = "INSERT INTO results (examid,userid,totalquestions,totaltrueanswer,totalfalseanswer,result) VALUES (:examid,:userid,:totalquestions,:totaltrue,:totalfalse,:result)";
    $SORGU = $DB->prepare($sql);
    $SORGU->bindParam(':examid', $examid);
    $SORGU->bindParam(':userid', $userid);
    $SORGU->bindParam(':totalquestions', $totalquestions);
    $SORGU->bindParam(':totaltrue', $totalTrue);
    $SORGU->bindParam(':totalfalse', $totalFalse);
    $SORGU->bindParam(':result', $result);
    $SORGU->execute();
    echo '<script>';
    echo 'alert("The Exam Ended Successfully...");';
    echo 'window.location.href = "show.exam.result.php?userid=' . $userid . '";';
    echo '</script>';
}
?>
<?php
//!Soruları listele
foreach ($questions as $question) {
    ?>
  <div class="row justify-content-center g-2 ">
      <div class="col-6">
          <form method="post">
              <P class="alert alert-info "><?php echo $questionNumber ?>) <?php echo $question['questiontitle'] ?></p>
              <?php
// Her radio buton için benzersiz bir id oluştur
    $answerLabelidA = "flexRadioDefault{$question['questionid']}A";
    $answerLabelidB = "flexRadioDefault{$question['questionid']}B";
    $answerLabelidC = "flexRadioDefault{$question['questionid']}C";
    $answerLabelidD = "flexRadioDefault{$question['questionid']}D";
    ?>
              <div class="form-check">
                  <input class="form-check-input" required type="radio" name="form_answer_<?php echo $question['questionid'] ?>" id="<?php echo $answerLabelidA ?>" value="<?php echo $question['answera'] ?>">
                  <label class="form-check-label" for="<?php echo $answerLabelidA ?>">
                      <?php echo $question['answera'] ?>
                  </label>
              </div>
              <div class="form-check">
                  <input class="form-check-input" required type="radio" name="form_answer_<?php echo $question['questionid'] ?>" id="<?php echo $answerLabelidB ?>" value=" <?php echo $question['answerb'] ?>">
                  <label class="form-check-label" for="<?php echo $answerLabelidB ?>">
                      <?php echo $question['answerb'] ?>
                  </label>
              </div>
              <div class="form-check">
                  <input class="form-check-input" required type="radio" name="form_answer_<?php echo $question['questionid'] ?>" id="<?php echo $answerLabelidC ?>" value=" <?php echo $question['answerc'] ?>">
                  <label class="form-check-label" for="<?php echo $answerLabelidC ?>">
                      <?php echo $question['answerc'] ?>
                  </label>
              </div>
              <div class="form-check">
                  <input class="form-check-input" required type="radio" name="form_answer_<?php echo $question['questionid'] ?>" id="<?php echo $answerLabelidD ?>" value=" <?php echo $question['answerd'] ?>">
                  <label class="form-check-label" for="<?php echo $answerLabelidD ?>">
                      <?php echo $question['answerd'] ?>
                  </label>
              </div>
              <!--   Sorular arası çizgi -->
              <hr class="border border-danger border-2 opacity-50">
      </div>
  </div>
  <?php
// Her döngüde soru sayacını artır
    $questionNumber++;
}
?>
</div>
<div class="row justify-content-center ">
<div class="col-2">
<button type="submit" name="form_result" class="btn btn-primary m-4 ">End The Exam <i class="bi bi-skip-end-fill"></i></button>
</div>
</div>
</form>
</div>
<script>
         // Sayacı geriye doğru çalıştıran JavaScript kodu
         var sayi = <?php echo $totalExamTimeMinute; ?>; // PHP'den gelen değeri JavaScript'e aktarıyoruz
        var sayaç = document.getElementById('sayaç');

        function geriyeSay() {
            var dakika = Math.floor(sayi / 60);
            var saniye = sayi % 60;

            sayaç.innerHTML = dakika + " Minute " + saniye + " Seconds Left.";
            sayi--; // Her saniyede bir azalt

            // Eğer sayı 0'dan küçük veya eşitse, sayaçı durdur
            if (sayi < 0) {
                clearInterval(sayaçDurdur);
                sayaç.innerHTML = "Time Is Up!";
                window.location.href = 'time.control.php';
            }
        }

        // Her 1 saniyede bir geriye doğru sayacı güncelleyen fonksiyonu çağır
        var sayaçDurdur = setInterval(geriyeSay, 1000);
    </script>
    <?php require 'footer.php';?>
<?php require 'down.html.php';?>