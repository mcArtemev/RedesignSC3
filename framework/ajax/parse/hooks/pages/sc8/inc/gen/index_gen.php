<?php

use framework\ajax\parse\hooks\sc;
use framework\rand_it;

$banner_txt = array();
$banner_txt[] = array('Наш сервисный центр', 'Наш сервис центр', 'Сервисный центр', 'Сервис центр');
$banner_txt[] = array($servicename);
$banner_txt[] = array('в');
$banner_txt[] = array($city);
$banner_txt[] = array('оказывает');
$banner_txt[] = array('широкий');
$banner_txt[] = array('спектр');
$banner_txt[] = array('ремонтных', 'восстановительных');
$banner_txt[] = array('услуг', 'работ');
$banner_txt[] = array('по');
$banner_txt[] = array('доступным', 'приемлемым');
$banner_txt[] = array('ценам:');

$banner_list = array();

$banner_list_tmp_1 = array();
$banner_list_tmp_1[] = array('Ремонт');
$banner_list_tmp_1[] = array('любого вида', 'всех типов');
$banner_list_tmp_1[] = array('электронной');
$banner_list_tmp_1[] = array('техники и');
$banner_list_tmp_1[] = array('марки', 'бренда');
$banner_list[] = sc::_createTree($banner_list_tmp_1, $feed);


$banner_list_tmp_2 = array();
$banner_list_tmp_2[] = array('Диагностирование', 'Анализ');
$banner_list_tmp_2[] = array('поломки');
$banner_list[] = sc::_createTree($banner_list_tmp_2, $feed);

$banner_list_tmp_3 = array();
$banner_list_tmp_3[] = array('Гарантийное');
$banner_list_tmp_3[] = array('обслуживание');
$banner_list[] = sc::_createTree($banner_list_tmp_3, $feed);

$banner_list_tmp_4 = array();
$banner_list_tmp_4[] = array('Установка');
$banner_list_tmp_4[] = array('и');
$banner_list_tmp_4[] = array('обновление');
$banner_list_tmp_4[] = array('программного обеспечения');
$banner_list[] = sc::_createTree($banner_list_tmp_4, $feed);

$about_team = array();
$about_team[] = array('У');
$about_team[] = array('нас');
$about_team[] = array('работают');
$about_team[] = array('профессионалы', 'специалисты', 'мастера');
$about_team[] = array('с');
$about_team[] = array('огромным', 'большим');
$about_team[] = array('опытом');
$about_team[] = array('по');
$about_team[] = array('обслуживанию', 'ремонту');
$about_team[] = array('различных устройств.', 'техники.', 'электроники и бытовой техники.');
$about_team[] = array('Мастера', 'Наши мастера', 'Специалисты');
$about_team[] = array('восстановят', 'вернут');
$about_team[] = array('работоспособность');
$about_team[] = array('даже');

srand($feed);

$choose = rand(0, 1);

switch ($choose) {
    case '0' :
        $about_team[] = array('самых хрупких');
        $about_team[] = array('гаджетов', 'устройств');
        break;
    case '1' :
        $about_team[] = array('самой хрупкой');
        $about_team[] = array('техники');
        break;
}

$about_team[] = array('быстро');
$about_team[] = array('и');
$about_team[] = array('качественно,');
$about_team[] = array('несмотря');
$about_team[] = array('на');
$about_team[] = array('сложность');
$about_team[] = array('поломки.');
$about_team[] = array('Опытные', 'Квалифицированные');
$about_team[] = array('инженеры');
$about_team[] = array('производят', 'оказывают', 'проводят');
$about_team[] = array('бесплатную');
$about_team[] = array('диагностику', 'проверку', 'тестирование');
$about_team[] = array('в');
$about_team[] = array('короткие', 'минимальные');
$about_team[] = array('сроки.');

$principles = array();
$principles[] = array('В');
$principles[] = array('работе');
$principles[] = array('используется', 'применяется');
$principles[] = array('современное', 'новейшее');
$principles[] = array('оборудование.');
$principles[] = array('Замена деталей');
$principles[] = array('выполняется', 'производится');
$principles[] = array('только', 'исключительно');
$principles[] = array('оригинальными');
$principles[] = array('комплектующими', 'компонентами');
$principles[] = array('от');
$principles[] = array('официальных');
$principles[] = array('представителей.', 'дистрибьюторов.');
$principles[] = array('Можно');
$principles[] = array('вызвать');
$principles[] = array('мастера', 'специалиста', 'инженера');
$principles[] = array('на');
$principles[] = array('дом или офис,');
$principles[] = array('заказать доставку курьером,');
$principles[] = array('получить дополнительную информацию');

srand($feed);

$choose = rand(0, 1);

switch ($choose) {
    case '0' :
        $principles[] = array('заполнив заявку или связаться с нами по телефону указанному на сайте.');
        break;
    case '1' :
        $principles[] = array('связаться с нами по телефону указанному на сайте или заполнив заявку.');
        break;
}
$principles[] = array('На');
$principles[] = array('все виды');
$principles[] = array('услуг');
$principles[] = array('распространяется');
$principles[] = array('гарантия.');

$this->_ret['$banner_list'] = rand_it::randMas($banner_list, count($banner_list), '', $feed);
$this->_ret['banner_txt'] = sc::_createTree($banner_txt, $feed);
$this->_ret['about_team'] = sc::_createTree($about_team, $feed);
$this->_ret['principles'] = sc::_createTree($principles, $feed);