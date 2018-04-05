<?php
session_start();

if(!$_SESSION['username']){
    header('Location: ../index.php');
}
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
    <!-- cropper api -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/cropper/2.3.4/cropper.min.css'>
    <link rel="stylesheet" href="css/style.css">

    <link rel="stylesheet" href="css/bootstrap-select.css">
    <?php

    include_once 'connect.php';

    $actorsSql = "SELECT * FROM actors ORDER BY CONVERT( name USING gbk ) COLLATE gbk_chinese_ci ASC";
    $stmt = $pdo->prepare($actorsSql);
    $stmt->execute();
    $resultActors = $stmt->fetchAll();

    //$host = 'https://'.$_SERVER['HTTP_HOST'];
    $host = 'http://'.$_SERVER['HTTP_HOST'];
    $movieId = $_GET["movieId"];
    $movieStatus = $_GET["status"];

    switch ($movieStatus){
        case '已上映':
            //$filename = $host."/actorrating/in_theaters.php?id=".$movieId;
            $filename = $host."/actorrating_backend/in_theaters.php?id=".$movieId;
            $json_string = file_get_contents($filename);

            $movieContent =  json_decode($json_string);
            $movie = $movieContent[0];

            $movieId = $movie->id;
            $movieTitle = $movie->title;
            $movieDirector = $movie->director;
            $type = $movie->type;
            $released = $movie->status;
            $movieDescription = $movie->description;
            $posterV = $movie->posterVName;
            $posterH = $movie->posterHName;
            $actors = $movie->actors;
            break;
        case '未上映':
            //$filename = $host."/actorrating/coming_soon.php?id=".$movieId;
            $filename = $host."/actorrating_backend/coming_soon.php?id=".$movieId;
            $json_string = file_get_contents($filename);

            $movieContent =  json_decode($json_string);
            $movie = $movieContent[0];

            $movieId = $movie->id;
            $movieTitle = $movie->title;
            $movieDirector = $movie->director;
            $type = $movie->type;
            $released = $movie->status;
            $movieDescription = $movie->description;
            $posterV = $movie->posterVName;
            $posterH = $movie->posterHName;

            $roles = $movie->roles;
            break;
    }
    ?>

    <title>编辑影视剧详细信息</title>

</head>
<body>

<div class="container" style="margin-top: 2%;">
    <!-- Content here -->
    <div class="row">
        <div class="col-12 align-items-center justify-content-center">
            <h1>编辑影片 <?php echo $movieTitle; ?> 的详细信息</h1>
        </div>
    </div>
    <div class="row">

        <form class="col-8" enctype="multipart/form-data" action="controller/editor.php?page=<?php echo $_GET['page']; ?>&movieId=<?php echo $movieId; ?>" method="POST">
            <div class="form-group row col-sm-12">
                <label class="col-sm-3 col-form-label" for="movieTitle">名称</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="movieTitle" name="movieTitle" value="<?php echo $movieTitle; ?>" required>
                </div>
            </div>
            <div class="form-group row col-sm-12">
                <label class="col-sm-3 col-form-label" for="director">导演</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="director" name="director" value="<?php echo $movieDirector; ?>" required>
                </div>
            </div>
            <div class="form-group row col-sm-12">
                <label class="col-sm-3 col-form-label" for="type">类型</label>
                <div class="col-sm-9">
                    <select id="type" class="form-control" name="type" required>
                        <option value="">请选择...</option>
                        <?php
                        switch ($type) {
                            case '电影':
                                echo '<option value="电影" selected>电影</option>
                        <option value="电视剧">电视剧</option>';
                                break;
                            case '电视剧':
                                echo '<option value="电影">电影</option>
                        <option value="电视剧" selected>电视剧</option>';
                                break;
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group col-sm-12" style="border:0;">
                <div class="row">
                    <legend class="col-form-label col-sm-3 pt-0">状态</legend>
                    <div class="col-sm-9">
                        <?php
                        switch ($released) {
                            case 1:
                                echo '<div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="online" value="1" checked>
                            <label class="form-check-label">
                                已上映
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="offline" value="0">
                            <label class="form-check-label">
                                未上映
                            </label>
                        </div>';
                                break;
                            case 0:
                                echo '<div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="online" value="1">
                            <label class="form-check-label">
                                已上映
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="offline" value="0" checked>
                            <label class="form-check-label">
                                未上映
                            </label>
                        </div>';
                                break;
                        }
                        ?>
                    </div>
                </div>
            </div>

            <div class="form-group row col-sm-12">
                <label class="col-sm-3 col-form-label" for="movieDescription">简介</label>
                <div class="col-sm-9">
                    <textarea class="form-control" id="movieDescription" name="movieDescription" rows="5"><?php echo $movieDescription; ?></textarea>
                </div>

            </div>
            <div class="form-group row col-sm-12">
                <label class="col-sm-3 col-form-label" for="posterV">纵版海报</label>
                <div class="col-sm-3 img-result">
                    <img class="cropped" src="<?php echo $host.'/actorrating/images/movies/'.$posterV; ?>" style="width: 100px;" />
                </div>
                <div class="col-sm-6">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="posterV" name="posterV">
                        <input type="text" style="display: none;" id="posterVName" name="posterVName" value="<?php echo $posterV; ?>">
                        <label class="custom-file-label" for="posterV">上传图片</label>
                    </div>
                    <p id="error3" style="display:none; color:#FF0000;">
                        上传图片格式错误!
                    </p>
                    <p id="error4" style="display:none; color:#FF0000;">
                        上传图片过大，不能超过10M！
                    </p>
                    <footer style="display: block;font-size: 80%;color: #6c757d;margin-top: 5px;">请选择JPG，JPEG，PNG，GIF格式，小于10M的图片</footer>
                </div>
            </div>
            <div class="form-group row col-sm-12">
                <label class="col-sm-3 col-form-label" for="type">横版海报</label>
                <div class="col-sm-3 img-resultH">
                    <img class="croppedH" src="<?php echo $host.'/actorrating/images/movies/'.$posterH; ?>" style="width: 100px;" />
                </div>
                <div class="col-sm-6">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="posterH" name="posterH">
                        <input type="text" style="display: none;" id="posterHName" name="posterHName" value="<?php echo $posterH; ?>">
                        <label class="custom-file-label" for="posterH">上传图片</label>
                    </div>
                    <p id="error5" style="display:none; color:#FF0000;">
                        上传图片格式错误!
                    </p>
                    <p id="error6" style="display:none; color:#FF0000;">
                        上传图片过大，不能超过10M！
                    </p>
                    <footer style="display: block;font-size: 80%;color: #6c757d;margin-top: 5px;">请选择JPG，JPEG，PNG，GIF格式，小于10M的图片</footer>
                </div>

            </div>
            <div class="form-group">
                <label class="col-sm-3 col-form-label" style="margin-top: 20px;">角色和演员</label>


                    <?php
                    switch ($movieStatus){
                        case '已上映':
                            echo '<button class="btn btn-info col-sm-2" type="button" id="addRole" onclick="$(\'#addNewActor\').show();">添加角色</button>
                <a class="btn btn-success" id="addNewActor" data-toggle="modal" onclick="setConstellation();" data-target="#addActorEditor" style="display: none;">添加角色时没有找到演员？这里添加</a>
            </div>

            <div class="form-group col-sm-12" id="roles">';
                            $i =1;
                            foreach ($actors as $actor){


                                $actorId = $actor->id;
                                $role = $actor->role;
                                $roleId = $actor->roleId;
                                $roleDescription = $actor->roleDescription;

                                $roleIdArray[] = $roleId;

                                echo'
                            <div class="inputRoleActorInfo" style="margin-bottom: 30px;">
                                <div class="form-group row jumbotron" style="padding: 1rem 1rem; padding-bottom: 75px;">
                                    <span class="col-sm-2" style="padding: .375rem .75rem;">角色'.$i.':</span>                          
                                    <input type="text" class="form-control col-sm-10" style="margin-bottom: 5px;" placeholder="角色名" aria-label="角色名" aria-describedby="basic-addon2" name="roleName[]" value="'.$role.'" required>
                                    <input type="text" style="display:none;" name="roleId[]" value="'.$roleId.'">                                                                 
                                    <span class="col-sm-2" style="padding: .375rem .75rem;">演员:</span>    
                                <select id="actor" class="selectpicker show-tick form-control col-sm-10 custom-select" name="actors[]" data-live-search="true" required>';
                                foreach ($resultActors as $actor){

                                    echo '<option value="'.$actor[id].'"';
                                    if($actor[id]==$actorId){
                                        echo ' selected';
                                    }
                                    echo '>'.$actor[name].'</option>';

                                }
                                echo '</select>
                                    <textarea class="form-control col-sm-12" style="margin-top: 10px; display: none;" rows="3" name="roleDescription[]">'.$roleDescription.'</textarea>
                                </div>
                                <div class="form-group col-sm-12" style="margin-top: -88px;">
                                    <button class="btn btn-danger remove_field col-sm-12" id="'.$roleId.'" type="button">删除角色</button>
                                </div>
                            </div>';

                                $i++;
                            }
                            break;
                        case '未上映':
                            $i =1;
                            echo '<button class="btn btn-info col-sm-2" type="button" id="addRole">添加角色</button>
                <a class="btn btn-success" id="addNewActor" data-toggle="modal" onclick="setConstellation();" data-target="#addActorEditor" style="display: none;">添加角色时没有找到演员？这里添加</a>
            </div>

            <div class="form-group col-sm-12" id="roles">';
                            foreach ($roles as $role){

                                $roleName = $role->name;
                                $roleId = $role->id;
                                $roleDescription = $role->description;
                                $actorNumber = count($role->actors);
                                $actors = $role->actors;

                                $roleIdArray[] = $roleId;

                                echo'
                            <div class="inputRoleActorInfo" style="margin-bottom: 30px;">
                                <div class="form-group row jumbotron" style="padding: 1rem 1rem; padding-bottom: 50px;">
                                    <span class="col-sm-2" style="padding: .375rem .75rem;">角色'.$i.':</span>                                
                                <input type="text" class="form-control col-sm-10" placeholder="角色名" aria-label="角色名" aria-describedby="basic-addon2" name="roleName[]" value="'.$roleName.'" required>                               
                                <input type="text" style="display:none;" name="roleId[]" value="'.$roleId.'">
                                <span class="col-sm-2" style="padding: .375rem .75rem;">简介</span>
                                <textarea class="form-control col-sm-10" rows="3" style="margin-top: 10px;" name="roleDescription[]">'.$roleDescription.'</textarea>
                                <div class="col-sm-12" style="margin-top: 10px;margin-bottom: 10px;">
                                        <label for="inputAddress2">添加/修改备选演员</label>
                                
                                ';
                                echo '<button class="btn btn-outline-success add_actor" style="margin-left: 10px;" id="add_actor" onclick="$(\'#addNewActor\').show();add_actors('.$i.')" type="button">添加演员</button></div>';
                                for ($a=0;$a<$actorNumber;$a++){

                                    $nowActorId = $actors[$a]->id;

                                    echo '<div class="col-sm-12" style="margin-bottom: 10px;"><select id="actor" class="selectpicker show-tick form-control col-sm-9 custom-select" name="actors'.$i.'[]" data-live-search="true" required>';

                                    foreach ($resultActors as $actor){

                                        echo '<option value="'.$actor[id].'"';
                                        if($actor[id]==$nowActorId){
                                            echo ' selected';
                                        }
                                        echo '>'.$actor[name].'</option>';

                                    }
                                    echo '</select><button class="btn btn-outline-danger remove_actor col-sm-2 offset-sm-1"  type="button" onclick="$(this).parent(\'div\').remove();">移除</button></div>';
                                }
                                echo '<div class="form-group col-sm-12" id="addActors'.$i.'"></div>';

                                echo '</div>
                                         <div class="form-group col-sm-12" style="margin-top: -88px;">                          
                                    <button class="btn btn-danger remove_field col-sm-12" id="'.$roleId.'" type="button">删除角色</button>
                                </div>
                            </div>';

                               $i++;
                            }
                            break;
                    }

                    ?>
                </div>

            <div class="form-group" style="margin-top: 50px;">

                <a class="btn btn-secondary" href="index.php" name="submit">取消</a>
                <button class="btn btn-primary" type="submit" id="saveMovie" name="submit">保存</button>
            </div>


        </form>

        <!--input new actor-->

        <div class="modal fade" id="addActorEditor" tabindex="-1" role="dialog" aria-labelledby="actorLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content" style="width: 140%;">
                    <div class="modal-header">
                        <h5 class="modal-title" id="actorLabel">添加演员</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="col-12" style="text-align: left;" enctype="multipart/form-data" method="POST" onsubmit="return insertNewActor()" id="addActorEditorForm">
                            <div class="form-group row col-sm-12">
                                <label class="col-sm-3 col-form-label">姓名</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="actorName" name="actorName" required>
                                </div>
                            </div>
                            <div class="form-group row col-sm-12">
                                <label class="col-sm-3 col-form-label" for="birthday">生日</label>
                                <div class="col-sm-9">
                                    <input type="date" class="form-control" id="birthday" name="birthday" >
                                </div>
                            </div>
                            <div class="form-group row col-sm-12">
                                <label class="col-sm-3 col-form-label" for="constellation">星座</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="constellation" name="constellation" >
                                </div>
                            </div>
                            <div class="form-group row col-sm-12">
                                <label class="col-sm-3 col-form-label" for="birthplace">出生地</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="birthplace" name="birthplace">
                                </div>
                            </div>
                            <div class="form-group row col-sm-12">
                                <label class="col-sm-3 col-form-label" for="profession">职业</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="profession" name="profession" placeholder="演员，导演，编剧" >
                                </div>
                            </div>
                            <div class="form-group row col-sm-12">
                                <label class="col-sm-3 col-form-label" for="actorDescription">简介</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" id="actorDescription" name="actorDescription" rows="5"></textarea>
                                </div>

                            </div>
                            <div class="form-group row col-sm-12">
                                <label class="col-sm-3 col-form-label" for="photo">照片</label>
                                <div class="col-sm-3 img-result'.$id.'">
                                    <img class="croppedA" src="" style="width: 100px;" />
                                </div>
                                <div class="col-sm-6">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="photo" name="photo" required>
                                        <input type="text" style="display: none;" id="photoName" name="photoName" value="">
                                        <label class="custom-file-label" for="photo">上传图片</label>
                                    </div>
                                    <p id="error1" style="display:none; color:#FF0000;">
                                        上传图片格式错误!
                                    </p>
                                    <p id="error2" style="display:none; color:#FF0000;">
                                        上传图片过大，不能超过10M！
                                    </p>
                                    <footer style="display: block;font-size: 80%;color: #6c757d;margin-top: 5px;">请选择JPG，JPEG，PNG，GIF格式，小于10M的图片</footer>
                                </div>
                            </div>

                        </form>

                        <div class="form-group col-3">
                            <div class="resultA"></div>
                            <!-- save btn -->
                            <button class="btn btn-success saveA hide">截取照片并保存</button>
                        </div>
                        <div class="form-group col-3 img-resultA hide">
                            <img class="croppedA" src="" alt="">
                        </div>
                        <!-- input file -->
                        <div class="form-group col-4">
                            <div class="optionsA hide">

                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                        <button type="submit" class="btn btn-primary" id="saveActor" form="addActorEditorForm">保存</button>

                    </div>
                </div>
            </div>
        </div>
        <!--input new actor-->

        <div class="col-4">

            <div class="col-sm-12">
                <div class="form-group col-6 img-result hide">
                    <label type="text">纵版预览图</label>
                    <img class="cropped" src="" alt="">
                </div>
                <div class="form-group col-12">
                    <div class="result"></div>
                    <!-- save btn -->
                    <button class="btn btn-success align-middle save hide">截取纵版海报并保存</button>
                </div>

                <!-- input file -->
                <div class="form-group">
                    <div class="options hide">

                    </div>
                </div>
            </div>


            <div class="col-sm-12">
                <div class="form-group col-6 img-resultH hide">
                    <label type="text">横版预览图</label>
                    <img class="croppedH" src="" alt="">
                </div>
                <div class="form-group col-12">
                    <div class="resultH"></div>
                    <!-- save btn -->
                    <button class="btn btn-success align-middle saveH hide">截取横版海报并保存</button>
                </div>
                <!-- input file -->
                <div class="form-group">
                    <div class="optionsH hide">

                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group col-6 img-resultA hide">
                    <label type="text">照片预览</label>

                </div>
                <div class="form-group col-6">
                    <div class="resultA"></div>
                    <!-- save btn -->
                    <button class="btn btn-success align-middle saveA hide">截取照片并保存</button>
                </div>
                <!-- input file -->
                <div class="form-group">
                    <div class="optionsA hide">

                    </div>
                </div>
            </div>

        </div>
    </div>

    </div>

</div>


<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/cropperjs/0.8.1/cropper.min.js'></script>

<script src='js/bootstrap-select.js'></script>
<script  src="js/cropperPoster.js"></script>

<script>

    //check image size and type
    var a=0;
    //photo
    $('#photo').bind('change', function() {

        var ext = $('#photo').val().split('.').pop().toLowerCase();
        if ($.inArray(ext, ['gif','png','jpg','jpeg']) == -1){
            $('#error1').slideDown("slow");
            $('#error2').slideUp("slow");
            a=0;
        }else{
            var picsize = (this.files[0].size);
            if (picsize > 10000000){
                $('#error2').slideDown("slow");
                a=0;
            }else{
                a=1;
                $('#error2').slideUp("slow");
            }
            $('#error1').slideUp("slow");

        }
    });

    //posterV
    $('#posterV').bind('change', function() {

        var ext = $('#posterV').val().split('.').pop().toLowerCase();
        if ($.inArray(ext, ['gif','png','jpg','jpeg']) == -1){
            $('#error3').slideDown("slow");
            $('#error4').slideUp("slow");
            a=0;
        }else{
            var picsize = (this.files[0].size);
            if (picsize > 10000000){
                $('#error4').slideDown("slow");
                a=0;
            }else{
                a=1;
                $('#error4').slideUp("slow");
            }
            $('#error3').slideUp("slow");

        }
    });
    //posterH
    $('#posterH').bind('change', function() {

        var ext = $('#posterH').val().split('.').pop().toLowerCase();
        if ($.inArray(ext, ['gif','png','jpg','jpeg']) == -1){
            $('#error5').slideDown("slow");
            $('#error6').slideUp("slow");
            a=0;
        }else{
            var picsize = (this.files[0].size);
            if (picsize > 10000000){
                $('#error6').slideDown("slow");
                a=0;
            }else{
                a=1;
                $('#error6').slideUp("slow");
            }
            $('#error5').slideUp("slow");

        }
    });

    //input new actor

    function insertNewActor() {

        $.post('controller/inputActors.php', {ajaxInputActor:'yes',actorName : $('#actorName').val(),birthday : $('#birthday').val(),constellation : $('#constellation').val(),birthplace : $('#birthplace').val(),profession : $('#profession').val(),actorDescription : $('#actorDescription').val(),photoName : $('#photoName').val()}, function(data) {

            if (data) {
                alert('演员保存成功，可以从演员下拉菜单中选择。');
                var newActorId = data;
                var newActorName = $('#actorName').val();
                $("select").append("<option value='"+newActorId+"'>"+newActorName+"</option>");
                $('#rolesForm').find('ul').append("<li><a role=\"option\" class=\"dropdown-item\" aria-disabled=\"false\" tabindex=\"0\" aria-selected=\"false\"><span class=\" bs-ok-default check-mark\"></span><span class=\"text\">"+newActorName+"</span></a></li>");
                $('select').selectpicker("refresh");
            }
        });

        $('#addActorEditor').modal('toggle');
        $('#addNewActor').hide();
        $("#addActorEditor input").not(":button, :submit, :reset, :hidden").val("");
        $(".croppedA").attr('src','');
        $(".resultA").html('');
        $(".saveA").attr('class','btn btn-success saveA hide');
        return false;
    }


</script>
<script>
    $('#offline').change(function() {

        var r=confirm("更改影片状态需要重新为此影片录入角色。是否继续？");
        if (r==true)
        {
            $("div.inputRoleActorInfo").remove();
            $.ajax({
                type: "POST",
                url: 'controller/del.php?status=未上映&movieId=<?php echo $movieId;?>&changeStatus=<?php echo json_encode($roleIdArray);?>',
                data:{action:'call_this'},
                success:function(html) {
                    alert(html);
                    window.location.href="movieEditor.php?status=未上映&movieId=<?php echo $movieId;?>"
                }

            });
        }else {
            $('#online').prop('checked', true);
        }

    })
    $('#online').change(function() {
        var r=confirm("更改影片状态需要重新为此影片录入角色。是否继续？");
        if (r==true)
        {
            $("div.inputRoleActorInfo").remove();
            $.ajax({
                type: "POST",
                url: 'controller/del.php?status=1&movieId=<?php echo $movieId;?>&changeStatus=<?php echo json_encode($roleIdArray);?>',
                data:{action:'call_this'},
                success:function(html) {
                    alert(html);
                    window.location.href="movieEditor.php?status=已上映&movieId=<?php echo $movieId;?>"
                }

            });
        }else {
            $('#offline').prop('checked', true);
        }

    })

    //初始参数个数
    $(document).ready(function() {

        var max_fields      = 100; //maximum input boxes allowed
        var wrapper         = $("#roles"); //Fields wrapper
        var add_button      = $("#addRole"); //Add button ID

        var x = <?php echo $i; ?>; //initlal text box count
        $(add_button).click(function(e){ //on add input button click
            e.preventDefault();
            if(x < max_fields){ //max input box allowed

                <?php
                switch ($movieStatus){
                    case '已上映':
                        echo "var status = '1';";
                        break;
                    case '未上映':
                        echo "var status = '0';";
                        break;
                }
                ?>
                if(status==1){
                    $(wrapper).append('<div class="inputRoleActorInfo" style="margin-top:30px;"><div class="form-group row jumbotron" style="padding: 1rem 1rem; padding-bottom:75px;"><span class="col-sm-2" style="padding:  .375rem .75rem;">新加角色:</span>' +
                        '<input type="text" class="form-control col-sm-10" style="margin-bottom:5px;" placeholder="此处填写角色名" aria-label="角色名" aria-describedby="basic-addon2" id="focus'+x+'" name="roleName[]" required>' +
                            '<span class="col-sm-2" style="padding:  .375rem .75rem;">演员:</span>'+
                        '                                <select id="actor" class="selectpicker show-tick form-control col-sm-10" name="actors[]" data-live-search="true" required>\n' +
                        '                                   <option value="">请选择演员...</option>\n' +
                        '<?php foreach ($resultActors as $actor){ echo '<option value="'.$actor[id].'">'.$actor[name].'</option>';} ?> \n'+
                        '                                   </select>\n'+
                        '<textarea class="col-sm-12" rows="3" style="margin-top:10px; display:none;" name="roleDescription[]" placeholder="此处填写角色简介"></textarea>' +
                        '</div><div class="form-group col-sm-12" style="margin-top:-88px;"><button class="btn btn-danger remove_field col-sm-12" id="remove_field" type="button">删除角色</button></div>'); //add input box

                    $('select').selectpicker('refresh');



                }else {
                    $(wrapper).append('<div class="inputRoleActorInfo"><div class="form-group row jumbotron" style="padding: 1rem 1rem;padding-bottom: 50px;margin-top: 30px;"><span class="col-sm-2" style="padding:  .375rem .75rem;">新加角色:</span>' +
                        '<input type="text" class="form-control col-sm-10" placeholder="此处填写角色名" aria-label="角色名" aria-describedby="basic-addon2" id="focus'+x+'" name="roleName[]" required>' +
                        '<span class="col-sm-2" style="padding:  .375rem .75rem;">简介</span>' +
                        '<textarea class="col-sm-10" rows="3" style="margin-top: 10px;" name="roleDescription[]" placeholder="此处填写角色简介"></textarea>' +
                        '<div class="col-sm-12" style="margin-top: 10px;margin-bottom: 10px;">'+
                        '<label for="inputAddress2">添加/修改备选演员</label>'+
                        '<button class="btn btn-outline-success add_actor" style="margin-left: 10px;" id="add_actor" onclick="$(\'#addNewActor\').show();add_actors('+x+')" type="button">添加演员</button></div>\n' +
                        '                                <div class="form-group col-sm-12" id="addActors'+x+'">\n' +
                        '                                </div>\n' +
                        '</div><div class="form-group col-sm-12" style="margin-top: -88px;">' +
                        '<button class="btn btn-danger remove_field col-sm-12" id="remove_field" type="button">删除角色</button></div>'); //add input box

                    $('select').selectpicker("refresh");

                }
                $('#focus'+x).focus();
                x++; //text box increment
            }
        });

        $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
            e.preventDefault(); $(this).parent('div').parent('div').remove(); x--;
            var roleId = this.id;
            //alert(roleId);
            if(roleId!='remove_field'){
                $.ajax({
                    type: "POST",
                    url: 'controller/del.php?delRole='+roleId,
                    data:{action:'call_this'},
                    success:function(html) {
                        alert(html);
                    }

                });
            }

        })
    });


</script>
<script>

    function add_actors(roleNumber) {

        $(document).ready(function() {
            var max_fields      = 100; //maximum input boxes allowed
            var wrapper         = $("#addActors"+roleNumber); //Fields wrapper

            var z = 1; //initlal text box count
            if(z < max_fields){ //max input box allowed


                $(wrapper).append('<div style="margin-bottom:5px;">' +
                    '<select id="actor" class="selectpicker show-tick form-control col-sm-8 custom-select" name="actors'+roleNumber+'[]" data-live-search="true" required>\n' +
                    '                                       <option value="">请选择演员...</option>\n' +
                    '<?php foreach ($resultActors as $actor){ echo '<option value="'.$actor[id].'">'.$actor[name].'</option>';} ?> \n'+
                    '                                   </select>' +
                    '                                    <button class="btn btn-outline-danger remove_actor col-sm-2 offset-sm-1" type="button">移除</button></div>');

                $('select').selectpicker("refresh");
            }

            $(wrapper).on("click",".remove_actor", function(e){ //user click on remove text
                e.preventDefault(); $(this).parent('div').remove(); z--;

            })

            z++; //text box increment
        });
    }


</script>
<script>
    $(document).ready(function(){
        //判断电影名是否已经注册了
        $('#movieTitle').blur(function() {
            if ($('#movieTitle').val() != '') {
                $.post('controller/movieTitleCheck.php?movieId=<?php echo $movieId; ?>', {title : $('#movieTitle').val()}, function(data) {
                    if (data == 0) {
                        alert('此电影名称已被占用！请更改！');
                        $('#movieTitle').val('').css('border-color','red');
                    }
                });
            }
        });
    });
</script>
<script>

    //birthday to constellation
    function getConstellationByBirthday(strBirthday) {

        var value;
        var strBirthdayArr=strBirthday.split("-");
        var birthMonth = strBirthdayArr[1];
        var birthDay = strBirthdayArr[2];

        if (birthMonth == 1 && birthDay >=20 || birthMonth == 2 && birthDay <=18) {value = "水瓶座";}
        if (birthMonth == 1 && birthDay > 31) {value = "Huh?";}
        if (birthMonth == 2 && birthDay >=19 || birthMonth == 3 && birthDay <=20) {value = "双鱼座";}
        if (birthMonth == 2 && birthDay > 29) {value = "Say what?";}
        if (birthMonth == 3 && birthDay >=21 || birthMonth == 4 && birthDay <=19) {value = "白羊座";}
        if (birthMonth == 3 && birthDay > 31) {value = "OK. Whatever.";}
        if (birthMonth == 4 && birthDay >=20 || birthMonth == 5 && birthDay <=20) {value = "金牛座";}
        if (birthMonth == 4 && birthDay > 30) {value = "I'm soooo sorry!";}
        if (birthMonth == 5 && birthDay >=21 || birthMonth == 6 && birthDay <=21) {value = "双子座";}
        if (birthMonth == 5 && birthDay > 31) {value = "Umm ... no.";}
        if (birthMonth == 6 && birthDay >=22 || birthMonth == 7 && birthDay <=22) {value = "巨蟹座";}
        if (birthMonth == 6 && birthDay > 30) {value = "Sorry.";}
        if (birthMonth == 7 && birthDay >=23 || birthMonth == 8 && birthDay <=22) {value = "狮子座";}
        if (birthMonth == 7 && birthDay > 31) {value = "Excuse me?";}
        if (birthMonth == 8 && birthDay >=23 || birthMonth == 9 && birthDay <=22) {value = "处女座";}
        if (birthMonth == 8 && birthDay > 31) {value = "Yeah. Right.";}
        if (birthMonth == 9 && birthDay >=23 || birthMonth == 10 && birthDay <=22) {value = "天秤座";}
        if (birthMonth == 9 && birthDay > 30) {value = "Try Again.";}
        if (birthMonth == 10 && birthDay >=23 || birthMonth == 11 && birthDay <=21) {value = "天蝎座";}
        if (birthMonth == 10 && birthDay > 31) {value = "Forget it!";}
        if (birthMonth == 11 && birthDay >=22 || birthMonth == 12 && birthDay <=21) {value = "射手座";}
        if (birthMonth == 11 && birthDay > 30) {value = "Invalid Date";}
        if (birthMonth == 12 && birthDay >=22 || birthMonth == 1 && birthDay <=19) {value = "摩羯座";}
        if (birthMonth == 12 && birthDay > 31) {value = "No way!";}
        return  value;

    }

    function setConstellation() {
        $('#birthday').bind('input', function() {

            $('#constellation').val(getConstellationByBirthday($(this).val()));
        });
    }


</script>
</body>
</html>