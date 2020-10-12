<?
use framework\ajax\parse\hooks\sc;
use framework\tools;
use framework\rand_it;
use framework\pdo;
      
$vars = array();

$model_array = array('Apple Iphone 6', 'Apple Iphone 6S', 'Apple Iphone 6 Plus', 'Apple Iphone 6S Plus', 'Apple Iphone 7', 'Apple Iphone 7 Plus');

$model_array_pr = array('Apple Iphone 6' => 'шестого', 'Apple Iphone 6S' => 'шестого', 'Apple Iphone 6 Plus' => 'шестого', 
             'Apple Iphone 6S Plus' => 'шестого', 'Apple Iphone 7' => 'седьмого', 'Apple Iphone 7 Plus' => 'седьмого');
             
$model_array_rus = array('Apple Iphone 6' => 'Айфон 6', 'Apple Iphone 6S' => 'Айфон 6S', 'Apple Iphone 6 Plus' => 'Айфон 6 Plus', 
             'Apple Iphone 6S Plus' => 'Айфон 6S Plus', 'Apple Iphone 7' => 'Айфон 7', 'Apple Iphone 7 Plus' => 'Айфон 7 Plus');

$apple_device_type = array('ноутбук' => 'MacBook', 'планшет' => 'iPad', 'смартфон' => 'iPhone'); 

$iphone_text = array();      
$iphone_text_footer = array();
$iphone_text_data = array();
       
$feed = $this->_datas['feed'];

$site_id = $this->_datas['site_id'];
$model_id = $this->_datas['model']['id'];
    
$marka = $this->_datas['marka']['name'];
$marka_ru =  $this->_datas['marka']['ru_name'];
$marka_id = $this->_datas['marka']['id'];
$marka_lower = mb_strtolower($this->_datas['marka']['name']);
$accord2 = array('смартфон' => 'telefon', 'ноутбук' => 'notebook', 'планшет' => 'planshet');
$model_type_id = $this->_datas['model_type']['id'];

$setka_name = $this->_datas['setka_name'];

$eds = $this->_datas['eds'];
$availables = $this->_datas['availables'];

$vals = $this->_datas['vals'];

$accord_type = array('p' => '3', 'n' => '3', 'f' => '3');
$diagnostic_id = array('p' => 1, 'n' => 1, 'f' => 1);

$diagnostic = current($this->_get_vals('service', array($diagnostic_id[$this->_suffics])));

$diagnostic_name = tools::mb_firstupper($diagnostic['name']);
$diagnostic_time = tools::format_time($diagnostic['time_min'], $diagnostic['time_max'], $eds[$this->_datas['id']]['ed_time']);
$diagnostic_price = tools::format_price($diagnostic['price'], $setka_name);

if ($this->_datas['id'] != 3)
{
     $vars[] = array('<p>В большинстве случаев', '<p>Чаще всего');
     $vars[] = array('необходимость', 'потребность');
     $vars[] = array('в '.tools::skl('service', $this->_suffics, $this->_datas['syns'][2], 'dat'));
     $vars[] = array('вызвана механическим воздействием на');
     $vars[] = array($this->_datas['model']['name'].'.');
     
     $vars[] = array('Возможна поломка', 'Возможна неисправность', 'Возможен дефект');
     $vars[] = array('в следствии');
     $vars[] = array('заводского брака,', 'брака при производстве,');
     $vars[] = array('который выявляется сразу по прошествии');
     $vars[] = array('гарантийного периода', 'гарантийного срока');
     $vars[] = array('либо в результате естественного износа');
     $vars[] = array('аппарата.', 'гаджета.', 'устройства.');
     
     $vars[] = array('В');
     $vars[] = array('сервис', 'сервисный центр');
     $vars[] = array('REMONT CENTRE');
     $vars[] = array('часто приносят');
     $vars[] = array('на ремонт', 'на обслуживание');
     $vars[] = array($this->_datas['model']['name']);
     $vars[] = array('с этой проблемой -');
     $vars[] = array('записывайтесь на ремонт,', 'оставляйте заявку,');
     $vars[] = array('все починим!');
}
else
{
    if (in_array($this->_datas['model']['name'], $model_array))
    {
        $short_model = str_replace('Apple ', '', $this->_datas['model']['name']);
    
        $vars[] = array('<p>Треснувшее или разбившееся', '<p>Разбившееся или треснувшее');
        $vars[] = array('стекло на дисплее нового Айфона может стать причиной 
                    быстрого выхода гаджета из строя. Если вы повредили дисплей, или допустили его контакт с водой, 
                    может потребоваться замена экрана '.$short_model.'.</p>');
                    
        $vars[] = array('<p>Как заменить экран быстро и без потери функциональности устройства?</p>');
        $vars[] = array('<p>Если у вас нет опыта ремонта современных мобильных телефонов Apple, не пытайтесь произвести замену экрана самостоятельно. 
            Приносите ваш Айфон к нам: в столичном сервисном центре Apple вся работа займет не более часа и обойдется вам по умеренной цене.</p>');
    
        $iphone_text[] = array('<h3>Как производится ремонт экранного модуля '.$model_array_pr[$this->_datas['model']['name']].' айфона?</h3>');
        
        $iphone_text[] = array('<p>Эта модель iPhone имеет функцию сканера отпечатка пальцев для идентификации пользователя. Опция облегчает владельцу эксплуатацию телефона, но усложняет задачу специалистам по замене разбитого или треснувшего стекла. 
            Для правильной замены дисплея iPhone без повреждения чувствительной матрицы необходимы профессиональные инструменты.</p>');
            
        $iphone_text[] = array('<p>Чтобы добраться до экранного модуля и отделить треснувшее стекло, специалисту придется выполнить свыше 40 действий:'); 
        
        $iphone_text_li_0 = array();
        
        $iphone_text_li_1 = array('домашнюю кнопку', 'фронтальную камеру и сенсорную панель');
        $iphone_text_li_1 = rand_it::randMas($iphone_text_li_1, 2, '', $feed);
    
        $iphone_text_li_0[] = 'снять '. implode(', ', $iphone_text_li_1);
        
        $iphone_text_li_2 = array('пластину экрана', 'ленточный кабель'); 
        $iphone_text_li_2 = rand_it::randMas($iphone_text_li_2, 2, '', $feed);
        
        $iphone_text_li_0[] = 'удалить '. implode(', ', $iphone_text_li_1);
        
        $iphone_text_li_0 = rand_it::randMas($iphone_text_li_0, 2, '', $feed);
        $iphone_text[] = array(implode(', ', $iphone_text_li_0));
        $iphone_text[] = array('и другие детали. Не повредить тонкое стекло экрана позволят специальные инструменты:</p>');
            
        $iphone_text[] = array('<ul>');
        
        $iphone_text_li = array('присоски iSclack', 'тонкие пластиковые лезвия, пинцеты и отвертки для винтиков', 
               'нагревательные элементы iOpener для растворения клея жидкого оптического клея LOCA');
                      
        $iphone_text_li = rand_it::randMas($iphone_text_li, 3, '', $feed);
        
        foreach ($iphone_text_li as $key => $v)
        {
           if ($key == 2) 
                $v = '<li>'. $v . ' и другие приспособления, сертифицированные Apple.'.'</li>';
           else
                $v = '<li>'. $v . ';' .'</li>';
                
           $iphone_text[] = array($v);   
        }
        
        $iphone_text[] = array('</ul>');
         
        $iphone_text[] = array('<p>В обычных сервисных пунктах эту работу могут выполнить топорно с помощью простых инструментов, не предназначенных для работы с iPhone. 
                Только в лицензированном центре по ремонту Айфонов ваш «яблочный» гаджет получит профессиональное обращение и долгосрочную гарантию на замену стекла.</p>');
                
        $iphone_text_footer = array();
        $iphone_text_footer[] = array('<h3>Бесплатная диагностика и срочный выезд курьера – все виды сервиса к вашим услугам</h3>');
        $iphone_text_footer[] = array('<p>Преимущества обслуживания телефонов iPhone в '. $this->_datas['region']['pril'].' сервисном центре оценит каждый, кто нуждается в срочном профессиональном сервисе:</p>');
        $iphone_text_footer[] = array('<ul>');
        
        $iphone_text_li = array(
                'мы бесплатно диагностируем гаджеты на предмет неисправностей всего за 30 минут', 
                'работаем как в салоне, так и на дому/в офисе у клиента, выезжая в день обращения',
                'используем на 100% оригинальные запчасти для устройств Apple',
                'применяем только сертифицированное оборудование и инструменты для ремонта');
                
        $iphone_text_li = rand_it::randMas($iphone_text_li, 4, '', $feed);
        foreach ($iphone_text_li as $key => $v)
        {
           if ($key == 3)
                $v = '<li>'. $v . '.</li>';
           else 
                $v = '<li>'. $v . ';' .'</li>';
                
           $iphone_text_footer[] = array($v);   
        }
        
        $iphone_text_footer[] = array('</ul>');
        
        $iphone_text_data[] = array('<p>Оперативный сервис по замене экрана на '.$model_array_rus[$this->_datas['model']['name']].' в '. $this->_datas['region']['pril'] .' центре Apple вернет вашему гаджету утраченную функциональность. 
            Цена на услуги специалистов по ремонту брендовой электроники позволит вам не задумываться над покупкой нового телефона.</p>');
        $iphone_text_data[] = array('<p>Ждем вас на ремонт дисплея iPhone по предварительной записи. На сайте нашего центра можно заранее заказать оригинальные запчасти.</p>');
    }
    else
    {
        $vars[] = array('По нашей оценке', 'По системе оценок', 'По нашей статистике', 'По нашим данным', 'По нашим оценкам');
        $vars[] = array('больше', 'более', 'около', 'приблизительно', '>', '~', '');
        
        $vars[] = array(tools::get_rand(array('40%', '45%', '50%', '55%', '60%'), $this->_datas['f']));
        
        $t_array = array();
        foreach ($this->_datas['orig_model_type'] as $type)
            $t_array[] = $type['name_rm'];
            
        $vars[] = $t_array;
        $vars[] = array('поступают');
        $vars[] = array('в сервис', 'в центр', 'в сервис центр', 'в сервисный центр', 'в мастерскую', 'в лабораторию', 'в лабораторию центра', 'в наш сервис', 'в наш центр', 'в наш сервис центр', 'в наш сервисный центр', 'в нашу мастерскую', 'в нашу лабораторию');
        $vars[] = array('c неисправным', 'с разбитым');
        
        $t_array = array('экраном', 'дисплеем', 'стеклом', 'сенсором', 'тачскрином', 'стеклом экрана', 'стеклом дисплея', 'стеклом сенсора', 'сенсорным экраном', 'сенсорным стеклом', 'сенсорным дисплеем', 'экранным модулем', 'дисплейным модулем', 'модулем дисплея', 'модулем эрана');
        
        srand($feed);
        $choose = rand(0, count($t_array) - 1);
        
        $vars[] = array($t_array[$choose].'.'); 
        
        $vars[] = array('На практике,', 'В парктике,');
        $vars[] = array('при наличии');
        $vars[] = array('подходящих', 'требуемых', '', '', '');
        $vars[] = array('комплектующих,', 'запчастей,', 'деталей,', 'запасных частей,');
        $vars[] = array('замена');
        
        $t_array = array('экрана', 'дисплея', 'стекла', 'сенсора', 'тачскрина', 'стекла экрана', 'стекла дисплея', 'стекла сенсора', 'сенсорного экрана', 'сенсорного стекла', 'сенсорного дисплея', 'экрана модуля', 'дисплейного модуля', 'модуля дисплея', 'модуля эрана');
        unset($t_array[$choose]);
        $t_array = array_values($t_array);
        
        $vars[] = $t_array;
        $vars[] = array('на');
        $vars[] = array($this->_datas['model']['name']);
        $vars[] = array('занимает');
        
        $choose = rand(0, 1);
        switch ($choose)
        {
            case 0:
                $vars[] = array('не больше', 'не более', 'около');
                $vars[] = array('1 часа.', '1,5 часов.', 'одного часа.', 'получаса.', '30 минут.', '40 минут.', '50 минут.', '45 минут.');
            break;
            case 1:
                $vars[] = array('приблизительно', 'примерно', '~', 'в среднем');
                $vars[] = array('1 час.', '1,5 часа.', 'один час.', 'полчаса.', '30 минут.', '40 минут.', '50 минут.', '45 минут.');
            break;
        }
        
        if (mb_strtolower($this->_datas['model']['lineyka']) == mb_strtolower($this->_datas['model']['sublineyka']))
            $vars[] = array($this->_datas['model']['submodel']);   
        else
            $vars[] = array($this->_datas['m_model']['name'] . ' ' . $this->_datas['model']['submodel']);  
        
        $vars[] = array('распространенная', 'популярная');
        $vars[] = array('модель,');
        $vars[] = array('которую');
        $vars[] = array('мы часто ремонтируем,', 'нам часто приносят на ремонт,');
        $vars[] = array('поэтому');
        $vars[] = array('на нее');
        $vars[] = array('всегда', 'почти всегда');
        $vars[] = array('на складе', '');
        $vars[] = array('есть', 'есть в наличии');
        $vars[] = array('комплектующие -', 'все комплектующие -', 'комплекты всех комплектующих -', 'запасы комплектующих -', 'оригинальные дисплеи -', 'оригинальные модуля -', 'фирменные дисплеи -', 'фирменные модуля -', 
                'запасы фирменных стекол -', 'запасы фирменных дисплеев -', 'запасы фирменных экраном -', 'запасы фирменных модулей -', 'запасы оригинальных стекол -', 'запасы оригинальных дисплеев -', 'запасы оригинальных экранов -');
        
        $vars[] = array('записывайтесь на ремонт, все починим!', 'записывайтесь на ремонт, все починим без проблем!', 'записывайтесь, все починим!', 'записывайтесь, все починим без проблем!',
                    'записывайтесь, не ремонтируемых аппаратов не бывает!', 'записывайтесь, не ремонтируемых устройств не бывает!', 'записывайтесь, не ремонтируемой техники не бывает!',
                    'записывайтесь на ремонт, все отремонтируем!', 'записывайтесь на ремонт, все отремонтируем без проблем!', 'записывайтесь, все отремонтируем!',
                    'записывайтесь, все отремонтируем без проблем!', 'записывайтесь, мы починим!', 'записывайтесь, мы отремонтируем!');
    }
}

$text2 = array();
$text2[] = array($this->_datas['servicename'].':');

$blocks = array();
$blocks[] = array('лучшие сроки ремонта', 'оптимальные сроки ремонта', 'сжатые сроки ремонт', 'кратчайшие сроки ремонта');
$blocks[] = array('бесплатные консультация по телефону', 'бесплатные консультации', 'бесплатная горячая линия '.$this->_datas['marka']['name'],
            'бесплатная горячая линия '.$this->_datas['marka']['ru_name']);
$blocks[] = array('лучшее оборудование', 'современное оборудование', 'фирменное оборудование', 'профессиональное оборудование');
$blocks[] = array('гарантии на все работы', 'гарантии на любой ремонт', 'гарантии на все услуги', 'гарантии на все услуги и комплектующие', 
        'гарантии на все комплектующие и услуги', 'гарантии на все ремонтные работы');
$blocks[] = array('бесплатная экспресс диагностика', 'бесплатная срочная диагностика', 'бесплантная диагностика', 'срочная диагностика', 'экспресс диагностика');
$blocks[] = array('оригинальные запчасти', 'оригинальные комплектующие', 'все комплектующие в наличии');

$t_count = count($blocks);
$i = 0;
foreach (rand_it::randMas($blocks, $t_count, '', $feed) as $v)
{
    foreach ($v as $kk => $vv)
    {
        if ($i !== $t_count-1)
            $v[$kk] .= ',';
        else
            $v[$kk] .= '.';
    }
    $text2[] = $v;
    $i++;
}

$text2[] = array('Звоните:', 'Звоните!');
/*$text2[] = array(tools::format_phone($this->_datas['phone']).' -');
$text2[] = array('поможем!', 'мы поможем!', 'мы починим!', 'все починим, без проблем!', 'все починим!');*/

$ring = 20;
$half_ring = $ring / 2;

$m_models_table = 'm_models';
$m_models_link = 'm_model_id';

if ($this->_datas['id'] == 3)
{
    $ex = array('marka_id' => $marka_id, 'site_id' => $site_id);
    $cond_model = "`m_models`.`marka_id`=:marka_id";
}
else
{
    $ex = array('marka_id' => $marka_id, 'site_id' => $site_id, 'model_type_id' => $model_type_id);
    $cond_model = "`m_models`.`marka_id`=:marka_id AND `m_models`.`model_type_id`=:model_type_id";
}

$sql = "SELECT `models`.`id` as `id`, `models`.`name` as `name`, `model_types`.`name` as `type` FROM `model_to_sites`
                INNER JOIN `sites` ON `sites`.`id`=`model_to_sites`.`site_id`
                INNER JOIN `models` ON `models`.`id`=`model_to_sites`.`model_id`
                INNER JOIN `{$m_models_table}` ON `{$m_models_table}`.`id`=`models`.`{$m_models_link}`
                INNER JOIN `model_types` ON `m_models`.`model_type_id` = `model_types`.`id`
                    WHERE {$cond_model} AND `model_to_sites`.`site_id`=:site_id ORDER BY `models`.`id`";
                    
$stm = pdo::getPdo()->prepare($sql);
$stm->execute($ex);
$data = $stm->fetchAll(\PDO::FETCH_ASSOC);
  
$count = count($data);

if ($count <= $ring)
{
    $all_models = rand_it::randMas($data, $count, '', $this->_datas['feed']);
}
else
{
    $m = array();
    $t_m = array();
    
    foreach ($data as $model)
        $m[] = $model['id'];
        
    $start_key = array_search($model_id, $m);
    $c = $start_key;
    
    for ($i = 0; $i < $half_ring; $i++)
    {
        $c++;
        if ($c == $count) $c = 0;
        $t_m[] = $data[$c];    
    }
    
    $c = $start_key;
    for ($i = 0; $i < $half_ring; $i++)
    {
        $c--;
        if ($c == -1) $c = $count-1;
        $t_m[] = $data[$c];
    }
    
    $all_models = $t_m;
}

$complect_to_services = isset($this->_datas['complect_to_services']) ? $this->_datas['complect_to_services'] : array();
$service_name = tools::mb_firstupper($vals['name']);
$service_time = tools::format_time($vals['time_min'], $vals['time_max'], $eds[$this->_datas['id']]['ed_time']);
$service_price = tools::format_price($vals['price'], $setka_name);

?>

<section class="inner-page gradient page">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="breadcrumbs">
                <? if ($this->_datas['id'] == 3):?>
                    <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="/"><span itemprop="title">Главная</span></a></span>
                    &nbsp;|&nbsp;<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="/<?=tools::search_url($site_id, serialize(array('marka_id' => (integer) $marka_id, 'static' => 'zamena-ekrana')))?>/"><span itemprop="title">Замена экрана <?=$this->_datas['marka']['name']?></span></a></span>
                    &nbsp;|&nbsp;<span>Замена экрана <?=$this->_datas['model']['name']?></span>
                <?else:?>
                    <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="/"><span itemprop="title">Главная</span></a></span>
                    &nbsp;|&nbsp;<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="/<?=tools::search_url($site_id, serialize(array('model_type_id' => $model_type_id, 'marka_id' => $marka_id)))?>/">

                <? if ($marka_lower == 'apple'):?>
                    <span itemprop="title"><?=$apple_device_type[$this->_datas['orig_model_type'][0]['name']]?></span>
                <?else:?>
                    <span itemprop="title"><?=tools::mb_ucfirst($this->_datas['orig_model_type'][0]['name'])?></span>
                <?endif;?>
            </a></span>
                    &nbsp;|&nbsp;<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="/<?=tools::search_url($site_id, serialize(array('model_id' => $model_id)))?>/"><span itemprop="title">Ремонт <?=$this->_datas['model']['name']?></span></a></span>
                    &nbsp;|&nbsp;<span><?=$this->_datas['syns'][1]?></span>
                <?endif;?>
            </div>
            </div>
            <div class="col-sm-7 textblock">
                <h1 class="smallh1"><?=$this->_ret['h1']?></h1>
                <?=sc::_createTree($vars, $feed);?>
                <div class="title">от 390 руб</div>
                <div class="block-button">
                    <a href="#callback-repair" class="callback-modal button button-reverse mr-20 dell" data-title="Запишитесь на ремонт" data-button="записаться на ремонт" data-textarea="ваша неисправность" data-title-tip="и мы свяжемся с вами в течении 3х минут">записаться на ремонт</a>
                    <button type="button" class="callback-modal button dell" data-title="Получите промокод на 1500р" data-button="получить промокод" data-action="promo_sms" data-title-tip="и оплатите им до 15% стоимости заказа" id="default_button">промокод на 1500 руб</button>
                </div>
            </div>
            <div class="col-sm-5 displayMoble">
                <div class="image-clip">
                    <img src="/bitrix/templates/remont/images/<?=$marka_lower?>/<?=$accord2[$this->_datas['orig_model_type']['0']['name']]?>.png"/>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="whitebg">
    <div class="container">
        <h2 class="title">Стоимость <?=tools::skl('service', $this->_suffics, $this->_datas['syns'][0], 'rp')?> <?=$this->_datas['model']['name']?></h2>
        <table class="price-table">
            <thead>
            <tr>
                <th>Наименование услуги</th>
                <th>Стоимость</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td><?=$diagnostic_name?></td>
                <td>
                    <span class="price"><?=$diagnostic_price?> руб</span>
                    <span class="time"><?=$diagnostic_time?></span>
                </td>
            </tr>
            <tr>
                <td><?=$service_name?></td>
                <td>
                    <span class="price"><?=$service_price?> руб</span>
                    <span class="time"><?=$service_time?></span>
                </td>
            </tr>
            </tbody>
        </table>
        <table class="price-table">
            <thead>
            <tr>
                <th>Наименование оборудования</th>
                <th>Стоимость</th>
            </tr>
            </thead>
            <tbody>
            <? foreach ($complect_to_services as $value):?>
                <tr class="complect">
                    <td><?=tools::mb_firstupper($value['name'])?></td>
                    <td>
                        <span class="price">от <?=tools::format_price($value['price'], $setka_name)?> руб</span>
                        <span class="time"><?=$availables[$value['available_id']]['name']?></span>
                    </td>
                </tr>
            <? endforeach; ?>
            </tbody>
        </table>

        <?php include __DIR__ . '/popular_moadl_section.php'; ?>
</section>


<?php
if ($iphone_text_data)
    $ask_text = sc::_createTree($iphone_text_data, $this->_datas['feed']);
else
    $ask_text = sc::_createTree($text2, $this->_datas['feed']);

include __DIR__ . '/ask_expert.php';
unset($ask_text);

$section_class = 'whitebg';
include __DIR__.'/preims.php';
unset($section_class);
