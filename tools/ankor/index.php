<?php

require_once 'Ankor.php';


if (isset($_POST['submit'])) {
  $file = file_get_contents($_FILES['in']['tmp_name']);
  $file = iconv("Windows-1251", "UTF-8", $file);
  $rows = explode("\r\n", $file);

  $sites = [];

  foreach ($rows as $row) {
    $cols = explode(";", $row);
    if (count($cols) < 4) continue;

    $sites[] = $cols;
  }

  $resStr = '';

  foreach ($sites as $k => $site) {
    if (trim($site[0]) == '' || trim($site[1]) == '' || trim($site[2]) == '' || trim($site[3]) == '') {
      echo 'error '.($k+1).' row';
      exit;
    }
    Ankor::setParams([
      'site' => $site[0],
      'city' => $site[1],
      'brand' => $site[2],
      'setka' => (int)$site[3],
      'count' => rand(35,40),
    ]);

    $res = Ankor::generate();
    if ($res !== false) {
      $resStr .= Ankor::toCsv($res)."\r\n";
    }
  }

  header('Content-Type: application/csv');
  header("Content-disposition: attachment; filename = ankor.csv");
  echo iconv("UTF-8", "Windows-1251", $resStr);
  exit;
}



?>

<form method = "POST" enctype="multipart/form-data">
  <input type = "file" name = "in">
  <input type = "submit" name = "submit">
</form>
