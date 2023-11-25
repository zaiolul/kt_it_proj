<?php
// procregister.php tikrina registracijos reikšmes
// įvedimo laukų reikšmes issaugo $_SESSION['xxxx_login'], xxxx-name, pass, mail
// jei randa klaidų jas sužymi $_SESSION['xxxx_error']
// jei vardas, slaptažodis ir email tinka, įraso naują vartotoja į DB, nukreipia į index.php
// po klaidų- vel į register.php 

session_start();
// cia sesijos kontrole
if (!isset($_SESSION['prev']) || ($_SESSION['prev'] != "register")) {
    header("Location: logout.php");
    exit;
}

include("config.php");
include("functions.php");



$_SESSION['name_error'] = "";
$_SESSION['pass_error'] = "";
$_SESSION['mail_error'] = "";
$user = $_POST['name'];
$_SESSION['name_login'] = $user;
$pass = $_POST['pass'];
$_SESSION['pass_login'] = $pass;
$mail = $_POST['email'];
$_SESSION['mail_login'] = $mail;
$_SESSION['prev'] = "procregister";

$reg = $_POST['region'];
$_SESSION['reg_error'] = "";

$_SESSION['reg_reg'] = $regions[$reg];

$age = $_POST['age'];
$_SESSION['age_error'] = "";
$_SESSION['age_reg'] = $age;
$imageName = "./stock_profile.jpg";

if (checkname($user)) {

    list($dbuname) = checkname($user);
    if ($dbuname) {
        $_SESSION['name_error'] =
            "<font size=\"2\" color=\"#ff0000\">* Tokiu vardu jau yra registruotas vartotojas</font>";
    } else {
        $_SESSION['name_error'] = "";
        if (validatepassword($pass, substr(hash('sha256', $pass), 5, 32), 'pass_error') && checkmail($mail) && checkage($age) && checkregion($reg)) {
          
            $pass = substr(hash('sha256', $pass), 5, 32);
            if ($_SESSION['ulevel'] == $user_roles[ADMIN_LEVEL]) $ulevel = $_POST['role'];
            else $ulevel = $user_roles[DEFAULT_LEVEL];

            $imgContent = addslashes(file_get_contents($imageName));

            $db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
            $sql = "INSERT INTO users (username, password, email, region, age, ulevel, image)
          VALUES ('$user', '$pass', '$mail', '$regions[$reg]', '$age','$ulevel', '$imgContent')";

            if (mysqli_query($db, $sql)) {
                $_SESSION['message'] = "Registracija sėkminga";
            } else {
                $_SESSION['message'] = "DB registracijos klaida:" . $sql . "<br>" . mysqli_error($db);
            }
            

            if ($_SESSION['ulevel'] == $user_roles[ADMIN_LEVEL]) {
                header("Location:admin.php");
            } else {
                header("Location:index.php");
            }
            
            exit;
        }
    }
}
// griztam taisyti
// session_regenerate_id(true);
header("Location:register.php");
exit;
