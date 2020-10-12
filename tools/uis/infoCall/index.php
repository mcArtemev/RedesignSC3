<?php

if (isset($_POST['submit'])) {
  $phones = preg_replace('/(\+|\(|\))/', '', ereg_replace("\n", PHP_EOL, $_POST['phones']));
  $message = $_POST['message'];

  file_put_contents(__DIR__.'/phones.txt', $phones);
  file_put_contents(__DIR__.'/message.txt', $message);

  echo 'Данные изменены!';
  exit;
}

if (isset($argv)) {

  $phones = trim(file_get_contents(__DIR__.'/phones.txt'));
  if ($phones == '') {
    exit;
  }

  $phones = explode(PHP_EOL, $phones);
  $message = file_get_contents(__DIR__.'/message.txt');

  shuffle($phones);
  $phone = trim($phones[0]);

  if (strlen($phone) != 11) {
    $error = 'error phone';
  }

  $result = date('d.m.Y G:i:s').' | '.$phone.' - ';

  if (!isset($error)) {

    require_once __DIR__.'/../UisCallApi.php';
    $uisCA = new UisCallApi();

    $res = $uisCA->callMethod('start.informer_call', [
      'virtual_phone_number' => '74951045666',
      'contact' => $phone,
      'contact_message' => [
        'type' => 'tts',
        'value' => $message,
      ],
    ]);

    if (isset($res['error']))
      $result .= 'ОШИБКА '.$res['error']['code'].' (код '.$res['error']['code'].')';
    else
      $result .= 'УСПЕШНО (session_id - '.$res['result']['data']['call_session_id'].')';

  }
  else {
    $resilt .= 'ОШИБКА - '.$error;
  }

  unset($phones[0]);

  file_put_contents(__DIR__.'/phones.txt', implode(PHP_EOL, $phones));
  file_put_contents(__DIR__.'/call.log', $result.PHP_EOL, FILE_APPEND);

  exit;

}

?>

<form method = "POST">
  <p><textarea name = "phones" placeholder = "Телефоны по одному на строку" rows = "10" cols = "50"></textarea></p>
  <p><textarea name = "message" placeholder = "Сообщение" rows = "15" cols = "50"></textarea></p>
  <p><input type = "submit" name = "submit" value = "Добавить"></p>
</form>
