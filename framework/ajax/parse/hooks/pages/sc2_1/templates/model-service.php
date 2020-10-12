<?

use framework\tools;

$site_id = $this->_site_id;

if ($this->_mode)
{
    $model_type = $this->_datas['model_type'];
    $m_model_id = $this->_datas['m_model']['id'];
}

$model_type_id = $this->_datas['model_type']['id'];
$marka_id = $this->_datas['marka']['id'];

if ($this->_mode == 2)
{
    $model_id = $this->_datas['model']['id'];
    $full_type_name = $model_type['name_re'].' '.$this->_datas['model']['name'];
    $full_type_ru_name = $model_type['name_re'].' '.$this->_datas['model']['ru_name'];
    $full_name =  $this->_datas['model']['name'];
    $full_ru_name = $this->_datas['model']['ru_name'];
    $f_name = tools::mb_ucfirst($model_type['name']).' '.$this->_datas['model']['name'];
}

if ($this->_mode == 1)
{
    $full_type_name = $model_type['name_rm'].' '.$this->_datas['marka']['name'].' '.$this->_datas['m_model']['name'];
    $full_type_ru_name = $model_type['name_rm'].' '.$this->_datas['marka']['ru_name'].' '.$this->_datas['m_model']['ru_name'];
    $full_name = $this->_datas['marka']['name'].' '.$this->_datas['m_model']['name'];
    $full_ru_name = $this->_datas['marka']['ru_name'].' '.$this->_datas['m_model']['ru_name'];
    $f_name = tools::mb_ucfirst($model_type['name']).' '.$this->_datas['marka']['name'].' '.$this->_datas['m_model']['name'];
}

if ($this->_mode == 0)
{
    /*$full_type_name = $model_type['name_rm'].' '.$this->_datas['marka']['name'];
    $full_type_ru_name = $model_type['name_rm'].' '.$this->_datas['marka']['ru_name'];
    $full_name = $this->_datas['marka']['name'];
    $full_ru_name = $this->_datas['marka']['ru_name'];
    $f_name = tools::mb_ucfirst($model_type['name']).' '.$this->_datas['marka']['name'];*/
}

$setka_name = $this->_datas['setka_name'];

#$eds = $this->_datas['eds'];
#$availables = $this->_datas['availables'];

$service = $this->_datas['service'];

if ($this->_mode)
{
    $service_name = tools::mb_firstupper($service['name']);
    $service_time = $service['time_repair'];
    $service_price = tools::format_price($service['cost'], $setka_name);
}
else
{
    //$service_name = tools::mb_firstupper($this->_datas['syns'][3]);
    //$service_price = tools::format_price($this->_datas['price'], $setka_name);
}

$complect_to_services = isset($this->_datas['complect_to_services']) ? $this->_datas['complect_to_services'] : array();
$dop_defects = isset($this->_datas['dop_defects']) ? $this->_datas['dop_defects'] : array();
$other_services = isset($this->_datas['other_services']) ? $this->_datas['other_services'] : array();

if ($this->_mode)
{
    $other_services_ids = array();

    foreach ($other_services as $value)
      $other_services_ids[] = $value[$this->_suffics.'_service_id'];

    $other_complects = $this->_find('complect', 'service', $other_services_ids);
}

$type_accord = array('n' => 4, 'p' => 5, 'f' => 3);

$accord_image = $this->_datas['accord_image'];
$this->_ret['img'] = 'userfiles/site/large/'.$accord_image[$this->_datas['model_type']['name']].'-'.mb_strtolower($this->_datas['marka']['name']).'.png';

?>
<section class="fixed content-wrapper">
<div class="content-block">

    <section class="crumbs">

    <? if ($this->_mode == 2): ?>
        <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="/servis-<?=$marka_lower?>/"><span itemprop="title">Cервис <?=$this->_datas['marka']['name']?></span></a></span>
        <span> / </span>
        <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="/<?=$accord[$this->_datas['model_type']['name']]?>/"><span itemprop="title">Ремонт <?=$this->_datas['model_type']['name_rm']?> <?=$this->_datas['marka']['name']?></span></a></span>
        <span> / </span>
        <span><?=$this->_datas['m_model']['name']?></span>
        <span> / </span>
        <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="/<?=$accord[$this->_datas['model_type']['name']]?>/<?=$this->urlModel($this->_datas['model']['name'], $marka_lower, $model_type['name'])?>/"><span itemprop="title"><?=$this->_datas['model']['name']?></span></a></span>
        <span> / </span>
        <span><?=tools::mb_firstupper($this->_datas['syns'][3])?></span>
    <? endif; ?>

    <? if ($this->_mode == 1): ?>
        <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="/servis-<?=$marka_lower?>/"><meta itemprop="title" content="Главная"/><amp-img src="/bitrix/templates/centre/img/home.png" alt="home"/></a></span>
        <span> / </span>
        <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="/<?=tools::search_url($site_id, serialize(array('model_type_id' => $model_type_id, 'marka_id' => $marka_id)))?>/"><span itemprop="title"><?=tools::mb_ucfirst($this->_datas['orig_model_type'][0]['name_m'])?></span></a></span>
        <span> / </span>
        <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="/<?=tools::search_url($site_id, serialize(array('m_model_id' => $m_model_id)))?>/"><span itemprop="title"><?=$this->_datas['m_model']['name']?></span></a></span>
        <span> / </span>
        <span><?=tools::mb_firstupper($this->_datas['syns'][3])?></span>
    <? endif; ?>

    <? if ($this->_mode == 0): ?>
        <a href="/"><amp-img src="/bitrix/templates/centre/img/home.png" alt="home"/></a>
        <span> / </span>
        <span><?=tools::mb_firstupper($this->_datas['syns'][3])?></span>
    <? endif; ?>
    </section>

    <div class="content-block__top">

        <div class="info-block remont-block" itemscope itemtype="http://schema.org/Product">

            <h1 itemprop="name"><?=$this->_ret['h1']?></h1>

            <amp-img itemprop="image" src="http://<?=$this->_datas['site_name']?>/<?=$this->_ret['img']?>"/>

            <div class="block-wrp">
                <div itemprop="description"><?=$this->_ret['text']?></div>
                <div itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                    <span class="price" itemprop="price"><?=$service_price?> <?=(($service['cost'] > 0) ? 'р.' : '')?></span>
                    <meta itemprop="priceCurrency" content="RUB"/>
                     <? if ($this->_mode): ?>
                        <a href="/zakaz/?text=<?=urlencode($f_name.', '.$service_name)?>&brand=<?=$marka_lower?>&type=<?=$model_type['name']?>" class="btn btn--fill">Записаться на ремонт</a>
                     <? else: ?>
                        <a href="/zakaz/?text=<?=urlencode($f_name.', '.$service_name)?>&brand=<?=$marka_lower?>&type=<?=$model_type['name']?>" class="btn btn--fill">Записаться на ремонт</a>
                     <? endif; ?>
                </div>
            </div>

            <div class="clear"></div>
        </div>

    </div>
    <div class="divider divider--three"></div>

    <div class="content-block__bottom">
        <div class="info-block">

                <span class="h2">Цены на ремонт</span>
                <div class="tab-block">

                    <input id="tab1" type="radio" name="tab" checked="checked"/>
                    <label for="tab1">Обслуживание <?=$full_type_name?></label>

                    <?if ($complect_to_services):?>
                        <input id="tab2" type="radio" name="tab"/>
                        <label for="tab2">Комплектующие для <?=$full_ru_name?></label>
                    <? endif; ?>

                    <section id="content1" class="frame">
                        <table class="priceTable">
                        <tbody>
                            <tr>
                                <td>Наименование работ</td>
                                <td>Время работы, мин.</td>
                                <td>Цена, р.</td>
                                <td>&nbsp;</td>
                            </tr>
                            <? if ($this->_mode): ?>
                            <tr>
                                <td><?=$service_name?></td>
                                <td><?=$service_time?></td>
                                <td><?=$service_price?></td>
                                <!--noindex--><td><a href="/zakaz/?text=<?=urlencode($f_name.', '.$service_name)?>&brand=<?=$marka_lower?>&type=<?=$model_type['name']?>" class="order-btn">заказать со скидкой</a></td><!--/noindex-->
                            </tr>
                            <? else:
                                foreach ($service as $key => $value):
                                    $suffics = $this->_datas[$key]['suffics'];
                                ?>
                                     <tr>
                                        <td><?=($n = tools::mb_firstupper($value['name']).' '.$this->_datas[$key]['model_type'][3]['name_re']);?></td>
                                        <td><?=tools::format_garantee($value['garantee'], $eds[$key][$value[$suffics.'_service_id']]['ed_garantee']);?></td>
                                        <td><?=tools::format_price($value['price'], $setka_name)?></td>
                                        <!--noindex--><td><a href="/zakaz/?text=<?=urlencode($f_name.', '.$n)?>&brand=<?=$marka_lower?>&type=<?=$model_type['name']?>" class="order-btn">заказать со скидкой</a></td><!--/noindex-->
                                     </tr>
                                <? endforeach;
                            endif; ?>
                        </tbody>
                        </table>
                        <p><?=$this->_datas['vars2']?></p>
                    </section>

                    <? if ($complect_to_services):?>
                    <section id="content2" class="frame">
                        <table class="priceTable">
                        <tbody>
                            <tr>
                                <td>Название комплектующей</td>
                                <td>Наличие</td>
                                <td>Цена, р.</td>
                                <td>&nbsp;</td>
                            </tr>

                            <? if ($this->_mode):

                                foreach ($complect_to_services as $value):?>
                                <?
                                 if ($this->_mode == 2)
                                    $href = tools::search_url($site_id, serialize(array('model_id' => $model_id, 'key' => 'complect', 'id' => $value[$this->_suffics.'_complect_id'])));

                                 if ($this->_mode == 1)
                                    $href = tools::search_url($site_id, serialize(array('m_model_id' => $m_model_id, 'key' => 'complect', 'id' => $value[$this->_suffics.'_complect_id'])));
                                ?>
                                <tr>
                                    <td><a href="/<?=$href?>/"><?=($n = tools::mb_firstupper($value['name']))?></a></td>
                                    <td><div class="amount"><?=$value['amount']?></div></td>
                                    <td>от <?=tools::format_price($value['price'], $setka_name)?></td>
                                    <!--noindex--><td><a href="/zakaz/?text=<?=urlencode($f_name.', '.$n)?>&brand=<?=$marka_lower?>&type=<?=$model_type['name']?>" class="order-btn">заказать со скидкой</a></td><!--/noindex-->
                                </tr>
                                <? endforeach;

                            else:

                                foreach ($complect_to_services as $key => $cts):
                                    foreach ($cts as $value):
                                        $suffics = $this->_datas[$key]['suffics']; ?>

                                        <tr>
                                            <td><?=($n = tools::mb_firstupper($value['name']).' '.$this->_datas[$key]['model_type'][3]['name_re']);?></td>
                                            <td><div class="amount"><?=$value['amount']?></div></td>
                                            <td>от <?=tools::format_price($value['price'], $setka_name)?></td>
                                            <!--noindex--><td><a href="/zakaz/?text=<?=urlencode($f_name.', '.$n)?>&brand=<?=$marka_lower?>&type=<?=$model_type['name']?>" class="order-btn">заказать со скидкой</a></td><!--/noindex-->
                                        </tr>

                                        <?
                                    endforeach;
                                endforeach;

                            endif; ?>
                        </tbody>
                        </table>
                        <p><?=$this->_datas['vars3']?></p>
                     </section>
                  <? endif; ?>
             </div>

            <? if ($dop_defects && $this->_mode):?>
                <p><strong><?=tools::mb_firstupper($this->_datas['syns'][3])?> может потребоваться в следующих случаях:</strong></p>
                <section class="frame def">
                    <ul class="list">
                        <? foreach ($dop_defects as $value):

                        if ($this->_mode == 2)
                            $href = tools::search_url($site_id, serialize(array('model_id' => $model_id, 'key' => 'defect', 'id' => $value[$this->_suffics.'_defect_id'])));

                        if ($this->_mode == 1)
                            $href = tools::search_url($site_id, serialize(array('m_model_id' => $m_model_id, 'key' => 'defect', 'id' => $value[$this->_suffics.'_defect_id'])));
                        ?>
                            <li><span><a href="/<?=$href?>/"><?=tools::mb_firstupper($value['name'])?></a></span></li>
                        <? endforeach; ?>
                    </ul>
                </section>
            <? endif; ?>

            <?if ($other_services):?>
                <span class="h2">Что может потребоваться</span>
                <div class="tab-block">

                    <input id="tab3" type="radio" name="tab2" checked="checked"/>
                    <label for="tab3">Обслуживание <?=$full_type_name?></label>

                    <? if ($other_complects):?>
                        <input id="tab4" type="radio" name="tab2"/>
                        <label for="tab4">Комплектующие для <?=$full_ru_name?></label>
                    <? endif; ?>

                    <section id="content3" class="frame">
                        <table class="priceTable">
                        <tbody>
                            <tr>
                                <td>Наименование работ</td>
                                <td>Гарантия</td>
                                <td>Цена, р.</td>
                                <td>&nbsp;</td>
                            </tr>

                        <? if ($this->_mode):

                            foreach ($other_services as $value):

                                if ($this->_mode == 2)
                                    $href = tools::search_url($site_id, serialize(array('model_id' => $model_id, 'key' => 'service', 'id' => $value[$this->_suffics.'_service_id'])));

                                if ($this->_mode == 1)
                                    $href = tools::search_url($site_id, serialize(array('m_model_id' => $m_model_id, 'key' => 'service', 'id' => $value[$this->_suffics.'_service_id'])));?>
                                <tr>
                                    <td><a href="/<?=$href?>/"><?=($n = tools::mb_firstupper($value['name']))?></a></td>
                                    <td><?=tools::format_garantee($value['garantee'], $eds[$value[$this->_suffics.'_service_id']]['ed_garantee']);?></td>
                                    <td><?=tools::format_price($value['price'], $setka_name)?></td>
                                    <!--noindex--><td><a href="/zakaz/?text=<?=urlencode($f_name.', '.$n)?>&brand=<?=$marka_lower?>&type=<?=$model_type['name']?>" class="order-btn">заказать со скидкой</a></td><!--/noindex-->
                                </tr>

                          <? endforeach;

                            else:

                                foreach ($other_services as $key => $os):
                                    foreach ($os as $value):
                                        $suffics = $this->_datas[$key]['suffics'];?>

                                    <tr>
                                        <td><?=($n = tools::mb_firstupper($value['name']).' '.$this->_datas[$key]['model_type'][3]['name_re'])?></td>
                                        <td><?=tools::format_garantee($value['garantee'], $eds[$key][$value[$suffics.'_service_id']]['ed_garantee']);?></td>
                                        <td><?=tools::format_price($value['price'], $setka_name)?></td>
                                        <!--noindex--><td><a href="/zakaz/?text=<?=urlencode($f_name.', '.$n)?>&brand=<?=$marka_lower?>&type=<?=$model_type['name']?>" class="order-btn">заказать со скидкой</a></td><!--/noindex-->
                                    </tr>

                                 <? endforeach;
                                endforeach;

                            endif; ?>
                        </tbody>
                        </table>
                    </section>

                    <? if ($other_complects):?>
                    <section id="content4" class="frame">
                        <table class="priceTable">
                        <tbody>
                            <tr>
                                <td>Название комплектующей</td>
                                <td>Наличие</td>
                                <td>Цена, р.</td>
                                <td>&nbsp;</td>
                            </tr>

                        <? if ($this->_mode):

                               foreach ($other_complects as $value):

                                    if ($this->_mode == 2)
                                        $href = tools::search_url($site_id, serialize(array('model_id' => $model_id, 'key' => 'complect', 'id' => $value[$this->_suffics.'_complect_id'])));

                                    if ($this->_mode == 1)
                                        $href = tools::search_url($site_id, serialize(array('m_model_id' => $m_model_id, 'key' => 'complect', 'id' => $value[$this->_suffics.'_complect_id'])));?>
                                    <tr>
                                        <td><a href="/<?=$href?>/"><?=($n = tools::mb_firstupper($value['name']))?></a></td>
                                        <td><div class="amount"><?=$value['amount']?></div></td>
                                        <td>от <?=tools::format_price($value['price'], $setka_name)?></td>
                                        <!--noindex--><td><a href="/zakaz/?text=<?=urlencode($f_name.', '.$n)?>&brand=<?=$marka_lower?>&type=<?=$model_type['name']?>" class="order-btn">заказать со скидкой</a></td><!--/noindex-->
                                    </tr>

                            <? endforeach;

                             else:

                                foreach ($other_complects as $key => $oc):
                                    foreach ($oc as $value):
                                        $suffics = $this->_datas[$key]['suffics'];?>

                                        <tr>
                                            <td><?=($n = tools::mb_firstupper($value['name']).' '.$this->_datas[$key]['model_type'][3]['name_re'])?></a></td>
                                            <td><div class="amount"><?=$value['amount']?></div></td>
                                            <td>от <?=tools::format_price($value['price'], $setka_name)?></td>
                                            <!--noindex--><td><a href="/zakaz/?text=<?=urlencode($f_name.', '.$n)?>&brand=<?=$marka_lower?>&type=<?=$model_type['name']?>" class="order-btn">заказать со скидкой</a></td><!--/noindex-->
                                        </tr>

                                <? endforeach;
                                endforeach;

                            endif; ?>
                        </tbody>
                        </table>
                     </section>
                     <? endif; ?>
             </div>
            <? endif; ?>
            <?=$this->_datas['vars4']?>
            <?=$this->_datas['addition']?>
        </div>
        <? if ($this->_mode): ?>
            <a href="/zakaz/?text=<?=urlencode($f_name.', '.$service_name)?>&brand=<?=$marka_lower?>&type=<?=$model_type['name']?>" class="btn btn--fill">Записаться на ремонт</a>
        <? else: ?>
            <a href="/zakaz/?text=<?=urlencode($f_name.', '.$service_name)?>&brand=<?=$marka_lower?>&type=<?=$model_type['name']?>" class="btn btn--fill">Записаться на ремонт</a>
        <? endif; ?>
    </div>
</div>
<? include __DIR__.'/js.php'; ?>

<? include __DIR__.'/aside2.php'; ?>
</section>
<div class="clear"></div>
