<?
use framework\tools;

$use_choose_city = $this->_datas['use_choose_city'];

$marka = $this->_datas['marka']['name'];
$mail = $this->_datas['partner']['email'];
if ($mail == 'litovchenko@list.ru') {
	$mail = '';
}

$mail_counter = $this->_datas['mail_counter'];

$region_name = $this->_datas['region']['name'];
$region_name_pe = $this->_datas['region']['name_pe'];

$analytics = $this->_datas['analytics'];
$metrica = $this->_datas['metrica'];
$menu = $this->_datas['footer_menu'];
//$addresis = $this->_footer_addresis(array('Москва', 'Санкт-Петербург'), 8);

$addresis = $this->_pay_addr();

$url = ($this->_datas['arg_url'] != '/') ? '/'.$this->_datas['arg_url'].'/' : '/';
$accord = $this->_datas['accord'];

$time = ($this->_datas['partner']['time']) ? tools::mb_ucfirst($this->_datas['partner']['time'], 'utf-8', false) : 'Ежедневно, с 10:00 до 21:00';

if ($this->_datas['setka_name'] == 'СЦ-1' && $marka_lower == 'samsung')
    $add_class = ' uk-text-muted';
else
    $add_class = '';
    
$jivo = array(
    'nnv.sony-russia.com' => 'kjv1659bqk',
    'spb.sony-russia.com' => 'NIrTQ9PfI2',
    'nnv.acer.russia.expert' => '4Jp0hH2rmk',
    'nnv.alcatel-russia.com' => 'hKuyXZU6Tw',
    'nnv.apple.russia.expert' => 'J6UQusdZCm',
    'nnv.asus-russia.ru' => 'UOApHBz8qy',
    'nnv.canon-russia.com' => 'fICLOgJ0NZ',
    'nnv.notebook-russia.com' => 'FrCpa83kom',
    'nnv.fly-russia.com' => 'r5d4uItoF5',
    'nnv.hp.russia.expert' => 'oPPeXPGkJz',
    'nnv.htcrussia.com' => 'nn0TbB7lA5',
    'nnv.huawei.russia.expert' => 'tl5ZLKrIwI',
    'nnv.lenovo-russia.ru' => 'C3MY5cSJqA',
    'nnv.lg-russia.ru' => 'XFDgn58phw',
    'nnv.meizu.russia.expert' => 'sc7ju6oPFB',
    'nnv.msi.russia.expert' => 'WdPjRcvVkB',
    'nnv.nikon.russia.expert' => 'DRp7E12mSq',
    'nnv.nokia-russia.com' => 'ZIW6WjVOLS',
    'nnv.smrussia.com' => 'QiO1xuNadl',
    'nnv.toshiba.russia.expert' => '5YxOwTxkMV',
    'nnv.xiaomi.russia.expert' => 'BkcG6E6Yc5',
    'nnv.zte.russia.expert' => 'CGdpaxQWtJ',
    'spb.acer.russia.expert' => 'ir3qpBr05O',
    'spb.alcatel-russia.com' => 'Z2CZ5btBTU',
    'spb.apple.russia.expert' => 'wWYWwhehZb',
    'spb.asus-russia.ru' => '7sQud4yP8I',
    'spb.canon-russia.com' => '6ZAQaO4quP',
    'spb.notebook-russia.com' => 'C5ZjaPHL7N',
    'spb.fly-russia.com' => '5Mjyv6necq',
    'spb.hp.russia.expert' => 'lx5Six1SM2',
    'spb.htcrussia.com' => '3Hye2iwA5r',
    'spb.huawei.russia.expert' => 'D8NrCNsDyD',
    'spb.lenovo-russia.ru' => 'E2PWH1bz7v',
    'spb.lg-russia.ru' => 'XnDloZpkMD',
    'spb.meizu.russia.expert' => 'fqQ5FKcCao',
    'spb.msi.russia.expert' => 'ZlbpQ641yW',
    'spb.nikon.russia.expert' => 'P8yuhiqMjd',
    'spb.nokia-russia.com' => 'I89nOTv6jL',
    'spb.smrussia.com' => 'kkjUCJ4a4R',
    'spb.toshiba.russia.expert' => '6wuChrB6zb',
    'spb.xiaomi.russia.expert' => '2mKcXtJ7hU',
    'spb.zte.russia.expert' => 'li44JuR1nq',
);

$use_choose_city = $this->_datas['use_choose_city'];
$address_choose = $this->_datas['address_choose'];
$city = $this->_datas['find_city']; 


if($this->_datas['arg_url'] =='vosstanovlenie-dannyh'){
    $vosstanovlenieDannyh1 =[
        'Мастер', 'Специалист','Программный инженер', 'Специалист сервиса', 'Мастер сервиса'
    ];
    
    $vosstanovlenieDannyh2= [
        'проводит', 'выполняет', 'осуществляет', 'делает'
    ];
    
    $vosstanovlenieDannyh3 = [
        ['вашего устройства.' , 'вашем устройстве.','носитель | накопитель'],
        ['вашей техники.' , 'вашей технике.','носитель | накопитель'],
        ['вашего носителя.' , 'вашем носителе.','накопитель'],
        ['вашего накопителя.' , 'вашем накопителе.','носитель '],
        ['вашего запоминающего устройства.' , 'вашем запоминающем устройстве.','носитель | накопитель'],
    ];
    
    shuffle($vosstanovlenieDannyh1);
    shuffle($vosstanovlenieDannyh2);
    shuffle($vosstanovlenieDannyh3);
    $textVosstDan =[
        1 => $vosstanovlenieDannyh1[rand(0,1)] .' {выезжает | приезжает | подъезжает} к вам ^{на дом | домой}^(0) 
                или ^в офис^(0) по {{вашей заявке. }|{вашему запросу.}}', 
        2 => $vosstanovlenieDannyh1[rand(2,3)] .' '.$vosstanovlenieDannyh2[rand(0,1)].' {полную | } {диагностику | проверку} '.$vosstanovlenieDannyh3[rand(0,1)][0],
        3 => '{После чего | После} {проводится | осуществляется} {расчет | подсчет} {стоимости | итоговой стоимости} на 
                {{услуги восстановления данных }| { работы по восстановлению данных }} и {согласование | согласование с вами}.',
        4 => $vosstanovlenieDannyh1[4] .' '.$vosstanovlenieDannyh2[rand(2,3)] .' {{{восстановление поврежденных | восстановление удаленных} 
                {данных | файлов} }|{{восстановление поврежденной | восстановление удаленной} информации } } 
                {{на  {'.$vosstanovlenieDannyh3[rand(2,3)][1].'} }|{с  {'.$vosstanovlenieDannyh3[rand(2,3)][0].'} }}',
        5 => '{{По окончании процедуры {{	вы получаете }|{вам {выдают | передают} } } {работающий |исправный} {'.$vosstanovlenieDannyh3[4][2].'}  
                {с вашими данными | с вашими файлами | с восстановленными данными | с восстановленными файлами | с извлеченными данными | с извлеченными файлами} 
                и {гарантийный талон. | гарантийный чек. | гарантийный бланк. } }|
                {В итоге {{вы получаете }|{вам {выдают | передают} }} {работающий | исправный} {'.$vosstanovlenieDannyh3[4][2].'} 
                {с вашими данными | с вашими файлами | с восстановленными данными | с восстановленными файлами | с извлеченными данными | с извлеченными файлами} 
                и {гарантийный талон. | гарантийный чек.| гарантийный бланк. } }} ' ,      
    ];

}

?>
<? $show_line = isset($show_line) ? $show_line : true; 
$show_b2b = isset($show_b2b) ? $show_b2b : false; ?>

<? if ($show_line):?>    
<!--noindex-->
<div class="sr-main target ">
    <div class="uk-container-center uk-container how-we-work-wrapper">
        <div class="how-we-work"></div>
        <h2 class="uk-text-center uk-margin-large-top">Как мы работаем</h2>
        <div class="uk-child-width-expand@s uk-text-center uk-margin-large-bottom uk-grid uk-margin-large-top">
            <div class="uk-width-medium-1-5">
                <p class="uk-text-large text-30-px uk-contrast">1</p>
                <? if ($this->_datas['arg_url'] =='kompyuternaya-pomoshch') :?>
                    <p class="uk-margin-medium-top">Мастер выезжает к вам на дом или в офис по вашей заявке</p>
                <? elseif ($this->_datas['arg_url'] =='vosstanovlenie-dannyh'):?>
                    <p class="uk-margin-medium-top"><?=tools::new_gen_text($textVosstDan[1])?></p>    
                <? elseif (!$this->_datas['sdek']):?>
                    <p class="uk-margin-medium-top">Вы самостоятельно или наш курьер привозите аппарат в сервисный центр <?=$this->_datas['servicename']?></p>
                <? else:?>
                    <p class="uk-margin-medium-top">Вы приносите ваш <?=$marka?> на пункт СДЭК, после чего он доставляется в сервис Russia Expert Москва</p>
                <?endif;?>
            </div>
            <div class="uk-width-medium-1-5">
                <p class="uk-text-large text-30-px uk-contrast">2</p>
                <? if ($this->_datas['arg_url'] =='kompyuternaya-pomoshch') :?>
                    <p class="uk-margin-medium-top">Специалист проводит полную диагностику устройства. Процедура занимает некоторое время</p>
                <? elseif ($this->_datas['arg_url'] =='vosstanovlenie-dannyh'):?>
                    <p class="uk-margin-medium-top"><?=tools::new_gen_text($textVosstDan[2])?></p>
                <? else:?>
                    <p class="uk-margin-medium-top">Инженеры проводят полную диагностику: аппаратную, техническую. Процедура занимает некоторое время</p>
                <?endif;?>
            </div>
            <div class="uk-width-medium-1-5">
                <p class="uk-text-large text-30-px uk-contrast">3</p>
                <? if ($this->_datas['arg_url'] =='kompyuternaya-pomoshch') :?>
                    <p class="uk-margin-medium-top">После чего проводится расчет стоимости на услуги компьютерной помощи и согласование с вами</p>
                <? elseif($this->_datas['arg_url'] =='vosstanovlenie-dannyh'):?>
                    <p class="uk-margin-medium-top"><?=tools::new_gen_text($textVosstDan[3])?></p>
                <? else:?>
                    <p class="uk-margin-medium-top">Менеджеры согласовывают с вами все условия ремонта: стоимость, сроки, гарантийные условия</p>
                <?endif;?>    
            </div>
            <div class="uk-width-medium-1-5">
                <p class="uk-text-large text-30-px uk-contrast">4</p>
                <? if ($this->_datas['arg_url'] =='kompyuternaya-pomoshch') :?>
                    <p class="uk-margin-medium-top">Мастер устраняет возникшие проблемы на вашем устройстве, восстанавливает работоспособность</p>
                <? elseif ($this->_datas['arg_url'] =='vosstanovlenie-dannyh'):?>
                    <p class="uk-margin-medium-top"><?=tools::new_gen_text($textVosstDan[4])?></p>
                <? else:?>
                    <p class="uk-margin-medium-top">Мастер проводит ремонт: заменяет неисправную часть новой оригинальной деталью</p>
                <?endif;?>    
            </div>
            <div class="uk-width-medium-1-5">
                <p class="uk-text-large text-30-px uk-contrast green">5</p>
                <? if ($this->_datas['arg_url'] =='kompyuternaya-pomoshch') :?>
                    <p class="uk-margin-medium-top">По окончании процедуры вы получаете работающую технику и гарантийный талон</p>
                <? elseif ($this->_datas['arg_url'] =='vosstanovlenie-dannyh'):?>
                    <p class="uk-margin-medium-top"><?=tools::new_gen_text($textVosstDan[5])?></p>    
                <? elseif (!$this->_datas['sdek']):?>
                    <p class="uk-margin-medium-top">По окончании ремонта вы получаете исправный гаджет с гарантийным бланком <?=$marka?></p>
                <? else:?>
                    <p class="uk-margin-medium-top">По окончании ремонта осуществляется доставка на пункт СДЭК в <?=$region_name_pe?> и вы забираете исправный гаждет с гарантийным бланком</p>
                <?endif;?>
            </div>
        </div>
        <? if ($this->_mode == -3
            && $this->_datas['region']['name'] == 'Москва'
            && $this->_datas['marka']['name'] == 'Huawei'
            && $this->_datas['model_type'][0]['name'] == 'телефон') { ?>
          <p style = "display: none;">
            Инженеры нашей компании — высококвалифицированные специалисты, которые регулярно повышают собственные навыки. Мы не стоим на месте и динамично развиваемся, отслеживая последние новости из мира высоких технологий. Наш сервисный центр располагает самым современным оборудованием, которое полностью соответствует европейским стандартам. Мы ценим каждого клиента и бережем отличную репутацию компании. Обратившись к нам, Вы получите профессиональный подход к проблеме.
          </p>
          <p style = "display: none;">
            Чтобы сдать телефон Huawei в ремонт, не обязательно ехать в наш офис. Просто позвоните нашим менеджерам и вызовите курьера. А чтобы мы сами связались с Вами, заполните простую форму обратной связи.
          </p>
        <? } ?>
    </div>
</div>
<!--/noindex-->
<?endif;?>

<div class="sr-footer-top uk-contrast">
        <div class="uk-container-center uk-container">
            <div class="uk-grid" data-uk-grid-margin>
                <div class="uk-width-medium-1-4">
                    <p class="uk-text-large">Ремонт</p>
                    <ul class="uk-list-line uk-list">
                         <?
                         $accord_menu = array('ноутбук' => 'MacBook', 'смартфон' => 'iPhone', 'планшет' => 'iPad', 'моноблок' => 'iMac', 'смарт-часы' => 'Watch', 'телевизор' => 'Apple TV', 'компьютер' => 'Mac');
                         foreach ($this->_datas['all_devices'] as $device)
                         {
                            $key = '/'.$accord[$device['type']].'/';

                            if (!empty($accord_menu[$device['type']]) && $marka_lower == 'apple')
                            {
                                $value = $accord_menu[$device['type']];
                            }
                            else
                            {
                                $value = tools::mb_ucfirst($device['type_m']);
                            }

                            if ($url == $key)
                                echo '<li><span class="active">'.$value.'</span></li>';
                            else
                                echo '<li><a href="'.$key.'">'.$value.'</a></li>';
                         }
                         ?>

                    </ul>
                </div>
                <?
                    //if (isset($this->_datas['admin'])){
                    foreach ($this->_datas['all_devices'] as $key => $value) {
                        switch ($value['type']) {
                            case 'холодильник':
                            case 'стиральная машина':
                            case 'посудомоечная машина':
                            case 'сушильная машина':
                            $menu= array(
                                '/o-nas/' => 'О нас',
                                '/diagnostika/' => 'Диагностика',
                                '/dostavka/' => 'Выезд и доставка',
                                '/sroki/' => 'Срочный ремонт',
                                '/zapchasti/' => 'Комплектующие',
                                '/ceny/' => 'Цены',
                                '#' => 'Статус заказа',
                                '/vakansii/' => 'Вакансии',
                                '/kontakty/' => 'Контакты',  
                            );
                            break;                                    
                        }
                    }
                //} 
                ?>
                <div class="uk-width-medium-1-4">
                    <p class="uk-text-large">Сервис</p>
                    <ul class="uk-list-line uk-list">
                        <?
                            $i=0;
                            $l=0;
                            foreach ($menu as $key => $value)
                            {
                                if ($key == '#')
                                {
                                    echo '<li><span style="cursor: pointer" class="uk-link" data-uk-modal="{target:\'#status\'}">'.$value.'</span></li>';
                                }    
                                else
                                {
                                    if ($url == $key)
                                        echo '<li><span class="active">'.$value.'</span></li>';
                                    else
                                        echo '<li><a href="'.$key.'">'.$value.'</a></li>';
                                }
                                $i++;
                                $l++;
                                if ($i >4 && ($l % $i == 0) && ($l+1)<count($menu)-1){ 
                                    $i=0;
                                ?>
                                  </ul>
                                </div>
                                <div class="uk-width-medium-1-4">
                                    <ul class="uk-list-line uk-list" style="margin-top: 38px;">
                            <?                                    
                                } 
                            }
                          
                          ?>
                    </ul>
                </div>

                <?
                //if ($this->_datas['setka_name'] != 'СЦ-1' || $marka_lower != 'samsung')
                //{
                    $left = $right = '<div class="uk-width-medium-1-4 uk-hidden-small" style="margin-top:12px;">';
                    $i = 0;
                    foreach ($addresis as $key => $value)
                    {
                        $region_name = ($value['region_name']) ? $value['region_name'] : 'Москва';
                        $address = $value['address2'] ? $value['address2'] : $value['address1'];
                        $phone_a = '+'.tools::format_phone($value['phone']);
                        
                        $str = '';

                        if ($marka_lower == 'hp')
                        {
                           if ($value['site'] == $this->_datas['site_name'] || $this->_datas['realHost'] != $this->_datas['site_name'] )
                           {
                                $str .= '<div class="item"><span>'.$region_name.'</span>
                                <br />
                                    <span class="uk-text-small">'.$phone_a.'</span>
                                </div>';
                           }
                           else
                           {
                                $str .= '<!--noindex--><div class="item"><a href="https://'.$value['site'].($url).'">'.$region_name.'</a>
                                <br />
                                    <span class="uk-text-small">'.$phone_a.'</span>
                                </div><!--/noindex-->';
                           }
                        }
                        else
                        {
                           if ($value['site'] == $this->_datas['site_name'] || $this->_datas['realHost'] != $this->_datas['site_name'])
                                $str .= '<div class="item"><span>'.$region_name.'</span>';
                           else
                                $str .= '<div class="item"><a href="https://'.$value['site'].($url).'">'.$region_name.'</a>';

                           $str .= '
                                <br />
                                    <span class="uk-text-small">'.$phone_a.'</span>
                                </div>';
                        }

                        if ($i < 8)
                            $left .= $str;
                        else
                            $right .= $str;
                        $i++;
                    }
                    $left .= '</div>';
                    $right .= '</div>';

                    echo $left .$right;
                    //echo $left;
                //}?>
            </div>
        </div>
    </div>
    
    <!--noindex-->
    <div class="sr-footer-bottom">
        <div class="uk-container-center uk-container uk-contrast">
			<p class="uk-text-small uk-margin-top-remove footer_brand" style="margin-right: 35px;"><span class="<?=$add_class?>">© <?=date("Y");?> СЕРВИСНЫЙ ЦЕНТР ПО <?=mb_strtoupper($marka)?></span>
			<br />
			<span class="flag"></span><?=mb_strtoupper($this->_datas['site_name']);?></p>

			<p class="uk-text-small" style="color: rgba(255,255,255, 0.7); margin: 0;">
				Информация на сайте не является публичной офертой и носит исключительно информационный характер. Окончательные условия предоставления услуг определяются менеджером компании по итогам проведения программной или аппаратной диагностики и согласовываются с владельцами техники по телефону. Название компании <?=$marka?>, ее логотипы, используются на сайте с целью ознакомления. Russia Expert не является официальным сервисным центром <?=$marka?>. <span class="uk-link" id="sogl">Пользовательское соглашение</span>.
			</p>
		</div>
        </div>
    </div>
    <!--/noindex-->
    
<? if ($this->_datas['arg_url'] =='vakansii'){
        include ('form-vakansii.php');
    }else {
        include ('form-remont.php');
    } ?>
    
    <? if ($show_b2b):?>  
    <div id="popup-b2b" class="uk-modal">
        <div class="uk-modal-dialog">
            <span class="uk-link uk-modal-close uk-close"></span>
            <p class="uk-h2 uk-text-center">Заявка на обслуживание со скидкой*</p>
            <form class="uk-form">

                <fieldset data-uk-margin>
                    <p>
                        <input class="uk-width-1-1 name" type="text" placeholder="Контактное лицо">
                    </p>
                    <p>
                        <input class="uk-width-1-1 tel" type="text" placeholder="Номер телефона">
                    </p>

                    <p>
                        <select class="uk-width-1-1">
                            <option>Первичное обращение</option>
                            <option>Повторное обращение</option>
                        </select>
                    </p>
                    <p>
                        <textarea class="uk-width-1-1" cols="30" rows="5" placeholder="Краткое описание ситуации и текущих неисправностей"></textarea>
                    </p>
                    <p>
                        *&nbsp;&nbsp;Скидка на первичное обращение - 10% <br />
                        **&nbsp;Менеджеры свяжутся с вами через несколько минут после отправки заявки 
                    </p>
                    <p class="uk-text-center">
                        <button class="uk-button uk-button-success uk-button-large" type="button" onclick="if (typeof window['yaCounter<?=$metrica?>'] !== 'undefined') yaCounter<?=$metrica?>.reachGoal('ZAKAZ'); return false;">Отправить заявку</button>
                    </p>
                </fieldset>

            </form>
        </div>
    </div>
    <?endif;?>
    
    <div id="popup_qcs" class="uk-modal">
        <div class="uk-modal-dialog">
            <span class="uk-link uk-modal-close uk-close"></span>
            <p class="uk-h2">СЛУЖБА КОНТРОЛЯ КАЧЕСТВА</p>
            <form class="uk-form">

                <fieldset data-uk-margin>
                    <p>
                        <input class="uk-width-1-1 name" type="text" placeholder="Имя">
                    </p>
                    <p>
                        <input class="uk-width-1-1 tel" type="text" placeholder="Телефон">
                    </p>
                    <p>
                        <textarea class="uk-width-1-1" cols="30" rows="5" placeholder="Комментарий"></textarea>
                    </p>
                    <p>
                        <label style="display: block; line-height: 20px;"><input class="datago" type="checkbox" style="float: left; width: 14px; height: 14px; margin: 3px 5px 3px 0px;" checked required>Я даю согласие на обработку персональных данных.</label>
                    </p>
                    <p class="uk-text-center">
                        <input class="uk-button uk-button-success uk-button-large" style="color: #fff;" id="send_qcs" type="button" value="Отправить">
                    </p>
                </fieldset>

            </form>
        </div>
    </div>
    
    <div id="status" class="uk-modal">
        <div class="uk-modal-dialog">
            <span class="uk-link uk-modal-close uk-close"></span>

                <p class="uk-h2">Статус заказа</p>
                
                <div class="question">
                    <p>Для уточнения информации по ремонту введите номер для проверки в это поле:</p>
                    <form class="uk-grid uk-form uk-grid-small">
                         <div class="uk-width-large-3-4 uk-width-medium-3-4 uk-width-small-1-1 margin-small uk-flex uk-flex-middle">
                              <!--<p class="uk-margin-remove">SC-1</p>-->
                              <input class="uk-input uk-width-1-1" type="text"/>
                          </div>
                          <div class="uk-width-large-1-4 uk-width-medium-1-4 uk-width-small-1-1">
                                <button class="uk-button uk-width-1-1 uk-button-success check">Проверить</button>
                          </div>
                    </form>
                    <p class="uk-margin-small-top uk-text-small uk-margin-bottom-remove">Пример: <span class="uk-text-bold">1998</span></p>
                    <p class="uk-margin error"></p>
                </div>
                
                <div class="answer">
                </div>
        </div>
    </div>    
    <? if ($use_choose_city):?>
    <div id="js_cityModal" class="uk-modal">
         <div class="uk-modal-dialog">
            <span class="uk-link uk-modal-close uk-close"></span>
            <p class="uk-h2">Выберите ваш город</p>
            <ul class="uk-column-large-1-3 uk-column-medium-1-2">
                <? foreach ($address_choose as $value):
                    $region_name = ($value['region_name']) ? $value['region_name'] : 'Москва';?>
                    <li><a href="<?=$value['site']?>"><?=$region_name?></a></li>
                <?endforeach;?>                
            </ul>
        </div>
    </div>
    <?endif;?>
    
    <div id="mobmenu" class="uk-offcanvas">

        <div class="uk-offcanvas-bar">
            <!--<a href="" class="uk-close uk-close-alt uk-position-top-right closemenu"></a>-->

            <!--<p class="uk-text-bold uk-contrast uk-margin-left">Сервисный центр <?=mb_strtoupper($marka)?></p>
            <div class="uk-panel">
                <h3 class="uk-panel-title" tid="ch3_66"><a href="tel:+<?=$this->_datas['phone']?>"><?=tools::format_phone($this->_datas['phone'])?></a></h3>
            </div>-->

            <div class="sr-header">
                <div class="uk-container-center uk-container">
                    <div class="uk-flex uk-flex-space-between uk-flex-middle">
                        <div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-5-10 ">
                            <? if ($url != '/') :?>
                                <a href="/" class="logo <?=$marka_lower?>" style="background: url(/wp-content/themes/studiof1/img/<?=$marka_lower?>/logo.jpg) no-repeat; background-size: contain;"></a>
                            <?else:?>
                                <span class="logo <?=$marka_lower?>" style="background: url(/wp-content/themes/studiof1/img/<?=$marka_lower?>/logo.jpg) no-repeat; background-size: contain;"></span>
                            <?endif;?>

                            <div class="uk-text-muted uk-button-dropdown center-mobile">
                                    Сервисный центр <?=mb_strtoupper($marka)?>
                            </div>
                        </div>
                        <div class="uk-width-small-5-10 uk-text-right uk-visible-small ">
                            <button type="button" class="uk-button uk-margin close-menu"><i class="uk-icon-close"></i></button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="sr-main target">
                <div class="uk-width-medium-1-1 bgcolorwhite uk-visible-small">
                    <div class="uk-container-center uk-container uk-margin-bottom">
                       <a href="tel:+<?=$phone?>" class="uk-contrast"><?=$phone_format?></a>
                    </div>
                </div>
            </div>

            <ul class="uk-nav uk-nav-offcanvas uk-nav-parent-icon"  data-uk-nav="{multiple:true}">
                <li class="uk-nav-divider"></li>

                <li class="uk-parent " >
                    <span class="uk-link">Ремонт</span>
                    <!-- <div style="overflow: hidden; position: relative;"> -->
                        <ul class="uk-nav-sub">
                            <? /*foreach ($this->_datas['all_devices'] as $device)
                             {
                                $key = '/'.$accord[$device['type']].'/';
                                $value = tools::mb_ucfirst($device['type_m']);
                                if ($url == $key)
                                    echo '<li class="uk-active">'.$value.'</li>';
                                else
                                    echo '<li><a href="'.$key.'">'.$value.'</a></li>';
                             }*/
                            ?>
                        </ul>
                    <!-- </div> -->
                </li>
                <li class="uk-nav-divider"></li>

                <li class="uk-parent">
                    <span class="uk-link">Сервис</span>

                        <ul class="uk-nav-sub">
                            <?
                            /*foreach ($menu as $key => $value)
                            {
                                if ($key == '#')
                                {
                                    echo '<li><a href="#" data-uk-modal="{target:\'#status\'}">'.$value.'</a></li>';
                                }    
                                else
                                {
                                    if ($url == $key)
                                        echo '<li class="uk-active">'.$value.'</li>';
                                    else
                                        echo '<li><a href="'.$key.'">'.$value.'</a></li>';
                                } 
                            }*/ ?>
                        </ul>

                </li>
                <li class="uk-nav-divider"></li>

                <li class="uk-parent">
                    <span class="uk-link">Филиалы</span>
                    <ul class="uk-nav-sub">
                    <?
                    /*foreach ($addresis as $key => $value)
                    {
                        $region_name = ($value['region_name']) ? $value['region_name'] : 'Москва';

                        if ($value['site'] != $this->_datas['site_name'])
                            echo '<li><a href="https://'.$value['site'].($url).'">'.$region_name.'</a></li>';
                    }*/
                    ?>
                    </ul>
                </li>
                <li class="uk-nav-divider"></li>
            </ul>
            <div class="uk-panel">
                <p><?=$time?></p>
                <?if (!$this->_datas['partner']['exclude']):?><p><?=$this->_datas['partner']['address1']?></p><?endif;?>
            </div>
        </div>
    </div>

    <input type="hidden" name="mail" value="<?=$mail?>"/>
    <input type="hidden" name="mango_id" value="<?=tools::format_phone($this->_datas['phone'])?>"/>
<?php //if ( 'ariston.russia-centre.com' !== $this->_datas['realHost'] && $this->_datas['realHost'] == $this->_datas['site_name'] ) :
       if ( 'ariston.russia-centre.com' !== $this->_datas['realHost']) : ?>
    <input type="hidden" name="metrica" value="<?=$metrica?>"/>
<?php endif; ?>

    <?   $add = '';
        if ($this->_datas['arg_url'] == 'otpravleno') $add .= ',/wp-content/themes/studiof1/js/otpravleno.js';
        if ($this->_datas['arg_url'] == 'kontakty') $add .= ',/wp-content/themes/studiof1/js/kontakty.js';
        if ($this->_datas['arg_url'] == 'o-nas' || $this->_datas['arg_url'] == 'kontakty') $add .= ',/wp-content/themes/studiof1/js/components/slider.min.js'; ?>
        
        <? //if ($this->_datas['realHost'] == $this->_datas['site_name']):?>
            <script type="text/javascript" src="/min/f=/wp-content/themes/studiof1/js/jquery-3.1.1.min.js,/wp-content/themes/studiof1/js/uikit.js,/wp-content/themes/studiof1/js/jquery.maskedinput.js,/wp-content/themes/studiof1/js/main.js,/wp-content/themes/studiof1/js/yacounter.js<?=$add?>&123456"></script>
        <?//endif;?>

    <? //if ($analytics  && $this->_datas['realHost'] == $this->_datas['site_name']):
      if ($analytics):?>
         <script>
          (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
          (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
          m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
          })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
          ga('create', '<?=$analytics?>', 'auto');
          ga('send', 'pageview');

        </script>
    <?endif;?> 
        <?php //if ( 'ariston.russia-centre.com' !== $this->_datas['realHost'] && $this->_datas['realHost'] == $this->_datas['site_name'] ) :;
         if ('ariston.russia-centre.com' !== $this->_datas['realHost']):?>
            <script type="text/javascript"> (function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter<?=$metrica?> = new Ya.Metrika({ id:<?=$metrica?>, clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true, triggerEvent:1 }); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = "https://mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks"); </script> <noscript><div><img src="https://mc.yandex.ru/watch/<?=$metrica?>" style="position:absolute; display: none; left:-9999px;" alt="" /></div></noscript>
        
            <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

            ga('create', 'UA-86227825-1', 'auto');
            ga('send', 'pageview');

            </script>
        <?php endif; ?>

        <?php if ('ariston.russia-centre.com' === $this->_datas['realHost']):?>
            <!-- Yandex.Metrika counter -->
            <script type="text/javascript" >
                (function (d, w, c) {
                    (w[c] = w[c] || []).push(function() {
                        try {
                            w.yaCounter49329793 = new Ya.Metrika2({
                                id:49329793,
                                clickmap:true,
                                trackLinks:true,
                                accurateTrackBounce:true,
                                webvisor:true,
                                triggerEvent:1
                            });
                        } catch(e) { }
                    });

                    var n = d.getElementsByTagName("script")[0],
                        s = d.createElement("script"),
                        f = function () { n.parentNode.insertBefore(s, n); };
                    s.type = "text/javascript";
                    s.async = true;
                    s.src = "https://mc.yandex.ru/metrika/tag.js";

                    if (w.opera == "[object Opera]") {
                        d.addEventListener("DOMContentLoaded", f, false);
                    } else { f(); }
                })(document, window, "yandex_metrika_callbacks2");
            </script>
            <noscript><div><img src="https://mc.yandex.ru/watch/49329793" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
            <!-- /Yandex.Metrika counter -->
        <?php elseif ('oneplus.russia-mobile.com' === $this->_datas['realHost']):?>
            <!-- Yandex.Metrika counter -->
            <script type="text/javascript" >
               (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
               m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
               (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");
               ym(65637571, "init", {
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true
               });
            </script>
            <noscript><div><img src="https://mc.yandex.ru/watch/65637571" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
            <!-- /Yandex.Metrika counter -->
        <?php elseif ('vertu.russia-mobile.com' === $this->_datas['realHost']):?>
            <!-- Yandex.Metrika counter -->
            <script type="text/javascript" >
               (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
               m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
               (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");
               ym(65638672, "init", {
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true
               });
            </script>
            <noscript><div><img src="https://mc.yandex.ru/watch/65638672" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
            <!-- /Yandex.Metrika counter -->
        <?php endif; ?>

        <?php if ($mail_counter) :; ?>
            <!-- Rating@Mail.ru counter -->
                <script type="text/javascript">
                    var _tmr = window._tmr || (window._tmr = []);
                    _tmr.push({id: "<?php echo $mail_counter; ?>", type: "pageView", start: (new Date()).getTime(), pid: "USER_ID"});
                    (function (d, w, id) {
                        if (d.getElementById(id)) return;
                        var ts = d.createElement("script"); ts.type = "text/javascript"; ts.async = true; ts.id = id;
                        ts.src = "https://top-fwz1.mail.ru/js/code.js";
                        var f = function () {var s = d.getElementsByTagName("script")[0]; s.parentNode.insertBefore(ts, s);};
                        if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); }
                    })(document, window, "topmailru-code");
                </script><noscript><div>
                        <img src="https://top-fwz1.mail.ru/counter?id=<?php echo $mail_counter; ?>;js=na" style="border:0;position:absolute;left:-9999px;" alt="Top.Mail.Ru" />
                    </div></noscript>
                <!-- //Rating@Mail.ru counter -->
        <?php endif; ?>

        <? if (isset($jivo[$this->_datas['site_name']])):?>
        
            <!-- BEGIN JIVOSITE CODE {literal} -->
            <script type='text/javascript'>
            (function(){ var widget_id = '<?=$jivo[$this->_datas['site_name']]?>';var d=document;var w=window;function l(){
            var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);}if(d.readyState=='complete'){l();}else{if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})();</script>
            <!-- {/literal} END JIVOSITE CODE -->
        
        <?endif;?>
        
        <? //if ($this->_datas['realHost'] == $this->_datas['site_name']):?>
            <?php if (!empty($this->_datas['piwik'])) { ?>
                <!-- Matomo -->
                <script type="text/javascript">
                var _paq = _paq || [];
                /* tracker methods like "setCustomDimension" should be called before "trackPageView" */
                _paq.push(['trackPageView']);
                _paq.push(['enableLinkTracking']);
                (function() {
                    var u="/piwik/";
                    _paq.push(['setTrackerUrl', u+'piwik.php']);
                    _paq.push(['setSiteId', '<?=$this->_datas['piwik']?>']);
                    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
                    g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
                })();
                </script>
    			<noscript><p><img src="/piwik/piwik.php?idsite=<?=$this->_datas['piwik']?>&amp;rec=1" style="border:0;" alt="" /></p></noscript>
                <!-- End Matomo Code -->
            <?php } ?>
        <?//endif;?>
        
        <? if ($phone == '78003506058' && $this->_datas['original_setka_id'] == 1):?>
            <script type="text/javascript">
                (function(metaWindow, c) {
                    metaWindow.jus_custom_param={
                    webmaster:{
                    webmaster_id: "14649",
                    subaccount: ""
                    },
                    widgetStyle:{
                    position:"right",
                    bottom:"0",
                    left:"0",
                    right:"0",
                    mobileBottom:"0",
                    }
                    };
                    var WebDGapLoadScripts = function(widgetURL, $q) {
                    var script = c.createElement("script");
                    script.type = "text/javascript";
                    script.charset = "UTF-8";
                    script.src = widgetURL;
                    if ("undefined" !== typeof $q) {
                    metaWindow.lcloaderror = true;
                    script.onerror = $q;
                    }
                    c.body.appendChild(script);
                    };
                    WebDGapLoadScripts("/f604cdf54096.php", function() {
                    WebDGapLoadScripts("https://uberlaw.ru/js/comp-a-b.js");
                    });
                    })(window, document);
                </script>
        <?endif;?>
        <!-- <script>
        function myFunction() {
  document.getElementById("myDropdown").classList.toggle("show");
}

// Close the dropdown menu if the user clicks outside of it
window.onclick = function(event) {
  if (!event.target.matches('#dropbtn')) {
    var dropdowns = document.getElementsByClassName("uk-nav-sub");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}
        </script> -->
</body>

</html>
