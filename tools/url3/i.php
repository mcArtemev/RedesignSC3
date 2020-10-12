<?php
$sc3_dbname = $_ENV['CFG_DATA']['db']['sc3']['db_name'];
$sc3_login = $_ENV['CFG_DATA']['db']['sc3']['sc3-user']['user'];
$sc3_pass = $_ENV['CFG_DATA']['db']['sc3']['sc3-user']['pass'];

$dbh2 = new \PDO('mysql:host=localhost;dbname='.$sc3_dbname.';charset=UTF8', $sc3_login, $sc3_pass);

// $in = 'displey
// materinskaya-plata
// multikontroller
// hdmi
// usb
// wifi
// akkumulyator
// kamera
// mikrofon
// razyom-pitaniya
// korpus
// kryshka
// sim-holder
// knopka-vklyucheniya
// gps
// vibro
// dinamik
// shleyf';
//
// $i = 21;
// foreach (explode("\r\n", $in) as $c) {
//   ++$i;
//   $dbh2->query("UPDATE services SET url = REPLACE(url, '-', '_')");
//   exit;
// }

$services = $dbh2->query("SELECT id, url FROM services WHERE model_type_id = 3")->fetchAll(\PDO::FETCH_ASSOC);
foreach ($services as $k=>$v) {
  $services[$v['url']] = $v['id'];
  unset($services[$k]);
}

$complects = $dbh2->query("SELECT id, url FROM complects WHERE model_type_id = 3")->fetchAll(\PDO::FETCH_ASSOC);
foreach ($complects as $k=>$v) {
  $complects[$v['url']] = $v['id'];
  unset($complects[$k]);
}

function csvToArray($str, $countMin = 1) {

  $rows = explode("\r\n", $str);
  $arr = [];

  foreach ($rows as $row) {
    if (trim($row) != '') {
      $item = explode(";", trim($row));
      if (count($item) >= $countMin)
        $arr[] = $item;
    }
  }

  return $arr;
}

// $types = [
//   'ноутбук' => 1,
//   'планшет' => 2,
//   'смартфон' => 3,
// ];
//
// $services = csvToArray(file_get_contents('services.csv'));
//
// $insert = [];
// foreach ($services as $v) {
//   $syns = explode('@', $v[2]);
//   $name = $syns[0];
//   unset($syns[0]);
//   $syns = implode('@', $syns);
//   $time_min = rand(5, 15)*5;
//   $time_max = rand($time_min/5, 15)*5;
//   $cost = rand(2, 50)*50;
//   $insert[] = "(NULL, '$name', {$types[$v[0]]}, $cost, $time_min, $time_max, '$syns', '{$v[1]}', '{$v[3]}', '{$v[4]}', 1)";
// }
//
// exit;
//
// $dbh2->query("INSERT INTO services(id,name,model_type_id,cost,time_min,time_max,syns,url,title,h1,urlWork) VALUES ".implode(',', $insert));
//
// echo "INSERT INTO defects(id,name,model_type_id,cost,time_min,time_max,syns,url,title,h1,urlWork) VALUES ".implode(',', $insert);

// echo '<pre>';
// print_r($complects);
// echo '</pre>';


// $models = csvToArray(file_get_contents('models.csv'));
//
// $stmt = $dbh2->prepare("UPDATE models SET active = 1, popular = ? WHERE LOWER(name) = ?");
// foreach ($models as $model) {
//   $popular = $model[1] == '1' ? 1 : 0;
//   $stmt->execute([$popular, mb_strtolower($model[0])]);
// }

$in = array(
  array('s' => 'zamena-wifi','c' => 'wifi'),
  array('s' => 'zamena-displeya','c' => 'displey'),
  array('s' => 'zamena-materinskoy-platy','c' => 'materinskaya-plata'),
  array('s' => 'zamena-multikontrollera','c' => 'multikontroller'),
  array('s' => 'zamena-hdmi','c' => 'hdmi'),
  array('s' => 'zamena-usb','c' => 'usb'),
  array('s' => 'zamena-shleyfa','c' => 'shleyf'),
  array('s' => 'zamena-batarei','c' => 'akkumulyator'),
  array('s' => 'zamena-gnezda-pitaniya','c' => 'razyom-pitaniya'),
  array('s' => 'zamena-kamery','c' => 'kamera'),
  array('s' => 'zamena-mikrofona','c' => 'mikrofon'),
  array('s' => 'zamena-korpusa','c' => 'korpus'),
  array('s' => 'zamena-dinamika','c' => 'dinamik'),
  array('s' => 'zamena-zadney-kryshki','c' => 'kryshka'),
  array('s' => 'zamena-derzhatelya-sim','c' => 'sim-holder'),
  array('s' => 'zamena-knopki-vklyucheniya','c' => 'knopka-vklyucheniya'),
  array('s' => 'zamena-gps','c' => 'gps'),
  array('s' => 'zamena-vibro','c' => 'vibro')
);

foreach ($in as $k=>$v) {
  $s = str_replace('-', '_', $v['s']);
  $c = str_replace('-', '_', $v['c']);
  if (!isset($services[$s]) || !isset($complects[$c])) {
    echo $s.' '.$c."<br>";
    continue;
  }
  $insert[] = "({$services[$s]}, {$complects[$c]})";
}

$insert = implode(',', $insert);

$dbh2->query("INSERT IGNORE INTO services_complects(service_id, complect_id) VALUES $insert");


?>
