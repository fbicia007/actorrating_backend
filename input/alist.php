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
    <div class="jumbotron jumbotron-fluid">
        <div class="container">
            <h1 class="display-4">演员列表</h1>
        </div>
    </div>
    <div class="row">

        <table class="table table-striped">
            <thead class="thead-light">
            <tr>
                <th scope="col">#</th>
                <th scope="col">姓名</th>
                <th scope="col">照片</th>
                <th scope="col">生日</th>
                <th scope="col">专精</th>
                <th scope="col">星座</th>
                <th scope="col">编辑/删除</th>
            </tr>
            </thead>
            <tbody>
            <?php
            include_once "connect.php";

            if($_POST['search']){

                $actorsSql = "SELECT * FROM `actors` WHERE actors.name LIKE ? OR description LIKE ? OR constellation LIKE ? OR birthplace LIKE ? OR profession LIKE ?";
                $stmt = $pdo->prepare($actorsSql);
                $stmt->execute(array('%'.$_POST['search'].'%','%'.$_POST['search'].'%','%'.$_POST['search'].'%','%'.$_POST['search'].'%','%'.$_POST['search'].'%'));

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
            $stmt->execute(array('%'.$_POST['search'].'%','%'.$_POST['search'].'%','%'.$_POST['search'].'%','%'.$_POST['search'].'%','%'.$_POST['search'].'%'));
            $resultPageActors = $stmt->fetchAll();

            $n = 1;

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
                <th scope="row">'.$n.'</th>
                <td>'.$name.'</td>
                <td><img style="width: 25px;" src="../images/actors/'.$photo.'"  alt="'.$name.'" /></td>
                <td>'.$birthday.'</td>
                <td>'.$profession.'</td>
                <td>'.$constellation.'</td>
                <td>
                   
                        <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" onclick=" imgViewer('.$id.')" data-target="#actorEditor'.$id.'">
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
                            <h5 class="modal-title" id="actorLabel">编辑演员:<span style="color: darkturquoise">'.$name.'</span>的详细资料</h5>
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
                                    <label class="col-sm-3 col-form-label" for="photo">更改照片</label>
                                    <div class="col-sm-9">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="photo'.$id.'" name="photo">
                                            <input type="text" style="display: none;" id="photoName'.$id.'" name="photoName" value="'.$photo.'">
                                            <label class="custom-file-label" for="photo">照片</label>
                                        </div>
                                    </div>
                                </div>
                
                            </form>
                            
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                            <button type="submit" class="btn btn-primary" form="actorEditorForm'.$id.'">保存</button>
                            
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
                            您确定要从列表中删除演员：<span style="color: darkturquoise">'.$name. '</span> 吗？
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                            <form action="controller/del.php" method="POST">
                                <input style="display: none;" name="actorId" value="' .$id.'">
                                <button type="submit" class="btn btn-danger">删除</button>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                </td>
            </tr>';

                $n++;

            }
            ?>

            <!--pic viewer-->
            <div style="z-index: 9999;">
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

            <!--end pic viewer-->

            </tbody>
        </table>
        <?php
        //Show page links
        for ($i = 1; $i <= $pages; $i++)
        {?>
            <tr id="<?php echo $i;?>"><a href="alist.php?page=<?php echo $i;?>"><?php echo $i;?></a></tr>
            <?php
        }
        ?>
    </div>

</div>


<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/cropperjs/0.8.1/cropper.min.js'></script>
<script src='https://code.jquery.com/jquery-3.1.0.min.js'></script>


<script  src="js/cropperActorEditor.js"></script>
</body>
</html>