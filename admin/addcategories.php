<?php
session_start();
if (isset($_SESSION['message'])):
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
endif;
if (filter_input(INPUT_POST, 'add')):
    $filename = 'goods.txt';
    $handle = fopen($filename, 'a+');
    if ($handle):
        $message = '<div class="alert alert-success">
                    <h3>Новая категория успешно успешно добавлена.</h3>
                </div>';
        $_SESSION['message'] = $message;
        $array = unserialize(fgets($handle));
        (array) $array;
        fclose($handle);
        $categories_ids = array_keys($array);
        $last_category_id = end($categories_ids);
        $id = $last_category_id + 1;
        $array[$id] = array(
            'name' => filter_input(INPUT_POST, 'name'),
            'items' => array()
        );
        $newfile = fopen($filename, 'w+');
        fwrite($newfile, serialize($array));
        fclose($newfile);
        header("Location:" . $_SERVER['PHP_SELF']);
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
            <form method="post" enctype="multipart/form-data">
                <h2>Новая категория:</h2>  
                <br>
                <br>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Название</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="text" name="name" class="name" required/></td>
                        </tr>
                    </tbody> 
                </table>
                <input type="submit" name="add" value="Добавить категорию"/>
            </form>
            <br>
            <?php
            if (isset($message)):
                echo $message;
            endif;
            ?>
        </div>
    </body>
</html>