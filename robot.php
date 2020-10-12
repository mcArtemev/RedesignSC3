<?

header('Content-Type: text/html; charset=utf-8');
spl_autoload_extensions('.php');
spl_autoload_register();

use framework\pdo;

//$host = 'http://www.servicebox.ru/moresvc.php?city=&cat=&man=&sprivate=&auth=&metrost=&page=20';
//$host = 'https://autoreshenie.ru/pereborka-benzinovogo-dvigatelya-jaguar-v-cao-750/';
//$host = 'https://webmaster.yandex.ru/site/http:asus-moscow.com:80/indexing/indexing/';
$host = 'http://sony-russia.com';

function get_url($url = "")
{
    global $host;
    if ($url) $url = $url."/";
    
    //$ch = curl_init("http://{$host}/".$url);
    //$ch = curl_init($url);
    $ch = curl_init($host."/".$url);
    
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    
    //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    //curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); 
        
    //curl_setopt($ch, CURLOPT_HTTPHEADER, array(   
        //'Cookie: Session_id=3:1486483668.5.4.1485181078010:vQMXUQ:86.0|312804426.0.2|406761557.67656.2.2:67656|426437000.843443.2.2:843443|437002651.851325.2.2:851325|353196701.860197.2.2:860197|158578.677703.K97Ur9hKmKiCD0IHCdRs11xrTNA; sessionid2=3:1486483668.5.0.1485181078010:vQMXUQ:86.1|312804426.0.2|406761557.67656.2.2:67656|426437000.843443.2.2:843443|437002651.851325.2.2:851325|353196701.860197.2.2:860197|158578.108013.rAR0B-iVR_SQtR6Zn17TpPamlFg;',    
        //'Host: webmaster.yandex.ru'));
    
    $data = curl_exec($ch);

    curl_close($ch);
    return $data;
}

function parse_dom($html, $tag, $func)
{
    $dom = new DOMDocument;
    libxml_use_internal_errors(true);
    $dom->loadHTML($html);
    $element = $dom->getElementsByTagName($tag);
    return $func($element);
}

function get_links($links)
{
    //global $host;
    $return = array();
    //$return2 = array();
    
    foreach ($links as $link)
    {
        $name = trim($link->nodeValue);
        //if (mb_strpos($name, "Samsung") !== false)
        //{
            $link = $link->getAttribute('href');
            //$return1[] = str_replace('http://'.$host.'/', '', mb_substr($link, 0, -1));
            //$return2[] = mb_substr($name, 7);
            $return[] = $link;
        //}
    }
        
    //return array($return1, $return2);
    return $return;
}

/*function get_img($divs)
{
    global $host;
    $img_str = "";
       
    foreach ($divs as $div)
    {
        if ($class = $div->attributes->getNamedItem('class'))
        { 
            if ($class->value == "ImgLeft")
            {
                $img = $div->getElementsByTagName('img');
                if ($img->length > 0) 
                {
                    $img_str = str_replace('http://'.$host.'/', '', $img[0]->getAttribute('src'));
                    break;
                }
            }
         }
    }
    
    return $img_str;
}

$auth = false;
         
if (isset($_COOKIE["AUTH"]))
{
    $sql = "SELECT `id` FROM `users` WHERE `id`=:id";
    $stm = pdo::getPdo()->prepare($sql);
    $stm->execute(array('id' => base64_decode($_COOKIE["AUTH"])));
    if ($stm->fetchColumn())
        $auth = true;
}

if (!$auth) exit();*/

$links = parse_dom(get_url('karta-sayta'), 'a', 'get_links');

foreach ($links as $link)
{
   echo $link.PHP_EOL;    
}

/*$imgs = array();
$i = 0;

foreach ($links[0] as $link)
{
    //if ($i > 20) break;
    $imgs[$link] = array(parse_dom(get_url($link), 'div', 'get_img'), $links[1][$i]);
    
    $i++;
}

foreach ($imgs as $key => $img)
    echo $key.';'.$img[0].';'.$img[1].PHP_EOL;*/

//print_r(get_url());
    
?>