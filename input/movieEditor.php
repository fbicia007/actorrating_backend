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

    $actorsSql = "SELECT * FROM `actors`";
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

        <form class="col-6" enctype="multipart/form-data" action="controller/editor.php?movieId=<?php echo $movieId; ?>" method="POST">
            <div class="form-group row col-sm-12">
                <label class="col-sm-3 col-form-label" for="movieTitle">影片名称</label>
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
                <label class="col-sm-3 col-form-label" for="type">影片类型</label>
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
            <fieldset class="form-group col-sm-12" style="border:0;">
                <div class="row">
                    <legend class="col-form-label col-sm-3 pt-0">影片状态</legend>
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
            </fieldset>

            <div class="form-group row col-sm-12">
                <label class="col-sm-3 col-form-label" for="movieDescription">简介：</label>
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
                        <label class="custom-file-label" for="posterV">重新上传纵版海报</label>
                    </div>
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
                        <label class="custom-file-label" for="posterH">重新上传横版海报</label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-form-label">角色和演员</label>
                <button class="btn btn-info col-sm-2" type="button" id="addRole">添加角色</button>
                <a class="btn btn-success" href="inputActor.php" target="_blank">添加角色时没有找到演员？这里添加</a>
            </div>

            <div class="form-group col-sm-12" id="roles">

                    <?php
                    switch ($movieStatus){
                        case '已上映':
                            $i =1;
                            foreach ($actors as $actor){


                                $actorId = $actor->id;
                                $role = $actor->role;
                                $roleId = $actor->roleId;
                                $roleDescription = $actor->roleDescription;

                                $roleIdArray[] = $roleId;

                                echo'
                            <div class="form-group row inputRoleActorInfo mb-12">
                                <div class="form-group row col-sm-10">
                                    <span class="input-group-text col-sm-4">现有角色'.$i.'</span>                          
                                    <input type="text" class="form-control col-sm-4" placeholder="角色名" aria-label="角色名" aria-describedby="basic-addon2" name="roleName[]" value="'.$role.'" required>
                                    <input type="text" style="display:none;" name="roleId[]" value="'.$roleId.'">                                                                 
                                <select id="actor" class="selectpicker show-tick form-control col-sm-4 custom-select" name="actors[]" data-live-search="true" required>';
                                foreach ($resultActors as $actor){

                                    echo '<option value="'.$actor[id].'"';
                                    if($actor[id]==$actorId){
                                        echo ' selected';
                                    }
                                    echo '>'.$actor[name].'</option>';

                                }
                                echo '</select>
                                    <textarea class="form-control col-sm-12" style="margin-top: 10px;" rows="3" name="roleDescription[]">'.$roleDescription.'</textarea>
                                </div>
                                <div class="form-group col-sm-2">
                                    <button class="btn btn-outline-danger remove_field" id="'.$roleId.'" type="button">删除角色</button>
                                </div>
                            </div>';

                                $i++;
                            }
                            break;
                        case '未上映':
                            $i =1;
                            foreach ($roles as $role){

                                $roleName = $role->name;
                                $roleId = $role->id;
                                $roleDescription = $role->description;
                                $actorNumber = count($role->actors);
                                $actors = $role->actors;

                                $roleIdArray[] = $roleId;

                                echo'
                            <div class="form-group row inputRoleActorInfo mb-12">
                                <div class="form-group row col-sm-10">
                                    <span class="input-group-text col-sm-6">现有角色'.$i.'</span>                                
                                <input type="text" class="form-control col-sm-6" placeholder="角色名" aria-label="角色名" aria-describedby="basic-addon2" name="roleName[]" value="'.$roleName.'" required>                               
                                <input type="text" style="display:none;" name="roleId[]" value="'.$roleId.'">
                                <textarea class="form-control col-sm-12" rows="3" style="margin-top: 10px;" name="roleDescription[]">'.$roleDescription.'</textarea>
                                <div class="col-sm-12" style="margin-top: 10px;margin-bottom: 10px;">
                                        <label for="inputAddress2">添加/修改备选演员</label>
                                
                                ';
                                echo '<button class="btn btn-outline-warning add_actor" id="add_actor" onclick="add_actors('.$i.')" type="button">添加演员</button></div>';
                                for ($a=0;$a<$actorNumber;$a++){

                                    $nowActorId = $actors[$a]->id;

                                    echo '<div class="col-sm-12"><select id="actor" class="selectpicker show-tick form-control col-sm-8 custom-select" name="actors'.$i.'[]" data-live-search="true" required>';

                                    foreach ($resultActors as $actor){

                                        echo '<option value="'.$actor[id].'"';
                                        if($actor[id]==$nowActorId){
                                            echo ' selected';
                                        }
                                        echo '>'.$actor[name].'</option>';

                                    }
                                    echo '</select><button class="btn btn-outline-danger remove_actor col-sm-4" style="margin-bottom: 5px;" type="button" onclick="$(this).parent(\'div\').remove();">移除此演员</button></div>';
                                }
                                echo '<div class="form-group col-sm-12" id="addActors'.$i.'"></div>';

                                echo '</div>
                                <div class="form-group col-sm-2">                                   
                                    <button class="btn btn-outline-danger remove_field" id="'.$roleId.'" type="button">删除角色</button>
                                </div>
                            </div>';

                               $i++;
                            }
                            break;
                    }

                    ?>
                </div>

            <button class="btn btn-primary" type="submit" id="saveMovie" name="submit">保存已修改信息</button>
            <a class="btn btn-secondary" href="index.php" name="submit">取消</a>

        </form>

        <div class="col-6">

            <div class="col-sm-6">
                <div class="form-group col-6 img-result hide">
                    <label type="text">纵版预览图</label>
                    <img class="cropped" src="" alt="">
                </div>
                <div class="form-group col-6">
                    <div class="result"></div>
                    <!-- save btn -->
                    <button class="btn btn-success align-middle save hide">截取纵版海报</button>
                </div>

                <!-- input file -->
                <div class="form-group">
                    <div class="options hide">

                    </div>
                </div>
            </div>


            <div class="col-sm-6">
                <div class="form-group col-6 img-resultH hide">
                    <label type="text">横版预览图</label>
                    <img class="croppedH" src="" alt="">
                </div>
                <div class="form-group col-6">
                    <div class="resultH"></div>
                    <!-- save btn -->
                    <button class="btn btn-success align-middle saveH hide">截取横版海报</button>
                </div>
                <!-- input file -->
                <div class="form-group">
                    <div class="optionsH hide">

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
    $('#offline').change(function() {

        var r=confirm("更改影片状态将会清空影片角色和演员，是否确认？");
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
        var r=confirm("更改影片状态将会清空影片角色的演员，是否确认？");
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
                    $(wrapper).append('<div class="form-group row inputRoleActorInfo mb-12"><div class="form-group row col-sm-10"><span class="input-group-text col-sm-4">新加角色</span>' +
                        '<input type="text" class="form-control col-sm-4" placeholder="此处填写角色名" aria-label="角色名" aria-describedby="basic-addon2" name="roleName[]" required>' +
                        '                                <select id="actor" class="selectpicker show-tick form-control col-sm-4" name="actors[]" data-live-search="true" required>\n' +
                        '                                   <option value="">请选择演员...</option>\n' +
                        '<?php foreach ($resultActors as $actor){ echo '<option value="'.$actor[id].'">'.$actor[name].'</option>';} ?> \n'+
                        '                                   </select>\n'+
                        '<textarea class="col-sm-12" rows="3" style="margin-top:10px;" name="roleDescription[]" placeholder="此处填写角色简介"></textarea>' +
                        '</div><div class="form-group col-sm-2"><button class="btn btn-outline-danger remove_field" id="remove_field" type="button">删除角色</button></div>'); //add input box

                    $('select').selectpicker('refresh');


                }else {
                    $(wrapper).append('<div class="form-group row inputRoleActorInfo mb-12"><div class="form-group row col-sm-10"><span class="input-group-text col-sm-6">新加角色</span>' +
                        '<input type="text" class="form-control col-sm-6" placeholder="此处填写角色名" aria-label="角色名" aria-describedby="basic-addon2" name="roleName[]" required>' +
                        '<textarea class="col-sm-12" rows="3" style="margin-top: 10px;" name="roleDescription[]" placeholder="此处填写角色简介"></textarea>' +
                        '<div class="col-sm-12" style="margin-top: 10px;margin-bottom: 10px;">'+
                        '<label for="inputAddress2">添加/修改备选演员</label>'+
                        '<button class="btn btn-outline-warning add_actor" id="add_actor" onclick="add_actors('+x+')" type="button">添加演员</button></div>\n' +
                        '                                <div class="form-group col-sm-12" id="addActors'+x+'">\n' +
                        '                                </div>\n' +
                        '</div><div class="form-group col-sm-2">' +
                        '<button class="btn btn-outline-danger remove_field" id="remove_field" type="button">删除角色</button></div>'); //add input box

                    $('select').selectpicker("refresh");
                }

                x++; //text box increment
            }
        });

        $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
            e.preventDefault(); $(this).parent('div').parent('div').remove(); x--;
            var roleId = this.id;
            alert(roleId);
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
                    '<select id="actor" class="selectpicker show-tick form-control col-sm-7 custom-select" name="actors'+roleNumber+'[]" data-live-search="true" required>\n' +
                    '                                       <option value="">请选择演员...</option>\n' +
                    '<?php foreach ($resultActors as $actor){ echo '<option value="'.$actor[id].'">'.$actor[name].'</option>';} ?> \n'+
                    '                                   </select>' +
                    '                                    <button class="btn btn-outline-danger remove_actor col-sm-4" type="button">移除此演员</button></div>');

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
</body>
</html>