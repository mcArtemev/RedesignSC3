<?php

$dbh = new \PDO('mysql:host=localhost;dbname=service-3_gg;charset=UTF8', 'service-3_mysql', '0X4l3U3q');

$accord_suffics = array('ноутбук' => 'n', 'планшет' => 'p', 'смартфон' => 'f',
    'компьютер' => 'k', 'принтер' => 'r', 'монитор' => 'o', 'сервер' => 's', 'проектор' => 'e', 'игровая приставка' => 'i',
    'холодильник' => 'h', 'фотоаппарат' => 'a', 'видеокамера' => 'v', 'телевизор' => 't', 'моноблок' => 'm',
        'стиральная машина' => 'w');
$sql = [];

foreach ($accord_suffics as $type=>$s) {
  $sql[] = "SELECT '$type' as 'type', {$s}_service_syns.name, {$s}_services.name_eng FROM `{$s}_services` JOIN {$s}_service_syns ON {$s}_services.id = {$s}_service_syns.{$s}_service_id JOIN {$s}_service_costs ON {$s}_services.id = {$s}_service_costs.{$s}_service_id WHERE {$s}_service_costs.setka_id = 7 GROUP BY {$s}_services.id";
}

$sql = implode(' UNION ', $sql);

echo $sql;

?>
