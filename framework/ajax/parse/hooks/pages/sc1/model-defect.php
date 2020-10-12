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

$dop_reasons = isset($this->_datas['dop_reasons']) ? $this->_datas['dop_reasons'] : array();        
$dop_services = isset($this->_datas['dop_services']) ? $this->_datas['dop_services'] : array();
$other_defects = isset($this->_datas['other_defects']) ? $this->_datas['other_defects'] : array();
    
$defect_price = tools::format_price($this->_datas['price'], $setka_name);

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
						<div class="price"><p><span itemprop="price">от <?=$defect_price?> руб.</span></p></div>
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
                <? if ($dop_reasons):?>
                <br><span class="h2">Возможные причины данной неисправности</span>
                <br>
                <table class="priceTable">
                <tbody>
                    <? $i=0; 
                    foreach ($dop_reasons as $value):?>
                     <tr<?=((!$i) ? ' class="green"' : '')?>>
                        <td><?=tools::mb_firstupper($value)?></td>
                     </tr>
                    <? $i++;
                    endforeach; ?>                  
                </tbody>
                </table> 
              <? endif; ?>
             
            <?if ($dop_services):?>
                <br><span class="h2">Услуги, которые могут потребоваться</span>
                <br>
                
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
                
                        foreach ($dop_services as $value):?>
                        <? 
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
                    <? endforeach; 
                    
                    else:
                    
                        foreach ($dop_services as $key => $ds):
                            foreach ($ds as $value):
                                $m_type_id = $this->_datas[$key]['model_type']['id'];
                                $suffics = $this->_datas[$key]['suffics'];
                                $href = tools::search_url($site_id, serialize(array('model_type_id' => $m_type_id, 'marka_id' => $marka_id, 'key' => 'service', 'id' => $value[$suffics.'_service_id'])));
                                ?>                            
                                <tr>
                                    <td><a href="/<?=$href?>/"><?=tools::mb_firstupper($value['name']).' '.$this->_datas[$key]['model_type'][3]['name_re']?></a></td>
                                    <td><?=tools::format_time($value['time_min'], $value['time_max'], $eds[$key][$value[$suffics.'_service_id']]['ed_time'])?></td>
                                    <td><?=tools::format_price($value['price'], $setka_name)?></td>
                               </tr>
                        <? endforeach; 
                     endforeach;
                      
                    endif;?>
                    
                </tbody>
                </table>
           <? endif; ?>
            
          <? include __DIR__.'/form.php'; ?>
          
          <? if ($other_defects) :?>    
              <br><span class="h2">Дополнительная информация</span>
              <br>     
                   <p class="title">Другие неисправности <?=$full_type_name?></p>
                   <ul class="dops">            
                        <? if ($this->_mode):  
                        
                            foreach ($other_defects as $value):?>
                            <?
                                if ($this->_mode == 2)  
                                    $href = tools::search_url($site_id, serialize(array('model_id' => $model_id, 'key' => 'defect', 'id' => $value[$this->_suffics.'_defect_id'])));  
                                
                                if ($this->_mode == 3) 
                                    $href = tools::search_url($site_id, serialize(array('model_type_id' => $model_type_id, 'marka_id' => $marka_id, 'key' => 'defect', 'id' => $value[$this->_suffics.'_defect_id'])));    
                            ?>
                                 <li><a href="/<?=$href?>/"><?=tools::mb_firstupper($value['name'])?></a></li>
                            <? endforeach; ?>
                            
                        <? endif; ?>
                    </ul>
          <? endif; ?>
             
                </div>
			<div class="clear"></div>
		</div>
	</div>			
</div> 