<?
use framework\tools;
$marka_lower = mb_strtolower($this->_datas['marka']['name']);
$marka_upper = mb_strtoupper($this->_datas['marka']['name']);
$marka = $this->_datas['marka']['name'];
$marka_ru =  $this->_datas['marka']['ru_name'];

//$accord = array('ноутбук' => 'remont_noutbukov', 'планшет' => 'remont_planshetov', 'смартфон' => 'remont_telefonov');
//$accord_img = array('ноутбук' => 'noutbuk', 'планшет' => 'planshet', 'смартфон' => 'telefon');
$accord = $this->_datas['accord'];
$accord_img = $this->_datas['accord_image'];


         if (file_exists($_SERVER['DOCUMENT_ROOT'].'/../sc3/templates/moscow/img/'.$marka_lower.'/imagerow.png')) { // Одно изображение
            $banner_img = '/templates/moscow/img/'.strtr(trim($marka_lower),' ','_').'/imagerow.png"';
        } else { // Несколько
            $banner_img = '/templates/moscow/img/imagerow.png" style="position: absolute;"';
            $banner_img_dop = '/templates/moscow/img/'.strtr(trim($marka_lower),' ','_').'/banner.png" style="position: absolute;z-index: 500;height: 100%;width: auto;object-fit: none;right: 0;"';
        } 
        $banner_right = false;
        include __DIR__.'/banner.php'; 
        
        
        ?>
        
        <div class="aboutrow">
            <div class="container">
                <h1><?=$this->_ret['h1']?></h1>
                <div class="abouttext">Наш специализированный постгарантийный сервисный центр <?=$this->_datas['servicename']?> проводит комплексное обслуживание линейки электронной техники <?=$marka?>. Уже 10 лет мы специализируемся на аппаратах <?=$marka?> и знаем о них все или даже чуть больше.</div>
                <div class="imgmenu">
                    <? foreach ($this->_datas['all_devices'] as $device):?>
                    <div class="imgmenuitem">
                        <div class="imgmenuname"><?=tools::mb_ucfirst($device['type'])?></div>
                        <img src="/templates/moscow/img/<?=strtr(trim($marka_lower),' ','_')?>/<?=$accord_img[$device['type']]?>.png">
                        <a href="/<?=$accord[$device['type']]?>_<?=tools::translit($marka,'_')?>/" class="imgmenubutton">Отремонтировать</a>
                    </div>
                    <? endforeach;?>
                </div>
            </div>
        </div>

        <div class="preimrow">
            <div class="container">
                <h2>Преимущества сервиса <?=$this->_datas['servicename']?></h2>
                <div class="preimlist col2">
                    <div class="preimitem">
                        <a class="preimimage" href="<?=(in_array($this->_datas['region']['name'], ['Новосибирск', 'Нижний Новгород', 'Екатеринбург', 'Казань', 'Санкт-Петербург', 'Москва']) ? '/zapchasti_'.$marka_lower.'/' : '/komplektuyushie/')?>">
                            <img src="/templates/moscow/img/shared/komplektuyushie.png">
                        </a>
                        <div class="preimtext">
                            <div class="preimname">Качественные комплектующие</div>
                            <div class="preiman">
                                Оригинальные комплектующие всегда в наличии. Возможность персонального дозаказа.
                            </div>
                            <a href="<?=(in_array($this->_datas['region']['name'], ['Новосибирск', 'Нижний Новгород', 'Екатеринбург', 'Казань', 'Санкт-Петербург', 'Москва']) ? '/zapchasti_'.$marka_lower.'/' : '/komplektuyushie/')?>" class="preimbtn">Подробнее</a>
                        </div>
                    </div>
                    <div class="preimitem">
                        <a class="preimimage" href="<?=(in_array($this->_datas['region']['name'], ['Новосибирск', 'Нижний Новгород', 'Екатеринбург', 'Казань', 'Санкт-Петербург', 'Москва']) ? '/neispravnosti_'.$marka_lower.'/' : '/neispravnosti/')?>">
                            <img src="/templates/moscow/img/shared/neispravnosti.png">
                        </a>
                        <div class="preimtext">
                            <div class="preimname">Ремонт любых неисправностей</div>
                            <div class="preiman">
                                В наших мастерских производится ремонт любого уровня сложности аппаратов <?=$this->_datas['marka']['name']?>.
                            </div>
                            <a href="<?=(in_array($this->_datas['region']['name'], ['Новосибирск', 'Нижний Новгород', 'Екатеринбург', 'Казань', 'Санкт-Петербург', 'Москва']) ? '/neispravnosti_'.$marka_lower.'/' : '/neispravnosti/')?>" class="preimbtn">Подробнее</a>
                        </div>
                    </div>
                    <div class="preimitem">
                        <a class="preimimage" href="<?=(in_array($this->_datas['region']['name'], ['Новосибирск', 'Нижний Новгород', 'Екатеринбург', 'Казань', 'Санкт-Петербург', 'Москва']) ? '/diagnostika_'.$marka_lower.'/' : '/diagnostika/')?>">
                            <img src="/templates/moscow/img/shared/diagnostika.png">
                        </a>
                        <div class="preimtext">
                            <div class="preimname">Срочная диагностика, тех. заключение</div>
                            <div class="preiman">
                                Срочная диагностика, не отходя от кассы. Углублённое аппаратное и программное тестирование техники.
                            </div>
                            <a href="<?=(in_array($this->_datas['region']['name'], ['Новосибирск', 'Нижний Новгород', 'Екатеринбург', 'Казань', 'Санкт-Петербург', 'Москва']) ? '/diagnostika_'.$marka_lower.'/' : '/diagnostika/')?> " class="preimbtn">Подробнее</a>
                        </div>
                    </div>
                    <div class="preimitem">
                        <a class="preimimage" href="/dostavka/">
                            <img src="/templates/moscow/img/shared/dostavka.png">
                        </a>
                        <div class="preimtext">
                            <div class="preimname">Доставка вашей техники </div>
                            <div class="preiman">
                                Чтобы вернуть в строй вашу технику <?=$this->_datas['marka']['ru_name']?>, не обязательно выходить из дома.
                            </div>
                            <a href="/dostavka/" class="preimbtn">Подробнее</a>
                        </div>
                    </div>
                </div>
                <div class="text">Мы используем только оригинальные комплектующие, на протяжении нашего сотрудничества вас будет вести личный менеджер, вы всегда будете знать о статусе ремонта, цены в нашем СЦ фиксированные. Будем рады видеть вас среди наших гостей.</div>
            </div>
        </div>


        <div class="planrow">
            <div class="container">
                <h2>План ремонта в нашем сервисе <?=$marka?></h2>
                <div class="planrow">
                    <div class="planitem">
                        <div class="planimage">
                            <img src="/templates/moscow/img/shared/plan1.png">
                        </div>
                        <div class="plantext">
                            Вы <strong>приезжаете</strong> к нам в сервисный центр или <strong>вызываете</strong> курьера на дом
                        </div>
                    </div>
                    <div class="planitem">
                        <div class="planimage">
                            <img src="/templates/moscow/img/shared/plan2.png">
                        </div>
                        <div class="plantext">
                            Мы проводим <strong>диагностику</strong> и согласовываем с вами ремонтные работы
                        </div>
                    </div>
                    <div class="planitem">
                        <div class="planimage">
                            <img src="/templates/moscow/img/shared/plan3.png">
                        </div>
                        <div class="plantext">
                            Качественно <strong>ремонтируем</strong> вашу любимую технику <?=$marka?> и выдаем гарантию
                        </div>
                    </div>
                    <div class="planitem">
                        <div class="planimage">
                            <img src="/templates/moscow/img/shared/plan4.png">
                        </div>
                        <div class="plantext">
                            Вы <strong>наслаждаетесь</strong> своим отремонтированным гаджетом
                        </div>
                    </div>
                </div>
            </div>
        </div>
