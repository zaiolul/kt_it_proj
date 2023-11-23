<?php

session_start();

if (!isset($_SESSION['prev']) || ($_SESSION['prev'] != "useredit"))
{ header("Location: logout.php");exit;}

include("config.php");
include("functions.php");
$_SESSION['prev'] = "procuseredit";
$_SESSION['pass_error'] = "";
$_SESSION['mail_error'] = "";
$_SESSION['passn_error'] = "";
$_SESSION['desc_error'] = "";

$user = $_SESSION['user'];
$pass = $_POST['pass'];
$_SESSION['pass_login'] = $pass;    
$passn = $_POST['passn'];
$_SESSION['passn_login'] = $passn;   
$mail = $_POST['email'];
$_SESSION['mail_login'] = $mail;

if(isset($_POST['vis'])){
    $visible = 1;
    $_SESSION['visible_up'] = true;
}else{ $visible = 0;
    $_SESSION['visible_up'] = false;
}

$_SESSION['reg_error'] = "";
$reg_p = $_POST['region'];
$age = $_POST['age'];
$_SESSION['age_error'] = "";
$_SESSION['age_reg'] = $age;
$desc = $_POST['description'];
$_SESSION['desc_reg'] = $desc;
$_SESSION['message'] = "";

list(,, $dbpass, $dbmail,, $dbregion, $dbage,,,$dbvisible,$dbdesc) = checkname($user);

if (!$dbpass) {
    echo " DB klaida nuskaitant slaptazodi vartotojui " . $user;
    exit;
}

if($reg_p == 0){
    $_SESSION['reg_reg'] = $dbregion;
    $reg = array_search($dbregion, $regions);
}  else{
    $_SESSION['reg_reg'] = $regions[$reg_p];
    $reg = $reg_p;
} 

$change = false;

$allowTypes = array('jpg','png','jpeg','gif'); 

$db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

if ($pass || $passn) {
    $check_pw_old = validatepassword($pass, $dbpass, 'pass_error');
    $check_pw_new = validatepassword($passn, substr(hash('sha256', $passn), 5, 32), 'passn_error');
    if ($check_pw_old) {  // senas slaptazodis ivestas geras  
        if ($check_pw_new)  // lauku reiksmes geros
        {
            if ($pass != $passn)   // vartotojas kazka keicia
            {
                $dbpass = substr(hash('sha256', $passn), 5, 32);
                $sql = "UPDATE " . USERS . " SET password='$dbpass'  WHERE  username='$user'";
                if (!mysqli_query($db, $sql)) {
                    echo " DB klaida keiciant slaptazodi: " . $sql . "<br>" . mysqli_error($db);
                    exit;
                }
                $changed = true;
            }
            else{
                $_SESSION['passn_error'] =  "<font size=\"2\" color=\"#ff0000\">* Dabartinis ir naujas slaptažodžiai sutampa</font>";
            }
            // $_SESSION['user'] = "";
            //    session_regenerate_id(true);
            // header("Location:index.php");
            // exit;
           
            // $_SESSION['pass_error'] = "";
        }  // yra kazkokiu klaidu, jos liecia ne galiojanti, o nauja slaptazodi, perrasom

      

        // jei neteisingas galiojantis, nieko daugiau netikrinom 
      
    }
}
$imgContent = "";
if(!empty($_FILES["image"]["name"])) { 
    $fileName = basename($_FILES["image"]["name"]);
    $fileType = pathinfo($fileName, PATHINFO_EXTENSION); 
    if(in_array($fileType, $allowTypes)){ 
        $_SESSION['message'] =  $_SESSION['message'] ."GALIMA DET";
        $image = $_FILES['image']['tmp_name']; 
        $imgContent = addslashes(file_get_contents($image)); 

        $sql = "UPDATE " . USERS . " SET image='$imgContent' WHERE  username='$user'";
        if (!mysqli_query($db, $sql)) {
            echo " DB klaida keiciant nuotrauka: " . $sql . "<br>" . mysqli_error($db);
            exit;
        }
        $changed = true;
    }
}

$mail_check =checkmail($mail) ;
$age_check = checkage($age);
$region_check = checkregion($reg); 
$desc_check = checkdescription($desc);
if ($age_check && $region_check && $mail_check  && $desc_check &&  !$passwords_change  ) {
        
    if($mail != $dbmail || $regions[$reg] != $dbregion || $age != $dbage || $visible != $dbvisible || $desc != $dbdesc) {
        $temp = isset($_POST['vis']);
        $sql = "UPDATE " . USERS . " SET email='$mail', region='$regions[$reg]', age='$age', visible=$visible, description='$desc' WHERE  username='$user'";
        if (!mysqli_query($db, $sql)) {
            echo " DB klaida keiciant info: " . $sql . "<br>" . mysqli_error($db);
            exit;
        }

         $changed = true;
        $_SESSION['message'] = "Informacija pakeista";
        $_SESSION['visible'] = $visible;
    }
  
    // header("Location:index.php");
} 

if ($changed) {
    $_SESSION['message'] = "Paskyros duomenys atnaujinti.";
} else{
    $_SESSION['message'] = "Paskyros duomenys nekeisti.";
}

// // taisyti
// $_SESSION['message'] = "$reg; $reg_p";

// session_regenerate_id(true);
header("Location:useredit.php");
exit;
