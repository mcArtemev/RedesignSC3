<div class="modal fade" id="callback" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="close x_pos" data-dismiss="modal">&times;</button>
            <div class="modal-header">
                <div class="modal-title">Заказать обратный звонок</div>
            </div>
            <div class="modal-body">
                <div class="block-form">
                    <form class="block-form-inside">
                        <div class="send">
                            <div class="form-input">
                                <input type="text" class="phone inputform" placeholder="Телефн" name="phone" required>
                                <i class="fa fa-question-circle"></i>
                                <div class="input-tooltip">Обязательное поле</div>
                            </div>
                            <div class="form-input">
                                <input type="text" class="name inputform" placeholder="Имя">
                            </div>
                            <div class="form-btn">
                                <div class="btn btn-accent btn-with-input" onClick="ValidPhone()">
                                    <input type="submit" class="" value="Отправить заявку">
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
            </div>
        </div>
    </div>
</div>