<?
use framework\tools;

$marka = $this->_datas['marka']['name'];  // SONY
$servicename = $this->_datas['servicename']; //SONY Russia
$ru_servicename = $this->_datas['ru_servicename']; //
$ru_marka = $this->_datas['marka']['ru_name']; // СОНИ

$region_name = $this->_datas['region']['name'];//Москва
$region_name_pril = $this->_datas['region']['pril'];//Московского
$region_name_pe = $this->_datas['region']['name_pe'];//в Москве (в Владивостоке)
$region_name_de = $this->_datas['region']['name_de'];//по Москве (Владивостоку)
$region_name_re = $this->_datas['region']['name_re'];//служба Москвы (Владивостока)
$phone = $this->_datas['phone'];
$phone_format = tools::format_phone($phone);
$metrica = $this->_datas['metrica'];
//$address = $this->_datas['partner']['address1'];

srand($this->_datas['feed']);

$use_choose_city = $this->_datas['use_choose_city'];
$add_class = ($use_choose_city) ? " js-choose-city" : "";

?>


<div class="uk-width-large-3-10 sr-content-grey">
    <div class="uk-clearfix<?=$add_class?>">
        <img src="/wp-content/themes/studiof1/images/call-center.png" class="uk-align-right uk-margin-bottom-remove uk-hidden-small uk-hidden-medium">
        <p class="uk-text-large"><a href="tel:+<?=$phone?>"><?=$phone_format?></a></p>
        <p class="uk-margin-bottom">Единый номер телефона сервисного центра</p>
    </div>
    <hr style="margin-top: 0px !important;" class="<?=$add_class?>">
    <p class="uk-text-large">Спросите Russia Expert</p>
    <p>
        <? 
            if (isset($vacancy)) {
                echo 'Получите консультацию специалистов '.$this->_datas['marka']['ru_name'].' по актуальным вакансиям или о подробной программе курсов';
            } else {
                echo 'Получите консультацию специалистов Russia Expert по вопросам ремонта и обслуживания техники.';
            }
        ?>
    </p>
    <form class="uk-form">
        <fieldset data-uk-margin>
            <p><input class="uk-width-1-1 tel" type="text" placeholder="Номер телефона"></p>
            <p><input class="uk-width-1-1 name" type="text" placeholder="Имя и фамилия"></p>
            <p><textarea class="uk-width-1-1" cols="30" rows="5" placeholder="Ваш вопрос"></textarea></p>
            <p><label style="display: block; line-height: 20px;"><input class="datago" type="checkbox" style="float: left; width: 14px; height: 14px; margin: 3px 5px 3px 0px;" checked required>Я даю согласие на обработку персональных данных.</label></p>
            <p class="uk-text-center"><button class="uk-button uk-button-success uk-button-large" type="button" onclick="if (typeof window['yaCounter<?=$metrica?>'] !== 'undefined') yaCounter<?=$metrica?>.reachGoal('VOPROS'); return false;">Задать вопрос</button></p>
		</fieldset>
    </form>
    <hr class="uk-hidden-small">
</div>
