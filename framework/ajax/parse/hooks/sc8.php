<?php

namespace framework\ajax\parse\hooks;

use framework\tools;
use framework\pdo;
use framework\rand_it;

class sc8 extends sc
{
    private $dbh = null;
    public $device_types_suf = array(
        'n' => ['notebooks', ['ноутбука'], ['Ноутбуки', 'ноутбуков']],
        'f' => ['phones', ['телефона', 'смартфона'], ['Телефоны', 'телефонов']],
        'p' => ['planshets', ['планшета'], ['Планшеты', 'планшетов']]
    );
    public $device_types = array(
        'phone' => array('телефон','телефоны','телефонов'),
        'laptop' => array('ноутбук','ноутбуки','ноутбуков'),
        'tv' => array('телевизор','телевизоры','телевизоров'),
        'fridge' => array('холодильник','холодильники','холодильников'),
        'washing-machine' => array('стиральная машина','стиральные машины','стиральных машин'),
        'tablet' => array('планшет','планшеты','планшетов',),
        'monobloc' => array('моноблок','моноблоки','моноблоков'),
        'computer' => array('компьютер','компьютеры','компьютеров',),
        'game-console' => array('playstation','playstation','playstation'),
    );
    public $brands = array(
        'Asus',
        'LG',
        'Fly',
        'Meizu',
        'Indesit',
        'Huawei',
        'Dell',
        'Acer',
        'Apple',
        'Samsung',
        'Htc',
        'Lenovo',
        'Bosch',
        'HP',
        'Sony',
        'MSI',
    );
    public $brandt = array(
        ['Asus'],
        ['LG'],
        ['Fly'],
        ['Meizu'],
        ['Indesit'],
        ['Huawei'],
        ['Dell'],
        ['Acer'],
        ['Apple'],
        ['Samsung'],
        ['Htc'],
        ['Lenovo'],
        ['Bosch'],
        ['HP'],
        ['Sony'],
        ['MSI'],
    );

    public function generate($answer, $params)
    {
        $this->_site_id = $params['site_id'];

        $f = $this->_datas['f'] = tools::gen_feed($params['site_name']);

        $this->_datas['region'] = $this->_getRegion($params['region_id']);
        $city = $this->_datas['region']['name_pe'];
        $city_m = $this->_datas['region']['name'];
        $city_d = $this->_datas['region']['name_de'];
        $city_r = $this->_datas['region']['name_re'];
        $city_pril = $this->_datas['region']['pril'];

        $this->_datas['partner'] = $this->_getPartner($params['partner_id']);
        
        $this->_datas['zoom'] = 18;
        if ($this->_datas['partner']['exclude']) $this->_datas['zoom'] = 13;

        $this->_datas['menu'] = array(
			'/' => 'Главная',
            '/about/diagnostic/' => 'Диагностика',
            '/about/testimonials/' => 'Отзывы',
            '/about/special/' => 'Акции',
            '/about/master/' => 'Выезд курьера',
            '/about/contacts/' => 'Контакты',
        );

        $this->_datas['menu_footer'] = array(
			'/status/' => 'Статус заказа',
            '/about/urgent-repair/' => 'Срочный ремонт',
            '/about/diagnostic/' => 'Диагностика',
            '/about/master/' => 'Выезд курьера',
            '/about/guarantees/' => 'Гарантии',
			'/about/special/' => 'Акции',
            //'/about/quality-control/' => 'Отдел контроля качества',
        );

        $this->_datas['menu_types'] = array(
            '/phone-service/' => 'Телефоны',
            '/laptop-service/' => 'Ноутбуки',
            '/tv-service/' => 'Телевизоры',
            '/fridge-service/' => 'Холодильники',
            '/washing-machine-service/' => 'Стиральные машины',
            '/tablet-service/' => 'Планшеты',
            '/monobloc-service/' => 'Моноблоки',
            '/computer-service/' => 'Компьютеры',
            '/game-console-service/' => 'Playstation',
        );

        $this->_datas['menu_dop'] = array(
            '/status/' => 'Статус заказа',
            '/about/special/' => 'Акции',
            '/about/contacts/' => 'Контакты',
        );

        // Sales discount items from 3 to 5 generate by Region
        srand(tools::gen_feed($this->_datas['region']['translit1']));
        $sales = rand(3, 5);

        $brandsName = rand_it::randMas($this->brandt, count($this->brandt), '', tools::gen_feed($this->_datas['region']['geo_region']));
        $this->_datas['brands_special'] = rand_it::randMas($brandsName, $sales, '', tools::gen_feed($this->_datas['region']['translit1']));

        $this->_datas['isLocal'] = (isset($_SERVER['HTTP_CLIENT_IP'])
            || isset($_SERVER['HTTP_X_FORWARDED_FOR'])
            || !(in_array(@$_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1']) || PHP_SAPI === 'cli-server')) ? false : true;

        if (isset($params['static'])) {
            $file_name = ($params['static'] == '/') ? 'index' : $params['static'];

            if ($file_name) {
                $this->_datas = $this->_datas + $params;

                $feed = $this->_datas['feed'] = (isset($this->_datas['vals']['feed']) ? $this->_datas['vals']['feed'] : $this->_datas['feed']);
                $servicename = $this->_datas['servicename'];

                list($title, $h1, $description) = array('', '', '');

                switch ($file_name) {
                    case 'index':
                        $title = 'Сервисный центр ' . $servicename . ' в ' . $city;
                        $h1 = 'Cервисный центр в ' . $city;

                        $description = array();
                        $description[] = array('Мультибрендовый');
                        $description[] = array('сервисный центр', 'сервис центр', 'сервис');
                        $description[] = array($servicename);
                        $description[] = array('Осущевстляющий', 'Производящий');
                        $description[] = array('ремонт');
                        $description[] = array('популярных брендов:');

                        srand($feed);
                        $brandsCnt = rand(6, 16);

                        $brands_tmp_arr = rand_it::randMas($this->brandt, $brandsCnt, '', $feed);
                        $brands_tmp = array();

                        $count = count($brands_tmp_arr) - 1;

                        foreach ($brands_tmp_arr as $key => $value) {
                            foreach ($value as $k => $v) {
                                if ($count != $key)
                                    $brands_tmp[$key][$k] = $v . ',';
                                else
                                    $brands_tmp[$key][$k] = $v;
                            }

                            $description[] = $brands_tmp[$key];
                        }

                        // Generating all text
                        $description = sc::_createTree($description, $feed);

                        require_once __DIR__ . '/pages/sc8/inc/gen/index_gen.php';

                        break;
                    case 'testimonials':
                        $title = array();

                        $title[] = array('Отзывы');
                        $title[] = array('клиентов о');
                        $title[] = array('компании', 'сервисном центре', 'сервисе', 'ремонтном центре', 'ремонтном сервисе', 'ремонтном сервисном центре', 'мастерской', 'ремонтной мастеркой', 'сервисной мастерской');
                        $title[] = array($servicename);

                        $h1 = array();

                        $h1[] = array('Отзывы о', 'Отзывы клиентов о');
                        $h1[] = array('компании', 'сервисном центре', 'сервисе', 'сервис центре');
                        $h1[] = array($servicename, '');

                        $description = array();

                        $description[] = array('Реальные отзывы', 'Только реальные отзывы', 'Исключительно реальные отзывы', 'Мнения');
                        $description[] = array('клиентов', 'обращавшихся клиентов');
                        $description[] = array('о');

                        //Description data generations - shuffle
                        $desc_term = array();

                        $desc_term[] = array('качестве');
                        $desc_term[] = array('скорости');
                        $desc_term[] = array('отношении');

                        $desc_term = rand_it::randMas($desc_term, 3, '', $feed);
                        $count = count($desc_term) - 1;

                        foreach ($desc_term as $key => $value) {
                            foreach ($value as $k => $v) {
                                if ($count != $key)
                                    $desc_term[$key][$k] = $v . ',';
                                else
                                    $desc_term[$key][$k] = $v;
                            }

                            $description[] = $desc_term[$key];
                        }

                        $variant_array = array('компании', 'сервисном центре', 'сервисе', 'мастерской', 'сервисной мастерской', 'ремонтном центре', 'ремонтном сервисе', 'ремонтном сервисном центре', 'ремонтной мастеркой');

                        $description[] = $variant_array;

                        srand($feed);

                        $choose = rand(0, 1);

                        switch ($choose) {
                            case 1 :
                                $description[] = array('к работе.');
                                break;
                            case 0 :
                                $remont_sting = array('к восстановлению');
                                $desc_variant = sc::_createTree(array($variant_array), $feed);

                                if (strstr($desc_variant, 'ремонт') === FALSE) array_unshift($remont_sting, 'к ремонту');

                                $description[] = $remont_sting;
                                $description[] = array('устройств.', 'техники.', 'гаджетов.', 'аппаратов.',);
                                break;
                        }

                        $h1 = sc::_createTree($h1, $feed);
                        $title = sc::_createTree($title, $feed);
                        $description = sc::_createTree($description, $feed);

                        break;
                    case 'about' :
                        srand($feed);

                        $title = array();

                        $choose = rand(0, 1);
                        switch ($choose) {
                            case 0 :
                                $title[] = array('О', 'О мультибрендовом');
                                $title[] = array('сервисном центре', 'сервисе', 'ремонтном центре', 'ремонтном сервисе', 'ремонтном сервисном центре');
                                $title[] = array($servicename);
                                $title[] = array('в');
                                $title[] = array($city);
                                break;
                            case 1 :
                                $title[] = array('О мультибрендовой');
                                $title[] = array('мастерской', 'ремонтной мастеркой', 'сервисной мастерской');
                                $title[] = array($servicename);
                                $title[] = array('в');
                                $title[] = array($city);
                                break;
                        }

                        $description = array();
                        $choose = rand(0, 1);
                        switch ($choose) {
                            case 0 :
                                $description[] = array('О мультибрендовой');
                                $description[] = array('мастерской', 'ремонтной мастеркой', 'сервисной мастерской');
                                $description[] = array($servicename);
                                $description[] = array('в');
                                $description[] = array($city);
                                break;
                            case 1 :
                                $description[] = array('О', 'О мультибрендовом');
                                $description[] = array('компании', 'сервисном центре', 'сервисе', 'ремонтном центре', 'ремонтном сервисе', 'ремонтном сервисном центре');
                                $description[] = array($servicename . ':');

                                //Description data generations - shuffle
                                $desc_ab = array();

                                $desc_ab[] = array('путь', 'история');
                                $desc_ab[] = array('достижения');
                                $desc_ab[] = array('акции', 'специальные предложения', 'скидки');
                                $desc_ab[] = array('отзывы', 'мнения клиентов', 'отзывы клиентов');
                                $desc_ab[] = array('вакансии');


                                $desc_ab = rand_it::randMas($desc_ab, 5, '', $feed);
                                $count = count($desc_ab) - 1;

                                foreach ($desc_ab as $key => $value) {
                                    foreach ($value as $k => $v) {
                                        if ($count != $key)
                                            $desc_ab[$key][$k] = $v . ',';
                                        else
                                            $desc_ab[$key][$k] = $v . '.';
                                    }

                                    $description[] = $desc_ab[$key];
                                }
                                break;
                        }

                        $h1 = 'О компании';

                        require_once __DIR__ . '/pages/sc8/inc/gen/about_gen.php';

                        // Generating all text
                        $title = sc::_createTree($title, $feed);
                        $description = sc::_createTree($description, $feed);
                        break;
                    case 'contacts' :
                        $title = array();

                        $title[] = array('Контакты', 'Контактная информация');
                        $title[] = array('компании:', 'сервисного центра:', 'сервиса:', 'компании ' . $servicename . ':', 'сервисного центра ' . $servicename . ':', 'сервиса ' . $servicename . ':');

                        //Title data generations - shuffle
                        $title_sh = array();

                        $title_sh[] = array('территориальное расположение в ' . $city, 'локация в ' . $city, 'адрес в ' . $city);
                        $title_sh[] = array('время работы', 'расписание работы');
                        $title_sh[] = array('телефон для связи', 'телефон');
                        $title_sh[] = array('email');


                        $title_sh = rand_it::randMas($title_sh, 4, '', $feed);
                        $count = count($title_sh) - 1;

                        foreach ($title_sh as $key => $value) {
                            foreach ($value as $k => $v) {
                                if ($count != $key)
                                    $title_sh[$key][$k] = $v . ',';
                                else
                                    $title_sh[$key][$k] = $v;
                            }

                            $title[] = $title_sh[$key];
                        }

                        $description = array();

                        $description[] = array('Контактная информация', 'Контакты');
                        $description[] = array('сервисного центра', 'компании', 'сервиса', 'компании ' . $servicename, 'сервисного центра ' . $servicename, 'сервиса ' . $servicename);
                        $description[] = array('находящегося по адресу:', 'территориально расположеного:');
                        $description[] = array($this->_datas['region']['name'] . ', ' . $this->_datas['partner']['address1'] . '.');


                        //Description data generations - shuffle
                        $description_sh = array();

                        $description_sh[] = array('время работы', 'расписание работы');
                        $description_sh[] = array('елефон для связи', 'телефон');
                        $description_sh[] = array('email');

                        $description_sh = rand_it::randMas($description_sh, 3, '', $feed);
                        $count = count($description_sh) - 1;

                        foreach ($description_sh as $key => $value) {
                            foreach ($value as $k => $v) {
                                if ($key == 0) {
                                    $description_sh[$key][$k] = tools::mb_ucfirst($v, 'UTF-8', false) . ',';
                                    continue;
                                }

                                if ($count != $key)
                                    $description_sh[$key][$k] = $v . ',';
                                else
                                    $description_sh[$key][$k] = $v;
                            }

                            $description[] = $description_sh[$key];
                        }

                        $h1 = array();

                        $h1[] = array('Контакты', 'Контактная информация');

                        // Generating all text
                        $title = sc::_createTree($title, $feed);
                        $description = sc::_createTree($description, $feed);
                        $h1 = sc::_createTree($h1, $feed);
                        break;
                    case 'master' :
                        $title = array();

                        $title[] = array('Выезд');
                        $title[] = array('курьера');
                        $title[] = array('на дом');
                        $title[] = array($servicename);

                        $description = array();

                        $description[] = array('Условия выезда курьера');
                        $description[] = array($servicename);
                        $description[] = array('на дом.');
                        $description[] = array('Онлайн заявка на ремонт.', 'Онлайн заявка на восстановление.', 'Онлайн заявка на починку.');

                        $h1 = array();

                        $h1[] = array('Выезд');
                        $h1[] = array('курьера');

                        require_once __DIR__ . '/pages/sc8/inc/gen/master_gen.php';

                        $title = sc::_createTree($title, $feed);
                        $description = sc::_createTree($description, $feed);
                        $h1 = sc::_createTree($h1, $feed);
                        break;
                    case 'diagnostic' :
                        $title = array();

                        $title[] = array('Диагностика');
                        $title[] = array('в центре ремонта', 'в сервисе', 'в сервисном центре');
                        $title[] = array($servicename);

                        $description = array();

                        $description[] = array('Диагностика техники:');

                        # TODO необходимо добавить вывод типов техники | "перемешиваем выводим 3 -5"

                        $description[] = array('в ' . $servicename);

                        $h1 = array();

                        $h1[] = array('Диагностика', 'Тестирование', 'Аппаратная диагностика', 'Программная диагностика', 'Аппаратное тестирование', 'Программное тестирование');

                        require_once __DIR__ . '/pages/sc8/inc/gen/diagnostic_gen.php';

                        // Generating all text
                        $title = sc::_createTree($title, $feed);
                        $description = sc::_createTree($description, $feed);
                        $h1 = sc::_createTree($h1, $feed);
                        break;
                    case 'urgent-repair' :
                        $title = array();
                        $title[] = array('Срочный ремонт', 'Экспресс ремонт');
                        $title[] = array('в');
                        $title[] = array('сервисном центром', 'сервисе', 'ремонтном центре', 'мастерской');
                        $title[] = array($servicename);


                        $description = array();
                        $description[] = array('Онлайн заявка на срочный ремонт,');
                        $description[] = array('условия, сроки.');

                        $h1 = array();
                        $h1[] = array('Экспресс ремонт', 'Срочный ремонт');

                        require_once __DIR__ . '/pages/sc8/inc/gen/urgent_gen.php';

                        // Generating all text
                        $title = sc::_createTree($title, $feed);
                        $description = sc::_createTree($description, $feed);
                        $h1 = sc::_createTree($h1, $feed);

                        break;
                    case 'guarantees' :
                        $title = array();
                        $title[] = array('Гарантийное обслуживание', 'Обслуживание по гарантии', 'Гарантийные услуги');
                        $title[] = array('в сервисном центре', 'клиентов');
                        $title[] = array($servicename . '.');


                        $description = array();
                        $description[] = array('Условия обслуживания');
                        $description[] = array('аппаратов', 'устройств', 'техники');
                        $description[] = array('по гарантии в ' . $servicename . '.');

                        $h1 = array();
                        $h1[] = array('Обслуживание по гарантии', 'Гарантийные услуги', 'Гарантийное обслуживание');

                        require_once __DIR__ . '/pages/sc8/inc/gen/guarantees_gen.php';

                        // Generating all text
                        $title = sc::_createTree($title, $feed);
                        $description = sc::_createTree($description, $feed);
                        $h1 = sc::_createTree($h1, $feed);
                        break;
                    case 'special' :
                        $title = array();
                        $title[] = array('Специальные предложения','Скидки','Акции');

                        $title_tmp_varArr = array('сервисном центре','сервисе','мастерской','сервисной мастерской','сервис центр','ремонтном центре','ремонтном сервисе','ремонтном сервисном центре','ремонтной мастеркой');
                        $title_tmp_var = sc::_createTree([$title_tmp_varArr], $feed);

                            $title_tmp_str = array('по обслуживанию в');

                            if (strstr($title_tmp_var, 'ремонт') === FALSE) array_unshift($title_tmp_str, 'по ремонту в');

                        $title[] = $title_tmp_str;
                        $title[] = $title_tmp_var;
                        $title[] = array($servicename);

                        $description = array();
                        $description[] = array('Специальные предложения','Скидки','Акции');

                        $desc_tmp_varArr = array('сервисного центра','сервиса','ремонтного центра','ремонтнго сервиса','ремонтнго сервисного центра','мастерской','ремонтной мастеркой','сервисной мастерской');
                        $description[] = $desc_tmp_varArr;

                        $description[] = array($servicename);

                            $desc_tmp_str = array('по обслуживанию','по восстановлению');
                            $desc_tmp_var = sc::_createTree(array($desc_tmp_varArr), $feed);

                            if (strstr($desc_tmp_var, 'ремонт') === FALSE) array_unshift($desc_tmp_str, 'по ремонту');

                        $description[] = $desc_tmp_str;

                        //Description data generations - shuffle
                        $desc_tmp_type = array();

                        $desc_tmp_type[] = array('бытовой техники');
                        $desc_tmp_type[] = array('электроники');
                        $desc_tmp_type[] = array('мобильных устройств');


                        $desc_tmp_type = rand_it::randMas($desc_tmp_type, 3, '', $feed);
                        $count = count($desc_tmp_type) - 1;

                        foreach ($desc_tmp_type as $key => $value) {
                            foreach ($value as $k => $v) {
                                if ($count != $key)
                                    $desc_tmp_type[$key][$k] = $v . ',';
                                else
                                    $desc_tmp_type[$key][$k] = $v . '.';
                            }

                            $description[] = $desc_tmp_type[$key];
                        }

                        $h1 = array();
                        $h1[] = array('Специальные предложения','Скидки','Акции');

                        // Generating all text
                        $title = sc::_createTree($title, $feed);
                        $description = sc::_createTree($description, $feed);
                        $h1 = sc::_createTree($h1, $feed);
                        break;
                    case 'quality-control' :
                        $title = array();
                        $title[] = array('Отдел контроля качества', 'Служба контроля качества');
                        $title[] = array($servicename);

                        $description = array();
                        $description[] = array('Отдел контроля качества');
                        $description[] = array('сервисного центра','сервиса','мастерской','ремонтного центра');
                        $description[] = array($servicename);

                        $h1 = array();
                        $h1[] = array('Отдел контроля качества', '');

                        require_once __DIR__ . '/pages/sc8/inc/gen/quality_gen.php';

                        // Generating all text
                        $title = sc::_createTree($title, $feed);
                        $description = sc::_createTree($description, $feed);
                        $h1 = sc::_createTree($h1, $feed);
                        break;
                    case 'services-list':
                        $title = array();
                        $title[] = array('Перечень');
                        $title[] = array('услуг');
                        $title[] = array('по обслуживанию', 'по ремонту');
                        $title[] = array('техники');
                        $title[] = array('в сервисном центре','в ремонтном центре','в мастерской','в сервис центре','в сервисной мастерской');


                        $description = array();
                        $description[] = array('Все услуги по', 'Перечень всех услуг по');
                        $description[] = array('ремонту', 'восстановлению', 'починке');
                        $description[] = array('устройств', 'техники', 'электроники и бытовой техники');
                        $description[] = array('оказываемых');
                        $description[] = array('в сервисном центре','в ремонтном центре','в мастерской','в сервис центре','в сервисной мастерской');
                        $description[] = array($servicename . '.');


                        $h1 = array();
                        $h1[] = array('Все оказываемые услуги', 'Все услуги');
                        $h1[] = array($servicename, '');

                        // Generating all text
                        $title = sc::_createTree($title, $feed);
                        $description = sc::_createTree($description, $feed);
                        $h1 = sc::_createTree($h1, $feed);
                        break;
                    case 'privacy-policy' :
                        $title = array();
                        $title[] = array('Политика конфиденциальности - ' . $servicename);

                        $description = array();
                        $description[] = array('Политика конфиденциальности сервисного центра ' . $servicename);

                        $title = sc::_createTree($title, $feed);
                        $description = sc::_createTree($description, $feed);
                        break;
                    case 'status' :
                        $title = array();
                        $title[] = array('Проверка статуса ремонта в ' . $servicename);

                        $description = array();
                        $description[] = array('Статус заказа на ремонт в сервисном центре ' . $servicename);

                        $h1 = array();
                        $h1[] = array('Статус ремонта');

                        $h1 = sc::_createTree($h1, $feed);
                        $title = sc::_createTree($title, $feed);
                        $description = sc::_createTree($description, $feed);
                        break;
                    default:
                        if (in_array('/' . $file_name . '/', array_keys($this->_datas['menu_types']))) {
                            $file_name = 'device-type';

                            $devices_types = $this->device_types;
                            $this->_datas['brands'] = $this->brands;

                            $this->_datas['dev_type_name'] = mb_substr($this->_datas['arg_url'], 0, stripos($this->_datas['arg_url'], '-'));
                            if ('washing' === $this->_datas['dev_type_name'])
                                $this->_datas['dev_type_name'] .= '-machine';
                            if ('game' === $this->_datas['dev_type_name'])
                                $this->_datas['dev_type_name'] .= '-console';

                            $dev_type_name = $this->_datas['dev_type_name'];

                            $title = array();
                            $title[] = array('Ремонт');
                            $title[] = array($devices_types[$dev_type_name][2]);
                            $title[] = array('в');
                            $title[] = array($city);

                            $description = array();
                            $description[] = array('Ремонт', 'Восстановление', 'Починка', 'Обслуживание');
                            $description[] = array($devices_types[$dev_type_name][2]);
                            $description[] = array('различных', 'разных');
                            $description[] = array('марок', 'брендов');
                            $description[] = array('и линеек в');

                            srand($feed);
                            $choose = rand(0, 1);

                            switch ($choose) {
                                case 0 :
                                    $description[] = array('мультибрендовой', 'многобрендовой');
                                    $description[] = array('лаборатории');
                                    $description[] = array($city_r . '.');
                                    break;
                                case 1 :
                                    $description[] = array('мультибрендовом', 'многобрендовом',);
                                    $description[] = array(tools::mb_ucfirst($city_pril));
                                    $description[] = array('сервисе.', 'сервисном центре.', 'сервис центре.', 'местерской.', 'сервисной мастерской.');
                                    break;
                            }
                            $description[] = array('Выбор', 'Поиск');

                            srand($feed);
                            $tmpArr[] = array('бренда');
                            $tmpArr[] = array('модели');
                            $tmpArr[] = array('марки');

                            $tmpArr = rand_it::randMas($tmpArr, count($tmpArr), '', $feed);
                            $tmp_arr_storage = array();

                            $count = count($tmpArr) - 1;

                            foreach ($tmpArr as $key => $value) {
                                foreach ($value as $k => $v) {
                                    if ($count != $key)
                                        $tmp_arr_storage[$key][$k] = $v . ',';
                                    else
                                        $tmp_arr_storage[$key][$k] = $v . '.';
                                }

                                $description[] = $tmp_arr_storage[$key];
                            }
                            unset($tmpArr, $tmp_arr_storage);

                            $h1 = array();
                            $h1[] = array('Ремонт');
                            $h1[] = array($devices_types[$dev_type_name][2]);

                            require_once __DIR__ . '/pages/sc8/inc/gen/types_gen.php';

                            $h1 = sc::_createTree($h1, $feed);
                            $title = sc::_createTree($title, $feed);
                            $description = sc::_createTree($description, $feed);
                        } else {
                            $file_name = 'brand';

                            $curBrand = '';

                            foreach ($this->brands as $brand) {
                                if ($this->_datas['arg_url'] === strtolower($brand)) {
                                    $curBrand = $this->_datas['curBrand'] = $brand;
                                    break;
                                }
                            }

                            $title = array();
                            $title[] = array('Ремонт');
                            $title[] = array($curBrand);
                            $title[] = array('в ' . tools::mb_ucfirst($city_pril));
                            $title[] = array('сервисном центре');

                            $description = array();
                            $description[] = array('Ремонт', 'Восстановление', 'Починка', 'Обслуживание');
                            $description[] = array($curBrand);
                            $description[] = array('в');
                            $description[] = array('мультибрендовом', 'многобрендовом');
                            $description[] = array(tools::mb_ucfirst($city_pril) . ' сервисном центре. Выбор');
                            $description[] = array('');

                            srand($feed);
                            $choose = rand(0, 1);

                            switch ($choose) {
                                case 0 :
                                    $description[] = array('типа устройства,', 'типа аппарата,', 'типа девайса,', 'типа техники,', 'вида техники,');
                                    $description[] = array('модели.');
                                    break;
                                case 1 :
                                    $description[] = array('модели,');
                                    $description[] = array('типа устройства.', 'типа аппарата.', 'типа девайса.', 'типа техники.', 'вида техники.');
                                    break;
                            }

                            $h1 = array();
                            $h1[] = array('Сервисный центр по ремонту ' . $curBrand);

                            require_once __DIR__ . '/pages/sc8/inc/gen/brand_gen.php';

                            $title = sc::_createTree($title, $feed);
                            $description = sc::_createTree($description, $feed);
                            $h1 = sc::_createTree($h1, $feed);
                        }
                        break;
                }

                $this->_ret['title'] = $title;
                $this->_ret['description'] = $description;
                $this->_ret['h1'] = $h1;
                
                $this->_sdek();  
                $body = $this->_body($file_name, basename(__FILE__, '.php'));

                return array('body' => $body);
            }

        }
        
        $this->_sqlData($params);
        if (isset($params['marka_id']) && isset($params['model_type_id']))
        {
            if (!isset($params['key']))
            {
                $file_name = 'model';

                $cBrand = $this->_datas['marka']['name'];
                $cModel = $this->_datas['orig_model_type'][0]['name_rm'];
                $feed = $this->_datas['feed'];
                $servicename = $this->_datas['servicename'];

                $title = array();

                srand($feed);
                $choose = rand(0, 1);

                switch ($choose) {
                    case 0 :
                        $title[] = array('Ремонт ' . $cModel . ' ' . $cBrand . ' в ' . $city);

                        $title_tmp = array();
                        $title_tmp[] = array('адрес', 'местонахождение', 'локация', 'расположение');
                        $title_tmp[] = array('цена', 'стоимость', 'прейскурант', 'цены');
                        $title_tmp[] = array('выезд', 'выезд курьера');

                        $title_tmp = rand_it::randMas($title_tmp, count($title_tmp), '', $feed);
                        $count = count($title_tmp) - 1;

                        foreach ($title_tmp as $key => $value) {
                            foreach ($value as $k => $v) {
                                if ($count != $key)
                                    $title_tmp[$key][$k] = $v . ',';
                                else
                                    $title_tmp[$key][$k] = $v;
                            }

                            $title[] = $title_tmp[$key];
                        }

                        break;
                    case 1 :
                        $title[] = array('Ремонт ' . $cModel . ' ' . $cBrand);

                        $title_tmp = array();
                        $title_tmp[] = array('адрес', 'местонахождение', 'локация', 'расположение');
                        $title_tmp[] = array('цена', 'стоимость', 'прейскурант', 'цены');
                        $title_tmp[] = array('выезд', 'выезд курьера');

                        $title_tmp = rand_it::randMas($title_tmp, count($title_tmp), '', $feed);
                        $count = count($title_tmp) - 1;

                        foreach ($title_tmp as $key => $value) {
                            foreach ($value as $k => $v) {
                                if ($count != $key)
                                    $title_tmp[$key][$k] = $v . ',';
                                else
                                    $title_tmp[$key][$k] = $v;
                            }

                            $title[] = $title_tmp[$key];
                        }
                        $title[] = array('в ' . $city, $city_m);

                        break;
                }

                $description = array();
                $description[] = array('Услуги по', 'Перечень услуг по', 'Перечисление услуг по');

                $choose_term = sc::_createTree([array('ремонту', 'восстановлению', 'починке')], $feed);

                $term_pars = array('сервисном центре', 'сервисе', 'сервис центре', 'мастерской', 'сервисной мастерской');

                if ('ремонту' !== $choose_term)
                    $term_pars = array_merge($term_pars, array('ремонтном центре', 'ремонтном сервисе', 'ремонтном сервисном центре', 'ремонтной мастерской'));

                $description[] = array($choose_term);
                $description[] = array($cModel . ' ' . $cBrand . ' в ' . tools::mb_ucfirst($city_pril));
                $description[] = $term_pars;
                $description[] = array($servicename);

                $h1 = array();
                $h1[] = array('Ремонт ' . $cModel . ' ' . $cBrand);

                require_once __DIR__ . '/pages/sc8/inc/gen/model_gen.php';

                $title = sc::_createTree($title, $feed);
                $description = sc::_createTree($description, $feed);
                $h1 = sc::_createTree($h1, $feed);
            }
        }

        $this->_ret['title'] = isset($title) ? $title : '';
        $this->_ret['description'] = isset($description) ? $description : '';
        $this->_ret['h1'] = isset($h1) ? $h1 : '';
        
        $this->_sdek();  
        $body = $this->_body($file_name, basename(__FILE__, '.php'));
           
        return array('body' => $body);
    }

    public function getServices($device_types, $addDevice = true) {
        $services = array();

        foreach ($this->device_types_suf as $suf => $type) {
            $sql = <<<QUERY
    SELECT syns.name, syns.weight, syns.{$suf}_service_id AS service_id, ROUND((costs.time_min + costs.time_max) / 2, 0) AS time, costs.price 
      FROM {$suf}_service_syns AS syns
      LEFT JOIN {$suf}_service_costs AS costs ON syns.{$suf}_service_id = costs.{$suf}_service_id
      WHERE costs.setka_id = 1
QUERY;

            $servicesRaw = $this->dbQuery($sql);

            foreach ($servicesRaw as $service) {
                $deviceName = $addDevice ? ' ' . self::_createTree([$type[1]], tools::gen_feed($service['name'][0] . $service['name'][2])) : '';
                $services[$suf][$service['service_id']]['name'][] = $service['name'] . $deviceName;
                $services[$suf][$service['service_id']]['time'] = round($service['time'] / 5) * 5;
                $services[$suf][$service['service_id']]['price'] = round($service['price'] * 0.9 / 50) * 50;
            }
            unset($sql, $servicesRaw);
        }

        unset($suf, $type);

        return $services;
    }

    public function getBrandsByType($typeName = null)
    {
        $sql = "SELECT m.name FROM model_type_to_markas_8 AS ttm
                  LEFT JOIN markas AS m ON m.id = ttm.marka_id
                  LEFT JOIN model_types AS t ON t.id = ttm.model_type_id
                  WHERE t.name = :name";

        $model_name = $this->device_types[$typeName][0];

        if ('телефон' === $model_name)  $model_name = 'смартфон';
        if ('playstation' === $model_name)  $model_name = 'игровая приставка';

        $model = array_column($this->dbQuery($sql, array(':name' => $model_name)), 'name');
        $brandsName = array_intersect($this->brands, $model);

        return $brandsName;
    }

    public function getTypesByBrand($brandName = null)
    {
        $sql = "SELECT t.name FROM model_type_to_markas_8 AS ttm
                  LEFT JOIN model_types AS t ON t.id = ttm.model_type_id
                  LEFT JOIN markas AS m ON m.id = ttm.marka_id
                  WHERE m.name = :name";

        $types = array_column($this->dbQuery($sql, array(':name' => $brandName)), 'name');

        $types = $this->changeArrayValue($types, array('смартфон', 'телефон'));

        $typesName = array();

        foreach ($this->device_types as $t => $type) {
            if (in_array($type[0], $types))
                $typesName[$t] = $type;
        }

        return $typesName;
    }

    private function changeArrayValue($arr = array(), $values = array())
    {
        $cbFun = function ($v) use ($values) {
            if ($values[0] === $v)
                $v = $values[1];
            return $v;
        };

        $tmpArr = array_map($cbFun, $arr);

        return $tmpArr;
    }

    private function getCon() {
        if (isset($this->dbh))
            return $this->dbh;
        else
            $this->dbh = pdo::getPdo();

        return $this->dbh;
    }

    function dbExec($sql) {
        $dbh = $this->getCon();;
        $res = $dbh->exec($sql);
        return $res;
    }

    function dbQuery($sql, $args = array()) {
        $dbh = $this->getCon();
        $stmt = $dbh->prepare($sql);
        if (!empty($args))
            $stmt->execute($args);
        else
            $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    function __destruct()
    {
        if (isset($this->dbh))
            unset($this->dbh);
    }
    
    private function _sdek()
    {
        $this->_datas['sdek'] = false;
        if ($this->_datas['partner']['email'] == 'litovchenko@list.ru')
        {
            $point = $this->_one_point($this->_datas['region']['name'], $this->_datas['setka_name']);
            if ($point)
            {
                $this->_datas['partner']['x'] = $point[0];
                $this->_datas['partner']['y'] = $point[1];
                $this->_datas['partner']['exclude'] = 1;
                $this->_datas['zoom'] = 9;
            }
        }
        return;
    }
}