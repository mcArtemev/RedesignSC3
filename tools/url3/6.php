<?php

exit;

$dbh = new \PDO('mysql:host=93.95.97.77:3306;dbname=service-3_gg;charset=UTF8', 'service-3_mysql', '0X4l3U3q');

$sites = $dbh->query("SELECT id FROM sites WHERE setka_id = 6")->fetchAll(\PDO::FETCH_ASSOC);

foreach ($sites as $site) {
  $stmt = $dbh->query("SELECT * FROM urls WHERE site_id = {$site['id']} AND params regexp 'a:1:{s:8:\"model_id\";s:4:\"(2628)\";}'");
  if ($stmt->rowCount() > 0) {
    foreach ($stmt->fetchAll() as $url) {
      $newUrl = strtr($url['name'], [
        '_-_' => '-',
      ]);
      echo $url['name'].' '.$newUrl.'<br>';
      $dbh->query("UPDATE urls SET name = '$newUrl' WHERE id = {$url['id']}");
    }
  }
}


?>
