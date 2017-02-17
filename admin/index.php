<?php
session_start();
if (!isset($_SESSION['auth'])):
    header("Location:" . '../');
endif;
$file = file_exists('goods.txt');
if ($file):
    $filename = 'goods.txt';
    $handle = fopen($filename, 'r');
    if ($handle):
        $array = unserialize(fgets($handle));
        (array) $array;
        fclose($handle);
    endif;
endif;
if (filter_input(INPUT_POST, 'delid')):
    unset($array[filter_input(INPUT_POST, 'idcat_of_delid')]['items'][filter_input(INPUT_POST, 'delid')]);
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
                    <a class="navbar-brand" href="#">Админ-панель:</a>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="index.php">Товары</a></li>
                        <li><a href="categories.php">Категории</a></li>
                        <li><a href="#">Заказы(В разработке)</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="../"><span class="glyphicon glyphicon-log-in"></span> На сайт</a></li>
                        <li><form method="post" class="form-inline"><input type="submit" name="exit" value="(Выйти)" class="btn btn-link"><span class="glyphicon glyphicon-log-in"></span></form></li>
                    </ul>
                </div>
            </div>
        </nav>
        <br>
        <br>
        <br>
        <div class="container">
            <a href="addgood.php" type="button" class="btn btn-default">Добавить новый товар</a>
            <h2>Товары:</h2>
            <br>
            <br>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Изображение</th>
                        <th>Название</th>
                        <th>Описание</th>
                        <th>Цена</th>
                        <th>Категория</th>
                        <th>ID</th>
                        <th colspan="2">Управление</th>
                    </tr>
                </thead>
                <?php
                if ($file):
                    if (filesize($filename) > 0 && $handle):
                        foreach ($array as $cat_id => $category):
                            foreach ($category['items'] as $id => $item):
                                ?>
                                <tbody>
                                    <tr>
                                        <td class='images'><img src="images/<?= $item['imagename'] ?>"></td>
                                        <td><strong><?= $item['name'] ?></strong></td>
                                        <td><strong><?= $item['description'] ?></strong></td>
                                        <td><strong><?= $item['price'] ?> грн.</strong></td>
                                        <td><strong><?= $category['name'] ?></strong></td>
                                        <td><strong><?= $id ?></strong></td>
                                        <td>
                                            <strong>
                                                <form method="post" enctype="multipart/form-data">
                                                    <input type="hidden" value="<?= $cat_id ?>" name="category_of_edit"/>
                                                    <input type="hidden" value="<?= $id ?>" name="edit_id"/>
                                                    <input type="submit" name="edit" value="Редактировать"/>
                                                </form>
                                            </strong>
                                        </td>
                                        <td>
                                            <strong>
                                                <form method="post" enctype="multipart/form-data">
                                                    <input type="hidden" value="<?= $cat_id ?>" name="idcat_of_delid"/>
                                                    <input type="hidden" value="<?= $id ?>" name="delid"/>
                                                    <input type="submit" name="delete" value="Удалить"/>
                                                </form>
                                            </strong>
                                        </td>
                                    </tr>
                                </tbody> 
                                <?php
                            endforeach;
                        endforeach;
                    endif;
                endif;
                ?>
            </table>
        </div>
    </body>
</html>
