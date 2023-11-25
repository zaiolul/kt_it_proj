<?php
// index.php
// jei vartotojas prisijungęs rodomas demonstracinis meniu pagal jo rolę
// jei neprisijungęs - prisijungimo forma per include("login.php");
// toje formoje daugiau galimybių...

session_start();
include("functions.php");
?>
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>IT projektas</title>
    <link href="styles.css" rel="stylesheet" type="text/css">

    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>

<body class="main-bg">
    <?php
    
   
    
    if (!empty($_SESSION['user']))
    {                                  
       
        if (!isset($_SESSION)) {
            header("Location: logout.php");
            exit;
        }
        include("config.php");

        inisession("part");   //   pavalom prisijungimo etapo kintamuosius
        $_SESSION['prev'] = "index";
        
        include("menu.php"); //įterpiamas meniu pagal vartotojo rolę
    ?>
       
    <?php
        echo "<br>";
        if($_SESSION['current'] == "main")
            include("search_users.php");
        else if($_SESSION['current'] == "event")
            include("events.php");
        
    } else {
        if (!isset($_SESSION['prev'])) inisession("full");             
        else {
            if ($_SESSION['prev'] != "proclogin") inisession("part"); 
        }
        // jei ankstesnis puslapis perdavė $_SESSION['message']
        // echo "<div align=\"center\">";
        // echo "<font size=\"4\" color=\"#ff0000\">" . $_SESSION['message'] . "<br></font>";

        // echo "<table class=\"center\"><tr><td>";

        include("login.php");                    // prisijungimo forma
        // echo "</td></tr></table></div><br>";
    }
    ?>
    </div>
</body>

</html>