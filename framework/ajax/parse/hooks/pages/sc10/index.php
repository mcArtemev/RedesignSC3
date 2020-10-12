<?

use framework\tools;

$marka = $this->_datas['marka']['name'];
$phone = $this->_datas['phone'];
$phone_format = tools::format_phone($phone);
$marka_lower = mb_strtolower($marka); 
$metrica = $this->_datas['metrica'];
$mail = $this->_datas['partner']['email'];
if ($mail == 'litovchenko@list.ru') {
	$mail = '';
}

$time = ($this->_datas['partner']['time']) ? $this->_datas['partner']['time'] : 'Ежедневно с 10:00 до 20:00';

$region_name = $this->_datas['region']['name'];
$address = $this->_datas['partner']['address1'];
$point = $this->_datas['partner']['x'].','.$this->_datas['partner']['y'];
$exclude = $this->_datas['partner']['exclude'];
$utm_click = $this->_datas['referal'];

include __DIR__. '/types.php'; 

?>


<!DOCTYPE html>
<html>
    <head>
         <!-- Yandex.Metrika counter -->
        <script type="text/javascript">
            (function (d, w, c) {
                (w[c] = w[c] || []).push(function() {
                    try {
                        w.yaCounter<?=$metrica?> = new Ya.Metrika({
                            id:<?=$metrica?>,
                            clickmap:true,
                            trackLinks:true,
                            webvisor:true,
                            accurateTrackBounce:true
                        });
                    } catch(e) { }
                });

                var n = d.getElementsByTagName("script")[0],
                    s = d.createElement("script"),
                    f = function () { n.parentNode.insertBefore(s, n); };
                s.type = "text/javascript";
                s.async = true;
                s.src = "https://mc.yandex.ru/metrika/watch.js";

                if (w.opera == "[object Opera]") {
                    d.addEventListener("DOMContentLoaded", f, false);
                } else { f(); }
            })(document, window, "yandex_metrika_callbacks");
        </script>
        
        <meta charset="utf-8"/>
        <title>Надежный ремонт <?=$marka == 'Apple' ? 'Вашей техники' : 'техники '.$marka?></title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" name="viewport"/>
        <link rel="icon" href="/img/<?=$marka_lower?>/favicon.ico" type="image/x-icon"/>
    </head>
    <body>
        <header>
            <div class="inner">
                <div class="logo-wrapper">
                    <img src="/img/<?=$marka_lower?>/logo_t.png" alt=""/>
                    <p class="small">Надежный ремонт  <?=$marka == 'Apple' ? 'Вашей техники' : 'техники '.$marka?></p>
                </div>
                <div class="phone">
                    <a href="tel:+<?=$phone?>"><?=$phone_format?></a>
                </div>
            </div>
        </header>
        <div class="firstscreen padding">
            <div class="inner">
                 <img id= "load-img" src="<?=getDeviceCode($marka_lower, current($this->_datas['all_devices'])['type']);?>" onerror="setDefImg(this);"/>
                 <div class="first-title">
                    <h1>
                        Лаборатория<br>ремонта<br><?=$marka == 'Apple' ? 'iMaster' : $marka ?>
                    </h1>
                    <p>
                        Мы позаботимся о вашем гаджете.<br>Бережно. Педантично. Скрупулёзно.
                    </p>
                    <div class="button">
                        <a href="#free-call" class="fancybox">Узнать стоимость и время ремонта</a>
                    </div>
                 </div>
            </div>
        </div>
        
        <div class="menu-upper">
            <div class="inner">
                <img src="/img/<?=$marka_lower?>/logo_t.png" alt=""/>
                <div class="phone">
                    <p class="small">Свяжитесь с нами:</p>
                    <a href="tel:+<?=$phone?>"><?=$phone_format?></a>
                </div>
               <div class="button">
                    <a href="#free-call" class="fancybox">Узнать стоимость и время ремонта</a>
               </div>
            </div>
       </div>
        
        <div class="secondscreen padding" id="ceny">
            <div class="inner">
                <h2>Цены, которые не вырастут после диагностики</h2>
                <? include __DIR__. '/prices.php'; ?>
                
                <ul class="tabs">
                <?  $i = 0;           
                    $get_services = '';
                    $times = [
                        ['минута','минуты','минут'],
                        ['час','часа','часов'],
                        ['день','дня','дней'],
                    ];
                    // function setHours($val){
                    //     $default = $val;
                    //     $val = $val % 10;
                    //     if ($val == 1 && $default%100 !=11) return $default.' час';
                    //     if ($val == 2 &&  $val <=4 && $default <=4) return $default.' часа';
                    //     return $default.' часов';
                    // }

                    foreach ($this->_datas['all_devices'] as $device)
                    {
                        //if (isset($prices[$device['type']]))
                        //{
                            $getType = getDeviceCode($marka_lower, $device['type']);
                  
                            $add_class = '';
                            if (!$i) $add_class = ' active';
                            
                            echo '<li class="tabsli '.$add_class.'" data-type="'.$getType.'"><span>'.tools::mb_ucfirst($device['type_m']).'</span></li>';
                            
                        //}
                        $get_services .= "&type[]=" .urlencode(mb_strtolower($device['type']));
                            
                        $i++;
                    }
                ?>    
                </ul>
                
                <?
            
                $url_connect = 'method=get_services' . $get_services;
                $services = tools::connect_gc($url_connect);
                
                $t = [];
                
                if (isset($services['response']))
                {
                    foreach ($services['response'] as $data)
                    {
                        $t[mb_strtolower($data['type']['name'])][] = $data;
                    }
                }
                
                $services = $t;
                
                foreach ($services as $type_name => $value)
                {
                    foreach ($value as $key => $v)
                    {
                        $lower = mb_strtolower($v['name']);
                        if (in_array($lower, ['диагностика', 'выезд мастера'])) 
                            unset($value[$key]);
                    }
                    
                    usort($value, array("framework\\tools", "cmp_obj"));
                    
                    $value = array_slice($value, 0, 10);
                    $services[$type_name] = $value;                    
                }
                
                ?> 
                
                <div class="tabsfon-all">
                    
                    <?
                     $i = 0;
                        
                     foreach ($this->_datas['all_devices'] as $device)
                     {
                        //if (isset($prices[$device['type']]))
                        //{
                            $add_class = '';                        
                            if (!$i) $add_class = ' active';
                            
                            echo '<div class="tabsfon'.$add_class.'">';
                            
                                echo '<table>
                                    <thead>
                                        <tr>
                                            <th>Услуга</th>
                                            <th>Время ремонта</th>
                                           	<th>Гарантия</th>
                                            <th>Стоимость</th>  
                                            <th></th>                                      
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class = "w">Программная диагностика</td>
                                            <td>30 минут</td>
                                           	<td>-</td>
                                            <td>0/250 р.<sup>*</sup></td>
                                            <td><div class="button"><a href="#free-call" class="fancybox">Записаться на ремонт</a></div></td>
                                       </tr>
                                       <tr>
                                            <td class = "w">Аппаратная диагностика</td>
                                            <td>60 минут</td>
                                           	<td>-</td>
                                            <td>0/500 р.<sup>*</sup></td>
                                            <td><div class="button"><a href="#free-call" class="fancybox">Записаться на ремонт</a></div></td>
                                        </tr>';
                                
                                 $lower = mb_strtolower($device['type']);
                                 
                                 $feed = tools::gen_feed($this->_datas['feed']);
                                 srand($feed);
                                 
                                 if (isset($services[$lower]))
                                 {
                                     foreach ($services[$lower] as $service)
                                     {
                                         $procent = (100 + rand(0, 20)) / 100;
                                         $price = round($procent  * $service['price'] / 50) * 50;
                                         $time = $service['min_time'];
                                         $count = '';
                                         if ($time >= 90 && $time <=1440) {
                                            $hours = floor($time / 60);
                                            $minutes = $time % 60;
                                            $count = tools::declOfNum($hours,$times[1]).' '.tools::declOfNum($minutes,$times[0]);
                                            if ($hours && $minutes !=0) 
                                                $count = tools::declOfNum($hours,$times[1]).' '.tools::declOfNum($minutes,$times[0]);
                                            else  $count = tools::declOfNum($hours,$times[1]); 
                                         }
                                         if ($time >= 1440) {
                                            $days = intval($time / 1440);
                                            $hours = intval(($time-$days * 1440) / 60);
                                            $minutes = $time - ($days*1440 + $hours*60);
                                            if ($hours && $minutes !=0) $count = tools::declOfNum($days,$times[2]).' '.tools::declOfNum($hours,$times[1]).' '.tools::declOfNum($minutes,$times[0]); 
                                            else  $count = tools::declOfNum($days,$times[2]);                                      
                                         }
                                         if ($time <90) $count = tools::declOfNum($service['min_time'],$times[0]);

                                         echo '<tr>
                                            <td class = "w">'.$service['name'].'</td>
                                            <td>'.$count.'</td>
                                           	<td>До 1 года</td>
                                            <td>'.$price.' р.</td>
                                            <td><div class="button"><a href="#free-call" class="fancybox">Записаться на ремонт</a></div></td>
                                        </tr>';
                                     }
                                 }
                                
                                echo '</tbody>
                                    </table>';
                                    
                            echo '</div>';
                            $i++;
                        //}
                     } ?>
                </div>
                
                <p class="small">* Диагностика бесплатна при проведении ремонтных работ. Отдельный заказ программной или аппаратной диагностики указан в прейскуранте выше.</p>
                <p class="small">Мы работаем с несколькими поставщиками оригинальных и аналоговых комплектующих. Цены на одни и те же запчасти могут отличаться, в зависимости от партии, производителя и параметров комплектующей. Точные цены на комплектующие уточняйте у менеджеров в день обращения.</p>
            </div>
        </div>
        <div class="thirdscreen padding" id="garantiya">
            <div class="inner">
                <h2>Гарантия: мы не обещаем – мы ремонтируем</h2>
                <p class="small">Менее 5 % отремонтированных аппаратов возвращаются в сервис по гарантии</p>
                <p class="desc">Мы знаем, что качественно выполняем свою работу. Чтобы вы не сомневались в этом, мы выдаем гарантийный талон. Гарантия на все проведенные работы от 30 дней и установленные детали до 3 лет (в зависимости от услуги и комплектующей).</p>
                <img src="/img/<?=$marka_lower?>/bg.png" alt=""/>
            </div>
        </div>
        <div class="fourscreen padding" id="pochinim">
            <div class="inner">
                <h2>Починим любую неисправность</h2>
                <? include __DIR__. '/defects.php'; ?>
                <ul class="tabs">
                <?  $i = 0;
                     
                    foreach ($this->_datas['all_devices'] as $device)
                    {
                        if (isset($defects[$device['type']]))
                        {
                            $add_class = '';
                            if (!$i) $add_class = ' active';
                            
                            echo '<li class="tabsli'.$add_class.'"><span>'.tools::mb_ucfirst($device['type_m']).'</span></li>';
                            
                            $i++;
                        }
                    }
                ?>    
                </ul>             
                <div class="tabsfon-all">
                    
                    <?
                     $i = 0;
                        
                     foreach ($this->_datas['all_devices'] as $device)
                     {
                        if (isset($defects[$device['type']]))
                        {
                            $add_class = '';                        
                            if (!$i) $add_class = ' active';
                            
                            echo '<div class="tabsfon'.$add_class.'">';
                            
                                echo '<ul class="defect-list">';
                                
                                 foreach ($defects[$device['type']] as $defect)
                                 {
                                     echo '<li>
                                        <div class="name">'.tools::mb_firstupper($defect[0]).'</div>
                                        <p>Стоимость от '.$defect[2].' руб</p>                                        
                                        <div class="description">'.tools::mb_firstupper($defect[1]).'</div>                                        
                                        <div class="button opacity"><a href="#free-call" class="fancybox">Записаться на ремонт</a></div>
                                     </li>';
                                 }
                                
                                echo '</ul>';
                            echo '</div>';
                        
                            $i++;
                        }
                     } ?>
                </div>
                
            </div>
        </div>
        <div class="fivescreen padding">
            <div class="inner">
                <div class="form-wrapper">
                    <h2>Запишитесь онлайн прямо сейчас</h2>
                    <p>Оставьте свои контактные данные и оператор свяжется с вами в течении 1,5 минут.</p>
                    <form>
                        <input class="form-input" type="text" name="name" placeholder="Имя заказчика"/>
                        <input class="form-input" type="tel" name="number" placeholder="Номер телефона"/>
                        <div class="button">
                            <a href="#">Отправить заявку</a>
                        </div>
                        <label>
                            <input type="checkbox" name="check_form" checked="checked"/>
                            <a class="label_txt fancybox" href="#policy">Согласие на обработку персональных данных</a>
                        </label>
                    </form>
                    <p class="thank-you">Спасибо за заявку!</p>
                </div>
            </div>
        </div>
        <div class="sixscreen padding" style="min-height: 300px;">
            <div class="map" id="map" data-yandex_zoom="<?=$this->_datas['zoom']?>"></div>
            <div class="inner">
                <div class="map-wrapper">
                    <? if (!$exclude):?><p><?=$region_name?>,<br /><?=$address?><br /><?=$time?></p><?endif;?>
                    <p class="small">Позвоните нам:</p>
                    <p class="phone"><a style="text-decoration: none; color: #000;" href="tel:+<?=$phone?>"><?=$phone_format?></a></p>
                </div>
            </div>
        </div>
        <div class="sevenscreen padding" id="o-servise">
            <div class="inner">
                <h2>О сервисе</h2>
                <div class="block-wrapper">
                    <img src="/img/girl.png" style="width: 378px;"/>
                    
                    <div class="left-side">
                    
                        <div class="block">                    
                            <h3>Срочный ремонт</h3>
                            <p>Большинство стандартных ремонтов производится в день обращения. Мы не делаем дополнительные наценки за срочность. Но при этом способны отремонтировать даже самые «сложные» аппараты быстрее большинства сервисов <?=$this->_datas['region']['name_re']?>.</p>
                        </div>
                        <div class="block" style="width: 65%;">
                            <h3>Оригинальные запчасти</h3>
                            <p>Непосредственно в сервисе имеется запас оригинальных запчастей из расчёта месячной потребности. Но главное - это даже не наличие популярных комплектующих, а регулярные поставки заказанных комплектующих с центральных складов 2 раза в день.</p>
                        </div>
                        <div class="block" style="width: 60%;">
                            <h3>Честные цены</h3>
                            <p>Мы не обманываем: не устанавливаем б/у комплектующие и не придумываем лишние услуги. Все работы проводятся ТОЛЬКО после согласования с владельцем гаджета точных сроков и полной стоимости.</p>
                        </div>
                        
                    </div>
                    <div class="right-side">
                    
                        <div class="block">                    
                            <h3>Экономия на ремонте</h3>
                            <p>При замене нескольких комплектующих на работы предоставляются существенные скидки. Если аппарат уже разобран, мы не считаем полную стоимость каждой услуги требующей его разборку.</p>
                        </div>
                        <div class="block" style="width: 60%;">
                            <h3>Поддержка клиентов</h3>
                            <p>Сразу после передачи аппарата в диагностику вам выделяется персональный менеджер, который будет контролировать ход выполнения ремонта и постоянно держать вас в курсе всех изменений статуса аппарата.</p>
                        </div>
                        <div class="block" style="width: 66%;">
                            <h3>Контроль качества</h3>
                            <p>Критика – это возможность стать лучше. Нам важно мнение наших клиентов, поэтому всегда открыты для жалоб и предложений. <a href="#free-calla" class="fancybox" style="color: #6c6aeb;">Пишите</a> о своем опыте обслуживания напрямую руководству сервисного центра.</p>
                        </div>
                        
                    </div>
                    
                </div>
            </div>
        </div>
        <footer>
            <div class="inner">
                <div class="logo-wrapper">
                    <img src="/img/<?=$marka_lower?>/logo_t.png" alt=""/>
                    <p class="small">Если техника могла выбирать, она бы выбрала нас!</p>
                </div>
                <div class="phone">
                    <a href="tel:+<?=$phone?>"><?=$phone_format?></a>
                    <a href="#policy" class="policy small fancybox">Пользовательское соглашение</a>
                </div>
            </div>
        </footer>
        
        <div id="free-call" class="popup-form padding">
        
                <div class="form-wrapper">
                    <h2>Узнайте cтоимость и время ремонта</h2>                    
                    <form>
                        <input class="form-input" type="text" name="name" placeholder="Имя заказчика"/>
                        <input class="form-input" type="tel" name="number" placeholder="Номер телефона"/>                        
                        <label>
                            <input type="checkbox" name="check_form" checked="checked"/>
                            <a class="label_txt fancybox" href="#policy">Согласие на обработку персональных данных</a>
                        </label>
                        <div class="button">
                            <a href="#">Отправить заявку</a>
                        </div>
                    </form>
                    <p class="thank-you">Спасибо за заявку!</p>
                </div>
        
        </div>
		
        <div id="free-calla" class="popup-form padding">
        
                <div class="form-wrapper">
                    <h2>Пожаловаться</h2>                    
                    <form>
                        <input class="form-input" type="text" name="name" placeholder="Имя заказчика"/>
                        <input class="form-input" type="tel" name="number" placeholder="Номер телефона"/>                        
                        <label>
                            <input type="checkbox" name="check_form" checked="checked"/>
                            <a class="label_txt fancybox" href="#policy">Согласие на обработку персональных данных</a>
                        </label>
                        <div class="button">
                            <a href="#">Отправить заявку</a>
                        </div>
                    </form>
                    <p class="thank-you">Спасибо за заявку!</p>
                </div>
        
        </div>
        
        <div id="policy" class="popup-form-2 padding">
            <p class="privacy">Соглашение на обработку персональных данных на сайте <a href="#" class="privacy-text-a">https://<?=$this->_datas['realHost']?>/</a></p>
            <p>
                Присоединяясь к настоящему Соглашению и оставляя свои данные на сайте https://<?=$this->_datas['realHost']?>/ (далее — Сайт), путём заполнения полей форм Пользователь:<br>
                •	подтверждает, что все указанные им данные принадлежат лично ему;<br>
                •	подтверждает и признаёт, что им внимательно в полном объёме прочитано Соглашение и условия обработки его персональных данных, указываемых им в полях форм, текст соглашения и условия обработки персональных данных ему понятны;<br>
                •	даёт согласие на обработку Сайтом предоставляемых в составе информации персональных данных в целях заключения между ним и Сайтом настоящего Соглашения, а также его последующего исполнения;<br>
                •	выражает согласие с условиями обработки персональных данных.<br>
                Пользователь даёт своё согласие на обработку его персональных данных, а именно совершение действий, предусмотренных п. 3 ч. 1 ст. 3 Федерального закона от 27.07.2006 N 152-ФЗ «О персональных данных», и подтверждает, что, давая такое согласие, он действует свободно, своей волей и в своём интересе.<br>
                Согласие Пользователя на обработку персональных данных является конкретным, информированным и сознательным.<br>
                Целью обработки персональных данных является предоставление Пользователю услуг, описанных на Сайте.<br>
                Настоящее согласие Пользователя признаётся исполненным в простой письменной форме, на обработку следующих персональных данных:<br>
                •	фамилии, имени, отчества;<br>
                •	места пребывания (город, область);<br>
                •	номеров телефонов;<br>
                •	адресов электронной почты (e-mail);<br>
                •	cookie-файлов;<br>
                •	информации об IP-адресе Пользователя;<br>
                •	информации о местоположении Пользователя.<br>
                <br>
                Пользователь, предоставляет https://<?=$this->_datas['realHost']?>/ право осуществлять следующие действия (операции) с персональными данными: сбор и накопление; хранение в течение установленных нормативными документами сроков хранения отчётности, но не менее трёх лет, с момента даты прекращения пользования услуг Пользователем; уточнение (обновление, изменение); использование; уничтожение; обезличивание; передача по требованию суда, в т. ч., третьим лицам, с соблюдением мер, обеспечивающих защиту персональных данных от несанкционированного доступа.<br>
                Указанное согласие действует бессрочно с момента предоставления данных и может быть отозвано вами путём подачи заявления администрации сайта с указанием данных, определённых ст. 14 Закона «О персональных данных».<br>
                Отзыв согласия на обработку персональных данных может быть осуществлён путём направления Пользователем соответствующего распоряжения в простой письменной форме на адрес электронной почты (e-mail)info@<?=$this->_datas['site_name']?>.<br>
                Сайт имеет право вносить изменения в настоящее Соглашение. При внесении изменений в актуальной редакции указывается дата последнего обновления. Новая редакция Соглашения вступает в силу с момента её размещения, если иное не предусмотрено новой редакцией Соглашения.<br>
                К настоящему Соглашению и отношениям между Пользователем и Сайтом, возникающим в связи с применением Соглашения, подлежит применению право Российской Федерации.
            </p>
        </div>
        
        <input type="hidden" name="point" value="<?=$point?>"/>
        <input type="hidden" name="mail" value="<?=$mail?>"/>
        <input type="hidden" name="referal" value="<?=$utm_click?>"/>
          
        <?php if (!empty($this->_datas['piwik'])) { ?>
            <!-- Matomo -->
            <script type="text/javascript">
            var _paq = _paq || [];
            /* tracker methods like "setCustomDimension" should be called before "trackPageView" */
            _paq.push(['trackPageView']);
            _paq.push(['enableLinkTracking']);
            (function() {
                var u="/stat/";
                _paq.push(['setTrackerUrl', u+'piwik.php']);
                _paq.push(['setSiteId', '<?=$this->_datas['piwik']?>']);
                var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
                g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
            })();
            </script>
            <noscript><p><img src="/stat/piwik.php?idsite=<?=$this->_datas['piwik']?>&amp;rec=1" style="border:0;" alt="" /></p></noscript>
            <!-- End Matomo Code -->
        <?php } ?>
            <script>
                function setImg(){
                        let check = document.querySelector('.active').getAttribute('data-type');
                         document.getElementById('load-img').setAttribute('src',check);                   
                }
                function setDefImg(source){
                    let brand = "<?=strtolower($this->_datas['marka']['name'])?>";
                    document.getElementById('load-img').setAttribute('src','/img/'+brand+'/bg.png');
                }
                document.querySelector('.tabs').addEventListener('click',function(){
                    setImg();
                });
               
            </script>

    </body>
</html>


