<?php 
use framework\pdo;
use framework\tools;

$akcii = array();
$akcii = array("скидки","снижение стоимости","акционные услуги");

$vakansii = array();
$vakansii = array("карьера","работа в успешной компании");

$kontakti = array();
$kontakti_rand = rand(1,2);
if($kontakti_rand == 1)
{
    $kontakti = array("адрес","время работы","телефон");
}
if($kontakti_rand == 2)
{
    $kontakti = array("расположение офиса","расписание","номер телефона");
}

$prices=[
        "HP"=>'2600',
        "Canon"=>'от 2200',
        // "Epson"=>'',
        // 'Brother'=>'',
        // 'Graphtec'=>'',
        // 'Mimaki'=>'',
        // 'Silhouette'=>'',
        // 'Vicsign'=>'',
        // 'GCC'=>'',
        // 'Roland'=>'',
    ];
    
?>
<main>
    <section class="breadcrumbs">
        <div class="container">
            <div class="grid-12" itemscope="" itemtype="http://schema.org/BreadcrumbList">
                <ul class="breadcrumbs-inside">
                    <li itemprop="name"><a href="/" itemprop="url">Главная</a></li>
                    <li itemprop="name"><span>Заправка картриджей</span></li>
                </ul>
            </div>
        </div>
    </section>
    <section class="title-block">
        <div class="container">
            <div class="grid-12">
                <h1><?=$this->_ret['h1']?></h1>
                <p class="non-block-text">
                    Перед проведением заправки нашими специалистами проводятся процедуры по комплексной диагностике печатного устройства. 
                    Также мы тестируем качество печати после того, как картридж был заправлен и установлен. 
                    Если у Вас возникли трудности, мы готовы предоставить полный комплекс услуг по ремонту и заправке картриджей.
                </p>
            </div>
        </div>
    </section>
    
   <section class="block-section">
        <div class="container">
            <div class="block block-auto block-full block-table block-service-table">
                <div class="block-inside">
                    <h2>Стоимость заправки картриджей</h2>
				    <ul class="nekingukib quenes-posad">
		    <?php   foreach ($this->_datas['all_brands'] as $data):	?>
                        <li>
                            <a <?=($data['brand_name'] =='HP')?'class="cusgomes"':'';?> id='<?=mb_strtolower($data['brand_name']);?>'>
                                <img class="logo-image" src="/images/hab/<?=mb_strtolower($data['brand_name']);?>/<?=mb_strtolower($data['brand_name']);?>-logo.png">
                            </a>
                        </li>
            <?php   endforeach; ?> 
                    </ul>
                    <div id="gocampunes" class="services-item-table services-item-table-full">
                        <a class="services-item-row" style="color: black; font-weight: 500;">
    						<span class="services-item-name" style="text-decoration: none;">Название услуги</span>
    						<span class="services-item-value">Стоимость, руб</span>
    						<span class="services-item-callback"></span>
					    </a>
			<?php   $styleTab='';
					foreach ($this->_datas['all_brands'] as $data):
    					$stmt = pdo::getPdo()->prepare("SELECT name FROM models_list
                            WHERE marka_id = ? AND model_type_id = ? ");
                        $stmt->execute([$data['brand_id'],$all_deall_devices[0]['type_id']]);
                        $modelsList = $stmt->fetchAll(\PDO::FETCH_COLUMN);

                        $brand='';
                        if($data['brand_name'] !='HP'){
                            $brand=tools::mb_firstupper($data['brand_name']).' ';
                            $styleTab=(reset($this->_datas['all_brands'])==$data)? '' :'style="display:none;"';
                        }
                        foreach($modelsList as $model):
    		?>            
        					<div class="a services-item-row brand-block <?=mb_strtolower($data['brand_name']);?>" <?=$styleTab?>>
        						<span class="services-item-name"><?=$brand.$model?></span>
        						<span class="services-item-value"><?=(!empty($prices[$data['brand_name']]))?$prices[$data['brand_name']]:rand(20,26).'00';  ?></span>
                                <span class="services-item-callback"><button href="#callback" class="service-button-callback" data-toggle="modal"><span>Заказать звонок</span></button></span>
        					</div>
            <?php       endforeach;
					endforeach; 
			?>
                    </div>
                </div>
            </div>
        </div>    
    </section>
    
    <section class="title-block">
        <div class="container">
            <div class="grid-12">
            <p class="non-block-text" style="padding-bottom: 0px;">
                Заправка и ремонт картриджей в нашем сервисе, это быстрое и высококачественное обслуживание. 
                Следует понимать, что, если картриджи заправить некачественно или неправильно, 
                нарушив какое-либо из правил, вы рискуете поломать не только картридж, но и печатное устройство в целом. 
                Именно поэтому следует обращаться за помощью только к профессионалам. 
                Мы используем специализированную технику по ремонту и заправке картриджей.
            </p>
            </div>
        </div>
    </section>
    
    <section class="link-block-section">
        <div class="container">
            <div class="grid-12">
                <div class="link-block-list perelink">
                    <a href="/about/action/" class="link-block">
                        <div class="link-block-title-strong">Акции</div><?=$this->firstup($this->rand_arr_str($akcii))?>
                    </a>
                    <a href="/about/vacancy/" class="link-block">
                        <div class="link-block-title-strong">Вакансии</div><?=$this->firstup($this->rand_arr_str($vakansii))?>
                    </a>
                    <a href="/about/contacts/" class="link-block">
                        <div class="link-block-title-strong">Контакты</div><?=$this->firstup($this->rand_arr_str($kontakti))?>
                    </a>
            </div>
            </div>
    </section>
</main>