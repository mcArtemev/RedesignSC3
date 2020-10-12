<?php

use framework\ajax\parse\hooks\sc;
use framework\rand_it;

// Information about company first sentence
$about_c_first = array();

$about_c_first[] = array('Организация', 'Компания');
$about_c_first[] = array('начала');
$about_c_first[] = array('свою', '');
$about_c_first[] = array('активную');
$about_c_first[] = array('деятельность');
$about_c_first[] = array('несколько', 'пару');
$about_c_first[] = array('лет');
$about_c_first[] = array('назад');
$about_c_first[] = array('и');
$about_c_first[] = array('уже');
$about_c_first[] = array('сумела', 'смогла');
$about_c_first[] = array('завоевать', 'заслужить');
$about_c_first[] = array('признание');
$about_c_first[] = array('со');
$about_c_first[] = array('стороны');
$about_c_first[] = array('обратившихся', 'своих');
$about_c_first[] = array('клиентов.');

// Information about company second sentence
$about_c_second = array();

$about_c_second[] = array($servicename);
$about_c_second[] = array('работает');
$about_c_second[] = array('365');
$about_c_second[] = array('дней');
$about_c_second[] = array('в');
$about_c_second[] = array('году,');
$about_c_second[] = array('ежедневно');
$about_c_second[] = array('удовлетворяя');
$about_c_second[] = array('потребности', 'нужды');
$about_c_second[] = array('обращающихся', 'своих');
$about_c_second[] = array('клиентов.');

// Information about company third sentence
$about_c_third = array();

$about_c_third[] = array('Независимо');
$about_c_third[] = array('от');
$about_c_third[] = array('сложности', 'трудоемкости');
$about_c_third[] = array('ремонта', 'осуществления ремонта', 'проведения ремонта');
$about_c_third[] = array('качество');
$about_c_third[] = array('работы', 'нашей работы');
$about_c_third[] = array('высокое');
$about_c_third[] = array('и');
$about_c_third[] = array('на');
$about_c_third[] = array('нее');
$about_c_third[] = array('прилагается', 'распостраняется', 'дается');
$about_c_third[] = array('гарантия.');

$h2 = array();
$h2[] = array('Наши преимущества', 'Наши достоинства', 'Наши особенности');

// Information about team first sentence
$team_first = array();

$team_first[] = array('В');
$team_first[] = array('нашей');
$team_first[] = array('компании', 'организации');
$team_first[] = array('работают');
$team_first[] = array('только', 'исключительно');
$team_first[] = array('квалифицированные', 'опытные', 'грамотные');
$team_first[] = array('специалисты,');
$team_first[] = array('разбирающиеся');
$team_first[] = array('в');
$team_first[] = array('устройстве', 'тонкостях', 'особенностях');
$team_first[] = array('любой', 'всей');

# TODO необходимо добавить вывод типов техники | "Выводим все через запятую, перемешиваем точка в конце"
$team_first[] = array('техники:');
$temp_tupes = array(['смартфонов'], ['ноутбуков'], ['телевизоров'], ['холодильников'], ['стиральных машин'], ['планшетов'], ['моноблоков'], ['компьютеров'], ['playstation']);
$team_first_types = rand_it::randMas($temp_tupes, count($temp_tupes), '', $feed);
$count = count($team_first_types) - 1;

foreach ($team_first_types as $key => $value) {
    foreach ($value as $k => $v) {
        if ($count != $key)
            $team_first_types[$key][$k] = $v . ',';
        else
            $team_first_types[$key][$k] = $v . '.';
    }

    $team_first[] = $team_first_types[$key];
}

//Description data generations - shuffle
$team_first_tech = array();

$team_first_tech = rand_it::randMas($team_first_tech, 5, '', $feed); // Заменить  третьий аргумент на количество генерируемых сущьностей
$count = count($team_first_tech) - 1;

foreach ($team_first_tech as $key => $value) {
    foreach ($value as $k => $v) {
        if ($count != $key)
            $team_first_tech[$key][$k] = $v . ',';
        else
            $team_first_tech[$key][$k] = $v . '.';
    }

    $team_first[] = $team_first_tech[$key];
}

// Information about team second sentence
$team_second = array();

$team_second[] = array('Ресурс', 'Наш реусрс');
$team_second[] = array('сервиса');
$team_second[] = array('предоставляет', 'оказывает');
$team_second[] = array('возможности');
$team_second[] = array('информирования', 'осведомления');
$team_second[] = array('клиентов,');
$team_second[] = array('а');
$team_second[] = array('также');
$team_second[] = array('их');
$team_second[] = array('непосредственную', 'личную', 'прямую');
$team_second[] = array('связь');
$team_second[] = array('с');
$team_second[] = array('руководством', 'руководителями', 'начальством');
$team_second[] = array('компании.', 'организации.', 'фирмы.');

// Information about team third sentence
$team_third = array();

$team_third[] = array('Организация');
$team_third[] = array('сохраняет');
$team_third[] = array('политику');
$team_third[] = array('конфиденциальности');
$team_third[] = array('ваших', 'всех ваших', 'оставленных вами');
$team_third[] = array('личных');
$team_third[] = array('данных,');
$team_third[] = array('отправленных');
$team_third[] = array('через');
$team_third[] = array('регистрационноую');
$team_third[] = array('форму.');

// Information about team fourth sentence
$team_fourth = array();

$team_fourth[] = array('Ознакомиться');
$team_fourth[] = array('с');
$team_fourth[] = array('отзывами', 'оставленными отзывами');
$team_fourth[] = array('о');
$team_fourth[] = array($servicename);
$team_fourth[] = array('можно', 'возможно');
$team_fourth[] = array('на');
$team_fourth[] = array('соотвествующей');
$team_fourth[] = array('странице');
$team_fourth[] = array('сайта,');
$team_fourth[] = array('где');
$team_fourth[] = array('многие');
$team_fourth[] = array('клиенты', 'заказчики');
$team_fourth[] = array('оставили', 'написали');
$team_fourth[] = array('свое');
$team_fourth[] = array('мнение', 'заключение');
$team_fourth[] = array('о');
$team_fourth[] = array('работе');
$team_fourth[] = array('организации,', 'компании,', 'фирме,');
$team_fourth[] = array('ее');
$team_fourth[] = array('сотрудниках', 'работниках', 'мастерах', 'специалистах', 'мастерах-ремонтниках');
$team_fourth[] = array('.');

$this->_ret['about_c_first'] = sc::_createTree($about_c_first, $feed);
$this->_ret['about_c_second'] = sc::_createTree($about_c_second, $feed);
$this->_ret['about_c_third'] = sc::_createTree($about_c_third, $feed);
$this->_ret['h2'] = sc::_createTree($h2, $feed);
$this->_ret['team_first'] = sc::_createTree($team_first, $feed);
$this->_ret['team_second'] = sc::_createTree($team_second, $feed);
$this->_ret['team_third'] = sc::_createTree($team_third, $feed);
$this->_ret['team_fourth'] = sc::_createTree($team_fourth, $feed);