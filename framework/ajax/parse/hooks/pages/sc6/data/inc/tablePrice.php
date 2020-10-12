<?php

use framework\ajax\parse\hooks\pages\sc6\data\src\service_service;

$slidetable = isset($maxcount);
$c = 0;
$i = 0;
?>

<div <?=($slidetable ? 'class = "slideTable"' : '')?>>
<table class="table">
    <thead>
    <tr>
        <th>Услуга</th>
        <th class="coast">Стоимость</th>
        <th class="time">Время ремонта</th> 
        <th></th>
    </tr>
    </thead> 
    <tbody>
    <? foreach (service_service::groups($services) as $nameGroup => $group) {
      if (is_string($nameGroup) && count($group)) {
      ?>
      <tr <?=($slidetable && ++$c > $maxcount ? 'style = "display:none;"' : '')?> class = "titleGroup <?=($slidetable && $c > $maxcount ? 'hideTr' : '')?>"><td colspan = "4"><?=$nameGroup?></td></tr>
    <?php }
    foreach ($group as $service) {
		if ($service['name'] != "Ремонт на дому") {?>
		<tr <?=($slidetable && ++$c > $maxcount ? 'style = "display:none;"' : '')?> class = "<?=($slidetable && $c > $maxcount ? 'hideTr' : '')?>">
			<td><?php if ($service['urlWork'] == 1) { ?>
			  <span><a href = "<?=service_service::fullUrl($service['type'], $service['url'])?>"><?=$service['name']?></a></span>
			<?php } else { ?>
			  <span><?=$service['name']?></span>
			<?php } ?> 
			</td>
			<td class="coast"><?=(!$i) ? ('0') : $service['cost']?> р.</td>
			<td class="time"><?=$service['time']?> мин.</td>
            <td><a href="#" class="btn btn-default yellow_bottom" data-toggle="modal" data-target="#requestModal">заказать</a></td>    
		</tr>
		<? }}  $i++; } ?>
    </tbody>
</table>
</div>
