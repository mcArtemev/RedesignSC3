<?
use framework\tools;
use framework\ajax\parse\hooks\sc;
use framework\rand_it;

$marka_lower = mb_strtolower($this->_datas['marka']['name']);

$feed = $this->_datas['feed'];

$str = '';

for($i=0; $i<3; $i++)
{
    $str .= '<div class="tables"><div class="preiman">';
    $t = array();

    switch ($i)
    {
        case 0:
            $t[] = array('Выезд');
            $t[] = array('специалиста', 'сервисного специалиста', 'курьера', 'сервисного курьера');
            $t[] = array('в пределах МКАД -');
            $t[] = array('БЕСПЛАТНО');
        break;
        case 1:
            $t[] = array('Выезд');
            $t[] = array('специалиста', 'сервисного специалиста', 'курьера', 'сервисного курьера');
            $t[] = array('в пределах 10 км от МКАД -');
            $t[] = array('500 рублей');
        break;
        case 2:
            $t[] = array('Выезд');
            $t[] = array('специалиста', 'сервисного специалиста', 'курьера', 'сервисного курьера');
            $t[] = array('в Подмосковье более 10 км от МКАД -');
            $t[] = array('договорная');
        break;
    }

    $str .=  sc::_createTree($t, $feed);

    $str .= '</div></div>';
}

$texts = array();
$texts[] = array('<p>Мы ценим');
$texts[] = array('время');
$texts[] = array('наших клиентов');
$texts[] = array('и поэтому');
$texts[] = array('открыли');
$texts[] = array('свой');
$texts[] = array('логистический отдел.', 'отдел логистики.');

$texts[] = array('Это позволило');
$texts[] = array('увеличить');
$texts[] = array('количество');
$texts[] = array('доставок техники', 'доставок', 'выездов к заказчикам', 'выездов к клиентам', 'курьерских выездов');
$texts[] = array('на');

$t_array = array();
$t1 = array('10', '15', '20', '25');
$t2 = array('процентов.', '%.');
foreach ($t1 as $t1_1)
{
    $t_array[] = $t1_1.' '.$t2[0];
    $t_array[] = $t1_1.$t2[1];
}

$texts[] = $t_array;

$texts[] = array('Сегодня');
$texts[] = array('курьерская служба', 'служба доставки', 'служба курьерской доставки');
$texts[] = array('в Support -');
$texts[] = array('это эффективный', 'это высокоэффективный');
$texts[] = array('отдел,');
$texts[] = array('в основе работы которого');
$texts[] = array('лежат:');

$t_array = array('пунктуальность', 'бережливость', 'оперативность', 'вежливость', 'безопасность');
$t_array = rand_it::randMas($t_array, 3, '', $feed);

$texts[] = array(implode(', ', $t_array).'.</p>');

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

         <? $banner_img = '/templates/moscow/img/shared/banners/'.$this->_datas['images']['dostavka'];
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
                <h2>Условия выезда</h2>
                <div class="tables-wrapper">
                    <?=$str;?>
                </div>
            </div>
        </div>

         <? include __DIR__.'/banner-total.php'; ?>

         <?=$this->_datas['preims']?>

        <ul class="breadcrumb">
            <li><a href="/">Главная</a></li>
            <li>Доставка вашей техники</li>
        </ul>
