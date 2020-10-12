<?php
use framework\ajax\parse\hooks\sc;

$banner_txt = array();

$banner_txt[] = array('Служба', 'Отдел');
$banner_txt[] = array('контроля качества');
$banner_txt[] = array('сервиса', 'мастерской', 'ремонтного центра', 'сервисного центра');
$banner_txt[] = array('принимает заявки ежедневно.');
$banner_txt[] = array('Если вы столкнулись');
$banner_txt[] = array('с некачественным обслуживанием или', 'с некачественным сервисом или');
$banner_txt[] = array('у вас');
$banner_txt[] = array('есть претензии к работе');
$banner_txt[] = array('мастерской', 'ремонтного центра', 'сервисного центра');
$banner_txt[] = array('или');
$banner_txt[] = array('отдельных сотрудников,');
$banner_txt[] = array('сообщите нам!');
$banner_txt[] = array('Специалисты', 'Сотрудники');
$banner_txt[] = array('отдела', 'службы');
$banner_txt[] = array('контроля качества');
$banner_txt[] = array('свяжутся с вами', 'выйдут с вами на связь');
$banner_txt[] = array('в');
$banner_txt[] = array('ближайшее время.');
$banner_txt[] = array('Мы разберем любые вопросы!');

$this->_ret['banner_txt'] = sc::_createTree($banner_txt, $this->_datas['feed']);