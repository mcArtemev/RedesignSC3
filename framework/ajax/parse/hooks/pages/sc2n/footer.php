<?
use framework\tools;
use framework\pdo;

$marka = $this->_datas['marka']['name']; 
$marka_lower = mb_strtolower($marka);

$analytics = $this->_datas['analytics'];
$metrica = $this->_datas['metrica'];
$mail = $this->_datas['partner']['email'];
if ($mail == 'litovchenko@list.ru') {
	$mail = '';
}

$accord = $this->_datas['accord'];
$url = ($this->_datas['arg_url'] != '/') ? '/'.$this->_datas['arg_url'].'/' : '/'; 

$addresis = $this->_datas['addresis'];

$footer_1 = true;
if ($this->_datas['setka_name'] == 'СЦ-2' && (($marka_lower == 'samsung') || ($marka_lower == 'nikon') || ($marka_lower == 'sony')))
    $footer_1 = false;

$footer_add_style = '';    
if ($url == '/contacts/requisites/')
{
    $footer_1 = false;
    $footer_add_style = ' style="position: fixed; bottom: 0; left: 0; width: 100%;"';
}

$status = '';
if (!in_array($marka_lower, array('canon', 'dell', 'nikon', 'toshiba')) && $this->_datas['region']['name'] == 'Москва')
{
    $status = ' class="menu-status"';
}

?>
        <footer class="footer"<?=$footer_add_style?>>

            <?php if(empty($this->_datas['region_name'])|| !empty($this->_datas['multiBrand'])):?>
                <div class="wrapper gray">

                    <div class="fixed">

                        <div class="footer__nav">

                            <ul<?=$status?>>
                                <? foreach ($this->_datas['menu'] as $key => $value)
                                {
                                    if ($url == $key)
                                        echo '<li><span class="active">'.$value.'</span></li>';
                                    else
                                        echo '<li><a href="'.$multiMirrorLink.$key.'">'.$value.'</a></li>';                                
                                 }  
                                ?>
                            </ul>

                        </div>

                    </div>

                </div>
            <?php endif; ?>    
                

                <div class="wrapper dgray">

                    <div class="fixed">
                    
                    <?php if(empty($this->_datas['region_name'])|| !empty($this->_datas['multiBrand'])):?>
                        <div class="footer__links">
                            
                        
                            <div class="halfMin">
                            <?php if($this->_datas['realHost'] !='customers.ru.com'):?>
                                <p class="title">Контактная информация<p>
                                <a class="footphone mango_id" href="tel:+<?=$this->_datas['phone']?>">+<?=tools::format_phone($this->_datas['phone'])?></a>
                                
                                <? 
                                    if ($footer_1)
                                    { 
                                        $str = '';
                                        $current_region_name = '';
                                        
                                        /*масив и условие в ифи ниже ( and !in_array($value['region_name'],$notWorkCities))
                                        является заглушкой до тех пор пока не будут развернуты сайты в эти города. Rat*/
                                        $notWorkCities =[
                                            "Ярославль","Томск","Барнаул","Ульяновск","Набережные Челны","Киров",
                                            "Курск","Магнитогорск","Брянск","Улан-Удэ","Иваново","Нижний Тагил",
                                            "Владимир","Чита","Калуга","Орёл","Смоленск","Йошкар-Ола","Иркутск",
                                            "Кемерово","Благовещенск","Новороссийск","Сыктывкар","Псков","Химки",
                                            "Балашиха","Домодедово",
                                        ];
                                        
                                        foreach ($addresis as $value)
                                        {
                                            $region_name = ($value['region_name']) ? $value['region_name'] : 'Москва';
                                            $v = $region_name;    
                                                                               
                                            $address = $value['address2'] ? $value['address2'] : $value['address1'];
                                            
                                            if ($value['site'] !== $this->_datas['site_name'] and !in_array($value['region_name'],$notWorkCities))
                                            {
                                                $str .= '<li>';
                                                $str .= '<a href="http://'.$value['site'].($url).'">'.$v.'</a>';
                                                //$str .= '<br>'.$address;
                                                $str .= '<br>+'.tools::format_phone($value['phone']);
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
                                <div id="popup-wrapper">
                                    <p>Мы в других городах: <a class="current-region" href="#"><?=$current_region_name?></a></p>
                                    <div class="popup" id="footer-popup">
                                        <ul>
                                           <?=$str?>
                                        </ul>
                                        <a href="#" class="close">&times;</a>
                                    </div>
                                </div>
                                <!-- /noindex -->
                              <?endif;?>  
                            <?php endif;?>
                            </div>
                        
                            
                            <div class="halfMin">
                                <p class="title">Обслуживание и ремонт<p>
                                    <ul class="links-list"> 
                                         <? foreach ($this->_datas['all_devices'] as $devices)
                                         {
                                            $st_url = "/".$accord[$devices['type']]."/";
                                            // $v = tools::mb_ucfirst($devices['type_m']);
                                            $v = tools::mb_ucfirst($devices['type']);
                                            if ($url == $st_url)
                                                echo '<li><span class="active">'.$v.'</span></li>';
                                            else
                                                echo '<li><a href="'.$multiMirrorLink.$st_url.'">'.$v.'</a></li>';
                                         }
                                         ?>
                                    </ul>
                            </div>
                            
                            <div class="halfMin">
                                <p class="title">Обратная связь</p>
                                    <ul class="links-list" style="overflow: hidden; margin-bottom: 25px;">
                                    <?
                                        $array = array("/order/" => "Запись на ремонт", "/ask/" => "Задать вопрос");
                                        if ($status) $array["/status/"] = "Статус заказа";
                                        
                                        foreach ($array as $key => $value)
                                        {
                                            if ($url == $key)
                                                echo '<li><span class="active">'.$value.'</span></li>';
                                            else
                                                echo '<li><a href="'.$multiMirrorLink.$key.'">'.$value.'</a></li>';                                
                                         } 
                                    ?>
                                        <!--<li><a href="/order/">Запись на ремонт</a></li>
                                        <li><a href="/ask/">Задать вопрос</a></li>-->
                                    </ul>
                            </div>                        

                        </div>
                    <?php endif; ?>     

                    </div>

                </div>

                <div class="wrapper footer__line">

                </div>

                <div class="wrapper dgray">

                    <div class="fixed">

                        <div class="footer__bottom">
                            <?php if ($this->_datas['realHost'] !='customers.ru.com'):?>

                            <!--noindex--><a href="<?=$multiMirrorLink?>/politica/" class="politica" rel="nofollow">Политика обработки персональных данных</a><!--/noindex-->
                            <?php endif;?>
                            <div class="footer__bottom__copy">
                                <p><!--noindex-->Сервисный центр 
                                
                                <?php if ($this->_datas['realHost'] !='customers.ru.com'):?>
                                
                                    <?=($marka_lower != 'nikon') ? ' '.$this->_datas['marka']['name'] : ''?>
                                    <? if ($marka_lower == 'nikon') echo 'Nikon Centre <span style="text-transform: none;">не является официальным сервисным центром Nikon</span>';?>
                                <?php else:?>
                                 Remont Centre
                                <?php endif;?> 
                                
                                    <br> © <?=date("Y")?>. Все права защищены<!--/noindex--></p>

                            </div>
                            
                            <div style="margin-left: 410px;">
                                <img src="/img/master.png" width="50" height="30" style="margin-right: 1em;"/>
                                <img src="/img/visa.png" width="98" height="30"/>
                            </div>

                        </div>

                    </div>

                </div>

            </footer>

        </div>
        
       <input type="hidden" name="mail" value="<?=$mail?>">    
        <? if ($this->_datas['realHost'] == $this->_datas['site_name']):?> 
        <? if ($metrica):?>    
            <script type="text/javascript"> (function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter<?=$metrica?> = new Ya.Metrika({ id:<?=$metrica?>, clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true }); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = "https://mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks"); </script> <noscript><div><img src="https://mc.yandex.ru/watch/<?=$metrica?>" style="position:absolute; display: none; left:-9999px;" alt="" /></div></noscript> 
        <?endif;?>
    <?endif;?>
 <!--<script>
  /*(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', '<?=$analytics?>', 'auto');
  ga('send', 'pageview');*/
    
</script>-->     
 <script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-86304949-4', 'auto');
    ga('send', 'pageview');

</script>
	<?php if (!empty($this->_datas['piwik'])) { ?>
		<!-- Matomo -->
		<script type="text/javascript">
		var _paq = _paq || [];
		/* tracker methods like "setCustomDimension" should be called before "trackPageView" */
		_paq.push(['trackPageView']);
		_paq.push(['enableLinkTracking']);
		(function() {
			var u="/datastat/";
			_paq.push(['setTrackerUrl', u+'piwik.php']);
			_paq.push(['setSiteId', '<?=$this->_datas['piwik']?>']);
			var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
			g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
		})();
		</script>
		<noscript><p><img src="/datastat/piwik.php?idsite=<?=$this->_datas['piwik']?>&amp;rec=1" style="border:0;" alt="" /></p></noscript>
		<!-- End Matomo Code -->
	<?php } ?>
    
    <? if (mb_strpos($this->_datas['site_name'], 'spb') !== false):?>
        <script type="text/javascript">!function(){var t=document.createElement("script");t.type="text/javascript",t.async=!0,t.src="https://vk.com/js/api/openapi.js?160",t.onload=function(){VK.Retargeting.Init("VK-RTRG-358213-Jztb"),VK.Retargeting.Hit()},document.head.appendChild(t)}();</script><noscript><img src="https://vk.com/rtrg?p=VK-RTRG-358213-Jztb" style="position:fixed; left:-999px;" alt=""/></noscript>
    <?endif;?>
    </body>

</html> 