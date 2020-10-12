<?php
use framework\tools;
use framework\ajax\parse\hooks\pages\sc6\data\src\helpers6;

$marka = $this->_datas['marka']['name'];  // SONY
$address = $this->_datas['partner']['address1'];
$time = $this->_datas['partner']['time'];
$email = [
  'admin@'.$this->_datas['site_name'],
  'support@'.$this->_datas['site_name'],
  'marketing@'.$this->_datas['site_name'],
];
$phone = $this->_datas['phone'];

?>
<?php helpers6::breadcrumbs([
	['/', 'Главная'],
  [0, 'Контакты'],
]); 
    
?>

<main>
    <section class="part-2">
        <div class="container">
            <div class="part_header">
                <h1 class="part-title part-title__left part-title__bold">Контактная информация</h1>
            </div>
            <div class="part-col">
                <div class="part-col__left">


                    <div class="contact-info">
                        <ul class="contact-info__inner vcard" itemscope itemtype="http://schema.org/Organization">
                            <meta itemprop="name" content="<?=$this->_datas['servicename']?>"/>
                            <meta itemprop="url" content="<?='https://'.$this->_datas['site_name']?>"/>
                            <li class="adr" itemprop="address" itemscope itemtype="http://schema.org/PostalAddress"<?=(($this->_datas['partner']['exclude']) ? (" style='display:none'") : '')?>>
                                <i class="fa fa-map-marker" aria-hidden="true"></i>
                                <span class = "contactItem">Адрес: </span>
                                <span itemprop="postalCode"><?=$this->_datas['partner']['index']?></span>,&nbsp;
                                <span class="locality" itemprop="addressLocality"><?=$this->_datas['region']['name']?></span>,&nbsp;
                                <span class="street-address" itemprop="streetAddress"><?=$address?></span>
                            </li>
                            <li>
                                <i class="fa fa-phone" aria-hidden="true"></i>
                                <span class = "contactItem">Телефон: </span>
                                <a href="tel:<?=$phone?>"> <span class="tel" itemprop="telephone"><?=tools::format_phone($phone)?></span></a>
                            </li>
                            <li>
                                <i class="fa fa-clock-o" aria-hidden="true"></i>
                                <span class = "contactItem">Время работы: </span>
                                <span class="workhours">
                                <?
                                if(!$this->_datas['partner']['time'])
                                {
                                    echo "Пн-Вс, с 9:00 до 18:00";
                                }
                                else
                                {

                                    echo $this->_datas['partner']['time'];
                                }

                                ?>
                                </span>
                            </li>
                            <li>
                                <i class="fa fa-envelope" aria-hidden="true"></i>
                                <span class = "contactItem">Электронная почта: </span>
                                <a href="mailto:<?=$email[0]?>"><span class = "email" itemprop="email"><?=$email[0]?></span></a>
                            </li>
                            <li>
                                <i class="fa fa-envelope" aria-hidden="true"></i>
                                <span class = "contactItem">Техническая поддержка: </span>
                                <a href="mailto:<?=$email[1]?>"><?=$email[1]?></a>
                            </li>
                            <li>
                                <i class="fa fa-envelope" aria-hidden="true"></i>
                                <span class = "contactItem">Корпоративным клиентам: </span>
                                <a href="mailto:<?=$email[2]?>"><?=$email[2]?></a>
                            </li>
                            <span class="category"><span class="value-title" title="Сервисный центр"></span></span>
                            <span class="url"><span class="value-title" title="<?='https://'.$this->_datas['site_name']?>"></span></span>
                            <span class="fn org"><span class="value-title" title="<?=$this->_datas['servicename']?>"></span></span>
                            <span class="geo"><span class="latitude"><span class="value-title" title="<?=$this->_datas['partner']['x']?>"> </span></span><span class="longitude"><span class="value-title" title="<?=$this->_datas['partner']['y']?>"> </span></span></span>
                        </ul>
                    </div>
                    <div class="contact-map">
                        <h3>Как нас найти?</h3>
                        <div class="contact-map__item">
							<div style="width: 100%; height: 300px; background-image: url('https://static-maps.yandex.ru/1.x/?ll=<?=$this->_datas['partner']['y']?>,<?=$this->_datas['partner']['x']?>&size=600,450&z=<?=$this->_datas['zoom']?>&l=map&pt=<?=$this->_datas['partner']['y']?>,<?=$this->_datas['partner']['x']?>,org'); background-repeat: no-repeat; background-attachment: scroll; background-position-y: center;background-position-x: center;"></div>
                            <!--<div data-map="<?=$this->_datas['partner']['x'].';'.$this->_datas['partner']['y'].';16'?>" id="map1" style="width: 100%; height: 300px;"></div>-->
							<? if ($this->_datas['region']['name'] == "Москва") { ?>
								<!--<br><p>м Алексеевская жилой комплекс Парк Мира д 102 строение 12. Бесплатная парковка 25 минут,  пропуск на территорию можно заказать при записи по телефону.</p>-->
							<? } ?>
							
						</div>
                    </div>
                    <div class="devices-info">
                        <h3>Мы ремонтируем:</h3>
                        <ul>
                          <? 
                            $accord_url = array();
                            $typeList = array_column($this->_datas['all_devices'], 'type_m');
                            
                            foreach ($this->_datas['all_devices'] as $value)
                            {
                                $accord_url[$value['type_m']] = $this->_datas['types_urls'][$value['type']];    
                            }                          
                           
                            foreach ($typeList as $type) { ?>
                            <li><a href = "/<?=$accord_url[$type]?>/"><?=tools::mb_ucfirst($type)?></a></li>
                          <? } ?>
                        </ul>
                    </div> 
                    <!--
                    <div class="other-cities">
                        <h3>Мы в других городах</h3>

                        <div class="other-cities__block">
                            <div class="other-cities__inner">
                                <div class="other-cities__item">
                                    <h4>Санкт-Петербург</h4>
                                    <span>ул. Ленина, 23-А (офис 235)</span>
                                    <a href="tel:88000000000">8 800 000 00 00</a>
                                    <span>с 9:00 до 18:00 (без выходных)</span>
                                </div>
                                <div class="other-cities__map">
                                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2248.050325821746!2d37.646447315928775!3d55.70549698054076!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x46b54b358e5aa217%3A0xd07ef9eadd9c5f9d!2z0YPQuy4g0JvQtdC90LjQvdGB0LrQsNGPINCh0LvQvtCx0L7QtNCwLCAyMywg0JzQvtGB0LrQstCwLCDQoNC-0YHRgdC40Y8sIDExNTI4MA!5e0!3m2!1sru!2sua!4v1480939309805"></iframe>
                                </div>
                            </div>
                        </div>
                    </div>-->
                </div>
                <div class="part-col__right">
                    <?php include "data/inc/formFeedback.php"; ?>
                    <?php include 'data/inc/infoList.php'; ?>
                </div>
            </div>
        </div>
    </section>
</main>
