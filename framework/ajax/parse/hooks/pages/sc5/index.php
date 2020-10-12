<?

use framework\rand_it;
use framework\tools;
use framework\ajax\parse\hooks\sc;
use framework\pdo;

$marka = $this->_datas['marka']['name'];
$marka_lower = mb_strtolower($marka);
$marka_ru =  $this->_datas['marka']['ru_name'];
$accord = array('смартфон' => 'notebooks', 'ноутбук' => 'telefonov', 'планшет' => 'planshetov');

$new_temp_d = [];
foreach ($this->_datas['all_devices'] as $key => $device) {
    if (!empty($new_temp_d[$device['type']])) {
        unset($this->_datas['all_devices'][$key]);
    }
    $new_temp_d[$device['type']] = true;
}

$phone = $this->_datas['phone'];
$phone_format = tools::format_phone($phone, true);

$feed = tools::gen_feed($this->_datas['site_name']);

$vars = array();

$vars['f'][] = array('Диагностика','Экспресс диагностика','Диагностика телефона','Бесплатная диагностика','Комплексная диагностика','Диагностика смартфона');
$vars['f'][] = array('Замена Wi-Fi модулей','Ремонт/замена Wi-Fi','Замена Wi-Fi');
$vars['f'][] = array('Замена дисплеев','Замена экранов','Замена тачскринов','Замена сенсоров','Замена модулей экрана','Замена модуле дисплея');
$vars['f'][] = array('Ремонт цепей питания','Ремонт цепей питания плат');
$vars['f'][] = array('Замена материнских плат','Замена системных плат','Замена плат телефонов','Замена платы');
$vars['f'][] = array('Чистка телефонов','Чистка от пыли','Чистка смартфонов','Полная чистка');
$vars['f'][] = array('Замена мультиконтроллеров','Замена контроллеров плат','Ремонт мультиконтроллеров','Ремонт контроллеров плат');
$vars['f'][] = array('Замена разъемов HDMI','Замена HDMI','Замена модулей HDMI','Ремонт разъемов HDMI','Ремонт HDMI','Ремонт модулей HDMI');
$vars['f'][] = array('Замена разъемов USB','Замена портов USB','Замена USB','Ремонт разъемов USB','Ремонт портов USB','Ремонт USB ');
$vars['f'][] = array('Замена шлейфов','Ремонт шлейфов');
$vars['f'][] = array('Замена АКБ','Замена батарей','Замена аккумуляторов');
$vars['f'][] = array('Замена гнезд питания','Замена разъемов питания','Замена разъемов зарядки');
$vars['f'][] = array('Замена камер','Замена встроенных камер','Замена передних/задних камер');
$vars['f'][] = array('Замена микрофонов');
$vars['f'][] = array('Замена корпусов','Ремонт корпусов');
$vars['f'][] = array('Замена динамиков','Ремонт динамиков');
$vars['f'][] = array('Замена держателей сим','Замена сим холдеров','Замена sim holder','Замена сим лотков','Ремонт держателей сим','Ремонт сим лотков');
$vars['f'][] = array('Замена кнопок включения','Ремонт кнопок включения');
$vars['f'][] = array('Замена GPS','Замена модулей GPS','Ремонт GPS','Ремонт GPS модулей','Замена плат GPS','Ремонт плат GPS');
$vars['f'][] = array('Замена вибро','Замена вибромоторов','Замена модулей вибро','Ремонт вибро модулей');

$vars['p'][] = array('Диагностика','Экспресс диагностика','Комплексная диагностика','Бесплатная диагностика');
$vars['p'][] = array('Замена Wi-Fi модулей','Ремонт/замена Wi-Fi','Замена Wi-Fi');
$vars['p'][] = array('Замена дисплеев','Замена экранов','Замена тачскринов','Замена сенсоров','Замена модулей экрана','Замена модуля дисплея');
$vars['p'][] = array('Ремонт цепей питания','Ремонт цепей питания плат');
$vars['p'][] = array('Замена материнских плат','Замена системных плат','Замена плат планшетов','Замена плат');
$vars['p'][] = array('Полная чистка','Чистка от пыли','Чистка планшетов');
$vars['p'][] = array('Замена мультиконтроллеров','Замена контроллеров плат','Ремонт мультиконтроллеров','Ремонт контроллеров плат');
$vars['p'][] = array('Замена разъемов HDMI','Замена HDMI','Замена модулей HDMI','Ремонт разъемов HDMI','Ремонт HDMI','Ремонт модулей HDMI');
$vars['p'][] = array('Замена разъемов USB','Замена портов USB','Замена USB','Ремонт разъемов USB','Ремонт портов USB','Ремонт USB ');
$vars['p'][] = array('Замена шлейфов','Ремонт шлейфов');
$vars['p'][] = array('Замена АКБ','Замена батарей','Замена аккумуляторов');
$vars['p'][] = array('Замена гнезд питания','Замена разъемов питания','Замена разъемов зарядки','Замена зарядки');
$vars['p'][] = array('Замена камер','Замена встроенных камер','Замена передних/задних камер');
$vars['p'][] = array('Замена микрофонов');
$vars['p'][] = array('Замена корпусов','Ремонт корпусов');
$vars['p'][] = array('Замена динамиков','Ремонт динамиков');
$vars['p'][] = array('Замена держателей сим','Замена сим холдеров','Замена sim holder','Замена сим лотков','Ремонт держателей сим','Ремонт сим лотков');
$vars['p'][] = array('Замена кнопок включения','Ремонт кнопок включения');
$vars['p'][] = array('Замена GPS','Замена модулей GPS','Ремонт GPS','Ремонт GPS модулей','Замена плат GPS','Ремонт плат GPS');

$vars['n'][] = array('Диагностика','Экспресс диагностика','Диагностика ноутбука','Полная диагностика','Комплексная диагностика');
$vars['n'][] = array('Замена Wi-Fi модулей','Ремонт/замена Wi-Fi','Ремонт Wi-Fi модулей','Ремонт модулей Wi-Fi','Замена модулей Wi-Fi');
$vars['n'][] = array('Замена матриц экрана','Замена матриц','Замена экранов','Замена матриц дисплея');
$vars['n'][] = array('Ремонт цепей питания','Ремонт питания плат');
$vars['n'][] = array('Ремонт/замена видеокарт','Ремонт/замена видеочипов','Замена видеочипов','Реболл видеочипов');
$vars['n'][] = array('Замена накопителей HDD/SSD','Замена жестких дисков','Замена дисков HDD / SSD','Замена HDD и SSD');
$vars['n'][] = array('Замена/ремонт клавиатур','Ремонт клавиатур','Ремонт/замена клавиатур','Замена клавиатур');
$vars['n'][] = array('Прошивка BIOS','Перепрошивка BIOS','Настройка программ, BIOS','Настройка BIOS, ПО');
$vars['n'][] = array('Замена плат','Замена материнских плат','Замена платы ноутбуков');
$vars['n'][] = array('Замена оперативной памяти','Замена ОЗУ','Замена памяти (ОЗУ)');
$vars['n'][] = array('Чистка ноутбуков','Чистка от пыли','Полная чистка ноутбуков','Комплексная чистка');
$vars['n'][] = array('Замена кулеров','Замена вентиляторов','Замена охлаждения');
$vars['n'][] = array('Ремонт южных мостов','Замена южных мостов','Замена чипов южного моста','Ремонт чипов южного моста');
$vars['n'][] = array('Установка драйверов','Настройка драйверов');
$vars['n'][] = array('Замена мультиконтроллеров','Замена контроллеров плат','Ремонт мультиконтроллеров','Ремонт контроллеров плат');
$vars['n'][] = array('Замена разъемов HDMI','Замена HDMI','Замена модулей HDMI','Ремонт разъемов HDMI','Ремонт HDMI','Ремонт модулей HDMI');
$vars['n'][] = array('Замена разъемов USB','Замена портов USB','Замена USB','Ремонт разъемов USB','Ремонт портов USB','Ремонт USB');
$vars['n'][] = array('Замена звуковых карт','Ремонт звуковых карт','Замена звуковых плат','Ремонт звуковых плат');
$vars['n'][] = array('Замена шлейфов','Замена шлейфов матрицы');
$vars['n'][] = array('Ремонт северных мостов','Замена северных мостов','Замена чипов северного моста','Ремонт чипов северного моста');
$vars['n'][] = array('Замена АКБ','Замена батарей','Замена аккумуляторов');
$vars['n'][] = array('Замена блоков питания','Замена ЗУ','Замена зарядных устройств');
$vars['n'][] = array('Замена гнезд питания','Замена разъемов питания','Ремонт гнезд питания','Ремонт разъемов питания');
$vars['n'][] = array('Замена камер','Замена встроенных камер','Ремонт камер','Ремонт встроенных камер');
$vars['n'][] = array('Замена микрофонов','Ремонт микрофонов');
$vars['n'][] = array('Замена тачпадов','Замена модулей тачпад','Ремонт/замена тачпадов','Замена/ремонт тачпадов');

$h2 = array();
$h2[] = array('<p>Мы -');
$h2[] = array('сервисный центр', 'сервис центр');
$h2[] = array($this->_datas['servicename'].',');
$h2[] = array('наша специализация -');
$h2[] = array('ремонт');
$h2[] = array('техники','устройств','гаджетов');
//$h2[] = array('бренда', 'марки');
$h2[] = array($this->_datas['marka']['name'].'.', $this->_datas['marka']['ru_name'].'.');

$choose = rand(0, 1);
$count = count($this->_datas['all_devices'])-1;

/*switch ($choose)
{
    case 0:
    {
        $h2[] = array('умеем');

        $i = 0;
        foreach ($this->_datas['all_devices'] as $device)
        {
            $add = ($i == $count) ? ' '.$device['type_m'].'.' : ' '.$device['type_m'].',';
            $h2[] = array('чинить'.$add, 'восстанавливать'.$add, 'ремонтировать'.$add, 'настраивать'.$add);
            $i++;
        }
        break;
    }
    case 1:
    {
        $h2[] = array('знаем толк в');

        $i = 0;
        foreach ($this->_datas['all_devices'] as $device)
        {
            $add = ($i == $count) ? ' '.$device['type_rm'].'.' : ' '.$device['type_rm'].',';
            $h2[] = array('починке'.$add, 'восстановлении'.$add, 'ремонте'.$add, 'настройке'.$add);
            $i++;
        }
        break;
    }
}*/

switch ($choose)
{
    case 0:
        $h2[] = array('Ремонтируем', 'Восстанавливаем', 'Чиним');
        $h2[] = array('и настраиваем');
    break;
    case 1:
        $h2[] = array('Настраиваем и');
        $h2[] = array('ремонтируем', 'восстанавливаем', 'чиним');
    break;
}

$t = array();
foreach ($this->_datas['all_devices'] as $device)
{
    $t[] = $device['type_m'];
}

$h2[] = array(implode(', ', $t).'.');

$h2[] = array('Диагностика -');
$h2[] = array('бесплатная,');
$h2[] = array('цены -');
$h2[] = array('вменяемые,', 'фиксированные,');
$h2[] = array('оборудование -');
$h2[] = array('профессиональное,');
$h2[] = array('мастера -');
$h2[] = array('квалифицированные,','опытные,');
$h2[] = array('время ремонта - минимальное,','сроки ремонта - минимальные,');
$h2[] = array('оставляйте');
$h2[] = array('телефон','номер телефона');
$h2[] = array('или');
$h2[] = array('звоните:','набирайте:');

$h3 = array();
$h3[] = array('Уже более', 'Более');
$h3[] = array('1000', '1100', '1200', '1300', '1400', '1500', '1600', '1700', '1800', '1900', '2000', '2500');
$h3[] = array('жителей');
$h3[] = array($this->_datas['region']['name_re']);
$h3[] = array('доверили',);
$h3[] = array('нам');
$h3[] = array('ремонт своих гаджетов','ремонтировать свои гаджеты');
$h3[] = array($this->_datas['marka']['name'].' -', $this->_datas['marka']['ru_name'].' -');
$h3[] = array('ремонтируем на совесть!','чиним на совесть!');

$pluses = array();

$pluses[0] = '<div class="col-sm-6 col-xs-12 item"><div class="pluses-icon"><img src="/bitrix/templates/remont/images/shared/plus-1.svg"></div><div class="pluses-link">Среднее время ремонтных работ по сумме обращений - ';
$pluses[0] .= '<b>'.tools::declOfNum((integer) tools::get_rand(array('37','38', '39', '40', '41', '42', '43', '44', '45', '46', '47', '48', '49', '50', '51',
        '52', '53', '54', '55', '56', '57'), $feed), array('минута', 'минуты', 'минут')).'</b></div></div>';

$pluses[1] = '<div class="col-sm-6 col-xs-12 item"><div class="pluses-icon"><img src="/bitrix/templates/remont/images/shared/plus-3.svg"></div><div class="pluses-link">Процент возвратов на гарантийный ремонт - ';
$pluses[1] .= '<b>'.tools::get_rand(array('0,70%', '0,80%', '0,90%', '1,00%', '1,10%', '1,20%', '1,30%', '1,40%', '1,50%', '1,60%', '1,70%', '1,80%', '1,90%',
            '2,00%', '2,10%', '2,20%', '2,30%', '2,40%', '2,50%', '2,60%', '2,70%', '2,80%', '2,90%'), $feed).' '.tools::get_rand(array('аппаратов','устройств'), $feed).'</b></div></div>';

$pluses[2] = '<div class="col-sm-6 col-xs-12 item"><div class="pluses-icon"><img src="/bitrix/templates/remont/images/shared/plus-4.svg"></div><div class="pluses-link">На складе в ';
$pluses[2] .= tools::get_rand(array('постоянном', 'круглосуточном', 'ежедневном', 'повседневном'), $feed).' доступе более<br>'.
        '<b>'.tools::get_rand(array('9800', '9900', '10000', '10100', '10200', '10300', '10400', '10500', '10600', '10700', '10800', '10900', '11000', '11100', '11200',
        '11300', '11400', '11500', '11600', '11700', '11800', '11900', '12000', '12100', '12200', '12300', '12400', '12500', '12600', '12700', '12800', '12900',
        '13000', '13100', '13200', '13300', '13400', '13500', '13600', '13700', '13800', '13900', '14000', '14100', '14200', '14300', '14400', '14500',
        '14600', '14700', '14800', '14900', '15000', '15100', '15200'), $feed).' комплектующих</b></div></div>';

$pluses[3] = '<div class="col-sm-6 col-xs-12 item"><div class="pluses-icon"><img src="/bitrix/templates/remont/images/shared/plus-2.svg"></div><div class="pluses-link">Суммарный опыт ремонта '.$marka.' ';
$pluses[3] .=  'наших '.tools::get_rand(array('мастеров', 'специалистов', 'сервис инженеров', 'сервисных мастеров', 'сервисных специалистов'), $feed).' - '.
                     '<b>'.tools::declOfNum((integer) tools::get_rand(array('29', '30', '31', '32', '33', '34', '35', '36', '37', '38', '39', '40', '41', '42', '43', '44', '45', '46', '47', '48',
                            '49', '50', '51', '52', '53', '54', '55', '56', '57', '58', '59', '60', '61', '62', '63', '64', '65', '66', '67', '68'), $feed),
                            array('год','года','лет')).'</b></div></div>';

//$accord = array('смартфон' => 'telefonov', 'ноутбук' => 'notebooks', 'планшет' => 'planshetov', 'фотоаппарат' => 'foto');
//$accord2 = array('смартфон' => 'telefon', 'ноутбук' => 'notebook', 'планшет' => 'planshet', 'фотоаппарат' => 'foto');

$accord = $this->_datas['accord_url'];
$accord2 = $this->_datas['accord_image'];

$site_id = $this->_datas['site_id'];

/*<div class="service-text">
    <?=sc::_createTree($texts, $feed);?>
</div>*/

// Get from promo page
$moscow = ($this->_datas['region']['name'] == 'Москва');
$spb = ($this->_datas['region']['name'] == 'Санкт-Петербург' && $this->_datas['partner']['id'] == 27);

$point = $this->_datas['partner']['x'].','.$this->_datas['partner']['y'];

$request = [];
$request['op'] = 'dt';
$request['args']['mode'] = 'pattern_mas';
$request['args']['sid'] = $this->_datas['sid'];
$request['args']['setka'] = $this->_datas['setka_name'];

$answer_original = $answer = tools::connect_ciba($request);
$answer = json_decode($answer, true);
$answer = $answer['answer'];

if (!function_exists('setDefault')) {
    $default = [
        'table_h1' => 'Ремонт техники',
        'table_h2' => $marka,
        'table_text' => '- ремонт от 15 минут
- гарантия до 3 лет
- сервис в центре города
- бесплатный курьер по '. $this->_datas['region']['name_de'],
        'table_price' => 'от 390 руб',
    ];

    $setDefault = function ($key) use ($default) {
        if (array_key_exists($key, $default))
            return $default[$key];
        else
            throw new \Exception(sprintf('Default %s must by defined', $key));
    };
}

// Formatting table_text
$table_text = isset($answer['table_text']) ? $answer['table_text'] : $setDefault('table_text');
$table_textArr = explode("\n", $table_text);
$table_textHTML = '';

foreach ($table_textArr as $item)
    $table_textHTML .= sprintf('<li>%s</li>', trim($item));

$use_choose_city = $this->_datas['use_choose_city'];

$table_text = $table_textHTML;
unset($table_textHTML, $table_textArr);

include __DIR__.'/text/exclude.php';
include __DIR__.'/text/popular.php';
$merge_popular = get_popular($site_id, $marka_lower, $feed);


//echo '<div style="display:none">'.$this->_datas['site_name'].'</div>';

?>
<section class="inner-page gradient mainscreen">
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-xs-12 textblock">
                <h1>
                    <span class="smallh1"><?= isset($answer['table_h1']) ? $answer['table_h1'] : $setDefault('table_h1');?></span>
                    <span class="boldh1"><?= isset($answer['table_h2']) ? $answer['table_h2'] : $setDefault('table_h2');?></span> - в <?=$this->_datas['region']['name_pe']?>
                </h1>

                <!-- noindex -->
                <ul><?php // table text are formatted bellow comes as string? al item in <li> tag? with dash (- ) prefixed
                    echo $table_text;?></ul>

                <div class="title"><?= isset($answer['table_price']) ? $answer['table_price'] : $setDefault('table_price');?></div>
                <!-- /noindex -->

                <div class="block-button">
                    <button type="button"
                            class="callback-modal button button-reverse mr-20 <?=$marka_lower?>"
                            data-title="Запишитесь на ремонт"
                            data-button="записаться на ремонт"
                            data-textarea="ваша неисправность"
                            data-title-tip="и мы свяжемся с вами в течении 3х минут"
                    >записаться на ремонт</button>
                    <button type="button"
                            class="callback-modal button dell <?=$marka_lower?>"
                            data-title="Вызовите курьера на дом"
                            data-button="вызвать курьера"
                            data-textarea="ваш адрес и описание неисправности"
                            data-title-tip="Это бесплатно в пределах <?=(($moscow) ? 'МКАД' : 'города')?>. Перезвоним за 3 мин!"
                            data-textarea-tip="пример: <?=$courier_textarea_tip?>">бесплатный курьер</button>
                </div>
            </div>

            <div class="col-sm-6 displayMoble">
            <?php // if (file_exists('/var/www/www-root/data/www/sc5/bitrix/templates/remont/images/'.$marka_lower.'/'.$marka_lower.'.png')):?>
                    <div class="image-clip" style="background-image: url(/bitrix/templates/remont/images/<?=$marka_lower?>/<?=$marka_lower?>.png)"></div>
            <?php //  else:?>   
                <?php //if(in_array($marka_lower, array('cisco','ibm','oracle','intel','inspur','supermicro','nec'))):?>
                    <!--<div class="image-clip" style="background-image: url(/bitrix/templates/remont/images/stub/server.png)"></div>-->
                <?php // else: ?>
                    <!--<div class="image-clip" style="background-image: url(/bitrix/templates/remont/images/stub/stub.png)"></div>-->
                <?php // endif; ?> 
                    
            <?php  //endif;?>
                <!--<div class="image-clip" style="background-image: url(/bitrix/templates/remont/images/<?//=$marka_lower?>/<?//=$marka_lower?>.png)"></div>-->
            </div>
        </div>
    </div>
</section>

        <?php
        /*include_once "text/index.php";
        if (isset($indexText) && is_array($indexText)) {
          echo '<div style = "display: none;">';
          if (isset($indexText[$marka_lower]))
            renderIndexText($indexText[$marka_lower][0]);
          echo '</div>';
        }*/
        ?>


<section class="whitebg">
    <div class="container">
        <div class="row services-list">
            <?php foreach ($this->_datas['all_devices'] as $device) :
                    if (file_exists("/var/www/www-root/data/www/sc5/bitrix/templates/remont/images/".$marka_lower."/".$accord2[$device['type']]."-mini.png")){
                        $littleImg = "background-image: url(/bitrix/templates/remont/images/".$marka_lower."/".$accord2[$device['type']]."-mini.png)";
                    }else{
                        $littleImg = "background-image: url(/bitrix/templates/remont/images/stub/little/".$accord2[$device['type']].".png)";
                    }    
            ?>
                <div class="col-sm-4 col-xs-6">
                    <div class="item">
                        <a href="/remont-<?= $accord[$device['type']] ?>-<?= $marka_lower ?>/" class="service-link">
                            <div class="service-images contain-img"
                                 style="<?=$littleImg?>">
                                <img src="/bitrix/templates/remont/images/shared/empty-service.png"/>
                            </div>
                            <? if ($marka_lower == 'apple'):
                                $apple_device_type = array('ноутбук' => 'MacBook', 'планшет' => 'iPad', 'смартфон' => 'iPhone'); ?>
                                <div class="service-title"><?= (isset($apple_device_type[$device['type']]) ? $apple_device_type[$device['type']] : tools::mb_ucfirst($device['type'])) ?></div>
                            <? else: ?>
                                <div class="service-title"><?= tools::mb_ucfirst($device['type']) ?></div>
                            <?endif; ?>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <? if ($merge_popular): ?>
            <div class="index-popular">
                <h2>Популярные устройства</h2>
                <div class="model-list">
                    <ul class="row">
                        <? foreach ($merge_popular as $value): ?>
                            <li class="col-sm-3 col-xs-6">
                                <a href="/<?= tools::search_url($site_id, serialize(array('model_id' => $value['id']))) ?>/"><?= $value['name'] ?></a>
                            </li>
                        <? endforeach; ?>
                    </ul>
                </div>
            </div>
        <? endif; ?>
        <h2 class="displaySmaller">Запись на ремонт в 1 клик</h2>
        <?php
        include_once "text/index.php";
        $genText = false;
        if (isset($indexText) && is_array($indexText)) {
            if (isset($indexText[$marka_lower])) {
                renderIndexText($indexText[$marka_lower][0], 'displaySmaller text-justify');
                $genText = true;
            }
        }
        if (!$genText)
            echo str_replace('<p>', '<p class="displaySmaller">', sc::_createTree($h2, $feed));
        ?>
        <div class="block-button">
            <p class="phone mr-20"><i class="fa fa-phone"></i>
                <a href="tel:+<?= tools::cut_phone($this->_datas['phone']) ?>"><?= tools::format_phone($this->_datas['phone'], true) ?></a>
            </p>
            <button type="button"
                    class="callback-modal button margin-left-little no-margin-left-sm margin-top-little-sm <?=$marka_lower?>"
                    data-title="Запишитесь на ремонт"
                    data-button="записаться на ремонт"
                    data-textarea="ваша неисправность"
                    data-title-tip="и мы свяжемся с вами в течении 3х минут"
            >записаться на ремонт</button>
        </div>
    </div>
</section>

        <? include __DIR__.'/preims.php'; ?>


        <? include __DIR__.'/ask_expert.php'; ?>

        <section class="greybg">
            <div class="container">
                <h2 class="title">Статистика работы <?=$this->_datas['servicename']?> за год</h2>
                <div class="row pluses">
                    <?=implode('', rand_it::randMas($pluses, 4, '', $feed))?>
                </div>
                <?php
                if (isset($indexText) && is_array($indexText)) {
                  if (isset($indexText[$marka_lower])) {
                    renderIndexText($indexText[$marka_lower][3]);
                  }
                }
                ?>
            </div>
        </section>

        <? $add_section_class = '';
        if ($this->_datas['partner']['exclude']) $add_section_class = ' no-events';?>

        <section class="map-section mobile-top<?=$add_section_class?>">
             <? include __DIR__.'/contact-block.php'; ?>
        </section>
