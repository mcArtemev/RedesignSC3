<div class="contact-form pt-40">
    <div class="container">
        <h1 style="font-size: 30px; font-weight: 800;">Статус ремонта</h1>
        <p><?= $this->_datas['form_description'] ?></p>
        <div class="form-block">
            <form class="status-form">
                <div class="row">
                    <div class="col-sm-8 col-sm-offset-2 nopadding">
                        <input type="text" name="order-num" placeholder="номер заказа" autocomplete="off">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 text-center status-button">
                        <input type="submit" class="btn btn-gr" value="Проверить заказ">
                    </div>
                </div>
            </form>
        </div>

    </div>
</div>
