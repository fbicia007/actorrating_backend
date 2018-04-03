<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Signin Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- Custom styles for this template -->
    <link href="css/signin.css" rel="stylesheet">
    <?php
    if(isset($_POST['submit'])){
        include_once 'connect.php';
        session_start();
        $username = $_POST['username'];
        $password = $_POST['password'];
        $_SESSION['login_user']=$username;

        $userSql = 'SELECT username FROM login WHERE username=? AND password=?';
        $stmt = $pdo->prepare($userSql);
        $stmt->execute(array($username,$password));
        $resultUserPW = $stmt->fetchAll();

        if(count($resultUserPW)!=0){
            echo "<script> location.href='test.php'; </script>";
        }else{
            echo "<script>alert('User Name Or Password Invalid!');</script>";
        }
    }
    ?>
</head>

<body class="text-center">
<form class="form-signin" method="post">
    <img class="mb-4" src="https://getbootstrap.com/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
    <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
    <label for="inputEmail" class="sr-only">Email address</label>
    <input type="email" id="inputEmail" name="username" class="form-control" placeholder="Email address" required autofocus>
    <label for="inputPassword" class="sr-only">Password</label>
    <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required>
    <div class="checkbox mb-3">
        <label>
            <input type="checkbox" value="remember-me"> Remember me
        </label>
    </div>
    <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
    <p class="mt-5 mb-3 text-muted">&copy; 2017-2018</p>
</form>
</body>
</html>
