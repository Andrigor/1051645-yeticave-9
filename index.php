<?php

require_once ('init.php');
require_once('functions.php');

session_start();

// Запрос на показ объявлений
$sql = "SELECT l.id, title, path, start_price, name FROM lot l "
    . "JOIN categories c on l.category_id = c.id "
    . "WHERE user_id_win IS NULL "
    . "ORDER BY created_at DESC LIMIT 9";

// Делаем запрос и проверяем
if ($res = mysqli_query($link, $sql)) {
    $advert = mysqli_fetch_all($res, MYSQLI_ASSOC);

    // Передаем в основной шаблон результат выполнения
    $content = include_template('index.php', ['categories' => $categories, 'advert' => $advert]);
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