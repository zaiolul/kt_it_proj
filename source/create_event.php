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

if ($_SESSION['prev'] == "index" || $_SESSION['prev'] == "event_page") {
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
    $_SESSION['limit_error'] = "";
    $_SESSION['limit_event'] = "";
    // pav
    // short desc
    // desc
    // data

}
$_SESSION['prev'] = "create_event";
if (!isset($_GET['update'])) {
    header("Location:/index.php");
    exit;
}

$update = $_GET['update'];
$delete="";

if($update){
    
    $db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

    $result = mysqli_query($db, "SELECT * FROM events WHERE id='$update'");
    $arr = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $arr = array("id" => $row['id'], "title" => $row['title'], "description" => $row['description'], "short" => $row['short_description'], "count" => $row['reg_count'], "limit" => $row['reg_limit'], "start" => $row['start_date'], "loc" => $row['location']);
    }

    $_SESSION['title_event'] = $arr['title'];

    $_SESSION['short_event'] = $arr['short'];

    $_SESSION['desc_event'] = $arr['description'];

    $_SESSION['date_event'] = $arr['start'];

    $_SESSION['loc_event'] = $arr['loc'];
    $_SESSION['limit_event'] = $arr['limit'];
}
?>
<html>

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=9; text/html; charset=utf-8">
    <title>Paskyros</title>
    <link href="styles.css" rel="stylesheet" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>

<body class="main-bg">
    <div class="container">



        <div class="row m-4  justify-content-center">
            <div class="col-6  bg-light text-center">

                <div class="row m-4 ">
                    <?php
                    if (empty($update)) {
                        echo "<p><b>Renginio kūrimas</b><br>";
                    } else echo "<p><b>Renginio redagavimas</b><br>"
                    ?>
                   
                        Atgal į [<a href="/index.php">Pradžia</a>]</p>

                </div>

                <div class="row m-4 text-warning justify-content-center">
                    <b><?php echo $_SESSION['message']; ?></b>
                </div>
                <form action="/create_event_func.php" method="POST" class="justify-content-center">
                    <input name="update" type="hidden" value="<?php echo $update ?>" />
                    <div class="row mb-4 justify-content-center">
                        <div class="col-6">

                            <div class="form-group">
                                <div class="form-floating mb-3">
                                    <input type="text" name="title" class="form-control" id="title" value="<?php echo $_SESSION['title_event'];  ?>" />
                                    <label for="title">Pavadinimas</label>
                                    <?php echo $_SESSION['title_error']; ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <div class="form-floating mb-3">
                                    <input type="date" name="data" class="form-control" id="data" value="<?php echo $_SESSION['date_event'];  ?>" />
                                    <label for="data">Data</label>
                                    <?php echo $_SESSION['date_error']; ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-floating mb-3">
                                <input type="text" name="loc" class="form-control" id="loc" value="<?php echo $_SESSION['loc_event'];  ?>" />
                                <label for="loc">Vieta</label>
                                <?php echo $_SESSION['loc_error']; ?>
                            </div>

                        </div>
                        <div class="form-group">
                            <div class="form-floating mb-3">
                                <input type="text" name="limit" class="form-control" id="limit" value="<?php echo $_SESSION['limit_event'];  ?>" />
                                <label for="limit">Maksimalus kiekis registracijų</label>
                                <?php echo $_SESSION['limit_error']; ?>
                            </div>

                        </div>

                        <div class="form-group">
                            <div class="form-floating mb-3">
                                <input type="text" name="short" class="form-control" id="short" value="<?php echo $_SESSION['short_event'];  ?>" />
                                <label for="short">Trumpas aprašymas</label>
                                <?php echo $_SESSION['short_error']; ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-floating mb-4">
                                <textarea class="form-control" style="max-height: 150px; height: 100px;" name="description" id="description" wrap="soft"><?php echo $_SESSION['desc_event']; ?></textarea>
                                <label for="description">Pagrindinis aprašymas</label>
                                <?php echo $_SESSION['desc_error']; ?>
                            </div>
                        </div>


                    </div>

                    <div class="row m-4">

                        <input type='submit' value="<?php echo empty($update) ? "Kurti" : "Atnaujinti" ?>" class="btn btn-primary">
                      
                    </div>
                    <div class="row m-4 justify-content-center">
                        <div class="col">
                      <?php
                            if(!empty($update)){
                            echo "<a href=\"/delete_event.php/?event=$update\" class=\"btn btn-danger btn-block\">Šalinti</a> ";  
                            }
                        ?>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>

</body>

</html>