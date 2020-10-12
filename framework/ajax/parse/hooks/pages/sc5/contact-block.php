            <?  use framework\tools; 
            $time = ($this->_datas['partner']['time']) ? $this->_datas['partner']['time'] : 'без выходных с 10:00 до 20:00';
            $point = $this->_datas['partner']['x'].','.$this->_datas['partner']['y'];
            ?>               
               <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
<!--               <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU&apikey=24261e60-ced5-4231-aa1e-a40c5b3251e2" type="text/javascript"></script> если перестанет работать карта раскоментируйте эту строку эта ссылка с рабочем апи ключом-->
               <input type="hidden" name="point" value="<?=$point?>">
            <section class="inner-page cut map-wrapper">
                <div class="container">
                    <div class="h1">Удобный сервис, <br>который всегда рядом</div>
                    <div class="map">
                        <div id="map" style="width: 831px; height: 500px;"></div>
                    </div>
                </div>
                <div class="container mb-40">
                    <p><?=$phone_format?><br>
                        Работаем Пн-Вс: с 10-00 до 20-00</p>
                    <input type="hidden" name="point" value="55.794401, 37.592042">
<!--                    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU&apikey=24261e60-ced5-4231-aa1e-a40c5b3251e2" type="text/javascript"></script> если перестанет работать карта раскоментируйте эту строку эта ссылка с рабочем апи ключом-->
                    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
                    <p>
                        - хорошая пешая доступность<br>
                        - удобно подъехать на автомобиле<br>
                        - наш курьер, если не хотите ехать сами<br>
                        - без выходных и праздничных дней
                    </p>
                    <div class="button-block">
                        <button type="button" class="callback-modal button button-reverse dell mr-20" data-title="Запишитесь на ремонт" data-button="записаться на ремонт" data-textarea="ваша неисправность" data-title-tip="и мы свяжемся с вами в течении 3х минут">записаться на ремонт</button>
                        <button type="button" class="callback-modal button  dell" data-title="Вызовите курьера на дом" data-button="вызвать курьера" data-textarea="ваш адрес и описание неисправности" data-title-tip="Это бесплатно в пределах города. Перезвоним за 3 мин!" data-textarea-tip="пример: курьер на , Dell Inspiron 5555 после падения перестал заряжать батарею">бесплатный курьер</button>
                    </div>
                </div>
            </section>