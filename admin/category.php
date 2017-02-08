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
if (filter_input(INPUT_POST, 'rename')):
    $idcat = filter_input(INPUT_POST, 'idcat');
    $catsfilename = 'categories.txt';
    $catsfile = fopen($catsfilename, 'a+');
    $catsarray = unserialize(fgets($catsfile));
    fclose($catsfile);
    $catsarray[$idcat]['name'] = filter_input(INPUT_POST, 'newname');
    $newcatsfile = fopen($catsfilename, 'w+');
    fwrite($newcatsfile, serialize($catsarray));
    fclose($newcatsfile);
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
        .newname{
            width: 40%;
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
            <?php
            if (file_exists('categories.txt') && (filter_input(INPUT_POST, 'cat') || filter_input(INPUT_POST, 'delid') || filter_input(INPUT_POST, 'idcat'))):
                $filename = 'categories.txt';
                $catsfile = fopen($filename, 'a+');
                $catsarray = unserialize(fgets($catsfile));
                $idcat = filter_input(INPUT_POST, 'id');
                if (filter_input(INPUT_POST, 'back')):
                    $idcat = filter_input(INPUT_POST, 'back');
                elseif (filter_input(INPUT_POST, 'rename')):
                    $idcat = filter_input(INPUT_POST, 'idcat');
                endif;
                $name = $catsarray[$idcat]['name'];
                ?>
                <h2><?= $name ?>:</h2>
                <br>
                <br>
                <form method="post" enctype="multipart/form-data">
                    <input type="hidden" value="<?= $idcat ?>" name="idcat"/>
                    <input type="text" value="<?= $catsarray[$idcat]['name'] ?>" name="newname" class="newname"/>
                    <input type="submit" name="rename" value="Переименовать категорию" class="btn btn-default"/>
                </form>
                <br>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Изображение</th>
                            <th>Название</th>
                            <th>Цена</th>
                            <th>ID</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (file_exists('goods.txt')):
                            $filename = 'goods.txt';
                            $goodsfile = fopen($filename, 'a+');
                            $goodsarray = unserialize(fgets($goodsfile));
                            foreach ($catsarray[$idcat]['items'] as $iditem => $goodincat):
                                ?>
                                <tr>
                                    <td class='images'><img src="images/<?= $goodsarray[$iditem]['imagename'] ?>"></td>
                                    <td><strong><?= $goodsarray[$iditem]['name'] ?></strong></td>
                                    <td><strong><?= $goodsarray[$iditem]['price'] ?></strong></td>
                                    <td><strong><?= $iditem ?></strong></td>
                                    <td>
                                        <strong>
                                            <form action="editgood.php" method="post" enctype="multipart/form-data">
                                                <input type="hidden" value="<?= $iditem ?>" name="editid"/>
                                                <input type="submit" name="edit" value="Редактировать"/>
                                            </form>
                                        </strong>
                                    </td>
                                    <td>
                                        <strong>
                                            <form method="post" enctype="multipart/form-data">
                                                <input type="hidden" value="<?= $iditem ?>" name="delid"/>
                                                <input type="hidden" value="<?= $idcat ?>" name="back"/>
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
                endif;
                ?>
            </table>
        </div>
    </body>
</html>