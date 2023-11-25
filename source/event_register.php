<?php
session_start();
include("config.php");


if(!isset($_POST['event']) && !isset($_POST['registered'])){
    header("Location:index.php");
    exit;
}

$eventid = $_POST['event'];

$userid = $_SESSION['id'];
$db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

if(empty($_POST['registered']))
{
    $result = mysqli_query($db, "INSERT INTO user_events (user_id, event_id) VALUES('$userid', '$eventid')");
    if (!$result) {
        echo "DB klaida " . mysqli_error($db);
        exit;
    }

    $result = mysqli_query($db, "UPDATE events SET reg_count=reg_count+1 WHERE id='$eventid'");
    if (!$result) {
        echo "DB klaida " . mysqli_error($db);
        exit;
    }
} else{

    $result = mysqli_query($db, "DELETE FROM user_events WHERE event_id='$eventid' and user_id='$userid'");
    if (!$result) {
        echo "DB klaida " . mysqli_error($db);
        exit;
    }

    $result = mysqli_query($db, "UPDATE events SET reg_count=reg_count-1 WHERE id='$eventid'");
    if (!$result) {
        echo "DB klaida " . mysqli_error($db);
        exit;
    }
}




header("Location:event_page.php?event=$eventid");
exit;

?>