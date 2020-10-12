<?      use framework\tools; ?>

        <div class="bannerrow">
            <div class="container">
                <div class="textbanner<?=((isset($this->_datas['static'])) ? ' static' : '')?>">
                    <div class="text"><?=$this->_datas['total']?></div>
                    <div class="text-phone"><a href="tel:+<?=$this->_datas['phone']?>">+ <?=tools::format_phone($this->_datas['phone'])?></a></div> 
                </div>
            </div>
        </div>
        
        <? if (isset($this->_datas['max_amount'])):?>
            <input type="hidden" value="<?=$this->_datas['max_amount']?>" name="max_amount"/>
        <? endif;?>
        