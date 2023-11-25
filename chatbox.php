 <div class="col-6 bg-light">

     <div class="row m-4">
         <div class="container chatbox bg-light">
             <?php

                if (isset($sender) && isset($receiver)) {
                    $sql = "SELECT * FROM messages WHERE user_id='$id' and receiver='$receiver' or user_id='$rid' and receiver='$sender'  ORDER BY id DESC";

                    $res = mysqli_query($db, $sql);
                    if (!$res) {
                        echo " DB klaida skaitant zinutes: " . $sql . "<br>" . mysqli_error($db);
                        exit;
                    }
                    while ($row = mysqli_fetch_assoc($res)) {
                ?>
                     <p><b><?php echo $row['user_id'] ==  $id ? $sender  : $receiver ?></b>:<br> <?php echo $row['content'] ?></p>
             <?php
                    }
                }
                ?>
         </div>
     </div>
     <form method="POST" class="justify-content-center">
         <div class="row m-4">
             <div class="col-10">
                 <div class="form-group">
                     <div class="form-floating mb-3">
                         <input type="text" name="msg" class="form-control" id="msg" />
                         <label for="msg">Žinutė</label>
                     </div>
                 </div>
             </div>
             <div class="col-2">
                 <input type='submit' value='Siųsti' class="btn btn-primary">
             </div>
         </div>


     </form>
 </div>