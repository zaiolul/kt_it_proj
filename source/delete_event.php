<?php

session_start();
include("config.php");
// sesijos kontrole
if (!isset($_SESSION['prev']) ) {
    header("Location:/logout.php");
    exit;
}
if($_SESSION['ulevel'] != $user_roles[MOD_LEVEL]){
    header("Location:/index.php");
    exit;
}

if(empty($_GET['event'])){
    header("Location:/index.php");
    exit;
}
$db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

$eventid = $_GET['event'];
if (!mysqli_query($db, "DELETE FROM user_events WHERE event_id='$eventid'")) {
    echo " DB klaida keiciant info: " . $sql . "<br>" . mysqli_error($db);
    exit;
}

if (!mysqli_query($db, "DELETE FROM events WHERE id='$eventid'")) {
    echo " DB klaida keiciant info: " . $sql . "<br>" . mysqli_error($db);
    exit;
}

header("Location:/index.php");
exit;
?>