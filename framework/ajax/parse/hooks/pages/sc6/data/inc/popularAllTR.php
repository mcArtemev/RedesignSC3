<?php

use framework\ajax\parse\hooks\pages\sc6\data\src\service_service;

?>

<div>
    <div class="part_header">
        <h2 class="part-title part-title__left part-title__light" style="font-size: 24px;">Время ремонта популярных устройств <?=$this->_datas['marka']['name']?></h2>
    </div>
    <div class="service-price">
        <div class="service-price__item">
            <table class="simple-example-table">
                <thead>
                <tr>
                    <th>Услуга</th>
                    <th>Время ремонта (мин)</th>
                </tr>
                </thead>
                <tbody>
                  <? foreach (service_service::groups($services) as $nameGroup => $group) {
                    if (is_string($nameGroup) && count($group)) {
                    ?>
                    <tr class = "titleGroup"><td colspan = "2"><?=$nameGroup?></td></tr>
                  <?php }
                  foreach ($group as $service) { ?>
                  <tr>
                      <td><span><?=$service['name']?></span></td>
                      <td><?=$service['time']?></td>
                  </tr>
                <? }} ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
