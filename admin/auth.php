<?php
$users = array(
    'admin' => array(
        'login' => 'Victor',
        'password' => 'vfhfrfy'
    )
);
if(filter_input(INPUT_POST, 'auth')):
if ((filter_input(INPUT_POST, 'login') == $users['admin']['login']) && (filter_input(INPUT_POST, 'password') == $users['admin']['password'])):
    header("Location:" . '/admin/main.php');
else: $message = '<h3>В доступе отказано!</h3>';
endif;
endif;
?>
<!DOCTYPE html>
<html lang="ru">
    <head>
        <title>Auth</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
    <style>
        body{padding-top:50px;}
        h3{
            text-align: center;
        }
    </style>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Please sign in</h3>
                        </div>
                        <div class="panel-body">
                            <form method="post" accept-charset="UTF-8" role="form">
                                <fieldset>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Ваш логин:" name="login" type="text">
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Ваш пароль:" name="password" type="password">
                                    </div>
                                    <input class="btn btn-lg btn-success btn-block" type="submit" value="Войти" name="auth">
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?= $message ?>
    </body>
</html>
