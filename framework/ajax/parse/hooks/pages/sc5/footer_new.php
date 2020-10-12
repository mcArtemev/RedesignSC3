<? 
use framework\tools;

$marka = $this->_datas['marka']['name'];
$marka_lower = mb_strtolower($marka);   
$phone = $this->_datas['phone'];
$phone_format = tools::format_phone($this->_datas['phone'], true);
$metrica = $this->_datas['metrica'];
$analytics = $this->_datas['analytics'];

$url = ($this->_datas['arg_url'] != '/') ? '/'.$this->_datas['arg_url'].'/' : '/';

$mail = $this->_datas['partner']['email'];
if ($mail == 'litovchenko@list.ru') {
	$mail = '';
}

$feed = tools::gen_feed($this->_datas['site_name']);
$rand_devices = tools::get_rand($this->_datas['all_devices'], $feed);

$use_choose_city = $this->_datas['use_choose_city'];
$address_choose = $this->_datas['address_choose'];
$city = $this->_datas['find_city']; 
    
?>
    <footer class="inner-page gray font-color-gray">
         <div class="container">
                <div class="grid-12 flex-row margin-top margin-bottom flex-start footer-wrapper">
                    <div>                        	
                        <span class="logo <?=$marka_lower?> flex-row">
                            <img class="padding-little-right" src="https://<?=$this->_datas['realHost']?>/bitrix/templates/remont/images/<?=$marka_lower?>/logo.png">
                            <p class="logo-title font-little auto-line margin-left-little">Сервисный центр<br /><?=$marka?></p>
                        </span>                           
                    </div>
                    <div class="font-little footer-about padding-medium-right padding-medium-left">
                        <p>- записаться на ремонт в сервис центр</p>
                        <p>- вызвать бесплатного курьера</p>
                        <p>- получить консультацию специалиста</p>
                        <p>- скачать промокод или получить в sms</p>
                    </div>
                    <div class="align-right">
                        <p class="font-little display-sm">Сервисный центр <?=$marka?></p>
                    
                        <? if (!$use_choose_city):?><a href="tel:+<?=$phone?>" class="font-medium"><?=$phone_format?></a><?endif;?>
                    <? if (!$this->_datas['partner']['exclude']) : ?>
                        <p class="font-little"><?=$this->_datas['region']['name'] . (($this->_datas['partner']['address2']) ? ', ' . $this->_datas['partner']['address2'] : 
                                        ($this->_datas['partner']['address1'] ? ', ' . $this->_datas['partner']['address1'] : ''))?></p>
                    <? endif; ?>                
                    </div>
                </div>
                <!--noindex-->
                <div class="grid-12 align-center font-very-little margin-bottom-little footer-copy">
                    <p>Copyright © <?=date('Y')?>. Копирование и использование информации и материалов сайта запрещено. Сайт носит информационный характер и ни при каких условиях не является офертой.<br />
                        Товарные знаки, торговые марки, фирменные обозначения используемые на сайте, принадлежат производителю и не являются собственностью сервисного центра.</p>
                </div>
                <!--/noindex-->
         </div>
    </footer>
    
     <div class="modal fade" id="callback" tabindex="-1">
     
            <div class="modal-content padding-modal">
            
                <p id="default" class="auto-line"><span class="title-middle">Запишитесь на ремонт</span><br /><span class="title-tip font-little">и мы свяжемся с вами в течении 3х минут</span></p>
                
                <p id="good" class="title-middle align-center margin-bottom-little">Отлично!</p>
                <p id="double-title" class="title-middle align-center margin-bottom-little">Попробуйте позже</p>
                <p id="bravo" class="title-middle align-center margin-bottom-little">Поздравляем!</p>
                
                <form>
                    <div class="form-send">
                        <div class="margin-bottom-little margin-top">
                            <input name="tel" type="tel" class="font-button inputbox" placeholder="телефон*"/>  
                            <p id="error" class="margin-bottom-very-little font-tip font-color-gray">укажите телефон</p>
                            <p class="margin-bottom-very-little font-tip font-color-gray">пример: +7 (926) 123-45-67</p>
                            
                            <input name="name" type="text" class="font-button inputbox margin-top-little-sm" placeholder="имя"/>
                            <p class="margin-bottom-very-little font-tip font-color-gray">пример: Сидоров Иван Петрович</p>                            

                            <select name="type" data-placeholder="тип устройства">                            
                                <option></option>
                                <? foreach ($this->_datas['all_devices'] as $key => $device): ?>
                                    <option><?=$device['type']?></option>
                                <?endforeach;?>    
                            </select>
                            <p class="margin-bottom-very-little font-tip font-color-gray">пример: <?=$rand_devices['type']?></p>
                            
                            <? if ($use_choose_city):?>
                                <select name="city" data-placeholder="регион" class="green">
                                    <? foreach ($address_choose as $key => $value): 
                                        $selected = ($value['region_name'] == $city) ? ' selected' : '';?>
                                        <option<?=$selected?>><?=$value['region_name']?></option>
                                    <?endforeach;?>    
                                </select>
                                <p class="margin-bottom-very-little font-tip font-color-gray">пример: <?=$city?></p>
                            <?endif;?>
                                                                                                                        
                            <textarea rows="3" name="comment" class="font-button inputbox margin-top-little-sm" placeholder="ваша неисправность"></textarea>
                            <p class="font-tip font-color-gray">пример: <?=$default_textarea_tip?></p>
                        </div>
                        
                        <div class="flex-row">
                            <p class="font-tip font-color-gray auto-line" id="promo-tip">*промокод будет привязан к указанному номеру телефона</p>
                            <p class="font-tip font-color-gray auto-line" id="license-tip">отправляя заявку вы даете согласие на обработку персональных данных</p>
                            <button type="submit" class="font-button button <?=$marka_lower?>">записаться на ремонт</button>
                        </div>
                    </div>
                    
                    <div class="form-double">
                        <p class="font-little" id="double">Вы уже <span id="double-text">отправляли заявку или получали промокод</span>.<br /><br />
                            Повторно <span id="double-tip">это можно сделать</span> через <span id="second">30 секунд</span>.</p>
                    </div>
                    
                    <div class="form-success">
                        <p class="font-little" id="success">Наш специалисты получили заявку и уже приступили к ее обработке.<br /><br />Всего 3 минуты и мы свяжемся с вами.</p>
                    </div>
                    
                    <i class="fa fa-spinner fa-pulse spinner"></i>    
                </form>                      
                    
                <button type="button" class="close font-button" data-dismiss="modal" title="закрыть"><i class="fa fa-times"></i></button>
                </div>                
            </div>
        </div>
    
    <input type="hidden" name="mail" value="<?=$mail?>">
    <input type="hidden" name="yandex-zoom" id="yandex-zoom" value="<?=$this->_datas['zoom']?>">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://<?=$this->_datas['realHost']?>/bitrix/templates/remont/js/bootstrap.min.js"></script>
    <script src="https://<?=$this->_datas['realHost']?>/bitrix/templates/remont/js/jquery.maskedinput.min.js"></script>
    <script src="https://<?=$this->_datas['realHost']?>/bitrix/templates/remont/js/promo.js"></script>
    <script src="https://<?=$this->_datas['realHost']?>/bitrix/templates/remont/js/select2.full.min.js"></script>
    <script src="https://<?=$this->_datas['realHost']?>/bitrix/templates/remont/js/map.js"></script>

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
<? endif;?>
    
    
    
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
     
    </body>
</html>