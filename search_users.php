<div class="container">
    <?php
    if (isset($_POST['region_search'])) {
        $_SESSION['region_search'] = $regions[$_POST['region_search']];
    }

    if (isset($_POST['name_search'])) {
        $_SESSION['name_search'] = $_POST['name_search'];
    }
    ?>
    <div class="row bg-light mb-6 justify-content-center">
        <div class="col-12 text-center">
            <b>Portalo naudotojų paieška</b>
        </div>
        <form method="POST">

            <div class="row m-4 justify-content-center">
                <div class="col-4">
                    <div class="form-floating mb-3">
                        <input class="form-control" name="name_search" type="text" id="name_search" />
                        <label for="name_search">Vardas</label>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-floating mb-3">
                        <select class="form-select" name="region_search" id="region_search">

                            <?php
                            echo "<option value=\"0\">" . "Visos" . "</option>";
                            for ($i = 1; $i < count($regions); $i++) {
                                echo "<option value=\"" . ($i) . "\">$regions[$i]</option>";
                            }
                            ?>

                        </select>
                        <label for="region_search">Apskritis</label>
                    </div>
                </div>
                <div class="col-2 text-center">
                    <input type='submit' value='Ieškoti' class="btn btn-primary">
                </div>


        </form>
    </div>

    <!-- <?php
            echo "TEST: " . $_SESSION['name_search'] . $_SESSION['region_search'];
            ?> -->

    <div class="row m-4 justify-content-center">
        <div class="col-6">
            <div class="container userlist bg-light">
                <table class="table text-center">
                    <thead>
                        <?php

                        $db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
                        $sql = "SELECT username, age, region, image FROM " . USERS . " WHERE visible='1'";

                        if (isset($_SESSION['region_search'])) {
                            if ($_SESSION['region_search'])
                                $sql = $sql . " and region='" . $_SESSION['region_search'] . "'";
                        }
                        if (isset($_SESSION['name_search'])) {
                            $sql = $sql . "and username LIKE '%" . $_SESSION['name_search'] . "%'";
                        }
                        $res = mysqli_query($db, $sql);
                        if (!$res) {
                            echo " DB klaida ieškant naudotojų: " . $sql . "<br>" . mysqli_error($db);
                            exit;
                        }
                        $arr = array();
                        while ($row = mysqli_fetch_assoc($res)) {
                            if ($row['username'] == $_SESSION['user'])
                                continue;
                            array_push($arr, array($row['image'], $row['username'], $row['age'], $row['region']));
                        }

                        $_SESSION['read_users'] = $arr;

                        if (count($arr)) {
                            echo "<tr><td></td><td>Vardas</td><td>Amžius</td><td>Regionas</td><td>Anketa</td></tr>";
                        } else {
                            echo "<tr><td colspan=\"5\">Nerasta naudotojų.</td></tr>";
                        }
                        ?>

                    </thead>
                    <tbody>
                        <?php
                        // header("Location:index.php");
                        // exit;

                        if (isset($_SESSION['read_users'])) {
                            $rows = $_SESSION['read_users'];
                            foreach ($_SESSION['read_users'] as $key => $value) {
                        ?>
                                <tr>
                                    <td>
                                        <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($value[0]) ?>" width="30" height="30" />
                                    </td>
                                    <td>
                                        <?php echo $value[1] ?>
                                    </td>
                                    <td>
                                        <?php echo $value[2] ?>
                                    </td>
                                    <td>
                                        <?php echo $value[3] ?>
                                    </td>
                                    <td>
                                        <a href="profile.php/?usr=<?php echo $value[1] ?>" class="btn btn-primary">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                                                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                                                <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1" />
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                        <?php
                            }
                        }
                        ?>

                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>