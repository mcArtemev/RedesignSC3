<?
use framework\tools;
include ('description-vacancy.php');
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
//$address = $this->_datas['partner']['address1'];

//srand($this->_datas['feed']);

$use_choose_city = $this->_datas['use_choose_city'];
$add_class = ($use_choose_city) ? " js-choose-city" : "";


$marka = mb_strtolower($this->_datas['marka']['name']);

switch ($marka) {
	case 'neff':  // посудомойки и холодильники
	case 'whirlpool':
	case 'gaggenau':
	case 'weissgauff':
	case 'korting':
	case 'maunfeld':
	case 'midea':
	case 'ardo':
	case 'samsung':
	case 'beko':
	case 'vestfrost':
	case 'kaiser':
	case 'atlant':
	case 'miele':
	case 'aeg':
	case 'zanussi':
	case 'hansa':
	case 'gorenje':
	case 'siemens':
	case 'candy':
	case 'lg':
	case 'ariston':
	case 'bosch':
	case 'electro':
	case 'indesit':
		$types = 0;
	break;
	case 'liebherr':
	case 'hitachi':  // холодильники
		$types = 1;
	break;
	case 'delonghi':  // посудомойки
		$types = 2;
	break;
}


?>
<style>
	.b {
		font-weight:bold;
	}
</style>
<div class="sr-main vacancy-img">
    <div class="uk-width-medium-1-1 bgcolorwhite uk-hidden-small breadcrumbs">
        <div class="uk-container-center uk-container">
             <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="/" class="uk-icon-home uk-text-muted"><meta itemprop="title" content="Главная"/></a></span>
             &nbsp;/&nbsp;
             <span class="uk-text-muted">Запчасти</span>
        </div>
    </div>
    <div class="uk-width-medium-1-1 bgcolorwhite uk-visible-small<?=$add_class?>">
        <div class="uk-container-center uk-container">
           <a href="tel:+<?=$phone?>" class="uk-contrast"><?=$phone_format?></a>
        </div>
    </div>
    <div class="uk-container-center uk-container ">
        <div class="uk-grid uk-margin-remove" data-uk-grid-margin>
            <div class="uk-width-medium-5-10"></div>
            <div class="uk-width-medium-5-10 whiteblock ">
                <h1>Актуальные вакансии сервисного центра</h1>
                <ul class="list-blue-marker">
                <?=$description_banner?>
                </ul>
                <p><input type="button" data-uk-modal="{target:'#popup'}" class=" uk-button  uk-button-large uk-button-success uk-margin-right" onclick="if (typeof window['yaCounter<?=$metrica?>'] !== 'undefined') yaCounter<?=$metrica?>.reachGoal('ORDER'); return false;" value="Записаться на курс"/>
                </p>
            </div>
        </div>
    </div>
</div>
<?
$block_holodilnink = "
                <p class=\"uk-h2 b\">Мастер по ремонту холодильного оборудования</p>
                <p>Полный рабочий день</p>
					Опыт работы от 1 года от 95 000 до 125 000 руб. в месяц
					<p class=\"uk-h4\">Условия работы:</p>
					<ul class=\"list-blue-marker\">
						<li>Работа на полную ставку, есть возможность выбрать удобный график </li>
						<li>Высокий процент на каждую выполненную заявку (от 45 %)</li>
						<li>График 5/2, 2/2, 3/3 на выбор (согласовывается)</li>
						<li>Постоянность заказов без сезонности (от 3 до 8 в день)</li>
						<li>Комплектующие и запчасти от закупщиков</li>
						<li>Официальное трудоустройство </li>
					</ul>
					<p class=\"uk-h4\">Основные обязанности:</p>
					<ul class=\"list-blue-marker\">
						<li>Работа на выезде к юридическим и физическим лицам</li>
						<li>Поиск неисправностей и поломок в холодильниках</li>
						<li>Проведение работ по ремонту холодильного оборудования</li>
						<li>Замена (блочная) поврежденных запчастей</li>
						<li>Расчет и согласование стоимости работ по ремонту</li>
						<li>Консультировать клиентов по эксплуатации техники и объяснять причину поломок</li>
						<li>Ежедневная отчетность</li>
					</ul>
					<p class=\"uk-h4\">Требования к кандидату:</p>
					<ul class=\"list-blue-marker\">
						<li>Приветствуется успешный опыт ремонта холодильников разных брендов</li>
						<li>Быть готовым в работе разъездного характера</li>
						<li>Желательно знание стандартных неисправностей холодильных систем</li>
						<li>Ответственность, клиентоориентированность, добросовестность, пунктуальность</li>
					</ul>
					<hr>
";
$block_holodilnink2 = "
					<p class=\"uk-h3 b\">Курс по ремонту холодильного оборудования – срок 2 недели.</p>
					<p class=\"uk-h4\">Теоретические знания, которые вы получите:</p>
					<ul class=\"list-blue-marker\">
						<li>устройство и компоненты холодильников различных брендов</li>
						<li>типовые неисправности и методы их диагностики</li>
						<li>принципы работы электронных и механических систем</li>
						<li>технологии устранения поломок, замена блочных компонентов</li>
						<li>общение с заказчиками и составление сметы</li>
					</ul>
					<p>Стоимость обучения всего <span style=\"color:green;\">15 000р.</span> старая цена <strike><span style=\"color:#B5B8B1;\">17 000р</strike></p>
					<input type=\"button\" data-uk-modal=\"{target:'#popup'}\" class=\" uk-button uk-button-large uk-button-success uk-margin-right\" onclick=\"if (typeof window['yaCounter] !== 'undefined') yaCounter.reachGoal('ORDER'); return false;\" value=\"Записаться на курс\">
                	<hr>
";
$block_mashin = "
				<p class=\"uk-h2 b\">Мастер по ремонту стиральных/посудомоечных машин</p>
                <p>Полный рабочий день</p>
					Опыт работы от 1 года от 85 000 до 119 000 руб. в месяц
					<p class=\"uk-h4\">Условия работы:</p>
					<ul class=\"list-blue-marker\">
						<li>Работа на полную ставку, есть возможность выбрать удобный график </li>
						<li>Высокий процент на каждую выполненную заявку (от 45 %)</li>
						<li>График 5/2, 2/2, 3/3 на выбор (согласовывается)</li>
						<li>Постоянность заказов без сезонности (от 3 до 8 в день)</li>
						<li>Комплектующие и запчасти от закупщиков</li>
						<li>Официальное трудоустройство </li>
					</ul>
					<p class=\"uk-h4\">Основные обязанности:</p>
					<ul class=\"list-blue-marker\">
						<li>Работа на выезде к юридическим и физическим лицам</li>
						<li>Поиск неисправностей и поломок в посудомоечных и стиральных машинах</li>
						<li>Проведение работ по ремонту холодильного оборудования</li>
						<li>Замена (блочная) поврежденных запчастей</li>
						<li>Расчет и согласование стоимости работ по ремонту</li>
						<li>Консультировать клиентов по эксплуатации техники и объяснять причину поломок</li>
						<li>Ежедневная отчетность</li>
					</ul>
					<p class=\"uk-h4\">Требования к кандидату:</p>
					<ul class=\"list-blue-marker\">
						<li>Приветствуется успешный опыт ремонта посудомоечных/стиральных машин разных брендов</li>
						<li>Быть готовым в работе разъездного характера</li>
						<li>Желательно знание стандартных неисправностей в посудомоечных и стиральных машинах</li>
						<li>Ответственность, клиентоориентированность, добросовестность, пунктуальность</li>
					</ul>
					<hr>
";
$block_mashin2 = "
					<p class=\"uk-h3 b\">Курс по ремонту стиральных и посудомоечных машин – срок 2 недели.</p>
					<p class=\"uk-h4\">Теоретические знания, которые вы получите:</p>
					<ul class=\"list-blue-marker\">
						<li>устройство и компоненты стиральных, посудомоечных машин от разных производителей</li>
						<li>типовые неисправности и методы их диагностики</li>
						<li>принципы работы электронных и механических систем</li>
						<li>технологии устранения поломок, замена блочных компонентов</li>
						<li>общение с заказчиками и составление сметы</li>
					</ul>
					<p>Стоимость обучения всего <span style=\"color:green;\">14 000р.</span> старая цена <strike><span style=\"color:#B5B8B1;\">16 000р</strike></p>
					<p><input type=\"button\" data-uk-modal=\"{target:'#popup'}\" class=\" uk-button uk-button-large uk-button-success uk-margin-right\" onclick=\"if (typeof window['yaCounter57452464'] !== 'undefined') yaCounter57452464.reachGoal('ORDER'); return false;\" value=\"Записаться на курс\"></p>
                <hr>
";


?>
<div class="sr-content">
    <div class="uk-container-center uk-container uk-margin-bottom">
        <div class="uk-flex sr-contetnt-block uk-margin-top">
            <div class="uk-width-large-7-10 sr-content-white">
            <? 
            	switch ($types) {
            		case 0:
		            echo $block_holodilnink;
		            echo $block_mashin;
            			break;
            		case 1:
		            echo $block_holodilnink;
		            	break;
		            case 2:
		            echo $block_mashin;
            			break;
            	}

            ?>
			<p><?=$description_vacancy?></p>
            <?  
            	switch ($types) {
            		case 0:
		            echo $block_holodilnink2;
		            echo $block_mashin2;
            			break;
            		case 1:
		            echo $block_holodilnink2;
		            	break;
		            case 2:
		            echo $block_mashin2;
            			break;
            	}
            ?>
			<p>Практические навыки отрабатываются после каждого занятия, в оборудованных всем необходимым, учебных классах.</p>
                
			</div>
            <? $vacancy = true; 
            	include __DIR__.'/rightPart2.php'; 
            ?>
        </div>
    </div>
</div>