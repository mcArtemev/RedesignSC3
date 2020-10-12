<?

use framework\tools;
use framework\pdo;

$site_id = $this->_site_id;
$model_type = $this->_datas['model_type'];
$model_type_id = $this->_datas['model_type']['id'];
$marka_id = $this->_datas['marka']['id'];

$dbh = $this->dbh;

if ($this->_mode == -2)
{
    $model_id = $this->_datas['model']['id'];
    $modelUrl = $this->translit($this->clearBrandLin($this->_datas['model']['name'], $marka_lower));
}

if ($this->_mode == -3)
{
  $stmt = $dbh->prepare("
  SELECT * FROM
  (
    (SELECT 'm' as 'type', models.name as 'name', models.frequency as 'frequency' FROM `models` JOIN m_models ON models.m_model_id = m_models.id WHERE m_models.marka_id = ? AND model_type_id = ? AND popular = 1 ORDER BY `frequency` DESC LIMIT 6)
    UNION
    (SELECT 'mm' as 'type', m_models.name as 'name', m_models.frequency as 'frequency' FROM m_models WHERE m_models.marka_id = ? AND model_type_id = ? AND `frequency` > 0 ORDER BY `frequency` DESC LIMIT 6)
   ) m
  ");
  $stmt->execute([$marka_id, $model_type_id, $marka_id, $model_type_id]);
  $popular = $stmt->fetchAll(\PDO::FETCH_ASSOC);

  if (count($popular) < 12) {
    $stmt = $dbh->prepare("SELECT 'm' as 'type', models.name FROM `models` JOIN m_models ON models.m_model_id = m_models.id  WHERE m_models.marka_id = ? AND model_type_id = ? AND popular != 1");
    $stmt->execute([$marka_id, $model_type_id]);
    $popular1 = $stmt->fetchAll(\PDO::FETCH_ASSOC);

    srand($this->_datas['feed']);
    shuffle($popular1);
    srand();

    $popular = array_merge($popular, $popular1);
  }
}

if ($this->_mode == -5)
{

  $m_model_id = $this->_datas['m_model']['id'];
  $m_modelUrl = $this->translit($this->_datas['m_model']['name']);

  $stmt = $dbh->prepare("SELECT 'm' as 'type', models.name FROM `models` WHERE m_model_id = ? AND popular = 1");
  $stmt->execute([$this->_datas['m_model']['id']]);
  $popular = $stmt->fetchAll(\PDO::FETCH_ASSOC);

  if (count($popular) < 8) {
    $stmt = $dbh->prepare("SELECT 'm' as 'type', models.name FROM `models` WHERE m_model_id = ? AND popular != 1");
    $stmt->execute([$this->_datas['m_model']['id']]);
    $popular1 = $stmt->fetchAll(\PDO::FETCH_ASSOC);

    srand($this->_datas['feed']);
    shuffle($popular1);
    srand();

    $popular = array_merge($popular, $popular1);
  }
}

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
        <? if ($this->_mode == -3): ?>
             <li><a href="/<?=$marka_lower?>/">Главная</a></li>
             <li>Ремонт <?=$this->_datas['orig_model_type'][0]['name_rm']?> <?=$this->_datas['marka']['name']?></li>
        <? endif; ?>
         <? if ($this->_mode == -2): ?>
             <li><a href="/<?=$marka_lower?>/">Главная</a></li>
             <li><a href="/<?=$this->urlType($this->_datas['model_type']['name'])?>/">Ремонт <?=$this->_datas['orig_model_type'][0]['name_rm']?> <?=$this->_datas['marka']['name']?></a></li>
             <li><?php if ($this->_datas['m_model']['frequency'] > 0) { ?><a href = "/<?=$this->urlType($this->_datas['model_type']['name'])?>/<?=$this->translit($this->_datas['m_model']['name'])?>/"><?=$this->_datas['m_model']['name']?></a><?php } else { ?><?=$this->_datas['m_model']['name']?><?php } ?></li>
             <li><?=$this->_datas['model']['name']?></li>
        <? endif; ?>
        <? if ($this->_mode == -5): ?>
            <li><a href="/<?=$marka_lower?>/">Главная</a></li>
            <li><a href="/<?=$this->urlType($this->_datas['model_type']['name'])?>/">Ремонт <?=$this->_datas['orig_model_type'][0]['name_rm']?> <?=$this->_datas['marka']['name']?></a></li>
            <li><?=$this->_datas['m_model']['name']?></li>
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
                <? if ($this->_mode == -3 || $this->_mode == -5 && count($popular)) :?>
                     <h2>Популярные устройства</h2>
                     <ul class="popularlist">
                       <?php
                        foreach (array_slice($popular, 0, 12) as $p) {
                          $modelUrl = $p['type'] == 'm' ? $this->translit($this->clearBrandLin($p['name'], $marka_lower)) : $this->translit($p['name']);
                          $url = $this->urlType($this->_datas['model_type']['name']).'/'.$modelUrl;
                          echo '<li><a href = "/'.mb_strtolower($url).'/">'.$p['name'].'</a></li>';
                       } ?>
                     </ul>
                <?endif;?>
                <? if ($this->_mode == -2 && count($this->_datas['other_models'])) :?>
                     <h2>Другие устройства</h2>
                     <ul class="popularlist">
                       <?php
                        foreach (array_slice($this->_datas['other_models'], 0, 8) as $m) {
                          $url = $this->urlType($this->_datas['model_type']['name']).'/'.$this->translit($this->clearBrandLin($m['name'], $marka_lower));
                          echo '<li><a href = "/'.mb_strtolower($url).'/">'.$m['name'].'</a></li>';
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
                                <th>Время, мин</th>
                                <th>Цена, руб</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?foreach ($all_services as $value):
                              $hrefService = $value['url'];
                                if ($this->_mode == -2)
                                    $href = $this->urlType($this->_datas['model_type']['name']).'/'.$modelUrl.'/'.$hrefService;

                                if ($this->_mode == -3)
                                    $href = $this->urlType($this->_datas['model_type']['name']).'/'.$hrefService;

                                if ($this->_mode == -5)
                                    $href = $this->urlType($this->_datas['model_type']['name']).'/'.$m_modelUrl.'/'.$hrefService;


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
                           <? foreach ($all_complects as $value):
                             $hrefComplect = $value['url'];
                             if ($this->_mode == -2)
                                 $href = $this->urlType($this->_datas['model_type']['name'], true).'/'.$modelUrl.'/'.$hrefComplect;

                             if ($this->_mode == -3)
                                 $href = $this->urlType($this->_datas['model_type']['name'], true).'/'.$hrefComplect;

                             if ($this->_mode == -5)
                                 $href = $this->urlType($this->_datas['model_type']['name'], true).'/'.$m_modelUrl.'/'.$hrefComplect;

                            //$href = $this->urlType($this->_datas['model_type']['name'], true).'/'.$hrefComplect;
                            ?>
                            <tr>
                                <td><a href="/<?=$href?>/"><?=tools::mb_firstupper($value['name'])?></a></td>
                                <td><div class="amount"><?=$this->randAmount($value['id'])?></div></td>
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
             <li><a href="/<?=$marka_lower?>/">Главная</a></li>
             <li>Ремонт <?=$this->_datas['orig_model_type'][0]['name_rm']?> <?=$this->_datas['marka']['name']?></li>
        <? endif; ?>
         <? if ($this->_mode == -2): ?>
             <li><a href="/<?=$marka_lower?>/">Главная</a></li>
             <li><a href="/<?=$this->urlType($this->_datas['model_type']['name'])?>/">Ремонт <?=$this->_datas['orig_model_type'][0]['name_rm']?> <?=$this->_datas['marka']['name']?></a></li>
             <li><?php if ($this->_datas['m_model']['frequency'] > 0) { ?><a href = "/<?=$this->urlType($this->_datas['model_type']['name'])?>/<?=$this->translit($this->_datas['m_model']['name'])?>/"><?=$this->_datas['m_model']['name']?></a><?php } else { ?><?=$this->_datas['m_model']['name']?><?php } ?></li>
             <li><?=$this->_datas['model']['name']?></li>
        <? endif; ?>
        <? if ($this->_mode == -5): ?>
            <li><a href="/<?=$marka_lower?>/">Главная</a></li>
            <li><a href="/<?=$this->urlType($this->_datas['model_type']['name'])?>/">Ремонт <?=$this->_datas['orig_model_type'][0]['name_rm']?> <?=$this->_datas['marka']['name']?></a></li>
            <li><?=$this->_datas['m_model']['name']?></li>
       <? endif; ?>
        </ul>
