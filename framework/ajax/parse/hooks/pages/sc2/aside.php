 <?  use framework\tools; 
 
$marka = $this->_datas['marka']['name'];
$marka_upper = mb_strtoupper($this->_datas['marka']['name']);
$accord = $this->_datas['accord'];
$region_name_pe = $this->_datas['region']['name_pe'];

$mode = isset($mode) ? $mode : 1;
?>            

<aside class="aside-menu">
                 
        <div class="aside-menu__panel">
          <div class="aside-menu__phone">
            <a class="footphone mango_id" href="tel:+<?=$this->_datas['phone']?>">+<?=tools::format_phone($this->_datas['phone'])?></a>
            <p>Многоканальная горячая линия сервисного центра <?=$marka_upper?> в <?=$region_name_pe?></p>

          </div>
          <div class="divider"></div>
            <div class="ask-sony">
                <? if ($mode):?>
                    <p class="ask-sony__header">Спросите <?=$marka_upper?></p>
                    <p class="ask-sony__text">Задайте ваш вопрос по использованию, обслуживанию или ремонту специалистам <?=$marka?></p>               
                    <a href="/ask/" class="btn btn--empty">задать вопрос</a>
                <? else: ?>
                    <p class="ask-sony__header">Запись на ремонт</p>
                    <p class="ask-sony__text">Ремонт и обслуживание техники <?=$marka?> со скидкой 10%</p>               
                    <a href="/order/" class="btn btn--empty">записаться</a>
                <? endif; ?>
            </div>
        </div>

            <ul>
            <? foreach ($this->_datas['all_devices'] as $devices)
                 {
                    $st_url = "/".$accord[$devices['type']]."/";
                    $v = tools::mb_ucfirst($devices['type_m'], 'utf-8', false);
                    if ($url == $st_url)
                        echo '<li><span class="active">'.$v.'</span></li>';
                    else
                        echo '<li><a href="'.$st_url.'">'.$v.'</a></li>';
                 }
            ?>
            </ul>
</aside>