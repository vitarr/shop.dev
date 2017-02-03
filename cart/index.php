<?php
$filename = '../goods.csv';
session_start();
$goods_list = file($filename);
if (isset($_POST['drop'])) {
    $item_id = filter_input(INPUT_POST, 'drop');
    if (isset($_SESSION['cart'][$item_id])) {
        unset($_SESSION['cart'][$item_id]);
        header("Location:" . $_SERVER['PHP_SELF']);
    }
}
$cart = $_SESSION['cart'];
if (count($cart) > 0) {
    $count = '(' . count($cart) . ')';
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
        <link href="../css/shop.css" rel="stylesheet" type="text/css"/>
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
                    <a class="navbar-brand" href="http://vitarr-shop.tk"><span class="glyphicon glyphicon-globe"></span></a>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="nav navbar-nav">
                        <li><a href="http://vitarr-shop.tk">Каталог</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="../"><span class="glyphicon glyphicon-shopping-cart"></span><?= $count ?> Корзина</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container text-center" id="content">
            <h3>Корзина ваших покупок:</h3>
            <div class="row">
                <?php
                $handle = fopen($filename, 'a+');
                if ($handle && $cart):
                    foreach ($goods_list as $position):
                        $position = preg_split('/,/', $position);
                        $goods[] = $position;
                    endforeach;
                    foreach ($cart as $key => $purchase):
                        ?>
                        <div class="col-md-4">
                            <div class="product-item">
                                <div class="pi-img-wrapper">
                                    <img src="../<?= $goods[$purchase - 1][1] ?>" class="img-responsive" alt="Berry Lace Dress">
                                </div>
                                <h3><?= $goods[$purchase - 1][0] ?></h3>
                                <div class="pi-price"><?= $goods[$purchase - 1][2] ?> грн.</div>
                                <form method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="drop" value="<?= $key ?>"/>
                                    <label class="glyphicon glyphicon-scissors"></label><input type="submit" value="Удалить из корзины" class="btn add2cart"/>
                                </form>
                            </div>
                        </div>   
                        <?php
                    endforeach;
                endif;
                fclose($handle);
                ?>
            </div>
            <br>
            <?php if (count($_SESSION['cart']) > 0): ?>
                <form action="../" method="post" enctype="multipart/form-data">
                    <input type="submit" name="reset" id="reset" value="Очистить корзину" class="btn btn-default btn-block">
                </form>
            <?php endif; ?>
        </div>
        <br>
        <footer class="container-fluid text-center">
            <a href="#myNavbar" id="up"><span class="glyphicon glyphicon-arrow-up"></span>  Вернутся в начало страницы</a>
            <br>
        </footer>
    </body>
</html>
