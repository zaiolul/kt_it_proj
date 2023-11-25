<?php

session_start();

if (!isset($_SESSION['prev']) || ($_SESSION['prev'] != "create_event" && $_SESSION['prev'] != "index")) {
    header("Location:logout.php");
    exit;
}
include("config.php");
include("functions.php");
if ($_SESSION['ulevel'] != $user_roles[MOD_LEVEL]) {
    header("Location:index.php");
    exit;
}


if (!isset($_POST['update'])) {
    header("Location:index.php");
    exit;
}


$_SESSION['prev'] = "create_event_func";
$_SESSION['message'] = "";
$_SESSION['title_error'] = "";
$_SESSION['title_event'] = $_POST['title'];
$_SESSION['short_error'] = "";
$_SESSION['short_event'] = $_POST['short'];
$_SESSION['desc_error'] = "";
$_SESSION['desc_event'] = $_POST['description'];
$_SESSION['date_error'] = "";
$_SESSION['date_event'] = strtotime($_POST['data']);
$_SESSION['loc_error'] = "";
$_SESSION['loc_event'] = $_POST['loc'];
$_SESSION['limit_error'] = "";
$_SESSION['limit_event'] = $_POST['limit'];

$title = $_POST['title'];
$short = $_POST['short'];
$desc = $_POST['description'];
$date = $_POST['data'];
$loc = $_POST['loc'];
$limit = $_POST['limit'];
$update = $_POST['update'];

$title_check = checktext($title, 5, 25, 'title_error');
$short_check = checktext($short, 5, 50, 'short_error');
$loc_check = checktext($loc, 5, 20, 'loc_error');
$desc_check = checktext($desc, 20, 250, 'desc_error');
$date_check = validdate(strtotime($date));
$limit_check = checknum($limit, 5, 1000);
$changed = false;



$db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);



if (!empty($update)) {
    $result = mysqli_query($db, "SELECT * FROM events WHERE id='$update'");

    if (!$result) {
        echo "DB klaida " . mysqli_error($db);
        exit;
    }

    $arr = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $arr = array("id" => $row['id'], "title" => $row['title'], "description" => $row['description'], "short" => $row['short_description'], "count" => $row['reg_count'], "limit" => $row['reg_limit'], "start" => $row['start_date'], "loc" => $row['location']);
    }

    $id = $arr['id'];
    if ($title_check && $date_check && $desc_check  && $loc_check &&  $short_check && $limit_check) {

        if ($arr['title'] != $title || $arr['short'] != $short || $arr['loc'] != $loc || $arr['date'] != $date || $arr['desc'] != $desc && $arr['limit'] != $limit) {


            if (!mysqli_query($db, "UPDATE events SET short_description='$short', description='$desc', title='$title', start_date='$date', location='$loc', reg_limit='$limit' WHERE id='$id'")) {
                echo " DB klaida keiciant info: " . $sql . "<br>" . mysqli_error($db);
                $_SESSION['message'] = "sprogo";
                exit;
            }

            $changed = true;
            $_SESSION['message'] = "Informacija pakeista";
        }
    }

    if ($changed) {
        $_SESSION['message'] = "Renginio duomenys atnaujinti.";
    } else {
        $_SESSION['message'] = "Renginio duomenys nekeisti.";
    }
    header("Location:create_event.php?update=$update");
    exit;
} else {
    if ($title_check && $date_check && $desc_check  && $loc_check &&  $short_check && $limit_check) {
        if (!mysqli_query($db, "INSERT INTO events (title, short_description, description, reg_limit, start_date, location) VALUES('$title', '$short', '$desc', '$limit', '$date', '$loc')")) {
            echo " DB klaida keiciant info: <br>" . mysqli_error($db);
            $_SESSION['message'] = "sprogo";
            exit;
        }
        $id = mysqli_insert_id($db);
        header("Location:event_page.php?event=$id");
        exit;
    }
}

header("Location:create_event.php?update=$update");
exit;
