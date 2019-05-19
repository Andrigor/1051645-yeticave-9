<?php

require_once ('init.php');
require_once('functions.php');

session_start();

// Проверка параметра запроса
if (isset($_GET['id']) AND !empty($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
} else {
    http_response_code(404);
    print('<h1>404 Ошибка параметра запроса</h1>');
    die();
}
    // Запрос на показ объявления
    $sql = "SELECT title, description, path, start_price, name, step FROM lot l "
        . "JOIN categories c on l.category_id = c.id "
        . "WHERE l.id = $id";

    // Делаем запрос и проверяем
    if ($res = mysqli_query($link, $sql)) {
        $advert = mysqli_fetch_all($res, MYSQLI_ASSOC);
        if (empty($advert)) {
            http_response_code(404);
            print('<h1>404 Ошибка: такой записи нет в БД</h1>');
            die();
        }
        // Передаем в основной шаблон результат выполнения
        $content = include_template('lot.php', ['categories' => $categories, 'advert' => $advert]);
    } else {
        $error = mysqli_error($link);
        print ("Ошибка подключения: " . $error);
    }

// Подключаем layout
print(include_template('layout.php', [
    'title_layout' => $title_layout,
    'content' => $content,
    'categories' => $categories
]));
