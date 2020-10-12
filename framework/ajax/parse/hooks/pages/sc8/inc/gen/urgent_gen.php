<?php

use framework\ajax\parse\hooks\sc;

$remont_txt_1 = array();
$remont_txt_1[] = array('У');
$remont_txt_1[] = array('вас');
$remont_txt_1[] = array('случилась');
$remont_txt_1[] = array('неприятность', 'проблема');
$remont_txt_1[] = array('с');
$remont_txt_1[] = array('техникой?');

$remont_txt_2 = array();
$remont_txt_2[] = array('Тогда');
$remont_txt_2[] = array('вы');
$remont_txt_2[] = array('можете', 'имеете возможность');
$remont_txt_2[] = array('воспользоваться');
$remont_txt_2[] = array('услугой');
$remont_txt_2[] = array('срочного', 'быстрого', 'экстренного');
$remont_txt_2[] = array('ремонта');
$remont_txt_2[] = array('от');
$remont_txt_2[] = array('квалифицированных', 'опытных', 'знающих');
$remont_txt_2[] = array('специалистов', 'мастеров');
$remont_txt_2[] = array('нашей');
$remont_txt_2[] = array('организации,', 'фирмы,', 'компании,');
$remont_txt_2[] = array('заполнив');
$remont_txt_2[] = array('всего', 'только', 'исключительно');
$remont_txt_2[] = array('лишь');
$remont_txt_2[] = array('небольшую', 'короткую');
$remont_txt_2[] = array('форму заявки.', 'онлайн форму.', 'форму.');

$remont_txt_3 = array();
$remont_txt_3[] = array('Ваше');
$remont_txt_3[] = array('устройство');
$remont_txt_3[] = array('обязательно', 'гарантированно');
$remont_txt_3[] = array('приведут');
$remont_txt_3[] = array('в');
$remont_txt_3[] = array('порядок');
$remont_txt_3[] = array('оперативно.');

$h2 = array();
$h2[] = array('Ремонт не требующий много времени!');

$remont_txt_4 = array();
$remont_txt_4[] = array('Обращение');
$remont_txt_4[] = array('в');
$remont_txt_4[] = array('сервис');
$remont_txt_4[] = array('не');
$remont_txt_4[] = array('отнимет', 'заберет');
$remont_txt_4[] = array('много', 'большое количество');
$remont_txt_4[] = array('времени');
$remont_txt_4[] = array('у');
$remont_txt_4[] = array('клиента', 'заказчика');
$remont_txt_4[] = array('благодаря', 'по причине');
$remont_txt_4[] = array('продуманной', 'расчитанной', 'обдуманной');
$remont_txt_4[] = array('продуманной', 'структуре');
$remont_txt_4[] = array('ресурса.');

$remont_txt_5 = array();
$remont_txt_5[] = array('Форма');
$remont_txt_5[] = array('заполняется');
$remont_txt_5[] = array('в');
$remont_txt_5[] = array('течении');
$remont_txt_5[] = array('30');
$remont_txt_5[] = array('секунд');
$remont_txt_5[] = array('и');
$remont_txt_5[] = array('обязательно');
$remont_txt_5[] = array('указывается', 'отмечается');
$remont_txt_5[] = array('пункт');
$remont_txt_5[] = array('о');
$remont_txt_5[] = array('срочности');
$remont_txt_5[] = array('ремонта.');

$remont_txt_6 = array();
$remont_txt_6[] = array('Консультант');
$remont_txt_6[] = array('связывается');
$remont_txt_6[] = array('с');
$remont_txt_6[] = array('вами');
$remont_txt_6[] = array('и');
$remont_txt_6[] = array('уточняет,');
$remont_txt_6[] = array('когда', 'в какое время', 'в какой период');
$remont_txt_6[] = array('вам');
$remont_txt_6[] = array('удобно', 'комфортно');
$remont_txt_6[] = array('прийти');
$remont_txt_6[] = array('или');
$remont_txt_6[] = array('же');
$remont_txt_6[] = array('предлагается', 'предоставляется', 'оказывается');
$remont_txt_6[] = array('услуга');
$remont_txt_6[] = array('выезда', 'визита');
$remont_txt_6[] = array('мастера');
$remont_txt_6[] = array('на');
$remont_txt_6[] = array('указанный');
$remont_txt_6[] = array('адрес.');


$remont_txt_7 = array();
$remont_txt_7[] = array('В 90% случаев срочный ремонт длится не более 2 часов, проходя все этапы: от диагностики до выдачи рабочего аппарата.');

$this->_ret['remont_txt_1'] = !empty($remont_txt_1) ? sc::_createTree($remont_txt_1, $feed) : null;
$this->_ret['remont_txt_2'] = !empty($remont_txt_2) ? sc::_createTree($remont_txt_2, $feed) : null;
$this->_ret['remont_txt_3'] = !empty($remont_txt_3) ? sc::_createTree($remont_txt_3, $feed) : null;
$this->_ret['h2'] = !empty($h2) ? sc::_createTree($h2, $feed) : null;
$this->_ret['remont_txt_4'] = !empty($remont_txt_4) ? sc::_createTree($remont_txt_4, $feed) : null;
$this->_ret['remont_txt_5'] = !empty($remont_txt_5) ? sc::_createTree($remont_txt_5, $feed) : null;
$this->_ret['remont_txt_6'] = !empty($remont_txt_6) ? sc::_createTree($remont_txt_6, $feed) : null;
$this->_ret['remont_txt_7'] = !empty($remont_txt_7) ? sc::_createTree($remont_txt_7, $feed) : null;