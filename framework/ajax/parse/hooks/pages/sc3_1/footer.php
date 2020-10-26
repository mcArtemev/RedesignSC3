<?
use framework\tools;
use framework\pdo;

if (isset($this->_datas['marka'])) {
$marka = $this->_datas['marka']['name'];
$marka_lower = mb_strtolower($marka);
$_marka_lower = tools::translit($marka, '_');

}
else {
  $marka_lower = 'sony';
}

$mail = $this->_datas['partner']['email'];
if ($mail == 'litovchenko@list.ru') {
	$mail = '';
}
$metrica = $this->_datas['metrica'];
$mail_counter = $this->_datas['mail_counter'];

//$accord = array('смартфон' => 'telefonov', 'ноутбук' => 'noutbukov', 'планшет' => 'planshetov');
$accord = $this->_datas['accord'];
$accord_img = $this->_datas['accord_image'];

$time = ($this->_datas['partner']['time']) ? $this->_datas['partner']['time'] : 'пн-вс: 10:00 - 20:00';

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

if (in_array($this->_datas['region']['name'], ['Новосибирск', 'Нижний Новгород', 'Екатеринбург', 'Казань', 'Санкт-Петербург', 'Москва']) && in_array($url, ['/dostavka/', '/vakansii/', '/o_nas/', '/kontakty/']) || !isset($this->_datas['marka'])) {
  $this->_datas['menu_footer'] = array(
      #'/diagnostika_'.$marka_lower.'/' => 'Диагностика',
      #'/zapchasti_'.$marka_lower.'/' => 'Комплектующие',
      #'/neispravnosti_'.$marka_lower.'/' => 'Неисправности',
      '/dostavka/' => 'Доставка',
      '/vakansii/' => 'Вакансии',
      '/kontakty/' => 'Контакты',
  );
}
else {
  $this->_datas['menu_footer'] = array(
      '/diagnostika_'.$marka_lower.'/' => 'Диагностика',
      '/zapchasti_'.$marka_lower.'/' => 'Комплектующие',
      '/neispravnosti_'.$marka_lower.'/' => 'Неисправности',
      '/dostavka/' => 'Доставка',
      '/vakansii/' => 'Вакансии',
      '/kontakty/' => 'Контакты',
  );
}

?>
  <!--  -->
  <section>

    <div class="container">
      <div class="row contacts-block gx-0">
        <div class="col-md-6" id="cnt-map"></div>
        

        <div class="col-md-6">
          <div class="contacts-block-info">
            <h2>Контакты</h2>
            <p class="mt-3">Работаем без выходных с <?=$time?></p>
            <ul class="town-list" id="cnt-accordion">
                  <? $i =0;
                    foreach ($addresis as $value):
                        $v = ($value['region_name']) ? $value['region_name'] : 'Москва';
                        $address = $value['address2'] ? $value['address2'] : $value['address1'];
                        $urlSite = preg_replace('/^([a-z]+\.)([a-z]+\.support)/', '$2', $value['site']);
                        if (isset($this->_datas['geo']) && $v != 'Москва') { continue; }?>
                          <div class="contacttable panel">
                            <? if ($i): ?>
                              <li class="" data-target="#cnt-<?=$i?>"  data-x="<?=$value['x']?>" data-y="<?=$value['y']?>"><span class="name"><?=$v?></span>
                                <i class="fas fa-map-marker-alt icon"></i>
                                <p><a class="phone" href="http://<?=$urlSite?><?=($url)?>"><?=tools::format_phone($value['phone'])?></a></p>
                              
                            <? else :?>
                              <li class="active" data-target="#cnt-<?=$i?>"  data-x="<?=$value['x']?>" data-y="<?=$value['y']?>">
                                <i class="fas fa-map-marker-alt icon"></i><span class="name"><?=$v?></span>
                                <p><a class="phone"><?=tools::format_phone($value['phone'])?></a></p>
                              
                            <?endif;?>
                            </li>
                            </div>   
                            <?  $i++;
                    endforeach; 
                  ?>
            </ul>  
                   <div class="row">
                            <div class="col-md-7">   
                              <p><b>Остались вопросы?</b></br>Оставьте номер вашего телефона и оператор колл центра обязательно перезвонит вам</p>
                            </div>
                            <div class="col-md-5 align-self-center"> <button class="inputbutton inputbutton-outlinecallBackBtn">Перезвонить мне</button></div>
                   </div> 
          </div>
        </div>
      </div>
    </div>
  </section>
  <footer>
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <p class="footer-title">Услуги сервиса:</p>
          <?php if (in_array($url, ['/o_nas/', '/dostavka/', '/vakansii/', '/kontakty/']) || !isset($this->_datas['marka'])) { ?>
            <ul class="footermenu">

                           
                            
                            <?php foreach ($this->_datas['a_marka'] as $type_name => $brands) { ?>
                              
                              <li>
                                <a href=<?"'.$s_path.'"?>
                                       data-target="#types-<?=$type_name?>" ><?=tools::mb_ucfirst($this->_datas['add_device_type'][$type_name]['type_m'])?></a>
                                       
                            </li>
                                  
                            <?php } ?>
              </ul>
                          <?php } else { ?>
                            <ul class="footermenu">
                            <? foreach ($this->_datas['all_devices'] as $device):
                                $s_path = '/'.$accord[$device['type']].'_'.strtr(trim($marka_lower),' ','_').'/';
                                if ($url == $s_path)
                                    echo '<li class="selected"><span>Ремонт '.$device['type_rm'].'</span></li>';
                                else
                                    echo '<li><a href="'.$s_path.'">Ремонт '.$device['type_rm'].'</a></li>';
                             endforeach; ?>
                           </ul>
                          <?php } ?>
                         
          
        </div>
        <div class="col-md-5">
          <p class="footer-title">Клиентам</p>
          <ul class="footermenu nocolumn">
              <? foreach ($this->_datas['menu_footer'] as $key => $value):
                  if ($url == $key)
                      echo '<li class="selected"><span>'.$value.'</span></li>';
                  else
                      echo '<li><a href="'.strtr(trim($key),' ','_').'">'.$value.'</a></li>';
              endforeach; ?>
          </ul>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-5">
            <p class="footer-title">
                Карты сайта:
            </p>
            <ul class="footermenu nocolumn">
                <li><a href="/sitemap/">Карта сайта</a></li>
                <li><a href="/sitemap_noutbuki/">Ремонт ноутбуков</a></li>
                <li><a href="/sitemap_planshety/">Ремонт планшетов</a></li>
                <li><a href="/sitemap_telefony/">Ремонт смартфонов</a></li>
            </ul>
        </div>
      </div> 
      <p><small>2007 - 2020 . Вся информация на сайте носит информационный характер и не является публичной офертой.</small></p>               
    </div>
  </footer>
  </body>
</html>










  <!--  -->
        
                    
                    <div class="footeritem contact-map">
                        
                        <div class="contact-content">
                            
                              <? $i =0;
                                 foreach ($addresis as $value):
                                    $v = ($value['region_name']) ? $value['region_name'] : 'Москва';
                                    $address = $value['address2'] ? $value['address2'] : $value['address1'];
                                    $urlSite = preg_replace('/^([a-z]+\.)([a-z]+\.support)/', '$2', $value['site']);

                                    if (isset($this->_datas['geo']) && $v != 'Москва') { continue; }?>

                                  <div class="contacttable panel">

                                        <? if ($i): ?>

                                         
                                            <div class="collapse" id="cnt-<?=$i?>">
                                                <p><a href="http://<?=$urlSite?><?=($url)?>"><?=tools::format_phone($value['phone'])?></a></p>

                                        <? else :?>

                                         <div class="contacttitle" data-toggle="collapse"
                                                data-target="#cnt-<?=$i?>" data-parent="#cnt-accordion" data-x="<?=$value['x']?>" data-y="<?=$value['y']?>"></div>

                                            <div class="collapse in" id="cnt-<?=$i?>">
                                                <p><?=tools::format_phone($value['phone'])?></p>
                                                
                                        <?endif;?>
                                        
                                  
                              <?  $i++;
                                 endforeach; ?>
                              

                              <div id="cnt-map"></div>
                        </div>
                        
                      </div>
                 </div>
             
        

       

        <script type="text/javascript" async src="/min/f=/templates/moscow/js/jquery.min.js,/templates/moscow/js/bootstrap.min.js,/templates/moscow/js/jquery.maskedinput.js,/templates/moscow/js/main.js,/templates/moscow/js/kontakty.js,/templates/moscow/js/jquery.mCustomScrollbar.concat.min.js&123456"></script>
        <script src="//api-maps.yandex.ru/2.0/?load=package.standard,package.geoObjects&amp;lang=ru-RU" type="text/javascript"></script>

        <script>
        (function($){
            $(window).on("load",function(){
                $(".submenu").mCustomScrollbar({
                    scrollInertia:450,
                    theme:"minimal-dark",
                });
                
            });
        })(jQuery);
    </script>
        
        <? if (mb_strpos($this->_datas['site_name'], 'peterburg') !== false):?>
            <script type="text/javascript">!function(){var t=document.createElement("script");t.type="text/javascript",t.async=!0,t.src="https://vk.com/js/api/openapi.js?160",t.onload=function(){VK.Retargeting.Init("VK-RTRG-358213-Jztb"),VK.Retargeting.Hit()},document.head.appendChild(t)}();</script><noscript><img src="https://vk.com/rtrg?p=VK-RTRG-358213-Jztb" style="position:fixed; left:-999px;" alt=""/></noscript>
        <?endif;?>
        
    </body>
</html>
