<?php


session_start();
if (empty($_SESSION['prev'])) {
    header("Location: logout.php");
    exit;
}


include("config.php");
include("functions.php");
if ($_SESSION['prev'] != "event_page") {
    $_SESSION['message'] = "";
}
$_SESSION['prev'] = "event_page";


if (!isset($_GET['event'])) {
    header("Location:index.php");
    exit;
}
$eventid = $_GET['event'];
$userid = $_SESSION['id'];

$userlevel = $_SESSION['ulevel'];
$role = "";
foreach ($user_roles as $x => $x_value) {
    if ($x_value == $userlevel) $role = $x_value;
}

$db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

$result = mysqli_query($db, "SELECT * FROM events WHERE id='$eventid'");
if (!$result) {
    echo "DB klaida " . mysqli_error($db);
    exit;
}

$arr = array();
while ($row = mysqli_fetch_assoc($result)) {
    $arr = array("id" => $row['id'], "title" => $row['title'], "description" => $row['description'], "short" => $row['short_description'], "count" => $row['reg_count'],
     "limit" => $row['reg_limit'],"start" => $row['start_date'], "loc" => $row['location']);
}




$result = mysqli_query($db, "SELECT * FROM user_events WHERE user_id='$userid' and event_id='$eventid'");
if (!$result) {
    echo "DB klaida " . mysqli_error($db);
    exit;
}

$test = 0;
if ($test = mysqli_fetch_assoc($result))
    $registered =  true;
else $registered = false;


if(strtotime(date("Y-m-d")) > strtotime($arr['start'])  && $role != $user_roles["Moderatorius"] && !$registered){
    header("Location:index.php");
    exit;
}
?>
<html>

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=9; text/html; charset=utf-8">
    <title>Pokalbis</title>
    <link href="/styles.css" rel="stylesheet" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>

<body class="main-bg ">
    <div class="container rounded">

        <div class="row m-4 justify-content-center">

            <div class="col-8 bg-light ">
                <div class="text-center">
                <p >Atgal į [<a href="/index.php">Pradžia</a>]</p>
             
                <?php 
                   if ($role == $user_roles["Moderatorius"] )
                   echo "<a href=\"/create_event.php/?update=$eventid\">Redaguoti renginį</a>";
                ?>
                </div>
                <div class="row m-4 justify-content-center">
                    <div class="col text-center">
                        <h1> <?php echo $arr["title"] ?></h1>
                    </div>
                    <div class="col text-center align-self-center">
                        <form method="POST" action="/event_register.php">
                            <input type="hidden" name="registered" value="<?php echo $registered ?>"/> 
                            <?php
                            echo "<button type=\"submit\" name=\"event\" value=\"$eventid\"";
                            if(strtotime(date("Y-m-d")) > strtotime($arr['start'])){
                                echo " class=\"btn btn-secondary btn-block\" disabled> Renginys pasibaigė ";
                            }
                            else if ($arr["count"] == $arr["limit"] || $registered) {
                                echo " class=\"btn btn-secondary btn-block\"";
                                if($registered){
                                    echo ">Atšaukti registraciją ";
                                 
                                }else  echo "disabled>Nėra vietų ";
                            
                           
                            }else
                                echo " class=\"btn btn-primary btn-block\" > Registruotis ";

                            echo $arr["count"] . "/" . $arr["limit"] . "</button>";
                
                            ?>
                        </form>
                    </div>
                </div>
                <div class="row m-4 justify-content-start">
                   
                        <p><b>Pradžia:</b> <?php echo $arr['start']; ?> </p>
                       
                        <p><b>Vieta:</b> <?php echo $arr['loc']; ?> </p>
                        <p><b>Aprašymas:</b><br>
                        <div class="desc-event sec-bg"> <?php echo $arr['description'];?> </div>
                   
                </div>
            </div>





        </div>

    </div>
    </div>
</body>

</html>