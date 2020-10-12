<?php
$sc3_dbname = $_ENV['CFG_DATA']['db']['sc3']['db_name'];
$sc3_login = $_ENV['CFG_DATA']['db']['sc3']['sc3-user']['user'];
$sc3_pass = $_ENV['CFG_DATA']['db']['sc3']['sc3-user']['pass'];

$dbh2 = new \PDO('mysql:host=localhost;dbname='.$sc3_dbname.';charset=UTF8', $sc3_login, $sc3_pass);
$dbh = new \PDO('mysql:host=localhost;dbname=service-3_gg;charset=UTF8', 'service-3_mysql', '0X4l3U3q');

$siteOtec = 4780;
$regionID = 0;

define('MOVE', isset($_GET['m']) ? $_GET['m'] : 0);
define('DEBUG', isset($_GET['r']) ? false : true);

$sites = $dbh->query("SELECT sites.id as 'id', LOWER(markas.name) as 'mName', markas.id as 'mID' FROM `sites` JOIN marka_to_sites ON sites.id = marka_to_sites.site_id JOIN markas ON marka_to_sites.marka_id = markas.id WHERE `setka_id` = 3 AND region_id = 0")->fetchAll();

function curDate() {
  return time();
}

function genFeed() {
  return rand(100000000,999999999);
}

if (MOVE == 0) {
  echo curDate().'<br>';
  echo genFeed().'<br>';
  #echo serialize(['sitemap' => ['type' => 'type', 'type_id' => '1']]);
  echo serialize(['sitemap' => 'general']);
  exit;
}

$insertUrls = "INSERT IGNORE INTO sc3.urls(id, site_id, name, params, `date`, feed) VALUES ";
$prefixType = 'remont_';
$prefixType2 = 'zapchasti_dlya_';

# выехали

if (MOVE == 1) { # Служебки (общие)
  $sl = ['o_nas' => 'o_nas', 'kontakty' => 'kontakty', 'dostavka' => 'dostavka', 'vakansii' => 'vakansii', 'indexSite' => '/'];
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
  $pages = ['diagnostika_{brand}' => 'diagnostika', 'zapchasti_{brand}' => 'komplektuyushie', 'neispravnosti_{brand}' => 'neispravnosti', '{brand}/ceny' => 'ceny', '{brand}' => 'index'];
  $date = curDate();
  $sql = $insertUrls;
  $vals = [];
  foreach ($sites as $site) {
    foreach ($pages as $new=>$old) {
      $feed = genFeed();
      $params = serialize(['static' => $old, 'marka_id' => $site['mID']]);
      $newUrl = str_replace('{brand}', $site['mName'], $new);
      $vals[] = "(NULL, $siteOtec, '$newUrl', '$params', $date, $feed)";
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
else if (MOVE == 3 || MOVE == 31 || MOVE == 32 || MOVE == 33) { # хабы -brand
  $typesUrl = [
    'ноутбук' => 'noutbukov',
    'планшет' => 'planshetov',
    'телефон' => 'telefonov',
    'смартфон' => 'telefonov',
  ];

  $brandTypesStmt = $dbh->query("SELECT LOWER(markas.name), `model_types`.`name` as `type` FROM `m_models` INNER JOIN `model_types` ON `m_models`.`model_type_id` = `model_types`.`id` JOIN markas ON m_models.marka_id = markas.id GROUP BY markas.id, model_types.id");

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

  $services = ['ноутбук' => [], 'планшет' => [], 'смартфон' => []];

  $servicesArr = $dbh2->query("SELECT model_types.name as 'type', services.id as 'id', services.url as 'url' FROM services JOIN model_types ON services.model_type_id = model_types.id")->fetchAll(\PDO::FETCH_ASSOC);

  foreach ($servicesArr as $k=>$v) {
    $type = $v['type'];
    unset($v['type']);
    $services[$type][] = $v;
  }

  $complects = ['ноутбук' => [], 'планшет' => [], 'смартфон' => []];

  $complectsArr = $dbh2->query("SELECT model_types.name as 'type', complects.id as 'id', complects.url as 'url' FROM complects JOIN model_types ON complects.model_type_id = model_types.id")->fetchAll(\PDO::FETCH_ASSOC);

  foreach ($complectsArr as $k=>$v) {
    $type = $v['type'];
    unset($v['type']);
    $complects[$type][] = $v;
  }

  $defects = ['ноутбук' => [], 'планшет' => [], 'смартфон' => []];

  $defectsArr = $dbh2->query("SELECT model_types.name as 'type', defects.id as 'id', defects.url as 'url' FROM defects JOIN model_types ON defects.model_type_id = model_types.id")->fetchAll(\PDO::FETCH_ASSOC);

  foreach ($defectsArr as $k=>$v) {
    $type = $v['type'];
    unset($v['type']);
    $defects[$type][] = $v;
  }

  $date = curDate();
  $sql = $insertUrls;
  $vals = [];

  foreach ($brandTypes as $brand=>$types) {
    foreach ($types as $type) {
      #$mts[] = [$markasTypes[$brand], $modelTypes[$type]];

      if (MOVE == 3) {
        $feed = genFeed();
        $params = serialize(['marka_id' => $markasTypes[$brand], 'model_type_id' => $modelTypes[$type]]);
        $vals[] = "(NULL, $siteOtec, '{$prefixType}{$typesUrl[$type]}_{$brand}', '$params', $date, $feed)";
      }
      else if (MOVE == 31) {
        foreach ($services[$type] as $service) {
          $feed = genFeed();
          $params = serialize(['marka_id' =>  $markasTypes[$brand], 'service_id' => $service['id']]);
          $vals[] = "(NULL, $siteOtec, '{$prefixType}{$typesUrl[$type]}_{$brand}/{$service['url']}', '$params', $date, $feed)";
        }
      }
      else if (MOVE == 32) {
        foreach ($complects[$type] as $complect) {
          $feed = genFeed();
          $params = serialize(['marka_id' =>  $markasTypes[$brand], 'complect_id' => $complect['id']]);
          $vals[] = "(NULL, $siteOtec, '{$prefixType2}{$typesUrl[$type]}_{$brand}/{$complect['url']}', '$params', $date, $feed)";
        }
      }
      else if (MOVE == 33) {
        foreach ($defects[$type] as $defect) {
          $feed = genFeed();
          $params = serialize(['marka_id' =>  $markasTypes[$brand], 'defect_id' => $defect['id']]);
          $vals[] = "(NULL, $siteOtec, '{$prefixType}{$typesUrl[$type]}_{$brand}/{$defect['url']}', '$params', $date, $feed)";
        }
      }
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
else if (MOVE == 4 || MOVE == 41 || MOVE == 42) {

  $typesUrl = [
    'ноутбук' => 'noutbukov',
    'планшет' => 'planshetov',
    'телефон' => 'telefonov',
    'смартфон' => 'telefonov',
  ];

  $mmodels = $dbh2->query("SELECT m_models.name, m_models.id, model_types.name as 'type', LOWER(markas.name) as 'marka' FROM m_models JOIN model_types ON m_models.model_type_id = model_types.id JOIN markas ON m_models.marka_id = markas.id WHERE frequency > 0")->fetchAll(\PDO::FETCH_ASSOC);

  function translit($string) {
    return mb_strtolower(preg_replace('/(\s+|\.)/', '_', $string));
  }

  $services = ['ноутбук' => [], 'планшет' => [], 'смартфон' => []];

  $servicesArr = $dbh2->query("SELECT model_types.name as 'type', services.id as 'id', services.url as 'url' FROM services JOIN model_types ON services.model_type_id = model_types.id")->fetchAll(\PDO::FETCH_ASSOC);

  foreach ($servicesArr as $k=>$v) {
    $type = $v['type'];
    unset($v['type']);
    $services[$type][] = $v;
  }

  $complects = ['ноутбук' => [], 'планшет' => [], 'смартфон' => []];

  $complectsArr = $dbh2->query("SELECT model_types.name as 'type', complects.id as 'id', complects.url as 'url' FROM complects JOIN model_types ON complects.model_type_id = model_types.id")->fetchAll(\PDO::FETCH_ASSOC);

  foreach ($complectsArr as $k=>$v) {
    $type = $v['type'];
    unset($v['type']);
    $complects[$type][] = $v;
  }

  $date = curDate();
  $sql = $insertUrls;
  $vals = [];

  foreach ($mmodels as $mm) {
    $mmUrl = translit($mm['name']);
    $typeUrl = (MOVE == 42 ? $prefixType2 : $prefixType).$typesUrl[$mm['type']].'_'.$mm['marka'];

    if (MOVE == 4) {
      $feed = genFeed();
      $params = serialize(['m_model_id' => $mm['id']]);
      $vals[] = "(NULL, $siteOtec, '$typeUrl/$mmUrl', '$params', $date, $feed)";
    }
    else if (MOVE == 41) {
      foreach ($services[$mm['type']] as $service) {
        $feed = genFeed();
        $params = serialize(['m_model_id' => $mm['id'], 'service_id' => $service['id']]);
        $vals[] = "(NULL, $siteOtec, '$typeUrl/$mmUrl/{$service['url']}', '$params', $date, $feed)";
      }
    }
    else if (MOVE == 42) {
      foreach ($complects[$mm['type']] as $complect) {
        $feed = genFeed();
        $params = serialize(['m_model_id' => $mm['id'], 'complect_id' => $complect['id']]);
        $vals[] = "(NULL, $siteOtec, '$typeUrl/$mmUrl/{$complect['url']}', '$params', $date, $feed)";
      }
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
else if (MOVE == 5 || MOVE == 51 || MOVE == 52 || MOVE == 53) {

  if (MOVE != 5) {
    if (isset($_GET['t']) && in_array($_GET['t'], [1,2,3])) {
      $typeID = $_GET['t'];
    }
    else {
      echo 'тип не указан';
      exit;
    }
  }

  $where = isset($typeID) ? 'model_types.id = '.$typeID : '1';

  $models = $dbh2->query("SELECT models.id, models.name, LOWER(model_types.name) as 'type', LOWER(markas.name) as 'marka'
  FROM models
  JOIN m_models ON models.m_model_id = m_models.id
  JOIN model_types ON m_models.model_type_id  = model_types.id
  JOIN markas ON m_models.marka_id = markas.id WHERE $where")->fetchAll(PDO::FETCH_ASSOC);

  $services = ['ноутбук' => [], 'планшет' => [], 'смартфон' => []];

  $servicesArr = $dbh2->query("SELECT model_types.name as 'type', services.id as 'id', services.url as 'url' FROM services JOIN model_types ON services.model_type_id = model_types.id")->fetchAll(\PDO::FETCH_ASSOC);

  foreach ($servicesArr as $k=>$v) {
    $type = $v['type'];
    unset($v['type']);
    $services[$type][] = $v;
  }

  $complects = ['ноутбук' => [], 'планшет' => [], 'смартфон' => []];

  $complectsArr = $dbh2->query("SELECT model_types.name as 'type', complects.id as 'id', complects.url as 'url' FROM complects JOIN model_types ON complects.model_type_id = model_types.id")->fetchAll(\PDO::FETCH_ASSOC);

  foreach ($complectsArr as $k=>$v) {
    $type = $v['type'];
    unset($v['type']);
    $complects[$type][] = $v;
  }

  $defects = ['ноутбук' => [], 'планшет' => [], 'смартфон' => []];

  $defectsArr = $dbh2->query("SELECT model_types.name as 'type', defects.id as 'id', defects.url as 'url' FROM defects JOIN model_types ON defects.model_type_id = model_types.id")->fetchAll(\PDO::FETCH_ASSOC);

  foreach ($defectsArr as $k=>$v) {
    $type = $v['type'];
    unset($v['type']);
    $defects[$type][] = $v;
  }

  $typesUrl = [
    'ноутбук' => 'noutbukov',
    'планшет' => 'planshetov',
    'телефон' => 'telefonov',
    'смартфон' => 'telefonov',
  ];

  function clearBrandLin($model, $brand, $lin = false) {
    $lin = $lin !== false ? "|".$lin."[\s-]" : '';
    return preg_replace("/(".$brand."[\s-]".$lin.")/i", '', $model);
  }

  function translit($string) {
    return mb_strtolower(preg_replace('/(\s+|\.)/', '_', $string));
  }

  $date = curDate();
  $sql = $insertUrls;
  $vals = [];
  #foreach ($sites as $site) {
    foreach ($models as $model) {
      $brand = $model['marka'];
      #if ($model['marka'] == $brand) {
        $modelName = translit(clearBrandLin($model['name'], $brand));
        $typeUrl = (MOVE == 52 ? $prefixType2 : $prefixType).$typesUrl[$model['type']].'_'.$brand;
        if (MOVE == 5) {
          $feed = genFeed();
          $params = serialize(['model_id' => $model['id']]);
          $vals[] = "(NULL, $siteOtec, '$typeUrl/$modelName', '$params', $date, $feed)";
        }
        else if (MOVE == 51) {
          foreach ($services[$model['type']] as $service) {
            $feed = genFeed();
            $params = serialize(['model_id' => $model['id'], 'service_id' => $service['id']]);
            $vals[] = "(NULL, $siteOtec, '$typeUrl/$modelName/{$service['url']}', '$params', $date, $feed)";
          }
        }
        else if (MOVE == 52) {
          foreach ($complects[$model['type']] as $complect) {
            $feed = genFeed();
            $params = serialize(['model_id' => $model['id'], 'complect_id' => $complect['id']]);
            $vals[] = "(NULL, $siteOtec, '$typeUrl/$modelName/{$complect['url']}', '$params', $date, $feed)";
          }
        }
        else if (MOVE == 53) {
          foreach ($defects[$model['type']] as $defect) {
            $feed = genFeed();
            $params = serialize(['model_id' => $model['id'], 'defect_id' => $defect['id']]);
            $vals[] = "(NULL, $siteOtec, '$typeUrl/$modelName/{$defect['url']}', '$params', $date, $feed)";
          }
        }
      #}
    }
  #}
  if (DEBUG) {
    echo count($vals).'<br><br>';
    if (MOVE == 5) echo $sql.implode(',', $vals);
    else echo $vals[0];
  }
  else {
    for ($i=1; $i<=ceil(count($vals)/100000); $i++) {
      $sql1 = $sql.implode(',', array_slice($vals, 100000*($i-1), 100000));
      $dbh2->query($sql1);
      if ($dbh2->errorInfo()[0] == '00000') {
        echo 'ok<br>';
      }
      else {
        echo $dbh2->errorInfo()[0];
      }
    }
  }
}
else if (MOVE == 6 || MOVE == 61 || MOVE == 62) {
  $typesUrl = [
    'ноутбук' => [1, 'noutbukov'],
    'планшет' => [2, 'planshetov'],
    'смартфон' => [3, 'telefonov'],
  ];

  $geo = $dbh2->query("SELECT * FROM geo WHERE city_id = $regionID")->fetchAll(\PDO::FETCH_ASSOC);

  $models = $dbh2->query("SELECT models.id, models.name, LOWER(model_types.name) as 'type', LOWER(markas.name) as 'marka'
  FROM models
  JOIN m_models ON models.m_model_id = m_models.id
  JOIN model_types ON m_models.model_type_id  = model_types.id
  JOIN markas ON m_models.marka_id = markas.id")->fetchAll(PDO::FETCH_ASSOC);

  $mmodels = $dbh2->query("SELECT m_models.name, m_models.id, model_types.name as 'type', LOWER(markas.name) as 'marka' FROM m_models JOIN model_types ON m_models.model_type_id = model_types.id JOIN markas ON m_models.marka_id = markas.id")->fetchAll(\PDO::FETCH_ASSOC);

  $brandTypesStmt = $dbh->query("SELECT LOWER(markas.name), `model_types`.`name` as `type` FROM `m_models` INNER JOIN `model_types` ON `m_models`.`model_type_id` = `model_types`.`id` JOIN markas ON m_models.marka_id = markas.id GROUP BY markas.id, model_types.id");

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

  function clearBrandLin($model, $brand, $lin = false) {
    $lin = $lin !== false ? "|".$lin."[\s-]" : '';
    return preg_replace("/(".$brand."[\s-]".$lin.")/i", '', $model);
  }

  function translit($string) {
    $converter = array(
        'а' => 'a',   'б' => 'b',   'в' => 'v',
        'г' => 'g',   'д' => 'd',   'е' => 'e',
        'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
        'и' => 'i',   'й' => 'y',   'к' => 'k',
        'л' => 'l',   'м' => 'm',   'н' => 'n',
        'о' => 'o',   'п' => 'p',   'р' => 'r',
        'с' => 's',   'т' => 't',   'у' => 'u',
        'ф' => 'f',   'х' => 'h',   'ц' => 'c',
        'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
        'ь' => '',  'ы' => 'y',   'ъ' => '',
        'э' => 'e',   'ю' => 'yu',  'я' => 'ya',

        'А' => 'A',   'Б' => 'B',   'В' => 'V',
        'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
        'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
        'И' => 'I',   'Й' => 'Y',   'К' => 'K',
        'Л' => 'L',   'М' => 'M',   'Н' => 'N',
        'О' => 'O',   'П' => 'P',   'Р' => 'R',
        'С' => 'S',   'Т' => 'T',   'У' => 'U',
        'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
        'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
        'Ь' => '',  'Ы' => 'Y',   'Ъ' => '',
        'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
    );
    return mb_strtolower(preg_replace('/(\s+|\.)/', '_', strtr($string, $converter)));
  }

  $date = curDate();
  $sql = $insertUrls;
  $vals = [];



  foreach ($geo as $g) {
    $gUrl = translit($g['name']);
    if (MOVE == 6) {
      foreach ($typesUrl as $type) {
        $feed = genFeed();
        $params = serialize(['model_type_id' => $type[0], 'geo_id' => $g['id']]);
        $vals[] = "(NULL, $siteOtec, '{$prefixType}{$type[1]}/{$gUrl}', '$params', $date, $feed)";
      }
    }
    else if (MOVE == 61) {
      foreach ($brandTypes as $brand=>$types) {
        foreach ($types as $type) {
          $feed = genFeed();
          $params = serialize(['model_type_id' => $modelTypes[$type], 'marka_id' => $markasTypes[$brand], 'geo_id' => $g['id']]);
          $vals[] = "(NULL, $siteOtec, '{$prefixType}{$typesUrl[$type][1]}_{$brand}/{$gUrl}', '$params', $date, $feed)";
        }
      }
    }
    else if (MOVE == 62) {
      foreach ($mmodels as $mm) {
        $feed = genFeed();
        $urlMM = translit($mm['name']);
        $params = serialize(['m_model_id' => $modelTypes[$mm['type']], 'geo_id' => $g['id']]);
        $vals[] = "(NULL, $siteOtec, '{$prefixType}{$typesUrl[$mm['type']][1]}_{$mm['marka']}/{$urlMM}/{$gUrl}', '$params', $date, $feed)";
      }
    }
  }

  if (DEBUG) {
    echo count($vals).'<br><br>';
    if (MOVE == 6 || MOVE == 61) echo $sql.implode(',', $vals);
    else echo $vals[0];
  }
  else {
    for ($i=1; $i<=ceil(count($vals)/100000); $i++) {
      $sql1 = $sql.implode(',', array_slice($vals, 100000*($i-1), 100000));
      $dbh2->query($sql1);
      if ($dbh2->errorInfo()[0] == '00000') {
        echo 'ok<br>';
      }
      else {
        echo $dbh2->errorInfo()[0];
      }
    }
  }
}

?>
