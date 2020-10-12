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

        <div class="footerrow">
            <div class="container">
                <div class="footerflex">
                    <div class="footeritem">
                        <div class="footertitle">Услуги сервиса</div>
                          <?php if (in_array($url, ['/dostavka/', '/vakansii/', '/o_nas/', '/kontakty/']) || !isset($this->_datas['marka'])) { ?>
                            <div class="panel-group" id="types-accordion">

                            <?php foreach ($this->_datas['all_devices_site'] as $type) { ?>
                              <div class="contacttable panel">
                                <div class="contacttitle collapsed" data-toggle="collapse"
                                       data-target="#types-<?=$type['type_id']?>" data-parent="#types-accordion"><?=tools::mb_ucfirst($type['type_m'])?></div>
                                       <div class="collapse" id="types-<?=$type['type_id']?>">
                                  <? foreach ($typeMarkas[$type['type_id']] as $brand):
                                      $s_path = '/'.$accord[$type['type']].'_'.mb_strtolower($brand).'/';
                                      echo '<p><a href="'.$s_path.'">'.$brand.'</a></p>';
                                      endforeach; ?>
                                    </div>
                                  </div>
                            <?php } ?>
                            
                            <?php foreach ($this->_datas['a_marka'] as $type_name => $brands) { ?>
                              <div class="contacttable panel">
                                <div class="contacttitle collapsed" data-toggle="collapse"
                                       data-target="#types-<?=$type_name?>" data-parent="#types-accordion"><?=tools::mb_ucfirst($this->_datas['add_device_type'][$type_name]['type_m'])?></div>
                                       <div class="collapse" id="types-<?=$type_name?>">
                                  <? foreach ($brands as $brand):
                                      $s_path = '/'.$type_name.'_'.mb_strtolower($brand).'/';
                                      echo '<p><a href="'.$s_path.'">'.$brand.'</a></p>';
                                      endforeach; ?>
                                    </div>
                                  </div>
                            <?php } ?>
                          </div>
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
                        <div class="footertitle margin">Клиентам</div>
                        <ul class="footermenu">
                            <? foreach ($this->_datas['menu_footer'] as $key => $value):
                                if ($url == $key)
                                    echo '<li class="selected"><span>'.$value.'</span></li>';
                                else
                                    echo '<li><a href="'.strtr(trim($key),' ','_').'">'.$value.'</a></li>';
                            endforeach; ?>
                        </ul>
                        <div class="footertitle margin">Карты сайта</div>
                        <ul class="footermenu">
                            <? foreach (['sitemap' => 'Карта сайта', 'sitemap_noutbuki' => 'Ремонт ноутбуков', 'sitemap_planshety' => 'Ремонт планшетов', 'sitemap_telefony' => 'Ремонт смартфонов'] as $key => $value):
                                if ($url == $key)
                                    echo '<li class="selected"><span>'.$value.'</span></li>';
                                else
                                    echo '<li><a href="/'.$key.'/">'.$value.'</a></li>';
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
                                    $urlSite = preg_replace('/^([a-z]+\.)([a-z]+\.support)/', '$2', $value['site']);

                                    if (isset($this->_datas['geo']) && $v != 'Москва') { continue; }?>

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
                    <input type="submit" class="inputbutton" value="Записаться" id="submit">
                </form>
                <div class="successMessage">
                  <i class="fa fa-check" aria-hidden="true"></i>
                  Форма отправлена. В ближайшее время вам перезвонит наш консультант.
                </div>
              </div>
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
