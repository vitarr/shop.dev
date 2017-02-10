<?php
if (filter_input(INPUT_POST, 'add')):
    $filename = 'categories.txt';
    $catsfile = fopen($filename, 'a+');
    if ($catsfile):
        $catsarray = unserialize(fgets($catsfile));
        (array) $catsarray;
        fclose($catsfile);
        $id = count($catsarray);
        if (array_key_exists($id, $catsarray)):
            $id++;
        endif;
        $catsarray[$id] = array(
            'name' => filter_input(INPUT_POST, 'name'),
            'items' => array()
        );
        $newcatsfile = fopen($filename, 'w+');
        fwrite($newcatsfile, serialize($catsarray));
        fclose($newcatsfile);
        $message = '<div class="alert alert-success">
                    <h3>Новая категория успешно успешно добавлена.</h3>
                </div>';
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
        <style>
            .name{
                width: 100%;
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
            <form method="post" enctype="multipart/form-data">
                <h2>Новая категория:</h2>         
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Название</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="text" name="name" class="name"/></td>
                        </tr>
                    </tbody> 
                </table>
                <input type="submit" name="add" value="Добавить категорию"/>
            </form>
            <br>
            <?php $message ?>
        </div>
    </body>
</html>