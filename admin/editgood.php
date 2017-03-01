<?php
session_start();
if (!isset($_SESSION['auth'])):
    header("Location:" . '../');
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
$handle = fopen($filename, 'r');
$array = unserialize(fgets($handle));
(array) $array;
fclose($handle);
$item_id = $_SESSION['edit_id'];
$cat_id = $_SESSION['category_of_edit'];

if (filter_input(INPUT_POST, 'edit')):
    $file = 'image';
    $size = 3;
    $root = 'images';
    include_once 'imagefunction.php';
    $message = handler($file, $size, $root, $AVAILABLE_TYPES);
    if ($message[1] == 'loaded' || !$_FILES[$file]['name']):
        $message = '<div class="alert alert-success">
                    <h3 style="text-align: center">Товар успешно успешно отредактирован.</h3>
                </div>';
        $_SESSION['message'] = $message;
        if ($_FILES[$file]['name']):
            $array[$cat_id]['items'][$item_id]['imagename'] = $_FILES[$file]['name'];
        endif;
        $array[$cat_id]['items'][$item_id]['name'] = filter_input(INPUT_POST, 'name');
        $array[$cat_id]['items'][$item_id]['description'] = filter_input(INPUT_POST, 'description');
        $array[$cat_id]['items'][$item_id]['price'] = filter_input(INPUT_POST, 'price');
        if ($cat_id !== filter_input(INPUT_POST, 'selectedcat')):
            $array[filter_input(INPUT_POST, 'selectedcat')]['items'][$item_id] = $array[$cat_id]['items'][$item_id];
            $_SESSION['category_of_edit'] = filter_input(INPUT_POST, 'selectedcat');
            unset($array[$cat_id]['items'][$item_id]);
        endif;
        $newfile = fopen($filename, 'w+');
        fwrite($newfile, serialize($array));
        fclose($newfile);
        header("Location:" . $_SERVER['PHP_SELF']);
    endif;
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
    <body>
        <nav class="navbar navbar-inverse">
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
                        <li class="active"><a href="goods.php">Товары</a></li>
                        <li><a href="categories.php">Категории</a></li>
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
            <form method="post" enctype="multipart/form-data">
                <h2>Редактирование товара:</h2>
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
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="images">
                                <img src="images/<?= $array[$cat_id]['items'][$item_id]['imagename'] ?>">
                                <input type="file" name="image"/>
                            </td>
                            <td>
                                <input type="text" name="name"  value="<?= $array[$cat_id]['items'][$item_id]['name'] ?>"/>
                            </td>
                            <td>
                                <textarea type="text" name="description"><?= $array[$cat_id]['items'][$item_id]['description'] ?></textarea>
                            </td>
                            <td>
                                <input type="number" name="price"  value="<?= $array[$cat_id]['items'][$item_id]['price'] ?>"/>
                            </td>
                            <td>
                                <select name="selectedcat" required>
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
                <input type="submit" name="edit" value="Подтвердить изменения"/>
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