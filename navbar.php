<?php
@session_start();
?>
<nav class="navbar navbar-expand-lg bg-primary " data-bs-theme="dark">
  <div class="container-fluid ">
    <a class="navbar-brand " href="index.php">School Management System</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
    <ul class="navbar-nav">
    <?php if ($_SESSION['isLogin'] == 1 && $_SESSION['role'] == 1) {?>
      <li class="nav-item">
          <a class="nav-link  <?=($activePage == 'index') ? 'active' : '';?>" href="index.php">Home</a>
        </li>
    <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle <?=($activePage == 'add.admin' || $activePage == 'admin.list' || $activePage == 'view.admin' || $activePage == 'admin.update') ? 'active' : '';?>" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Admin
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item <?=($activePage == 'add.admin') ? 'active' : '';?>" href="add.admin.php">Add Admin User</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item <?=($activePage == 'admin.list') ? 'active' : '';?>" href="list.admin.php">List Admin User</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle <?=($activePage == 'register.unit.add' || $activePage == 'register.unit.list' || $activePage == 'view.register.unit' || $activePage == 'update.register.unit') ? 'active' : '';?>" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          Register Unit
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item <?=($activePage == 'register.unit.add') ? 'active' : '';?>" href="add.register.unit.php">Add Register Unit
 User</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item <?=($activePage == 'register.unit.list') ? 'active' : '';?>" href="list.register.unit.php">List Register Unit
 User</a></li>
          </ul>
        </li>
        <?php }?>
        <?php if ($_SESSION['isLogin'] == 1 && $_SESSION['role'] == 3) {?>
      <li class="nav-item">
          <a class="nav-link  <?=($activePage == 'index') ? 'active' : '';?>" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link  <?=($activePage == 'teacher.class.list') ? 'active' : '';?>" href="list.teacher.class.php">Student's Class</a>
        </li>
        <li class="nav-item">
        <a class="nav-link  <?=($activePage == 'parent.list' || $activePage == 'update.parent' || $activePage == 'show.parent') ? 'active' : '';?>" href="list.parent.php">Parent</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle <?=($activePage == 'add.exam' || $activePage == 'list.exam' || $activePage == 'update.exam' || $activePage == 'teacher.exam.result') ? 'active' : '';?>" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          Exams
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item <?=($activePage == 'add.exam') ? 'active' : '';?>" href="add.exam.php">Add Exam </a></li>
            <li><a class="dropdown-item <?=($activePage == 'list.exam') ? 'active' : '';?>" href="list.exam.php">Exam List</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item <?=($activePage == 'teacher.exam.result') ? 'active' : '';?>" href="teacher.exam.result.php">Exam Result</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle <?=($activePage == 'send.announcement' || $activePage == 'list.announcement' || $activePage == 'announcement.update') ? 'active' : '';?>" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          Announcement
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item <?=($activePage == 'send.announcement') ? 'active' : '';?>" href="add.announcement.php">Send  Announcement</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item <?=($activePage == 'list.announcement') ? 'active' : '';?>" href="list.announcement.php">List  Announcement</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link  <?=($activePage == 'food.list') ? 'active' : '';?>" href="list.food.php">Food Menu</a>
        </li>
        <?php }?>
        <?php if ($_SESSION['isLogin'] == 1 && $_SESSION['role'] == 4) {?>
      <li class="nav-item">
          <a class="nav-link  <?=($activePage == 'index') ? 'active' : '';?>" href="index.php">Home</a>
        </li>
        <?php
require 'db.php';
    $id = $_SESSION['id'];
    $sql = "SELECT * FROM results WHERE  userid=:id";
    $SORGU = $DB->prepare($sql);
    $SORGU->bindParam(':id', $id);
    $SORGU->execute();
    $results = $SORGU->fetchAll(PDO::FETCH_ASSOC);
/* echo '<pre>';
print_r($results);
die(); */
    ?>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle <?=($activePage == 'list.student.exams' || $activePage == 'show.exam.result') ? 'active' : '';?>" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          Exams
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item <?=($activePage == 'list.student.exams') ? 'active' : '';?>" href="list.student.exams.php">Exam List</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item <?=($activePage == 'show.exam.result') ? 'active' : '';?>" href="show.exam.result.php?userid=<?php echo $results[0]['userid'] ?>">Exam Result</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link  <?=($activePage == 'list.announcement') ? 'active' : '';?>" href="list.announcement.php">Annoucement</a>
        </li>
        <li class="nav-item">
          <a class="nav-link  <?=($activePage == 'food.list') ? 'active' : '';?>" href="list.food.php">Food Menu</a>
        </li>
        <?php }?>
    <?php if ($_SESSION['isLogin'] == 1 && $_SESSION['role'] == 2) {?>
      <li class="nav-item">
          <a class="nav-link  <?=($activePage == 'index') ? 'active' : '';?>" href="index.php">Home</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle <?=($activePage == 'add.teacher' || $activePage == 'teacher.list' || $activePage == 'student.lesson.list' || $activePage == 'teacher.update') ? 'active' : '';?>" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Teacher
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item <?=($activePage == 'add.teacher') ? 'active' : '';?>" href="add.teacher.php">Add Teacher User</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item <?=($activePage == 'teacher.list') ? 'active' : '';?>" href="list.teacher.php">List Teacher User</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle <?=($activePage == 'add.student' || $activePage == 'student.list' || $activePage == 'class.student.list' || $activePage == 'view.student' || $activePage == 'student.update') ? 'active' : '';?>" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Student
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item <?=($activePage == 'add.student') ? 'active' : '';?>" href="add.student.php">Add Student User</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item <?=($activePage == 'student.list') ? 'active' : '';?>" href="list.student.php">List Student User</a></li>
          </ul>
        </li>
        <li class="nav-item">
        <a class="nav-link  <?=($activePage == 'parent.list' || $activePage == 'update.parent' || $activePage == 'show.parent') ? 'active' : '';?>" href="list.parent.php">Parent</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle <?=($activePage == 'add.class' || $activePage == 'class.list' || $activePage == 'class.update') ? 'active' : '';?>" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Class
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item <?=($activePage == 'add.class') ? 'active' : '';?>" href="add.class.php">Add Class</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item <?=($activePage == 'class.list') ? 'active' : '';?>" href="list.class.php">List Class</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle <?=($activePage == 'add.lesson' || $activePage == 'lesson.list' || $activePage == 'lesson.update') ? 'active' : '';?>" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Lesson
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item <?=($activePage == 'add.lesson') ? 'active' : '';?>" href="add.lesson.php">Add Lesson</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item <?=($activePage == 'lesson.list') ? 'active' : '';?>" href="list.lessons.php">List Lesson</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle <?=($activePage == 'send.announcement' || $activePage == 'list.announcement' || $activePage == 'announcement.update') ? 'active' : '';?>" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          Announcement
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item <?=($activePage == 'send.announcement') ? 'active' : '';?>" href="add.announcement.php">Send  Announcement</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item <?=($activePage == 'list.announcement') ? 'active' : '';?>" href="list.announcement.php">List  Announcement</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle <?=($activePage == 'add.information' || $activePage == 'information.list' || $activePage == 'update.information') ? 'active' : '';?>" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Information
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item <?=($activePage == 'add.information') ? 'active' : '';?>" href="add.information.php">Add Information</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item <?=($activePage == 'information.list') ? 'active' : '';?>" href="list.information.php">List Information</a></li>
          </ul>
        </li>
            <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle <?=($activePage == 'add.food' || $activePage == 'food.list' || $activePage == 'food.update') ? 'active' : '';?>" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Food
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item <?=($activePage == 'add.food') ? 'active' : '';?>" href="add.food.php">Add Food</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item <?=($activePage == 'food.list') ? 'active' : '';?>" href="list.food.php">List Information</a></li>
          </ul>
        </li>
        <?php }?>
      </ul>
    </div>

    <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
      <ul class="navbar-nav">
      <?php if ($_SESSION['isLogin'] == 1) {?>
        <?php
require 'db.php';
    $imageFolder = '';
    if ($_SESSION['role'] == 1) {
        $SORGU = $DB->prepare("SELECT * FROM admins WHERE userid = :idUser");
        $imageFolder = 'admin_images';
    } else if ($_SESSION['role'] == 2) {
        $SORGU = $DB->prepare("SELECT * FROM registerunits WHERE userid = :idUser");
        $imageFolder = 'register_unit_images';
    } else if ($_SESSION['role'] == 3) {
        $SORGU = $DB->prepare("SELECT * FROM teachers WHERE userid = :idUser");
        $imageFolder = 'teacher_images';
    } else if ($_SESSION['role'] == 4) {
        $SORGU = $DB->prepare("SELECT * FROM students WHERE userid = :idUser");
        $imageFolder = 'student_images';
    } else if ($_SESSION['role'] == 5) {
        $SORGU = $DB->prepare("SELECT * FROM parents WHERE userid = :idUser");
        $imageFolder = 'parent_images';
    }
    $SORGU->bindParam(':idUser', $_SESSION['id']);
    $SORGU->execute();
    $users = $SORGU->fetchAll(PDO::FETCH_ASSOC);
    $users = $users[0];
    //! Kullanıcı resim dosyası
    $_SESSION['imageFolderName'] = $imageFolder;
    ?>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="" role="button" data-bs-toggle="dropdown" aria-expanded="false">
<span class="badge rounded-pill text-bg-danger">Welcome! <?=$users['username']?></span>
          <img src='<?php echo "$imageFolder/{$users['userimg']}"; ?>' class='rounded-circle' height="30" width='30'>
          </a>
          <ul class="dropdown-menu  dropdown-menu-end">
          <?php if ($_SESSION['role'] == 3 || $_SESSION['role'] == 4 || $_SESSION['role'] == 5) {?>
            <li><a class="dropdown-item <?=($activePage == 'user.profile') ? 'active' : '';?> " href="show.user.profile.php">Profile <i class="bi bi-person-circle"></i></a></li>
            <?php }?>
            <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#exampleModal">Change Password <i class="bi bi-arrow-repeat"></i></a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="logout.php">Logout <i class="bi bi-box-arrow-right"></i></a></li>
          </ul>
        </li>
        <?php }?>
        <?php if ($_SESSION['isLogin'] == 0) {?>
        <li class="nav-item">
          <a class="nav-link  <?=($activePage == 'login') ? 'active' : '';?>" href="login.php">Login</a>
        </li>
          <?php }?>
      </ul>
    </div>
  </div>
</nav>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Change Password</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form method="POST">
<div class="input-group mb-3 inputGroup-sizing-default">
  <input type="password" name="form_oldpassword" class="form-control" id="reoldPassword" placeholder="Write Old Password">
  <span class="input-group-text bg-transparent"><i id="retoggleOldPassword" class="bi bi-eye-slash"></i></span>
</div>
<div class="input-group mb-3 inputGroup-sizing-default">
  <input type="password" name="form_repassword" class="form-control" id="reoldRePassword" placeholder="Write Again Old Password">
  <span class="input-group-text bg-transparent"><i id="retoggleOldRePassword" class="bi bi-eye-slash"></i></span>
</div>
<div class="input-group mb-3 inputGroup-sizing-default">
  <input type="password"  name="form_newpassword" class="form-control" id="renewRePassword" placeholder="Write New Password">
  <span class="input-group-text bg-transparent"><i id="retoggleNewRePassword" class="bi bi-eye-slash"></i></span>
</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Close <i class="bi bi-x-circle"></i></button>
        <button type="submit" name="form_submit" class="btn btn-outline-success">Change Password <i class="bi bi-arrow-repeat"></i> </button>
      </div>
      </form>
    </div>
  </div>
</div>
<?php
//!form_email post edilmişse
if (isset($_POST['form_submit'])) {
    $errors = array();
    require 'db.php';
    //! Post edilen verileri değişkenlere atama
    $oldPassword = $_POST['form_oldpassword'];
    $olRePassword = $_POST['form_repassword'];
    $newPassword = $_POST['form_newpassword'];

    // Form gönderildi
    // 1.DB'na bağlan
    // 2.SQL hazırla ve çalıştır
    // 3.Gelen sonuç 1 satırsa GİRİŞ BAŞARILI değilse, BAŞARISIZ
    //! Eğer boş alan varsa uyarı mesajı
    if (empty($_POST["form_oldpassword"]) || empty($_POST["form_newpassword"])) {
        $errors[] = "Both Fields are required !";
    } else if ($_POST['form_oldpassword'] != $_POST['form_repassword']) {
        $errors[] = "Passwords Do Not Match!";
    }
    //! Boş alan yoksa
    else {
        //! SQL hazırlama ve çalıştırma
        //! formdan gelen email ile db de varsa
        $id = $_SESSION['id'];
        if ($_SESSION['role'] == 1) {
            $sql = "SELECT * FROM admins WHERE userid = :id";
        } else if ($_SESSION['role'] == 2) {
            $sql = "SELECT * FROM registerunits WHERE userid = :id";
        } else if ($_SESSION['role'] == 3) {
            $sql = "SELECT * FROM teachers WHERE userid = :id";
        } else if ($_SESSION['role'] == 4) {
            $sql = "SELECT * FROM students WHERE userid = :id";
        }
        $SORGU = $DB->prepare($sql);
        $SORGU->bindParam(':id', $id);
        $SORGU->execute();
        $CEVAP = $SORGU->fetchAll(PDO::FETCH_ASSOC);

        /*    var_dump($CEVAP);
        echo "Gelen cevap " . count($CEVAP) . " adet satırdan oluşuyor";
        die(); */
        //! Gelen sonuç 1 satırsa db de kullanıcı var olduğunu anlarız
        if (count($CEVAP) == 1) {
            //! Kullanıcının şifresini doğrulama
            //? posttan gelen ile db den gelen karşılaştırma
            //? password_verify() fonksiyonu ile
            $hashedOldPassword = $CEVAP[0]['userpassword'];
            if (password_verify($oldPassword, $hashedOldPassword)) {
                //return true;
                $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                $id = $_SESSION['id'];
                if ($_SESSION['role'] == 1) {
                    $sql = "UPDATE admins SET userpassword	 = '$hashedNewPassword',lastupdate = CURRENT_TIMESTAMP() WHERE userid = :id";
                } else if ($_SESSION['role'] == 2) {
                    $sql = "UPDATE registerunits SET userpassword	 = '$hashedNewPassword',lastupdate = CURRENT_TIMESTAMP() WHERE userid = :id";
                } else if ($_SESSION['role'] == 3) {
                    $sql = "UPDATE teachers SET userpassword	 = '$hashedNewPassword',lastupdate = CURRENT_TIMESTAMP() WHERE userid = :id";
                } else if ($_SESSION['role'] == 4) {
                    $sql = "UPDATE students SET userpassword	 = '$hashedNewPassword',lastupdate = CURRENT_TIMESTAMP() WHERE userid = :id";
                }
                $SORGU = $DB->prepare($sql);
                $SORGU->bindParam(':id', $id);
                $SORGU->execute();
                $approves[] = "Password Changed Successfully...";
            } else {
                //return false;
                //!Şifreler Eşleşmiyorsa
                $errors[] = "INCORRECT Email OR PASSWORD MATCH!...";

            }
        } else {
            //! Kullanıcı yoksa
            $errors[] = "There Is No Such User !.";
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