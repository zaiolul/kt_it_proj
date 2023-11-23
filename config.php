<?php
define("DB_SERVER", "localhost");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "it_proj");
define("USERS", "users");
define("MESSAGES", "messages");
$user_roles=array(     
	"Administratorius"=>"2",
	"Moderatorius"=>"1",
	"Narys"=>"0",
	);
$regions = array("","Alytaus", "Kauno", "Klaipėdos", "Marijampolės", "Panevėžio", "Šiaulių", "Tauragės", "Telšių", "Utenos", "Vilniaus");
define("MIN_AGE", 16);
define("DEFAULT_LEVEL","Narys");  // kokia rolė priskiriama kai registruojasi
define("ADMIN_LEVEL","Administratorius");  // kas turi vartotojų valdymo teisę
define("MOD_LEVEL","Moderatorius");  // kas turi vartotojų valdymo teisę

define("UZBLOKUOTAS","255");      // vartotojas negali prisijungti kol administratorius nepakeis rolės
$uregister="self";  // kaip registruojami vartotojai
// self - pats registruojasi, admin - tik ADMIN_LEVEL, both - abu atvejai
// * Email Constants - 
// define("EMAIL_FROM_NAME", "Demo");
// define("EMAIL_FROM_ADDR", "demo@ktu.lt");
// define("EMAIL_WELCOME", false);
