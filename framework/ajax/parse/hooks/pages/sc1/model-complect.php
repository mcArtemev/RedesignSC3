<?

use framework\tools;

$site_id = $this->_site_id;

if ($this->_mode)
{
    $model_type = $this->_datas['model_type'][3];
}

$model_type_id = $this->_datas['model_type']['id'];

$marka_id = $this->_datas['marka']['id'];

if ($this->_mode == 2)
{
    $model_id = $this->_datas['model']['id'];
    $full_type_name = $model_type['name_re'].' '.$this->_datas['model']['name'];
    $full_name = $this->_datas['model']['name'];
}

if ($this->_mode == 3)
{
    $full_name = $full_type_name = $model_type['name_re'].' '.$this->_datas['marka']['name'];
}

if ($this->_mode == 0)
{
    $full_name = $full_type_name = $this->_datas['marka']['name'];
}

$setka_name = $this->_datas['setka_name'];

$eds = $this->_datas['eds'];
$availables = $this->_datas['availables']; 

$vals = $this->_datas['vals'];

if ($this->_mode)
{
    $complect_name = tools::mb_firstupper($vals['name']);
    $complect_available = $this->_datas['available'];
    $complect_price = tools::format_price($vals['price'], $setka_name);
}
else
{
    $complect_price = tools::format_price($this->_datas['price'], $setka_name);  
}

$services_to_complect = isset($this->_datas['services_to_complect']) ? $this->_datas['services_to_complect'] : array();
$dop_services = isset($this->_datas['dop_services']) ? $this->_datas['dop_services'] : array();
$other_complects = isset($this->_datas['other_complects']) ? $this->_datas['other_complects'] : array();

?>

<div class="Content">
	<div class="TopBlock">
		<div class="Breadcrumbs">
			<div class="fixBlock">
            <? if ($this->_mode == 2): ?>
                <p class="home"><a href="/"></a></p>
                <p>/</p>
                <p><a href="/<?=tools::search_url($site_id, serialize(array('model_type_id' => $model_type_id, 'marka_id' => $marka_id)))?>/">Ремонт <?=$this->_datas['orig_model_type'][0]['name_rm']?></a></p>
                <p>/</p>
                <p><a href="/<?=tools::search_url($site_id, serialize(array('model_id' => $model_id)))?>/">Ремонт <?=$this->_datas['model']['name']?></p></a>
                <p>/</p>
                <p><?=tools::mb_firstupper($this->_datas['syns'][3])?></p>
            <? endif; ?>
            <? if ($this->_mode == 3): ?>
                <p class="home"><a href="/"></a></p>
                <p>/</p>
                <p><a href="/<?=tools::search_url($site_id, serialize(array('model_type_id' => $model_type_id, 'marka_id' => $marka_id)))?>/">Ремонт <?=$this->_datas['orig_model_type'][0]['name_rm']?></a></p>
                <p>/</p>
                <p><?=tools::mb_firstupper($this->_datas['syns'][3])?></p>
            <? endif; ?>  
            <? if ($this->_mode == 0): ?>
               <p class="home"><a href="/"></a></p>
               <p>/</p>		  
               <p><?=tools::mb_firstupper($this->_datas['syns'][3])?></p>
            <? endif; ?>   					
            </div>
		</div>
		<div class="fixBlock">
            <div class="ContentText" itemscope itemtype="http://schema.org/Product">
				<div class="ImgLeft">
					<img itemprop="image" src="/<?=$this->_ret['img']?>"/>
				</div>
				<div class="text">
					<h1 itemprop="name"><?=$this->_ret['h1']?></h1>
                    <div itemprop="description"><?=$this->_ret['text']?></div>
                    <div class="textPrice" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
						<div class="price"><p><span itemprop="price">от <?=$complect_price?> руб.</span></p></div>
                        <meta itemprop="priceCurrency" content="RUB"/>
						<div class="Button"><p><a data-modal="zakazPopup" class="md-trigger" href="#">Записаться на ремонт</a></p></div>
						<div class="clear"></div>
					</div>
				</div>
				<div class="clear"></div>
			</div>
		</div>
	</div>
	<div class="PriceContent">
		<div class="fixBlock">
			<? include __DIR__.'/rightPart.php'; ?>
			<div class="LeftPart">
                <br><span class="h2">
                <?
                $titles = array(
                    'Цены на комплектующие и услуги по ремонту', 
                    'Стоимость комплектующих и услуг по ремонту', 
                    'Комплектующие и услуги - цены', 
                    'Комплектующие и услуги - стоимость'
                );
                srand($this->_datas['feed']);
                echo $titles[rand(0, count($titles)-1)];
                ?></span>
                <br>
                <table class="priceTable">
                <thead>
                    <tr class="green">
                        <th>Наименование оборудования</th>
                        <th>Статус</th>
                        <th>Цена, руб.</th>
                    </tr>
                </thead>
                <tbody>
                    <? if ($this->_mode): ?>
                    <tr>
                        <td><?=$complect_name?></td>
                        <td><?=$complect_available?></td>
                        <td>от <?=$complect_price?></td>
                    </tr>
                    <? else: 
                        foreach ($vals as $key => $value):
						if ($value['name'] != "Диагностика" && $value['name'] != "Программная диагностика") {
                    ?>  
                        <tr>
                            <td><?=tools::mb_firstupper($value['name']).' '.$this->_datas[$key]['model_type'][3]['name_re'];?></td>
                            <td><?=$availables[$value['available_id']]['name']?></td>
                            <td>от <?=tools::format_price($value['price'], $setka_name);?></td>
                        </tr>                  
						<? } endforeach; 
                    endif; ?>
                </tbody>
                </table> 
             
            <? if ($services_to_complect):?>
             
                <table class="priceTable">
                <thead>
                    <tr>
                        <th>Наименование услуги</th>
                        <th>Время ремонта</th>
                        <th>Цена, руб.</th>
                    </tr>
                </thead>
                <tbody>
                <? if ($this->_mode): 
                    
                    foreach ($services_to_complect as $value): ?>
                    <? 
					if ($value['name'] != "Диагностика" && $value['name'] != "Программная диагностика") {
                     if ($this->_mode == 2) 
                        $href = tools::search_url($site_id, serialize(array('model_id' => $model_id, 'key' => 'service', 'id' => $value[$this->_suffics.'_service_id'])));
                         
                     if ($this->_mode == 3) 
                        $href = tools::search_url($site_id, serialize(array('model_type_id' => $model_type_id, 'marka_id' => $marka_id, 'key' => 'service', 'id' => $value[$this->_suffics.'_service_id'])));
                    ?>
                        
                    <tr>
                        <td><a href="/<?=$href?>/"><?=tools::mb_firstupper($value['name'])?></a></td>
                        <td><?=tools::format_time($value['time_min'], $value['time_max'], $eds[$value[$this->_suffics.'_service_id']]['ed_time']);?></td>
                        <td><?=tools::format_price($value['price'], $setka_name)?></td>
                    </tr>
					<? }
					endforeach;
                
                else:
                
                    foreach ($services_to_complect as $key => $stc):
                        foreach ($stc as $value): ?>
                        <?
						if ($value['name'] != "Диагностика" && $value['name'] != "Программная диагностика") {
                         $m_type_id = $this->_datas[$key]['model_type']['id'];                         
                         $suffics = $this->_datas[$key]['suffics'];
                         $href = tools::search_url($site_id, serialize(array('model_type_id' => $m_type_id, 'marka_id' => $marka_id, 'key' => 'service', 'id' => $value[$suffics.'_service_id'])));
                        ?>
                            
                        <tr>
                            <td><a href="/<?=$href?>/"><?=tools::mb_firstupper($value['name']).' '.$this->_datas[$key]['model_type'][3]['name_re'];?></a></td>
                            <td><?=tools::format_time($value['time_min'], $value['time_max'], $eds[$key][$value[$suffics.'_service_id']]['ed_time']);?></td>
                            <td><?=tools::format_price($value['price'], $setka_name)?></td>
                        </tr>
                     <? 
						}
                     endforeach; 
                 endforeach;                    
                    
                endif; ?>
                </tbody>
                </table>
           <? endif; ?>
            
          <? include __DIR__.'/form.php'; ?>
            
          <br><span class="h2">Дополнительная информация</span>
          <br>
                    
           <? if ($dop_services && $this->_mode) :?>
             <p class="title">Услуги, которые могут потребоваться</p>
                <table class="priceTable">
                <thead>
                    <tr>
                        <th>Наименование услуги</th>
                        <th>Время ремонта</th>
                        <th>Цена, руб.</th>
                    </tr>
                </thead>
                <tbody>            
                    <? foreach ($dop_services as $value): ?>  
                        <? 
						if ($value['name'] != "Диагностика" && $value['name'] != "Программная диагностика") {
                        if ($this->_mode == 2) 
                            $href = tools::search_url($site_id, serialize(array('model_id' => $model_id, 'key' => 'service', 'id' => $value[$this->_suffics.'_service_id']))); 
                            
                        if ($this->_mode == 3) 
                            $href = tools::search_url($site_id, serialize(array('model_type_id' => $model_type_id, 'marka_id' => $marka_id, 'key' => 'service', 'id' => $value[$this->_suffics.'_service_id'])));
                        ?>
                                              
                        <tr>
                            <td><a href="/<?=$href?>/"><?=tools::mb_firstupper($value['name'])?></a></td>
                            <td><?=tools::format_time($value['time_min'], $value['time_max'], $eds[$value[$this->_suffics.'_service_id']]['ed_time'])?></td>
                            <td><?=tools::format_price($value['price'], $setka_name)?></td>
                        </tr>
						<? }
						endforeach; ?>
                </tbody>
                </table>
            <? endif; ?>
             
            <? if ($other_complects) :?>                    
               <p class="title">Другие комплектующие для <?=$full_type_name?></p>
                <table class="priceTable">
                <thead>
                    <tr>
                        <th>Наименование оборудования</th>
                        <th>Статус</th>
                        <th>Цена, руб.</th>
                    </tr>
                </thead>
                <tbody>
                
                <? if ($this->_mode): 
                
                       foreach ($other_complects as $value):
					   if ($value['name'] != "Диагностика" && $value['name'] != "Программная диагностика") {
						   ?>
                       <tr>
                            <td><?=tools::mb_firstupper($value['name'])?></td>
                            <td><?=$availables[$value['available_id']]['name']?></td>
                            <td>от <?=tools::format_price($value['price'], $setka_name)?></td>
                       </tr>
					   <? } endforeach; 
                    
                    else: 
                    
                        foreach ($other_complects as $key => $oc):
                            foreach ($oc as $value):
							if ($value['name'] != "Диагностика" && $value['name'] != "Программная диагностика") { 
							?>
                               <tr>
                                    <td><?=tools::mb_firstupper($value['name']).' '.$this->_datas[$key]['model_type'][3]['name_re'];?></td>
                                    <td><?=$availables[$value['available_id']]['name']?></td>
                                    <td>от <?=tools::format_price($value['price'], $setka_name)?></td>
                               </tr>
							<? } endforeach;
                        endforeach; 
                        
                    endif;?>
                
               </tbody>
               </table>                   
            <? endif; ?>
                <? 
                if ($this->_mode):
                    if ($this->_mode == 2) 
                        $href = tools::search_url($site_id, serialize(array('model_id' => $model_id))); 
                    
                    if ($this->_mode == 3) 
                        $href = tools::search_url($site_id, serialize(array('model_type_id' => $model_type_id, 'marka_id' => $marka_id)));                      
                    ?>
                    <a class="link-to-all" href="/<?=$href?>/">Все комплектующие и услуги по ремонту <?=$full_name?></a>
                <? endif; ?>
                <? //include __DIR__.'/form.php'; ?>
                </div>
			<div class="clear"></div>
		</div>
	</div>			
</div>     