<?

use framework\ajax\parse\hooks\sc;
use framework\tools;
    $marka = $this->_datas['marka']['name'];
    $marka_ru =  $this->_datas['marka']['ru_name'];

    $address = (($this->_datas['partner']['index']) ? '<span itemprop="postalCode">'.$this->_datas['partner']['index'].'</span>, ' : '') .
            '<span itemprop="addressLocality">'.$this->_datas['region']['name'].'</span>, <span itemprop="streetAddress">'.$this->_datas['partner']['address1'].'</span>';
    $time = ($this->_datas['partner']['time']) ? $this->_datas['partner']['time'] : 'с 10:00 до 20:00, без выходных';
?>
<section class="inner-page gradient page" itemscope itemtype="http://schema.org/Organization">
    <meta itemprop="name" content="<?=$this->_datas['servicename']?>"/>
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <?php include __DIR__ . '/breadcrumb.php' ?>
            </div>
            <div class="col-sm-7 textblock">
                <? //if (!$this->_datas['region']['code']):
                if (false):?>
                    <div class="omega">
                        <?php/*<p class="margin" itemprop="address" itemscope itemtype="http://schema.org/PostalAddress"><strong>Адрес</strong>
                               <?=$address?>
                            </p>*/?>
                        <p class="margin"><strong>Реквизиты </strong>
                            ООО "РЕМЦЕНТР"<br/>
                            ОГРН 5167746420562<br/></p>
                        <p><a itemprop="url" href="https://<?=$this->_datas['site_name']?>">Запись на ремонт <?=$marka?> в 1 клик</a></p>
                    </div>
                    <div class="alpha">
                        <p class="margin"><strong>График работы </strong><?=$time?></p>
                        <p><strong>Телефоны</strong>
                            Записаться на ремонт: <span itemprop="telephone" class="phone-wrap"><a href="tel:+<?=$this->_datas['phone']?>">+<?=tools::format_phone($this->_datas['phone'])?></a></span><br>
                            Сотрудничество: <span class="phone-wrap"><a href="tel:+74951323618">+7 (495) 132-36-18</a></span><br />
                            Почта: <span itemprop="email" class="phone-wrap">support@<?=$this->_datas['site_name']?></span></p>
                    </div>
                <?  else: ?>
                    <div class="omega">
                        <h1><?=$this->_ret['h1']?></h1>
                        <? if (!$this->_datas['partner']['exclude']) { ?>
                            <p itemprop="address" itemscope itemtype="http://schema.org/PostalAddress"><strong>Адрес: </strong><br>
                                <?=$address?><br/>
                                <? if ($this->_datas['partner']['dop_address1']): ?>
                                    <?=$this->_datas['partner']['dop_address1']?><br/>
                                <? endif; ?>
                                <? if ($this->_datas['partner']['dop_address2']): ?>
                                    <?=$this->_datas['partner']['dop_address2']?><br/>
                                <? endif; ?>
                            </p>
                        <? } ?>
                        <? //if ($this->_datas['region']['name'] == 'Санкт-Петербург' && $this->_datas['realHost'] != $this->_datas['site_name']):?>
                            <!--<p itemprop="address" itemscope itemtype="http://schema.org/PostalAddress"><strong>Адрес</strong>
                                Сервис расположен на пересечение набережной Макарова и Тучкова переулка. Парковаться удобнее на набережной Макарова возле дома 20.
                            </p>-->
                        <?//endif;?>
                        <p><strong>График работы:</strong></br><?=$time?></p>
                        <p><strong>Телефоны:</strong></br>
                            Записаться на ремонт: <span itemprop="telephone" class="phone-wrap"><a href="tel:+<?=$this->_datas['phone']?>">+<?=tools::format_phone($this->_datas['phone'])?></a></span><br>
                            Сотрудничество: <span class="phone-wrap"><a href="tel:+74951323618">+7 (495) 132-36-18</a></span><br />
                            Почта: <span itemprop="email" class="phone-wrap">support@<?=$this->_datas['site_name']?></span></p>
                        <?//if ($this->_datas['region']['name'] == 'Москва'):?>
<!--                            <p><strong>Мы ближе, чем кажется:</strong>-->
                                <!--800 метров от метро Алексеевская. Вход через Кучин переулок или проспект Мира. Автомобиль можно припарковать на Кучином переулке, на платной городской парковке.</p>-->
                                <!--<p>м Новые Черемушки, ул Профсоюзная, д 58, корпус 4, заезд с ул Гарибальди направо перед ТЦ Черемушки, жилой многоэтажный дом из красного кирпича, на первом этаже на углу дома вывеска "Сервисный центр Лаборатория"</p>-->
<!--                            <p>м. Проспект Мира (кольцевая линия). Выход из стеклянных дверей направо, дойти до трамвайных путей, повернуть направо и двигаться вдоль них до Астраханского переулка (ориентир - с правой стороны Универсам "Да!") и повернуть налево, далее пройти по прямой. В конце переулка с левой стороны вход с торца здания. Ориентир - красная вывеска продукты (вход слева от нее за шлагбаумом).</p>-->
                        <?//endif;?>
                        <p><a itemprop="url"  href="https://<?=$this->_datas['site_name']?>">Запись на ремонт <?=$marka?> в 1 клик</a></p>
                    </div>
                <? endif; ?>
            </div>
            <div class="col-sm-5 displayMoble">
                <?//if ($this->_datas['region']['name'] == 'Москва'):
                if ($this->_datas['region']['name'] == 'Никогда'):?>
                    <div class="image-clip" style="background-image: url(/bitrix/templates/remont/images/schema.jpg"></div>
                <?else:?>
                    <? //if ($this->_datas['region']['name'] == 'Санкт-Петербург' && $this->_datas['realHost'] != $this->_datas['site_name']):?>
                        <!--<div class="image-clip" style="background-image: url(/bitrix/templates/remont/images/shared/map-spb.png)"></div>-->
                    <?//else:?>
                        <div class="image-clip" style="background-image: url(/bitrix/templates/remont/images/shared/contacts.png)"></div>
                    <?//endif;?>
                <?endif;?>
            </div>
        </div>
    </div>
</section>

    <? include __DIR__.'/ask_expert.php'; ?>

    <? $add_section_class = '';
    if ($this->_datas['partner']['exclude']) $add_section_class = ' no-events';?>

    <section class="map-section mobile-top<?=$add_section_class?>">
         <? include __DIR__.'/contact-block.php'; ?>
    </section>
