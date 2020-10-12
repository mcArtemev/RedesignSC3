<?php

namespace framework\ajax\parse\hooks\pages\sc6\data\src;

use framework\pdo;
use framework\ajax\parse\hooks\pages\sc6\data\src\exclude_models;

class model_service
{

  const START_COUNT = [
    68 => [
      2 => 1,
      1 => 6,
    ],
    69 => [
      1 => 5,
      2 => 6,
      3 => 12,
    ],
    34 => [
      2 => 44,
      3 => 29,
    ],
    35 => [
      3 => 3,
    ],
    36 => [
      3 => 30,
    ],
    37 => [
      2 => 33,
    ],
    38 => [
      2 => 15,
      3 => 38,
      1 => 7,
    ],
    39 => [
      2 => 54,
      3 => 29,
      1 => 1,
    ],
    40 => [
      1 => 1,
    ],
    41 => [
      3 => 86,
      2 => 33,
    ],
    42 => [
      2 => 6,
      1 => 24,
    ],
    43 => [
      2 => 19,
      3 => 44,
    ],
    44 => [
      2 => 3,
      3 => 15,
      1 => 1,
    ],
    45 => [
      3 => 37,
    ],
    46 => [
      2 => 9,
      3 => 2,
    ],
    47 => [
      2 => 110,
      3 => 29,
      1 => 2,
    ],
    48 => [
      3 => 48,
    ],
    49 => [
      3 => 11,
    ],
    50 => [
      3 => 12,
    ],
    52 => [
      3 => 89,
    ],
    53 => [
      3 => 41,
    ],
    54 => [
      2 => 1,
    ],
    56 => [
      2 => 9,
      3 => 19,
    ],
    57 => [
      1 => 19,
    ],
    58 => [
      2 => 25,
      3 => 37,
      1 => 8,
    ],
    59 => [
      2 => 16,
      3 => 14,
    ],
    60 => [
      2 => 31,
      3 => 1,
    ],
    61 => [
      2 => 53,
      3 => 41,
    ],
    62 => [
      3 => 25,
    ],
    65 => [
      3 => 9,
    ],
    64 => [
      2 => 23,
      3 => 1,
    ],
    4 => [
      1 => 114,
      2 => 41,
      3 => 19,
    ],
    21 => [
      1 => 10,
      2 => 10,
      3 => 15,
    ],
    3 => [
      1 => 222,
      2 => 46,
      3 => 27,
    ],
    16 => [
      2 => 4,
      3 => 45,
    ],
    6 => [
      1 => 51,
    ],
    10 => [
      3 => 38,
    ],
    17 => [
      3 => 53,
      2 => 23,
    ],
    5 => [
      1 => 55,
      3 => 101,
      2 => 34,
    ],
    20 => [
      3 => 31,
    ],
    8 => [
      1 => 40,
    ],
    11 => [
      3 => 42,
      2 => 3,
    ],
    1 => [
      1 => 15,
      3 => 33,
      2 => 7,
    ],
    7 => [
      1 => 4,
      2 => 4,
    ],
    18 => [
      1 => 2,
      3 => 47,
    ],
    9 => [
      1 => 71,
    ],
    66 => [
      3 => 39,
    ],
    12 => [
      3 => 19,
    ],

  ];

  public static function getForTypeMark($type, $mark, $site_id) {

    $dbh = pdo::getPdo();

    $stmt = $dbh->prepare("SELECT models2.id as 'id', models2.name as 'name', model_types.name as 'type' FROM models2_to_setka
    JOIN models2 ON models2_to_setka.id_model = models2.id
    JOIN model_type_to_markas ON models2.model_type_mark = model_type_to_markas.id
    JOIN model_types ON model_type_to_markas.model_type_id = model_types.id
    JOIN marka_to_sites ON model_type_to_markas.marka_id = marka_to_sites.marka_id
    JOIN sites ON marka_to_sites.site_id = sites.id
    WHERE models2_to_setka.id_setka = 6 AND models2_to_setka.active = 1 AND sites.setka_id = 6 AND model_type_to_markas.model_type_id = ? AND model_type_to_markas.marka_id = ? AND marka_to_sites.site_id = ?
    ORDER BY models2.id");

    $stmt->execute([$type,$mark,$site_id]);
    
    $exclude_models = exclude_models::getExcludeModels();

    if ($stmt !== false && $dbh->errorInfo()[0] == '00000') {
      $startDate = 2018+2;
      $startPercent = 0.7;
      $stepPercent = 0.1;
      $percent = $startPercent + (date('Y')+date('n')-$startDate)*$stepPercent;
      $models = $stmt->fetchAll();
      
      foreach ($models as $key => $model)
        if (in_array($model['name'], $exclude_models)) unset($models[$key]);
      
      $startCount = self::START_COUNT;
      $count = isset($startCount[$mark][$type]) ? ceil($startCount[$mark][$type]*$percent) : count($models);
      return array_slice($models, 0, $count);
    }
    else {
      return [];
    }

  }

  public static function renderUrl($name) {
    return mb_strtolower(preg_replace("/\s+/", "_", $name));
  }

  public static function getForId($id) {
    $dbh = pdo::getPdo();
    $stmt = $dbh->prepare("SELECT id, name, name_ru FROM models2 WHERE id = ?");
    $stmt->execute([$id]);

    return $stmt->fetch();
  }
  public static function GetModelsList($type_id, $brand_id) {
        $dbh = pdo::getPdo();
        $modelsList = $dbh->prepare('SELECT * FROM `models_list` WHERE `model_type_id`=? AND `marka_id`=?');
        $modelsList->execute([$type_id,$brand_id]);
        return $modelsList->fetchAll();
      
  }


}

?>
