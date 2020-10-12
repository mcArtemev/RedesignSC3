<? 
    use framework\ajax\parse\hooks\sc;
    use framework\tools;
    
    $marka = $this->_datas['marka']['name'];
    $marka_ru =  $this->_datas['marka']['ru_name'];
    
    $vars = array();
    $vars[] = array('<p>Мы имеем', '<p>У нас есть');
    $vars[] = array('всегда в наличии', 'в наличии', '');
    $vars[] = array('все', 'почти все', 'все или почти все', '');
    $vars[] = array('необходимые', 'основные', 'распространенные');
    
    $feed = tools::gen_feed($this->_datas['site_name']);
    srand($feed);
    
    $choose = rand(0, 3);
    $t_array = array('запчасти', 'запасные части', 'детали', 'комплектующие');
    $vars[] = array($t_array[$choose]);     
      
    $vars[] = array('к большинству', 'к абсолютному большинству');
    $vars[] = array('моделей', 'видов и моделей');
    $vars[] = array('ремонтируемой техники.', 'поступающей техники.', 'ремонтируемых устройств.', 'поступающих устройств.', 'ремонтируемых аппаратов.', 'поступающих аппаратов.');
    //$vars[] = array('прямо на');
    $vars[] = array('Большинство', 'Абсолютное большинство');
    $vars[] = array('комплектующих', 'запасных частей', 'запчастей');
    $vars[] = array('хранится на');
    $vars[] = array('складе');
    $vars[] = array('в лаборатории.</p>', 'в мастерской.</p>', 'в ремонтной лаборатории.</p>');
    //$vars[] = array('по адресу:');
    
    //$vars[] = array($this->_datas['region']['name'].', '.$this->_datas['partner']['address1'].'.</p>');    

    $vars[] = array('<p>Поставки', '<p>Регулярные поставки');
    $vars[] = array('запчастей', 'запасных частей', 'деталей', 'комплектующих');
    $vars[] = array('на склад', 'на наш склад');
    $vars[] = array('производятся', 'осуществляются');
    $vars[] = array('каждые 3-4 дня.', 'каждые 2-3 дня.', '2 раза в неделю.', '2-3 раза в неделю.');

    $vars[] = array('Отлаженная', 'Отработанная', 'Четко настроенная', 'Организованная');
    $vars[] = array('логистика');
    $vars[] = array('позволяет', 'дает возможность');
    $vars[] = array('гарантировать');
    $vars[] = array('вам');
    $vars[] = array('одни из лучших');
    $vars[] = array('условий');
    $vars[] = array('по срокам');
    $vars[] = array('доставки', 'поставок');
    
    $choose_m = rand(0, 1);
    switch ($choose_m)
    {
        case 0:
            $vars[] = array('в '.$this->_datas['region']['name_pe'].'.');
        break;
        case 1:
            $vars[] = array('даже');
            $vars[] = array('редких', 'редко используемых', 'редко востребованных');    
    
            $t_array = array('запчастей.', 'запасных частей.', 'деталей.', 'комплектующих.');
            unset($t_array[$choose]);
            $t_array = array_values($t_array);
            $vars[] = $t_array;
            //$vars[] = array('в сервисный центр', 'в сервис центр', 'в наш центр', 'в наш сервисный центр', 'в наш сервис центр');
            //$vars[] = array($marka.'.');
        break;
    }
   
   

?>
<section class="inner-page gradient page">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <?php include __DIR__ . '/breadcrumb.php' ?>
            </div>
            <div class="col-sm-7 textblock">
                <h1><span class="smallh1"><?=$this->_ret['h1']?></span></h1>
                <p><?=sc::_createTree($vars, $feed);?></p>
            </div>
            <div class="col-sm-5 displayMoble">
                <div class="image-clip" style="background-image: url(/bitrix/templates/remont/images/shared/zapchasti.png)"></div>
            </div>
        </div>
    </div>
</section>


<? include __DIR__.'/devices.php'; ?>
<? include __DIR__.'/ask_expert.php'; ?>
<?php
$section_class = 'whitebg';
include __DIR__.'/preims.php';
unset($section_class);
?>