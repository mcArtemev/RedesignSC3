<?php

use framework\tools;
use framework\rand_it;
use framework\ajax\parse\hooks\sc;
use framework\pdo;

$site_id = $this->_site_id;
$model_type = $this->_datas['model_type'][3];
$model_type_id = $this->_datas['model_type']['id'];
$marka_id = $this->_datas['marka']['id'];
$region_name_pe = $this->_datas['region']['name_pe'];
$marka_lower = mb_strtolower($this->_datas['marka']['name']);
$apple_device_type = array('ноутбук' => 'MacBook', 'планшет' => 'iPad', 'смартфон' => 'iPhone');
$feed = tools::gen_feed($this->_datas['site_name']);

$ring = 20;
$half_ring = $ring / 2;
 
$m_models_table = 'm_models';
$m_models_link = 'm_model_id';

$ex = array('marka_id' => $marka_id, 'model_type_id' => $model_type_id, 'site_id' => $site_id);
$cond_model = "`m_models`.`marka_id`=:marka_id AND `m_models`.`model_type_id`=:model_type_id";

$sql = "SELECT `models`.`id` as `id`, `models`.`name` as `name` FROM `model_to_sites`
                INNER JOIN `sites` ON `sites`.`id`=`model_to_sites`.`site_id`
                INNER JOIN `models` ON `models`.`id`=`model_to_sites`.`model_id`
                INNER JOIN `{$m_models_table}` ON `{$m_models_table}`.`id`=`models`.`{$m_models_link}`
                    WHERE {$cond_model} AND `model_to_sites`.`site_id`=:site_id ORDER BY `models`.`id`";

$stm = pdo::getPdo()->prepare($sql);
$stm->execute($ex);
$data = $stm->fetchAll(\PDO::FETCH_ASSOC);

include __DIR__.'/text/exclude.php';

$exclude = get_exclude();
     
foreach ($data as $key => $value)
    if (in_array($value['id'], $exclude)) unset($data[$key]);   
    
$data = array_values($data);      

$count = count($data);

if ($this->_mode == -2)
{
    $model_id = $this->_datas['model']['id'];
    $full_type_name = $model_type['name_re'].' '.$this->_datas['model']['name'];
    $full_name = $this->_datas['model']['name'];
    $model_name = $this->_datas['model']['name'];
    
    $default_scheme = true;
    
    include __DIR__.'/text/popular.php';
    
    $suffics = $this->_suffics;
    $merge_popular = get_popular($site_id, $marka_lower, $feed);
    
    if ($merge_popular)
    {  
        $popular_by_suffics = [];
        
        foreach ($merge_popular as $value)
            $popular_by_suffics[$value['suffics']][] = $value;
        
        if (isset($popular_by_suffics[$suffics]))
        { 
            $position = -1;
            $i = 0;
            
            foreach ($popular_by_suffics[$suffics] as $value)
            {
                if ($value['name'] == $model_name) $position = $i;
                $i++;
            }
            
            if ($position != -1)
            { 
                $t = [];
                foreach ($data as $value)
                    if ($value['name'] != $model_name) $t[] = $value;
                    
                $count_t = count($t);
                $count_suff = count($popular_by_suffics[$suffics]);
                $step = $count_t / $count_suff;
                $step = ceil($step / 4) * 4;
                
                if ($step > $count_t) $step = $count_t;
                  
                $start = ($position * $step) % $count_t;
                $end = $start + $step;
                                
                //echo '<div style="display:none">'.$count_t.' '.$step.' '.$position.' '.print_r($t, true).' '.$count_suff.' '.$start.' '.$end.'</div>';
                
                $c = $start;
                for ($i = $start; $i < $end; $i++)
                {
                    if ($i == $count_t) $c = 0;
                    $this->_datas['all_models'][] = $t[$c];                    
                    $c++;
                }
                              
                $default_scheme = false;
            }                                                   
        }
    }
    
    
    if ($default_scheme)
    {
        if ($count <= $ring)
        {
            $this->_datas['all_models'] = rand_it::randMas($data, $count, '', $this->_datas['feed']);
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
    
            $this->_datas['all_models'] = $t_m;
        }
    }
}

if ($this->_mode == -3)
{
    $this->_datas['all_models'] = $data;
    
    if ($marka_lower == 'apple')
        $full_name = $full_type_name = $apple_device_type[$this->_datas['orig_model_type'][0]['name']];
    else
        $full_name = $full_type_name = $model_type['name_rm'].' '.$this->_datas['marka']['name'];
}

$count_models = count($this->_datas['all_models']);
if ($count_models > 100) $count_models = 100;
$this->_datas['all_models'] = rand_it::randMas($this->_datas['all_models'], $count_models, '', $this->_datas['feed']);

$setka_name = $this->_datas['setka_name'];

$eds = $this->_datas['eds'];
$availables = $this->_datas['availables'];

$all_services =  $this->_datas['all_services'];
$all_complects = $this->_datas['all_complects'];


srand($this->_datas['feed']);

$text1 = array();
$choose = rand(0, 1);

switch ($choose)
{
    case 0:
        $text1[] = array('Мы ремонтируем', 'Мы чиним', 'Мы восстанавливаем');
        foreach ($this->_datas['orig_model_type'] as $type)
            $t_array[] = $type['name_m'];

        $text1[] = $t_array;
    break;
    case 1:
        $text1[] = array('Мы восстанавливаем работоспсобность', 'Мы проводим ремонт',
            'Мы производим ремонт', 'Мы занимаемся ремонтом', 'Мы занимаемся починкой', 'Мы занимаемся восстановлением',
                'Мы занимаемся восстановлением работоспособности');

        $t_array = array();
        foreach ($this->_datas['orig_model_type'] as $type)
            $t_array[] = $type['name_rm'];

        $text1[] = $t_array;
    break;
}

srand($this->_datas['f']);

$choose = rand(0, 7);

switch ($choose)
{
    case 0:
        $text1[] = array('3 года', 'больше 3 лет', 'более 3 лет', 'три года', 'больше трех лет', 'более трех лет');
    break;
    case 1:
        $text1[] = array('7 лет', 'больше 7 лет', 'более 7 лет', 'семь лет', 'больше семи лет', 'более семи лет');
    break;
    case 2:
       $text1[] = array('4 года', 'больше 4 лет', 'более 4 лет', 'четыре года', 'больше четырех лет', 'более четырех лет');
    break;
    case 3:
       $text1[] = array('8 лет', 'больше 8 лет', 'более 8 лет', 'восемь лет', 'больше восьми лет', 'более восьми лет');
    break;
    case 4:
       $text1[] = array('9 лет', 'больше 9 лет', 'более 9 лет', 'девять лет', 'больше девяти лет', 'более девяти лет');
    break;
    case 5:
       $text1[] = array('5 лет', 'больше 5 лет', 'более 5 лет', 'пять лет', 'больше пяти лет', 'более пяти лет');
    break;
    case 6:
       $text1[] = array('6 лет', 'больше 6 лет', 'более 6 лет', 'шесть лет', 'больше шести лет', 'более шести лет');
    break;
    case 7:
       $text1[] =  array('10 лет', 'больше 10 лет', 'более 10 лет', 'десять лет', 'больше десяти лет', 'более десяти лет');
    break;
}

srand($this->_datas['feed']);

$choose = rand(0, 1);

switch ($choose)
{
    case 0:
        $text1[] = array('и знаем о ремонте');
        $text1[] = array($full_type_name);
        $text1[] = array('все!', 'абсолютно все!');
    break;
    case 1:
        $text1[] = array('и умеем ремонтировать', 'и умеем чинить');
        $text1[] = array('все', 'абсолютно все');
        $text1[] = array('неисправности', 'поломки', 'модели');
        $text1[] = array($full_type_name.'.');
    break;
}

$choose_r = rand(0, 1);
$t_masters = array();
$t = array('мастеров', 'штатных мастеров', 'сервисных мастеров', 'ремонтных мастеров', 'мастеров ремонтников', 'штатных мастеров ремонтников', 'сервисных мастеров ремонтников');
foreach ($t as $v)
{
    $t_masters[0][] = $v;
    $t_masters[1][] = $v.' '.$this->_datas['servicename'];
}

$choose_2 = rand(0, 1);
for ($i = 0; $i < 2; $i++)
{
    if ($i == $choose_2)
    {
        $text1[] = array('Образование и большой опыт', 'Знания и накопленный опыт', 'Накопленные знания и регулярная практика', 'Образование и навыки', 'Образование и опыт', 'Опыт и образование', 'Регулярная практика', 'Постоянная практика', 'Ежедневная практика', 'Большой опыт', 'Высокая квалификация',
                'Многолетний опыт', 'Опыт и практика', 'Опыт и навыки', 'Опыт и знания', 'Опыт и квалификация', 'Практика и опыт', 'Навыки и опыт',
                'Знания  и опыт', 'Квалификация и опыт', 'Квалификация и навыки', 'Квалификация и знания', 'Квалификация и практика', 'Опыт и квалификация',
                'Навыки и квалификация', 'Знания и квалификация', 'Регулярная практика и квалификация', 'Ежедневная практика и квалификация', 'Постоянная практика и квалификация',
                'Регулярная практика и квалификация', 'Многолетняя практика и квалификация', 'Образование и многолетняя практика', 'Навыки и квалификация', 'Знания и многолетний опыт');

        $text1[] = $t_masters[$choose_r];

        $text1[] = array('позволяет', 'дает возможность');
        $text1[] = array('нам', '');
        $text1[] = array('гарантировать');
        $text1[] = array('стабильную работу', 'устойчивую работу');

        /*if ($this->_mode == -2)
            $text1[] = array($model_type['name_re']);
        else
            $text1[] = array($model_type['name_re'].' '.$this->_datas['marka']['name']);*/

        $text1[] = array('после любого ремонта.', 'после ремонта любой сложности.', 'после любых видов ремонта.', 'после любых видов ремонтных работ.',
                    'после ремонта любого вида сложности.', 'после ремонта любого уровня сложности.');
    }
    else
    {
        $text1[] = array('Наша лаборатория в '.$region_name_pe, 'Наша техническая лаборатория в '.$region_name_pe);
        $text1[] = array('оснащена', 'оборудована');
        $text1[] = array('профессиональными', 'высокопрофессиональными', 'специализированными', 'фирменными', 'новейшими профессиональными',
                        'новейшими высокопрофессиональными', 'новейшими специализированными', 'новейшими фирменными', 'новейшими', '');

        $choose = rand(0, 1);

        switch ($choose)
        {
            case 0:
                $text1[] = array('инфракрасными', 'ИК');
                $text1[] = array('паяльными станциями', 'ремонтными системами', 'ремонтными станциями', 'паяльными системами', 'паяльными комплексами', 'ремонтными комплексами',
                    'паяльно-ремонтными комплексами', 'паяльно-ремонтными системами', 'паяльно-ремонтными центрами', 'паяльно-ремонтными станциями');
                $text1[] = array('ERSA IR550A PLUS', 'ERSA HR100AHP', 'ERSA PCBXY');
                $text1[] = array('для монтажа BGA элементов.', 'для монтажа BGA компонент.', 'для монтажа/демонтажа BGA компонент.', 'для монтажа BGA элементов.');
            break;
            case 1:
                $text1[] = array('паяльными станциями', 'ремонтными системами', 'ремонтными станциями', 'паяльными системами', 'паяльными комплексами', 'ремонтными комплексами',
                    'паяльно-ремонтными комплексами', 'паяльно-ремонтными системами', 'паяльно-ремонтными центрами', 'паяльно-ремонтными станциями');
                $text1[] = array('ERSA IR550A PLUS', 'ERSA HR100AHP', 'ERSA PCBXY');
                $text1[] = array('с ИК нагревом.', 'с ИК подогревом.', 'с верхним/нижним ИК подогревом.', 'с верхним/нижним ИК нагревом.', 'с нижним/верхним ИК подогревом.', 'с нижним/верхним ИК нагревом.');
            break;
        }
    }
}

$text1[] =  array('Больше', 'Более', '');

$text1[] = array(tools::get_rand(array('80%', '75%', '70%', '65%', '60%'), $this->_datas['f']));

srand($this->_datas['feed']);

$choose = rand(0, 1);

switch ($choose)
{
    case 0:
        $text1[] = array('устройств,', 'аппаратов,', 'гаджетов,');
        $text1[] = array('поступающих');
        if ($choose_r == 1)
            $text1[] = array('в сервис', 'в центр', 'в сервис центр', 'в сервисный центр', 'в мастерскую', 'в лабораторию', 'в лабораторию центра', 'в наш сервис', 'в наш центр', 'в наш сервис центр', 'в наш сервисный центр', 'в нашу мастерскую', 'в нашу лабораторию');
        else
            $text1[] = array('в сервис '.$this->_datas['servicename'], 'в центр '.$this->_datas['servicename'],
                    'в сервис центр '.$this->_datas['servicename'], 'в сервисный центр '.$this->_datas['servicename'], 'в мастерскую '.$this->_datas['servicename'], 'в лабораторию '.$this->_datas['servicename'],
                            'в лабораторию центра '.$this->_datas['servicename'], 'в лабораторию сервис центра '.$this->_datas['servicename']);
    break;
    case 1:
        $text1[] = array('устройств', 'аппаратов', 'гаджетов');
    break;
}

$text1[] = array('удается отремонтировать', 'удается починить', 'ремонтируются', 'удается восстановить');

$choose = rand(0, 1);

switch ($choose)
{
    case 0:
        $text1[] = array('в течение', 'быстрее');
        $text1[] = array('суток.', 'одних суток.', 'одного дня.', '24 часов.');
    break;
    case 1:
        $text1[] = array('за');
        $text1[] = array('сутки.', 'одни сутки.', 'один день.', '24 часа.');
    break;
}

$text2 = array();
$text2[] = array('Ежедневно');
$text2[] = array('помогаем решать проблемы', 'помогаем устранять неисправности', 'помогаем устранять поломки', 'оказываем помощь');
$text2[] = array('десяткам жителей');
$text2[] = array($this->_datas['region']['name_re'].',');
$text2[] = array('устраняя');
$text2[] = array('любые', 'любые, даже самые сложные', 'самые сложные');
$text2[] = array('аппаратные', 'программные', 'аппаратные и программные', 'программные и аппаратные');
$text2[] = array('неполадки', 'ошибки');

$t_array = array();
$t1 = array($this->_datas['marka']['name'], $this->_datas['marka']['ru_name']);

foreach ($this->_datas['orig_model_type'] as $type)
    foreach ($t1 as $t1_value)
        $t_array[] = 'в работе '.$type['name_rm'].' '.$t1_value.'.';

$text2[] = array_merge(array('в работе устройств '.$this->_datas['marka']['name'].'.', 'в работе устройств '.$this->_datas['marka']['ru_name'].'.',
    'в работе техники '.$this->_datas['marka']['name'].'.', 'в работе техники '.$this->_datas['marka']['ru_name'].'.',
    'устройств '.$this->_datas['marka']['name'].'.', 'устройств '.$this->_datas['marka']['ru_name'].'.',
    'техники '.$this->_datas['marka']['name'].'.', 'техники '.$this->_datas['marka']['ru_name'].'.'), $t_array);

$text2[] = array('REMONT CENTRE:');

$t = array();
$t[] = array('лучшие сроки ремонта', 'оптимальные сроки ремонта', 'сжатые сроки ремонт', 'кратчайшие сроки ремонта');
$t[] = array('бесплатные консультации по телефону', 'бесплатные консультации', 'бесплатная горячая линия');
$t[] = array('лучшее оборудование', 'современное оборудование', 'фирменное оборудование', 'профессиональное оборудование');
$t[] = array('гарантии на все работы', 'гарантии на любой ремонт', 'гарантии на все услуги', 'гарантии на все услуги и комплектующие',
        'гарантии на все комплектующие и услуги', 'гарантии на все ремонтные работы');
$t[] = array('бесплатная экспресс диагностика', 'бесплатная срочная диагностика', 'бесплантная диагностика', 'срочная диагностика', 'экспресс диагностика');
$t[] = array('оригинальные запчасти', 'оригинальные комплектующие', 'все комплектующие в наличии');

$mas = rand_it::randMas($t, 4, '', $this->_datas['feed']);
$count = count($mas)-1;
$i = 0;
foreach ($mas as $key => $val)
{
    $add = ($i == $count) ? '.' : ',';
    foreach ($val as $k => $v)
    {
        $mas[$key][$k] .= $add;
    }
    $text2[] = $mas[$key];
    $i++;
}

$accord = array('смартфон' => 'telefonov', 'ноутбук' => 'notebooks', 'планшет' => 'planshetov');
$accord2 = array('смартфон' => 'telefon', 'ноутбук' => 'notebook', 'планшет' => 'planshet');

$t_array = array();
$swap = array('p' => 1, 'n' => 1, 'f' => 1);

foreach ($all_services as $key => $value)
{
    // echo $value[$this->_suffics.'_service_id'] . ' - ' . $swap[$this->_suffics] . '<br>';
    if ($value[$this->_suffics.'_service_id'] == $swap[$this->_suffics])
    {
        $swap_key = $key;
        break;
    }
}

// $a = $all_services[0];
// $all_services[0] = $all_services[$swap_key];
// $all_services[$swap_key] = $a;

?>

<section class="inner-page gradient page">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="breadcrumbs">
                    <? if ($this->_mode == -2): ?>
                        <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url"
                                                                                            href="/"><span
                                        itemprop="title">Главная</span></a></span>
                        &nbsp;|&nbsp;<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url"
                                                                                                         href="/<?= tools::search_url($site_id, serialize(array('model_type_id' => $model_type_id, 'marka_id' => $marka_id))) ?>/">
                            <? if ($marka_lower == 'apple'): ?>
                                <span itemprop="title"><?= $apple_device_type[$this->_datas['orig_model_type'][0]['name']] ?></span>
                            <? else: ?>
                                <span itemprop="title"><?= tools::mb_ucfirst($this->_datas['orig_model_type'][0]['name']) ?></span>
                            <? endif; ?>
                        </a></span>
                        &nbsp;|&nbsp;<span>Ремонт <?= $this->_datas['model']['name'] ?></span>
                    <? endif; ?>
                    <? if ($this->_mode == -3): ?>
                        <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url"
                                                                                            href="/"><span
                                        itemprop="title">Главная</span></a></span>
                        &nbsp;|&nbsp;
                        <? if ($marka_lower == 'apple'): ?>
                            <span><?= $apple_device_type[$this->_datas['orig_model_type'][0]['name']] ?></span>
                        <? else: ?>
                            <span><?= tools::mb_ucfirst($this->_datas['orig_model_type'][0]['name']) ?></span>
                        <? endif; ?>
                    <? endif; ?>
                </div>
            </div>
            <div class="col-sm-7 textblock">
                <h1><span class="smallh1"><?= $this->_ret['h1'] ?></span></h1>
                <?php
                include_once "text/index.php";
                $genText = false;
                if (isset($hubText) && is_array($hubText)) {
                    if (isset($hubText[$marka_lower])) {
                        renderIndexText($hubText[$marka_lower][0]);
                        $genText = true;
                    }
                }
                if (!$genText) {
                    echo '<p>' . sc::_createTree($text1, $this->_datas['feed']) . '</p>';
                }
                ?>
                <div class="title">от 390 руб</div>
                <div class="block-button">
                    <button type="button"
                            class="callback-modal button button-reverse mr-20 <?= $marka_lower ?>"
                            data-title="Запишитесь на ремонт"
                            data-button="записаться на ремонт"
                            data-textarea="ваша неисправность"
                            data-title-tip="и мы свяжемся с вами в течении 3х минут"
                    >записаться на ремонт
                    </button>
                    <button type="button"
                            class="callback-modal button dell <?= $marka_lower ?>"
                            data-title="Вызовите курьера на дом"
                            data-button="вызвать курьера"
                            data-textarea="ваш адрес и описание неисправности"
                            data-title-tip="Это бесплатно в пределах <?= (($moscow) ? 'МКАД' : 'города') ?>. Перезвоним за 3 мин!"
                            data-textarea-tip="пример: <?= $courier_textarea_tip ?>">бесплатный курьер
                    </button>
                </div>
            </div>
            <div class="col-sm-5 displayMoble">
                <div class="image-clip">
                    <?
                    $accord_f_name = $accord2[$this->_datas['orig_model_type']['0']['name']];
                    if ($this->_mode == -3)
                        $file_name = $marka_lower . '/' . $accord_f_name;
                    else {
                        srand($this->_datas['f']);
                        $choose = rand(0, 1);
                        $model = str_replace(array(' ', '.', '-'), '_', mb_strtolower($this->_datas['model']['name']));
                        if ($choose)
                            $file_name = $accord_f_name . '/' . $model;
                        else
                            $file_name = $marka_lower . '/' . $accord_f_name . '_' . $model;
                    }
                    ?>
                    <img src="/bitrix/templates/remont/images/<?= $file_name ?>.png"/>

                </div>
            </div>
        </div>
    </div>
</section>

<section class="whitebg">
    <div class="container">
        <div class="prices">
            <h2 class="title">Цены на услуги по ремонту <?= $full_type_name ?></h2>
            <table class="price-table">
                <thead>
                <tr>
                    <th>Наименование услуги</th>
                    <th>Стоимость</th>
                </tr>
                </thead>
                <tbody>
                <? foreach ($all_services as $value): ?>
                    <tr>
                        <td>
                            <?php if ($this->_mode == -2) { ?>
                                <a href="/<?= tools::search_url($site_id, serialize(array('model_id' => $model_id, 'key' => 'service', 'id' => $value[$this->_suffics . '_service_id']))) ?>/"><?= tools::mb_firstupper($value['name']) ?></a>
                            <?php } else { ?>
                                <?= tools::mb_firstupper($value['name']) ?>
                            <?php } ?>
                        </td>
                        <? $star_str = '';
                        if ($value[$this->_suffics . '_service_id'] == 1) $star_str = '*'; ?>
                        <td>
                            <span class="price"><?= tools::format_price($value['price'], $setka_name) ?><?= $star_str ?> руб</span>
                            <span class="time"><?= tools::format_time($value['time_min'], $value['time_max'], $eds[$value[$this->_suffics . '_service_id']]['ed_time']); ?></span>
                        </td>
                    </tr>
                <? endforeach; ?>
                </tbody>
            </table>
            <?php
            if (isset($hubText) && is_array($hubText)) {
                if (isset($hubText[$marka_lower])) {
                    renderIndexText($hubText[$marka_lower][2]);
                    //$genText = true;
                }
            }
            ?>
            <p>* цена при проведении ремонта</p>
        </div>


        <h2 class="title">Комплектующие для <?= $full_type_name ?></h2>
        <table class="price-table">
            <thead>
            <tr>
                <th>Наименование оборудования</th>
                <th>Стоимость</th>
            </tr>
            </thead>
            <tbody>
            <? foreach ($all_complects as $value): ?>
                <tr class="complect">
                    <td><?= tools::mb_firstupper($value['name']) ?></td>
                    <td>
                        <span class="price">от <?= tools::format_price($value['price'], $setka_name) ?> руб</span>
                        <span class="time"><?= $availables[$value['available_id']]['name'] ?></span>
                    </td>
                </tr>
            <? endforeach; ?>
            </tbody>
        </table>
        <?php
        if (isset($hubText) && is_array($hubText)) {
            if (isset($hubText[$marka_lower])) {
                renderIndexText($hubText[$marka_lower][3]);
                //$genText = true;
            }
        }
        ?>
    <?php include __DIR__ . '/popular_moadl_section.php'; ?>
</section>

<?php include __DIR__ . '/ask_expert.php'; ?>
<?php
$section_class = 'whitebg';
include __DIR__.'/preims.php';
unset($section_class);
?>
