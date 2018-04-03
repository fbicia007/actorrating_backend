<?php
$user_id = $_POST['user_id'] ;
$user_passwd = $_POST['user_passwd'] ;
?>
<center>
    <?php
    if($user_id =="john" && $user_passwd =="john@123")
    {
        echo "<h3>Correct</h3>" ;
    }
    else
    {
        echo "<h3>Incorrect</h3>" ;
    }
    ?>
    </div>
</center>