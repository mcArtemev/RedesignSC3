<?php

$in = 'spb.acer.russia.expert	7(812)416-06-57	6042770	6042778
spb.alcatel-russia.com	7(812)416-06-58	6042771	6042786
spb.apple.russia.expert	7(812)416-06-59	6042783	6042785
spb.asus-russia.ru	7(812)416-06-60	6042781	6042787
spb.canon-russia.com	7(812)416-06-61	6042793	6042789
spb.notebook-russia.com	7(812)416-06-63	6042774	6042758
spb.fly-russia.com	7(812)416-06-64	6042759	6042792
spb.hp.russia.expert	7(812)416-06-65	6042784	6042753
spb.htcrussia.com	7(812)416-06-66	6042768	6042754
spb.huawei.russia.expert	7(812)416-06-67	6042779	6042782
spb.lenovo-russia.ru	7(812)385-02-61	6042791	6042761
spb.lg-russia.ru	7(812)385-02-63	6042790	6042794
spb.meizu.russia.expert	7(812)416-06-68	6042776	6042795
spb.msi.russia.expert	7(812)416-06-69	6042756	6042760
spb.nikon.russia.expert	7(812)416-06-70	6042797	6042798
spb.nokia-russia.com	7(812)416-06-71	6042796	6042801
spb.smrussia.com	7(812)416-06-72	6042799	6042802
spb.sony-russia.com	7(812)385-02-64	6042803	6042762
spb.toshiba.russia.expert	7(812)416-06-73	6042764	6042763
spb.xiaomi.russia.expert	7(812)416-06-74	6042767	6042765
spb.zte.russia.expert	7(812)416-06-75	6042773	6042766';

$rows = explode("\r\n", $in);

foreach ($rows as $k=>$v) {
  $rows[$k] = explode(' ', preg_replace('/\s+/', ' ', $v));
}


$dbh = new \PDO('mysql:host=localhost;dbname=service-3_gg;charset=UTF8', 'service-3_mysql', '0X4l3U3q');
$sites = [];
foreach ($rows as $r) {
  #$r[1] = preg_replace('/(\s|\(|\)|\+)/', '', $r[1]);
  #if ($r[1][0] == '8') $r[1][0] = '7';

  #echo "UPDATE sites SET phone_yd = '7812{$r[2]}', phone_yd_rs = '7812{$r[3]}' WHERE name = '{$r[0]}'"."<br>";
  $sites[] = "'{$r[0]}'";
  #$site = $sites[] = $dbh->query("SELECT sites.name FROM sites JOIN marka_to_sites ON sites.id = marka_to_sites.site_id JOIN markas ON marka_to_sites.marka_id = markas.id WHERE markas.name = '{$r[0]}' AND sites.region_id = 0")->fetchColumn();
  #$stmt = $dbh->query("UPDATE sites SET phone_yd = '7812{$r[2]}', phone_yd_rs = '7812{$r[3]}' WHERE name = '{$r[0]}'");
}

echo implode(',',$sites);
exit;

echo '<pre>';
print_r($rows);
echo '</pre>';

?>
