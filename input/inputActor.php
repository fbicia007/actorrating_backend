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

    <title>录入演员</title>

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
                    <a class="nav-link" href="alist.php">列表</a>
                </li>
                <li class="nav-item dropdown active">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        数据录入
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item active" href="inputActor.php">录入演员</a>
                        <a class="dropdown-item" href="inputMovie.php">录入影片</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="comment.php">评论管理</a>
                </li>
            </ul>
        </div>
    </nav>
    <!-- Content here -->
    <div class="container" style="margin-top: 2%;">
        <div class="row">
            <div class="col-12 align-items-center justify-content-center">
                <h1>录入演员信息</h1>
                <p class="col-md-auto">请填写演员详细信息</p>
            </div>
        </div>
        <div class="row">

            <!-- <form class="col-12"  enctype="multipart/form-data" action="inputMovieRoles.php" method="POST">-->
            <form class="col-6" enctype="multipart/form-data" action="controller/inputActors.php" method="POST">

                <div class="form-group row col-sm-12">
                    <label class="col-sm-3 col-form-label" for="actorName">姓名</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="actorName" name="actorName" required>
                    </div>
                </div>
                <div class="form-group row col-sm-12">
                    <label class="col-sm-3 col-form-label" for="birthday">生日</label>
                    <div class="col-sm-9">
                        <input type="date" class="form-control" id="birthday" name="birthday">
                    </div>
                </div>
                <div class="form-group row col-sm-12">
                    <label class="col-sm-3 col-form-label" for="constellation">星座</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="constellation" name="constellation" value="" >
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
                        <input type="text" class="form-control" id="profession" name="profession" placeholder="演员，导演，编剧">
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
                    <div class="col-sm-9">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="photo" name="photo" required>
                            <input type="hidden" style="display: ;" id="photoName" name="photoName" >
                            <label class="custom-file-label" for="photo">上传图片</label>
                            <p id="error1" style="display:none; color:#FF0000;">
                                上传图片格式错误!
                            </p>
                            <p id="error2" style="display:none; color:#FF0000;">
                                上传图片过大，不能超过10M！
                            </p>
                        </div>
                        <footer style="display: block;font-size: 80%;color: #6c757d; margin-top: 5px;">请选择JPG，JPEG，PNG，GIF格式，小于10M的图片</footer>
                    </div>
                </div>

                <button class="btn btn-primary" type="submit" id="saveActor" name="submit">保存</button>
                <a class="btn btn-secondary" href="alist.php" name="submit">取消</a>


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
    <script src="js/cropperActor.js"></script>

    <script>

        //check image size and type
        var a=0;
        //binds to onchange event of your input field
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


        $('#birthday').bind('input', function() {

            $('#constellation').val(getConstellationByBirthday($(this).val()));
        });



    </script>

</body>
</html>
