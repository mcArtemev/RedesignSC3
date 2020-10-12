<?php

require 'GoogleClass.php';
$googl = new Googl('AIzaSyA2WIMZzeAicPlQnG8yYRXrnRJO9ZwfznM');

$urls = explode("\r\n", file_get_contents(__DIR__."/common/urls"));

$urlsCon = array_slice($urls, 0, 20);

if (count($urlsCon) && $urlsCon[0] != '') {
  $shorten = "";
  foreach ($urlsCon as $i => $url) {
    unset($urls[$i]);
    $sh = $googl->shorten($url);
    if (is_null($sh) || $sh == '') {
      file_put_contents(__DIR__ . '/common/status', '3');
      exit;
    }
    $shorten .= $url." ".$sh.(count($urls) > 0 ? "\r\n" : '');
  }
  file_put_contents(__DIR__ . '/common/shorten.txt', $shorten, FILE_APPEND | LOCK_EX);
  file_put_contents(__DIR__ . '/common/urls', implode("\r\n", $urls));
  exec("php ".__DIR__."/genOne.php > /dev/null &", $output, $return_var);
}
else
  file_put_contents(__DIR__ . '/common/status', '2');





?>
