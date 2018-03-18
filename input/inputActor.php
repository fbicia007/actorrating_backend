<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    <title>录入演员</title>

</head>
<body>

<div class="container">
    <!-- Content here -->
    <div class="container">
        <div class="row">
            <div class="col-12 align-items-center justify-content-center">
                <h1>录入演员信息</h1>
                <p class="col-md-auto">请填写演员详细信息</p>
            </div>
        </div>
        <div class="row">

            <!-- <form class="col-12"  enctype="multipart/form-data" action="inputMovieRoles.php" method="POST">-->
            <form class="col-12" enctype="multipart/form-data" action="controlle/inputActors.php" method="POST">
                <div class="form-group row col-sm-5">
                    <label class="col-sm-3 col-form-label" for="actorName">演员姓名</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="actorName" name="actorName" required>
                    </div>
                </div>
                <div class="form-group row col-sm-5">
                    <label class="col-sm-3 col-form-label" for="birthday">生日</label>
                    <div class="col-sm-9">
                        <input type="date" class="form-control" id="birthday" name="birthday" required>
                    </div>
                </div>
                <div class="form-group row col-sm-5">
                    <label class="col-sm-3 col-form-label" for="constellation">星座</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="constellation" name="constellation" required>
                    </div>
                </div>
                <div class="form-group row col-sm-5">
                    <label class="col-sm-3 col-form-label" for="birthplace">出生地</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="birthplace" name="birthplace" required>
                    </div>
                </div>
                <div class="form-group row col-sm-5">
                    <label class="col-sm-3 col-form-label" for="profession">精通专业</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="profession" name="profession" placeholder="比如演员,导演等，用逗号隔开" required>
                    </div>
                </div>
                <div class="form-group row col-sm-5">
                    <label class="col-sm-3 col-form-label" for="actorDescription">简介：</label>
                    <div class="col-sm-9">
                        <textarea class="form-control" id="actorDescription" name="actorDescription" rows="5"></textarea>
                    </div>

                </div>
                <div class="form-group row col-sm-5">
                    <label class="col-sm-3 col-form-label" for="photo">照片</label>
                    <div class="col-sm-9">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="photo" name="photo" required>
                            <label class="custom-file-label" for="photo">照片</label>
                        </div>
                    </div>
                </div>

                <button class="btn btn-primary" type="submit" name="submit">保存</button>

            </form>
        </div>
    </div>

</div>


<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>
</html>
