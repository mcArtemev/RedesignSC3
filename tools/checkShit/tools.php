<?php

class tools {

    public static function checkCode($urls)
    {
      $chs = [];
      $multi = curl_multi_init();
      $res = [];

      foreach ($urls as $k => $url) {
        $url = explode(" ", $url);
        $ch = curl_init();
        //echo $url[1];
        curl_setopt($ch, CURLOPT_URL, $url[1]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, true);

        curl_multi_add_handle($multi, $ch);

        $chs[$k] = [$url[0], $ch];
      }

      $running = NULL;
        do {
            curl_multi_exec($multi,$running);
        } while ($running > 0);

      foreach ($chs as $k => $ch) {
          $info = curl_getinfo($ch[1]);
          $res[$k] = [$ch[0], $info['http_code']];
          curl_multi_remove_handle($multi, $ch[1]);
      }

      curl_multi_close($multi);

      return $res;
   }
}

?>
