<?php
// useredit.php 
// vartotojas gali pasikeisti slaptažodį ar email
// formos reikšmes tikrins procuseredit.php. Esant klaidų pakartotinai rodant formą rodomos ir klaidos

session_start();
include("config.php");
// sesijos kontrole
if (!isset($_SESSION['prev']) || (($_SESSION['prev'] != "index") && ($_SESSION['prev'] != "procuseredit")  && ($_SESSION['prev'] != "useredit") && ($_SESSION['prev'] != "chat"))) {
    header("Location: logout.php");
    exit;
}
if ($_SESSION['prev'] == "index" || $_SESSION['prev'] == "chat") {
    $_SESSION['mail_login'] = $_SESSION['email'];
    $_SESSION['reg_reg'] = $_SESSION['region'];
    $_SESSION['age_reg'] = $_SESSION['age'];
    $_SESSION['desc_reg'] = $_SESSION['description'];
    $_SESSION['passn_error'] = "";
    $_SESSION['passn_login'] = "";
    $_SESSION['reg_error'] = "";
    $_SESSION['age_error'] = "";
    $_SESSION['mail_error'] = "";
    $_SESSION['message'] = "";
    $_SESSION['sreg_reg'] = $_SESSION['sreg'];
    $_SESSION['visible_up'] = $_SESSION['visible'];
}
$_SESSION['prev'] = "useredit";
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
        <form action="useredit_func.php" method="POST" class="justify-content-center" enctype="multipart/form-data">


            <div class="row m-4 justify-content-center">
                <div class="col-8 bg-light text-center">

                    <div class="row m-4 bg-light">
                        <p><b>Paskyros redagavimas</b><br>
                            Atgal į [<a href="profile.php">Anketa</a>]</p>

                    </div>
                    <div class="row m-4">
                        <b>Naudotojas: <?php echo $_SESSION['user'];  ?></b>
                    </div>
                    <div class="row m-4 text-warning justify-content-center">
                        <b><?php echo $_SESSION['message']; ?></b>
                    </div>
                    <div class="row mb-4 justify-content-between">
                        <div class="col-4">
                            <b>
                                <p>Paskyros informacija</p>
                            </b>
                            <div class="form-group">
                                <div class="form-floating mb-3">
                                    <input type="password" name="pass" class="form-control" id="pass" value="<?php echo $_SESSION['pass_login'];  ?>" />
                                    <label for="pass">Dabartinis slaptažodis</label>
                                    <?php echo $_SESSION['pass_error']; ?>
                                </div>
                            </div>


                            <div class="form-group">
                                <div class="form-floating mb-3">
                                    <input type="password" name="passn" class="form-control" id="passn" value="<?php echo $_SESSION['passn_login'];  ?>" />
                                    <label for="passn">Naujas slaptažodis</label>
                                    <?php echo $_SESSION['passn_error']; ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-8 md-4">
                            <b>
                                <p>Anketos informacija</p>
                            </b>
                            <div class="form-group">
                                <div class="form-floating mb-3">
                                    <input class="form-control" name="email" type="text" id="email" value="<?php echo $_SESSION['mail_login']; ?>" />
                                    <label for="email">E-paštas</label>
                                    <?php echo $_SESSION['mail_error']; ?>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-6">
                                    <div class="form-floating">
                                        <select class="form-select" name="region" id="region">

                                            <?php
                                            echo "<option value=\"0\">" . $_SESSION['reg_reg'] . "</option>";
                                            for ($i = 1; $i < count($regions); $i++) {
                                                echo "<option value=\"" . ($i) . "\">$regions[$i]</option>";
                                            }
                                            ?>

                                        </select>
                                        <label for="region">Apskritis</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-floating mb-3">
                                        <input class="form-control" name="age" type="text" id="age" value="<?php echo $_SESSION['age_reg']; ?>" />
                                        <label for="age">Metai</label>
                                        <?php echo $_SESSION['age_error']; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row   justify-content-center text-center">
                                <div class="form-group">
                                    <div class="form-floating mb-4">
                                        <textarea class="form-control" style="max-height: 150px; height: 100px;" name="description" id="description" wrap="soft"><?php echo $_SESSION['desc_reg']; ?></textarea>
                                        <label for="description">Aprašymas</label>
                                        <?php echo $_SESSION['desc_error']; ?>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <input type="file" name="image" id="image" class="form-control">
                                    <label class="form-label" for="image">Profilio nuotrauka</label>
                                </div>

                                <div class="col">
                                    <div class="form-check text-start">
                                        <input class="form-check-input" type="checkbox" value="on" id="vis" name="vis" <?php echo ($_SESSION['visible_up']  == 1 ? "checked" : "") ?> />
                                        <label class="form-check-label" for="vis">Matomas kitiems</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <b>
                                    <p>Anketų paieška</p>
                                </b>
                                <div class="form-group">
                                    <div class="form-floating">
                                        <select class="form-select" name="sreg" id="sreg">

                                            <?php
                                            echo "<option selected=\"0\">" . $_SESSION['sreg_reg'] . "</option>";
                                            for ($i = 0; $i < count($regions); $i++) {
                                                echo "<option value=\"" . ($i) . "\">$regions[$i]</option>";
                                            }
                                            ?>

                                        </select>
                                        <label for="sreg">Rodomų anketų apskritis</label>
                                    </div>
                                </div>
                            </div>


                        </div>

                    </div>

                </div>
                <div class="row m-4">

                    <input type='submit' value='Atnaujinti' class="btn btn-primary">
                </div>
            </div>
    </div>
    </form>
    </div>

</body>

</html>