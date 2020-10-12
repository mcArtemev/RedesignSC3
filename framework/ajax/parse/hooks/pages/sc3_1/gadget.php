<?

use framework\tools;
use framework\ajax\parse\hooks\sc;
use framework\rand_it;

$gadget = $this->_datas['gadget']; 

$marka = $this->_datas['marka']['name'];
$marka_lower = mb_strtolower($this->_datas['marka']['name']);
$ru_marka =  $this->_datas['marka']['ru_name'];
$servicename = $this->_datas['servicename'];

$add_device_type = $this->_datas['add_device_type'];
$accord_image = $this->_datas['accord_image'];

$setka_name = $this->_datas['setka_name'];

$feed = $this->_datas['feed'];
$f = tools::gen_feed($this->_datas['site_name']);           

//var_dump($gadget);

include __DIR__.'/data/price.php';

$total = array();
$choose = rand(0, 1);
$v = array('и выявление', 'и нахождение', 'и обнаружение', 'и определение', 'и поиск');

switch ($choose)
{
    case 0:
        $total[] = array('<p>Диагностика', '<p>Экспресс диагностика');
        $total[] = $v;
        $total[] = array('аппаратных', 'программных', 'аппаратных и программных', 'программных и аппаратных');
    break;
    case 1:
        $total[] = array('<p>Программная диагностика', '<p>Аппаратная диагностика', '<p>Программная/аппаратная диагностика', '<p>Аппаратная/программная диагностика');
        $total[] = $v;
        $total[] = array('любых', '');
    break;
}

$total[] = array('неисправностей', 'ошибок', 'проблем', 'неполадок');

$t_array = array('в работе устройств', 'в работе техники');
$t_array[] = 'в работе '.$gadget['type_re'];

$t2 = array($this->_datas['marka']['name']);

$t1 = $t_array;
$t1[] = 'устройств';

foreach ($t1 as $value1)
    foreach ($t2 as $value2)
        $t_array[] = $value1.' '.$value2;

$total[] = $t_array;
$total[] = array('проводится', 'производится', 'выполняется');
$total[] = array('бесплатно,', 'БЕСПЛАТНО,');
$minuts = tools::get_diagnostic_minuts($this->_datas['site_name']);

$minuts1 = tools::declOfNum($minuts, array('минуты', 'минут', 'минут'));
$minuts2 =  tools::declOfNum($minuts, array('минуту', 'минуты', 'минут'));

$total[] = array('в течении '.$minuts1.'.</p>', 'за '.$minuts2.'.</p>', 'в среднем за '.$minuts2.'.</p>', '~'.$minuts2.'.</p>', 'в пределах '.$minuts1.'.</p>');
$this->_datas['total'] = sc::_createTree($total, $feed);

$block_text = array();

$j = 0;
$block_text[$j][] = array('<div class="tables"><div class="title">Цены</div><div class="preiman">Стоимость работ',
   '<div class="tables"><div class="title">Цены</div><div class="preiman">Стоимость услуг');
$block_text[$j][] = array('зависит');

$t_array = array();
$t1_array = array('от типа устройства,', 'от типа техники,', 'от модели устройства,', 'от модели аппарата,');
$t2_array = array('от характера повреждения,', 'от характера поломки,', 'от степени повреждения,');

foreach ($t1_array as $t1)
{
   foreach ($t2_array as $t2)
   {
       $t_array[] = $t1.' '.$t2;
       $t_array[] = $t2.' '.$t1;
   }
}

$block_text[$j][] = $t_array;
$block_text[$j][] = array('никаких сюрпризов -');
$block_text[$j][] = array('все цены');
$block_text[$j][] = array('регламентированы', 'зафиксированы');
$block_text[$j][] = array('прайс-листом</div></div>', 'прайсом</div></div>');

$j++;

$block_text[$j][] = array('<div class="tables"><div class="title">Оборудование</div><div class="preiman">Работаем');
$block_text[$j][] = array('на проффессиональных');
//$block_text[$j][] = array('паяльных станциях', 'ремонтных системах', 'ремонтных станциях', 'паяльных системах', 'паяльных комплексах',
//       'ремонтных комплексах', 'паяльно-ремонтных комплексах', 'паяльно-ремонтных системах', 'паяльно-ремонтных центрах', 'паяльно-ремонтных станциях');

if($gadget['type'] =="посудомоечная машина" || $gadget['type'] == 'холодильник'  || $gadget['type'] == 'стиральная машина'){
    $block_text[$j][] = array('ремонтных станках', 'ремонтных станциях');
       
    $block_text[$j][] = array('с ИК нагревом</div></div>', 'с ИК подогревом</div></div>', 'с верхним/нижним ИК подогревом</div></div>', 'с верхним/нижним ИК нагревом</div></div>',
       'с нижним/верхним ИК подогревом</div></div>', 'с нижним/верхним ИК нагревом</div></div>', 'для монтажа элементов</div></div>',
       'для монтажа компонент</div></div>', 'для монтажа/демонтажа компонент</div></div>', 'для монтажа  элементов</div></div>');
}else{
    $block_text[$j][] = array('паяльных станциях', 'ремонтных системах', 'ремонтных станциях', 'паяльных системах', 'паяльных комплексах',
       'ремонтных комплексах', 'паяльно-ремонтных комплексах', 'паяльно-ремонтных системах', 'паяльно-ремонтных центрах', 'паяльно-ремонтных станциях');
       
    $block_text[$j][] = array('с ИК нагревом</div></div>', 'с ИК подогревом</div></div>', 'с верхним/нижним ИК подогревом</div></div>', 'с верхним/нижним ИК нагревом</div></div>',
       'с нижним/верхним ИК подогревом</div></div>', 'с нижним/верхним ИК нагревом</div></div>', 'для монтажа BGA элементов</div></div>',
       'для монтажа BGA компонент</div></div>', 'для монтажа/демонтажа BGA компонент</div></div>', 'для монтажа BGA элементов</div></div>');
       
}

$j++;

$block_text[$j][] = array(
   '<div class="tables"><div class="title">Сотрудники</div><div class="preiman">Наши мастера -',
   '<div class="tables"><div class="title">Сотрудники</div><div class="preiman">Наши ремонтные мастера -');
$block_text[$j][] = array('сертифицированные', 'дипломированные');
$block_text[$j][] = array('специалисты', 'спецы');
$block_text[$j][] = array('с опытом ремонта', 'с практическим опытом ремонта', 'с ежедневным опытом ремонта', 'с непрерывным опытом ремонта');

$t_array[] = $gadget['type_re'];

$block_text[$j][] = $t_array;

if (isset($this->_datas['marka'])) $block_text[$j][] = array($this->_datas['marka']['name'], $this->_datas['marka']['ru_name']);

$t_array = array();
$t_array[] = array('больше 3 лет', 'более 3 лет', 'больше трех лет', 'более трех лет');
$t_array[] = array('больше 7 лет', 'более 7 лет', 'больше семи лет', 'более семи лет');
$t_array[] = array('больше 4 лет', 'более 4 лет', 'больше четырех лет', 'более четырех лет');
$t_array[] = array('больше 8 лет', 'более 8 лет', 'больше восьми лет', 'более восьми лет');
$t_array[] = array('больше 5 лет', 'более 5 лет', 'больше пяти лет', 'более пяти лет');
$t_array[] = array('больше 9 лет', 'более 9 лет', 'больше девяти лет', 'более девяти лет');
$t_array[] = array('больше 6 лет', 'более 6 лет', 'больше шести лет', 'более шести лет');
$t_array[] = array('больше 10 лет', 'более 10 лет', 'больше десяти лет', 'более десяти лет');

$t_array = tools::get_rand($t_array, $f);

foreach ($t_array as $key => $value)
   $t_array[$key] = $value.'</div></div>';

$block_text[$j][] = $t_array;

$block_text = rand_it::randMas($block_text, count($block_text), '', $feed);

$this->_datas['block_text'] = '';

foreach ($block_text as $var)
   $this->_datas['block_text'] .= sc::_createTree($var, $feed);

$text = [];

$text[] = array('<p>Ремонт');

$t_array = array();
$t_array[] = $gadget['type_rm'];

$text[] = $t_array;

$t_marka = array($this->_datas['marka']['name'], $this->_datas['marka']['ru_name']);
$choose = rand(0, 1);
$text[] = array($t_marka[$choose]);

unset($t_marka[$choose]);

$t_marka = array_values($t_marka);

$text[] = array('в сервисном центре', 'в сервисе', 'в сервис центре');
$text[] = array($this->_datas['servicename']);
$text[] = array('это не только:');

$vars = array();
$vars[] = array('камер', 'корпусов', 'динамиков', 'разъемов', 'портов', 'шлейфов',
           'кнопок', 'микрофонов', 'слотов', 'крышек');


$vars[] = array('гнезд питания', 'разъемов питания', 'разъемов зарядки', 'гнезд зарядки');

if($gadget['type'] == "посудомоечная машина" || $gadget['type'] == 'холодильник'  || $gadget['type'] == 'стиральная машина'){
    $vars[] = array('моторов', 'электромоторов');
    $vars[] = array('шлангов','кабелей');
}elseif($gadget['type'] =="смартфон" || $gadget['type'] =="планшет" ||$gadget['type'] =="ноутбук"){
    $vars[] = array('симхолдеров', 'сим-лотков', 'держателей сим', 'simholder');
    $vars[] = array('GPS', 'GPS-модулей', 'модулей GPS', 'плат GPS', 'GPS-плат');
    $vars[] = array('WI-FI', 'WI-FI модулей', 'модулей WI-FI', 'плат WI-FI', 'WI-FI плат');
}else{
    $vars[] = array('вибромоторов', 'вибро', 'вибромодулей');
    $vars[] = array('модулей', 'плат');
    $vars[] = array('камер','ёмкостей');
    $vars[] = array('панелей');
}
if($gadget['type'] =="проектор"){
     $vars[] = array('линзы');
}

$vars[] = array('материнских плат', 'плат', 'элементов плат', 'системных плат');

$vars = rand_it::randMas($vars, 4, '', $feed);

$text[] = array('замена');
$text[] = $vars[0];
$text[] = array('и');

foreach ($vars[1] as $key => $value)
   $vars[1][$key] = $value.',';

$text[] = $vars[1];
$text[] = array('ремонт');

$text[] = $vars[2];
$text[] = array('и');

foreach ($vars[3] as $key => $value)
   $vars[3][$key] = $value.',';

$text[] = $vars[3];

$text[] = array('перепайка');

$t_array = array();
$t1_array = array('контроллеров', 'контроллеров плат', 'ШИМ-контроллеров', 'PWM-контроллеров', 'мультиконтроллеров');
if($gadget['type'] !="посудомоечная машина" and $gadget['type'] != 'холодильник'  and $gadget['type'] != 'стиральная машина'){
    $t2_array = array('цепей питания', 'цепей питания плат', 'чипов',  'кондесаторов плат');
}else{
    $t2_array = array('цепей питания', 'цепей питания плат', 'чипов',  'кондесаторов плат');
}

foreach ($t1_array as $t1)
{
   foreach ($t2_array as $t2)
   {
       $t_array[] = $t1.' и '.$t2.',';
       $t_array[] = $t2.' и '.$t1.',';
   }
}

$text[] = $t_array;

$text[] = array('но и');
$text[] = array('индивидуальный', 'персональный');
$text[] = array('подход');
$text[] = array('к проблемам каждого', 'к проблемам и неисправностям каждого');

$choose = rand(0, 1);

switch ($choose)
{
   case 0:
       $text[] = array('клиента', 'посетителя');
       $text[] = array('нашего');
       $text[] = array('сервиса.', 'центра.');
   break;
   case 1:
       $text[] = array('владельца');
       $text[] = $gadget['type_re'];
       if (isset($this->_datas['marka'])) $text[] = array(current($t_marka).'.');
   break;
}

$text[] = array('Отлаженая работа', 'Отработаная схема работы');
$text[] = array('курьерской службы', 'службы доставки', 'службы курьерской доставки');
$text[] = array('позволяет нам', 'дает нам возможность');
$text[] = array('принимать');
$text[] = array('на ремонт');
$text[] = array('технику', 'аппараты');
$text[] = array('со всех ');
$text[] = array('районов '.$this->_datas['region']['name_re'].',');
$text[] = array('за мастерами', 'за специалистами', 'за курьерами', 'за специалистами курьерской службы', 'за специалистами службы доставки');
$text[] = array('закреплены');
$text[] = array('основные', 'популярные');
$text[] = array('станции метро -', 'метро -');
$text[] = array('это позволяет ');
$text[] = array('выезжать ', 'приезжать', 'добираться');

$t_array = array('за 20-30 минут', 'за 25-30 минут', 'за 20-40 минут', 'за 25-40 минут', 'за 25-35 минут', 'за 20-45 минут', 'за 25-45 минут');
$text[] = array(tools::get_rand($t_array, $f));
$text[] = array('в');
$text[] = array('любую точку');

if ($this->_datas['region_id'])
{
   $text[] = array('города.</p>');
}
else
{
   $text[] = array('города.');
   $text[] = array('Выезд в пределах МКАД бесплатный.</p>', 'В пределах МКАД выезжаем бесплатно.</p>');
}

$this->_ret['text'] = sc::_createTree($text, $feed);

foreach ($info_block as $key => $value)
{
    if (mb_strpos($this->_datas['arg_url'], $key) !== false)
    {
        $all_services = $value;
        break;        
    }    
}

foreach ($complect_block as $key => $value)
{
    if (mb_strpos($this->_datas['arg_url'], $key) !== false)
    {
        $all_complects = $value;
        break;        
    }    
}

$min_price = PHP_INT_MAX;

foreach ($all_services as $service)
    if ($service[3] && ($service[3] < $min_price)) $min_price = $service[3];
    
foreach ($all_complects as $k => $v)
    $all_complects[$k] = (array) $v;
    
$price = tools::format_price($min_price, $setka_name);
$price_str = 'от <span>'.$price.'</span>';
?>
        
        <div class="title-row">
            <div class="container">
                <h1><?=$this->_ret['h1']?></h1>
            </div>
        </div>

        <? include __DIR__.'/banner.php'; ?>

        <ul class="breadcrumb">
             <li><a href="/<?=$marka_lower?>/">Главная</a></li>
             <li>Ремонт <?=$gadget['type_rm']?> <?=$this->_datas['marka']['name']?></li>
        </ul>

        <div class="aboutrow">
            <div class="container">
                <div class="abouttext">
                    <?=$this->_ret['text']?>
                </div>
            </div>
        </div>

        <div class="popularrow">
            <div class="container">
                <div class="tables-wrapper block-text">
                    <?=$this->_datas['block_text']?>
                </div>
            </div>
        </div>

        <div class="servicerow">
            <div class="container">
                <h2>Услуги</h2>
                <div class="servicetable">
                    <table>
                        <thead>
                            <tr>
                                <th>Услуга</th>
                                <th>Время, мин</th>
                                <th>Цена, руб</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?foreach ($all_services as $value):?>                              
                            <tr>
                                <td><?=tools::mb_firstupper($value[0])?></td>
                                <td><?=($value[1]."-".$value[2])?></td>
                                <td><?=tools::format_price($value[3], $setka_name)?></td>
                            </tr>
                            <? endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="servicerow">
            <div class="container">
                <h2>Оборудование</h2>
                <div class="servicetable">
                    <table>
                        <thead>
                            <tr>
                                <th>Оборудование</th>
                                <th>Наличие</th>
                                <th>Цена, руб</th>
                            </tr>
                        </thead>
                        <tbody>
                           <? foreach ($all_complects as $key => $value):?>
                            <tr>
                                <td><?=tools::mb_firstupper($value[0])?></a></td>
                                <td><div class="amount"><?=$this->randAmount($key)?></div></td>
                                <td>от <?=tools::format_price(isset($value[1]) ?$value[1] : 0, $setka_name)?></td>
                            </tr>
                            <? endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <? include __DIR__.'/banner-total.php'; ?>

        <ul class="breadcrumb">
             <li><a href="/<?=$marka_lower?>/">Главная</a></li>
             <li>Ремонт <?=$gadget['type_rm']?> <?=$this->_datas['marka']['name']?></li>
        </ul>