<?php
//подключение к бд
define('DB_HOST', '');
define('DB_USER', '');
define('DB_PASSWORD', '');
define('DB_NAME', '');

define('CLIENT_ID', 0000); //id клиента 
define('SENDER_ID', 0000); //id магазина

$KEYS = array(
//Массив ключей
);
//переменные для шаблонизации
$vars = array();
$vars[0] = array('name' => '%delivery_name%', 'desc' => 'Имя службы доставки');
$vars[1] = array('name' => '%track%', 'desc' => 'Трек номер');
$vars[2] = array('name' => '%full_name%', 'desc' => 'Полное имя получателя');
$vars[3] = array('name' => '%user_phone%', 'desc' => 'Телефон получателя');
$vars[4] = array('name' => '%address_string%', 'desc' => 'Адрес доставки (пункт выдачи или адрес для курьера)');
$vars[5] = array('name' => '%first_name%', 'desc' => 'Имя');
$vars[6] = array('name' => '%text_map%', 'desc' => 'Схема проезда');