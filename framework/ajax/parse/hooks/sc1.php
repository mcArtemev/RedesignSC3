<?

namespace framework\ajax\parse\hooks;

use framework\tools;
use framework\pdo;
use framework\rand_it;

class sc1 extends sc
{
    public function generate($answer, $params)
    {
         $sql =  "SELECT `model_types`.`name` as `type`, `model_types`.`id` as `type_id`,
                `model_types`.`name_re` as `type_re`, `model_types`.`name_rm` as `type_rm`,
                 `model_types`.`name_m` as `type_m`, `model_types`.`name_de` as `type_de` FROM `m_model_to_sites`
            INNER JOIN `m_models` ON `m_models`.`id` = `m_model_to_sites`.`m_model_id`
            INNER JOIN `model_types` ON `m_models`.`model_type_id` = `model_types`.`id` WHERE `m_model_to_sites`.`site_id`= ? GROUP BY `model_types`.`name`";
        $stm = pdo::getPdo()->prepare($sql);
        $stm->execute(array($params['site_id']));
        $this->_datas['all_devices'] = $stm->fetchAll(\PDO::FETCH_ASSOC);
        $f = tools::gen_feed($params['site_name']);
        $this->_datas['all_devices'] = rand_it::randMas($this->_datas['all_devices'], count($this->_datas['all_devices']), '', $f);
        // region
        $this->_datas['region'] = $this->_getRegion($params['region_id']);
        $city = str_replace("Санкт-Петербурге", "Санкт-Петербурге (СПБ)", $this->_datas['region']['name_pe']);

        // partner
        $this->_datas['partner'] = $this->_getPartner($params['partner_id']);

        // menu
        $this->_datas['header_menu'] = array(
            '/' => 'Главная',
            '/diagnostika/' => 'Диагностика',
            '/dostavka/' => 'Выезд и доставка',
            '/sroki/' => 'Срочный ремонт',
            '/zapchasti/' => 'Комплектующие',
            '/ceny/' => 'Цены',
            '/kontakty/' => 'Контакты',
            '#' => 'Статус заказа',    
        );
        
        $this->_datas['footer_menu'] = array(
            '/o-nas/' => 'О нас',
            '/diagnostika/' => 'Диагностика',
            '/dostavka/' => 'Выезд и доставка',
            '/sroki/' => 'Срочный ремонт',
            '/zapchasti/' => 'Комплектующие',
            '/ceny/' => 'Цены',
            '#' => 'Статус заказа',
            '/kontakty/' => 'Контакты',  
        );
        
        $compHelpBrands = [
            4, 21, 3, 295, 15, 9, 6, 17, 
            293, 297, 294, 5, 12, 8, 144, 
            296, 2, 1, 298, 7, 18,
        ];
        if (isset($params['marka_id'])){
            if(in_array($params['marka_id'],$compHelpBrands)){
                $this->_datas['footer_menu'] = array(
                    '/o-nas/' => 'О нас',
                    '/diagnostika/' => 'Диагностика',
                    '/dostavka/' => 'Выезд и доставка',
                    '/sroki/' => 'Срочный ремонт',
                    '/kompyuternaya-pomoshch/'=> 'Помощь с ПО',
                    '/vosstanovlenie-dannyh/' => 'Восстановление данных',
                    '/zapchasti/' => 'Комплектующие',
                    '/ceny/' => 'Цены',
                    '#' => 'Статус заказа',
                    '/kontakty/' => 'Контакты',
                );
            }
        }
        
        $this->_datas['zoom'] = 13;
        // #rat
        $this->_datas['original_setka_id'] = (!empty($params['original_setka_id']))? $params['original_setka_id'] : $params['setka_id'];

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
                $marka_lower = mb_strtolower($this->_datas['marka']['name']);
                $ru_marka = $this->_datas['marka']['ru_name'];
                $servicename = $params['servicename'];
                $region_name_pe = str_replace("Санкт-Петербурге", "Санкт-Петербурге (СПБ)", $this->_datas['region']['name_pe']);
                $region_name_re = $this->_datas['region']['name_re'];
                $region_name_de = $this->_datas['region']['name_de'];

                $this->_make_accord_table($marka_lower);

                switch ($file_name)
            	{
                    case 'index': case 'b2b':

                        $accord_array = array(
                            'acer' => 'Cервисный центр Acer Russia &#127757; Ремонт Acer (Асер) в '.$region_name_pe,
                            'alcatel' => 'Сервисный центр Алкатель &#127757; Ремонт Alcatel (Алкатель) в '.$region_name_pe,
                            'apple' => 'Cервисный центр Apple Russia &#127757; Ремонт Apple (Эпл) в '.$region_name_pe,
                            'asus' => 'Cервисный центр Asus Russia &#127757; Ремонт Asus (Асус) в '.$region_name_pe,
                            'canon' => 'Cервисный центр Canon Russia &#127757; Ремонт Canon (Кэнон) в '.$region_name_pe,
                            'dell' => 'Cервисный центр Dell Russia &#127757; Ремонт Dell (Делл) в '.$region_name_pe,
                            'fly' => 'Ремонт Fly (Флай) &#127757; Cервисный центр Fly Russia в '.$region_name_pe,
                            'hp' => 'Cервисный центр HP Russia &#127757; Ремонт HP в '.$region_name_pe,
                            'htc' => 'Cервисный центр HTC Russia &#127757; Ремонт HTC в '.$region_name_pe,
                            'huawei' => 'Ремонт Huawei (Хуавей) &#127757; Cервисный центр Huawei Russia в '.$region_name_pe,
                            'lenovo' => 'Cервисный центр Леново в '.$region_name_pe.' &#127757; Ремонт Lenovo',
                            'lg' => 'Cервисный центр LG Russia &#127757; Ремонт LG (Лджи) в '.$region_name_pe,
                            'meizu' => 'Ремонт Мейзу (Meizu) &#127757; Cервисный центр Meizu Russia в '.$region_name_pe,
                            'msi' => 'Cервисный центр MSI Russia &#127757; Ремонт MSI в '.$region_name_pe,
                            'nikon' => 'Ремонт Nikon (Никон) &#127757; Cервисный центр Nikon Russia в '.$region_name_pe,
                            'nokia' => 'Cервисный центр Nokia Russia &#127757; Ремонт Нокиа (Nokia) в '.$region_name_pe,
                            'samsung' => 'Cервисный центр Самсунг в '.$region_name_pe.' &#127757; Ремонт Самсунг (Samsung)',
                            'sony' => 'Ремонт Sony (Сони) в '.$region_name_pe.' &#127757; Cервисный центр Сони',
                            'toshiba' => 'Ремонт Toshiba (Тошиба) в '.$region_name_pe.' &#127757; Cервисный центр Тошиба',
                            'xiaomi' => 'Ремонт Xiaomi &#127757; Cервисный центр Xiaomi Russia в '.$region_name_pe,
                            'zte' => 'Ремонт ZTE &#127757; Cервисный центр ZTE Russia в '.$region_name_pe,
                            'vertu' => 'Ремонт Vertu &#127757; Сервисный центр Vertu Russia в ' .$region_name_pe,
                            'oneplus' => 'Ремонт OnePlus &#127757; Сервисный центр OnePlus Russia в ' .$region_name_pe,
                        );

                        $accord_array_h1 = array(
                            'alcatel' => 'Сервисный центр Алкатель',
                            'fly' => 'Ремонт Fly',
                            'huawei' => 'Ремонт Huawei',
                            'lenovo' => 'Сервисный центр Леново',
                            'meizu' => 'Ремонт Meizu',
                            'samsung' => 'Сервисный центр Самсунг',
                            'xiaomi' => 'Ремонт Xiaomi',
                            'zte' => 'Ремонт ZTE',
                            'vertu' => 'Ремонт Vertu',
                            'oneplus' => 'Ремонт OnePlus',
                        );

                        $t = array();
                        foreach ($this->_datas['all_devices'] as $device)
                            $t[] = $device['type_rm'];

                        $title_old = 'Ремонт ' .  $marka . ' в сервисном центре &#127757; ' . $servicename . ' в ' . $region_name_pe;
                        $title = isset($accord_array[$marka_lower]) ? $accord_array[$marka_lower] : $title_old;

                        $description = '⭐⭐⭐⭐⭐ Сервисный центр ' . $servicename . '. Ремонт и обслуживание техники ' . $ru_marka . ': '.tools::implode_or($t).'. Срочный ремонт и бесплатная диагностика.';

                        if ($this->_datas['region']['name'] == 'Москва' && $marka_lower == 'nikon')
                        {
                            $h1 = 'Сервисный центр фотоаппаратов';
                        }
                        else
                        {
                            $h1 = isset($accord_array_h1[$marka_lower]) ? $accord_array_h1[$marka_lower] : 'Сервисный центр ' . $marka;
                        }

                        break;

                    case 'diagnostika':
                        $title = 'Диагностика аппаратов ' . $marka . ' в '. $region_name_pe.' за 15-40 минут';
                        $description = 'Оперативная диагностика устройств ' . $ru_marka . '. Диагностика в ' . $servicename . ' выполняется бесплатно, среднее время проведения процедуры – 15-40 минут. Необходимость выполнения осмотра аппарата перед любым видом ремонта.';
                        $h1 = 'Экспресс диагностика';
                        break;
						
					case 'search':
                        $title = 'Диагностика аппаратов ' . $marka . ' в '. $region_name_pe.' за 15-40 минут';
                        $description = 'Оперативная диагностика устройств ' . $ru_marka . '. Диагностика в ' . $servicename . ' выполняется бесплатно, среднее время проведения процедуры – 15-40 минут. Необходимость выполнения осмотра аппарата перед любым видом ремонта.';
                        $h1 = 'Экспресс диагностика';
                        break;

                    case 'dostavka':
                        $title = 'Выезд курьера на дом или в офис по '.$region_name_de;
                        $description = 'Выезд курьера на дом к клиенту. Доставка аппарата в сервис – бесплатно по ' . $region_name_de . '.';
                        $h1 = 'Доставка и выезд на дом';
                        break;

                    case 'sroki':
                        $title = 'Срочный ремонт техники ' . $marka. ' в ' . $region_name_pe;
                        $description = 'Срочный ремонт техники ' . $ru_marka . ' в сервисном центре ' . $servicename . '. Сроки обслуживания в зависимости от характера неисправности. Стационарный ремонт и выезд курьера.';
                        $h1 = 'Срочный ремонт от ' . $servicename;
                        break;

                    case 'ceny':
                        $t = array();
                        foreach ($this->_datas['all_devices'] as $device)
                            $t[] = $device['type_rm'];
                        $title = 'Цены на работы сервисного центра ' . $servicename.' в ' . $region_name_pe;
                        $description = 'Прайслист на услуги по ремонту техники в ' . $servicename .': '.tools::implode_or($t).'. Подробный перечень услуг с указанием цен и сроков ремонта по каждому из типов продуктов ' . $ru_marka . '.';
                        $h1 = 'Обслуживание ' . $marka . '&ndash; Цены';
                        break;

                    case 'zapchasti':
                        $title = 'Оригинальные комплектующие и программное обеспечение — '.$servicename.' '.$this->_datas['region']['translit1'];
                        $description = 'Комплектующие для ремонта аппаратов в ' . $servicename .'. Широкий ассортимент запчастей на популярные модели в наличии и под заказ. Оригинальные дистрибутивы программных продуктов ' . $ru_marka . '. Возможен выезд курьера.';
                        $h1 = 'Оригинальные комплектующие';
                        break;

                    case 'kontakty':
                        $title = 'Контакты ' . $servicename . ' в ' . $region_name_pe;
                        $description = 'Контактная информация сервисного центра ' . $servicename . '. Адрес, телефон, месторасположение офиса на карте ' . $region_name_re . '. Электронные почтовые адреса по общим, техническим и вопросам сотрудничества.';
                        $h1 = 'Контакты. Свяжитесь с нами';
                        break;

                    case 'otpravleno':
                        $title = 'Спасибо';
                        $description = '';
                        $h1 = 'Спасибо!';
                        break;

                    case 'o-nas':
                        $title = 'О компании '.$servicename;
                        $description = 'О сервисном центре '.$servicename.':  наша команда.';
                        $h1 = 'О компании';
                    break;
                    
                    case 'kompyuternaya-pomoshch':
                        $title = 'Компьютерная помощь '.$marka.' в '.$region_name_pe.' – установка и настройка ПО';
                        $description = tools::new_gen_text('{Проводим | Осуществляем | Выполняем } {установку и настройку | настройку и установку } 
                                {{{программного обеспечения | программ и компонентов} {техники |устройств} '.$marka.' }|{ПО {техники | устройств} '.$marka.' }}. 
                                Выезд {мастера | специалиста | системного администратора | сис.админа | программного инженера} 
                                {{{на дом или в офис | в офис или на дом} { - бесплатный.| - абсолютно бесплатный.| - совершенно бесплатный.} 
                                }|{{по вашему адресу | на ваш адрес | по вашему адресу} { - бесплатный. | - абсолютно бесплатный. | - совершенно бесплатный.}}} 
                                Гарантия {низкой | фиксированной | прозрачной} {цены.|стоимости.} ');
                        $h1 = 'Помощь в установке и настройке ПО';
                        break;
                        
                    case 'vosstanovlenie-dannyh':
                        $title = 'Восстановление данных с жесткого диска, флешки, телефона, после форматирования в '.$region_name_pe.' – цена для техники '.$marka;
                        $description = tools::new_gen_text('{Проводим | Осуществляем | Выполняем} ^извлечение^(0) и ^восстановление^(0) 
                            { { {удаленных | поврежденных | зашифрованных | стертых | утраченных} данных 
                            {данных с любых |со всех } }|{{удаленной | поврежденной | зашифрованной |стертой | утраченной} 
                            {информации с любых | со всех} } } {носителей | накопителей | устройств | запоминающих устройств} 
                            {техники|} '.$marka.' в '.$region_name_pe.'. 
                            Гарантия {{конфиденциальности. }|{сохранности {информации. | данных. } }|{
                            сохранения конфиденциальности. }|{сохранения конфиденциальности {данных. | информации.} } } 
                            {Оперативный | Срочный | Быстрый | Экстренный} выезд {специалиста. | мастера. | программного инженера.} 
                            ');
                        $h1 = 'Восстановление удаленных данных';
                        break;    
                    case 'vakansii':
                        include(__DIR__.'/pages/sc1/description-vacancy.php');
                        $file_name = 'vacancy';
                        $title = 'Вакансии сервисного центра по ремонту бытовой техники (бренд) в '.$region_name_pe;
                        $description = $description_description;
                        $h1 = 'Актуальные вакансии сервисного центра'.$this->_datas['marka']['ru_name'];
                    break;

                    default:
                        $gadget = $this->_datas['add_device_type'][$this->_datas['arg_url']];
                        $accord_apple = array('ноутбук' => 'MacBook', 'смартфон' => 'iPhone', 'планшет' => 'iPad', 'моноблок' => 'iMac', 'смарт-часы' => 'Apple Watch');
                        $accord_apple_desc = array('ноутбук' => 'МакБук', 'смартфон' => 'АйФон', 'планшет' => 'АйПад', 'моноблок' => 'АйМак', 'смарт-часы' => 'Эпл вотч');

                        if ($marka_lower == 'apple')
                        {
							$title = 'Ремонт '.(isset($accord_apple[$gadget['type']]) ? $accord_apple[$gadget['type']] : $gadget['type_rm']).' в '.$region_name_pe.' — '.$this->_datas['servicename'];
							if ($gadget['type'] == 'смарт-часы') {
								$title = 'Ремонт '.(isset($accord_apple[$gadget['type']]) ? $accord_apple[$gadget['type']] : $gadget['type_rm']).' (3, 2) в '.$region_name_pe.' — '.$this->_datas['servicename'];
							}
                            $description = 'Обслуживание и ремонт '.$this->_datas['marka']['ru_name'].' '.(isset($accord_apple_desc[$gadget['type']]) ? $accord_apple_desc[$gadget['type']] : $gadget['type_rm'].' '.$this->_datas['marka']['ru_name']).' в '.$region_name_pe.'. Подробный перечень услуг и запчастей. Надежный сервис. Время выполнения работ. Наличие и заказ деталей.';
                            $h1 = 'Ремонт '.(isset($accord_apple[$gadget['type']]) ? $accord_apple[$gadget['type']] : $gadget['type_rm'].' '.$this->_datas['marka']['name']);
                        } elseif($gadget['type'] == 'умные часы') {
                            $title = 'Ремонт '.$gadget['type_rm'].' '.$this->_datas['marka']['name'].' в '.$region_name_pe.' — '.$this->_datas['servicename'];
                            $description = 'Обслуживание и ремонт '.$gadget['type_rm'].' '.$this->_datas['marka']['ru_name'].' в '.$region_name_pe.'. Подробный перечень услуг и запчастей. Надежный сервис. Время выполнения работ. Наличие и заказ деталей.';
                            $h1 = "Ремонт Samsung Gear";
						}
                        else
                        {
                            $title = 'Ремонт '.$gadget['type_rm'].' '.$this->_datas['marka']['name'].' в '.$region_name_pe.' — '.$this->_datas['servicename'];
                            $description = 'Обслуживание и ремонт '.$gadget['type_rm'].' '.$this->_datas['marka']['ru_name'].' в '.$region_name_pe.'. Подробный перечень услуг и запчастей. Надежный сервис. Время выполнения работ. Наличие и заказ деталей.';
                            $h1 = 'Ремонт '.$gadget['type_rm'].' '.$this->_datas['marka']['name'];
                        }

                        //hack dops
                       $sql = "SELECT `title`, `h1` FROM `dop_urls`
                         LEFT JOIN `marka_to_sites` ON `dop_urls`.`site_id` = `marka_to_sites`.`site_id`
                         LEFT JOIN `sites` ON `marka_to_sites`.`site_id` = `sites`.`id`
                            WHERE `sites`.`setka_id`=:setka_id AND `marka_to_sites`.`marka_id`=:marka_id AND (`sites`.`region_id` = 0 OR `sites`.`region_id` IS NULL)
                            AND `dop_urls`.`name`=:url";

                        $stm = pdo::getPdo()->prepare($sql);
                        $stm->execute(array('setka_id' => $this->_datas['setka_id'], 'marka_id' => $this->_datas['marka']['id'], 'url' => $this->_datas['arg_url']));
                        $new_array = current($stm->fetchAll(\PDO::FETCH_ASSOC));

                        if ($new_array)
                        {
                            if ($new_array['title'])
                            {
                                $title = str_replace('[city]', $city, $new_array['title']);
                            }

                            if ($new_array['h1'])
                            {
                                $h1 = str_replace('[city]', $city, $new_array['h1']);
                            }
                        }

                        $file_name = 'gadget';
               }

                // addresis
                $address_setka_id = isset($params['original_setka_id']) ? $params['original_setka_id'] : $params['setka_id'];
                $this->_datas['addresis'] = $this->_getAddresis($address_setka_id, $this->_datas['marka']['id']);
                //$this->_normalize_addresis();

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

        if (isset($params['model_type_id']))
        {
            if (is_array($params['model_type_id']))
            {
                $this->_sqlLevelData($params);
                $level = true;
            }
        }

        if (!$level) $this->_sqlData($params);
        $this->_make_accord_table(mb_strtolower($this->_datas['marka']['name']));
        
        
        
        // addresis
        $address_setka_id = isset($params['original_setka_id']) ? $params['original_setka_id'] : $params['setka_id'];
        $this->_datas['addresis'] = $this->_getAddresis($address_setka_id, $this->_datas['marka']['id']);
        //$this->_normalize_addresis();

        /*if ($this->_cache_mode === 2 || $this->_cache_mode === 3)
        {
            $this->_createContext();
            return false;
        }*/
        
        $ret = array();
        
        $file_name = '';

        // добавка
        if ($this->_suffics == 'n')
        {
            $laptops = array();
            $laptops[0][] = array("апгрейд","upgrade","перепрошивка BIOS","перепрошивка БИОС","установка драйверов","установка программ","установка ПО","настройка ПО",
                "настройка программ","восстановление жестких дисков","восстановление HDD/SSD","восстановление HDD/SSD дисков","увеличения памяти","диагностика","чистки",
                "чистки от пылы","настройки драйверов");
            $laptops[1][] = array("ремонт","замена");
            $laptops[1][] = array("встроенных камер","корпусов","петель","динамиков","портов","шлейфов","разъемов","кулеров","вентиляторов","охлаждения","систем охлаждения",
                "жестких дисков","HDD/SSD","HDD/SSD накопителей","HDD/SSD дисков","клавиатуры","кнопок клавиатуры","микрофонов","гнезд питания","разъемов питания",
                "разъемов зарядки","гнезд зарядки","WI-FI","WI-FI модулей","модулей WI-FI","плат WI-FI","WI-FI плат","HDMI разъемов","USB разъемов","разъемов наушников",
                "аудио-разъемов","vga разъемов","lan разъемов","разъемов","звуковых карт","звуковых плат","зарядных устройств","блоков питания","камер","тачпадов","модулей тачпад",
                "ОЗУ","памяти","ОЗУ памяти","шлейфов матрицы","АКБ","батареи","аккумуляторов","аккумуляторных батарей");
            $laptops[2][] = array("пайка","перепайка");
            $laptops[2][] = array("материнских плат","плат","элементов плат","системных плат","мультиконтроллеров","контроллеров","контроллеров плат","ШИМ-контроллеров",
                "PWM-контроллеров","процессоров","чипов","цепей питания","цепей питания плат","BGA-элементов","BGA-чипов","мостов","южных мостов","северных мостов",
                "чипов южного мостов","чипов северного мостов","видеокарт","чипов видеокарт");


            $laptops_a = "";

            $rand_in = array_rand($laptops,1);
            $laptops_a .= $this->checkarray($laptops[$rand_in]) . ", ";
            unset($laptops[$rand_in]);

            $rand_in = array_rand($laptops,1);
            $laptops_a .= $this->checkarray($laptops[$rand_in]) . ", ";
            unset($laptops[$rand_in]);

            $rand_in = array_rand($laptops,1);
            $laptops_a .= $this->checkarray($laptops[$rand_in]);
            unset($laptops[$rand_in]);

            $this->_datas['add_title'] = $laptops_a;
        }

        if ($this->_suffics == 'p')
        {
            $tablet = array();
            $tablet_rand = rand(1,2);
            if($tablet_rand == 1)
            {
                $tablet[0][] = array("диагностика","чистка","перепрошивка","настройка ПО");
            }
            if($tablet_rand == 2)
            {
                $tablet[0][] = array("пайка","перепайка");
                $tablet[0][] = array("материнских плат","плат","элементов плат","системных плат","мультиконтроллеров","контроллеров","контроллеров плат","ШИМ-контроллеров",
                    "PWM-контроллеров","процессоров","чипов","цепей питания","цепей питания плат","BGA-элементов","BGA-чипов","мостов","южных мостов","северных мостов",
                    "чипов южного мостов","чипов северного мостов");
            }
            $tablet[1][] = array("ремонт","замена");
            $tablet[1][] = array("камер","встроенных камер","корпусов","динамиков","разъемов","портов","шлейфов","симхолдеров","сим-лотков","держателей сим","simholder","кнопок",
                "кнопок включения","кнопок выключения","GPS","GPS-модулей","модулей GPS","плат GPS","GPS-плат","вибромоторов","вибро","вибромодулей","микрофонов","гнезд питания",
                "разъемов питания","разъемов зарядки","гнезда питания","гнезда зарядки","WI-FI","WI-FI модулей","модулей WI-FI","плат WI-FI","WI-FI плат","слотов","крышки","антенны",
                "батарей","батареек","АКБ","аккумуляторов","аккумуляторных батарей","флеш памяти","прошивки","памяти","увеличения памяти","деталей");

            $tablet_a = "";
            $tablet_rand_in = array_rand($tablet,1);
            $tablet_a .= $this->checkarray($tablet[$tablet_rand_in]) . ", ";
            unset($tablet[$tablet_rand_in]);

            $tablet_rand_in = array_rand($tablet,1);
            $tablet_a .= $this->checkarray($tablet[$tablet_rand_in]);
            unset($tablet[$tablet_rand_in]);

            $this->_datas['add_title'] = $tablet_a;
        }

        if ($this->_suffics == 'f')
        {
            $phone = array();
            $phone_rand = rand(1,2);
            if($phone_rand == 1)
            {
                $phone[0][] = array("диагностика","чистка","перепрошивка","настройка ПО");
            }
            if($phone_rand == 2)
            {
                $phone[0][] = array("пайка","перепайка");
                $phone[0][] = array("материнских плат","плат","элементов плат","системных плат","мультиконтроллеров","контроллеров","контроллеров плат","ШИМ-контроллеров",
                    "PWM-контроллеров","процессоров","чипов","цепей питания","цепей питания плат","BGA-элементов","BGA-чипов","мостов","южных мостов","северных мостов",
                    "чипов южного мостов","чипов северного мостов");
            }
            $phone[1][] = array("ремонт","замена");
            $phone[1][] = array("камер","встроенных камер","корпусов","динамиков","разъемов","портов","шлейфов","симхолдеров","сим-лотков","держателей сим","simholder","кнопок",
                "кнопок включения","кнопок выключения","GPS","GPS-модулей","модулей GPS","плат GPS","GPS-плат","вибромоторов","вибро","вибромодулей","микрофонов","гнезд питания",
                "разъемов питания","разъемов зарядки","гнезда питания","гнезда зарядки","WI-FI","WI-FI модулей","модулей WI-FI","плат WI-FI","WI-FI плат","слотов",
                "крышки","антенны","батарей","батареек","АКБ","аккумуляторов","аккумуляторных батарей","флеш памяти","прошивки","памяти","увеличения памяти",
                "деталей","корпусных деталей");

            $phone_a = "";
            $phone_rand_in = array_rand($phone,1);
            $phone_a .=  $this->checkarray($phone[$phone_rand_in]) . ", ";
            unset($phone[$phone_rand_in]);

            $phone_rand_in = array_rand($phone,1);
            $phone_a .=  $this->checkarray($phone[$phone_rand_in]);
            unset($phone[$phone_rand_in]);

            $this->_datas['add_title'] = $phone_a;
        }

        $marka_lower = mb_strtolower($this->_datas['marka']['name']);
        $accord_apple = array('n' => 'MacBook', 'f' => 'iPhone', 'p' => 'iPad');
        $accord_apple_desc = array('n' => 'МакБук', 'f' => 'АйФон', 'p' => 'АйПад');

        if (isset($params['marka_id']) && isset($params['model_type_id']))
        {
            if (!isset($params['key']))
            {

                /*$ret['title'] = array(
                    'Ремонт',
                    $this->_datas['marka']['name'],
                    $this->_datas['vsemodeli'],
                    'в сервисном центре',
                    $this->_datas['servicename']
                );

                if (isset($this->_datas['price']))
                {
                    $ret['title'][] = 'от';
                    $ret['title'][] = $this->_datas['price'].'р';
                }*/

                //if ($this->_datas['site_name'] == 'oms.htcrussia.com')
                //{
                    //$ret['title'] = array('Свой тайтл');
                //}
                //else
                //{

                    if ($marka_lower == 'apple')
                    {
                        $ret['title'] = array(
                            'Ремонт ',
                            $accord_apple[$this->_suffics],
                            ' &#127757; в',
                            $city,
                            '—',
                            $this->_datas['servicename']
                        );

                        $ret['h1'] = array(
                            'Ремонт',
                            $this->_datas['vsemodeli']
                        );

                        $ret['description'] = array(
                            '⭐⭐⭐⭐⭐ Обслуживание и ремонт',
                            $this->_datas['marka']['ru_name'],
                            $accord_apple_desc[$this->_suffics],
                            'в '.$city.'.',
                            $this->_datas['dop']
                        );
                    }
                    else
                    {
                        $ret['title'] = array(
                            'Ремонт ',
                            $this->_datas['model_type'][0]['name_rm'],
                            $this->_datas['marka']['name'],
                            ' &#127757; в',
                            $city,
                            '—',
                            $this->_datas['servicename']
                        );
                    //}

                        $ret['h1'] = array(
                            'Ремонт',
                            $this->_datas['model_type'][1]['name_rm'],
                            $this->_datas['marka']['name'],
                            $this->_datas['vsemodeli']
                        );

                        $ret['description'] = array(
                            '⭐⭐⭐⭐⭐ Обслуживание и ремонт',
                            $this->_datas['model_type'][2]['name_rm'],
                            $this->_datas['marka']['ru_name'],
                            'в '.$city.'.',
                            $this->_datas['dop']
                        );
                    }

                    $file_name = 'model2';
            }
            else
            {
                switch ($params['key'])
                {
                    case 'service':

                        /*$ret['title'] = array(
                            tools::mb_firstupper($this->_datas['syns'][0])
                        );

                        if (!$level)
                        {
                            $ret['title'][] = $this->_datas['marka']['name'];
                            $ret['title'][] = $this->_datas['vsemodeli'];
                        }
                        else
                        {
                            $ret['title'][] = implode(', ', $this->_datas['model_type'][0]['name_rm']);
                            $ret['title'][] = $this->_datas['marka']['name'];
                        }

                        $ret['title'][] = 'всех моделей';
                        $ret['title'][] = 'в сервисном центре';
                        $ret['title'][] = $this->_datas['servicename'];

                        if (isset($this->_datas['price']))
                        {
                            $ret['title'][] = '-';
                            $ret['title'][] = $this->_datas['price'];
                            $ret['title'][] = 'руб';
                        }*/

                        $ret['title'] = array(
                            tools::mb_firstupper($this->_datas['syns'][0])
                        );

                        if (!$level)
                        {
                            $ret['title'][] = $this->_datas['marka']['name'];
                            $ret['title'][] = $this->_datas['vsemodeli'];

                            $ret['title'][] = 'всех моделей';
                            $ret['title'][] = 'в '.$city;
                            $ret['title'][] = '—';
                            $ret['title'][] = 'ремонт';
                            $ret['title'][] = 'в';
                            $ret['title'][] = $this->_datas['servicename'];

                            if (isset($this->_datas['price']))
                            {
                                $ret['title'][] = 'от';
                                $ret['title'][] = $this->_datas['price'].'р';
                            }
                        }
                        else
                        {
                            $ret['title'][] = implode(', ', $this->_datas['model_type'][0]['name_rm']);
                            $ret['title'][] = $this->_datas['marka']['name'];

                            $ret['title'][] = 'в '.$city;
                            $ret['title'][] = '—';

                            if (isset($this->_datas['price']))
                            {
                                $ret['title'][] = 'от';
                                $ret['title'][] = $this->_datas['price'].'р';
                            }

                            $ret['title'][] = $this->_datas['servicename'];
                        }


                        $ret['h1'] = array(
                            tools::mb_firstupper($this->_datas['syns'][1])
                        );

                        if (!$level)
                        {
                            $ret['h1'][] = $this->_datas['marka']['name'];
                            $ret['h1'][] = $this->_datas['vsemodeli'];
                        }
                        else
                        {
                            //$ret['h1'][] = implode(', ', $this->_datas['model_type'][1]['name_rm']);
                            $ret['h1'][] = $this->_datas['marka']['name'];
                        }

                        $ret['description'] = array(
                            tools::mb_firstupper($this->_datas['syns'][2])
                        );

                        if (!$level)
                        {
                            $ret['description'][] = $this->_datas['model_type'][2]['name_rm'];
                        }
                        else
                        {
                            $ret['description'][] = implode(', ', $this->_datas['model_type'][2]['name_rm']);
                        }

                        $ret['description'][] = $this->_datas['marka']['ru_name'];

                        if (!$level)
                        {
                            $ret['description'][] = $this->_datas['ru_vsemodeli'];
                        }

                        $ret['description'][] = 'в '.$city.'.';
                        $ret['description'][] = $this->_datas['dop'];

                    $file_name = 'model-service2';

                    break;
                    case 'defect':

                        /*$ret['title'] = array(
                            tools::mb_firstupper($this->_datas['syns'][0])
                        );

                        if (!$level)
                        {
                            $ret['title'][] = $this->_datas['marka']['name'];
                            $ret['title'][] = $this->_datas['vsemodeli'];
                        }
                        else
                        {
                            $ret['title'][] = $this->_datas['marka']['name'];
                        }

                        $ret['title'][] = '-';
                        $ret['title'][] = 'ремонт в сервис центре';
                        $ret['title'][] = $this->_datas['servicename'];

                        if (isset($this->_datas['price']))
                        {
                            $ret['title'][] = 'от';
                            $ret['title'][] = $this->_datas['price'];
                            $ret['title'][] = 'руб';
                        }*/

                        /*$ret['title'] = array(
                            tools::mb_firstupper($this->_datas['syns'][0])
                        );

                        if (!$level)
                        {
                            $ret['title'][] = $this->_datas['marka']['name'];
                            $ret['title'][] = $this->_datas['vsemodeli'];
                        }
                        else
                        {
                            $ret['title'][] = $this->_datas['marka']['name'];
                        }

                        $ret['title'][] = '—';
                        $ret['title'][] = 'ремонт';
                        $ret['title'][] = 'в';
                        $ret['title'][] = $this->_datas['servicename'];

                        if (isset($this->_datas['price']))
                        {
                            $ret['title'][] = 'от';
                            $ret['title'][] = $this->_datas['price'].'р';
                        }*/

                         // Неисправность Т
                        $title_new = '';
                        $sql = "SELECT `title` FROM `{$this->_suffics}_dop_defect_urls`
                                    WHERE `{$this->_suffics}_defect_id`=:defect_id";

                        $stm = pdo::getPdo()->prepare($sql);
                        $stm->execute(array('defect_id' => $this->_datas['id']));
                        $title_new = $stm->fetchColumn();

                        $syns = tools::mb_firstupper($this->_datas['syns'][rand(0, 3)]);
                        $marka = $this->_datas['marka']['name'];  // SONY
                        $region_name_a = $this->_datas['region']['translit1'];// Omsk
                        $servicename = $this->_datas['servicename']; //SONY Russia

                        $malfunction_t = array();
                        $malfunction_t[0][] = array("Информация о причинах неисправности","Причины неисправности","Симптомы неисправности","Возможные причины неисправности","Частые симптомы неисправности",
                            "Популярные симптомы неисправности","Популярные причины неисправности","Частые причины неисправности","Информация о причинах неисправности","Причины возникновения неисправности",
                            "Симптомы возникновения неисправности","Причины появления неисправности","Симптомы появления неисправности","Причины возникновения проблемы","Симптомы возникновения проблемы",
                            "Причины проблемы","Симптомы проблемы","Возможные причины проблемы","Частые симптомы проблемы","Популярные симптомы проблемы","Популярные причины проблемы",
                            "Частые причины проблемы","Информация о причинах проблемах","Причины возникновения проблемы","Симптомы возникновения проблемы","Причины появления проблемы",
                            "Симптомы появления проблемы","Информация о причинах данной неисправности","Причины данной неисправности","Симптомы данной неисправности",
                            "Возможные причины данной неисправности","Частые симптомы данной неисправности","Популярные симптомы данной неисправности","Популярные причины данной неисправности",
                            "Частые причины данной неисправности","Информация о причинах неисправности","Причины возникновения данной неисправности","Симптомы возникновения данной неисправности",
                            "Причины появления данной неисправности","Симптомы появления данной неисправности","Причины возникновения данной проблемы","Симптомы возникновения данной проблемы",
                            "Причины данной проблемы","Симптомы данной проблемы","Возможные причины данной проблемы","Частые симптомы данной проблемы","Популярные симптомы данной проблемы",
                            "Популярные причины данной проблемы","Частые причины данной проблемы","Информация о причинах данной проблемы","Причины возникновения данной проблемы",
                            "Симптомы возникновения данной проблемы","Причины появления данной проблемы","Симптомы появления данной проблемы");
                        $malfunction_t[1][] = array("по статистике $servicename $region_name_a","по статистике сервиса $servicename $region_name_a",
                            "по статистике центра $servicename $region_name_a");

                        $t1_str = mb_strtolower($this->checkarray($malfunction_t[0]));
                        $t2_str = $this->checkarray($malfunction_t[1]);

                        if ($title_new)
                        {
                            $ret['title'] = array(str_replace(
                                array('[city]', '[brand]', '[brandru]'),
                                array($city, $this->_datas['marka']['name'], $this->_datas['marka']['ru_name']),
                                $title_new
                            ));
                        }
                        else
                        {
                            $ret['title'] = array($this->firstup(trim("$syns $marka — $t1_str $t2_str")));
                        }

                        $ret['h1'] = array(
                        );

                        if (!$level)
                        {
                            $ret['h1'][] = $this->_datas['marka']['name'];
                            $ret['h1'][] = $this->_datas['vsemodeli'].':';
                        }
                        else
                        {
                            $ret['h1'][] = $this->_datas['marka']['name'].':';
                        }

                        $ret['h1'][] = tools::mb_firstlower($this->_datas['syns'][1]);

                        $ret['description'] = array(
                        );

                        if (!$level)
                        {
                            $ret['description'][] = $this->_datas['marka']['ru_name'];
                            $ret['description'][] = $this->_datas['ru_vsemodeli'];
                        }
                        else
                        {
                            $ret['description'][] = 'Устройство';
                            $ret['description'][] = $this->_datas['marka']['ru_name'];
                        }

                        $ret['description'][] = tools::mb_firstlower($this->_datas['syns'][2]).'.';
                        $ret['description'][] = $this->_datas['dop'];

                    $file_name = 'model-defect2';

                    break;
                    case 'complect':

                        /*$ret['title'] = array(
                            tools::mb_firstupper($this->_datas['syns'][0])
                        );

                        $ret['title'][] = $this->_datas['marka']['name'];

                        if (!$level)
                        {
                            $ret['title'][] = $this->_datas['vsemodeli'];
                        }

                        $ret['title'][] = 'всех моделей';
                        $ret['title'][] = '-';

                        if (isset($this->_datas['price']))
                        {
                            $ret['title'][] = 'от';
                            $ret['title'][] = $this->_datas['price'];
                            $ret['title'][] = 'руб,';
                        }

                        $ret['title'][] = 'ремонт';

                        if (!$level)
                        {
                            $ret['title'][] = $this->_datas['model_type'][0]['name_rm'];
                        }
                        else
                        {
                            //$ret['title'][] = implode(', ', $this->_datas['model_type'][0]['name_rm']);
                        }

                        $ret['title'][] = 'в';
                        $ret['title'][] = $this->_datas['servicename'];*/

                        $ret['title'] = array(
                            tools::mb_firstupper($this->_datas['syns'][0])
                        );

                        if (!$level)
                        {
                            $ret['title'][] = $this->_datas['marka']['name'];
                            $ret['title'][] = $this->_datas['vsemodeli'];

                            $ret['title'][] = 'всех моделей';
                            $ret['title'][] = 'в '.$city;
                            $ret['title'][] = '—';
                            $ret['title'][] = 'ремонт';
                        }
                        else
                        {
                            $ret['title'][] = implode(', ', $this->_datas['model_type'][0]['name_rm']);
                            $ret['title'][] = $this->_datas['marka']['name'];

                            $ret['title'][] = 'в '.$city;
                            $ret['title'][] = '—';
                            $ret['title'][] = 'замена';

                        }

                        $ret['title'][] = 'в';
                        $ret['title'][] = $this->_datas['servicename'];

                        if (isset($this->_datas['price']))
                        {
                            $ret['title'][] = 'от';
                            $ret['title'][] = $this->_datas['price'].'р';
                        }

                        $ret['h1'] = array(
                        );

                        if (!$level)
                        {
                            $ret['h1'][] = $this->_datas['marka']['name'];
                            $ret['h1'][] = $this->_datas['vsemodeli'].':';
                        }
                        else
                        {
                            //$ret['h1'][] =  tools::mb_firstupper(implode(', ', $this->_datas['model_type'][1]['name_m']));
                            $ret['h1'][] = $this->_datas['marka']['name'].':';
                        }

                        $ret['h1'][] = tools::mb_firstlower($this->_datas['syns'][1]);

                        if (!$level)
                        {
                            $ret['h1'][] = $this->_datas['model_type'][1]['name_re'];
                        }

                        $ret['description'] = array(
                            tools::mb_firstupper($this->_datas['syns'][2])
                        );

                        if (!$level)
                        {
                            $ret['description'][] = $this->_datas['marka']['ru_name'];
                            $ret['description'][] = $this->_datas['ru_vsemodeli'].'.';
                        }
                        else
                        {
                            $ret['description'][] = implode(', ', $this->_datas['model_type'][2]['name_rm']);
                            $ret['description'][] = $this->_datas['marka']['ru_name'].'.';
                        }

                        $ret['description'][] = $this->_datas['dop'];

                    $file_name = 'model-complect2';

                    break;
                }
            }
        }

        if (isset($params['model_id']))
        {
            if (!isset($params['key']))
            {
                 /*$ret['title'] = array(
                    'Ремонт',
                    $this->_datas['model']['name'],
                    'в сервисном центре',
                    $this->_datas['servicename']
                 );*/

                 /*$ret['title'] = array(
                    'Ремонт',
                    $this->_datas['model_type'][0]['name_re'],
                    $this->_datas['model']['name'],
                    'в '.$city
                 );

                 if (isset($this->_datas['price']))
                 {
                     $ret['title'][] = 'от';
                     $ret['title'][] = $this->_datas['price'].'р';
                 }

                 $ret['title'][] = '—';
                 $ret['title'][] = $this->_datas['servicename'];*/


                $model_type_name = $this->_datas['model_type'][3]['name']; // тип устройства
                $model_type_name_re  = $this->_datas['model_type'][3]['name_re'];
                $model_name = $this->_datas['model']['name']; // название модели
                $servicename = $this->_datas['servicename']; //SONY Russia
                $region_name_pe = $this->_datas['region']['name_pe'];//в Москве (в Владивостоке)

                //$ret['title'] = array($this->firstup(trim("{$this->_datas['add_title']} $model_type_name_re $model_name в $servicename в $region_name_pe")));*/
                
                $ret['title'] = array(
                    'Ремонт',
                    $this->_datas['model_type'][0]['name_rm'],
                    $this->_datas['model']['name'],
                    '—',
                    'сервисный центр',
                    $this->_datas['marka']['ru_name'],
                    'в',
                    $city.', ',
                    'любой ремонт:',
                    $this->_datas['add_title']
                );                            
                         

                $ret['h1'] = array(
                    'Ремонт',
                    $this->_datas['model_type'][1]['name_rm'],
                    $this->_datas['model']['name']
                 );

                 $ret['description'] = array(
                    'Обслуживание и ремонт',
                    $this->_datas['model_type'][2]['name_rm'],
                    $this->_datas['marka']['ru_name'],
                    $this->_datas['m_model']['ru_name'],
                    $this->_datas['model']['submodel'],
                    'в '.$city.'.',
                    $this->_datas['dop']
                 );

                 $file_name = 'model2';
            }
            else
            {
                switch ($params['key'])
                {
                    case 'service':

                        /*$ret['title'] = array(
                            tools::mb_firstupper($this->_datas['syns'][0]),
                            $this->_datas['model']['name'],
                            'в сервисном центре',
                            $this->_datas['servicename']
                        );*/

                        /*$ret['title'] = array(
                            tools::mb_firstupper($this->_datas['syns'][0]),
                            $this->_datas['model_type'][0]['name_re'],
                            $this->_datas['model']['name'],
                            'в '.$city
                        );

                        if (isset($this->_datas['price']))
                        {
                            $ret['title'][] = 'за';
                            $ret['title'][] = $this->_datas['price'].'р';
                        }

                        $ret['title'][] = '—';
                        $ret['title'][] = $this->_datas['servicename'];*/


                        // Услуга М
                        $syns = tools::mb_firstupper($this->_datas['syns'][rand(0, 3)]); // название услуги , 4 варианта
                        $model_name = $this->_datas['model']['name']; // название модели
                        $marka = $this->_datas['marka']['name'];  // SONY
                        $servicename = $this->_datas['servicename']; //SONY Russia
                        $service_price = $this->_datas['price'];
                        $region_name = $this->_datas['region']['name'];

                        $service_m_title = array();
                        $service_m_title[] = array("$syns $model_name в ");
                        $service_m_title[] = array("сервисе","центре","сервисном центре","сервис центре","лаборатории");
                        $service_m_title[] = array("$servicename $region_name — $service_price руб"); // нужно уточнить как вытаскивать цену

                        $ret['title'] = array($this->firstup(trim($this->checkarray($service_m_title))));

                        $ret['h1'] = array(
                            tools::mb_firstupper($this->_datas['syns'][1]),
                            $this->_datas['model']['name']
                        );

                        $ret['description'] = array(
                            tools::mb_firstupper($this->_datas['syns'][2]),
                            $this->_datas['model_type'][2]['name_re'],
                            $this->_datas['marka']['ru_name'],
                            $this->_datas['m_model']['ru_name'],
                            $this->_datas['model']['submodel'],
                            'в '.$city.'.',
                            $this->_datas['dop']
                        );

                    $file_name = 'model-service2';

                    break;

                    case 'defect':

                        /*$ret['title'] = array(
                            tools::mb_firstupper($this->_datas['syns'][0]),
                            $this->_datas['model']['name'],
                            '-',
                            'ремонт в сервис центре',
                            $this->_datas['servicename']
                        );*/

                        /*$ret['title'] = array(
                            tools::mb_firstupper($this->_datas['syns'][0]),
                            $this->_datas['model']['name'],
                            '—',
                            'ремонт в',
                            $this->_datas['servicename']
                        );

                        if (isset($this->_datas['price']))
                        {
                            $ret['title'][] = 'от';
                            $ret['title'][] = $this->_datas['price'].'р';
                        };*/

                        // Неисправность М
                        $title_new = '';
                        $sql = "SELECT `title` FROM `{$this->_suffics}_dop_defect_model_urls`
                                    LEFT JOIN `{$this->_suffics}_defect_syns` ON
                                        `{$this->_suffics}_defect_syns`.`id` = `{$this->_suffics}_dop_defect_model_urls`.`{$this->_suffics}_defect_syn_id`
                                    WHERE `{$this->_suffics}_defect_syns`.`name`=:syn";

                        $stm = pdo::getPdo()->prepare($sql);
                        $stm->execute(array('syn' => $this->_datas['syns'][0]));
                        $title_new = $stm->fetchColumn();

                        //if ($this->_datas['site_name'] == 'acer.russia.expert' && $this->_datas['arg_url'] == 'remont-noutbukov/acer-aspire-e5-421g/polosi-na-monitore')
                        //{
                            //echo $this->_datas['syns'][0].' '.$title_new.' '.$sql;
                        //}

                        preg_match_all('#\{(.+?)\}#is', $title_new, $arr);

                        $str_val = array();

                        foreach ($arr[1] as $k => $arr_1_val)
                        {
                            $arr_1_val = explode('|', $arr_1_val);

                            foreach ($arr_1_val as $key => $val)
                            {
                               $arr_1_val[$key] = trim($val);
                            }

                            $str_val[$arr[0][$k]] = $arr_1_val[rand(0, count($arr_1_val)-1)];
                        }

                        $syns = tools::mb_firstupper($this->_datas['syns'][rand(0, 3)]); // название услуги , 4 варианта
                        $model_name = $this->_datas['model']['name']; // название модели
                        $servicename = $this->_datas['servicename']; //SONY Russia
                        $region_name = $this->_datas['region']['name'];//Москва
                        $region_name_a = $this->_datas['region']['translit1'];// Omsk

                        $malfunction_m_title_h2 = array();
                        $malfunction_m_title_h2[] = array("Информация о причинах неисправности","Причины неисправности","Симптомы неисправности","Возможные причины неисправности",
                            "Частые симптомы неисправности","Популярные симптомы неисправности","Популярные причины неисправности","Частые причины неисправности","Информация о причинах неисправности",
                            "Причины возникновения неисправности","Симптомы возникновения неисправности","Причины появления неисправности","Симптомы появления неисправности",
                            "Причины возникновения проблемы","Симптомы возникновения проблемы","Причины проблемы","Симптомы проблемы","Возможные причины проблемы","Частые симптомы проблемы",
                            "Популярные симптомы проблемы","Популярные причины проблемы","Частые причины проблемы","Информация о причинах проблемах","Причины возникновения проблемы",
                            "Симптомы возникновения проблемы","Причины появления проблемы","Симптомы появления проблемы","Информация о причинах данной неисправности","Причины данной неисправности",
                            "Симптомы данной неисправности","Возможные причины данной неисправности","Частые симптомы данной неисправности","Популярные симптомы данной неисправности",
                            "Популярные причины данной неисправности","Частые причины данной неисправности","Информация о причинах неисправности","Причины возникновения данной неисправности",
                            "Симптомы возникновения данной неисправности","Причины появления данной неисправности","Симптомы появления данной неисправности","Причины возникновения данной проблемы",
                            "Симптомы возникновения данной проблемы","Причины данной проблемы","Симптомы данной проблемы","Возможные причины данной проблемы","Частые симптомы данной проблемы",
                            "Популярные симптомы данной проблемы","Популярные причины данной проблемы","Частые причины данной проблемы","Информация о причинах данной проблемы",
                            "Причины возникновения данной проблемы","Симптомы возникновения данной проблемы","Причины появления данной проблемы","Симптомы появления данной проблемы");

                        $malfunction_m_title = array();
                        $malfunction_m_title[] = array("$syns");
                        $malfunction_m_title_a = mb_strtolower($this->checkarray($malfunction_m_title_h2));
                        $malfunction_m_title[] = array("$model_name — $malfunction_m_title_a");
                        $malfunction_m_title[] = array("по статистике $servicename $region_name_a","по статистике сервиса $servicename $region_name_a","по статистике центра $servicename $region_name_a");

                        if ($title_new)
                        {
                            $ret['title'] = array(str_replace(
                                array_merge(array('[brand]', '[model]', '[brandru]', '[modelru]'), array_keys($str_val)),
                                array_merge(array(
                                    $this->_datas['marka']['name'],
                                    $this->_datas['model']['name'],
                                    $this->_datas['marka']['ru_name'],
                                    $this->_datas['model']['ru_name'],
                                    ), array_values($str_val)),
                                $title_new
                            ));
                        }
                        else
                        {
                            $ret['title'] = array($this->firstup(trim($this->checkarray($malfunction_m_title))));
                        }

                        $ret['h1'] = array(
                            tools::mb_firstupper($this->_datas['model_type'][1]['name']),
                            $this->_datas['model']['name'].':',
                            tools::mb_firstlower($this->_datas['syns'][1])
                        );

                        $ret['description'] = array(
                            $this->_datas['marka']['ru_name'],
                            $this->_datas['m_model']['ru_name'],
                            $this->_datas['model']['submodel'],
                            tools::mb_firstlower($this->_datas['syns'][2]).'.',
                            $this->_datas['dop']
                        );

                    $file_name = 'model-defect2';

                    break;

                    case 'complect':

                        /*$ret['title'] = array(
                            tools::mb_firstupper($this->_datas['syns'][0]),
                            $this->_datas['model']['name'],
                            '-'
                        );*/

                        /*$ret['title'] = array(
                            tools::mb_firstupper($this->_datas['syns'][0]),
                            $this->_datas['model_type'][0]['name_re'],
                            $this->_datas['model']['name'],
                            'в '.$city
                        );

                        if (isset($this->_datas['price']))
                        {
                            $ret['title'][] = 'от';
                            $ret['title'][] = $this->_datas['price'].'р';
                        }

                        $ret['title'][] = '—';
                        $ret['title'][] = $this->_datas['servicename'];

                        /*$ret['title'][] = 'ремонт';
                        $ret['title'][] = $this->_datas['model_type'][0]['name_rm'];
                        $ret['title'][] = 'в';
                        $ret['title'][] = $this->_datas['servicename'];*/

                        $dat = $this->_datas['syns'][rand(0, 3)];
                        $marka = $this->_datas['marka']['name'];  // SONY
                        $model_name = $this->_datas['model']['name']; // название модели
                        $servicename = $this->_datas['servicename']; //SONY Russia
                        $region_name = $this->_datas['region']['name'];//Москва
                        $complect_price = $this->_datas['price'];

                        $accessories_m_title = array();
                        $accessories_m_title[] = array("$dat");
                        $accessories_m_title[] = array("для","");
                        $accessories_m_title[] = array("$model_name от $complect_price руб","$model_name с доставкой от $complect_price руб"); // узнать как вытаскивать цену
                        $accessories_m_title[] = array("на складе","в наличии","в наличии на складе","в центре","на складе центра","в");
                        $accessories_m_title[] = array("$servicename $region_name");

                        $ret['title'] = array($this->firstup(trim($this->checkarray($accessories_m_title))));

                        $ret['h1'] = array(
                            $this->_datas['model']['name'].':',
                            tools::mb_firstlower($this->_datas['syns'][1]),
                            $this->_datas['model_type'][1]['name_re']
                        );

                        $ret['description'] = array(
                            tools::mb_firstupper($this->_datas['syns'][2]),
                            $this->_datas['marka']['ru_name'],
                            $this->_datas['m_model']['ru_name'],
                            $this->_datas['model']['submodel'].'.',
                            $this->_datas['dop']
                        );

                    $file_name = 'model-complect2';

                    break;
                }
            }
        }

        $vars = array();
        $feed = (isset($this->_datas['vals']['feed']) ? $this->_datas['vals']['feed'] : $this->_datas['feed']);

        if (!isset($params['key']))
        {
            $choose_fix = rand(0,2);
            switch ($choose_fix)
            {
                case 0:
                    $vars[] = array('<p>Что бы ни случилось с вашим', '<p>Что бы ни произошло с вашим');
                break;
                case 1:
                    $vars[] = array('<p>Если вышел из строя ваш', '<p>Как бы сильно ни был поврежден ваш');
                break;
                case 2:
                    $vars[] = array('<p>Какой бы ни была неисправность вашего');
                break;
            }

            if (isset($params['model_id']))
                $vars[] = array($this->_datas['model']['name']);

            if (isset($params['marka_id']) && isset($params['model_type_id']))
            {
                $t_array = array();

                switch ($choose_fix)
                {
                    case 0:
                        foreach ($this->_datas['orig_model_type'] as $type)
                            $t_array[] = $type['name_de'];
                    break;
                    case 1:
                        foreach ($this->_datas['orig_model_type'] as $type)
                            $t_array[] = $type['name'];
                    break;
                    case 2:
                        foreach ($this->_datas['orig_model_type'] as $type)
                            $t_array[] = $type['name_re'];
                    break;
                }

                $vars[] = $t_array;
                $vars[] = array($this->_datas['marka']['name']);
            }

            $vars[] = array('- не беспокойтесь.', '- не переживайте.', '- не стоит расстраиваться.', '- все можно исправить.', '- всегда есть верное решение.');

            $vars[] = array('Специалисты', 'Профессионалы', 'В', 'В сервисе', 'Эксперты');
            $vars[] = array($this->_datas['servicename']);
            $vars[] = array('придут на помощь', 'помогут', 'окажут помощь', 'будут рядом');
            $vars[] = array('тогда, когда это будет необходимо.</p>', 'тогда, когда это будет нужно.</p>', 'тогда, когда это потребуется.</p>', 'незамедлительно.</p>', 'в самый нужный момент.</p>');

            $t_array = array();

            foreach ($this->_datas['orig_model_type'] as $type)
            {
                if (isset($params['model_id']))
                    $t_array[] = '<p>'.tools::mb_firstupper($type['name']).' '.$this->_datas['model']['ru_name'];

                if (isset($params['marka_id']) && isset($params['model_type_id']))
                {
                    if ($marka_lower == 'apple')
                    {
                        $t_array[] = '<p>'.$this->_datas['marka']['ru_name'].' '.$accord_apple_desc[$this->_suffics];
                    }
                    else
                    {
                        $t_array[] = '<p>'.tools::mb_firstupper($type['name']).' '.$this->_datas['marka']['ru_name'];
                    }
                }
            }

            if (isset($params['model_id']))
                $t_array[] = '<p>'.$this->_datas['model']['ru_name'];

            $vars[] = $t_array;

            $vars[] = array('отличается своей надежностью.', 'отличает надежность и долговечность.', 'отличает длительная работоспособность.', 'прослужит вам долго.', 'будет работать долго.');

            $vars[] = array('Но не забывайте, что как и любой технике, ему',
                        'Но помните, всякой технике, в том числе и этой,',
                        'Но это не исключает того, что при эксплуатации каждому устройству',
                        'Но помните, в течение срока использования аппарату',
                        'Но не стоит забывать, что каждому устройству');

            $vars[] = array('требуется профилактика,', 'нужна профилактика,', 'необходима профилактика,', 'будет полезна профилактика,', 'не помешает профилактика,');
            $vars[] = array('а в некоторых случаях -', 'а иногда', 'а в особых случаях', 'а временами', 'а в крайнем случае');
            $vars[] = array('и сервисное обслуживание.</p>', 'и ремонт, и обслуживание.</p>', 'и обслуживание в сервис центре.</p>', 'и ремонт в сервис центре.</p>', 'и специализированное обслуживание.</p>');
        }
        else
        {
            switch ($params['key'])
            {

                case 'service':

                    $vars[] = array('<p>Исходя из статистики', '<p>По статистике', '<p>По нашему опыту', '<p>По частоте обращений', '<p>По нашим данным');
                    $vars[] = array('услуга');
                    $vars[] = array('по');
                    $vars[] = array(tools::skl('service', $this->_suffics, $this->_datas['syns'][0], 'dat'));

                    $t_array = array();

                    if (!$level)
                    {
                        foreach ($this->_datas['orig_model_type'] as $type)
                            $t_array[] = $type['name_re'];
                    }
                    else
                    {
                        foreach ($this->_datas['orig_model_type'] as $type)
                            $t_array[] = tools::commit($type['name_re']);
                    }

                    $vars[] = $t_array;

                    $vars[] = array('является одной из самых', ' - одна из самых', ' - одна из наиболее');
                    $vars[] = array('популярных.', 'востребованных.', 'запрашиваемых.');

                    $vars[] = array('Мы - ');
                    $vars[] = array('эксперты', 'профессионалы', 'специалисты');
                    $vars[] = array('в данном вопросе,', 'в этом деле,');
                    $vars[] = array('и знаем, что делать.</p>', 'и точно справимся с задачей.</p>', 'и мы вам поможем.</p>', 'для нас нет невозможного.</p>', 'в этом вы можете быть уверены.</p>');

                    $vars[] = array('<p>С','<p>В');
                    $vars[] = array($this->_datas['servicename'], $this->_datas['ru_servicename']);
                    $vars[] = array('вы получите', 'вам гарантирован', 'вам обеспечен');
                    $vars[] = array('не только');
                    $vars[] = array('качественный', 'квалифицированный', 'надежный');
                    $vars[] = array('ремонт');
                    $vars[] = array('вашего');

                    if (isset($params['model_id']))
                        $vars[] = array($this->_datas['model']['ru_name'].',');

                    if (isset($params['marka_id']) && isset($params['model_type_id']))
                    {
                        $t_array = array();

                        if (!$level)
                        {
                            foreach ($this->_datas['orig_model_type'] as $type)
                                $t_array[] = $type['name_re'];
                        }
                        else
                        {
                            foreach ($this->_datas['orig_model_type'] as $type)
                                $t_array[] = tools::commit($type['name_re'], 'или');
                        }

                        $vars[] = $t_array;

                        $vars[] = array($this->_datas['marka']['ru_name'].',');
                    }

                    $vars[] = array('но');
                    $vars[] = array('и');
                    $vars[] = array('клиентское обслуживание', 'клиентский сервис');
                    $vars[] = array('самого высокого', 'европейского', 'высочайшего', 'топ -');
                    $vars[] = array('уровня.</p>', 'класса.</p>', 'качества.</p>');

                break;

                case 'defect':

                    $vars[] = array('<p>В');
                    $vars[] = array('сервисе', 'сервисном центре', 'сервис центре');
                    $vars[] = array($this->_datas['marka']['name'], $this->_datas['marka']['ru_name'], $this->_datas['servicename'], $this->_datas['ru_servicename']);
                    $vars[] = array('наши');
                    $vars[] = array('специалисты', 'мастера', 'эксперты', 'тех-инженеры');
                    $vars[] = array('ежедневно', 'постоянно', 'регулярно', 'каждый день');
                    $vars[] = array('имеют дело', 'сталкиваются');
                    $vars[] = array('с самыми разными', 'со всеми распространенными', 'со всеми возможными', 'с различными', 'с самыми разнообразными');
                    $vars[] = array('типами', 'видами', 'вариантами');

                    $t_array = array();
                    $t1 = array('поломок', 'неисправностей', 'дефектов', 'повреждений');
                    $t2 = array('Проблема', 'Неисправность');
                    $t1_count = count($t1);
                    $t2_count = count($t2);

                    for ($i=0; $i<$t1_count; $i++)
                    {
                        for ($k=0; $k<$t2_count; $k++)
                        {
                            if ($i != 1 || $k != 1) $t_array[] = $t1[$i].'. '.$t2[$k];
                        }
                    }

                    for ($i=0; $i<$t1_count; $i++)
                    {
                         for ($j=0; $j<$t1_count; $j++)
                         {
                            for ($k=0; $k<$t2_count; $k++)
                            {
                                if ($i != $j && ($k != 1 || $j != 1)) $t_array[] = $t1[$i].' и '.$t1[$j].'. '.$t2[$k];
                            }
                         }
                    }

                    $vars[] = $t_array;

                    $vars[] = array('"'.tools::mb_firstlower($this->_datas['syns'][0]).'"');
                    $vars[] = array('для');

                    $t_array = array();

                    if (!$level)
                    {
                        foreach ($this->_datas['orig_model_type'] as $type)
                            $t_array[] = $type['name_re'];
                    }
                    else
                    {
                        foreach ($this->_datas['orig_model_type'] as $type)
                            $t_array[] = tools::commit($type['name_re'], 'или');
                    }

                    $vars[] = $t_array;

                    if (isset($params['model_id']))
                        $vars[] = array($this->_datas['model']['ru_name']);

                    if (isset($params['marka_id']) && isset($params['model_type_id']))
                        $vars[] = array($this->_datas['marka']['ru_name']);

                    $vars[] = array('одна из них.</p>', 'как раз тот случай.</p>', 'типовой случай.</p>', 'не исключение.</p>', 'является типичной.</p>', 'как раз из их числа.</p>', 'является типовой.</p>');

                    $vars[] = array('<p>Будьте спокойны', '<p>Не волнуйтесь', '<p>Не переживайте', '<p>Будьте уверены');
                    $vars[] = array('мы');
                    $vars[] = array('все исправим.', 'поможем вам с этим.', 'решим данный вопрос.', 'справимся с этим.');

                    $vars[] = array('Сделайте заказ', 'Звоните', 'Приезжайте', 'Оставьте заявку', 'Запишитесь на ремонт');
                    $vars[] = array('и');
                    $vars[] = array('мы');
                    $vars[] = array('отремонтируем ваш', 'починим ваш', 'восстановим ваш', 'исправим');

                    if (isset($params['model_id']))
                        $vars[] = array($this->_datas['model']['name']);

                    if (isset($params['marka_id']) && isset($params['model_type_id']))
                    {
                        $t_array = array();

                        if (!$level)
                        {
                            foreach ($this->_datas['orig_model_type'] as $type)
                                $t_array[] = $type['name'];
                        }
                        else
                        {
                            foreach ($this->_datas['orig_model_type'] as $type)
                                $t_array[] = tools::commit($type['name'], 'или');
                        }

                        $vars[] = $t_array;

                        $vars[] = array($this->_datas['marka']['name']);
                    }

                    $vars[] = array('в самое ближайшее время.</p>', 'в самые сжатые сроки.</p>', 'в самые короткие сроки.</p>', 'в кратчайшие сроки.</p>', 'в наикратчайшие сроки.</p>', 'уже совсем скоро.</p>');

                break;

                case 'complect':

                    $vars[] = array('<p>Каждый день', '<p>Ежедневно', '<p>Регулярно');
                    $vars[] = array('в');
                    $vars[] = array('сервисе', 'сервисном центре', 'сервис центре');
                    $vars[] = array($this->_datas['marka']['name'], $this->_datas['marka']['ru_name'], $this->_datas['servicename'], $this->_datas['ru_servicename']);
                    $vars[] = array('в наличии');
                    $vars[] = array('имеется', 'находится');
                    $vars[] = array('более', 'свыше', '>');
                    $vars[] = array('6000', '7000', '8000', '9000', '6 тысяч', '7 тысяч', '8 тысяч', '9 тысяч');
                    $vars[] = array('наименований', 'единиц');
                    $vars[] = array('оригинальных', 'фирменных');
                    $vars[] = array('комплектующих', 'запчастей', 'деталей и запчастей');
                    $vars[] = array('в том числе');
                    $vars[] = array('и');
                    $vars[] = array('для');
                    $vars[] = array('модели', 'устройства', 'аппарата');

                    if (isset($params['model_id']))
                        $vars[] = array($this->_datas['model']['name'].'.</p>');

                    if (isset($params['marka_id']) && isset($params['model_type_id']))
                        $vars[] = array($this->_datas['marka']['name'].'.</p>');

                    $vars[] = array('<p>Приобрести', '<p>Купить', '<p>Заказать', '<p>Сделать заказ на');
                    $vars[] = array(tools::skl('complect', $this->_suffics, $this->_datas['syns'][0], 'vin'));
                    $vars[] = array('для вашего');

                    $t_array = array();

                    if (!$level)
                    {
                        foreach ($this->_datas['orig_model_type'] as $type)
                            $t_array[] = $type['name_re'];
                    }
                    else
                    {
                        foreach ($this->_datas['orig_model_type'] as $type)
                            $t_array[] = tools::commit($type['name_re'], 'или');
                    }

                    $vars[] = $t_array;

                    $vars[] = array($this->_datas['marka']['name'], $this->_datas['marka']['ru_name']);
                    $vars[] = array('вы');
                    $vars[] = array('можете');
                    $vars[] = array('предварительно', 'заранее');
                    $vars[] = array('уточнив');
                    $vars[] = array('сведения', 'информацию', 'данные');
                    $vars[] = array('у наших менеджеров.</p>', 'у наших специалистов.</p>', 'у наших операторов.</p>', 'у сотрудников call-центра.</p>', 'у менеджеров колл-центра.</p>', 'у специалистов колл-центра.</p>');

                break;
            }
        }

        $station = tools::get_station($this->_datas['site_name'], tools::gen_feed($this->_datas['site_name']));

        srand($feed);
        $choose = rand(0, 3);
        srand();

        switch ($choose)
        {
            case 0:
                $vars2[] = array('<p>Работаем только на', '<p>Ремонт производим на', '<p>Ремонт производится на', '<p>Ремонтируем на');
                $t1 = array('современном', 'профессиональном', 'высокопрофессиональном', 'специализированном', 'новейшем', 'оригинальном');
                $t2 = array('оборудовании:', 'спецоборудовании:');
            break;
            case 1:
                $vars2[] = array('<p>Для ремонта используется', '<p>В ремонте используем');
                $t1 = array('современное', 'профессиональное', 'высокопрофессиональное', 'специализированное', 'новейшее', 'оригинальное');
                $t2 = array('оборудование:', 'спецоборудование:');
            break;
            case 2:
                $vars2[] = array('<p>Работаем только на', '<p>Ремонт производим на', '<p>Ремонт производится на', '<p>Ремонтируем на');
                $t1 = array('современной', 'профессиональной', 'высокопрофессиональной', 'специализированной', 'новейшей', 'оригинальной');
                $t2 = array('технике:');
            break;
            case 3:
                $vars2[] = array('<p>Для ремонта используется');
                $t1 = array('современная', 'профессиональная', 'высокопрофессиональная', 'специализированная', 'новейшая', 'оригинальная');
                $t2 = array('техника:');
            break;
            case 4:
                $vars2[] = array('<p>В ремонте используем');
                $t1 = array('современную', 'профессиональную', 'высокопрофессиональную', 'специализированную', 'новейшую', 'оригинальную');
                $t2 = array('технику:');
            break;
        }

        $t_array = array();
        $t1_count = count($t1);

        for($i=0; $i<$t1_count; $i++)
        {
           for($j=0; $j<$t1_count; $j++)
           {
                if ($i != $j) $t_array[] = $t1[$i].', '.$t1[$j];
           }
        }
        $vars2[] = $t_array;

        $vars2[] = $t2;

        $t_array = array();
        $t1 = array('паяльные станции '.$station[0], 'ремонтные системы '.$station[0], 'ремонтные станции '.$station[0], 'паяльные системы '.$station[0],
                            'паяльные станции '.$station[0], 'ремонтные системы '.$station[0], 'ремонтные станции '.$station[0], 'паяльные системы '.$station[0]);

        $t2 = array('инфракрасные');
        $t3 = array('с ИК нагревом', 'с ИК подогревом', 'с верхним/нижним ИК подогревом', 'с верхним/нижним ИК нагревом', 'с нижним/верхним ИК подогревом',
                'с нижним/верхним ИК нагревом', 'для монтажа BGA элементов', 'для монтажа BGA компонент', 'для монтажа/демонтажа BGA компонент',
                    'для монтажа BGA элементов');

        $t1_count = count($t1);
        $t2_count = count($t2);
        $t3_count = count($t3);

        for($i=0; $i<$t1_count; $i++)
        {
            for ($j=0; $j<$t2_count; $j++)
                $t_array[] = $t2[$j].' '.$t1[$i].';';

            for ($j=0; $j<$t3_count; $j++)
                $t_array[] = $t1[$i].' '.$t3[$j].';';
        }

        $vars2[] = $t_array;

        $t_t = array();
        $t_t[] = array('трафарет для реболла BGA',	'оригинальные BGA трафареты', 'BGA трафареты под все разъемы',
                                'BGA трафареты под любые сокеты', 'BGA трафареты под все чипы');
        $t_t[] = array('тестеры', 'тестовые карты', 'наборы разъемов для тестирования', 'брендовые тестеры', 'тестовое оборудование/карты');

        $t2 = array('осциллографы', 'осциллографы-мультимерты', 'цифровые осциллографы');
        $t3 = array();
        foreach ($t2 as $t2_value)
            foreach ($station[3] as $osc)
                $t3[] = $t2_value.' '.$osc;

        $t3[] = 'многоканальные осциллографы';
        $t3[] = 'осциллографы-мультимерты';
        $t_t[] = $t3;

        $t_t[] = array('программаторы', 'фирменные программаторы',	'программаторы Motorola', 'кабели программирования Motorola', 'кабели программирования');

        $t2 = array('микроскопы', 'цифровые микроскопы', 'бинокулярные микроскопы');
        $t3 = array();
        foreach ($t2 as $t2_value)
            foreach ($station[1] as $osc)
                $t3[] = $t2_value.' '.$osc;

        $t3[] = 'микроскопы';
        $t3[] = 'цифровые микроскопы';
        $t_t[] = $t3;

        $t2 = array('паяльные станции', 'термовоздушные паяльники', 'многофункциональные паяльные станции');
        $t3 = array();
        foreach ($t2 as $t2_value)
            foreach ($station[2] as $osc)
                $t3[] = $t2_value.' '.$osc;

        $t3[] = 'термовоздушные паяльные станции';
        $t3[] = 'термовоздушные паяльные системы';
        $t_t[] = $t3;

        $t_t[]= array('ультразвуковые ванны', 'ультразвуковые ванны/мойки',
                    'ультразвуковые очистители', 'ультразвуковые ванны-очистители', 'ультразвуковые мойки');

        $t_t_index = array();
        for($i=0; $i<count($t_t); $i++)
            $t_t_index[] = $i;

        srand($feed);
        $t_count = rand(3, 5);
        srand();
        $t_keys = rand_it::randMas($t_t_index, $t_count, '', $feed);

        $t_keys_count = count($t_keys);
        for($i=0; $i<$t_keys_count; $i++)
        {
            $sign = ($i == ($t_keys_count - 1)) ? '.<p>' : ';';
            $ind = $t_keys[$i];

            for($j=0; $j<count($t_t[$ind]); $j++)
                $t_t[$ind][$j] = $t_t[$ind][$j].$sign;

            $vars2[] = $t_t[$ind];
        }

        if ((!$this->_datas['region_id'] && isset($params['model_id']) && !isset($params['key'])) || $this->_datas['region_id'])
        {
            $vars2[] = array('<p>Всегда', '<p>Все время', '<p>У нас');
            $vars2[] = array('в наличии', 'есть', 'в достаточном количестве', 'в большом количестве');
            $vars2[] = array('расходные материалы:', 'все расходники:', 'все расходные материалы:', 'любые расходные материалы:');

            $t_t = array();
            $t_t[] = array('ШИМы', 'ШИМ контроллеры', 'PWM контроллеры', 'ШИМ (PWM) контроллеры', 'ШИМ-контроллеры', 'контроллеры PWM');
            $t_t[] = array('микросхемы', 'чипы', 'оригинальные чипы', 'микросхемы', 'оригинальные чипы/микросхемы');
            $t_t[] = array('транзисторы', 'диоды/транзисторы', 'конденсаторы, транзисторы', 'конденсаторы, диоды', 'резисторы, транзисторы, конденсаторы',
                        'резисторы, конденсаторы');
            $t_t[] = array('термопасты', 'термопрокладки', 'термоклей', 'термоскотч', 'термоклеи/термопасты', 'термопасты, термопрокладки');
            $t_t[] = array('BGA шары для реболла', 'BGA шарики разного диаметра', 'BGA шарики', 'свинцовые BGA шары',
                    'BGA шарики для реболлла', 'свинцовые BGA шары для реболла');
            $t_t[] = array('флюс', 'BGA флюс', 'флюс BGA');
            $t_t[] = array('винты', 'наборы винтов', 'микровинты');
            $t_t[] = array('сокеты', 'сокеты для материнских плат', 'сокеты для плат', 'сокеты материнских плат',
                        'сокеты плат');
            $t_t[] = array('разъемы', 'разъемы питания', 'разъемы, шлейфы', 'шлейфы, разъемы питания', 'разъемы платы, шлейфы', 'шлейфы, разъемы');
            $t_t[] = array('штекеры', 'штекеры и шнуры питания', 'оплетки; штекеры', 'спреи', 'спреи, очищающие жидкости', 'штекеры, оплетки, спреи');
            $t_t[] = array('процессоры', 'микропроцессоры', 'CPU', 'процессоры (CPU)');
            $t_t[] = array('жесткие диски', 'ssd/hdd носители', 'ssd, hdd винчестеры', 'ssd, hdd диски', 'жесткие ssd/hdd диски',
                        'ssd, hdd диски разных объемов');
            $t_t[] = array('оперативная память', 'ОЗУ',	'комплекты ОЗУ', 'оперативная память (ОЗУ)', 'ОЗУ (оперативная память)', 'наборы ОЗУ');

            $t_t_index = array();
            for($i=0; $i<count($t_t); $i++)
                $t_t_index[] = $i;

            srand($feed);
            $t_count = rand(4, 7);
            srand();
            $t_keys = rand_it::randMas($t_t_index, $t_count, '', $feed);

            $t_keys_count = count($t_keys);
            for($i=0; $i<$t_keys_count; $i++)
            {
                $sign = ($i == ($t_keys_count - 1)) ? '.<p>' : ';';
                $ind = $t_keys[$i];

                for($j=0; $j<count($t_t[$ind]); $j++)
                    $t_t[$ind][$j] = $t_t[$ind][$j].$sign;

                $vars2[] = $t_t[$ind];
            }
        }

        if ($this->_datas['region_id'])
        {
            $block1 = array();
            $block1[] = array('получить консультацию', 'проконсультироваться', 'получить детальную консультацию',
                        'получить предметную консультацию', 'получить более детальную консультацию',
                        'получить более предметную консультацию', 'получить оперативную консультацию');
            $block1[] = array('по');
            $block1[] = array('вопросам',	'интересующим вас вопросам', 'возникшим у вас вопросам', 'появившимся у вас вопросам');

            $complect = false;

            if (isset($params['key']))
                if ($params['key'] == 'complect')
                    $complect = true;

            if ($complect)
            {
                $block1[] = array('ремонта', 'стоимости ремонта', 'сроков ремонта', 'времени ремонта',
                        'стоимости и сроков ремонта', 'стоимости и времени ремонта', 'сроков и стоимости ремонта',
                        'времени и стоимости ремонта', 'стоимости услуг', 'стоимости и сроков услуг', 'стоимости и времени услуг',
                        'сроков и стоимости услуг', 'времени и стоимости услуг');
            }
            else
            {
                $block1[] = array('стоимости запчастей', 'стоимости комплектующих', 'наличия комплектующих', 'наличия запчастей',
                        'стоимости и наличия запчастей', 'стоимости и наличия комплектующих', 'наличия и стоимости запчастей',
                            'наличия и стоимости комплектующих');

            }

            $block2 = array();
            $block2[] = array('записаться на ремонт');

            $choose = rand(0, 1);
            switch ($choose)
            {
                case 0:
                    $text_form = array_merge($block1, array(array('и', 'или')), $block2);
                break;
                case 1:
                    $text_form = array_merge($block2, array(array('и', 'или')), $block1);
                break;
            }

            $text_form[] = array('вы можете', 'можно');
            $text_form[] = array('у наших менеджеров', 'у наших специалистов', 'у наших операторов', 'у сотрудников call-центра', 'у менеджеров колл-центра',
                'у специалистов колл-центра', 'у менеджеров '. $this->_datas['servicename'], 'у специалистов '. $this->_datas['servicename'], 'у операторов '. $this->_datas['servicename'],
                'у операторов call-центра '. $this->_datas['servicename'], 'у сотрудников call-центра '. $this->_datas['servicename'], 'у менеджеров колл-центра '. $this->_datas['servicename'],
                'у специалистов колл-центра '. $this->_datas['servicename'], 'у менеджеров сервиса '. $this->_datas['servicename'], 'у специалистов сервиса '. $this->_datas['servicename'],
                'у операторов сервиса '. $this->_datas['servicename'], 'у операторов call-центра '. $this->_datas['servicename'], 'у сотрудников call-центра '. $this->_datas['servicename'],
                'у менеджеров колл-центра '. $this->_datas['servicename'], 'у специалистов колл-центра '. $this->_datas['servicename'], 'у менеджеров сервисного центра '. $this->_datas['servicename'],
                'у специалистов сервисного центра '. $this->_datas['servicename'], 'у операторов сервисного центра '. $this->_datas['servicename'], 'у менеджеров сервисного центра',
                'у специалистов сервисного центра', 'у операторов сервисного центра');

            $text_form[] = array('по телефону', 'по номеру телефона',
                'по единому телефону', 'по единому номеру телефона', 'по многоканальному телефону',
                'по многоканальному номеру телефона');

            $text_form[] = array('в '.$this->_datas['region']['name_pe'], 'в '.$this->_datas['region']['name_pe'].':', 'в '.$this->_datas['region']['name_pe'].' - ');

            $this->_datas['text-form'] = tools::mb_ucfirst(sc::_createTree($text_form, $feed), 'utf-8', false);
        }

        foreach (array('h1', 'title', 'description') as $key)
            if (isset($ret[$key])) $ret[$key] = implode(' ', $ret[$key]);

        $ret['img'] = $this->_datas['img'];
        $ret['text'] = sc::_createTree($vars, $feed);

        $this->_datas['vars2'] = sc::_createTree($vars2, $feed);

        $this->_ret = $this->_answer($answer, $ret);

        //hack dops
       $sql = "SELECT `title`, `h1` FROM `dop_urls`
             LEFT JOIN `marka_to_sites` ON `dop_urls`.`site_id` = `marka_to_sites`.`site_id`
             LEFT JOIN `sites` ON `marka_to_sites`.`site_id` = `sites`.`id`
                WHERE `sites`.`setka_id`=:setka_id AND `marka_to_sites`.`marka_id`=:marka_id AND (`sites`.`region_id` = 0 OR `sites`.`region_id` IS NULL)
                AND `dop_urls`.`name`=:url";

        $stm = pdo::getPdo()->prepare($sql);
        $stm->execute(array('setka_id' => $this->_datas['setka_id'], 'marka_id' => $this->_datas['marka']['id'], 'url' => $this->_datas['arg_url']));
        $new_array = current($stm->fetchAll(\PDO::FETCH_ASSOC));

        //if ($this->_datas['site_name'] == 'zte.russia.expert') print_r($this->_datas);

        if ($new_array)
        {
            if ($new_array['title'])
            {
                $this->_ret['title'] = str_replace('[city]', $city, $new_array['title']);
            }

            if ($new_array['h1'])
            {
                $this->_ret['h1'] = str_replace('[city]', $city, $new_array['h1']);
            }
        }

        $host = explode('.', $this->_datas['site_name']);
        $count = count($host);
        if (!$this->_ret['img'] && $count == 3)
        {
              $sql = "SELECT `url` FROM `imgs` INNER JOIN `sites` ON `sites`.`id` = `imgs`.`site_id` WHERE `sites`.`name` = ? AND `imgs`.`marka_id`= ? AND `imgs`.`model_type_id` = ?";
              $stm = pdo::getPdo()->prepare($sql);
              $stm->execute(array($host[$count-2].".".$host[$count-1], $this->_datas['marka']['id'], $this->_datas['model_type']['id']));
              $this->_ret['img']  = $stm->fetchColumn();
        }
        
        
        $this->_sdek();
        $body = $this->_body($file_name, basename(__FILE__, '.php'));

        //return array('title' => $this->_ret['title'], 'description' => $this->_ret['description'], 'body' => $body);
        return array('body' => $body);
    }

    protected function _normalize_addresis($addresis)
    {
        $current_key = false;
        foreach ($addresis as $key => $value)
        {
            if ($value['site'] == $this->_datas['site_name'])
            {
                $current_key = $key;
                break;
            }
        }

        if ($current_key !== false)
        {
            $t = $addresis[$current_key];
            unset($addresis[$current_key]);
            array_unshift($addresis, $t);
        }
        return $addresis;
    }
    
    protected function _pay_addr()
    {
        $addresis = $this->_datas['addresis'];
        $region_name = $this->_datas['region']['name'];
        
        $upper = array($region_name, 'Москва', 'Санкт-Петербург');
        
        foreach ($addresis as $value)
        {
            if ($value['email'] != 'litovchenko@list.ru' && $value['email']) $upper[] = $value['region_name'];
        }
        
        $upper = array_unique($upper);        
        
        foreach ($addresis as $value)
        {
           if (!$value['region_name']) 
           {
                $value['region_name'] = 'Москва';
                $value['region_name_pe'] = 'Москве';
           }
           
           //if ($value['email'] == 'litovchenko@list.ru') $value['phone'] = '78003506058';
           
           $key = array_search($value['region_name'], $upper);
           
           if ($key !== false)
           {
               $first_mas[] = $value;    
           }  
        }
        
        $first_mas = array_slice($first_mas, 0, 8);
        
        return $first_mas;
    }

    private function _make_accord_table($marka_lower)
    {
        $urls = array(
            'acer' => array('remont-naushnikov','remont-monoblokov','remont-proektorov', 'remont-kompyuterov', 'remont-televizorov', 'remont-monitorov'),
            'alcatel' => array('remont-telefonov','remont-smartfonov'),
            'apple' => array('remont-naushnikov','remont-monoblokov', 'remont-apple-watch', 'remont-kompyuterov', 'remont-televizorov', 'remont-printerov', 'remont-monitorov'),
            'ariston' => array('remont-holodilnikov','remont-stiralnyh-mashin','remont-posudomoechnyh-mashin'),
            'asus' => array('remont-naushnikov','remont-monoblokov', 'remont-materinskih-plat', 'remont-kompyuterov', 'remont-televizorov', 'remont-monitorov','remont-proektorov'),
            'bbk' => array('remont-televizorov'),
            'bosch' => array('remont-holodilnikov','remont-stiralnyh-mashin','remont-pylesosov','remont-posudomoechnyh-mashin'),
            'canon' => array('remont-printerov', 'remont-fotoapparatov','remont-proektorov', 'remont-monitorov'),
            'compaq' => array('remont-monoblokov', 'remont-kompyuterov', 'remont-monitorov'),
            'dell' => array('remont-naushnikov','remont-monoblokov','remont-proektorov', 'remont-kompyuterov', 'remont-printerov', 'remont-monitorov','remont-serverov'),
            'electrolux' => array('remont-holodilnikov', 'remont-stiralnyh-mashin','remont-posudomoechnyh-mashin'),
            'epson' => array('remont-printerov','remont-proektorov', 'remont-televizorov'),
        	'fly' => array('remont-telefonov','remont-smartfonov'),
        	'hp' => array('remont-naushnikov','remont-monoblokov', 'remont-kompyuterov', 'remont-printerov', 'remont-televizorov', 'remont-monitorov','remont-proektorov','remont-serverov'),
        	'indesit' => array('remont-holodilnikov', 'remont-stiralnyh-mashin','remont-posudomoechnyh-mashin'),
        	'lenovo' => array('remont-naushnikov','remont-monoblokov', 'remont-kompyuterov', 'remont-televizorov', 'remont-printerov', 'remont-monitorov','remont-proektorov','remont-serverov'),
        	'lg' => array('remont-naushnikov','remont-televizorov','remont-proektorov', 'remont-kompyuterov', 'remont-printerov', 'remont-monitorov'),
        	'msi' => array('remont-naushnikov','remont-monoblokov', 'remont-materinskih-plat', 'remont-kompyuterov', 'remont-monitorov'),
        	'nikon' => array('remont-fotoapparatov'),
        	'panasonic' => array('remont-fotoapparatov', 'remont-holodilnikov', 'remont-televizorov', 'remont-printerov', 'remont-kompyuterov', 'remont-televizorov', 'remont-printerov'),
        	'philips' => array('remont-monitorov', 'remont-televizorov', 'remont-printerov', 'remont-pylesosov', 'remont-televizorov', 'remont-printerov', 'remont-monitorov'),
        	'samsung' => array('remont-naushnikov','remont-monoblokov', 'remont-monitorov', 'remont-televizorov', 'remont-samsung-gear', 'remont-kompyuterov', 'remont-printerov','remont-proektorov'),
        	'sony' => array('remont-naushnikov','remont-monoblokov', 'remont-ultrabukov', 'remont-pristavok', 'remont-fotoapparatov', 'remont-videocamer', 'remont-televizorov','remont-proektorov','remont-kompyuterov', 'remont-printerov'),
        	'xiaomi' => array('remont-televizorov', 'remont-noutbukov', 'remont-ekshen-kamer', 'remont-robotov-pylesosov', 'remont-naushnikov', 'remont-elektrosamokatov', 'remont-printerov','remont-proektorov'),
            'nokia' => array('remont-naushnikov'),
			'toshiba' => array('remont-naushnikov','remont-televizorov', 'remont-kompyuterov', 'remont-printerov', 'remont-monitorov','remont-proektorov'),
            'candy' => array('remont-holodilnikov','remont-stiralnyh-mashin','remont-posudomoechnyh-mashin'),
            'siemens' => array('remont-holodilnikov','remont-stiralnyh-mashin','remont-posudomoechnyh-mashin'),
            'gorenje' => array('remont-holodilnikov','remont-stiralnyh-mashin','remont-posudomoechnyh-mashin'),
            'hansa' => array('remont-holodilnikov','remont-stiralnyh-mashin','remont-posudomoechnyh-mashin'),
            'zanussi' => array('remont-holodilnikov','remont-stiralnyh-mashin','remont-posudomoechnyh-mashin'),
            'aeg' => array('remont-holodilnikov','remont-stiralnyh-mashin','remont-posudomoechnyh-mashin'),
            'miele' => array('remont-holodilnikov','remont-stiralnyh-mashin','remont-posudomoechnyh-mashin'),
            'atlant' => array('remont-holodilnikov','remont-stiralnyh-mashin'),
            'kaiser' => array('remont-holodilnikov','remont-stiralnyh-mashin','remont-posudomoechnyh-mashin'),
            'ardo' => array('remont-holodilnikov','remont-stiralnyh-mashin','remont-posudomoechnyh-mashin'),
            'vestfrost' => array('remont-holodilnikov','remont-stiralnyh-mashin','remont-posudomoechnyh-mashin'),
            'beko' => array('remont-holodilnikov','remont-stiralnyh-mashin','remont-posudomoechnyh-mashin'),
            'htc' => array('remont-naushnikov','remont-televizorov'),
			'huawei' => array('remont-naushnikov','remont-televizorov', 'remont-printerov','remont-serverov'),
			'vertu' => array('remont-telefonov'),
            'oneplus' => array('remont-naushnikov','remont-smartfonov'),
            'zte' => array('remont-naushnikov','remont-proektorov'),
            'meizu' => array('remont-naushnikov'),
            'delonghi' => array('remont-coffee-machin','remont-posudomoechnyh-mashin','remont-pylesosov','remont-obogrevatelej'),
            'cisco' => array('remont-serverov'),
            'ibm' => array('remont-serverov'),
            'oracle' => array('remont-serverov'),
            'intel' => array('remont-serverov'),
            'inspur' => array('remont-serverov'),
            'supermicro' => array('remont-serverov'),
            'nec' => array('remont-serverov'),
            'airwheel' => array('remont-elektrosamokatov','remont-giroskuterov','remont-monokoles','remont-segveev' ),
            'globber' => array('remont-elektrosamokatov'),
            'halten' => array('remont-elektrosamokatov'),
            'hiper' => array('remont-elektrosamokatov','remont-proektorov'),
            'hoverbot' => array('remont-elektrosamokatov','remont-giroskuterov','remont-monokoles','remont-segveev' ),
            'iconbit' => array('remont-elektrosamokatov','remont-giroskuterov','remont-naushnikov','remont-planshetov','remont-smartfonov'),
            'inmotion' => array('remont-elektrosamokatov','remont-giroskuterov','remont-monokoles','remont-segveev' ),
            'kingsong' => array('remont-elektrosamokatov','remont-monokoles'),
            'kugoo' => array('remont-elektrosamokatov'),
            'ninebot' => array('remont-elektrosamokatov','remont-giroskuterov','remont-monokoles','remont-segveev' ),
            'polaris' => array('remont-elektrosamokatov','remont-giroskuterov'),
            'razor' => array('remont-elektrosamokatov','remont-giroskuterov'),
            'zaxboard' => array('remont-elektrosamokatov','remont-giroskuterov','remont-segveev' ),
            'infocus' => array('remont-proektorov'),
            'optoma' => array('remont-proektorov'),
            'leica' => array('remont-fotoapparatov'),
            'olympus' => array('remont-fotoapparatov'),
            'fujitsu' => array('remont-noutbukov','remont-smartfonov','remont-kompyuterov','remont-monoblokov','remont-planshetov','remont-serverov'),
            'viewsonic' => array('remont-proektorov','remont-monoblokov','remont-planshetov','remont-smartfonov','remont-noutbukov','remont-televizorov','remont-videocamer'),
            'gigabyte' => array('remont-noutbukov','remont-kompyuterov','remont-serverov'),
            'emachines' => array('remont-noutbukov','remont-monoblokov'),
            'digma' => array('remont-elektrosamokatov','remont-giroskuterov','remont-planshetov','remont-smartfonov','remont-noutbukov','remont-proektorov','remont-videocamer'),
            '4good' => array('remont-noutbukov','remont-smartfonov','remont-planshetov'),
            'haier' => array('remont-noutbukov','remont-smartfonov','remont-planshetov','remont-robotov-pylesosov'),
            'honor' => array('remont-noutbukov','remont-smartfonov','remont-planshetov'),
            'irbis' => array('remont-noutbukov','remont-smartfonov','remont-planshetov','remont-kompyuterov','remont-monoblokov'),
            'micromax' => array('remont-noutbukov','remont-smartfonov','remont-planshetov'),
            'microsoft' => array('remont-noutbukov','remont-smartfonov','remont-planshetov','remont-kompyuterov','remont-monoblokov','remont-pristavok'),
            'dexp' => array('remont-televizorov','remont-planshetov','remont-noutbukov','remont-smartfonov','remont-kompyuterov','remont-monoblokov','remont-fotoapparatov','remont-videocamer', 'remont-pristavok'), 
            'benq' => array('remont-smartfonov','remont-televizorov','remont-planshetov','remont-noutbukov','remont-videocamer'), 
            'omen' => array('remont-noutbukov','remont-kompyuterov'),
            'motorola' => array('remont-planshetov','remont-noutbukov','remont-smartfonov'),
            'vestel' => array('remont-planshetov','remont-smartfonov','remont-noutbukov','remont-televizorov'),
            'rover' => array('remont-planshetov','remont-noutbukov'),
            'prestigio' => array('remont-televizorov','remont-planshetov','remont-noutbukov','remont-smartfonov','remont-monoblokov'),
            'predator' => array('remont-kompyuterov','remont-noutbukov')
        );

        if (!empty($this->_datas['original_setka_id']) && $this->_datas['original_setka_id'] == 12) {
            $urls['samsung'] = array('remont-holodilnikov','remont-stiralnyh-mashin','remont-posudomoechnyh-mashin');
            $urls['lg'] = array('remont-holodilnikov','remont-stiralnyh-mashin','remont-posudomoechnyh-mashin');
            $urls['midea'] = array('remont-holodilnikov','remont-varochnyh-panelej','remont-vytyazhek','remont-duhovyh-shkafov','remont-kondicionerov','remont-mikrovolnovyh-pechej','remont-morozilnikov','remont-posudomoechnyh-mashin','remont-pylesosov','remont-robotov-pylesosov','remont-stiralnyh-mashin');
            $urls['maunfeld'] = array('remont-varochnyh-panelej','remont-vytyazhek','remont-duhovyh-shkafov','remont-mikrovolnovyh-pechej','remont-morozilnikov','remont-posudomoechnyh-mashin','remont-stiralnyh-mashin','remont-holodilnikov');
            $urls['korting'] = array('remont-varochnyh-panelej','remont-vytyazhek','remont-duhovyh-shkafov','remont-kondicionerov','remont-mikrovolnovyh-pechej','remont-morozilnikov','remont-posudomoechnyh-mashin','remont-stiralnyh-mashin','remont-sushilnyh-mashin','remont-holodilnikov');
            $urls['weissgauff'] = array('remont-varochnyh-panelej','remont-vytyazhek','remont-duhovyh-shkafov','remont-mikrovolnovyh-pechej','remont-morozilnikov','remont-posudomoechnyh-mashin','remont-pylesosov','remont-robotov-pylesosov','remont-stiralnyh-mashin','remont-sushilnyh-mashin','remont-holodilnikov');
            $urls['hitachi'] = array('remont-videocamer','remont-domashnih-kinoteatrov','remont-kondicionerov','remont-proektorov','remont-robotov-pylesosov','remont-serverov','remont-televizorov','remont-holodilnikov');
            $urls['gaggenau'] = array('remont-varochnyh-panelej','remont-vytyazhek','remont-duhovyh-shkafov','remont-coffee-machin','remont-mikrovolnovyh-pechej','remont-morozilnikov','remont-posudomoechnyh-mashin','remont-stiralnyh-mashin','remont-sushilnyh-mashin','remont-holodilnikov');
            $urls['whirlpool'] = array('remont-varochnyh-panelej','remont-vodonagrevatelej','remont-vytyazhek','remont-duhovyh-shkafov','remont-kondicionerov','remont-coffee-machin','remont-mikrovolnovyh-pechej','remont-morozilnikov','remont-posudomoechnyh-mashin','remont-pylesosov','remont-stiralnyh-mashin','remont-sushilnyh-mashin','remont-holodilnikov'); 
            $urls['neff'] = array('remont-varochnyh-panelej','remont-vytyazhek','remont-duhovyh-shkafov','remont-coffee-machin','remont-mikrovolnovyh-pechej','remont-morozilnikov','remont-posudomoechnyh-mashin','remont-stiralnyh-mashin','remont-sushilnyh-mashin','remont-holodilnikov'); 
            $urls['wiebherr'] = array('remont-holodilnikov','remont-morozilnikov'); 
            $urls['liebherr'] = array('remont-holodilnikov','remont-morozilnikov'); 
            
            //$urls['delonghi'] = array('remont-coffee-machin','remont-posudomoechnyh-mashin','remont-pylesosov','remont-obogrevatelej');
        } 

        $this->_datas['add_device_type'] = $add_device_type = array(
            'remont-vodonagrevatelej' => array('type' => 'водонагреватель', 'type_rm' => 'водонагревателей', 'type_m' => 'водонагреватели', 'type_de' => 'водонагревателям', 'type_re' => 'водонагревателя'),
            'remont-varochnyh-panelej' => array('type' => 'варочная панель', 'type_rm' => 'варочных панелей', 'type_m' => 'варочные панели', 'type_de' => 'варочным панелям', 'type_re' => 'варочной панели'),
            'remont-domashnih-kinoteatrov' => array('type' => 'домашний кинотеатр', 'type_rm' => 'домашних кинотеатров', 'type_m' => 'домашние кинотеатры', 'type_de' => 'домашним кинотеатрам', 'type_re' => 'домашнего кинотеатра'),
            'remont-kondicionerov' => array('type' => 'кондиционер', 'type_rm' => 'кондиционеров', 'type_m' => 'кондиционеры', 'type_de' => 'кондиционерам', 'type_re' => 'кондиционера'),
            'remont-sushilnyh-mashin' => array('type' => 'сушильная машина', 'type_rm' => 'сушильных машин', 'type_m' => 'сушильные машины', 'type_de' => 'сушильным машинам', 'type_re' => 'сушильных машин'),
            'remont-vytyazhek' => array('type' => 'вытяжка', 'type_rm' => 'вытяжек', 'type_m' => 'вытяжки', 'type_de' => 'вытяжкам', 'type_re' => 'вытяжки'),
            'remont-duhovyh-shkafov' => array('type' => 'духовой шкаф', 'type_rm' => 'духовых шкафов', 'type_m' => 'духовые шкафы', 'type_de' => 'духовым шкафам', 'type_re' => 'духового шкафа'),
            'remont-mikrovolnovyh-pechej' => array('type' => 'микроволновая печь', 'type_rm' => 'микроволновых печей', 'type_m' => 'микроволновые печи', 'type_de' => 'микроволновые печи', 'type_re' => 'микроволновой печи'),
            'remont-morozilnikov' => array('type' => 'морозильник', 'type_rm' => 'морозильников', 'type_m' => 'морозильники', 'type_de' => 'морозильником', 'type_re' => 'морозильника'),
            'remont-monoblokov' => array('type' => 'моноблок', 'type_rm' => 'моноблоков', 'type_m' => 'моноблоки', 'type_de' => 'моноблоком', 'type_re' => 'моноблока'),
            'remont-telefonov' => array('type' => 'телефон', 'type_rm' => 'телефонов', 'type_m' => 'телефоны', 'type_de' => 'телефоном', 'type_re' => 'телефона'),
            'remont-holodilnikov' => array('type' => 'холодильник', 'type_rm' => 'холодильников', 'type_m' => 'холодильники', 'type_de' => 'холодильником', 'type_re' => 'холодильника'),
            'remont-stiralnyh-mashin' => array('type' => 'стиральная машина', 'type_rm' => 'стиральных машин', 'type_m' => 'стиральные машины', 'type_de' => 'стиральной машиной', 'type_re' => 'стиральной машины'),
            'remont-televizorov' => array('type' => 'телевизор', 'type_rm' => 'телевизоров', 'type_m' => 'телевизоры', 'type_de' => 'телевизором', 'type_re' => 'телевизора'),
            'remont-pylesosov' => array('type' => 'пылесос', 'type_rm' => 'пылесосов', 'type_m' => 'пылесосы', 'type_de' => 'пылесосом', 'type_re' => 'пылесоса'),
            'remont-printerov' => array('type' => 'принтер', 'type_rm' => 'принтеров', 'type_m' => 'принтеры', 'type_de' => 'принтером', 'type_re' => 'принтера'),
            'remont-fotoapparatov' => array('type' => 'фотоаппарат', 'type_rm' => 'фотоаппаратов', 'type_m' => 'фотоаппараты', 'type_de' => 'фотоаппаратом', 'type_re' => 'фотоаппарата'),
        	'remont-kompyuterov' => array('type' => 'компьютер', 'type_rm' => 'компьютеров', 'type_m' => 'компьютеры', 'type_de' => 'кмопьютером', 'type_re' => 'компьютера'),
            'remont-ultrabukov' => array('type' => 'ультрабук', 'type_rm' => 'ультрабуков', 'type_m' => 'ультрабуки', 'type_de' => 'ультрабуком', 'type_re' => 'ультрабука'),
            'remont-pristavok' => array('type' => 'приставки', 'type_rm' => 'приставок', 'type_m' => 'приставки', 'type_de' => 'приставкой', 'type_re' => 'приставки'),
            'remont-monitorov' => array('type' => 'монитор', 'type_rm' => 'мониторов', 'type_m' => 'мониторы', 'type_de' => 'монитором', 'type_re' => 'монитора'),
            'remont-noutbukov' => array('type' => 'ноутбук', 'type_rm' => 'ноутбуков', 'type_m' => 'ноутбуки', 'type_de' => 'ноутбуком', 'type_re' => 'ноутбука'),
            'remont-planshetov' => array('type' => 'планшет', 'type_rm' => 'планшетов', 'type_m' => 'планшеты', 'type_de' => 'планшетом', 'type_re' => 'планшета'),
            'remont-smartfonov' => array('type' => 'смартфон', 'type_rm' => 'смартфонов', 'type_m' => 'смартфоны', 'type_de' => 'смартфоном', 'type_re' => 'смартфона'),
			'remont-ekshen-kamer' => array('type' => 'экшн-камера', 'type_rm' => 'экшн-камер', 'type_m' => 'экшн-камеры', 'type_de' => 'экшн-камерой', 'type_re' => 'экшн-камеры'),
			'remont-apple-watch' => array('type' => 'смарт-часы', 'type_rm' => 'смарт-часов', 'type_m' => 'смарт-часы', 'type_de' => 'смарт-часами', 'type_re' => 'смарт-часов'),
			'remont-materinskih-plat' => array('type' => 'материнская плата', 'type_rm' => 'материнских плат', 'type_m' => 'материнских плат', 'type_de' => 'материнскими платами', 'type_re' => 'материнских плат'),
			'remont-samsung-gear' => array('type' => 'умные часы', 'type_rm' => 'умных часов', 'type_m' => 'умные часы', 'type_de' => 'умными часами', 'type_re' => 'умных часов'),
			'remont-videocamer' => array('type' => 'видеокамера', 'type_rm' => 'видеокамер', 'type_m' => 'видеокамеры', 'type_de' => 'видеокамерой', 'type_re' => 'видеокамеры'),
			'remont-elektrosamokatov' => array('type' => 'электросамокат', 'type_rm' => 'электросамокатов', 'type_m' => 'электросамокаты', 'type_de' => 'электросамокатом', 'type_re' => 'электросамоката'),
 			'remont-robotov-pylesosov' => array('type' => 'робот-пылесос', 'type_rm' => 'робот-пылесосов', 'type_m' => 'робот-пылесосы', 'type_de' => 'робот-пылесосом', 'type_re' => 'робот-пылесоса'),
			'remont-naushnikov' => array('type' => 'наушники', 'type_rm' => 'наушников', 'type_m' => 'наушники', 'type_de' => 'наушниками', 'type_re' => 'наушников'),
            'remont-proektorov' => array('type' => 'проектор', 'type_rm' => 'проекторов', 'type_m' => 'проекторы', 'type_de' => 'проектором', 'type_re' => 'проектора'),
            'remont-posudomoechnyh-mashin' => array('type' => 'посудомоечная машина', 'type_rm' => 'посудомоечных машин', 'type_m' => 'посудомоечные машины', 'type_de' => 'посудомоечной машиной', 'type_re' => 'посудомоечные машины'),
            'remont-coffee-machin' => array('type' => 'кофемашина', 'type_rm' => 'кофемашин', 'type_m' => 'кофемашины', 'type_de' => 'кофемашиной', 'type_re' => 'кофемашина'),
            //'remont-pylesosov' => array('type' => 'пылесос', 'type_rm' => 'пылесосов', 'type_m' => 'пылесосы', 'type_de' => 'обогревателю', 'type_re' => 'обогревателя'),
            'remont-obogrevatelej' => array('type' => 'обогреватель', 'type_rm' => 'обогревателей', 'type_m' => 'обогреватели', 'type_de' => 'обогревателю', 'type_re' => 'обогревателя'),
            'remont-serverov' => array('type' => 'сервер', 'type_rm' => 'серверов', 'type_m' => 'серверы', 'type_de' => 'серверу', 'type_re' => 'сервера'),
             'remont-elektrosamokatov' => array('type' => 'электросамокат', 'type_rm' => 'электросамокатов', 'type_m' => 'электросамокаты', 'type_de' => 'электросамокатом', 'type_re' => 'электросамоката'),
            'remont-giroskuterov' => array('type' => 'гироскутер', 'type_rm' => 'гироскутеров', 'type_m' => 'гироскутеры', 'type_de' => 'гироскутером', 'type_re' => 'гироскутера'),
            'remont-monokoles' => array('type' => 'моноколесо', 'type_rm' => 'моноколес', 'type_m' => 'моноколеса', 'type_de' => 'моноколесом', 'type_re' => 'моноколеса'),
            'remont-segveev' => array('type' => 'сегвей', 'type_rm' => 'сегвеев', 'type_m' => 'сегвеи', 'type_de' => 'сегвеем', 'type_re' => 'сегвея'),    
		);


        $this->_datas['accord'] = array('смартфон' => 'remont-smartfonov', 'ноутбук' => 'remont-noutbukov', 'планшет' => 'remont-planshetov');

        foreach ($add_device_type as $key => $value)
            $this->_datas['accord'][$value['type']] = $key;
        if (isset($urls[$marka_lower]))
        {
            $t = array();
            foreach ($urls[$marka_lower] as $url)
                $t[] = $add_device_type[$url];
            $this->_datas['all_devices'] = array_merge($this->_datas['all_devices'], $t);
        }

        $this->_datas['accord_image'] = array(
            'ноутбук' => 'noutbuk',
            'смартфон' => 'smartfon',
            'планшет' => 'planshet',
            'моноблок' => 'all-in-one',
            'телефон' => 'telefone',
            'холодильник' => 'holodilnik',
            'стиральная машина' => 'stiralnaya-mashina',
            'сушильная машина' => 'sushilnaya-mashina',
            'телевизор' => 'televizor',
            'пылесос' => 'pylesos',
            'робот-пылесос' => 'robot-pylesos',
            'фотоаппарат' => 'fotoapparat',
            'принтер' => 'printer',
            'компьютер' => 'kompyuter',
            'монитор' => 'monitor',
            'приставки' => 'pristavki',
            'ультрабук' => 'ultrabook',
            'экшн-камера' => 'ekshen-kameri',
            'умные часы' => 'smart-watch',
            'смарт-часы' =>  'smart-watch',
            'материнская плата' => 'mat-plata',
            'видеокамера' => 'videocam',
            'электросамокат' => 'elektrosamokat',
            'моноколесо' => 'monokoles',
            'сегвей' => 'segway',
            'гироскутер' => 'hoverboard',
            'наушники' => 'headphones',
            'проектор' => 'proektor',
            'посудомоечная машина' => 'posudomoechnaya-mashina',
            'кофемашина' => 'coffee-machina',
            // 'пылесос' =>'remont-pylesos',
            'обогреватель' =>'remont-obogrevatel',
            'сервер' =>'server',
            'варочная панель'=> 'varochnaya-panel',
            'вытяжка'=> 'vytyazhka',
            'духовой шкаф'=>'duhovoj-shkaf',
            'микроволновая печь'=> 'mikrovolnovaya-pech',
            'морозильник'=>'morozilnik',
            'кондиционер'=> 'kondicioner',
            'домашний кинотеатр'=> 'domashnih-kinoteatr',
            'водонагреватель'=>'remont-vodonagrevatelej',
         );
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
        
        $exclude_array_markas = array('Indesit', 'Ariston', 'Bosch', 'Electrolux');
        
        $this->_datas['sdek'] = false;
        if ($this->_datas['partner']['email'] == 'litovchenko@list.ru' && !in_array($this->_datas['marka']['name'], $exclude_array_markas))
        {
            $this->_datas['phone'] = '78003506058';
            $this->_datas['partner']['exclude'] = 1;  
            unset($this->_datas['header_menu']['/dostavka/'], $this->_datas['header_menu']['/sroki/']);
            unset($this->_datas['footer_menu']['/dostavka/'], $this->_datas['footer_menu']['/sroki/']);
            $this->_datas['partner']['time']  = 'Пн-Вс: с 10-00 до 20-00';
            
            $this->_datas['sdek'] = true; 
        } 

    }
}

?>
