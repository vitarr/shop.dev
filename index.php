<?php
$filename = 'goods.csv';
session_start();
if (!empty($_SESSION['cart'])) {
    $cart = $_SESSION['cart'];
} else {
    $cart = array();
}
$tocart = filter_input(INPUT_POST, 'tocart');
$reset = filter_input(INPUT_POST, 'reset');
if ($tocart) {
    $cart[] = $tocart;
    $_SESSION['cart'] = $cart;
    header("Location:" . $_SERVER['PHP_SELF']);
} else if ($reset) {
    session_destroy();
    header("Location:" . $_SERVER['PHP_SELF']);
}
if(count($cart)>0){
    $count = '('.count($cart).')';
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
                        <li><a href="cart/"><span class="glyphicon glyphicon-shopping-cart"></span><?= $count ?> Корзина</a></li>
                        <li><a href="/admin/auth.php"><span class="glyphicon glyphicon-log-in"></span> Войти</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container text-center" id="content">
            <h3><strong>Наши товары:</strong></h3>
            <div class="row">
                <?php
                $handle = fopen($filename, 'a+');
                if ($handle):
                    $num = 1;
                    while ($item = fgetcsv($handle)):
                        ?>
                        <div class="col-md-4">
                            <div class="product-item">
                                <div class="pi-img-wrapper">
                                    <img src="<?= $item[1] ?>" class="img-responsive" alt="Berry Lace Dress">
                                </div>
                                <h3><?= $item[0] ?></h3>
                                <div class="pi-price"><?= $item[2] ?> грн.</div>
                                <form method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="tocart" value="<?= $num ?>"/>
                                    <label class="glyphicon glyphicon-shopping-cart"></label><input type="submit" value="Купить" class="btn add2cart"/>
                                </form>
                            </div>
                        </div>   
                        <?php
                        $num++;
                    endwhile;
                endif;
                fclose($handle);
                ?>
            </div>
        </div>
        <br>
        <br>
        <footer class="container-fluid text-center">
            <a href="#myNavbar" id="up"><span class="glyphicon glyphicon-arrow-up"></span>  Вернутся в начало страницы</a>
            <br>
        </footer>
    </body>
</html>