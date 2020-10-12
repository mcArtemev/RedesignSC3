<?php

use framework\tools;


$marka = $this->_datas['marka']['name'];  // SONY
$marka_id = $this->_datas['marka']['id'];
$marka_lower = mb_strtolower($marka);
$servicename = $this->_datas['servicename']; //SONY Russia
$ru_servicename = $this->_datas['ru_servicename']; //
$ru_marka = $this->_datas['marka']['ru_name']; // СОНИ
$marka_lower = mb_strtolower($marka);

$region_name = $this->_datas['region']['name'];//Москва
$region_name_eng = $this->_datas['region']['translit2'];//Moscow
$region_name_pril = $this->_datas['region']['pril_rp'];//Московского
$region_name_pe = $this->_datas['region']['name_pe'];//в Москве (в Владивостоке)
$region_name_de = $this->_datas['region']['name_de'];//по Москве (Владивостоку)
$region_name_re = $this->_datas['region']['name_re'];//служба Москвы (Владивостока)
$phone = $this->_datas['phone'];
$phone_format = tools::format_phone($phone);

$metrica = $this->_datas['metrica'];
$site_id = $this->_site_id;
$setka_id = $this->_datas['setka_id'];
$setka_name = $this->_datas['setka_name'];

// if ($this->_datas['query'] == 'admin=admin'){
     //var_dump($this->_datas);
// }

$centr1 = "<div class=\"item\"><div class=\"digits-num\">";
$centr2 = "</div><div class=\"digits-text\">";
$centr3 = "</span></div></div>";


$centr = array();
$centr_0 = rand(3,11);
$centr[0][] = array($centr_0);
$centr[0][] = array(
    mb_substr(tools::declOfNum($centr_0, array("Свободный<span>оператор", "Свободных<span>оператора", "Свободных<span>операторов")), mb_strlen($centr_0)+1),
    mb_substr(tools::declOfNum($centr_0, array("Свободный<span>диспетчер", "Свободных<span>диспетчера", "Свободных<span>диспетчеров")), mb_strlen($centr_0)+1),
    mb_substr(tools::declOfNum($centr_0, array("Оператор<span>call-центра", "Оператора<span>call-центра", "Операторов<span>call-центра")), mb_strlen($centr_0)+1),
    mb_substr(tools::declOfNum($centr_0, array("Диспетчер<span>call-центра", "Диспетчера<span>call-центра", "Диспетчеров<span>call-центра")), mb_strlen($centr_0)+1),
    mb_substr(tools::declOfNum($centr_0, array("Оператор<span>колл-центра", "Оператора<span>колл-центра","Операторов<span>колл-центра" )), mb_strlen($centr_0)+1),
    mb_substr(tools::declOfNum($centr_0, array("Диспетчер<span>колл-центра", "Диспетчера<span>колл-центра", "Диспетчеров<span>колл-центра")), mb_strlen($centr_0)+1),
    mb_substr(tools::declOfNum($centr_0, array("Оператор<span>свободен", "Оператора<span>свободно", "Операторов<span>свободно")), mb_strlen($centr_0)+1),
    mb_substr(tools::declOfNum($centr_0, array("Оператор<span>в колл-центре", "Оператора<span>в колл-центре", "Операторов<span>в колл-центре")), mb_strlen($centr_0)+1),
    mb_substr(tools::declOfNum($centr_0, array("Оператор<span>в call-центре", "Оператора<span>в call-центре", "Операторов<span>в call-центре")), mb_strlen($centr_0)+1),
    mb_substr(tools::declOfNum($centr_0, array("Не занятый<span>оператор", "Не занятых<span>оператора", "Не занятых<span>операторов")), mb_strlen($centr_0)+1));
$centr_1 = rand(27,44);
$centr[1][] = array($centr_1);
$centr[1][] = array(
    mb_substr(tools::declOfNum($centr_1, array("Заказ<span>в работе", "Заказа<span>в работе", "Заказов<span>в работе")), mb_strlen($centr_1)+1),
    mb_substr(tools::declOfNum($centr_1, array("Устройство<span>в работе", "Устройства<span>в работе", "Устройств<span>в работе")), mb_strlen($centr_1)+1),
    mb_substr(tools::declOfNum($centr_1, array("Аппарат<span>в работе", "Аппарата<span>в работе", "Аппаратов<span>в работе")), mb_strlen($centr_1)+1),
    mb_substr(tools::declOfNum($centr_1, array("Устройство<span>в ремонте", "Устройства<span>в ремонте", "Устройств<span>в ремонте")), mb_strlen($centr_1)+1),
    mb_substr(tools::declOfNum($centr_1, array("Аппарат<span>в ремонте", "Аппарата<span>в ремонте", "Аппаратов<span>в ремонте")), mb_strlen($centr_1)+1),
    mb_substr(tools::declOfNum($centr_1, array("Устройство<span>в лаборатории", "Устройств<span>в лаборатории", "Устройств<span>в лаборатории")), mb_strlen($centr_1)+1),
    mb_substr(tools::declOfNum($centr_1, array("Аппарат<span>в лаборатории", "Аппарата<span>в лаборатории", "Аппаратов<span>в лаборатории")), mb_strlen($centr_1)+1),
    mb_substr(tools::declOfNum($centr_1, array("Ремонтируется<span>устройство", "Ремонтируется<span>устройства", "Ремонтируется<span>устройств")), mb_strlen($centr_1)+1),
    mb_substr(tools::declOfNum($centr_1, array("Ремонтируется<span>аппарат", "Ремонтируется<span>аппарата", "Ремонтируется<span>аппаратов")), mb_strlen($centr_1)+1));
$centr_2 = rand(10,35);
$centr[2][] = array($centr_2);
$centr[2][] = array(
    mb_substr(tools::declOfNum($centr_2, array("Всего<span>инженеров", "Всего<span>инженеров", "Всего<span>инженеров")), mb_strlen($centr_2)+1),
    mb_substr(tools::declOfNum($centr_2, array("Сервисных<span>инженеров", "Сервисных<span>инженера", "Сервисных<span>инженеров")), mb_strlen($centr_2)+1),
    mb_substr(tools::declOfNum($centr_2, array("Мастер<span>", "Мастера<span>", "Мастеров<span>")), mb_strlen($centr_2)+1),
    mb_substr(tools::declOfNum($centr_2, array("Мастер<span>по ремонту", "Мастера<span>по ремонту", "Мастеров<span>по ремонту")), mb_strlen($centr_2)+1),
    mb_substr(tools::declOfNum($centr_2, array("Сервисный<span>мастер", "Сервисных<span>мастера", "Сервисных<span>мастеров")), mb_strlen($centr_2)+1),
    mb_substr(tools::declOfNum($centr_2, array("Ремонтный<span>мастер", "Ремонтных<span>мастера", "Ремонтных<span>мастеров")), mb_strlen($centr_2)+1),
    mb_substr(tools::declOfNum($centr_2, array("Сервисныq<span>специалист", "Сервисных<span>специалиста", "Сервисных<span>специалистов")), mb_strlen($centr_2)+1),
    mb_substr(tools::declOfNum($centr_2, array("Всего<span>мастеров", "Всего<span>мастеров", "Всего<span>мастеров")), mb_strlen($centr_2)+1));

$centr[3][] = array($this->_datas['rand_ustroistva']);
$centr_3 = $this->_datas['rand_ustroistva'];
$centr[3][] = array(
    tools::declOfNum($centr_3, array("Отремонтированое<span>устройство", "Отремонтированных<span>устройств", "Отремонтированных<span>устройств"),false),
    tools::declOfNum($centr_3, array("Отремонтированный<span>аппарат", "Отремонтированных<span>аппарата", "Отремонтированых<span>аппаратов"),false),
    tools::declOfNum($centr_3, array("Устройство<span>отремонтировано", "Устройства<span>отремонтировано", "Устройств<span>отремонтировали"),false),
    tools::declOfNum($centr_3, array("Аппарат<span>отремонтирован", "Аппарата<span>отремонтировано", "Аппаратов<span>отремонтировали"),false)

);



$centr_count = count($centr);
$centr_out = "";
for ($i = 0;$i < $centr_count;$i++)
{
    $centr_arr = array_rand($centr);
    $centr_out .= $centr1 . $this->checkcolumn($centr[$centr_arr][0]) . $centr2 .$this->checkcolumn($centr[$centr_arr][1]) . $centr3;
    unset($centr[$centr_arr]);
}

srand($this->_datas['feed']);

?>
<main>
    <section class="showcase showcase-top">
        <div class="container showcase-inside">
            <div class="grid-6">
                <div class="showcase-info">
                    <h1 class="showcase-title"><?=$this->_ret['h1']?></h1>
                    <div class="showcase-text">
                        <p><?=$description_baner?></p>
                    </div>
                    <button href="#callback_order" class="btn btn-border-light" data-toggle="modal">Статус заказа</button>
                </div>
            </div>
            <div class="grid-5">
                <div class="block-form block-rel">
                    <button type="button" class="close x_pos">&times;</button>
                    <form class="block-form-inside">
                             <div class="send">
                            <div class="form-title">Вызов мастера</div>
                            <div class="form-input">
                                <input type="text" class="phone inputform" placeholder="Телефон">
                                <i class="fa fa-question-circle"></i>
                                <div class="input-tooltip">Обязательное поле</div>
                            </div>
                            <div class="form-input">
                                <input type="text" class="name inputform" placeholder="Имя">
                            </div>
                            <div class="form-btn">
                                <div class="btn btn-accent btn-with-input">
                                    <input type="submit" class="" value="Перезвоните мне">
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
    </section>
    <section class="digits">
        <div class="container">
            <div class="grid-12">
                <div class="digits-inside">
                    <?=$centr_out?>
                </div>
            </div>
        </div>
    </section>

  <section class="articles">
  	<div class="container">
        <div class="grid-12">
            <div class="articles-inside">
                <div class="item">
                    <div class="articles-info">
                        <div class="articles-title">
                            <a href="/antivirus-help">Антивирусная помощь</a>
                        </div>
                            <a class="btn btn-link" href="/antivirus-help">Подробнее</a>
                    </div>
                    <div class="articles-image" style="margin: 10px auto;">
                        <a href="/antivirus-help"><img src="/images/pomosch-img/notebook.png"></a>
                    </div>
                </div>
                <div class="item">
                    <div class="articles-info">
                        <div class="articles-title">
                            <a href="/data-recovery">Восстановление данных</a>
                        </div>
                            <a class="btn btn-link" href="/data-recovery">Подробнее</a>
                    </div>
                    <div class="articles-image" style="margin: 10px auto;">
                        <a href="/data-recovery"><img src="/images/pomosch-img/disc.png"></a>
                    </div>
                </div>
                <div class="item">
                    <div class="articles-info">
                        <div class="articles-title">
                            <a href="/installing-os">Установка и настройка ОС</a>
                        </div>
                            <a class="btn btn-link" href="/installing-os">Подробнее</a>
                    </div>
                    <div class="articles-image" style="margin: 10px auto;">
                        <a href="/installing-os"><img src="/images/pomosch-img/OS.png"></a>
                    </div>
                </div>
                <div class="item">
                    <div class="articles-info">
                        <div class="articles-title">
                            <a href="/installing-software">Установка и настройка ПО</a>
                        </div>
                            <a class="btn btn-link" href="/installing-software">Подробнее</a>
                    </div>
                    <div class="articles-image" style="margin: 10px auto;">
                        <a href="/installing-software"><img src="/images/pomosch-img/load.png"></a>
                    </div>
                </div>
                <div class="item">
                    <div class="articles-info">
                        <div class="articles-title">
                            <a href="/configuring-internet">Настройка роутера и интернета</a>
                        </div>
                            <a class="btn btn-link" href="/configuring-internet">Подробнее</a>
                    </div>
                    <div class="articles-image" style="margin: 10px auto;">
                        <a href="/configuring-internet"><img src="/images/pomosch-img/router.png"></a>
                    </div>
                </div> 
                <div class="item">
                    <div class="articles-info">
                        <div class="articles-title">
                            <a href="/installing-devices">Подключение и настройка периферии</a>
                        </div>
                            <a class="btn btn-link" href="/installing-devices">Подробнее</a>
                    </div>
                    <div class="articles-image" style="margin: 10px auto;">
                        <a href="/installing-devices"><img src="/images/pomosch-img/printer.png"></a>
                    </div>
                </div> 
            </div>
        </div>
  	</div>
  	</section>
    <? //include ('pomosch-promo.php');
       //include ('pomosch-how-we-work.php'); ?>
    <div class="modal fade" id="callback_order" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="close x_pos" data-dismiss="modal">&times;</button>
                <div class="modal-header">
                    <div class="modal-title">Введите номер заказа</div>
                </div>
                <div class="modal-body">
                    <div class="block-form">
                        <form class="block-form-inside">
                            <div class="send">
                                <div class="form-input">
                                    <input type="text" id="order_id" class="phone inputform" placeholder="Номер заказа *">
                                    <i class="fa fa-question-circle"></i>
                                    <div class="input-tooltip">Обязательное поле</div>
                                </div>
                                <div class="form-btn">
                                    <div class="btn btn-accent btn-with-input">
                                        <input type="submit" class="" value="Проверить">
                                    </div>
                                </div>
                            </div>
                            <div class="success">
                                <p class="block-text">Извините,<br />заказ не найден.</p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
