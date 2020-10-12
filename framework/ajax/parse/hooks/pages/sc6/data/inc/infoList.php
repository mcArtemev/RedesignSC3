<?php

$url = $this->_datas['arg_url'];

if ($this->_datas['region']['name'] == "Москва") {
	$infoItems = [
	  'o_kompanii/diagnostika' => ['Диагностика', 'Среднее время диагностики в нашем сервисе занимает около 40 минут'],
	  'o_kompanii/dostavka' => ['Выезд и доставка', 'Доставка техники в сервисный центр в пределах МКАД БЕСПЛАТНО'],
	  'o_kompanii/vremya_remonta' => ['Время ремонта', 'Большую часть поступающей техники удается отремонтировать в день обращения'],
	];
} else {
	$infoItems = [
	  'o_kompanii/diagnostika' => ['Диагностика', 'Среднее время диагностики в нашем сервисе занимает около 40 минут'],
	  'o_kompanii/dostavka' => ['Выезд и доставка', 'Доставка техники в сервисный центр в пределах города БЕСПЛАТНО'],
	  'o_kompanii/vremya_remonta' => ['Время ремонта', 'Большую часть поступающей техники удается отремонтировать в день обращения'],
	];
}

?>
<div class="repair-types">
    <ul class="repair-types__inner">
        <?php foreach ($infoItems as $urlItem => $item) {
          if ($urlItem != $url) {
        ?>
        <li>
            <a href="/<?=preg_replace('/(^\/|\/$)/', '', $urlItem)?>/"><?=$item[0]?></a>
            <span><?=$item[1]?></span>
        </li>
      <?php }} ?>
    </ul>
</div>
