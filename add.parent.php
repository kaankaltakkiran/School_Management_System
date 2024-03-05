<?php
@session_start();
require_once 'db.php';
$id = $_SESSION['id'];
$SORGU = $DB->prepare("SELECT * FROM students WHERE addedunitid = :id ORDER BY userid DESC LIMIT 1");
$SORGU->bindParam(':id', $id);
$SORGU->execute();
$students = $SORGU->fetchAll(PDO::FETCH_ASSOC);
/* echo '<pre>';
print_r($students);
die(); */
//!Son eklenen öğrencinin idsi
$lastStudentId = $students[0]['userid'];
?>

<?php
//! Veri tabanına öğrenci ekleme
if (isset($_POST['add_parent']) && isset($_FILES['form_parentImage'])) {
    //!Hata mesajlarını göstermek için boş bir dizi
    $errors = array();
    require_once 'db.php';
    //!htmlspecialchars() kullanıcıdan alınan veriyi güvenli hale getirir
    //! eğer kullanıcı zararlı bir kod gönderirse bunu html etiketlerine dönüştürür
    $parentName = htmlspecialchars($_POST['form_parentName']);
    $parentEmail = htmlspecialchars($_POST['form_parentEmail']);
    $parentGender = $_POST['form_parentGender'];
    $parentAddress = htmlspecialchars($_POST['form_parentAdress']);
    $parentPhoneNumber = htmlspecialchars($_POST['form_parentPhonenumber']);
    $parentBirthDate = $_POST['form_parentBirthdate'];
    $addedUnitid = $_SESSION['id'];
    $addedUnitName = $_SESSION['userName'];

    $parentRePassword = $_POST['form_parentRepassword'];
    $parentPassword = ($_POST['form_parentPassword']);
/*  Şifrele hashleme */
    $parentPassword = password_hash($parentPassword, PASSWORD_DEFAULT);

    //!Resim yükleme
    $img_name = $_FILES['form_parentImage']['name'];
    $img_size = $_FILES['form_parentImage']['size'];
    $tmp_name = $_FILES['form_parentImage']['tmp_name'];
    $error = $_FILES['form_parentImage']['error'];
    // Hata kontrolü
    $errors = array();

    //?Kullanıcı var mı yok mu kontrol etme
    $sql = "SELECT * FROM parents WHERE useremail = :form_parentEmail";
    $SORGU = $DB->prepare($sql);
    $SORGU->bindParam(':form_parentEmail', $parentEmail);
    $SORGU->execute();
    $isUser = $SORGU->fetch(PDO::FETCH_ASSOC);
    /*  echo '<pre>';
    print_r($isUser);
    die(); */
    //!Eğer kullanıcı üye olmuşsa  hata ver
    if ($isUser) {
        $errors[] = "This email is already registered !";

        //!Eğer kullanıcı yoksa kaydet
    } else if ($_POST['form_parentRepassword'] != $_POST['form_parentPassword']) {
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
                $img_upload_path = 'parent_images/' . $new_img_name;
                move_uploaded_file($tmp_name, $img_upload_path);

                // Insert into Database
                $sql = "INSERT INTO parents(username,useremail,usergender,useraddress,phonenumber,studentid,birthdate,userpassword,userimg,addedunitid,addedunitname) VALUES (:form_parentName,:form_parentEmail,:form_parentGender,:form_parentAdress,:form_parentPhonenumber,:studentid,:form_parentBirthdate,'$parentPassword','$new_img_name',:unitid,:unitname)";
                $SORGU = $DB->prepare($sql);
                $SORGU->bindParam(':form_parentName', $parentName);
                $SORGU->bindParam(':form_parentEmail', $parentEmail);
                $SORGU->bindParam(':form_parentGender', $parentGender);
                $SORGU->bindParam(':form_parentAdress', $parentAddress);
                $SORGU->bindParam(':form_parentPhonenumber', $parentPhoneNumber);
                $SORGU->bindParam(':studentid', $lastStudentId);
                $SORGU->bindParam(':form_parentBirthdate', $parentBirthDate);
                $SORGU->bindParam(':unitid', $addedUnitid);
                $SORGU->bindParam(':unitname', $addedUnitName);
                $SORGU->execute();
                $approves[] = "Parent User Added Successfully...";
            } else {
                $errors[] = "You can't upload files of this type !";
            }
        }
    } else {
        /*     $errors[] = "unknown error occurred!"; */
        $errors[] = "Image Not Selected !";
    }

}
