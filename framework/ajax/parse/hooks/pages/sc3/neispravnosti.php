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
    $table_name = $s.'_defect_to_m_models';
    $join_table = $s.'_defect_syns';
    $link_field = $s.'_defect_syn_id';
    $main_table = $s.'_defects';
    $main_table_field = $s.'_defect_id';

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
        $href = tools::search_url($this->_datas['site_id'], serialize(array('model_type_id' => $suffics['type_id'], 'marka_id' => $this->_datas['marka_id'], 'key' => 'defect', 'id' => $syn['id'])));
        $str .= '<li><a href="/'.$href.'/">'.tools::mb_firstupper($syn['name']).'</a></li>';
    }
    $str .= '</ul></div>';
}

$texts = array();
$t_array = array();

$feed = $this->_datas['feed'];
srand($feed);

$choose = rand(0, 1);
switch ($choose)
{
    case 0:
        $texts[] = array('<p>Ремонтируем');
        foreach ($this->_datas['all_devices'] as $device)
            $t_array[] = $device['type_m'];
    break;
    case 1:
        $texts[] = array('<p>Восстанавливаем работоспособность');
        foreach ($this->_datas['all_devices'] as $device)
            $t_array[] = $device['type_rm'];
    break;
}

$texts[] = array(implode(', ', $t_array));
$texts[] = array($marka, $marka_ru);
$texts[] = array('с любыми неисправностями - ', 'с любыми поломками - ');
$texts[] = array('от самых');
$texts[] = array('незначитильных', 'мелких');
$texts[] = array('до');
$texts[] = array('сложного ремонта');
$texts[] = array('по ');
$texts[] = array('перепайке цепей питания', 'перепайке цепей питания плат', 'перепайке мультиконтроллеров', 'перепайки контроллеров', 'перепайки контроллеров плат', 'перепайке ШИМ-контроллеров', 'перепайке PWM-контроллеров');
$texts[] = array('и');
$texts[] = array('реболла чипов.</p>', 'реболла BGA-чипов.</p>', 'BGA-чипов.</p>');

$total = array();
$total[] = array('<p>Гарантия на');
$total[] = array('работы', 'услуги', 'проведенные работы', 'ремонтные работы');
$total[] = array('в '.$this->_datas['servicename']);
$total[] = array('до 6 месяцев,');
$total[] = array('на устанавливаемые');
$total[] = array('комплектующие', 'запчасти', 'запасные части');
$total[] = array('до 3 лет</p>');

$this->_datas['total'] = sc::_createTree($total, $feed);

?>
        <div class="title-row">
            <div class="container">
                <h1><?=$this->_ret['h1']?></h1>
            </div>
        </div>

        <? $banner_img = '/templates/moscow/img/shared/banners/'.$this->_datas['images']['neispravnosti'];
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
                <h2>Частые неисправности</h2>
                <div class="tables-wrapper">
                    <?=$str;?>
                </div>
            </div>
        </div>

        <? include __DIR__.'/banner-total.php'; ?>

         <?=$this->_datas['preims']?>

        <ul class="breadcrumb">
            <li><a href="/">Главная</a></li>
            <li>Ремонт любых неисправностей</li>
        </ul>
