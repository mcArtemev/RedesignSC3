<? use framework\tools; ?>
<div class="rightPart">
		<div class="BlockInfo diagnostika">
			<div class="text">
				<p class="title">Экспресс диагностика</p>
				<p>точное выявление<br>неисправности</p>
				<p class="link"><a href="/diagnostika/">Подробнее</a></p>
			</div>
		</div>
		<div class="BlockInfo garantiya">
			<div class="text">
                <p class="title">Детали <?=mb_strtoupper($this->_datas['marka']['name'])?></p>
				<p>в наличии более<br>10000 наименований<br>комплектующих <?=tools::mb_ucfirst($this->_datas['marka']['name'])?></p>
				<p class="link"><a href="/zapchasti/">Подробнее</a></p>
			</div>
		</div>
		<div class="BlockInfo vyezd">
			<div class="text">
				<p class="title">Выезд и доставка</p>
				<p>Курьерская доставка - <br>от 30 минут</p>
				<p class="link"><a href="/dostavka/">Подробнее</a></p>
			</div>
		</div>
		<div class="BlockInfo srochnyy-remont">
			<div class="text">
				<p class="title">Срочный ремонт</p>
				<p>Устранение типовых<br>неисправностей<br>в течение 24 часов</p>
				<p class="link"><a href="/sroki/">Подробнее</a></p>
			</div>
	   </div> 
      <? if ($this->_datas['region']['name'] != 'Москва'):?> 
       <!--/noindex-->   
       <div class="BlockInfo station">
            <div class="text">
                <p class="title">Наше оборудование</p>
                <?=$this->_datas['vars2']?>
            </div>
       </div>
       <? endif; ?>
</div>
