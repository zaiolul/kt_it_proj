<?php
// meniu.php  rodomas meniu pagal vartotojo rolę


$user = $_SESSION['user'];
$userlevel = $_SESSION['ulevel'];
$role = "";
foreach ($user_roles as $x => $x_value) {
    if ($x_value == $userlevel) $role = $x;
}
?>

<div class="container  bg-light text-dark">
    <div class="row mb-10 justify-content-between">
        <div class="col-4">
            <div class="row mb-4 mt-4 justify-content-center">
                <div class="col-6 text-center">
                    <?php
                    $db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
                    $result = $db->query("SELECT image FROM users WHERE username='$user'");
                    $row = $result->fetch_assoc();
                    ?>

                    <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['image']) ?>" width="150" height="150" />

                </div>
                <div class="col-6">
                    <div class="row  justify-content-left">
                        <?php echo "<p><b>Vardas</b>: " . $user . "</p>" ?>
                        <?php echo "<p><b>Rolė: </b>" . $role . "</p>" ?>

                        <a href="profile.php">Anketa</a> <br>
                        <a href="logout.php">Atsijungti</a>
                        <?php
                        if ($role == ADMIN_LEVEL) {
                            echo "<a href=\"admin.php\">Administratoriaus sąsaja</a>";
                        }
                        ?>
                    </div>

                </div>

            </div>

        </div>

        <div class="col-8 text-center">
            <div class="row mb- mt-4 justify-content-center">
                <b>
                    <p style="font-size:18px"> Pažinčių portalas</p>
                </b>
                <b>
                    <p style="font-size:18px"> Ernestas Sabaliauskas IFK-1</p>
                </b>
            </div>
            <form method="GET" action="set_tab.php">
                <?php
                if ($_SESSION['current'] == "main") {
                    echo "<button class=\"btn btn-primary\" type=\"submit\">Renginiai</a> <br>";
                } else {
                    echo "<button class=\"btn btn-primary\" type=\"submit\">Anketos</a> <br>";
                }
                echo "</button>";

                echo $_SESSION['prev']."----";
                ?>


            </form>
            
           
            <?php
            if ($role == MOD_LEVEL && $_SESSION['current'] == "event" )
                echo "<a href=\"create_event.php?update=\">Kurti renginį</a>";
            ?>
        </div>

    </div>

</div>