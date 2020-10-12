<div class="container">
    <div class="grid-12">

    <!--noindex-->
    <div class="block block-small block-image block-promo-wrapper">
    <?php if (!empty($this->_datas['hb'])) { ?>
        <div class="block-image-url" style="background-image: url('/images/hab/<?=mb_strtolower($marka)?>/<?=$this->_datas['accord_image'][$model_type_name_ru]?>.png'); background-position: 50% 50%;">
    <?php } else { ?>
        <div class="block-image-url" style="background-image: url('/images/sample/hub<?=$this->_datas['accord_image'][$model_type_name_ru]?>.png'); background-position: 50% 50%;">
    <?php } ?>
             <div class="block-promo">
                <p class="block-promo-title">ДАРИМ 1000 рублей</p>
                <p class="block-promo-title"><small>Получить промокод на ремонт ПРОСТО!</small></p>
                <p class="block-promo-title-text"><span class="number">1</span> Получите промокод SMS сообщением<br />
                <span class="number">2</span> Сообщите промокод при сдаче устройства в сервис/курьеру<br />
                <span class="number">3</span> Оплачивайте до 1000 рублей полностью с помощью промокода*<br />
                <small>* - оплачивать промокодом можно не более 20% от суммы ремонта</small></p>
            </div>
        </div>
        <div class=" block-small block-form">
		<button type="button" class="close x_pos">&times;</button>
		<form class="block-form-inside" data-op="promo">
			<div class="send">
				<div class="form-title">Получить SMS с промокодом</div>
				<div class="form-input">
					<input type="text" class="phone inputform" placeholder="Телефон">
					<i class="fa fa-question-circle"></i>
					<div class="input-tooltip">Обязательное поле</div>
				</div>
				<!--<div class="form-input">
					<input type="text" class="name inputform" placeholder="Имя">
				</div>-->
				<div class="form-btn">
					<div class="btn btn-accent btn-with-input">
						<input type="submit" class="" value="Отправьте мне SMS">
					</div>
				</div>
			</div>
			<div class="success">
                <div class="block-text">
    				<img src="/templates/russupport/img/success-512.png" style="width: 20%;" />
    				<p></p>
                </div>
			</div>
		</form>
	</div>
    </div>
    <!--/noindex-->
                             
	
    
    </div>
 </div>