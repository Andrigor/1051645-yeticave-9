<?php
date_default_timezone_set('Europe/Moscow');
$is_auth = rand(0, 1);
$user_name = 'Igor'; // укажите здесь ваше имя
$title = 'Главная';

require_once('functions.php');

// Подключение к базе данных
$link = mysqli_connect("localhost", "Igor", "", "yeticave1");
mysqli_set_charset($link, "utf8");

// Проверка подключения
if ($link == false) {
    print("Ошибка подключения: " . mysqli_connect_error());
} else {
    //print("Соединение установлено");
    // Запрос на получение списка категорий
    $sql = "SELECT id, name, symbol FROM categories";

    // Выполняем запрос и получаем резуьтат
    $result = mysqli_query($link, $sql);

    // Запрос выполнен успешно
    if ($result) {
        // Получаем все категории в виде двумерного массива
        $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        // Получить текст поседней ошибки
        $error = mysqli_error($link);
        print ("Ошибка подключения: " . $error);
    }
    // Запрос на показ объявлений
    $sql = "SELECT l.id, category_id, title, path, start_price, name FROM lot l "
        . "JOIN categories c on l.category_id = c.id "
        . "WHERE user_id_win IS NULL "
        . "ORDER BY created_at DESC LIMIT 6";

    // Делаем запрос и проверяем
    if ($res = mysqli_query($link, $sql)) {
        $advert = mysqli_fetch_all($res, MYSQLI_ASSOC);

        // Передаем в основной шаблон результат выполнения
        $content = include_template('index.php', ['categories' => $categories, 'advert' => $advert]);
    } else {
        $error = mysqli_error($link);
        print ("Ошибка подключения: " . $error);
    }
}
// Подключаем layout
print(include_template('layout.php', [
    'title' => $title,
    'content' => $content,
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'categories' => $categories
]));

