<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>和风清穆-小程序后台管理系统</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- Custom styles for this template -->
    <link href="input/css/signin.css" rel="stylesheet">

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src='https://code.jquery.com/jquery-3.1.0.min.js'></script>
    <?php

    session_start();

    if(isset($_POST['btnLogin'])){

        include_once 'pdo_connect.php';

        $username = $_POST['username'];
        $password = $_POST['password'];


        $_SESSION['login_user']=$username;

        $userSql = 'SELECT username FROM login WHERE username=? AND password=?';
        $stmt = $pdo->prepare($userSql);
        $stmt->execute(array($username,$password));
        $resultUserPW = $stmt->fetchAll();

        if(count($resultUserPW) > 0){

            if(!empty($_POST['remember'])){
                setcookie('username',$username, time()+60*60*7);
                setcookie('password',$password, time()+60*60*7);
            }else{
                if(isset($_COOKIE['username'])) {

                    setcookie('username', '');
                }
                if(isset($_COOKIE['password'])) {

                    setcookie('password', '');
                }
            }

            $_SESSION['username'] = $username;
            header('Location: ./input/index.php');

        }else{

            echo '<script>

                        $(document).ready(function(){ 
                            $("#error").slideDown("slow"); 
                        });
                    
                    </script>';

        }
    }

    if(isset($_POST['logout'])){

            session_destroy();


    }


    ?>
</head>

<body class="text-center">
<form class="form-signin" method="post">
    <img class="mb-4" src="images/logo.png" alt="" width="150" height="150">

    <label for="inputUsername" class="sr-only">Email address</label>
    <input type="text" id="inputUsername" name="username" class="form-control" placeholder="用户名" value="<?php if(isset($_COOKIE['username'])){echo $_COOKIE['username']; } ?>" required autofocus>
    <label for="inputPassword" class="sr-only">Password</label>
    <input type="password" id="inputPassword" name="password" class="form-control" placeholder="密码" value="<?php if(isset($_COOKIE['password'])){echo $_COOKIE['password']; } ?>" required>
    <p id="error" style="display: none;" class="text-danger">登陆信息错误.</p>
    <div class="checkbox mb-3">
        <label>
            <input type="checkbox" name="remember" value="remember-me" <?php if(isset($_COOKIE['username'])){echo 'checked'; } ?> > Remember me
        </label>
    </div>
    <button class="btn btn-lg btn-primary btn-block" name="btnLogin" type="submit">登陆</button>
    <p class="mt-5 mb-3 text-muted">&copy; 2018 和风清穆</p>
</form>

</body>
</html>
