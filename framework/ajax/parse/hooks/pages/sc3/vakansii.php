<?      
use framework\tools; 
use framework\rand_it;
use framework\ajax\parse\hooks\sc;

$marka_lower = mb_strtolower($this->_datas['marka']['name']);?>          

<div class="title-row">
    <div class="container">
        <h1><?=$this->_ret['h1']?></h1>
    </div>
</div>

<? $banner_img = '/templates/moscow/img/shared/banners/'.$this->_datas['images']['vakansii'];    
include __DIR__.'/banner.php'; 

$feed = $this->_datas['feed'];
$texts = array();
$texts[] = array('Компания '.$this->_datas['servicename'].' разыскивает', 'Компания '.$this->_datas['servicename'].' приглашает на работу',        
            'Компания '.$this->_datas['servicename'].' приглашает в свою команду');
            
$t_array = array('амбициозных', 'трудолюбивых', 'целеустремленных', 'стрессоустойчивых', 'коммуникабельных', 'внимательных',
            'честных', 'добросовестных');

$t_array = rand_it::randMas($t_array, 3, '', $feed);
$t_str = implode(', ', $t_array);

$texts[] = array($t_str);

$texts[] = array('сотрудников с опытом работы в');
$texts[] = array('сервисном центре', 'сервис центре');
$texts[] = array('от года:', 'от полугода:', 'от 6 месяцев:', 'от 9 месяцев:', 'от 12 месяцев:');

$peoples = array();

foreach ($this->_datas['all_devices'] as $device)
{
    $peoples[] = 'Мастер по ремонту '.$device['type_rm'];  
}

$peoples[] = 'Оператор call-центра';
$peoples[] = 'Менеджер приемщик';
$peoples[] = 'Курьер';

srand($feed);

?>

        <div class="aboutrow">
            <div class="container">
                <div class="abouttext">
                    <p><?=sc::_createTree($texts, $feed);?></p>
                      <ul>
                        <? foreach (rand_it::randMas($peoples, rand(3, count($peoples)), '', $feed) as $people):?>
                        <li><?=$people?></li>
                        <? endforeach;?>
                    </ul>
                </div>
            </div>
        </div>

        <div class="vakanrow">
            <div class="container">
                <div class="vakanlist">
                    <ul class="tabs">
                        <li class="active" data-toggle="tab" data-target="#tab-1">Менеджер</li>
                        <li class="" data-toggle="tab" data-target="#tab-2">Мастер</li>
                    </ul>
                    <div class="tabs-content">
                        <div id="tab-1" class="tab-content active">
                            <div class="vakantext">
                                <p><strong>Требования к менеджерам:</strong></p>
                                <ul>
                                    <li>Девушка от 25 лет.</li>
                                    <li>Грамотная письменная и устная речь.</li>
                                    <li>Опыт работы с клиентами от 1 года.</li>
                                    <li>Хотя-бы минимальные знания структуры электронных устройств.</li>
                                    <li>Пунктуальность, ответственность, чистоплотность, аккуратность, желание развиваться, умение работать в коллективе, активность. Очень ценится умение быстро и правильно реагировать в любой ситуации, а именно - находчивость.</li>
                                </ul>
                                <p><strong>Условия:</strong></p>
                                <ul>
                                    <li>График 5/2.</li>
                                    <li>Ежедневная фиксированная оплата труда.</li>
                                    <li>Лояльное руководство.</li>
                                    <li>Возможность быстрого развития и повышение квалификации.</li>
                                    <li>Сплоченная, молодая команда.</li>
                                    <li>Праздничные премии и премии за особые заслуги.</li>
                                    <li>Обучение работе с внутренней базой компании.</li>
                                    <li>Оплата с первого дня работы.</li>
                                </ul>
                                <p>Свои резюме отправляйте на почту <a href="mailto:remont@<?=$this->_datas['site_name']?>">remont@<?=$this->_datas['site_name']?></a> или через форму обратной связи на странице <a href="/kontakty/">контакты</a>.</p>
                            </div>
                        </div>
                        <div id="tab-2" class="tab-content">
                            <div class="vakantext">
                                <p><strong>Требования к мастерам:</strong></p>
                                <ul>
                                    <li>Высокий уровень компетентности.</li>
                                    <li>Умение выполнять сложный ремонт (пайка, восстановление текстолита, реболл БГА чипов, ремонт северного, южного моста, короткое замыкание на плате, прошивка bios и прочее.)</li>
                                    <li>Опыт работы от 5 лет.</li>
                                    <li>Пунктуальность, ответственность, желание развиваться, аккуратность.</li>
                                </ul>
                                <p><strong>Условия:</strong></p>
                                <ul>
                                    <li>График (по договоренности).</li>
                                    <li>Высококачественное оборудование, такое как: станция "ТЕРМОПРО 650". Личное рабочее место с микроскопом, паяльной станцией, хим.средствами, всеми возможными инструментами.</li>
                                    <li>Ежедневная оплата труда.</li>
                                    <li>Высокие фиксированные цены на ремонт по сравнению с рыночными в сервисных центрах.</li>
                                    <li>Опытные мастера, к которым всегда можно обратиться за советом.</li>
                                    <li>Возможность быстрого развития и повышение квалификации.</li>
                                    <li>Работа БЕЗ общения с клиентами.</li>
                                    <li>Праздничные премии и премии за особые заслуги.</li>
                                </ul>
                                <p>Свои резюме отправляйте на почту <a href="mailto:remont@<?=$this->_datas['site_name']?>">remont@<?=$this->_datas['site_name']?></a> или через форму обратной связи на странице <a href="/kontakty/">контакты</a>.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
         <ul class="breadcrumb">
            <li><a href="/">Главная</a></li>
            <li>Вакансии</li>
        </ul>