<?php
$sc2_dbname = $_ENV['CFG_DATA']['db']['sc2']['db_name'];
$sc2_login = $_ENV['CFG_DATA']['db']['sc2']['sc2-user']['user'];
$sc2_pass = $_ENV['CFG_DATA']['db']['sc2']['sc2-user']['pass'];

$dbh = new \PDO('mysql:host=localhost;dbname=service-3_gg;charset=UTF8', 'service-3_mysql', '0X4l3U3q');
$dbh2 = new \PDO('mysql:host=localhost;dbname='.$sc2_dbname.';charset=UTF8', $sc2_login, $sc2_pass);


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
    'телефон' => 'iphone',
    'моноблок' => 'imac',
  ],
  'sony' => [
    'игровая приставка' => 'playstation',
  ],
];

$hub = [
  'laptop' => 'ноутбук',
  'tablets' => 'планшет',
  'phones' => 'телефон',
  'computers' => 'моноблок',
  'desctops' => 'компьютер',
  'foto' => 'фотоаппарат',
  'printers' => 'принтер',
  'all-in-one' => 'принтер',
  'servers' => 'сервер',
  'tv' => 'телевизор',
  'photo_video' => 'видеокамера',
];



// $sites = $dbh->query("SELECT id FROM sites WHERE setka_id = 2 AND region_id = 0")->fetchAll(\PDO::FETCH_COLUMN);
//
// $modelsAll = $dbh2->query("SELECT models.id, models.name, models.sublineyka as 'lin', markas.name as 'marka', model_types.name as 'type', model_types.id as 'typeId' FROM models JOIN m_models ON models.m_model_id = m_models.id JOIN markas ON m_models.marka_id = markas.id JOIN model_types ON m_models.model_type_id = model_types.id")->fetchAll(\PDO::FETCH_ASSOC);
//
// $models = [];
// foreach ($modelsAll as $k=>$v) {
//   $models[$v['type'].'_'.$v['id']] = [strtolower($v['marka']), urlModel($v['name'], strtolower($v['marka']), $v['type'])];
// }
//
// $oldModelsAll = $dbh->query("SELECT models.id, models.name, models.sublineyka as 'lin', markas.name as 'marka', model_types.name as 'type' FROM models JOIN m_models ON models.m_model_id = m_models.id JOIN markas ON m_models.marka_id = markas.id JOIN model_types ON m_models.model_type_id = model_types.id")->fetchAll(\PDO::FETCH_ASSOC);
//
// $oldModels = [];
// foreach ($oldModelsAll as $k=>$v) {
//   $oldModels[$v['id']] = $v['type'];
// }
//
//  function translit($string) {
//   return mb_strtolower(preg_replace('/(\s+|\.)/', '-', $string));
// }
//
// function urlModel($name, $brand, $type) {
//   global $typesBrandUrl;
//   $brand = mb_strtolower($brand);
//   return translit(clearBrandLin($name, $brand, isset($typesBrandUrl[$brand][$type]) ? $typesBrandUrl[$brand][$type] : false));
// }
//
// function clearBrandLin($model, $brand, $lin = false) {
//   $lin = $lin !== false ? "|".$lin."[\s-]" : '';
//   return preg_replace("/(".$brand."[\s-]".$lin.")/i", '', $model);
// }
//
// $modelsUrls = [];
//
// $stmtUrl = $dbh->prepare("SELECT name, params FROM `urls` WHERE site_id = ? AND params regexp 'a:1.*\"model_id.*'");
// foreach ($sites as $site) {
//   $stmtUrl->execute([$site]);
//   $urls = $stmtUrl->fetchAll(\PDO::FETCH_ASSOC);
//   foreach ($urls as $url) {
//     $url['name'] = explode('/', $url['name']);
//     unset($url['name'][0]);
//     $url['name'] = implode('/', $url['name']);
//     preg_match('/model_id";s:\d+:"(\d+)"/', $url['params'], $match);
//     $type = $oldModels[$match[1]];
//     if (isset($models[$type.'_'.$match[1]]))
//       $modelsUrls[$type.'_'.$url['name']] = $models[$type.'_'.$match[1]];
//   }
// }
//
// file_put_contents("models2.json", json_encode($modelsUrls));
//
// exit;


$siteBrand = [
  'centre.services' => 'Sony',
  'sam-centre.com' => 'Samsung',
  'asus-centre.com' => 'Asus',
  'acer-centre.com' => 'Acer',
  'lenovo-centre.com' => 'Lenovo',
  'hp-centre.com' => 'HP',
  'toshiba-centre.com' => 'Toshiba',
  'msi.centre.services' => 'MSI',
  'dell.centre.services' => 'Dell',
  'htc-centre.com' => 'HTC',
  'nokia-centre.com' => 'Nokia',
  'lg-centre.com' => 'LG',
  'xiaomi-centre.com' => 'Xiaomi',
  'huawei-centre.com' => 'Huawei',
  'meizu-centre.com' => 'Meizu',
  'apple.centre.services' => 'Apple',
  'canon-centre.com' => 'Canon',
  'photo.centre.services' => 'Nikon'
];

$services = [
  'ноутбук' => [
    'diagnostics' => 'diagnostika',
    'remont-wifi' => 'zamena-wi-fi',
    'remont-matritsy' => 'zamena-matritsy',
    'vosstanovlenie-tsepi-pitaniya' => 'zamena-tsepi-pitaniya',
    'remont-videokarty' => 'remont-videokarty',
    'remont-hdd' => 'zamena-diska-hdd-ssd',
    'remont-klaviatury' => 'zamena-klaviatury',
    'nastroika-os-windows' => 'nastrojka-windows',
    'remont-platy' => 'zamena-materinskoj-platy',
    'zamena-ozu' => 'zamena-operativnoj-pamyati',
    'chistka' => 'chistka',
    'remont-kulera' => 'zamena-kulera',
    'nastroika-bios' => 'nastrojka-bios',
    'razborka' => 'razborka',
    'nastroika-draiverov' => 'ustanovka-drajverov',
    'remont-hdmi' => 'zamena-razyoma-hdmi',
    'remont-usb' => 'zamena-razyoma-usb',
    'remont-zvukovoy-karty' => 'zamena-zvukovoj-karty',
    'remont-shleyfa' => 'zamena-shlejfa',
    'zamena-severnogo-mosta' => 'zamena-severnogo-mosta',
    'zamena-akkumulyatora' => 'zamena-batarei',
    'zamena-zu' => 'zamena-zaryadnogo',
    'remont-razyoma-pitaniya' => 'zamena-gnezda-pitaniya',
    'remont-kamery' => 'zamena-kamery',
    'remont-microfona' => 'zamena-mikrofona',
    'remont-tachpada' => 'zamena-tachpad',

    'diagnostika' => 'diagnostika',
    'zamena-wifi' => 'zamena-wi-fi',
    'zamena-matritsy' => 'zamena-matritsy',
    'remont-tsepi-pitaniya' => 'zamena-tsepi-pitaniya',
    'zamena-videokarty' => 'remont-videokarty',
    'zamena-zhestkogo-diska' => 'zamena-diska-hdd-ssd',
    'zamena-klaviatury' => 'zamena-klaviatury',
    'nastroyka-windows' => 'nastrojka-windows',
    'zamena-materinskoy-platy' => 'zamena-materinskoj-platy',
    'zamena-pamyati' => 'zamena-operativnoj-pamyati',
    'chistka-noutbuka' => 'chistka',
    'zamena-kulera' => 'zamena-kulera',
    'nastroyka-bios' => 'nastrojka-bios',
    'razborka-noutbuka' => 'razborka',
    'ustanovka-drayverov' => 'ustanovka-drajverov',
    'zamena-hdmi' => 'zamena-razyoma-hdmi',
    'remont-usb' => 'zamena-razyoma-usb',
    'remont-zvukovoy-karty' => 'zamena-zvukovoj-karty',
    'remont-shleyfa' => 'zamena-shlejfa',
    'zamena-severnogo-mosta' => 'zamena-severnogo-mosta',
    'zamena-batarei' => 'zamena-batarei',
    'zamena-zaryadnogo-ustroystva' => 'zamena-zaryadnogo',
    'zamena-gnezda-pitaniya' => 'zamena-gnezda-pitaniya',
    'remont-kamery' => 'zamena-kamery',
    'remont-microfona' => 'zamena-mikrofona',
    'remont-tachpada' => 'zamena-tachpad',
  ],

  'планшет' => [
    'diagnostics' => 'diagnostika',
    'remont-wifi' => 'zamena-wi-fi',
    'zamena-ekrana' => 'zamena-displeya',
    'vosstanovlenie-tsepi-pitaniya' => 'remont-tsepi-pitaniya',
    'remont-platy' => 'zamena-materinskoj-platy',
    'chistka' => 'chistka',
    'razborka' => 'razborka',
    'remont-kontrollera' => 'zamena-kontrollera-platy',
    'remont-hdmi' => 'zamena-razyoma-hdmi',
    'remont-usb' => 'zamena-razyoma-usb',
    'zamena-akkumulyatora' => 'zamena-batarei',
    'remont-kamery' => 'zamena-kamery',
    'remont-microfona' => 'zamena-mikrofona',
    'remont-korpusa' => 'zamena-korpusa',
    'remont-dinamika' => 'zamena-dinamika',
    'remont-kryshki' => 'zamena-zadnej-kryshki',
    'remont-simholdera' => 'zamena-derzhatelya-sim',
    'remont-knopki' => 'zamena-knopki-vklyucheniya',
    'remont-gps' => 'zamena-gps',
    'remont-vibro' => 'zamena-vibro',

    'diagnostika' => 'diagnostika',
    'zamena-wifi' => 'zamena-wi-fi',
    'zamena-displeya' => 'zamena-displeya',
    'remont-tsepi-pitaniya' => 'remont-tsepi-pitaniya',
    'zamena-materinskoy-platy' => 'zamena-materinskoj-platy',
    'chistka-plansheta' => 'chistka',
    'razborka-plansheta' => 'razborka',
    'zamena-multikontrollera' => 'zamena-kontrollera-platy',
    'zamena-hdmi' => 'zamena-razyoma-hdmi',
    'zamena-usb' => 'zamena-razyoma-usb',
    'zamena-shleyfa' => 'zamena-batarei',
    'zamena-kamery' => 'zamena-kamery',
    'zamena-mikrofona' => 'zamena-mikrofona',
    'zamena-korpusa' => 'zamena-korpusa',
    'zamena-dinamika' => 'zamena-dinamika',
    'zamena-zadney-kryshki' => 'zamena-zadnej-kryshki',
    'zamena-derzhatelya-sim' => 'zamena-derzhatelya-sim',
    'zamena-knopki-vklyucheniya' => 'zamena-knopki-vklyucheniya',
    'zamena-gps' => 'zamena-gps',
    'zamena-vibro' => 'zamena-vibro',
  ],

  'смартфон' => [
    'diagnostics' => 'diagnostika',
    'remont-wifi' => 'zamena-wi-fi-modulya',
    'zamena-ekrana' => 'zamena-displeya',
    'vosstanovlenie-tsepi-pitaniya' => 'remont-tsepi-pitaniya',
    'remont-platy' => 'zamena-materinskoj-platy',
    'chistka' => 'chistka',
    'razborka' => 'razborka',
    'remont-kontrollera' => 'zamena-multikontrollera',
    'remont-hdmi' => 'zamena-razyoma-hdmi',
    'remont-usb' => 'zamena-razyoma-usb',
    'remont-shleyfa' => 'zamena-shlejfa',
    'zamena-akkumulyatora' => 'zamena-akkumulyatora',
    'remont-razyoma-pitaniya' => 'zamena-gnezda-pitaniya',
    'remont-kamery' => 'zamena-kamery',
    'remont-microfona' => 'zamena-mikrofona',
    'remont-korpusa' => 'zamena-korpusa',
    'remont-dinamika' => 'zamena-dinamika',
    'remont-kryshki' => 'zamena-zadnej-kryshki',
    'remont-simholdera' => 'zamena-derzhatelya-sim',
    'remont-knopki' => 'zamena-knopki-vklyucheniya',
    'remont-gps' => 'zamena-gps',
    'remont-vibro' => 'zamena-vibro',

    'diagnostika' => 'diagnostika',
    'zamena-wifi' => 'zamena-wi-fi-modulya',
    'zamena-displeya' => 'zamena-displeya',
    'remont-tsepi-pitaniya' => 'remont-tsepi-pitaniya',
    'zamena-materinskoy-platy' => 'zamena-materinskoj-platy',
    'chistka-telefona' => 'chistka',
    'razborka-telefona' => 'razborka',
    'zamena-multikontrollera' => 'zamena-multikontrollera',
    'zamena-hdmi' => 'zamena-razyoma-hdmi',
    'zamena-usb' => 'zamena-razyoma-usb',
    'zamena-shleyfa' => 'zamena-shlejfa',
    'zamena-batarei' => 'zamena-akkumulyatora',
    'zamena-gnezda-pitaniya' => 'zamena-gnezda-pitaniya',
    'zamena-kamery' => 'zamena-kamery',
    'zamena-mikrofona' => 'zamena-mikrofona',
    'zamena-korpusa' => 'zamena-korpusa',
    'zamena-dinamika' => 'zamena-dinamika',
    'zamena-zadney-kryshki' => 'zamena-zadnej-kryshki',
    'zamena-derzhatelya-sim' => 'zamena-derzhatelya-sim',
    'zamena-knopki-vklyucheniya' => 'zamena-knopki-vklyucheniya',
    'zamena-gps' => 'zamena-gps',
    'zamena-vibro' => 'zamena-vibro',
  ],

  'телефон' => [
    'diagnostics' => 'diagnostika',
    'remont-wifi' => 'zamena-wi-fi-modulya',
    'zamena-ekrana' => 'zamena-displeya',
    'vosstanovlenie-tsepi-pitaniya' => 'remont-tsepi-pitaniya',
    'remont-platy' => 'zamena-materinskoj-platy',
    'chistka' => 'chistka',
    'razborka' => 'razborka',
    'remont-kontrollera' => 'zamena-multikontrollera',
    'remont-hdmi' => 'zamena-razyoma-hdmi',
    'remont-usb' => 'zamena-razyoma-usb',
    'remont-shleyfa' => 'zamena-shlejfa',
    'zamena-akkumulyatora' => 'zamena-akkumulyatora',
    'remont-razyoma-pitaniya' => 'zamena-gnezda-pitaniya',
    'remont-kamery' => 'zamena-kamery',
    'remont-microfona' => 'zamena-mikrofona',
    'remont-korpusa' => 'zamena-korpusa',
    'remont-dinamika' => 'zamena-dinamika',
    'remont-kryshki' => 'zamena-zadnej-kryshki',
    'remont-simholdera' => 'zamena-derzhatelya-sim',
    'remont-knopki' => 'zamena-knopki-vklyucheniya',
    'remont-gps' => 'zamena-gps',
    'remont-vibro' => 'zamena-vibro',

    'diagnostika' => 'diagnostika',
    'zamena-wifi' => 'zamena-wi-fi-modulya',
    'zamena-displeya' => 'zamena-displeya',
    'remont-tsepi-pitaniya' => 'remont-tsepi-pitaniya',
    'zamena-materinskoy-platy' => 'zamena-materinskoj-platy',
    'chistka-telefona' => 'chistka',
    'razborka-telefona' => 'razborka',
    'zamena-multikontrollera' => 'zamena-multikontrollera',
    'zamena-hdmi' => 'zamena-razyoma-hdmi',
    'zamena-usb' => 'zamena-razyoma-usb',
    'zamena-shleyfa' => 'zamena-shlejfa',
    'zamena-batarei' => 'zamena-akkumulyatora',
    'zamena-gnezda-pitaniya' => 'zamena-gnezda-pitaniya',
    'zamena-kamery' => 'zamena-kamery',
    'zamena-mikrofona' => 'zamena-mikrofona',
    'zamena-korpusa' => 'zamena-korpusa',
    'zamena-dinamika' => 'zamena-dinamika',
    'zamena-zadney-kryshki' => 'zamena-zadnej-kryshki',
    'zamena-derzhatelya-sim' => 'zamena-derzhatelya-sim',
    'zamena-knopki-vklyucheniya' => 'zamena-knopki-vklyucheniya',
    'zamena-gps' => 'zamena-gps',
    'zamena-vibro' => 'zamena-vibro',
  ],
];

$sl = ['order' => 'zakaz', 'status' => 'status', 'services' => 'ekspress-remont', 'contacts' => 'kontakty', 'ask' => 'sprosi', 'delivery' => 'dostavka', 'politica' => 'politika', 'contacts/requisites' => 'kontakty/rekvizity', 'thank-you' => 'spasibo', 'diagnostics' => 'diagnostika-{brand}', 'price' => 'ceny-remonta-{brand}', '/' => 'servis-{brand}'];

if (isset($_POST['old'])) {

  #выехали

  function url($url, $brand) {

    global $sl;
    global $hub;
    global $typesUrl;
    global $typesBrandUrl;
    global $services;

    #служебки
    if (isset($sl[$_POST['old']])) {
      return $sl[$_POST['old']];
    }

    $old = trim($_POST['old'], '/');
    $lvl = explode("/", $old);
    $active = true;

    $newUrl = [];

    #хабы
    if (isset($hub[$lvl[0]])) {
      $type = $hub[$lvl[0]];
      if (isset($typesBrandUrl[$brand][$type])) {
        $newUrl[] = 'remont-'.$typesBrandUrl[$brand][$type];
      }
      else if (isset($typesUrl[$type])) {
        $newUrl[] = 'remont-'.$typesUrl[$type].'-{brand}';
      }
      else
        return false;
    }

    if (count($lvl) > 2) {
      $modelsUrls = json_decode(file_get_contents("models2.json"), true);
      $model = $type.'_'.$lvl[1].'/'.$lvl[2];
      if (isset($modelsUrls[$model])) {
        if ($modelsUrls[$model] != 'false' && $modelsUrls[$model] !== false && $modelsUrls[$model][0] == $brand) {
          $newUrl[] = $modelsUrls[$model][1];
        }
      }
      else {
        $active = false;
      }
    }

    if (count($lvl) > 3 && isset($services[$type][$lvl[3]]) && $active) {
      $newUrl[] = $services[$type][$lvl[3]];
    }

    if (count($newUrl))
      return implode('/', $newUrl);
    else
      return false;
  }

  $brand = strtolower($siteBrand[$_POST['site']]);
  $url = str_replace('{brand}', $brand, url($_POST['old'], $brand));

  echo '<p>'.($url === false ? 'хуй' : $url).'<br><br></p>';
}

?>

<form class="" action="" method="post">
  <select name = "site">
  <?php foreach ($siteBrand as $site=>$brand) { ?>
  <option value = "<?=$site?>"><?=$site.' ~ '.$brand?></option>
  <?php } ?>
  </select>
  <input type = "text" name = "old" placeholder="old url">
  <input type = "submit">
</form>
