<?php
// the message
$db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
$id = $_SESSION['id'];
$mail = $_SESSION['email'];
$result = mysqli_query($db, "SELECT * FROM userviews WHERE user_id='$id'");
$msg = "Jūsų profilį peržiūrejo šie naudotojai:\n";
while($row = mysqli_fetch_assoc($result)){
    $msg = $msg.$row['username'].", ".$row['viewcount']." kart.\n";
}

// use wordwrap() if lines are longer than 70 characters
$msg = wordwrap($msg,100);

// send email
mail($mail,"Anketos peržiūros",$msg);

?>