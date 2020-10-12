<? //ppinfo();

define('CFG_FOLDER', dirname(__DIR__) . DIRECTORY_SEPARATOR . 'cfg');
define("CFG_FILE", CFG_FOLDER . DIRECTORY_SEPARATOR . 'cfg.php');

$_ENV['CFG_DATA'] = require_once CFG_FILE;

spl_autoload_extensions('.php');
spl_autoload_register();

use framework\ajax\parse\parse;
use framework\pdo;

use framework\ajax\edit_table\hooks\gen_level;
use framework\ajax\edit_table\hooks\fill_new;
use framework\ajax\edit_table\hooks\dell_sites;
use framework\ajax\edit_table\hooks\gen_urls;

$args1 = $args2 = array('site_id' => 43345);
$obj1 = new fill_new();
$obj1->beforeAdd($args1); //генерация хабовых страниц + служебных
//
//var_dump('test');
//
//$pdo = new \PDO('mysql:host=78.47.129.12;dbname=piwik;charset=UTF8', 'piwik', 'J9qWqEf56EjHyei');
//$calls = $pdo->query("SELECT `id` FROM `matomo_log_visit` LIMIT 0,1")->fetchAll(\PDO::FETCH_ASSOC);
//
//print_r($calls);
 
// exec("php /var/www/www-root/data/www/studiof1-test.ru/cache_bg.php pid=1", $output, $return_var);
// print_r($output);
// print_r($return_var);

// echo 'test';

/*$str = '{
"op": "call",
"args": {
"mode": "out",
"notification_name": "crm-out",
"virtual_phone_number": "78633109653",
"notification_time": "2019-12-16 14:40:47.234",
"external_id": null,
"contact_phone_number": "79508418541",
"employee_full_name": "Ростов-на-Дону СЦ-5",
"employee_id": 323409,
"call_source": "va",
"direction": "in",
"call_session_id": 998677427,
"scenario_name": "СЦ-5 Ростов Михаил",
"talk_time_duration": 12,
"total_time_duration": 23,
"wait_time_duration": 11,
"tag_names": null,
"is_transfer": false,
"last_talked_employee_id": 323409
}
}';

echo $str;


$request_json = mb_convert_encoding(json_encode(json_decode($str, TRUE)), 'UTF-8');

echo $request_json;

$url = 'https://cibacrm.com/admin/';
//$request_json = $str;
    
$ch = curl_init();
curl_setopt_array($ch,
	array(CURLOPT_URL => 'https://cibacrm.com/admin/index.php', CURLOPT_POST => 1,
		CURLOPT_POSTFIELDS => $request_json, CURLOPT_RETURNTRANSFER => 1, CURLOPT_SSL_VERIFYPEER => 0, 
            CURLOPT_SSL_VERIFYHOST => 0, CURLOPT_FOLLOWLOCATION => 1,
              CURLOPT_HTTPHEADER => array(
                        'Accept: application/json',
                        'Connection: close',
                        'Content-Type: application/json; charset=UTF-8',
                        'Content-Length: '.mb_strlen($request_json))));

var_dump(curl_exec($ch));

/*$sql = "SELECT `sites`.`id`, `partner_id` FROM `sites`";
$sites = pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_ASSOC);


$sql = "SELECT `id`, `name` FROM `partners`";
$partners = pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_KEY_PAIR);

$partners_reverse = array_flip($partners);

foreach ($sites as $site)
{
    $name = $partners[$site['partner_id']];
    $t_name = mb_substr($name, 0, -5);
    
    echo $t_name.PHP_EOL;
    
    $name = $t_name.', YD';
    
    $sql = "UPDATE `sites` SET `partner_yd` = $partners_reverse[$name] WHERE `id` = {$site['id']}";   
    //echo $sql.PHP_EOL;
    pdo::getPdo()->query($sql);
    
    $name = $t_name.', GA';
    $sql = "UPDATE `sites` SET `partner_ga` = $partners_reverse[$name] WHERE `id` = {$site['id']}";   
    //echo $sql.PHP_EOL;
    pdo::getPdo()->query($sql);
}

/*foreach ($partners as $partner)
{
    $args = $partner;
    unset($args['id']);
    $t_name = $args['name'];
    
    foreach (['YD', 'GA'] as $name)
    {
        $args['name'] = $t_name.', '.$name;
        $sql = "INSERT INTO `partners` SET ".pdo::prepare($args);
        
        //echo $sql.PHP_EOL;
       // print_r($args);
        
        $stm = pdo::getPdo()->prepare($sql);  
        $stm->execute($args);
    }
    
    $t_t_name = $t_name.', SEO';
    $sql = "UPDATE `partners` SET `name` = '{$t_t_name}' WHERE `id` = {$partner['id']}";
    //echo $sql.PHP_EOL;
    pdo::getPdo()->query($sql);
}*/




/*$url = 'ir.hp-recentre.ru/promo/';

$ch = curl_init();
                curl_setopt_array($ch, array(CURLOPT_URL => $url, CURLOPT_POST => 1,
        		          CURLOPT_RETURNTRANSFER => 1, CURLOPT_SSL_VERIFYPEER => 0, 
                                    CURLOPT_SSL_VERIFYHOST => 0, CURLOPT_FOLLOWLOCATION => 1));
                
                $html = curl_exec($ch);
                
                curl_close($ch);
                
$dom = new DOMDocument;
libxml_use_internal_errors(true);
$dom->loadHTML($html);
$element = $dom->getElementById('mango');
$mango = $element->nodeValue;
print_r($mango);

/*$sites = [
    'Acer' => 'acer.russupport.com',
    'Apple' => 'apple.russupport.com',
    'Asus' => 'asus.russupport.com',
    'BQ' => 'bq.russupport.com',
    'Canon' => 'canon.russupport.com',
    'Dell' => 'dell.russupport.com',
    'DEXP' => 'dexp.russupport.com',
    'Digma' => 'digma.russupport.com',
    'Explay' => 'explay.russupport.com',
    'Fly' => 'fly.russupport.com',
    'Haier' => 'haier.russupport.com',
    'Highscreen' => 'highscreen.russupport.com',
    'HP' => 'hp.russupport.com',
    'HTC' => 'htc.russupport.com',
    'Huawei' => 'huawei.russupport.com',
    'Irbis' => 'irbis.russupport.com',
    'Lenovo' => 'lenovo.russupport.com',
    'Meizu' => 'meizu.russupport.com',
    'Motorola' => 'motorola.russupport.com',
    'MSI' => 'msi.russupport.com',
    'Nokia' => 'nokia.russupport.com',
    'Prestigio' => 'prestigio.russupport.com',
    'Samsung' => 'samsung.russupport.com',
    'Sony' => 'service.russupport.com',
    'teXet' => 'texet.russupport.com',
    'Toshiba' => 'toshiba.russupport.com',
    'Xiaomi' => 'xiaomi.russupport.com',
    'ZTE' => 'zte.russupport.com'
];

$t = '';

$sites = ['HP' => 'hp.russupport.com'];

foreach ($sites as $marka => $site)
{
    $t .= "'" . mb_strtolower($marka) . "' => [".PHP_EOL;
    
    $ch = curl_init();
    curl_setopt_array($ch,
        	array(
                CURLOPT_URL => 'https://' . $site . '/sitemap.xml',
        		CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_USERAGENT => 'Mozilla',
              ));
              
  echo 'https://' . $site . '/sitemap.xml';
              
  $str = curl_exec($ch);
  preg_match_all('|<loc(.*?)>(.*?)</loc>|isu', $str, $matches);
  
  $locs = $matches[2];
  
  foreach ($locs as $loc)
  {
     curl_setopt_array($ch,
        	array(
                CURLOPT_URL => $loc,
        		CURLOPT_RETURNTRANSFER => 1,
              ));
              
     $h1 = curl_exec($ch);     
     $path = parse_url($loc, PHP_URL_PATH);
     
     preg_match_all('|<h1(.*?)>(.*?)</h1>|isu', $h1, $matches);
     
     $t .= "\t'" . $path . "' => '" . $matches[2][0] . "',".PHP_EOL; 
  }
     
  $t .= "],";
}

echo $t;

                                           
         

/*$sql = "SELECT `m_models`.`name` AS `m_model_name`, `model_types`.`name` AS `type_name`, `markas`.`name` AS `marka_name`,
                `model_types`.`id` as `type_id`, `m_models`.`id` as `m_model_id`, `models`.`submodel` AS `submodel`,
                    `models`.`name` AS `model_name`, `models`.`sublineyka` AS `sublineyka`, `models`.`lineyka` AS `lineyka`,
                        `models`.`id` AS `model_id`, `sites`.`id` AS `site_id`
                    FROM `models` 
                INNER JOIN `m_models` ON `m_models`.`id` = `models`.`m_model_id`
                INNER JOIN `model_types` ON `model_types`.`id` = `m_models`.`model_type_id`
                INNER JOIN `markas` ON `markas`.`id` = `m_models`.`marka_id`
                        INNER JOIN `model_to_sites` ON `model_to_sites`.`model_id` = `models`.`id`
                         INNER JOIN `sites` ON `model_to_sites`.`site_id` = `sites`.`id`  
                        WHERE `sites`.`setka_id` = 5";
                    
$models = pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_ASSOC);

$t = [];
foreach ($models as $k)
    $t[$k['site_id']][] = $k;
    
//print_r($models);

$accord = array('ноутбук' => 'remont-notebooks', 'планшет' => 'remont-planshetov', 'смартфон' => 'remont-telefonov');
$urls = [];

foreach ($t as $site_id => $models)
{
    foreach ($models as $model_info)
    {
        $marka_name = tools::translit($model_info['marka_name']);
        $type_name = $model_info['type_name'];
        
        $m_model_name = tools::translit($model_info['m_model_name']);
        $submodel_name = tools::translit($model_info['submodel']);
        
        if (mb_strtolower($model_info['lineyka']) == mb_strtolower($model_info['sublineyka']))
            $model_sc5 = $submodel_name;   
        else
            $model_sc5 = $m_model_name.' '.$submodel_name; 
                                        
        $model_sc5 = str_replace(array('-',' '), '', $model_sc5);
        
        $url = $accord[$type_name].'-'.$marka_name.'/'.$model_sc5;
        $urls[$site_id][$url][] = array($model_info['model_name'], $model_info['model_id']);
    }
}

//print_r($urls);

foreach ($urls as $site_id => $url)
    foreach ($url as $key => $array)
        if (count($array) == 1) unset($urls[$site_id][$key]);

//print_r($urls);

$ex = [];
foreach ($urls as $site_id => $url)
{
    foreach ($url as $key => $array)
    {
        $sql = "SELECT * FROM `urls` WHERE `name` = '$key' AND `site_id` = $site_id";
        $arr = current(pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_ASSOC));
        
        $params = unserialize($arr['params']);
        
        foreach ($array as $u)
        {
            if ($u[1] != $params['model_id'])
                $ex[$u[1]] = $u[1];
        }
    }
}

file_put_contents('list.txt', implode(",".PHP_EOL, $ex));

//$args2 = array('site_id' => 156);  
//$obj2 = new fill_new();
//$obj2->beforeAdd($args2);*/

/*$sql = "select sites.id, name from sites 
        left join `marka_to_sites` on sites.id = marka_to_sites.site_id
                where marka_id = 1 and sites.setka_id = 1";
$sites = pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_ASSOC);*/

/*$sql = "SELECT `sites`.`id` as `site_id`, `marka_to_sites`.`marka_id` as `marka_id` FROM `sites` 
            inner join `marka_to_sites` on sites.id = marka_to_sites.site_id
                    WHERE `sites`.`setka_id` = 1";
$sites = pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_ASSOC);

print_r($sites);

$insert = [];
foreach ($sites as $site)
{
    $params = serialize(array('marka_id' => $site['marka_id'], 'static' => 'b2b'));
    $insert[] = "('b2b',".$site['site_id'].",'".$params."',".tools::get_rand_dop().",".tools::get_time().")";
}    

$sql = "INSERT IGNORE INTO `urls` (`name`,`site_id`,`params`,`feed`,`date`) VALUES ".implode(',', $insert);
echo $sql;
pdo::getPdo()->query($sql);  


/*$insert = [];
foreach ($sites as $site)
{
    $params = serialize(array('marka_id' => 1, 'static' => 'remont-televizorov'));
    $insert[] = "('remont-televizorov',".$site['id'].",'".$params."',".tools::get_rand_dop().",".tools::get_time().")";
}    

$sql = "INSERT IGNORE INTO `urls` (`name`,`site_id`,`params`,`feed`,`date`) VALUES ".implode(',', $insert);
echo $sql;
pdo::getPdo()->query($sql);      

//or name like '%nikon%'

/*$sql = "SELECT * FROM `sites` WHERE setka_id = 5 and (name like '%nikon%')";
$sites = pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
print_r($sites);

foreach ($sites as $site)
{
    $sql = "select * from urls where site_id = {$site['id']} and name = 'zamena-ekrana-nikon'";
    $assox = current(pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_ASSOC));
    print_r($assox);
    
    $sql = "delete from urls where id = {$assox['id']}";
    echo $sql.PHP_EOL;  
    //pdo::getPdo()->query($sql);
}


/*foreach ($sites as $site)
{
   $name = explode('.', $site['name']);
   $city = '';
   if (mb_strpos($name[0], '-') !== false) 
   {
      $arr = explode('-', $name[0]);
      $city = $arr[1] . '.';
      $name[0] = $arr[0];
   }
   
   $name = $city . $name[0] . '-recentre.ru';

   $sql = "UPDATE `sites` SET `name` = '{$name}' WHERE `id` = {$site['id']}";
   echo $site['name'].' '.$site['id'].' '.$sql.PHP_EOL;
   pdo::getPdo()->query($sql); 
}*/

/*use framite['']ework\tools;
use framework\gen\gen_model;
use framework\ajax\update_partner\update_partner;

$str = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/sdek/sdek.csv');
$rows = explode("||\r\n", $str);

$city_original = 'Барнаул';

$city = mb_strtolower($city_original);
$t_city = array();

foreach ($rows as $row)
{
    if ($row)
    {
        $row = str_replace(PHP_EOL, ' ', $row);
        $cols = explode(';', $row);
        
        if (mb_strtolower($cols[5]) == $city)
            $t_city[] = "'".$city_original.", ".$cols[6].", ".$cols[7].($cols[8] ? ", " : $cols[8])."'";
    }
}

print_r($t_city);

$sql = "SELECT `x`,`y`,`addres` FROM `sdek` WHERE `addres` IN (".implode(',',$t_city ).")"; echo $sql;
$address = pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_ASSOC);

$t = array();
foreach ($address as $value)
    $t[$value['addres']] = array($value['x'], $value['y']);    

$address = $t;

$mas = array();
$insert = array();

foreach ($t_city as $value)
{ 
    $value = mb_substr($value, 1, -1);
    
    if (isset($address[$value]))
    {
        $mas[] = $address[$value];
    }
    else
    {
        $responce = file_get_contents('https://geocode-maps.yandex.ru/1.x/?format=json&apikey=e0d7d39d-e16c-4097-bad3-4a66985b01ad&geocode='.urlencode($value));
        $responce = json_decode($responce, true);
        
        if (isset($responce['response']['GeoObjectCollection']['featureMember'][0]['GeoObject']['Point']['pos']))
        {
           $point = $responce['response']['GeoObjectCollection']['featureMember'][0]['GeoObject']['Point']['pos'];
           $point = explode(' ', $point);
           
           $insert[] = "('".$value."',".$point[0].",".$point[1].")";
           $mas[] = $point;  
        }
    }
}

if ($insert)
{
    $sql = "INSERT IGNORE INTO `sdek` (`addres`,`x`,`y`) VALUES ".implode(',', $insert);
    pdo::getPdo()->query($sql);    
}

print_r($mas);

//$obj = new update_partner();

/*$suffics = array('p', 'n', 'f');

$tables = array('service');

foreach ($tables as $value)
{
    $select_table = $suffics.'_'.$value.'s';
    $select_key = $value;
    
    if (pdo::getPdo()->query("SHOW TABLES LIKE '{$select_table}'")->rowCount() > 0)
    {
        $sql = "SELECT `name3`, `id` FROM `{$select_table}`";
        $table_mas[$select_key] = pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
    }
}

print_r($table_mas);

/*    $accord = array('ноутбук' => 'remont-notebooks', 'планшет' => 'remont-planshetov', 'смартфон' => 'remont-telefonov');
                        
    $params = serialize(array('model_type_id' => $type_id, 'marka_id' => $marka_id));
    $urls[] = array($site['site_id'], "'".$accord[$type_name].'-'.$marka_name."'",
        "'".$params."'", tools::get_rand_dop());*/

/*  $numbers = array_merge(range(1, 7), range(9, 12));
  print_r(range(1, 7));
  print_r(range(9, 12));
  shuffle($numbers);
  
  print_r($numbers);

/*$site_name = 'lenovo-russia.ru';
$mode = 1;
$ajax = new parse(array('site' => $site_name, 'url' => 'sitemap.xml'));
$urls = array();
       
$insert = array();
$i = 0;
            
foreach(explode("\n", $ajax->getWrapper()->getChildren(0)) as $url)
{
    $url = trim($url);
    if ($url) $urls[] = $url;
}

foreach ($urls as $url)
{
    $pid = $i % 20;
    $insert[] = "('{$site_name}','{$url}',{$pid},{$mode})";
    $i++;
}

if ($insert)
{
    $sql = "INSERT IGNORE INTO `batchs` (`site_name`,`name`,`pid`,`mode`) VALUES ".implode(',', $insert);
    pdo::getPdo()->query($sql);
}*/
/*$marka_id = array('Fly' => 16, 'Alcatel' => 14);

$sql = "SELECT `id` FROM `sites` WHERE `setka_id` = 1 AND `name` LIKE '%alcatel%'";
$sites = pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_COLUMN);

$insert = array();
$insert_urls = array();

foreach ($sites as $site)
{
    $params = serialize(array('marka_id' => $marka_id['Alcatel'], 'static' => 'remont-smartfonov'));
    $insert[] = array($site, "'remont-smartfonov'", 
        "'".$params."'", tools::get_rand_dop());
}

print_r($sites);

if ($insert)
{
    foreach ($insert as $url)
        $insert_urls[] = '('.implode(',', $url).','.tools::get_time().')';           
    
    
    print_r($insert_urls);
    
    $sql = "INSERT IGNORE INTO `urls` (`site_id`,`name`,`params`,`feed`,`date`) VALUES ".implode(',', $insert_urls);
    pdo::getPdo()->query($sql);
}*/
            

/*$sql = "SELECT `setkas`.`name` as `setka_name`, `regions`.`name` as `region_name`, `markas`.`name` as `marka_name`, `phone`, `phone_yd`, `phone_ga`, 
                `sites`.`name` as `site_name` FROM `sites` 
        LEFT JOIN `setkas` ON `sites`.`setka_id` = `setkas`.`id`
        LEFT JOIN `regions` ON `sites`.`region_id` = `regions`.`id`
        LEFT JOIN `marka_to_sites` ON `marka_to_sites`.`site_id` = `sites`.`id`
        LEFT JOIN `markas` ON `marka_to_sites`.`marka_id` = `markas`.`id`";
$sites = pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
foreach ($sites as $value)
{
    echo $value['setka_name'].';'.($value['region_name'] ? $value['region_name'] : 'Москва').';'.$value['marka_name'].
            ';'.$value['site_name'].';'.       
            ';'.tools::format_phone($value['phone']).';'.
            tools::format_phone($value['phone_yd']).';'.
            tools::format_phone($value['phone_ga']).PHP_EOL;
}*/

//array(278, 279, 280, 281, 282, 283, 284)*/

/*$sql = "SELECT * FROM `fields` WHERE `table_id` = 125";
$insert = array();

foreach (array(306 => 'k_', 307 => 'r_', 308 => 'o_', 309 => 's_', 310 => 'e_', 311 => 'i_', 312 => 'h_') as $table_id => $suffics)
{
    foreach(pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_ASSOC) as $field)
    {
        if ($field['name'] !== 'id')
        {
            
            $insert[] = "(".$table_id.",'".str_replace('f_', $suffics, $field['name'])."','".$field['label']."',".$field['type_id'].','.($field['null'] ? $field['null'] : 'null').",".
                    ($field['sort'] ? $field['sort'] : 'null').")";
        }
    } 
} 

//print_r($insert);

if ($insert)
{    
    $sql = "INSERT IGNORE INTO `fields` (`table_id`,`name`,`label`,`type_id`,`null`,`sort`) VALUES ".implode(',', $insert);
    pdo::getPdo()->query($sql);
}*/

/*$sql = "SELECT `sites`.`id` FROM `sites` INNER JOIN `setkas` ON `setkas`.`id` = `sites`.`setka_id` WHERE `setkas`.`name` = 'СЦ-2'";
$site_ids = pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_COLUMN);

print_r($site_ids);

$sql = "SELECT `marka_id`, `site_id` FROM `marka_to_sites` WHERE `site_id` IN (".implode(',', $site_ids).")";
$datas = pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_ASSOC);

print_r($datas);

$mas_url = array();

foreach ($datas as $data)
{
    $key = 'politica';
    $params = serialize(array('marka_id' => $data['marka_id'], 'static' => $key));
    $mas_url[] = array($data['site_id'], "'".$key."'", 
            "'".$params."'", tools::get_rand_dop());
}

$insert_urls = array();

foreach ($mas_url as $url)
    $insert_urls[] = '('.implode(',', $url).','.tools::get_time().')';                
    
if ($insert_urls)
{
    //print_r($insert_urls);
    $sql = "INSERT IGNORE INTO `urls` (`site_id`,`name`,`params`,`feed`,`date`) VALUES ".implode(',', $insert_urls);
    pdo::getPdo()->query($sql);
}*/

/*$al = '%/#marka-%/akkumulyator
%/#marka-%/cherniy-ekran
%/#marka-%/chistka-noutbuka
%/#marka-%/chistka-plansheta
%/#marka-%/chistka-telefona
%/#marka-%/deformatsiya-korpusa
%/#marka-%/deformatsiya-kryshki
%/#marka-%/diagnostika
%/#marka-%/dinamik
%/#marka-%/displey
%/#marka-%/gps
%/#marka-%/hdmi
%/#marka-%/kamera
%/#marka-%/klaviatura
%/#marka-%/knopka-vklyucheniya
%/#marka-%/korpus
%/#marka-%/kryshka
%/#marka-%/kuler
%/#marka-%/materinskaya-plata
%/#marka-%/matritsa
%/#marka-%/mikrofon
%/#marka-%/multikontroller
%/#marka-%/nastroyka-bios
%/#marka-%/nastroyka-windows
%/#marka-%/ne-gorit-ekran
%/#marka-%/ne-rabotaet-dinamik
%/#marka-%/ne-rabotaet-gps
%/#marka-%/ne-rabotaet-hdmi
%/#marka-%/ne-rabotaet-kamera
%/#marka-%/ne-rabotaet-klaviatura
%/#marka-%/ne-rabotaet-knopka
%/#marka-%/ne-rabotaet-mikrofon
%/#marka-%/ne-rabotaet-tachpad
%/#marka-%/ne-rabotaet-tachskrin
%/#marka-%/ne-rabotaet-usb
%/#marka-%/ne-rabotaet-vibro
%/#marka-%/ne-rabotaet-wifi
%/#marka-%/net-zvuka
%/#marka-%/ne-vidit-disk
%/#marka-%/ne-vidit-sim
%/#marka-%/ne-vkluchaetsya
%/#marka-%/ne-zagruzhaetsya
%/#marka-%/ne-zaryazhaetsya
%/#marka-%/operativnaya-pamyat
%/#marka-%/peregrevaetsya
%/#marka-%/perezagruzhaetsya
%/#marka-%/razborka-noutbuka
%/#marka-%/razborka-plansheta
%/#marka-%/razborka-telefona
%/#marka-%/razryazhaetsya
%/#marka-%/razyom-pitaniya
%/#marka-%/remont-severnogo-mosta
%/#marka-%/remont-tsepi-pitaniya
%/#marka-%/seveniy-most
%/#marka-%/shleyf
%/#marka-%/shleyf-matritsy
%/#marka-%/shumit
%/#marka-%/sim-holder
%/#marka-%/siniy-ekran
%/#marka-%/tachpad
%/#marka-%/usb
%/#marka-%/ustanovka-drayverov
%/#marka-%/vibro
%/#marka-%/videokarta
%/#marka-%/vykluchaetsya
%/#marka-%/wifi
%/#marka-%/yuzhniy-most
%/#marka-%/zamena-batarei
%/#marka-%/zamena-derzhatelya-sim
%/#marka-%/zamena-dinamika
%/#marka-%/zamena-gnezda-pitaniya
%/#marka-%/zamena-hdmi
%/#marka-%/zamena-klaviatury
%/#marka-%/zamena-knopki-vklyucheniya
%/#marka-%/zamena-kulera
%/#marka-%/zamena-materinskoy-platy
%/#marka-%/zamena-matritsy
%/#marka-%/zamena-mikrofona
%/#marka-%/zamena-multikontrollera
%/#marka-%/zamena-pamyati
%/#marka-%/zamena-shleyfa
%/#marka-%/zamena-shleyfa-matritsy
%/#marka-%/zamena-tachpad
%/#marka-%/zamena-usb
%/#marka-%/zamena-vibro
%/#marka-%/zamena-videokarty
%/#marka-%/zamena-wifi
%/#marka-%/zamena-zadney-kryshki
%/#marka-%/zamena-zaryadnogo-ustroystva
%/#marka-%/zamena-zhestkogo-diska
%/#marka-%/zamena-zvukovoy-karty
%/#marka-%/zaryadnoe-ustroystvo
%/#marka-%/zhestkiy-disk
%/#marka-%/zvukovaya-karta
%/#marka-%/polosy-na-ekrane
%/#marka-%/razbit-ekran
%/#marka-%/remont-yuzhnogo-mosta
%/#marka-%/zamena-displeya
%/#marka-%/zamena-gps
%/#marka-%/zamena-kamery
%/#marka-%/zamena-korpusa';

$sql = "SELECT `sites`.`id` as `id`, `markas`.`name` as `m_name`, `sites`.`name` as `s_name` FROM `sites` 
            INNER JOIN `marka_to_sites` ON `sites`.`id` = `marka_to_sites`.`site_id` 
            INNER JOIN `markas` ON `markas`.`id` = `marka_to_sites`.`marka_id`  
        WHERE `setka_id` = 2 AND `region_id` != 22 AND `region_id` != 0";
$sites = pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_ASSOC);

foreach ($sites as $site)
{
    $allow = str_replace('#marka', mb_strtolower($site['m_name']), $al);
    $update_args = array('allow' => $allow, 'id' => $site['id']);
    
    $sql = "UPDATE `sites` SET `allow`=:allow, `ya_urls`=NULL WHERE `id`=:id";
    $stm = pdo::getPdo()->prepare($sql);
    $stm->execute($update_args);
}*/


/*$redirects = array(
'/remont-noutbukov/acer-aspire-4720g-3a1g08mi/,',
'/remont-noutbukov/acer-aspire-5333-p462g25mikk/,',
'/remont-noutbukov/acer-aspire-5552g-n954g32mnkk/,',
'/remont-noutbukov/acer-aspire-5720g-302g16mi/,',
'/remont-noutbukov/acer-aspire-5732z-433g25mi/,',
'/remont-noutbukov/acer-aspire-5738g-653g25mi/,',
'/remont-noutbukov/acer-aspire-5738pzg-434g32mn/,',
'/remont-noutbukov/acer-aspire-5738zg-424g32mn/,',
'/remont-noutbukov/acer-aspire-5738zg-442g50mnbb/,',
'/remont-noutbukov/acer-aspire-5739g-754g50mi/,',
'/remont-noutbukov/acer-aspire-5742g-383g50mnkk/,',
'/remont-noutbukov/acer-aspire-5742g-484g50mnrr/,',
'/remont-noutbukov/acer-aspire-5750g-2434g64mnbb/,',
'/remont-noutbukov/acer-aspire-5750g-2674g50mnkk/,',
'/remont-noutbukov/acer-aspire-5810tg-353g25mi/,',
'/remont-noutbukov/acer-aspire-7540g-304g25mi/,',
'/remont-noutbukov/acer-aspire-7738g-904g100bi/,',
'/remont-noutbukov/acer-aspire-7740g-624g50mn/,',
'/remont-noutbukov/acer-aspire-7750g-2434g75mnkk/,',
'/remont-noutbukov/acer-aspire-7750g-2634g75mnkk/,',
'/remont-noutbukov/acer-aspire-e1-522-12502g32mn/,',
'/remont-noutbukov/acer-aspire-e1-531-10052g32mn/,',
'/remont-noutbukov/acer-aspire-e1-531-b822g50mnks/,',
'/remont-noutbukov/acer-aspire-e1-531-b9604g50ma/,',
'/remont-noutbukov/acer-aspire-e1-570g-33216g75mn/,',
'/remont-noutbukov/acer-aspire-e1-570g-33224g50mn/,',
'/remont-noutbukov/acer-aspire-e1-570g-33224g75mn/,',
'/remont-noutbukov/acer-aspire-e1-571-33124g50mn/,',
'/remont-noutbukov/acer-aspire-e1-571g-53236g1tmn/,',
'/remont-noutbukov/acer-aspire-e1-571g-b9704g75mn/,',
'/remont-noutbukov/acer-aspire-e5-551-88q2/,',
'/remont-noutbukov/acer-aspire-e5-571g-37fy/,',
'/remont-noutbukov/acer-aspire-e5-571g-52vr/,',
'/remont-noutbukov/acer-aspire-e5-571g-56a6/,',
'/remont-noutbukov/acer-aspire-e5-572g-78m4/,',
'/remont-noutbukov/acer-aspire-e5-573g-32zc/,',
'/remont-noutbukov/acer-aspire-e5-573g-52z9/,',
'/remont-noutbukov/acer-aspire-e5-573g-p6ym/,',
'/remont-noutbukov/acer-aspire-e5-731-p7u9/,',
'/remont-noutbukov/acer-aspire-es1-512-p65g/,',
'/remont-noutbukov/acer-aspire-es1-731g-p15k/,',
'/remont-noutbukov/acer-aspire-ethos-8951g-267161-5twnkk/,',
'/remont-noutbukov/acer-aspire-one-ao532h-28sw/,',
'/remont-noutbukov/acer-aspire-one-ao721-12b8rr/,',
'/remont-noutbukov/acer-aspire-one-ao722-c6crr/,',
'/remont-noutbukov/acer-aspire-one-ao752-741gkk/,',
'/remont-noutbukov/acer-aspire-one-ao753-u341ss/,',
'/remont-noutbukov/acer-aspire-one-aod257-n57cws/,',
'/remont-noutbukov/acer-aspire-one-aod270-268bb/,',
'/remont-noutbukov/acer-aspire-one-happy-aohappy2-n578qb2b/,',
'/remont-noutbukov/acer-aspire-timelinex-1830t-33u2g25ik/,',
'/remont-noutbukov/acer-aspire-timelinex-3820t-333g32n/,',
'/remont-noutbukov/acer-aspire-timelinex-3820tg-434g32i/,',
'/remont-noutbukov/acer-aspire-timelinex-3830t-2334g50nbb/,',
'/remont-noutbukov/acer-aspire-v3-371-52pk/,',
'/remont-noutbukov/acer-aspire-v3-571g-32376g75makk/,',
'/remont-noutbukov/acer-aspire-v3-572-51tr/,',
'/remont-noutbukov/acer-aspire-v3-574g-35pf/,',
'/remont-noutbukov/acer-aspire-v3-771g-32354g50makk/,',
'/remont-noutbukov/acer-aspire-v5-472g-53334g50a/,',
'/remont-noutbukov/acer-aspire-v5-572g-33226g50a/,',
'/remont-noutbukov/acer-aspire-v5-573g-54208g50a/,',
'/remont-noutbukov/acer-aspire-v5-573g-74506g50a/,',
'/remont-noutbukov/acer-aspire-v7-482pg-54206g50t/,',
'/remont-noutbukov/acer-aspire-v7-482pg-74508g52t/,',
'/remont-noutbukov/acer-aspire-v7-582pg-54208g52t/,',
'/remont-noutbukov/acer-aspire-vn7-591g-72ru/,',
'/remont-noutbukov/acer-cb3-111-c8ub/,',
'/remont-noutbukov/acer-travelmate-5740-434g32mi/,',
'/remont-noutbukov/acer-travelmate-5760g-2414g50mnbk/,',
'/remont-noutbukov/acer-travelmate-5760g-2454g50mnsk/,',
'/remont-noutbukov/acer-travelmate-7750-32314g50mnss/,',
'/remont-noutbukov/acer-travelmate-7750g-2354g32mnss/,',
'/remont-noutbukov/acer-travelmate-p253-mg-20204g50mn/,',
'/remont-noutbukov/acer-travelmate-p273-mg-32344g75mn/,',
'/remont-noutbukov/acer-travelmate-p453-mg-33124g50ma/,',
);

foreach ($redirects as $key => $value)
{
  $redirects[$key] = mb_substr($value, 1, -2);
}

foreach ($redirects as $value)
{
  $sql = "SELECT * FROM `urls` WHERE `name` = '{$value}' AND `site_id` = 15";
  $result = pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
  if (!$result)
  {
    echo $value.';404'.PHP_EOL;
  }
  else
  {
    echo $value.';200'.PHP_EOL;
  }   
}


/*$sql = "DELETE FROM `urls` WHERE `params` LIKE '%\"model_type_id\";a%'";
//echo $sql;
$sites = pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_ASSOC);

print_r($sites);*/

/*$sites_array = array(
'acer.russia.expert'=>'acer.ruservicecenters.com',
'alcatel-russia.com'=>'alcatel.ruservicecenters.com',
'apple.russia.expert'=>'apple.ruservicecenters.com',
'asus-russia.ru'=>'asus.ruservicecenters.com',
'canon-russia.com'=>'canon.ruservicecenters.com',
'notebook-russia.com'=>'dell.ruservicecenters.com',
'fly-russia.com'=>'fly.ruservicecenters.com',
'hp-russia.pro'=>'hp.ruservicecenters.com',
'htcrussia.com'=>'htc.ruservicecenters.com',
'huawei.russia.expert'=>'huawei.ruservicecenters.com',
'lenovo-russia.ru'=>'lenovo.ruservicecenters.com',
'lg-russia.ru'=>'lg.ruservicecenters.com',
'meizu.russia.expert'=>'meizu.ruservicecenters.com',
'msi.russia.expert'=>'msi.ruservicecenters.com',
'foto.russia.expert'=>'nikon.ruservicecenters.com',
'nokia-russia.com'=>'nokia.ruservicecenters.com',
'moskva-servis.com'=>'samsung.ruservicecenters.com',
'sony-russia.com'=>'sony.ruservicecenters.com',
'toshiba.russia.expert'=>'toshiba.ruservicecenters.com',
'xiaomi.russia.expert'=>'xiaomi.ruservicecenters.com',
'zte.russia.expert'=>'zte.ruservicecenters.com',
);



/*$sql = "SELECT * FROM `sites` WHERE `name` IN ('".implode("','", array_keys($sites_array))."')";
$sites = pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_ASSOC);

//echo $sql;

$t = array();
foreach ($sites as $site)
    $t[$site['name']] = $site;
    
$sites = $t;

//print_r($sites);

foreach ($sites_array as $key => $site)
{
   $mas = $sites[$key];
   
   $sql = "INSERT INTO `sites` (`setka_id`, `name`, `phone`, `phone_yd`, `phone_ga`, `phone_yd_rs`, `partner_id`,`timestamp`)
            VALUES (1,'".$site."','".$mas['phone']."','".$mas['phone_yd']."','".$mas['phone_ga']."','".
                    $mas['phone_yd_rs']."',".$mas['partner_id'].",".tools::get_time().")".PHP_EOL;
                    
   echo $sql;
   
   pdo::getPdo()->query($sql);
            
   //   $sites = pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_ASSOC); 
}*/


/*$sql = "SELECT `name`,`id` FROM `markas`";
$brands = pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_KEY_PAIR);
 
 $t = array();
 foreach ($brands as $key => $value)
    $t[mb_strtolower($key)] =  $value;
    
    $brands = $t;
    
 print_r($brands);
 $sites_array = array_values($sites_array);
$j = 0;
  for ($i = 5010; $i<=5030; $i++)
  {
    $ex = explode('.', $sites_array[$j]);
    
    $ar = serialize(array('marka_id' => $brands[$ex[0]], 'static' => '/'));
    $sql = "INSERT INTO `urls` (`site_id`, `name`, `params`,`date`,`feed`) VALUES (".$i.",'/','".$ar."',".tools::get_time().",".rand().")";
    echo $sql;
    
    $j++; 
    pdo::getPdo()->query($sql);
  }*/
  
  

  

/*$sql = "SELECT `id` FROM `sites` WHERE `id` > 5031";
$sites = pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_COLUMN);

//print_r($sites);

foreach ($sites as $site_id)
{
    $add_condition = " AND `m_models`.`brand` = 1";
    
    $sql = "SELECT `m_models`.`id` FROM `m_models`
            INNER JOIN `markas` ON `markas`.`id` = `m_models`.`marka_id`
            INNER JOIN `marka_to_sites` ON `markas`.`id` = `marka_to_sites`.`marka_id`
                WHERE `site_id`=:site_id".$add_condition;
    
    $stm = pdo::getPdo()->prepare($sql);
    $stm->execute(array('site_id' => $site_id));
    $m_models = $stm->fetchAll(\PDO::FETCH_COLUMN);    
    
    if ($m_models)
    {
        $sql = "SELECT `models`.`id` FROM `models` WHERE `m_model_id` IN (".implode(',', $m_models).")";
        $models = pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_COLUMN);

        foreach ($models as $model)
        {
            $args = array('model_id' => $model, 'site_id' => $site_id);
            $gen = new gen_model($model, $site_id);
            
            $gen->genUrls();
        }
    }
}*/

/*$insert = [];
$insert2 = [];

$str = 'acer.ruservicecenters.com
alcatel.ruservicecenters.com
apple.ruservicecenters.com
asus.ruservicecenters.com
canon.ruservicecenters.com
dell.ruservicecenters.com
fly.ruservicecenters.com
hp.ruservicecenters.com
htc.ruservicecenters.com
huawei.ruservicecenters.com
lenovo.ruservicecenters.com
lg.ruservicecenters.com
meizu.ruservicecenters.com
msi.ruservicecenters.com
nikon.ruservicecenters.com
nokia.ruservicecenters.com
samsung.ruservicecenters.com
sony.ruservicecenters.com
toshiba.ruservicecenters.com
xiaomi.ruservicecenters.com
zte.ruservicecenters.com';

$brands = '1;sony.ruservicecenters.com
2;samsung.ruservicecenters.com
3;asus.ruservicecenters.com
4;acer.ruservicecenters.com
5;lenovo.ruservicecenters.com
6;hp.ruservicecenters.com
7;toshiba.ruservicecenters.com
8;msi.ruservicecenters.com
9;dell.ruservicecenters.com
10;htc.ruservicecenters.com
11;nokia.ruservicecenters.com
12;lg.ruservicecenters.com
14;alcatel.ruservicecenters.com
16;fly.ruservicecenters.com
17;huawei.ruservicecenters.com
18;xiaomi.ruservicecenters.com
20;meizu.ruservicecenters.com
21;apple.ruservicecenters.com
22;nikon.ruservicecenters.com
23;canon.ruservicecenters.com
66;zte.ruservicecenters.com';

$t = [];
$brands = explode(PHP_EOL, $brands);
foreach ($brands as $brand)
{
    if ($brand)
    {
        $cols = explode(';', $brand);
        $t[trim($cols[1])] = trim($cols[0]);
    }
}

$brands = $t;

$phones = '74950325406
74950325407
74950325408
74950325409
74950325410
74950325411
74950325407
74950325412
74950325413
74950325414
74950325415
74950325416
74950325417
74950325418
74950325419
74950325420
74950325431
74950325432
74950325433
74950325434
74950325407
74950325435
74950325436
74950325437
74950325438
74950325439
74950325440
74950325436
74950325441
74950325442
74950325443
74950325446
74950325447
74950325448
74950325449
74950325450
74950325451
74950325452
74950325456
74950325457
74950325458
74950325436';

$rows = explode(PHP_EOL, $str);
$phones = explode(PHP_EOL, $phones);

$i = 0;
$site_id = 8172;

foreach ($rows as $row)
{
    $row = trim($row);
    if ($row)
    {
        $insert[] = "('".$row."',9,'".$phones[$i]."','".$phones[$i + 21]."',0,329,".tools::get_time().",1)";
        
        $ar = serialize(array('marka_id' => $brands[$row], 'static' => '/'));
        
        $insert2[] = "(".$site_id.",'/','".$ar."',".tools::get_time().",".rand().")";
        
        $site_id++;
        $i++;
    }
}

print_r($insert);
print_r($insert2);

$sql = "INSERT INTO `sites` (`name`, `setka_id`, `phone`, `phone_yd`, `region_id`, `partner_id`, `timestamp`, `robots`) VALUES ".implode(',', $insert);
echo $sql.PHP_EOL;
pdo::getPdo()->query($sql);

$sql = "INSERT INTO `urls` (`site_id`, `name`, `params`, `date`, `feed`) VALUES ".implode(',', $insert2);
echo $sql.PHP_EOL;
pdo::getPdo()->query($sql);*/
 
?>