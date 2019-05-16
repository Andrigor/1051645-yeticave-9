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
        $form = $_POST;
        $errors = [];

        // Определяем список полей для валидации, описание
        $req_fields = ['email', 'password', 'name', 'message'];
        $dict = ['email' => 'E-mail', 'password' => 'Пароль', 'name' => 'Имя', 'message' => "Контактные данные"];

        // Проверяем заполненность полей и записываем ошибки
        foreach ($req_fields as $field) {
            if (empty($form[$field])) {
                $errors[$field] = "Это поле надо заполнить";
            }
        }
        if (!filter_var($form['email'], FILTER_VALIDATE_EMAIL) && !empty($form['email'])) {
            $errors['email'] = 'Введите корректный e-mail';
        }
        // Проверяем существование пользователя
        if (empty($errors)) {
            $email = mysqli_real_escape_string($link, $form['email']);
            $sql = "SELECT id FROM users WHERE email = '$email'";
            $res = mysqli_query($link, $sql);

            if (mysqli_num_rows($res) > 0) {
                $errors['email'] = 'Пользователь с этим email уже зарегистрирован';

            } else {
                // Делаем запрос на добавление нового пользователя через подготовленные выражения
                $password = password_hash($form['password'], PASSWORD_DEFAULT);
                $sql = "INSERT INTO users (created_at, email, name, password, contact) VALUES (NOW(), ?, ?, ?, ?)";
                $stmt = db_get_prepare_stmt($link, $sql, [$form['email'], $form['name'], $password, $form['message']]);
                $res = mysqli_stmt_execute($stmt);
            }
            // Если нет ошибок, то переходим на страницу входа
            if ($res && empty($errors)) {
                header("Location: /pages/login.html");
                exit();
            }
        }
        // Подключаем шаблон с ошибками
        $content = include_template('sign-up.php', ['categories' => $categories, 'errors' => $errors, 'form' => $form,
            'dict' => $dict]);

    } else {
        $content = include_template('sign-up.php', ['categories' => $categories]);
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