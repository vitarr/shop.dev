<?php
session_start();
unset($_SESSION['cart']);
if (!isset($_SESSION['placed_order'])) {
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
$order_file = file_exists('admin/goods.txt');
if ($order_file):
    $order_filename = 'admin/orders.txt';
    $order_handle = fopen($order_filename, 'r');
    if ($order_handle):
        $order_array = unserialize(fgets($order_handle));
        (array) $order_array;
        fclose($order_handle);
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
        <title>Order</title>
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
        <br><br><br><br><br><br><br><br><br><br><br><br>
        <div class="container text-center">
            <?= $_SESSION['placed_order']['message'] ?>
        </div>
        <footer class="text-center">
            <h5>Developed by Victor :)</h5>
        </footer>
    </body>
</html>
<?php
unset($_SESSION['placed_order']);
?>