<? use framework\tools;

$marka = $this->_datas['marka']['name'];
$format_phone = tools::format_phone($this->_datas['phone']);
$marka_lower = mb_strtolower($marka);

$point = $this->_datas['partner']['x'].','.$this->_datas['partner']['y'];
$address = (($this->_datas['partner']['index']) ? $this->_datas['partner']['index'].', ' : ''). $this->_datas['region']['name'].', '.$this->_datas['partner']['address1'];
$time = ($this->_datas['partner']['time']) ? $this->_datas['partner']['time'] : 'пн-вс: 10:00 - 20:00';
?>

        <div class="title-row">
            <div class="container">
                <h1><?=$this->_ret['h1']?></h1>
            </div>
        </div>

        <div class="imagerow banner-kontakty">
            <div class="container">
                <div class="imagerel">
                    <!--<img src="<?='/templates/moscow/img/shared/banners/'.$this->_datas['images']['kontakty']?>"/>-->
                    <img src="/templates/moscow/img/shared/kontakty.png"/>
                    <div class="addresstext">
                            <? if (!$this->_datas['partner']['exclude']): ?><p>Адрес: <?=$address?></p><? endif;?>
                            <p>Телефон: <?=$format_phone?></p>
                            <p>График работы: <?=$time?></p>
                            <p>E-mail: inbox@<?=$this->_datas['site_name']?></p>
                            <p>Гарантия: garantya@<?=$this->_datas['site_name']?></p>
                            <p>Доставка: delivery@<?=$this->_datas['site_name']?></p>
                            <p>Сайт сервисного центра: <a href="/" title="Сервисный центр <?=$this->_datas['servicename']?>"><?=$this->_datas['site_name']?></a></p>
                    </div>
                    <div class="imageabs imageabs-right">
                        <div class="imagetitle">
                            Спросите SUPPORT<?//=//$marka?>
                        </div>
                        <div class="brand-ask">
                            <form class="imageform">
                                <div class="inputform">
                                    <input type="text"  name="name" placeholder="Ваше имя">
                                </div>
                                <div class="inputform inputformreq">
                                    <input type="tel" placeholder="Контактный телефон">
                                    <span class="input-error">Заполните ваш телефон</span>
                                </div>
                                <div class="inputform">
                                    <textarea placeholder="Ваш вопрос" name="text"></textarea>
                                </div>
                                <input type="submit" class="inputbutton" value="Задать вопрос" id="submit">
                            </form>
                        </div>
                        <div class="brand-success">
                            <p>Форма отправлена. В ближайшее время вам перезвонит наш консультант.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="maprow">
            <div class="container">
                <? if ($this->_datas['partner']['exclude']): ?><input type="hidden" name="exclude" value="1"/><?endif;?>
                <input type="hidden" name="wide" value="<?=$this->_datas['wide'];?>"/>
                <div class="mapblock">
                    <!--<div class="address-hide address-show">
                        <div class="title">
                            <span>Контакты</span>
                            <div class="closed"></div>
                        </div>
                        <div class="addresstext">
                            <p>Адрес: <?=$address?></p>
                            <p>Телефон: <?=$format_phone?></p>
                            <p>E-mail: inbox@toshiba-moscow.com</p>
                            <p>График работы: пн-вс: 10:00 - 20:00</p>
                        </div>
                    </div>
                    <div class="addressclick openblock">Контакты <span class="arrow"></span></div>-->
                    <div id="map" style="height: 100%; width: 100%;"></div>
                  </div>

            </div>
        </div>

        <? /*if ($this->_datas['partner']['name'] != 'tkachdenis' && $this->_datas['region']['name'] == 'Москва'):
        echo '<div class="preimrow kontakty">
            <div class="container">
                <h2>Как проехать</h2>

                <div class="preimlist col2">
                    <div class="preimitem">
                        <img src="/templates/moscow/img/shared/man.png">
                        <div class="preimtext">
                            <div class="preimname">Пешком</div>
                            <div class="preiman">Путь от метро до нас занимает 2 минуты. М. Нагатинская, 1-й вагон из центра, 200 метров через скверик к ближайшему зданию. Точный адрес Варшавское шоссе д.32, дальний вход от метро, Вывеска «Компьютерный сервисный центр». 3 этаж офис № 301</div>
                        </div>
                    </div>
                    <div class="preimitem">
                        <img src="/templates/moscow/img/shared/car.png">
                        <div class="preimtext">
                            <div class="preimname">На машине</div>
                            <div class="preiman">Точный адрес: Варшавское шоссе д.32. Ориентир «Варшавские бани». Возле здания всегда найдутся парковочные места.
                            Если двигаться из центра по Варшавскому шоссе, то после перекрестка с Нагатинским проездом (м. Нагатинская), завернуть направо сразу после большого надземного перехода к Варшавским БАНЯМ.
                                Из области: необходимо съехать на дублер на перекрестке с Нагатинским проездом и  совершить разворот в обратную сторону.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>';
         endif;*/?>

        <ul class="breadcrumb">
                <li><a href="/">Главная</a></li>
                <li>Контакты</li>
        </ul>

        <input type="hidden" name="marka" value="<?=$marka?>">
        <input type="hidden" name="phone" value="<?=$format_phone?>">
        <input type="hidden" name="point" value="<?=$point?>">
