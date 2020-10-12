<?php

use framework\ajax\parse\hooks\sc;

$guarant_txt_1 = array();
$guarant_txt_1[] = array('Организация', 'Фирма', 'Компания');
$guarant_txt_1[] = array($servicename);
$guarant_txt_1[] = array('занимается');
$guarant_txt_1[] = array('ремонтом');
$guarant_txt_1[] = array('и');
$guarant_txt_1[] = array('сервисным');
$guarant_txt_1[] = array('обслуживанием');
$guarant_txt_1[] = array('техники в ' . $city);
$guarant_txt_1[] = array('всех');
$guarant_txt_1[] = array('известных', 'популярных', 'любимых');
$guarant_txt_1[] = array('брендов.', 'марок.', 'фирм.');

$guarant_txt_2 = array();
$guarant_txt_2[] = array('Немаловажно', 'Важно');
$guarant_txt_2[] = array('и');
$guarant_txt_2[] = array('соблюдение', 'выполнение');
$guarant_txt_2[] = array('гарантийных');
$guarant_txt_2[] = array('обязательств,', 'ситуаций,', 'условий,');
$guarant_txt_2[] = array('что');
$guarant_txt_2[] = array('обеспечивает', 'оказывает');
$guarant_txt_2[] = array('далеко');
$guarant_txt_2[] = array('не');
$guarant_txt_2[] = array('каждая', 'всякая');
$guarant_txt_2[] = array('порядочная', 'хорошая', 'известная');
$guarant_txt_2[] = array('организация', 'фирма', 'компания');
$guarant_txt_2[] = array('по ремонту.', 'осуществляющая ремонт.');

$guarant_txt_3 = array();
$guarant_txt_3[] = array('В');
$guarant_txt_3[] = array('случае', 'ситуации');
$guarant_txt_3[] = array('возникновения', 'появления', 'выявления');
$guarant_txt_3[] = array('вопросов');
$guarant_txt_3[] = array('в');
$guarant_txt_3[] = array('отношении');
$guarant_txt_3[] = array('качества');
$guarant_txt_3[] = array('работы,');
$guarant_txt_3[] = array('компания', 'сервисный центр', 'сервис');
$guarant_txt_3[] = array('предоставляет');
$guarant_txt_3[] = array('возможность');
$guarant_txt_3[] = array('обращения');
$guarant_txt_3[] = array('клиента', 'заказчика');
$guarant_txt_3[] = array('в');
$guarant_txt_3[] = array('отдел');
$guarant_txt_3[] = array('контроля');
$guarant_txt_3[] = array('качества,');
$guarant_txt_3[] = array('для выполнения');
$guarant_txt_3[] = array('гарантийных обязательств перед клиентом.');

$guarant_txt_4 = array();
$guarant_txt_4[] = array('Обслуживание производится в максимально короткое время, по прошествии которого выдается заключение о причине поломки, рабочий');
$guarant_txt_4[] = array('аппарат', 'гаджет', 'девайс');
$guarant_txt_4[] = array('и новый гарантийный бланк.');

$h2 = array();
$h2[] = array('Гарантия на работу', 'Наши гарантии на ремонт');

$this->_ret['guarant_txt_1'] = !empty($guarant_txt_1) ? sc::_createTree($guarant_txt_1, $feed) : null;
$this->_ret['guarant_txt_2'] = !empty($guarant_txt_2) ? sc::_createTree($guarant_txt_2, $feed) : null;
$this->_ret['guarant_txt_3'] = !empty($guarant_txt_3) ? sc::_createTree($guarant_txt_3, $feed) : null;
$this->_ret['guarant_txt_4'] = !empty($guarant_txt_4) ? sc::_createTree($guarant_txt_4, $feed) : null;
$this->_ret['h2'] = !empty($h2) ? sc::_createTree($h2, $feed) : null;