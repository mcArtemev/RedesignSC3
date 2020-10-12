<? 
    use framework\ajax\parse\hooks\sc;
    use framework\tools;
    
    $marka = $this->_datas['marka']['name'];
    $marka_ru =  $this->_datas['marka']['ru_name'];
    $marka_lower = mb_strtolower($marka);
    
    // var_dump($this->_datas['all_devices']);
    
    $vars = array();
    $vars[] = array('<ul><li>Мы каждый день ', '<ul><li>Изо дня в день', '<ul><li>С утра до вечера, мы каждый день');
    $vars[] = array('ремонтируем', 'восстанавливаем', 'чиним');
    
    $t = array();
    
    $apple_device_type = array('ноутбук' => 'MacBook', 'планшет' => 'iPad', 'смартфон' => 'iPhone'); 
    //$accord = array('смартфон' => 'telefonov', 'ноутбук' => 'notebooks', 'планшет' => 'planshetov', 'фотоаппарат' => 'foto');
    $accord = $this->_datas['accord_url'];
    
    if ($marka_lower == 'apple')
    {
        $vars[] = array($marka);
        
        foreach ($this->_datas['all_devices'] as $device)
            $t[] = '<a href="/remont-'.$accord[$device['type']].'-'.$marka_lower.'/">'.(isset($apple_device_type[$device['type']]) ? $apple_device_type[$device['type']] : ($device['type_m'])).'</a>';
        
        $vars[] = array(implode(', ', $t).',</li>');
    }
    else
    {
        foreach ($this->_datas['all_devices'] as $device)
            $t[] = '<a href="/remont-'.$accord[$device['type']].'-'.$marka_lower.'/">'.$device['type_m'].'</a>';
    
        $vars[] = array(implode(', ', $t));
        $vars[] = array('бренда', 'марки', '');
        $vars[] = array($marka.'.</li>');
    }
    
    $vars[] = array('<li>У нас');
    $vars[] = array('есть в налиии', 'всегда в наличии', 'на складе есть', 'на складе имеются');
    
    $feed = tools::gen_feed($this->_datas['site_name']);
    $vars[] = array(tools::get_rand(array('9800', '9900', '10000', '10100', '10200', '10300', '10400', '10500', '10600', '10700', '10800', '10900', '11000', '11100', '11200', 
        '11300', '11400', '11500', '11600', '11700', '11800', '11900', '12000', '12100', '12200', '12300', '12400', '12500', '12600', '12700', '12800', '12900', 
        '13000', '13100', '13200', '13300', '13400', '13500', '13600', '13700', '13800', '13900', '14000', '14100', '14200', '14300', '14400', '14500', 
        '14600', '14700', '14800', '14900', '15000', '15100', '15200'), $feed));
    $vars[] = array('комплектующих,</li>', 'запчастей,</li>', 'запасных частей,</li>');
    
    srand($feed);
    $choose = rand(0, 1);
    switch ($choose)
    {
        case 0:
            $vars[] = array('<li>наша лаборатория', '<li>наша мастерская');
            $vars[] = array('оснащена');
            $vars[] = array('современным');
            $vars[] = array('оборудованием,', 'спец оборудованием,');
        break;
        case 1:
            $vars[] = array('<li>в нашей лаборатории', '<li>в нашей мастерской');
            $vars[] = array('установлено');
            $vars[] = array('современное');
            $vars[] = array('оборудование,</li>', 'спец оборудование,</li>');
        break;
    }
    
    $vars[] = array('<li>мы');
    $vars[] = array('дипломированные ', 'сертифицированные');
    $vars[] = array('эксперты', 'специалисты');
    $vars[] = array('с опытом работы');
    $vars[] = array('более', 'больше ', 'от', '>');
    $vars[] = array('3 лет.</li></ul>', '4 лет.</li></ul>', '5 лет.</li></ul>');

    $vars[] = array('Это позволяет нам', 'Это дает нам возможность');
    $vars[] = array('проводить ', 'выполнять');
    $vars[] = array('срочный ремонт,', 'экспресс ремонт,');
    $vars[] = array('гарантируя');
    $vars[] = array('высокое', 'клиентам высокое');
    $vars[] = array('качество');
    $vars[] = array('работы.', 'своей работы.', 'ремонтных работ.');

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
                <div class="image-clip" style="background-image: url(/bitrix/templates/remont/images/shared/srochniy-remont.png)"></div>
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
