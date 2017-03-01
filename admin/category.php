<?php
session_start();
if (!isset($_SESSION['auth'])):
    header("Location:" . '../');
endif;
$filename = 'goods.txt';
$handle = fopen($filename, 'r');
$array = unserialize(fgets($handle));
(array) $array;
fclose($handle);
if (filter_input(INPUT_POST, 'del_id')):
    unset($array[filter_input(INPUT_POST, 'category_of_del')]['items'][filter_input(INPUT_POST, 'del_id')]);
    $newfile = fopen($filename, 'w+');
    fwrite($newfile, serialize($array));
    fclose($newfile);
    header("Location:" . $_SERVER['PHP_SELF']);
elseif (filter_input(INPUT_POST, 'rename')):
    $array[filter_input(INPUT_POST, 'cat_id')]['name'] = filter_input(INPUT_POST, 'newname');
    $newfile = fopen($filename, 'w+');
    fwrite($newfile, serialize($array));
    fclose($newfile);
    header("Location:" . $_SERVER['PHP_SELF']);
elseif (filter_input(INPUT_POST, 'redesc')):
    $array[filter_input(INPUT_POST, 'cat_id')]['description'] = filter_input(INPUT_POST, 'newdesc');
    $newfile = fopen($filename, 'w+');
    fwrite($newfile, serialize($array));
    fclose($newfile);
    header("Location:" . $_SERVER['PHP_SELF']);
elseif (filter_input(INPUT_POST, 'edit')):
    unset($_SESSION['edit_id']);
    unset($_SESSION['category_of_edit']);
    $_SESSION['edit_id'] = filter_input(INPUT_POST, 'edit_id');
    $_SESSION['category_of_edit'] = filter_input(INPUT_POST, 'category_of_edit');
    header("Location:" . 'editgood.php');
endif;
if (filter_input(INPUT_POST, 'exit')):
    unset($_SESSION['auth']);
    header("Location:" . '../');
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
        <link href="../css/admin.css" rel="stylesheet" type="text/css"/>
        <style>
            textarea{
                height: 36px;
            }
        </style>
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
                    <a class="navbar-brand" href="index.php">Админ-панель:</a>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="nav navbar-nav">
                        <li><a href="goods.php">Товары</a></li>
                        <li class="active"><a href="categories.php">Категории</a></li>
                        <li><a href="orders.php">Заказы</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="../"><span class="glyphicon glyphicon-log-in"></span> На сайт</a></li>
                        <li><form method="post" class="form-inline"><input type="submit" name="exit" value="Выйти" class="btn btn-link"><span class="glyphicon glyphicon-log-in"></span></form></li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container">
            <?php
            if (file_exists('goods.txt') && isset($_SESSION['cat_id'])):
                $cat_id = $_SESSION['cat_id'];
                $name = $array[$cat_id]['name'];
                ?>
                <h3><?= $name ?>:</h3>
                <br>
                <br>
                <div class="row">
                    <div class="col-md-6">
                        <form method="post" enctype="multipart/form-data">
                            <input type="hidden" value="<?= $cat_id ?>" name="cat_id"/>
                            <br>
                            <input type="text" value="<?= $name ?>" name="newname" class="newname"/>
                            <input id="rename" class="newname" type="submit" name="rename" value="Переименовать категорию" class="btn btn-default"/>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <form method="post" enctype="multipart/form-data">
                            <input type="hidden" value="<?= $cat_id ?>" name="cat_id"/>
                            <br>
                            <textarea type="text" name="newdesc" class="newname"><?= $array[$cat_id]['description'] ?></textarea>
                            <input class="newname" type="submit" name="redesc" value="Изменить описание" class="btn btn-default"/>
                        </form>
                    </div>
                </div>
                <br>
                <h3>Товары в категории:</h3>
                <br>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Изображение</th>
                            <th>Название</th>
                            <th>Описание</th>
                            <th>Цена</th>
                            <th>ID</th>
                            <th colspan="2">Управление</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($array[$cat_id]['items'] as $item_id => $item):
                            ?>
                            <tr>
                                <td class='images'><img src="images/<?= $item['imagename'] ?>"></td>
                                <td><strong><?= $item['name'] ?></strong></td>
                                <td><strong><?= $item['description'] ?></strong></td>
                                <td><strong><?= $item['price'] ?> грн.</strong></td>
                                <td><strong><?= $item_id ?></strong></td>
                                <td>
                                    <strong>
                                        <form method="post" enctype="multipart/form-data">
                                            <input type="hidden" value="<?= $cat_id ?>" name="category_of_edit"/>
                                            <input type="hidden" value="<?= $item_id ?>" name="edit_id"/>
                                            <input type="submit" name="edit" value="Редактировать"/>
                                        </form>
                                    </strong>
                                </td>
                                <td>
                                    <strong>
                                        <form method="post" enctype="multipart/form-data">
                                            <input type="hidden" value="<?= $item_id ?>" name="del_id"/>
                                            <input type="hidden" value="<?= $cat_id ?>" name="category_of_del"/>
                                            <input type="submit" name="delete" value="Удалить"/>
                                        </form>
                                    </strong>
                                </td>
                            </tr>
                        </tbody> 
                        <?php
                    endforeach;
                endif;
                ?>
            </table>
        </div>
    </body>
</html>