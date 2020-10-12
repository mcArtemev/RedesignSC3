<?
use framework\tools;
use framework\pdo;

$footer_1 = true;
$status = '';
if (isset($this->_datas['marka'])) {
  $marka = $this->_datas['marka']['name'];
  $marka_lower = mb_strtolower($marka);

  if ($this->_datas['setka_name'] == 'СЦ-2' && (($marka_lower == 'samsung') || ($marka_lower == 'nikon') || ($marka_lower == 'sony')))
      $footer_1 = false;

  $accord = $this->_datas['typeUrl'];
}

if ($this->_datas['region']['name'] == 'Москва')
    $status = ' menu-status';

$analytics = $this->_datas['analytics'];
$metrica = $this->_datas['metrica'];
$mail = $this->_datas['partner']['email'];
if ($mail == 'litovchenko@list.ru') {
	$mail = '';
}

$url = ($this->_datas['arg_url'] != '/') ? '/'.$this->_datas['arg_url'].'/' : '/';

$addresis = [];//$this->_datas['addresis'];

$footer_add_style = '';
if ($url == '/contacts/requisites/')
{
    $footer_1 = false;
    $footer_add_style = ' style="position: fixed; bottom: 0; left: 0; width: 100%;"';
}

?>
        <footer class="footer"<?=$footer_add_style?>>

                <div class="wrapper gray">

                    <div class="fixed">

                        <div class="footer__nav">

                          <ul class = "mainNav <?=$status?>">
                              <? foreach ($this->_datas['menu'] as $key => $value)
                              {
                                if ($key[0] == '/')
                                  if ($url == $key)
                                      echo '<li><span class="active">'.$value.'</span></li>';
                                  else
                                      echo '<li><a href="'.$key.'">'.$value.'</a></li>';
                                else if (isset($value['name']) && isset($value['list']) && isset($value['pos'])) {
                                  $pos = $value['pos'] == 'right' ? ' class = "right"' : '';
                                  echo '<li class = "subItem"><a>'.$value['name'].'</a><ul'.$pos.'>';
                                  foreach ($value['list'] as $urlItem => $item) {
                                    if ($url == $urlItem)
                                        echo '<li><span class="active">'.$item.'</span></li>';
                                    else
                                        echo '<li><a href="'.$urlItem.'">'.$item.'</a></li>';
                                  }
                                  echo '</ul></li>';
                                }
                               }
                              ?>
                          </ul>

                        </div>

                    </div>

                </div>

                <div class="wrapper dgray">

                    <div class="fixed">

                        <div class="footer__links">

                            <div class="halfMin">
                                <p class="title">Контактная информация<p>
                                <p><?=$this->_datas['region']['name']?>, <?=$this->_datas['partner']['address1']?></p>
                                <a class="footphone mango_id" href="tel:+<?=$this->_datas['phone']?>">+<?=tools::format_phone($this->_datas['phone'])?></a>

                                <?
                                    if ($footer_1)
                                    {
                                        $str = '';
                                        $current_region_name = '';

                                        foreach ($addresis as $value)
                                        {
                                            $region_name = ($value['region_name']) ? $value['region_name'] : 'Москва';
                                            $v = $region_name;

                                            $address = $value['address2'] ? $value['address2'] : $value['address1'];

                                            if ($value['site'] !== $this->_datas['site_name'])
                                            {
                                                $str .= '<li>';
                                                $str .= '<a href="http://'.$value['site'].($url).'">'.$v.'</a>';
                                                $str .= '<br>'.$address;
                                                $str .= '</li>';
                                            }
                                            else
                                            {
                                                   $current_region_name = $region_name;
                                            }

                                            //$str .= '<br>+'.tools::format_phone($value['phone']);
                                        }
                                    }
                                ?>
                                <? if ($footer_1):?>
                                <!-- noindex -->
                                <?php /*<div id="popup-wrapper">
                                    <p>Адреса в других городах: <a class="current-region" href="#"><?=$current_region_name?></a></p>
                                    <div class="popup" id="footer-popup">
                                        <ul>
                                           <?=$str?>
                                        </ul>
                                        <a href="#" class="close">&times;</a>
                                    </div>
                                </div>*/?>
                                <!-- /noindex -->
                              <?endif;?>
                            </div>
                            <div class="halfMin">
                            <?php if (isset($this->_datas['all_devices'])) { ?>
                                <p class="title">Обслуживание и ремонт<p>
                                      <ul class="links-list">
                                         <? foreach ($this->_datas['all_devices'] as $devices)
                                         {
                                            $st_url = "/".$accord[$devices['type']]."/";
                                            $v = tools::mb_ucfirst($devices['type_m']);
                                            if ($url == $st_url)
                                                echo '<li><span class="active">'.$v.'</span></li>';
                                            else
                                                echo '<li><a href="'.$st_url.'">'.$v.'</a></li>';
                                         }
                                         ?>
                                    </ul>
                            <?php } ?>
                          </div>

                            <div class="halfMin">
                                <p class="title">Обратная связь</p>
                                    <ul class="links-list overflow-hidden mb-25">
                                    <?
                                        $array = array("/zakaz/" => "Записаться", "/sprosi/" => "Задать вопрос");
                                        if ($status) $array["/status/"] = "Статус заказа";

                                        foreach ($array as $key => $value)
                                        {
                                            if ($url == $key)
                                                echo '<li><span class="active">'.$value.'</span></li>';
                                            else
                                                echo '<li><a href="'.$key.'">'.$value.'</a></li>';
                                         }
                                    ?>  
                                    </ul>
                            </div>

                        </div>

                    </div>

                </div>

                <div class="wrapper footer__line">

                </div>

                <div class="wrapper dgray">

                    <div class="fixed">

                        <div class="footer__bottom">

                            <?php if ($url != '/politika/') { ?><a href="/politika/" class="politica" rel="nofollow">Политика обработки персональных данных</a><?php } ?>

                            <div class="footer__bottom__copy">
								<?php if ($marka == 'Sony') { ?>
									<p>Сервисный центр CENTRE - обслуживание Сони
										<br> © <?=date("Y")?>. Все права защищены
									</p>
								<?php } elseif ($marka == 'Xiaomi') { ?>
									<p>Centre - сервисный центр по ремонту <?=$marka?>
										<br> © <?=date("Y")?>. Все права защищены
									</p>
								<?php } else { ?>
									<p>Сервисный центр 
									  <?php
										  if (isset($marka_lower) && $marka_lower == 'nikon')
											echo $this->_datas['servicename'].' <span style="text-transform: none;">не является официальным сервисным центром Nikon</span>';
										  else
											echo $this->_datas['servicename'];
										?>
										<br> © <?=date("Y")?>. Все права защищены
									</p>
								<?php } ?>
                            </div>

                            <?php /*<div style="margin-left: 410px;">
                                <img src="/bitrix/templates/centre/img/master.png" width="50" height="30" style="margin-right: 1em;"/>
                                <img src="/bitrix/templates/centre/img/visa.png" width="98" height="30"/>
                            </div>*/?>

                        </div>

                    </div>

                </div>

            </footer>

        </div>

       <input type="hidden" name="mail" value="<?=$mail?>">
       <? if ($metrica && !$this->_datas['isAMP']  ):?>
               <script type="text/javascript"> (function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter<?=$metrica?> = new Ya.Metrika({ id:<?=$metrica?>, clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true }); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = "https://mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks"); </script> <noscript><div>
                       <img src="https://mc.yandex.ru/watch/<?=$metrica?>" style="position:absolute; display: none; left:-9999px;" alt="" />
                   </div></noscript>
       <?endif;?>

</body>

</html>
