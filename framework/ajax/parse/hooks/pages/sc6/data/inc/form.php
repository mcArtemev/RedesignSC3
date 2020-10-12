<div class="form-question actual-price">
  <h2 class="form-question__title">Узнать точную стоимость</h2>
  <p class="form-question__txt">Цены озвученные оператором не изменятся</p>
  <form class="form-horizontal form-question__inner">
    <div class="form-group form-question__item">
      <input type="text" class="form-control form-question__input" name = "name" placeholder="Ваш имя *" required>
    </div>
    <div class="form-group form-question__item">
      <input type="text" class="form-control form-question__input" name = "phone" placeholder="Ваш номер телефона *" required>
    </div>
    <?php if (isset($this->_datas['model_type']['name'])) { ?><input type = "hidden" name = "select" value = "<?=$this->_datas['model_type']['name']?>"> <?php } ?>
    <div class="form-group form-question__item">
      <button type="submit" class="btn btn-default form-question__btn">Отправить запрос</button>
    </div>
  </form>
</div>
