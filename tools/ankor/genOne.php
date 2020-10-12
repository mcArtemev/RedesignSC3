<?php

require_once 'Ankor.php';

if (isset($_POST) && count($_POST)) {
  $csv = isset($_POST['csv']);
  unset($_POST['csv']);
  Ankor::setParams($_POST);
  $res = Ankor::generate();
}


?>

<form method="POST" style = "float: left; margin-right: 60px;">
  <p><input name = "site" placeholder="Сайт" required></p>
  <p><select name = "setka" required>
    <?php foreach (Ankor::$setkas as $k=>$v) { ?>
      <option value = "<?=$k?>"><?=$v?></option>
    <?php } ?>
  </select></p>
  <p><select name = "brand" required>
    <?php foreach (Ankor::$brandName as $k=>$v) { ?>
      <option value = "<?=$k?>"><?=$v[0]?></option>
    <?php } ?>
  </select></p>
  <p><select name = "city" required>
    <?php foreach (Ankor::$cities as $k=>$v) { ?>
      <option value = "<?=$k?>"><?=$v[0]?></option>
    <?php } ?>
  </select></p>
  <p><input name = "count" placeholder="Кол-во" required></p>
  <p><label><input type = "checkbox" name = "csv"> <span>csv вид</span></label></p>
  <input type = "submit">
</form>

<?php if (isset($res)) {
  echo '<textarea style = "display: block; width: 500px;" rows = "'.(count($res)+2).'">';
  foreach ($res as $v) {
    if ($csv)
      echo implode(';', $v);
    else
      echo $v[0];
    echo "\r\n";
  }
  echo '</textarea>';
}
?>
