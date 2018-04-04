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

    <link href="css/theme.bootstrap_4.css" rel="stylesheet">
    <title>录入影视剧详细信息</title>
    <?php
    $host = 'https://'.$_SERVER['HTTP_HOST'];
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
            <li class="nav-item active">
                <a class="nav-link" href="alist.php">演员列表</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    数据录入
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="inputActor.php">录入演员</a>
                    <a class="dropdown-item" href="inputMovie.php">录入影片</a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="comment.php">评论管理</a>
            </li>
        </ul>
        <form class="form-inline my-2 my-lg-0" method="post" id="search">
            <input class="form-control mr-sm-2" type="text" name="search" placeholder="搜索演员" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">搜索</button>
        </form>
    </div>
</nav>

<div class="container">
    <!-- Content here -->
    <div class="jumbotron row top">

        <div class="container">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">演员列表</h5>
                    <p class="card-text">在此可添加演员，对现有演员进行排序查看，编辑和删除操作。</p>
                    <a class="btn btn-outline-success" href="inputActor.php">添加演员</a>
                </div>
            </div>
        </div>

    </div>
    <div class="row" style="text-align: center;">

        <table class="table table-striped" id="myTable">
            <thead class="thead-light">
            <tr>
                <th scope="col">姓名</th>
                <th scope="col" class="sorter-false filter-false">照片</th>
                <th scope="col">生日</th>
                <th scope="col">职业</th>
                <th scope="col">星座</th>
                <th scope="col" class="sorter-false filter-false">编辑/删除</th>
            </tr>
            </thead>
            <tbody>
            <?php
            include_once "connect.php";

            if($_POST['search']){

                //$actorsSql = "SELECT * FROM `actors` WHERE actors.name LIKE ? OR description LIKE ? OR constellation LIKE ? OR birthplace LIKE ? OR profession LIKE ?";
                $actorsSql = "SELECT * FROM `actors` WHERE actors.name LIKE ?";
                $stmt = $pdo->prepare($actorsSql);
                //$stmt->execute(array('%'.$_POST['search'].'%','%'.$_POST['search'].'%','%'.$_POST['search'].'%','%'.$_POST['search'].'%','%'.$_POST['search'].'%'));
                $stmt->execute(array('%'.$_POST['search'].'%'));

            }else{

                $actorsSql = "SELECT * FROM `actors`";
                $stmt = $pdo->prepare($actorsSql);
                $stmt->execute();
            }


            $resultActors = $stmt->fetchAll();

            #定义翻页
            $per_page = 10;//define how many results for a page
            $count = count($resultActors);
            $pages = ceil($count / $per_page);

            if (empty($_GET['page'])) {
                $page = "1";
            } else {
                $page = $_GET['page'];
            }
            $start = ($page - 1) * $per_page;
            $pageSql = $actorsSql . " LIMIT $start,$per_page";
            $stmt = $pdo->prepare($pageSql);
            //$stmt->execute(array('%'.$_POST['search'].'%','%'.$_POST['search'].'%','%'.$_POST['search'].'%','%'.$_POST['search'].'%','%'.$_POST['search'].'%'));
            $stmt->execute(array('%'.$_POST['search'].'%'));
            $resultPageActors = $stmt->fetchAll();

            foreach ($resultPageActors as $actor){

                $id = $actor[id];
                $name = $actor[name];
                $birthday = $actor[birthday];
                $photo = $actor[photo];
                $profession = $actor[profession];
                $constellation = $actor[constellation];
                $birthplace = $actor[birthplace];
                $description = $actor[description];

                echo '<tr>
                
                <td>'.$name.'</td>
                <td><img style="width: 25px;" src="../images/actors/'.$photo.'"  alt="'.$name.'" /></td>
                <td>'.$birthday.'</td>
                <td>'.$profession.'</td>
                <td>'.$constellation.'</td>
                <td>
                   
                        <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" onclick=" imgViewer('.$id.');setConstellation('.$id.');" data-target="#actorEditor'.$id.'">
                      编辑
                    </button>
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delActor'.$id.'">
                      删除
                    </button>
                    
                    <!-- Modal editor -->
                    <div class="modal fade" id="actorEditor'.$id.'" tabindex="-1" role="dialog" aria-labelledby="actorLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="actorLabel">编辑演员: '.$name.' 的详细资料</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <form class="col-12" enctype="multipart/form-data" action="controller/editor.php?actorId='.$id.'" method="POST" id="actorEditorForm'.$id.'">
                                <div class="form-group row col-sm-12">
                                    <label class="col-sm-3 col-form-label">演员姓名</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="actorName'.$id.'" name="actorName" value="'.$name.'" required>
                                    </div>
                                </div>
                                <div class="form-group row col-sm-12">
                                    <label class="col-sm-3 col-form-label" for="birthday">生日</label>
                                    <div class="col-sm-9">
                                        <input type="date" class="form-control" id="birthday'.$id.'" name="birthday" value="'.$birthday.'" >
                                    </div>
                                </div>
                                <div class="form-group row col-sm-12">
                                    <label class="col-sm-3 col-form-label" for="constellation">星座</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="constellation'.$id.'" name="constellation" value="'.$constellation.'" >
                                    </div>
                                </div>
                                <div class="form-group row col-sm-12">
                                    <label class="col-sm-3 col-form-label" for="birthplace">出生地</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="birthplace'.$id.'" name="birthplace" value="'.$birthplace.'">
                                    </div>
                                </div>
                                <div class="form-group row col-sm-12">
                                    <label class="col-sm-3 col-form-label" for="profession">精通专业</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="profession'.$id.'" name="profession" placeholder="比如演员,导演等，用逗号隔开" value="'.$profession.'">
                                    </div>
                                </div>
                                <div class="form-group row col-sm-12">
                                    <label class="col-sm-3 col-form-label" for="actorDescription">简介：</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" id="actorDescription'.$id.'" name="actorDescription" rows="5">'.$description.'</textarea>
                                    </div>
                
                                </div>
                                <div class="form-group row col-sm-12">
                                    <label class="col-sm-3 col-form-label" for="photo">现有照片</label>
                                    <div class="col-sm-3 img-result'.$id.'">
                                        <img class="cropped'.$id.'" src="'.$host.'/actorrating/images/actors/'.$photo.'" style="width: 100px;" />
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="photo'.$id.'" name="photo">
                                            <input type="text" style="display: none;" id="photoName'.$id.'" name="photoName" value="'.$photo.'">
                                            <label class="custom-file-label" for="photo">更改照片</label>
                                        </div>
                                    </div>
                                </div>
                
                            </form>
                            
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="f1()">取消</button>
                            <button type="submit" class="btn btn-primary" id="saveActor'.$id.'" form="actorEditorForm'.$id.'">保存</button>
                            
                          </div>
                        </div>
                      </div>
                    </div>
                    
                    <!-- Modaldel -->
                    <div class="modal fade" id="delActor'.$id.'" tabindex="-1" role="dialog" aria-labelledby="actorLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="actorLabel">删除操作确认</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            您确定要从列表中删除演员：'.$name. ' 吗？
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                            <form action="controller/del.php" method="POST">
                                <input style="display: none;" name="actorId" value="' .$id.'">
                                <input style="display: none;" name="pageDel" value="' .$_GET['page'].'">
                                <button type="submit" class="btn btn-danger">删除</button>
                            </form>
                            
                          </div>
                        </div>
                      </div>
                    </div>
                </td>
            </tr>';

            }
            ?>
            <!--pic viewer-->
            <div class="uploadPic" style="position:absolute; z-index: 9999;">
                <div class="form-group col-3">
                    <div class="result"></div>
                    <!-- save btn -->
                    <button class="btn btn-success save hide">截取</button>
                </div>
                <!--<div class="form-group col-3 img-result hide">
                    <img class="cropped" src="" alt="">
                </div>-->
                <!-- input file -->
                <div class="form-group col-4">
                    <div class="options hide">

                    </div>
                </div>
            </div>

            <!--end pic viewer-->

            </tbody>
        </table>


        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item">
                    <?php
                        $akteullePage = $_GET['page'];
                        if($akteullePage && ($akteullePage!=1)){
                            $targetPage = $akteullePage-1;
                            echo '<a class="page-link" href="alist.php?page='.$targetPage.'" aria-label="Previous">';
                        }else{
                            echo '<a class="page-link" href="#" aria-label="Previous">';
                        }
                    ?>
                        <span aria-hidden="true">&laquo;</span>
                        <span class="sr-only">Previous</span>
                    </a>
                </li>
                <?php
                //Show page links
                for ($i = 1; $i <= $pages; $i++)
                {
                    if(!$akteullePage){
                        if($i == 1){
                            echo '<li class="page-item" id="'.$i.'"><a class="page-link" style="background-color: #dee2e6;" href="comment.php?page='.$i.'">'.$i.'</a></li>';
                        }else{
                            echo '<li class="page-item" id="'.$i.'"><a class="page-link" href="alist.php?page='.$i.'">'.$i.'</a></li>';
                        }
                    }else{
                        if($i == $akteullePage){
                            echo '<li class="page-item" id="'.$i.'"><a class="page-link" style="background-color: #dee2e6;" href="comment.php?page='.$i.'">'.$i.'</a></li>';
                        }else{
                            echo '<li class="page-item" id="'.$i.'"><a class="page-link" href="alist.php?page='.$i.'">'.$i.'</a></li>';
                        }
                    }

                }
                ?>
                <li class="page-item">
                    <?php

                    if($akteullePage!=$i-1){
                        $targetPage = $akteullePage+1;
                        echo '<a class="page-link" href="alist.php?page='.$targetPage.'" aria-label="Next">';
                    }else{
                        echo '<a class="page-link" href="#" aria-label="Next">';
                    }
                    ?>
                        <span aria-hidden="true">&raquo;</span>
                        <span class="sr-only">Next</span>
                    </a>
                </li>
            </ul>
        </nav>



    </div>

</div>


<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/cropperjs/0.8.1/cropper.min.js'></script>
<script src='https://code.jquery.com/jquery-3.1.0.min.js'></script>
<script src="js/jquery.tablesorter.js"></script>
<script src="js/jquery.tablesorter.widgets.js"></script>
<script>
    $(function() {
        $("#myTable").tablesorter({
            theme : "bootstrap",

        });
    });
</script>

<script  src="js/cropperActorEditor.js"></script>
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

    function setConstellation(id) {
        $('#birthday'+id).bind('input', function() {

            $('#constellation'+id).val(getConstellationByBirthday($(this).val()));
        });
    }

    function f1() {
        document.querySelector('.uploadPic').setAttribute('style','display:none;');
    }

</script>
</body>
</html>