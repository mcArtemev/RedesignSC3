<? use framework\tools; 

$use_choose_city = $this->_datas['use_choose_city'];
$add_class = ($use_choose_city) ? " js-choose-city" : "";

?>

<!--noindex-->
<? if (!$this->_datas['region_id']): ?>
<div class="target-content-block uk-grid uk-grid-medium form-bid<?=$add_class?>">
        <div class="uk-width-large-4-10 uk-width-medium-1-2 uk-width-small-1-2">
            <p class="uk-text-large"><span data-uk-modal="{target:'#popup'}" onclick="if (typeof window['yaCounter<?=$metrica?>'] !== 'undefined') yaCounter<?=$metrica?>.reachGoal('ORDER'); return false;" class="uk-text-success uk-text-bold uk-h3 callback">Запишитесь на ремонт</span></p><p class="uk-margin-bottom">прямо сейчас<br>
            и получите скидку 10%</p>
        </div>
        <div class="uk-width-large-4-10 uk-width-medium-1-2  uk-width-small-1-2 uk-text-center">
            <p>Или оставьте заявку по телефону единого сервисного центра <?=mb_strtoupper($this->_datas['marka']['name'])?></p>
            <p class="uk-text-bold uk-h3"><a href="tel:+<?=$this->_datas['phone']?>">+<?=tools::format_phone($this->_datas['phone'])?></a></p>
        </div>
        <div class="uk-width-large-2-10 uk-hidden-small uk-hidden-medium"><img src="/wp-content/themes/studiof1/img/call-center.png" class="imgbottom"/></div>
</div>
<?else:?>
<div class="target-content-block uk-grid uk-padding form-bid<?=$add_class?>">
        <div class="uk-width-large-8-10">
            <p><?=$this->_datas['text-form']?></p>
            
            <div class="uk-grid uk-margin-bottom">
                <div class="uk-width-medium-1-2">
                    <p class="uk-text-bold uk-h3 textmobile uk-margin-bottom"><a href="tel:+<?=$this->_datas['phone']?>">+<?=tools::format_phone($this->_datas['phone'])?></a></p>
                </div>
                <div class="uk-width-medium-1-2">
                        <p class="textmobile">
                            <span class="">
                                <input type="button" data-uk-modal="{target:'#popup'}"
                       class=" uk-button  uk-button-success uk-margin-left" onclick="if (typeof window['yaCounter<?=$metrica?>'] !== 'undefined') yaCounter<?=$metrica?>.reachGoal('ORDER'); return false;" value="Записаться на ремонт"/>
                            </span>
                       </p>
                </div>
            </div>
        </div>
        <div class="uk-width-large-2-10 uk-hidden-small uk-hidden-medium uk-position-relative"><img src="/wp-content/themes/studiof1/img/call-center.png"></div>
</div>
<?endif;?>
<!--/noindex-->