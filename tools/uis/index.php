<?php

/*session_start();

require_once 'UisCallApi.php';

$uisCA = new UisCallApi();

if (isset($_POST['type'])) {

  if ($_POST['type'] == 1) {

    $call = $uisCA->callMethod('start.employee_call', [
      'first_call' => 'employee',
      'virtual_phone_number' => '74951045666',
      'contact' => '79152184658',
      'employee' => [
        'id' => 347458,
        'phone_number' => '023131',
      ],
    ]);

    echo '<pre>';
    print_r($call);
    echo '</pre>';

    $session_id = $call['result']['data']['call_session_id'];
    $_SESSION['csID'] = $session_id;
  }
  else if ($_POST['type'] == 2 && isset($_SESSION['csID'])) {

    $call = $uisCA->callMethod('hold.call', [
      'call_session_id' => $_SESSION['csID'],
    ]);

    echo '<pre>';
    print_r($call);
    echo '</pre>';

  }
  else if ($_POST['type'] == 3 && isset($_SESSION['csID'])) {

    $call = $uisCA->callMethod('make.call', [
      'call_session_id' => $_SESSION['csID'],
      'to' => '79165243329',
    ]);

    echo '<pre>';
    print_r($call);
    echo '</pre>';

  }
  else if ($_POST['type'] == 4 && isset($_SESSION['csID'])) {

    $call = $uisCA->callMethod('transfer.talk', [
      'call_session_id' => $_SESSION['csID'],
    ]);

    echo '<pre>';
    print_r($call);
    echo '</pre>';

  }
  else if ($_POST['type'] == 5 && isset($_SESSION['csID'])) {

    $call = $uisCA->callMethod('unhold.call', [
      'call_session_id' => $_SESSION['csID'],
    ]);

    echo '<pre>';
    print_r($call);
    echo '</pre>';

  }
}


?>
<br><br>
<form method = "POST">
  <input type = "hidden" name = "type" value = "1">
  <input type = "submit" value = "Начать звонок">
</form>
<br>
<form method = "POST">
  <input type = "hidden" name = "type" value = "2">
  <input type = "submit" value = "Поставить на удержание">
</form>
<br>
<form method = "POST">
  <input type = "hidden" name = "type" value = "3">
  <input type = "submit" value = "Создать для трансфера">
</form>
<br>
<form method = "POST">
  <input type = "hidden" name = "type" value = "4">
  <input type = "submit" value = "Transfer">
</form>
<br>
<form method = "POST">
  <input type = "hidden" name = "type" value = "5">
  <input type = "submit" value = "отключить удержание">
</form>
<br>

<?php

exit;*/

require_once 'UisDataApi.php';

$uisDA = new UisDataApi();



//$res = $uisDA->userEditStatus(347458, true);

// echo '<pre>';
// print_r($res);
// echo '</pre>';
//
// exit;*/

function csvToArray($string, $iconv = true) {
  if ($iconv)
    $string = iconv("Windows-1251", "UTF-8", $string);

  $rows = explode("\r\n", $string);

  $res = [];

  foreach ($rows as $row) {
    $cols = explode(";", $row);
    if (count($cols) < 1 || trim($cols[0]) == '') continue;
    $res[] = $cols;
  }

  return $res;
}

function arrayToCsv($arr, $iconv = true) {
  $newArr = [];
  foreach ($arr as $k=>$v) {
    foreach ($v as $k1=>$v1) {
      $newArr[] = implode(';', [$k, $k1, $v1[2]]);
    }
  }

  $res = implode("\r\n", $newArr);

  if ($iconv)
    $res = iconv("UTF-8", "Windows-1251", $res);

  return $res;
}


$zhopa = [
  'Санкт-Петербург' => ['спб', 'петербург'],
  'Балашиха' => 'бал',
  'Брянск' => 'бря',
  'Воронеж' => 'врн',
  'Екатеринбург' => 'екб',
  'Ижевск' => 'иж',
  'Казань' => 'кзн',
  'Липецк' => 'лип',
  'Волгоград' => 'влг',
  'Краснодар' => 'крд',
  'Москва' => 'мск',
  'Нижний Новгород' => 'нн',
  'Новороссийск' => 'новорос',
  'Новосибирск' => 'нск',
  'Набережные Челны' => ['нч', 'нче'],
  'Омск' => 'омс',
  'Оренбург' => 'орн',
  'Пенза' => 'пен',
  'Ростов-на-Дону' => 'рнд',
  'Рязань' => 'ряз',
  'Самара' => 'сам',
  'Саранск' => 'сар',
  'Сочи' => 'соч',
  'Тверь' => 'тве',
  'Томск' => 'том',
  'Тула' => 'тул',
  'Тюмень' => 'тюм',
  'Ульяновск' => 'уль',
  'Чебоксары' => 'чеб',
  'Челябинск' => 'чел',
  'Ярославль' => 'яр',
  'Магнитогорск' => 'маг',
  'Пермь' => 'пер',
  'Курск' => 'кур',
  'Красноярск' => 'крс',
  'Киров' => 'кир',
];

$sites = csvToArray(file_get_contents('sites.csv'));
$regions = csvToArray(file_get_contents('regions.csv'));
$setkas = csvToArray(file_get_contents('setkas.csv'));

$keys = [];
foreach ($sites as $k=>$site) {
  if (!isset($site[3]) || !isset($site[4]) || $site[3] > 8) {
    var_dump($k+1, $site);
    exit;
  }
  $keys[$site[3]][$site[4]] = [$site[3], $site[4], 0];
}

foreach ($regions as $k => $region) {
  $regions[mb_strtolower($region[1])] = $region[0];
  if (isset($zhopa[$region[1]])) {
    if (!is_array($zhopa[$region[1]]))
      $add = [$zhopa[$region[1]]];
    else
      $add = $zhopa[$region[1]];

    foreach ($add as $a) {
      $regions[mb_strtolower($a)] = $region[0];
    }
  }
  unset($regions[$k]);
}

foreach ($setkas as $k => $setka) {
  $setkas[mb_strtolower($setka[3])] = $setka[0];
  unset($setkas[$k]);
}



$res = $uisDA->callMethod('get.employees');
$list = [];

foreach ($res['result']['data'] as $empl) {
  $list[] = $empl['id'].';'.$empl['full_name'];
}

file_put_contents('list.csv', implode("\r\n", $list));


$list = csvToArray(file_get_contents('list.csv'), false);

$res = [];

$count = 0;

foreach ($list as $empl) {
  if (preg_match('/([А-Яа-я]+)\s+(СЦ\-\d+)/u', $empl[1], $match)) {
    if (isset($setkas[mb_strtolower($match[2])]) && isset($regions[mb_strtolower($match[1])])) {
      $keys[$setkas[mb_strtolower($match[2])]][$regions[mb_strtolower($match[1])]][2] = $empl[0];
      $res[$setkas[mb_strtolower($match[2])]][$regions[mb_strtolower($match[1])]] = $empl[0];
      $count++;
    }
  }
  else if (preg_match('/(СЦ\-\d+)\s+([А-Яа-я]+)/u', $empl[1], $match)) {
    if (isset($setkas[mb_strtolower($match[1])]) && isset($regions[mb_strtolower($match[2])])) {
      $keys[$setkas[mb_strtolower($match[1])]][$regions[mb_strtolower($match[2])]][2] = $empl[0];
      $res[$setkas[mb_strtolower($match[1])]][$regions[mb_strtolower($match[2])]] = $empl[0];
      $count++;
    }
  }
}

echo $count.'<br>';
echo '<pre>';
print_r($res);
echo '</pre>';

file_put_contents("result2.csv", arrayToCsv($keys, false));

?>
