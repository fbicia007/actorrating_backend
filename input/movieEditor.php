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
    <?php

    $host = $_SERVER['HTTP_HOST'];
    $movieId = $_GET["movieId"];
    $movieStatus = $_GET["status"];

    switch ($movieStatus){
        case '已上映':
            $filename = "http://".$host."/actorrating_backend/in_theaters.php?id=".$movieId;
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
            $filename = "http://".$host."/actorrating_backend/coming_soon.php?id=".$movieId;
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
            <h1>编辑影片<span style="color: #2196f3;"><?php echo $movieTitle; ?></span>的详细信息</h1>
        </div>
    </div>
    <div class="row">

        <!--<form class="col-9" enctype="multipart/form-data" action="controller/inputMovieRoles.php" method="POST">-->
        <form class="col-9" enctype="multipart/form-data" action="controller/editor.php?movieId=<?php echo $movieId; ?>" method="POST">
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
                <label class="col-sm-3 col-form-label" for="posterV">纵版影片海报</label>
                <div class="col-sm-3">
                    <img src="<?php echo $posterV; ?>" style="width: 100px;" />
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
                <label class="col-sm-3 col-form-label" for="type">横版影片海报</label>
                <div class="col-sm-3">
                    <img src="<?php echo $posterH; ?>" style="width: 100px;" />
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
                <label class="col-sm-12 col-form-label">角色和演员</label>
                <div id="roles">


                    <?php
                    switch ($movieStatus){
                        case '已上映':
                            $i =1;
                            foreach ($actors as $actor){

                                $role = $actor->role;
                                $roleId = $actor->roleId;
                                $roleDescription = $actor->roleDescription;

                                echo'
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">现有角色'.$i.'</span>
                                </div>
                                <input type="text" class="form-control" placeholder="角色名" aria-label="角色名" aria-describedby="basic-addon2" name="roleName[]" value="'.$role.'" required>
                                <input type="text" style="display:none;" name="roleId[]" value="'.$roleId.'">
                                <textarea class="col-sm-5" rows="3" name="roleDescription[]">'.$roleDescription.'</textarea>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-danger remove_field" id="'.$roleId.'" type="button">删除</button>
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

                                echo'
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">现有角色'.$i.'</span>
                                </div>
                                <input type="text" class="form-control" placeholder="角色名" aria-label="角色名" aria-describedby="basic-addon2" name="roleName[]" value="'.$roleName.'" required>
                                <input type="text" class="form-control" placeholder="分配的演员数" aria-label="分配的演员数" aria-describedby="basic-addon2" name="actorNumbers[]" value="'.$actorNumber.'" required>
                                <input type="text" style="display:none;" name="roleId[]" value="'.$roleId.'">
                                <textarea class="col-sm-5" rows="3" name="roleDescription[]">'.$roleDescription.'</textarea>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-danger remove_field" id="'.$roleId.'" type="button">删除</button>
                                </div>
                            </div>';

                                $i++;
                            }
                            break;
                    }

                    ?>
                </div>

                <button class="btn btn-success" type="button" id="addRole">添加角色</button>
            </div>


            <button class="btn btn-primary" type="submit" name="submit">保存修已修改信息</button>

        </form>

        <div class="form-group col-3">
            <div class="result"></div>
            <!-- save btn -->
            <button class="btn btn-success save hide">截取</button>
        </div>
        <div class="form-group col-3 img-result hide">
            <img class="cropped" src="" alt="">
        </div>
        <!-- input file -->
        <div class="form-group col-4">
            <div class="options hide">

            </div>
        </div>


    </div>

</div>


<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/cropperjs/0.8.1/cropper.min.js'></script>
<script src='https://code.jquery.com/jquery-3.1.0.min.js'></script>

<script  src="js/cropperPoster.js"></script>

<script>

    //初始参数个数
    $(document).ready(function() {
        var max_fields      = 100; //maximum input boxes allowed
        var wrapper         = $("#roles"); //Fields wrapper
        var add_button      = $("#addRole"); //Add button ID

        var x = 1; //initlal text box count
        $(add_button).click(function(e){ //on add input button click
            e.preventDefault();
            if(x < max_fields){ //max input box allowed
                x++; //text box increment
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
                    $(wrapper).append('<div class="input-group mb-3"><div class="input-group-prepend"><span class="input-group-text">新加角色</span></div>' +
                        '<input type="text" class="form-control" placeholder="此处填写角色名" aria-label="角色名" aria-describedby="basic-addon2" name="roleName[]" required>' +
                        '<textarea class="col-sm-5" rows="3" name="roleDescription[]" placeholder="此处填写角色简介"></textarea>' +
                        '<div class="input-group-append"><button class="btn btn-outline-danger" id="remove_field" type="button">删除</button></div></div>'); //add input box
                }else {
                    $(wrapper).append('<div class="input-group mb-3"><div class="input-group-prepend"><span class="input-group-text">新加角色</span></div>' +
                        '<input type="text" class="form-control" placeholder="此处填写角色名" aria-label="角色名" aria-describedby="basic-addon2" name="roleName[]" required>' +
                        '<input type="text" class="form-control" placeholder="分配的演员数" aria-label="分配的演员数" aria-describedby="basic-addon2" name="actorNumbers[]" required>' +
                        '<textarea class="col-sm-5" rows="3" name="roleDescription[]" placeholder="此处填写角色简介"></textarea>' +
                        '<div class="input-group-append"><button class="btn btn-outline-danger" id="remove_field" type="button">删除</button></div></div>'); //add input box
                }

            }
        });

        $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
            e.preventDefault(); $(this).parent('div').parent('div').remove(); x--;
            var roleId = this.id;
            $.ajax({
                type: "POST",
                url: 'controller/del.php?delRole='+roleId,
                data:{action:'call_this'},
                success:function(html) {
                    alert(html);
                }

            });
        })
    });


</script>
</body>
</html>