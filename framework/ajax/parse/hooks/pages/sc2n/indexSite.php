<?php

use framework\tools;
use framework\pdo;
 
 $brands =[
     'Acer', 'Samsung', 'Apple','Asus', 'Sony','Xiaomi', 'Lenovo','Dell','Bork','Aeg', 'Bosch', 'Brother', 'Candy', 'Canon',  'Dji', 
    'Electrolux', 'Epson', 'Gaggenau', 'Ardo',   'Gorenje', 'Haier', 'Hansa', 'Hitachi', 'HP', 'HTC', 'Huawei', 'Indesit', 'iRobot', 
    /*'Jura',*/ 'JVC', 'Korting', 'Kuppersberg', /*'Kuppersbusch',*/ 'Kyocera',  'LG', 'Liebherr','Beko', 'Maunfeld', 'Meizu', 
    'Midea', 'Miele','Motorola', 'MSI', 'Neff', 'Nikon', 'Nokia', 'Panasonic', 'Philips', /*'Saeco',*/  'Sharp', 
    'Siemens', 'Smeg', 'Ariston', 'Toshiba', 'Weissgauff', 'Whirlpool', /*'Xbox',*/ 'Xerox',  'Zanussi', 'ZTE',
];

    $mainBrand ='';
    $brandlist = '';
    for($i =0; $i<count($brands);$i++){
        if($i<8){
            $mainBrand .= '<div class="box"><a href="/'.mb_strtolower($brands[$i]).'/"><img src="/img/logosvg/logo-'.mb_strtolower($brands[$i]).'.svg" class="vitrina-logo" alt"'.$brands[$i].'"></a></div>';
        }else{
            $brandlist .= '<li><a href="/'.mb_strtolower($brands[$i]).'/">'.$brands[$i].'</a></li>';
        }
    } 


?>
<section class="hello firstIdexBlock">
    <div class="fixed">
        <h1>Сервисный центр Remont Centre</h1>
        <div class="hello__photo"><img src="/userfiles/site/large/indexsite.png" width="415" height="221"></div>
        <div class="hello__info">
            <p>Обслуживайте свою технику у нас.</p>
            <p>В нашем сервисном центре есть профессионалы специализирующийся на любом типе техники или бренде.</p>
            <p>Ждем вас!</p>
        </div>
    </div>
</section>

<section class="experts">
    <div class="fixed">
        
        <!--<div>-->
            
            <!--<ul class='showcase'>-->
            <?//php foreach($brands as $brand):?>

            <!--<div class="box"><a href="#"><img src="../logo-lenovo.svg" class="vitrina-logo"></a></div>-->
                    <!--<li><?/*=strtoupper($brand)*/?>-->
                    <!--<a href="/<?//=mb_strtolower($brand)?>/" style='background-image: url(/img/logo-<?//=mb_strtolower($brand)?>.png);'>-->
                       <!-- <img src="/img/logo-<?//=mb_strtolower($brand)?>.png" alt="logo" class="<?//=$marka_lower?>"/>-->
                    <!--</a>-->
                    <!--</li>        -->
                <?//php endforeach; ?>
            <!--</ul>-->
                    
        <!--</div>        -->
        
        
        <span class="h2">Выберите свой бренд</span>
        <div class="box-vitrina">
            
            <!--<p class="vitrina-title">Выберите свой бренд</p>-->
            <div class="vitrina-brands">
                
                <?=$mainBrand?>
            </div>
            
            <button id="openBrandList" class="vitrina-button btn btn--fill" >Показать другие</button>  
        
            <div class="vitrina-list">
                <ul class="three" id="vitrina-list">
                    <?=$brandlist?>
                </ul>
            </div>
            <button  id="closeBrandList" class='vitrina-button btn btn--fill'>Скрыть</button>
    
        </div>
    </section>
    
    
<section class="prefMain">
    <div class="fixed">
     <div class="block-new">
        <span class="h2">Сервис со знаком качества</span>
        <div class="pref">
            <!-- <a href="<?/*=$multiMirrorLink*/?>/delivery/">Выезд курьера</a>-->
            <span class="indexSite_infoBlock">Выезд курьера</span>
            <p>Курьерская доставка в сервисный центр из любой точки <?=$region_name_re?>.</p>
        </div>
         
        <div class="pref">
            <!-- <a href="<?/*=$multiMirrorLink*/?>/diagnostics/">Диагностика за 15 минут</a>-->
            <span class="indexSite_infoBlock">Диагностика за 15 минут</span>
            <p>Выявление неисправности устройства в кратчайшие сроки.</p>
        </div>
         
        <div class="pref last">
                <!--<a href="<?/*=$multiMirrorLink*/?>/services/">Срочный ремонт</a>-->
            <span class="indexSite_infoBlock">Срочный ремонт</span>
            <p>Экспресс ремонт за 1-2 часа. Комплектующие в наличии.</p>
        </div>
        <div class="clear"></div>
      </div>
    </div>
</section>

