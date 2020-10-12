<?php
$types_array = [
	"монитор"     => ["display.jpg", "remont-monitorov"],
	"моноблок"    => ["all-in-one.jpg", "remont-monoblokov"],
	"ноутбук"     => ["laptop.jpg", "remont-noutbukov"],
	"планшет"  	  => ["tablet.jpg", "remont-planshetov"],
	"смартфон"    => ["phone.jpg", "remont-telefonov"],
	"проектор"    => ["projector.jpg", "remont-proektorov"],
	"фотоаппарат" => ["photo.jpg", "remont-fotoapparatov"],
	"принтер"     => ["mfu.jpg", "remont-printerov"],
	"компьютер"   => ["computer.jpg", "remont-kompyuterov"],
	"телевизор"   => ["tv.jpg", "remont-televizorov"]
];

use framework\tools;
use framework\pdo;

$metrica = $this->_datas['metrica'];
$analytics = $this->_datas['analytics'];
$marka = $this->_datas['marka']['name'];  // SONY
$marka_lower = mb_strtolower($marka);
$servicename = $this->_datas['servicename']; //SONY Russia
$ru_servicename = $this->_datas['ru_servicename']; //
$ru_marka = $this->_datas['marka']['ru_name']; // СОНИ
$region_name = $this->_datas['region']['name'];//Москва
$region_name_eng = $this->_datas['region']['translit2'];//Moscow
$region_name_pril = $this->_datas['region']['pril'];//Московского
$region_name_pe = $this->_datas['region']['name_pe'];//в Москве (в Владивостоке)
$region_name_de = $this->_datas['region']['name_de'];//по Москве (Владивостоку)
$region_name_re = $this->_datas['region']['name_re'];//служба Москвы (Владивостока)
$phone = $this->_datas['phone'];
$phone_format = tools::format_phone($phone);
$address = $this->_datas['partner']['address1'];
$address2 = $this->_datas['partner']['address2'];
$geo_google = $this->_datas['partner']['sid'];
$all_deall_devices = $this->_datas['all_devices'];
$menuf = $this->_datas['menuf'];
$menus = $this->_datas['menus'];
$menud = $this->_datas['menud'];
$urlm = ($this->_datas['arg_url'] != '/') ? '/'.$this->_datas['arg_url'].'/' : '/';
$addresis = $this->_datas['addresis'];
$site_id = $this->_site_id;
$marka_id = $this->_datas['marka']['id'];
$mail = $this->_datas['partner']['email'];
if ($mail == 'litovchenko@list.ru') {
	$mail = '';
}

srand($this->_datas['feed']);

$h2 = array();
if ($marka == 'RUSSUPPORT'){
 $h2[] = array("Консультация $marka по телефону","Бесплатные консультации от $marka","Горячая линия консультаций $marka",
    "Консультации $marka","Специалисты $marka на связи","Горячая линия $marka");   
} else {
$h2[] = array("Консультация $marka RUSSUPPORT по телефону","Бесплатные консультации от $marka RUSSUPPORT","Горячая линия консультаций $marka RUSSUPPORT",
    "Консультации $marka RUSSUPPORT","Специалисты $marka RUSSUPPORT на связи","Горячая линия $marka RUSSUPPORT");
}
$poslednii_abzats = array();
$poslednii_abzats_rand = rand(1,2);
if($poslednii_abzats_rand == 1)
{
    $poslednii_abzats[] = array("Заполняйте телефон","Заполняйте номер телефона","Заполняйте свой телефон","Заполняйте свой номер телефона","Заполняйте номер своего телефона");
    $poslednii_abzats[] = array("и отправляйте","и посылайте","и оставляйте");
    $poslednii_abzats[] = array("онлайн заявку -","online заявку -","онлайн заказ -","online заказ -","онлайн запрос -","online запрос -");
}
if($poslednii_abzats_rand == 2)
{
    $poslednii_abzats[] = array("Заполняйте телефон через онлайн форму","Заполняйте номер телефона через онлайн форму","Заполняйте свой телефон через онлайн форму",
        "Заполняйте свой номер телефона через онлайн форму","Заполняйте номер своего телефона через онлайн форму","Заполняйте телефон через online форму",
        "Заполняйте номер телефона через online форму","Заполняйте свой телефон через online форму","Заполняйте свой номер телефона через online форму","Заполняйте номер своего телефона через online форму");
    $poslednii_abzats[] = array("и отправляйте","и посылайте","и оставляйте");
    $poslednii_abzats[] = array("заявку -","заказ -","запрос -");
}

$poslednii_abzats[] = array("наши специалисты","наши операторы","наши сотрудники","сотрудники колл-центра","операторы колл-центра","специалисты колл-центра","сотрудники нашего колл-центра",
    "операторы нашего колл-центра","специалисты нашего колл-центра","сотрудники колл-центра  $marka","операторы колл-центра $marka",
    "специалисты колл-центра $marka", "сотрудники колл-центра  $marka","операторы колл-центра  $marka","специалисты колл-центра $marka");
$poslednii_abzats[] = array("проконсультируют по любым вопросам ремонта","проконсультируют по любым вопросам ремонта и обслуживания","проконсультируют по всем вопросам ремонта",
    "проконсультируют по всем вопросам ремонта и обслуживания","проведут консультацию по любым вопросам ремонта","проведут консультацию по любым вопросам ремонта и обслуживания",
    "проведут консультацию по всем вопросам ремонта","проведут консультацию по всем вопросам ремонта и обслуживания","ответят на любые вопросы по любым видам ремонта",
    "ответят на любые вопросы по любым видам ремонта и обслуживания","ответят на все вопросы по любым видам ремонта","ответят на все вопросы по любым видам ремонта и обслуживания",
    "проконсультируют по любым видам ремонта","проконсультируют по любым видам ремонта и обслуживания","проконсультируют по всем видам ремонта","проконсультируют по всем видам ремонта и обслуживания",
    "проведут консультацию по любым видам ремонта","проведут консультацию по любым видам ремонта и обслуживания","проведут консультацию по всем видам ремонта",
    "проведут консультацию по всем видам ремонта и обслуживания","ответят на вопросы по любым видам ремонта","ответят на вопросы по любым видам ремонта и обслуживания",
    "ответят на вопросы по всем видам ремонта","ответят на вопросы по всем видам ремонта и обслуживания");

	$cont_arr1 = array();
	$cont_arr2 = array();
	foreach ($addresis as $items)
	{
		if($region_name == $items['region_name'])
		{
			$cont_arr1[] = $items;
			break;
		}
	}
	foreach ($addresis as $items)
	{
		if($region_name != $items['region_name'])
		{
			if($items['region_name'] == "" || $items['region_name'] == "Санкт-Петербург" || $items['region_name'] == "Краснодар" || $items['region_name'] == "Воронеж " || $items['region_name'] == "Волгоград" || $items['region_name'] == "Тула" || $items['region_name'] == "Самара")
			{
				if(count($cont_arr1) < 6)
				{
					$cont_arr1[] = $items;
				}
				else
				{
					$cont_arr2[] = $items;
				}
			}
			else
			{
				$cont_arr2[] = $items;
			}
		}
		else
		{
			if($region_name != $items['region_name'])
			{
				$cont_arr2[] = $items;
			}
		}
	}

$use_choose_city = $this->_datas['use_choose_city'];

?>
<footer>
    <section class="showcase showcase-bottom">
        <div class="container showcase-inside">
            <div class="grid-6">
                <div class="showcase-info">
                    <div class="showcase-title"><?=$this->checkarray($h2)?></div>
                    <div class="showcase-text">
                        <p><?=$this->checkarray($poslednii_abzats)?>
                         <?php if(!empty($this->_datas['hab']) && !empty($this->_datas['hb'])) echo "плоттеров" ?>
                         <?php if(!empty($this->_datas['hab']) && !empty($this->_datas['hb'])): ?>
                            <!--<span class="phone-number">-->
                                или свяжитесь с нами: <br><a href="tel:<?=$phone;?>"><?=$phone_format;?></a>
                                <!--</span>-->
                            <?php endif; ?> 
                        </p>
                    </div>
                    
                       
                </div>
            </div>
            <div class="grid-5">
                <div class="block-form block-rel">
                    <button type="button" class="close x_pos">&times;</button>
                    <form class="block-form-inside">
                        <div class="send">
                            <div class="form-title">Бесплатная консультация</div>
                            <div class="form-input">
                                <input type="text" class="phone inputform"  placeholder="Телефон">
                                <i class="fa fa-question-circle"></i>
                                <div class="input-tooltip">Обязательное поле</div>
                            </div>
                            <div class="form-input">
                                <input type="text" class="name inputform" placeholder="Имя">
                            </div>
                            <div class="form-btn">
                                <div class="btn btn-accent btn-with-input">
                                    <input type="submit" value="Перезвоните мне">
                                </div>
                            </div>
                        </div>
                        <div class="success">
							<div class="block-text">
								<img src="/templates/russupport/img/success-512.png" style="width: 30%;" />
								<p>Спасибо за заявку,<br />мы свяжемся с вами в течении 15-30 минут.</p>
							</div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
<?php //if ($this->_datas['hb'] !== false || $this->_datas['hab'] !== false): ?>
    <section class="cities">
        <div class="container">
            <div class="grid-12">
                <div class="cities-inside">
                    <?foreach ($cont_arr1 as $key => $item):?>
                    <div class="item">
                        <div class="cities-name"><<?if ($key != 0){echo "a";}else{echo "span";}?> class="color-white" <?if ($key != 0):?>href="https://<?=$item["site"]?>"<?endif;?>><?if($item["region_name"] == ""){echo "Москва";}else{echo $item["region_name"];}?></<?if ($key != 0){echo "a";}else{echo "span";}?>></div>
                        <div class="cities-address"><?//if($item["address2"]){echo $item["address2"];}else{echo $item["address1"];}?></div>
                        <?
                        $phone_item = $item["phone"];
                        
                        if (mb_strpos($this->_datas['realHost'], 'rsupport.ru.com') !== false)
                        {
                            $phone_item = '78003015964';
                            if ($item["region_name"] == "Санкт-Петербург") $phone_item = '78126039538';  
                            if ($item["region_name"] == "") $phone_item  = '74950324977';        
                        }
                        ?>
                        <div class="cities-phone"><?=tools::format_phone($phone_item)?></div>
                        <!--<div class="cities-worktime"><?if(!$this->_datas['partner']['time']){echo "с 9:00 до 18:00 (без выходных)";}else{echo $this->_datas['partner']['time'];}?></div>-->
                    </div>
                    <?endforeach;?>
                </div>
                <div class="cities-inside" id="cont" style="display: none;">
                    <?foreach ($cont_arr2 as $key => $item):?>
                        <div class="item">
                            <div class="cities-name"><a class="color-white" href="https://<?=$item["site"]?>"><?if($item["region_name"] == ""){echo "Москва";}else{echo $item["region_name"];}?></a></div>
                            <div class="cities-address"><?//if($item["address2"]){echo $item["address2"];}else{echo $item["address1"];}?></div>
                            <?
                            $phone_item = $item["phone"];
                            
                            if (mb_strpos($this->_datas['realHost'], 'rsupport.ru.com') !== false)
                            {
                                $phone_item = '78003015964';
                                if ($item["region_name"] == "Санкт-Петербург") $phone_item = '78126039538';  
                                if ($item["region_name"] == "") $phone_item  = '74950324977';        
                            }
                            ?>
                            <div class="cities-phone"><?=tools::format_phone($phone_item)?></div>
                            <!--<div class="cities-worktime"><?if(!$item['time']){echo "с 9:00 до 18:00 (без выходных)";}else{echo $this->_datas['partner']['time'];}?></div>-->
                        </div>
                    <?endforeach;?>
                </div>
                <div class="else-city"><a class="btn btn-link-w" id ="apokewe">Показать ещё</a></div>
            </div>
        </div>
    </section>
<?php //endif; ?>    
    <section class="footer-bottom">
        <div class="container footer-menu-container">
            <div class="grid-12">
                <div class="footer-menu">
                    <div class="item">
                        <div class="footer-menu-title">Обслуживание и ремонт</div>
                        <ul class="footer-menu-list">
                        <?php
                            $columCount = '';
                            foreach ($menuf as $key => $value)
                            {
                                if ($urlm == $key){
                                    echo '<li><span>'.$value.'</span></li>';
                                }else{
                                    echo '<li><a href="'.$key.'">'.$value.'</a></li>';
                                }
                            }
                        ?>
                        <?
                        $showPC=[1,4,5,6];
                        
                            foreach ($all_deall_devices as $key => $value) {
                                if (isset ($value['type_id'])) {
                                   if (in_array($value['type_id'],$showPC)) {
                                    //echo '<li><a itemprop="url" href="/help-pc/">Компьютерная помощь</a></li>';
                                break;
                                }
                            }
                        }
                    
                       
                       ?>
                        </ul>
                    </div>
					<? if ($this->_datas['hab'] === false) { ?>
                    <div class="item">
                        <div class="footer-menu-title">Устройства</div>
                        <ul class="footer-menu-list">
                            <? 
                            //$all_deall_devices=array_unique($all_deall_devices, SORT_REGULAR);
                            foreach ($all_deall_devices as $item) {
                               
                              $urlDev = '/repair-' . $this->_datas['accord_image'][$item["type"]].'/'; 
                              if ($urlm != $urlDev) {?>
                            <li><a href="<?=$urlDev?>"><?echo $this->firstup($item['type']);?></a></li>
                          <? } else { ?>
                            <li><span><?echo $this->firstup($item['type']);?></span></li>
                            <?}}?>
                        </ul>
                    </div>
					<? } else { ?>
                        <? if ($this->_datas['hb'] === true) { ?>
                            <div class="item">
                                <div class="footer-menu-title">Устройства</div>
                                <ul class="footer-menu-list">
                                    <?
                                        foreach ($this->_datas['all_brands'] as $item) {
                                            $urlDev = "/remont-plotterov-".strtolower($item['brand_name'])."/";
                                            if ($urlm != $urlDev) { ?>
                                                <li><a href="<?=$urlDev?>"><?=$item['brand_name']?></a></li>
                                            <? } else { ?>
                                            <li><span><?=$item['brand_name']?></span></li>
                                            <? }
                                        }?>
                                </ul>
                            </div>
                        <? } else { 
                                if(count($this->_datas['all_brands'])>10 && count($this->_datas['all_brands'])<=20){
                                    $columCount = 'colum_count_two';
                                }
                                // elseif(count($this->_datas['all_brands'])>20 && count($this->_datas['all_brands'])<=30){
                                //     $columCount = 'colum_count_three';
                                // }
                                elseif(count($this->_datas['all_brands'])>20){
                                    $columCount = 'colum_count_three';
                                }
                        ?>
                            <div class="item">
                                <div class="footer-menu-title">Производители</div>
                                <ul class="footer-menu-list <?=$columCount?>">
                            <?php      foreach ($this->_datas['all_brands'] as $item) {
                                        $urlDev = "/repair-".$this->_datas['accord_image'][$this->_datas['all_devices'][0]['type']]."-".strtolower($item['brand_name'])."/";
                                        if ($urlm != $urlDev) { ?>
                                            <li><a href="<?=$urlDev?>"><?=$item['brand_name']?></a></li>
                                        <? } else { ?>
                                        <li><span><?=$item['brand_name']?></span></li>
                                        <? }
                                    }
                            ?>
                                </ul>
                            </div>
                        <? } ?>
					<? } ?>
                    <div class="item">
                        <div class="footer-menu-title">Информация</div>
                        <ul class="footer-menu-list">
                        <?php
                            foreach ($menus as $key => $value)
                            {
                                if ($urlm == $key){
                                    echo '<li><span>'.$value.'</span></li>';
                                }else{
                                    echo '<li><a href="'.$key.'">'.$value.'</a></li>';
                                }
                            }
                            // if(!empty($columCount)){
                            //     foreach ($menud as $key => $value)
                            //     {
                            //         if ($urlm == $key){
                            //             echo '<li><span>'.$value.'</span></li>';
                            //         }else{
                            //             echo '<li><a href="'.$key.'">'.$value.'</a></li>';
                            //         }
                            //     }
                            // }
                        ?>
                        </ul>
                    </div>
                    
                <?php /*if(empty($columCount)):*/ ?>
                    <div class="item">
                        <div class="footer-menu-title">Сервисный центр</div>
                        <ul class="footer-menu-list">
                        <?php
                        foreach ($menud as $key => $value)
                        {
                            if ($urlm == $key){
                                echo '<li><span>'.$value.'</span></li>';
                            }else{
                                echo '<li><a href="'.$key.'">'.$value.'</a></li>';
                            }
                        }
                            ?>
                        </ul>
                    </div>
                <?php /*endif;*/ ?>    
                </div>
            </div>
        </div>
        <div class="copyright">
            <div class="container">
                <div class="grid-12">
                    <div class="copy-text">
                        <? if ($urlm != '/'):?>
                            <a href="/#main">Сервисный центр <?=$marka?> в <?=$region_name_pe?></a>
                        <?else:?>
                            <span>Сервисный центр <?=$marka?> в <?=$region_name_pe?></span>
                        <?endif;?>
                        Официальный сайт сервисного центра <?=($servicename!='PARTNERSER')?strstr($servicename, ' '):$servicename; ?><br>
                        &copy; <?=date("Y")?>. Все права защищены. <a id="politics" href="#">Политика конфиденциальности</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</footer>

<? if ($use_choose_city):?>
<div class="modal modal-big fade" id="js_cityTop" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content ">
            <button type="button" class="close x_pos" data-dismiss="modal">&times;</button>
            <div class="modal-header">
                <div class="modal-title">Ваш город</div>
            </div>
            <div class="modal-body">
                <div class="block-form">
                    <ul class="city_list">
                        <? foreach ($address_choose as $value):
                        $region_name = ($value['region_name']) ? $value['region_name'] : 'Москва';?>
                        <li><a href="#" data-href="<?=$value['site']?>"><?=$region_name?></a></li>
                        <?endforeach;?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<?endif;?>
<?
    if ($this->_datas['arg_url'] != 'courses-repair'){
            include ('form-callback.php');
        }
        else {
            include ('form-callback-washmachine.php');
        }
   
?>    


<input type="hidden" name="mail" value="<?=$mail?>">
            <? if (!empty($metrica)):?>
                <input type = "hidden" name = "ymid" value = "<?=$metrica?>">
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
			<script type="text/javascript">
			var _paq = _paq || [];
			_paq.push(['trackPageView']);
			_paq.push(['enableLinkTracking']);
			(function() {
				var u="/trafic/";
				_paq.push(['setTrackerUrl', u+'piwik.php']);
				_paq.push(['setSiteId', '<?=$this->_datas['piwik']?>']);
				var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
				g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
			})();
			</script>
			<noscript><p><img src="/trafic/piwik.php?idsite=<?=$this->_datas['piwik']?>&amp;rec=1" style="border:0;" alt="" /></p></noscript>
		<?php } ?>
        
        <script>
        (function(w, d, s, h, id) {
            w.roistatProjectId = id; w.roistatHost = h;
            var p = d.location.protocol == "https:" ? "https://" : "http://";
            var u = /^.*roistat_visit=[^;]+(.*)?$/.test(d.cookie) ? "/dist/module.js" : "/api/site/1.0/"+id+"/init";
            var js = d.createElement(s); js.charset="UTF-8"; js.async = 1; js.src = p+h+u; var js2 = d.getElementsByTagName(s)[0]; js2.parentNode.insertBefore(js, js2);
        })(window, document, 'script', 'cloud.roistat.com', 'cf9256914e256b80168e9e2eb0c30f16');
        </script>
</body>
</html>
