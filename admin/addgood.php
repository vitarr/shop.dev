<?php
session_start();
if (!isset($_SESSION['auth'])):
    header("Location:" . 'http://test.dev');
endif;
$AVAILABLE_TYPES = array(
    'image/jpeg',
    'image/png',
    'image/gif',
);

if (isset($_SESSION['message'])):
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
endif;
$filename = 'goods.txt';
$handle = fopen($filename, 'a+');
$array = unserialize(fgets($handle));
(array) $array;
fclose($handle);
if (filter_input(INPUT_POST, 'add')):
    $file = 'image';
    $size = 3;
    if (!is_dir('images')):
        mkdir('images');
    endif;
    $root = 'images';
    include_once 'imagefunction.php';
    $message = handler($file, $size, $root, $AVAILABLE_TYPES);
    if ($message[1] == 'loaded'):
        $message = $message[0];
        $_SESSION['message'] = $message;
        $id = 0;
        foreach ($array as $category):
            $items_ids = array_keys($category['items']);
            $last_item_id = end($items_ids);
            if ($id <= $last_item_id):
                $id = $last_item_id + 1;
            endif;
        endforeach;
        $array[filter_input(INPUT_POST, 'selectedcat')]['items'][$id] = array(
            'imagename' => $_FILES[$file]['name'],
            'name' => filter_input(INPUT_POST, 'name'),
            'description' => filter_input(INPUT_POST, 'description'),
            'price' => filter_input(INPUT_POST, 'price')
        );
        $newfile = fopen($filename, 'w+');
        fwrite($newfile, serialize($array));
        fclose($newfile);
        header("Location:" . $_SERVER['PHP_SELF']);
    endif;
endif;
if (filter_input(INPUT_POST, 'exit')):
    unset($_SESSION['auth']);
    header("Location:" . 'http://test.dev');
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
                        <li><form method="post" class="form-inline"><input type="submit" name="exit" value="Выйти" class="btn btn-link"><span class="glyphicon glyphicon-log-in"></span></form></li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container">
            <form method="post" enctype="multipart/form-data">
                <h2>Новый товар:</h2> 
                <br>
                <br>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Изображение</th>
                            <th>Название</th>
                            <th>Описание</th>
                            <th>Цена</th>
                            <th>Категория</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="file" name="image" required/></td>
                            <td><input type="text" name="name" required/></td>
                            <td><textarea type="text" name="description" required></textarea></td>
                            <td><input type="number" name="price" required/></td>
                            <td>
                                <select name="selectedcat" required>
                                    <option selected disabled=""></option>
                                    <?php
                                    foreach ($array as $id => $category):
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
                <input type="submit" name="add" value="Добавить товар"/>
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
