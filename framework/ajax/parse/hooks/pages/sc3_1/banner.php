    
    <section class="main-screen">
       
        <div class="bg"></div>
        <div class="bg bg2"></div>
        <div class="bg bg3"></div>
            <div class="container">
                <div class="row">
                    <div class="col-md-7">
                        <h1>Сервисный центр <?=(!in_array($url, ['/o_nas/', '/kontakty/', '/vakansii/', '/dostavka/']) && isset($this->_datas['marka']) ? ' '.$marka : '')?></h1>
                        <div class="row">
                            <div class="col-md-2 text-center align-self-center">
                                <img src="/templates/moscow/img/images/delivery.svg" alt="" width="50">
                            </div>
                            <div class="col-md-10 py-3">
                                Выезд курьера/мастера или доставка <br>до нас бесплатно в пределах МКАД в течение 40 минут
                            </div>
                            <div class="col-md-2 text-center align-self-center">
                                <img src="/templates/moscow/img/images/premium-quality.svg" alt="" width="50">
                            </div>
                            <div class="col-md-10 py-3">
                                Гарантия на услуги 5 лет.<br>Ремонт гарантийных случаев без очереди.
                            </div>
                            <div class="col-md-2 text-center align-self-center">
                                <img src="/templates/moscow/img/images/clock.svg" alt="" width="50">
                            </div>
                            <div class="col-md-10 py-3">
                                Ремонт и настройка от 20 минут. <br>
                                Срочная диагностика от 30 минут.
                            </div>
                        </div>
                    </div>
                        
                        <? if (isset($banner_img_dop)) { echo '<img src="'.$banner_img_dop.'"/>'; } 
                        
                        if (isset($price_str)):?>
                        <div class="imageprice">
                            <?=$price_str?> руб
                        </div>
                        <? endif; ?>
                        <div class="col-md-5 align-self-center">
                            <div class="target-form">
                                <p class="target-form-title">Закажите ремонт<br> <span class="target-blue">со скидкой 10%</span></p>
                                <p>Записываясь на ремонт любой техники <?=(!in_array($url, ['/o_nas/', '/kontakty/', '/vakansii/', '/dostavka/']) && isset($this->_datas['marka']) ? ' '.$marka : '')?> в нашем сервисе в этом месяце, вы получаете скидку на все услуги</p>
                                <form class="imageform">
                                    <div class="inputform"><input type="text" name="name" class="form-control" placeholder="Ваше имя"></div>
                                    <div class="inputform inputformreq">
                                        <input type="tel" class="form-control" placeholder="Контактный телефон">
                                        <span class="input-error">Заполните ваш телефон</span>
                                    </div>
                                    <input type="submit" class="inputbutton" value="Записаться на ремонт" id="submit">
                                </form>
                            </div>
                            
                        </div>
                </div>
            </div>
    </section>
