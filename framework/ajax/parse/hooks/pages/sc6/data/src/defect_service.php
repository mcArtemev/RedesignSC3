<?php

namespace framework\ajax\parse\hooks\pages\sc6\data\src;

use framework\pdo;
use framework\tools;

use framework\ajax\parse\hooks\pages\sc6\data\src\helpers6;

class defect_service
{

  public static function process($defects, $nameRand = true) {
    foreach ($defects as $k => $defect) {
      $defects[$k]['names'] = [$defect['name']];
      foreach (explode('@', $defect['syns']) as $name) {
        if (trim($name) != '') {
          $services[$k]['names'][] = tools::mb_ucfirst($name, 'utf-8', false);
        }
      }
      if ($nameRand)
        $defects[$k]['name'] = $defects[$k]['names'][array_rand($defects[$k]['names'])];

      unset($defects[$k]['syns']);
    }
    return $defects;
  }

  public static function getForType($type, $srand = false) {
    if ($srand !== false)
      srand($srand+strlen($type));

    $dbh = pdo::getPdo();

    $stmt = $dbh->prepare("SELECT 6_defects.id, 6_defects.name, 6_defects.syns, model_types.name as 'type', 6_defects.url FROM 6_defects JOIN model_types ON 6_defects.model_type_id = model_types.id WHERE model_types.name = ?");
    $stmt->execute([$type]);

    $defects = self::process($stmt->fetchAll(\PDO::FETCH_ASSOC));


    if ($srand !== false) {
      helpers6::shuffle($defects);
      srand();
    }

    return $defects;
  }

  public static function getForId($id, $nameRand = true) {
    $dbh = pdo::getPdo();

    $stmt = $dbh->prepare("SELECT 6_defects.id, 6_defects.name, 6_defects.title, 6_defects.h1, 6_defects.description, 6_defects.syns, model_types.id as 'type_id', model_types.name as 'type' FROM 6_defects JOIN model_types ON 6_defects.model_type_id = model_types.id WHERE 6_defects.id = ?");
    $stmt->execute([$id]);

    $defects = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    $defect = self::process($defects, $nameRand)[0];

    return $defect;
  }

  public static function fullUrl($type, $url) {
    $typesUrl = type_service::TYPES_URL;
    return '/'.$typesUrl[$type].'/'.$url.'/';
  }

}


?>
