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
$reset = filter_input(INPUT_POST, 'reset');
if (filter_input(INPUT_POST, 'buy')) {
    $quantity = 1;
    if (isset($_SESSION['cart'][filter_input(INPUT_POST, 'item_id')])):
        $_SESSION['cart'][filter_input(INPUT_POST, 'item_id')]['quantity'] = $_SESSION['cart'][filter_input(INPUT_POST, 'item_id')]['quantity'] + 1;
    else:
        $tocart = array(
            'item_id' => filter_input(INPUT_POST, 'item_id'),
            'cat_id' => filter_input(INPUT_POST, 'cat_id'),
            'quantity' => $quantity
        );
        $_SESSION['cart'][filter_input(INPUT_POST, 'item_id')] = $tocart;
    endif;
    header("Location:" . $_SERVER['PHP_SELF']);
} else if ($reset) {
    unset($_SESSION['cart']);
    header("Location:" . $_SERVER['PHP_SELF']);
}
$count = '';
if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
    $cart = $_SESSION['cart'];
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
                    <a class="navbar-brand" href="/"><span class="glyphicon glyphicon-globe"></span></a>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="/">Каталог</a></li>
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
                        <?php
                        endif;
                        ?>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container text-center" id="content">
            <br><br><br>
            <div class="row">
                <h3 class="alert alert-warning"><strong>Все товары:</strong></h3>
                <?php
                if ($file):
                    foreach ($array as $cat_id => $category):
                        foreach ($category['items'] as $item_id => $item):
                            ?>
                            <div class="col-md-4">
                                <div class="product-item">
                                    <form action="item.php" method="post" enctype="multipart/form-data">
                                        <div class="pi-img-wrapper itemhref">
                                            <input type="hidden" name="item_id" value="<?= $item_id ?>"/>
                                            <input type="hidden" name="cat_id" value="<?= $cat_id ?>"/>
                                            <input type="image" name="item" src="admin/images/<?= $item['imagename'] ?>" class="img-responsive" alt="Berry Lace Dress">
                                        </div>
                                    </form>
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
        <footer class="text-center">
            <h5>Developed by Victor :)</h5>
        </footer>
    </body>
</html>