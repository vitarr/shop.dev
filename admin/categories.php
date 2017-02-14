<?php
$filename = 'goods.txt';
$handle = fopen($filename, 'a+');
$array = unserialize(fgets($handle));
(array) $array;
fclose($handle);
if (filter_input(INPUT_POST, 'delid')):
    unset($array[filter_input(INPUT_POST, 'delid')]);
    $newfile = fopen($filename, 'w+');
    fwrite($newfile, serialize($array));
    fclose($newfile);
    header("Location:" . $_SERVER['PHP_SELF']);
endif;
if (filter_input(INPUT_POST, 'category')):
    session_start();
    unset($_SESSION['cat_id']);
    $_SESSION['cat_id'] = filter_input(INPUT_POST, 'cat_id');
    header("Location:" . 'category.php');
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
            table, th{
                text-align: center;
            }
        </style>
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
                        <li><a href="index.php">Товары</a></li>
                        <li class="active"><a href="categories.php">Категории</a></li>
                        <li><a href="#">Заказы(В разработке)</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Выйти</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container">
            <a href="addcategories.php" type="button" class="btn btn-default">Добавить новую категорию</a>
            <h2>Категории:</h2>  
            <br>
            <br>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Название</th>
                        <th>ID</th>
                        <th>Управление</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (filesize($filename) > 0):
                        foreach ($array as $id => $category):
                            ?>
                            <tr>
                                <td><strong>
                                        <form method="post" enctype="multipart/form-data">
                                            <input type="hidden" value="<?= $id ?>" name="cat_id"/>
                                            <input type="submit" name="category" value="<?= $category['name'] ?>" class="btn btn-link"/>
                                        </form>
                                    </strong>
                                </td>
                                <td><strong><?= $id ?></strong></td>
                                <td>
                                    <strong>
                                        <form method="post" enctype="multipart/form-data">
                                            <input type="hidden" value="<?= $id ?>" name="delid"/>
                                            <input type="submit" name="delete" value="Удалить"/>
                                        </form>
                                    </strong>
                                </td>
                            </tr>
                            <?php
                        endforeach;
                    endif;
                    ?>
                </tbody> 
            </table>
        </div>
    </body>
</html>
