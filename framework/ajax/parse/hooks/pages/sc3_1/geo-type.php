<?

use framework\tools;
use framework\pdo;

$site_id = $this->_site_id;
$model_type = $this->_datas['model_type'];
$model_type_id = $this->_datas['model_type']['id'];

if (isset($this->_datas['marka'])) $marka_id = $this->_datas['marka']['id'];

$dbh = $this->dbh;

$setka_name = $this->_datas['setka_name'];

#$eds = $this->_datas['eds'];
#$availables = $this->_datas['availables'];

$all_services =  $this->_datas['all_services'];
$all_complects = $this->_datas['all_complects'];

srand($this->_datas['feed']);
shuffle($all_complects);
shuffle($all_services);
srand();

$price = tools::format_price($this->_datas['price'], $setka_name);
$price_str = 'от <span>'.$price.'</span>';

?>

        <div class="title-row">
            <div class="container">
                <h1><?=$this->_ret['h1']?></h1>
            </div>
        </div>

        <? include __DIR__.'/banner.php'; ?>

        <ul class="breadcrumb">
        <? if ($this->_mode == 112): ?>
            <li><a href="/<?=$marka_lower?>/">Главная</a></li>
            <li><a href="/<?=$this->urlType($this->_datas['model_type']['name'])?>/">Ремонт <?=$this->_datas['orig_model_type'][0]['name_rm']?> <?=$this->_datas['marka']['name']?></a></li>
            <li><?=$this->_datas['geo']['name']?></li>
        <? endif; ?>
        <? if ($this->_mode == 111): ?>
            <li><a href="/<?=$marka_lower?>/">Главная</a></li>
            <li>Ремонт <?=$this->_datas['orig_model_type'][0]['name_rm']?> <?=$this->_datas['geo']['name']?></li>
        <? endif; ?>
        </ul>

        <div class="aboutrow">
            <div class="container">
                <div class="abouttext">
                    <?=$this->_ret['plain']?>
                </div>
            </div>
        </div>

        <div class="servicerow">
            <div class="container">
                <h2>Услуги</h2>
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
                            <?foreach ($all_services as $value):
                              if ($this->_mode == 112) {
                                $hrefService = $value['url'];
                                $hrefS = $this->urlType($this->_datas['model_type']['name']).'/'.$hrefService;
                              }
                            ?>
                            <tr>
                                <td><?php if (isset($hrefS)) { ?><a href="/<?=$hrefS?>/"><?=tools::mb_firstupper($value['name'])?></a><?php } else { ?><?=tools::mb_firstupper($value['name'])?><?php } ?></td>
                                <td><?=($value['time_min']."-".$value['time_max'])?></td>
                                <td><?=tools::format_price($value['cost'], $setka_name)?></td>
                            </tr>
                            <? endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="servicerow">
            <div class="container">
                <h2>Оборудование</h2>
                <div class="servicetable">
                    <table>
                        <thead>
                            <tr>
                                <th>Оборудование</th>
                                <th><?php if (isset($this->_datas['marka'])) { ?>Наличие<?php } ?></th>
                                <th>Цена, руб</th>
                            </tr>
                        </thead>
                        <tbody>
                           <? foreach ($all_complects as $value):
                            if ($this->_mode == 112) {
                              $hrefComplect = $value['url'];
                              $hrefC = $this->urlType($this->_datas['model_type']['name'], true).'/'.$hrefComplect;
                            }
                            ?>
                            <tr>
                                <td><?php if (isset($hrefC)) { ?><a href="/<?=$hrefC?>/"><?=tools::mb_firstupper($value['name'])?></a><?php } else { ?><?=tools::mb_firstupper($value['name'])?><?php } ?></td>
                                <td><?php if (isset($this->_datas['marka'])) { ?><div class="amount"><?=$this->randAmount($value['id'])?></div><?php } ?></td>
                                <td>от <?=tools::format_price($value['price'], $setka_name)?></td>
                            </tr>
                            <? endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <? include __DIR__.'/banner-total.php'; ?>
