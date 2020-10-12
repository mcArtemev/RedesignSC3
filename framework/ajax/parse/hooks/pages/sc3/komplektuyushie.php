<?

use framework\tools;
use framework\rand_it;
use framework\pdo;
use framework\ajax\parse\hooks\sc;

$marka = $this->_datas['marka']['name'];
$marka_ru = $this->_datas['marka']['ru_name'];
$marka_upper = mb_strtoupper($marka);
$marka_lower = mb_strtolower($this->_datas['marka']['name']);

$address = $this->_datas['region']['name'].', '.(($this->_datas['partner']['address2']) ? $this->_datas['partner']['address2'] : $this->_datas['partner']['address1']);

$sql =  "SELECT `model_types`.`name` as `type`, `model_types`.`id` as `type_id` FROM `m_model_to_sites`
    INNER JOIN `m_models` ON `m_models`.`id` = `m_model_to_sites`.`m_model_id`
        INNER JOIN `model_types` ON `m_models`.`model_type_id` = `model_types`.`id` WHERE `m_model_to_sites`.`site_id`= ? GROUP BY `model_types`.`name`";
$stm = pdo::getPdo()->prepare($sql);
$stm->execute(array($this->_datas['site_id']));
$suffics = $stm->fetchAll(\PDO::FETCH_ASSOC);

$str = '';

foreach ($this->_datas['all_devices'] as $suffics)
{
    $s = tools::get_suffics($suffics['type']);
    $table_name = $s.'_complect_to_m_models';
    $join_table = $s.'_complect_syns';
    $link_field = $s.'_complect_syn_id';
    $main_table = $s.'_complects';
    $main_table_field = $s.'_complect_id';

    $sql = "SELECT `{$join_table}`.`name` as `name`, `{$main_table}`.`id` as `id`
            FROM `{$table_name}`
                INNER JOIN `{$join_table}` ON `{$table_name}`.`{$link_field}` = `{$join_table}`.`id`
                INNER JOIN `{$main_table}` ON `{$join_table}`.`{$main_table_field}` = `{$main_table}`.`id`
            WHERE `{$table_name}`.`type` = 3 AND `{$table_name}`.`site_id`=:site_id
        AND `{$table_name}`.`marka_id`=:marka_id AND `{$table_name}`.`model_type_id`=:model_type_id";

    $stm = pdo::getPdo()->prepare($sql);
    $stm->execute(array('site_id' => $this->_datas['site_id'], 'marka_id' => $this->_datas['marka_id'], 'model_type_id' => $suffics['type_id']));

    $vals = $stm->fetchAll(\PDO::FETCH_ASSOC);

    $vals = rand_it::randMas($vals, 5, '', $this->_datas['feed']);

    $str .= '<div class="tables"><div class="title">'.tools::mb_ucfirst($suffics['type']).'</div><ul class="popularlist">';
    foreach ($vals as $syn)
    {
        $href = tools::search_url($this->_datas['site_id'], serialize(array('model_type_id' => $suffics['type_id'], 'marka_id' => $this->_datas['marka_id'], 'key' => 'complect', 'id' => $syn['id'])));
        $str .= '<li><a href="/'.$href.'/">'.tools::mb_firstupper($syn['name']).'</a></li>';
    }
    $str .= '</ul></div>';
}

$texts = array();
$texts[] = array('<p>В нашей ремонтной лаборатории', '<p>В нашей лаборатории', '<p>На нашем локальном складе лаборатории',
            '<p>В нашей ремонтной мастерской', '<p>В нашей мастерской', '<p>На нашем локальном складе, в мастерской');
$texts[] = array('по адресу:');
$texts[] = array($address.',');
$texts[] = array('всегда', 'постоянно', '');
$texts[] = array('есть в наличии', 'есть', 'присутствует');
$texts[] = array('большинство', 'большая часть');
$texts[] = array('популярных', 'распространенных', 'часто используемых', 'часто требующихся', 'часто востребованных',
            'часто необходимых');
$texts[] = array('комплектующих', 'запчастей', 'запасных частей');
$texts[] = array('и');
$texts[] = array('все', 'все необходимые');
$texts[] = array('расходные материалы:', 'все расходники:', 'все расходные материалы:', 'любые расходные материалы:');

$t_array = array();
$t_array[] = array('ШИМы', 'ШИМ контроллеры','PWM контроллеры', 'ШИМ (PWM) контроллеры', 'ШИМ-контроллеры', 'контроллеры PWM');
$t_array[] = array('микросхемы', 'чипы', 'оригинальные чипы', 'оригинальные чипы/микросхемы');
$t_array[] = array('транзисторы', 'диоды/транзисторы',	'конденсаторы, транзисторы', 'конденсаторы, диоды', 'резисторы, транзисторы, конденсаторы',	'резисторы, конденсаторы');
$t_array[] = array('термопаста', 'термопрокладки', 'термоклей',	'термоскотч', 'термоклеи/термопасты', 'термопасты, термопрокладки');
$t_array[] = array('BGA шары для реболла', 'BGA шарики разного диаметра', 'BGA шарики', 'свинцовые BGA шары', 'BGA шарики для реболлла', 'свинцовые BGA шары для реболла');
$t_array[] = array('флюс', 'BGA флюс', 'флюс BGA');
$t_array[] = array('винты', 'наборы винтов', 'болтики', 'запасы винтов');
$t_array[] = array('сокеты', 'сокеты для материнских плат',	'сокеты для плат', 'сокеты материнских плат', 'сокеты плат');
$t_array[] = array('разъемы', 'разъемы питания', 'разъемы, шлейфы',	'шлейфы, разъемы питания', 'разъемы платы, шлейфы',	'шлейфы, разъемы');
$t_array[] = array('штекеры', 'штекеры и шнуры питания', 'оплетки, штекеры', 'спреи', 'спреи, очищающие жидкости',	'штекеры, оплетки, спреи');
$t_array[] = array('процессоры', 'микропроцессоры', 'CPU', 'процессоры (CPU)');
$t_array[] = array('жесткие диски',	'ssd/hdd носители',	'ssd, hdd винчестеры',	'ssd, hdd диски',	'жесткие ssd/hdd диски', 'ssd, hdd диски разных объемов');
$t_array[] = array('оперативная память', 'ОЗУ', 'комплекты ОЗУ', 'оперативная память (ОЗУ)', 'ОЗУ (оперативная память)', 'наборы ОЗУ');

$feed = $this->_datas['feed'];
srand($feed);
$t_array = rand_it::randMas($t_array, rand(4, 6), '', $feed);
$count = count($t_array) - 1;

foreach ($t_array as $key => $value)
{
    foreach ($value as $k => $v)
    {
        if ($key != $count)
           $t_array[$key][$k] = $v.';';
        else
           $t_array[$key][$k] = $v.'.';
    }

    $texts[] = $t_array[$key];
}

$texts[] = array('Редкие комплектующие,', 'Редко используемые комплектующие,');
$texts[] = array('которые могут понадобиться в ходе');
$texts[] = array('ремонта', 'ремонтных работ');
$texts[] = array('дозаказываются', 'заказываются');
$texts[] = array('ежедневно -');
$texts[] = array('это');
$texts[] = array('позволяет', 'дает возможность');
$texts[] = array('гарантировать');
$texts[] = array('клиентам');
$texts[] = array('сервиса', 'сервисного центра', 'сервис центра');
$texts[] = array($this->_datas['servicename']);

$choose = rand(0, 1);
switch ($choose)
{
    case 0:
        $texts[] = array('оптимальные', 'лучшие');
        $texts[] = array('сроки доставки');
    break;
    case 1:
        $texts[] = array('оптимальное', 'лучшее');
        $texts[] = array('время доставки');
    break;
}

$texts[] = array('с центрального склада', 'с главного склада');
$texts[] = array('и оперативный ремонт.</p>');

$total = array();
$total[] = array('<p>Гарантия на');
$total[] = array('устанавливаемые');
$total[] = array('в '.$this->_datas['servicename']);
$total[] = array('комплектующие','запчасти','запасные части');
$total[] = array('от 6 месяцев до 3 лет</p>', 'до 3 лет</p>');

$this->_datas['total'] = sc::_createTree($total, $feed);

?>
        <div class="title-row">
            <div class="container">
                <h1><?=$this->_ret['h1']?></h1>
            </div>
        </div>

        <? $banner_img = '/templates/moscow/img/shared/banners/'.$this->_datas['images']['komplektuyushie'];
        include __DIR__.'/banner.php'; ?>

        <div class="aboutrow">
            <div class="container">
                <div class="abouttext">
                   <?=sc::_createTree($texts, $feed);?>
                </div>
            </div>
        </div>

        <div class="popularrow">
            <div class="container">
                <h2>Популярные комплектующие</h2>
                <div class="tables-wrapper">
                    <?=$str;?>
                </div>
            </div>
        </div>

         <? include __DIR__.'/banner-total.php'; ?>

         <?=$this->_datas['preims']?>

        <ul class="breadcrumb">
            <li><a href="/">Главная</a></li>
            <li>Качественные комплектующие</li>
        </ul>
