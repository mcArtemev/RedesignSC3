<?php
$sc2_dbname = $_ENV['CFG_DATA']['db']['sc2']['db_name'];
$sc2_login = $_ENV['CFG_DATA']['db']['sc2']['sc2-user']['user'];
$sc2_pass = $_ENV['CFG_DATA']['db']['sc2']['sc2-user']['pass'];

$dbh = new \PDO('mysql:host=localhost;dbname=service-3_gg;charset=UTF8', 'service-3_mysql', '0X4l3U3q');
$dbh2 = new \PDO('mysql:host=localhost;dbname='.$sc2_dbname.';charset=UTF8', $sc2_login, $sc2_pass);


$siteOtec = 4779;

define('MOVE', isset($_GET['m']) ? $_GET['m'] : 0);
define('DEBUG', isset($_GET['r']) ? false : true);

$sites = $dbh->query("SELECT sites.id as 'id', LOWER(markas.name) as 'mName', markas.id as 'mID' FROM `sites` JOIN marka_to_sites ON sites.id = marka_to_sites.site_id JOIN markas ON marka_to_sites.marka_id = markas.id WHERE `setka_id` = 2 AND region_id = 0")->fetchAll();

function curDate() {
  return time();
}

function genFeed() {
  return rand(100000000,999999999);
}

if (MOVE == 0) {
  echo curDate().'<br>';
  echo genFeed();
  exit;
}

$insertUrls = "INSERT IGNORE INTO sc2.urls(id, site_id, name, params, `date`, feed) VALUES ";
$prefixType = 'remont-';

# выехали

if (MOVE == 1) { # Служебки (общие)
  #'rekvizity' => 'kontakty/rekvizity'
  $sl = ['zakaz' => 'zakaz', 'status' => 'status', 'ekspress-remont' => 'ekspress-remont', 'kontakty' => 'kontakty', 'sprosi' => 'sprosi', 'dostavka' => 'dostavka', 'politika' => 'politika', 'index' => '/'];
  $date = curDate();
  $sql = $insertUrls;
  $vals = [];
  foreach ($sl as $n=>$s) {
    $feed = genFeed();
    $params = serialize(['static' => $n]);
    $vals[] = "(NULL, $siteOtec, '$s', '$params', $date, $feed)";
  }
  $sql .= implode(',', $vals);
  if (DEBUG) {
    echo $sql;
  }
  else {
    $dbh2->query($sql);
    if ($dbh2->errorInfo()[0] == '00000') {
      echo 'ok';
    }
    else {
      echo $dbh2->errorInfo()[0];
    }
  }
}
else if (MOVE == 2) { # главная и служебные -brand
  $pages = ['diagnostika' => 'diagnostics', 'ceny-remonta' => 'price', 'servis' => '/'];
  $date = curDate();
  $sql = $insertUrls;
  $vals = [];
  foreach ($sites as $site) {
    foreach ($pages as $new=>$old) {
      $feed = genFeed();
      $params = serialize(['static' => $new, 'marka_id' => $site['mID']]);
      $vals[] = "(NULL, $siteOtec, '$new-{$site['mName']}', '$params', $date, $feed)";
    }
  }
  $sql .= implode(',', $vals);
  if (DEBUG) {
    echo count($vals).'<br><br>';
    echo $sql;
  }
  else {
    $dbh2->query($sql);
    if ($dbh2->errorInfo()[0] == '00000') {
      echo 'ok';
    }
    else {
      echo $dbh2->errorInfo()[0];
    }
  }
}
else if (MOVE == 3) { # хабы -brand
  $typesUrl = [
    'ноутбук' => 'noutbukov',
    'планшет' => 'planshetov',
    'телефон' => 'telefonov',
    'смартфон' => 'telefonov',
    'моноблок' => 'monoblokov',
    'компьютер' => 'kompyuterov',
    'фотоаппарат' => 'fotoapparatov',
    'принтер' => 'printerov',
    'мфу' => 'printerov',
    'сервер' => 'serverov',
    'телевизор' => 'televizorov',
    'видеокамера' => 'fotoapparatov',
  ];
  $typesBrandUrl = [
    'apple' => [
      'ноутбук' => 'macbook',
      'планшет' => 'ipad',
      'смартфон' => 'iphone',
      'моноблок' => 'imac',
    ],
    'sony' => [
      'игровая приставка' => 'playstation',
    ],
  ];

  $urls = array(
    "acer" => array('computers'),
    "apple" => array('computers'),
    "asus" => array('computers'),
    "canon" => array('foto','all-in-one','printers'),
    "dell" => array('desctops','computers'),
    "hp" => array('computers','desctops','printers','all-in-one'),
    "lenovo" => array('computers','desctops','servers'),
    "msi" => array('computers'),
    "nikon" => array('foto'),
    "samsung" => array('computers'),
    "sony" => array('computers','consoles','photo_video'),
    "xiaomi" => array('tv', 'laptop'),
    "nokia" => array('tablets'),
    'htc' => [],
    'huawei' => [],
    'lg' => [],
    'meizu' => [],
    'toshiba' => [],
  );

  $add_device_type = array(
      'computers' => array('type' => 'моноблок', 'type_rm' => 'моноблоков', 'type_m' => 'моноблоки'),
      'foto' => array('type' => 'фотоаппарат', 'type_rm' => 'фотоаппаратов', 'type_m' => 'фотоаппараты'),
      'all-in-one' => array('type' => 'мфу', 'type_rm' => 'МФУ', 'type_m' => 'МФУ'),
      'printers' => array('type' => 'принтер', 'type_rm' => 'принтеров', 'type_m' => 'принтеры'),
      'desctops' => array('type' => 'компьютер', 'type_rm' => 'компьютеров', 'type_m' => 'компьютеры'),
      'servers' => array('type' => 'сервер', 'type_rm' => 'серверов', 'type_m' => 'серверы'),
      'consoles' => array('type' => 'игровая приставка', 'type_rm' => 'приставок', 'type_m' => 'приставки'),
      'photo_video' => array('type' => 'видеокамера', 'type_rm' => 'камер', 'type_m' => 'камеры'),
      'tv' => array('type' => 'телевизор', 'type_rm' => 'телевизоров', 'type_m' => 'телевизоры'),
      'laptop' => array('type' => 'ноутбук', 'type_rm' => 'ноутбуков', 'type_m' => 'ноутбуки'),
      'tablets' => array('type' => 'планшет', 'type_rm' => 'планшетов', 'type_m' => 'планшеты'),
      'phones' => array('type' => 'смартфон'),
  );

  $brandTypesStmt = $dbh->query("SELECT DISTINCT LOWER(markas.name), LOWER(`model_types`.`name`) as `type` FROM `m_model_to_sites` INNER JOIN `m_models` ON `m_models`.`id` = `m_model_to_sites`.`m_model_id` INNER JOIN `model_types` ON `m_models`.`model_type_id` = `model_types`.`id` JOIN sites ON m_model_to_sites.site_id = sites.id JOIN marka_to_sites ON sites.id = marka_to_sites.site_id JOIN markas ON marka_to_sites.marka_id = markas.id WHERE sites.setka_id = 2 ORDER BY markas.name");

  $modelTypes = $dbh->query("SELECT id, LOWER(name) FROM model_types")->fetchAll();
  foreach ($modelTypes as $k=>$mt) {
    $modelTypes[$mt[1]] = $mt[0];
    unset($modelTypes[$k]);
  }

  $markasTypes = $dbh->query("SELECT id, LOWER(name) FROM markas")->fetchAll();
  foreach ($markasTypes as $k=>$mt) {
    $markasTypes[$mt[1]] = $mt[0];
    unset($markasTypes[$k]);
  }

  $brandTypes = [];

  foreach ($brandTypesStmt->fetchAll() as $bt) {
    $brandTypes[$bt[0]][] = $bt[1];
  }

  $date = curDate();
  $sql = $insertUrls;
  $vals = [];

  foreach ($sites as $site) {
    $brand = $site['mName'];
    $types = $urls[$brand];
    foreach ($types as $k=>$v) {
      $t = $add_device_type[$v]['type'];
      if ($t == 'мфу') $t = 'принтер';
      $types[$t] = $t;
      unset($types[$k]);
    }
    if (isset($brandTypes[$brand]))
      foreach ($brandTypes[$brand] as $k=>$v) {
        $types[$v] = $v;
      }
    foreach ($types as $type) {
      #if ($type != 'МФУ') {
        $feed = genFeed();
        $params = serialize(['marka_id' => $markasTypes[$brand], 'model_type_id' => $modelTypes[$type]]);
        $mts[] = [$markasTypes[$brand], $modelTypes[$type]];
        if (isset($typesBrandUrl[$brand][$type])) {
          $vals[] = "(NULL, $siteOtec, '{$prefixType}{$typesBrandUrl[$brand][$type]}', '$params', $date, $feed)";
          #echo $brand.' '.$prefixType.$typesBrandUrl[$brand][$type].'<br>';
        }
        else {
          $vals[] = "(NULL, $siteOtec, '{$prefixType}{$typesUrl[$type]}-{$brand}', '$params', $date, $feed)";
          #echo $brand.' '.$prefixType.$typesUrl[$type].'-'.$brand.'<br>';
        }
      #}
    }
    #echo '<br>';
  }
  $sql .= implode(',', $vals);
  if (DEBUG) {
    echo count($vals).'<br><br>';
    echo $sql;
  }
  else {
    $dbh2->query($sql);
    if ($dbh2->errorInfo()[0] == '00000') {
      echo 'ok';
    }
    else {
      echo $dbh2->errorInfo()[0];
    }
  }
}
else if (MOVE == 4 || MOVE == 5) {

  if (MOVE == 5) {
    if (isset($_GET['t']) && in_array($_GET['t'], [1,2,3])) {
      $typeID = $_GET['t'];
    }
    else {
      echo 'тип не указан';
      exit;
    }
  }

  $where = isset($typeID) ? 'model_types.id = '.$typeID : '1';

  $models = $dbh2->query("SELECT models.id, models.name, models.sublineyka as 'lineyka', LOWER(model_types.name) as 'type', LOWER(markas.name) as 'marka'
  FROM models
  JOIN m_models ON models.m_model_id = m_models.id
  JOIN model_types ON m_models.model_type_id  = model_types.id
  JOIN markas ON m_models.marka_id = markas.id WHERE $where")->fetchAll(PDO::FETCH_ASSOC);

  $services = [
    'планшет' => [
      ['id' => 1, 'url' => 'zamena-huyni'],
      ['id' => 2, 'url' => 'prikrutka-huyni']
    ],
  ];

  $typesUrl = [
    'ноутбук' => 'noutbukov',
    'планшет' => 'planshetov',
    'телефон' => 'telefonov',
    'смартфон' => 'telefonov',
    'моноблок' => 'monoblokov',
    'компьютер' => 'kompyuterov',
    'фотоаппарат' => 'fotoapparatov',
    'принтер' => 'printerov',
    'сервер' => 'serverov',
    'телевизор' => 'televizorov',
    'видеокамера' => 'fotoapparatov',
  ];

  $typesBrandUrl = [
    'apple' => [
      'ноутбук' => 'macbook',
      'планшет' => 'ipad',
      'смартфон' => 'iphone',
      'моноблок' => 'imac',
    ],
    'sony' => [
      'игровая приставка' => 'playstation',
    ],
  ];

  function clearBrandLin($model, $brand, $lin = false) {
    $lin = $lin !== false ? "|".$lin."[\s-]" : '';
    return preg_replace("/(".$brand."[\s-]".$lin.")/i", '', $model);
  }

  function translit($string) {
    return mb_strtolower(preg_replace('/(\s+)/', '-', $string));
  }

  $date = curDate();
  $sql = $insertUrls;
  $vals = [];
  foreach ($sites as $site) {
    $brand = $site['mName'];
    foreach ($models as $model) {
      if ($model['marka'] == $brand) {
        $modelName = translit(clearBrandLin($model['name'], $brand, isset($typesBrandUrl[$brand][$model['type']]) ? $typesBrandUrl[$brand][$model['type']] : false));
        $typeUrl = $prefixType.(isset($typesBrandUrl[$brand][$model['type']]) ? $typesBrandUrl[$brand][$model['type']] : $typesUrl[$model['type']].'-'.$brand);
        if (MOVE == 4) {
          $feed = genFeed();
          $params = serialize(['model_id' => $model['id']]);
          $vals[] = "(NULL, $siteOtec, '$typeUrl/$modelName', '$params', $date, $feed)";
        }
        else {
          foreach ($services[$model['type']] as $service) {
            $feed = genFeed();
            $params = serialize(['model_id' => $model['id'], 'service_id' => $service['id']]);
            $vals[] = "(NULL, $siteOtec, '$typeUrl/$modelName/{$service['url']}', '$params', $date, $feed)";
          }
        }
      }
    }
  }
  $sql .= implode(',', $vals);
  if (DEBUG) {
    echo count($vals).'<br><br>';
    if (MOVE != 5) echo $sql;
  }
  else {
    $dbh2->query($sql);
    if ($dbh2->errorInfo()[0] == '00000') {
      echo 'ok';
    }
    else {
      echo $dbh2->errorInfo()[0];
    }
  }
}

?>
