<?php

$dbh = new \PDO('mysql:host=localhost;dbname=service-3_gg;charset=UTF8', 'service-3_mysql', '0X4l3U3q');
$setkas = $dbh->query("SELECT id, name FROM setkas")->fetchAll(\PDO::FETCH_ASSOC);

if (isset($_POST['submit'])) {

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

  $file = file_get_contents($_FILES['in']['tmp_name']);
  $file = iconv("Windows-1251", "UTF-8", $file);

  $add = csvToArray($file);
  $sid = $_POST['sid'];

  $stmt = $dbh->query("SELECT models2.id as 'id', models2.name as 'name', model_types.name as 'type', markas.name as 'mark'
  FROM models2
  JOIN model_type_to_markas ON models2.model_type_mark = model_type_to_markas.id
  JOIN model_types ON model_type_to_markas.model_type_id = model_types.id
  JOIN markas ON model_type_to_markas.marka_id = markas.id");

  $models = [];
  foreach ($stmt->fetchAll(\PDO::FETCH_ASSOC) as $m) {
    $models[strtolower($m['mark'])][$m['type']][$m['name']] = $m['id'];
  }

  //echo '<pre>';
  //print_r($models);
  //echo '</pre>';
  //exit;

  $error = [];

  foreach ($add as $k=>$m) {
    foreach ($m as $i=>$v) {
      $m[$i] = trim($v);
    }
    $m[0] = mb_strtolower($m[0]);
    $m[1] = mb_strtolower($m[1]);

	//echo $m[0].' '.$m[1].' '.$m[2];
	//exit;

    if (isset($models[$m[1]][$m[0]][$m[2]])) {
      $add[$k] = $models[$m[1]][$m[0]][$m[2]];
    }
    else {
      $error[$k+1][] = 'Не найдена модель '.$m[2];
    }
  }

  if (count($error)) {
    foreach ($error as $n=>$er) {
      echo "$n - ";
      foreach ($er as $tr) {
        echo "$tr; ";
      }
      echo "<br>";
    }
    exit;
  }

  $countInInsert = 100;
  try {
    $dbh->beginTransaction();

    for ($i = 1; $i <= ceil(count($add)/$countInInsert); $i++) {
      $from = ($i-1)*$countInInsert;
      $a = array_slice($add, $from, $countInInsert);
      $insert = [];
      foreach ($a as $m) {
        $insert[] = '('.$m.','.$sid.')';
      }
      $insert = implode(',', $insert);

      $dbh->query("INSERT IGNORE INTO `models2_to_setka`(id_model, id_setka) VALUES ".$insert.";");
      if ($dbh->errorInfo()[0] != '00000') {
        $dbh->rollBack();
        echo 'error '.$i.' iteration '.$dbh->errorInfo()[2];
        exit;
      }
    }

    echo 'я добавиль<br><br>';
    $dbh->commit();
  }
  catch (PDOException $e) {
    $dbh->rollBack();
    echo 'error '.$e;
    exit;
  }

}


?>

<form method = "POST" enctype="multipart/form-data">
  <p><input type = "file" name = "in"></p>
  <p><select name = "sid">
  <?php foreach ($setkas as $sc) { ?>
    <option value = "<?=$sc['id']?>"><?=$sc['name']?></option>
  <?php } ?>
  </select></p>
  <p><input type = "submit" name = "submit"></p>
</form>

<p>
  Файл в том же виде, что и заливка.<br>
  Модели сразу же привяжутся к сетке, но не будут показаны на сайте.<br>
  После привязки нужно обратиться к программисту, чтобы он сгенерировал урлы для них и сделал активными.
</p>
