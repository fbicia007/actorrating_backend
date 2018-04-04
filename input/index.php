<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/theme.bootstrap_4.css" rel="stylesheet">

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
            <li class="nav-item active">
                <a class="nav-link" href="index.php">影片列表 <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
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
            <input class="form-control mr-sm-2" type="text" name="search" placeholder="搜索影片" aria-label="Search">
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
                    <h5 class="card-title">影片列表</h5>
                    <p class="card-text">在此可添加影片，对已有影片进行排序查看，编辑和删除操作。</p>
                    <a class="btn btn-outline-success" href="inputMovie.php">添加影片</a>
                </div>
            </div>
        </div>

    </div>
    <div class="row" style="text-align: center;">

        <table class="table table-striped tablesorter" id="myTable">
            <thead class="thead-light">
            <tr>
                <th scope="col">名称</th>
                <th scope="col">类型</th>
                <th scope="col">导演</th>
                <th scope="col">状态</th>
                <th scope="col" class="sorter-false filter-false">编辑/删除</th>
            </tr>
            </thead>
            <tbody>
            <?php
            include_once "connect.php";

            if($_POST['search']){

                //$moviesSql = "SELECT * FROM `movies` WHERE title LIKE ? OR director LIKE ?";
                $moviesSql = "SELECT * FROM `movies` WHERE title LIKE ?";
                $stmt = $pdo->prepare($moviesSql);
                //$stmt->execute(array('%'.$_POST['search'].'%','%'.$_POST['search'].'%'));
                $stmt->execute(array('%'.$_POST['search'].'%'));

            }else{

                $moviesSql = "SELECT * FROM `movies`";
                $stmt = $pdo->prepare($moviesSql);
                $stmt->execute();
            }

            $resultMovies = $stmt->fetchAll();

            #定义翻页
            $per_page = 10;//define how many results for a page
            $count = count($resultMovies);
            $pages = ceil($count / $per_page);

            if (empty($_GET['page'])) {
                $page = "1";
            } else {
                $page = $_GET['page'];
            }
            $start = ($page - 1) * $per_page;
            $pageSql = $moviesSql . " LIMIT $start,$per_page";
            $stmt = $pdo->prepare($pageSql);
            //$stmt->execute(array('%'.$_POST['search'].'%','%'.$_POST['search'].'%'));
            $stmt->execute(array('%'.$_POST['search'].'%'));
            $resultPageActors = $stmt->fetchAll();



            foreach ($resultMovies as $movie){
                $id = $movie[id];
                $title = $movie[title];
                $released = $movie[released];
                $director = $movie[director];
                $type = $movie[type];

                switch ($released){
                    case 1:
                        $status = '已上映';
                        break;
                    case 0:
                        $status = '未上映';
                        break;
                }

                echo '<tr>
                <td>'.$title.'</td>
                <td>'.$type.'</td>
                <td>'.$director.'</td>
                <td>'.$status.'</td>
                <td>
                    
                    <a class="btn btn-primary" href="movieEditor.php?page='.$_GET['page'].'&status='.$status.'&movieId='.$id.'">
                            编辑
                        </a>
                        <!-- Button trigger modal -->
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delet'.$id.'">
                      删除
                    </button>
                 
                    
                    <!-- Modal -->
                    <div class="modal fade" id="delet'.$id.'" tabindex="-1" role="dialog" aria-labelledby="deletLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="deletLabel">删除操作确认</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            您确定要从列表中删除影片 '.$title. '  吗？
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                            <form action="controller/del.php" method="POST">
                                <input style="display: none;" name="movieId" value="' .$id.'">
                                <input style="display: none;" name="pageDel" value="' .$_GET['page'].'">
                                <button type="submit" class="btn btn-danger" name="submit">删除</button>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                </td>
            </tr>';

            }

            ?>

            </tbody>
        </table>

        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item">
                    <?php
                    $akteullePage = $_GET['page'];
                    if($akteullePage && ($akteullePage!=1)){
                        $targetPage = $akteullePage-1;
                        echo '<a class="page-link" href="index.php?page='.$targetPage.'" aria-label="Previous">';
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
                //Show page links
                for ($i = 1; $i <= $pages; $i++)
                {
                    if(!$akteullePage){
                        if($i == 1){
                            echo '<li class="page-item" id="'.$i.'"><a class="page-link" style="background-color: #dee2e6;" href="comment.php?page='.$i.'">'.$i.'</a></li>';
                        }else{
                            echo '<li class="page-item" id="'.$i.'"><a class="page-link" href="index.php?page='.$i.'">'.$i.'</a></li>';
                        }
                    }else{
                        if($i == $akteullePage){
                            echo '<li class="page-item" id="'.$i.'"><a class="page-link" style="background-color: #dee2e6;" href="comment.php?page='.$i.'">'.$i.'</a></li>';
                        }else{
                            echo '<li class="page-item" id="'.$i.'"><a class="page-link" href="index.php?page='.$i.'">'.$i.'</a></li>';
                        }
                    }

                }
                ?>
                <li class="page-item">
                    <?php

                    if($akteullePage!=$i-1){
                        $targetPage = $akteullePage+1;
                        echo '<a class="page-link" href="index.php?page='.$targetPage.'" aria-label="Next">';
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
<script src="js/jquery.tablesorter.js"></script>
<script src="js/jquery.tablesorter.widgets.js"></script>
<script>
    $(function() {
        $("#myTable").tablesorter({
            theme : "bootstrap",
            //theme : "green",
        });
    });
</script>

</body>
</html>