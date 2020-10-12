<!-- Modal -->
<div class="modal fade" id="getPrice" tabindex="-1" role="dialog" aria-labelledby="getPrice">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            <div class="modal-body">
                <h3>Вызвать мастера</h3>
                <form class="contact" <?= (!empty($this->_datas['partner']['email']) && $this->_datas['partner']['email'] != 'litovchenko@list.ru') ? 'data-mail="' . $this->_datas['partner']['email'] . '"' : ''; ?>>
                    <div class="send">
                        <input type="text" name="name" placeholder="Имя">
                        <input type="tel" name="phone" placeholder="+7 (777)-777-77-77">
                        <textarea name="message" rows="3" placeholder="Сообщение"></textarea>
                        <button type="submit" class="btn btn-gr">Отправить заявку</button>
                    </div>
                    <div class="success">
                        <p>Спасибо! Ваше сообщение успешно отправлено.</p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>