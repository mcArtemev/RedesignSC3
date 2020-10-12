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
    $service_name = tools::mb_firstupper($vals['name']);
    $service_time = tools::format_time($vals['time_min'], $vals['time_max'], $eds[$this->_datas['id']]['ed_time']);
    $service_price = tools::format_price($vals['price'], $setka_name);
}
else
{
    $service_name = tools::mb_firstupper($this->_datas['syns'][3]);
    $service_price = tools::format_price($this->_datas['price'], $setka_name);
}

$complect_to_services = isset($this->_datas['complect_to_services']) ? $this->_datas['complect_to_services'] : array();
$dop_defects = isset($this->_datas['dop_defects']) ? $this->_datas['dop_defects'] : array();
$other_services = isset($this->_datas['other_services']) ? $this->_datas['other_services'] : array();

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
						<div class="price"><p><span itemprop="price"><?=$service_price?> руб.</span></p></div>
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
                $dat = tools::skl('service', $this->_suffics, (($this->_mode) ? $vals['name'] : $this->_datas['syns'][3]), 'dat');
                $titles = array(
                    'Стоимость услуг по '.$dat,
                    'Цены на услугу по '.$dat,
                    $service_name.' - цены',
                    $service_name.' - стоимость'
                );
                srand($this->_datas['feed']);
                echo $titles[rand(0, count($titles)-1)];
                ?></span>
                <br>
                <table class="priceTable">
                <thead>
                    <tr class="green">
                        <th>Наименование услуги</th>
                        <th>Время ремонта</th>
                        <th>Цена, руб.</th>
                    </tr>
                </thead>
                <tbody>
                    <? if ($this->_mode): ?>
                    <tr>
                        <td><?=$service_name?></td>
                        <td><?=$service_time?></td>
                        <td><?=$service_price?></td>
                    </tr>
                    <? else:
                        foreach ($vals as $key => $value):
                        $suffics = $this->_datas[$key]['suffics'];
                    ?>
                         <tr>
                            <td><?=tools::mb_firstupper($value['name']).' '.$this->_datas[$key]['model_type'][3]['name_re'];?></td>
                            <td><?=tools::format_time($value['time_min'], $value['time_max'], $eds[$key][$value[$suffics.'_service_id']]['ed_time']);?></td>
                            <td><?=tools::format_price($value['price'], $setka_name);?></td>
                         </tr>
                    <? endforeach;
                    endif; ?>
                </tbody>
                </table>

            <?if ($complect_to_services):?>

                <table class="priceTable">
                <thead>
                    <tr>
                        <th>Наименование оборудования</th>
                        <th>Статус</th>
                        <th>Цена, руб.</th>
                    </tr>
                </thead>
                <tbody>
                <?  if ($this->_mode):

                        foreach ($complect_to_services as $value):?>
                        <?
                         if ($this->_mode == 2)
                            $href = tools::search_url($site_id, serialize(array('model_id' => $model_id, 'key' => 'complect', 'id' => $value[$this->_suffics.'_complect_id'])));

                         if ($this->_mode == 3)
                            $href = tools::search_url($site_id, serialize(array('model_type_id' => $model_type_id, 'marka_id' => $marka_id, 'key' => 'complect', 'id' => $value[$this->_suffics.'_complect_id'])));
                        ?>
                        <tr>
                            <td><a href="/<?=$href?>/"><?=tools::mb_firstupper($value['name'])?></a></td>
                            <td><?=$availables[$value['available_id']]['name']?></td>
                            <td>от <?=tools::format_price($value['price'], $setka_name)?></td>
                        </tr>
                    <? endforeach;

                    else:

                    foreach ($complect_to_services as $key => $cts):
                        foreach ($cts as $value): ?>
                        <?
                         $m_type_id = $this->_datas[$key]['model_type']['id'];
                         $suffics = $this->_datas[$key]['suffics'];
                         $href = tools::search_url($site_id, serialize(array('model_type_id' => $m_type_id, 'marka_id' => $marka_id, 'key' => 'complect', 'id' => $value[$suffics.'_complect_id'])));
                        ?>

                        <tr>
                            <td><a href="/<?=$href?>/"><?=tools::mb_firstupper($value['name']).' '.$this->_datas[$key]['model_type'][3]['name_re'];?></a></td>
                            <td><?=$availables[$value['available_id']]['name']?></td>
                            <td>от <?=tools::format_price($value['price'], $setka_name)?></td>
                        </tr>
                    <?
                    endforeach;
                 endforeach;

                endif; ?>
                </tbody>
                </table>
           <? endif; ?>

          <? include __DIR__.'/form.php'; ?>

          <br><span class="h2">Дополнительная информация</span>
          <br>

            <? if ($dop_defects && $this->_mode) :?>
               <p class="title">Неисправности связанные с <?=tools::skl('service', $this->_suffics, $vals['name'], 'tp');?></p>
               <ul class="dops">
                    <? foreach ($dop_defects as $key => $value):?>
                    <?
                    if ($this->_mode == 2)
                        $href = tools::search_url($site_id, serialize(array('model_id' => $model_id, 'key' => 'defect', 'id' => $value[$this->_suffics.'_defect_id'])));

                    if ($this->_mode == 3)
                        $href = tools::search_url($site_id, serialize(array('model_type_id' => $model_type_id, 'marka_id' => $marka_id, 'key' => 'defect', 'id' => $value[$this->_suffics.'_defect_id'])));
                    ?>
                         <li><a href="/<?=$href?>/"><?=tools::mb_firstupper($value['name'])?></a></li>
                    <? endforeach; ?>
                </ul>
            <? endif; ?>

            <? if ($other_services) :?>
               <p class="title">Другие услуги по ремонту <?=$full_type_name?></p>
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

                       foreach ($other_services as $value):?>
                       <tr>
                            <td><?=tools::mb_firstupper($value['name'])?></td>
                            <td><?=tools::format_time($value['time_min'], $value['time_max'], $eds[$value[$this->_suffics.'_service_id']]['ed_time']);?></td>
                            <td><?=tools::format_price($value['price'], $setka_name);?></td>
                       </tr>
                    <? endforeach;

                    else:

                        foreach ($other_services as $key => $os):
                            foreach ($os as $value):
                                $suffics = $this->_datas[$key]['suffics'];?>
                               <tr>
                                    <td><?=tools::mb_firstupper($value['name']).' '.$this->_datas[$key]['model_type'][3]['name_re'];?></td>
                                    <td><?=tools::format_time($value['time_min'], $value['time_max'], $eds[$key][$value[$suffics.'_service_id']]['ed_time']);?></td>
                                    <td><?=tools::format_price($value['price'], $setka_name)?></td>
                               </tr>
                        <? endforeach;
                        endforeach;

                    endif; ?>

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
                    <a class="link-to-all" href="/<?=$href?>/">Все услуги и комплектующие по ремонту <?=$full_name?></a>
                 <? endif; ?>
                <? //include __DIR__.'/form.php'; ?>
                </div>
			<div class="clear"></div>
		</div>
	</div>
</div>
