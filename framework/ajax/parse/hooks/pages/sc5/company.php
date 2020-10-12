<? 
    use framework\ajax\parse\hooks\sc;
    use framework\rand_it;
    
    $marka = $this->_datas['marka']['name'];
    $marka_lower = mb_strtolower($marka);
    $marka_ru =  $this->_datas['marka']['ru_name'];
    
    $lis = array();
    $lis[] = array('фиксированные цены', 'честные цены', 'цены регламентированы прайс-листом', 'цены регламентированы прейскурантом', 'выгодные цены');
    $lis[] = array('бесплатная экспресс диагностика', 'бесплатная срочная диагностика', 'бесплантная диагностика', 'срочная диагностика',
                        'экспресс диагностика');
    $lis[] = array('лучшие сроки ремонта', 'оптимальные сроки ремонта', 'сжатые сроки ремонт', 'кратчайшие сроки ремонта');
    $lis[] = array('гарантии на все работы', 'гарантии на любой ремонт', 'гарантии на все услуги',
            'гарантии на все услуги и комплектующие', 'гарантии на все комплектующие и услуги', 'гарантии на все ремонтные работы',
            'длительная гарантия', 'длительная гарантия на все услуги', 'длительная гарантия на все работы', 'длительная гарантия на ремонт');
    $lis[] = array('оригинальные запчасти', 'оригинальные комплектующие', 'все комплектующие в наличии', 'фирменные запчасти',
            'фирменные комплектующие');     
    $lis[] = array('бесплатные консультация по телефону', 'бесплатные консультации', 'бесплатная горячая линия', 'онлайн консультации',
                'online консультации', 'консультации online');

    $menu = $this->_datas['menu'];
    unset($menu['/']);
    $menu = array_keys($menu);
    
    foreach ($lis as $key => $value)
    {
        foreach ($value as $k => $v)
        {
            $lis[$key][$k] = '<li><a href="'.$menu[$key].'">'.$v.'</a></li>';         
        }
    }
    
    $feed = $this->_datas['feed'];
    
    $lis = rand_it::randMas($lis, count($lis), '', $feed);    

?>


<section class="inner-page gradient page">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <?php include __DIR__ . '/breadcrumb.php' ?>
            </div>
            <div class="col-sm-7 textblock">
                <h1><span class="smallh1"><?=$this->_ret['h1']?></span></h1>
                <p><?=sc::_createTree($lis, $feed);?></p>
            </div>
            <div class="col-sm-5 displayMoble">
                <div class="image-clip" style="background-image: url(/bitrix/templates/remont/images/shared/contacts.png)"></div>
            </div>
        </div>
    </div>
</section>
<?php
$section_class = 'whitebg';
include __DIR__.'/preims.php';
unset($section_class);
