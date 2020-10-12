<?
use framework\tools;

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


$pomoshch[] = '{{^{{качественный | надежный | гарантированный| отличный} результат}^(1), 
^{{демократичные | низкие | фиксированные | доступные} цены}^(1)}|{
 ^{цены - {демократичные | низкие | фиксированные | доступные}} ^(2), 
 ^{результат - {качественный | надежный | гарантированный}} ^(2)}}';

$pomoshch[] ='{Бесплатный выезд | Срочный выезд | Оперативный выезд | Быстрый выезд | Выезд } 
{мастера | специалиста | системного администратора | сис&#46;админа | программиста | программного инженера} 
{{в течение {30 минут | получаса | 30-60 минут | часа | одного часа | 1 часа | 60 минут} 
}|{	от 30 до 60 минут }|{в пределах {30 минут | получаса | 30-60 минут | часа | одного часа | 1 часа | 60 минут} }}';

$pomoshch[] ='{{Компьютерная помощь }|{	Помощь { с ПО | с программным обеспечением }}} {на дому или в офисе | в офисе или на дому}';
shuffle($pomoshch);
?>

<div class="sr-main kompyuternaya-pomoshch-img">
    <div class="uk-width-medium-1-1 bgcolorwhite uk-hidden-small breadcrumbs">
        <div class="uk-container-center uk-container">
             <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="/" class="uk-icon-home uk-text-muted"><meta itemprop="title" content="Главная"/></a></span>
             &nbsp;/&nbsp;
             <span class="uk-text-muted">Помощь с ПО</span>
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
                <h1><?=$this->_ret['h1']?></h1>
                <ul class="list-blue-marker">
                    <li><?=tools::new_gen_text($pomoshch[0]);?></li>
                    
                    <li><?=tools::new_gen_text($pomoshch[1]);?></li>
                    
                    <li><?=tools::new_gen_text($pomoshch[2]);?></li>
                </ul>
                <p><input type="button" data-uk-modal="{target:'#popup'}" class=" uk-button  uk-button-large uk-button-success uk-margin-right" onclick="if (typeof window['yaCounter<?=$metrica?>'] !== 'undefined') yaCounter<?=$metrica?>.reachGoal('ORDER'); return false;" value="Выезд мастера"/>
                </p>
            </div>
        </div>
    </div>
</div>

<div class="sr-content">
    <div class="uk-container-center uk-container uk-margin-bottom">
        <div class="uk-flex sr-contetnt-block uk-margin-top sr-content-main">
            <div class="uk-width-large-7-10 sr-content-white ">
                <div class="uk-clearfix ">
                    <h2>Компьютерная помощь в <?=$region_name_pe?></h2>
                    <p>
                        <?=tools::new_gen_text('{Что делать, |Что предпринять,} {если вдруг | если | когда } {внезапно | без видимых причин} 
                            {на мониторе | на дисплее} {появился | возник} {«синий экран смерти» | экран BSOD} и 
                            {требуется | необходима | срочно необходима | срочно требуется | крайне необходима 
                            | крайне требуется | нужна | срочно нужна |  срочно требуется} компьютерная помощь? 
                            
                            {Или | Или же } {{ ваш {ноутбук | компьютер | ПК | моноблок | лэптоп | персональный компьютер } 
                            {{перестал открывать {все | } {{офисные {программы?|пакеты приложений?} }|{	
                            программы пакета Office? }}	}|{	не открывает {все| никакие| } { {офисные {программы? | пакеты приложений?}
                            }|{	программы пакета Office? } } } }}|{
                            {на вашем | на} {ноутбуке | компьютере | ПК | персональном компьютере | моноблоке | лэптопе } 
                            {{не открываются {все | никакие | } {{офисные {программы? |пакеты приложений?} 
                            }|{ программы пакета Office? }}}|{перестали открываться {все | } 
                            {{офисные {пакеты приложений? | программы?} }|{программы пакета Office? }}}}}} 
                            
                            {Вопросов | Число вопросов} может {быть | образоваться | сформироваться | накопиться } 
                            {{{бесчисленное | бесконечное} {множество, |количество, } }|{{огромное |большое} количество, }} 
                            {однако,| но,| как бы то ни было,} {{{единственно верный | единственно правильный | верный | правильный |} 
                            {ответ | выход} {всегда | только | } один {{{– звонить | - писать | - звонить или писать | - писать или звонить} 
                            {нам!|нам.} }|{-  обращаться {к нам! | к нам.} } } }|{ {единственный| единственно верный| единственно правильный} 
                            {выход|ответ} {из данной | в данной | в этой |из этой} ситуации 
                            {{– звонить | - писать | - звонить или писать | - писать или звонить } {нам! | нам.} } |{-  обращаться {к нам! |к нам.} }}}
                            
                            {{Мы {устраняем | ликвидируем | поможем устранить | поможем ликвидировать } {любые | все} 
                            {проблемы,| ошибки, | неполадки, } связанные с 	^{операционной системой | ОС}^(1) и ^{программным обеспечением| ПО}^(1). 
                            }|{	{Наша компания | Наш сервис | Наш сервисный центр} устраняет {любые | все |} проблемы, связанные с 
                            {ошибками | фатальными ошибками | неполадками | совместимостью } ^{операционной системы | ОС}^(2) и ^{программного обеспечения | ПО}^(2). 
                            }|{	{Наши сотрудники | Наши специалисты | Наши мастера } {{устраняют | устранят | помогут устранить |ликвидируют} 
                            {любые | все} проблемы, связанные с {ошибками | фатальными ошибками | неполадками | совместимостью} 
                            ^{операционной системы | ОС}^(3) и ^{программного обеспечения | ПО}^(3). 
                            }|{избавят вас от {любых | всех } проблем, связанных с {ошибками | фатальными ошибками | неполадками | совместимостью } 
                            ^{операционной системы | ОС}^(4) и ^{программного обеспечения | ПО}^(4).}}} 
                            
                            {Будь то, | Это могут быть,} 
                            ^{неправильная настройка BIOS |неправильная настройка БИОС | нехватка свободного места на жестком диске |
                            заражение различными вредоносными программами | разгон процессора и оперативной памяти | заражение вирусами 
                            заражение вредоносными программами | отсутствие свободного места на жестком диске}^(5), 
                            ^{неработающий драйвер | конфликт драйверов | несовместимость драйвера с операционной системой | 
                            несовместимость драйвера с ОС | несовместимость программ и компонентов}^(5), или 
                            {{работы по установке {новой ОС | новой операционной системы | нескольких ОС на один ПК | 
                            нескольких операционных систем на 1 ПК | нескольких операционных систем на 1 компьютер |
                            нескольких ОС на один компьютер | обновлению ОС | Windows | Виндоус} и настройке {всех | } 
                            {программ и компонентов. | программ. | приложений.} }|{
                            работы по установке {специализированного ПО | специализированного программного обеспечения} и его настройке. }|{
                            работы по {восстановлению ОС. | восстановлению операционной системы.} }|{
                            работы по настройке {сети Интернет. | роутера. | принтера. | системы сетевой безопасности. }}}
                            
                            {{Мы {превосходно | отлично | безупречно | первоклассно | блестяще } {{
                            справляемся {с такими | с этими | со всеми} {задачами | работами}}|{выполняем такие {задачи | работы} 
                            }|{ проводим такие работы } }}|{ {Наша компания | Наш сервисный центр | Наш сервис | Наш сервис центр } 
                            {превосходно | отлично | безупречно | первоклассно | блестяще} справляется {с такими | с этими | со всеми} {задачами | работами}}
                            } благодаря нашим {	{ { сотрудникам – мастерам {на все руки.|своего дела.} }|{ мастерам. 
                            }|{ специалистам профессионалам своего дела. } }|{ {высоковалифицированным | профессиональным |
                             опытным | многоопытным | квалифицированным | высокопрофессиональным | грамотным | умелым | компетентным } 
                            {сотрудникам. | мастерам. | специалистам. | системным администраторам. | сис.админам. } }} ')?>
                    </p>
                </div>
                <hr>    
                <h2>Прейскурант цен на услуги компьютерной помощи:</h2>
                <table class="priceTable uk-table uk-table-hover uk-table-striped services">
                    <tbody>
                        <tr class="uk-text-small active"><th>Наименование услуги</th><th class="uk-text-center">Время ремонта, мин</th><th class="uk-text-center">Цена, руб</th></tr>
                        <tr><td>Выезд мастера</td><td class="uk-text-center">30 </td><td class="uk-text-center">Бесплатно</td></tr>
                        <tr><td>Диагностика</td><td class="uk-text-center">15 </td><td class="uk-text-center">Бесплатно</td></tr>
                        <tr><td>Активация антивируса (лицензионный ключ заказчика)</td><td class="uk-text-center">20</td><td class="uk-text-center">350</td></tr>
                        <tr><td>Базовая настройка Wi-Fi роутера</td><td class="uk-text-center">20 </td><td class="uk-text-center">330</td></tr>
                        <tr><td>Восстановление не работающей ОС</td><td class="uk-text-center">45 </td><td class="uk-text-center">350</td></tr>
                        <tr><td>Восстановление пароля Wi-Fi роутера</td><td class="uk-text-center">15 </td><td class="uk-text-center">690</td></tr>
                        <tr><td>Клонирование MAC-адреса устройства</td><td class="uk-text-center">5 </td><td class="uk-text-center">150</td></tr>
                        <tr><td>Лечение от вирусов</td><td class="uk-text-center">10 </td><td class="uk-text-center">364</td></tr>
                        <tr><td>Настройка / установка программ</td><td class="uk-text-center">10 </td><td class="uk-text-center">150</td></tr>
                        <tr><td>Настройка 1С и другого специального ПО</td><td class="uk-text-center">10 </td><td class="uk-text-center">650</td></tr>
                        <tr><td>Настройка WINDOWS</td><td class="uk-text-center">45 </td><td class="uk-text-center">250</td></tr>
                        <tr><td>Настройка БИОС</td><td class="uk-text-center">45 </td><td class="uk-text-center">560</td></tr>
                        <tr><td>Настройка почты</td><td class="uk-text-center">5 </td><td class="uk-text-center">450</td></tr>
                        <tr><td>Настройка принтера</td><td class="uk-text-center">10 </td><td class="uk-text-center">420</td></tr>
                        <tr><td>Настройка роутера</a></td><td class="uk-text-center">10 </td><td class="uk-text-center">480</td></tr>
                        <tr><td>Обновление драйверов</td><td class="uk-text-center">5 </td><td class="uk-text-center">110</td></tr>
                        <tr><td>Обновление микропрограммы роутера</td><td class="uk-text-center">5 </td><td class="uk-text-center">100</td></tr>
                        <tr><td>Обновление операционной системы</a></td><td class="uk-text-center">45 </td><td class="uk-text-center">440</td></tr>
                        <tr><td>Обучение работе с ПК</a></td><td class="uk-text-center">60 </td><td class="uk-text-center">690</td></tr>
                        <tr><td>Определение причины неисправности сигнала роутера</td><td class="uk-text-center">15 </td><td class="uk-text-center">200</td></tr>
                        <tr><td>Полная антивирусная профилактика ПК</td><td class="uk-text-center">25 </td><td class="uk-text-center">450</td></tr>
                        <tr><td>Полная настройка системы сетевой безопасности</td><td class="uk-text-center">40 </td><td class="uk-text-center">360</td></tr>
                        <tr><td>Рекомендации и помощь в подключении к новому провайдеру связи</td><td class="uk-text-center">20 </td><td class="uk-text-center">350</td></tr>
                        <tr><td>Создание домашней сети "под ключ" (более 5 устройств)</td><td class="uk-text-center">40 </td><td class="uk-text-center">450</td></tr>
                        <tr><td>Создание домашней сети "под ключ" (до 5 устройств)</td><td class="uk-text-center">30 </td><td class="uk-text-center">400</td></tr>
                        <tr><td>Тестирование качества Интернет-соединения</td><td class="uk-text-center">5 </td><td class="uk-text-center">330</td></tr>
                        <tr><td>Удаление вирусов</td><td class="uk-text-center">10 </td><td class="uk-text-center">310</td></tr>
                        <tr><td>Удаление вирусов в системных файлах</td><td class="uk-text-center">10 </td><td class="uk-text-center">350</td></tr>
                        <tr><td>Удаление вирусов на съемных носителях с сохранением информации</td><td class="uk-text-center">10 </td><td class="uk-text-center">350</td></tr>
                        <tr><td>Установка WINDOWS</td><td class="uk-text-center">60 </td><td class="uk-text-center">364</td></tr>
                        <tr><td>Установка антивируса (1 год)</td><td class="uk-text-center">10 </td><td class="uk-text-center">390</td></tr>
                        <tr><td>Установка антивируса с дистрибутива заказчика</td><td class="uk-text-center">10 </td><td class="uk-text-center">350</td></tr>
                        <tr><td>Установка графических редакторов</td><td class="uk-text-center">10 </td><td class="uk-text-center">340</td></tr>
                        <tr><td>Установка двух и более ОС на 1 ПК</td><td class="uk-text-center">45 </td><td class="uk-text-center">550</td></tr>
                        <tr><td>Установка драйверов</td><td class="uk-text-center">5 </td><td class="uk-text-center">190</td></tr>
                        <tr><td>Установка и настройка Банк-Клиент</td><td class="uk-text-center">15 </td><td class="uk-text-center">650</td></tr>
                        <tr><td>Установка и настройка удаленного доступа к компьютеру</td><td class="uk-text-center">10 </td><td class="uk-text-center">410</td></tr>
                        <tr><td>Установка офисного пакета (Word, Excel)</td><td class="uk-text-center">10 </td><td class="uk-text-center">690</td></tr>
                        <tr><td>Установка программного обеспечения</td><td class="uk-text-center">20 </td><td class="uk-text-center">450</td></tr>
                    </tbody>
                </table>
                
                <div class="target-content-block uk-grid uk-padding form-bid">
                    <div class="uk-width-large-8-10">
                        <p>
                            <?=tools::new_gen_text('
                                    {{{Чтобы | Для того, чтобы} вызвать }|{	Для вызова }}  
                                    {специалиста, | мастера, | специалиста нашего сервиса, | специалиста нашего сервисного центра, 
                                    мастера нашего сервиса, | мастера нашего сервисного центра,} 
                                    {достаточно просто | необходимо | необходимо просто | нужно всего лишь | нужно просто}  
                                    {{позвонить нам {или | или же } {оставить | разместить} {заявку | запрос | обращение } 
                                    {{{на сайте. | онлайн. | online.} }|{ через {форму обратной связи | контактную форму} {на сайте|}. }} 
                                    }|{	набрать	{наш номер:| наш номер телефона:| наш контактный номер:| наш контактный номер телефона:| 
                                    контактный номер нашего телефона:| номер нашего телефона:| номер нашей горячей линии:| телефон нашей горячей линии:} 
                                    '.$phone_format.' {или | или же} {оставить | разместить} {заявку | запрос | обращение} 
                                    {{{на сайте. | онлайн. |online.} }|{ через {форму обратной связи | контактную форму} {на сайте|}.}}}} 
                                    
                                    {Сотрудник | Специалист | Мастер | Системный администратор | Сис.админ } 
                                    {сервисного центра | сервис центра | сервиса | нашего сервисного центра | нашего сервис центра | нашего сервиса } 
                                    {приедет | прибудет | подъедет | выедет } {{к вам	{{{на дом | домой} илив офис }|{в офис или на дом }} в день обращения 
                                    {и быстро | и оперативно | и в срочном порядке} {устранит | решит} {проблему|неполадку} {с |с вашим} 
                                    ^{ПК | компьютером}^(6), ^{моноблоком}^(6) или ^{ноутбуком|лэптопом}^(6). 
                                    }|{	к вам {на дом/ в офис | домой/ в офис} в день обращения {и быстро | и оперативно | и в срочном порядке} 
                                    {устранит | решит} {проблему | неполадку} {с|с вашим} 
                                    ^{ПК | компьютером}^(7), ^{моноблоком}^(7) или ^{ноутбуком|лэптопом}^(7).  
                                    }|{{по вашему адресу | на указанный вами адрес | по указанному вами адресу} {{
                                    {в оговоренное | в условленное} время и день }|{{в оговоренный | в условленный} {день и время | час и день} 
                                    }} {и быстро | и оперативно | и в срочном порядке} {устранит | решит} {проблему | неполадку} { с|с вашим} 
                                    ^{ПК | компьютером}^(8), ^{моноблоком}^(8) или ^{ноутбуком|лэптопом}^(8). 
                                    }|{ {по вашему адресу|на указанный вами адрес|по указанному вами адресу} 
                                    {и быстро | и оперативно | и в срочном порядке} окажет компьютерную помощь 
                                    {{на дому или в офисе. }|{в офисе или на дому. }}}} 
                                    
                                    {{На все {работы|услуги} }|{На все виды {работ | услуг} }} 
                                    {оформляем|выписываем|выдаем|предоставляем} 
                                    {гарантию|  гарантийный чек|  гарантийный талон|  чек и гарантийный талон|
                                     кассовый чек и гарантийный талон|  гарантийный талон и чек|  товарно-гарантийный чек} 
                                    {с печатью организации|на фирменном бланке|с печатью компании|}.')?>
                        </p>
                        <div class="uk-grid uk-margin-bottom">
                            <div class="uk-width-medium-1-2">
                                <p class="uk-text-bold uk-h3 textmobile uk-margin-bottom">
                                    <a href="tel:+<?=$phone?>"><?=$phone_format?></a>
                                </p>
                            </div>
                            <div class="uk-width-medium-1-2">
                                <p class="textmobile">
                                        <span class="">
                                            <input type="button" data-uk-modal="{target:'#popup'}" class=" uk-button uk-button-success uk-margin-left" onclick="if (typeof window['yaCounter41536289'] !== 'undefined') yaCounter41536289.reachGoal('ORDER'); return false;" value="Вызвать мастера">
                                        </span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="uk-width-large-2-10 uk-hidden-small uk-hidden-medium uk-position-relative pcHelpPage">
                        <img src="/wp-content/themes/studiof1/img/call-center.png">
                    </div>
                </div>
            </div><!---->

            <div class="uk-width-large-3-10 sr-content-inertnit">
                <div class="uk-grid uk-grid-medium right-part-new" data-uk-grid-margin="">
                    
                    <div class="uk-width-medium-1-1 uk-grid-margin uk-row-first">
                        <div class="uk-panel uk-panel-box uk-panel-box-secondary sr-block-white diagnostika">
                            <p class="uk-h3">Бесплатная диагностика</p>
                            <p>Выявление неисправностей за 15 минут</p><a href="/diagnostika">Подробнее</a>
                        </div>
                    </div>

                    <div class="uk-width-medium-1-1 uk-grid-margin uk-row-first">
                        <div class="uk-panel uk-panel-box uk-panel-box-secondary sr-block-white rabota">
                            <p class="uk-text-large">График работы</p>
                            <p>Работаем без выходных и перерывов: <br><?=str_replace(',','<br>',$time)?></p><p>
                                <a href="/kontakty">Подробнее</a>
                            </p>
                        </div>
                    </div>
                    
                    <div class="uk-width-medium-1-1 uk-grid-margin uk-row-first">
                        <div class="uk-panel uk-panel-box uk-panel-box-secondary sr-block-white garantia">
                            <p class="uk-text-large">Фирменная гарантия</p>
                            <p>Гарантия на услуги компьютерной помощи до 6 месяцев</p>
                        </div>
                    </div>

                    <div class="uk-width-medium-1-1 uk-grid-margin uk-row-first">
                        <div class="m-l-20 m-t-50">
                            <div class="uk-clearfix<?=$add_class?>">
                                <img src="/wp-content/themes/studiof1/images/call-center.png" class="uk-align-right uk-margin-bottom-remove uk-hidden-small uk-hidden-medium">
                                <p class="uk-text-large"><a href="tel:+<?=$phone?>"><?=$phone_format?></a></p>
                                <p class="uk-margin-bottom">Единый номер телефона сервисного центра</p>
                            </div>
                            <hr style="margin-top: 0px !important;" class="<?=$add_class?>">
                            <p class="uk-text-large">Спросите Russia Expert</p>
                            <p>Получите консультацию специалистов Russia Expert по вопросам ремонта и обслуживания техники.</p>
                            <form class="uk-form">
                                <fieldset data-uk-margin>
                                    <p><input class="uk-width-1-1 tel" type="text" placeholder="Номер телефона"></p>
                                    <p><input class="uk-width-1-1 name" type="text" placeholder="Имя и фамилия"></p>
                                    <p><textarea class="uk-width-1-1" cols="30" rows="5" placeholder="Ваш вопрос"></textarea></p>
                                    <p class='consent uk-text-small'><label style="display: block; "><input class="datago" type="checkbox" style="float: left; width: 14px; height: 14px; margin: 3px 5px 3px 0px;" checked required>Я даю согласие на обработку персональных данных.</label></p>
                                    <p class="uk-text-center"><button class="uk-button uk-button-success uk-button-large" type="button" onclick="if (typeof window['yaCounter<?=$metrica?>'] !== 'undefined') yaCounter<?=$metrica?>.reachGoal('VOPROS'); return false;">Задать вопрос</button></p>
                                </fieldset>
                            </form>
                            <hr class="uk-hidden-small">
                        </div>
                    </div>

                </div>
            </div>
            
        </div>
    </div>
</div>