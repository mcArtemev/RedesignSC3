<div class="block block-small block-form">
    <button type="button" class="close x_pos">&times;</button>
    <form class="block-form-inside">
        <div class="send">
            <div class="form-title">Заказать звонок специалиста</div>
            <div class="form-input">
                <input type="text" class="phone inputform" placeholder="Телефон" id="phone" name="phone" required>
                <i class="fa fa-question-circle"></i>
                <div class="input-tooltip" id="message">Обязательное поле</div>
            </div>
            <div class="form-input">
                <input type="text" class="name inputform" placeholder="Имя">
            </div>
            <div class="form-btn">
                <div class="btn btn-accent btn-with-input" onClick="ValidPhone()">
                    <input type="submit" class="" value="Перезвоните мне">
                </div>
            </div>
        </div>
        <div class="success">
			<div class="block-text">
				<img src="/templates/russupport/img/success-512.png" style="width: 30%;" />
				<p>Спасибо за заявку,<br />мы свяжемся с вами в течении 15-30 минут.</p>
			</div>
        </div>
    </form>
</div>

<!-- Отвечает за внутрений page "ремонт (тип устроства)" -->