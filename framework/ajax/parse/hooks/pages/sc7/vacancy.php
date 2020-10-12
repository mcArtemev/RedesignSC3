<?
use framework\tools;
use framework\ajax\parse\parse;
include('description_vacancy.php');

$marka = $this->_datas['marka']['name'];  // SONY
$servicename = $this->_datas['servicename']; //SONY Russia
$ru_servicename = $this->_datas['ru_servicename']; //
$ru_marka = $this->_datas['marka']['ru_name']; // СОНИ
$region_name = $this->_datas['region']['name'];//Москва
$region_name_pril = $this->_datas['region']['pril'];//Московского
$region_name_pe = $this->_datas['region']['name_pe'];//в Москве (в Владивостоке)
$region_name_de = $this->_datas['region']['name_de'];//по Москве (Владивостоку)
$region_name_re = $this->_datas['region']['name_re'];//служба Москвы (Владивостока)
$phone = $this->_datas['phone'];
$phone_format = tools::format_phone($phone);
$metrica = $this->_datas['metrica'];
$all_deall_devices = $this->_datas['all_devices'];

$all_deall_devices_str = "";
foreach ($all_deall_devices as $items)
{
    $all_deall_devices_str .= $items["type_rm"] . ", ";
}
$all_deall_devices_str = substr("$all_deall_devices_str",0, -2);

$pervoepredlojenie = array();
$pervoe_predlojenie[] = array("Мастер по ремонту","Сервисный инженер","Сервис-инженер");
$pervoe_predlojenie[] = array("Сервисное обслуживание оборудования: ".$all_deall_devices_str.".","Диагностика неисправностей, определение необходимых ремонтных работ.");
$vtoroe_predlojenie = array();
$vtoroe_predlojenie[] = array("Сервисное обслуживание оборудования: ".$all_deall_devices_str."","Распределение ремонтных работ между сервисными инженерами. менеджеров, заказчиков по техническим вопросам.",
    "Диагностика неисправностей, определение необходимых ремонтных работ и контроль их проведения.");
$tretie_predlojenie = array();
$tretie_predlojenie[] = array("Оператор Call-центра","Оператор");
$tretie_predlojenie[] = array("прием заказов","составление маршрутного листа для курьера","общение с клиентами");
$chetvertoe_predlojenie = array();
$chetvertoe_predlojenie[] = array("без опыта работы","от " . rand(1,2) . "-х лет");
$chetvertoe_predlojenie[] = array("выезд к клиенту","выезд к заказчику");
$chetvertoe_predlojenie[] = array("доставка устройства","доставка аппарата","доставка техники","доставка гаджета","доставка девайса");
$chetvertoe_predlojenie[] = array("следование маршрутному листу");
$chetvertoe_predlojenie[] = array("первичный осмотр устройства");
$chetvertoe_predlojenie[] = array("оформление листа приемки","оформление бланка приемки");

$rand_arr = array(0,1,2,3);

$rand_arr_mass_rand = array_rand($rand_arr,1);
$rand_arr_mass[] = $rand_arr[$rand_arr_mass_rand];
unset($rand_arr[$rand_arr_mass_rand]);
if($rand_arr_mass[0] == 0)
{
    unset($rand_arr[1]);
}

if($rand_arr_mass[0] == 1)
{
    unset($rand_arr[0]);
}

$rand_arr_mass_rand = array_rand($rand_arr,1);
$rand_arr_mass[] = $rand_arr[$rand_arr_mass_rand];


$akcii = array();
$akcii = array("скидки","снижение стоимости","акционные услуги");

$uslugi = array();
$uslugi_rand = rand(1,3);
if($uslugi_rand == 1)
{
    $uslugi = array("цены","наименования услуг");
}
if($uslugi_rand == 2)
{
    $uslugi = array("прайслист","названия услуг");
}
if($uslugi_rand == 3)
{
    $uslugi = array("стоимость","перечисление услуг");
}

$kontakti = array();
$kontakti_rand = rand(1,2);
if($kontakti_rand == 1)
{
    $kontakti = array("адрес","время работы","телефон");
}
if($kontakti_rand == 2)
{
    $kontakti = array("расположение офиса","расписание","номер телефона");
}

?>

<main>
    <section class="breadcrumbs">
        <div class="container">
            <div class="grid-12" itemscope="" itemtype="http://schema.org/BreadcrumbList">
                <ul class="breadcrumbs-inside">
                       <li itemprop="name"><a href="/" itemprop="url">Главная</a></li>  
                            <li class="breadcrumbs-inside-drop">
                                <span itemprop="name"><a itemprop="url" href="/about/">О компании</a></span>
                                <span class="breadcrumbs-inside-drop-btn"></span>
                                <ul class="drop">
                                    <li itemprop="name"><a itemprop="url" href="/about/action/">Акции</a></li>
                                    <li itemprop="name"><a itemprop="url" href="/about/contacts/">Контакты</a></li>
                                    <li itemprop="name"><a itemprop="url" href="/about/price/">Услуги и цены</a></li>
                                </ul>
                            </li>
                        <li itemprop="name"><span>Вакансии</span></li>
                </ul>
            </div>
        </div>
    </section>
    <section class="title-block">
        <div class="container">
            <div class="grid-12">
                <h1><?=$this->_ret['h1']?></h1>
            </div>
        </div>
    </section>
    <section class="vacancy">
        <div class="container">
            <div class="grid-12">
                <div class="vacancy-list">
                    <?if($rand_arr_mass[0] == "0" || $rand_arr_mass[1] == "0"):?>
                    <div class="vacancy-list-item">
                        <div class="vacancy-list-title"><?=$this->checkcolumn($pervoe_predlojenie[0])?></div>
                        <p><b>Опыт работы:</b> от <?=rand(2,4)?>-х лет</p>
                        <p><b>Возраст:</b> <?=tools::declOfNum(rand(21,35), array("год", "года", "лет"))?></p>
                        <p><b>Обязанности:</b><br>
                            - Сервисное обслуживание оборудования: <?=$all_deall_devices_str?>.<br>
                            - Диагностика неисправностей, определение необходимых ремонтных работ.
                        </p>
                        <p><b>з/п: от <?=round(rand(40000,60000), -3);?> рублей</b></p>
                    </div>
                <?endif;?>
                <?if($rand_arr_mass[0] == "1" || $rand_arr_mass[1] == "1"):?>
                    <div class="vacancy-list-item">
                        <div class="vacancy-list-title">Ведущий сервисный инженер</div>
                        <p><b>Опыт работы:</b> от <?=rand(5,7)?>-и лет</p>
                        <p><b>Возраст:</b> <?=tools::declOfNum(rand(28,40), array("год", "года", "лет"))?></p>
                        <p><b>Обязанности:</b><br>
                            - Сервисное обслуживание оборудования.<br>
                            - Распределение ремонтных работ между сервисными инженерами, менеджерами, заказчиками по техническим вопросам.<br>
                            - Диагностика неисправностей, определение необходимых ремонтных работ и контроль их проведения.
                        </p>
                        <p><b>з/п: от <?=round(rand(60000,100000), -3);?> рублей</b></p>
                    </div>
                <?endif;?>
                <?if($rand_arr_mass[0] == "2" || $rand_arr_mass[1] == "2"):?>
                    <div class="vacancy-list-item">
                        <div class="vacancy-list-title"><?=$this->checkcolumn($tretie_predlojenie[0])?></div>
                        <p><b>Опыт работы:</b> от <?=rand(2,4)?>-х лет</p>
                        <p><b>Возраст:</b> <?=tools::declOfNum(rand(18,30), array("год", "года", "лет"))?></p>
                        <p><b>Обязанности:</b><br>
                            - Прием заказов.<br>
                            - Составление маршрутного листа для курьера.<br>
                            - Общение с клиентами.<br>
                        </p>
                        <p><b>з/п: от <?=round(rand(30000,50000), -3);?> рублей</b></p>
                    </div>
                <?endif;?>
                <?if($rand_arr_mass[0] == "3" || $rand_arr_mass[1] == "3"):?>
                    <div class="vacancy-list-item">
                        <div class="vacancy-list-title">Курьер</div>
                        <p><b>Опыт работы:</b> <?=$this->checkcolumn($chetvertoe_predlojenie[0])?></p>
                        <p><b>Возраст: </b><?=tools::declOfNum(rand(20,25), array("год", "года", "лет"))?></p>
                        <p><b>Обязанности:</b><br>
                            - <?=$this->firstup($this->checkcolumn($chetvertoe_predlojenie[1]))?><br>- <?=$this->firstup($this->checkcolumn($chetvertoe_predlojenie[2]))?><br>- <?=$this->firstup($this->checkcolumn($chetvertoe_predlojenie[3]))?><br>- <?=$this->firstup($this->checkcolumn($chetvertoe_predlojenie[4]))?><br>- <?=$this->firstup($this->checkcolumn($chetvertoe_predlojenie[5]))?></p>
                        <p><b>з/п: от <?=round(rand(25000,40000), -3);?> рублей</b></p>
                    </div>
                <?endif;?>
                </div>
            </div>
        <section class="title-block">
            <div class="container">
                <div class="grid-12">
                    <p class="non-block-text" style="padding-bottom: 0px;">
                        <?
                        if ($this->_datas['realHost'] == 'remont-washmachine.ru'){
                        echo $vacancy.'<a href="/courses-repair"> ремонту стиральных машин</a>';
                        }
                        ?>
                       
                    </p>
                </div>
            </div>
        </section>

        <div class="grid-12">
            <div class="link-block-list perelink">
                <a href="/about/vacancy/" class="link-block">
                    <div class="link-block-title-strong">Контакты</div><?=$this->firstup($this->rand_arr_str($kontakti))?>
                </a>
                <a href="/about/price/" class="link-block">
                    <div class="link-block-title-strong">Услуги</div><?=$this->firstup($this->rand_arr_str($uslugi))?>
                </a>
                <a href="/about/action/" class="link-block">
                    <div class="link-block-title-strong">Акции</div><?=$this->firstup($this->rand_arr_str($akcii))?>
                </a>
            </div> 
        </div>
        </div>
    </section>
</main>