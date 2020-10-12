<?
use framework\tools;
use framework\pdo;

$marka = $this->_datas['marka']['name'];
$marka_lower = mb_strtolower($marka);
$marka_ru =  $this->_datas['marka']['ru_name'];
$marka_full = ($marka_lower == 'hp') ? 'Hewlett<br>Packard' : '';
$phone = tools::format_phone($this->_datas['phone']);
$metrica = $this->_datas['metrica'];
$analytics = $this->_datas['analytics'];

$addresis = $this->_footer_addresis(array('Москва', 'Нижний Новгород', 'Санкт-Петербург', 'Екатеринбург'), 4);

$mail = $this->_datas['partner']['email'];
if ($mail == 'litovchenko@list.ru') {
	$mail = '';
}

//$accord = array('смартфон' => 'telefonov', 'ноутбук' => 'notebooks', 'планшет' => 'planshetov', 'фотоаппарат' => 'foto');
$accord = $this->_datas['accord_url'];

$url = ($this->_datas['arg_url'] != '/') ? '/'.$this->_datas['arg_url'].'/' : '/';
$add = '';
if ($marka_lower == 'sony') $add = ' style="margin-top: 10px"';

?>
        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-xs-6 displayLille">
                        <div class="logo <?=$marka_lower?>">
                            <a  href="/">
                                <img src="/bitrix/templates/remont/images/<?=$marka_lower?>/logo.png"<?=$add?>>
                            </a>
                            <div class="slogan displaySmaller">
                                Сервисный центр<br> <?=$marka?> в <?=$this->_datas['region']['name_pe']?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xs-12">
                        <div class="phone">
                            <a href="tel:+<?=tools::cut_phone($phone)?>" id="mango"><?=$phone_format?></a>
                            <a href="#" class="link callback-modal">заказать обратный звонок</a>
                        </div>
                    </div>

                </div>
            </div>
            <div class="container">
                <div class="row footer-menu-block mt-20">
                    <div class="columns two">
                        <ul>
                            <?

                            foreach ($this->_datas['menu'] as $key => $value)
                            {
                                if ($url == $key)
                                    echo '<li class="active"><span>'.$value.'</span></li>';
                                else
                                    echo '<li><a href="'.$key.'">'.$value.'</a></li>';
                            }
                            ?>
                        </ul>
                    </div>
                    <div class="columns three">
                        <ul>
                            <?
                            $apple_device_type = array('ноутбук' => 'MacBook', 'планшет' => 'iPad', 'смартфон' => 'iPhone');
                            
                            foreach ($this->_datas['all_devices'] as $device)
                            {
                                
                                $s_path = '/remont-'.$accord[$device['type']].'-'.$marka_lower.'/';
                                if ($marka_lower == 'apple')
                                {
                                    if ($url == $s_path)
                                        echo '<li class="active"><span>Ремонт '.(isset($apple_device_type[$device['type']]) ? $apple_device_type[$device['type']] : $device['type_rm']).'</span></li>';
                                    else
                                        echo '<li><a href="'.$s_path.'">Ремонт '.(isset($apple_device_type[$device['type']]) ? $apple_device_type[$device['type']] : $device['type_rm']).'</a></li>';
                                }
                                else
                                {
                                    if ($url == $s_path)
                                        echo '<li class="active"><span>Ремонт '.$device['type_rm']. ' ' . $marka .'</span></li>';
                                    else
                                        echo '<li><a href="'.$s_path.'">Ремонт '.$device['type_rm'].' ' . $marka .'</a></li>';
                                }
                            }

                            ?>
                        </ul>
                        <? if(empty($this->_datas['original_setka_id']) || $this->_datas['original_setka_id'] !=20):
                            $btn = false;
                            foreach ($this->_datas['all_devices'] as $device){
                            	if (in_array($device['type'],['ноутбук','смартфон','планшет'])){
                                    $btn = true;
                                    break;
                                }
                            }
                        
                            if($btn === true):?>
                                <!-- noindex -->
                                <? if ($this->_datas['arg_url'] == 'zamena-ekrana-'.$marka_lower) :?>
                                    <span class="button <?=$marka_lower?> active" style="cursor: default">Замена экрана</span>
                                <?else:?>
                                    <a href="/zamena-ekrana-<?=$marka_lower?>/" class="button <?=$marka_lower?>">Замена экрана</a>
                                <?endif;?>
                                <!-- /noindex -->
                            <?endif;?>
                        <?endif;?>
                    </div>
                <?php if(!empty($addresis[0])): ?>
                    <div class="columns seven footer-addresis">
                    <!-- noindex -->
                        <?
                        $left = $right = '';

                        $i = 0;
                        $mobile_str = '';

                            foreach ($addresis as $key => $value) {
                                if(!empty($value)){
                                    $address = $value['address2'] ? $value['address2'] : $value['address1'];
    
                                    $v = (($value['region_name']) ? $value['region_name'] : 'Москва') . '<br>+' . tools::format_phone($value['phone']);
    
                                    $str = '<div class="contacts-block">';
    
                                    if ($value['site'] !== $this->_datas['site_name'] && $this->_datas['realHost'] == $this->_datas['site_name']) {
                                        $str .= '<a href="https://' . $value['site'] . ($url) . '">' . $v . '</a>';
                                    } else {
                                        $str .= $v;
                                        $mobile_str = $v;
                                    }
    
                                    $str .= '<!--<br>Работаем без выходных <strong>с 10:00 до 20:00</strong>-->
                                            </div>';
    
                                    if ($i % 2 == 0)
                                        $left .= $str;
                                    else
                                        $right .= $str;
                                    $i++;
                                }
                            }


                        echo $left,$right ;?>
                        <!-- /noindex -->
                    </div>
                <?php endif;?>
                </div>
                <!--noindex-->
                <div class="footer-copy">
                    <div class="ssl"><img src="/bitrix/templates/remont/images/shared/comodo_secure_seal.png"></div>
                    <p>Copyright © <?=date('Y')?>. Копирование и использование информации и материалов сайта запрещено. Сайт носит информационный характер и ни при каких условиях не является офертой.
                        Товарные знаки, торговые марки, фирменные обозначения используемые на сайте, принадлежат производителю и не являются собственностью сервисного центра.</p>
                </div>
                <!--/noindex-->
            </div>
        </footer>

        <?php include __DIR__.'/form.php'; ?>

        <input type="hidden" name="mail" value="<?=$mail?>">
        <input type="hidden" name="yandex-zoom" id="yandex-zoom" value="<?=$this->_datas['zoom']?>">

        <?//<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>?>
<!--        <script type="text/javascript" src="/bitrix/templates/remont/js/main.min.js"></script>-->
<!--        <script type="text/javascript" src="/bitrix/templates/remont/js/metrika.min.js"></script>-->

        <script src="https://kit.fontawesome.com/aa0ec93a29.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="/bitrix/templates/remont/js/bootstrap.min.js"></script>
        <script src="/bitrix/templates/remont/js/select2.full.min.js"></script>
        <script src="/bitrix/templates/remont/js/jquery.maskedinput.min.js"></script>
        <script src="/bitrix/templates/remont/src/js/owl.carousel.min.js"></script>

        <?php
            $needMap = ['/', 'company/contacts'];

            if (in_array($this->_datas['arg_url'], $needMap)) :; ?>
                <script src="/bitrix/templates/remont/js/map.js"></script>
        <?php endif; ?>

        <script src="/bitrix/templates/remont/js/promo.js"></script>
        <script src="/bitrix/templates/remont/js/custom.js"></script>

    <?php if(!empty($metrica)):?>
        <!-- Yandex.Metrika counter -->
        <script type="text/javascript" >
            (function (d, w, c) {
                (w[c] = w[c] || []).push(function() {
                    try {
                        w.yaCounter<?=$metrica?> = new Ya.Metrika2({
                            id:<?=$metrica?>,
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
            options = {};
            options.YaMetrikId = <?=$metrica?>;
        </script>
        <noscript><div><img src="https://mc.yandex.ru/watch/<?=$metrica?>" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
        <!-- /Yandex.Metrika counter -->
    <?endif;?>
        <?php if (!empty($analytics)) { ?>
        <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
            ga('create', '<?=$analytics?>', 'auto');
            ga('send', 'pageview');
        </script>
        <?php } ?>
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
        <?php if (!empty($this->_datas['mail_counter'])) :;?>
            <!-- Rating@Mail.ru counter -->
            <script type="text/javascript">
                var _tmr = window._tmr || (window._tmr = []);
                _tmr.push({id: "<?php echo $this->_datas['mail_counter']; ?>", type: "pageView", start: (new Date()).getTime(), pid: "USER_ID"});
                (function (d, w, id) {
                    if (d.getElementById(id)) return;
                    var ts = d.createElement("script"); ts.type = "text/javascript"; ts.async = true; ts.id = id;
                    ts.src = "https://top-fwz1.mail.ru/js/code.js";
                    var f = function () {var s = d.getElementsByTagName("script")[0]; s.parentNode.insertBefore(ts, s);};
                    if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); }
                })(document, window, "topmailru-code");
            </script><noscript><div>
                    <img src="https://top-fwz1.mail.ru/counter?id=<?php echo $this->_datas['mail_counter']; ?>;js=na" style="border:0;position:absolute;left:-9999px;" alt="Top.Mail.Ru" />
                </div></noscript>
            <!-- //Rating@Mail.ru counter -->
        <?php endif; ?>
    </body>
</html>
