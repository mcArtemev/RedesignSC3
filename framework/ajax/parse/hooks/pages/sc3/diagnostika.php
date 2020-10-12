<?

use framework\tools;
use framework\rand_it;
use framework\pdo;
use framework\ajax\parse\hooks\sc;

$marka = $this->_datas['marka']['name'];
$marka_ru = $this->_datas['marka']['ru_name'];
$marka_upper = mb_strtoupper($marka);
$marka_lower = mb_strtolower($this->_datas['marka']['name']);

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
    $table_name = $s.'_service_to_m_models';
    $join_table = $s.'_service_syns';
    $link_field = $s.'_service_syn_id';
    $main_table = $s.'_services';
    $main_table_field = $s.'_service_id';

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
        $href = tools::search_url($this->_datas['site_id'], serialize(array('model_type_id' => $suffics['type_id'], 'marka_id' => $this->_datas['marka_id'], 'key' => 'service', 'id' => $syn['id'])));
        $str .= '<li><a href="/'.$href.'/">'.tools::mb_firstupper($syn['name']).'</a></li>';
    }
    $str .= '</ul></div>';
}

$texts = array();
$texts[] = array('<p>Диагностика -', '<p>Комплексная диагностика -');
$texts[] = array('важный');
$texts[] = array('этап');
$texts[] = array('ремонта');
$texts[] = array('любого устройства,', 'любого гаджета,', 'любой модели устройства,', 'любой техники,');
$texts[] = array('только');
$texts[] = array('ознакомившись');
$texts[] = array('с причинами');
$texts[] = array('неисправности', 'поломки');
$texts[] = array('и проведя ');
$texts[] = array('техническое', '');
$texts[] = array('программное и аппаратное', 'аппаратное и программное');
$texts[] = array('тестирование');
$texts[] = array('можно');
$texts[] = array('делать оценку');
$texts[] = array('сроков и стоимости', 'стоимости и сроков');
$texts[] = array('ремонта.', 'ремонтных работ.', 'любого ремонта.', 'любых ремонтных работ.');

$texts[] = array('Не имея', 'Не имея на руках');
$texts[] = array('результатов', 'итоговый результат');
$texts[] = array('диагностики', 'диагностики аппарата');
$texts[] = array('нельзя');
$texts[] = array('приступать', 'переходить');
$texts[] = array('к ремонту!</p>');

$texts[] = array('<p><strong>Срочная программная диагностика -', '<p><strong>Программная экспресс диагностика -');
$texts[] = array('от 5', 'от 10', 'от 15');
$texts[] = array('минут</strong>.<br/>');

$texts[] = array('Программное тестирование');
$texts[] = array('может проводиться как ');
$texts[] = array('в лаборатории ', 'в мастерской');
$texts[] = array('сервиса,');
$texts[] = array('так и на выезде.</p>', 'так и у вас на дому.</p>');

$texts[] = array('<p><strong>Срочная аппаратная диагностика -', '<p><strong>Аппаратная экспресс диагностика -');
$texts[] = array('от 20', 'от 25', 'от 30', 'от 45');
$texts[] = array('минут</strong>.<br/>');

$texts[] = array('Аппаратное тестирование');
$texts[] = array('проводиться');
$texts[] = array('исключительно', 'только');
$texts[] = array('в лаборатории', 'в мастерской');
$texts[] = array('сервисного центра', 'сервиса', 'сервис центра');
$texts[] = array('с полной');
$texts[] = array('или частичной');
$texts[] = array('разборкой');
$texts[] = array('аппарата.', 'устройства.');

$texts[] = array('По запросу');
$texts[] = array('владельца');
$texts[] = array('устройства', 'гаджета', 'девайса');
$texts[] = array('матером', 'сервисным инженером');
$texts[] = array('может быть');
$texts[] = array('выдано', 'выписано');
$texts[] = array('техническое заключение');
$texts[] = array('на фирменном бланке');
$texts[] = array('организации.', 'компании.', $this->_datas['servicename'].'.</p>');

$total = array();
$total[] = array('<p>Гарантия на');
$total[] = array('работы', 'услуги', 'проведенные работы', 'ремонтные работы');
$total[] = array('в '.$this->_datas['servicename']);
$total[] = array('до 6 месяцев,');
$total[] = array('на устанавливаемые');
$total[] = array('комплектующие', 'запчасти', 'запасные части');
$total[] = array('до 3 лет</p>');

$feed = $this->_datas['feed'];
$this->_datas['total'] = sc::_createTree($total, $feed);

?>

        <div class="title-row">
            <div class="container">
                <h1><?=$this->_ret['h1']?></h1>
            </div>
        </div>

        <? $banner_img = '/templates/moscow/img/shared/banners/'.$this->_datas['images']['diagnostika'];
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
                <h2>Популярные услуги</h2>
                <div class="tables-wrapper">
                    <?=$str;?>
                </div>
            </div>
        </div>

        <? include __DIR__.'/banner-total.php'; ?>

        <?=$this->_datas['preims']?>

        <ul class="breadcrumb">
            <li><a href="/">Главная</a></li>
            <li>Срочная диагностика, тех. заключение</li>
        </ul>
