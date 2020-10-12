<div class="slogan-right">
    <div class="slogan-right__form">
        <h2>Заявка на ремонт</h2>
        <p>Оформите заявку прямо сейчас <br> и получите скидку 25%</p>
        <form class="form-request">
            <div class="form-request__item">
                <input type="text" class="form-request__input" name = "name" placeholder="Ваш имя *" required>
            </div>
            <div class="form-request__item">
                <input type="text" class="form-request__input" name = "phone" placeholder="Ваш номер телефона *" required>
            </div>
            <div class="form-request__item">
                <select class="form-request__select" name = "select" placeholder="Выберите тип устройства">
                    <option value="" disabled selected>Выберите тип устройства</option>
                    <? foreach ($types as $typeName => $type)
                    {
                        echo "<option value=\"".mb_strtolower($typeName)."\">".$this->firstup($typeName) . "</option>";
                    }
                        ?>
                </select>
            </div>
            <div class="form-request__submit">
                <button type = "submit" class="form-request__btn">Отправить заявку</button>
            </div>
        </form>
    </div>
</div>
