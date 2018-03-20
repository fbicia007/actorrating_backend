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
        <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>
    </div>
</nav>

<div class="container">
    <!-- Content here -->
    <div class="jumbotron jumbotron-fluid">
        <div class="container">
            <h1 class="display-4">影片列表</h1>
        </div>
    </div>
    <div class="row">

        <table class="table table-striped">
            <thead class="thead-light">
            <tr>
                <th scope="col">#</th>
                <th scope="col">影片名</th>
                <th scope="col">影片类型</th>
                <th scope="col">导演</th>
                <th scope="col">状态</th>
                <th scope="col">编辑/删除</th>
            </tr>
            </thead>
            <tbody>
            <?php
            include_once "connect.php";

            $moviesSql = "SELECT * FROM `movies`";
            $stmt = $pdo->prepare($moviesSql);
            $stmt->execute();
            $resultMovies = $stmt->fetchAll();

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
                <th scope="row">'.$id.'</th>
                <td>'.$title.'</td>
                <td>'.$type.'</td>
                <td>'.$director.'</td>
                <td>'.$status.'</td>
                <td>
                    <a class="col-sm-5" href="editor.php?movieId='.$id.'">
                            <button type="button" class="btn btn-primary">编辑</button>
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
                            您确定要从列表中删除演员：<span style="color: darkturquoise">'.$title.'</span> 吗？
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                            <form action="controlle/del.php" method="POST">
                                <input style="display: none;" name="movieId" value="'.$id.'">
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


    </div>

</div>


<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>
</html>