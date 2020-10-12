<?

use framework\tools;
use framework\pdo;

$site_id = $this->_site_id;
$model_type = $this->_datas['model_type'][3];
$model_type_id = $this->_datas['model_type']['id'];
$marka_id = $this->_datas['marka']['id'];

$dbh = pdo::getPdo();

if ($this->_mode == -2)
{
    $model_id = $this->_datas['model']['id'];
    $sublineyka_id = $this->_datas['sublineyka']['id'];
}

if ($this->_mode == -3)
{
  if (in_array($this->_datas['region']['name'], ['Новосибирск', 'Нижний Новгород', 'Екатеринбург', 'Казань', 'Санкт-Петербург', 'Москва'])) {
    $stmt = $dbh->prepare("SELECT name FROM `m_models` WHERE m_models.marka_id = ? AND model_type_id = ?");
    $stmt->execute([$marka_id, $model_type_id]);
    $popular = $stmt->fetchAll();
  }
}

if ($this->_mode == -5)
{
    $sublineyka_id = $this->_datas['sublineyka']['id'];
    $sublineykaName = $this->_datas['sublineyka']['name'];

    if (in_array($this->_datas['region']['name'], ['Новосибирск', 'Нижний Новгород', 'Екатеринбург', 'Казань', 'Санкт-Петербург', 'Москва'])) {
      $stmt = $dbh->prepare("SELECT models.name FROM `models` JOIN m_models ON models.m_model_id = m_models.id  WHERE m_models.marka_id = ? AND model_type_id = ? AND sublineyka = ?");
      $stmt->execute([$marka_id, $model_type_id, $sublineykaName]);
      $popular = $stmt->fetchAll();
    }
}

$setka_name = $this->_datas['setka_name'];

$eds = $this->_datas['eds'];
$availables = $this->_datas['availables'];

$all_services =  $this->_datas['all_services'];
$all_complects = $this->_datas['all_complects'];

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
        <? if ($this->_mode == -3): ?>
             <li><a href="/">Главная</a></li>
             <li>Ремонт <?=$this->_datas['orig_model_type'][0]['name_rm']?></li>
        <? endif; ?>
        <? if ($this->_mode == -5): ?>
             <li><a href="/">Главная</a></li>
             <li><a href="/<?=tools::search_url($site_id, serialize(array('model_type_id' => $model_type_id, 'marka_id' => $marka_id)))?>/">Ремонт <?=$this->_datas['orig_model_type'][0]['name_rm']?></a></li>
             <li><?=$this->_datas['sublineyka']['name']?></li>
        <? endif; ?>
         <? if ($this->_mode == -2): ?>
             <li><a href="/">Главная</a></li>
             <li><a href="/<?=tools::search_url($site_id, serialize(array('model_type_id' => $model_type_id, 'marka_id' => $marka_id)))?>/">Ремонт <?=$this->_datas['orig_model_type'][0]['name_rm']?></a></li>
             <li><a href="/<?=tools::search_url($site_id, serialize(array('sublineyka_id' => $sublineyka_id)))?>/"> <?=$this->_datas['sublineyka']['name']?></a></li>
             <li><?=$this->_datas['model']['name']?></li>
        <? endif; ?>
        </ul>

        <div class="aboutrow">
            <div class="container">
                <div class="abouttext">
                    <?=$this->_ret['text']?>
                </div>
            </div>
        </div>

        <? if ($this->_mode == -3 && isset($this->_datas['block_text'])): ?>
        <div class="popularrow">
            <div class="container">
                <div class="tables-wrapper block-text">
                    <?=$this->_datas['block_text']?>
                </div>
            </div>
        </div>
        <? endif; ?>

        <div class="popularrow models">
            <div class="container">
                 <? if ($this->_mode == -3) :?>
                     <h2>Популярные линейки</h2>
                     <ul class="popularlist">
                       <?php
                        foreach ($popular as $p) {
                          echo '<li><a href = "'.preg_replace('/-series/ui', '', preg_replace('/(\s+|\.)/', '_', mb_strtolower($p['name']))).'/">'.$p['name'].'</a></li>';
                       } ?>
                     </ul>
                <?endif;?>
                <? if ($this->_mode == -5) :?>
                     <h2>Популярные устройства</h2>
                     <ul class="popularlist">
                       <?php
                        $reUrl = $marka_lower != 'meizu' ? '/('.$sublineykaName.'[\s-]|'.$this->_datas['marka']['name'].'[\s-])/i' : '/('.$this->_datas['marka']['name'].'[\s-])/i';
                        foreach (array_slice($popular, 0, 8) as $p) {
                          $url = preg_replace('/(\s+|\.)/', '_', preg_replace($reUrl, '', $p['name']));
                          echo '<li><a href = "'.mb_strtolower($url).'/">'.$p['name'].'</a></li>';
                       } ?>
                     </ul>
                <?endif;?>
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
                                <th>Время, час</th>
                                <th>Цена, руб</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?foreach ($all_services as $value):
                                if ($this->_mode == -2)
                                    $href = tools::search_url($site_id, serialize(array('model_id' => $model_id, 'key' => 'service', 'id' => $value[$this->_suffics.'_service_id'])));

                                if ($this->_mode == -3)
                                    $href = tools::search_url($site_id, serialize(array('model_type_id' => $model_type_id, 'marka_id' => $marka_id, 'key' => 'service', 'id' => $value[$this->_suffics.'_service_id'])));

                                if ($this->_mode == -5)
                                    $href = tools::search_url($site_id, serialize(array('sublineyka_id' => $sublineyka_id, 'key' => 'service', 'id' => $value[$this->_suffics.'_service_id'])));

                            ?>
                            <tr>
                                <td><a href="/<?=$href?>/"><?=tools::mb_firstupper($value['name'])?></a></td>
                                <td><?=str_replace(array('часа', 'час'), '', tools::format_time($value['time_min'], $value['time_max'], $eds[$value[$this->_suffics.'_service_id']]['ed_time']))?></td>
                                <td><?=tools::format_price($value['price'], $setka_name)?></td>
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
                                <th>Наличие</th>
                                <th>Цена, руб</th>
                            </tr>
                        </thead>
                        <tbody>
                           <?foreach ($all_complects as $value):
                            if ($this->_mode == -2)
                                    $href = tools::search_url($site_id, serialize(array('model_id' => $model_id, 'key' => 'complect', 'id' => $value[$this->_suffics.'_complect_id'])));

                            if ($this->_mode == -3)
                                    $href = tools::search_url($site_id, serialize(array('model_type_id' => $model_type_id, 'marka_id' => $marka_id, 'key' => 'complect', 'id' => $value[$this->_suffics.'_complect_id'])));

                            if ($this->_mode == -5)
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

        <? include __DIR__.'/banner-total.php'; ?>

        <ul class="breadcrumb">
        <? if ($this->_mode == -3): ?>
             <li><a href="/">Главная</a></li>
             <li>Ремонт <?=$this->_datas['orig_model_type'][0]['name_rm']?></li>
        <? endif; ?>
        <? if ($this->_mode == -5): ?>
             <li><a href="/">Главная</a></li>
             <li><a href="/<?=tools::search_url($site_id, serialize(array('model_type_id' => $model_type_id, 'marka_id' => $marka_id)))?>/">Ремонт <?=$this->_datas['orig_model_type'][0]['name_rm']?></a></li>
             <li>Ремонт <?=$this->_datas['sublineyka']['name']?></li>
        <? endif; ?>
         <? if ($this->_mode == -2): ?>
             <li><a href="/">Главная</a></li>
             <li><a href="/<?=tools::search_url($site_id, serialize(array('model_type_id' => $model_type_id, 'marka_id' => $marka_id)))?>/">Ремонт <?=$this->_datas['orig_model_type'][0]['name_rm']?></a></li>
             <li><a href="/<?=tools::search_url($site_id, serialize(array('sublineyka_id' => $sublineyka_id)))?>/">Ремонт <?=$this->_datas['sublineyka']['name']?></a></li>
             <li>Ремонт <?=$this->_datas['model']['name']?></li>
        <? endif; ?>
        </ul>
