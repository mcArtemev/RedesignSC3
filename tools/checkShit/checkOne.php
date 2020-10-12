<?php

require __DIR__.'/tools.php';

$array = file_get_contents(__DIR__ . '/common/url');
$urls = explode("\r\n", $array);
$urlsCon = array_slice($urls, 0, 20);
if (count($urlsCon) && $urlsCon[0] != '')
{
    $res = $res2 = '';
        foreach (tools::checkCode($urlsCon) as $k => $urlRes) {
          unset($urls[$k]);
          if ($urlRes[1] == "200")
            $res .= $urlRes[0].(count($urls) > 0 ? "\r\n" : "");
          else
            $res2 .= $urlRes[0].(count($urls) > 0 ? "\r\n" : "");
        }
        file_put_contents(__DIR__ . '/common/shitDomains.txt', $res, FILE_APPEND | LOCK_EX);
        file_put_contents(__DIR__ . '/common/goodDomains.txt', $res2, FILE_APPEND | LOCK_EX);
        file_put_contents(__DIR__ . '/common/url', implode("\r\n", $urls));
        exec("php ".__DIR__."/checkOne.php > /dev/null &", $output, $return_var);
}
else
{
    file_put_contents(__DIR__ . '/common/status', '2');
}

?>
