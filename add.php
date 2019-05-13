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
    $sql = "SELECT id, name FROM categories";

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
}
// Подключаем layout
print(include_template('layout.php', [
    'title_layout' => $title_layout,
    'content' => $content,
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'categories' => $categories
]));