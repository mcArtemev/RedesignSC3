<?php

use \framework\tools;

use framework\ajax\parse\hooks\pages\sc6\data\src\model_service;
use framework\ajax\parse\hooks\pages\sc6\data\src\service_service;
use framework\ajax\parse\hooks\pages\sc6\data\src\helpers6;

$feed = $this->_datas['feed'];

$services = service_service::getForType($this->_datas['model_type']['name'], $this->_datas['site_id']);
if (count($services)) {
	$minCost = helpers6::min(array_column($services, 'cost'));
	$minTime = helpers6::min(array_column($services, 'time'));
}


$models = model_service::getForTypeMark($this->_datas['model_type']['id'], $this->_datas['marka']['id'], $this->_datas['site_id']);

if(empty($models)){
    $models = model_service::GetModelsList($this->_datas['model_type']['id'], $this->_datas['marka']['id']);
}

function discounts($brand_ru, $brand, $model, $feed){
    srand($feed);
    $type=[' экрана ', ' дисплея ',' тачскрина ', ' стекла ',' дисплейного модуля ', ' сенсора ',  ' стекла экрана ', ' стекла дисплея ',
        ' стекла сенсора ',' сенсорного экрана ', ' сенсорного стекла ', ' сенсорного дисплея ', ' модуля дисплея ', ' модуля экрана '];
    $masters =[' мастеру',' специалисту',' сервисному инженеру',' нашему мастеру',' нашему специалисту'];
    $gadget =[' на телефонах',' на смартфонах',' у телефонов',' у смартфонов',' телефона',' смартфона'];
    // титул
    $title ='Замена ';
    $i = rand(0, 3);
    $title .= $type[$i];
    unset($type[$i]);
    $title .= $model;
    $title .= ' '.$brand;
    $title .= ' со скидкой 50%';
    //первое предложение
    $firstSentence = 'Замена ';
    $i =array_rand($type);
    $firstSentence .= $type[$i];
    unset($type[$i]);
    $firstSentence .=$gadget[array_rand($gadget)];
    if (rand(0,1)==1) {
        $g = [' марки', ' бренда', ''];
        $firstSentence .=$g[array_rand($g)].' '.(rand(0,1)==1) ? $brand_ru : $brand;
    }

    $s1[0][0] = [' самая популярная услуга', ' самый популярный вид ремонта'];
    $s1[0][1] = [' в нашем'];
    $s1[0][2] =[' сервисе',' сервис центре',' сервисном центре',' центре'];
    $s1[1][0]= [' одна из самых популярных услуг',' один из самых популярных видов ремонта'];
    $s1[1][1]=[' в наших'];
    $s1[1][2]=[' сервисах',' сервис центрах',' сервисных центрах',' центрах',' отделениях'];
    $i =rand(0,1);
    $firstSentence .=' - '.$s1[$i][0][array_rand($s1[$i][0])]. ' '.$s1[$i][1][array_rand($s1[$i][1])].' '.$s1[$i][2][array_rand($s1[$i][2])].'.';
    //второе предложение
    $secondSentence ='';
    $s2[0] =['Среднее время, требуемое для замены', 'Время, требуемое для замены'];
    $s2[1] =['В среднем, на замену','В среднем, для замены'];
    $s2[2] =['На замену'];
    $i =rand(0,2);
    $secondSentence .=$s2[$i][array_rand($s2[$i])].' ';
    $secondSentence .=($i == 0) ? " экрана".' '.$model.' ' : " экрана на смартфонах ";
    $secondSentence .= ' '.$brand_ru;
    $secondSentence =($i == 0 || $i == 1) ? trim($secondSentence).',' : $secondSentence;
    if($i>0) {
        if($i == 2) {
            $i = array_rand($masters);
            $secondSentence .= (rand(0, 1) == 1) ? $masters[$i] : "";
            unset($masters[$i]);
        }
        if($i == 1) {
            $key = array_rand(array_slice($masters,1,2,TRUE));
            $secondSentence .= (rand(0, 1) == 1) ? $masters[$key] : "";
            unset($masters[$key]);
        }
        $branch =[' требуется',' необходимо'];
        $secondSentence .= $branch[array_rand($branch)];
    }else{
        $secondSentence .=' составляет';
    }
    $time[0][0] =[' около '];
    $time[0][1] =['1 часа','1,5 часов','одного часа','получаса','30 минут','40 минут','50 минут','45 минут'];
    $time[1][0] =[' не больше ',' не более '];
    $time[1][1] =['двух часов','2-х часов','3-х часов','трех часов'];
    $time[2][0] =[' приблизительно ',' примерно ', ' ~ '];
    $time[2][1] =['1 час','1,5 часа','один час','полчаса','30 минут','40 минут','50 минут','45 минут'];
    $i = rand(0, 2);
    $secondSentence .=$time[$i][0][array_rand($time[$i][0])].' '.$time[$i][1][array_rand($time[$i][1])].'.';
    //третье предложение
    $thirdSentence ='';
    $s3 = ['Для оперативного ремонта ','Для максимально оперативного ремонта ','Для срочного ремонта '];
    $thirdSentence .=$s3[array_rand($s3)];
    $branch1[0][0] =['производим ','проводим ','осуществляем '];
    $branch1[0][1] =['ежедневные ','регулярные '];
    $branch1[1][0] =['регулярно ','ежедневно '];
    $branch1[2][0] =['наши специалисты '];
    $branch1[2][1] =['проводят ','производят ','осуществляют '];
    $i = rand(0,2);
    if($i ==0)
        $thirdSentence .='мы '.$branch1[0][0][array_rand($branch1[0][0])].' '.$branch1[0][1][array_rand($branch1[0][1])];
    if($i ==1)
        $thirdSentence .='мы '.$branch1[1][0][array_rand($branch1[1][0])].' '.$branch1[0][0][array_rand($branch1[0][0])];
    if($i ==2)
        $thirdSentence .=$branch1[2][0][array_rand($branch1[2][0])].' '.$branch1[2][1][array_rand($branch1[2][1])];
    $thirdSentence .=' пополнения';
    $s3 = [' нашего склада',' наших складов',' склада',' складов'];
    $thirdSentence.=$s3[array_rand($s3)];
    $s3 = ['поэтому','это позволяет нам'];
    $dot = (rand(0,1) == 1) ? ", " : ". ";
    $thirdSentence .=$dot;
    $i = rand(0,1);
    $thirdSentence .=($dot =='. ') ? tools::mb_firstupper($s3[$i]).' всегда' : $s3[$i].' всегда';
    if($i==0) {
        $s3 = [' есть ', ' есть в наличии ', ' в наличии есть ', ' в наличии имеются ', ' имеются '];
    }
    if($i==1){
        $s3 = [' иметь ',' иметь в наличии '];
    }
    $key = array_rand($s3);
    $thirdSentence .=$s3[$key];
    $parts[0] =[' все комплектующие',' комплекты всех комплектующих',' запасы фирменных стекол',' запасы фирменных дисплеев',
        ' запасы фирменных экранов',' запасы фирменных модулей',' запасы оригинальных стекол',
        ' запасы оригинальных дисплеев',' запасы оригинальных экраном', 'запасы оригинальных модулей'];
    $parts[1] =[' оригинальные дисплеи',' оригинальные модули',' фирменные дисплеи',' фирменные модули'];
    $i = rand(0,1);
    $thirdSentence .=$parts[$i][array_rand($parts[$i])];
    if(empty($g)){
        if($i ==0)
            $thirdSentence .= ' '.$brand;
        if($i ==1)
            $thirdSentence .= ' для '.$model.' '.$brand;
    }
    $thirdSentence =($key ==0 || $key==4) ? trim($thirdSentence).' в наличии.' : trim($thirdSentence).'.';

    //четвертое предлажение
    $fourthSentence ='';
    $s4[0] = ['Скидка ','Данная скидка '];
    $s4[1] = ['50%',''];
    $s4[2] = ['предоставляется ','распространяется '];
    $fourthSentence .= $s4[0][array_rand($s4[0])].' '.$s4[1][array_rand($s4[1])].' '.$s4[2][array_rand($s4[2])];
    $i = rand(0,1);
    if($i==0){
        $fourthSentence .='на услугу "замена ';
        $fourthSentence.=trim($type[array_rand($type)]).'".';
    }
    if($i==1) {
        $fourthSentence .= 'на работу ';
        $s4 = [' мастера', ' специалиста', ' сервисного инженера'];
        $i = rand(0,2);
        $fourthSentence .=$s4[array_rand(array_slice ($masters,0,3))].' по замене ';
        $fourthSentence.=trim($type[array_rand($type)]).'.';
    }

    $discounts =$firstSentence.' ';
    $discounts .=(rand(0,1)==1) ? $secondSentence .' '.$thirdSentence.' ' :  $thirdSentence.' '.$secondSentence.' ';
    $discounts .= $fourthSentence;

    echo '<h2  class="service__quality-mark_title">'.$title.'</h2>';
    echo '<p class="part-txt">'.$discounts.'</p>';
}
srand($feed);
// var_dump($this->_datas['orig_model_type'][0]);
?>

<?php helpers6::breadcrumbs([
	['/', 'Главная'],
  [0, 'Ремонт '.$this->_datas['orig_model_type'][0]['name_rm'].' '.$this->_datas['marka']['ru_name']],
]); ?>

<main class="page-main">

	<section class="part">
		<div class="container">
			<header class="part-header">
				<h1 class="part-title__left"><?=$this->_ret['h1']?></h1>
			</header>

			<div class="row">
				<div class="col-md-7 col-sm-7 ">
					<p class="part-txt"><?=tools::new_gen_text(
                    "Ремонт 
                    {".$this->_datas['orig_model_type'][0]['name_re']." ".$this->_datas['marka']['ru_name']."|"
                    .$this->_datas['orig_model_type'][0]['name_re']."|".$this->_datas['marka']['name']." |"
                    .$this->_datas['orig_model_type'][0]['name_re']." ".$this->_datas['marka']['name']."}
                    это
                    {
                    	{
                    		{задача , которую не стоит|задача, на решение которой не стоит|работа, которую не стоит}
                    		{
                    			{
                    				доверять
                    				{любителям|непрофессионалам|дилетантам|не специалистам}
                    			}|{
                    				возлагать на 
                    				{любителей|непрофессионалов|дилетантов|не специалистов}
                    			}
                    		}
                    		и должна
                    	}|{
                    		{дело, которое не стоит|занятие, которое не стоит|задание, которое не стоит}
                    		{
                    			{
                    				доверять
                    				{любителям|непрофессионалам|дилетантам|не специалистам}
                    			}|{
                    				возлагать на 
                    				{любителей|непрофессионалов|дилетантов|не специалистов}
                    			}
                    		}
                    		и должно		
                    	}
                    }
                    {проводиться в|производиться в|осуществляться в|выполняться в}
                    {специализированном сервисном центре|сервисном центре соответствующей специализации|специализированном сервис центре|сервис центре соответствующей специализации}."
		            )
		            .' '.
		            tools::new_gen_text('^{знания и большой опыт|знания и регулярная практика|регулярная практика и знания|образование и опыт|многолетний опыт и образование|регулярная практика|постоянная практика и квалификация |ежедневная практика|высокая квалификация и многолетний опыт|опыт |квалификация |навыки|знания|образование|практика|образование и большой опыт|образование и навыки|опыт и образование|постоянная практика|большой опыт|высокая квалификация|многолетний опыт|опыт и практика|опыт и навыки|опыт и знания|опыт и квалификация|практика и опыт|навыки и опыт|знания  и опыт|квалификация и опыт|квалификация и навыки|квалификация и знания|квалификация и практика|навыки и квалификация|знания и квалификация|регулярная практика и квалификация|ежедневная практика и квалификация|постоянная практика и квалификация|многолетняя практика и квалификация|образование и многолетняя практика|знания и многолетний опыт} 
                    {наших мастеров|наших сервисных мастеров|наших сервисных инженеров|наших сервисных специалистов|наших специалистов}^(1)
                    , 
                    ^{профессиональное|высокопрофессиональное|новейшее|оригинальное}
                    {оборудование|специализированное оборудование|спецоборудование}^(1)
                    и 
                    ^{наличие оригинальных|наличие фирменных}
                    {запасных частей|запчастей|комплектующих}^(1)
                    
                    {позволяет|дает возможность}
                    {производить|проводить|выполнять|осуществлять}
                    нам 
                    {ремонт|ремонтные работы|сложный ремонт|сложные ремонтные работы|даже самый сложный ремонт|даже самый сложные работы|даже сложный ремонт|даже сложные работы|ремонт любой сложности|ремонтные работы любой|сложности|даже самый непростой ремонт|даже самый трудный ремонт}
                    {качественно и|высококачественно и|квалифичцированно и|как следует и|доброкачественно и}
                    {максимально быстро.|максимально оперативно.|быстро.|оперативно.|в кротчайшие сроки.|быстро и качественно.|качественно и быстро.|максимально быстро и качественно.|быстрее, чем в других сервисных центрах.}').' '.
		            $this->_ret['plain']?></p>
					<div class="block-select">
						<?php include 'data/inc/minCostTime.php'; ?>
						<?php //include 'data/inc/selectModel.php'; ?>
					</div>
				</div>
				<div class="col-md-4 col-md-offset-1 col-sm-5">
					<?php include 'data/inc/form.php'; ?>
				</div>
			</div>

		</div>
	</section>

	<?php if (count($services)) { ?>
	<section class="">
		<div class="container">
			<header class="part-title">
				<h3><?=$this->_ret['hService']?></h3>
			</header>
			<div class="service-price">
				<div class="service-price__item">
					<?php include 'data/inc/tablePrice.php'; ?>
                    <noindex><p style="font-weight: 300; margin-bottom: 20px;">Цены указаны за работу специалиста без учета стоимости запчастей.<br/>Стоимость диагностики составляет 500 рублей. В случае проведения ремонтных работ диагностика в подарок.<br> В таблице указано среднее время оказания услуги при условии наличия необходимой для ремонта комплектующей.</p></noindex>


			    </div>
			</div>
			<?php  include 'data/inc/selectModel.php'; ?>


			<?php if(!empty($models)):?>

			<h3 class="block-select__title">Популярные модели:</h3>
			<div class="row" style="margin-bottom: 30px;">

    			    <?php if(count($models)<4):?>
    			       <?php foreach ($models as $model) {
                            $url = tools::search_url($this->_datas['site_id'], serialize(array('model_id' => $model['id'])));
                            if (!empty($url)) {
                                echo "<div class='col-md-3'><a href='/{$url}/'>{$model['name']}</a></div>";
                            } else {
                                echo "<div class='col-md-3'><a data-toggle='modal' data-target='#requestModal' href='#'>{$model['name']}</a></div>";
                            }
                        } ?>
    			    <?php else:
    			        if(count($models)>20){
    			            shuffle($models);
    			            $models = array_slice($models,1,20);
    			        }

    			        /*
    			         * <span data-toggle="modal" data-target="#requestModal">Заказать звонок</span>
    			         * <?=tools::search_url($site_id, serialize(array('model_type_id' => $model_type_id, 'marka_id' => $marka_id)))?>/">Ремонт <?=$this->_datas['orig_model_type'][0]['name_rm']?>
    			         */

    			        $part = ceil(count($models)/4);
        			    foreach (array_chunk($models,$part) as $val):?>
        			        <div class="col-md-3">
        			            <ul>
        			                <?php
                                    foreach($val as $model) {
                                        $url = tools::search_url($this->_datas['site_id'], serialize(array('model_id' => $model['id'])));
                                        if (!empty($url)) {
                                            echo "<li><a href='/{$url}/'>{$model['name']}</a></li>";
                                        } else {
                                            echo "<li><a data-toggle='modal' data-target='#requestModal' href='#'>{$model['name']}</a></li>";
                                        }
        			                }
        			                ?>
        			            </ul>
        			        </div>
        			    <?php endforeach;?>
        			 <?php endif;?>
			</div>
			
			<?php endif;?>
			
		</div>
	</section>
	<?php } ?> 
<?php if($this->_datas['orig_model_type'][0]['name']=='смартфон'):?>
<section class="part" style="margin-bottom: -20px;">
	<div class="container">
		<div class="part-header">
			
			<div class="row flex">
				<div class="col-md-7 sale">
					<?php discounts($this->_datas['marka']['ru_name'], $this->_datas['marka']['name'], $this->_datas['orig_model_type'][0]['name_rm'],$feed); ?>
					<div class="header-phone"><a href="tel:74951820728"><i class="fa fa-phone" aria-hidden="true"></i>&nbsp;7 (495) 182-07-28 </a><span data-toggle="modal" data-target="#requestModal">Заказать звонок</span></div>
				</div>
				<div class="col-md-5 img-sale">
					 
					 	<img src="/_mod_files/_img/girl-sale-screen.png" alt="">
					 
				</div>
			</div>
		</div>
	</div>
</section>
<? endif;?>

	<?php srand($this->_datas['feed']); include 'preference.php'; ?>
    <?php include 'relink.php'; ?>
</main>
