<?php
session_start();
if (isset($_SESSION['order'])) {
    $order = $_SESSION['order'];
}else{
    header("Location:" . "index.php");
}
$file = file_exists('admin/goods.txt');
if ($file):
    $filename = 'admin/goods.txt';
    $handle = fopen($filename, 'r');
    if ($handle):
        $array = unserialize(fgets($handle));
        (array) $array;
        fclose($handle);
    endif;
endif;
if (filter_input(INPUT_POST, 'place_order')):
    $orders_filename = 'admin/orders.txt';
    $orders_handle = fopen($orders_filename, 'a+');
    if ($orders_handle):
        $message = '<div class="alert alert-success">
                    <h3>Ваш заказ принят в обработку. Наш менеджер свяжется с вами (как рак на горе свиснет).</h3>
                </div>';
        $_SESSION['placed_order']['message'] = $message;
        $orders_array = unserialize(fgets($orders_handle));
        (array) $orders_array;
        if (!$orders_array):
            $orders_array = array();
        endif;
        fclose($orders_handle);
        $orders__ids = array_keys($orders_array);
        $last_order_id = end($orders__ids);
        $id = $last_order_id + 1;
        $_SESSION['placed_order']['id'] = $id;
        $orders_array[$id] = array(
            'contacts' => array(
                'first_name' => filter_input(INPUT_POST, 'first_name'),
                'last_name' => filter_input(INPUT_POST, 'last_name'),
                'address' => filter_input(INPUT_POST, 'address'),
                'city' => filter_input(INPUT_POST, 'city'),
                'phone_number' => filter_input(INPUT_POST, 'phone_number'),
                'email_address' => filter_input(INPUT_POST, 'email_address'),
            ),
            'order' => $order
        );
        $newfile = fopen($orders_filename, 'w+');
        fwrite($newfile, serialize($orders_array));
        fclose($newfile);
        header("Location:" . "order.php");
    endif;
endif;
$count = '';
if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
    $cart = $_SESSION['cart'];
    $count = '(' . count($_SESSION['cart']) . ')';
}
if (filter_input(INPUT_POST, 'exit')):
    unset($_SESSION['auth']);
    header("Location:" . $_SERVER['PHP_SELF']);
endif;
?>
<!DOCTYPE html>
<html lang="ru">
    <head>
        <title>Checkout</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link href="css/checkout.css" rel="stylesheet" type="text/css"/>
        <link href="../css/shop.css" rel="stylesheet" type="text/css"/>
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
                    <a class="navbar-brand" href="../"><span class="glyphicon glyphicon-globe"></span></a>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="nav navbar-nav">
                        <li><a href="../">Каталог</a></li>
                        <li><a href="../categories.php">Категории</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="active"><a href="../cart/"><span class="glyphicon glyphicon-shopping-cart"></span><?= $count ?> Корзина</a></li>
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
        <div class="container wrapper">
            <div class="row cart-head">
                <div class="container">
                    <div class="row">
                        <p></p>
                    </div>
                    <div class="row">
                        <div style="display: table; margin: auto;">
                            <span class="step step_complete"> <a href="cart/" class="check-bc">Корзина</a> <span class="step_line step_complete"> </span> <span class="step_line backline"> </span> </span>
                            <span class="step step_complete ch"> <a href="#" class="check-bc">Заказ</a></span>
                        </div>
                    </div>
                    <div class="row">
                        <p></p>
                    </div>
                </div>
            </div>    
            <div class="row cart-body">
                <form class="form-horizontal" method="post" action="">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 col-md-push-6 col-sm-push-6">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                Представление заказа <div class="pull-right"><small><a class="afix-1" href="cart/">Изменить покупки</a></small></div>
                            </div>
                            <div class="panel-body">
                                <?php
                                if ($file && isset($order)):
                                    $sum = 0;
                                    foreach ($order as $item_id => $item):
                                        ?>
                                        <div class="form-group">
                                            <div class="col-sm-3 col-xs-3">
                                                <img class="img-responsive" src="admin/images/<?= $array[$item['category']]['items'][$item_id]['imagename'] ?>" />
                                            </div>
                                            <div class="col-sm-6 col-xs-6">
                                                <div class="col-xs-12"><?= $array[$item['category']]['items'][$item_id]['name'] ?></div>
                                                <br>
                                                <br>
                                                <div class="col-xs-12"><small>Количество: <span><?= $item['quantity'] ?></span></small></div>
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
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 col-md-pull-6 col-sm-pull-6">
                        <div class="panel panel-info">
                            <div class="panel-heading">Контакты</div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <h4>Ваши данные:</h4>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-6 col-xs-12">
                                        <strong>Имя:</strong>
                                        <input type="text" name="first_name" class="form-control" required/>
                                    </div>
                                    <div class="span1"></div>
                                    <div class="col-md-6 col-xs-12">
                                        <strong>Фамилия:</strong>
                                        <input type="text" name="last_name" class="form-control"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12"><strong>Адрес:</strong></div>
                                    <div class="col-md-12">
                                        <input type="text" name="address" class="form-control"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12"><strong>Город:</strong></div>
                                    <div class="col-md-12">
                                        <input type="text" name="city" class="form-control"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12"><strong>Моб. телефон:</strong></div>
                                    <div class="col-md-12"><input type="text" name="phone_number" class="form-control" required/></div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12"><strong>Email:</strong></div>
                                    <div class="col-md-12"><input type="text" name="email_address" class="form-control"/></div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input name="place_order"type="submit" class="btn btn-primary btn-submit-fix" value="Подтвердить заказ">
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
        <footer class="text-center">
            <h5>Developed by Victor :)</h5>
        </footer>
    </body>
</html>
