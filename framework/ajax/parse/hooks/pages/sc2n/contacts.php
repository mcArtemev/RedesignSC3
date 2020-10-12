<?
use framework\tools; 
$marka = $this->_datas['marka']['name']; 
$marka_lower = mb_strtolower($marka);

$servicename = $this->_datas['servicename'];
$ru_servicename = $this->_datas['ru_servicename'];
$ru_marka = $this->_datas['marka']['ru_name']; 
$time = ($this->_datas['partner']['time']) ? $this->_datas['partner']['time'] : 'Пн-Вс: 10:00-21:00';
//$point = $this->_datas['partner']['x'].','.$this->_datas['partner']['y'];
?>  

    <section class="fixed content-wrapper">

          <div class="content-block content-block--contacts">
            <section class="crumbs">
                <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="<?=$multiMirrorLink?>/"><meta itemprop="title" content="Главная"/><img src="/img/home.png" alt="home"/></a></span>
                <span> / </span>
                <span>Контакты</span>
            </section>
            <div class="content-block__top">
                <div class="info-block">
                    <h1><?=$this->_ret['h1']?></h1>
          
                    <img src="/userfiles/site/large/kontakty.jpg" width="350" height="110" alt="Контакты" title="Контакты">

                    <ul class="list">
                        <li><span>Ежедневный график работы</span></li>
                        <li><span>Курьерская доставка по <?=$this->_datas['region']['name_de']?></span></li>
                        <li><span>Удобное расположение офиса</span></li>
                        <li><span>Единая горячая линия</span></li>
                    </ul> 
                    
                    <a href="<?=$multiMirrorLink?>/order/"  class="btn btn--fill">Записаться на ремонт</a>
                  
                </div>
            </div>
            
            <div class="divider divider--three"></div>
            
            <? 
                // $requisites_str = ''; 
                $req_style = '';
                if (!in_array($marka_lower, array('canon', 'dell', 'nikon', 'toshiba')) && $this->_datas['region']['name'] == 'Москва')
                {
                    // $requisites_str = '<a href="/contacts/requisites/" id="requisites">Наши реквизиты</a>';
                    $req_style = ' style="margin-bottom: 0px;"';
                }  
            ?>
            
            <div class="content-block__bottom">

                    <div class="info-block">
                    <span class="h2">Обратная связь</span>

                        <section class="prefMain no-height">
                   
                     <div class="block-new"<?=$req_style?>>
                         <div class="pref">
                            <p class="h4">Время работы <?=$ru_servicename?></p><p><?=$time?></p>
                         </div>
                         <div class="pref">
                            <p class="h4">Единый телефон горячей линии</p><a class="footphone mango_id" href="tel:+<?=$this->_datas['phone']?>">+<?=tools::format_phone($this->_datas['phone'])?></a>
                         </div>
                         <div class="pref last">
                            <p class="h4">По вопросам обслуживания</p><a href="mailto:info@<?=($this->_datas['site_name'] != $this->_datas['realHost'])?$this->_datas['realHost']:$this->_datas['site_name'];?>">
                                info@<?=($this->_datas['site_name'] != $this->_datas['realHost'])?$this->_datas['realHost']:$this->_datas['site_name'];?>
                                </a>
                         </div>
                    </div>
                    <?php  //echo '<div style="display:none">'.$this->_datas['realHost'].'</div>'; ?>
                    <?php /*echo $requisites_str;*/ ?>
                    </section>

                    </div>

                </div>
                
            <div class="divider divider--three"></div>
              
              <div class="content-block__bottom">

                    <div class="info-block">

                        <span class="h2">Адрес и схема проезда</span>
                        
                        <? if (!$this->_datas['partner']['exclude']):?>
                            <p><strong><?=$servicename?> в <?=$this->_datas['region']['name_pe']?>:</strong>&nbsp;<?=$this->_datas['partner']['address1']?></p>
                            <!--<script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%<?=$this->_datas['partner']['sid']?>&amp;width=100%25&amp;height=400&amp;lang=ru_RU&amp;scroll=true"></script>-->
                         <?endif;?>
                                                  
                        <div style="width: 100%; height: 300px; background-image: url('https://static-maps.yandex.ru/1.x/?ll=<?=$this->_datas['partner']['y']?>,<?=$this->_datas['partner']['x']?>&size=600,450&z=<?=$this->_datas['zoom']?>&l=map&pt=<?=$this->_datas['partner']['y']?>,<?=$this->_datas['partner']['x']?>,org'); background-repeat: no-repeat; background-attachment: scroll; background-position-y: center; background-size: cover;"></div>
                    
                        <? switch($this->_datas['partner']['name'])
                        {
                            case 'laptop': case 'laptop2':
                                $str = 'На городском транспорте: м. Савеловская, выход из метро в сторону ТЦ "Савеловский". Здание "Компьютерный".<br><br>На автомобиле: съезд с Третьего Транспортного Кольца не доезжая Савеловской эстакады. Поворот направо после мебельного центра "Каскад Мебель". Здание "Компьютерный".';
                            break;
                            case 'tkachdenis2':
                                $str = 'На городском транспорте: м. Савеловская, выход из метро в сторону ТЦ "Савеловский". Далее следуйте в направлении автосалона Kia Motors. Здание '.$ru_servicename.' - следующее по ходу движения после автосалона.<br><br>На автомобиле: съезд с Третьего Транспортного Кольца на Савеловский проезд после автозаправки "Газпромнефть". Далее проедите 300 метров прямо до поворота. Здание '.$ru_servicename.' будет с левой стороны от вас.';
                            break;
                            default:
                                $str = '';
                                
                            if ($str)
                                $str = '<span class="h2">Как добраться</span><p class="text--full-width">'.$str.'</p>';                        }
                        ?>                         
                        
                    </div>

                </div>
                
                <a href="<?=$multiMirrorLink?>/order/"  class="btn btn--fill">Записаться на ремонт</a>
          </div>
     
        <? include __DIR__.'/aside.php'; ?>
    </section>
    <div class="clear"></div>