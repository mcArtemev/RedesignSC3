<?

use framework\tools;

$site_id = $this->_site_id;
$model_type = $this->_datas['model_type'][3];
$model_type_id = $this->_datas['model_type']['id'];
$marka_id = $this->_datas['marka']['id'];

if ($this->_mode == 2)
{
    $model_id = $this->_datas['model']['id'];
    $sublineyka_id = $this->_datas['sublineyka']['id'];
}

if ($this->_mode == 3)
{

}

if ($this->_mode == 5)
{
    $sublineyka_id = $this->_datas['sublineyka']['id'];
}

$setka_name = $this->_datas['setka_name'];

$eds = $this->_datas['eds'];
$availables = $this->_datas['availables'];

$vals = $this->_datas['vals'];

$complect_name = tools::mb_firstupper($vals['name']);
$complect_amount = $this->_datas['amount'];
$complect_price = tools::format_price($vals['price'], $setka_name);
$price_str = 'от <span>'.$complect_price.'</span>';

$services_to_complect = $this->_datas['services_to_complect'];
$dop_services = isset($this->_datas['dop_services']) ? $this->_datas['dop_services'] : array();
$other_complects = $this->_datas['other_complects'];

?>
        <div class="title-row">
            <div class="container">
                <h1><?=$this->_ret['h1']?></h1>
            </div>
        </div>

         <? include __DIR__.'/banner.php'; ?>

         <ul class="breadcrumb">
         <? if ($this->_mode == 3): ?>
              <li><a href="/">Главная</a></li>
              <li><a href="/<?=tools::search_url($site_id, serialize(array('model_type_id' => $model_type_id, 'marka_id' => $marka_id)))?>/">Ремонт <?=$this->_datas['orig_model_type'][0]['name_rm']?></a></li>
              <li><?=tools::mb_firstupper($this->_datas['syns'][3])?></li>
         <? endif; ?>
         <? if ($this->_mode == 5): ?>
              <li><a href="/">Главная</a></li>
              <li><a href="/<?=tools::search_url($site_id, serialize(array('model_type_id' => $model_type_id, 'marka_id' => $marka_id)))?>/">Ремонт <?=$this->_datas['orig_model_type'][0]['name_rm']?></a></li>
              <li><a href="/<?=tools::search_url($site_id, serialize(array('sublineyka_id' => $sublineyka_id)))?>/"> <?=$this->_datas['sublineyka']['name']?></a></li>
              <li><?=tools::mb_firstupper($this->_datas['syns'][3])?></li>
         <? endif; ?>
          <? if ($this->_mode == 2): ?>
              <li><a href="/">Главная</a></li>
              <li><a href="/<?=tools::search_url($site_id, serialize(array('model_type_id' => $model_type_id, 'marka_id' => $marka_id)))?>/">Ремонт <?=$this->_datas['orig_model_type'][0]['name_rm']?></a></li>
              <li><a href="/<?=tools::search_url($site_id, serialize(array('sublineyka_id' => $sublineyka_id)))?>/"> <?=$this->_datas['sublineyka']['name']?></a></li>
              <li><a href="/<?=tools::search_url($site_id, serialize(array('model_id' => $model_id)))?>/"> <?=$this->_datas['model']['name']?></a></li>
              <li><?=tools::mb_firstupper($this->_datas['syns'][3])?></li>
         <? endif; ?>
         </ul>

        <div class="aboutrow">
            <div class="container">
                <div class="abouttext">
                    <?=$this->_ret['text']?>
                </div>
            </div>
        </div>

        <div class="servicerow">
            <div class="container">
                <div class="servicetable">
                    <table>
                        <thead>
                            <tr>
                                <th>Оборудование</th>
                                <th>Наличие</th>
                                <th>Цена, руб</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                 <td><?=$complect_name?></td><td><div class="amount"><?=$complect_amount?></div></td><td><?=$price_str?></td>
                            </tr>
                        </tbody>
                    </table>
                    <? if ($services_to_complect):?>
                        <table>
                            <thead>
                                <tr>
                                    <th>Услуга</th>
                                    <th>Время, час</th>
                                    <th>Цена, руб</th>
                                </tr>
                            </thead>
                            <tbody>
                                <? foreach ($services_to_complect as $value):

                                    if ($this->_mode == 2)
                                        $href = tools::search_url($site_id, serialize(array('model_id' => $model_id, 'key' => 'service', 'id' => $value[$this->_suffics.'_service_id'])));

                                    if ($this->_mode == 3)
                                        $href = tools::search_url($site_id, serialize(array('model_type_id' => $model_type_id, 'marka_id' => $marka_id, 'key' => 'service', 'id' => $value[$this->_suffics.'_service_id'])));

                                    if ($this->_mode == 5)
                                        $href = tools::search_url($site_id, serialize(array('sublineyka_id' => $sublineyka_id, 'key' => 'service', 'id' => $value[$this->_suffics.'_service_id'])));
                                ?>
                                <tr>
                                    <td><a href="/<?=$href?>/"><?=tools::mb_firstupper($value['name'])?></a></td>
                                    <td><?=str_replace(array('часа', 'час'), '', tools::format_time($value['time_min'], $value['time_max'], $eds[$value[$this->_suffics.'_service_id']]['ed_time']))?></td>
                                    <td><?=tools::format_price($value['price'], $setka_name)?></td>
                                </tr>
                                <?endforeach;?>
                            </tbody>
                        </table>
                    <?endif;?>
                </div>
            </div>
        </div>

        <div class="preimin">
            <div class="container">
                <div class="preiminlist">
                    <?=$this->_datas['preims']?>
                </div>
            </div>
        </div>

        <? if ($dop_services):?>
        <div class="servicerow">
            <div class="container">
                <h2>Дополнительно</h2>
                <div class="servicetable">
                    <table>
                        <thead>
                            <tr>
                                <th>Услуга</th>
                                <th>Время, час</th>
                                <th>Цена, руб</th>
                            </tr>
                        </thead>
                        <tbody>
                             <?foreach ($dop_services as $value):?>
                            <tr>
                                <td><?=tools::mb_firstupper($value['name'])?></td>
                                <td><?=str_replace(array('часа', 'час'), '', tools::format_time($value['time_min'], $value['time_max'], $eds[$value[$this->_suffics.'_service_id']]['ed_time']))?></td>
                                <td><?=tools::format_price($value['price'], $setka_name)?></td>
                            </tr>
                        <? endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
         <?endif;?>

         <? if ($other_complects):?>
            <div class="servicerow">
                <div class="container">
                    <h2>Другие услуги</h2>
                    <div class="servicetable">
                        <table>
                            <thead>
                                <tr>
                                    <th>Оборудование</th><th>Наличие</th><th>Цена, руб</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?foreach ($other_complects as $value):
                                    if ($this->_mode == 2)
                                            $href = tools::search_url($site_id, serialize(array('model_id' => $model_id, 'key' => 'complect', 'id' => $value[$this->_suffics.'_complect_id'])));

                                    if ($this->_mode == 3)
                                            $href = tools::search_url($site_id, serialize(array('model_type_id' => $model_type_id, 'marka_id' => $marka_id, 'key' => 'complect', 'id' => $value[$this->_suffics.'_complect_id'])));

                                    if ($this->_mode == 5)
                                            $href = tools::search_url($site_id, serialize(array('sublineyka_id' => $sublineyka_id, 'key' => 'complect', 'id' => $value[$this->_suffics.'_complect_id'])));
                                ?>
                                <tr>
                                    <td><a href="/<?=$href?>/"><?=tools::mb_firstupper($value['name'])?></a></td>
                                    <td><div class="amount"><?=$value['amount']?></div></td>
                                    <td>от <?=tools::format_price($value['price'], $setka_name)?></td>
                                </tr>
                                <? endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?endif;?>

        <div class="text2">
                <div class="container">
                    <?=$this->_datas['text2']?>
                </div>
        </div>

        <? include __DIR__.'/banner-total.php'; ?>

        <ul class="breadcrumb">
        <? if ($this->_mode == 3): ?>
             <li><a href="/">Главная</a></li>
             <li><a href="/<?=tools::search_url($site_id, serialize(array('model_type_id' => $model_type_id, 'marka_id' => $marka_id)))?>/">Ремонт <?=$this->_datas['orig_model_type'][0]['name_rm']?></a></li>
             <li><?=tools::mb_firstupper($this->_datas['syns'][3])?></li>
        <? endif; ?>
        <? if ($this->_mode == 5): ?>
             <li><a href="/">Главная</a></li>
             <li><a href="/<?=tools::search_url($site_id, serialize(array('model_type_id' => $model_type_id, 'marka_id' => $marka_id)))?>/">Ремонт <?=$this->_datas['orig_model_type'][0]['name_rm']?></a></li>
             <li><a href="/<?=tools::search_url($site_id, serialize(array('sublineyka_id' => $sublineyka_id)))?>/">Ремонт <?=$this->_datas['sublineyka']['name']?></a></li>
             <li><?=tools::mb_firstupper($this->_datas['syns'][3])?></li>
        <? endif; ?>
         <? if ($this->_mode == 2): ?>
             <li><a href="/">Главная</a></li>
             <li><a href="/<?=tools::search_url($site_id, serialize(array('model_type_id' => $model_type_id, 'marka_id' => $marka_id)))?>/">Ремонт <?=$this->_datas['orig_model_type'][0]['name_rm']?></a></li>
             <li><a href="/<?=tools::search_url($site_id, serialize(array('sublineyka_id' => $sublineyka_id)))?>/">Ремонт <?=$this->_datas['sublineyka']['name']?></a></li>
             <li><a href="/<?=tools::search_url($site_id, serialize(array('model_id' => $model_id)))?>/">Ремонт <?=$this->_datas['model']['name']?></a></li>
             <li><?=tools::mb_firstupper($this->_datas['syns'][3])?></li>
        <? endif; ?>
        </ul>
