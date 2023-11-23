<?php
// register.php registracijos forma
// jei pats registruojasi rolė = DEFAULT_LEVEL, jei registruoja ADMIN_LEVEL vartotojas, rolę parenka
// Kaip atsiranda vartotojas: nustatymuose $uregister=
//                                         self - pats registruojasi, admin - tik ADMIN_LEVEL, both - abu atvejai galimi
// formos laukus tikrins procregister.php

session_start();
if (empty($_SESSION['prev'])) {
    header("Location: logout.php");
    exit;
} // registracija galima kai nera userio arba adminas
// kitaip kai sesija expirinasi blogai, laikykim, kad prev vistik visada nustatoma
include("config.php");
include("functions.php");
if ($_SESSION['prev'] != "procregister")  inisession("part");  // pradinis bandymas registruoti

$_SESSION['prev'] = "register";
?>
<html>

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=9; text/html; charset=utf-8">
    <title>Registracija</title>
    <link href="styles.css" rel="stylesheet" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>

<body class="main-bg">
    <div class="container">
        <form action="register_func.php" method="POST">
            <div class="row m-4 justify-content-center">
                <div class="col-4 bg-light text-center">

                    <div class="row m-4 justify-content-center bg-light">
                   
                        <p style="font-size:18pt;"><b>Registracija</b></p>
                        <p>Atgal į [<a href="index.php">Pradžia</a>]</p>
                    </div>

                    <div class="form-group">
                        <div class="form-floating mb-3">
                            <input class="form-control" name="email" type="text" id="email" value="<?php echo $_SESSION['mail_login']; ?>" />
                            <label for="email">E-paštas</label>
                            <?php echo $_SESSION['mail_error']; ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-floating mb-3">
                            <input type="text" name="name" class="form-control" id="name" value="<?php echo $_SESSION['name_login'];  ?>" />
                            <label for="name">Vartotojo vardas</label>
                            <?php echo $_SESSION['name_error']; ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-floating mb-3">
                            <input class="form-control" name="pass" type="password" value="<?php echo $_SESSION['pass_login']; ?>" />
                            <label for="pass">Slaptažodis</label>
                            <?php echo $_SESSION['pass_error']; ?>
                        </div>

                    </div>
                  

                    <div class="row m-4">
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
                                <input class="form-control" name="age" type="text" value="<?php echo $_SESSION['age_reg']; ?>" />
                                <label for="age">Metai</label>
                                <?php echo $_SESSION['age_error']; ?>
                            </div>
                        </div>
                    </div>
                    <?php

                    if ($_SESSION['ulevel'] == $user_roles[ADMIN_LEVEL]) {
                        echo "<p style=\"text-align:left;\">Rolė<br>";
                        echo "<select class=\"form-select\" name=\"role\">";
                        foreach ($user_roles as $x => $x_value) {
                            echo "<option ";
                            if ($x == DEFAULT_LEVEL) echo "selected ";
                            echo "value=\"" . $x_value . "\" ";
                            echo ">" . $x . "</option></p>";
                        }
                    }
                    ?>

                    <div class="row m-4">
                        <input type='submit' value='Registruoti' class="btn btn-primary">
                    </div>
        </form>

    </div>
    </div>

    </div>

</body>

</html>