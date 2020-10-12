<?php


if (isset($_POST['submit'])) {
  $file = file_get_contents($_FILES['in']['tmp_name']);
  $file = iconv("Windows-1251", "UTF-8", $file);
  $rows = explode("\r\n", $file);

  $res = [];
  $n = 0;

  foreach ($rows as $row) {
    //echo $row;
    //exit;
    $cols = explode(";", $row);
    //var_dump($cols);
    //exit;
    if (count($cols) < 4) continue;
    $name = trim($cols[1]);
    if (isset($res[$name])) {
      $res[$name]['items'][] = [trim($cols[2]), trim($cols[3])];
    }
    else {
      $res[$name] = [
        'num' => ++$n,
        'items' => [[trim($cols[2]), trim($cols[3])]],
      ];
    }
  }

  $resStr = [];

  foreach ($res as $k=>$name) {
    foreach ($name['items'] as $item) {
      $row = [$name['num'], $k, $item[0], $item[1]];
      $resStr[] = implode(';', $row);
    }
  }

  header('Content-Type: application/csv');
  header("Content-disposition: attachment; filename = res.csv");
  echo iconv("UTF-8", "Windows-1251", implode(PHP_EOL, $resStr));

  exit;
}

?>

<form method = "POST" enctype="multipart/form-data">
  <input type = "file" name = "in">
  <input type = "submit" name = "submit">
</form>
