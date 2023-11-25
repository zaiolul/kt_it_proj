<?php

session_start();

if($_SESSION['current'] == "event")
    $_SESSION['current'] = "main";
else  $_SESSION['current'] = "event";
header("Location:index.php");
exit;
?>