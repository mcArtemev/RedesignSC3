<? use framework\tools;
?>
    <div id="popup" class="uk-modal">
        <div class="uk-modal-dialog">
            <span class="uk-link uk-modal-close uk-close"></span>
            <p class="uk-h2">Записаться на ремонт со скидкой 10%</p>
            <form class="uk-form">

                <fieldset data-uk-margin>
                    <p>
                        <input class="uk-width-1-1 name" type="text" placeholder="ФИО">
                    </p>
                    <p>
                        <input class="uk-width-1-1 tel" type="text" placeholder="Телефон">
                    </p>

                    <p>
                        <select class="uk-width-1-1">
                    <?  foreach ($this->_datas['all_devices'] as $device){
                            if ($this->_datas['arg_url'] =='kompyuternaya-pomoshch'){
                                $selectedType = ('компьютер' == $device['type'])?'selected':'';
                                echo '<option '.$selectedType.'>'.tools::mb_ucfirst($device['type_m']).'</option>';
                            }else{
                                $selectedType = (!empty($this->_datas['model_type'][3]['name_m']) && $this->_datas['model_type'][3]['name_m'] == $device['type_m'])?'selected':'';
                                echo '<option '.$selectedType.'>'.tools::mb_ucfirst($device['type_m']).'</option>';
                            }
                        }    
                    ?>
                        </select>
                    </p>
                    <p>
                        <textarea class="uk-width-1-1" cols="30" rows="5" placeholder="Комментарий к заказу"></textarea>
                    </p>
                    <p>
                        <label style="display: block; line-height: 20px;"><input class="datago" type="checkbox" style="float: left; width: 14px; height: 14px; margin: 3px 5px 3px 0px;" checked required>Я даю согласие на обработку персональных данных.</label>
                    </p>
                    <p class="uk-text-center">
                        <button class="uk-button uk-button-success uk-button-large" type="button" onclick="if (typeof window['yaCounter<?=$metrica?>'] !== 'undefined') yaCounter<?=$metrica?>.reachGoal('ZAKAZ'); return false;">Заказать</button>
                    </p>
                </fieldset>

            </form>
        </div>
    </div>