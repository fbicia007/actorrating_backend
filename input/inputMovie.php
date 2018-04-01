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

    <title>录入影视剧详细信息</title>
    <?php
    /**
     * Created by PhpStorm.
     * User: fbicia
     * Date: 2018/3/18
     * Time: 下午1:17
     */

    include_once "connect.php";

    $actorsSql = "SELECT * FROM `actors`";
    $stmt = $pdo->prepare($actorsSql);
    $stmt->execute();
    $resultActors = $stmt->fetchAll();
    ?>

</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">和风清穆-小程序后台管理系统</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="index.php">影片列表 <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="alist.php">演员列表</a>
            </li>
            <li class="nav-item dropdown active">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    数据录入
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="inputActor.php">录入演员</a>
                    <a class="dropdown-item active" href="inputMovie.php">录入影片</a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="comment.php">评论管理</a>
            </li>
        </ul>
    </div>
</nav>

<div class="container" style="margin-top: 2%;">
    <!-- Content here -->
    <div class="row">
        <div class="col-12 align-items-center justify-content-center">
            <h1>录入影视剧详细信息</h1>
            <p class="col-md-auto">请填写电影详细信息，选择演员同时分配角色，如果演员不存在，请自行添加演员资料</p>
        </div>
    </div>
    <div class="row">

        <!-- <form class="col-12"  enctype="multipart/form-data" action="inputMovieRoles.php" method="POST">-->
        <form class="col-6" enctype="multipart/form-data" action="controller/inputMovieRoles.php" method="POST">
            <div class="form-group row col-sm-12">
                <label class="col-sm-3 col-form-label" for="movieTitle">影片名称</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="movieTitle" name="movieTitle" required>
                </div>
            </div>
            <div class="form-group row col-sm-12">
                <label class="col-sm-3 col-form-label" for="director">导演</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="director" name="director" required>
                </div>
            </div>
            <div class="form-group row col-sm-12">
                <label class="col-sm-3 col-form-label" for="type">影片类型</label>
                <div class="col-sm-9">
                    <select id="type" class="form-control" name="type" required>
                        <option value="">请选择...</option>
                        <option value="电影">电影</option>
                        <option value="电视剧">电视剧</option>
                    </select>
                </div>
            </div>
            <fieldset class="form-group col-sm-12" style="border:0;">
                <div class="row">
                    <legend class="col-form-label col-sm-3 pt-0">影片状态</legend>
                    <div class="col-sm-9">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="online" value="1" required>
                            <label class="form-check-label">
                                已上映
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="offline" value="0" required>
                            <label class="form-check-label">
                                未上映
                            </label>
                        </div>
                    </div>
                </div>
            </fieldset>

            <div class="form-group row col-sm-12">
                <label class="col-sm-3 col-form-label" for="movieDescription">简介：</label>
                <div class="col-sm-9">
                    <textarea class="form-control" id="movieDescription" name="movieDescription" rows="5"></textarea>
                </div>

            </div>
            <div class="form-group row col-sm-12">
                <label class="col-sm-3 col-form-label" for="posterV">纵版海报</label>
                <div class="col-sm-9">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="posterV" name="posterV" required>
                        <input type="text" style="display: none;" id="posterVName" name="posterVName" value="">
                        <label class="custom-file-label" for="posterV">纵版海报</label>
                    </div>
                </div>
            </div>
            <div class="form-group row col-sm-12">
                <label class="col-sm-3 col-form-label" for="type">横版海报</label>
                <div class="col-sm-9">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="posterH" name="posterH" required>
                        <input type="text" style="display: none;" id="posterHName" name="posterHName" value="">
                        <label class="custom-file-label" for="posterH">横版海报</label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-form-label">添加角色</label>
                <button type="button" class="btn btn-info col-sm-2" id="addRole" style="display: none;">添加角色</button>
                <button type="button" class="btn btn-info col-sm-2" id="addRoleActors" style="display: none;">添加角色</button>
                <a class="btn btn-success" href="inputActor.php" id="addNewActor" target="_blank" style="display: none;">添加角色时没有找到演员？这里添加</a>
            </div>
            <div class="form-group">
                <div class="col-sm-12 form-inline" id="rolesForm">

                    <!--添加角色
                    <select id="actor" class="form-control col-sm-3" required>
                         <option value="">请选择...</option>
                         <option value="1">aaa</option>
                         <option value="2">bbb</option>
                         <option value="3">ccc</option>
                         <option value="4">ddd</option>
                         <option value="4">武警</option>
                     </select>
-->
                </div>

            </div>

            <button class="btn btn-primary" type="submit" name="submit" id="saveMovie">保存</button>

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
<script src='https://code.jquery.com/jquery-3.1.0.min.js'></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/cropperjs/0.8.1/cropper.min.js'></script>


<script>

    var x= 1; //已上映计数器
    var n= 1; //未上映计数器

    $('#offline').change(function() {
        $("#rolesForm").empty();
        x = 1;
        n = 1;
    })
    $('#online').change(function() {
        $("#rolesForm").empty();
        x = 1;
        n = 1;
    })


    $( "#offline" ).focus(function() {

        $( "#addRoleActors" ).show();
        $( "#addNewActor" ).show();
        $( "#addRole" ).hide();
        var x = 1;

    });
    $( "#online" ).focus(function() {

        $( "#addRoleActors" ).hide();
        $( "#addNewActor" ).show();
        $( "#addRole" ).show();
        var x = 1;
    });

    //已上映添加角色演员
    $(document).ready(function() {

        var max_fields      = 100; //maximum input boxes allowed
        var wrapper         = $("#rolesForm"); //Fields wrapper
        var add_button      = $("#addRole"); //Add button ID


        $(add_button).click(function(e){ //on add input button click
            e.preventDefault();
            $('#inputActorx').show();
            if(x < max_fields){ //max input box allowed



                var addRoleActor = $('<div class="input-group mb-12">\n' +
                    '                                <div class="input-group-prepend">\n' +
                    '                                    <span class="input-group-text">角色'+x+'</span>\n' +
                    '                                </div>\n' +
                    '                                <input type="text" class="form-control" placeholder="角色名" aria-label="角色名" aria-describedby="basic-addon2" name="roleName[]" required>\n' +
                    '                                <textarea class="col-sm-3" rows="1" name="roleDescription[]" placeholder="角色简介"></textarea>\n' +
                    '                                <select id="actor" class="custom-select" name="actors[]" required>\n' +
                    '                                   <option value="">请选择演员...</option>\n' +
                    '<?php foreach ($resultActors as $actor){ echo '<option value="'.$actor[id].'">'.$actor[name].'</option>';} ?> \n'+
                    '                                   </select>\n'+
                    '                                <div class="input-group-append">\n' +
                    '                                    <button class="btn btn-outline-danger remove_field" type="button">删除</button>\n' +
                    '                                </div>\n' +
                    '                            </div>');
                $(wrapper).append(addRoleActor);

                x++; //text box increment

            }
        });

        $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
            e.preventDefault(); $(this).parent('div').parent('div').remove(); x--;

        })
    });

    //未上映添加角色演员们
    $(document).ready(function() {
        var max_fields      = 100; //maximum input boxes allowed
        var wrapper         = $("#rolesForm"); //Fields wrapper
        var add_button      = $("#addRoleActors"); //Add button ID

        $(add_button).click(function(e){ //on add input button click
            e.preventDefault();
            if(n < max_fields){ //max input box allowed


                var addRoleActor = $('<div class="input-group mb-3">\n' +
                    '                                <div class="input-group-prepend">\n' +
                    '                                    <span class="input-group-text">角色'+n+'</span>\n' +
                    '                                </div>\n' +
                    '                                <input type="text" class="form-control" placeholder="角色名" aria-label="角色名" aria-describedby="basic-addon2" name="roleName[]" required>\n' +
                    '                                <textarea class="col-sm-5" rows="1" name="roleDescription[]" placeholder="角色简介"></textarea>\n' +
                    '                                <div class="input-group-prepend" id="addActors'+n+'">\n' +
                    '                                </div>\n' +
                    '                                <div class="input-group-append">\n' +
                    '                                    <button class="btn btn-outline-warning add_actor" id="add_actor" onclick="add_actors('+n+')" type="button">添加演员</button>\n' +
                    '                                    <button class="btn btn-outline-danger remove_field" type="button">删除角色</button>\n' +
                    '                                </div>\n' +
                    '                            </div>');
                $(wrapper).append(addRoleActor);
                n++; //text box increment

            }
        });

        $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
            e.preventDefault(); $(this).parent('div').parent('div').remove(); n--;

        })
    });

</script>
<script  src="js/cropperPoster.js"></script>
<script>

    function add_actors(roleNumber) {

        $(document).ready(function() {
            var max_fields      = 100; //maximum input boxes allowed
            var wrapper         = $("#addActors"+roleNumber); //Fields wrapper

            var z = 1; //initlal text box count
            if(z < max_fields){ //max input box allowed


                $(wrapper).append('<div>' +
                    '<select id="actor" class="custom-select" name="actors'+roleNumber+'[]" required>\n' +
                    '                                       <option value="">请选择演员...</option>\n' +
                    '<?php foreach ($resultActors as $actor){ echo '<option value="'.$actor[id].'">'.$actor[name].'</option>';} ?> \n'+
                    '                                   </select>' +
                    '                                    <button class="btn btn-outline-danger remove_actor" type="button">减少演员</button></div>');

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
        //判断用户名是否已经注册了
        $('#movieTitle').blur(function() {
            if ($('#movieTitle').val() != '') {
                $.post('controller/movieTitleCheck.php', {title : $('#movieTitle').val()}, function(data) {
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