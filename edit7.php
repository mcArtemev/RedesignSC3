<?php

spl_autoload_extensions('.php');
spl_autoload_register();

use framework\ajax\service\service;

$res = new service(['сц-2', 'планшет']);

var_dump($res);
exit;

/*spl_autoload_extensions('.php');
spl_autoload_register();

use framework\pdo;

$dbh = pdo::getPdo();

$stmt = $dbh->query("SELECT * FROM sites WHERE setka_id = 7");

try {
  $dbh->beginTransaction();
  foreach ($stmt->fetchAll() as $site) {
    $dbh->query("UPDATE `urls` SET name = 'replacing-cpu-monitors' WHERE site_id = {$site['id']} AND name = 'replacing-cpu -monitors'");
  }
  if ($dbh->errorInfo()[0] != '00000') {
    $dbh->rollBalck();
    echo 'error';
    exit;
  }
  $dbh->commit();
}
catch (PDOException $e) {
  $dbh->rollBalck();
  echo 'error';
}*/

##SELECT * FROM `urls` WHERE site_id = 1208 AND name = 'replacing-cpu -monitors'

?>
