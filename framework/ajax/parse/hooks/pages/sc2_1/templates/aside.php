 <?  use framework\tools;


$region_name_pe = $this->_datas['region']['name_pe'];

$mode = isset($mode) ? $mode : 1;
?>

<aside class="aside-menu">

        <div class="aside-menu__panel">
          <div class="aside-menu__phone">
            <a class="footphone mango_id" href="tel:+<?=$this->_datas['phone']?>">+<?=tools::format_phone($this->_datas['phone'])?></a>
            <p>Многоканальная горячая линия сервисного центра в <?=$region_name_pe?></p>

          </div>
          <div class="divider"></div>
            <div class="ask-sony">
                <? if ($mode):?>
                    <p class="ask-sony__header">Спросите <?=$this->_datas['servicename']?></p>
                    <p class="ask-sony__text">Задайте ваш вопрос по использованию, обслуживанию или ремонту специалистам <?=$this->_datas['servicename']?></p>
                    <a href="/sprosi/" class="btn btn--empty">задать вопрос</a>
                <? else: ?>
                    <p class="ask-sony__header">Запись на ремонт</p>
                    <p class="ask-sony__text">Ремонт и обслуживание техники со скидкой 10%</p>
                    <a href="/zakaz/" class="btn btn--empty">записаться</a>
                <? endif; ?>
            </div>
        </div>

            <ul>
            <? /*foreach ($this->_datas['all_devices'] as $devices)
                 {
                    $st_url = "/".$accord[$devices['type']]."/";
                    $v = tools::mb_ucfirst($devices['type_m'], 'utf-8', false);
                    if ($url == $st_url)
                        echo '<li><span class="active">'.$v.'</span></li>';
                    else
                        echo '<li><a href="'.$st_url.'">'.$v.'</a></li>';
                 }*/
            ?>
            </ul>
</aside>
