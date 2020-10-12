<?

use framework\tools;
use framework\pdo;

$site_id = $this->_site_id;
$model_type = $this->_datas['model_type'];
$model_type_id = $this->_datas['model_type']['id'];
$marka_id = $this->_datas['marka']['id'];
$marka_lower = strtolower($this->_datas['marka']['name']);

if ($this->_mode == -2)
{
    $model = $this->_datas['model'];
    $m_model_id = $this->_datas['m_model']['id'];
    $model_id = $this->_datas['model']['id'];
    $full_type_name = $model_type['name_re'].' '.$this->_datas['model']['name'];
    $full_name = $this->_datas['model']['name'];
    $full_ru_name = $this->_datas['model']['ru_name'];
    $f_name = tools::mb_ucfirst($model_type['name']).' '.$this->_datas['model']['name'];

    $all_complects = $this->_datas['complects'];
}

if ($this->_mode == -3)
{
    $full_name = $full_type_name = $model_type['name_rm'].' '.$this->_datas['marka']['name'];
    $full_ru_name = $this->_datas['marka']['ru_name'];
    $f_name = tools::mb_ucfirst($model_type['name']).' '.$this->_datas['marka']['name'];
    $all_complects = $this->_datas['complects'];
}

$setka_name = $this->_datas['setka_name'];

#$eds = $this->_datas['eds'];
#$availables = $this->_datas['availables'];

$all_services = $this->_datas['services'];

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

    $stmt = $this->dbh->prepare("SELECT models.name FROM `models` JOIN m_models ON models.m_model_id = m_models.id WHERE m_models.marka_id = ? AND model_type_id = ?");
    $stmt->execute([$marka_id, $model_type_id]);
    $popular = array_column($stmt->fetchAll(), 0);
    srand($marka_id+$model_type_id);
    shuffle($popular);
    srand();
}

$price = tools::format_price(isset($this->_datas['price']) ? $this->_datas['price'] : 0, $setka_name);

$accord = $this->_datas['typeUrl'];
$type_accord = array('n' => 4, 'p' => 5, 'f' => 3);


$accord_image = $this->_datas['accord_image'];
$this->_ret['img'] = 'userfiles/site/large/'.$accord_image[$this->_datas['model_type']['name']].'-'.mb_strtolower($this->_datas['marka']['name']).'.png';

$textHub = require_once "text/hub.php";

?>
<section class="fixed content-wrapper">
<div class="content-block">

  <section class="crumbs">

  <? if ($this->_mode == -3): ?>
      <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="/servis-<?=$marka_lower?>/"><span itemprop="title">Cервис <?=$this->_datas['marka']['name']?></span></a></span>
      <span> / </span>
      <span>Ремонт <?=$this->_datas['model_type']['name_rm']?> <?=$this->_datas['marka']['name']?></span>
  <? endif; ?>

  <? if ($this->_mode == -1): ?>
      <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="/servis-<?=$marka_lower?>/"><span itemprop="title">Cервис <?=$this->_datas['marka']['name']?></span></a></span>
      <span> / </span>
      <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="/<?=tools::search_url($site_id, serialize(array('model_type_id' => $model_type_id, 'marka_id' => $marka_id)))?>/"><span itemprop="title">Ремонт <?=$this->_datas['model_type']['name_rm']?> <?=$this->_datas['marka']['name']?></span></a></span>
      <span> / </span>
      <span><?=$this->_datas['m_model']['name']?></span>
  <? endif; ?>

  <? if ($this->_mode == -2): ?>
      <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="/servis-<?=$marka_lower?>/"><span itemprop="title">Cервис <?=$this->_datas['marka']['name']?></span></a></span>
      <span> / </span>
      <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="/<?=$accord[$this->_datas['model_type']['name']]?>/"><span itemprop="title">Ремонт <?=$this->_datas['model_type']['name_rm']?> <?=$this->_datas['marka']['name']?></span></a></span>
      <span> / </span>
      <span><?=$this->_datas['m_model']['name']?></span>
      <span> / </span>
      <span><?=$this->_datas['model']['name']?></span>
  <? endif; ?>

  </section>

  <div class="content-block__top">

      <div class="info-block remont-block" itemscope itemtype="http://schema.org/Product">

          <h1 itemprop="name"><?=$this->_ret['h1']?></h1>

          <amp-img itemprop="image" src="/<?=$this->_ret['img']?>"/>
          <div class="block-wrp">
              <div itemprop="description">
                <?php
                  if ($this->_mode == -3 && $this->_datas['region']['name'] == "Москва" && isset($textHub[$this->_datas['model_type']['name']][0])) {
                    $this->renderText($textHub[$this->_datas['model_type']['name']][0]);
                  }
                  else
                    echo $this->_ret['text'];
                ?>
              </div>
              <div itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                  <?php if (!is_null($this->_datas['minCost'])) { ?><span class="price" itemprop="price">от <?=$this->_datas['minCost']?> <?=($this->_datas['minCost'] > 0 ? 'р.' : '')?></span><?php } ?>
                  <meta itemprop="priceCurrency" content="RUB"/>
                  <a href="/zakaz/?text=<?=urlencode($f_name)?>&brand=<?=$marka_lower?>&type=<?=$model_type['name']?>" class="btn btn--fill">Записаться на ремонт</a>
              </div>
          </div>

          <div class="clear"></div>
      </div>

  </div>
  <div class="divider divider--three"></div>

  <div class="content-block__bottom">
      <div class="info-block">
          <?php if ((isset($all_services) && count($all_services) > 0) || (isset($all_complects) && count($all_complects) > 0)) { ?>
          <span class="h2">Услуги и цены по ремонту <?=$full_name?></span>
          <?php } ?>

           <div class="tab-block">

                  <?php if (isset($all_services) && count($all_services) > 0) { ?>
                  <input id="tab1" type="radio" name="tab" checked="checked"/>
                  <label for="tab1">Обслуживание <?=$full_type_name?></label>
                  <?php } ?>

                  <?php if (isset($all_complects) && count($all_complects) > 0) { ?>
                  <input id="tab2" type="radio" name="tab"/>
                  <label for="tab2">Комплектующие для <?=$full_ru_name?></label>
                  <?php } ?>

                  <?php if (isset($all_services) && count($all_services) > 0) { ?>
                  <section id="content1" class="frame">
                      <table class="priceTable">
                      <tbody>
                          <tr>
                              <td>Наименование работ</td>
                              <td>Время работы, мин.</td>
                              <td>Цена, р.</td>
                              <td>&nbsp;</td>
                          </tr>
                          <?php
                          if ($this->_mode == -2)
                            $prefixUrl = $accord[$this->_datas['model_type']['name']].'/'.$this->urlModel($model['name'], $marka_lower, $this->_datas['model_type']['name']);

                          if ($this->_mode == -3)
                            $prefixUrl = $accord[$this->_datas['model_type']['name']];

                          foreach ($all_services as $service):

                              $href = $prefixUrl.'/'.$service['url'];
                          ?>
                          <tr>
                              <?php if ($this->_mode == -2) { ?>
                                <td><a href="/<?=$href?>/"><?=($n = tools::mb_firstupper($service['name']))?></a></td>
                              <?php } else { ?>
                                <td><?=($n = tools::mb_firstupper($service['name']))?></td>
                              <?php } ?>
                              <td><?=$service['time_repair']?></td>
                              <td><?=tools::format_price($service['cost'], $setka_name)?></td>
                              <!--noindex--><td><a href="/zakaz/?text=<?=urlencode($f_name)?>&brand=<?=$marka_lower?>&type=<?=$model_type['name']?>" class="order-btn">заказать со скидкой</a></td><!--/noindex-->
                          </tr>
                      <? endforeach; ?>
                      </tbody>
                      </table>
                      <p><?=$this->_datas['vars2']?></p>
                  </section>
                  <?php } ?>

                  <?php if (isset($all_complects) && count($all_complects) > 0) { ?>
                  <section id="content2" class="frame">
                      <table class="priceTable">
                      <tbody>
                          <tr>
                              <td>Название комплектующей</td>
                              <td></td>
                              <td>Цена, р.</td>
                              <td>&nbsp;</td>
                          </tr>

                          <?  foreach ($all_complects as $value):?>
                          <?
                           /*if ($this->_mode == -2)
                              $href = tools::search_url($site_id, serialize(array('model_id' => $model_id, 'key' => 'complect', 'id' => $value[$this->_suffics.'_complect_id'])));

                           if ($this->_mode == -1)
                              $href = tools::search_url($site_id, serialize(array('m_model_id' => $m_model_id, 'key' => 'complect', 'id' => $value[$this->_suffics.'_complect_id'])));*/
                          ?>
                          <tr>
                              <td><?=($n = tools::mb_firstupper($value['name']))?></td>
                              <td></td>
                              <td>от <?=tools::format_price($value['cost'], $setka_name)?></td>
                              <!--noindex--><td><a href="/zakaz/?text=<?=urlencode($f_name)?>&brand=<?=$marka_lower?>&type=<?=$model_type['name']?>" class="order-btn">заказать со скидкой</a></td><!--/noindex-->
                          </tr>
                          <? endforeach; ?>
                      </tbody>
                      </table>
                      <p><?=$this->_datas['vars3']?></p>
                   </section>
                  <?php } ?>
           </div>

           <?php
           if ($this->_mode == -3 && $this->_datas['region']['name'] == "Москва" && isset($textHub[$this->_datas['model_type']['name']][1])) {
             $this->renderText($textHub[$this->_datas['model_type']['name']][1]);
           }
           ?>

          <? if (($this->_mode == -3) && count($popular) > 0): ?>
              <span class="h2">Популярные устройства</span>
              <section class="frame">
              <ul class="list three">
                <?php
                 foreach (array_slice($popular, 0, 9) as $pModel) {
                   $name =$this->clearBrandLin($pModel, $this->_datas['marka']['name']);
                   $url = $accord[$this->_datas['model_type']['name']].'/'.$this->urlModel($pModel, $marka_lower, $this->_datas['model_type']['name']);
                   echo '<li><a title = "'.$name.'" href = "/'.$url.'/">'.$name.'</a></li>';
                } ?>
              </ul>
              </section>
          <? endif; ?>

          <? if (($this->_mode == -2) && count($this->_datas['allModels']) > 0): ?>
              <span class="h2">Другие устройства</span>
              <section class="frame">
              <ul class="list three">
                <?php
                 foreach (array_slice($this->_datas['allModels'], 0, 9) as $model) {
                   $name =$this->clearBrandLin($model['name'], $this->_datas['marka']['name']);
                   $url = $accord[$this->_datas['model_type']['name']].'/'.$this->urlModel($name, $marka_lower, $this->_datas['model_type']['name']);
                   echo '<li><a title = "'.$name.'" href = "/'.$url.'/">'.$name.'</a></li>';
                } ?>
              </ul>
              </section>
          <? endif; ?>

          <?=$this->_datas['vars4']?>
          <?=$this->_datas['addition']?>
      </div>
      <a href="/zakaz/?text=<?=urlencode($f_name)?>&brand=<?=$marka_lower?>&type=<?=$model_type['name']?>" class="btn btn--fill">Записаться на ремонт</a>
  </div>
</div>
<? include __DIR__.'/js.php'; ?>

<? include __DIR__.'/aside2.php'; ?>
</section>
<div class="clear"></div>

</div>
</section>
