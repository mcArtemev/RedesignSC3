    <? $banner_right = isset($banner_right) ? $banner_right : true;
     $banner_img = isset($banner_img) ? $banner_img : '/templates/moscow/img/shared/main_phone.png'; ?>
    <div class="imagerow ir-small-margin">
            <div class="container">
                <div class="imagerel">
                    <img src="<?=$banner_img?>"/>
                    <? if (isset($banner_img_dop)) { echo '<img src="'.$banner_img_dop.'"/>'; } 
                    
                    if (isset($price_str)):?>
                    <div class="imageprice">
                        <?=$price_str?> руб
                    </div>
                    <? endif; ?>
                    <div class="imageabs <?=(($banner_right) ? ' imageabs-right' : '')?> <?=(($banner_img ==  '/templates/moscow/img/shared/main_phone.png') ? 'dark-form' : '')?> style='z-index: 600;'">
                        <div class="imagetitle">
                            Закажите ремонт со <span>скидкой 10%</span>
                        </div>
                        <div class="imagetext">
                            Записываясь на ремонт любой техники<?=(!in_array($url, ['/o_nas/', '/kontakty/', '/vakansii/', '/dostavka/']) && isset($this->_datas['marka']) ? ' '.$marka : '')?> в нашем сервисе в этом месяце, вы получаете скидку на все услуги
                        </div>
                        <div class="brand-ask">
                            <form class="imageform">
                                <div class="inputform">
                                    <input type="text" name="name" placeholder="Ваше имя">
                                </div>
                                <div class="inputform inputformreq">
                                    <input type="tel" placeholder="Контактный телефон">
                                    <span class="input-error">Заполните ваш телефон</span>
                                </div>
                                <input type="submit" class="inputbutton" value="Записаться на ремонт" id="submit">
                            </form>
                        </div>
                        <div class="brand-success">
                            <p>Форма отправлена. В ближайшее время вам перезвонит наш консультант.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
