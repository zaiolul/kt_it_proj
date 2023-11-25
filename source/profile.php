<?php


session_start();
if (empty($_SESSION['prev']) ) {
    header("Location:logout.php");
    exit;
}


include("config.php");
include("functions.php");
if ($_SESSION['prev'] != "chat") {
    $_SESSION['message'] = "";
}
$_SESSION['prev'] = "chat";



$db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

$sender = $_SESSION['user'];
$res = mysqli_query($db, "SELECT id FROM users WHERE username='$sender'");

$res_id = mysqli_fetch_assoc($res);
$id = $res_id['id'];


if (isset($_GET['usr'])) {
    $receiver = $_GET['usr'];
    $usr = $receiver;
    $sql = "SELECT id FROM users WHERE username='$receiver'";
    $res = mysqli_query($db, $sql);
    if (!$res) {
        echo " DB klaida skaitant id: " . $sql . "<br>" . mysqli_error($db);
        exit;
    }
    $res_recv = mysqli_fetch_assoc($res);
    $rid = $res_recv['id'];
} else {
    $usr = $sender;
}




// if ($sender == $receiver) {
//     header("Location: /index.php");
//     exit;
// }


// if (!isset($_GET['usr'])) {
//     header("Location: /index.php");
//     exit;
// }

if ($_POST != null) {
    $content = $_POST['msg'];
    if (!empty($content)) {

        $sql = "INSERT INTO messages (content, user_id, receiver) VALUES('$content', '$id', '$receiver')";
        if (!mysqli_query($db, $sql)) {
            echo " DB klaida iterpiant zinute: " . $sql . "<br>" . mysqli_error($db);
            exit;
        }
    }
    header("Location:profile.php?usr=$receiver");
    exit;
}


?>
<html>

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=9; text/html; charset=utf-8">
    <title>Pokalbis</title>
    <link href="styles.css" rel="stylesheet" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>

<body class="main-bg ">
    <div class="container rounded">

        <div class="row m-4 justify-content-center">
           
            <div class="col bg-light ">
            <div class="row text-center bg-light ">
                <p>Atgal į [<a href="index.php">Pradžia</a>]</p>
                <?php
                if ($usr == $sender)
                    echo "<a href=\"useredit.php\">Redaguoti anketą</a>";
                ?>
                <p style="color:red"><b><?php echo $_SESSION['message']; ?></b></p>
            </div>
                <div class="row mb-4">

                    <?php
                    $sql = "SELECT regdate, region, age, image, description FROM users WHERE username='" . $usr . "'";
                    $query = mysqli_query($db, $sql);
                    if (!$query) {
                        echo " DB klaida ieskant naudotojo: " . $sql . "<br>" . mysqli_error($db);
                        exit;
                    }
                    $result = mysqli_fetch_assoc($query);
                    ?>

                    <div class="col text-center">

                        <h1 class="text-center"><b><?php echo $usr ?></b></h1>
                        <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($result['image']) ?>" width="250" height="250" />

                    </div>
                    <div class="col d-flex align-self-center">

                        <div>
                            <b>Amžius:</b> <?php echo $result['age'] ?> <br>
                            <b>Regionas:</b> <?php echo $result['region'] ?> <br>
                            <b>Prisiregistravo:</b> <?php echo date("Y-m-d", strtotime($result['regdate'])) ?> <br><br>


                            <b>Aprašymas:</b><br>
                            <div class="justify desc">
                                <i> <?php echo $result['description'] ?> </i>
                            </div>
                        </div>


                    </div>
                </div>

            </div>
            <?php
            if (isset($receiver)) {
                include("chatbox.php");


                $query = mysqli_query($db, "SELECT id FROM userviews WHERE username='$sender' and user_id='$rid'");
                if (!$query) {
                    echo " DB klaida ieskant naudotojo: " . $sql . "<br>" . mysqli_error($db);
                    exit;
                }
                $result = mysqli_fetch_assoc($query);
                if (isset($result)) {
                    $view_id = $result['id'];
                    $query = mysqli_query($db, "UPDATE userviews SET viewcount=viewcount+1 WHERE id='$view_id'");
                } else {
                    $query = mysqli_query($db, "INSERT INTO userviews (username, user_id) VALUES('$sender', '$rid')");
                }
            }

            ?>



        </div>

    </div>
    </div>
</body>

</html>