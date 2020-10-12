<?

namespace framework\ajax\parse\hooks;

use framework\tools;
use framework\rand_it;
use framework\pdo;
use framework\ajax\boost\amp;

class sc2_1 extends sc
{

    public $dbh = null;

    public function generate($answer, $params)
    {

      $this->dbh = pdo::getPdo(2);

      $this->_datas = $this->_datas + $params;

      $this->_datas['accord_image'] = array(
          'принтер' => 'printery',
          'моноблок' => 'monobloki',
          'МФУ' => 'mfu',
          'фотоаппарат' => 'fotoapparaty',
          'компьютер' => 'kompyutery',
          'сервер' => 'servery',
          'видеокамера' => 'kamery',
          'игровая приставка' => 'pristavki',
          'телевизор' => 'televizory',
          'ноутбук' => 'noutbuki',
          'смартфон' => 'telefony',
          'планшет' => 'planshety',
      );

      $this->_datas['typeUrl'] = [
        'ноутбук' => 'noutbukov',
        'планшет' => 'planshetov',
        'телефон' => 'telefonov',
        'смартфон' => 'telefonov',
        'моноблок' => 'monoblokov',
        'компьютер' => 'kompyuterov',
        'фотоаппарат' => 'fotoapparatov',
        'принтер' => 'printerov',
        'мфу' => 'printerov',
        'сервер' => 'serverov',
        'телевизор' => 'televizorov',
        'видеокамера' => 'fotoapparatov',
      ];

      $this->_datas['typesBrandUrl'] = [
        'apple' => [
          'ноутбук' => 'macbook',
          'планшет' => 'ipad',
          'смартфон' => 'iphone',
          'моноблок' => 'imac',
        ],
        'sony' => [
          'игровая приставка' => 'playstation',
        ],
      ];

		$this->changePhone($params['pb_mode']);

      $stmt = $this->dbh->prepare("SELECT `model_types`.`name` as `type`, `model_types`.`id` as `type_id`,
             `model_types`.`name_re` as `type_re`, `model_types`.`name_rm` as `type_rm`,
              `model_types`.`name_m` as `type_m` FROM `model_types`");
      $stmt->execute();
      $this->_datas['allTypes'] = $stmt->fetchAll(\PDO::FETCH_ASSOC);
      foreach ($this->_datas['allTypes'] as $k=>$v) {
        $this->_datas['allTypes'][$v['type']] = $v;
        unset($this->_datas['allTypes'][$k]);
      }

      $stmt = $this->dbh->query("SELECT markas.name as 'marka', GROUP_CONCAT(model_types.name SEPARATOR ',') as 'types' FROM marka_types JOIN model_types ON marka_types.model_type_id = model_types.id JOIN markas ON marka_types.marka_id = markas.id GROUP BY markas.id");
      $markaTypes = $stmt->fetchAll(\PDO::FETCH_ASSOC);
      $this->_datas['markaTypes'] = [];
      foreach ($markaTypes as $k=>$v) {
        $this->_datas['markaTypes'][$v['marka']] = explode(',', $v['types']);
      }
      $this->urlTypeMark();

      if (isset($params['marka_id'])) {
        $this->sqlMarka($params['marka_id']);
      }

      // region
      $this->_datas['region'] = $this->_getRegion($params['region_id']);
      $city = $this->_datas['region']['name_pe'];
      $city_d = $this->_datas['region']['name_de'];
      $city_r = $this->_datas['region']['name_re'];

      if ($this->_datas['region']['translit2']) $this->_datas['region']['translit1'] = $this->_datas['region']['translit2'];

      // partner
      $this->_datas['partner'] = $this->_getPartner($params['partner_id']);

      $this->_datas['menu'] = array(
          '/' => 'Главная',
          '/zakaz/' => 'Запись на ремонт',
          'diagnostika' => 'Диагностика',
          '/ekspress-remont/' => 'Экспресс ремонт',
          '/dostavka/' => 'Выезд курьера',
          'ceny-remonta' => 'Цены',
          '/kontakty/' => 'Контакты',
      );
	  
	  /*if (($this->_datas['servicename'] == 'Centre' || $this->_datas['servicename'] == 'Sony Centre') && $this->_datas['region']['name'] == 'Москва') {
		$this->_datas['servicename'] = 'сервис Сони от Centre';
	  }*/
	  
        if (isset($params['static']))
        {
            $file_name = $params['static'];


            if ($file_name)
            {

                $feed = $this->_datas['feed'] = (isset($this->_datas['vals']['feed']) ? $this->_datas['vals']['feed'] : $this->_datas['feed']);

                switch ($file_name) {
              		case 'index': //+
              			$title = $this->_datas['servicename'].': сеть сервисных центров';
              			$modelTypes = array_column($this->_datas['allTypes'], 'type_rm');
              			$allMarkas = array_keys($this->_datas['markaTypes']);

                        $description = array();
                        $description[] = array('Сеть сервисный центров в Москве по ремонту:');

                        srand($feed);
                        $modelCnt = rand(3, 4);

                        $model_tmp_arr = rand_it::randMas($modelTypes, $modelCnt, '', $feed);
                        $model_tmp = array();

                        $count = count($model_tmp_arr) - 1;

                        foreach ($model_tmp_arr as $key => $value) {
                                if ($count != $key)
                                    $model_tmp[$key] = $value . ',';
                                else
                                    $model_tmp[$key] = $value;


                            $description[] = $model_tmp[$key];
                        }

                        $description[] = array('от производителей:');

                        srand($feed);

                        $markas_tmp_arr = rand_it::randMas($allMarkas, count( $allMarkas ), '', $feed);
                        $markas_tmp = array();

                        $count = count($markas_tmp_arr) - 1;

                        foreach ($markas_tmp_arr as $key => $value) {
                            if ($count != $key)
                                $markas_tmp[$key] = $value . ',';
                            else
                                $markas_tmp[$key] = $value;


                            $description[] = $markas_tmp[$key];
                        }

                        // Generating all text
                        $description = sc::_createTree($description, $feed);

                    $h1 = '';
              		break; 
                  case 'servis': //+
						$title = 'Сервисный центр '.$this->_datas['marka']['name'].' в '.$city.': Ремонт '.$this->_datas['ru_servicename'];
						if (($this->_datas['servicename'] == 'Centre' || $this->_datas['servicename'] == 'Sony Centre') && $this->_datas['region']['name'] == 'Москва') {
							$title = 'Сервисный центр '.$this->_datas['marka']['name'].' в '.$city.': Ремонт Сони от Центр';
						}
						if (($this->_datas['servicename'] == 'Centre' || $this->_datas['servicename'] == 'Xiaomi Centre') && $this->_datas['region']['name'] == 'Москва') {
							$title = 'Сервисный центр '.$this->_datas['marka']['name'].' в '.$city.': Ремонт Xiaomi от Центр';
						}						
                    $t = [];
                    foreach ($this->_datas['all_devices'] as $device)
                        $t[] = $device['type_rm'];

              			$description = 'Обслуживание и ремонт устройств '.$this->_datas['marka']['name'].'. Условия предоставления услуг. Ремонт '.tools::implode_or($t).'.';

                    $marka_lower = strtolower($this->_datas['marka']['name']);
                    if ($this->_datas['setka_name'] == 'СЦ-2' && (($marka_lower == 'samsung') || ($marka_lower == 'nikon') || ($marka_lower == 'sony')))
                         $h1 = 'Сервисный центр Centre - Ремонт '.$this->_datas['marka']['ru_name'];
                    else
                   $h1 = $this->_datas['servicename'].' - сервисный центр '.$this->_datas['marka']['ru_name'];
              		break;
              		case 'zakaz':
                    $this->_datas['getBrand'] = isset($_GET['brand']) ? $_GET['brand'] : null;

            				$title = 'Запись на ремонт техники в сервисе '.$this->_datas['servicename'].' в '.$city;
              			$description = 'Запишитесь на ремонт, и мы с вами свяжемся! Оперативность, качество и отличные цены в сервисе '.$this->_datas['ru_servicename'].' в '.$city.'.';
              			$h1 = 'Запись на ремонт';
              		break;
              		case 'diagnostika'://+
                    $title = [
                      ['Диагностика '.$this->_datas['marka']['name'].' в '.$this->_datas['region']['pril']],
                      ['сервисном центре','сервис центре'],
                      [$this->_datas['servicename']],
                    ];
                    $title = $this->_createTree($title, $feed);
              			$description = 'Диагностирование всех видов неисправностей техники '.$this->_datas['marka']['ru_name'].': от технических неполадок до программных ошибок. Звоните в сервис '.$this->_datas['servicename'].' в '.$city.'!';
              			$h1 = 'Диагностика '.$this->_datas['marka']['name'];
                  break;
                  case 'ekspress-remont'://+
                    $title = 'Срочный ремонт в '.$city.' от сервиса '.$this->_datas['servicename'];
              			$description = 'Нужен экстренный ремонт? Буквально за час наши специалисты готовы исправить большинство неисправностей вашей техники.';
              			$h1 = 'Экспресс ремонт';
                  break;
                  case 'dostavka'://+
                    $title = [
                      ['Заказ'],
                      ['курьерской доставки','выезда курьера','доставки'],
                      ['до'],
                      ['сервисного центра','сервиса','сервис центра'],
                      [$this->_datas['servicename'].' по '.$city],
                    ];
                    $title = $this->_createTree($title, $feed);
              			$description = 'Не хотите ехать к нам - не беда! Наш курьер приедет к вам, заберёт вашу сломавшуюся технику и вернёт уже отремонтированную!';
              			$h1 = 'Выезд курьера';
                  break;
                  case 'ceny-remonta': //+
                    $stmt = $this->dbh->prepare("SELECT * FROM services JOIN marka_types ON services.model_type_id = marka_types.model_type_id WHERE marka_types.marka_id = ?");
                    $stmt->execute([$this->_datas['marka']['id']]);

                    $services = [];

                    foreach ($stmt->fetchAll(\PDO::FETCH_ASSOC) as $service) {
                      $services[$service['model_type_id']][] = $service;
                    }

                    $this->_datas['services'] = $services;

                    $title = 'Цены на обслуживание в '.$this->_datas['servicename'].' '.$this->_datas['region']['translit1'];
                    $description = 'Прайс-лист на услуги по сервисному ремонту и обслуживанию техники '.$this->_datas['marka']['name'].'. Подробный прейскурант на работы для каждого из типов устройств.';
                    $h1 = 'Цены '.$this->_datas['marka']['name'];
                  break;
                  case 'kontakty':
                    $title = 'Контакты '.$this->_datas['servicename'].' в '.$city.': адреса, телефоны компании';
                    $description = 'Адрес, телефон и схема проезда авторизованного сервисного центра '.$this->_datas['servicename'].'.';
                    $h1 = 'Контакты';
                  break;
                  case 'sprosi':
                    $title = [
                      ['Спросите'],
                      ['специалиста','мастера','инженера'],
                      ['сервисного центра','сервиса','сервис центра'],
                      [$this->_datas['servicename'].' в '.$city],
                    ];
                    $title = $this->_createTree($title, $feed);
                    $description = 'Не знаете, что случилось с вашим устройством? Задайте вопрос эксперту.';
                    $h1 = 'Задать вопрос';
                  break;
                  case 'status':
                    $title = 'Узнать статус заказа в сервисном центре '.$this->_datas['servicename'];
                    $description = 'Узнать статус заказа по номеру квитанции в '.$this->_datas['servicename'].'.';
                    $h1 = 'Статус заказа';
                  break;
                  case 'spasibo':
                    $title = 'Спасибо — Сервисный центр '.$this->_datas['servicename'];
                    $description = '';
                    $h1 = 'Ваша заявка отправлена!';
                  break;
                  case 'politika':
                    $title = 'Политика обработки персональных данных';
                    $description = 'Политика обработки персональных данных';
                    $h1 = 'Политика обработки персональных данных';
                  break;
                  case 'rekvizity':
                    $title = [
                      ['Реквизиты'],
                      ['компании','сервисного центра','сервиса','сервис центра'],
                      [$this->_datas['servicename'].' в '.$city],
                    ];
                    $title = $this->_createTree($title, $feed);
                    $description = 'Наши реквизиты';
                    $h1 = 'Наши реквизиты';
                  break;
                  default:
                    $gadget = $this->_datas['add_device_type'][$this->_datas['arg_url']];
                    $title = 'Ремонт '.$gadget['type_rm'].' '.$this->_datas['marka']['name'].' в '.$city.' от '.$this->_datas['servicename'];
					  if (($this->_datas['servicename'] == 'Centre' || $this->_datas['servicename'] == 'Sony Centre') && $this->_datas['region']['name'] == 'Москва') {
						  $title = 'Ремонт '.$gadget['type_rm'].' '.$this->_datas['marka']['name'].' в '.$city.': сервис Сони от Centre';
					  }
					  if (($this->_datas['servicename'] == 'Centre' || $this->_datas['servicename'] == 'Xiaomi Centre') && $this->_datas['region']['name'] == 'Москва') {
						  $title = 'Ремонт '.$gadget['type_rm'].' '.$this->_datas['marka']['name'].' в '.$city.': сервис Xiaomi от Centre';
					  }
                    $description = 'Обслуживание и ремонт '.$gadget['type_rm'].' '.$this->_datas['marka']['ru_name'].'. Прайс на услуги. Регламент ремонта. Полный список услуг и цен сервиса.';
                    $h1 = 'Ремонт '.$gadget['type_rm'].' '.$this->_datas['marka']['name'];
                    $file_name = 'gadget';
                }

                // addresis
                #$this->_datas['addresis'] = $this->_getAddresis($params['setka_id'], $this->_datas['marka']['id']);

                $this->_ret['title'] = $title;
                $this->_ret['h1'] = $h1;
                $this->_ret['description'] = $description;

				// если amp менять
				
				if (!$this->_datas['isAMP']) {
					$body = $this->_body($file_name, basename(__FILE__, '.php'));
				} else {
					$body = $this->_body('templates/'.$file_name, basename(__FILE__, '.php'));
				}
                //return array('title' => $title, 'description' => $description, 'body' => $body);
                return array('body' => $body);
            }
        }

        $level = false;

        $ret = array();

        $file_name = '';

        #$this->_sqlData($params);

        $feed = $this->_datas['feed'] = (isset($this->_datas['vals']['feed']) ? $this->_datas['vals']['feed'] : $this->_datas['feed']);
        $this->_datas['dop'] = ''; // ### ремонта;выполнения работ;оказания услуг;обслуживания


        // addresis
        #$this->_datas['addresis'] = $this->_getAddresis($params['setka_id'], $this->_datas['marka']['id']);

        if (isset($params['marka_id']) && isset($params['model_type_id']))
        {
            $stmt = $this->dbh->prepare("SELECT * FROM model_types WHERE id = ?");
            $stmt->execute([$params['model_type_id']]);
            $this->_datas['model_type'] = $stmt->fetch(\PDO::FETCH_ASSOC);

            $stmt = $this->dbh->prepare("SELECT * FROM services WHERE model_type_id = ?");
            $stmt->execute([$params['model_type_id']]);
            $this->_datas['services'] = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            srand($feed);
            shuffle($this->_datas['services']);
            srand();

            $costs = [];
            $minCost = null;
            foreach (array_column($this->_datas['services'], 'cost') as $cost) {
              if ($cost > 0 && ($cost < $minCost || is_null($minCost)))
                $minCost = $cost;
            }
            $this->_datas['minCost'] = $minCost;

            $stmt = $this->dbh->prepare("SELECT * FROM complects WHERE model_type_id = ?");
            $stmt->execute([$params['model_type_id']]);
            $this->_datas['complects'] = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            srand($feed);
            shuffle($this->_datas['complects']);
            foreach ($this->_datas['complects'] as $k=>$v) {
              srand($this->_datas['marka']['id']+$v['id']);
              $costs = explode(';', $this->_datas['complects'][$k]['costs']);
              $cost = $costs[array_rand($costs)];
              $this->_datas['complects'][$k]['cost'] = $cost;
              unset($this->_datas['complects'][$k]['costs']);
            }

            $titleHub = [
              'apple' => [
                'ноутбук' => 'Ремонт MacBook в {city}: сервис МакБук от {name}',
                'планшет' => 'Ремонт iPad в {city}: сервис айПад от {name}',
                'телефон' => 'Ремонт iPhone в {city}: сервис айФон от {name}',
                'компьютер' => 'Ремонт iMac в {city}: сервис айМак от {name}',
              ],
              'canon' => [
                'принтер' => 'Ремонт принтеров (МФУ) Canon в {city} от {name}',
              ],
              'hp' => [
                'принтер' => 'Ремонт принтеров (МФУ) HP в {city} от {name}',
              ],
              'sony' => [
                'игровая приставка' => 'Ремонт Playstation в {city} от {name}',
              ],
            ];
			if (($this->_datas['servicename'] == 'Centre' || $this->_datas['servicename'] == 'Sony Centre') && $this->_datas['region']['name'] == 'Москва') {
				$titleHub = [
				  'sony' => [
					'игровая приставка' => 'Ремонт Playstation в Москве: сервис Sony от Centre',
					'моноблок' => 'Ремонт моноблоков Sony в Москве: сервис Сони от Centre',
					'ноутбук' => 'Ремонт ноутбуков Sony Vaio в Москве: сервис Сони от Centre',
					'планшет' => 'Ремонт планшетов Sony в Москве: сервис Сони от Centre',
					'смартфон' => 'Ремонт смартфонов Sony Xperia в Москве: сервис Сони от Centre',
				  ],
				];
			}

            if (isset($titleHub[strtolower($this->_datas['marka']['name'])][$this->_datas['model_type']['name']])) {
              $ret['title'] = [strtr($titleHub[strtolower($this->_datas['marka']['name'])][$this->_datas['model_type']['name']], [
                '{city}' => $this->_datas['region']['name_pe'],
                '{name}' => $this->_datas['servicename'],
              ])];
            }
            else {
              $ret['title'] = array(
                  'Ремонт',
                  $this->_datas['model_type']['name_rm'],
                  $this->_datas['marka']['name'],
                  'в',
                  $city,
                  'от',
                  $this->_datas['servicename']
              );
				if (($this->_datas['servicename'] == 'Centre' || $this->_datas['servicename'] == 'Sony Centre') && $this->_datas['region']['name'] == 'Москва') {
					  $ret['title'] = array(
						  'Ремонт',
						  $this->_datas['model_type']['name_rm'],
						  $this->_datas['marka']['name'],
						  'в',
						  $city.':',
						  'сервис Сони от Centre'
					  );
				}
				if (($this->_datas['servicename'] == 'Centre' || $this->_datas['servicename'] == 'Xiaomi Centre') && $this->_datas['region']['name'] == 'Москва') {
					  $ret['title'] = array(
						  'Ремонт',
						  $this->_datas['model_type']['name_rm'],
						  $this->_datas['marka']['name'],
						  'в',
						  $city.':',
						  'сервис Xiaomi от Centre'
					  );
				}
            }

            $ret['h1'] = array(
              'Ремонт',
              $this->_datas['model_type']['name_rm'],
              $this->_datas['marka']['name']
            );
            $ret['description'] = array(
                'Обслуживание и ремонт',
                $this->_datas['model_type']['name_rm'],
                $this->_datas['marka']['ru_name'].'.',
                $this->_datas['dop']
            );

            $this->_mode = -3;
            $file_name = 'model';
        }
        else if (isset($params['model_id']) && isset($params['service_id'])) {
          $stmt = $this->dbh->prepare("SELECT * FROM models WHERE id = ?");
          $stmt->execute([$params['model_id']]);
          $this->_datas['model'] = $stmt->fetch(\PDO::FETCH_ASSOC);

          $stmt = $this->dbh->prepare("SELECT * FROM m_models WHERE id = ?");
          $stmt->execute([$this->_datas['model']['m_model_id']]);
          $this->_datas['m_model'] = $stmt->fetch(\PDO::FETCH_ASSOC);

          $stmt = $this->dbh->prepare("SELECT * FROM model_types WHERE id = ?");
          $stmt->execute([$this->_datas['m_model']['model_type_id']]);
          $this->_datas['model_type'] = $stmt->fetch(\PDO::FETCH_ASSOC);

          $stmt = $this->dbh->prepare("SELECT * FROM services WHERE id = ?");
          $stmt->execute([$params['service_id']]);
          $this->_datas['service'] = $stmt->fetch(\PDO::FETCH_ASSOC);

          $syns = explode('@', $this->_datas['service']['syns']);
          if (count($syns) < 4) {
            for ($i=count($syns); $i<=4; $i++) {
              $syns[$i] = $this->_datas['service']['name'];
            }
          }
          srand($this->_datas['service']['id']);
          shuffle($syns);
          $this->_datas['syns'] = $syns;

          $this->sqlMarka($this->_datas['m_model']['marka_id']);

          if (!is_null($this->_datas['service']['title']) && trim($this->_datas['service']['title']) != '') {
            $ret['title'] = [
              strtr($this->_datas['service']['title'], [
                '[city]' => $this->_datas['region']['name_pe'],
                '[name]' => $this->_datas['servicename'],
                '[model]' => $this->_datas['model']['name'],
              ]),
            ];
			  if (($this->_datas['servicename'] == 'Centre' || $this->_datas['servicename'] == 'Sony Centre' || $this->_datas['servicename'] == 'Xiaomi Centre') && $this->_datas['region']['name'] == 'Москва') {
				$ret['title'] = [
				  strtr($this->_datas['service']['title'], [
					'[city]' => $this->_datas['region']['name_pe'],
					'[name]' => 'Centre',
					'[model]' => $this->_datas['model']['name'],
				  ]),
				]; 
			  } else {
				$ret['title'] = [
				  strtr($this->_datas['service']['title'], [
					'[city]' => $this->_datas['region']['name_pe'],
					'[name]' => $this->_datas['servicename'],
					'[model]' => $this->_datas['model']['name'],
				  ]),
				];
			  }
          }
          else {
			if (($this->_datas['servicename'] == 'Centre' || $this->_datas['servicename'] == 'Sony Centre' || $this->_datas['servicename'] == 'Xiaomi Centre') && $this->_datas['region']['name'] == 'Москва') {
				$ret['title'] = array(
					tools::mb_firstupper($this->_datas['syns'][0]),
					$this->_datas['marka']['name'],
					$this->_datas['m_model']['name'],
					'в',
					$city,
					'от',
					'Centre:'
				);
			} else {
				$ret['title'] = array(
					tools::mb_firstupper($this->_datas['syns'][0]),
					$this->_datas['marka']['name'],
					$this->_datas['m_model']['name'],
					'в',
					$city,
					'от',
					$this->_datas['servicename'].':'
				);
			}
			
			if (isset($this->_datas['time']))
            {
                $ret['title'][] = 'от';
                $ret['title'][] = $this->_datas['time'];
                $ret['title'][] = 'мин';
            }			

          }

          $ret['h1'] = array(
              tools::mb_firstupper($this->_datas['syns'][1]),
              //'<span>'.$this->_datas['marka']['name'],
              '<span>'.$this->_datas['model']['name'].'</span>'
          );

          $ret['description'] = array(
              $this->_datas['marka']['name'],
              $this->_datas['model']['name'],
              '-',
              tools::mb_firstlower($this->_datas['syns'][2]).'.',
              $this->_datas['dop']
          );

          $this->_mode = 2;
          $file_name = 'model-service';
        }
        else if (isset($params['model_id'])) {
          $stmt = $this->dbh->prepare("SELECT * FROM models WHERE id = ?");
          $stmt->execute([$params['model_id']]);
          $this->_datas['model'] = $stmt->fetch(\PDO::FETCH_ASSOC);

          $stmt = $this->dbh->prepare("SELECT * FROM m_models WHERE id = ?");
          $stmt->execute([$this->_datas['model']['m_model_id']]);
          $this->_datas['m_model'] = $stmt->fetch(\PDO::FETCH_ASSOC);

          $stmt = $this->dbh->prepare("SELECT * FROM model_types WHERE id = ?");
          $stmt->execute([$this->_datas['m_model']['model_type_id']]);
          $this->_datas['model_type'] = $stmt->fetch(\PDO::FETCH_ASSOC);

          $stmt = $this->dbh->prepare("SELECT * FROM services WHERE model_type_id = ?");
          $stmt->execute([$this->_datas['m_model']['model_type_id']]);
          $this->_datas['services'] = $stmt->fetchAll(\PDO::FETCH_ASSOC);
          srand($feed);
          shuffle($this->_datas['services']);
          srand();

          $costs = [];
          $minCost = null;
          foreach (array_column($this->_datas['services'], 'cost') as $cost) {
            if ($cost > 0 && ($cost < $minCost || is_null($minCost)))
              $minCost = $cost;
          }
          $this->_datas['minCost'] = $minCost;

          $stmt = $this->dbh->prepare("SELECT * FROM complects WHERE model_type_id = ?");
          $stmt->execute([$this->_datas['model_type']['id']]);
          $this->_datas['complects'] = $stmt->fetchAll(\PDO::FETCH_ASSOC);
          srand($feed);
          shuffle($this->_datas['complects']);
          foreach ($this->_datas['complects'] as $k=>$v) {
            srand($this->_datas['m_model']['marka_id']+$v['id']);
            $costs = explode(';', $this->_datas['complects'][$k]['costs']);
            $cost = $costs[array_rand($costs)];
            $this->_datas['complects'][$k]['cost'] = $cost;
            unset($this->_datas['complects'][$k]['costs']);
          }
          srand();

          $this->sqlMarka($this->_datas['m_model']['marka_id']);

          $stmt = $this->dbh->prepare("SELECT models.id, models.name FROM models JOIN m_models ON models.m_model_id = m_models.id WHERE m_models.marka_id = ? AND m_models.model_type_id = ?");
          $stmt->execute([$this->_datas['m_model']['marka_id'], $this->_datas['m_model']['model_type_id']]);
          $allModels = $stmt->fetchAll(\PDO::FETCH_ASSOC);

          $two = $one = [];
          foreach ($allModels as $model) {
            if ($model['id'] > $params['model_id']) {
              $one[] = $model;
            }
            else if ($model['id'] < $params['model_id']) {
              $two[] = $model;
            }
          }
          $this->_datas['allModels'] = array_merge($one, $two);
		  
          $ret['title'] = array( // Ремонт моноблоков Sony в Москве: сервис Сони от Centre
             'Ремонт',
             $this->_datas['model_type']['name_rm'],
             $this->_datas['model']['name'],
             'в',
             $city,
			 'от',
             $this->_datas['servicename']
          );
		  if (($this->_datas['servicename'] == 'Centre' || $this->_datas['servicename'] == 'Sony Centre') && $this->_datas['region']['name'] == 'Москва') {
			  $ret['title'] = array( // Ремонт моноблоков Sony в Москве: сервис Сони от Centre
				 'Ремонт',
				 $this->_datas['model_type']['name_rm'],
				 $this->_datas['model']['name'],
				 'в',
				 $city.':',
				 'сервис Сони от Centre'
			  );  
		  }
		  if (($this->_datas['servicename'] == 'Centre' || $this->_datas['servicename'] == 'Xiaomi Centre') && $this->_datas['region']['name'] == 'Москва') {
			  $ret['title'] = array( // Ремонт моноблоков Sony в Москве: сервис Сони от Centre
				 'Ремонт',
				 $this->_datas['model_type']['name_rm'],
				 $this->_datas['model']['name'],
				 'в',
				 $city.':',
				 'сервис Xiaomi от Centre'
			  );  
		  }

          $ret['h1'] = array(
             'Ремонт',
             '<span>'.$this->_datas['model']['name'].'</span>'
          );

          $ret['description'] = array(
             $this->_datas['model']['name'],
             '-',
             'услуги по ремонту.',
             $this->_datas['dop']
          );

          $this->_mode = -2;
          $file_name = 'model';
        }
        else if (0 && isset($params['m_model_id']) || (isset($params['marka_id']) && isset($params['model_type_id'])))
        {
            if (0) {

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
							
							if (($this->_datas['servicename'] == 'Centre' || $this->_datas['servicename'] == 'Sony Centre' || $this->_datas['servicename'] == 'Xiaomi Centre') && $this->_datas['region']['name'] == 'Москва') {
								$ret['title'] = array(
									tools::mb_firstupper($this->_datas['syns'][0]),
									$this->_datas['marka']['name'],
									$this->_datas['m_model']['name'],
									'в',
									$city.':',
									tools::mb_firstupper($this->_datas['syns'][1]),
									'от Centre',
								);
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

        /*for ($i = 0; $i < 2; $i++)
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
        }*/

        $vars2[] = $t_array;

        $vars2[] = array('Запишитесь на ремонт онлайн', 'Запишитесь на ремонт через онлайн форму', 'Заполните форму заявки на сайте', 'Оставьте заказ на сайте', 'Оставьте заявку на сайте',
                            'Отправьте заявку на ремонт', 'Отправьте онлайн-заявку', 'Оформите заказ онлайн', 'Оформите заказ через сайт', 'Оформите онлайн заявку на ремонт', 'Сделайте заказ онлайн');

        $vars2[] = array('или');
        $vars2[] = array('сообщите нашим менеджерам, что делаете заказ на '.$this->_datas['site_name'], 'сообщите нашим операторам, что делаете заказ на '.$this->_datas['site_name'],
                            'сообщите нашим диспетчерам, что делаете заказ на '.$this->_datas['site_name'], 'позвоните по телефону '.tools::format_phone($this->_datas['phone']),
                            'позвоните по номеру '.tools::format_phone($this->_datas['phone']), 'позвоните по единому номеру сервисного центра '.tools::format_phone($this->_datas['phone']),
                            'проинформируйте менеджера, что хотите сделать заказ на '.$this->_datas['site_name'], 'проинформируйте оператора, что хотите сделать заказ на '.$this->_datas['site_name'],
                            'проинформируйте диспетчера, что хотите сделать заказ на '.$this->_datas['site_name']);

        $vars2[] = array('и получите скидку 10%.</p>');

        $vars3 = array();
        $vars3[] = array('<p>Стоимость', '<p>Цена');
        $vars3[] = array('комплектующих', 'запчастей');

        $t_array = array();
        if (isset($this->_datas['model_type'])) {
          $type = $this->_datas['model_type'];
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
        if (isset($this->_datas['model_type'])) {
          $type = $this->_datas['model_type'];
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
        $orig_model_type = $this->_datas['model_type']; // тип устройства
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

        if (isset($this->_datas['model_type'])) {
          $type = $this->_datas['model_type'];
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

        #$ret['img'] = $this->_datas['img'];
        $ret['text'] = sc::_createTree($vars, $feed);

        $this->_datas['vars2'] = sc::_createTree($vars2, $feed);
        $this->_datas['vars3'] = sc::_createTree($vars3, $feed);
        $this->_datas['vars4'] = sc::_createTree($vars4, $feed);

        $this->_ret = $this->_answer($answer, $ret);
        $body = $this->_body($file_name, basename(__FILE__, '.php'));


        //return array('title' => $this->_ret['title'], 'description' => $this->_ret['description'], 'body' => $body);
        return array('body' => $body);
    }

    public function urlModel($name, $brand, $type) {
      $brand = mb_strtolower($brand);
      return $this->translit($this->clearBrandLin($name, $brand, isset($this->_datas['typesBrandUrl'][$brand][$type]) ? $this->_datas['typesBrandUrl'][$brand][$type] : false));
    }

    public function clearBrandLin($model, $brand, $lin = false) {
      $lin = $lin !== false ? "|".$lin."[\s-]" : '';
      return preg_replace("/(".$brand."[\s-]".$lin.")/i", '', $model);
    }

    private function translit($string) {
      return mb_strtolower(preg_replace('/(\s+|\.)/', '-', $string));
    }

    private function sqlMarka($markaID) {
      $stmt = $this->dbh->prepare("SELECT * FROM `markas` WHERE `id`= ?");
      $stmt->execute([$markaID]);
      $this->_datas['marka'] = $stmt->fetch(\PDO::FETCH_ASSOC);

      $marka = $this->_datas['marka']['name'];
      if ($this->_datas['marka']['name'] == "LG") $this->_datas['marka']['ru_name'] = "LG";
      $marka_lower = mb_strtolower($this->_datas['marka']['name']);

      $stmt = $this->dbh->prepare("SELECT `model_types`.`name` as `type`, `model_types`.`id` as `type_id`,
             `model_types`.`name_re` as `type_re`, `model_types`.`name_rm` as `type_rm`,
              `model_types`.`name_m` as `type_m` FROM `marka_types` JOIN model_types ON marka_types.model_type_id = model_types.id WHERE marka_types.`marka_id`= ?");
      $stmt->execute([$markaID]);
      $this->_datas['all_devices'] = $stmt->fetchAll(\PDO::FETCH_ASSOC);

      foreach ($this->_datas['all_devices'] as $device) {
        $this->_datas['typeUrl'][$device['type']] = $this->_datas['markasTypesUrl'][$marka_lower][$device['type']];
      }

      $this->_datas['servicename'] = $marka.' '.$this->_datas['servicename'];
      $this->_datas['ru_servicename'] = $this->_datas['marka']['ru_name'].' '.$this->_datas['ru_servicename'];

	  if (isset($this->_datas['pb_mode'])) {
		$this->changePhone($this->_datas['pb_mode']);  
	  } else {
		$this->changePhone($this->_datas['site_name'].'/'.$this->_datas['site_in_url'].'/');
	  }
    }

    private function urlTypeMark() {
      foreach ($this->_datas['markaTypes'] as $marka => $types) {
        $marka_lower = strtolower($marka);
        $this->_datas['markasTypesUrl'][$marka_lower] = [];
        foreach ($types as $type) {
          if (isset($this->_datas['typesBrandUrl'][$marka_lower][$type])) {
            $this->_datas['markasTypesUrl'][$marka_lower][$type] = 'remont-'.$this->_datas['typesBrandUrl'][$marka_lower][$type];
          }
          else {
            $this->_datas['markasTypesUrl'][$marka_lower][$type] = 'remont-'.$this->_datas['typeUrl'][$type].'-'.$marka_lower;
          }
        }
      }
    }

    public function renderText($textArr) {
      $text = "";
      foreach ($textArr as $k=>$v) {
        $tag = $v[0];
        $t = $v[1];
        switch ($tag) {
          case 'h':
            $text .= "<span class=\"h2\">$t</span>";
          break;
          case 'ul':
            if (isset($t['before']))
              $text .= "<p>{$t['before']}</p>";
            if (isset($t['list'])) {
              $text .= '<ul class = "listUl">';
              foreach ($t['list'] as $li) {
                $text .= "<li>$li</li>";
              }
              $text .= '</ul>';
            }
            if (isset($t['after']))
              $text .= "<p>{$t['after']}</p>";
          break;
          case 'p':
            if (!is_array($t))
              $t = [$t];

            foreach ($t as $p) {
              $text .= "<p>$p</p>";
            }
          break;
        }
      }
      echo strtr($text, [
        '{brand}' => isset($this->_datas['marka']['name']) ? $this->_datas['marka']['name'] : '',
        '{time}' => $this->_datas['partner']['time'] ? mb_strtolower($this->_datas['partner']['time']) : 'без выходных, с 10-00 до 21-00',
        '{servicename}' => $this->_datas['servicename'],
      ]);
    }

    private function changePhone($site) {
		$stmt = pdo::getPdo()->query("SELECT * FROM sites WHERE name = '$site'");
		if ($stmt->rowCount() > 0) {
		  $site = $stmt->fetch(\PDO::FETCH_ASSOC);
		  if ($this->_datas['p_mode'] == 'YD' && trim($site['phone_yd']) != '')
			$this->_datas['phone'] = $site['phone_yd'];
		  else if ($this->_datas['p_mode'] == 'GA' && trim($site['phone_ga']) != '')
			$this->_datas['phone'] = $site['phone_ga'];
		  else
			$this->_datas['phone'] = $site['phone'];
		}
    }

}

?>
