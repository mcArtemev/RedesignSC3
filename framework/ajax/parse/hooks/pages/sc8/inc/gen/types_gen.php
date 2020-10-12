<?php

use framework\ajax\parse\hooks\sc;

$banner_text = array();
$banner_text[] = array('Сервисный центр', 'Сервис центр');
$banner_text[] = array($devices_types[$dev_type_name][2]);
$banner_text[] = array('предлагает', 'оказывает');
$banner_text[] = array('услуги восстановления');
$banner_text[] = array('любого бренда указанного', 'всех брендов указанных');
$banner_text[] = array('на сайте.');
$banner_text[] = array('Мастерские обеспечены всем необходимым современным оборудованием для эффективного устранения');
$banner_text[] = array('дефектов.', 'неполадок.', 'неисправностей.');
$banner_text[] = array('Наши инженеры имеют огромный опыт в данной сфере и легко осуществляют ремонт');
$banner_text[] = array($devices_types[$dev_type_name][2]);

$h2_1 = array();
$h2_1[] = array('Услуги качественного ремонта');

$h2_1_txt = array();
$h2_1_txt[] = array('Мы предоставляем качественные услуги в городе ' . $this->_datas['region']['name']);
$h2_1_txt[] = array('любой сложности в короткие сроки: срочный ремонт, сервисное обслуживание' . ' ' . $this->device_types[$this->_datas['dev_type_name']][2] . '.');
$h2_1_txt[] = array('Ремонтные работы');
$h2_1_txt[] = array('проходят', 'производятся', 'оказываются');
$h2_1_txt[] = array('в несколько этапов:');

$h2_1_list = array();
$h2_1_list[] = array('неисправность', 'неполадки', 'дефекты');

$h2_2 = array();
$h2_2[] = array('Выезд мастера на дом');

$h2_2_txt = array();
$h2_2_txt[] = array('Наши опытные');
$h2_2_txt[] = array('специалисты', 'инженеры');
$h2_2_txt[] = array('производят эффективную починку');
$h2_2_txt[] = array('электроники и бытовой техники', 'бытовой техники и электроники');
$h2_2_txt[] = array('на');
$h2_2_txt[] = array('дому и офисе.', 'офисе и дому.');


$this->_ret['banner_text'] = sc::_createTree($banner_text, $feed);
$this->_ret['h2_1'] = sc::_createTree($h2_1, $feed);
$this->_ret['h2_1_txt'] = sc::_createTree($h2_1_txt, $feed);
$this->_ret['h2_1_list'] = sc::_createTree($h2_1_list, $feed);
$this->_ret['h2_2'] = sc::_createTree($h2_2, $feed);
$this->_ret['h2_2_txt'] = sc::_createTree($h2_2_txt, $feed);
