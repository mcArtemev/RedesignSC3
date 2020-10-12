<?php
$sc3_dbname = $_ENV['CFG_DATA']['db']['sc3']['db_name'];
$sc3_login = $_ENV['CFG_DATA']['db']['sc3']['sc3-user']['user'];
$sc3_pass = $_ENV['CFG_DATA']['db']['sc3']['sc3-user']['pass'];

$dbh2 = new \PDO('mysql:host=localhost;dbname='.$sc3_dbname.';charset=UTF8', $sc3_login, $sc3_pass);

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

$geo = csvToArray(file_get_contents('geo.csv'));

$types = [
  'округ' => 'county',
  'метро' => 'metro',
];

$insert = [];

foreach ($geo as $g) {
  $type = $types[trim(mb_strtolower($g[1]))];
  $name = trim($g[0]);
  $insert[] = "(NULL, 0, '$type', '$name')";
}

$sql = "INSERT INTO geo(id, city_id, type, name) VALUES ".implode(',', $insert);

echo $sql;
$dbh2->query($sql);
var_dump($dbh2->errorInfo());

?>
