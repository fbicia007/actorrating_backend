<?php
/**
 * Created by PhpStorm.
 * User: fbicia
 * Date: 2018/3/18
 * Time: 下午1:17
 */

    include_once "connect.php";

    $movieId = $_GET["movieId"];
    $status = $_GET["status"];

    $rolesSql = "SELECT * FROM `roles` WHERE `movieId`=?  ";
    $stmt = $pdo->prepare($rolesSql);
    $stmt->execute(array($movieId));
    $resultRoles = $stmt->fetchAll();

    $actorsSql = "SELECT * FROM `actors`";
    $stmt = $pdo->prepare($actorsSql);
    $stmt->execute();
    $resultActors = $stmt->fetchAll();
?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    <title>角色分配演员</title>

</head>
<body>

<div class="container">
    <!-- Content here -->
    <div class="container">
        <div class="row">
            <div class="col-12 align-items-center justify-content-center">
                <h1>角色添加对应演员</h1>
                <p class="col-md-auto">请给每个角色选择一位演员</p>
            </div>
        </div>
        <div class="row">

            <!-- <form class="col-12"  enctype="multipart/form-data" action="inputMovieRoles.php" method="POST">-->
            <form class="col-12" action="controller/inputRolesActors.php?status=<?php echo $status; ?>" method="POST">

                <?php
                if($status==1){
                    #已上映
                    foreach ($resultRoles as $role){
                        echo '<div class="form-group row col-sm-12">
                        <label class="col-sm-3 col-form-label" for="role">角色（'.$role[name].'）的扮演者：</label>
                        <input type="text" class="form-control" name="roles[]" value="'.$role[name].'" style="display: none;">
                        <input type="text" class="form-control" name="movieId" value="'.$movieId.'" style="display: none;">
                        <div class="col-sm-9">
                            <select id="actors" class="form-control col-sm-12" name="actors[]" required>
                             <option value="">请选择...</option>';
                        foreach ($resultActors as $actor){
                            echo '<option value="'.$actor[id].'">'.$actor[name].'</option>';
                        }
                        echo '
                         </select>
                        </div>
                    </div>';
                    }
                }else{
                    #未上映
                    foreach ($resultRoles as $role){
                        echo '<div class="form-group row col-sm-12">
                        <label class="col-sm-3 col-form-label" for="role">角色（'.$role[name].'）的备选扮演者：</label>
                        <input type="text" class="form-control" name="roles[]" value="'.$role[name].'" style="display: none;">
                        <input type="text" class="form-control" name="movieId" value="'.$movieId.'" style="display: none;">';

                        $actorNumber = $role[actorNumber];
                        echo'<div class="col-sm-6">';
                        #分配演员
                        for($i=0;$i<$actorNumber;$i++){

                            echo'<select id="actors" class="form-control col-sm-12" name="actors'.$role[id].'[]" required>
                             <option value="">请选择...</option>';
                            foreach ($resultActors as $actor){
                                echo '<option value="'.$actor[id].'">'.$actor[name].'</option>';
                            }
                            echo '
                             </select>';

                        }
                        echo '</div>';
                        #end 分配演员


                    echo '</div>';
                    }
                }


                $pdo = null;
                ?>


                <button class="btn btn-primary" type="submit" name="submit">保存</button>
                <button class="btn btn-primary" onclick="window.location.href='inputActor.php'" >没有找到演员？这里添加</button>

            </form>
        </div>
    </div>

</div>


<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>
</html>
