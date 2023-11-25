<?php
session_start();
include("config.php");
include("functions.php");
// cia sesijos kontrole
if (!isset($_SESSION['prev']) || ($_SESSION['ulevel'] != $user_roles[ADMIN_LEVEL])) {
    header("Location: logout.php");
    exit;
}
$_SESSION['prev'] = "admin";

$db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

if ($_POST != null) {

    $sql = "SELECT username, ulevel, email "
    . "FROM " . USERS . " ORDER BY ulevel DESC,username";
    $_SESSION['message']="Pakeitimai atlikti.";
    $result = mysqli_query($db, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $level = $row['ulevel'];
        $user = $row['username'];
        $nlevel = $_POST['role_' . $user];
        $remove = (isset($_POST['naikinti_' . $user]));
        if ($remove || ($nlevel != $level)) {

            if ($remove) {
                $sql = "DELETE FROM " . USERS . "  WHERE  username='$user'";
                if (!mysqli_query($db, $sql)) {
                    echo " DB klaida šalinant vartotoją: " . $sql . "<br>" . mysqli_error($db);
                    exit;
                }
            } else {
                $sql = "UPDATE " . USERS . " SET ulevel='$nlevel' WHERE  username='$user'";
                if (!mysqli_query($db, $sql)) {
                    echo " DB klaida keičiant vartotojo įgaliojimus: " . $sql . "<br>" . mysqli_error($db);
                    exit;
                }
            }
        }

    }
    
    header("Location:/admin.php");
    exit;
}
?>

<html>

<head>

    <meta content="IE=9; text/html; charset=utf-8">
    <title>Administratoriaus langas</title>
    <link href="/styles.css" rel="stylesheet" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>

</head>

<body class="main-bg">
    <div class="container">

       
        <div class="row m-4 justify-content-center">

            <div class="col-6 bg-light">
                <div class="row m-4 text-center bg-light">
                    <p>Naudotojų redagavimas</p>
                    <p>Atgal į [<a href="/index.php">Pradžia</a>]</p>
                    <p style="color:red"><b><?php echo $_SESSION['message']; ?></b></p>
                </div>
                <form name="users" method="post">

                    <?php 
                    $sql = "SELECT username, ulevel, email,image "
                        . "FROM " . USERS . " ORDER BY ulevel DESC,username";
                    $result = mysqli_query($db, $sql);
                    if (!$result || (mysqli_num_rows($result) < 1)) {
                        echo "Klaida skaitant lentelę users";
                        exit;
                    }
                    ?>
                    <table class="table text-center">
                        <thead>
                            <td><b>Vartotojo vardas</b></td>
                            <td><b>Rolė</b></td>
                            <td><b>E-paštas</b></td>
                            <td><b>Šalinti</b></td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($row = mysqli_fetch_assoc($result)) {
                                $level = $row['ulevel'];
                                $user = $row['username'];
                                $email = $row['email'];
                                // $image = $row['image'];

                                echo "<tr><td>" . $user . "</td><td>";
                                echo "<select name=\"role_" . $user . "\">";
                                $yra = false;
                                foreach ($user_roles as $x => $x_value) {
                                    echo "<option ";
                                    if ($x_value == $level) {
                                        $yra = true;
                                        echo "selected ";
                                    }
                                    echo "value=\"" . $x_value . "\" ";
                                    echo ">" . $x . "</option>";
                                }
                                if (!$yra) {
                                    echo "<option selected value=" . $level . ">Neegzistuoja=" . $level . "</option>";
                                }
                                $UZBLOKUOTAS = UZBLOKUOTAS;
                                echo "<option ";
                                if ($level == UZBLOKUOTAS) echo "selected ";
                                echo "value=" . $UZBLOKUOTAS . " ";
                                echo ">Užblokuotas</option>";   
                                echo "</select></td>";

                                echo "<td>" . $email . "</td>";
                                echo "<td><input type=\"checkbox\" name=\"naikinti_" . $user . "\"> </td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                    <div class="row m-4 justify-content-center">
                        <input type="submit" value="Vykdyti" class="btn btn-primary">
                    </div>
                </form>
            </div>
</body>

</html>