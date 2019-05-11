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

    // Запрос на получение списка категорий
    $sql = "SELECT id, name FROM categories";

    // Выполняем запрос и получаем резуьтат
    $result = mysqli_query($link, $sql);

    // Запрос выполнен успешно
    if ($result) {
        // Получаем все категории в виде двумерного массива
        $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        // Получить текст последней ошибки
        $error = mysqli_error($link);
        print ("Ошибка подключения: " . $error);
    }
    // Передаем в основной шаблон результат выполнения
    $content = include_template('add.php', ['categories' => $categories]);

    // Проверяем получение данных из формы
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $lot = $_POST['lot'];

        // Прописываем новое имя и путь для сохраняемого файла
        $filename = uniqid() . '.jpg';
        $lot['path'] = 'uploads/' . $filename;

        // Перемещаем картинку в папку uploads
        move_uploaded_file($_FILES['lot_img']['tmp_name'], 'uploads/' . $filename);

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
}
// Подключаем layout
print(include_template('layout.php', [
    'title' => $title,
    'content' => $content,
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'categories' => $categories
]));