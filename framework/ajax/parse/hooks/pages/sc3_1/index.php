<?
use framework\tools;
$marka_lower = mb_strtolower($this->_datas['marka']['name']);
$marka_upper = mb_strtoupper($this->_datas['marka']['name']);
$marka = $this->_datas['marka']['name'];
$marka_ru =  $this->_datas['marka']['ru_name'];

$accord = array('ноутбук' => 'remont_noutbukov', 'планшет' => 'remont_planshetov', 'смартфон' => 'remont_telefonov');
$accord_img = array('ноутбук' => 'noutbuk', 'планшет' => 'planshet', 'смартфон' => 'telefon');
// $accord = $this->_datas['accord'];
$accord_img = $this->_datas['accord_image'];       
// $banner_right = false;

include __DIR__.'/banner.php'; 
        
        
?>
        
<section class="content-screen">
    <div class="container">
            <p class="mt-4 pt-4">Наш специализированный постгарантийный сервисный центр <?=$this->_datas['servicename']?> проводит комплексное обслуживание линейки электронной техники <?=$marka?>. Уже 10 лет мы специализируемся на аппаратах <?=$marka?> и знаем о них все или даже чуть больше.</p>
            <div class="row gx-0 listing mb-4">
                <? foreach ($this->_datas['all_devices'] as $device):?>
                    <div class="col-md-4">
                        <div class="imgmenuitem h-100 align-self-center">
                            <img src="/templates/moscow/img/<?=strtr(trim($marka_lower),' ','_')?>/<?=$accord_img[$device['type']]?>.png">
                            <div class="align-self-center">
                                <div class="imgmenuname"><?=tools::mb_ucfirst($device['type'])?></div>
                                <a href="/<?=$accord[$device['type']]?>_<?=tools::translit($marka,'_')?>/" class="inputbutton">Отремонтировать</a>
                            </div>
                        </div>
                    </div>
                <? endforeach;?>
            </div>
        
        
   
        <h2 class="mt-4">Преимущества сервиса <?=$this->_datas['servicename']?></h2>
        <div class="row gx-0 listing mb-4">
            <div class="col-md-3">
                <div class="imgmenuitem h-100">
                    <div>
                        <p class="title">Качественные<br>комплектующие</p>
                        <p class="text">Оригинальные комплектующие всегда в наличии. Возможность персонального дозаказа.</p>
                        <a href="<?=(in_array($this->_datas['region']['name'], ['Новосибирск', 'Нижний Новгород', 'Екатеринбург', 'Казань', 'Санкт-Петербург', 'Москва']) ? '/zapchasti_'.$marka_lower.'/' : '/komplektuyushie/')?>" class="inputbutton inputbutton-outline">Подробнее</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="imgmenuitem h-100">
                    <div>
                        <p class="title">Ремонт любых<br>неисправностей</p>
                        <p class="text">В наших мастерских производится ремонт любого уровня сложности аппаратов <?=$this->_datas['marka']['name']?>.</p>
                        <a href="<?=(in_array($this->_datas['region']['name'], ['Новосибирск', 'Нижний Новгород', 'Екатеринбург', 'Казань', 'Санкт-Петербург', 'Москва']) ? '/neispravnosti_'.$marka_lower.'/' : '/neispravnosti/')?>" class="inputbutton inputbutton-outline">Подробнее</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="imgmenuitem h-100">
                    <div>
                        <p class="title">Срочная диагностика, тех. заключение</p>
                        <p class="text">Срочная диагностика, не отходя от кассы. Углублённое аппаратное и программное тестирование техники.</p>
                        <a href="<?=(in_array($this->_datas['region']['name'], ['Новосибирск', 'Нижний Новгород', 'Екатеринбург', 'Казань', 'Санкт-Петербург', 'Москва']) ? '/diagnostika_'.$marka_lower.'/' : '/diagnostika/')?> " class="inputbutton inputbutton-outline">Подробнее</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="imgmenuitem h-100">
                    <div>
                        <p class="title">Доставка вашей техники</p>
                        <p class="text">Чтобы вернуть в строй вашу технику <?=$this->_datas['marka']['ru_name']?>, не обязательно выходить из дома.</p>
                        <a href="/dostavka/" class="inputbutton inputbutton-outline">Подробнее</a>
                    </div>
                </div>
            </div>
        </div>
        <p class="text">Мы используем только оригинальные комплектующие, на протяжении нашего сотрудничества вас будет вести личный менеджер, вы всегда будете знать о статусе ремонта, цены в нашем СЦ фиксированные. Будем рады видеть вас среди наших гостей.</p>
            
          
       
        <h2 class="mt-5">План ремонта в нашем сервисе <?=$marka?></h2>                    
        <div class="row steps mt-5">
            <div class="col-md-3">
                <div class="number">01</div>
                <div class="plantext">Вы <strong>приезжаете</strong> к нам в сервисный центр или <strong>вызываете</strong> курьера на дом</div>   
            </div>
            <div class="col-md-3">
                <div class="number">02</div>
                <div class="plantext">Мы проводим <strong>диагностику</strong> и согласовываем с вами ремонтные работы</div>
            </div>
            <div class="col-md-3">
                <div class="number">03</div>
                <div class="plantext">Качественно <strong>ремонтируем</strong> вашу любимую технику <?=$this->_datas['marka']['ru_name']?> и выдаем гарантию</div>
            </div>
            <div class="col-md-3">
                <div class="number">04</div>
                <div class="plantext">Вы <strong>наслаждаетесь</strong> своим отремонтированным гаджетом</div>
            </div>
        </div>
    </div>
</section>  