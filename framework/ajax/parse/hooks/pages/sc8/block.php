<?php
    $this->_datas['form_title'] = isset($this->_datas['form_title']) ? $this->_datas['form_title'] : 'Записаться на ремонт';
    $this->_datas['form_description'] = isset($this->_datas['form_description']) ? $this->_datas['form_description'] : 'Оставьте свои контактные данные и мы перезвоним Вам в ближайшее время';
?>
    
    <div class="contact-form">
      <div class="container">
        <h2><?=$this->_datas['form_title']?></h2>
        <p><?=$this->_datas['form_description']?></p>
            <div class="form-block">
                <form class="contact" <?= (!empty($this->_datas['partner']['email']) && $this->_datas['partner']['email'] != 'litovchenko@list.ru') ? 'data-mail="' . $this->_datas['partner']['email'] . '"' : ''; ?>>
                    <div class="send">
                        <div class="row">
                            <div class="col-sm-6 nopadding">
                                <input type="text" name="name" placeholder="Имя">
                            </div>
                            <div class="col-sm-6 nopadding">
                                <input type="tel" name="phone" placeholder="+7 (777) 777-77-77">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 nopadding">
                                <textarea name="message" rows="5" placeholder="Сообщение"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 text-center">
                                <input type="submit" class="btn btn-gr" value="Отправить заявку">
                            </div>
                        </div>
                    </div>
                    <div class="success">
                        <p>Спасибо! Ваше сообщение успешно отправлено.</p>
                    </div>
                </form>
            </div>

      </div>
    </div>
