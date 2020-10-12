<?

use framework\tools;
use framework\ajax\parse\parse;
use framework\ajax\parse\hooks\sc;

$marka = $this->_datas['marka']['name'];
$marka_lower = mb_strtolower($this->_datas['marka']['name']);
$marka_ru = $this->_datas['marka']['ru_name'];
$marka_upper = mb_strtoupper($marka);

$feed = $this->_datas['feed'];

$types = [];

include __DIR__.'/data/price.php';

$services = [];

foreach ($this->_datas['all_devices'] as $k => $type) {
  if (isset($type['type_id']))
    $types[$type['type_id']] = $type;
  else
  {
    $services[$type['type']] = $info_block[$this->_datas['accord'][$type['type']]];
    $types[(-1) * $k] = $type;
  }
}

if (isset($this->_datas['all_services']))
{
    foreach ($this->_datas['all_services'] as $service) {
      $services[$types[$service['model_type_id']]['type']][] = $service;
    }
}

srand($this->_datas['feed']);
foreach ($services as $k=>$v) {
  shuffle($services[$k]);
}
srand();

$texts = array();
$texts[] = array('<p>Цены на ремонт');
$texts[] = array('техники', 'устройств', 'аппаратуры');
$texts[] = array($marka, $marka_ru);
$texts[] = array('представлены');
$texts[] = array('ниже.', 'на сайте.');

$texts[] = array('Данный');

srand($feed);
$choose_r_1 = rand(0, 2);
$choose_r_2 = rand(0, 1);

$t_price_1 = array('прейскурант', 'прайс', 'прай-лист');
$t_price_2 = array('прейскуранта', 'прайса', 'прайс-листа');
$t_price_3 = array('прейскуранта', 'прайса', 'прайс-листа');

unset($t_price_2[$choose_r_1], $t_price_3[$choose_r_1]);
$t_price_2 = array_values($t_price_2);
$t_price_3 = array_values($t_price_3);

unset($t_price_3[$choose_r_2]);
$t_price_3 = array_values($t_price_3);

$texts[] = array($t_price_1[$choose_r_1]);
$texts[] = array('является');
$texts[] = array('основным');

$t_array = array();
$t1 = array('при определении итоговой стоимости');
$t2 = array('работ', 'работ мастера', 'работ сервисного инженера');

$t_array[] = $t1[0].'.';

foreach ($t2 as $t2_2)
{
    $t_array[] = $t1[0].' '.$t2_2.'.';
}

$texts[] = $t_array;

$texts[] = array('Работа не подподающая под пункты', 'Стоимость услуг не подподающих под пункты');
$texts[] = array($t_price_2[$choose_r_2]);
$texts[] = array('рассчитывается ', 'высчитывается', 'оценивается');
$texts[] = array('из расчета');
$texts[] = array('750 рублей');
$texts[] = array('в час.');

$texts[] = array('Мы следим за ');
$texts[] = array('обновлениями');
$texts[] = $t_price_3;
$texts[] = array('и');
$texts[] = array('регулярно', 'своевременно');
$texts[] = array('вносим');
$texts[] = array('правки,', 'изменения,', 'обновления,');
$texts[] = array('благодаря');
$texts[] = array('этому');
$texts[] = array('вы всегда можете быть', 'вы можете быть');
$texts[] = array('в курсе');
$texts[] = array('актуальных');
$texts[] = array('цен.', 'расценок.');

$texts[] = array('Вопросы, возникшие', 'Свои вопросы, возникшие', 'Вопросы', 'Свои вопросы');
$texts[] = array('по стоимости');
$texts[] = array('тех или иных', '');
$texts[] = array('работ', 'услуг');
$texts[] = array('вы можете', 'можно');
$texts[] = array('задать');
$texts[] = array('нашему оператору', 'нашему менеджеру', 'нашему специалисту', 'нашему сотруднику call-центра', 'нашему менеджеру колл-центра', 'специалисту нашего колл-центра');
$texts[] = array('по телефону', 'по телефону:', 'по телефону -', 'по номеру тефона', 'по номеру тефона:', 'по номеру тефона -', 'по единому номеру тефона', 'по единому номеру тефона:', 'по единому номеру тефона -');
$texts[] = array(tools::format_phone($this->_datas['phone']).'.</p>');

$total = array();
$total[] = array('<p>Наш сервис обслуживает физических и юридических лиц.', 'Наш сервис обслуживает юридических и физических лиц.');
$total[] = array('Принимаем к оплате наличный и безналичный расчет.</p>', 'Принимаем к оплате наличный и безналичный расчет и кредитные карты.</p>',
        'Принимаем к оплате кредитные карты, наличный и безналичный расчет.</p>',
        'Работаем с наличным и безналичным расчетом, принимаем кредитные карты.</p>', 'Работаем с наличным и безналичным расчетом.</p>',
        'Принимаем кредитные карты, работаем с наличным и безналичным расчетом.</p>', 'Принимаем оплату кредитными картами, работаем с наличным и безналичным расчетом</p>');

$this->_datas['total'] = sc::_createTree($total, $feed);
?>

        <div class="title-row">
            <div class="container">
                <h1><?=$this->_ret['h1']?></h1>
            </div>
        </div>

        <? $banner_img = '/templates/moscow/img/shared/banners/'.$this->_datas['images']['ceny'];
        include __DIR__.'/banner.php'; ?>

        <div class="aboutrow">
            <div class="container">
                <div class="abouttext">
                     <?=sc::_createTree($texts, $feed);?>
                </div>
            </div>
        </div>

        <div class="pricerow">
            <div class="container">
                <div class="panel-group" id="accordion">
                        <?  $i = 1;
                            foreach ($types as $id=>$type) { ?>


                              <div class="servicetable panel">
                                    <h3 class="pricetitle collapsed" data-toggle="collapse" data-target="#priceitem-<?=$i?>" data-parent="#accordion">Ремонт <?=$type['type_rm']?></h3>
                                    <div class="pricetext collapse" id="priceitem-<?=$i?>">
                                      <table>
                                          <thead>
                                              <tr>
                                                  <th>Услуга</th>
                                                  <th>Время, мин</th>
                                                  <th>Цена, руб</th>
                                              </tr>
                                          </thead>
                                          <tbody>
                                              <? if ($id > 0):?>
                                                  <?foreach ($services[$type['type']] as $value):
                                                    $hrefService = $value['url'];
    
    
                                                      $href = $this->urlType($type['type']).'/'.$hrefService;
                                                  ?>
                                                  <tr>
                                                      <td><a href="/<?=$href?>/"><?=tools::mb_firstupper($value['name'])?></a></td>
                                                      <td><?=($value['time_min']."-".$value['time_max'])?></td>
                                                      <td><?=tools::format_price($value['cost'], $this->_datas['setka_name'])?></td>
                                                  </tr>
                                                  <? endforeach; ?>
                                              <?else:?>                                              
                                                <?foreach ($services[$type['type']] as $value):?>                                                  
                                                  <tr>
                                                      <td><?=tools::mb_firstupper($value[0])?></td>
                                                      <td><?=($value[1]."-".$value[2])?></td>
                                                      <td><?=tools::format_price($value[3], $this->_datas['setka_name'])?></td>
                                                  </tr>
                                                  <? endforeach; ?>                                                
                                              <?endif;?>
                                          </tbody>
                                      </table>
                                    </div>
                              </div>



                        <? $i++; ?>
                      <?php } ?>

                </div>
            </div>
         </div>

         <? include __DIR__.'/banner-total.php'; ?>

         <ul class="breadcrumb">
            <li><a href="/<?=$marka_lower?>/">Главная</a></li>
            <li>Цены на ремонт техники <?=$this->_datas['marka']['name']?></li>
        </ul>
