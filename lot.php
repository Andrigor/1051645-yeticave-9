<?php

require_once ('functions.php');

if (isset($_GET['id']) AND empty(!$_GET['id'])) {
    $id = $_GET['id'];
}
else {
    http_response_code(404);
    print('<h1>404 Ошибка параметра запроса</h1>');
    die();
}
// Подключение к базе данных
$link = mysqli_connect("localhost", "Igor", "", "yeticave1");
mysqli_set_charset($link, "utf8");

// Проверка подключения
if ($link == false) {
    print("Ошибка подключения: " . mysqli_connect_error());
}
else {
    //print("Соединение установлено");
    // Запрос на получение списка категорий
    $sql = "SELECT id, name, symbol FROM categories";

    // Выполняем запрос и получаем резуьтат
    $result = mysqli_query($link, $sql);

    // Запрос выполнен успешно
    if ($result) {
        // Получаем все категории в виде двумерного массива
        $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    else {
        // Получить текст поседней ошибки
        $error = mysqli_error($link);
        print ("Ошибка подключения: " . $error);
    }
    // Запрос на показ объявления
    $sql = "SELECT title, description, path, start_price, name FROM lot l "
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
        print(include_template('lottemp.php', ['categories' => $categories, 'advert' => $advert]));
    }
    else {
        $error = mysqli_error($link);
        print ("Ошибка подключения: " . $error);
    }
};
