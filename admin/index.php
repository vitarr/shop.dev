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
            max-width: 100px;
        }
        h2{
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
                        <li class="active"><a href="#">Товары</a></li>
                        <li><a href="#">Категории</a></li>
                        <li><a href="#">Заказы</a></li>
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
                    foreach ($goodsarray as $good):
                        ?>
                        <tbody>
                            <tr>
                                <td class='images'><img src="images/<?= $good['imagename'] ?>"></td>
                                <td><strong><?= $good['name'] ?></strong></td>
                                <td><strong><?= $good['price'] ?></strong></td>
                                <td><strong><?= $good['category'] ?></strong></td>
                                <td><strong><?= $good['id'] ?></strong></td>
                            </tr>
                        </tbody> 
                        <?php
                    endforeach;
                    fclose($goodsfile);
                endif;
                ?>
            </table>
        </div>
    </body>
</html>
