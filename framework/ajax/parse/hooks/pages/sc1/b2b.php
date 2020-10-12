<?
use framework\tools;

$marka = $this->_datas['marka']['name'];  // SONY
$marka_lower = mb_strtolower($marka);
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

$accord_image = $this->_datas['accord_image'];
$accord = $this->_datas['accord'];
$metrica = $this->_datas['metrica'];

$accord_menu = array('ноутбук' => 'MacBook', 'смартфон' => 'iPhone', 'планшет' => 'iPad', 'моноблок' => 'iMac', 'смарт-часы' => 'Watch', 'телевизор' => 'Apple TV', 'компьютер' => 'Mac');

include __DIR__.'/text/default.php';

$text_file = __DIR__.'/text/'.$marka_lower.'.php';

if (file_exists($text_file))
    include $text_file;

if ($marka_lower == 'apple' && $region_name == 'Москва')
   include __DIR__.'/text/apple_0.php';

if ($marka_lower == 'meizu' && $region_name == 'Москва')
    include __DIR__.'/text/meizu_0.php';

if ($marka_lower == 'samsung' && $region_name == 'Москва')
    include __DIR__.'/text/samsung_0.php';

?>

<div class="sr-main">
    <div class="uk-container-center uk-container">
        <div class="uk-flex vitrina-img" data-uk-grid-margin style="background: url(/wp-content/themes/studiof1/img/<?=$marka_lower?>/bgBlockOne.jpg) 50% 50% no-repeat">
            <div class="uk-width-large-5-10 uk-width-medium-6-10 greyblock ">
                <h1><?=$this->_ret['h1']?></h1>
                <p>Обслуживание устройств <?=$ru_marka?> в <?=$region_name_pe?> стало еще удобнее благодаря b2b сервису <?=$servicename?>.</p>
                <p>Теперь вы можете ощутить все преимущества корпоративного сервиса, не выходя из офиса. </p>
                <p><input type="button" data-uk-modal="{target:'#popup-b2b'}" class=" uk-button  uk-button-large uk-button-success uk-margin-right mobileWidth-1-1" onclick="if (typeof window['yaCounter<?=$metrica?>'] !== 'undefined') yaCounter<?=$metrica?>.reachGoal('ORDER'); return false;" value="Стать клиентом"/><span class="uk-contrast"> и получить скидку 10%</span></p>
            </div>
        </div>

    </div>
</div>
<div class="sr-content">
    <div class="uk-container-center uk-container uk-margin-large-bottom">
        <p class="uk-h2 uk-margin-large-top uk-text-center">
        Обслуживание от экспертов <?=$marka?>. Стань партнёром.
        </p>
        <p class="uk-margin-bottom">Деловой стиль жизни подвергает персональную технику жесточайшим нагрузкам каждый день. Даже технику <?=$marka?>. 
                Рабочий ноутбук, телефон, планшет - неполадки в них могут нарушить ваши планы. Хорошие новости - теперь вы можете обслуживать ваши компьютеры, смартфоны и другую рабочую технику по корпоративному тарифу <?=$servicename?>  и получать скидки для постоянных клиентов.</p>
        
            <?
            $str = '<div class="uk-grid " data-uk-grid-margin>';
            $i = 1;
            $count = count($this->_datas['all_devices']);

            switch ($count)
            {
                case 1:
                  $width = '1';
                break;
                case 2:
                  $width = '2';
                break;
                case 4:
                  $width = '2';
                break;
                case 5:
                   $width[0] = 3;
				   $width[1] = 2;
                break;
				case 7:
				   $width[0] = 3;
                   $width[1] = 2;
				   $width[2] = 2;
                break;
				case 8:
				   $width[0] = 3;
                   $width[1] = 3;
				   $width[2] = 2;
                break;
                case 10:
                   $width[0] = 3;
                   $width[1] = 3;
				   $width[2] = 4;
                break;
				default:
                   $width = '3';
				break;
            }

            $hp_index = array(
                'ноутбук' => 'Среднее время обслуживания ноутбуков в сервисном центре один час.',
                'планшет' => 'Самая популярная услуга в сервисном центре для планшетов: замена дисплея.',
                'моноблок' => 'За вашим моноблоком приедет курьер из сервисного центра.',
                'компьютер' => 'Сервисный центр проведёт бесплатную диагностику компьютера.',
				'принтер' => 'Сервисный центр проведёт бесплатную диагностику принтера.',
            );

            $samsung_index = array(
                'ноутбук' => 'Во время ремонта ноутбука параллельно делаем его чистку.',
                'планшет' => 'Комплектующие для обслуживания планшетов в наличии.',
                'смартфон' => 'Диагностика смартфона в сервисном центре занимает минимум времени.',
                'моноблок' => 'Самая популярная услуга для моноблоков: перепайка BGA чипа.',
                'монитор' => 'За вашим монитором приедет курьер из сервисного центра.',
                'телевизор' => 'Среднее время обслуживания телевизора 30 минут.',
				'умные часы' => 'Время ремонта умных часов от 30 минут.',
            );

			if (is_array($width)) {
				$i = 0;
				$j = 0;
				$exwidth = $width[$j];
			} else {
				$exwidth = $width;
			}
            foreach ($this->_datas['all_devices'] as $device)
            {
				if (is_array($width)) {
					if ($width[$j] === $i) {
						$i = 0;
						$j++;
						$exwidth = $width[$j];
					}
					$i++;
				}
				
                $str .= '<div class="uk-width-large-1-'.$exwidth.' uk-width-medium-1-2 uk-width-small-1-1">
                    <div class="uk-panel uk-panel-box uk-panel-box-secondary uk-text-center sr-block-white index-picture">
                        <div>';

                            if ($marka_lower == 'apple' && !empty($accord_menu[$device['type']]))
                            {
                                $str .= '<p class="uk-h3">'.$accord_menu[$device['type']].'</p>';
                            }
                            else
                            {
                                $str .= '<p class="uk-h3">'.tools::mb_ucfirst($device['type_m'], 'utf-8', false).'</p>';
                            }

							if (strpos($accord_image[$device['type']], 'brand') !== false) {
								$accord_image[$device['type']] = str_replace('brand', $marka_lower, $accord_image[$device['type']]);
                            }
                            
                            $str .= '<img src="/wp-content/themes/studiof1/img/'.$marka_lower.'/'.$accord_image[$device['type']].'.jpg" alt="'.mb_strtolower($device['type']).'">

                            <div class="HoverDivais">
                                <div class="fixBlock">';

                                    if ($marka_lower == 'samsung' && $region_name == 'Москва')
                                        $str .= '<!--noindex--><span class="uk-h3">Ремонт '.$device['type_rm'].'</span><!--/noindex-->';
                                    else
                                        $str .= '<span class="uk-h3">Ремонт '.$device['type_rm'].'</span>';

                                    if ($marka_lower == 'hp')
                                    {
                                        $str .= '<p>'.$hp_index[$device['type']].'</p>';
                                    }
                                    else
                                    {
                                        if ($marka_lower == 'samsung' && $region_name == 'Москва')
                                        {
                                            $str .= '<p>'.$samsung_index[$device['type']].'</p>';
                                        }
                                        else
                                        {
                                            $str .= '<p>Ремонт и обслуживание '.$device['type_rm'].' в сервисном центре или с выездом курьера на дом или в офис.</p>';
                                        }
                                    }


                                    $str .=
                                '</div>
                            </div>
                        </div>
                    </div>
                </div>';

                /*if ($i == $row && $count > 3)
                    $str .= '</div><div class="uk-grid " data-uk-grid-margin>';*/
                //$i++;
            }
            echo $str.'</div>';
            ?>
        <p class="uk-h2 uk-margin-large-top uk-text-center">Сервис со знаком качества</p>
        <div class="uk-grid index-page" data-uk-grid-margin>
            <div class="uk-width-medium-1-2 ">
                <div class="uk-panel uk-panel-box uk-panel-box-secondary sr-block-white diagnostika">
                    <p class="uk-h3">Корпоративный тариф</p>                        
                    <p>Экономьте, поставив на обслуживание большее количество устройств <?=$marka?>.</p>
                    <p><input type="button" data-uk-modal="{target:'#popup-b2b'}" class=" uk-button  uk-button-large uk-button-success uk-margin-right mobileWidth-1-1" onclick="if (typeof window['yaCounter<?=$metrica?>'] !== 'undefined') yaCounter<?=$metrica?>.reachGoal('ORDER'); return false;" value="Стать клиентом"/></p>                   
                </div>
            </div>
            <div class="uk-width-medium-1-2 ">
                <div class="uk-panel uk-panel-box uk-panel-box-secondary sr-block-white komplekt">
                    <p class="uk-h3">Комплектующие <?=$marka?></p>                        
                    <p>Фирменные запчасти и лицензионное ПО. В наличии и на заказ.</p>
                    <p><input type="button" data-uk-modal="{target:'#popup-b2b'}" class=" uk-button  uk-button-large uk-button-success uk-margin-right mobileWidth-1-1" onclick="if (typeof window['yaCounter<?=$metrica?>'] !== 'undefined') yaCounter<?=$metrica?>.reachGoal('ORDER'); return false;" value="Стать клиентом"/></p>                   
                </div>
            </div>
           <div class="uk-width-medium-1-2 ">
                <div class="uk-panel uk-panel-box uk-panel-box-secondary sr-block-white viezd">
                    <p class="uk-h3">Накопительная программа b2b</p>                        
                    <p>Чем чаще вы обращаетесь в <?=$servicename?>, тем больше выгода.</p>
                    <p><input type="button" data-uk-modal="{target:'#popup-b2b'}" class=" uk-button  uk-button-large uk-button-success uk-margin-right mobileWidth-1-1" onclick="if (typeof window['yaCounter<?=$metrica?>'] !== 'undefined') yaCounter<?=$metrica?>.reachGoal('ORDER'); return false;" value="Стать клиентом"/></p>                    
                </div>
            </div>
            <div class="uk-width-medium-1-2 ">
                <div class="uk-panel uk-panel-box uk-panel-box-secondary sr-block-white srochniy">
                    <p class="uk-h3">Ремонт в день обращения</p>                        
                    <p>Стандарты качества. Гарантия до 3 лет. Без переплаты.</p>
                    <p><input type="button" data-uk-modal="{target:'#popup-b2b'}" class=" uk-button  uk-button-large uk-button-success uk-margin-right mobileWidth-1-1" onclick="if (typeof window['yaCounter<?=$metrica?>'] !== 'undefined') yaCounter<?=$metrica?>.reachGoal('ORDER'); return false;" value="Стать клиентом"/></p>        
                </div>
            </div>
        </div>

    </div>
</div>
</div>
<div class="sr-dark">
    <div class="uk-container-center uk-container  ">
        <div class="uk-flex expert ">
            <div class="uk-width-medium-3-5">

                 <p class="uk-h2 uk-margin-large-top uk-contrast">Скидка 10% по корпоративному тарифу </p>
                 <p class="uk-contrast">Неважно, одно у вас устройство <?=$marka?> или несколько - вы уже идете вперёд вместе с нами. И это здорово. А чтобы было ещё приятнее, мы дарим вам 10% скидку на первое обращение по корпоративному тарифу. Подробности уточняйте у менеджеров по телефону: <?=$phone_format?>.<br /><br /></p>
                 <p><input type="button" data-uk-modal="{target:'#popup-b2b'}" class=" uk-button  uk-button-large uk-button-success uk-margin-right mobileWidth-1-1" onclick="if (typeof window['yaCounter<?=$metrica?>'] !== 'undefined') yaCounter<?=$metrica?>.reachGoal('ORDER'); return false;" value="Стать клиентом"/><span class="uk-contrast uk-text-muted">со скидкой 10%</span></p>
                 <!--<p><input type="button" data-uk-modal="{target:'#popup-b2b'}" class=" uk-button  uk-button-large uk-button-success uk-margin-right mobileWidth-1-1" onclick="if (typeof window['yaCounter<?=$metrica?>'] !== 'undefined') yaCounter<?=$metrica?>.reachGoal('ORDER'); return false;" value="Записаться на ремонт"/><span class="uk-contrast uk-text-muted">со скидкой 10%</span></p>-->

            </div>

            <div class="uk-width-medium-2-5 divaisInfo <?=$marka_lower?>" style=" background: url(/wp-content/uploads/2015/03/<?=$marka_lower?>/divaisInfo-reg.png) no-repeat right;"><?=((($this->_datas['setka_name'] != 'СЦ-1' || $marka_lower != 'samsung') && ($this->_datas['setka_name'] != 'СЦ-1' && $marka_lower != 'nikon') && ($this->_datas['setka_name'] != 'СЦ-1' && $marka_lower != 'dell')) ? '<div>Сервисный центр '.$marka.'<br>'.' в '.$region_name_pe.'</div>' : '');?></div>

        </div>

    </div>
</div>
<div class="sr-content-footer">
    <div class="uk-container-center uk-container">
        <p class="uk-h2 uk-margin-large-top uk-text-center">Сервис центр <?=$servicename?> – надёжный помощник для вас и вашего бизнеса!</p>
        <p>Уже обслуживаетесь по корпоративному тарифу? Значит вы точно оценили его преимущества. Подключайте к нему ещё больше устройств своих коллег по организации и получайте дополнительные скидки и привилегии. С нами ваша компания всегда под надёжной защитой. 
<?=$servicename?> - мы рядом, когда это необходимо.</p>
        <p>Получите консультацию специалиста прямо сейчас!</p>
    </div>
</div>

<? $show_line = false;
$show_b2b = true; ?>
