<?php
if (filter_input(INPUT_POST, 'delid')):
    $filename = 'goods.txt';
    $goodsfile = fopen($filename, 'a+');
    $goodsarray = unserialize(fgets($goodsfile));
    fclose($goodsfile);
    $catsfilename = 'categories.txt';
    $catsfile = fopen($catsfilename, 'a+');
    $catsarray = unserialize(fgets($catsfile));
    fclose($catsfile);

    unset($catsarray[$goodsarray[filter_input(INPUT_POST, 'delid')]['category']]['items'][filter_input(INPUT_POST, 'delid')]);
    unset($goodsarray[filter_input(INPUT_POST, 'delid')]);

    $newcatsfile = fopen($catsfilename, 'w+');
    fwrite($newcatsfile, serialize($catsarray));
    fclose($newcatsfile);
    $newgoodsfile = fopen($filename, 'w+');
    fwrite($newgoodsfile, serialize($goodsarray));
    fclose($newgoodsfile);
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
            <a href="addgood.php" type="button" class="btn btn-default">Добавить новый товар</a>
            <h2>Товары:</h2>
            <br>
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
                <?php
                if (file_exists('goods.txt')):
                    $filename = 'goods.txt';
                    $goodsfile = fopen($filename, 'a+');
                    $goodsarray = unserialize(fgets($goodsfile));
                    $catsfilename = 'categories.txt';
                    $catsfile = fopen($catsfilename, 'a+');
                    $catsarray = unserialize(fgets($catsfile));
                    foreach ($goodsarray as $id => $good):
                        ?>
                        <tbody>
                            <tr>
                                <td class='images'><img src="images/<?= $good['imagename'] ?>"></td>
                                <td><strong><?= $good['name'] ?></strong></td>
                                <td><strong><?= $good['price'] ?> грн.</strong></td>
                                <td><strong><?= $catsarray[$good['category']]['name'] ?></strong></td>
                                <td><strong><?= $id ?></strong></td>
                                <td>
                                    <strong>
                                        <form action="editgood.php" method="post" enctype="multipart/form-data">
                                            <input type="hidden" value="<?= $good['category'] ?>" name="catid"/>
                                            <input type="hidden" value="<?= $id ?>" name="editid"/>
                                            <input type="submit" name="edit" value="Редактировать"/>
                                        </form>
                                    </strong>
                                </td>
                                <td>
                                    <strong>
                                        <form method="post" enctype="multipart/form-data">
                                            <input type="hidden" value="<?= $id ?>" name="delid"/>
                                            <input type="submit" name="delete" value="Удалить"/>
                                        </form>
                                    </strong>
                                </td>
                            </tr>
                        </tbody> 
                        <?php
                    endforeach;
                    fclose($goodsfile);
                    fclose($catsfile);
                endif;
                ?>
            </table>
        </div>
    </body>
</html>
