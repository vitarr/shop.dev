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
    include_once 'imagefunction.php';
    $message = handler($file, $size, $root, $AVAILABLE_TYPES);
    if ($message[1] == 'loaded'):
        $message = $message[0];
        $filename = 'goods.txt';
        $goodsfile = fopen($filename, 'a+');
        $goodsarray = unserialize(fgets($goodsfile));
        (array)$goodsarray;
        fclose($goodsfile);
        $id = count($goodsarray);
        while (array_key_exists($id, $goodsarray) || $id < 1 || $id < end(array_keys($goodsarray)) || $id == end(array_keys($goodsarray))):
            $id++;
        endwhile;
        $goodsarray[$id] = array(
            'imagename' => $_FILES[$file]['name'],
            'name' => filter_input(INPUT_POST, 'name'),
            'price' => filter_input(INPUT_POST, 'price'),
            'category' => filter_input(INPUT_POST, 'selectedcat'),
        );
        $newgoodsfile = fopen($filename, 'w+');
        fwrite($newgoodsfile, serialize($goodsarray));
        fclose($newgoodsfile);
        $catsfilename = 'categories.txt';
        $catsfile = fopen($catsfilename, 'a+');
        $catsarray = unserialize(fgets($catsfile));
        fclose($catsfile);
        $catsarray[filter_input(INPUT_POST, 'selectedcat')]['items'][$id] = filter_input(INPUT_POST, 'name');
        $newcatsfile = fopen($catsfilename, 'w+');
        fwrite($newcatsfile, serialize($catsarray));
        fclose($newcatsfile);
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
                        <li><a href="#">Заказы(В разработке)</a></li>
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
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="file" name="image"/></td>
                            <td><input type="text" name="name"/></td>
                            <td><input type="number" name="price"/></td>
                            <td>
                                <select name="selectedcat" required>
                                    <option selected disabled=""></option>
                                    <?php
                                    $catsfilename = 'categories.txt';
                                    $catsfile = fopen($catsfilename, 'a+');
                                    $catsarray = unserialize(fgets($catsfile));
                                    foreach ($catsarray as $id => $category):
                                        ?>
                                        <option value="<?= $id ?>"><?= $category['name'] ?></option>
                                        <?php
                                    endforeach;
                                    fclose($catsfile);
                                    ?>
                                </select>
                            </td>
                        </tr>
                    </tbody> 
                </table>
                <input type="submit" name="add" value="Добавить товар"/>
            </form>
            <br>
            <?php $message ?>
        </div>
    </body>
</html>
