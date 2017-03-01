<?php
session_start();
if (!isset($_SESSION['auth'])):
    header("Location:" . '../');
endif;
$file = file_exists('orders.txt');
if ($file):
    $filename = 'orders.txt';
    $handle = fopen($filename, 'r');
    if ($handle):
        $array = unserialize(fgets($handle));
        (array) $array;
        fclose($handle);
    endif;
endif;
if (filter_input(INPUT_POST, 'delid')):
    unset($array[filter_input(INPUT_POST, 'delid')]);
    $newfile = fopen($filename, 'w+');
    fwrite($newfile, serialize($array));
    fclose($newfile);
    header("Location:" . $_SERVER['PHP_SELF']);
endif;
if (filter_input(INPUT_POST, 'order')):
    $_SESSION['order_id'] = filter_input(INPUT_POST, 'order');
    header("Location:" . 'order.php');
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
        <link href="../css/admin.css" rel="stylesheet" type="text/css"/>
    </head>
    <style>
        input{
            user-select: none;
        }
    </style>
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
                        <li><a href="categories.php">Категории</a></li>
                        <li class="active"><a href="orders.php">Заказы</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="../"><span class="glyphicon glyphicon-log-in"></span> На сайт</a></li>
                        <li><form method="post" class="form-inline"><input type="submit" name="exit" value="Выйти" class="btn btn-link"><span class="glyphicon glyphicon-log-in"></span></form></li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container">
            <h2>Заказы:</h2>  
            <br>
            <br>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID заказа</th>
                        <th>Управление</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($file):
                        if (filesize($filename) > 0):
                            foreach ($array as $id => $order):
                                ?>
                                <tr>
                                    <td><strong>
                                            <form method="post" enctype="multipart/form-data">
                                                <label style="cursor: pointer">Заказ №<input type="submit" name="order" value="<?= $id ?>" class="btn btn-link"/></label>
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
                                <?php
                            endforeach;
                        endif;
                    endif;
                    ?>
                </tbody> 
            </table>
        </div>
    </body>
</html>