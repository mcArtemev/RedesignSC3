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
  $m_model_id = $this->_datas['m_model']['id'];
  $modelUrl = $this->translit($this->_datas['m_model']['name']);
}

$setka_name = $this->_datas['setka_name'];

#$eds = $this->_datas['eds'];
#$availables = $this->_datas['availables'];

$complect = $this->_datas['complect'];

$complect_name = tools::mb_firstupper($complect['name']);
$complect_amount = $this->randAmount($complect['id']);
$complect_price = tools::format_price($this->costComplect($complect['costs'], $complect['id']), $setka_name);
$price_str = 'от <span>'.$complect_price.'</span>';

$servicesComplect = $this->_datas['servicesComplect'];
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
              <li><a href="/<?=$marka_lower?>/">Главная</a></li>
              <li><a href="/<?=$this->urlType($this->_datas['model_type']['name'])?>/">Ремонт <?=$this->_datas['orig_model_type'][0]['name_rm']?> <?=$this->_datas['marka']['name']?></a></li>
              <li><?=tools::mb_firstupper($this->_datas['syns'][3])?></li>
         <? endif; ?>
          <? if ($this->_mode == 2): ?>
              <li><a href="/<?=$marka_lower?>/">Главная</a></li>
              <li><a href="/<?=$this->urlType($this->_datas['model_type']['name'])?>/">Ремонт <?=$this->_datas['orig_model_type'][0]['name_rm']?> <?=$this->_datas['marka']['name']?></a></li>
              <li><?php if ($this->_datas['m_model']['frequency'] > 0) { ?><a href = "/<?=$this->urlType($this->_datas['model_type']['name'])?>/<?=$this->translit($this->_datas['m_model']['name'])?>/"><?=$this->_datas['m_model']['name']?></a><?php } else { ?><?=$this->_datas['m_model']['name']?><?php } ?></li>
              <li><a href="/<?=$this->urlType($this->_datas['model_type']['name'])?>/<?=$modelUrl?>/"><?=$this->_datas['model']['name']?></a></li>
              <li><?=tools::mb_firstupper($this->_datas['syns'][3])?></li>
         <? endif; ?>
         <? if ($this->_mode == 5): ?>
             <li><a href="/<?=$marka_lower?>/">Главная</a></li>
             <li><a href="/<?=$this->urlType($this->_datas['model_type']['name'])?>/">Ремонт <?=$this->_datas['orig_model_type'][0]['name_rm']?> <?=$this->_datas['marka']['name']?></a></li>
             <li><?php if ($this->_datas['m_model']['frequency'] > 0) { ?><a href = "/<?=$this->urlType($this->_datas['model_type']['name'])?>/<?=$this->translit($this->_datas['m_model']['name'])?>/"><?=$this->_datas['m_model']['name']?></a><?php } else { ?><?=$this->_datas['m_model']['name']?><?php } ?></li>
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
                    <? if (count($servicesComplect)):?>
                        <table>
                            <thead>
                                <tr>
                                    <th>Услуга</th>
                                    <th>Время, мин</th>
                                    <th>Цена, руб</th>
                                </tr>
                            </thead>
                            <tbody>
                              <?foreach ($servicesComplect as $value):
                                $hrefService = $value['url'];
                                  if ($this->_mode == 2)
                                      $href = $this->urlType($this->_datas['model_type']['name']).'/'.$modelUrl.'/'.$hrefService;

                                  if ($this->_mode == 3)
                                      $href = $this->urlType($this->_datas['model_type']['name']).'/'.$hrefService;

                                  if ($this->_mode == 5)
                                      $href = $this->urlType($this->_datas['model_type']['name']).'/'.$modelUrl.'/'.$hrefService;


                                  //$href = $this->urlType($this->_datas['model_type']['name']).'/'.$hrefService;
                              ?>
                              <tr>
                                  <td><a href="/<?=$href?>/"><?=tools::mb_firstupper($value['name'])?></a></td>
                                  <td><?=($value['time_min']."-".$value['time_max'])?></td>
                                  <td><?=tools::format_price($value['cost'], $setka_name)?></td>
                              </tr>
                              <? endforeach; ?>
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
                                <th>Время, мин</th>
                                <th>Цена, руб</th>
                            </tr>
                        </thead>
                        <tbody>
                             <?foreach ($dop_services as $value):?>
                            <tr>
                                <td><?=tools::mb_firstupper($value['name'])?></td>
                                <td><?=($value['time_min']."-".$value['time_max'])?></td>
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
                    <h2>Другие комплектующие</h2>
                    <div class="servicetable">
                        <table>
                            <thead>
                                <tr>
                                    <th>Оборудование</th><th>Наличие</th><th>Цена, руб</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?

                                foreach (array_slice($other_complects, 0, 7) as $value):
                                  $hrefComplect = $value['url'];
                                    if ($this->_mode == 2)
                                        $href = $this->urlType($this->_datas['model_type']['name'], true).'/'.$modelUrl.'/'.$hrefComplect;

                                    if ($this->_mode == 3)
                                        $href = $this->urlType($this->_datas['model_type']['name'], true).'/'.$hrefComplect;

                                    if ($this->_mode == 5)
                                        $href = $this->urlType($this->_datas['model_type']['name'], true).'/'.$modelUrl.'/'.$hrefComplect;

                                ?>
                                <tr>
                                    <td><a href="/<?=$href?>/"><?=tools::mb_firstupper($value['name'])?></a></td>
                                    <td><div class="amount"><?=$this->randAmount($value['id'])?></div></td>
                                    <td>от <?=tools::format_price($this->costComplect($value['costs'], $value['id']), $setka_name)?></td>
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
             <li><a href="/<?=$marka_lower?>/">Главная</a></li>
             <li><a href="/<?=$this->urlType($this->_datas['model_type']['name'])?>/">Ремонт <?=$this->_datas['orig_model_type'][0]['name_rm']?> <?=$this->_datas['marka']['name']?></a></li>
             <li><?=tools::mb_firstupper($this->_datas['syns'][3])?></li>
        <? endif; ?>
         <? if ($this->_mode == 2): ?>
             <li><a href="/<?=$marka_lower?>/">Главная</a></li>
             <li><a href="/<?=$this->urlType($this->_datas['model_type']['name'])?>/">Ремонт <?=$this->_datas['orig_model_type'][0]['name_rm']?> <?=$this->_datas['marka']['name']?></a></li>
             <li><?php if ($this->_datas['m_model']['frequency'] > 0) { ?><a href = "/<?=$this->urlType($this->_datas['model_type']['name'])?>/<?=$this->translit($this->_datas['m_model']['name'])?>/"><?=$this->_datas['m_model']['name']?></a><?php } else { ?><?=$this->_datas['m_model']['name']?><?php } ?></li>
             <li><a href="/<?=$this->urlType($this->_datas['model_type']['name'])?>/<?=$modelUrl?>/"><?=$this->_datas['model']['name']?></a></li>
             <li><?=tools::mb_firstupper($this->_datas['syns'][3])?></li>
        <? endif; ?>
        <? if ($this->_mode == 5): ?>
            <li><a href="/<?=$marka_lower?>/">Главная</a></li>
            <li><a href="/<?=$this->urlType($this->_datas['model_type']['name'])?>/">Ремонт <?=$this->_datas['orig_model_type'][0]['name_rm']?> <?=$this->_datas['marka']['name']?></a></li>
            <li><?php if ($this->_datas['m_model']['frequency'] > 0) { ?><a href = "/<?=$this->urlType($this->_datas['model_type']['name'])?>/<?=$this->translit($this->_datas['m_model']['name'])?>/"><?=$this->_datas['m_model']['name']?></a><?php } else { ?><?=$this->_datas['m_model']['name']?><?php } ?></li>
            <li><?=tools::mb_firstupper($this->_datas['syns'][3])?></li>
       <? endif; ?>
        </ul>
