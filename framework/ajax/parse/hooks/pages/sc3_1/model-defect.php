<?

use framework\tools;

$site_id = $this->_site_id;
$model_type = $this->_datas['model_type'];
$model_type_id = $this->_datas['model_type']['id'];
$marka_id = $this->_datas['marka']['id'];

if ($this->_mode == 2)
{
    $model_id = $this->_datas['model']['id'];
    $modelUrl = $this->translit($this->clearBrandLin($this->_datas['model']['name'], $marka_lower));
}

if ($this->_mode == 3)
{

}

if ($this->_mode == 5)
{
    $sublineyka_id = $this->_datas['sublineyka']['id'];
}

$setka_name = $this->_datas['setka_name'];

#$eds = $this->_datas['eds'];
#$availables = $this->_datas['availables'];

$defect = $this->_datas['defect'];

$defect_price = tools::format_price($this->_datas['price'], $setka_name);
$dop_services = isset($this->_datas['dop_services']) ? $this->_datas['dop_services'] : array();
$price_str = 'от <span>'.$defect_price.'</span>';

?>

        <div class="title-row">
            <div class="container">
                <h1><?=$this->_ret['h1']?></h1>
            </div>
        </div>

         <? include __DIR__.'/banner.php'; ?>

         <ul class="breadcrumb">
           <? if ($this->_mode == 3): ?>
                <li><a href="/<?=$marka_lower?>/">Главная</a></li>
                <li><a href="/<?=$this->urlType($this->_datas['model_type']['name'])?>/">Ремонт <?=$this->_datas['orig_model_type'][0]['name_rm']?></a></li>
                <li><?=tools::mb_firstupper($this->_datas['syns'][3])?></li>
           <? endif; ?>
            <? if ($this->_mode == 2): ?>
                <li><a href="/<?=$marka_lower?>/">Главная</a></li>
                <li><a href="/<?=$this->urlType($this->_datas['model_type']['name'])?>/">Ремонт <?=$this->_datas['orig_model_type'][0]['name_rm']?></a></li>
                <li><?=$this->_datas['model']['sublineyka']?></li>
                <li><a href="/<?=$this->urlType($this->_datas['model_type']['name'])?>/<?=$modelUrl?>/"><?=$this->_datas['model']['name']?></a></li>
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

        <div class="popularrow">
            <div class="container">
                 <? if ($this->_mode == -3) :?>
                     <h2>Популярные линейки</h2>
                     <ul class="popularlist">

                     </ul>
                <?endif;?>
                <? if ($this->_mode == -5) :?>
                     <h2>Популярные устройства</h2>
                     <ul class="popularlist">

                     </ul>
                <?endif;?>
            </div>
        </div>

         <? if ($dop_services):?>

             <div class="servicerow">
                <div class="container">
                    <div class="servicetable">
                        <table>
                            <thead>
                                <tr>
                                    <th>Услуга</th>
                                    <th>Время, мин</th>
                                    <th>Цена, руб</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?foreach ($dop_services as $value):

                                    if ($this->_mode == 2)
                                        $href = tools::search_url($site_id, serialize(array('model_id' => $model_id, 'key' => 'service', 'id' => $value[$this->_suffics.'_service_id'])));

                                    if ($this->_mode == 3)
                                        $href = tools::search_url($site_id, serialize(array('model_type_id' => $model_type_id, 'marka_id' => $marka_id, 'key' => 'service', 'id' => $value[$this->_suffics.'_service_id'])));

                                    if ($this->_mode == 5)
                                        $href = tools::search_url($site_id, serialize(array('sublineyka_id' => $sublineyka_id, 'key' => 'service', 'id' => $value[$this->_suffics.'_service_id'])));
                                ?>
                                <tr>
                                    <td><a href="/<?=$href?>/"><?=tools::mb_firstupper($value['name'])?></a></td>
                                    <td><?=($value['time_min']."-".$value['time_max'])?></td>
                                    <td><?=tools::format_price($value['price'], $setka_name)?></td>
                                </tr>
                                <? endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
             </div>

        <?endif; ?>

        <div class="text2">
                <div class="container">
                    <?=$this->_datas['text2']?>
                </div>
        </div>

        <? include __DIR__.'/banner-total.php'; ?>

        <ul class="breadcrumb">
          <? if ($this->_mode == 3): ?>
               <li><a href="/<?=$marka_lower?>/">Главная</a></li>
               <li><a href="/<?=$this->urlType($this->_datas['model_type']['name'])?>/">Ремонт <?=$this->_datas['orig_model_type'][0]['name_rm']?></a></li>
               <li><?=tools::mb_firstupper($this->_datas['syns'][3])?></li>
          <? endif; ?>
           <? if ($this->_mode == 2): ?>
               <li><a href="/<?=$marka_lower?>/">Главная</a></li>
               <li><a href="/<?=$this->urlType($this->_datas['model_type']['name'])?>/">Ремонт <?=$this->_datas['orig_model_type'][0]['name_rm']?></a></li>
               <li><?=$this->_datas['model']['sublineyka']?></li>
               <li><a href="/<?=$this->urlType($this->_datas['model_type']['name'])?>/<?=$modelUrl?>/"><?=$this->_datas['model']['name']?></a></li>
               <li><?=tools::mb_firstupper($this->_datas['syns'][3])?></li>
          <? endif; ?>
          </ul>
