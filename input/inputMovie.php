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

    <title>录入影片详细信息</title>
    <?php
    /**
     * Created by PhpStorm.
     * User: fbicia
     * Date: 2018/3/18
     * Time: 下午1:17
     */

    include_once "connect.php";

    $actorsSql = "SELECT * FROM actors ORDER BY CONVERT( name USING gbk ) COLLATE gbk_chinese_ci ASC";
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
            <h1>录入影片详细信息</h1>
            <p class="col-md-auto">请填写影片详细信息，选择演员同时分配角色，如果演员不存在，请自行添加演员资料</p>
        </div>
    </div>
    <div class="row">

        <!-- <form class="col-12"  enctype="multipart/form-data" action="inputMovieRoles.php" method="POST"> -->
        <form class="col-6" style="text-align: left;" enctype="multipart/form-data" action="controller/inputMovieRoles.php" method="POST">
            <div class="form-group row col-sm-12">
                <label class="col-sm-3 col-form-label" for="movieTitle">名称</label>
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
                <label class="col-sm-3 col-form-label" for="type">类型</label>
                <div class="col-sm-9">
                    <select id="type" class="form-control" name="type" required>
                        <option value="">请选择...</option>
                        <option value="电影">电影</option>
                        <option value="电视剧">电视剧</option>
                    </select>
                </div>
            </div>
            <div class="form-group col-sm-12" style="border:0;">
                <div class="row">
                    <legend class="col-form-label col-sm-3 pt-0">状态</legend>
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
            </div>

            <div class="form-group row col-sm-12">
                <label class="col-sm-3 col-form-label" for="movieDescription">简介</label>
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
                        <label class="custom-file-label" for="posterV">上传图片</label>
                    </div>
                    <p id="error3" style="display:none; color:#FF0000;">
                        上传图片格式错误!
                    </p>
                    <p id="error4" style="display:none; color:#FF0000;">
                        上传图片过大，不能超过10M！
                    </p>
                    <footer style="display: block;font-size: 80%;color: #6c757d; margin-top: 5px;">请选择JPG，JPEG，PNG，GIF格式，小于10M的图片</footer>
                </div>

            </div>
            <div class="form-group row col-sm-12">
                <label class="col-sm-3 col-form-label" for="type">横版海报</label>
                <div class="col-sm-9">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="posterH" name="posterH" required>
                        <input type="text" style="display: none;" id="posterHName" name="posterHName" value="">
                        <label class="custom-file-label" for="posterH">上传图片</label>
                    </div>
                    <p id="error5" style="display:none; color:#FF0000;">
                        上传图片格式错误!
                    </p>
                    <p id="error6" style="display:none; color:#FF0000;">
                        上传图片过大，不能超过10M！
                    </p>
                    <footer style="display: block;font-size: 80%;color: #6c757d; margin-top: 5px;">请选择JPG，JPEG，PNG，GIF格式，小于10M的图片</footer>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-form-label" style="margin-top: 20px;">角色和演员</label>
                <span id="example" class="d-inline-block" tabindex="0" data-toggle="tooltip" title="选择状态后激活此功能">
                    <button class="btn btn-info" style="pointer-events: none;" type="button" disabled>添加角色</button>
                </span>

                <button type="button" class="btn btn-info col-sm-2" id="addRole" style="display: none;" onclick="$('#addNewActor').show();">添加角色</button>
                <button type="button" class="btn btn-info col-sm-2" id="addRoleActors" style="display: none;">添加角色</button>
                <a class="btn btn-success" id="addNewActor" data-toggle="modal" onclick="setConstellation();" data-target="#addActorEditor" style="display: none;">添加角色时没有找到演员？这里添加</a>

            </div>

            <div class="form-group">
                <div class="col-sm-12 form-inline" id="rolesForm">


                </div>

            </div>
            <div class="form-group">
                <a class="btn btn-secondary" href="index.php" name="submit">取消</a>
                <button class="btn btn-primary" type="submit" name="submit" id="saveMovie">保存</button>
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
                        <form class="col-12" enctype="multipart/form-data" method="POST" onsubmit="return insertNewActor()" id="addActorEditorForm">
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
                                    <footer style="display: block;font-size: 80%;color: #6c757d; margin-top: 5px;">请选择JPG，JPEG，PNG，GIF格式，小于10M的图片</footer>
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

        <div class="col-6">

            <div class="col-sm-9">
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


            <div class="col-sm-9">
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

            <div class="col-sm-12">
                <div class="form-group col-6 img-resultA hide">
                    <label type="text">照片预览</label>

                </div>
                <div class="form-group col-12">
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

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<!--<script src='https://code.jquery.com/jquery-3.1.0.min.js'></script>-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/cropperjs/0.8.1/cropper.min.js'></script>
<script src='js/bootstrap-select.js'></script>
<script  src="js/cropperPoster.js"></script>

<script>
    //resetFormaddActorEditor

    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
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

    $( "#offline" ).click(function() {

        $( "#addRoleActors" ).show();
        //$( "#addNewActor" ).show();
        $( "#addRole" ).hide();
        $( "#addNewActor" ).hide();
        $( "#example" ).remove();
        var x = 1;

    });
    $( "#online" ).click(function() {

        $( "#addRoleActors" ).hide();
        $( "#example" ).remove();
        //$( "#addNewActor" ).show();
        $( "#addRole" ).show();
        //$( "#addNewActor" ).hide();
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



                var addRoleActor = $(
                    '<div class="col-md-12" style="margin-bottom:30px;">\n' +
                    '                                <div class="form-group jumbotron" style="padding: 1rem 1rem; padding-bottom:75px;">\n' +
                    '                                   <span class="col-sm-3" style="padding: .375rem .75rem;">角色'+x+'：</span>\n' +
                    '                                   <input type="text" class="form-control col-sm-9" placeholder="角色名" style="margin-bottom:5px;" id="focus'+x+'" aria-label="角色名" aria-describedby="basic-addon2" name="roleName[]" required>\n' +
                    '                                   <span class="col-sm-3" style="padding: .375rem .75rem;">演员：</span>\n' +
                    '                                   <select id="actor" class="selectpicker show-tick form-control custom-select col-sm-9" name="actors[]" data-live-search="true" required>\n' +
                    '                                       <option value="">添加备选演员...</option>\n' +
                    '<?php foreach ($resultActors as $actor){ echo '<option value="'.$actor[id].'">'.$actor[name].'</option>';} ?> \n'+
                    '                                   </select>\n'+
                    '                                   <textarea class="form-control col-sm-12" style="margin-top:10px; display:none;" rows="3" name="roleDescription[]" placeholder="角色简介"></textarea>\n' +
                    '                                </div>\n' +
                    '                                <div class="form-group col-md-12" style="margin-top:-55px;">\n' +
                    '                                    <button class="btn btn-danger remove_field col-md-12" type="button">删除</button>\n' +
                    '                                </div>\n' +
                    '                            </div>');
                $(addRoleActor).appendTo(wrapper);
                $('select').selectpicker("refresh");

                $('#focus'+x).focus();
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


                var addRoleActor = $('<div class="col-md-12" style="margin-bottom: 30px;">\n' +
                    '                                <div class="form-group jumbotron" style="padding: 1rem 1rem; padding-bottom:72px;">\n' +
                    '                                    <span class="col-sm-2" style="padding: .375rem .75rem;">角色'+n+':</span>\n' +
                    '                                <input type="text" class="form-control col-sm-10" placeholder="角色名" aria-label="角色名" aria-describedby="basic-addon2" id="focus'+n+'" name="roleName[]" required>\n' +
                    '                                    <span class="col-sm-2" style="padding: .375rem .75rem;">简介</span>\n' +
                    '                                <textarea class="form-control col-sm-10" style="margin-top: 10px;" rows="3" name="roleDescription[]" placeholder="角色简介"></textarea>\n' +
                    '<div class="form-group col-sm-12" style="margin-top: 5px; margin-bottom: 3px;">'+
                    '<label for="inputAddress2">添加/修改备选演员</label>'+
                    '                                    <button class="btn btn-outline-success add_actor" style="margin-left: 5px;" id="add_actor" onclick="$(\'#addNewActor\').show();add_actors('+n+')" type="button">添加演员</button>\n' +
                    '</div>'+
                    '                                <div class="col-sm-12" id="addActors'+n+'">\n' +
                    '                                </div>\n' +
                    '                                </div>\n' +
                    '                                <div class="form-group col-md-12" style="margin-top: -60px;">\n' +
                    '                                    <button class="btn btn-danger remove_field col-md-12" type="button">删除角色</button>\n' +
                    '                                </div>\n' +
                    '                            </div>');
                $(wrapper).append(addRoleActor);
                $('#focus'+n).focus();
                n++; //text box increment

            }
        });

        $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
            e.preventDefault(); $(this).parent('div').parent('div').remove(); n--;

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


                $(wrapper).append(
                //var addSelectActors = $(
                    '<div style="margin-top:5px;">' +
                    '<select id="actor" class="selectpicker show-tick col-sm-9" name="actors'+roleNumber+'[]" data-live-search="true" required>\n' +
                    '                                       <option value="">请选择演员...</option>\n' +
                    '<?php foreach ($resultActors as $actor){ echo '<option value="'.$actor[id].'">'.$actor[name].'</option>';} ?> \n'+
                    '                                   </select>' +
                    '                                    <button class="btn btn-outline-danger col-sm-2 remove_actor" type="button">移除</button>' +
                    '</div>');

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
        //判断用户名是否已经注册了
        $('#movieTitle').blur(function() {
            if ($('#movieTitle').val() != '') {
                $.post('controller/movieTitleCheck.php', {title : $('#movieTitle').val()}, function(data) {
                    if (data == 0) {
                        alert('数据库中已经有此影片，不能重复录入！');
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