<?php

$dbh = new \PDO('mysql:host=localhost;dbname=service-3_gg;charset=UTF8', 'service-3_mysql', '0X4l3U3q');

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

// $ms = $dbh->query("SELECT id, LOWER(name) as 'name' FROM markas")->fetchAll(\PDO::FETCH_ASSOC);
// foreach ($ms as $k=>$v) {
//   $ms[$v['name']] = $v['id'];
//   unset($ms[$k]);
// }
//
// $mts = $dbh->query("SELECT id, LOWER(name) as 'name' FROM model_types")->fetchAll(\PDO::FETCH_ASSOC);
// foreach ($mts as $k=>$v) {
//   $mts[$v['name']] = $v['id'];
//   unset($mts[$k]);
// }
//
//
// $mms = csvToArray(file_get_contents('mms2.csv'));
//
// $insert = [];
// $err = false;
//
// foreach ($mms as $k=>$mm) {
//   $type = strtolower(trim($mm[0]));
//   $marka = strtolower(trim($mm[1]));
//   $name = trim($mm[2]);
//   $nameRu = isset($mm[3]) ? trim($mm[3]) : '';
//
//   if (!isset($ms[$marka]) || !isset($mts[$type])) {
//     echo 'undefined suka '.($k+1).'<br>';
//     $err = true;
//   }
//   else {
//     $type = $mts[$type];
//     $marka = $ms[$marka];
//     $insert[] = "(NULL, $type, $marka, '$name', '$nameRu')";
//   }
// }
//
//
// if (!$err) {
//   $insert = "INSERT INTO m_models2(id, model_type_id, marka_id, name, name_ru) VALUES ".implode(',', $insert);
//   echo $insert;
//   #$dbh->query($insert);
// }

//-----

$mms = $dbh->query("SELECT id, model_type_id as 'type', LOWER(name) as 'name' FROM m_models2")->fetchAll(\PDO::FETCH_ASSOC);
foreach ($mms as $k=>$v) {
  $mms[$v['type'].'-'.$v['name']] = $v['id'];
  unset($mms[$k]);
}

$msStmt = $dbh->query("SELECT models2.id, model_type_id as 'type' FROM models2 JOIN model_type_to_markas ON models2.model_type_mark = model_type_to_markas.id")->fetchAll(\PDO::FETCH_ASSOC);
$ms = [];
foreach ($msStmt as $k=>$v) {
  $ms[$v['id']] = $v['type'];
}

$mtms = csvToArray(file_get_contents('ms.csv'));

$insert = [];
$err = false;

foreach ($mtms as $m) {
  $id = $m[0];
  $mm = trim(strtolower($m[1]));
  $type = $ms[$id];
  if (!isset($mms[$type.'-'.$mm])) {
    echo 'callich '.($k+1);
    $err = true;
  }
  else {
    $mm = $mms[$type.'-'.$mm];
    $insert[] = "($id, $mm)";
  }
}

if (!$err) {
  $insert = "INSERT INTO models2_to_m_models2(model_id, m_model_id) VALUES ".implode(',', $insert);
  echo $insert;
  $dbh->query($insert);
}

?>
