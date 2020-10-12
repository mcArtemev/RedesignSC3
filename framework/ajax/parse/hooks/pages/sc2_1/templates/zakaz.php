<?
use framework\tools;
$metrica = $this->_datas['metrica'];

?>

<script async custom-element="amp-form" src="https://cdn.ampproject.org/v0/amp-form-0.1.js"></script>
<script>
var sendPath = "/request/";
var loading = false;

$(function(){

    $("input[type=tel]").mask("+7 (999) 999-99-99")

    $(".promo-order .btn").click(function(){
        promo = '';
        number = '';
        for (i=0; i<4; i++)
        {
            rnd = getRandomInt(1, 9).toString();
            promo += '<span>'+ rnd  + '</span>';
            number += rnd;
        }

        $(this).hide();
        $(".promo-kod#text-1").hide();
        $(".promo-order .promo").html(promo);
        $(".promo-order .promo-info").show();
        $(".promo-order .promo-tooltip").show();
        $(".promo-kod#text-2").show();

        str = $("textarea").val();
        if (str)
            str += ', ';
        else
            str = '';

        str += 'Скидка 10% по промо-коду ' + number;
        $("textarea").val(str);

        $(".phone_id").focus();

        document.cookie = "promo=" + promo + "; path=/";
        return false;
    });

    /*if ($("[name=type_val]").length > 0)
        $(".modalDialog select").val($("[name=type_val]").val());*/

    $(".form-zakaz [name=brand]").on('change', function(event){
      var types = $(this).find('option:selected').data('types').split(',');
      $(".form-zakaz [name=type] option").hide().addClass('hide');
      for (i in types) {
        $(".form-zakaz [name=type] option[value='"+types[i]+"']").show().removeClass('hide');
      }
      if (types.length == 1) {
        $(".form-zakaz [name=type]").val(types[0]);
      }
      else {
        $(".form-zakaz [name=type]").val('0')
      }
      $(".form-zakaz [name=type]").removeAttr("disabled");
    });

    if (text = getParameterByName('text'))
        $(".modalDialog textarea").val(text);

    if ((brand = getParameterByName('brand')) && $(".modalDialog [name=brand] option[value="+brand+"]").length > 0) {
        $(".modalDialog [name=brand]").val(brand).trigger('change');
        setTimeout(function() {
        if ((type = getParameterByName('type')) && $(".modalDialog [name=type] option:not(.hide)[value="+type+"]").length > 0)
            $(".modalDialog [name=type]").val(type).removeAttr("disabled");
        }, 100);
    }

    $(".modalDialog form").submit(function(event){

            $context = $(this).closest("form");

            phone_obj = $context.find("input[type=tel]");
            phone_val = phone_obj.val();

            text_obj = $context.find("textarea");
            select_obj = $context.find("select[name=type]");
            name_obj = $context.find("input[type=text]");

            if (phone_val)
            {
               if (!loading)
               {
                   loading = true;

                   records = [];
                   records.push({phone: phone_val, mango: $(".mango_id").first().text(), site:window.location.hostname, mail: $("[name=mail]").val(), brand: $context.find("select[name=brand]").val()});

                   if (text_obj.length > 0)
                        if ((tr = text_obj.val().trim()) != '')
                            records[0]['text'] = tr;

                   if (select_obj.length > 0)
                        if (typeof (ts = select_obj.val()) != 'null')
                            records[0]['select'] = ts;

                   if (name_obj.length > 0)
                        if ((tn = name_obj.val().trim()) != '')
                            records[0]['name'] = tn;

                   $.post(sendPath, {args: {form: records}}, function(data){
                       loading = false;
                       window.location.pathname = "/spasibo/";
                   });
               }
            }
            else
            {
                phone_obj.focus();
            }

            event.preventDefault();
            return false;
        });

});

</script>

    <section class="fixed content-wrapper">

            <div class="content-block">
                <section class="crumbs">
                    <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="/"><meta itemprop="title" content="Главная"/><amp-img src="/bitrix/templates/centre/img/home.png" alt="home"/></a></span>
                    <span> / </span>
                    <span>Запись на ремонт</span>
                </section>
                <div class="content-block__top">
                    <div class="info-block">
                        <h1><?=$this->_ret['h1']?></h1>

                        <div class="promo-order">
                            	<div class="promo-info promo-left">
                            		<p>Получите <strong>10% скидку</strong> по промо-коду.<br/>Скидка действует на все услуги сервисного центра.</p>
                            	</div>
                            	<div class="promo-info promo-right">
                            		<a href="#" class="btn btn--fill">Получить промо-код</a>
                            		<div class="promo"></div>
                            		<div class="promo-tooltip"><p>Ваш промо-код</p></div>
                            	</div>
                            	<div class="clear"></div>
                            	<div class="divider"></div>
                        </div>

                        <p class="promo-kod" id="text-1">&nbsp;</p>
                        <p class="promo-kod" id="text-2">Промо-код действителен при заполнении заявки.</p>
                        <div class="modalDialog form-zakaz">
                            <form onsubmit="yaCounter<?=$metrica?>.reachGoal('ORDER'); return true;">

                                <input type="tel" class="phone_id" value="" placeholder="Телефон * ">
                                <input type="text" value="" placeholder="ФИО">
                                <select name = "brand">
                                  <option selected disabled hidden>Выберите бренд</option>
                                <? foreach($this->_datas['markaTypes'] as $brand=>$types): ?>
                                    <option value="<?=strtolower($brand)?>" data-types = "<?=implode(',', $types)?>"><?=$brand?></option>
                                 <? endforeach; ?>
                                </select>
                                <select name = "type" disabled>
                                  <option value = "0" selected disabled hidden>Выберите тип устройства</option>
                                <? foreach($this->_datas['allTypes'] as $device): ?>
                                    <option value="<?=$device['type']?>"><?=tools::mb_ucfirst($device['type'])?></option>
                                 <? endforeach; ?>
                                </select>
                                <textarea cols="40" rows="8" placeholder="Комментарий к заказу"></textarea>

                                <p>* обязательно для заполнения</p>
                                <input type="submit" class="btn btn--fill" value="Отправить заявку">
                                <div class="clear"></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <? include __DIR__.'/aside.php'; ?>
     </section>
     <div class="clear"></div>
