<? use framework\tools; ?>                
                <div class="uk-width-large-3-10 sr-content-inertnit">
                    <div class="uk-grid uk-grid-medium right-part-new" data-uk-grid-margin>
                        <!--noindex-->
                        <div class="uk-width-medium-1-1 ">
                            <div class="uk-panel uk-panel-box uk-panel-box-secondary sr-block-white diagnostika">
                                <? if (!$this->_datas['sdek']):?> 
                                    <p class="uk-h3">Экспресс диагностика</p>
                                    <p>Выявление неисправности 15-40 минут</p>
                                    <a href="/diagnostika/">Подробнее</a>
                                <?else:?>
                                    <p class="uk-h3">Экспертная диагностика</p>
                                    <p>Точное выявление неисправности даже в мелочах.</p>
                                    <a href="/diagnostika/">Подробнее</a>
                                <?endif;?>
                            </div>
                        </div>
                        <div class="uk-width-medium-1-1 ">
                            <div class="uk-panel uk-panel-box uk-panel-box-secondary sr-block-white komplekt">
                                <p class="uk-h3">Детали <?=(($this->_datas['setka_name'] != 'СЦ-1' || $marka_lower != 'samsung') ? mb_strtoupper($this->_datas['marka']['name']) : '')?></p>
                                <p>В наличии более 10000 наименований комплектующих <?=$this->_datas['marka']['name']?></p>
                                <a href="/zapchasti/">Подробнее</a>
                            </div>
                        </div>
                        <div class="uk-width-medium-1-1 ">
                            <div class="uk-panel uk-panel-box uk-panel-box-secondary sr-block-white viezd">
                                <? if (!$this->_datas['sdek']):?>
                                    <p class="uk-h3">Доставка</p>
                                    <p>Курьерская доставка - от 30 минут</p>
                                    <a href="/dostavka/">Подробнее</a>
                                 <?else:?>
                                    <p class="uk-h3">Удобное месторасположение</p>
                                    <p>Более 1500 пунктов приема заказов в России.</p>
                                    <a href="/kontakty/">Подробнее</a>
                                 <?endif;?>
                            </div>
                        </div>
                        <div class="uk-width-medium-1-1 ">
                            <div class="uk-panel uk-panel-box uk-panel-box-secondary sr-block-white srochniy">
                                 <? if (!$this->_datas['sdek']):?>
                                    <p class="uk-h3">Срочный ремонт</p>
                                    <p>Устранение типовых неисправностей в течение 24 часов</p>
                                    <a href="/sroki/">Подробнее</a>
                                 <?else:?>
                                    <p class="uk-h3">Срочный ремонт</p>
                                    <p>Устранение типовых неисправностей в короткие сроки. Без переплаты.</p>
                                    <a href="/diagnostika/">Подробнее</a>
                                 <?endif;?>
                            </div>
                        </div>
                        <!--/noindex-->
                        <? if (isset($this->_datas['vars2'])):?>
                        <div class="uk-width-medium-1-1 ">
                            <div class="uk-panel uk-panel-box uk-panel-box-secondary sr-block-white">
                            <p class="uk-text-large">Наше оборудование</p>
                                <?=$this->_datas['vars2']?>                           
                            </div>
                        </div>
                        <? endif; ?>
                    </div>
                </div>

