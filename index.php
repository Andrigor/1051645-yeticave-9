<?php
$is_auth = rand(0, 1);
$user_name = 'Igor'; // укажите здесь ваше имя
$title = 'Главная';
$categories = ["Доски и лыжи", "Крепления", "Ботинки", "Одежда", "Инструменты", "Разное"];
$advert = [
    [
        'name' => '2014 Rossignol District Snowboard',
        'category' => 'Доски и лыжи',
        'price' => 10999,
        'pic' => 'img/lot-1.jpg'
    ],
    [
        'name' => 'DC Ply Mens 2016/2017 Snowboard',
        'category' => 'Доски и лыжи',
        'price' => 159999,
        'pic' => 'img/lot-2.jpg'
    ],
    [
        'name' => 'Крепления Union Contact Pro 2015 года размер L/XL',
        'category' => 'Крепления',
        'price' => 8000,
        'pic' => 'img/lot-3.jpg'
    ],
    [
        'name' => 'Ботинки для сноуборда DC Mutiny Charocal',
        'category' => 'Ботинки',
        'price' => 10999,
        'pic' => 'img/lot-4.jpg'
    ],
    [
        'name' => 'Куртка для сноуборда DC Mutiny Charocal',
        'category' => 'Одежда',
        'price' => 7500,
        'pic' => 'img/lot-5.jpg'
    ],
    [
        'name' => 'Маска Oakley Canopy',
        'category' => 'Разное',
        'price' => 5400,
        'pic' => 'img/lot-6.jpg'
    ]
];
function format_price ($cost) {
    $form_cost = ceil($cost);
    if ($form_cost > 1000) {
        $form_cost = number_format($form_cost, 0, '', ' ');
    }
    $form_cost = $form_cost . " " . "&#8381";
    return $form_cost;
}

function include_template($name, array $data = []) {
    $name = 'templates/' . $name;
    $result = '';

    if (!is_readable($name)) {
        return $result;
    }

    ob_start();
    extract($data);
    require $name;

    $result = ob_get_clean();

    return $result;
}

function Show_time(){
    $cur_time = time();
    $midnight_time = strtotime('tomorrow');
    $diff_time = date('H:i', $midnight_time - $cur_time);

    Return $diff_time;
}

$content = include_template('index.php', ['categories' => $categories, 'advert' => $advert]);

$page = include_template('layout.php', [
    'title' => $title,
    'content' => $content,
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'categories' => $categories
]);

print($page);

?>

