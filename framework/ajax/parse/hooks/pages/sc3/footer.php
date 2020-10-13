<?
use framework\tools;
use framework\pdo;

$marka = $this->_datas['marka']['name'];
$marka_lower = mb_strtolower($marka);
$_marka_lower = tools::translit($marka, '_');

$mail = $this->_datas['partner']['email'];
if ($mail == 'litovchenko@list.ru') {
	$mail = '';
}
$metrica = $this->_datas['metrica'];
$mail_counter = $this->_datas['mail_counter'];

$accord = array('смартфон' => 'telefonov', 'ноутбук' => 'noutbukov', 'планшет' => 'planshetov');

$url = ($this->_datas['arg_url'] != '/') ? '/'.$this->_datas['arg_url'].'/' : '/';

$address = $this->_datas['region']['name'].', '.$this->_datas['partner']['address1'];

$addresis = $this->_datas['addresis'];

$swap_key = false;
foreach ($addresis as $key => $value)
{
    if ($value['site'] == $this->_datas['site_name'])
    {
        $swap_key = $key;
        break;
    }
}

$typeMarkas = $this->_datas['typeMarkas'];

if ($swap_key !== false)
{
    $t = $addresis[$swap_key];
    unset($addresis[$swap_key]);
    array_unshift($addresis, $t);
}

if (in_array($this->_datas['region']['name'], ['Новосибирск', 'Нижний Новгород', 'Екатеринбург', 'Казань', 'Санкт-Петербург', 'Москва'])) {
  $this->_datas['menu_footer'] = array(
      '/diagnostika_'.$marka_lower.'/' => 'Диагностика',
      '/zapchasti_'.$marka_lower.'/' => 'Комплектующие',
      '/neispravnosti_'.$marka_lower.'/' => 'Неисправности',
      '/dostavka/' => 'Доставка',
      '/vakansii/' => 'Вакансии',
      '/kontakty/' => 'Контакты',
  );
}

if (in_array($this->_datas['region']['name'], ['Новосибирск', 'Нижний Новгород', 'Екатеринбург', 'Казань', 'Санкт-Петербург', 'Москва']) && in_array($url, ['/dostavka/', '/vakansii/', '/o_nas/', '/kontakty/'])) {
  $this->_datas['menu_footer'] = array(
      #'/diagnostika_'.$marka_lower.'/' => 'Диагностика',
      #'/zapchasti_'.$marka_lower.'/' => 'Комплектующие',
      #'/neispravnosti_'.$marka_lower.'/' => 'Неисправности',
      '/dostavka/' => 'Доставка',
      '/vakansii/' => 'Вакансии',
      '/kontakty/' => 'Контакты',
  );
}

?>

        <div class="footerrow">
            <div class="container">
                <div class="footerflex">
                    <div class="footeritem">
                        <div class="footertitle">Услуги сервиса</div>
                          <?php if (in_array($this->_datas['region']['name'], ['Новосибирск', 'Нижний Новгород', 'Екатеринбург', 'Казань', 'Санкт-Петербург', 'Москва']) && in_array($url, ['/dostavka/', '/vakansii/', '/o_nas/', '/kontakty/'])) { ?>
                            <div class="panel-group" id="types-accordion">

                            <?php foreach ($this->_datas['all_devices_site'] as $type) { ?>
                              <div class="contacttable panel">
                                <div class="contacttitle collapsed" data-toggle="collapse"
                                       data-target="#types-<?=$type['type_id']?>" data-parent="#types-accordion"><?=tools::mb_ucfirst($type['type_m'])?></div>
                                       <div class="collapse" id="types-<?=$type['type_id']?>">
                                  <? foreach ($typeMarkas[$type['type_id']] as $brand):
                                      $s_path = '/remont_'.$accord[$type['type']].'_'.mb_strtolower($brand).'/';
                                      echo '<p><a href="'.$s_path.'">'.$brand.'</a></p>';
                                      endforeach; ?>
                                    </div>
                                  </div>
                            <?php } ?>
                          </div>
                          <?php } else { ?>
                            <ul class="footermenu">
                            <? foreach ($this->_datas['all_devices'] as $device):
                                $s_path = '/remont_'.$accord[$device['type']].'_'.$_marka_lower.'/';
                                if ($url == $s_path)
                                    echo '<li class="selected"><span>Ремонт '.$device['type_rm'].'</span></li>';
                                else
                                    echo '<li><a href="'.$s_path.'">Ремонт '.$device['type_rm'].'</a></li>';
                             endforeach; ?>
                           </ul>
                          <?php } ?>
                        <div class="footertitle margin">Клиентам</div>
                        <ul class="footermenu">
                            <? foreach ($this->_datas['menu_footer'] as $key => $value):
                                if ($url == $key)
                                    echo '<li class="selected"><span>'.$value.'</span></li>';
                                else
                                    echo '<li><a href="'.$key.'">'.$value.'</a></li>';
                            endforeach; ?>
                        </ul>
                    </div>
                    <div class="footeritem contact-map">
                        <div class="footertitle">контакты</div>
                        <div class="contact-content">
                            <div class="panel-group" id="cnt-accordion">
                              <? $i =0;
                                 foreach ($addresis as $value):
                                    $v = ($value['region_name']) ? $value['region_name'] : 'Москва';
                                    $address = $value['address2'] ? $value['address2'] : $value['address1'];
                                    $urlSite = preg_replace('/^([a-z]+\.)([a-z]+\.support)/', '$2', $value['site']); ?>

                                  <div class="contacttable panel">

                                        <? if ($i): ?>

                                         <div class="contacttitle collapsed" data-toggle="collapse"
                                                data-target="#cnt-<?=$i?>" data-parent="#cnt-accordion" data-x="<?=$value['x']?>" data-y="<?=$value['y']?>"><?=$v?></div>

                                            <div class="collapse" id="cnt-<?=$i?>">
                                                <p><a href="http://<?=$urlSite?><?=($url)?>"><?=tools::format_phone($value['phone'])?></a></p>

                                        <? else :?>

                                         <div class="contacttitle" data-toggle="collapse"
                                                data-target="#cnt-<?=$i?>" data-parent="#cnt-accordion" data-x="<?=$value['x']?>" data-y="<?=$value['y']?>"><?=$v?></div>

                                            <div class="collapse in" id="cnt-<?=$i?>">
                                                <p><?=tools::format_phone($value['phone'])?></p>
                                                
                                        <?endif;?>
                                        
                                        </div>
                                  </div>
                              <?  $i++;
                                 endforeach; ?>
                              </div>

                              <div id="cnt-map"></div>
                        </div>
                        <div class="footerpolitics"><a href="/politics.pdf"><img src="/templates/moscow/img/shared/pdf-icon.png">Политика</a></div>
                      </div>
                 </div>
             </div>
          </div>
        </div>
        <input type="hidden" name="mail" value="<?=$mail?>">

        <div class = "overlay">
          <div class = "modalBlock">
            <div class = "imagerow">
              <div class = "imageabs">
                <i class="fa fa-times modalClose" aria-hidden="true"></i>
                <div class = "modalTitle">Заказать обратный звонок</div>
                <form class="imageform">
                    <div class="inputform">
                        <input type="text" name="name" placeholder="Ваше имя">
                    </div>
                    <div class="inputform inputformreq">
                        <input type="tel" placeholder="Контактный телефон">
                        <span class="input-error">Заполните ваш телефон</span>
                    </div>
                    <input type="submit" class="inputbutton" value="Записатся" id="submit">
                </form>
                <div class="successMessage">
                  <i class="fa fa-check" aria-hidden="true"></i>
                  Форма отправлена. В ближайшее время вам перезвонит наш консультант.
                </div>
              </div>
            </div>
          </div>
        </div>

        <script type="text/javascript" async src="/min/f=/templates/moscow/js/jquery.min.js,/templates/moscow/js/bootstrap.min.js,/templates/moscow/js/jquery.maskedinput.js,/templates/moscow/js/main.js,/templates/moscow/js/kontakty.js&123456"></script>
        <script src="//api-maps.yandex.ru/2.0/?load=package.standard,package.geoObjects&amp;lang=ru-RU" type="text/javascript"></script>

        <!-- Rating@Mail.ru counter -->
        <script type="text/javascript">
        var _tmr = window._tmr || (window._tmr = []);
        _tmr.push({id: "<?=$mail_counter?>", type: "pageView", start: (new Date()).getTime()});
        (function (d, w, id) {
          if (d.getElementById(id)) return;
          var ts = d.createElement("script"); ts.type = "text/javascript"; ts.async = true; ts.id = id;
          ts.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//top-fwz1.mail.ru/js/code.js";
          var f = function () {var s = d.getElementsByTagName("script")[0]; s.parentNode.insertBefore(ts, s);};
          if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); }
        })(document, window, "topmailru-code");
        </script><noscript><div style="position:absolute;left:-10000px;">
        <img src="//top-fwz1.mail.ru/counter?id=<?=$mail_counter?>;js=na" style="border:0;" height="1" width="1" alt="Рейтинг@Mail.ru" />
        </div></noscript>
        <!-- //Rating@Mail.ru counter -->

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
        <noscript><div><img src="https://mc.yandex.ru/watch/<?=$metrica?>" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
        <!-- /Yandex.Metrika counter -->

        <!-- Yandex.Metrika counter -->
        <script type="text/javascript">
            (function (d, w, c) {
                (w[c] = w[c] || []).push(function() {
                    try {
                        w.yaCounter43649849 = new Ya.Metrika({
                            id:43649849,
                            clickmap:true,
                            trackLinks:true,
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
        <noscript><div><img src="https://mc.yandex.ru/watch/43649849" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
        
		<?php if (!empty($this->_datas['piwik'])) { ?>
			<script type="text/javascript">
			var _paq = _paq || [];
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
		<?php } ?>
        
        <? if (mb_strpos($this->_datas['site_name'], 'peterburg') !== false):?>
            <script type="text/javascript">!function(){var t=document.createElement("script");t.type="text/javascript",t.async=!0,t.src="https://vk.com/js/api/openapi.js?160",t.onload=function(){VK.Retargeting.Init("VK-RTRG-358213-Jztb"),VK.Retargeting.Hit()},document.head.appendChild(t)}();</script><noscript><img src="https://vk.com/rtrg?p=VK-RTRG-358213-Jztb" style="position:fixed; left:-999px;" alt=""/></noscript>
        <?endif;?>
        
    </body>
</html>
