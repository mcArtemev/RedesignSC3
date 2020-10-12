<?php

class UisCallApi
{

  const TOKEN = 'nrrrwtvr3ds8kx1a9b7tzw7b9';
  const VER = '4.0';

  public function callMethod($method, $params = []) {
    $json = [
      'jsonrpc' => '2.0',
      'id' => 347458,
      'method' => $method,
      'params' => $params
    ];
    $json['params']['access_token'] = self::TOKEN;

    $request_json = mb_convert_encoding(json_encode($json), 'UTF-8');

    $ch = curl_init();
    curl_setopt_array($ch,
        array(CURLOPT_URL => 'https://callapi.uiscom.ru/v'.self::VER, CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $request_json, CURLOPT_RETURNTRANSFER => 1, CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_SSL_VERIFYHOST => 0, CURLOPT_HTTPHEADER => array(
                            'Accept: application/json',
                            'Connection: close',
                            'Content-Type: application/json; charset=UTF-8',
                            'Content-Length: '.mb_strlen($request_json))));

    $response = curl_exec($ch);
    $response = json_decode($response, true);
    return $response;
  }

}
