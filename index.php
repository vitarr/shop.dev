<?php
session_start();
$filename = 'admin/goods.txt';
$handle = fopen($filename, 'a+');
$array = unserialize(fgets($handle));
(array) $array;
fclose($handle);
$reset = filter_input(INPUT_POST, 'reset');
if (filter_input(INPUT_POST, 'buy')) {
    $tocart = array(
        'item_id' => filter_input(INPUT_POST, 'item_id'),
        'cat_id' => filter_input(INPUT_POST, 'cat_id')
    );
    $_SESSION['cart'][] = $tocart;
    header("Location:" . $_SERVER['PHP_SELF']);
} else if ($reset) {
    session_destroy();
    header("Location:" . $_SERVER['PHP_SELF']);
}
if (!isset($_SESSION['cart'])) {
    $count = '';
} else if (count($_SESSION['cart']) > 0) {
    $count = '(' . count($_SESSION['cart']) . ')';
}
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
        <link href="css/shop.css" rel="stylesheet" type="text/css"/>
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
                    <a class="navbar-brand" href="http://test.dev"><span class="glyphicon glyphicon-globe"></span></a>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="nav navbar-nav">
                        <li><a href="http://test.dev">Каталог</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="http://test.dev/cart/"><span class="glyphicon glyphicon-shopping-cart"></span><?= $count ?> Корзина</a></li>
                        <?php
                        if (!isset($_SESSION['auth'])):
                            ?>
                            <li><a href="http://test.dev/admin/auth.php"><span class="glyphicon glyphicon-log-in"></span> Войти</a></li>
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
            <h3><strong>Наши товары:</strong></h3>
            <div class="row">
                <h3><strong>Наши товары:</strong></h3>
                <?php
                if ($handle):
                    foreach ($array as $cat_id => $category):
                        foreach ($category['items'] as $item_id => $item):
                            ?>
                            <div class="col-md-4">
                                <div class="product-item">
                                    <div class="pi-img-wrapper">
                                        <img src="admin/images/<?= $item['imagename'] ?>" class="img-responsive" alt="Berry Lace Dress">
                                    </div>
                                    <h3><?= $item['name'] ?></h3>
                                    <div class="pi-price"><?= $item['price'] ?> грн.</div>
                                    <form method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="item_id" value="<?= $item_id ?>"/>
                                        <input type="hidden" name="cat_id" value="<?= $cat_id ?>"/>
                                        <label class="glyphicon glyphicon-shopping-cart"></label><input type="submit" name="buy" value="Купить" class="btn add2cart"/>
                                    </form>
                                </div>
                            </div>   
                            <?php
                        endforeach;
                    endforeach;
                endif;
                ?>
            </div>
        </div>
        <br>
        <br>
        <footer class="container-fluid text-center">
            <h5>Developed by Victor :)</h5>
        </footer>
    </body>
</html>