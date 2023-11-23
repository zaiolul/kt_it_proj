<?php
session_start();

include("config.php");
include("functions.php");

if (isset($_GET['region'])) {
    $_SESSION['region'] = $regions[$_GET['region']];
}
if (isset($_GET['name'])) {
    $_SESSION['name'] = $_GET['name'];
 }
 
if(isset($_SESSION['read_users'])){
    echo "SET";
} else echo "NOT SET";
                
$region= $_SESSION['region'];
$name = $_SESSION['name'];
$db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
$sql = "SELECT username, age, region, image FROM " . USERS;

if($region){
    $sql = $sql." WHERE region='$region'";
}
if($name){
    $sql = $sql."and username LIKE '%".$name."%'";
}

$res = mysqli_query($db, $sql);
if (!$res) {
    echo " DB klaida ieškant naudotojų: " . $sql . "<br>" . mysqli_error($db);
    exit;
}
$arr = array();
while ($row = mysqli_fetch_assoc($res)) {
    array_push($arr, array($row['image'], $row['username'], $row['age'], $row['region']));
}

$_SESSION['read_users'] = $arr;
header("Location:index.php");
exit;
?>