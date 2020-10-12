<?

header('Content-Type: text/html; charset=utf-8');

function get_url($url, $multicurl = false)
{ 
    $ch = curl_init($url);
    
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
   
    $data = curl_exec($ch);
    //print_r($data);

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

function get_divs($divs)
{
    foreach ($divs as $div)
    {
        if ($class = $div->attributes->getNamedItem('class'))
        { 
            if ($class->value == "PageInner")
            {
                foreach ($div->getElementsByTagName('div') as $divas)
                {
                    if ($class2 = $divas->attributes->getNamedItem('class'))
                    { 
                        if ($class2->value == "LeftPart")
                        {
                            return $divas;
                        }
                    }
                }
            }
        }
    }
}

function get_links($links)
{
    $return = array();
    
    foreach ($links as $link)
    {
        $name = trim($link->nodeValue);
        $link = $link->getAttribute('href');
      
        $return[] = $link;
    }
    
    return $return;
}

$divs = parse_dom(get_url('http://samsung.russia-service.com/karta-sayta'), 'div', 'get_divs'); //!!
$links = get_links($divs->getElementsByTagName('a'));
//print_r($links);
foreach ($links as $link)
{   
   $array =  array();
   
   if (mb_strpos($link, 'http://samsung.russia-service.com') === false)
        $link = 'http://samsung.russia-service.com'.$link;
    
   $ch = curl_init($link);
    
   curl_setopt($ch, CURLOPT_HEADER, 0);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
   curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
   
   $data = curl_exec($ch);
   
   preg_match('|(<title>)(.*)(</title>)|s', $data, $array); 
   echo curl_getinfo($ch, CURLINFO_EFFECTIVE_URL).';'.$array[2].';'.((mb_strpos($array[2], 'руб') !== false) ? '1' : '0').PHP_EOL;  
   
   curl_close($ch);
} 
   
?>