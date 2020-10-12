<?

namespace framework\ajax\parse\hooks;

use framework\tools;
use framework\rand_it;
use framework\pdo;

class sc2 extends sc
{
    public function generate($answer, $params)
    {

         $sql =  "SELECT `model_types`.`name` as `type`, `model_types`.`id` as `type_id`,
                `model_types`.`name_re` as `type_re`, `model_types`.`name_rm` as `type_rm`,
                 `model_types`.`name_m` as `type_m` FROM `m_model_to_sites`
            INNER JOIN `m_models` ON `m_models`.`id` = `m_model_to_sites`.`m_model_id`
            INNER JOIN `model_types` ON `m_models`.`model_type_id` = `model_types`.`id` WHERE `m_model_to_sites`.`site_id`= ? GROUP BY `model_types`.`name`";
        $stm = pdo::getPdo()->prepare($sql);
        $stm->execute(array($params['site_id']));
        $this->_datas['all_devices'] = $stm->fetchAll(\PDO::FETCH_ASSOC);

        // region
        $this->_datas['region'] = $this->_getRegion($params['region_id']);
        $city = $this->_datas['region']['name_pe'];
        $city_d = $this->_datas['region']['name_de'];
        $city_r = $this->_datas['region']['name_re'];

        if ($this->_datas['region']['translit2']) $this->_datas['region']['translit1'] = $this->_datas['region']['translit2'];

        // partner
        $this->_datas['partner'] = $this->_getPartner($params['partner_id']);
        
        $this->_datas['zoom'] = 13;

        if (isset($params['static']))
        {
            $file_name = ($params['static'] == '/') ? 'index' : $params['static'];

            if ($file_name)
            {
                $this->_datas = $this->_datas + $params;

                $feed = $this->_datas['feed'] = (isset($this->_datas['vals']['feed']) ? $this->_datas['vals']['feed'] : $this->_datas['feed']);

                $sql = "SELECT * FROM `markas` WHERE `id`= ?";
                $stm = pdo::getPdo()->prepare($sql);
                $stm->execute(array($params['marka_id']));
                $this->_datas['marka'] = current($stm->fetchAll(\PDO::FETCH_ASSOC));

                $marka = $this->_datas['marka']['name'];
                if ($this->_datas['marka']['name'] == "LG") $this->_datas['marka']['ru_name'] = "LG";
                $marka_lower = mb_strtolower($this->_datas['marka']['name']);

                // menu
                if (!in_array($marka_lower, array('canon', 'dell', 'nikon', 'toshiba')) && $this->_datas['region']['name'] == 'Москва')
                {
                    $this->_datas['menu'] = array(
                        '/' => 'Главная',
                        '/order/' => 'Запись на ремонт',
                        '/status/' => 'Статус заказа',
                        '/diagnostics/' => 'Диагностика',
                        '/services/' => 'Экспресс ремонт',
                        '/delivery/' => 'Выезд курьера',
                        '/price/' => 'Цены',
                        '/contacts/' => 'Контакты',
                    );
                }
                else
                {
                    $this->_datas['menu'] = array(
                        '/' => 'Главная',
                        '/order/' => 'Запись на ремонт',
                        '/diagnostics/' => 'Диагностика',
                        '/services/' => 'Экспресс ремонт',
                        '/delivery/' => 'Выезд курьера',
                        '/price/' => 'Цены',
                        '/contacts/' => 'Контакты',
                    );
                }

                $this->_make_accord_table($marka_lower);         

                switch ($file_name)
            	{
            		case 'index': //+

                        $t = array();
                        foreach ($this->_datas['all_devices'] as $device)
                            $t[] = $device['type_rm'];

            			$title = 'Сервисный центр '.$marka.' в '.$city.': ремонт в '.$this->_datas['servicename'];
            			$description = 'Обслуживание и ремонт устройств '.$this->_datas['marka']['name'].'. Условия предоставления услуг. Ремонт '.tools::implode_or($t).'.';

                        //if ($this->_datas['setka_name'] == 'СЦ-2' && (($marka_lower == 'samsung') || ($marka_lower == 'nikon') || ($marka_lower == 'sony')))
                        if (($marka_lower == 'samsung') || ($marka_lower == 'nikon') || ($marka_lower == 'sony'))
                             $h1 = 'Centre - сервисный центр '.$this->_datas['marka']['ru_name'];
                        else
            			     $h1 = $this->_datas['servicename'].' - сервисный центр '.$this->_datas['marka']['ru_name'];
            		break;

            		case 'order':
          				$title = 'Запись на ремонт техники в сервисе '.$this->_datas['servicename'].' в '.$city;
            			$description = 'Запишитесь на ремонт, и мы с вами свяжемся! Оперативность, качество и отличные цены в сервисе '.$this->_datas['ru_servicename'].' в '.$city.'.';
            			$h1 = 'Запись на ремонт';
            		break;

            		case 'diagnostics'://+
                        $title = 'Диагностика проблем с техникой '.$this->_datas['marka']['name'].' — '.$this->_datas['ru_servicename'].' '.$this->_datas['region']['name'].' определим и исправим любую неполадку';
            			$description = 'Диагностирование всех видов неисправностей техники '.$this->_datas['marka']['ru_name'].': от технических неполадок до программных ошибок. Звоните в сервис '.$this->_datas['servicename'].' в '.$city.'!';
            			$h1 = 'Диагностика';
                    break;

                    case 'services'://+

                        $str = array();
                        for ($i = 0; $i < count($this->_datas['all_devices']); $i++)
                        {
                            if (!isset($this->_datas['all_devices'][$i])) break;
                            $str[] = $this->_datas['all_devices'][$i]['type_rm'];
                        }

                        if ($i > 1)
                            $str = implode(', ', $str).' и другой техники';
                        else
                            $str = $str[0];

                        $title = 'Срочный ремонт '.$str.' '.$this->_datas['marka']['name'].' в '.$city.' от сервиса '.$this->_datas['servicename'];
            			$description = 'Нужен экстренный ремонт? Буквально за час наши специалисты готовы исправить большинство неисправностей вашей техники '.$this->_datas['marka']['ru_name'].'.';
            			$h1 = 'Экспресс ремонт';
                    break;

                    case 'delivery'://+
                        $title = 'Заказ выезда курьера в сервисе '.$this->_datas['servicename'].' по '.$city_d;
            			$description = 'Не хотите ехать к нам - не беда! Наш курьер приедет к вам, заберёт вашу сломавшуюся технику '.$this->_datas['marka']['ru_name'].' и вернёт уже отремонтированную!';
            			$h1 = 'Выезд курьера';
                    break;

                    case 'price': //+
                        $title = 'Цены на обслуживание в '.$this->_datas['servicename'].' '.$this->_datas['region']['translit1'];
                        $description = 'Прайс-лист на услуги по сервисному ремонту и обслуживанию техники '.$this->_datas['marka']['name'].'. Подробный прейскурант на работы для каждого из типов устройств.';
                        $h1 = 'Цены';
                    break;

                    case 'contacts':
                        $title = 'Контакты '.$this->_datas['servicename'].' в '.$city.': адреса, телефоны компании';
                        $description = 'Адрес, телефон и схема проезда авторизованного сервисного центра '.$this->_datas['servicename'].'.';
                        $h1 = 'Контакты';
                    break;

                    case 'ask':
                        $title = 'Задать вопрос '.$this->_datas['servicename'].' '.$this->_datas['region']['translit1'];
                        $description = 'Не знаете, что случилось с вашим '.$this->_datas['marka']['name'].'? Задайте вопрос эксперту.';
                        $h1 = 'Задать вопрос';
                    break;

                    case 'status':
                        $title = 'Узнать статус заказа в сервисном центре '.$this->_datas['marka']['name'];
                        $description = 'Узнать статус заказа по номеру квитанции в '.$this->_datas['servicename'].'.';
                        $h1 = 'Статус заказа';
                    break;

                    case 'thank-you':
                        $title = 'Спасибо — Сервисный центр '.$this->_datas['marka']['name'];
                        $description = '';
                        $h1 = 'Ваша заявка отправлена!';
                    break;

                    case 'politica':
                        $title = 'Политика обработки персональных данных';
                        $description = 'Политика обработки персональных данных';
                        $h1 = 'Политика обработки персональных данных';
                    break;

                    case 'requisites':
                        $title = 'Наши реквизиты';
                        $description = 'Наши реквизиты';
                        $h1 = 'Наши реквизиты';
                    break;

                    default:
                        $gadget = $this->_datas['add_device_type'][$this->_datas['arg_url']];
                        $title = 'Ремонт '.$gadget['type_rm'].' '.$this->_datas['marka']['name'].' в '.$city.' от '.$this->_datas['servicename'];
                        $description = 'Обслуживание и ремонт '.$gadget['type_rm'].' '.$this->_datas['marka']['ru_name'].'. Прайс на услуги. Регламент ремонта. Полный список услуг и цен сервиса.';
                        $h1 = 'Ремонт '.$gadget['type_rm'].' '.$this->_datas['marka']['name'];
                        $file_name = 'gadget';
               }

                // addresis
                $this->_datas['addresis'] = $this->_getAddresis($params['setka_id'], $this->_datas['marka']['id']);

                $this->_ret['title'] = $title;
                $this->_ret['h1'] = $h1;
                $this->_ret['description'] = $description;

                $this->_sdek();
                $body = $this->_body($file_name, basename(__FILE__, '.php'));
                            
                //return array('title' => $title, 'description' => $description, 'body' => $body);
                return array('body' => $body);
            }
        }

        $level = false;

        $ret = array();

        $file_name = '';

        $this->_sqlData($params);
        $this->_make_accord_table(mb_strtolower($this->_datas['marka']['name']));
        if ($this->_datas['marka']['name'] == "LG") $this->_datas['marka']['ru_name'] = "LG";

        // menu
        $marka_lower = mb_strtolower($this->_datas['marka']['name']);
        if (!in_array($marka_lower, array('canon', 'dell', 'nikon', 'toshiba')) && $this->_datas['region']['name'] == 'Москва')
        {
            $this->_datas['menu'] = array(
                '/' => 'Главная',
                '/order/' => 'Запись на ремонт',
                '/status/' => 'Статус заказа',
                '/diagnostics/' => 'Диагностика',
                '/services/' => 'Экспресс ремонт',
                '/delivery/' => 'Выезд курьера',
                '/price/' => 'Цены',
                '/contacts/' => 'Контакты',
            );
        }
        else
        {
            $this->_datas['menu'] = array(
                '/' => 'Главная',
                '/order/' => 'Запись на ремонт',
                '/diagnostics/' => 'Диагностика',
                '/services/' => 'Экспресс ремонт',
                '/delivery/' => 'Выезд курьера',
                '/price/' => 'Цены',
                '/contacts/' => 'Контакты',
            );
        }

        // addresis
        $this->_datas['addresis'] = $this->_getAddresis($params['setka_id'], $this->_datas['marka']['id']);

        if (isset($params['m_model_id']) || (isset($params['marka_id']) && isset($params['model_type_id'])))
        {
            if (isset($params['marka_id']) && isset($params['model_type_id']))
            {
                $ret['title'] = array(
                    'Ремонт',
                    $this->_datas['model_type'][0]['name_rm'],
                    $this->_datas['marka']['name'],
                    'в',
                    $city,
                    'от',
                    $this->_datas['servicename']
                );

                $ret['h1'] = array(
                    'Ремонт',
                    $this->_datas['model_type'][1]['name_rm'],
                    $this->_datas['marka']['name']
                );

                $ret['description'] = array(
                    'Обслуживание и ремонт',
                    $this->_datas['model_type'][2]['name_rm'],
                    $this->_datas['marka']['ru_name'].'.',
                    $this->_datas['dop']
                );

                $file_name = 'model';
            }
            else
            {
                if (!isset($params['key']))
                {
                    /*$ret['title'] = array(
                        'Ремонт',
                        $this->_datas['model_type'][0]['name_rm'],
                        $this->_datas['marka']['name'],
                        $this->_datas['m_model']['name'],
                        'в',
                        $this->_datas['ru_servicename'].':'
                    );

                    if (isset($this->_datas['time']))
                    {
                        $ret['title'][] = 'от';
                        $ret['title'][] = $this->_datas['time'];
                        $ret['title'][] = 'мин,';
                    }

                    $ret['title'][] = tools::format_phone($this->_datas['phone']);*/

                    $ret['title'] = array(
                        'Ремонт',
                        $this->_datas['model_type'][0]['name_rm'],
                        $this->_datas['marka']['name'],
                        $this->_datas['m_model']['name'],
                        'в',
                        $city,
                        'от',
                        $this->_datas['servicename']
                    );

                    $ret['h1'] = array(
                        'Ремонт',
                        $this->_datas['model_type'][1]['name_rm'],
                        '<span>'.$this->_datas['marka']['name'],
                        $this->_datas['m_model']['name'].'</span>'
                    );

                    $ret['description'] = array(
                        'Обслуживание и ремонт',
                        $this->_datas['model_type'][2]['name_rm'],
                        $this->_datas['marka']['ru_name'],
                        $this->_datas['m_model']['ru_name'].'.',
                        $this->_datas['dop']
                    );

                    $file_name = 'model';
                }
                else
                {
                    switch ($params['key'])
                    {
                        case 'service':

                            /*$ret['title'] = array(
                                tools::mb_firstupper($this->_datas['syns'][0]),
                                $this->_datas['marka']['name'],
                                $this->_datas['m_model']['name'],
                                'в',
                                $this->_datas['ru_servicename'].':'
                            );

                            if (isset($this->_datas['time']))
                            {
                                $ret['title'][] = 'от';
                                $ret['title'][] = $this->_datas['time'];
                                $ret['title'][] = 'мин,';
                            }

                            $ret['title'][] = tools::format_phone($this->_datas['phone']);*/

                            $ret['title'] = array(
                                tools::mb_firstupper($this->_datas['syns'][0]),
                                $this->_datas['marka']['name'],
                                $this->_datas['m_model']['name'],
                                'в',
                                $city,
                                'от',
                                $this->_datas['servicename'].':'
                            );

                            if (isset($this->_datas['time']))
                            {
                                $ret['title'][] = 'от';
                                $ret['title'][] = $this->_datas['time'];
                                $ret['title'][] = 'мин';
                            }

                            $ret['h1'] = array(
                                tools::mb_firstupper($this->_datas['syns'][1]),
                                '<span>'.$this->_datas['marka']['name'],
                                $this->_datas['m_model']['name'].'</span>'
                            );

                            $ret['description'] = array(
                                $this->_datas['marka']['name'],
                                $this->_datas['m_model']['name'],
                                '-',
                                tools::mb_firstlower($this->_datas['syns'][2]).'.',
                                $this->_datas['dop']
                            );

                        $file_name = 'model-service';

                        break;
                        case 'defect':

                            /*$ret['title'] = array(
                                tools::mb_firstupper($this->_datas['syns'][0]),
                                $this->_datas['marka']['name'],
                                $this->_datas['m_model']['name'],
                                '-',
                                'устранение неисправности',
                                'в',
                                $this->_datas['ru_servicename']
                            );

                            if (isset($this->_datas['time']))
                            {
                                $ret['title'][] = 'от';
                                $ret['title'][] = $this->_datas['time'];
                                $ret['title'][] = tools::declOfNum($this->_datas['time'], array('минуты','минут','минут'), false).':';
                            }

                            $ret['title'][] = tools::format_phone($this->_datas['phone']);*/

                            $ret['title'] = array(
                                tools::mb_firstupper($this->_datas['syns'][0]),
                                $this->_datas['marka']['name'],
                                $this->_datas['m_model']['name'],
                                '-',
                                'устранение неисправности',
                                'в',
                                $this->_datas['servicename'],
                                $this->_datas['region']['translit1'].':'
                            );

                            if (isset($this->_datas['time']))
                            {
                                $ret['title'][] = 'от';
                                $ret['title'][] = $this->_datas['time'];
                                $ret['title'][] = tools::declOfNum($this->_datas['time'], array('минуты','минут','минут'), false);
                            }

                            $ret['h1'] = array(
                                tools::mb_firstupper($this->_datas['syns'][1]),
                                '<span>'.$this->_datas['marka']['name'],
                                $this->_datas['m_model']['name'].'</span>'
                            );

                            $ret['description'] = array(
                                $this->_datas['marka']['name'],
                                $this->_datas['m_model']['name'],
                                tools::mb_firstlower($this->_datas['syns'][2]).'.',
                                $this->_datas['dop']
                            );

                        $file_name = 'model-defect';

                        break;
                        case 'complect':

                            /*$ret['title'] = array(
                                tools::mb_firstupper($this->_datas['syns'][0]),
                                $this->_datas['marka']['name'],
                                $this->_datas['m_model']['name'],
                                'в наличии',
                                'в',
                                $this->_datas['ru_servicename'],
                                '-',
                                $this->_datas['amount'],
                                tools::declOfNum($this->_datas['amount'], array('единица','единицы','единиц'), false).':',
                                tools::format_phone($this->_datas['phone'])
                            );*/

                            $ret['title'] = array(
                                tools::mb_firstupper($this->_datas['syns'][0]),
                                $this->_datas['marka']['name'],
                                $this->_datas['m_model']['name'],
                                'в',
                                $city,
                                'от',
                                $this->_datas['servicename'].':',
                                $this->_datas['amount'],
                                tools::declOfNum($this->_datas['amount'], array('единица','единицы','единиц'), false),
                                'в наличии'
                            );

                            $ret['h1'] = array(
                                tools::mb_firstupper($this->_datas['syns'][1]),
                                $this->_datas['model_type'][1]['name_re'],
                                '<span>'.$this->_datas['marka']['name'],
                                $this->_datas['m_model']['name'].'</span>'
                            );

                            $ret['description'] = array(
                                $this->_datas['marka']['name'],
                                $this->_datas['m_model']['name'],
                                '-',
                                tools::mb_firstlower($this->_datas['syns'][2]),
                                $this->_datas['model_type'][2]['name_re'].'.',
                                $this->_datas['dop']
                            );

                        $file_name = 'model-complect';

                        break;
                    }
                }
            }
        }

        if (isset($params['model_id']))
        {
            if (!isset($params['key']))
            {
                 /*$ret['title'] = array(
                    'Ремонт',
                    $this->_datas['model_type'][0]['name_rm'],
                    $this->_datas['model']['name'],
                    'в',
                    $this->_datas['ru_servicename'].':'
                 );

                 if (isset($this->_datas['time']))
                 {
                     $ret['title'][] = 'от';
                     $ret['title'][] = $this->_datas['time'];
                     $ret['title'][] = 'мин,';
                 }

                 $ret['title'][] = 'тел';
                 $ret['title'][] = tools::format_phone($this->_datas['phone']);*/

                 $ret['title'] = array(
                    'Ремонт',
                    $this->_datas['model_type'][0]['name_rm'],
                    $this->_datas['model']['name'],
                    'в',
                    $city,
                    'от',
                    $this->_datas['servicename']
                 );

                 $ret['h1'] = array(
                    'Ремонт',
                    '<span>'.$this->_datas['model']['name'].'</span>'
                 );

                 /*if (mb_strtolower($this->_datas['model']['lineyka']) == mb_strtolower($this->_datas['model']['sublineyka']))
                 {
                    $ret['h1'][] = $this->_datas['model']['submodel'].'</span>';
                 }
                 else
                 {
                    $ret['h1'][] = $this->_datas['m_model']['ru_name'];
                    $ret['h1'][] = $this->_datas['model']['submodel'].'</span>';
                 }*/

                 $ret['description'] = array(
                    $this->_datas['model']['name'],
                    '-',
                    'услуги по ремонту.',
                    $this->_datas['dop']
                 );

                 $file_name = 'model';
            }
            else
            {
                switch ($params['key'])
                {
                    case 'service':

                        /*$ret['title'] = array(
                            tools::mb_firstupper($this->_datas['syns'][0]),
                            $this->_datas['model_type'][0]['name_re'],
                            $this->_datas['model']['name'],
                            'в',
                            $this->_datas['ru_servicename'].':'
                        );

                        if (isset($this->_datas['time']))
                        {
                            $ret['title'][] = 'от';
                            $ret['title'][] = $this->_datas['time'];
                            $ret['title'][] = 'мин,';
                        }

                        $ret['title'][] = 'тел';
                        $ret['title'][] = tools::format_phone($this->_datas['phone']);*/

                        $ret['title'] = array(
                            tools::mb_firstupper($this->_datas['syns'][0]),
                            $this->_datas['model_type'][0]['name_re'],
                            $this->_datas['model']['name'],
                            'в',
                            $city,
                            'от',
                            $this->_datas['servicename'].':'
                        );

                        if (isset($this->_datas['time']))
                        {
                            $ret['title'][] = 'от';
                            $ret['title'][] = $this->_datas['time'];
                            $ret['title'][] = 'мин';
                        }

                        $ret['h1'] = array(
                            tools::mb_firstupper($this->_datas['syns'][1]),
                            '<span>'.$this->_datas['model']['name'].'</span>'
                        );

                        /*if (mb_strtolower($this->_datas['model']['lineyka']) == mb_strtolower($this->_datas['model']['sublineyka']))
                        {
                            $ret['h1'][] = $this->_datas['model']['submodel'].'</span>';
                        }
                        else
                        {
                            $ret['h1'][] = $this->_datas['m_model']['ru_name'];
                            $ret['h1'][] = $this->_datas['model']['submodel'].'</span>';
                        }*/

                        $ret['description'] = array(
                            $this->_datas['model']['name'],
                            '-',
                            tools::mb_firstlower($this->_datas['syns'][2]).'.',
                            $this->_datas['dop']
                        );

                    $file_name = 'model-service';

                    break;

                    case 'defect':

                        /*$ret['title'] = array(
                            tools::mb_firstupper($this->_datas['syns'][0]),
                            $this->_datas['model']['name'],
                            '-',
                            'устранение неисправности',
                            'в',
                            $this->_datas['ru_servicename']
                        );

                        if (isset($this->_datas['time']))
                        {
                            $ret['title'][] = 'от';
                            $ret['title'][] = $this->_datas['time'];
                            $ret['title'][] = tools::declOfNum($this->_datas['time'], array('минуты','минут','минут'), false).':';
                        }

                       $ret['title'][]  = 'тел';
                       $ret['title'][] = tools::format_phone($this->_datas['phone']);*/

                       $ret['title'] = array(
                            tools::mb_firstupper($this->_datas['syns'][0]),
                            $this->_datas['model']['name'],
                            '-',
                            'устранение неисправности',
                            'в',
                            $this->_datas['servicename'],
                            $this->_datas['region']['translit1'].':'
                        );

                        if (isset($this->_datas['time']))
                        {
                            $ret['title'][] = 'от';
                            $ret['title'][] = $this->_datas['time'];
                            $ret['title'][] = tools::declOfNum($this->_datas['time'], array('минуты','минут','минут'), false);
                        }

                       $ret['h1'] = array(
                            tools::mb_firstupper($this->_datas['syns'][1]),
                            '<span>'.$this->_datas['model']['name'].'</span>'
                        );

                        /*if (mb_strtolower($this->_datas['model']['lineyka']) == mb_strtolower($this->_datas['model']['sublineyka']))
                        {
                            $ret['h1'][] = $this->_datas['model']['submodel'].'</span>';
                        }
                        else
                        {
                            $ret['h1'][] = $this->_datas['m_model']['ru_name'];
                            $ret['h1'][] = $this->_datas['model']['submodel'].'</span>';
                        }*/

                        $ret['description'] = array(
                            $this->_datas['model']['name'],
                            tools::mb_firstlower($this->_datas['syns'][2]).'.',
                            $this->_datas['dop']
                        );

                    $file_name = 'model-defect';

                    break;

                    case 'complect':

                        /*$ret['title'] = array(
                            tools::mb_firstupper($this->_datas['syns'][0]),
                            'для',
                            $this->_datas['model_type'][0]['name_re'],
                            $this->_datas['model']['name'],
                            'в наличии',
                            'в',
                            $this->_datas['servicename'],
                            '-',
                            $this->_datas['amount'],
                            tools::declOfNum($this->_datas['amount'], array('единица','единицы','единиц'), false).':',
                            tools::format_phone($this->_datas['phone'])
                        );*/

                        $ret['title'] = array(
                            tools::mb_firstupper($this->_datas['syns'][0]),
                            $this->_datas['model_type'][0]['name_re'],
                            $this->_datas['model']['name'],
                            'в',
                            $city,
                            'от',
                            $this->_datas['servicename'].':',
                            $this->_datas['amount'],
                            tools::declOfNum($this->_datas['amount'], array('единица','единицы','единиц'), false),
                            'в наличии'
                        );

                        $ret['h1'] = array(
                            tools::mb_firstupper($this->_datas['syns'][1]),
                            '<span>'.$this->_datas['model']['name'].'</span>'
                        );

                        /*if (mb_strtolower($this->_datas['model']['lineyka']) == mb_strtolower($this->_datas['model']['sublineyka']))
                        {
                            $ret['h1'][] = $this->_datas['model']['submodel'].'</span>';
                        }
                        else
                        {
                            $ret['h1'][] = $this->_datas['m_model']['ru_name'];
                            $ret['h1'][] = $this->_datas['model']['submodel'].'</span>';
                        }*/

                        $ret['description'] = array(
                            $this->_datas['model']['name'],
                            '-',
                            tools::mb_firstlower($this->_datas['syns'][2]),
                            $this->_datas['model_type'][2]['name_re'].'.',
                            $this->_datas['dop']
                        );

                    $file_name = 'model-complect';

                    break;
                }
            }
        }

        $vars = array();
        $text = array();
        $feed = (isset($this->_datas['vals']['feed']) ? $this->_datas['vals']['feed'] : $this->_datas['feed']);

        $vars[] = array('<ul class="list">');

        $text[] = array('<li><span>Запись на ремонт со скидкой 10%</span></li>', '<li><span>Онлайн запись на ремонт со скидкой</span></li>', '<li><span>Скидка 10% на обслуживание</span></li>', '<li><span>Скидка 10% при заказе онлайн</span></li>',
            '<li><span>Скидка на услуги при записи онлайн</span></li>', '<li><span>Экономия 10% при заказе с сайта</span></li>', '<li><span>Экономия при онлайн-заказе</span></li>');

        $text[] = array( (($this->_datas['region']['name'] == 'Москва') ? '<li><span>Выезд курьера в пределах МКАД</span></li>' : ''), '<li><span>Выезд курьера по '.$this->_datas['region']['name_de'].'</span></li>', '<li><span>Выезд на дом или в офис</span></li>', '<li><span>Доставка на дом или в офис</span></li>', '<li><span>Доставка по '.$this->_datas['region']['name_de'].'</span></li>',
            '<li><span>Доставка техники по '.$this->_datas['region']['name_de'].'</span></li>', '<li><span>Курьерская доставка по '.$this->_datas['region']['name_de'].'</span></li>', '<li><span>Курьерская доставка техники</span></li>');

        $text[] = array('<li><span>Выявление неисправности за 15 мин</span></li>', '<li><span>Диагностика за 15 минут</span></li>', '<li><span>Мгновенная диагностика</span></li>', '<li><span>Моментальная диагностика</span></li>', '<li><span>Экспресс диагностика</span></li>', '<li><span>Бесплатная диагностика</span></li>');

        $text[] = array('<li><span>Срочный ремонт по цене обычного</span></li>', '<li><span>Срочный ремонт техники</span></li>', '<li><span>Срочный ремонт от 0,5 часа</span></li>', '<li><span>Среднее время ремонта - 1,5 часа</span></li>', '<li><span>Оперативное устранение неисправности</span></li>',
                '<li><span>Оперативный ремонт от 30 минут</span></li>', '<li><span>Срочный ремонт без наценки</span></li>', '<li><span>Ремонт в день обращения</span></li>');

        $text[] = array('<li><span>Все запчасти в наличии</span></li>', '<li><span>Запчасти в наличии</span></li>', '<li><span>Комплектующие в наличии</span></li>', '<li><span>Оригинальные компоненты</span></li>', '<li><span>Сертифицированное оборудование</span></li>', '<li><span>Специализированное оборудование</span></li>',
                '<li><span>Фирменные комплектующие</span></li>');

        foreach(rand_it::randMas($text, 4, '', $feed) as $var)
            $vars[] = $var;

        $vars[] = array('</ul>');

        $vars2 = array();

        $t = array();
        $t[] = array('<p>Заказывая услуги по ремонту', '<p>Заказывая ремонт', '<p>Заказывая услуги по ремонту');
        $t[] = array('вы можете сэкономить.', ' - тратьте меньше.', 'и сэкономить - это возможно.');

        $t[] = array('<p>Стоимость обслуживания', '<p>Обслуживание');
        $t[] = array('может быть еще ниже.', 'может быть еще дешевле.', 'теперь дешевле.');

        $t_array = array();

        for ($i = 0; $i < 2; $i++)
        {
            foreach($t[ $i*2 ] as $t_w)
            {
                foreach ($this->_datas['orig_model_type'] as $type)
                {
                    foreach ($t[ $i*2 + 1 ] as $t_w1)
                    {
                        if (isset($params['marka_id']) && isset($params['model_type_id']))
                        {
                            if (!$level)
                                $t_array[] = $t_w.' '.$type['name_rm'].' '.$this->_datas['marka']['name'].' '.$t_w1;
                            else
                                $t_array[] = $t_w.' '.tools::commit($type['name_rm']).' '.$this->_datas['marka']['name'].' '.$t_w1;
                        }

                        if (isset($params['m_model_id']))
                        {
                            $t_array[] = $t_w.' '.$type['name_rm'].' '.$this->_datas['marka']['name'].' '.$this->_datas['m_model']['name'].' '.$t_w1;
                        }

                        if (isset($params['model_id']))
                        {
                            $t_array[] = $t_w.' '.$type['name_re'].' '.$this->_datas['model']['name'].' '.$t_w1;
                        }
                    }
                }
            }
        }

        $vars2[] = $t_array;

        $vars2[] = array('Запишитесь на ремонт онлайн', 'Запишитесь на ремонт через онлайн форму', 'Заполните форму заявки на сайте', 'Оставьте заказ на сайте', 'Оставьте заявку на сайте',
                            'Отправьте заявку на ремонт', 'Отправьте онлайн-заявку', 'Оформите заказ онлайн', 'Оформите заказ через сайт', 'Оформите онлайн заявку на ремонт', 'Сделайте заказ онлайн');

        $vars2[] = array('или');
        $vars2[] = array('сообщите нашим менеджерам, что делаете заказ на '.$params['realHost'], 'сообщите нашим операторам, что делаете заказ на '.$params['realHost'],
                            'сообщите нашим диспетчерам, что делаете заказ на '.$params['realHost'], 'позвоните по телефону '.tools::format_phone($this->_datas['phone']),
                            'позвоните по номеру '.tools::format_phone($params['phone']), 'позвоните по единому номеру сервисного центра '.tools::format_phone($this->_datas['phone']),
                            'проинформируйте менеджера, что хотите сделать заказ на '.$params['realHost'], 'проинформируйте оператора, что хотите сделать заказ на '.$params['realHost'],
                            'проинформируйте диспетчера, что хотите сделать заказ на '.$params['realHost']);

        $vars2[] = array('и получите скидку 10%.</p>');

        $vars3 = array();
        $vars3[] = array('<p>Стоимость', '<p>Цена');
        $vars3[] = array('комплектующих', 'запчастей');

        $t_array = array();
        foreach ($this->_datas['orig_model_type'] as $type)
        {
            if (isset($params['marka_id']) && isset($params['model_type_id']))
            {
                if (!$level)
                    $t_array[] = $type['name_rm'].' '.$this->_datas['marka']['name'];
                else
                    $t_array[] = tools::commit($type['name_rm']).' '.$this->_datas['marka']['name'];
            }

            if (isset($params['m_model_id']))
            {
                $t_array[] = $type['name_rm'].' '.$this->_datas['marka']['name'].' '.$this->_datas['m_model']['name'];
            }

            if (isset($params['model_id']))
            {
                $t_array[] = $type['name_re'].' '.$this->_datas['model']['name'];
            }
        }
        $vars3[] = $t_array;

        $vars3[] = array('варьируется', 'различается', 'отличается', 'может варьироваться', 'может различаться', 'может отличаться');
        $vars3[] = array('в зависимости от', 'исходя из');
        $vars3[] = array('характеристик', 'особенностей', 'параметров', 'номера ревизии');
        $vars3[] = array('выпущенного', 'конкретного', 'данного', 'вашего', 'заявленного');
        $vars3[] = array('устройства,', 'аппарата,');
        $vars3[] = array('страны');
        $vars3[] = array('изготовителя,', 'производителя,', 'производства,', 'выпуска,', 'изготовления,');
        $vars3[] = array('и', 'а также');
        $vars3[] = array('совместимости');
        $vars3[] = array('комплектующих.', 'запчастей.', 'компонентов.');
        $vars3[] = array('Для уточнения информации звоните по', 'Уточняйте информацию по', 'Точную информацию можно получить, позвонив по', 'Уточнить стоимость вы можете по',
            'Точную стоимость вы можете узнать по', 'Информацию о стоимости просим уточнять по', 'Уточняйте информацию у менеджеров по');
        $vars3[] = array('телефону', 'единому номеру телефона', 'телефону горячей линии', 'телефону '.$this->_datas['servicename'], 'многоканальному номеру');
        $vars3[] = array(tools::format_phone($this->_datas['phone']).'.</p>');

        $vars4 = array();
        $vars4[] = array('<p>'.$this->_datas['servicename'].',');
        $vars4[] = array('пожалуй,', 'вероятно,', 'возможно,');
        $vars4[] = array('лучшее место, чтобы отремонтировать', 'лучший сервис по ремонту', 'лучший вариант для вашего', 'лучшая возможность починить',
                'лучший способ отремонтировать');

        $t_array = array();
        foreach ($this->_datas['orig_model_type'] as $type)
        {
            if (isset($params['marka_id']) && isset($params['model_type_id']))
            {
                $t_array[] = $this->_datas['marka']['name'].'.';
            }

            if (isset($params['m_model_id']))
            {
                $t_array[] = $this->_datas['marka']['name'].' '.$this->_datas['m_model']['name'].'.';
            }

            if (isset($params['model_id']))
            {
                $t_array[] = $this->_datas['model']['name'].'.';
            }
        }
        $vars4[] = $t_array;

        $vars4[] = array('Мы -');
        $vars4[] = array('профессионалы', 'сильная команда', 'эксперты', 'настоящие профи', 'опытные специалисты', 'профи в своем деле');
        $vars4[] = array('и');
        $vars4[] = array('справимся с задачей', 'решим задачу', 'решим любой вопрос', 'делаем свою работу', 'знаем как работать', 'достигаем результата', 'справимся с ремонтом');
        $vars4[] = array('быстро и качественно.', 'быстро и надежно.', 'быстро и недорого.', 'качественно и быстро.',
                        'качественно и недорого.', 'качественно и оперативно.', 'надежно и недорого.', 'надежно и оперативно.', 'недорого и быстро.', 'недорого и качественно.',
                        'оперативно и качественно.', 'оперативно и надежно.', 'оперативно и недорого.', 'недорого и оперативно.');

        // addition
        $region_name_pe = $this->_datas['region']['name_pe'];//в Москве (в Владивостоке)
        $orig_model_type = $this->_datas['orig_model_type']; // тип устройства
        $marka = $this->_datas['marka']['name'];
        $ru_marka = $this->_datas['marka']['ru_name'];

        $syns = false;
        if (isset($params['key']))
            if ($params['key'] == 'service')
                $syns = tools::skl('service', $this->_suffics, $this->_datas['syns'][0], 'dat');// название услуги

        $addition =  array();
        $addition[] = array("техническое оснащение лаборатории","техническое оснащение мастерской","оснащение лаборатории","оснащение мастерской","оснащение лаборатории сервиса",
            "оснащение мастерской сервиса","оснащение лаборатории центра","оснащение мастерской центра","оборудование лаборатории сервиса","оборудование мастерской сервиса",
            "оборудование лаборатории центра","оборудование мастерской центра","фирменное оборудование лаборатории сервиса","фирменное оборудование сервиса",
            "фирменное оборудование лаборатории центра","фирменное оборудование центра","профессиональное оборудование лаборатории сервиса",
            "профессиональное оборудование сервиса","профессиональное оборудование лаборатории центра","профессиональное оборудование центра",
            "специализированное оборудование лаборатории сервиса","специализированное оборудование сервиса","специализированное оборудование лаборатории центра",
            "специализированное оборудование центра");
        $addition[] = array("прямые поставки комплектующих","регулярные поставки комплектующих","регулярные прямые поставки комплектующих","прямые регулярные поставки комплектующих",
            "прямые поставки запасных частей","регулярные поставки запасных частей","регулярные прямые поставки запасных частей","прямые регулярные поставки запасных частей",
            "прямые поставки запчастей","регулярные поставки запчастей","регулярные прямые поставки запчастей","прямые регулярные поставки запчастей",
            "налаженные прямые поставки комплектующих","налаженные прямые поставки запчастей","налаженные прямые поставки запасных частей");
        $addition[] = array("накопленный опыт мастеров","специализированное образование мастеров","регулярная практика мастеров","многолетняя практика мастеров",
            "ежедневная практика мастеров","многолетний опыт мастеров","высокая квалификация мастеров","знания мастеров","накопленный опыт специалистов",
            "специализированное образование специалистов","регулярная практика специалистов","многолетняя практика специалистов","ежедневная практика специалистов",
            "многолетний опыт специалистов","высокая квалификация специалистов","знания специалистов","накопленный опыт сервисных специалистов",
            "специализированное образование сервисных специалистов","регулярная практика сервисных специалистов","многолетняя практика сервисных специалистов",
            "ежедневная практика сервисных специалистов","многолетний опыт сервисных специалистов","высокая квалификация сервисных специалистов",
            "знания сервисных специалистов","накопленный опыт сервисных мастеров","специализированное образование сервисных мастеров","регулярная практика сервисных мастеров",
            "многолетняя практика сервисных мастеров","ежедневная практика сервисных мастеров","многолетний опыт сервисных мастеров","высокая квалификация сервисных мастеров",
            "знания сервисных мастеров","накопленный опыт ремонтных мастеров","специализированное образование ремонтных мастеров","регулярная практика ремонтных мастеров",
            "многолетняя практика ремонтных мастеров","ежедневная практика ремонтных мастеров","многолетний опыт ремонтных мастеров","высокая квалификация ремонтных мастеров",
            "знания ремонтных мастеров","накопленный опыт штатных мастеров","специализированное образование штатных мастеров","регулярная практика штатных мастеров",
            "многолетняя практика штатных мастеров","ежедневная практика штатных мастеров","многолетний опыт штатных мастеров","высокая квалификация штатных мастеров",
            "знания штатных мастеров","накопленный опыт штатных специалистов","специализированное образование штатных специалистов","регулярная практика штатных специалистов",
            "многолетняя практика штатных специалистов","ежедневная практика штатных специалистов","многолетний опыт штатных специалистов","высокая квалификация штатных специалистов",
            "знания штатных специалистов","накопленный опыт сервисных специалистов","специализированное образование сервисных специалистов","регулярная практика сервисных специалистов",
            "многолетняя практика сервисных специалистов","ежедневная практика сервисных специалистов","многолетний опыт сервисных специалистов","высокая квалификация сервисных специалистов",
            "знания сервисных специалистов");
        $addition2[0][] = array("позволяют нам гарантировать","позволяют гарантировать вам");
        $addition2[0][] = array("лучшие","самые лучшие");
        $addition2[0][] = array("в $region_name_pe");
        $addition2[0][] = array("цены,","расценки,");
        /*$addition2[1][] = array("позволяют нам работать по","позволяют работать по");
        $addition2[1][] = array("самым демократичным","самым доступным","лучшим");
        $addition2[1][] = array("в $region_name_pe");
        $addition2[1][] = array("ценам,","расценкам,");*/
        $addition2[2][] = array("- это лучшая гарантия","- это ваша гарантия");
        $addition2[2][] = array("низкой цены","низких цен","оптимальных цен","оптимальной цены");

        $t = array("на ремонт,","на любой ремонт,");

        foreach ($this->_datas['orig_model_type'] as $type)
        {
            $t[] = "на ремонт ".$type["name_re"].",";
            $t[] = "на ремонт ".$type["name_re"]." ".$marka.",";
            $t[] = "на ремонт ".$type["name_re"]." ".$ru_marka.",";

            if (isset($params['m_model_id']))
            {
                $t[] = "на ремонт ".$type["name_re"]." ".$marka.' '.$this->_datas['m_model']['name'].",";
                $t[] = "на ремонт ".$type["name_re"]." ".$ru_marka.' '.$this->_datas['m_model']['name'].",";
            }

            if (isset($params['model_id']))
            {
                $t[] = "на ремонт ".$type["name_re"]." ".$this->_datas['model']['name'].",";
            }

            if ($syns)
            {
                $t[] = "по $syns";
                $t[] = "по $syns ".$type["name_re"].",";
                $t[] = "по $syns ".$type["name_re"]." ".$marka.",";
                $t[] = "по $syns ".$type["name_re"]." ".$ru_marka.",";

                if (isset($params['m_model_id']))
                {
                    $t[] = "по $syns ".$type["name_re"]." ".$marka.' '.$this->_datas['m_model']['name'].",";
                    $t[] = "по $syns ".$type["name_re"]." ".$ru_marka.' '.$this->_datas['m_model']['name'].",";
                }

                if (isset($params['model_id']))
                {
                    $t[] = "по $syns ".$type["name_re"]." ".$this->_datas['model']['name'].",";
                }
            }

        }
        $addition2[2][] = $t;

        $addition31[0][] = array("высокое качество ремонта","высочайшее качество ремонта","безукоризненное качество ремонта","безупречное качество ремонта","отличное качество ремонта",
            "высокое качество услуг","высочайшее качество услуг","безукоризненное качество услуг","безупречное качество услуг","отличное качество услуг");
        $addition31[1][] = array("оптимальные сроки","кратчайшие сроки","оптимальное время","кратчайшее время");
        $addition31[1][] = array("проводимых работ","работы","своей работы","ремонтных работ","проводимых ремонтных работ");

        $addition32[0][] = array("высокого качества услуг","высочайшего качества услуг","безукоризненного качества услуг","безупречного качества услуг","отличного качества услуг");
        $addition32[1][] = array("оптимальных в $region_name_pe сроков","кратчайших в $region_name_pe сроков","оптимального в $region_name_pe времени","кратчайшего в $region_name_pe времени");
        $addition32[1][] = array("проводимых работ","работы","своей работы","ремонтных работ","проводимых ремонтных работ");

        $addition_a = "";

        while ( 0 < count($addition) )
        {
            $addition_in = array_rand($addition, 1);

            $addition_in_in = array_rand($addition[$addition_in], 1);
            $addition_a .= $addition[$addition_in][$addition_in_in];

            if (count($addition) == 3)
            {
                $addition_a .= ", ";
            }
            if (count($addition) == 2)
            {
                $addition_a .= " и ";
            }

            if (count($addition) == 1)
            {
                $addition_a .= " ";
            }

            unset($addition[$addition_in]);

        }

        $addition2_in = array_rand($addition2,1);


        $addition_a .= $this->checkarray($addition2[$addition2_in]) . " ";

        if ($addition2_in == 0) // было if ($addition2_in == 0 || $addition2_in == 1)
        {
            $addition31_a = rand(1,2);
            if ($addition31_a == 1)
            {
                $addition_a .= $this->checkcolumn($addition31[0][0]) . " и " . $this->checkarray($addition31[1]);
            }

            if ($addition31_a == 2)
            {
                $addition_a .= $this->checkarray($addition31[1]) . " и " . $this->checkcolumn($addition31[0][0]);
            }

        }

        if ($addition2_in == 2)
        {
            $addition32_a = rand(1,2);
            if ($addition32_a == 1)
            {
                $addition_a .= $this->checkcolumn($addition32[0][0]) . " и " . $this->checkarray($addition32[1]);
            }

            if ($addition32_a == 2)
            {
                $addition_a .= $this->checkarray($addition32[1]) . " и " . $this->checkcolumn($addition32[0][0]);
            }
        }

        $this->_datas['addition'] = tools::mb_ucfirst($addition_a, 'utf-8', false).".</p>";

        foreach (array('h1', 'title', 'description') as $key)
                $ret[$key] =  implode(' ', $ret[$key]);

        $ret['img'] = $this->_datas['img'];
        $ret['text'] = sc::_createTree($vars, $feed);

        $this->_datas['vars2'] = sc::_createTree($vars2, $feed);
        $this->_datas['vars3'] = sc::_createTree($vars3, $feed);
        $this->_datas['vars4'] = sc::_createTree($vars4, $feed);

        $this->_ret = $this->_answer($answer, $ret);
        
        $this->_sdek();                
        $body = $this->_body($file_name, basename(__FILE__, '.php'));


        //return array('title' => $this->_ret['title'], 'description' => $this->_ret['description'], 'body' => $body);
        return array('body' => $body);
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
                $this->_datas['zoom'] = 11;
            }
        }
        return;
    }

    private function _make_accord_table($marka_lower)
    {
        $urls = array(
        	"acer" => array('computers'),
        	"apple" => array('computers'),
        	"asus" => array('computers'),
        	"canon" => array('foto','all-in-one','printers'),
        	"dell" => array('desctops','computers'),
        	"hp" => array('computers','desctops','printers','all-in-one'),
        	"lenovo" => array('computers','desctops','servers'),
        	"msi" => array('computers'),
        	"nikon" => array('foto'),
        	"samsung" => array('computers'),
        	"sony" => array('computers','consoles','photo_video'),
        	"xiaomi" => array('tv', 'laptop'),
            "nokia" => array('tablets'),
	    );

        $this->_datas['add_device_type'] = $add_device_type = array(
            'computers' => array('type' => 'моноблок', 'type_rm' => 'моноблоков', 'type_m' => 'моноблоки'),
            'foto' => array('type' => 'фотоаппарат', 'type_rm' => 'фотоаппаратов', 'type_m' => 'фотоаппараты'),
            'all-in-one' => array('type' => 'МФУ', 'type_rm' => 'МФУ', 'type_m' => 'МФУ'),
            'printers' => array('type' => 'принтер', 'type_rm' => 'принтеров', 'type_m' => 'принтеры'),
        	'desctops' => array('type' => 'компьютер', 'type_rm' => 'компьютеров', 'type_m' => 'компьютеры'),
        	'servers' => array('type' => 'сервер', 'type_rm' => 'серверов', 'type_m' => 'серверы'),
        	'consoles' => array('type' => 'приставка', 'type_rm' => 'приставок', 'type_m' => 'приставки'),
            'photo_video' => array('type' => 'камера', 'type_rm' => 'камер', 'type_m' => 'камеры'),
            'tv' => array('type' => 'телевизор', 'type_rm' => 'телевизоров', 'type_m' => 'телевизоры'),
            'laptop' => array('type' => 'ноутбук', 'type_rm' => 'ноутбуков', 'type_m' => 'ноутбуки'),
            'tablets' => array('type' => 'планшет', 'type_rm' => 'планшетов', 'type_m' => 'планшеты')
        );

        $this->_datas['accord'] = array('смартфон' => 'phones', 'ноутбук' => 'laptop', 'планшет' => 'tablets');

        foreach ($add_device_type as $key => $value)
            $this->_datas['accord'][$value['type']] = $key;

        if (isset($urls[$marka_lower]))
        {
            $t = array();
            foreach ($urls[$marka_lower] as $url)
                $t[] = $add_device_type[$url];
            //print_r($t);
            $this->_datas['all_devices'] = array_merge($this->_datas['all_devices'], $t);
            //print_r($this->_datas['all_devices']);
        }

        $this->_datas['accord_image'] = array(
            'принтер' => 'printery',
            'моноблок' => 'monobloki',
            'МФУ' => 'mfu',
            'фотоаппарат' => 'fotoapparaty',
            'компьютер' => 'kompyutery',
            'сервер' => 'servery',
            'камера' => 'kamery',
            'приставка' => 'pristavki',
            'телевизор' => 'televizory',
            'ноутбук' => 'noutbuki',
            'смартфон' => 'telefony',
            'планшет' => 'planshety',
        );
    }
}

?>
