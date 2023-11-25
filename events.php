<?php
$db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

$result = mysqli_query($db, "SELECT * FROM events");
if (!$result) {
    echo "DB klaida " . mysqli_error($db);
    exit;
}
$arr = array();
while ($row = mysqli_fetch_assoc($result)) {
    array_push($arr, array($row['id'], $row['title'], $row['description'], $row['short_description'], $row['reg_count'], $row['reg_limit'], $row['start_date']));
}


$userid = $_SESSION['id'];

$result = mysqli_query($db, "SELECT event_id FROM user_events WHERE user_id='$userid'");
if (!$result) {
    echo "DB klaida " . mysqli_error($db);
    exit;
}

$reg_arr = array();
while ($row = mysqli_fetch_assoc($result)) {
    $reg_arr[$row['event_id']] = true;
}


?>

<div class="container rounded">
    <div class="row bg-light m-6 p-3 justify-content-center round">
        <div class="col-12 text-center round">
            <h1>Renginiai</h1>

            <table class="table text-start event-table">
                <thead>

                    <?php
                    if (count($arr)) {
                        echo "<tr class=\"main-bg\"><th>Pavadinimas</th><th colspan=3>Trumpas aprašymas</th><th>Data</th><th>Vietos</th></tr>";
                    } else {
                        echo "<tr class=\"main-bg\"><th>Nerasta renginių.</th></tr>";
                    }
                    ?>
                </thead>
                <tbody>
                    <?php
                    if (count($arr)) {
                        foreach ($arr as $key => $value) {
                    ?>
                            <tr>
                                <td>
                                    <?php echo $value[1] ?>
                                </td>
                                <td colspan=3>
                                    <?php echo $value[3] ?>
                                </td>
                                <td>
                                    <?php echo date("Y-m-d", strtotime($value[6])) ?>
                                </td>
                                <td>

                                    <?php
                                    echo "<a href=\"event_page.php/?event=$value[0]\"";

                                    if ($value[4] == $value[5] || isset($reg_arr[$value[0]])) {
                                        echo " class=\"btn btn-secondary\">";
                                    } else
                                        echo " class=\"btn btn-primary\" type=\"submit\">";
                                    ?>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-box-arrow-right">
                                        <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z" />
                                        <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z" />
                                    </svg>



                                    <?php
                                   
                                    echo "$value[4]/$value[5] </a>   ";

                                    if (isset($reg_arr[$value[0]])) {
                                        ?>
                                            <b><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="green" class="bi bi-check2" viewBox="0 0 16 16">
                                                <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z" />
                                            </svg></b>
                                        <?php
                                        }
                                    ?>
                                    

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