<?php

require_once('init.php');
require_once('functions.php');

session_start();

// Проверяем получение данных из формы
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $form = $_POST;
    $errors = [];

    // Определяем список полей для валидации, описание
    $req_fields = ['email', 'password'];
    $dict = ['email' => 'E-mail', 'password' => 'Пароль'];

    // Проверяем заполненность полей и записываем ошибки
    foreach ($req_fields as $field) {
        if (empty($form[$field])) {
            $errors[$field] = "Это поле надо заполнить";
        }
    }
    // Найдем в таблице users пользователя с переданным email
    $email = mysqli_real_escape_string($link, $form['email']);
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $res = mysqli_query($link, $sql);

    $user = $res ? mysqli_fetch_array($res, MYSQLI_ASSOC) : null;

    if (!count($errors) && $user) {
        // Проверяем, что пароль верный и записываем в сессию данные, либо записываем ошибку
        if (password_verify($form['password'], $user['password'])) {
            $_SESSION['user'] = $user;
        } else {
            $errors['password'] = 'Неверный пароль';
        }
    } else {
        // Если пользователь не найден, то записываем это как ошибку валидации
        $errors['email'] = 'Такой пользователь не найден';
    }
    // Подключаем шаблон с ошибками (если есть)
    if(count($errors)) {
        $content = include_template('login.php', ['categories' => $categories, 'errors' => $errors, 'form' => $form,
            'dict' => $dict]);
    } else {
        // Направляем на главную страницу, если все ОК
        header("Location: /index.php");
        exit();
    }
} else {
    $content = include_template('login.php', ['categories' => $categories]);
}

// Подключаем layout
print(include_template('layout.php', [
    'title_layout' => $title_layout,
    'content' => $content,
    'categories' => $categories
]));