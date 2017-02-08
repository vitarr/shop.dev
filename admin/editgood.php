<?php
$AVAILABLE_TYPES = array(
    'image/jpeg',
    'image/png',
    'image/gif',
);
$getid = filter_input(INPUT_POST, 'editid');
$getidcat = filter_input(INPUT_POST, 'catid');
$saveid = filter_input(INPUT_POST, 'saveid');
$savecatid = filter_input(INPUT_POST, 'savecatid');

$filename = 'goods.txt';
$goodsfile = fopen($filename, 'a+');
$goodsarray = unserialize(fgets($goodsfile));
fclose($goodsfile);

$catsfilename = 'categories.txt';
$catsfile = fopen($catsfilename, 'a+');
$catsarray = unserialize(fgets($catsfile));
fclose($catsfile);

if (filter_input(INPUT_POST, 'edit')):
    $file = 'image';
    $size = 3;
    $root = 'images';
    include_once 'imagefunction.php';
    $message = handler($file, $size, $root, $AVAILABLE_TYPES);
    if ($message[1] == 'loaded'):
        $message = $message[0];
        $goodsarray[$saveid]['imagename'] = $_FILES[$file]['name'];
        $goodsarray[$saveid]['name'] = filter_input(INPUT_POST, 'name');
        $goodsarray[$saveid]['price'] = filter_input(INPUT_POST, 'price');
        $goodsarray[$saveid]['category'] = filter_input(INPUT_POST, 'selectedcat');
        $newgoodsfile = fopen($filename, 'w+');
        fwrite($newgoodsfile, serialize($goodsarray));
        fclose($newgoodsfile);

        if ($getidcat !== filter_input(INPUT_POST, 'selectedcat')):
            unset($catsarray[$goodsarray[$savecatid]['category']]['items'][$savecatid]);
        endif;

        $catsarray[filter_input(INPUT_POST, 'selectedcat')]['items'][$saveid] = filter_input(INPUT_POST, 'name');
        $newcatsfile = fopen($catsfilename, 'w+');
        fwrite($newcatsfile, serialize($catsarray));
        fclose($newcatsfile);
        header("Location:" . '/admin/index.php');
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
    <style>
        .container{
            margin-top: 50px;
        }
        img{
            max-width: 200px;
            max-height: 200px;
        }
        .images{
            width: 20%;
            text-align: center;
        }
        h2{
            text-align: center;
        }
        table{
            text-align: center;
        }
    </style>
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
                <h2>Редактирование товара:</h2>         
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
                            <td class="images">
                                <img src="images/<?= $goodsarray[$getid]['imagename'] ?>">
                                <input type="file" name="image"/>
                            </td>
                            <td><br><br><input type="text" name="name"  value="<?= $goodsarray[$getid]['name'] ?>"/></td>
                            <td>
                                <br><br>
                                <input type="number" name="price"  value="<?= $goodsarray[$getid]['price'] ?>"/>
                                <input type="hidden" name="saveid"  value="<?= $getid ?>"/>
                                <input type="hidden" name="savecatid"  value="<?= $getidcat ?>"/>
                            </td>
                            <td><br><br>
                                <select name="selectedcat" required>
                                    <?php
                                    foreach ($catsarray as $id => $category):
                                        ?>
                                        <option value="<?= $id ?>"><?= $category['name'] ?></option>
                                        <?php
                                    endforeach;
                                    ?>
                                </select>
                            </td>
                        </tr>
                    </tbody> 
                </table>
                <input type="submit" name="edit" value="Подтвердить изменения"/>
            </form>
        </div>
    </body>
</html>