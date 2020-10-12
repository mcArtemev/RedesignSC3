<?php
$sc2_dbname = $_ENV['CFG_DATA']['db']['sc2']['db_name'];
$sc2_login = $_ENV['CFG_DATA']['db']['sc2']['sc2-user']['user'];
$sc2_pass = $_ENV['CFG_DATA']['db']['sc2']['sc2-user']['pass'];

$dbh2 = new \PDO('mysql:host=localhost;dbname='.$sc2_dbname.';charset=UTF8', $sc2_login, $sc2_pass);

$stmt = $dbh2->query("SELECT id, name FROM model_types");

$types = [];
foreach ($stmt->fetchAll() as $t) {
  $types[$t[1]] = $t[0];
}

function csvToArray($string, $iconv = false) {
  if ($iconv)
    $string = iconv("Windows-1251", "UTF-8", $string);

  $rows = explode("\r\n", $string);

  $res = [];

  foreach ($rows as $row) {
    $cols = explode(";", $row);
    if (count($cols) < 3 || trim($cols[2]) == '') continue;
    $res[] = $cols;
  }

  return $res;
}

$services = [];

$stmt = $dbh2->prepare("INSERT INTO services(id, name, model_type_id, cost, time_repair, syns, url, title, urlWork) VALUES (NULL, :name, :type, :cost, :time, :syns, :url, :title, :urlWork)");

foreach (csvToArray(file_get_contents('./services.csv')) as $k=>$service) {
  if ($k == 0) continue;
  if (trim($service[1]) != '') {
    $url = trim($service[1]);
    $urlWork = 1;
  }
  else {
    $url = '';
    $urlWork = 0;
  }
  $syns = [];
  for ($i=7;$i<=12;$i++) {
    if (trim($service[$i]) != '') {
      $syns[] = trim($service[$i]);
    }
  }
  $syns = implode('@', $syns);
  if ((int)$service[4] > 300) {
    $offset = rand(0,1) ? 50 : -50;
    $cost = (int)$service[4] + $offset;
  }
  else {
    $cost = (int)$service[4];
  }
  $item = [
    'name' => $service[6],
    'type' => $types[mb_strtolower($service[2])],
    'cost' => $cost,
    'time' => $service[3],
    'syns' => $syns,
    'url' => $url,
    'title' => trim($service[5]) == '' ? '' : trim($service[5]),
    'urlWork' => $urlWork,
  ];
  $stmt->execute($item);
  $services[] = $item;
}

?>
