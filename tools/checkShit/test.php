<?php

$urls = array(
    'http://graph.facebook.com/http://tech.vg.no',
    'http://graph.facebook.com/http://www.vg.no',
);

$multi = curl_multi_init();
$channels = array();

foreach ($urls as $url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    curl_multi_add_handle($multi, $ch);

    $channels[$url] = $ch;
}

$active = null;
do {
    $mrc = curl_multi_exec($mh, $active);
} while ($mrc == CURLM_CALL_MULTI_PERFORM);

while ($active && $mrc == CURLM_OK) {
    if (curl_multi_select($mh) != -1) {
        do {
            $mrc = curl_multi_exec($mh, $active);
        } while ($mrc == CURLM_CALL_MULTI_PERFORM);
    }
}

foreach ($channels as $channel) {
    echo curl_multi_getcontent($channel);
    curl_multi_remove_handle($multi, $channel);
}

curl_multi_close($multi);
?>
