<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>

<body>
    <div class="container mt-5 col-5">
        <div class="card">
            <div class="card-header bg-primary text-white">
                LOGIN
            </div>
            <form action="" method="POST">
                <?php
                if (session()->getFlashdata('error')) {
                ?>
                    <div class="alert alert-danger">
                        <?php echo session()->getFlashdata('error') ?>
                    </div>
                <?php
                }
                ?>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="username" class="form-label">
                            Username
                        </label>
                        <input type="text" name="user" class="form-control" value="<?php echo session()->getFlashdata('user') ?>" id="username" placeholder="Input Username">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">
                            Username
                        </label>
                        <input type="password" name="userpass" class="form-control" id="password" placeholder="Input Password">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">
                            Confirm Password
                        </label>
                        <input type="password" name="userpass" class="form-control" id="password" placeholder="Input Password">
                    </div>
                    <div class="mb-3">
                        <input type="submit" name="login" class="btn btn-primary" value="Login">
                    </div>
                </div>
        </div>
    </div>
    </form>
</body>

</html>