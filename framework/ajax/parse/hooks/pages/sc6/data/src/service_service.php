<?php

namespace framework\ajax\parse\hooks\pages\sc6\data\src;

use framework\pdo;
use framework\tools;

use framework\ajax\parse\hooks\pages\sc6\data\src\type_service;
use framework\ajax\parse\hooks\pages\sc6\data\src\helpers6;

class service_service
{

  const TYPES_TR_NAME = array(
        'ноутбук' => 'noutbuk',
        'планшет' => 'planshet',
        'смартфон' => 'telefon',
        'моноблок' => 'monoblok',
        'компьютер' => 'komputer',
        'сервер' => 'server',
        'телевизор' => 'televizor',
        'холодильник' => 'kholodilnik',
        'монитор' => 'monitor',
        'проектор' => 'proektor',
        'телефон' => 'telefon',
        'принтер' => 'printer',
        'электронная книга' => 'elektronnaya_kniga',
        'фотоаппарат' => 'fotoapparat', 
        'игровая приставка' => 'igrovaya_pristavka',
        'кофемашина' =>'kofemashina',
        
        'пылесос'=>'pylesos',
        'варочная панель'=> 'varochnaya_panel',
        'микроволновая печь'=> 'mikrovolnovaya_pech',
        'кондиционер'=> 'kondicioner',
        'робот-пылесос'=>'robot-pylesos',
        'домашний кинотеатр'=> 'domashnij_kinoteatr',
        'хлебопечка'=> 'hlebopechka',
        'морозильник'=>'morozilnik',
        'посудомоечная машина'=> 'posudomoechnaya_mashina',
        'духовой шкаф'=>'duhovoj_shkaf',
        'смарт-часы'=> 'smart-chasy',
        'вытяжка'=> 'vytyazhka',
        'видеокамера'=>'videokamera',
        'массажное кресло'=> 'massazhnoe_kreslo',
        'стиральная машина'=>'stiralnaya_mashina',
        'водонагреватель'=>'vodonagrevatel',
        'квадрокоптер'=>'kvadrokopter',
        'плоттер'=>'plotter',
        'гироскутер'=>'giroskuter',
        'электросамокат'=>'elektrosamokat',
        'моноколесо'=>'monokoleso',
        'сегвей' => 'segvej',
        'сушильная машина'=> 'sushilnaya_mashina',
        'лазерный принтер'=>'lazernyj_printer',
         'наушники'=>'naushniki',
        );

  const UC_NAMES = ['hdd' => 'HDD', 'ssd' => 'SSD', 'hdmi' => 'HDMI', 'озу' => 'ОЗУ', 'пзс' => 'ПЗС', 'bios' => 'BIOS', 'wi-fi' => 'Wi-Fi', 'flash' => 'FLASH', 'nfc' => 'NFC', 'sim' => 'SIM', 'эбу' => 'ЭБУ','ccd' => 'CCD', 'cmos' => 'CMOS', 'зу' => 'ЗУ', 'пзу' => 'ПЗУ'];

  public static function process($services, $nameRand = true) {
    foreach ($services as $k => $service) {
      $services[$k]['cost'] = ($services[$k]['minCost']+$services[$k]['maxCost'])/2;

      if ($services[$k]['minCost'] == 0)
        $services[$k]['cost'] = 'Бесплатно';
      else
        $services[$k]['cost'] += 50-($services[$k]['cost'] % 100)-1;

      $services[$k]['names'] = [$services[$k]['name']];
      foreach (explode('@', $services[$k]['syns']) as $name) {
        if (trim($name) != '') {
          if (preg_match_all('/[^\s]('.implode('|', array_keys(self::UC_NAMES)).')[\s$]/i', $name, $match)) {
            foreach ($match as $m) {
              #$name = str_replace($m[0], self::UC_NAMES[mb_strtolower($m[0])], $name);
            }
          }
          $services[$k]['names'][] = tools::mb_ucfirst($name, 'utf-8', false);
        }
      }
      if ($nameRand)
        $services[$k]['name'] = $services[$k]['names'][array_rand($services[$k]['names'])];

      $services[$k]['time'] = $services[$k]['time_repair'];
      unset($services[$k]['syns']);
    }
    return $services;
  }

  public static function ucNames($text) {
    $ucNames = self::UC_NAMES;
    if (preg_match_all('/('.implode('|', array_keys($ucNames)).')/iu', $text, $match)) {
      foreach ($match as $m) {
        if (isset($ucNames[mb_strtolower($m[0])]))
          $text = str_replace($m[0], $ucNames[mb_strtolower($m[0])], $text);
      }
    }
    return $text;
  }

  public static function getPopularForTypes($types, $srand = false) {
    if ($srand !== false)
      srand($srand);

    $dbh = pdo::getPdo();

    $stmt = $dbh->prepare("SELECT 6_services.id, 6_services.name, 6_services.minCost, 6_services.maxCost, 6_services.time_repair, 6_services.syns, 6_services.popular, model_types.name as 'type', 6_services.url, 6_services.urlWork FROM 6_services JOIN model_types ON 6_services.model_type_id = model_types.id WHERE model_types.id IN (".implode(',',$types).") AND popular = 1 ORDER BY urlWork DESC");
    $stmt->execute();

    $services = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    helpers6::shuffle($services);
    foreach ($services as $k=>$v) {
      if (!isset($services[$v['name']])) { // Убираем дубликаты
        $services[$v['name']] = $v;
      }
      unset($services[$k]);
    }
    $services = self::process($services);

    if ($srand !== false) {
      srand();
    }
    return $services;
  }

  public static function getForType($type, $srand = false) {
    if ($srand !== false)
      srand($srand+strlen($type));

    $dbh = pdo::getPdo();

    $stmt = $dbh->prepare("SELECT 6_services.id, 6_services.name, 6_services.minCost, 6_services.maxCost, 6_services.time_repair, 6_services.syns, 6_services.popular, model_types.name as 'type', 6_services.url, 6_services.urlWork FROM 6_services JOIN model_types ON 6_services.model_type_id = model_types.id WHERE model_types.name = ? ORDER BY urlWork DESC");
    $stmt->execute([$type]);

    $services = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    $services = self::process($services);

    if ($srand !== false) {
      $one = $two = [];
      foreach ($services as $s) {
        if ($s['urlWork'] == 1)
          $one[] = $s;
        else
          $two[] = $s;
      }
      helpers6::shuffle($one);
      helpers6::shuffle($two);
      $services = array_merge($one, $two);
      srand();
    }

    return $services;
  }

  public static function getForId($id, $nameRand = true) {
    $dbh = pdo::getPdo();

    $stmt = $dbh->prepare("SELECT 6_services.id, 6_services.name, 6_services.minCost, 6_services.maxCost, 6_services.time_repair, 6_services.title, 6_services.h1, 6_services.description, 6_services.plain, 6_services.syns, 6_services.popular, model_types.id as 'type_id', model_types.name as 'type' FROM 6_services JOIN model_types ON 6_services.model_type_id = model_types.id WHERE 6_services.id = ?");
    $stmt->execute([$id]);

    $services = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    $service = self::process($services, $nameRand)[0];

    return $service;
  }

  public static function selectPopular($services, $srand, $count = 5) {
    srand($srand);

    $res = [];

    $popular = $notPopular = [];
    foreach ($services as $service) {
      if ($service['popular'] === 1) {
        $popular[] = $service;
      }
      else if (is_numeric($service['cost']) && $service['cost'] > 0) {
        $notPopular[] = $service;
      }
    }

    if (count($popular) < $count) {
      $add = $count-count($popular);
      for ($i = 1; $i <= $add; $i++) {
        if (count($notPopular)) {
          $ind = array_rand($notPopular);
          $popular[] = $notPopular[$ind];
          unset($notPopular[$ind]);
        }
      }
    }

    srand();
    return $popular;
  }

  public static function minTimeRepair($types) {
    $dbh = pdo::getPdo();

    $stmt = $dbh->prepare("SELECT MIN(time_repair) FROM 6_services WHERE model_type_id IN (".implode(',',$types).")");
    $stmt->execute();

    if ($stmt->rowCount() == 0)
      return false;
    else
      return $stmt->fetch()[0];
  }

  public static function groups($services) {
    $groups = [
      0 => [],
      'Замена и ремонт' => [],
      'Другие' => [],
    ];
    foreach ($services as $service) {
      if ($service['minCost'] == 0) {
        $groups[0][] = $service;
      }
      else if (preg_match('/^(Замена|Ремонт)\s?(.+)$/', $service['name'], $match)) {
        $service['name'] = tools::mb_ucfirst($match[2], 'utf-8', false);
        $groups['Замена и ремонт'][] = $service;
      }
      else {
        $groups['Другие'][] = $service;
      }
    }

    return $groups;
  }

  public static function changeCost($services, $srand) {
      foreach ($services as $k=>$v) {
        if (is_numeric($v['cost'])) {
          srand($srand + $k);
          $deltaA = floor($v['cost']*0.35/50) > 5 ? 5 : floor($v['cost']*0.35/50);
          $services[$k]['cost'] = $v['cost']+(rand(0, $deltaA*2)-$deltaA)*50;
        }
      }
      srand();
      return $services;
  }

  public static function fullUrl($type, $url) {
    $typesUrl = type_service::TYPES_URL;
    return '/'.$typesUrl[$type].'/'.$url.'/';
  }

  public static function renderFullUrl($type, $name) {
    $typesUrl = type_service::TYPES_URL;
    if (preg_match('/(\/\S+)(\s|$)/', $name, $match))
      $name = str_replace($match[1], '', $name);
    if (isset($typesUrl[$type])) {
      return '/'.$typesUrl[$type].'/'.helpers6::translit(preg_replace('/(\(|\))/', '', mb_strtolower(preg_replace("/\s+/", "_", $name))));
    }
    else
      return helpers6::translit(preg_replace('/(\(|\))/', '', mb_strtolower(preg_replace("/\s+/", "_", $name))));
  }

   public static function strReplace( &$str , $feed  ) {
        $t_str = '';
        $cb_open = strpos($str, '{');
        $cb_close = strpos($str, '}');

        if ( $cb_open !== false ) {
            $variant = substr($str, $cb_open + 1, $cb_close - $cb_open - 1);
            $variant_arr = explode('|', $variant);

            srand( $feed );
            $random = rand(0, count($variant_arr) - 1);

            $t_str = substr_replace( $str, trim( $variant_arr[$random] ), $cb_open, $cb_close - $cb_open + 1);
            $str = self::strReplace( $t_str, $feed );
        }

        return $str;
   }

}




?>
