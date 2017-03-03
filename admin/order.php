<?php
session_start();
if (!isset($_SESSION['auth'])):
    header("Location:" . '../');
endif;
$orders_file = file_exists('orders.txt');
$file = file_exists('goods.txt');
if ($orders_file):
    $orders_filename = 'orders.txt';
    $orders_handle = fopen($orders_filename, 'r');
    if ($orders_handle):
        $orders_array = unserialize(fgets($orders_handle));
        (array) $orders_array;
        fclose($orders_handle);
    endif;
endif;
if ($file):
    $filename = 'goods.txt';
    $handle = fopen($filename, 'r');
    if ($handle):
        $array = unserialize(fgets($handle));
        (array) $array;
        fclose($handle);
    endif;
endif;
if (filter_input(INPUT_POST, 'exit')):
    unset($_SESSION['auth']);
    header("Location:" . '../');
endif;
?>
<!DOCTYPE html>
<html lang="ru">
    <head>
        <title>Admin</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link href="../css/admin.css" rel="stylesheet" type="text/css"/>
        <link href="../css/checkout.css" rel="stylesheet" type="text/css"/>
        <style>
            textarea{
                height: 36px;
            }
        </style>
    </head>
    <body data-spy="scroll" data-target=".navbar" data-offset="50">
        <nav class="navbar navbar-inverse" data-spy="affix">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>                        
                    </button>
                    <a class="navbar-brand" href="index.php">Админ-панель:</a>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="nav navbar-nav">
                        <li><a href="goods.php">Товары</a></li>
                        <li><a href="categories.php">Категории</a></li>
                        <li class="active"><a href="orders.php">Заказы</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="../"><span class="glyphicon glyphicon-log-in"></span> На сайт</a></li>
                        <li><form method="post" class="form-inline"><input type="submit" name="exit" value="Выйти" class="btn btn-link"><span class="glyphicon glyphicon-log-in"></span></form></li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container wrapper">
            <div class="row cart-head">
                <h3>Заказ № <?= $_SESSION['order_id'] ?></h3>
            </div>  
            <div class="row cart-body">
                <form class="form-horizontal" method="post" action="">
                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                Представление заказа 
                            </div>
                            <div class="panel-body">
                                <?php
                                if ($file):
                                    $sum = 0;
                                    foreach ($orders_array[$_SESSION['order_id']]['order'] as $item_id => $item):
                                        ?>
                                        <div class="form-group">
                                            <div class="col-sm-3 col-xs-3">
                                                <img class="img-responsive" src="images/<?= $array[$item['category']]['items'][$item_id]['imagename'] ?>" />
                                            </div>
                                            <div class="col-sm-6 col-xs-6">
                                                <div class="col-xs-12"><?= $array[$item['category']]['items'][$item_id]['name'] ?></div>
                                                <br>
                                                <br>
                                                <div class="col-xs-12"><small>Количество: <span><?= $item['quantity'] ?></span></small></div>
                                                <div class="col-xs-12"><small>ID: <span><?= $item_id ?></span></small></div>
                                            </div>
                                            <div class="col-sm-3 col-xs-3 text-right">
                                                <h6><span><?= $array[$item['category']]['items'][$item_id]['price'] ?></span> грн.</h6>
                                            </div>
                                        </div>
                                        <div class="form-group"><hr/></div>
                                        <?php
                                        $sum = $sum + $item['quantity'] * $array[$item['category']]['items'][$item_id]['price'];
                                    endforeach;
                                endif;
                                ?>
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <strong>Сумма заказа:</strong>
                                        <div class="pull-right"><span><?= $sum ?></span><span> грн.</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <div class="panel panel-info">
                            <div class="panel-heading">Контакты</div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <div class="col-md-6 col-xs-12">
                                        <strong>Имя:</strong>
                                        <p><?= $orders_array[$_SESSION['order_id']]['contacts']['first_name'] ?></p>
                                    </div>
                                    <div class="span1"></div>
                                    <div class="col-md-6 col-xs-12">
                                        <strong>Фамилия:</strong>
                                        <p><?= $orders_array[$_SESSION['order_id']]['contacts']['last_name'] ?></p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12"><strong>Адрес:</strong></div>
                                    <div class="col-md-12">
                                        <p><?= $orders_array[$_SESSION['order_id']]['contacts']['address'] ?></p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12"><strong>Город:</strong></div>
                                    <div class="col-md-12">
                                        <p><?= $orders_array[$_SESSION['order_id']]['contacts']['city'] ?></p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12"><strong>Моб. телефон:</strong></div>
                                    <div class="col-md-12">
                                        <p><?= $orders_array[$_SESSION['order_id']]['contacts']['phone_number'] ?></p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12"><strong>Email:</strong></div>
                                    <div class="col-md-12">
                                        <p><?= $orders_array[$_SESSION['order_id']]['contacts']['email_address'] ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="row cart-footer">
            </div>
        </div>
    </body>
</html>