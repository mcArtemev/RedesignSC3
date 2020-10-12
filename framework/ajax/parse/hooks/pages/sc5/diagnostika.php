<? 
    use framework\ajax\parse\hooks\sc;
    use framework\tools;
    
    $marka = $this->_datas['marka']['name'];
    $marka_ru =  $this->_datas['marka']['ru_name'];
    
    $vars = array();
    $vars[] = array('Для выявления', 'Для нахождения');
    $vars[] = array('истинных', 'настоящих');
    $vars[] = array('проблем', 'причин');
    $vars[] = array('неисправности');
    $vars[] = array('мы');
    $vars[] = array('в обязательном порядке');
    $vars[] = array('проводим');
    $vars[] = array('аппаратную');
    $vars[] = array('или');
    $vars[] = array('программную');
    $vars[] = array('диагностику');
    
    $feed = tools::gen_feed($this->_datas['site_name']);
    srand($feed);
    $choose = rand(0, 1);
    
    switch ($choose)
    {
        case 0:
            $vars[] = array('на своем');
            $vars[] = array('фирменном оборудовании.', 'спец оборудовании.', 'специализированном оборудовании.');
        break;
        case 1:
            $vars[] = array('с помощью');
            $vars[] = array('фирменного оборудования.', 'спец оборудования.', 'специализированном оборудования.');
        break;
    }
    
    if (!($this->_datas['region']['name'] == 'Москва' || $this->_datas['region']['name'] == 'Санкт-Петербург'))
    {
        $choose = rand(0, 1);
        switch ($choose)
        {
            case 0:
                $vars[] = array('Мы проффи', 'Мы профессионалы');
                $vars[] = array('и не можем');
                $vars[] = array('руководствоваться');
                $vars[] = array('симптомами', 'видимыми симптомами');
                $vars[] = array('и');
                $vars[] = array('результатами');
            break;
            case 1:
                $vars[] = array('Мы');
                $vars[] = array('не можем');
                $vars[] = array('полагаться на');
                $vars[] = array('симптомы', 'видимые симптомы');
                $vars[] = array('и');
                $vars[] = array('результаты');
            break;
        }   
       
        $vars[] = array('диагностики');
        $vars[] = array('неизвестных', 'неизвестных нам');
        
        $t1 = array('мастеров', 'специалистов');
        $t2 = array('компаний', 'фирм', 'контор');
        $t_array = array();
        foreach ($t1 as $t1_value)
        {
            foreach ($t2 as $t2_value)
            {
                //$t_array[] = $t1_value.' и '.$t2_value.',';
                //$t_array[] = $t2_value.' и '.$t1_value.',';
                $t_array[] = $t1_value.' или '.$t2_value.',';   
                $t_array[] = $t2_value.' или '.$t1_value.',';     
            }
        }
        
        $vars[] = $t_array;    
        
        $vars[] = array('которые могли',);
        $vars[] = array('не правильно', 'не корректно');
        $vars[] = array('диагностировать', 'определить');
        $vars[] = array('проблему.', 'неисправность.', 'причину поломки.'); 
    }
    
    $vars[] = array('Любая диагностика');
    $choose = rand(0, 1);
    
    switch ($choose)
    {
        case 0:
            $vars[] = array('в нашем');
            $choose_l = rand(0, 2);
            $l_array = array('сервисе', 'сервис центре', 'сервисном центре');
            $vars[] = array($l_array[$choose_l]);            
        break;
        case 1:
            $vars[] = array('в нашей');
            $vars[] = array('лаборатории', 'мастерской');
        break;
    }   
  
    $vars[] = array('стоит', 'обойдется вам в');
    
    if ($this->_datas['region']['name'] == 'Москва' || $this->_datas['region']['name'] == 'Санкт-Петербург')
    {
        $vars[] = array('0 рублей при проведении ремонта.');
        $vars[] = array('В случаях когда ремонт не требуется, нужна только диагностика, услуга предоставляется платно. Стоимость диагностики зависит от типа устройства.');
        $vars[] = array('Смартфон, планшет - 490р, компьютер, сервер, принтер или МФУ - 790р, ноутбук, моноблок,
                монитор, телевизор, игровая приставка, смарт-часы, самокат - 990р, фотоаппарат, видеокамера, проектор, vive и другое - 1490р.');
    }
    else
    {
        $vars[] = array('0 рублей при проведении ремонта:');
    }
    
    $t1_array = array();
    $t1 = array('программная диагностика -');
    $t2 = array('от 15 до 40 минут', 'от 20 до 50 минут', 'от 20 до 60 минут', 'от 10 до 40 минут', 'от 10 до 50 минут');
    
    foreach ($t1 as $t1_value)
        foreach ($t2 as $t2_value)
            $t1_array[] = $t1_value.' '.$t2_value;
            
    $t1 = array('аппаратная диагностика -');    
    $t2 = array('от 15 минут до нескольких суток', 'от 15 минут до 24 часов', 'от 20 минут до нескольких дней', 'от 20 минут до 3х дней', 'от 25 минут до 3х суток', 'от 25 минут до 2-3 дней', 'от 30 минут до 2-3х суток', 'от 30 минут до 3 суток');
             
    foreach ($t1 as $t1_value)
        foreach ($t2 as $t2_value)
            $t2_array[] = $t1_value.' '.$t2_value;
    
    $t_array = array();
    foreach ($t1_array as $val1)
    {
        foreach ($t2_array as $val2)
        {
            if ($this->_datas['region']['name'] == 'Москва' || $this->_datas['region']['name'] == 'Санкт-Петербург')
            {
                $t_array[] = tools::mb_ucfirst($val1).', '.$val2.'.';
                $t_array[] = tools::mb_ucfirst($val2).', '.$val1.'.';
            }
            else
            {
                $t_array[] = $val1.', '.$val2.'.';
                $t_array[] = $val2.', '.$val1.'.';
            }
        }
    }
                        
    $vars[] = $t_array;
    
    $vars[] = array('Это реально не много,', ' Это реально не долго,', ' Это реально быстро,', ' Это реально можно называть экспресс,', ' Это реально можно называть срочная диагностика,');
    $vars[] = array('если сравнивать');
    $vars[] = array('с другими');
    $t = array('ремонтными центрами,', 'сервис центрами,', 'сервисными центрами,');
    if (isset($choose_l))
    {
       if ($choose_l)
       {
            unset($t[$choose_l]);
            $t = array_values($t);
       }   
    }
    $vars[] = $t;
    $vars[] = array('<a href="/">ремонтирующими', 'занимающимися <a href="/">ремонтом');
    $vars[] = array($marka.'</a>');
    $vars[] = array('в '.$this->_datas['region']['name_pe'].'.');

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
                <div class="image-clip" style="background-image: url(/bitrix/templates/remont/images/shared/diagnostika-centre.png)"></div>
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