<?

/*spl_autoload_extensions('.php');
spl_autoload_register();

define('FILE_PATH', '/var/www/www-root/data/www/studiof1-test.ru/webmaster');

use framework\pdo;
use framework\tools;

function getIndexing($file_name)
{
    $buffer_size = 4096; 
    $out_file_name = str_replace('.gz', '', $file_name);
    
    $file = gzopen($file_name, 'rb');
    $out_file = fopen($out_file_name, 'wb');
    
    while (!gzeof($file)) {
        fwrite($out_file, gzread($file, $buffer_size));
    }
    
    fclose($out_file);
    gzclose($file);
    
    $array = file($out_file_name);
    
    $a = array();
    
    foreach ($array as $item) 
    {
        if (trim($item)) 
        {
            $arr = explode("\t", $item);
            
            if (count($arr) > 3)
            {
                if ($arr[1] == "200" && $arr[3] == "1") 
                {
                    if (($pos = mb_strpos($arr[0], "/", mb_strlen('https://'))) !== false)
                    {
                        $stroka = mb_substr($arr[0], $pos + 1);
                        
                        if (!$stroka)
                            $a[] = "/";  
                        else
                        {
                            if (mb_substr($stroka, -1, 1) == '/')
                                $stroka = mb_substr($stroka, 0, -1);
                                
                            $a[] = $stroka;
                        }
                    }    
                    else
                        $a[] = "/";
                }
            }
        }
    }
    
    return implode("\n", $a);
}

function parse_dom($html, $tag, $func)
{
    $dom = new DOMDocument;
    libxml_use_internal_errors(true);
    $dom->loadHTML($html);
    $element = $dom->getElementsByTagName($tag);
    return $func($element);
}

function get_link($links)
{
    $t = '';
    
    foreach ($links as $link)
    {
        if ($class = $link->attributes->getNamedItem('class'))
        { 
            if (mb_strpos($class->value, "archive-link") !== false)
            {
                $t = $link->getAttribute('href');
                break;   
            }            
            
        }        
    }
        
    return $t;
}

/*$sql = "SELECT `value` FROM `customs` WHERE `code` = 'webmaster'";
$webmaster = (integer) pdo::getPdo()->query($sql)->fetchColumn();

list($h, $i, $s, $n, $j, $Y) = array(date("H"),date("i"),date("s"),date("n"),date("j"),date("Y"));

$date_start = mktime(0, 0, 0, $n, $j, $Y);
$date_end = mktime($h, $i, $s, $n, $j, $Y);

$minuts = floor(($date_end - $date_start) / 60);

//if ($minuts % 18 != 0) exit();
if ((integer) ($minuts / 18) != $webmaster) exit();

$files = glob(FILE_PATH.'/*'); 
foreach($files as $file)
{
    if(is_file($file))
        unlink($file);
}*/

/*$setkas_cookie = array(
    //'СЦ-1' => 'yandexuid=7016644221489417373; isPromoSeen=true; _ym_uid=1489417285693359993; _ym_isad=2; Session_id=3:1489417382.5.0.1489417382543:4tZFUw:52.0|312804426.0.2|160206.532756.gE4gZuR3yWNn20IDW4MMXD6BQvg; sessionid2=3:1489417382.5.0.1489417382543:4tZFUw:52.1|312804426.0.2|160206.620611.5UOHjhd65kxbNuMkBgm_R8kaS6I; yp=1804777382.udn.cDpzb255LXJ1c3NpYQ%3D%3D; ys=udn.cDpzb255LXJ1c3NpYQ%3D%3D; L=CW1RYGkBWVFjRWFkcwdEeQVMbENOel4GGw4JM18VIQkZMA8=.1489417382.13007.394141.b78f720042352c035a9e0355b9a4fb05; yandex_login=sony-russia', 
    //'СЦ-2' => 'yandexuid=7016644221489417373; isPromoSeen=true; _ym_uid=1489417285693359993; _ym_isad=2; _ym_visorc_784657=b; Session_id=3:1489418207.5.1.1489417382543:4tZFUw:52.0|312804426.0.2|378709124.825.2.2:825|160206.932868.bOP1luAW5iThMEJp3rkKo9_AYuk; sessionid2=3:1489418207.5.0.1489417382543:4tZFUw:52.1|312804426.0.2|378709124.825.2.2:825|160206.536876.FA0WcUsGcvzhPhZtAc7lmyH5zuk; yp=1804778207.udn.cDpzb255LWNlbnRyZS5jb20%3D#1804778207.multib.1; ys=udn.cDpzb255LWNlbnRyZS5jb20%3D; L=CW1RYGkHU15jSGRkcQBAeQBNZ0dDelQDGw4JM18EMRQeKwtZASoo.1489418207.13007.345735.cead57a457df42845be2cc8c0c81cacb; yandex_login=sony-centre.com',
    'СЦ-3' => 'yandexuid=3245968731501687274; yandex_gid=213; _ym_uid=1503056707311744355; mda=0; yabs-frequency=/4/0000000000000000/bagmS8Wh89XAi728Ao6ATd9mY2id/; zm=m-white_bender_media.webp.css-https-www%3Awww_Y4hNQgetvrmrFb4OCsi6dnr_WNg%3Al; fuid01=5996d352768e7387.JA8J1XduJVm9imS4a9vKz0KiUg9NVcuckj2xb89eeP-DuypHjlWeVtMITtVv6-3khtRlGVt8DzWbIxl5cWW-dx7uokwyYy-jBARCcl0-T_oH-ZapalQ5V1NXk9lcPy0j; yp=1505648703.ygu.1#1504266308.ysl.1#1518824709.szm.1_00%3A1920x1080%3A1920x974#1818416790.udn.cDpydXNzaWEtc2Ftc3VuZw%3D%3D; L=cm8Cc1pdcQNzWVsJAEJmAAB0R1ZaeVR9ATccFQNVeTEWXAQQXi8=.1503056790.13218.353351.425b4849ab84b20cc26bc2268e794959; i=3WjcQb1C6sC6CfUoxiKYSU0jEtDZUI4XQMouPnL84fSrZh0iGayP0IYZfsdbzJog1d0JxZ2GyYInPB7jvfQIDhFecmU=; Session_id=3:1503495543.5.0.1503056790108:Jr54bQ:22.1|353196701.0.2|168571.354260.61TBEO-EG1uzoSGcWZbh97PT9Qs; sessionid2=3:1503495543.5.0.1503056790108:Jr54bQ:22.1|353196701.0.2|168571.930009.GEJuv22y6aHUMEDHNNKM9SSX4ZY; yandex_login=russia-samsung; isPromoSeen=true; _ym_isad=2',
    //'СЦ-5' => 'yandexuid=7016644221489417373; isPromoSeen=true; _ym_uid=1489417285693359993; _ym_isad=2; _ym_visorc_784657=b; Session_id=3:1489418330.5.3.1489417382543:4tZFUw:52.0|312804426.0.2|378709124.825.2.2:825|353196701.891.2.2:891|406761557.948.2.2:948|160206.856075.7BUSM8ukt2dpuCj672VuvX74OVc; sessionid2=3:1489418330.5.0.1489417382543:4tZFUw:52.1|312804426.0.2|378709124.825.2.2:825|353196701.891.2.2:891|406761557.948.2.2:948|160206.926319.a7XW9TAiUgemDOiXm4GWvHjTzfk; yp=1804778330.udn.cDpyZW1vbnQtY2VudHJl#1804778207.multib.1; ys=udn.cDpyZW1vbnQtY2VudHJl; L=CW1RYG4AXV5lQGBjcgRAeQhOZ0RJd18FGgQKJRwTeRkPNxoFBw==.1489418330.13007.3577.7b93c513cf60ad485c41f963816adcc2; yandex_login=remont-centre', 
); 

/*$sql = "SELECT `setkas`.`name` FROM `sites` 
            INNER JOIN `setkas` ON `setkas`.`id` = `sites`.`setka_id` ORDER BY `sites`.`timestamp` DESC LIMIT 0,1";
$last_setka = pdo::getPdo()->query($sql)->fetchColumn();

$setkas = array_keys($setkas_cookie);
unset($setkas[array_search($last_setka ,$setkas)]);
$setkas = array_values($setkas);*/

//$count = 0;

//$setka_key = $setkas[rand(0, count($setkas) - 1)];

/*$setka_key = 'СЦ-3';

$sql = "SELECT `sites`.`name` as `site_name`, `sites`.`id` as `site_id`, `setkas`.`https` as `https` 
            FROM `sites` 
        INNER JOIN `setkas` ON `setkas`.`id` = `sites`.`setka_id` WHERE (`setkas`.`name` = '".$setka_key."')";

$sites = pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_ASSOC);

$cmh = curl_multi_init(); 

$ch = array();
$file_names = array();
$site_ids = array();
$i = 0;
$active = null;    

foreach ($sites as $site)
{
    $url = 'https://webmaster.yandex.ru/site/'.(($site['https']) ? 'https' : 'http').':'.$site['site_name'].':'.(($site['https']) ? '443' : '80').'/indexing/indexing/';
    //echo $url;
    
    $ch[$i] = curl_init($url);

	curl_setopt($ch[$i], CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch[$i], CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch[$i], CURLOPT_HEADER, 0);
    
    curl_setopt($ch[$i], CURLOPT_HTTPHEADER, array(   
        'Cookie: '.$setkas_cookie[$setka_key],    
        'Host: webmaster.yandex.ru'));
    
    curl_setopt($ch[$i], CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch[$i], CURLOPT_SSL_VERIFYHOST, 0); 

	curl_multi_add_handle($cmh, $ch[$i]);  
    
    $file_names[] = FILE_PATH.'/'.$site['site_name'].'.tsv.gz';
    $site_ids[] = $site['site_id'];
    
    $i++;   
}

do { curl_multi_exec($cmh, $active); } while ($active);

$links = array();

for ($i=0; $i<count($ch); $i++)
{
    $content = curl_multi_getcontent($ch[$i]);
    //echo $content;
    $links[] = parse_dom($content, 'a', 'get_link'); 
        
    curl_multi_remove_handle($cmh, $ch[$i]);
    curl_close($ch[$i]);
}

print_r($links); 

/*$ch = array();
$f = array();
$i = 0;
$active = null;

foreach ($links as $link)
{
    if ($link) 
    {
        $ch[$i] = curl_init($link);
        
        $f[$i] = fopen($file_names[$i], 'w');
        
       	curl_setopt($ch[$i], CURLOPT_FOLLOWLOCATION, 1);
        
        curl_setopt($ch[$i], CURLOPT_HTTPHEADER, array(   
                'Cookie: '.$setkas_cookie[$setka_key],    
                'Host: webmaster.yandex.ru'));
                
        curl_setopt($ch[$i], CURLOPT_FILE, $f[$i]); 
        
        curl_setopt($ch[$i], CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch[$i], CURLOPT_SSL_VERIFYHOST, 0); 
        
        curl_multi_add_handle($cmh, $ch[$i]); 
    }
    else
        $ch[$i] = false;
        
    $i++;
}

do { curl_multi_exec($cmh, $active); } while ($active);

for ($i=0; $i<count($ch); $i++)
{
    if ($ch[$i])
    {
        curl_multi_getcontent($ch[$i]); 
        curl_multi_remove_handle($cmh, $ch[$i]);
        curl_close($ch[$i]);
        fclose($f[$i]);
    }
}

curl_multi_close($cmh);

for ($i=0; $i<count($file_names); $i++)
{
    if (file_exists($file_names[$i]))
    {
        $ya_urls = getIndexing($file_names[$i]);
                
        if ($ya_urls)
        {
            $sql_args = array('id' => $site_ids[$i], 'ya_urls' => $ya_urls, 'timestamp' => tools::get_time());
            
            //print_r($sql_args);
            $count = $count + count(explode("\n", $ya_urls));

            $sql = "UPDATE `sites` SET ".pdo::prepare($sql_args)." WHERE `id`=:id";
            $stm = pdo::getPdo()->prepare($sql);
            $stm->execute($sql_args);
        }
    }
}

//echo $count;

$sql = "UPDATE `customs` SET `value` = '".rand(1, 79)."' WHERE `code` = 'webmaster'";
pdo::getPdo()->query($sql);*/

?>