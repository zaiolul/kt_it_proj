<?php

// funkcijos  include/functions.php



function inisession($arg)
{   //valom sesijos kintamuosius

    if ($arg == "full") {

        $_SESSION['message'] = "";

        $_SESSION['user'] = "";

        $_SESSION['ulevel'] = 0;

        $_SESSION['userid'] = 0;

        $_SESSION['email'] = 0;
        $_SESSION['description'] = "";
        $_SESSION['current'] = "main";
    }

    $_SESSION['name_login'] = "";

    $_SESSION['pass_login'] = "";

    $_SESSION['mail_login'] = "";
    $_SESSION['visible_up'] = false;
    $_SESSION['name_error'] = "";

    $_SESSION['pass_error'] = "";

    $_SESSION['mail_error'] = "";
    $_SESSION['age_error'] = "";

    $_SESSION['reg_reg'] = "Pasirinkti...";
    $_SESSION['age_reg'] = "";

    $_SESSION['reg_error'] = "";
    $_SESSION['age_error'] = "";
    $_SESSION['desc_error'] = "";
    $_SESSION['desc_reg'] = "";
    unset( $_SESSION['read_users']);
    $_SESSION['region_search'] = "";
    $_SESSION['name_search'] = "";
    $_SESSION['message'] = "";


    $_SESSION['title_error'] = "";
    $_SESSION['title_event'] = "";
    $_SESSION['short_error'] = "";
    $_SESSION['short_event'] = "";
    $_SESSION['desc_error'] = "";
    $_SESSION['desc_event'] = "";
    $_SESSION['date_error'] = "";
    $_SESSION['date_event'] = "";
    $_SESSION['loc_error'] = "";
    $_SESSION['loc_event'] = "";
    $_SESSION['limit_event'] = "";
    $_SESSION['limit_error'] = "";
}



function validatename($username)
{   // Vartotojo vardo sintakse

    if (!$username || strlen($username = trim($username)) == 0) {
        $_SESSION['name_error'] =

            "<font size=\"2\" color=\"#ff0000\">* Neįvestas vartotojo vardas</font>";

        "";

        return false;
    } elseif (!preg_match("/^([0-9a-zA-Z])*$/", $username))  /* Check if username is not alphanumeric */ {
        $_SESSION['name_error'] =

            "<font size=\"2\" color=\"#ff0000\">* Vartotojo vardas gali būti sudarytas<br>

				&nbsp;&nbsp;tik iš raidžių ir skaičių</font>";

        return false;
    } else return true;
}



function validatepassword($pwd, $dbpwd, $text)
{     //  slaptazodzio tikrinimas (tik demo: min 4 raides ir/ar skaiciai) ir ar sutampa su DB esanciu

    if (!$pwd || strlen($pwd = trim($pwd)) == 0) {
        $_SESSION[$text] =

            "<font size=\"2\" color=\"#ff0000\">* Neįvestas slaptažodis</font>";

        return false;
    } elseif (!preg_match("/^([0-9a-zA-Z])*$/", $pwd))  /* Check if $pass is not alphanumeric */ {
        $_SESSION['pass_error'] = "* Slaptažodis gali būti sudarytas<br>&nbsp;&nbsp;tik iš raidžių ir skaičių";

        return false;
    } elseif (strlen($pwd) < 4)  // per trumpas

    {
        $_SESSION[$text] =

            "<font size=\"2\" color=\"#ff0000\">* Slaptažodžio ilgis <4 simbolius</font>";

        return false;
    } elseif ($dbpwd != substr(hash('sha256', $pwd), 5, 32)) {
        $_SESSION[$text] =

            "<font size=\"2\" color=\"#ff0000\">* Neteisingas slaptažodis</font>";

        return false;
    } else return true;
}



function checkname($username)
{  // iesko DB pagal varda, grazina {vardas,slaptazodis,lygis,id} ir nustato name_error

    $db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

    $sql = "SELECT * FROM " . USERS . " WHERE username = '$username'";

    $result = mysqli_query($db, $sql);

    $uname = $upass = $ulevel = $uid = $email = $regdate = $age = $image = $visible = $region =  null;

    if (!$result || (mysqli_num_rows($result) != 1))   // jei >1 tai DB vardas kartojasi, netikrinu, imu pirma

    {  // neradom vartotojo DB

        $_SESSION['name_error'] =

            "<font size=\"2\" color=\"#ff0000\">* Tokio vartotojo nėra</font>";
    } else {  //vardas yra DB

        $row = mysqli_fetch_assoc($result);

        $uname = $row["username"];
        $upass = $row["password"];

        $ulevel = $row["ulevel"];
        $uid = $row["id"];
        $email = $row["email"];
        $regdate = $row["regdate"];
        $visible = $row["visible"];
        $image = $row["image"];
        $age = $row["age"];
        $region = $row["region"];
        $desc = $row["description"];
    }

    return array($uid, $uname, $upass, $email, $regdate, $region, $age, $ulevel, $image, $visible, $desc);
}



function checkmail($mail)
{   // e-mail sintax error checking  

    if (!$mail || strlen($mail = trim($mail)) == 0) {
        $_SESSION['mail_error'] =

            "<font size=\"2\" color=\"#ff0000\">* Neįvestas e-pašto adresas</font>";

        return false;
    } elseif (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['mail_error'] =

            "<font size=\"2\" color=\"#ff0000\">* Neteisingas e-pašto adreso formatas</font>";

        return false;
    } else return true;
}


function checkage($age)
{
    if(!$age || intval($age) < MIN_AGE){
        $_SESSION['age_error'] =
            "<font size=\"2\" color=\"#ff0000\">* Minimalus amžius 16 metų.</font>";
        return false;
    }
    return true;
}

function checkregion($reg)
{
    if(!$reg || intval($reg) == 0){
        $_SESSION['reg_error'] =
            "<font size=\"2\" color=\"#ff0000\">* Pasirinkite apskritį</font>";
        return false;
    }
    return true;
}

function checkdescription($desc, $limit){
    // hardcoded idc
    if(!$desc){
        $_SESSION['desc_error'] =
        "<font size=\"2\" color=\"#ff0000\">* Laukas negali būti tuščias</font>";
    return false;
    }
    else if(strlen($desc) > $limit){ 
        $_SESSION['desc_error'] =
            "<font size=\"2\" color=\"#ff0000\">* Maksimalus simbolių kiekis $limit</font>";
        return false;
    }
    return true;
}


function checktext($text, $min, $max, $err_var){
    if(!$text || empty($text)){
        $_SESSION[$err_var] =
        "<font size=\"2\" color=\"#ff0000\">* Laukas negali būti tuščias</font>";
    return false;
    }
    else if(strlen($text) > $max){ 
        $_SESSION[$err_var] = "<font size=\"2\" color=\"#ff0000\">* Maksimalus simbolių kiekis $max</font>";
        return false;
    } else if(strlen($text) < $min){ 
        $_SESSION[$err_var] = "<font size=\"2\" color=\"#ff0000\">* Minimalus simbolių kiekis $min</font>";
        return false;
    }
    return true;
}


function validdate($ts){
    if(!$ts){
        $_SESSION['date_error'] = "<font size=\"2\" color=\"#ff0000\">* Pasirinkite datą</font>";
    }
    else if($ts <= strtotime(date("Y/m/d"))){
        $_SESSION['date_error'] = "<font size=\"2\" color=\"#ff0000\">* Data negali būti senesnė nei šiandiena</font>";
        return false;
    }
        
    return true;
}



function checknum($num,$min, $max)
{
    if(!$num){
        $_SESSION['limit_error'] =
        "<font size=\"2\" color=\"#ff0000\">* Laukas negali būti tuščias</font>";
    }
    else if(!intval($num)){
        $_SESSION['limit_error'] =
        "<font size=\"2\" color=\"#ff0000\">* Galimi tik skaičiai.</font>";
    }
    else if(intval($num) < $min ){
        $_SESSION['limit_error'] =
            "<font size=\"2\" color=\"#ff0000\">* Minimalus skaičius $min.</font>";
        return false;
    } else if(intval($num) > $max){
        $_SESSION['limit_error'] =
        "<font size=\"2\" color=\"#ff0000\">* Maksimalus skaičius $min.</font>";
    return false;
    }
    return true;
}
