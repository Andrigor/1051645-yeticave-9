<?php

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

