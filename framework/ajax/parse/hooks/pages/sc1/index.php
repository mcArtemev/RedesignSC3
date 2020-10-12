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

$accord_menu = array('ноутбук' => 'MacBook', 'смартфон' => 'iPhone', 'планшет' => 'iPad', 'моноблок' => 'iMac', 'смарт-часы' => 'Watch',);

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
    if (isset($this->_datas['admin'])){
        echo "<pre>";
        if (!empty($this->_datas['admin'][0])){
        print_r($this->_datas[$this->_datas['admin'][0]]);
        }else print_r($this->_datas);
        echo "</pre>";
    }
?>
<div class="sr-main">
    <div class="uk-container-center uk-container">
     <?  if (!empty($this->_datas['original_setka_id']) && $this->_datas['original_setka_id'] == 12){
        $bgblock = 'bgBlockOnes.png';
      } else {
        $bgblock = 'bgBlockOne.jpg';
            }
            ?> 
            <div class="uk-flex vitrina-img" data-uk-grid-margin style="background: url(/wp-content/themes/studiof1/img/<?=$marka_lower?>/<?=$bgblock?>) 50% 50% no-repeat">
            <div class="uk-width-large-5-10 uk-width-medium-6-10 greyblock ">
                <h1><?=$this->_ret['h1']?></h1>
                <?=$text1?>
                <p><input type="button" data-uk-modal="{target:'#popup'}" class=" uk-button  uk-button-large uk-button-success uk-margin-right mobileWidth-1-1" onclick="if (typeof window['yaCounter<?=$metrica?>'] !== 'undefined') yaCounter<?=$metrica?>.reachGoal('ORDER'); return false;" value="Записаться на ремонт"/><span class="uk-contrast"> и получить скидку 10%</span></p>
            </div>
        </div>

    </div>
</div>
<div class="sr-content">
    <div class="uk-container-center uk-container uk-margin-large-bottom">
        <p class="uk-h2 uk-margin-large-top uk-text-center">
        <?=$h2?>
        </p>
        <?=$text2?>
            <?
            $str = '<div class="uk-grid " data-uk-grid-margin>';
            $i = 1;
            
            $new_temp_d = [];
            foreach ($this->_datas['all_devices'] as $key => $device) {
                if (!empty($new_temp_d[$device['type']])) {
                    unset($this->_datas['all_devices'][$key]);
                }
                $new_temp_d[$device['type']] = true;
            }
            
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
                   $width[2] = 3;
                   $width[3] = 1;
                break;
                case 11:
                   $width[0] = 4;
                   $width[1] = 4;
				   $width[2] = 3;
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
                'телевизор' => 'Сервисный центр проведёт бесплатную диагностику телевизора.',
                'монитор' => 'Сервисный центр проведёт бесплатную диагностику монитора.',
                'проектор' => 'Сервисный центр проведёт бесплатную диагностику проектора.',
                'наушники' => 'Сервисный центр проведёт бесплатную диагностику наушников.',
                'сервер' => 'Сервисный центр проведёт бесплатную диагностику серверов.',
            );

            $samsung_index = array(
                'ноутбук' => 'Во время ремонта ноутбука параллельно делаем его чистку.',
                'планшет' => 'Комплектующие для обслуживания планшетов в наличии.',
                'смартфон' => 'Диагностика смартфона в сервисном центре занимает минимум времени.',
                'моноблок' => 'Самая популярная услуга для моноблоков: перепайка BGA чипа.',
                'монитор' => 'За вашим монитором приедет курьер из сервисного центра.',
                'телевизор' => 'Среднее время обслуживания телевизора 30 минут.',
				'умные часы' => 'Время ремонта умных часов от 30 минут.',
   	            'компьютер' => 'Сервисный центр проведёт бесплатную диагностику компьютера.',
   	            'принтер' => 'Сервисный центр проведёт бесплатную диагностику принтера.',
                'проектор' => 'Сервисный центр проведёт бесплатную диагностику проектора.',
                'наушники' => 'Сервисный центр проведёт бесплатную диагностику наушников.',
            );

            if (!empty($this->_datas['original_setka_id']) && $this->_datas['original_setka_id'] == 12){
               $samsung_index = array(
                   'холодильник' => 'Среднее время обслуживания холодильника 30 минут.',
                   'стиральная машина' => 'Диагностика стиральной машины в сервисном центре занимает минимум времени.',
                   'посудомоечная машина' => 'Время ремонта посудомоечных машин от 30 минут.',
               );
           }
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
                        <a href="/'.$accord[$device['type']].'/">';

                            if ($marka_lower == 'apple')
                            {
                                $str .= '<p class="uk-h3">'.(isset($accord_menu[$device['type']]) ? $accord_menu[$device['type']] : tools::mb_ucfirst($device['type_m'], 'utf-8', false)).'</p>';
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
                                        $str .= '<p>'.$hp_index[$device['type']].'</p>
                                            <!--noindex--><p><span class="uk-button uk-button-primary">Подробнее</span></p><!--/noindex-->';
                                    }
                                    else
                                    {
                                        if ($marka_lower == 'samsung' && $region_name == 'Москва')
                                        {
                                            $str .= '<p>'.$samsung_index[$device['type']].'</p>
                                                <!--noindex--><p><span class="uk-button uk-button-primary">Подробнее</span></p><!--/noindex-->';
                                        }
                                        else
                                        {
                                            $str .= '<p>Ремонт и обслуживание '.$device['type_rm'].' в сервисном центре или с выездом курьера на дом или в офис.</p>
                                                <p><span class="uk-button uk-button-primary">Подробнее</span></p>';
                                        }
                                    }


                                    $str .=
                                '</div>
                            </div>
                        </a>
                    </div>
                </div>';

                /*if ($i == $row && $count > 3)
                    $str .= '</div><div class="uk-grid " data-uk-grid-margin>';*/
                //$i++;
            }
            echo $str.'</div>';
            
            ?>
        <?=$text2_lower?>
        <p class="uk-h2 uk-margin-large-top uk-text-center"><?=$h3?></p>
        <?=$text3;?>
        <div class="uk-grid index-page" data-uk-grid-margin>
            <div class="uk-width-medium-1-2 ">
                <div class="uk-panel uk-panel-box uk-panel-box-secondary sr-block-white diagnostika">
                    <? if (!$this->_datas['sdek']):?>
                        <p class="uk-h3">Экспресс диагностика</p>
                        <? if ($marka_lower == 'hp'):?>
                            <p>Точное выявление неисправности за минимальное время.</p>
                            <!--noindex--><a class="uk-button uk-button-primary  uk-button-large" href="/diagnostika/">Подробнее</a><!--/noindex-->
                        <?else:?>
                            <p>Точное выявление неисправности в минимальные сроки.</p>
                            <a class="uk-button uk-button-primary  uk-button-large" href="/diagnostika/">Подробнее</a>
                        <?endif;?>
                    <?else:?>
                        <p class="uk-h3">Экспертная диагностика</p>
                        <p>Точное выявление неисправности даже в мелочах.</p>
                        <a class="uk-button uk-button-primary  uk-button-large" href="/diagnostika/">Подробнее</a>
                    <?endif;?>
                </div>
            </div>
            <div class="uk-width-medium-1-2 ">
                <div class="uk-panel uk-panel-box uk-panel-box-secondary sr-block-white komplekt">
                    <p class="uk-h3">Комплектующие <?=(($marka_lower == 'apple' && $region_name == 'Москва') ? '' : $marka)?></p>
                    <? if ($marka_lower == 'hp'):?>
                        <p>Фирменные запчасти/лицензионное ПО. На складе и на заказ.</p>
                        <!--noindex--><a class="uk-button uk-button-primary  uk-button-large" href="/zapchasti/">Подробнее</a><!--/noindex-->
                    <?else:?>
                        <p>Фирменные запчасти и лицензионное ПО. В наличии и на заказ.</p>
                        <a class="uk-button uk-button-primary  uk-button-large" href="/zapchasti/">Подробнее</a>
                    <?endif;?>
                </div>
            </div>
            <div class="uk-width-medium-1-2 ">
                <div class="uk-panel uk-panel-box uk-panel-box-secondary sr-block-white viezd">
                    <? if (!$this->_datas['sdek']):?>
                        <p class="uk-h3">Выезд и доставка</p>
                        <? if ($marka_lower == 'hp'):?>
                            <p>Доставка техники по <?=$region_name_de?> – от 30 минут.</p>
                            <!--noindex--><a class="uk-button uk-button-primary  uk-button-large" href="/dostavka/">Подробнее</a><!--/noindex-->
                         <?else:?>
                            <p>Доставка техники <?=$marka?> по <?=str_replace("Санкт-Петербургу", "СПБ",$region_name_de)?> – от 30 минут.</p>
                            <a class="uk-button uk-button-primary  uk-button-large" href="/dostavka/">Подробнее</a>
                         <?endif;?>
                    <?else:?>
                        <p class="uk-h3">Удобное месторасположение</p>
                        <p>Более 1500 пунктов приема заказов в России.</p>
                        <a class="uk-button uk-button-primary  uk-button-large" href="/kontakty/">Подробнее</a>
                    <?endif;?>
                </div>
            </div>
            <div class="uk-width-medium-1-2 ">
                <div class="uk-panel uk-panel-box uk-panel-box-secondary sr-block-white srochniy">
                    <? if (!$this->_datas['sdek']):?>
                        <p class="uk-h3">Срочный ремонт</p>
                         <? if ($marka_lower == 'hp'):?>
                            <p>Устранение типовых неисправностей в <?=$region_name_pe?> занимает не более 24 часов. Без переплаты.</p>
                            <!--noindex--><a class="uk-button uk-button-primary  uk-button-large" href="/sroki/">Подробнее</a><!--/noindex-->
                         <?else:?>
                            <p>Устранение типовых неисправностей в течение 24 часов. Без переплаты.</p>
                            <a class="uk-button uk-button-primary  uk-button-large" href="/sroki/">Подробнее</a>
                          <?endif;?>
                    <?else:?>
                         <p class="uk-h3">Срочный ремонт</p>
                         <p>Устранение типовых неисправностей в короткие сроки. Без переплаты.</p>
                         <a class="uk-button uk-button-primary  uk-button-large" href="/diagnostika/">Подробнее</a>
                    <?endif;?>
                </div>
            </div>
        </div>

        <?=$text3_lower?>

    </div>
</div>
</div>
<div class="sr-dark">
    <div class="uk-container-center uk-container  ">
        <div class="uk-flex expert ">
            <div class="uk-width-medium-3-5">

                 <p class="uk-h2 uk-margin-large-top uk-contrast"><?=$h4?></p>
                 <?=$text4?>
                 <p><input type="button" data-uk-modal="{target:'#popup'}" class=" uk-button  uk-button-large uk-button-success uk-margin-right mobileWidth-1-1" onclick="if (typeof window['yaCounter<?=$metrica?>'] !== 'undefined') yaCounter<?=$metrica?>.reachGoal('ORDER'); return false;" value="Записаться на ремонт"/><span class="uk-contrast uk-text-muted">со скидкой 10%</span></p>

            </div>

            <div class="uk-width-medium-2-5 divaisInfo <?=$marka_lower?>" style=" background: url(/wp-content/uploads/2015/03/<?=$marka_lower?>/<?= ($this->_datas['original_setka_id'] == 12) ? "divaisInfo-regB.png" : "divaisInfo-reg.png"?>) no-repeat right; background-size: contain;"><?=((($this->_datas['setka_name'] != 'СЦ-1' || $marka_lower != 'samsung') && ($this->_datas['setka_name'] != 'СЦ-1' && $marka_lower != 'nikon') && ($this->_datas['setka_name'] != 'СЦ-1' && $marka_lower != 'dell')) ? '<div>Сервисный центр '.$marka.'<br>'.' в '.$region_name_pe.'</div>' : '');?></div>
        </div>

    </div>
</div>
<div class="sr-content-footer">
    <div class="uk-container-center uk-container">
        <p class="uk-h2 uk-margin-large-top uk-text-center"><?=$h5?></p>
        <?=$text5?>
    </div>
</div>
