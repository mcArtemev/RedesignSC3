<? //dont use 
use framework\tools; ?>
<? if (!$this->_datas['region_id']): ?>
<div class="form-add-bid">
    <div class="left-part">
        <a data-modal="zakazPopup" class="md-trigger" href="#">Запишитесь на ремонт</a>
        <p>прямо сейчас<br />и получите скидку 10%</p>
    </div>
    <div class="right-part">
        <p>Или оставьте заявку по телефону единого сервисного центра <?=mb_strtoupper($this->_datas['marka']['name'])?></p>
        <p class="phone"><?=tools::format_phone($this->_datas['phone'])?></p>        
    </div>
    <div class="clear"></div>
</div>
<?else:?>
<div class="form-add-bid new-form">
    <p class="full-width">
        <?=$this->_datas['text-form']?>
    </p>
    <div class="Button"><p><a data-modal="zakazPopup" class="md-trigger" href="#">Записаться на ремонт</a></p></div>
    <p class="phone"><?=tools::format_phone($this->_datas['phone'])?></p>
</div>
<?endif;?>