<?php
session_start();

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
if (filter_input(INPUT_POST, 'item_id')) {
    $item = array(
        'item_id' => filter_input(INPUT_POST, 'item_id'),
        'cat_id' => filter_input(INPUT_POST, 'cat_id')
    );
    $_SESSION['item'] = $item;
    header("Location:" . $_SERVER['PHP_SELF']);
} elseif (filter_input(INPUT_POST, 'buy')) {
    if (isset($_SESSION['cart'][filter_input(INPUT_POST, 'product_id')])):
        $_SESSION['cart'][filter_input(INPUT_POST, 'product_id')]['quantity'] = $_SESSION['cart'][filter_input(INPUT_POST, 'product_id')]['quantity'] + filter_input(INPUT_POST, 'quantity');
    else:
        $tocart = array(
            'item_id' => filter_input(INPUT_POST, 'product_id'),
            'cat_id' => filter_input(INPUT_POST, 'category_id'),
            'quantity' => filter_input(INPUT_POST, 'quantity')
        );
        $_SESSION['cart'][filter_input(INPUT_POST, 'product_id')] = $tocart;
    endif;
    header("Location:" . "/cart/");
}
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
        <title>Shop</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="js/item.js" type="text/javascript"></script>
        <link href="css/shop.css" rel="stylesheet" type="text/css"/>
        <link href="css/item.css" rel="stylesheet" type="text/css"/>
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
                    <a class="navbar-brand" href="/"><span class="glyphicon glyphicon-globe"></span></a>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="nav navbar-nav">
                        <li><a href="/">Каталог</a></li>
                        <li><a href="categories.php">Категории</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="/cart/"><span class="glyphicon glyphicon-shopping-cart"></span><?= $count ?> Корзина</a></li>
                        <?php
                        if (!isset($_SESSION['auth'])):
                            ?>
                            <li><a href="/admin/auth.php"><span class="glyphicon glyphicon-log-in"></span> Войти</a></li>
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
        <br><br><br>
        <br><br><br>
        <?php
        if ($file):
            ?>
            <div class="container">
                <div class="row item">
                    <div class="col-xs-5 item-photo">
                        <img style="max-width:100%;" src="admin/images/<?= $array[$_SESSION['item']['cat_id']]['items'][$_SESSION['item']['item_id']]['imagename'] ?>" />
                    </div>
                    <div class="col-xs-7" style="border:0px solid gray">
                        <h3><?= $array[$_SESSION['item']['cat_id']]['items'][$_SESSION['item']['item_id']]['name'] ?></h3>
                        <hr>
                        <h6 class="title-price"><small>Стоимость:</small></h6>
                        <h3 style="margin-top:0px;"><?= $array[$_SESSION['item']['cat_id']]['items'][$_SESSION['item']['item_id']]['price'] ?> грн.</h3>
                        <hr>
                        <form method="post" enctype="multipart/form-data">
                            <div class="section" style="padding-bottom:20px;">
                                <h6 class="title-attr"><small>Количество:</small></h6>                    
                                <div>
                                    <div class="btn-minus"><span class="glyphicon glyphicon-minus"></span></div>
                                    <input name="quantity" value="1" />
                                    <div class="btn-plus"><span class="glyphicon glyphicon-plus"></span></div>
                                </div>
                            </div>                
                            <div class="section" style="padding-bottom:20px;">
                                <input type="hidden" name="product_id" value="<?= $_SESSION['item']['item_id'] ?>"/>
                                <input type="hidden" name="category_id" value="<?= $_SESSION['item']['cat_id'] ?>"/>
                                <button id="buy" type="submit" value="buy" name="buy" class="btn btn-success"><span style="margin-right:20px" class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span><b> В корзину </b></button>
                            </div> 
                        </form>
                        <hr>
                    </div>                              
                    <div class="col-xs-12">
                        <ul class="menu-items">
                            <li class="active">Описание:</li>
                        </ul>
                        <div style="width:100%;border-top:1px solid silver">
                            <br>
                            <p><?= $array[$_SESSION['item']['cat_id']]['items'][$_SESSION['item']['item_id']]['description'] ?></p>
                            <br>
                        </div>
                    </div>		
                </div>
            </div>
            <?php
        endif;
        ?>
        <br>
        <br>
        <footer class="text-center">
            <h5>Developed by Victor :)</h5>
        </footer>
    </body>
</html>