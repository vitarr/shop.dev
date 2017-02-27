<?php
$filename = 'users.txt';
$handle = fopen($filename, 'r');
$users = unserialize(fgets($handle));
fclose($handle);
$message = '';
session_start();
$count = '';
if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
    $cart = $_SESSION['cart'];
    $count = '(' . count($_SESSION['cart']) . ')';
}
if (filter_input(INPUT_POST, 'login-submit')):
    if (((filter_input(INPUT_POST, 'login') == $users['admin']['login']) && (filter_input(INPUT_POST, 'password') == $users['admin']['password'])) || ((filter_input(INPUT_POST, 'login') == $users['Anton']['login']) && (filter_input(INPUT_POST, 'password') == $users['Anton']['password']))):
        $_SESSION['auth'] = filter_input(INPUT_POST, 'login');
        header("Location:" . '../');
    else: $message = '<div class="alert alert-danger">
                    <h2 style="text-align: center">Отказ!</h2><h3 style="text-align: center">Введены неверные данные.</h3>
                </div>';
    endif;
endif;
if (filter_input(INPUT_POST, 'exit')):
    unset($_SESSION['auth']);
    header("Location:" . $_SERVER['PHP_SELF']);
endif;
?>
<!DOCTYPE html>
<html lang="ru">
    <head>
        <title>Auth</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link href="../css/auth.css" rel="stylesheet" type="text/css"/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="../js/auth.js" type="text/javascript"></script>
    </head>
    <body>
        <nav class="navbar navbar-inverse">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>                        
                    </button>
                    <a class="navbar-brand" href="../"><span class="glyphicon glyphicon-globe"></span></a>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="nav navbar-nav">
                        <li><a href="../">Каталог</a></li>
                        <li><a href="../categories.php">Категории</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="../cart/"><span class="glyphicon glyphicon-shopping-cart"></span><?= $count ?> Корзина</a></li>
                        <?php
                        if (!isset($_SESSION['auth'])):
                            ?>
                            <li><a href="../admin/auth.php"><span class="glyphicon glyphicon-log-in"></span> Войти</a></li>
                            <?php
                        else:
                            ?>
                            <li><a href=""><span class="glyphicon glyphicon-log-in"></span> Привет, <?= $_SESSION['auth'] ?></a></li>    
                            <li><form method="post" class="form-inline"><input type="submit" name="exit" value="Выйти" class="btn btn-link"><span class="glyphicon glyphicon-log-in"></span></form></li>
                        <?php
                        endif;
                        ?>
                    </ul>
                </div>
            </div>
        </nav>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="panel panel-login">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-6">
                                    <a href="#" class="active" id="login-form-link">Авторизация</a>
                                </div>
                                <div class="col-xs-6">
                                    <a href="#" id="register-form-link">Регистрация</a>
                                </div>
                            </div>
                            <hr>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <form id="login-form" method="post" role="form" style="display: block;">
                                        <div class="form-group">
                                            <input type="text" name="login" id="username" tabindex="1" class="form-control" placeholder="Ваш логин:">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="Ваш пароль:">
                                        </div>
                                        <div class="form-group text-center">
                                            <input type="checkbox" tabindex="3" class="" name="remember" id="remember">
                                            <label for="remember"> Запомнить меня</label>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-6 col-sm-offset-3">
                                                    <input type="submit" name="login-submit" id="login-submit" tabindex="4" class="form-control btn btn-login" value="Войти">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="text-center">
                                                        <a href="" tabindex="5" class="forgot-password">Забыли пароль?</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <form id="register-form" method="post" role="form" style="display: none;">
                                        <div class="form-group">
                                            <input type="text" name="username" id="username" tabindex="1" class="form-control" placeholder="Ваш логин:" value="">
                                        </div>
                                        <div class="form-group">
                                            <input type="email" name="email" id="email" tabindex="1" class="form-control" placeholder="Ваш Email:" value="">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="Ваш пароль:">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="confirm-password" id="confirm-password" tabindex="2" class="form-control" placeholder="Подтвердите ваш пароль:">
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-6 col-sm-offset-3">
                                                    <input type="submit" name="register-submit" id="register-submit" tabindex="4" class="form-control btn btn-register" value="Зарегистрироваться">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <?= $message ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <footer class="text-center">
            <h5>Developed by Victor :)</h5>
        </footer>
</html>
