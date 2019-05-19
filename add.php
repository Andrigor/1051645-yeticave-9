<?php

session_start();

if (!isset($_SESSION['user'])) {
    http_response_code(403);
    //print('<h1>403 Доступ запрещен</h1>');
    die();
}
require_once ('init.php');
require_once('functions.php');

// Проверяем получение данных из формы
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $lot = $_POST;

    // Определяем список полей для валидации, описание
    $required = ['title', 'description', 'start_price', 'step'];
    $dict = ['category' => 'Категория', 'title' => 'Наименование', 'description' => 'Описание', 'file' => "Изображение",
        'start_price' => 'Начальная цена', 'closed_at' => 'Дата окончания торгов', 'step' => 'Шаг ставки'];
    $errors = [];

    // Проверяем заполненность полей и записываем ошибки
    foreach ($required as $key) {
        if (empty($_POST[$key])) {
            $errors[$key] = 'Это поле надо заполнить';
        }
    }
    if ($_POST['category'] == 'Выберите категорию') {
        $errors['category'] = 'Категория не выбрана';
    }
    if (!is_date_valid($_POST['closed_at'])) {
        $errors['closed_at'] = 'Неправильный формат даты';
    }
    if ($_POST['closed_at'] <= date("Y-m-d")) {
        $errors['closed_at'] = 'Дата окончания торгов должна быть не меньше одного дня от текущей';
    }
    if (!filter_var($_POST['start_price'], FILTER_VALIDATE_INT) && $_POST['start_price'] <= 0) {
        $errors['start_price'] = 'Введите числовое значение больше нуля';
    }
    if (!filter_var($_POST['step'], FILTER_VALIDATE_INT) && $_POST['step'] <= 0) {
        $errors['step'] = 'Введите числовое значение больше нуля';
    }

    // Проверяем загружен ли файл и его тип
    if (isset($_FILES['lot_img']['name']) && !empty($_FILES['lot_img']['name'])) {
        $tmp_name = $_FILES['lot_img']['tmp_name'];

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $file_type = finfo_file($finfo, $tmp_name);
        if ($file_type !== 'image/jpeg' && $file_type !== 'image/png') {
            $errors['file'] = 'Загрузите картинку в формате jpeg/png';
        } else {
            // Прописываем новое имя
            $filename = uniqid() . '.jpg';

            // Перемещаем картинку в папку uploads
            move_uploaded_file($tmp_name, 'uploads/' . $filename);
            $lot['path'] = 'uploads/' . $filename;
        }
    } else {
        $errors['file'] = 'Вы не загрузили файл';
    }
    // Подключаем шаблон формы и передаем туда ошибки
    if (count($errors)) {
        $content = include_template('add.php', ['lot' => $lot, 'errors' => $errors, 'dict' => $dict,
            'categories' => $categories]);
    } else {
        // Делаем запрос на добавление лота через подготовленные выражения
        $sql = "INSERT INTO lot (category_id, user_id, created_at, title, description, path, start_price, closed_at, step) "
            . "VALUES (?, 1, NOW(), ?, ?, ?, ?, ?, ?)";

        $stmt = db_get_prepare_stmt($link, $sql, [$lot['category'], $lot['title'], $lot['description'], $lot['path'],
            $lot['start_price'], $lot['closed_at'], $lot['step']]);

        $res = mysqli_stmt_execute($stmt);

        // Переходим на страницу лота если всё ОК
        if ($res) {
            $lot_id = mysqli_insert_id($link);

            header("Location: lot.php?id=" . $lot_id);
        } else {
            $error = mysqli_error($link);
            print ("Ошибка подключения: " . $error);
        }
    }
} else {
    // Передаем в основной шаблон
    $content = include_template('add.php', ['categories' => $categories]);
}

// Подключаем layout
print(include_template('layout.php', [
    'title_layout' => $title_layout,
    'content' => $content,
    'categories' => $categories
]));