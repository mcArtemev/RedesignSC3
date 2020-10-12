<?php
$sc3_dbname = $_ENV['CFG_DATA']['db']['sc3']['db_name'];
$sc3_login = $_ENV['CFG_DATA']['db']['sc3']['sc3-user']['user'];
$sc3_pass = $_ENV['CFG_DATA']['db']['sc3']['sc3-user']['pass'];

$dbh2 = new \PDO('mysql:host=localhost;dbname='.$sc3_dbname.';charset=UTF8', $sc3_login, $sc3_pass);

function csvToArray($str, $countMin = 1) {

  $rows = explode("\r\n", $str);
  $arr = [];

  foreach ($rows as $row) {
    if (trim($row) != '') {
      $item = explode(";", trim($row));
      if (count($item) >= $countMin)
        $arr[] = $item;
    }
  }

  return $arr;
}

$mms = csvToArray(file_get_contents('frequency/mms.csv'));

$stmt = $dbh2->prepare("UPDATE m_models SET frequency = ? WHERE id = ?");
$stmt2 = $dbh2->prepare("UPDATE models SET frequency = ? WHERE id = ?");

try {
  $dbh2->beginTransaction();

  foreach ($mms as $mm) {
    if (trim($mm[5]) != '') {
      $stmt->execute([(int)trim($mm[5]), (int)trim($mm[1])]);
      if ($dbh2->errorInfo()[0] != '00000') {
       throw new Exception($dbh2->errorInfo());
      }
    }
    if (trim($mm[7]) != '') {
      $stmt2->execute([(int)trim($mm[7]), (int)trim($mm[0])]);
      if ($dbh2->errorInfo()[0] != '00000') {
       throw new Exception($dbh2->errorInfo());
      }
    }
  }

  echo 'ok';

  $dbh2->commit();
}
catch (PDOException $e) {
  $dbh2->rollBack();
  var_dump($e);
}

?>
