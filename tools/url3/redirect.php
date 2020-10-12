<?php
$sc3_dbname = $_ENV['CFG_DATA']['db']['sc3']['db_name'];
$sc3_login = $_ENV['CFG_DATA']['db']['sc3']['sc3-user']['user'];
$sc3_pass = $_ENV['CFG_DATA']['db']['sc3']['sc3-user']['pass'];

$dbh = new \PDO('mysql:host=localhost;dbname=service-3_gg;charset=UTF8', 'service-3_mysql', '0X4l3U3q');
$dbh2 = new \PDO('mysql:host=localhost;dbname='.$sc3_dbname.';charset=UTF8', $sc3_login, $sc3_pass);


$services = ["1-diagnostika","1-zamena_wifi","1-zamena_matritsy","1-remont_tsepi_pitaniya","1-zamena_videokarty","1-zamena_zhestkogo_diska","1-zamena_klaviatury","1-nastroyka_windows","1-zamena_materinskoy_platy","1-zamena_pamyati","1-chistka_noutbuka","1-zamena_kulera","1-nastroyka_bios","1-remont_yuzhnogo_mosta","1-ustanovka_drayverov","1-zamena_multikontrollera","1-zamena_hdmi","1-zamena_usb","1-zamena_shleyfa_matritsy","1-remont_severnogo_mosta","1-zamena_batarei","1-zamena_zaryadnogo_ustroystva","1-zamena_gnezda_pitaniya","1-zamena_kamery","1-zamena_tachpad","2-diagnostika","2-zamena_wifi","2-zamena_displeya","2-remont_tsepi_pitaniya","2-zamena_materinskoy_platy","2-chistka_plansheta","2-zamena_multikontrollera","2-zamena_usb","2-zamena_shleyfa","2-zamena_batarei","2-zamena_gnezda_pitaniya","2-zamena_kamery","2-zamena_mikrofona","2-zamena_korpusa","2-zamena_dinamika","2-zamena_zadney_kryshki","2-zamena_derzhatelya_sim","2-zamena_knopki_vklyucheniya","2-zamena_gps","3-diagnostika","3-zamena_wifi","3-zamena_displeya","3-remont_tsepi_pitaniya","3-zamena_materinskoy_platy","3-chistka_telefona","3-zamena_multikontrollera","3-zamena_usb","3-zamena_shleyfa","3-zamena_batarei","3-zamena_gnezda_pitaniya","3-zamena_kamery","3-zamena_mikrofona","3-zamena_korpusa","3-zamena_dinamika","3-zamena_zadney_kryshki","3-zamena_derzhatelya_sim","3-zamena_knopki_vklyucheniya","3-zamena_gps","3-zamena_vibro","2-chistka_ot_virusov","2-uvelichit_pamyat","2-vosstanovlenie_dannyh","2-zamena_antenny","2-zamena_gnezda_naushnikov","2-zamena_knopki_gromkosti","2-zamena_pamyati","3-pereproshivka_vosstanovlenie","3-vosstanovlenie_posle_popadaniya_vody","3-zamena_antennogo_modulya","3-zamena_gnezda_naushnikov","3-zamena_datchika_priblizheniya","3-zamena_zadnego_stekla","3-zamena_knopki_gromkosti","3-zamena_modema","3-zamena_pamyati","3-zamena_sistemnogo_razema","3-zamena_skanera_otpechatkov_palcev","3-zamenit_steklo_kamery","3-razlochka","3-rusifikaciya","3-uvelichenie_pamyati","3-chistka_dinamika","3-chistka_kamery","1-zamena_diska_na_ssd","1-gravirovka_klaviatury","1-zamena_batareyki_na_materinskoy_plate","1-zamena_korpusa","1-zamena_petel","1-zamena_termopasty","1-chistka_ot_pyli_i_zamena_termopasty","1-zamena_videochipa","1-zamena_processora","1-remont_zalitogo_noutbuka","1-remont_modulya_hdmi","1-sbros_parolya_bios"];

$complects = ["1-matritsa","1-klaviatura","1-materinskaya_plata","1-multikontroller","1-zhestkiy_disk","1-kuler","1-operativnaya_pamyat","1-hdmi","1-usb","1-wifi","1-akkumulyator","1-videokarta","1-zaryadnoe_ustroystvo","1-zvukovaya_karta","1-kamera","1-mikrofon","1-razyom_pitaniya","1-seveniy_most","1-tachpad","1-shleyf_matritsy","1-yuzhniy_most","2-displey","2-materinskaya_plata","2-multikontroller","2-hdmi","2-usb","2-wifi","2-akkumulyator","2-kamera","2-mikrofon","2-razyom_pitaniya","2-korpus","2-kryshka","2-sim_holder","2-knopka_vklyucheniya","2-gps","2-vibro","2-dinamik","2-shleyf","3-displey","3-materinskaya_plata","3-multikontroller","3-hdmi","3-usb","3-wifi","3-akkumulyator","3-kamera","3-mikrofon","3-razyom_pitaniya","3-korpus","3-kryshka","3-sim_holder","3-knopka_vklyucheniya","3-gps","3-vibro","3-dinamik","3-shleyf"];

$defects = ["1-ne_vkluchaetsya","1-cherniy_ekran","1-ne_zagruzhaetsya","1-perezagruzhaetsya","1-siniy_ekran","1-vykluchaetsya","1-ne_zaryazhaetsya","1-razryazhaetsya","1-ne_rabotaet_klaviatura","1-ne_vidit_disk","1-polosy_na_ekrane","1-net_zvuka","1-ne_rabotaet_usb","1-ne_rabotaet_hdmi","1-ne_rabotaet_tachpad","1-ne_rabotaet_kamera","1-ne_rabotaet_mikrofon","1-ne_rabotaet_wifi","1-shumit","1-peregrevaetsya","2-ne_vkluchaetsya","2-ne_gorit_ekran","2-ne_zagruzhaetsya","2-vykluchaetsya","2-ne_zaryazhaetsya","2-razryazhaetsya","2-ne_rabotaet_usb","2-ne_rabotaet_hdmi","2-ne_rabotaet_tachskrin","2-ne_rabotaet_kamera","2-ne_rabotaet_mikrofon","2-ne_rabotaet_wifi","2-ne_vidit_sim","2-ne_rabotaet_vibro","2-ne_rabotaet_dinamik","2-ne_rabotaet_knopka","2-ne_rabotaet_gps","2-razbit_ekran","2-deformatsiya_kryshki","2-deformatsiya_korpusa","3-ne_vkluchaetsya","3-ne_gorit_ekran","3-ne_zagruzhaetsya","3-vykluchaetsya","3-ne_zaryazhaetsya","3-razryazhaetsya","3-ne_rabotaet_usb","3-ne_rabotaet_hdmi","3-ne_rabotaet_tachskrin","3-ne_rabotaet_kamera","3-ne_rabotaet_mikrofon","3-ne_rabotaet_wifi","3-ne_vidit_sim","3-ne_rabotaet_vibro","3-ne_rabotaet_dinamik","3-ne_rabotaet_knopka","3-ne_rabotaet_gps","3-razbit_steklo","3-deformatsiya_kryshki","3-deformatsiya_korpusa"];

$mms = ["2-3-fonepad","2-3-memo_pad","2-3-nexus","2-3-transformer_pad","2-3-zenpad","1-3-eee_pc","1-3-rog","1-3-vivobook","1-3-zenbook","3-3-fonepad","3-3-nexus","3-3-padfone","3-3-zenfone","3-5-vibe","3-5-zuk","2-5-tab","2-5-miix","2-5-phab","2-5-thinkpad","1-5-ideapad","1-5-thinkpad","1-5-thinkpad_yoga","2-1-xperia_tablet","3-1-xperia","1-1-vaio","1-9-adamo","1-9-alienware","1-9-inspiron","1-9-latitude","1-9-vostro","1-9-xps","2-9-latitude","2-9-xps","3-4-liquid","2-4-iconia","2-4-iconia_one","2-4-iconia_tab","1-4-aspire","1-4-aspire_one","1-4-aspire_switch","1-4-extensa","1-4-travelmate","3-10-10","3-10-butterfly","3-10-desire","3-10-incredible","3-10-one","3-10-sensation","3-10-windows_phone","3-10-titan","3-17-ascend","3-17-g","3-17-honor","3-17-mate","2-17-mediapad","1-6-elitebook","1-6-envy","1-6-omen","1-6-pavilion","1-6-probook","1-6-spectre","2-6-elite","2-6-envy","2-6-pavilion","2-6-pro","2-7-satellite","1-7-qosmio","1-7-satellite","1-7-satellite_pro","3-18-mi","3-18-redmi","3-18-redmi_note","2-18-mipad","3-20-m2","3-20-m3","3-20-mx","3-20-mx2","3-20-mx3","3-20-mx4","3-20-mx5","3-20-mx6","1-21-macbook","1-21-macbook_air","1-21-macbook_pro","2-21-ipad_mini","1-6-compaq","3-10-wildfire","3-17-nova","3-17-y5","3-17-y7","3-17-p10","3-17-y6","3-17-p8","3-17-p9","1-5-g780","3-5-p780","3-5-s820","3-5-k3","3-5-k6","3-5-a6010","3-20-u10","3-20-m5c","3-20-m3s","3-20-m5","3-20-m6","3-2-c3520","3-18-mi4","3-18-mi4c","3-18-mi4i","3-18-mi2s","3-18-mi5"];

$markas = [
  "sony" => "1",
  "samsung" => "2",
  "asus" => "3",
  "acer" => "4",
  "lenovo" => "5",
  "hp" => "6",
  "toshiba" => "7",
  "msi" => "8",
  "dell" => "9",
  "htc" => "10",
  "nokia" => "11",
  "lg" => "12",
  "alcatel" => "14",
  "compaq" => "15",
  "fly" => "16",
  "huawei" => "17",
  "xiaomi" => "18",
  "meizu" => "20",
  "apple" => "21",
  "nikon" => "22",
  "canon" => "23",
  "ariston" => "24",
  "philips" => "25",
  "panasonic" => "26",
  "electrolux" => "29",
  "bbk" => "30",
  "bosch" => "31",
  "epson" => "32",
  "indesit" => "33",
  "archos" => "34",
  "benq" => "35",
  "blackberry" => "36",
  "bq" => "37",
  "dexp" => "38",
  "digma" => "39",
  "emachines" => "40",
  "explay" => "41",
  "fujitsu" => "42",
  "ginzzu" => "43",
  "haier" => "44",
  "highscreen" => "45",
  "iconbit" => "46",
  "irbis" => "47",
  "keneksi" => "48",
  "leeco" => "49",
  "lexand" => "50",
  "magic" => "51",
  "micromax" => "52",
  "motorola" => "53",
  "nautilus" => "54",
  "oneplus" => "55",
  "oysters" => "56",
  "packard bell" => "57",
  "prestigio" => "58",
  "qumo" => "59",
  "ritmix" => "60",
  "texet" => "61",
  "thl" => "62",
  "viewsonic" => "63",
  "wexler" => "64",
  "zopo" => "65",
  "zte" => "66",
  "kyocera" => "67",
  "3q" => "68",
  "4good" => "69",
];

$types = [
  "noutbukov" => 1,
  "planshetov" => 2,
  "telefonov" => 3,
];

function checkLin($lin, $typeMark) {
  global $mms;
  $mm = $typeMark[0].'-'.$typeMark[1].'-'.$lin;
  if (!array_search($mm, $mms)) {
    $mm .= '-series';
    $lin .= '-series';
    if (!array_search($mm, $mms)) {
      return false;
    }
  }
  return $lin;
}

if (isset($_POST['old'])) {

  #выехали

  function url($url) {

    global $services, $complects, $defects, $mms, $markas, $types;

    $old = trim($_POST['old'], '/');
    $lvl = explode("/", $old);

    $newUrl = [];

    if (count($lvl) > 1 && $lvl[1] != 'ceny') {
      $f = explode('_', $lvl[0]);
      $marka = $markas[$f[count($f)-1]];
      $type = $types[$f[count($f)-2]];
    }

    if (count($lvl) == 2 && $lvl[1] != 'ceny') {
      $l = $type.'-'.$lvl[1];
      if (!array_search($l, $services) && !array_search($l, $complects) && !array_search($l, $defects)) {
        $mm = $type.'-'.$marka.'-'.$lvl[1];
        if (!array_search($mm, $mms)) {
          $mm .= '-series';
          $lvl[1] .= '-series';
          if (!array_search($mm, $mms)) {
            $newUrl = [$lvl[0]];
          }
          else {
            $newUrl = $lvl;
          }
        }
      }
    }

    if (count($lvl) == 3) {
      $l = $type.'-'.$lvl[2];
      if (array_search($l, $services) || array_search($l, $complects) || array_search($l, $defects)) {
        if (($lin = checkLin($lvl[1], [$type, $marka]))) {
          $lvl[1] = $lin;
        }
        else {
          unset($lvl[1]);
        }
        $newUrl = $lvl;
      }
      else {
        $old = require_once 'oldmodels.php';
        $model = $lvl[1].'/'.$lvl[2];
        $findModel = false;
        if (isset($old[$model])) {
          $id = $old[$model];
          $new = require_once 'newmodels.php';
          if (isset($new[$id])) {
            $newUrl = [$lvl[0], $new[$id]];
            $findModel = true;
          }
        }

        if (!$findModel) {
          $mm = $type.'-'.$marka.'-'.$lvl[1];
          if (!array_search($mm, $mms)) {
            $mm .= '-series';
            $lvl[1] .= '-series';
            if (!array_search($mm, $mms)) {
              $newUrl = [$lvl[0]];
            }
            else {
              $newUrl = $lvl;
            }
          }
          else {
            unset($lvl[2]);
            $newUrl = $lvl;
          }
        }
      }
    }

    if (count($lvl) == 4) {
      $newUrl = [$lvl[0]];
      $old = require_once 'oldmodels.php';
      $model = $lvl[1].'/'.$lvl[2];
      $findModel = false;
      if (isset($old[$model])) {
        $id = $old[$model];
        $new = require_once 'newmodels.php';
        if (isset($new[$id])) {
          $newUrl[] = $new[$id];
          $findModel = true;
        }
      }

      if (!$findModel) {
        if (($lin = checkLin($lvl[1], [$type, $marka]))) {
          $newUrl[] = $lin;
        }
      }

      $l = $type.'-'.$lvl[3];
      if (array_search($l, $services) || array_search($l, $complects) || array_search($l, $defects)) {
        $newUrl[] = $lvl[3];
      }
    }

    if (count($newUrl))
      return implode('/', $newUrl);
    else
      return false;
  }

  $url = url($_POST['old']);

  echo '<p>'.($url === false ? 'ne treba' : $url).'<br><br></p>';
}

?>

<form class="" action="" method="post">
  <input type = "text" name = "old" placeholder="old url">
  <input type = "submit">
</form>
