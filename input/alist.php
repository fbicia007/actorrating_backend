<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

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
            <input class="form-control mr-sm-2" type="text" name="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
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

                echo '<tr>
                <th scope="row">'.$n.'</th>
                <td>'.$name.'</td>
                <td><img style="width: 25px;" src="../images/actors/'.$photo.'"  alt="'.$name.'" /></td>
                <td>'.$birthday.'</td>
                <td>'.$profession.'</td>
                <td>'.$constellation.'</td>
                <td>
                    <a class="col-sm-5" href="./controller/editor.php?actorId='.$id.'">
                            <button type="button" class="btn btn-primary">编辑</button>
                        </a>
                        <!-- Button trigger modal -->
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delActor'.$id.'">
                      删除
                    </button>
                    
                    <!-- Modal -->
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

</body>
</html>