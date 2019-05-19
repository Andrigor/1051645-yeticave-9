<?php

date_default_timezone_set('Europe/Moscow');
$is_auth = rand(0, 1);
$user_name = 'Igor'; // укажите здесь ваше имя
$title_layout = 'Главная';

require_once('functions.php');

// Подключение к базе данных
$link = mysqli_connect("localhost", "Igor", "", "yeticave1");
mysqli_set_charset($link, "utf8");

// Проверка подключения
if ($link == false) {
    print("Ошибка подключения: " . mysqli_connect_error());
} else {

    // Запрос на получение списка категорий
    $sql = "SELECT * FROM categories";

    // Выполняем запрос и получаем резуьтат
    $result = mysqli_query($link, $sql);

    // Запрос выполнен успешно
    if ($result) {
        // Получаем все категории в виде двумерного массива
        $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        // Получить текст ошибки
        $error = mysqli_error($link);
        print ("Ошибка подключения: " . $error);
    }
}