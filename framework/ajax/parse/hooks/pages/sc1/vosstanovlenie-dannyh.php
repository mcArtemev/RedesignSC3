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


$pomoshch[] = '{{{Извлечение | Восстановление} {поврежденных | утраченных | удаленных | стертых} данных }|{
    {Извлечение | Восстановление} {поврежденной | утраченной | удаленной | стертой} информации }} 
    {{{с любого | со всякого} {носителя | накопителя | устройства | запоминающего устройства} }|{
    со всех {носителей | накопителей | устройств | запоминающих устройств} }} ';

$pomoshch[] ='{Срочный | Оперативный | Быстрый | Немедленный | Экстренный} выезд 
    {мастера | специалиста | программного инженера} {{
    ^на дом^(0) или ^{в офис | на рабочее место}^(0) }|{
    к вам ^{домой | на дом}^(1) или ^{в офис | на рабочее место}^(1) }}  ';

$pomoshch[] ='Гарантия {{сохранения конфиденциальности }|{неразглашения {данных | информации | конфиденциальных данных} 
    }|{^сохранности^(2) и ^неприкосновенности^(2) {информации | данных} }} ';
shuffle($pomoshch);

$arr1 = [
    ['файлы','данные',],
    ['данные','файлы', ],
];
$arr2 = [
    ['данных','файлами'],
    ['файлов','данными'],
];
$arr3 = [
    ['заказчиком|клиентом','ему'],
    ['вами','вам'],
];
$arr4 = [
    ['мастер | специалиста | программного инженера | мастера сервиса','менеджеров | операторов |технических специалистов'],
    ['мастер | специалиста | программного инженера | мастера сервиса | специалиста сервиса','менеджеров | операторов '],
];
srand($this->_datas['feed']);
$i = rand(0,1);


?>

<div class="sr-main vosstanovlenie-dannyh-img">
    <div class="uk-width-medium-1-1 bgcolorwhite uk-hidden-small breadcrumbs">
        <div class="uk-container-center uk-container">
            <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="/" class="uk-icon-home uk-text-muted"><meta itemprop="title" content="Главная"/></a></span>
            &nbsp;/&nbsp;
            <span class="uk-text-muted">Восстановление данных</span>
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
                    <h2>Восстановление данных в <?=$region_name_pe?></h2>
                    <p>
                        <?=tools::new_gen_text('Мы {{занимаемся восстановлением {данных | информации} {с любых | со всех} {устройств:|носителей:} 
                            }|{{проводим | делаем | выполняем | осуществляем} восстановление {данных | информации} 
                            {с любых | со всех} {устройств: | носителей:} }} ^{HDD|жестких дисков}^(0), 
                            ^{серверов | ПК | компьютеров | ноутбуков | лэптопов | персональных компьютеров | планшетов}^(0) и 
                            ^{дисковых RAID массивов | RAID | RAID-массивов | аппаратных RAID | РЕЙД }^(0),
                            ^{USB-флешек | флешек | USB | флеш-накопителей}^(0), а также 
                            ^{карт памяти | SD карт | miniSD карт | microSD карт | TF карт | M2 карт}^(0) и 
                            ^{SSD |твердотельных накопителей | SSHD | SSD-накопителей | NAND SSD|RAM SSD}^(0). 
                            
                            {Если | Если вдруг,} при {физических | механических }  повреждениях образовались 
                            {{^{сколы | вмятины }^(1) {и | или } ^{царапины | потертости}^(1), произошло попадание {влаги | воды| жидкости},
                            {{{компьютер | ПК | ноутбук | смартфон | накопитель | носитель | лэптоп | персональный компьютер | планшет} 
                            перестал {включаться | запускаться} или начал }|{устройство перестало {включаться | запускаться} или начало } } 
                            {выдавать | показывать | обнаруживать} {ошибку, | баг,} то мы {{поможем {извлечь | вернуть | восстановить} {информацию | данные} }|{
                            окажем помощь {по извлечению | по возврату | по восстановлению} {информации | данных} }} 
                            {без потерь. | в целости. | без риска потери. | в полном объеме. | в целости и без потерь. | без потерь и в полном объеме.} 
                            }|{{сколы, | вмятины, | царапины, | потертости, | сколы и вмятины, | сколы и царапины, | сколы и потертости, |
                            вмятины и сколы, | царапины и сколы, | потертости и сколы, | царапины и | потертости, | потертости и царапины, | 
                            вмятины и царапины, | вмятины и потертости,} произошло попадание {влаги | воды | жидкости}, 
                            {{{компьютер | ПК | ноутбук | смартфон | накопитель | носитель | лэптоп | персональный компьютер | планшет } 
                            перестал {включаться | запускаться} или начал }|{устройство перестало {включаться | запускаться} или начало }} 
                            {выдавать | показывать | обнаруживать} {ошибку, | баг,} то мы {{поможем {извлечь | вернуть | восстановить} {информацию |данные} }|{
                            окажем помощь {по извлечению | по возврату | по восстановлению} {информации | данных} }} 
                            {без потерь. | в целости. | без риска потери. | в полном объеме. | в целости и без потерь. | без потерь и в полном объеме.} }} 
                            
                            {{{Если | Если ваши} '.$arr1[$i][0].' были ^{случайно | нечаянно | непреднамеренно}^(2) или 
                            ^{ преднамеренно | умышленно | предумышленно | нарочно | намеренно}^(2) {удалены | стерты | уничтожены} 
                            с {жесткого диска, | устройства, | запоминающего устройства, | компьютера, |
                            ПК, | ноутбука, | смартфона, | накопителя, | носителя, | лэптопа, | персонального компьютера, | планшета,} 
                            {{{произошел |случился} сбой }|{произошел {выход из строя | отказ в работе} }|{	{произошло | случилось} 
                            {повреждение | нарушение работы} } } ^{операционной системы | ОС}^(3) {или | и } ^{базы данных | банка данных | бд}^(3), 
                            {{информация {потеряна | утрачена | стёрта | зашифрована} при заражении 
                            {вирусами | вредоносными программами | вредоносным ПО}, то мы {восстановим | извлечем | вернем} {и эти '.$arr1[$i][1].'.|их. }
                            }|{'.$arr1[$i][1].' {потеряны | утрачены | стёрты |зашифрованы} при заражении 
                            {вирусами | вредоносными программами | вредоносным ПО}, то мы {восстановим | извлечем | вернем} {и эту информацию.|их. } 
                            }}}|{{Если | Если ваша} информация была 
                            ^{случайно | нечаянно | непреднамеренно}^(7) или ^{преднамеренно | умышленно | предумышленно | нарочно | намеренно}^(7)
                            {удалена | стерта | уничтожена } с {жесткого диска, | устройства, | запоминающего устройства, | компьютера, |
                            ПК, | ноутбука, | смартфона, | накопителя, | носителя, | лэптопа, | персонального компьютера, | планшета,} 
                            {{{произошел |случился} сбой }|{произошел {выход из строя | отказ в работе} }|{	{произошло | случилось} 
                            {повреждение | нарушение работы} }} ^{операционной системы | ОС}^(8) {или | и } ^{базы данных | банка данных | бд}^(8), 
                            '.$arr1[$i][0].' {потеряны | утрачены | стёрты |зашифрованы} при заражении 
                            {вирусами | вредоносными программами | вредоносным ПО}, то мы {восстановим | извлечем | вернем} {и эти '.$arr1[$i][1].'.|их. }}} 
                            
                        ')?>
                    </p>
                </div>
                <hr>
                <h2>Прейскурант цен на услуги по восстановлению данных:</h2>
                <table class="priceTable uk-table uk-table-hover uk-table-striped services">
                    <tbody>
                        <tr class="uk-text-small active"><th>Наименование услуги</th><th class="uk-text-center">Время, <br>мин</th><th class="uk-text-center">Цена, руб</th></tr>
                        <tr><td>Выезд специалиста</td><td class="uk-text-center">30 </td><td class="uk-text-center">0</td></tr>
                        <tr><td>Диагностика</td><td class="uk-text-center">15 </td><td class="uk-text-center">0</td></tr>
                <!--    </tbody>-->
                <!--</table>-->
                
                <!--<table class="priceTable uk-table uk-table-hover uk-table-striped services">-->
                <!--    <tbody>-->
                        <tr  class="uk-text-small active"><th class="uk-text-center">HDD и SSHD</th><th class="uk-text-center">Время, <br>часы</th><th class="uk-text-center">Цена, руб</th></tr>
                        <tr><td>Копирование восстановленных данных</td><td class="uk-text-center">от 2 </td><td class="uk-text-center">1200</td></tr>
                        <tr><td>Копирование данных с исправного носителя (без работ по восстановлению данных)</td><td class="uk-text-center">от 2 </td><td class="uk-text-center">1200</td></tr>
                        <tr><td>Создание посекторной копии исправного носителя</td><td class="uk-text-center">от 12 </td><td class="uk-text-center">2000</td></tr>
                        <tr><td>Логические проблемы на исправных жестких дисках</td><td class="uk-text-center">от 8  </td><td class="uk-text-center">1000</td></tr>
                        <tr><td>Нечитаемые сектора, BAD блоки</td><td class="uk-text-center">от 24 </td><td class="uk-text-center">2000</td></tr>
                        <tr><td>Неисправность контроллера</td><td class="uk-text-center">от 48  </td><td class="uk-text-center">2000</td></tr>
                        <tr><td>Неисправность блока магнитных головок</td><td class="uk-text-center">от 72  </td><td class="uk-text-center">5000</td></tr>
                        <tr><td>Залипание магнитных головок</td><td class="uk-text-center">от 48  </td><td class="uk-text-center">3000</td></tr>
                        <tr><td>Заклинивание вала двигателя жесткого диска</td><td class="uk-text-center">от 48 </td><td class="uk-text-center">6000</td></tr>
                        <tr><td>Проблемы с микропрограммой (служебная область диска)</td><td class="uk-text-center">от 24 </td><td class="uk-text-center">3000</td></tr>
                        <tr><td>Снятие пароля c HDD (с сохранением информации)</td><td class="uk-text-center">от 8 </td><td class="uk-text-center">3000</td></tr>
                        <tr><td>Повреждения поверхности пластин (царапины/сколы)</a></td><td class="uk-text-center">от 72 </td><td class="uk-text-center">10000</td></tr>

                        <tr class="uk-text-small active"><th class="uk-text-center">RAID и NAS</th><th class="uk-text-center"></th><th class="uk-text-center"></th></tr>
                        <tr><td>Копирование восстановленных данных</td><td class="uk-text-center">от 2 </td><td class="uk-text-center">0</td></tr>
                        <tr><td>Восстановление данных массива из 2 дисков: RAID 0, RAID 1 (за массив)</td><td class="uk-text-center">от 48 </td><td class="uk-text-center">2000</td></tr>
                        <tr><td>Восстановление данных массива из 3 и более дисков (за каждый диск массива)</td><td class="uk-text-center">от 48 </td><td class="uk-text-center">3000</td></tr>
                        <tr><td>Сбор RAID (за диск)</td><td class="uk-text-center">от 48 </td><td class="uk-text-center">5800</td></tr>

                        <tr class="uk-text-small active"><th class="uk-text-center">Флешки, карты памяти, SSD диски</th><th class="uk-text-center"></th><th class="uk-text-center"></th></tr>
                        <tr><td>Копирование восстановленных данных</td><td class="uk-text-center">от 1 </td><td class="uk-text-center">0</td></tr>
                        <tr><td>Выпайка и вычитка чипов на оборудовании</td><td class="uk-text-center">от 2 </td><td class="uk-text-center">1400</td></tr>
                        <tr><td>Логические проблемы на исправных носителях</td><td class="uk-text-center">от 2 </td><td class="uk-text-center">1000</td></tr>
                        <tr><td>Физические неисправности устройств (до 16 Гб)</td><td class="uk-text-center">от 8 </td><td class="uk-text-center">3000</td></tr>
                        <tr><td>Физические неисправности устройств (свыше 16 Гб)</td><td class="uk-text-center">от 8 </td><td class="uk-text-center">8000</td></tr>
                        <tr><td>Аппаратные неисправности (накопитель не определяется)</td><td class="uk-text-center">от 8 </td><td class="uk-text-center">4000</td></tr>
                        <tr><td>Повреждение контроллера, разрушение ячеек памяти NAND</td><td class="uk-text-center">от 8 </td><td class="uk-text-center">2500</td></tr>
                        <tr><td>Повреждение памяти или транслятора SSD диска</td><td class="uk-text-center">от 6 </td><td class="uk-text-center">8000</td></tr>
                        <tr><td>Восстановление данных SSD диска с шифрующим алгоритмом контроллера</td><td class="uk-text-center">от 6 </td><td class="uk-text-center">15000</td></tr>
                        <tr><td>Разрушение транслятора флешки (служебной микропрограммы)</td><td class="uk-text-center">от 6 </td><td class="uk-text-center">2500</td></tr>

                        <tr class="uk-text-small active"><th class="uk-text-center">Файлы, файловые системы, шифрование</th><th class="uk-text-center"></th><th class="uk-text-center"></th></tr>
                        <tr><td>Восстановление поврежденных файлов</td><td class="uk-text-center">от 12 </td><td class="uk-text-center">3000</td></tr>
                        <tr><td>Восстановление паролей файлов/архивов</td><td class="uk-text-center">от 8 </td><td class="uk-text-center">3000</td></tr>
                        <tr><td>Восстановление шифрованных разделов/папок/файлов/контейнеров</td><td class="uk-text-center">от 12 </td><td class="uk-text-center">10000</td></tr>
                        <tr><td>Восстановление баз данных</td><td class="uk-text-center">от 48 </td><td class="uk-text-center">10000</td></tr>
                        <tr><td>Восстановление виртуальных машин</td><td class="uk-text-center">от 48 </td><td class="uk-text-center">20000</td></tr>

                        <tr class="uk-text-small active"><th class="uk-text-center">CD/DVD, ZIP/JAZ/MO, дискеты</th><th class="uk-text-center"></th><th class="uk-text-center"></th></tr>
                        <tr><td>Повреждение логической структуры данных</td><td class="uk-text-center">от 8 </td><td class="uk-text-center">2000</td></tr>
                        <tr><td>Механические неисправности носителя</td><td class="uk-text-center">от 8 </td><td class="uk-text-center">2000</td></tr>
                    </tbody>
                </table>
                <hr class="m-b-25 m-t-30">
                <p>
                    <?=tools::new_gen_text('
                        {{{Восстановление | Извлечение} {информации | данных | файлов} может занять {как 5 минут | как 10 минут | как 15 минут | как 20 минут} }|{
                        {Восстановление | Извлечение } {информации | данных | файлов} возможно {за 5 минут | за 10 минут | за 15 минут | за 20 минут} }} - 
                        {^на дому^(4) или ^{в офисе клиента | в офисе заказчика}^(4) | ^у вас дома^(5) или ^в офисе^(5)}, так и 
                        {несколько дней | пару дней | до пяти дней | до шести дней | до семи дней | весь день | один день | до двух дней | до трех дней | до четырех дней | до одной недели} 
                        {– в нашем сервисном центре | – в нашем сервис центре | – в нашем сервисе | - в сервисном центре | - в сервис центре | - в сервисе} 
                        '.$this->_datas['servicename'].', в зависимости {от сложности | от масштаба | от уровня сложности | от объема} {предстоящих | будущих} работ. 
                        
                        {По окончании | По завершении | По итогу | После работ | После окончания | После завершения} восстановления и 
                        {
                            {
                                проверки {'.$arr3[$i][0].'} ^наличия^(6) и ^{целостности | полноты}^(6) {необходимой | нужной | требуемой} 
                                информации 
                                {
                                    {мы передаем }|{ {наш сервис | наш сервис центр |наш сервисный центр} передаст } } '.$arr3[$i][1].' 
                        {{{исправный | работоспособный | рабочий | пригодный к эксплуатации | новый} {накопитель | носитель} }|{
                        {исправное | работоспособное | рабочее | пригодное к эксплуатации | новое} {устройство | запоминающее устройство} } } 
                        
                
                        c {извлеченными | восстановленными} {данными | файлами} }|{проверки на наличие и {целостности | полноты} 
                        {необходимых | нужных | требуемых} '.$arr2[$i][0].' {{мы передаем }|{ {наш сервис | наш сервис центр |наш сервисный центр} 
                        передаст } } вам {{{исправный | работоспособный | рабочий | пригодный к эксплуатации | новый} 
                        {накопитель | носитель} }|{{исправное | работоспособное | рабочее | пригодное к эксплуатации | новое} 
                        {устройство | запоминающее устройство} } } c {{{извлеченными | восстановленными} '.$arr2[$i][1].' }|{
                        {извлеченной | восстановленной} информацией }}}}. 
                    ')?>
                </p>

                <div class="target-content-block uk-grid uk-padding form-bid">
                    <div class="uk-width-large-8-10">
                        <p>
                            <?=tools::new_gen_text('
                            {{Получить консультацию по вопросам {восстановления данных | восстановления информации} или вызвать 
                            {'.$arr4[$i][0].'} {{вы можете {у наших | у} {'.$arr4[$i][1].'} {колл-центра | call-центра | колл центра} 
                            {по номеру: |по контактному номеру: |по указанному номеру: | по контактному номеру телефона: |
                            по номеру телефона:|по указанному номеру телефона:} '.$phone_format.' или {оставьте | отправьте} 
                            {заявку. |запрос. | обращение.} }|{ можно {у наших | у} {'.$arr4[$i][1].'} 
                            {колл-центра | call-центра |колл центра} {по номеру: |по контактному номеру: |по указанному номеру: |
                            по контактному номеру телефона: |по номеру телефона: |по указанному номеру телефона:} '.$phone_format.' 
                            или	{оставьте | отправьте} {заявку. | запрос. |обращение.} }}}|{{{Проконсультироваться по вопросам 
                            {восстановления данных |восстановления информации} }|{Задать вопросы по 
                            {восстановлению данных | восстановлению информации} }} или вызвать {'.$arr4[$i][0].'}  {{
                            вы можете {у наших |у} {'.$arr4[$i][1].'} {колл-центра |call-центра |колл центра} 
                            {по номеру: |по контактному номеру: |по указанному номеру: |по контактному номеру телефона: |
                            по номеру телефона:|по указанному номеру телефона:} '.$phone_format.' или {оставьте | отправьте} 
                            {заявку.| запрос.|обращение.} }|{можно {у наших |у} {'.$arr4[$i][1].'} 
                            {колл-центра | call-центра |колл центра} {по номеру: | по контактному номеру: |по указанному номеру: |
                            по контактному номеру телефона: |по номеру телефона: |по указанному номеру телефона:}  '.$phone_format.' 
                            или {оставьте |отправьте} {заявку.|запрос.|обращение.} }}}} ')?>
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
                            <p>Гарантия на услуги восстановления данных до 6 месяцев</p>
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