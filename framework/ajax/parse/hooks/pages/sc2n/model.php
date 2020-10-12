<?
exit();

use framework\tools;
use framework\pdo;

$site_id = $this->_site_id;
$model_type = $this->_datas['model_type'][3];
$model_type_id = $this->_datas['model_type']['id'];
$marka_id = $this->_datas['marka']['id'];
$marka_lower = strtolower($this->_datas['marka']['name']);

if ($this->_mode == -2)
{
    $m_model_id = $this->_datas['m_model']['id'];
    $model_id = $this->_datas['model']['id'];
    $full_type_name = $model_type['name_re'].' '.$this->_datas['model']['name'];
    $full_name = $this->_datas['model']['name'];
    $full_ru_name = $this->_datas['model']['ru_name'];
    $f_name = tools::mb_ucfirst($model_type['name']).' '.$this->_datas['model']['name'];
}

if ($this->_mode == -3)
{
    $full_name = $full_type_name = $model_type['name_rm'].' '.$this->_datas['marka']['name'];
    $full_ru_name = $this->_datas['marka']['ru_name'];
    $f_name = tools::mb_ucfirst($model_type['name']).' '.$this->_datas['marka']['name'];
}

if ($this->_mode == -1)
{
    $m_model_id = $this->_datas['m_model']['id'];
    $full_name = $full_type_name = $model_type['name_rm'].' '.$this->_datas['marka']['name'].' '.$this->_datas['m_model']['name'];
    $full_ru_name = $this->_datas['marka']['ru_name'].' '.$this->_datas['m_model']['ru_name'];
    $f_name = tools::mb_ucfirst($model_type['name']).' '.$this->_datas['marka']['name'].' '.$this->_datas['m_model']['name'];
}

$setka_name = $this->_datas['setka_name'];

$eds = $this->_datas['eds'];
$availables = $this->_datas['availables'];

$all_services =  $this->_datas['all_services'];
$all_complects = $this->_datas['all_complects'];

#echo json_encode($all_services);

if ($this->_mode == -1)
{
    #if (isset($this->_datas['popular_models'])) $popular_models = $this->_datas['popular_models'];
    #if (isset($this->_datas['popular_m_models'])) $popular_m_models = $this->_datas['popular_m_models'];

    $m_model_id = $this->_datas['m_model']['id'];

    $dbh = pdo::getPdo();

    $stmt = $dbh->prepare("SELECT models.name, models.sublineyka FROM `models` JOIN m_models ON models.m_model_id = m_models.id  WHERE m_models.marka_id = ? AND model_type_id = ? AND m_model_id = ?");
    $stmt->execute([$marka_id, $model_type_id, $m_model_id]);
    $popular = $stmt->fetchAll();
    srand($marka_id+$model_type_id);
    shuffle($popular);
    srand();
}

if ($this->_mode == -3)
{

    $dbh = pdo::getPdo();

    $stmt = $dbh->prepare("SELECT name FROM `m_models` WHERE m_models.marka_id = ? AND model_type_id = ?");
    $stmt->execute([$marka_id, $model_type_id]);
    $popular = $stmt->fetchAll();
    srand($marka_id+$model_type_id);
    shuffle($popular);
    srand();
}

$price = tools::format_price(isset($this->_datas['price']) ? $this->_datas['price'] : 0, $setka_name);

$type_accord = array('n' => 4, 'p' => 5, 'f' => 3);


$accord_image = $this->_datas['accord_image'];
$this->_ret['img'] = 'userfiles/site/large/'.$accord_image[$this->_datas['orig_model_type']['0']['name']].'-'.mb_strtolower($this->_datas['marka']['name']).'.png';

?>
<section class="fixed content-wrapper">
<div class="content-block">

    <section class="crumbs">

    <? if ($this->_mode == -3): ?>
        <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="/"><meta itemprop="title" content="Главная"/><img src="/img/home.png" alt="home"/></a></span>
        <span> / </span>
        <span><?=tools::mb_ucfirst($this->_datas['orig_model_type'][0]['name_m'])?></span>
    <? endif; ?>

    <? if ($this->_mode == -1): ?>
        <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="/"><meta itemprop="title" content="Главная"/><img src="/img/home.png" alt="home"/></a></span>
        <span> / </span>
        <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="/<?=tools::search_url($site_id, serialize(array('model_type_id' => $model_type_id, 'marka_id' => $marka_id)))?>/"><span itemprop="title"><?=tools::mb_ucfirst($this->_datas['orig_model_type'][0]['name_m'])?></span></a></span>
        <span> / </span>
        <span><?=$this->_datas['m_model']['name']?></span>
    <? endif; ?>

    <? if ($this->_mode == -2): ?>
        <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="/"><meta itemprop="title" content="Главная"/><img src="/img/home.png" alt="home"/></a></span>
        <span> / </span>
        <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="/<?=tools::search_url($site_id, serialize(array('model_type_id' => $model_type_id, 'marka_id' => $marka_id)))?>/"><span itemprop="title"><?=tools::mb_ucfirst($this->_datas['orig_model_type'][0]['name_m'])?></span></a></span>
        <span> / </span>
        <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="/<?=tools::search_url($site_id, serialize(array('m_model_id' => $m_model_id)))?>/"><span itemprop="title"><?=$this->_datas['m_model']['name']?></span></a></span>
        <span> / </span>
        <span><?=$this->_datas['model']['name']?></span>
    <? endif; ?>

    </section>

    <div class="content-block__top">

        <div class="info-block remont-block" itemscope itemtype="http://schema.org/Product">

            <h1 itemprop="name"><?=$this->_ret['h1']?></h1>

            <img itemprop="image" src="/<?=$this->_ret['img']?>"/>
            <div class="block-wrp">
                <div itemprop="description">
                  <?php
                    include_once "text/type.php";
                    $genText = false;
                    if ($this->_mode == -3 && $this->_datas['region']['name'] == "Москва" && isset($typeText) && is_array($typeText)) {
                      if (isset($typeText[$this->_datas['orig_model_type'][0]['name_m']])) {
                        $text = $typeText[$this->_datas['orig_model_type'][0]['name_m']];
                        $genText = true;
                        //renderTypeText($text['text'][0]);
                        echo '<p>'.$text['desc'].'</p>';
                      }
                    }
                    if (!$genText)
                      echo $this->_ret['text'];
                  ?>
                </div>
                <div itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                    <span class="price" itemprop="price">от <?=$price?> <?=(($this->_datas['price'] > 0) ? 'р.' : '')?></span>
                    <meta itemprop="priceCurrency" content="RUB"/>
                    <a href="/order/?text=<?=urlencode($f_name)?>&type=<?=$type_accord[$this->_suffics]?>" class="btn btn--fill">Записаться на ремонт</a>
                </div>
            </div>

            <div class="clear"></div>
        </div>

    </div>
    <div class="divider divider--three"></div>

    <div class="content-block__bottom">
        <div class="info-block">
            <?php
              if ($this->_mode == -3 && $this->_datas['region']['name'] == "Москва" && isset($typeText) && is_array($typeText)) {
                if (isset($typeText[$this->_datas['orig_model_type'][0]['name_m']])) {
                  $text = $typeText[$this->_datas['orig_model_type'][0]['name_m']];
                  if (isset($text['text'][0]))
                    renderTypeText($text['text'][0]);
                }
              }
            ?>

            <span class="h2">Услуги и цены по ремонту <?=$full_name?></span>

             <div class="tab-block">

                    <input id="tab1" type="radio" name="tab" checked="checked"/>
                    <label for="tab1">Обслуживание <?=$full_type_name?></label>

                    <input id="tab2" type="radio" name="tab"/>
                    <label for="tab2">Комплектующие для <?=$full_ru_name?></label>

                    <section id="content1" class="frame">
                        <table class="priceTable">
                        <tbody>
                            <tr>
                                <td>Наименование работ</td>
                                <td>Гарантия</td>
                                <td>Цена, р.</td>
                                <td>&nbsp;</td>
                            </tr>
                            <? foreach ($all_services as $value):

                            if ($this->_mode == -2)
                                $href = tools::search_url($site_id, serialize(array('model_id' => $model_id, 'key' => 'service', 'id' => $value[$this->_suffics.'_service_id'])));

                            if ($this->_mode == -1)
                                $href = tools::search_url($site_id, serialize(array('m_model_id' => $m_model_id, 'key' => 'service', 'id' => $value[$this->_suffics.'_service_id'])));
                            ?>
                            <tr>
                                <td>
                                 <? if ($this->_mode == -2 || $this->_mode == -1): ?><a href="/<?=$href?>/"><?endif;?>
                                 <?=($n = tools::mb_firstupper($value['name']))?>
                                 <? if ($this->_mode == -2 || $this->_mode == -1): ?></a><?endif;?></td>
                                <td><?=tools::format_garantee($value['garantee'], $eds[$value[$this->_suffics.'_service_id']]['ed_garantee']);?></td>
                                <td><?=tools::format_price($value['price'], $setka_name)?></td>
                                <!--noindex--><td><a href="/order/?text=<?=urlencode($f_name.', '.$n)?>&type=<?=$type_accord[$this->_suffics]?>" class="order-btn">заказать со скидкой</a></td><!--/noindex-->
                            </tr>
                        <? endforeach; ?>
                        </tbody>
                        </table>
                        <?=$this->_datas['vars2']?>
                    </section>

                    <section id="content2" class="frame">
                        <table class="priceTable">
                        <tbody>
                            <tr>
                                <td>Название комплектующей</td>
                                <td>Наличие</td>
                                <td>Цена, р.</td>
                                <td>&nbsp;</td>
                            </tr>

                            <?  foreach ($all_complects as $value):?>
                            <?
                             if ($this->_mode == -2)
                                $href = tools::search_url($site_id, serialize(array('model_id' => $model_id, 'key' => 'complect', 'id' => $value[$this->_suffics.'_complect_id'])));

                             if ($this->_mode == -1)
                                $href = tools::search_url($site_id, serialize(array('m_model_id' => $m_model_id, 'key' => 'complect', 'id' => $value[$this->_suffics.'_complect_id'])));
                            ?>
                            <tr>
                                <td>
                                <? if ($this->_mode == -2 || $this->_mode == -1): ?><a href="/<?=$href?>/"><?endif;?>
                                <?=($n = tools::mb_firstupper($value['name']))?>
                                <? if ($this->_mode == -2 || $this->_mode == -1): ?></a><?endif;?></td>
                                <td><div class="amount"><?=$value['amount']?></div></td>
                                <td>от <?=tools::format_price($value['price'], $setka_name)?></td>
                                <!--noindex--><td><a href="/order/?text=<?=urlencode($f_name.', '.$n)?>&type=<?=$type_accord[$this->_suffics]?>" class="order-btn">заказать со скидкой</a></td><!--/noindex-->
                            </tr>
                            <? endforeach; ?>
                        </tbody>
                        </table>
                        <?=$this->_datas['vars3']?>
                     </section>
             </div>

             <?php
               if ($this->_mode == -3 && $this->_datas['region']['name'] == "Москва" && isset($typeText) && is_array($typeText)) {
                 if (isset($typeText[$this->_datas['orig_model_type'][0]['name_m']])) {
                   $text = $typeText[$this->_datas['orig_model_type'][0]['name_m']];
                   if (isset($text['text'][1]))
                     renderTypeText($text['text'][1]);
                 }
               }
             ?>

             <? if (($this->_mode == -3)): ?>
               <span class="h2">Популярные модели</span>

               <section class="frame">
               <ul class="list three">
                 <?php
                  foreach ($popular as $p) {
                    echo '<li><a href = "'.$marka_lower.'-'.preg_replace('/(\s+|\.)/', '-', mb_strtolower($p['name'])).'/">'.$p['name'].'</a></li>';
                 } ?>
                </ul>
                </section>
            <? endif; ?>

            <? if (($this->_mode == -1)): ?>
                <span class="h2">Популярные устройства</span>
                <section class="frame">
                <ul class="list three">
                  <?php
                   $sublineykaName = $popular[0]['sublineyka'];
                   $reUrl = '/('.$sublineykaName.'[\s-]|'.$this->_datas['marka']['name'].'[\s])/i';
                   foreach (array_slice($popular, 0, 8) as $p) {
                     $url = preg_replace('/(\s+|\.)/', '-', preg_replace($reUrl, '', $p['name']));
                     echo '<li><a href = "'.mb_strtolower($url).'/">'.$p['name'].'</a></li>';
                  } ?>
                </ul>
                </section>
            <? endif; ?>

            <?=$this->_datas['vars4']?>
            <?=$this->_datas['addition']?>
        </div>
        <a href="/order/?text=<?=urlencode($f_name)?>&type=<?=$type_accord[$this->_suffics]?>" class="btn btn--fill">Записаться на ремонт</a>
    </div>
</div>
<? include __DIR__.'/js.php'; ?>

<? include __DIR__.'/aside2.php'; ?>
</section>
<div class="clear"></div>
<section class="crumbs fixed">

<? if ($this->_mode == -3): ?>
    <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="/"><meta itemprop="title" content="Главная"/>Сервисный центр <?=$this->_datas['marka']['name']?> в <?=tools::mb_ucfirst($this->_datas['region']['name_pe'])?></a></span>
    <span> / </span>
    <span>Ремонт <?=$this->_datas['model_type'][1]['name_rm']?> <?=$this->_datas['marka']['name']?></span>
<? endif; ?>

<? if ($this->_mode == -1): ?>
    <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="/"><meta itemprop="title" content="Главная"/>Сервисный центр <?=$this->_datas['marka']['name']?> в <?=tools::mb_ucfirst($this->_datas['region']['name_pe'])?></a></span>
    <span> / </span>
    <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="/<?=tools::search_url($site_id, serialize(array('model_type_id' => $model_type_id, 'marka_id' => $marka_id)))?>/"><span itemprop="title">Ремонт <?=$this->_datas['model_type'][1]['name_rm']?> <?=$this->_datas['marka']['name']?></span></a></span>
    <span> / </span>
    <span><?=$this->_datas['m_model']['name']?></span>
<? endif; ?>

<? if ($this->_mode == -2): ?>
    <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="/"><meta itemprop="title" content="Главная"/>Сервисный центр <?=$this->_datas['marka']['name']?> в <?=tools::mb_ucfirst($this->_datas['region']['name_pe'])?></a></span>
    <span> / </span>
    <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="/<?=tools::search_url($site_id, serialize(array('model_type_id' => $model_type_id, 'marka_id' => $marka_id)))?>/"><span itemprop="title">Ремонт <?=$this->_datas['model_type'][1]['name_rm']?> <?=$this->_datas['marka']['name']?></span></a></span>
    <span> / </span>
    <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="/<?=tools::search_url($site_id, serialize(array('m_model_id' => $m_model_id)))?>/"><span itemprop="title"><?=$this->_datas['m_model']['name']?></span></a></span>
    <span> / </span>
    <span><?=$this->_datas['model']['name']?></span>
<? endif; ?>

</section>
