<?
exit();
use framework\tools;

$site_id = $this->_site_id;
$model_type = $this->_datas['model_type'][3];
$model_type_id = $this->_datas['model_type']['id'];
$marka_id = $this->_datas['marka']['id'];
$m_model_id = $this->_datas['m_model']['id'];

if ($this->_mode == 2)
{
    $model_id = $this->_datas['model']['id'];
    $full_type_name = $model_type['name_re'].' '.$this->_datas['model']['name'];
    $full_type_ru_name = $model_type['name_re'].' '.$this->_datas['model']['ru_name'];
    $full_name = $this->_datas['model']['name'];
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

$setka_name = $this->_datas['setka_name'];

$eds = $this->_datas['eds'];
$availables = $this->_datas['availables'];

$vals = $this->_datas['vals'];

$dop_reasons =  $this->_datas['dop_reasons'];
$dop_services = $this->_datas['dop_services'];

$dop_services_ids = array();

foreach ($dop_services as $value)
  $dop_services_ids[] = $value[$this->_suffics.'_service_id'];

$dop_complects = $this->_find('complect', 'service', $dop_services_ids);
$other_defects = $this->_datas['other_defects'];

$defect_price = tools::format_price($this->_datas['price'], $setka_name);
$defect_name = tools::mb_firstupper($vals['name']);

$type_accord = array('n' => 4, 'p' => 5, 'f' => 3);

$accord_image = $this->_datas['accord_image'];
$this->_ret['img'] = 'userfiles/site/large/'.$accord_image[$this->_datas['orig_model_type']['0']['name']].'-'.mb_strtolower($this->_datas['marka']['name']).'.png';

?>
<section class="fixed content-wrapper">
<div class="content-block">

    <section class="crumbs">

    <? if ($this->_mode == 2): ?>
        <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="/"><meta itemprop="title" content="Главная"/><img src="/img/home.png" alt="home"/></a></span>
        <span> / </span>
        <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="/<?=tools::search_url($site_id, serialize(array('model_type_id' => $model_type_id, 'marka_id' => $marka_id)))?>/"><span itemprop="title"><?=tools::mb_ucfirst($this->_datas['orig_model_type'][0]['name_m'])?></span></a></span>
        <span> / </span>
        <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="/<?=tools::search_url($site_id, serialize(array('m_model_id' => $m_model_id)))?>/"><span itemprop="title"><?=$this->_datas['m_model']['name']?></span></a></span>
        <span> / </span>
        <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="/<?=tools::search_url($site_id, serialize(array('model_id' => $model_id)))?>/"><span itemprop="title"><?=$this->_datas['model']['name']?></span></a></span>
        <span> / </span>
        <span><?=tools::mb_firstupper($this->_datas['syns'][3])?></span>
    <? endif; ?>

    <? if ($this->_mode == 1): ?>
        <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="/"><meta itemprop="title" content="Главная"/><img src="/img/home.png" alt="home"/></a></span>
        <span> / </span>
        <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="/<?=tools::search_url($site_id, serialize(array('model_type_id' => $model_type_id, 'marka_id' => $marka_id)))?>/"><span itemprop="title"><?=tools::mb_ucfirst($this->_datas['orig_model_type'][0]['name_m'])?></span></a></span>
        <span> / </span>
        <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="/<?=tools::search_url($site_id, serialize(array('m_model_id' => $m_model_id)))?>/"><span itemprop="title"><?=$this->_datas['m_model']['name']?></span></a></span>
        <span> / </span>
        <span><?=tools::mb_firstupper($this->_datas['syns'][3])?></span>
    <? endif; ?>

    </section>

    <div class="content-block__top">

        <div class="info-block remont-block" itemscope itemtype="http://schema.org/Product">

            <h1 itemprop="name"><?=$this->_ret['h1']?></h1>

            <img itemprop="image" src="/<?=$this->_ret['img']?>"/>

            <div class="block-wrp">
                <div itemprop="description"><?=$this->_ret['text']?></div>
                <div itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                    <span class="price" itemprop="price">от <?=$defect_price?> <?=(($this->_datas['price'] > 0) ? 'р.' : '')?></span>
                    <meta itemprop="priceCurrency" content="RUB"/>
                    <a href="/order/?text=<?=urlencode($f_name.', '.$defect_name)?>&type=<?=$type_accord[$this->_suffics]?>" class="btn btn--fill">Записаться на ремонт</a>
                </div>
            </div>

            <div class="clear"></div>
        </div>

    </div>
    <div class="divider divider--three"></div>

    <div class="content-block__bottom">
        <div class="info-block">

             <?if ($dop_services):?>
                <span class="h2">Что может потребоваться</span>
                <div class="tab-block">

                    <input id="tab1" type="radio" name="tab" checked="checked"/>
                    <label for="tab1">Обслуживание <?=$full_type_name?></label>

                    <?if ($dop_complects):?>
                        <input id="tab2" type="radio" name="tab"/>
                        <label for="tab2">Комплектующие для <?=$full_ru_name?></label>
                     <? endif; ?>

                    <section id="content1" class="frame">
                        <table class="priceTable">
                        <tbody>
                            <tr>
                                <td>Наименование работ</td>
                                <td>Гарантия</td>
                                <td>Цена, р.</td>
                                <td>&nbsp;</td>
                            </tr>

                        <? foreach ($dop_services as $value):

                            if ($this->_mode == 2)
                                $href = tools::search_url($site_id, serialize(array('model_id' => $model_id, 'key' => 'service', 'id' => $value[$this->_suffics.'_service_id'])));

                            if ($this->_mode == 1)
                                $href = tools::search_url($site_id, serialize(array('m_model_id' => $m_model_id, 'key' => 'service', 'id' => $value[$this->_suffics.'_service_id'])));?>
                            <tr>
                                <td><a href="/<?=$href?>/"><?=($n = tools::mb_firstupper($value['name']))?></a></td>
                                <td><?=tools::format_garantee($value['garantee'], $eds[$value[$this->_suffics.'_service_id']]['ed_garantee']);?></td>
                                <td><?=tools::format_price($value['price'], $setka_name)?></td>
                                <!--noindex--><td><a href="/order/?text=<?=urlencode($f_name.', '.$n)?>&type=<?=$type_accord[$this->_suffics]?>" class="order-btn">заказать со скидкой</a></td><!--/noindex-->
                            </tr>
                        <? endforeach; ?>
                        </tbody>
                        </table>
                        <?=$this->_datas['vars2']?>
                    </section>

                    <?if ($dop_complects):?>
                    <section id="content2" class="frame">
                        <table class="priceTable">
                        <tbody>
                            <tr>
                                <td>Название комплектующей</td>
                                <td>Наличие</td>
                                <td>Цена, р.</td>
                                <td>&nbsp;</td>
                            </tr>

                        <? foreach ($dop_complects as $value):

                            if ($this->_mode == 2)
                                $href = tools::search_url($site_id, serialize(array('model_id' => $model_id, 'key' => 'complect', 'id' => $value[$this->_suffics.'_complect_id'])));

                            if ($this->_mode == 1)
                                $href = tools::search_url($site_id, serialize(array('m_model_id' => $m_model_id, 'key' => 'complect', 'id' => $value[$this->_suffics.'_complect_id'])));?>
                            <tr>
                                <td><a href="/<?=$href?>/"><?=($n = tools::mb_firstupper($value['name']))?></a></td>
                                <td><div class="amount"><?=$value['amount']?></div></td>
                                <td>от <?=tools::format_price($value['price'], $setka_name)?></td>
                                <!--noindex--><td><a href="/order/?text=<?=urlencode($f_name.', '.$n)?>&type=<?=$type_accord[$this->_suffics]?>" class="order-btn">заказать со скидкой</a></td><!--/noindex-->
                            </tr>
                        <? endforeach; ?>
                        </tbody>
                        </table>
                        <?=$this->_datas['vars3']?>
                     </section>
                      <? endif; ?>
             </div>
            <? endif; ?>

            <section class="ask-section"><a href="/ask/" class="btn btn--fill">Задайте вопрос эксперту</a><p>Не знаете, что случилось с вашим <?=$this->_datas['marka']['name']?>?</p><p>Наши эксперты помогут вам разобраться в ситуации.</p></section>

            <? if ($dop_reasons):?>
                <span class="h2">В каких случаях происходит</span>
                <section class="frame">
                    <ul class="list">
                        <? foreach ($dop_reasons as $value):?>
                            <li><span><?=tools::mb_firstupper($value)?></span></li>
                        <? endforeach; ?>
                    </ul>
                </section>
            <? endif; ?>

            <? if ($other_defects) :?>
                <span class="h2">Какие еще бывают неисправности</span>

                <table class="priceTable">
                <tbody>
                    <? $i = 0;
                       foreach ($other_defects as $value):
                       if ($this->_mode == 2)
                            $href = tools::search_url($site_id, serialize(array('model_id' => $model_id, 'key' => 'defect', 'id' => $value[$this->_suffics.'_defect_id'])));

                       if ($this->_mode == 1)
                            $href = tools::search_url($site_id, serialize(array('m_model_id' => $m_model_id, 'key' => 'defect', 'id' => $value[$this->_suffics.'_defect_id'])));
                    ?>
                     <tr<?=((!$i) ? ' class="nth"' : '')?>>
                        <td><a href="/<?=$href?>/"><?=tools::mb_firstupper($value['name'])?></a></td>
                     </tr>
                    <?  $i++;
                    endforeach; ?>
                </tbody>
                </table>
            <? endif; ?>
            <?=$this->_datas['vars4']?>
            <?=$this->_datas['addition']?>
        </div>

        <a href="/order/?text=<?=urlencode($f_name.', '.$defect_name)?>&type=<?=$type_accord[$this->_suffics]?>" class="btn btn--fill">Записаться на ремонт</a>
    </div>
</div>
<? include __DIR__.'/js.php'; ?>

<? include __DIR__.'/aside.php'; ?>
</section>
<div class="clear"></div>
<section class="crumbs fixed">

<? if ($this->_mode == 2): ?>
    <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="/"><meta itemprop="title" content="Главная"/>Сервисный центр <?=$this->_datas['marka']['name']?> в <?=tools::mb_ucfirst($this->_datas['region']['name_pe'])?></a></span>
    <span> / </span>
    <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="/<?=tools::search_url($site_id, serialize(array('model_type_id' => $model_type_id, 'marka_id' => $marka_id)))?>/"><span itemprop="title">Ремонт <?=$this->_datas['model_type'][1]['name_rm']?> <?=$this->_datas['marka']['name']?></span></a></span>
    <span> / </span>
    <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="/<?=tools::search_url($site_id, serialize(array('m_model_id' => $m_model_id)))?>/"><span itemprop="title"><?=$this->_datas['m_model']['name']?></span></a></span>
    <span> / </span>
    <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="/<?=tools::search_url($site_id, serialize(array('model_id' => $model_id)))?>/"><span itemprop="title"><?=$this->_datas['model']['name']?></span></a></span>
    <span> / </span>
    <span><?=tools::mb_firstupper($this->_datas['syns'][3])?></span>
<? endif; ?>

<? if ($this->_mode == 1): ?>
    <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="/"><meta itemprop="title" content="Главная"/>Сервисный центр <?=$this->_datas['marka']['name']?> в <?=tools::mb_ucfirst($this->_datas['region']['name_pe'])?></a></span>
    <span> / </span>
    <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="/<?=tools::search_url($site_id, serialize(array('model_type_id' => $model_type_id, 'marka_id' => $marka_id)))?>/"><span itemprop="title">Ремонт <?=$this->_datas['model_type'][1]['name_rm']?> <?=$this->_datas['marka']['name']?></span></a></span>
    <span> / </span>
    <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="/<?=tools::search_url($site_id, serialize(array('m_model_id' => $m_model_id)))?>/"><span itemprop="title"><?=$this->_datas['m_model']['name']?></span></a></span>
    <span> / </span>
    <span><?=tools::mb_firstupper($this->_datas['syns'][3])?></span>
<? endif; ?>

</section>
