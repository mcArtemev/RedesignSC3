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

$types = [];
$defects = [];

include __DIR__.'/data/price.php';

foreach ($this->_datas['all_devices'] as $k => $type) {
  if (isset($type['type_id']))   
    $types[$type['type_id']] = $type['type'];
  else
  {
     $defects[$type['type']] = $defect_block[$this->_datas['accord'][$type['type']]];
     $types[(-1) * $k] = $type['type'];
  }
}

if (isset($this->_datas['all_defects']))
{
    foreach ($this->_datas['all_defects'] as $defect) {
      $defects[$types[$defect['model_type_id']]][] = $defect;
    }
}

srand($this->_datas['feed']);
foreach ($defects as $k=>$v) {
  shuffle($defects[$k]);
}
srand();

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
                  <?php foreach ($types as $id=>$type) { ?>
                  <div class="tables">
                    <div class="title"><?=tools::mb_ucfirst($type)?></div>
                    <ul class="popularlist">
                      <?php foreach (array_slice($defects[$type], 0, 5) as $defect) { ?>
                      <?if ($id>0):?>
                        <li><a href = "/<?=$this->urlType($type)?>/<?=$defect['url']?>/"><?=tools::mb_firstupper($this->randomSyns($defect['name'], $defect['syns']))?></a></li>
                      <?else:?>
                        <li><span><?=$defect?></span></li>
                      <?endif;?>
                      <?php } ?>
                    </ul>
                  </div>
                  <?php } ?>
                </div>
            </div>
        </div>

        <? include __DIR__.'/banner-total.php'; ?>

         <?=$this->_datas['preims']?>

        <ul class="breadcrumb">
            <li><a href="/<?=$marka_lower?>/">Главная</a></li>
            <li>Ремонт любых неисправностей</li>
        </ul>
