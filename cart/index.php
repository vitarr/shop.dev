<?php
$filename = '../admin/goods.txt';
$handle = fopen($filename, 'a+');
$array = unserialize(fgets($handle));
(array) $array;
fclose($handle);
session_start();
if (!isset($_SESSION['cart'])) {
    $count = '';
} else if (count($_SESSION['cart']) > 0) {
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
            <h3><strong>Корзина ваших покупок:</strong></h3>
            <div class="row">
                <h3><strong>Корзина ваших покупок:</strong></h3>
                <?php
                if ($handle && isset($cart)):
                    foreach ($cart as $key => $item):
                        ?>
                        <div class="col-md-4">
                            <div class="product-item">
                                <div class="pi-img-wrapper">
                                    <img src="../admin/images/<?= $array[$item['cat_id']]['items'][$item['item_id']]['imagename'] ?>" class="img-responsive" alt="img">
                                </div>
                                <h3><?= $array[$item['cat_id']]['items'][$item['item_id']]['name'] ?></h3>
                                <div class="pi-price"><?= $array[$item['cat_id']]['items'][$item['item_id']]['price'] ?> грн.</div>
                                <form method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="drop" value="<?= $key ?>"/>
                                    <label class="glyphicon glyphicon-scissors"></label><input type="submit" value="Удалить из корзины" class="btn add2cart"/>
                                </form>
                            </div>
                        </div>   
                        <?php
                    endforeach;
                endif;
                ?>
            </div>
            <br>
            <?php if (isset($cart) && count($cart) > 0): ?>
                <form action="../" method="post" enctype="multipart/form-data">
                    <input type="submit" name="reset" id="reset" value="Очистить корзину" class="btn btn-default btn-block">
                </form>
            <?php endif; ?>
        </div>
        <br>
        <footer class="container-fluid text-center">
            <h5>Developed by Victor :)</h5>
        </footer>
    </body>
</html>
