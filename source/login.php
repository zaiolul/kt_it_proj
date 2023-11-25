<?php

if (!isset($_SESSION)) {
    header("Location: logout.php");
    exit;
}

if(!isset($_SESSION['prev'])){
    $_SESSION['message'] ="";
}else if($_SESSION['prev'] == "login" && !empty($_SESSION['message']) ){
    $_SESSION['message'] ="";
}

$_SESSION['prev'] = "login";
include("config.php");
?>

<div class="container">

    <form action="login_func.php" method="POST" >

        <div class="row m-4 justify-content-center">
            <div class="col-4 bg-light">
            <div class="row m-4 text-center bg-light">
                <p style="font-size:18pt;"><b>Prisijungimas</b></p>
           
            </div>
            <div class="row m-4  text-center">
            <p style="color:red"><b><?php echo $_SESSION['message']; ?></b></p>
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
                        <input type="password" name="pass" id="pass" class="form-control" value="<?php echo $_SESSION['pass_login'];  ?>" />
                        <label for="pass">Slaptažodis</label>
                        <?php echo $_SESSION['pass_error']; ?>
                    </div>
                </div>

                <div class="row m-4 text-center">
                    <div class="col-6 ">
                       
                        <input type='submit' name='login' value='Prisijungti' class="btn btn-primary">
                    </div>
                    <div class="col-6">
                        <a href="register.php" class="btn btn-secondary" role="button">Registracija</a>
                     
                    </div>
                </div>

      
            </div>
        </div>
    </form>
</div>