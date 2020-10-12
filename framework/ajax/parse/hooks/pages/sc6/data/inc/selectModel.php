<?php
use framework\ajax\parse\hooks\pages\sc6\data\src\model_service;
use framework\ajax\parse\hooks\pages\sc6\data\src\type_service;
use framework\tools;

if (count($models)) {
$cur = current($models);
?>
<h3 class="block-select__title">Ремонтируем все модели:</h3>
<form class="block-select__form" id = "selectModel">
  <div class="block-select__form-wrap">
    <div class="block-select__form-left">
      <select class="block-select__form_select" name = "model">
        <?php foreach ($models as $model) {
            $url = tools::search_url($this->_datas['site_id'], serialize(array('model_id' => $model['id'])));
            // echo '<div style="display:none">'.$url.'</div>';
            if (!empty($url)) {
                echo "<option value='/{$url}'>{$model['name']}</option>";
                // echo "<option value='/{$url}'>{$model['name']}</option>";
            } else {
                echo "<option value='#{$model['id']}'>{$model['name']}</option>";
            }
        } ?>
      </select>
    </div>
    <div class="block-select__form-right">
      <button type="button">
        Перейти
         <i class="fa fa-angle-right" aria-hidden="true"></i>
      </button>
    </div>
  </div>
</form>

<p style = "display: none;" class="block-select__choosed">
    Вы выбрали:
    <!--<a data-in = "/<?//=type_service::TYPES_URL[$this->_datas['model_type']['name']]?>/" href="/<?//=type_service::TYPES_URL[$this->_datas['model_type']['name']]?>/<?//=model_service::renderUrl($cur['name'])?>/">-->
    <a data-in = "" href="/<?=type_service::TYPES_URL[$this->_datas['model_type']['name']]?>/<?=model_service::renderUrl($cur['name'])?>">
        <?=tools::mb_firstupper($this->_datas['model_type']['name'])?> 
        <span><?=$cur['name']?></span>
    </a>
</p>
<?php } ?>
