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
    <!-- pager plugin -->
    <link rel="stylesheet" href="css/jquery.tablesorter.pager.css">
    <style>
        .tablesorter-pager .btn-group-sm .btn {
            font-size: 1.2em; /* make pager arrows more visible */
        }
    </style>

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
            <li class="nav-item active">
                <a class="nav-link" href="comment.php">评论管理</a>
            </li>
        </ul>
        <form class="form-inline my-2 my-lg-0" method="post" id="search">
            <input class="form-control mr-sm-2" type="text" name="search" placeholder="搜索评论" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">搜索</button>
        </form>
        <?php
        session_start();

        if($_SESSION['username']){
            //echo 'Welcome'.$_SESSION['username'];
            echo '<form class="form-inline my-2 my-lg-0" method="post" action="../index.php" id="logout"><button class="btn btn-secondary offset-sm-1" name="logout" type="submit" form="logout">退出登陆</button> </form>';

        }
        else{
            header('Location: ../index.php');
        }
        ?>
    </div>
</nav>

<div class="container">
    <!-- Content here -->
    <div class="jumbotron row top">

        <div class="container">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">评分管理</h5>
                    <p class="card-text">在此可浏览演员评分和用户评论，可对评论进行删除操作。</p>
                </div>
            </div>
        </div>

    </div>
    <div class="row" style="text-align: center;">

        <table class="table table-striped" id="myTable">
            <thead class="thead-light">
            <tr>
                <th scope="col">演员</th>
                <th scope="col" class="sorter-false filter-false">照片</th>
                <th scope="col">评分</th>
                <th scope="col" class="sorter-false filter-false" style="width: 500px;">评论内容</th>
                <th scope="col">评论人</th>
                <th scope="col">时间</th>
                <th scope="col" class="sorter-false filter-false">删除</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th colspan="7" class="ts-pager">
                    <div class="Page navigation">
                        <div class="btn-group btn-group-sm mx-1" role="group">
                            <button type="button" class="btn btn-secondary first" style="padding-top: 8px;" title="回首页">⇤</button>
                            <button type="button" class="btn btn-secondary prev" title="上一页">←</button>
                        </div>
                        <span class="pagedisplay"></span>
                        <div class="btn-group btn-group-sm mx-1" role="group">
                            <button type="button" class="btn btn-secondary next" title="下一页">→</button>
                            <button type="button" class="btn btn-secondary last" style="padding-top: 8px;" title="最后一页">⇥</button>
                        </div>
                        <!--<div class="col-sm-5">
                            <select class="form-control-sm custom-select px-1 pagesize" title="Select page size">
                                <option selected="selected" value="10">10</option>
                                <option value="20">20</option>
                                <option value="30">30</option>
                                <option value="all">All Rows</option>
                            </select>
                            <select class="form-control-sm custom-select px-4 mx-1 pagenum" title="Select page number"></select>
                        </div>-->

                    </div>
                </th>
            </tr>
            </tfoot>
            <tbody>
            <?php
            include_once "connect.php";
            #search
            if($_POST['search']){

                $actorsSql = "SELECT * FROM `actors` INNER JOIN actorVote ON actors.id = actorVote.actorId WHERE actors.name LIKE ? OR actorVote.comment LIKE ?";
                $stmt = $pdo->prepare($actorsSql);
                $stmt->execute(array('%'.$_POST['search'].'%','%'.$_POST['search'].'%'));


            }else{

                $actorsSql = "SELECT * FROM actors INNER JOIN actorVote ON actors.id = actorVote.actorId ORDER BY CONVERT( actors.name USING gbk ) COLLATE gbk_chinese_ci ASC";
                $stmt = $pdo->prepare($actorsSql);
                $stmt->execute();
            }


            $resultActors = $stmt->fetchAll();


            foreach ($resultActors as $actor){

                $id = $actor[id];
                $name = $actor[name];
                $photo = $actor[photo];
                $comment = $actor[comment];
                $vote = $actor[vote];
                $timestamp = date("Y-m-d H:i",strtotime($actor[timestamp]));
                $openId = $actor[openId];

                $userSql = "SELECT * FROM cSessionInfo WHERE open_id = ?";
                $stmt = $pdo->prepare($userSql);
                $stmt->execute(array($openId));
                $resultUser = $stmt->fetchAll();

                $userObj = json_decode($resultUser[0]['user_info']);
                $user = $userObj->nickName;

                $actorId = $actor[actorId];

                echo '<tr>
                <td>'.$name.'</td>
                <td><img style="width: 25px;" src="../images/actors/'.$photo.'"  alt="'.$name.'" /></td>
                <td>'.$vote.'</td>
                <td>'.$comment.'</td>              
                <td>'.$user.'</td>
                <td>'.$timestamp.'</td>
                <td>
                    
                        <!-- Button trigger modal -->
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delActor'.$id.$openId.'">
                      删除
                    </button>
                    
                    <!-- Modal -->
                    <div class="modal fade" id="delActor'.$id.$openId.'" tabindex="-1" role="dialog" aria-labelledby="actorLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="actorLabel">删除操作确认</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            您确定要从列表中删除这条评论吗？
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                            <form action="controller/del.php" method="POST">
                                <input style="display: none;" name="openId" value="' .$openId.'">
                                <input style="display: none;" name="actorId" value="' .$actorId.'">
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

            </tbody>
        </table>
    </div>

</div>


<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="js/jquery.tablesorter.js"></script>
<script src="js/jquery.tablesorter.widgets.js"></script>
<script src="js/jquery.tablesorter.pager.js"></script>
<script>
    $(function() {

        $("table").tablesorter({
            theme : "bootstrap",

            //widthFixed: true,

            // widget code contained in the jquery.tablesorter.widgets.js file
            // use the zebra stripe widget if you plan on hiding any rows (filter widget)
            // the uitheme widget is NOT REQUIRED!
            widgets : [ "columns", "zebra" ],

            widgetOptions : {
                // using the default zebra striping class name, so it actually isn't included in the theme variable above
                // this is ONLY needed for bootstrap theming if you are using the filter widget, because rows are hidden
                zebra : ["even", "odd"],

                // class names added to columns when sorted
                columns: [ "primary", "secondary", "tertiary" ],

                // reset filters button
                filter_reset : ".reset",

                // extra css class name (string or array) added to the filter element (input or select)
                filter_cssFilter: [
                    'form-control',
                    'form-control',
                    'form-control', // select needs custom class names :(
                    'form-control',
                    'form-control',
                    'form-control',
                    'form-control'
                ]

            }
        })
            .tablesorterPager({

                // target the pager markup - see the HTML block below
                container: $(".ts-pager"),

                // target the pager page select dropdown - choose a page
                cssGoto  : ".pagenum",

                // remove rows from the table to speed up the sort of large tables.
                // setting this to false, only hides the non-visible rows; needed if you plan to add/remove rows with the pager enabled.
                removeRows: false,

                // output string - default is '{page}/{totalPages}';
                // possible variables: {page}, {totalPages}, {filteredPages}, {startRow}, {endRow}, {filteredRows} and {totalRows}
                output: '{startRow} - {endRow} / {filteredRows} ({totalRows})'

            });

    });
</script>
</body>
</html>