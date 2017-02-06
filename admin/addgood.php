<?php
$AVAILABLE_TYPES = array(
    'image/jpeg',
    'image/png',
    'image/gif',
);
if (filter_input(INPUT_POST, 'add')):
    $file = 'image';
    $size = 3;
    $root = 'images';
    include_once 'function.php';
    $message = handler($file, $size, $root, $AVAILABLE_TYPES);
    if ($message[1] == 'loaded'):
        $message = $message[0];
        $filename = 'goods.txt';
        $goodsfile = fopen($filename, 'a+');
        $goodsarray = unserialize(fgets($goodsfile));
        fclose($goodsfile);
        $newgood = array(
            'imagename' => $_FILES[$file]['name'],
            'name' => filter_input(INPUT_POST, 'name'),
            'price' => filter_input(INPUT_POST, 'price'),
            'category' => filter_input(INPUT_POST, 'cat'),
            'id' => filter_input(INPUT_POST, 'id')
        );
        $goodsarray[] = $newgood;
        $newgoodsfile = fopen($filename, 'w+');
        fwrite($newgoodsfile, serialize($goodsarray));
        fclose($newgoodsfile);
    endif;
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
                    <a class="navbar-brand" href="#">Админ-панель:</a>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="index.php">Товары</a></li>
                        <li><a href="categories.php">Категории</a></li>
                        <li><a href="orders.php">Заказы</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Выйти</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container">
            <form method="post" enctype="multipart/form-data">
                <h2>Новый товар:</h2>         
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Изображение</th>
                            <th>Название</th>
                            <th>Цена</th>
                            <th>Категория</th>
                            <th>ID</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="file" name="image"/></td>
                            <td><input type="text" name="name"/></td>
                            <td><input type="number" name="price"/></td>
                            <td><input type="text" name="cat"/></td>
                            <td><input type="number" name="id"/></td>
                        </tr>
                    </tbody> 
                </table>
                <input type="submit" name="add" value="Добавить товар"/>
            </form>
            <br>
            <?= $message ?>
        </div>
    </body>
</html>
