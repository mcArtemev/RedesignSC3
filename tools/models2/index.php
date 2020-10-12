<?php

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

  $models = csvToArray($file);

  $dbh = new \PDO('mysql:host=localhost;dbname=service-3_gg;charset=UTF8', 'service-3_mysql', '0X4l3U3q');
  $stmt = $dbh->query("SELECT model_type_to_markas.id as 'id', model_types.name as 'type', markas.name as 'mark' FROM model_type_to_markas
  JOIN model_types ON model_type_to_markas.model_type_id = model_types.id
  JOIN markas ON model_type_to_markas.marka_id = markas.id");

  $ms = $dbh->query("SELECT name, model_type_mark FROM models2")->fetchAll();
  foreach ($ms as $k=>$v) {
    $ms[$v[0].'_'.$v[1]] = true;
    unset($ms[$k]);
  }

  $ttom = [];


  foreach ($stmt as $item) {
    $ttom[mb_strtolower($item['type'])][mb_strtolower($item['mark'])] = $item['id'];
  }

  // echo "<pre>";
  // print_r($ttom);
  // echo "</pre>";
  //
  // exit;

  $error = $add = [];

  foreach ($models as $n => $model) {
    $n = $n + 1;

    if (count($model) < 3) {
      $error[$n][] = 'Недостаточно аргументов';
      continue;
    }

    foreach ($model as $k=>$v) {
      $model[$k] = trim($v);
    }

    $mType = mb_strtolower($model[0]);
    $mMark = mb_strtolower($model[1]);

    if (!isset($ttom[$mType][$mMark])) {
      $error[$n][] = 'Не найдены тип или марка';
      continue;
    }

    if (isset($ms[$model[2].'_'.$ttom[$mType][$mMark]])) {
      $error[$n][] = 'Данная модель уже существует';
    }

    if (isset($error[$n])) continue;

    $add[] = [
      'type_mark' => $ttom[$mType][$mMark],
      'name' => $model[2],
      'name_ru' => isset ($model[3]) && $model[3] != '' ? $model[3] : null,
    ];

    // if (!isset($types[$mType]))
    //   $error[$n][] = 'Не нашел тип устройства';
    //
    // if (!isset($marks[$mMark]))
    //   $error[$n][] = 'Не нашел марку';
    //
    // $add[$marks[$mMark].'_'.$types[$mType]] = [
    //   'mark' => $marks[$mMark],
    //   'type' => $types[$mType],
    // ];

  }

  if (count($error)) {
    foreach ($error as $n=>$er) {
      echo "$n - ";
      foreach ($er as $tr) {
        echo "$tr; ";
      }
      echo "<br>";
    }
  }
  else {
    if (isset($_GET['r'])) {
      try {
        echo 'Try added...<br>';
        $dbh->beginTransaction();
        $countInInsert = 100;
        for ($i = 1; $i <= ceil(count($add)/$countInInsert); $i++) {
          $from = ($i-1)*$countInInsert;
          $to = $i*$countInInsert;
          if (count($add) < $to) $to = count($add)+1;
          $a = array_slice($add, $from, $to-$from);
          $insert = '';
          foreach ($a as $row) {
            $insert .= (strlen($insert) == '' ? '' : ',').'(NULL, \''.$row['name'].'\',\''.$row['name_ru'].'\','.$row['type_mark'].')';
          }

          $dbh->query("INSERT INTO `models2`(id, name, name_ru, model_type_mark) VALUES ".$insert.";");
          if ($dbh->errorInfo()[0] != '00000') {
            $dbh->rollBack();
            echo 'error '.$i.' iteration '.$dbh->errorInfo()[2];
            exit;
          }
        }

        echo 'Добавлено '.count($add).' моделей';
        $dbh->commit();
      }
      catch (PDOException $e) {
        $dbh->rollBack();
        echo 'error - '.$e;
      }
    }
    else {
      echo "<pre>";
      print_r($add);
      echo "</pre>";
    }
  }
}

?>

<form method = "POST" enctype="multipart/form-data">
  <input type = "file" name = "in">
  <input type = "submit" name = "submit">
</form>

<p>
  Файл csv не меняя кодировку без шапки с 4 столбцами (4 не обязательный):<br>
  тип в е.ч.; марка (англ); имя модели; рус имя модели (необяз)<br>
  При ошибках выведутся их описания и на какой строчке произошло, в ином случае - список добавляемых моделей.<br>
  Если все хорошо и нужно <b>залить</b> - добавляем <b>?r в адресную строку</b> и повторяем заливку.
</p>
<p>После заливки моделей нужно <a href = "real.php">привязать их к сетке</a></p>
