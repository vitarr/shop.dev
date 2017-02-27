<?php
$file = file_exists('../admin/goods.txt');
if ($file):
    $filename = '../admin/goods.txt';
    $handle = fopen($filename, 'r');
    if ($handle):
        $array = unserialize(fgets($handle));
        (array) $array;
        fclose($handle);
    endif;
endif;
session_start();
$count = '';
if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
    $cart = $_SESSION['cart'];
    $count = '(' . count($_SESSION['cart']) . ')';
}
if (isset($_POST['drop'])) {
    $item_id = filter_input(INPUT_POST, 'drop');
    if (isset($_SESSION['cart'][$item_id])) {
        unset($_SESSION['cart'][$item_id]);
        header("Location:" . $_SERVER['PHP_SELF']);
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
    <head>
        <title>Cart</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="../js/cart.js" type="text/javascript"></script>
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
                        <?php
                        endif;
                        ?>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container text-center" id="content">
            <br><br><br><br>
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="panel panel-warning">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <h5><span class="glyphicon glyphicon-shopping-cart"></span> Корзина ваших товаров</h5>
                                        </div>
                                        <div class="col-xs-6">
                                            <a href="../index.php" type="button" class="btn btn-warning btn-sm btn-block">
                                                <span class="glyphicon glyphicon-share-alt"></span> Продолжить покупки
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <?php
                                if ($file && isset($cart)):
                                    foreach ($cart as $key => $item):
                                        ?>
                                        <div class="row">
                                            <div class="col-xs-2"><img class="img-responsive" src="../admin/images/<?= $array[$item['cat_id']]['items'][$item['item_id']]['imagename'] ?>">
                                            </div>
                                            <div class="col-xs-4">
                                                <h4 class="product-name"><strong><?= $array[$item['cat_id']]['items'][$item['item_id']]['name'] ?></strong></h4><h4><small><?= $array[$item['cat_id']]['items'][$item['item_id']]['description'] ?></small></h4>
                                            </div>
                                            <div class="col-xs-6">
                                                <div class="col-xs-6 text-right">
                                                    <input id="price" type="hidden" value="<?= $array[$item['cat_id']]['items'][$item['item_id']]['price'] ?>">
                                                    <h6><strong><?= $array[$item['cat_id']]['items'][$item['item_id']]['price'] ?> грн. <span class="text-muted"> x</span></strong></h6>
                                                </div>
                                                <div class="col-xs-4">
                                                    <input id="count" type="number" class="form-control input-sm" value="<?= $item['quantity']?>">
                                                </div>
                                                <div class="col-xs-2">
                                                    <form method="post" enctype="multipart/form-data">
                                                        <button type="submit" name="drop" value="<?= $key ?>" class="btn btn-link btn-xs">
                                                            <span class="glyphicon glyphicon-trash"> </span>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <?php
                                    endforeach;
                                endif;
                                ?>
                                <div class="row">
                                    <div class="text-center">
                                        <div class="col-xs-3">
                                            <?php if (isset($cart) && count($cart) > 0): ?>
                                                <form action="../" method="post" enctype="multipart/form-data">
                                                    <input type="submit" name="reset" id="reset" value="Очистить корзину" class="btn btn-default btn-block">
                                                </form>
                                            <?php endif; ?>
                                        </div>
                                        <div class="col-xs-6">
                                            <h6 class="text-right">Добавлены товары?</h6>
                                        </div>
                                        <div class="col-xs-3">
                                            <a href="/cart/" type="button" class="btn btn-default btn-sm btn-block">
                                                Обновить корзину
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-footer">
                                <div class="row text-center">
                                    <div class="col-xs-9">
                                        <h4 class="text-right">Всего: <strong id="sum"></strong></h4>
                                    </div>
                                    <div class="col-xs-3">
                                        <button type="button" class="btn btn-success btn-block">
                                            Оформить заказ
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <br>
                    </div>
                </div>
            </div> 
        </div>
        <br>
        <footer class="text-center">
            <h5>Developed by Victor :)</h5>
        </footer>
    </body>
</html>
