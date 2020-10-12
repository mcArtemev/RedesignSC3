<? 
    use framework\ajax\parse\hooks\sc;
    use framework\tools;
    
    $marka = $this->_datas['marka']['name'];
    $marka_ru =  $this->_datas['marka']['ru_name'];
    
    $vars = array();
    $vars[] = array('По статистике', 'По общей статистике', 'По данным статистики');
    $vars[] = array('количество', 'число', 'процент');
    $vars[] = array('гарантийных обращений', 'гарантийных возвратов');
    $vars[] = array('составляет', 'равняется');
    $vars[] = array('всего лишь ');
    
    $feed = tools::gen_feed($this->_datas['site_name']);
    $procent = tools::get_rand(array('0,70%,', '0,80%,', '0,90%,', '1,00%,', '1,10%,', '1,20%,', '1,30%,', '1,40%,', '1,50%,', '1,60%,', '1,70%,', '1,80%,', '1,90%,',
            '2,00%,', '2,10%,', '2,20%,', '2,30%,', '2,40%,', '2,50%,', '2,60%,', '2,70%,', '2,80%,', '2,90%,'), $feed);
    $vars[] = array($procent);
    $vars[] = array('т.е.', 'то есть');
    $vars[] = array('из 1000');
    $vars[] = array('отремонтированных');
    
    srand($feed);
    $choose_l = rand(0, 3);
    $t = array('аппаратов', 'устройств', 'девайсов', 'гаджетов');
    $vars[] = array($t[$choose_l]);
    $vars[] = array('всего');
    $vars[] = array((string) floatval(str_replace(',', '.', mb_substr($procent, 0 ,-1)))*10);
    
    unset($t[$choose_l]);
    $t = array_values($t);
    $t[] = 'штук';
    foreach ($t as $key => $t_v)
        $t[$key] = $t_v.',';
        
    $vars[] = $t;
    $vars[] = array('часть из которых');
    $vars[] = array('имеет другие проблемы.</p>', 'имеет новые проблемы.</p>', 'имеет не гарантийные проблемы.</p>', 'имеет другие неисправности.</p>', 'имеет новые неисправности.</p>', 'имеет не гарантийные неисправности.</p>');
    
    $vars[] = array('<p>Если вдруг у вас');
    $vars[] = array('возникнет', 'случится', 'произойдет');
    $vars[] = array('гарантийный случай,');
    $vars[] = array('то мы бесплатно');
    $vars[] = array('устраним ');
    $vars[] = array('неисправность.', 'проблему.');
    
    $vars[] = array('Сохраняйте');
    
    $t1 = array('бланк', 'бланк договора', 'бланк на ремонт', 'бланк заказа', 'бланк заявки', 'квитанцию');
    $t2 = array('договор');
    $t = array();
    
    foreach ($t1 as $t1_value)
    {
        foreach ($t2 as $t2_value)
        {
            $t[] = $t1_value.', '.$t2_value;
            $t[] = $t2_value.', '.$t1_value;
        }
    }
    
    $vars[] = $t;        
    $vars[] = array('и кассовый чек.');

    $choose = rand(0, 2);
    switch ($choose)
    {
        case 0:
            $vars[] = array('Гарантия на',);
            $vars[] = array('выполненные', 'произведенные', 'предоставленные');
            $vars[] = array('работы -', 'услуги -');
            $vars[] = array('3 месяца', '90 дней');
        break;
        case 1:
            $vars[] = array('Гарантия на',);
            $vars[] = array('установленные', 'замененные');
            $vars[] = array('комплектующие -', 'запчасти -', 'запасные части -', 'корпусные детали -');
            $vars[] = array('от 3');
            $vars[] = array('до');
            $vars[] = array('24 месяцев.', '36 месяцев.');
        break;
        case 2:
            $vars[] = array('Гарантия на',);
            $vars[] = array('установленные', 'замененные');
            $vars[] = array('комплектующие -', 'запчасти -', 'запасные части -', 'корпусные детали -');
            $vars[] = array('от 3 месяцев');
            $vars[] = array('до');
            $vars[] = array('2 лет.', '3 лет.');
        break;
    }
    
?>
<section class="inner-page gradient page">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <?php include __DIR__ . '/breadcrumb.php' ?>
            </div>
            <div class="col-sm-7 textblock">
                <h1><span class="smallh1"><?=$this->_ret['h1']?></span></h1>
                <p><?=sc::_createTree($vars, $feed);?></p>
            </div>
            <div class="col-sm-5 displayMoble">
                <div class="image-clip" style="background-image: url(/bitrix/templates/remont/images/shared/garantii.png)"></div>
            </div>
        </div>
    </div>
</section>


<? include __DIR__.'/devices.php'; ?>
<? include __DIR__.'/ask_expert.php'; ?>
<?php
$section_class = 'whitebg';
include __DIR__.'/preims.php';
unset($section_class);
?>