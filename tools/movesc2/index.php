<?php

define('DS', DIRECTORY_SEPARATOR);

use framework\pdo;

spl_autoload_register(function ($class) {
    $class = str_replace('\\', DS, $class);
    include dirname(dirname(__DIR__)) . DS . $class . '.php';
});


$except_brands = array(
    'MSI',
    'Sony',
    'Nikon',
    'Dell',
    'Apple'
);

//$sql = "SELECT * FROM regions WHERE name LIKE 'Новосибирск'"; // 9
$sql = "SELECT m.name FROM sites AS s
          JOIN marka_to_sites AS mts ON mts.site_id = s.id
          JOIN markas AS m ON m.id = mts.marka_id
          WHERE s.region_id = 9 AND setka_id = 2";


$stmt = pdo::getPdo()->prepare($sql);
$stmt->execute();
$brands = array_column($stmt->fetchAll(\PDO::FETCH_ASSOC), 'name');

$brands = array_diff($brands, $except_brands);

echo '<pre>';
var_dump($brands);
echo '</pre>';

echo '<hr>';

$sql = "SELECT s.name FROM sites AS s 
          JOIN marka_to_sites AS mts ON mts.site_id = s.id
          JOIN markas AS m ON m.id = mts.marka_id
          WHERE m.name IN :brands";

echo $brandsStr =  "('" .  implode("', '", $brands) . "')";

$stmt = pdo::getPdo()->prepare($sql);
$stmt->execute(array('brands' => $brandsStr ));
$sites = array_column($stmt->fetchAll(\PDO::FETCH_ASSOC), 'name');

echo '<pre>';
var_dump($brands);
echo '</pre>';
