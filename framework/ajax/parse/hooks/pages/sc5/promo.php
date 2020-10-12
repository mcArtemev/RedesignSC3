<?

use framework\tools;

$phone = $this->_datas['phone'];
$phone_format = tools::format_phone($this->_datas['phone'], true);

$marka = $this->_datas['marka']['name'];
$marka_lower = mb_strtolower($marka);

$moscow = ($this->_datas['region']['name'] == 'Москва');
$spb = ($this->_datas['region']['name'] == 'Санкт-Петербург' && $this->_datas['partner']['id'] == 27);

$point = $this->_datas['partner']['x'].','.$this->_datas['partner']['y'];

$request = [];
$request['op'] = 'dt';
$request['args']['mode'] = 'pattern_mas';
$request['args']['sid'] = $this->_datas['sid'];
$request['args']['setka'] = $this->_datas['setka_name'];

$answer_original = $answer = tools::connect_ciba($request);
$answer = json_decode($answer, true);
$answer = $answer['answer'];

$default = [
    'table_h1' => 'Ремонт техники', 
    'table_h2' => $marka,
    'table_text' => '- ремонт от 15 минут</br>
- гарантия до 3 лет</br>
- сервис в центре города</br>
- бесплатный курьер по '. $this->_datas['region']['name_de'].'</br>',
    'table_price' => 'от 390 руб',
];

foreach ($default as $key => $value)
    $$key = isset($answer[$key]) ? (($answer[$key]) ? $answer[$key] : $value) : $value;
    
$use_choose_city = $this->_datas['use_choose_city'];

?>        
<main>

    <section class="inner-page gradient cut">
        <div class="container">
            <div class="grid-7 padding grid-sm-12">
            
                <p class="auto-line"><span id="table_h1" class="title table_cell table_varchar"><?=$table_h1?></span><br />
                <span id="table_h2" class="title-big font-bold table_cell table_varchar"><?=$table_h2?></span></p>
                
                <div class="display-sm image" style="background-image: url(https://<?=$this->_datas['realHost']?>/bitrix/templates/remont/images/<?=$marka_lower?>/<?=$marka_lower?>.png)"></div>
                
                <p class="margin-bottom margin-top no-margin-top-sm table_text table_cell pre" id="table_text"><?=$table_text?></p>
                
                <p class="title font-bold margin-bottom align-center-sm table_varchar table_cell" id="table_price"><?=$table_price?></p>
                
                <div>
                    <button type="button" class="callback-modal font-button button-reverse <?=$marka_lower?>" 
                                    data-title="Запишитесь на ремонт" data-button="записаться на ремонт" data-textarea="ваша неисправность"
                                        data-title-tip="и мы свяжемся с вами в течении 3х минут">записаться на ремонт</button>
                    <button type="button" class="callback-modal font-button button margin-left-little no-margin-left-sm margin-top-little-sm <?=$marka_lower?>"
                                    data-title="Получите промокод на 1500р" data-button="получить промокод" data-action="promo_sms"
                                             data-title-tip="и оплатите им до 15% стоимости заказа" id="default_button">промокод на 1500 руб</button>
                </div>
            </div>
            
            <div class="image-clip image-clip-left" style="background-image: url(https://<?=$this->_datas['realHost']?>/bitrix/templates/remont/images/<?=$marka_lower?>/<?=$marka_lower?>.png)"></div>
        </div>
    </section>
    
    <section class="inner-page gray">
        <div class="container padding">
        
            <div class="grid-12">
            
                <p class="title align-center margin-bottom">4 плюса, чтобы быть в большом плюсе!</p>
             
            </div>
                
            <div class="grid-3 features align-center margin-bottom-sm">
                <img src="https://<?=$this->_datas['realHost']?>/bitrix/templates/remont/images/features-1.png"/>
                <p class="margin-top-little">Ремонт <?=$marka?><br/>в <?=$this->_datas['region']['name_pe']?></p>
                <p class="font-little font-color-gray">Приезжайте - мы рядом.<br/>Или просто вызовите нашего бесплатного курьера!</p>
            </div>
            
            <div class="grid-3 features align-center margin-bottom-sm">
                <img src="https://<?=$this->_datas['realHost']?>/bitrix/templates/remont/images/features-2.png"/>
                <p class="margin-top-little">Гарантия<br/>больше</p>
                <p class="font-little font-color-gray">Гарантия на<br/>комплектующие<br/>до 3х лет!</p>
            </div>
            
            <div class="grid-3 features align-center clear-sm">
                <img src="https://<?=$this->_datas['realHost']?>/bitrix/templates/remont/images/features-3.png"/>
                <p class="margin-top-little">Ремонт<br/>быстрее</p>
                <p class="font-little font-color-gray">Ремонт простых<br/> поломок - от 15 минут,<br/>сложных - несколько часов!</p>
            </div>
            
            <div class="grid-3 features align-center">
                <img src="https://<?=$this->_datas['realHost']?>/bitrix/templates/remont/images/features-4.png"/>
                <p class="margin-top-little">Цены<br/>ниже</p>
                <p class="font-little font-color-gray">Звоните сейчас и узнавайте,<br/>что такое по-настоящему<br/>низкие цены.</p>
            </div>
            
        </div>
    </section>
    
     <section class="inner-page gradient-reverse cut-reverse">
        <div class="container">
        
                <div class="image-clip" style="background-image: url(https://<?=$this->_datas['realHost']?>/bitrix/templates/remont/images/girl.png); background-size: contain;"></div>
                
                <div class="grid-6"></div>
                <div class="grid-6 padding grid-sm-12">
                    <p class="auto-line"><span class="title">Спросите эксперта</span><br />
                    <span class="title-big font-bold"><?=$marka?> </span><span class="title">прямо сейчас!</span></p>
                    
                    <div class="display-sm image" style="background-image: url(https://<?=$this->_datas['realHost']?>/bitrix/templates/remont/images/girl.png)"></div>
                    
                    <div class="margin-bottom margin-top">
                        <button type="button" class="callback-modal font-button button-reverse <?=$marka_lower?>"
                                data-title="Задайте вопрос эксперту" data-button="задать вопрос" data-textarea="ваш вопрос"
                                    data-title-tip="и мы свяжемся с вами в течении 3х минут">хочу задать вопрос</button>
                        <button type="button" class="callback-modal font-button button margin-left-little no-margin-left-sm margin-top-little-sm <?=$marka_lower?>"
                                data-title="Закажите обратный звонок" data-button="перезвоните мне"
                                    data-title-tip="и мы свяжемся с вами в течении 3х минут">перезвоните мне!</button>
                    </div>                    
                                        
                    <p class="margin-bottom-little">
                        Мы на связи с нашими пользователями 24 часа в сутки, 7 дней в неделю, 365 дней в году. 
                    </p>
                    
                    <p class="margin-bottom">    
                        И мы приложим все усилия, 
                            чтобы помочь вам наслаждаться вашим <?=$marka?> каждую секунду
                    </p>
                    
                    <? if (!$use_choose_city):?><p class="align-center-sm"><i class="fa fa-phone margin-right-very-little"></i><a href="tel:+<?=$phone?>" class="title font-bold"><?=$phone_format?></a></p><?endif;?>
                </div>

        </div>
    </section>
    
    <section class="inner-page gray">
        <div class="container padding">
                
                <div class="grid-12">
            
                    <p class="title align-center">Получите промокод на 1500 рублей!</p>
                
                    <div class="margin-top margin-bottom">
                        
                        <img src="https://<?=$this->_datas['realHost']?>/bitrix/templates/remont/images/chart.png" id="qr" class="margin-right margin-bottom-sm"/>
                    
                        <ol>
                            <li>1. Скачайте промокод на 1500 рублей на компьютер или мобильный</li>
                            <li>2. Или получите код в виде SMS</li>
                            <li>3. Зарегистируйте код у администратора в сервис-центре</li>
                            <li>4. Воспользуйтесь промокодом для получения скидки до 1500 рублей,<br/>но не более 15% от суммы ремонта</li>
                        </ol>
                        
                        <p class="margin-top-little font-color-gray font-little">* скидки по акциям не суммируются</p>
                    
                    </div>
                    
                    <div class="align-center">
                        <button type="button" class="callback-modal font-button button-reverse <?=$marka_lower?> button-white"
                                data-title="Скачайте промокод на 1500р" data-button="скачать промокод" data-action="promo_download"
                                        data-title-tip="и оплатите им до 15% стоимости заказа">
                                            скачать промокод</button>
                        <button type="button" class="callback-modal font-button button margin-left-little no-margin-left-sm margin-top-little-sm <?=$marka_lower?>"
                                data-title="Получите код по SMS на 1500р" data-button="получить промокод" data-action="promo_sms"
                                        data-title-tip="и оплатите им до 15% стоимости заказа"> 
                                                    получить код по sms</button>
                    </div>
                
            </div>
        </div>
    </section>
    
     <section class="inner-page cut map-wrapper">
      
        <div class="container">
        
            <div class="grid-7 padding grid-sm-12 padding-no-bottom">
                <p class="title margin-bottom-sm">Удобный сервис,<br/>который всегда рядом</p>
             </div>
             
         </div>
         
         <div id="map"></div>
           
         <div class="container">
         
               <div class="grid-7 padding grid-sm-12 padding-no-top">
               
                    <input type="hidden" name="point" value="<?=$point?>">
                    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
                    
                    <? if ($moscow || $spb):?>
                    
                        <p class="margin-top margin-bottom">
                            - хорошая пешая доступность<br>
                            - удобно подъехать на автомобиле<br>
                            - наш курьер, если не хотите ехать сами<br>
                            - без выходных и праздничных дней
                        </p>
                        
                        <p class="title font-bold margin-bottom align-center-sm">3 мин от метро</p>
                    
                    <?else:?>
                    
                        <p class="margin-top margin-bottom">
                            - хорошая пешая доступность<br>
                            - удобно подъехать на автомобиле<br>
                            - наш курьер, если не хотите ехать сами<br>
                            - без выходных и праздничных дней
                        </p>
                    
                    <?endif;?>
                    
                    <div>
                        <button type="button" class="callback-modal font-button button-reverse <?=$marka_lower?>"
                            data-title="Запишитесь на ремонт" data-button="записаться на ремонт" data-textarea="ваша неисправность"
                                    data-title-tip="и мы свяжемся с вами в течении 3х минут">записаться на ремонт</button>
                        <button type="button" class="callback-modal font-button button margin-left-little no-margin-left-sm margin-top-little-sm <?=$marka_lower?>"
                            data-title="Вызовите курьера на дом" data-button="вызвать курьера" data-textarea="ваш адрес и описание неисправности"
                                    data-title-tip="Это бесплатно в пределах <?=(($moscow) ? 'МКАД' : 'города')?>. Перезвоним за 3 мин!"
                                        data-textarea-tip="пример: <?=$courier_textarea_tip?>">бесплатный курьер</button>
                    </div>
                
            </div>
            
        </div>
     </section>
    
</main>
<div style="display: none;">
    <?=print_r($answer, true);?>
</div>