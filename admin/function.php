<?php

function handler($file, $size, $root) {
    if (!isset($_FILES[$file])) {
        $message = 'Изображение отсутствует';
    } else {
            if ($error != UPLOAD_ERR_OK) {
                switch ($error) {
                    case UPLOAD_ERR_INI_SIZE:
                        $message = '<div class="alert alert-danger">
                    <h2>Отказ!</h2><h3>Размер файла превышает допустимый сервером.</h3>
                </div>';
                        break;
                    case UPLOAD_ERR_FORM_SIZE:
                        $message = '<div class="alert alert-danger">
                    <h2>Отказ!</h2><h3>Размер файла превышает допустимый.</h3>
                </div>';
                        break;
                    case UPLOAD_ERR_PARTIAL:
                        $message = '<div class="alert alert-danger">
                    <h2>Отказ!</h2><h3>Загруженный файл был загружен только частично.</h3>
                </div>';
                        break;
                    case UPLOAD_ERR_NO_FILE:
                        $message = '<div class="alert alert-danger">
                    <h2>Отказ!</h2><h3>Файл не был загружен.</h3>
                </div>';
                        break;
                    case UPLOAD_ERR_NO_TMP_DIR:
                        $message = '<div class="alert alert-danger">
                    <h2>Отказ!</h2><h3>Отсутствует временная папка.</h3>
                </div>';
                        break;
                    case UPLOAD_ERR_CANT_WRITE:
                        $message = '<div class="alert alert-danger">
                    <h2>Отказ!</h2><h3>Не удалось записать файл на диск.</h3>
                </div>';
                        break;
                    case UPLOAD_ERR_EXTENSION:
                        $message = '<div class="alert alert-danger">
                    <h2>Отказ!</h2><h3>Загрузка файла остановлена расширением.</h3>
                </div>';
                        break;

                    default:
                        $message = '<div class="alert alert-danger">
                    <h2>Отказ!</h2><h3>Неизвестная ошибка загрузки.</h3>
                </div>';
                        break;
                }
            } elseif (!in_array($_FILES[$file]['type'], AVAILABLE_TYPES)) {
                $message = '<div class="alert alert-danger">
                    <h2>Отказ!</h2><h3>Тип файла не соответствует.</h3>
                </div>';
            } elseif ($_FILES[$file]['size'] > $size * 1024 * 1024) {
                $message = '<div class="alert alert-warning">
                    <h2>Внимание!</h2><h3>Размер файла больше допустимого.</h3>
                </div>';
            } else {
                $name = $_FILES[$file]['name'];
                $tmp_path = $_FILES[$file]['tmp_name'];
                $destination_path = $root . DIRECTORY_SEPARATOR . $name;
                if (move_uploaded_file($tmp_path, $destination_path)) {
                    $message = array(
                        '<div class="alert alert-success">
                    <h2>Успех!</h2><h3>Новый товар успешно успешно добавлен.</h3>
                </div>',
                        'loaded'
                    );
                } else {
                    $message = '<div class="alert alert-warning">
                    <h2>Внимание!</h2><h3>Возникла ошибка при сохранении файла.</h3>
                </div>';
                }
            }
    }
    return $message;
}
