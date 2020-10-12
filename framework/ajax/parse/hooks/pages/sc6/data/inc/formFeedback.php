<form class="form-question" data-type = "quest">
    <h2 class="form-question__title">Задай вопрос <?=$marka?></h2>
    <div class="form-question__item">
        <input type="text" class="form-control form-question__input" name = "name" placeholder="Ваш имя *" required>
    </div>
    <div class="form-question__item">
        <input type="text" class="form-control form-question__input" name = "phone" placeholder="Ваш номер телефона *" required>
    </div>
    <div class="form-question__item">
        <textarea class="form-control form-question__textarea" name = "text" rows="3" placeholder="Опишите свою проблему"></textarea>
    </div>
    <div class="form-question__last">
        <button type = "submit" class="btn btn-default form-question__btn">Задать вопрос</span>
    </div>
</form>
