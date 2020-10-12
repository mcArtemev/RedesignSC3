<?

// Comment Vlad 2*2445

namespace framework\ajax\parse\hooks;

use framework\tools;
use framework\pdo;
use framework\rand_it;

class sc5 extends sc
{
    public function generate($answer, $params)
    {
        $sql =  "SELECT `model_types`.`name` as `type`, `model_types`.`id` as `type_id`,
                `model_types`.`name_re` as `type_re`, `model_types`.`name_m` as `type_m`, `model_types`.`name_rm` as `type_rm` FROM `m_model_to_sites`
            INNER JOIN `m_models` ON `m_models`.`id` = `m_model_to_sites`.`m_model_id`
            INNER JOIN `model_types` ON `m_models`.`model_type_id` = `model_types`.`id` WHERE `m_model_to_sites`.`site_id`= ? GROUP BY `model_types`.`name`";
        $stm = pdo::getPdo()->prepare($sql);
        $stm->execute(array($params['site_id']));
        $this->_datas['all_devices'] = $stm->fetchAll(\PDO::FETCH_ASSOC);

        $f = $this->_datas['f'] = tools::gen_feed($params['site_name']);
        $diagnostic_time = $this->_datas['diagnostic_time'] = tools::get_rand(array(10, 15, 20, 30), $f);

        // region
        $this->_datas['region'] = $this->_getRegion($params['region_id']);
        $city = $this->_datas['region']['name_pe'];
        $city_d = $this->_datas['region']['name_de'];
        $city_r = $this->_datas['region']['name_re'];

        // partner
        $this->_datas['partner'] = $this->_getPartner($params['partner_id']);
        
        $this->_datas['zoom'] = 16;

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

                $marka_lower = mb_strtolower($this->_datas['marka']['name']);

                $this->_datas['menu'] = array(
                            '/' => 'Главная',
                            '/company/price/' => 'Цены',
                            '/company/diagnostika-'.$marka_lower.'/' => 'Диагностика',
                            '/company/remont-'.$marka_lower.'/' => 'Срочный ремонт',
                            '/company/garantiya/' => 'Гарантия',
                            '/company/zapchasti-'.$marka_lower.'/' => 'Комплектующие',
                            '/company/contacts/' => 'Контакты',
                    );

                $this->_make_accord_table($marka_lower);  
            
                switch ($file_name)
            	{
            		case 'index':
                    
                        $title = 'Cервисный центр '.$this->_datas['marka']['name'].': ремонт техники '.$this->_datas['marka']['name'].' в '.$city. ' — REMONT CENTRE';
                        $description = 'Сервисный центр REMONT CENTRE проводит ремонт техники '.$this->_datas['marka']['name'].' любой сложности: выезд курьера по '.$city_d.', бесплатная диагностика и срочный ремонт '.
                                    $this->_datas['marka']['ru_name'].' с гарантией';
                                                        
            			/*$title = 'Сервисный центр по ремонту ' . $this->_datas['marka']['name'].' ('.$this->_datas['marka']['ru_name'].')' . ' в '.$city.' REMONT CENTRE';
            			$description = 'Ремонт техники ' . $this->_datas['marka']['name'] . ': выезд курьера по '.$city_d.', бесплатная диагностика, срочный ремонт. Запись в REMONT CENTRE.';*/
                        
                        if ($marka_lower == 'sony')
                        {
                             $h1 = 'Сервисный центр по ремонту техники Sony';
                             $h1 .= ' в '.$city;
                        }
                        else
                        {
            			     if ($marka_lower == 'apple')
                             {
                                $h1 = 'Сервисный центр Apple';
                                $h1 .= ' в '.$city;
                             }
                             else
                             {
                                $h1 = 'Сервисный центр ' . $this->_datas['marka']['name'] . ' REMONT CENTRE';
                                $h1 .= ' в '.$city;
                             }
                        }
            		break;
            		case 'diagnostika':
            			$title = 'Диагностика техники ' . $this->_datas['marka']['name'] . ' в REMONT CENTRE '.mb_strtoupper($this->_datas['region']['translit1']);

            			$description = 'Аппаратная и программная диагностика ' . $this->_datas['marka']['name'] . ' в REMONT CENTRE '.mb_strtoupper($this->_datas['region']['translit1']).
                                        ': среднее время проведения диагностики — '.
                            tools::declOfNum($diagnostic_time, array('минуты', 'минут', 'минут')).'.';

            			$h1 = 'Бесплатная диагностика';
            		break;
            		case 'remont':

                        $min_time = tools::get_rand(array(10, 15, 20, 25, 30), $f);
                        $max_time = tools::get_rand(array(3, 4, 5), $f);

            			$title = 'Срочный ремонт техники ' . $this->_datas['marka']['name'] . ' в '.$city.' — REMONT CENTRE';
            			$description = 'Экспресс ремонт ' . $this->_datas['marka']['name'] . ' в сервисном центре REMONT CENTRE '.mb_strtoupper($this->_datas['region']['translit1']).
                                            ': в зависимости от типа неисправности от '.
                                        tools::declOfNum($min_time, array('минуты', 'минут', 'минут')).' до '.tools::declOfNum($max_time, array('часа', 'часов', 'часов')).'.';
            			$h1 = 'Срочный ремонт от '. tools::declOfNum($min_time, array('минуты', 'минут', 'минут'));
            		break;
            		case 'garantiya':
            			$title = 'Гарантии на услуги и комплектующие ' . $this->_datas['marka']['name'] .' в REMONT CENTRE '.mb_strtoupper($this->_datas['region']['translit1']);
            			$description = 'Гарантии на ремонтные работы и установленные комплектующие ' . $this->_datas['marka']['name'] . ' в REMONT CENTRE '.
                                            mb_strtoupper($this->_datas['region']['translit1']);
            			$h1 = 'Гарантии REMONT CENTRE';
            		break;
            		case 'zapchasti':
            			$title = 'Комплектующие ' . $this->_datas['marka']['name'] . ' и расходные материалы для ремонта — REMONT CENTRE '.mb_strtoupper($this->_datas['region']['translit1']);
            			$description = 'Весь ассортимент оригинальных запасных частей и ПО на поддерживаемые в обслуживании модели ' . $this->_datas['marka']['name'] . ' всегда в наличии в сервисе REMONT CENTRE '.
                                    'или на центральном складе в '.$city.'.';
            			$h1 = 'Оригинальные комплектующие';
            		break;
               		case 'contacts':
            			$title = 'Контактная информация REMONT CENTRE ' . $this->_datas['marka']['name'] . ' в '.$city.': адрес, телефон, схема проезда';
            			$description = 'Контакты сервисного центра ' . $this->_datas['marka']['name'] . ' в '. $city . ': адрес, телефон, схема и описание проезда, обратная связь со специалистами '.
                                    'и сотрудниками REMONT CENTRE.';
            			$h1 = 'Контакты центра';
            		break;
            		case 'price':
                        $types = array();
                        foreach ($this->_datas['all_devices'] as $device)
                            $types[] = $device['type'];

            			$title = 'Цены на услуги REMONT CENTRE ' . $this->_datas['marka']['name'].' в '.$city;
            			$description = 'Стоимость ремонтных работ в REMONT CENTRE '.mb_strtoupper($this->_datas['region']['translit1']).': '.implode(',', $types).' ' . $this->_datas['marka']['name'];
            			$h1 = 'Прайс лист';

                        $this->_datas['orig_params'] = $params;
            		break;
                    case 'company':
                        $title = 'О компании '.$this->_datas['servicename'].' ' .mb_strtoupper($this->_datas['region']['translit1']);

                        $description = array();
                        $description[] = array('Условия ремонта', ' Условия ремонта техники', 'Условия ремонта устройств', 'Условия проведения ремонта', 'Условия проведения ремонта техники',
                                'Условия проведения ремонта устройств', 'Условия проведения ремонтных работ');
                        $description[] = array($this->_datas['marka']['name']);
                        $description[] = array('в компании');
                        $description[] = array($this->_datas['servicename'].' в ' . $city. ':');

                        $lis[] = array('фиксированные цены', 'честные цены', 'цены регламентированы прайс-листом', 'цены регламентированы прейскурантом', 'выгодные цены');
                        $lis[] = array('бесплатная экспресс диагностика', 'бесплатная срочная диагностика', 'бесплантная диагностика', 'срочная диагностика',
                                            'экспресс диагностика');
                        $lis[] = array('лучшие сроки ремонта', 'оптимальные сроки ремонта', 'сжатые сроки ремонт', 'кратчайшие сроки ремонта');
                        $lis[] = array('гарантии на все работы', 'гарантии на любой ремонт', 'гарантии на все услуги',
                                'гарантии на все услуги и комплектующие', 'гарантии на все комплектующие и услуги', 'гарантии на все ремонтные работы',
                                'длительная гарантия', 'длительная гарантия на все услуги', 'длительная гарантия на все работы', 'длительная гарантия на ремонт');
                        $lis[] = array('оригинальные запчасти', 'оригинальные комплектующие', 'все комплектующие в наличии', 'фирменные запчасти',
                                'фирменные комплектующие');
                        $lis[] = array('бесплатные консультация по телефону', 'бесплатные консультации', 'бесплатная горячая линия', 'онлайн консультации',
                                    'online консультации', 'консультации online');

                        $lis = rand_it::randMas($lis, 5, '', $feed);
                        $count = count($lis) - 1;

                        foreach ($lis as $key => $value)
                        {
                            foreach ($value as $k => $v)
                            {
                                if ($count != $key)
                                    $lis[$key][$k] = $v.',';
                                else
                                    $lis[$key][$k] = $v.'.';
                            }

                            $description[] = $lis[$key];
                        }

                        $description = sc::_createTree($description, $feed);
                        $h1 = 'О компании';
                    break;

                    //zamena
                    case 'zamena-ekrana':
                        $types = array();
                        foreach ($this->_datas['all_devices'] as $device)
                            $types[] = $device['type'];

                        $title = 'Замена экрана '.$this->_datas['marka']['name'].' в '.$city.' REMONT CENTRE';
                        $h1 = 'Замена экрана на технике '.$this->_datas['marka']['name'];
                        $description = 'Стоимость замены экрана в REMONT CENTRE '.mb_strtoupper($this->_datas['region']['translit1']).': '.implode(',', $types).' ' . $this->_datas['marka']['name'];
                    break;
                    
                    case 'promo':
                        
                        $title = 'Cервисный центр '.$this->_datas['marka']['name'].': ремонт техники '.$this->_datas['marka']['name'].' в '.$city. ' — REMONT CENTRE';
                        $description = 'Сервисный центр REMONT CENTRE проводит ремонт техники '.$this->_datas['marka']['name'].' любой сложности: выезд курьера по '.$city_d.', бесплатная диагностика и срочный ремонт '.
                                    $this->_datas['marka']['ru_name'].' с гарантией';
                    break;
                    
                    default:
                        
                        foreach ($this->_datas['add_device_type'] as $key => $value)
                        {
                            if (mb_strpos($this->_datas['arg_url'], $key) !== false)
                            {
                                $gadget = $value;
                                break;        
                            }    
                        }
                        
                        $this->_datas['gadget'] = $gadget; 
                        
                        $title = 'Ремонт '.$gadget['type_rm'].' '.$this->_datas['marka']['name'].' ('.$this->_datas['marka']['ru_name'].') в '.$city.' — REMONT CENTRE';
                        $h1 = 'Ремонт '.$gadget['type_rm'].' '.$this->_datas['marka']['name'];
                        
                        $description = tools::mb_ucfirst($gadget['type_m']).' '.$this->_datas['marka']['name'].': ремонт в '.$city.'. Наличие комплектующих. Доставка на дом или в офис. Моментальная диагностика. Постгарантийный ремонт.';
                    
                        $file_name = 'gadget';
            	}

                $this->_preims($params);

                $this->_datas['addresis'] = $this->_getAddresis($params['setka_id'], $this->_datas['marka']['id']);

                if (isset($title)) $this->_ret['title'] = $title;
                if (isset($h1)) $this->_ret['h1'] = $h1;
                if (isset($description)) $this->_ret['description'] = $description;
                
                $this->_sdek();

                $body = $this->_body($file_name, basename(__FILE__, '.php'));
                //return array('title' => $title, 'description' => $description, 'body' => $body);
                return array('body' => $body);
            }
        }

        $ret = array();

        $file_name = '';

        $this->_sqlData($params);
        $this->_make_accord_table(mb_strtolower($this->_datas['marka']['name']));
        $this->_datas['addresis'] = $this->_getAddresis($params['setka_id'], $this->_datas['marka']['id']);

        //!!
        $marka_lower = mb_strtolower($this->_datas['marka']['name']);

        $this->_datas['menu'] = array(
                        '/' => 'Главная',
                        '/company/price/' => 'Цены',
                        '/company/diagnostika-'.$marka_lower.'/' => 'Диагностика',
                        '/company/remont-'.$marka_lower.'/' => 'Срочный ремонт',
                        '/company/garantiya/' => 'Гарантия',
                        '/company/zapchasti-'.$marka_lower.'/' => 'Комплектующие',
                        '/company/contacts/' => 'Контакты',
                );


        $feed = $this->_datas['feed'] = (isset($this->_datas['vals']['feed']) ? $this->_datas['vals']['feed'] : $this->_datas['feed']);

        switch ($this->_suffics)
        {
            case 'f':
            {
                $titles[0][] = array('диагностики','чистки','ремонта камер','ремонта встроенных камер','ремонта корпусов','ремонта динамиков','ремонта разъемов','ремонта портов','ремонта шлейфов','ремонта симхолдеров',
      						'ремонта сим-лотков','ремонта держателей сим','ремонта simholder','ремонта кнопок','ремонта кнопок включения','ремонта кнопок выключения','ремонта GPS','ремонта GPS-модулей','ремонта модулей GPS','ремонта плат GPS',
      						'ремонта GPS-плат ','ремонта вибромоторов','ремонта вибро','ремонта вибромодулей','ремонта микрофонов','ремонта гнезд питания','ремонта разъемов питания','ремонта разъемов зарядки','ремонта гнезда питания','ремонта гнезда зарядки',
      						'ремонта WI-FI','ремонта WI-FI модулей','ремонта модулей WI-FI','ремонта плат WI-FI','ремонта WI-FI плат ','ремонта слотов','перепрошивки','ремонта крышки','ремонта антенны');

                $titles[0][] = array('замены материнских плат', 'замены плат', 'замены элементов плат', 'замены системных плат', 'замены мультиконтроллеров', 'замены контроллеров', 'замены контроллеров плат',
     						 'замены ШИМ-контроллеров', 'замены PWM-контроллеров', 'замены процессоров', 'замены чипов', 'перепайки цепей питания', 'перепайки цепей питания плат', 'перепайки чипов', 'перепайки BGA-чипов',
     						 'перепайки кондесаторов плат', 'перепайки кондесаторов плат', 'перепайки мультиконтроллеров', 'перепайки контроллеров', 'перепайки контроллеров плат', 'перепайки ШИМ-контроллеров',
     						 'перепайки PWM-контроллеров', 'реболла чипов', 'реболла BGA-чипов');

                $titles[1][] = array('диагностики', 'чистки', 'замены камер', 'замены встроенных камер', 'замены корпусов', 'замены динамиков', 'замены разъемов', 'замены портов', 'замены шлейфов',
          						'замены симхолдеров', 'замены сим-лотков', 'замены держателей сим', 'замены simholder', 'замены кнопок', 'замены кнопок включения', 'замены кнопок выключения',
      						'замены GPS', 'замены GPS-модулей', 'замены модулей GPS', 'замены плат GPS', 'замены GPS-плат ', 'замены вибромоторов', 'замены вибро', 'замены вибромодулей',
  						    'замены микрофонов', 'замены батарей', 'замены батареек', 'замены АКБ', 'замены аккумуляторов', 'замены аккумуляторных батарей', 'замены WI-FI', 'замены WI-FI модулей',
      						'замены модулей WI-FI', 'замены плат WI-FI', 'замены WI-FI плат ', 'замены флеш памяти', 'замены слотов', 'замены прошивки', 'перепрошивки', 'замены памяти', 'увеличения памяти',
      						'замены крышки', 'замены деталей', 'замены антенны');

                $titles[1][] = array('ремонта материнских плат', 'ремонта плат', 'ремонта элементов плат', 'ремонта системных плат', 'ремонта мультиконтроллеров', 'ремонта контроллеров', 'ремонта контроллеров плат',
          					 'ремонта ШИМ-контроллеров', 'ремонта PWM-контроллеров', 'перепайки цепей питания', 'перепайки цепей питания плат', 'перепайки чипов', 'перепайки BGA-чипов', 'перепайки кондесаторов плат', 'перепайки кондесаторов плат',
          					 'перепайки мультиконтроллеров', 'перепайки контроллеров', 'перепайки контроллеров плат', 'перепайки ШИМ-контроллеров', 'перепайки PWM-контроллеров', 'реболла чипов', 'реболла BGA-чипов');
            }

            case 'p':
            {
                $titles[0][] = array('диагностики', 'чистки', 'ремонта камер', 'ремонта встроенных камер', 'ремонта корпусов', 'ремонта динамиков', 'ремонта разъемов', 'ремонта портов', 'ремонта шлейфов', 'ремонта симхолдеров',
					       'ремонта сим-лотков', 'ремонта держателей сим', 'ремонта simholder', 'ремонта кнопок', 'ремонта кнопок включения', 'ремонта кнопок выключения', 'ремонта GPS', 'ремонта GPS-модулей', 'ремонта модулей GPS', 'ремонта плат GPS',
					       'ремонта GPS-плат ', 'ремонта вибромоторов', 'ремонта вибро', 'ремонта вибромодулей', 'ремонта микрофонов', 'ремонта гнезд питания', 'ремонта разъемов питания', 'ремонта разъемов зарядки', 'ремонта гнезда питания',
					       'ремонта гнезда зарядки', 'ремонта WI-FI', 'ремонта WI-FI модулей', 'ремонта модулей WI-FI', 'ремонта плат WI-FI', 'ремонта WI-FI плат ', 'ремонта слотов', 'перепрошивки', 'ремонта крышки', 'ремонта антенны');

                $titles[0][] = array('замены материнских плат', 'замены плат', 'замены элементов плат', 'замены системных плат', 'замены мультиконтроллеров', 'замены контроллеров', 'замены контроллеров плат', 'замены ШИМ-контроллеров',
          					 'замены PWM-контроллеров', 'замены процессоров', 'замены чипов', 'перепайки цепей питания', 'перепайки цепей питания плат', 'перепайки чипов', 'перепайки BGA-чипов', 'перепайки кондесаторов плат', 'перепайки кондесаторов плат',
          					 'перепайки мультиконтроллеров', 'перепайки контроллеров', 'перепайки контроллеров плат', 'перепайки ШИМ-контроллеров', 'перепайки PWM-контроллеров', 'реболла чипов', 'реболла BGA-чипов');

                $titles[1][] = array('диагностики', 'чистки', 'замены камер', 'замены встроенных камер', 'замены корпусов', 'замены динамиков', 'замены разъемов', 'замены портов', 'замены шлейфов', 'замены симхолдеров', 'замены сим-лотков',
          					 'замены держателей сим', 'замены simholder', 'замены кнопок', 'замены кнопок включения', 'замены кнопок выключения', 'замены GPS', 'замены GPS-модулей', 'замены модулей GPS', 'замены плат GPS', 'замены GPS-плат ',
          					 'замены вибромоторов', 'замены вибро', 'замены вибромодулей', 'замены микрофонов', 'замены батарей', 'замены батареек', 'замены АКБ', 'замены аккумуляторов', 'замены аккумуляторных батарей', 'замены WI-FI', 'замены WI-FI модулей',
          					 'замены модулей WI-FI', 'замены плат WI-FI', 'замены WI-FI плат ', 'замены флеш памяти', 'замены слотов', 'замены прошивки', 'перепрошивки', 'замены памяти', 'увеличения памяти', 'замены крышки', 'замены деталей', 'замены антенны');

                $titles[1][] = array('ремонта материнских плат', 'ремонта плат', 'ремонта элементов плат', 'ремонта системных плат', 'ремонта мультиконтроллеров', 'ремонта контроллеров', 'ремонта контроллеров плат', 'ремонта ШИМ-контроллеров',
          					 'ремонта PWM-контроллеров', 'перепайки цепей питания', 'перепайки цепей питания плат', 'перепайки чипов', 'перепайки BGA-чипов', 'перепайки кондесаторов плат', 'перепайки кондесаторов плат', 'перепайки мультиконтроллеров',
          					 'перепайки контроллеров', 'перепайки контроллеров плат', 'перепайки ШИМ-контроллеров', 'перепайки PWM-контроллеров', 'реболла чипов', 'реболла BGA-чипов');
            }

            case 'n':
            {
                $titles[0][] = array('ремонта встроенных камер', 'ремонта корпусов', 'ремонта петель', 'ремонта динамиков', 'ремонта портов', 'ремонта шлейфов', 'ремонта разъемов', 'ремонта кулеров', 'ремонта вентиляторов', 'ремонта охлаждения',
	                         'ремонта систем охлаждения', 'ремонта жестких дисков', 'ремонта HDD/SSD', 'ремонта HDD/SSD накопителей', 'ремонта HDD/SSD дисков', 'ремонта клавиатуры', 'ремонта кнопок клавиатуры', 'ремонта микрофонов', 'ремонта гнезд питания',
					         'ремонта разъемов питания', 'ремонта разъемов зарядки', 'ремонта гнезд питания', 'ремонта гнезд зарядки', 'ремонта WI-FI', 'ремонта WI-FI модулей', 'ремонта модулей WI-FI', 'ремонта плат WI-FI', 'ремонта WI-FI плат ', 'ремонта HDMI разъемов',
					         'ремонта USB разъемов ', 'ремонта разъемов наушников ', 'ремонта аудио-разъемов ', 'ремонта vga разъемов ', 'ремонта lan разъемов ', 'ремонта разъемов ', 'ремонта звуковых карт', 'ремонта звуковых плат', 'ремонта ЗУ', 'ремонта БП',
					         'ремонта зарядных устройств', 'ремонта блоков питания', 'ремонта камер', 'ремонта встроенных камер', 'ремонта тачпадов', 'ремонта модулей тачпад', 'перепрошивки BIOS', 'перепрошивки БИОС', 'установки драйверов', 'установки программ',
					         'установки ПО', 'настройки ПО', 'настройки программ', 'восстановления жестких дисков', 'восстановления HDD/SSD', 'восстановления HDD/SSD накопителей', 'восстановления HDD/SSD дисков', 'увеличения памяти', 'диагностики', 'чистки', 'настройки драйверов');

                $titles[0][] = array('замены материнских плат', 'замены плат', 'замены элементов плат', 'замены системных плат', 'замены мультиконтроллеров', 'замены контроллеров', 'замены контроллеров плат', 'замены ШИМ-контроллеров',
          					 'замены PWM-контроллеров', 'замены процессоров', 'замены чипов', 'перепайки цепей питания', 'перепайки цепей питания плат', 'перепайки чипов', 'перепайки BGA-чипов', 'перепайки кондесаторов плат', 'перепайки кондесаторов плат',
          					 'перепайки мультиконтроллеров', 'перепайки контроллеров', 'перепайки контроллеров плат', 'перепайки ШИМ-контроллеров', 'перепайки PWM-контроллеров', 'реболла чипов', 'реболла BGA-чипов', 'замены мостов', 'замены южных мостов',
          					 'замены чипов южного моста', 'перепайки мостов', 'перепайки южных мостов', 'перепайки чипов южного моста', 'реболла мостов', 'реболла южных мостов', 'реболла чипов южного моста', 'замены видеокарт', 'перевайки видеочипов',
          					 'реболла видеочипов', 'апгрейда', 'upgrade', 'замены северных мостов', 'замены чипов южного моста', 'реболла северных мостов', 'реболла чипов южного моста', 'перепайки северных мостов', 'перепайки чипов южного моста');

                $titles[1][] = array('замены встроенных камер', 'замены корпусов', 'замены петель', 'замены динамиков', 'замены портов', 'замены шлейфов', 'замены разъемов', 'замены кулеров', 'замены вентиляторов', 'замены охлаждения',
          					 'замены систем охлаждения', 'замены жестких дисков', 'замены HDD/SSD', 'замены HDD/SSD накопителей', 'замены HDD/SSD дисков', 'замены клавиатуры', 'замены кнопок клавиатуры', 'замены микрофонов', 'замены гнезд питания',
          					 'замены разъемов питания', 'замены разъемов зарядки', 'замены гнезд питания', 'замены гнезд зарядки', 'замены WI-FI', 'замены WI-FI модулей', 'замены модулей WI-FI', 'замены плат WI-FI', 'замены WI-FI плат ',
          					 'замены HDMI разъемов ', 'замены USB разъемов ', 'замены разъемов наушников ', 'замены аудио-разъемов ', 'замены vga разъемов ', 'замены lan разъемов ', 'замены разъемов ', 'замены звуковых карт', 'замены звуковых плат',
          					 'замены ЗУ', 'замены БП', 'замены зарядных устройств', 'замены блоков питания', 'замены камер', 'замены встроенных камер', 'замены тачпадов', 'замены модулей тачпад', 'перепрошивки BIOS', 'перепрошивки БИОС',
          					 'установки драйверов', 'установки программ', 'установки ПО', 'настройки ПО', 'настройки программ', 'восстановления жестких дисков', 'восстановления HDD/SSD', 'восстановления HDD/SSD накопителей',
          					 'восстановления HDD/SSD дисков', 'увеличения памяти', 'диагностики', 'чистки', 'настройки драйверов', 'замены ОЗУ', 'замены памяти', 'замены ОЗУ памяти', 'замены шлейфов матрицы', 'замены АКБ',
          					 'замены батареи', 'замены аккумуляторов', 'замены аккумуляторных батарей');

                $titles[1][] = array('ремонта материнских плат', 'ремонта плат', 'ремонта элементов плат', 'ремонта системных плат', 'ремонта мультиконтроллеров', 'ремонта контроллеров', 'ремонта контроллеров плат',
          					 'ремонта ШИМ-контроллеров', 'ремонта PWM-контроллеров', 'ремонта процессоров', 'ремонта чипов', 'перепайки цепей питания', 'перепайки цепей питания плат', 'перепайки чипов', 'перепайки BGA-чипов',
          					 'перепайки кондесаторов плат', 'перепайки кондесаторов плат', 'перепайки мультиконтроллеров', 'перепайки контроллеров', 'перепайки контроллеров плат', 'перепайки ШИМ-контроллеров', 'перепайки PWM-контроллеров',
          					 'реболла чипов', 'реболла BGA-чипов', 'ремонта мостов', 'ремонта южных мостов', 'ремонта чипов южного моста', 'перепайки мостов', 'перепайки южных мостов', 'перепайки чипов южного моста', 'реболла мостов',
          					 'реболла южных мостов', 'реболла чипов южного моста', 'ремонта видеокарт', 'перевайки видеочипов', 'реболла видеочипов', 'апгрейда', 'upgrade', 'ремонта северных мостов', 'ремонта чипов южного моста',
          					 'реболла северных мостов', 'реболла чипов южного моста', 'перепайки северных мостов', 'перепайки чипов южного моста');
            }
        }

        if (isset($params['marka_id']) && isset($params['model_type_id']))
        {
            if (!isset($params['key']))
            {
                //Ремонт MacBook в Москве - REMONT CENTRE

                if ($marka_lower == 'apple')
                {
                     switch ($this->_suffics)
                     {
                        case 'f':
                            $add_str = 'iPhone';
                            $add_str2 = 'Айфонов';
                        break;
                        case 'p':
                            $add_str = 'iPad';
                            $add_str2 = 'Айпад';
                        break;
                        case 'n':
                            $add_str = 'MacBook';
                            $add_str2 = 'МакБук';
                        break;
                     }

                     $ret['title'] = array(
                            'Ремонт',
                            $add_str.' ('.$add_str2.')',
                            'в',
                            $city,
                            '—',
                            'REMONT CENTRE'
                    );

                    $ret['h1'] = array(
                            'Ремонт',
                            $add_str
                    );

                    $ret['description'] = array(
                            $this->_datas['marka']['name'],
                            $add_str.':',
                            'ремонт',
                            'в',
                            $city.'.',
                            $this->_datas['dop']
                    );

                }
                else
                {
                    $ret['title'] = array(
                            'Ремонт',
                            $this->_datas['model_type'][0]['name_rm'],
                            $this->_datas['marka']['name'].' ('.$this->_datas['marka']['ru_name'].')',
                            'в',
                            $city,
                            '—',
                            'REMONT CENTRE'
                    );

                    $ret['h1'] = array(
                            'Ремонт',
                            $this->_datas['model_type'][1]['name_rm'],
                            $this->_datas['marka']['name'],
                    );

                    $ret['description'] = array(
                            tools::mb_ucfirst($this->_datas['model_type'][2]['name_m']),
                            $this->_datas['marka']['name'].':',
                            'ремонт',
                            'в',
                            $city.'.',
                            $this->_datas['dop']
                    );
                }

                $file_name = 'model';
            }
            //else
            //{

            //}
        }

        $model_array = array('Apple Iphone 6', 'Apple Iphone 6S', 'Apple Iphone 6 Plus', 'Apple Iphone 6S Plus', 'Apple Iphone 7', 'Apple Iphone 7 Plus');

        if (isset($params['model_id']))
        {
            if (!isset($params['key']))
            {
                srand($feed);
                $t = array();

                $r = rand(0, 1);

                foreach ($titles[$r][0] as $val)
                    $t[0][] = 'от '.$val;

                foreach ($titles[$r][1] as $val)
                    $t[1][] = 'до '.$val;

                $ret['title'] = array(
                        'Ремонт',
                        $this->_datas['model_type'][0]['name_re'],
                        $this->_datas['model']['name'],
                        'в',
                        $city,
                        sc::_createTree($t, $feed)
                );

                $ret['h1'] =  array(
                        'Ремонт',
                        $this->_datas['model']['name']
                );

                $ret['description'] = array(
                    tools::mb_ucfirst($this->_datas['model_type'][2]['name']),
                    $this->_datas['model']['name'].':',
                    'сервисное обслуживание',
                    'в',
                    $city.'.',
                    $this->_datas['dop']
                );

                $file_name = 'model';
            }
            else
            {
                if ($params['key'] == "service")
                {
                    if (in_array($this->_datas['model']['name'], $model_array))
                    {
                        $short_model = str_replace('Apple ', '', $this->_datas['model']['name']);

                        $ret['title'] = array(
                            tools::mb_firstupper($this->_datas['syns'][0]),
                            $short_model,
                            'в',
                            $city.':',
                            implode(', ', rand_it::randMas(array('выезд курьера', 'цена'), 2, '', $feed)),
                        );

                        $ret['h1'] = array(
                            tools::mb_firstupper($this->_datas['syns'][1]),
                            $short_model,
                        );

                        $ret['description'] = array(
                            tools::mb_firstupper($this->_datas['syns'][2]),
                            $short_model,
                            'в',
                            $this->_datas['region']['pril'],
                            'сервисном центре',
                            'REMONT CENTRE:',
                            implode(', ', rand_it::randMas(array('цены', 'заказ выезда курьера'), 2, '', $feed)),
                        );
                    }
                    else
                    {
                        $ret['title'] = array(
                            tools::mb_firstupper($this->_datas['syns'][0]),
                            $this->_datas['model_type'][0]['name_re'],
                            $this->_datas['model']['name'],
                            'в',
                            $city,
                            '—',
                            'REMONT CENTRE'
                        );

                        $ret['h1'] = array(
                            tools::mb_firstupper($this->_datas['syns'][1]),
                            $this->_datas['model_type'][1]['name_re'],
                            $this->_datas['model']['name']
                        );

                        $ret['description'] = array(
                            tools::mb_ucfirst($this->_datas['model_type'][2]['name']),
                            $this->_datas['model']['name'].':',
                            'в',
                            $this->_datas['region']['pril'],
                            'сервисном центре.',
                            tools::mb_firstupper($this->_datas['syns'][2]).'.',
                            $this->_datas['dop']
                        );
                    }

                    $file_name = 'zamena-inner';
                }
            }
        }

        $this->_preims($params);

        foreach (array('h1', 'title', 'description') as $key)
            $ret[$key] =  implode(' ', $ret[$key]);

        $this->_ret = $this->_answer($answer, $ret);
        
        $this->_sdek();
        $body = $this->_body($file_name, basename(__FILE__, '.php'));

        //return array('title' => $this->_ret['title'], 'description' => $this->_ret['description'], 'body' => $body);
        return array('body' => $body);
    }

    private function _preims_icon(&$array, $icon)
    {
        foreach ($array[0] as $k => $v)
            $array[0][$k] = '<div class="col-sm-3 col-xs-6 item"><div class="reason-icon"><img src="/bitrix/templates/remont/images/shared/reason-'.$icon.'.svg"></div>' . $v;
    }

    private function _preims($params)
    {
        $f = $this->_datas['f'];
        $feed = $this->_datas['feed'];
        $diagnostic_time =  $this->_datas['diagnostic_time'];

        // preim
        $preim = array();
        $preims = array();

        srand($feed);

        //1
        $i = 0;

        if ((isset($params['marka_id']) && isset($params['model_type_id'])) || isset($params['model_id']))
        {
            $preim[$i][] = array('<div class="reason-link">Срочный ремонт</div>', '<div class="reason-link">Экспресс ремонт</div>', '<div class="reason-link">Оперативный ремонт</div>');

            $choose = rand(0, 1);

            switch ($choose)
            {
                case 0:
                    $preim[$i][] = array('<div class="reason-text">Ремонт', '<div class="reason-text">Ремонт и обслуживание', '<div class="reason-text">Обслуживание');

                    $t_array = array('устройств', 'техники', 'гаджетов');
                    foreach ($this->_datas['orig_model_type'] as $type)
                        $t_array[] = $type['name_rm'];

                    $preim[$i][] = $t_array;

                break;
                case 1:
                    $preim[$i][] = array('<div class="reason-text">Отремонтируем', '<div class="reason-text">Починим');

                    $t_array = array('ваше устройство', 'вашу технику', 'ваш гаджет');
                    foreach ($this->_datas['orig_model_type'] as $type)
                        $t_array[] = 'ваш '.$type['name'];

                    $preim[$i][] = $t_array;

                break;
            }

            if (isset($params['model_id']))
                $preim[$i][] = array($this->_datas['model']['name']);
            else
                $preim[$i][] = array($this->_datas['marka']['name'], $this->_datas['marka']['ru_name']);

            $preim[$i][] = array('с типовыми проблемами', 'с типовыми неисправностями', 'с типовыми поломками', 'со стандартными проблемами',
                        'со стандартными неисправностями', 'со стандартными поломками');

            $preim[$i][] = array('- в течении 24 часов</div></div>', '- в течении суток</div></div>', '- в течении 1 суток</div></div>', '- в течении одних суток</div></div>',
                        '- в пределах 24 часов</div></div>', '- в пределах суток</div></div>', '- в пределах 1 суток</div></div>', '- в пределах одних суток</div></div>',
                        '- за 24 часа и быстрее</div></div>', '- за сутки или быстрее</div></div>');

            $this->_preims_icon($preim[$i], 1);

            $i++;
        }

        //2
        $preim[$i][] = array('<div class="reason-link">Экспресс диагностика</div>', '<div class="reason-link">Быстрая диагностика</div>', '<div class="reason-link">Бесплантная диагностика</div>');

        $choose = rand(0, 2);

        $t1 = array('<div class="reason-text">Бесплатное выявление', '<div class="reason-text">Бесплатное нахождение', '<div class="reason-text">Бесплатное обнаружение',
            '<div class="reason-text">Бесплатное определение', '<div class="reason-text">Бесплатный поиск');
        $t2 = array('<div class="reason-text">Быстрое выявление', '<div class="reason-text">Быстрое нахождение', '<div class="reason-text">Быстрое обнаружение',
            '<div class="reason-text">Быстрое определение', '<div class="reason-text">Быстрый поиск', '<div class="reason-text">Оперативное выявление',
                 '<div class="reason-text">Оперативное нахождение', '<div class="reason-text">Оперативное обнаружение', '<div class="reason-text">Оперативное определение',
                 '<div class="reason-text">Оперативный поиск');

        switch ($choose)
        {
            case 0:
                $preim[$i][] = array_merge($t1, $t2);
            break;
            case 1:
                $preim[$i][] = $t1;
            break;
            case 2:
                $preim[$i][] = $t2;
            break;
        }

        $preim[$i][] = array('аппаратных', 'программных', 'аппаратных и программных', 'программных и аппаратных');
        $preim[$i][] = array('неисправностей ', 'ошибок', 'проблем');
        $preim[$i][] = array('на стенде '.$this->_datas['marka']['name'], 'на спецстенде '.$this->_datas['marka']['name'],
                'на специализированном стенде',
            'на специализированном оборудовании', 'на фирменном стенде', 'на фирменном оборудовании', 'с помощью специализированного стенда',
            'с помощью специализированного оборудования', 'с помощью фирменного стенда ', 'с помощью фирменного стенда '.$this->_datas['marka']['name'],
            'с помощью фирменного оборудования');

        $preim[$i][] = array('- в течении '.$diagnostic_time.' минут</div></div>', '- за '.$diagnostic_time.' минут</div></div>',
            '- в среднем за '.$diagnostic_time.' минут</div></div>', '~ '.$diagnostic_time.' минут</div></div>', '- в пределах '.$diagnostic_time.' минут</div></div>');

        $this->_preims_icon($preim[$i], 2);

        $i++;

        //3

        $preim[$i][] = array('<div class="reason-link">Выезд и доставка</div>', '<div class="reason-link">Выезд на дом/в офис</div>',
            '<div class="reason-link">Выезд курьера</div>');

        $preim[$i][] = array('<div class="reason-text">Бесплатный выезд', '<div class="reason-text">Оперативный выезд', '<div class="reason-text">Срочный выезд',
                '<div class="reason-text">Оперативное прибытие', '<div class="reason-text">Срочное прибытие', '<div class="reason-text">Срочный приезд',
                '<div class="reason-text">Бесплатный приезд', '<div class="reason-text">Оперативный приезд');

        $preim[$i][] = array('курьера');
        $preim[$i][] = array('к вам', '');
        $preim[$i][] = array('на дом или в офис', 'на дом или в офис компании', 'в офис компании или на дом', 'в офис или на дом',
                'на дом/в офис', 'на дом/в офис компании', 'в офис компании/на дом', 'в офис/на дом');

        srand($f);

        $choose = rand(0, 1);

        switch ($choose)
        {
            case 0:
                $preim[$i][] = array('- в течении 30 минут</div></div>', '- в течении получаса</div></div>', '- в пределах 30 минут</div></div>',
                        '- в пределах получаса</div></div>', '- за 30 минут</div></div>', '- за полчаса</div></div>', '~ 30 минут</div></div>');
            break;
            case 1:
                $preim[$i][] = array('- в течении 60 минут</div></div>', '- в течении одного часа</div></div>', '- в течении 1 часа</div></div>',
                    '- в пределах 60 минут</div></div>', '- в пределах 1 часа</div></div>',
                    '- в пределах одного часа</div></div>', '- в пределах 30-60 минут</div></div>', '- за 30-60 минут</div></div>');
            break;
       }

       srand($feed);

       $this->_preims_icon($preim[$i], 3);

       $i++;

        //4
        $choose = rand(0, 4);

        switch ($choose)
        {
            case 0:
                $preim[$i][] = array('<div class="reason-link">Запчасти Original</div>');
            break;
            case 1:
                $preim[$i][] = array('<div class="reason-link">Оригинальные запчасти</div>');
            break;
            case 2:
                $preim[$i][] = array('<div class="reason-link">Original запчасти</div>');
            break;
            case 3:
                $preim[$i][] = array('<div class="reason-link">Оригинальные комплектующие</div>');
            break;
            case 4:
                $preim[$i][] = array('<div class="reason-link">Original комплектующие</div>');
            break;
        }

        $preim[$i][] = array('<div class="reason-text">В работе используем', '<div class="reason-text">При ремонте используем', '<div class="reason-text">Мы используем');
        $preim[$i][] = array('только', 'исключительно', 'все', '');
        $preim[$i][] = array('фирменные', 'брендовые');
        //$preim[$i][] = array('комплектующие', 'запасные части', 'запчасти');

        $t_array = array('комплектующие', 'запасные части', 'запчасти');

        if ($choose == 3 || $choose == 4) unset($t_array[0]);
        if ($choose == 0 || $choose == 1 || $choose == 2) unset($t_array[2]);

        $preim[$i][] = array_values($t_array);

        //$preim[$i][] = array('от');
        $preim[$i][] = array($this->_datas['marka']['name'].'</div></div>', $this->_datas['marka']['ru_name'].'</div></div>');

        $this->_preims_icon($preim[$i], 4);

        $i++;


       //5

       $preim[$i][] = array('<div class="reason-link">Фиксированные цены</div>', '<div class="reason-link">Фиксированная стоимость</div>');

       $choose = rand(0, 3);

       switch ($choose)
       {
            case 0:
                $preim[$i][] = array('<div class="reason-text">Цены на все работы', '<div class="reason-text">Цены на работы');
                $preim[$i][] = array('специалистов', 'сотрудников', 'мастеров', 'инженеров');
                $preim[$i][] = array('центра', 'сервисного центра', 'сервис-центра', '');
            break;
            case 1:
                $preim[$i][] = array('<div class="reason-text">Цены на все услуги', '<div class="reason-text">Цены на услуги');
                $preim[$i][] = array('центра', 'сервисного центра', 'сервис-центра');
            break;
            case 2:
                $preim[$i][] = array('<div class="reason-text">Стоимость работы');
                $preim[$i][] = array('специалистов', 'мастеров', 'инженеров');
                $preim[$i][] = array('центра', 'сервисного центра', 'сервис-центра', '');
            break;
            case 3:
                $preim[$i][] = array('<div class="reason-text">Стоимость услуг');
                $preim[$i][] = array('центра', 'сервисного центра', 'сервис-центра');
            break;
       }

       $preim[$i][] = array($this->_datas['marka']['name'], $this->_datas['marka']['ru_name']);

       if ($choose == 0 || $choose == 1)
       {
           $preim[$i][] = array('регламентированы прайс-листом</div></div>', 'зафиксированы в прайс-листе</div></div>', 'определены прайс-листом</div></div>',
                    'прописаны в прайс-листе</div></div>', 'регламентированы прейскурантом</div></div>', 'зафиксированы в прейскуранте</div></div>',
                    'определены прейскурантом</div></div>', 'прописаны в прейскуранте</div></div>');
       }

       if ($choose == 2 || $choose == 3)
       {
            $preim[$i][] = array('регламентирована прайс-листом</div></div>', 'зафиксирована в прайс-листе</div></div>', 'определена прайс-листом</div></div>',
                    'прописана в прайс-листе</div></div>', 'регламентирована прейскурантом</div></div>', 'зафиксирована в прейскуранте</div></div>',
                    'определена прейскурантом</div></div>', 'прописана в прейскуранте</div></div>');
       }

       $this->_preims_icon($preim[$i], 5);

       $i++;

       //6
    
    if(empty($this->_datas['original_setka_id']) || $this->_datas['original_setka_id'] !=20){
       $preim[$i][] = array('<div class="reason-link">Лучшее оборудование</div>', '<div class="reason-link">Современное оборудование</div>',
                '<div class="reason-link">Фирменное оборудование</div>');

       $preim[$i][] = array('<div class="reason-text">Работаем на', '<div class="reason-text">Работа проводится на',
            '<div class="reason-text">Ремонт проводится на', '<div class="reason-text">Работа провоизводится на',
            '<div class="reason-text">Ремонт производится на', '<div class="reason-text">Ремонтируем на');

       $preim[$i][] = array('профессиональных', 'высокопрофессиональных', 'специализированных', 'новейших', 'оригинальных');
       $preim[$i][] = array('инфракрасных', 'ИК', 'термовоздушных и инфракрасных', 'инфракрасных и термовоздушных');
       $preim[$i][] = array('станциях', 'паяльных станциях', 'ремонтных системах', 'ремонтных станциях', 'паяльных системах', 'паяльных комплексах',
                'ремонтных комплексах', 'паяльно-ремонтных комплексах', 'паяльно-ремонтных системах', 'паяльно-ремонтных центрах', 'паяльно-ремонтных станциях',
                'станциях с разноуровневым нагревом', 'станциях для монтажа BGA элементов', 'станциях для монтажа BGA компонент',
                'станциях для монтажа BGA чипов', 'станциях для установки BGA компонент', 'станциях для установки BGA элементов', 'станциях для установки BGA чипов',
                'станциях для ребола BGA элементов', 'станциях для ребола BGA компонент', 'станциях для ребола BGA чипов');

        $t1 = array('Weller WQB4000 SOPS', 'HAKKO FX-952 ESD', 'HT-R392 BGA', 'SEAMARK ZM-R5860', 'ERSA IR550A PLUS', 'ERSA HR100AHP', 'ERSA PCBXY', 'HAKKO 702B', 'QUICK 9234', 'Jovy Systems RE-8500',
                'Jovy Systems Jetronix-Eco', 'ATTEN AT8235', 'Jovy Systems Turbo IR', 'HR200-HP');

        $t2 = array('Lukey 936A', 'Lukey 868', 'QUICK 713 ESD', 'QUICK 856AX ESD', 'ProsKit SS-989B', 'Goot XFC-300', 'BAKU BK-702B', 'BAKU BK-601D', 'BAKU BK-878', 'Accta 301', 'ATTEN AT860D',
                'ATTEN AT8502D', 'AOYUE 2703A++', 'AOYUE 6031 Sirocco', 'AOYUE 2702 с ', 'AOYUE 768');

        $t = array();

        foreach ($t1 as $t1_value)
        {
            foreach ($t2 as $t2_value)
            {
                $t[] = $t1_value.', '.$t2_value.'</div></div>';
                $t[] = $t1_value.' и '.$t2_value.'</div></div>';
            }
        }

        $preim[$i][] = $t;

        $this->_preims_icon($preim[$i], 6);
    }
        $i++;

        //7
        if ((isset($params['marka_id']) && isset($params['model_type_id'])) || isset($params['model_id']))
        {
            $preim[$i][] = array('<div class="reason-link">Лучшие сроки ремонта</div>', '<div class="reason-link">Сроки ремонта</div>',
                    '<div class="reason-link">Сжатые сроки ремонт</div>', '<div class="reason-link">Кратчайшие сроки ремонта</div>');

            $preim[$i][] = array('<div class="reason-text">Среднее время');
            $preim[$i][] = array('ремонта');

            if (isset($params['model_id']))
                $preim[$i][] = array($this->_datas['model']['name']);
            else
            {
                $t = array();
                $t1 = array($this->_datas['marka']['name'], $this->_datas['marka']['ru_name']);

                foreach ($this->_datas['orig_model_type'] as $type)
                    foreach ($t1 as $value)
                        $t[] = $type['name_re'].' '.$value;

                $preim[$i][] = $t;
            }

            $preim[$i][] = array('по нашей статистике ', 'по нашим данным', 'в нашем сервисе', 'в нашем сервисном центре', 'в нашем сервис-центре', 'в нашем центре');
            $preim[$i][] = array('- не превышает', '- около');
            $preim[$i][] = array('одного часа</div></div>', '1 часа</div></div>', '1,5 часов</div></div>', '2 часов</div></div>', 'двух часов</div></div>',
                '2,5 часов</div></div>', '3 часов</div></div>', 'трех часов</div></div>', '3,5 часов</div></div>');

            $this->_preims_icon($preim[$i], 7);
        }

        $preims = rand_it::randMas($preim, 4, '', $feed);
        $this->_datas['preims'] = '';

        foreach ($preims as $var)
            $this->_datas['preims'] .= sc::_createTree($var, $feed);
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
                $this->_datas['zoom'] = 12;
            }
        }
        return;
        
        $this->_datas['sdek'] = false;
        if ($this->_datas['partner']['email'] == 'litovchenko@list.ru')
        {
            $this->_datas['phone'] = '78007076513';
            $this->_datas['partner']['exclude'] = 1;  
            $this->_datas['partner']['time']  = 'Пн-Вс: с 10-00 до 20-00';
            $this->_datas['sdek'] = true; 
        } 
    }
    
    private function _make_accord_table($marka_lower)
    {
        $urls = array(
            'acer' => array('remont-monoblokov-acer', 'remont-monitorov-acer', 'remont-headphones-acer','remont-proektorov-acer', 'remont-computerov-acer'),
            'apple' => array('remont-smartwatchs-apple', 'remont-monoblokov-apple', 'remont-monitorov-apple', 'remont-computerov-apple'),
            'asus' => array('remont-smartwatchs-asus', 'remont-monoblokov-asus', 'remont-monitorov-asus','remont-proektorov-asus', 'remont-computerov-asus'),
            'canon' => array('remont-foto-canon', 'remont-video-canon', 'remont-printerov-canon','remont-proektorov-canon'),
            'dell' => array('remont-monoblokov-dell', 'remont-monitorov-dell', 'remont-headphones-dell', 'remont-serverov-dell','remont-proektorov-dell', 'remont-computerov-dell'),
            'hp' => array('remont-smartwatchs-hp', 'remont-monoblokov-hp', 'remont-monitorov-hp', 'remont-printerov-hp', 'remont-headphones-hp', 'remont-serverov-hp', 'remont-routers-hp', 'remont-computerov-hp'),
            
            'htc' => array('remont-headphones-htc', 'remont-vive-htc'),
            'huawei' => array('remont-notebooks-huawei', 'remont-smartwatchs-huawei', 'remont-headphones-huawei', 'remont-routers-huawei','remont-serverov-huawei',),
            'lenovo' => array('remont-monoblokov-lenovo', 'remont-monitorov-lenovo', 'remont-serverov-lenovo','remont-proektorov-lenovo', 'remont-computerov-lenovo'),
            'lg' => array('remont-monitorov-lg', 'remont-televizorov-lg', 'remont-headphones-lg','remont-proektorov-lg', 'remont-computerov-lg'),
            'meizu' => array('remont-smartwatchs-meizu', 'remont-headphones-meizu'),
            'msi' => array('remont-monoblokov-msi', 'remont-monitorov-msi', 'remont-headphones-msi', 'remont-routers-msi', 'remont-computerov-msi'),
            
            'nikon' => array('remont-foto-nikon', 'remont-video-nikon', 'remont-lens-nikon'),
            'nokia' => array('remont-smartwatchs-nokia', 'remont-headphones-nokia'),
            'samsung' => array('remont-smartwatchs-samsung', 'remont-monitorov-samsung', 'remont-televizorov-samsung', 'remont-printerov-samsung', 'remont-headphones-samsung', 'remont-vive-samsung', 'remont-foto-samsung','remont-proektorov-samsung', 'remont-computerov-samsung'),
            'sony' => array('remont-smartwatchs-sony', 'remont-televizorov-sony', 'remont-foto-sony', 'remont-video-sony', 'remont-headphones-sony', 'remont-vive-sony', 'remont-computerov-sony'),
            'toshiba' => array('remont-televizorov-toshiba', 'remont-printerov-toshiba','remont-proektorov-toshiba'),
            'xiaomi' => array('remont-notebooks-xiaomi', 'remont-smartwatchs-xiaomi', 'remont-televizorov-xiaomi', 'remont-headphones-xiaomi', 'remont-routers-xiaomi', 'remont-vive-xiaomi', 'remont-pristavok-xiaomi', 'remont-foto-xiaomi','remont-proektorov-xiaomi'),
            'zte' => array('remont-routers-zte'),
            'panasonic' => array('remont-foto-panasonic','remont-proektorov-panasonic'),
            'sigma' => array('remont-foto-sigma'),
            'fujifilm' => array('remont-foto-fujifilm'),
            'polaroid' => array('remont-foto-polaroid'),
            'olympus' => array('remont-foto-olympus'),
            'leica' => array('remont-foto-leica'),
            'hasselblad' => array('remont-foto-hasselblad'),
            
            'cisco' => array('remont-serverov'),
            'ibm' => array('remont-serverov'),
            'oracle' => array('remont-serverov'),
            'intel' => array('remont-serverov'),
            'inspur' => array('remont-serverov'),
            'supermicro' => array('remont-serverov'),
            'nec' => array('remont-serverov'),
            'infocus' => array('remont-proektorov-infocus'),
            'optoma' => array('remont-proektorov-optoma'),
            'iconbit' => array('remont-hoverboard','remont-elektrosamokatov'),
            'airwheel' => array('remont-hoverboard','remont-elektrosamokatov', 'remont-monokoles','remont-segway'),
            'globber' => array('remont-elektrosamokatov'),
            'halten' => array('remont-elektrosamokatov'),
            'hiper' => array('remont-elektrosamokatov','remont-proektorov'),
            'hoverbot' => array('remont-elektrosamokatov','remont-monokoles','remont-hoverboard','remont-segway'),
            'inmotion' => array('remont-elektrosamokatov','remont-monokoles','remont-hoverboard','remont-segway'),
            'kingsong' => array('remont-elektrosamokatov','remont-monokoles'),
            'kugoo' => array('remont-elektrosamokatov'),
            'ninebot' => array('remont-hoverboard', 'remont-monokoles', 'remont-elektrosamokatov','remont-segway'),
            'polaris' => array('remont-hoverboard', 'remont-elektrosamokatov'),
            'razor' => array('remont-hoverboard', 'remont-elektrosamokatov'),
            'zaxboard' => array('remont-hoverboard', 'remont-elektrosamokatov','remont-segway'),
        );
        
        if (!empty($this->_datas['original_setka_id']) && $this->_datas['original_setka_id'] == 20) {
            // $urls['ardo'] = array('remont-holodilnikov','remont-stiralnyh-mashin','remont-posudomoechnyh-mashin');
            // $urls['ariston'] = array('remont-holodilnikov','remont-stiralnyh-mashin','remont-posudomoechnyh-mashin');
            // $urls['aeg'] = array('remont-holodilnikov','remont-stiralnyh-mashin','remont-posudomoechnyh-mashin');
            // $urls['atlant'] = array('remont-holodilnikov','remont-stiralnyh-mashin');
            // $urls['beko'] = array('remont-holodilnikov','remont-stiralnyh-mashin','remont-posudomoechnyh-mashin');
            // $urls['bosch'] = array('remont-holodilnikov','remont-stiralnyh-mashin','remont-posudomoechnyh-mashin');
            // $urls['candy'] = array('remont-holodilnikov','remont-stiralnyh-mashin','remont-posudomoechnyh-mashin');
            // $urls['electrolux'] = array('remont-holodilnikov','remont-stiralnyh-mashin','remont-posudomoechnyh-mashin');
            // $urls['haier'] = array('remont-holodilnikov','remont-stiralnyh-mashin','remont-posudomoechnyh-mashin');
            // $urls['hansa'] = array('remont-holodilnikov','remont-stiralnyh-mashin','remont-posudomoechnyh-mashin');
            // $urls['indesit'] = array('remont-holodilnikov','remont-stiralnyh-mashin','remont-posudomoechnyh-mashin');
            // $urls['kuppersberg'] = array('remont-holodilnikov','remont-stiralnyh-mashin','remont-posudomoechnyh-mashin');
            // $urls['liebherr'] = array('remont-holodilnikov');
            // $urls['miele'] = array('remont-holodilnikov','remont-stiralnyh-mashin','remont-posudomoechnyh-mashin');
            // $urls['neff'] = array('remont-holodilnikov','remont-stiralnyh-mashin','remont-posudomoechnyh-mashin');
            // $urls['siemens'] = array('remont-holodilnikov','remont-stiralnyh-mashin','remont-posudomoechnyh-mashin');
            // $urls['whirlpool'] = array('remont-holodilnikov','remont-stiralnyh-mashin','remont-posudomoechnyh-mashin');
            // $urls['zanussi'] = array('remont-holodilnikov','remont-stiralnyh-mashin','remont-posudomoechnyh-mashin');
            $urls['aeg'] = array('remont-stiralnyh-mashin','remont-holodilnikov','remont-duhovih-shkafov','remont-posudomoechnyh-mashin','remont-varochnih-paneley','remont-pylesosov','remont-elektricheskih-plit','remont-vodonagrevateley','remont-kofemashin','remont-mikrovolnovih-pechey','remont-vytyazhk');
            $urls['ardo'] = array('remont-stiralnyh-mashin','remont-holodilnikov','remont-duhovih-shkafov','remont-elektricheskih-plit','remont-posudomoechnyh-mashin');
            $urls['ariston'] = array('remont-posudomoechnyh-mashin','remont-stiralnyh-mashin','remont-holodilnikov','remont-vodonagrevateley','remont-duhovih-shkafov','remont-elektricheskih-plit','remont-varochnih-paneley');
            $urls['atlant'] = array('remont-holodilnikov','remont-stiralnyh-mashin');
            $urls['beko'] = array('remont-stiralnyh-mashin','remont-holodilnikov','remont-posudomoechnyh-mashin','remont-elektricheskih-plit','remont-duhovih-shkafov','remont-varochnih-paneley','remont-mikrovolnovih-pechey');
            $urls['bosch'] = array('remont-posudomoechnyh-mashin','remont-stiralnyh-mashin','remont-holodilnikov','remont-pylesosov','remont-duhovih-shkafov','remont-kofemashin','remont-varochnih-paneley','remont-vytyazhk','remont-mikrovolnovih-pechey','remont-elektricheskih-plit','remont-robotov-pylesosov','remont-vodonagrevateley');
            $urls['candy'] = array('remont-stiralnyh-mashin','remont-posudomoechnyh-mashin','remont-holodilnikov','remont-mikrovolnovih-pechey','remont-duhovih-shkafov','remont-varochnih-paneley','remont-kondicionerov','remont-vytyazhk','remont-elektricheskih-plit');
            $urls['electrolux'] = array('remont-posudomoechnyh-mashin','remont-stiralnyh-mashin','remont-duhovih-shkafov','remont-vodonagrevateley','remont-pylesosov','remont-varochnih-paneley','remont-kondicionerov','remont-holodilnikov','remont-vytyazhk','remont-elektricheskih-plit','remont-mikrovolnovih-pechey','remont-robotov-pylesosov','remont-kofemashin');
            $urls['haier'] = array('remont-holodilnikov','remont-stiralnyh-mashin','remont-vytyazhk','remont-mikrovolnovih-pechey','remont-kondicionerov','remont-posudomoechnyh-mashin','remont-duhovih-shkafov','remont-vodonagrevateley','remont-varochnih-paneley','remont-elektricheskih-plit','remont-robotov-pylesosov');
            $urls['hansa'] = array('remont-holodilnikov','remont-posudomoechnyh-mashin','remont-duhovih-shkafov','remont-stiralnyh-mashin','remont-varochnih-paneley','remont-elektricheskih-plit','remont-vytyazhk','remont-mikrovolnovih-pechey');
            $urls['indesit'] = array('remont-stiralnyh-mashin','remont-holodilnikov','remont-posudomoechnyh-mashin','remont-elektricheskih-plit','remont-duhovih-shkafov','remont-varochnih-paneley');
            $urls['kuppersberg'] = array('remont-holodilnikov','remont-stiralnyh-mashin','remont-varochnih-paneley','remont-posudomoechnyh-mashin','remont-duhovih-shkafov','remont-vytyazhk','remont-mikrovolnovih-pechey');
            $urls['liebherr'] = array('remont-holodilnikov','remont-stiralnyh-mashin');
            $urls['miele'] = array('remont-stiralnyh-mashin','remont-holodilnikov','remont-posudomoechnyh-mashin','remont-pylesosov','remont-robotov-pylesosov','remont-kofemashin','remont-duhovih-shkafov','remont-varochnih-paneley','remont-vytyazhk','remont-mikrovolnovih-pechey');
            $urls['neff'] = array('remont-holodilnikov','remont-posudomoechnyh-mashin','remont-stiralnyh-mashin','remont-duhovih-shkafov','remont-varochnih-paneley','remont-vytyazhk','remont-kofemashin','remont-mikrovolnovih-pechey');
            $urls['siemens'] = array('remont-holodilnikov','remont-stiralnyh-mashin','remont-posudomoechnyh-mashin','remont-kofemashin','remont-duhovih-shkafov','remont-varochnih-paneley','remont-vytyazhk','remont-mikrovolnovih-pechey','remont-pylesosov','remont-elektricheskih-plit');
            $urls['whirlpool'] = array('remont-stiralnyh-mashin','remont-holodilnikov','remont-posudomoechnyh-mashin','remont-mikrovolnovih-pechey','remont-duhovih-shkafov','remont-varochnih-paneley','remont-elektricheskih-plit','remont-vytyazhk','remont-kondicionerov');
            $urls['zanussi'] = array('remont-stiralnyh-mashin','remont-holodilnikov','remont-posudomoechnyh-mashin','remont-duhovih-shkafov','remont-kondicionerov','remont-vodonagrevateley','remont-pylesosov','remont-varochnih-paneley','remont-elektricheskih-plit');
            
            $urls['delonghi'] = array('remont-duhovih-shkafov','remont-varochnih-paneley','remont-posudomoechnyh-mashin','remont-pylesosov','remont-vytyazhk','remont-kofemashin','remont-mikrovolnovih-pechey');
            $urls['fujitsu'] = array('remont-kondicionerov');
            $urls['ginzzu'] = array('remont-posudomoechnyh-mashin','remont-holodilnikov','remont-varochnih-paneley','remont-pylesosov');
            $urls['bauknecht'] = array('remont-stiralnyh-mashin','remont-holodilnikov','remont-posudomoechnyh-mashin');
            $urls['nintendo'] = array('remont-pylesosov','remont-robotov-pylesosov');
            $urls['pioneer'] = array('remont-kondicionerov');
            $urls['polaris'] = array('remont-pylesosov','remont-kofemashin','remont-vodonagrevateley','remont-mikrovolnovih-pechey','remont-robotov-pylesosov');
            $urls['roland'] = array('remont-kondicionerov');
            $urls['tefal'] = array('remont-robotov-pylesosov','remont-pylesosov');
            $urls['thomson'] = array('remont-pylesosov');
            $urls['vestfrost'] = array('remont-stiralnyh-mashin','remont-holodilnikov','remont-morozilnih-kamer','remont-duhovih-shkafov');
            $urls['kuppersbusch'] = array('remont-duhovih-shkafov','remont-varochnih-paneley','remont-vytyazhk','remont-posudomoechnyh-mashin','remont-stiralnyh-mashin','remont-holodilnikov');
            $urls['bork'] = array('remont-stiralnyh-mashin','remont-holodilnikov','remont-pylesosov','remont-mikrovolnovih-pechey','remont-hlebopechkek','remont-robotov-pylesosov','remont-kofemashin','remont-stiralnyh-mashin','remont-massazhnih-kresel');
            $urls['gaggenau'] = array('remont-duhovih-shkafov','remont-holodilnikov','remont-varochnih-paneley');
            $urls['gorenje'] = array('remont-duhovih-shkafov','remont-elektricheskih-plit','remont-mikrovolnovih-pechey','remont-stiralnyh-mashin','remont-holodilnikov','remont-varochnih-paneley','remont-posudomoechnyh-mashin','remont-vytyazhk','remont-hlebopechkek','remont-pylesosov','remont-vodonagrevateley');
            $urls['hitachi'] = array('remont-holodilnikov','remont-kondicionerov','remont-pylesosov');
            $urls['jura'] = array('remont-kofemashin');
            $urls['korting'] = array('remont-posudomoechnyh-mashin','remont-holodilnikov','remont-stiralnyh-mashin','remont-duhovih-shkafov','remont-varochnih-paneley','remont-vytyazhk','remont-mikrovolnovih-pechey');
            $urls['lg'] = array('remont-stiralnyh-mashin','remont-holodilnikov','remont-pylesosov','remont-varochnih-paneley','remont-mikrovolnovih-pechey','remont-kondicionerov','remont-robotov-pylesosov','remont-hlebopechkek','remont-posudomoechnyh-mashin','remont-duhovih-shkafov');
            $urls['maunfeld'] = array('remont-holodilnikov','remont-posudomoechnyh-mashin','remont-varochnih-paneley','remont-vytyazhk','remont-duhovih-shkafov','remont-mikrovolnovih-pechey');
            $urls['midea'] = array('remont-posudomoechnyh-mashin','remont-holodilnikov','remont-stiralnyh-mashin','remont-robotov-pylesosov','remont-kondicionerov','remont-mikrovolnovih-pechey','remont-pylesosov','remont-duhovih-shkafov','remont-varochnih-paneley','remont-hlebopechkek','remont-vytyazhk');
            $urls['panasonic'] = array('remont-holodilnikov','remont-mikrovolnovih-pechey','remont-kondicionerov','remont-pylesosov','remont-kofemashin','remont-hlebopechkek','remont-massazhnih-kresel');
            $urls['philips'] = array('remont-kofemashin','remont-pylesosov','remont-robotov-pylesosov','remont-hlebopechkek','remont-mikrovolnovih-pechey');
            $urls['saeco'] = array('remont-kofemashin');
            $urls['samsung'] = array('remont-stiralnyh-mashin','remont-mikrovolnovih-pechey','remont-holodilnikov','remont-pylesosov','remont-robotov-pylesosov','remont-duhovih-shkafov','remont-kondicionerov','remont-posudomoechnyh-mashin','remont-varochnih-paneley','remont-vytyazhk');
            $urls['sharp'] = array('remont-holodilnikov','remont-stiralnyh-mashin','remont-mikrovolnovih-pechey');
            $urls['smeg'] = array('remont-holodilnikov','remont-posudomoechnyh-mashin','remont-duhovih-shkafov','remont-stiralnyh-mashin','remont-vytyazhk','remont-varochnih-paneley','remont-kofemashin','remont-mikrovolnovih-pechey','remont-elektricheskih-plit');
            $urls['toshiba'] = array('remont-holodilnikov','remont-kondicionerov');
            $urls['weissgauff'] = array('remont-stiralnyh-mashin','remont-posudomoechnyh-mashin','remont-holodilnikov','remont-duhovih-shkafov','remont-varochnih-paneley','remont-vytyazhk','remont-elektricheskih-plit','remont-mikrovolnovih-pechey','remont-pylesosov','remont-robotov-pylesosov');
            $urls['xiaomi'] = array('remont-stiralnyh-mashin','remont-holodilnikov','remont-pylesosov','remont-robotov-pylesosov','remont-kondicionerov','remont-mikrovolnovih-pechey','remont-kofemashin','remont-posudomoechnyh-mashin','remont-vytyazhk','remont-massazhnih-kresel','remont-duhovih-shkafov','remont-vodonagrevateley');
            $urls['kaiser'] = array('remont-stiralnyh-mashin','remont-holodilnikov','remont-mikrovolnovih-pechey','remont-posudomoechnyh-mashin','remont-vytyazhk','remont-duhovih-shkafov','remont-varochnih-paneley','remont-elektricheskih-plit');
            $urls['daewoo']= array('remont-stiralnyh-mashin','remont-holodilnikov','remont-mikrovolnovih-pechey','remont-posudomoechnyh-mashin','remont-pylesosov','remont-morozilnih-kamer');
            
        }

        $this->_datas['add_device_type'] = $add_device_type = array(
            'remont-foto' => array('type' => 'фотоаппарат', 'type_rm' => 'фотоаппаратов', 'type_m' => 'фотоаппараты', 'type_de' => 'фотоаппаратом', 'type_re' => 'фотоаппарата'),
            'remont-smartwatchs' => array('type' => 'смарт-часы', 'type_rm' => 'смарт-часов', 'type_m' => 'смарт-часы', 'type_de' => 'смарт-часами', 'type_re' => 'смарт-часов'),
            'remont-monoblokov' => array('type' => 'моноблок', 'type_rm' => 'моноблоков', 'type_m' => 'моноблоки', 'type_de' => 'моноблоком', 'type_re' => 'моноблока'),
            'remont-monitorov' => array('type' => 'монитор', 'type_rm' => 'мониторов', 'type_m' => 'мониторы', 'type_de' => 'монитором', 'type_re' => 'монитора'),
            'remont-televizorov' => array('type' => 'телевизор', 'type_rm' => 'телевизоров', 'type_m' => 'телевизоры', 'type_de' => 'телевизором', 'type_re' => 'телевизора'),
            'remont-video' => array('type' => 'видеокамера', 'type_rm' => 'видеокамер', 'type_m' => 'видеокамеры', 'type_de' => 'видеокамерой', 'type_re' => 'видеокамеры'),
            'remont-printerov' => array('type' => 'принтер', 'type_rm' => 'принтеров', 'type_m' => 'принтеры', 'type_de' => 'принтером', 'type_re' => 'принтера'),
            'remont-headphones' => array('type' => 'наушники', 'type_rm' => 'наушников', 'type_m' => 'наушники', 'type_de' => 'наушниками', 'type_re' => 'наушников'),
            'remont-serverov' => array('type' => 'сервер', 'type_rm' => 'серверов', 'type_m' => 'сервера', 'type_de' => 'сервером', 'type_re' => 'сервера'),
            'remont-routers' => array('type' => 'роутер', 'type_rm' => 'роутеров', 'type_m' => 'роутеры', 'type_de' => 'роутером', 'type_re' => 'роутера'),
            'remont-vive' => array('type' => 'Vive', 'type_rm' => 'Vive', 'type_m' => 'Vive', 'type_de' => 'Vive', 'type_re' => 'Vive'),
            'remont-pristavok' => array('type' => 'приставка', 'type_rm' => 'приставок', 'type_m' => 'приставки', 'type_de' => 'приставкой', 'type_re' => 'приставки'),
            'remont-lens' => array('type' => 'объектив', 'type_rm' => 'объективов', 'type_m' => 'объективы', 'type_de' => 'объективом', 'type_re' => 'объектива'),
            'remont-notebooks' => array('type' => 'ноутбук', 'type_rm' => 'ноутбуков', 'type_m' => 'ноутбуки', 'type_de' => 'ноутбуком', 'type_re' => 'ноутбука'),
            'remont-proektorov' => array('type' => 'проектор', 'type_rm' => 'проекторов', 'type_m' => 'проекторы', 'type_de' => 'проектором', 'type_re' => 'проектора'),
            'remont-computerov' => array('type' => 'компьютер', 'type_rm' => 'компьютеров', 'type_m' => 'компьютеры', 'type_de' => 'компьютером', 'type_re' => 'компьютера'),
            'remont-holodilnikov' => array('type' => 'холодильник', 'type_rm' => 'холодильников', 'type_m' => 'холодильники', 'type_de' => 'холодильником', 'type_re' => 'холодильника'),
            'remont-posudomoechnyh-mashin' => array('type' => 'посудомоечная машина', 'type_rm' => 'посудомоечных машин', 'type_m' => 'посудомоечные машины', 'type_de' => 'посудомоечной машиной', 'type_re' => 'посудомоечные машины'),
            'remont-stiralnyh-mashin' => array('type' => 'стиральная машина', 'type_rm' => 'стиральных машин', 'type_m' => 'стиральные машины', 'type_de' => 'стиральной машиной', 'type_re' => 'стиральной машины'),
    
            'remont-elektricheskih-plit' => array('type' => 'электрическая плита', 'type_rm' => 'электрических плит', 'type_m' => 'электрические плиты', 'type_de' => 'электрической плите', 'type_re' => 'электрической плиты'),
            'remont-hlebopechkek' => array('type' => 'хлебопечка', 'type_rm' => 'хлебопечек', 'type_m' => 'хлебопечки', 'type_de' => 'хлебопечке', 'type_re' => 'хлебопечки'),
            'remont-massazhnih-kresel' => array('type' => 'массажное кресло', 'type_rm' => 'массажных кресел', 'type_m' => 'массажные кресла', 'type_de' => 'массажному креслу', 'type_re' => 'массажного кресла'),
            'remont-varochnih-paneley' => array('type' => 'варочная панель', 'type_rm' => 'варочных панелей', 'type_m' => 'варочные панели', 'type_de' => 'варочной панели', 'type_re' => 'варочной панели'),
            'remont-duhovih-shkafov' => array('type' => 'духовой шкаф', 'type_rm' => 'духовых шкафов', 'type_m' => 'духовые шкафы', 'type_de' => 'духовому шкафу', 'type_re' => 'духового шкафа'),
            'remont-kofemashin' => array('type' => 'кофемашина', 'type_rm' => 'кофемашин', 'type_m' => 'кофемашины', 'type_de' => 'кофемашине', 'type_re' => 'кофемашины'),
            'remont-pylesosov' => array('type' => 'пылесос', 'type_rm' => 'пылесосов', 'type_m' => 'пылесосы', 'type_de' => 'пылесосу', 'type_re' => 'пылесоса'),
            'remont-vytyazhk' => array('type' => 'вытяжка', 'type_rm' => 'вытяжек', 'type_m' => 'вытяжки', 'type_de' => 'вытяжке', 'type_re' => 'вытяжки'),
            'remont-mikrovolnovih-pechey' => array('type' => 'микроволновая печь', 'type_rm' => 'микроволновых печей', 'type_m' => 'микроволновые печи', 'type_de' => 'микроволновой печи', 'type_re' => 'микроволновой печи'),
            'remont-kondicionerov' => array('type' => 'кондиционер', 'type_rm' => 'кондиционеров', 'type_m' => 'кондиционеры', 'type_de' => 'кондиционеру', 'type_re' => 'кондиционеров'),
            'remont-robotov-pylesosov' => array('type' => 'робот-пылесос', 'type_rm' => 'роботов-пылесосов', 'type_m' => 'роботы-пылесосы', 'type_de' => 'роботу-пылесосу', 'type_re' => 'робота-пылесоса'),
            'remont-vodonagrevateley' => array('type' => 'водонагреватель', 'type_rm' => 'водонагревателей', 'type_m' => 'водонагреватели', 'type_de' => 'водонагревателю', 'type_re' => 'водонагревателя'),
            'remont-morozilnih-kamer' => array('type' => 'морозильная камера', 'type_rm' => 'морозильных камер', 'type_m' => 'морозильные камеры', 'type_de' => 'морозильной камере', 'type_re' => 'морозильной камеры'),
            
            'remont-elektrosamokatov' => array('type' => 'электросамокат', 'type_rm' => 'электросамокатов', 'type_m' => 'электросамокаты', 'type_de' => 'электросамокату', 'type_re' => 'электросамоката'),
            'remont-hoverboard' => array('type' => 'гироскутер', 'type_rm' => 'гироскутеров', 'type_m' => 'гироскутеры', 'type_de' => 'гироскутеру', 'type_re' => 'гироскутера'),
            'remont-monokoles' => array('type' => 'моноколесо', 'type_rm' => 'моноколес', 'type_m' => 'моноколесе', 'type_de' => 'моноколесу', 'type_re' => 'моноколеса'),
            'remont-segway'  => array('type' => 'сегвей', 'type_rm' => 'сегвеев', 'type_m' => 'сегвеи', 'type_de' => 'сегвеям', 'type_re' => 'сегвеев'),
        );
        


        if (isset($urls[$marka_lower]))
        {
            $t = array();
            foreach ($urls[$marka_lower] as $url)
            {
                foreach ($add_device_type as $key => $value)
                {
                    if (mb_strpos($url, $key) !== false) $t[] = $value;
                }
            }
          
            $this->_datas['all_devices'] = array_merge($this->_datas['all_devices'], $t);
        }

        $this->_datas['accord_image'] = array(
            'смартфон' => 'telefon', 
            'ноутбук' => 'notebook', 
            'планшет' => 'planshet',
            'фотоаппарат' => 'foto',
            'смарт-часы' => 'smartwatch',
            'моноблок' => 'monoblok',
            'монитор' => 'monitor',
            'телевизор' => 'televizor',
            'видеокамера' => 'video',
            'принтер' => 'printer',
            'наушники' => 'headphones',
            'сервер' => 'server',
            'роутер' => 'router',
            'Vive' => 'vive',
            'приставка' => 'pristavka',
            'объектив' => 'lens',
            'проектор' => 'proektor',
            'компьютер' => 'computer',
            'холодильник' => 'holodilnik',
            'посудомоечная машина' => 'posudomoechnaya-mashina',
            'стиральная машина' => 'stiralnaya-mashina',
            
            'электрическая плита'=>'elektricheskaya-plita',
            'хлебопечка'=>'hlebopechkeka',
            'массажное кресло'=>'massazhnoe-kreselo',
            'варочная панель'=>'varochnaya-panel',
            'духовой шкаф'=>'duhovoy-shkaf',
            'кофемашина'=>'kofemashina',
            'пылесос'=>'pylesos',
            'вытяжка'=>'vytyazhka',
            'микроволновая печь'=>'mikrovolnovaya-pech',
            'кондиционер'=>'kondicioner',
            'робот-пылесос'=>'robot-pylesos',
            'водонагреватель'=>'vodonagrevatel',
            'морозильная камера'=>'morozilnaya-kamera',
            
            'гироскутер'=>'hoverboard',
            'электросамокат'=>'elektrosamokat',
            'моноколесо'=>'monokoles',
            'сегвей'=>'segway',
            
        );
        
        $this->_datas['accord_url'] = array(
            'смартфон' => 'telefonov', 
            'ноутбук' => 'notebooks', 
            'планшет' => 'planshetov',
            'фотоаппарат' => 'foto',
            'смарт-часы' => 'smartwatchs',
            'моноблок' => 'monoblokov',
            'монитор' => 'monitorov',
            'телевизор' => 'televizorov',
            'видеокамера' => 'video',
            'принтер' => 'printerov',
            'наушники' => 'headphones',
            'сервер' => 'serverov',
            'роутер' => 'routers',
            'Vive' => 'vive',
            'приставка' => 'pristavok',
            'объектив' => 'lens',
            'проектор' => 'proektorov',
            'компьютер' => 'computerov',
            'холодильник' => 'holodilnikov',
            'посудомоечная машина' => 'posudomoechnyh-mashin',
            'стиральная машина' => 'stiralnyh-mashin',
            
            'электрическая плита'=>'elektricheskih-plit',
            'хлебопечка'=>'hlebopechkek',
            'массажное кресло'=>'massazhnih-kresel',
            'варочная панель'=>'varochnih-paneley',
            'духовой шкаф'=>'duhovih-shkafov',
            'кофемашина'=>'kofemashin',
            'пылесос'=>'pylesosov',
            'вытяжка'=>'vytyazhk',
            'микроволновая печь'=>'mikrovolnovih-pechey',
            'кондиционер'=>'kondicionerov',
            'робот-пылесос'=>'robotov-pylesosov',
            'водонагреватель'=>'vodonagrevateley',
            'морозильная камера'=>'morozilnih-kamer',
            
            'гироскутер'=>'hoverboard',
            'электросамокат'=>'elektrosamokatov',
            'моноколесо' => 'monokoles',
            'сегвей'=>'segway',
        );
    }

}

?>
