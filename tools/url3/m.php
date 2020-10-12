<?php
$sc3_dbname = $_ENV['CFG_DATA']['db']['sc3']['db_name'];
$sc3_login = $_ENV['CFG_DATA']['db']['sc3']['sc3-user']['user'];
$sc3_pass = $_ENV['CFG_DATA']['db']['sc3']['sc3-user']['pass'];

$dbh2 = new \PDO('mysql:host=localhost;dbname='.$sc3_dbname.';charset=UTF8', $sc3_login, $sc3_pass);

$mms = $dbh2->query("SELECT m_models.id, CONCAT(LOWER(markas.name), '_', LOWER(m_models.name)) as 'name' FROM m_models JOIN markas ON m_models.marka_id = markas.id")->fetchAll(\PDO::FETCH_ASSOC);
foreach ($mms as $k=>$v) {
  $mms[$v['name']] = $v['id'];
  unset($mms[$k]);
}

$ms = $dbh2->query("SELECT id, LOWER(name) as 'name' FROM models")->fetchAll(\PDO::FETCH_ASSOC);
foreach ($ms as $k=>$v) {
  $ms[$v['name']] = $v['id'];
  unset($ms[$k]);
}

// $ms = $dbh2->query("SELECT id, LOWER(name) as 'name' FROM markas")->fetchAll(\PDO::FETCH_ASSOC);
// foreach ($ms as $k=>$v) {
//   $ms[$v['name']] = $v['id'];
//   unset($ms[$k]);
// }
//
// $mts = $dbh2->query("SELECT id, LOWER(name) as 'name' FROM model_types")->fetchAll(\PDO::FETCH_ASSOC);
// foreach ($mts as $k=>$v) {
//   $mts[$v['name']] = $v['id'];
//   unset($mts[$k]);
// }

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

// $mms = csvToArray(file_get_contents('mms.csv'));
//
// $insert = [];
//
// foreach ($mms as $k=>$mm) {
//   $marka = strtolower($mm[0]);
//   $type = strtolower($mm[1]);
//   $name = $mm[2];
//   if (!isset($ms[$marka]) || !isset($mts[$type])) {
//     echo $k;
//     exit;
//   }
//   else {
//     $marka = $ms[$marka];
//     $type = $mts[$type];
//   }
//   $insert[] = "(NULL, '$name', '', $marka, $type, NULL)";
// }
//
// $insert = "INSERT INTO m_models(id, name, ru_name, marka_id, model_type_id, brand) VALUES ".implode(',', $insert);
//
// $dbh2->query($insert);
//
// exit;


$nms = csvToArray(file_get_contents('modelsn.csv'));

$errors = $missmm = $insert = [];

foreach ($nms as $k=>$m) {
  if ($k==0) continue;

  $mmodel = trim($m[2]);
  $marka = trim($m[1]);
  $type = trim($m[0]);
  $popular = (int)trim($m[4]) == 1 ? 1 : 0;
  $model = trim($m[5]);

  if (!isset($mms[strtolower($marka).'_'.strtolower($mmodel)])) {
    $errors[$k+1][] = 'Не нашел линейку '.$mmodel;
    $missmm[strtolower($marka).';'.strtolower($type).';'.strtolower($mmodel)] = $marka.';'.$type.';'.$mmodel;
  }
  if (isset($ms[strtolower($model)])) {
    $errors[$k+1][] = 'Нашел модель кек '.$model;
  }


  if (!isset($errors[$k+1])) {
    $mm = $mms[strtolower($marka).'_'.strtolower($mmodel)];
    $insert[] = "(NULL, '$model', $mm, '', '$mmodel', $popular)";
  }
}

if (count($errors)) {
  foreach ($errors as $row => $err) {
    echo $row.' - '.implode('; ', $err).'<br>';
  }
  // echo '<pre>';
  // print_r($missmm);
  // echo '</pre>';

  //file_put_contents('mms.csv', implode("\r\n", $missmm));
}
else {
  echo count($insert);
  $insert = "INSERT INTO models(id, name, m_model_id, submodel, sublineyka, popular) VALUES ".implode(',', $insert);
  #echo $insert;
  #$dbh2->query($insert);
  #var_dump($dbh2->errorInfo());
}


?>
