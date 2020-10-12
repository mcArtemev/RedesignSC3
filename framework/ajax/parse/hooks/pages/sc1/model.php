<?

use framework\tools;

$site_id = $this->_site_id;
$model_type = $this->_datas['model_type'][3];
$model_type_id = $this->_datas['model_type']['id'];
$marka_id = $this->_datas['marka']['id'];

if ($this->_mode == -2)
{
    $model_id = $this->_datas['model']['id'];
    $full_type_name = $model_type['name_re'].' '.$this->_datas['model']['name'];
    $full_name = $this->_datas['model']['name'];
}

if ($this->_mode == -3)
{
    $full_name = $full_type_name = $model_type['name_re'].' '.$this->_datas['marka']['name'];
}

$setka_name = $this->_datas['setka_name'];

$eds = $this->_datas['eds'];
$availables = $this->_datas['availables']; 

$all_services =  $this->_datas['all_services']; 
$all_complects = $this->_datas['all_complects'];

/* удаление из $all_services случайных строк от 0 до 3, удаление из $all_complects случайных строк от 0 до 2.
if ($this->_mode == -2) {
    $all_services_temporary = rand(0, 3);
    if ($all_services_temporary != 0) {
        for ($i = 0; $i < $all_services_temporary; $i++) {
            $all_services_in = array_rand($all_services, 1);
            unset($all_services[$all_services_in]);

        }
    }

    $all_complects_temporary = rand(0, 2);
    if ($all_complects_temporary != 0) {
        for ($i = 0; $i < $all_complects_temporary; $i++) {
            $all_complects_in = array_rand($all_complects, 1);
            unset($all_complects[$all_complects_in]);
        }
    }
}
*/


if ($this->_mode == -3 && isset($this->_datas['popular_models'])) $popular_models = $this->_datas['popular_models'];
    
$price = tools::format_price($this->_datas['price'], $setka_name);

?>

<div class="Content">
	<div class="TopBlock">
		<div class="Breadcrumbs">
			<div class="fixBlock">
            <? if ($this->_mode == -2): ?>
                <p class="home"><a href="/"></a></p>
                <p>/</p>
                <p><a href="/<?=tools::search_url($site_id, serialize(array('model_type_id' => $model_type_id, 'marka_id' => $marka_id)))?>/">Ремонт <?=$this->_datas['orig_model_type'][0]['name_rm']?></a></p>
                <p>/</p>
                <p>Ремонт <?=$this->_datas['model']['name']?></p>
            <? endif; ?>
            <? if ($this->_mode == -3): ?>
                <p class="home"><a href="/"></a></p>
                <p>/</p>
                <p>Ремонт <?=$this->_datas['orig_model_type'][0]['name_rm']?></p>
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
						<div class="price"><p><span itemprop="price">от <?=$price?> руб.</span></p></div>
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
                <br><span class="h2">Цены на работы по ремонту <?=$model_type['name_rm']?></span>
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
                    <? foreach ($all_services as $value): ?>
                    <? 
					if ($value['name'] != "Диагностика" && $value['name'] != "Программная диагностика") {
                     if ($this->_mode == -2) 
                        $href = tools::search_url($site_id, serialize(array('model_id' => $model_id, 'key' => 'service', 'id' => $value[$this->_suffics.'_service_id'])));
                         
                     if ($this->_mode == -3) 
                        $href = tools::search_url($site_id, serialize(array('model_type_id' => $model_type_id, 'marka_id' => $marka_id, 'key' => 'service', 'id' => $value[$this->_suffics.'_service_id'])));
                    ?>
                        
                    <tr>
                        <td><a href="/<?=$href?>/"><?=tools::mb_firstupper($value['name'])?></a></td>
                        <!--<td><?=tools::mb_firstupper($value['name'])?></td>-->
                        <td><?=tools::format_time($value['time_min'], $value['time_max'], $eds[$value[$this->_suffics.'_service_id']]['ed_time']);?></td>
                        <td><?=tools::format_price($value['price'], $setka_name)?></td>
                    </tr>
					<? }
					endforeach; ?>
                </tbody>
                </table> 
            
          <? include __DIR__.'/form.php'; ?>
            
          <br><span class="h2">Цены на комплектующие для <?=$full_name?></span>
          <br>                   
          
            <table class="priceTable collapsed">
            <thead>
                <tr>
                    <th>Наименование оборудования</th>
                    <th>Статус</th>
                    <th>Цена, руб.</th>
                </tr>
            </thead>
            <tbody>            
                <?  $i = 0;
                    foreach ($all_complects as $value): ?> 
                    <? 
					if ($value['name'] != "Диагностика" && $value['name'] != "Программная диагностика") {
                     if ($this->_mode == -2) 
                        $href = tools::search_url($site_id, serialize(array('model_id' => $model_id, 'key' => 'complect', 'id' => $value[$this->_suffics.'_complect_id']))); 
                        
                    if ($this->_mode == -3) 
                        $href = tools::search_url($site_id, serialize(array('model_type_id' => $model_type_id, 'marka_id' => $marka_id, 'key' => 'complect', 'id' => $value[$this->_suffics.'_complect_id']))); 
                    
                    ?>
                                          
                    <tr<?=(($i>9) ? ' class="invs"' : '')?>>
                        <td><a href="/<?=$href?>/"><?=tools::mb_firstupper($value['name'])?></a></td>
                        <!--<td><?=tools::mb_firstupper($value['name'])?></td>-->
                        <td><?=$availables[$value['available_id']]['name']?></td>
                        <td>от <?=tools::format_price($value['price'], $setka_name)?></td>
                    </tr>
                <?  $i++;
					}
                    endforeach; ?>
            </tbody>
            </table>
       
            <a class="link-to-all" href="#">Показать все комплектующие</a>
            
            <? if ($this->_mode == -3 && isset($this->_datas['popular_models'])):?>
            <br><span class="h2">Популярные модели</span>
            <ul class="dops collapsed">

            </ul>
            <? endif; ?> 
                
            </div>
			<div class="clear"></div>
		</div>
	</div>			
</div>
<script language="javascript">
$(function(){
    $(".link-to-all").click(function(){
        $(this).hide();
        $(this).prev(".collapsed").find(".invs").show();
        return false;
    }); 
});
</script>    