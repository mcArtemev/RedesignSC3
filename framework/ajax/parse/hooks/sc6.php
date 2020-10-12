<?

namespace framework\ajax\parse\hooks;

use framework\tools;
use framework\pdo;
use framework\rand_it;

use framework\ajax\parse\hooks\pages\sc6\data\src\type_service;
use framework\ajax\parse\hooks\pages\sc6\data\src\defect_service;
use framework\ajax\parse\hooks\pages\sc6\data\src\service_service;
use framework\ajax\parse\hooks\pages\sc6\data\src\helpers6;

class sc6 extends sc
{

  private function prepareSeo() {
    $replace = [
      '[city]' => $this->_datas['region']['name_pe'],
      '[brand]' => $this->_datas['marka']['name'],
      '[nameru]' => $this->_datas['ru_servicename'],
    ];

    foreach (['title', 'h1', 'description', 'plain'] as $seon) {
      $this->_ret[$seon] = service_service::ucNames(strtr($this->_ret[$seon], $replace));
    }

    srand($this->_datas['feed']);

    $regexp = '/\{(.*)\}/';
    if (preg_match($regexp, $this->_ret['title'], $match)) {
      $arr = explode('|', $match[1]);
      $new = $arr[rand(0, count($arr)-1)];
      $this->_ret['title'] = str_replace($match[0], $new, $this->_ret['title']);
    }

    srand();
  }

  public function _sqlData($params)
  {
      $this->_datas = $this->_datas + $params;
      $this->_site_id = $params['site_id'];
      $this->_cache_mode = $params['cache_mode'];

      // устанавливаем режим

      if (isset($params['model_id']))
      {
          if (isset($params['key']))
              $this->_mode = 2;
          else
              $this->_mode = -2;
      }

      // dop
      $this->_datas['dop'] = sc::createDop($params['setka_id'], $params['feed']);

      // model
      if (isset($params['model_id']))
      {
          $sql = "SELECT models2.id as 'id', models2.name as 'name', model_type_id, marka_id FROM models2
          JOIN models2_to_setka ON models2.id = models2_to_setka.id_model
          JOIN model_type_to_markas ON models2.model_type_mark = model_type_to_markas.id
          WHERE models2.id = ? AND models2_to_setka.id_setka = 6";
          $stm = pdo::getPdo()->prepare($sql);
          $stm->execute(array($params['model_id']));
          $data = current($stm->fetchAll(\PDO::FETCH_ASSOC));

          $params['model_type_id'] = $data['model_type_id'];
          $params['marka_id'] = $data['marka_id'];

          $this->_datas['model'] = $data;

      }

      //service

      if (isset($params['6_service_id'])) {
        $service = service_service::getForId($params['6_service_id'], false);
        $params['model_type_id'] = $service['type_id'];

        $this->_datas['service'] = $service;
        if (!is_null($service['title']) && trim($service['title']) != '')
          $this->_ret['title'] = $service['title'];
        if (!is_null($service['h1']) && trim($service['h1']) != '')
          $this->_ret['h1'] = $service['h1'];
        if (!is_null($service['plain']) && trim($service['plain']) != '')
          $this->_ret['plain'] = service_service::strReplace($service['plain'], $this->_datas['feed']);
      }

      // defect

      if (isset($params['6_defect_id'])) {
        $defect = defect_service::getForId($params['6_defect_id'], false);
        $params['model_type_id'] = $defect['type_id'];

        srand($params['feed']);

        $this->_datas['defect'] = $defect;
        if (!is_null($defect['title']) && trim($defect['title']) != '') {
          $titles = explode('@', $defect['title']);
          $this->_ret['title'] = $titles[array_rand($titles)];
        }
        if (!is_null($defect['h1']) && trim($defect['h1']) != '') {
          $h1 = explode('@', $defect['h1']);
          $this->_ret['h1'] = $h1[array_rand($h1)];
        }
      }

      #if (!isset($params['model_type_id'])) {
      #  $params['model_type_id'] = 1;
      #}

      // marka

      if (!isset($params['marka_id'])) {
        $sql = "SELECT marka_id FROM marka_to_sites WHERE site_id = ?";
        $stm = pdo::getPdo()->prepare($sql);
        $stm->execute(array($this->_site_id));
        $params['marka_id'] = $stm->fetch()[0];
      }

      // type
      $sql = "SELECT * FROM `model_types` WHERE `id`= ?";
      $stm = pdo::getPdo()->prepare($sql);
      $stm->execute(array($params['model_type_id']));

      $m_type = current($stm->fetchAll(\PDO::FETCH_ASSOC));

      foreach (array('name', 'name_re', 'name_rm', 'name_de', 'name_dm', 'name_m') as $name)
      {
          if (!$m_type[$name.'_syn'])
             $m_type[$name.'_syn'] = $m_type[$name];
          else
             $this->_datas['orig_model_type'][1][$name] = $m_type[$name.'_syn'];

          $this->_datas['orig_model_type'][0][$name] = $m_type[$name];
      }

      $this->_datas['model_type'] = $m_type;

      // marka
      $sql = "SELECT * FROM `markas` WHERE `id`= ?";
      $stm = pdo::getPdo()->prepare($sql);
      $stm->execute(array($params['marka_id']));
      $this->_datas['marka'] = current($stm->fetchAll(\PDO::FETCH_ASSOC));

      $this->_datas['addresis'] = $this->_getAddresis($params['setka_id'], $this->_datas['marka']['id']);

      // vsemodeli
      /*$vsemodeli = array();
      $ru_vsemodeli = array();
      $vsemodeli_id = array();

      $sql = "SELECT `m_models`.`name` as `name`,`m_models`.`ru_name` as `ru_name`,
              `m_models`.`id` as `id` FROM `m_model_to_sites`
          INNER JOIN `sites` ON `sites`.`id`=`m_model_to_sites`.`site_id`
          INNER JOIN `m_models` ON `m_models`.`id`=`m_model_to_sites`.`m_model_id`
              WHERE `m_models`.`marka_id`= ? AND `m_models`.`brand` = 1 AND `m_model_to_sites`.`site_id` = ? AND `m_models`.`model_type_id` = ?";

      $stm = pdo::getPdo()->prepare($sql);
      $stm->execute(array($params['marka_id'], $params['site_id'], $params['model_type_id']));
      $data = $stm->fetchAll(\PDO::FETCH_ASSOC);

      foreach ($data as $value)
      {
          $vsemodeli[] = $value['name'];
          $ru_vsemodeli[] = $value['ru_name'];
          $vsemodeli_id[] = $value['id'];
      }

      $this->_datas['vsemodeli_array'] = $vsemodeli;
      $this->_datas['vsemodeli'] = implode(', ', $vsemodeli);
      $this->_datas['ru_vsemodeli'] = implode(', ', $ru_vsemodeli);
      $this->_datas['vsemodeli_id'] = $vsemodeli_id;*/

      // others
      /*$this->_datas['suffics'] = $suffics = $this->_suffics = tools::get_suffics($this->_datas['model_type']['name']);

      // img
      $sql = "SELECT `url` FROM `imgs` WHERE `site_id` = ? AND `marka_id`= ? AND `model_type_id` = ?";
      $stm = pdo::getPdo()->prepare($sql);
      $stm->execute(array($this->_site_id, $params['marka_id'], $params['model_type_id']));
      $this->_datas['img']  = $stm->fetchColumn();

      // eds
      $table_cost = $suffics.'_service_costs';
      $j_field = $suffics.'_service_id';

      $this->_datas['eds'] = array();

      $sql = "SELECT `{$j_field}`, `ed_time`, `ed_garantee` FROM `{$table_cost}` WHERE `setka_id`=:setka_id";
      $stm = pdo::getPdo()->prepare($sql);
      $stm->execute(array('setka_id' => $this->_datas['setka_id']));
      foreach ($stm->fetchAll(\PDO::FETCH_ASSOC) as $ed)
          $this->_datas['eds'][$ed[$j_field]] = $ed;

      $eds = $this->_datas['eds'];

      // availables
      $this->_datas['availables'] = $availables = tools::get_base('', 'availables');

       //max_amount
      $this->_datas['max_amount'] = 0;
      $table_amount = $suffics.'_complect_amounts';

      if (pdo::getPdo()->query("SHOW TABLES LIKE '$table_amount'")->rowCount())
      {
          $sql = "SELECT `max_amount` FROM `{$table_amount}` WHERE `setka_id`=:setka_id";
          $stm = pdo::getPdo()->prepare($sql);
          $stm->execute(array('setka_id' => $this->_datas['setka_id']));
          $this->_datas['max_amount'] = $stm->fetchColumn();
      }

      if ($this->_mode > 0)
      {
          $syns = $this->_get_syns($params['key'], array($params['id']));
          $syns_ar = array();

          foreach ($syns as $syn)
          {
              $key = (integer) $syn['type'];
              $this->_datas['syns'][$key] = $syn['name'];
              $syns_ar[$key] = $syn;
          }

          // model_types_syns
          $t = array();
          foreach ($syns_ar as $key => $value)
          {
              if ($value['word'])
                  $ar = array(
                      'name' => $this->_datas['model_type']['name_syn'],
                      'name_re' => $this->_datas['model_type']['name_re_syn'],
                      'name_rm' => $this->_datas['model_type']['name_rm_syn'],
                      'name_m' => $this->_datas['model_type']['name_m_syn'],
                      );
              else
                  $ar = array(
                      'name' => $this->_datas['model_type']['name'],
                      'name_re' => $this->_datas['model_type']['name_re'],
                      'name_rm' => $this->_datas['model_type']['name_rm'],
                      'name_m' => $this->_datas['model_type']['name_m'],
                      );
              $t[$key] = $ar;
          }

          $this->_datas['model_type'] = array('id' => $this->_datas['model_type']['id']) + $t;

          $this->_datas['vals'] = $vals = current($this->_get_vals($params['key'], array($this->_datas['id'])));

          switch ($params['key'])
          {
              case 'complect':
                  $this->_datas['amount'] = $this->_datas['vals']['amount'];
                  $this->_datas['price'] = $this->_datas['vals']['price'];
                  $this->_datas['available'] = isset($availables[$vals['available_id']]['name']) ? $availables[$vals['available_id']]['name'] : array();

                  $this->_datas['services_to_complect'] = $this->_find('service', 'complect', $this->_datas['id']);
                  $this->_datas['dop_services'] = $this->_get_vals('service', unserialize($vals['dop_services']));
                  $this->_datas['other_complects'] = $this->_get_vals('complect', unserialize($vals['other_complects']));

              break;
              case 'service':
                  if (isset($this->_datas['vals']['price']))
                      $this->_datas['price'] = $this->_datas['vals']['price'];

                  if (isset($this->_datas['vals']['time_min']))
                      $this->_datas['time'] = $this->_datas['vals']['time_min'];

                  $this->_datas['complect_to_services'] = $this->_find('complect', 'service', $this->_datas['id']);

                  if (isset($vals['dop_defects']))
                      if ($dop_defects = unserialize($vals['dop_defects']))
                          $this->_datas['dop_defects'] = $this->_get_vals('defect', $dop_defects);

                  if (isset($vals['other_services']))
                      if ($other_services = unserialize($vals['other_services']))
                          $this->_datas['other_services'] = $this->_get_vals('service', $other_services);
              break;
              case 'defect':
                  $reasons_table = $this->_suffics.'_defect_reasons';
                  $sql = "SELECT `name` FROM `{$reasons_table}` WHERE `id` IN (".implode(",", unserialize($vals['dop_reasons'])).")";
                  $this->_datas['dop_reasons'] = pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_COLUMN);

                  $this->_datas['dop_services'] = $this->_get_vals('service', unserialize($vals['dop_services']));
                  $this->_datas['other_defects'] = $this->_get_vals('defect', unserialize($vals['other_defects']));

                  $prices = array();
                  $times = array();

                  foreach ($this->_datas['dop_services'] as $value)
                  {
                      $prices[] = $value['price'];
                      $times[] = $value['time_min'];
                  }

                  $this->_datas['price'] = min($prices);
                  $this->_datas['time'] = min($times);
              break;
          }
      }
      else
      {
          $table_mas = tools::get_codes($suffics);

          foreach ($table_mas as $key => $mas)
          {
              if ($key == 'defect') continue;

              $ids = array();
              foreach ($mas as $value)
                  $ids[] = $value['id'];

              if ($key == 'service')
              {
                  $this->_datas['all_services'] = rand_it::randMas($this->_get_vals($key, $ids), count($ids), '', $params['feed']);

                  $prices = array();
                  $times = array();

                  foreach ($this->_datas['all_services'] as $value)
                  {
                      if ($value['price'] > 100) $prices[] = $value['price'];
                      $times[] = $value['time_min'];
                  }

                  if ($prices) $this->_datas['price'] = min($prices);
                  if ($times) $this->_datas['time'] = min($times);
              }

              if ($key == 'complect')
              {
                  $this->_datas['all_complects'] = rand_it::randMas($this->_get_vals($key, $ids), count($ids), '', $params['feed']);
              }
          }

          srand($params['feed']);

          $t = array();
          for ($i=0; $i<4; $i++)
          {
              if (rand(0, 1))
              {
                  $ar = array(
                      'name' => $this->_datas['model_type']['name_syn'],
                      'name_re' => $this->_datas['model_type']['name_re_syn'],
                      'name_rm' => $this->_datas['model_type']['name_rm_syn'],
                      'name_m' => $this->_datas['model_type']['name_m_syn'],
                  );
              }
              else
              {
                  $ar = array(
                      'name' => $this->_datas['model_type']['name'],
                      'name_re' => $this->_datas['model_type']['name_re'],
                      'name_rm' => $this->_datas['model_type']['name_rm'],
                      'name_m' => $this->_datas['model_type']['name_m']
                  );
              }

              $t[$i] = $ar;
          }
          $this->_datas['model_type'] = array('id' => $this->_datas['model_type']['id']) + $t;

          if ($this->_mode == -1 || $this->_mode == -3)
          {
              if (isset($this->_datas['all_models']))
              {
                  $this->_datas['popular_models'] = rand_it::randMas($this->_datas['all_models'], count($this->_datas['all_models']), '', $params['feed']);

                  $t = array();
                  foreach ($this->_datas['popular_models'] as $key => $model)
                      $t[$model['m_model_name']] = $key;

                  foreach ($t as $value)
                      $this->_datas['popular_m_models'][] = $this->_datas['popular_models'][$value];
              }
          }
      }
      //print_r($this->_datas);*/
  }

    public function generate($answer, $params)
    {
        //см sc-1..5, запрос исправлен
        $sql =  "SELECT `model_types`.`name` as `type`, `model_types`.`id` as `type_id`,
                `model_types`.`name_m` as `type_m`,`model_types`.`name_rm` as `type_rm`,
                `model_types`.`name_re` as `type_re` FROM `marka_to_sites`
            LEFT JOIN `model_type_to_markas` ON `marka_to_sites`.`marka_id`= `model_type_to_markas`.`marka_id`
            INNER JOIN `model_types` ON `model_type_to_markas`.`model_type_id` = `model_types`.`id`
            WHERE `marka_to_sites`.`site_id`= ? GROUP BY `model_types`.`name` ORDER BY `model_types`.`id`";

        $stm = pdo::getPdo()->prepare($sql);
        $stm->execute(array($params['site_id']));
        $this->_datas['all_devices'] = $stm->fetchAll(\PDO::FETCH_ASSOC);

        // region
        $this->_datas['region'] = $this->_getRegion($params['region_id']);
        $city = $this->_datas['region']['name_pe'];
        $city_d = $this->_datas['region']['name_de'];
        $city_r = $this->_datas['region']['name_re'];
//
        // device_types
        $sql = "SELECT name FROM urls WHERE site_id = :site_id";

        $stm = pdo::getPdo()->prepare($sql);
        $stm->execute(array(':site_id' => $params['site_id']));
        $this->_datas['site_urls'] = array_column($stm->fetchAll(\PDO::FETCH_ASSOC), 'name');

        $this->_datas['types_urls'] = array( 
            'ноутбук' => 'remont_noutbukov', 
            'планшет' => 'remont_planshetov', 
            'смартфон' => 'remont_smartfonov', 
            'моноблок' => 'remont_monoblokov', 
            'компьютер' => 'remont_kompyuterov', 
            'сервер' => 'remont_serverov', 
            'телевизор' => 'remont_televizorov', 
            'холодильник' => 'remont_kholodilnikov',
            'монитор' => 'remont_monitorov', 
            'проектор' => 'remont_proyektorov', 
            'телефон' => 'remont_telefonov', 
            'принтер' => 'remont_printerov', 
            'электронная книга' => 'remont_elektronnykh_knig', 
            'фотоаппарат' => 'remont_fotoapparatov', 
            'игровая приставка' => 'remont_igrovykh_pristavok',
            'кофемашина' =>'remont_kofemashin',
            
            'пылесос'=> 'remont_pylesosov',
            'варочная панель'=> 'remont_varochnyh_panelej',
            'микроволновая печь'=> 'remont_mikrovolnovyh_pechej',
            'кондиционер'=> 'remont_kondicionerov',
            'робот-пылесос'=> 'remont_robotov-pylesosov',
            'домашний кинотеатр'=> 'remont_domashnih_kinoteatrov',
            'хлебопечка'=> 'remont_hlebopechek',
            'морозильник'=> 'remont_morozilnikov',
            'посудомоечная машина'=> 'remont_posudomoechnyh_mashin',
            'духовой шкаф'=> 'remont_duhovyh_shkafov',
            'смарт-часы'=> 'remont_smart-chasov',
            'вытяжка'=> 'remont_vytyazhek',
            'видеокамера'=> 'remont_videokamer',
            'массажное кресло'=> 'remont_massazhnyh_kresel',
            'стиральная машина'=>'remont_stiralnayh_mashin',
            'водонагреватель'=>'remont_vodonagrevatelej',
            'квадрокоптер'=>'remont_kvadrokopterov',
            'плоттер'=>'remont_plotterov',
            'гироскутер'=>'remont_giroskuterov',
            'электросамокат'=> 'remont_elektrosamokatov',
            'моноколесо' => 'remont_monokoles',
            'сегвей' => 'remont_segveev',
            'сушильная машина'=> 'remont_sushilnyh_mashin',
            'лазерный принтер'=>'remont_lazernyh_printerov',
            'наушники'=>'remont_naushnikov',
            );

        $this->_datas['types_photos'] = array(
            'ноутбук' => 'noutbuk',
            'планшет' => 'planshet',
            'смартфон' => 'telefon',
            'моноблок' => 'monoblok',
            'компьютер' => 'komputer',
            'сервер' => 'server',
            'телевизор' => 'televizor',
            'холодильник' => 'kholodilnik',
            'монитор' => 'monitor',
            'проектор' => 'proektor',
            'телефон' => 'telefon',
            'принтер' => 'printer',
            'электронная книга' => 'elektronnaya_kniga',
            'фотоаппарат' => 'fotoapparat', 
            'игровая приставка' => 'igrovaya_pristavka',
            'кофемашина' =>'kofemashina',
            
            'пылесос'=>'pylesos',
            'варочная панель'=> 'varochnaya_panel',
            'микроволновая печь'=> 'mikrovolnovaya_pech',
            'кондиционер'=> 'kondicioner',
            'робот-пылесос'=>'robot-pylesos',
            'домашний кинотеатр'=> 'domashnij_kinoteatr',
            'хлебопечка'=> 'hlebopechka',
            'морозильник'=>'morozilnik',
            'посудомоечная машина'=> 'posudomoechnaya_mashina',
            'духовой шкаф'=>'duhovoj_shkaf',
            'смарт-часы'=> 'smart-chasy',
            'вытяжка'=> 'vytyazhka',
            'видеокамера'=>'videokamera',
            'массажное кресло'=> 'massazhnoe_kreslo',
            'стиральная машина'=>'stiralnaya_mashina',
            'водонагреватель'=>'vodonagrevatel',
            'квадрокоптер'=>'kvadrokopter',
            'плоттер'=>'plotter',
            'гироскутер'=>'giroskuter',
            'электросамокат'=>'elektrosamokat',
            'моноколесо'=>'monokoleso',
            'сегвей' => 'segvej',
            'сушильная машина'=> 'sushilnaya_mashina',
            'лазерный принтер'=>'lazernyj_printer',
            'наушники'=>'naushniki',
            );

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

                $marka_lower = mb_strtolower($this->_datas['marka']['name']);

                $marka = $this->_datas['marka']['name'];  // SONY
                $region_name_pe = $this->_datas['region']['name_pe'];//в Москве (в Владивостоке)
                $ru_marka = $this->_datas['marka']['ru_name']; // СОНИ
                $servicename = $this->_datas['servicename']; //SONY Russia
                $region_name_pril = $this->_datas['region']['pril'];//Московском
                srand($feed);
                switch ($file_name)
            	{
            		case 'index':
                        $ustroista_all = "";
                        foreach ($this->_datas['all_devices'] as $item)
                        {
                            $ustroista_all .= $item['type_rm'] . ", ";
                        }
                        $ustroista_all = substr($ustroista_all,0,-2);
                        $description = array();
                        $description[] = array("Ремонт","Ремонт и восстановление");
                        $description[] = array($ustroista_all);
                        $description[] = array("$marka");
                        $description[] = array("в $region_name_pe -");
                        $description[] = array("ремонт любой сложности: от","любой ремонт: от");
                        $description[] = array("чистки","ремонта корпусов","ремонта динамиков","ремонта разъемов","ремонта портов","ремонта шлейфов","ремонта кнопок","ремонта гнезд питания",
                            "ремонта разъемов питания","ремонта разъемов зарядки","ремонта гнезда питания","ремонта гнезда зарядки");
                        $description[] = array("до");
                        $description[] = array("замены плат.","замены элементов плат.","замены системных плат.","замены мультиконтроллеров.","замены контроллеров.","замены контроллеров плат.","замены ШИМ-контроллеров.",
                            "замены PWM-контроллеров.","замены чипов.","перепайки цепей питания.","перепайки цепей питания плат.","перепайки чипов.","перепайки BGA-чипов.","перепайки мультиконтроллеров.",
                            "перепайки контроллеров.","перепайки контроллеров плат.","перепайки ШИМ-контроллеров.","перепайки PWM-контроллеров.","реболла чипов.","реболла BGA-чипов.");
                        $description[] = array("Бесплатные консультации.","Профессиональные консультации.","Бесплатные телефонные консультации.","Профессиональные телефонные консультации.");
                        $description[] = array("Запись на ремонт.","Онлайн запись на ремонт.","Online запись на ремонт.");

            			$title = "Ремонт ".$marka." в " . $region_name_pe." | сеть сервис центров " . $servicename;
            			$description = $this->checkarray($description);
            			$h1 = '';
            		break;
                    case 'uslugi':
                        $title = [
                          ['Популярные услуги оказываемые'],
                          ['сервисным центром','сервис центром','сервисом'],
                          [$this->_datas['servicename'].' в '.$this->_datas['region']['name_pe']],
                        ];
                        $title = self::_createTree($title, $feed);

                        $typeList = array_column($this->_datas['all_devices'], 'type_rm');
                        helpers6::shuffle($typeList, 0, $feed);
                        $typeList = implode(', ', $typeList);
                        $description = 'Популярные ремонтные услуги '.$typeList.' '.$this->_datas['marka']['name'].'.';
                        $h1 = "";
                    break;
                    case 'komplektuyshie':

                      $title = [
                        ['Комплектующие','Запасные части'],
                        ['для'],
                        ['устройств','гаджетов','аппаратов'],
                        [$this->_datas['marka']['name'].' в '.$this->_datas['region']['name_pe']],
                      ];
                      $title = self::_createTree($title, $feed);

                      $typeList = array_column($this->_datas['all_devices'], 'type_rm');
                      helpers6::shuffle($typeList, 0, $feed);
                      $typeList = implode(', ', $typeList).'.';

                      $desc = [
                        ['Комплектующие','Запасные части'],
                        ['используемые в'],
                        ['сервисном центре','сервисе','сервис центре'],
                        [$this->_datas['servicename'].' для '.$typeList],
                      ];

                        $h1 = "";

                        $description = sc::_createTree($desc, $feed);
                        break;
                    case 'neispravnosti':
                        $title = [
                          ['Часто встречаемые'],
                          ['неисправности','дефекты','поломки'],
                          ['устройств','гаджетов','аппаратов'],
                          [$this->_datas['marka']['name']],
                        ];
                        $title = self::_createTree($title, $feed);

                        $typeList = array_column($this->_datas['all_devices'], 'type_rm');
                        helpers6::shuffle($typeList, 0, $feed);
                        $typeList = implode(', ', $typeList);
                        $desc = [
                          ['Часто встречаемые'],
                          ['поломки:','дефекты:','неисправности:'],
                          [$typeList.' '.$this->_datas['marka']['name'].'.'],
                        ];

                        $h1 = "";
                        $description = sc::_createTree($desc, $feed);
                        break;
                    case 'price_list':
                      $title = "Цены на услуги RuExpert $marka в $region_name_pe";

                      $typeList = array_column($this->_datas['all_devices'], 'type_rm');
                      helpers6::shuffle($typeList, 0, $feed);
                      $typeList = implode(', ', $typeList);
                      $desc = [
                        ['Стоимость ремонта:', 'Цены на ремонт'],
                        [$typeList],
                        ['в сервисном центре','в сервис центре','в сервисе'],
                        [$this->_datas['servicename'].'.'],
                      ];

                        $description = self::_createTree($desc, $feed);
                        $h1 = "";
                        break;
                    case 'akciya':
                        $akciyaa = array();
                        $akciyaa[] = array("Акции компании ".$this->_datas['servicename']." в $region_name_pe. Заказывайте ремонт");
                        $akciyaa[] = array("со скидкой!","выгодно!","с выгодой!");

                        $title = "Акции RuExpert $marka в $region_name_pe";
                        $description = $this->checkarray($akciyaa);
                        $h1 = "";
                        break;
                    case 'informaciya':
                        $title = "Контактная информация ".$this->_datas['servicename']." в $region_name_pe";
                        $desc = [
                          ['Контактные данные'],
                          ['сервисного центра','сервиса','сервис центра'],
                          [$this->_datas['servicename'].'.'],
                          ['Номер телефона: '.tools::format_phone($this->_datas['phone']).', находится по адресу '.$this->_datas['partner']['address1'].', время работы: '.(!$this->_datas['partner']['time'] ? 'Пн-Вс, с 9:00 до 18:00' : $this->_datas['partner']['time']).'.'],
                        ];
                        $description = self::_createTree($desc, $feed);
                        $h1 = "";
                        break;
                    case 'o_kompanii':
                        $title = "Информация о компании ".$this->_datas['servicename']." в $region_name_pe";
                        $description = "О компании ".$this->_datas['servicename'].". Достижения и статистика работы.";
                        $h1 = "";
                        break;
                    case 'remont':
                    case 'vremya_remonta':
                        $title = "Время ремонта техники в RuExpert $marka в $region_name_pe";
                        $description = "Средние сроки различного ремонта устройств  $marka в RuExpert. Оценка основанная на опыте и статистики предыдущих ремонтов.";
                        $h1 = "";
                        break;
                    /*case 'vremya_remonta':
                        $title = "Срочный ремонт $marka в RuExpert в $region_name_pe";
                        $description = "Условия срочного ремонта, обслуживания и диагностики техники $marka в RuExpert. Стоимость, время, гарантии сервисного центра в $region_name_pe.";
                        $h1 = "";
                        break;*/
                    case 'diagnostika':
                        $title = [
                          ['Бесплатная диагностика','Бесплатное тестирование','Бесплатная комплексная диагностика'],
                          [$this->_datas['marka']['name'].' в '.$this->_datas['region']['name_pe']],
                          ['|'],
                          ['сервисный центр','сервис центр','сервис'],
                          [$this->_datas['ru_servicename']],
                        ];
                        $title = self::_createTree($title, $feed);

                        $description = "Условия проведения программной и аппаратной диагностики с разборкой аппарата и без разборки в $region_name_pril центре ".$this->_datas['servicename'].".";
                        $h1 = "";
                        break;
                    case 'vakansii':
                        $title = "Вакансии центра $marka RuExpert в $region_name_pe";
                        $description = "Открытые вакансии сервисного центра $marka RuExpert в $region_name_pe. Интересует работа в дружном, активном коллективе? Звоните!";
                        $h1 = "";
                        break;
                    case 'dostavka':
                        $title = "Доставка техники $marka по $region_name_pe от RuExpert";
                        $description = "Условия доставки в сервис и на дом сломанных и отремантированных устройств $marka по $region_name_pe от RuExpert.";
                        $h1 = "";
                        break;
                    case 'otzivy':
                        $title = "Отзывы клиентов центра $marka RuExpert в $region_name_pe";
                        $description = "Отзывы довольных клиентов сервисного центра $marka RuExpert в $region_name_pe. Отзывы недовольных клиентов мы не публикуем, мнение неадекватов можете искать в интернете.";
                        $h1 = "";
                        break;
                }

                srand();
                $this->_datas['addresis'] = $this->_getAddresis($params['setka_id'], $this->_datas['marka']['id']);

                $this->_ret['title'] = $title;
                $this->_ret['h1'] = $h1;
                $this->_ret['description'] = $description;
                
                $this->_sdek();

                $body = $this->_body($file_name, basename(__FILE__, '.php'));
                return array('body' => $body);
            }
        }
        
        $this->_sqlData($params);
        
        $feed = $this->_datas['feed'] = (isset($this->_datas['vals']['feed']) ? $this->_datas['vals']['feed'] : $this->_datas['feed']);

        if (isset($params['marka_id']) && isset($params['model_type_id'])) {
            $file_name = 'type';

            $feed = isset($this->_datas['vals']['feed']) ? $this->_datas['vals']['feed'] : $this->_datas['feed'];

            $cBrand = $this->_datas['marka']['name'];
            $cBrandRu = $this->_datas['marka']['ru_name'];
            $cModel = $this->_datas['orig_model_type'][0]['name'];
            $cModelRm = $this->_datas['orig_model_type'][0]['name_rm'];
            $vCity = $this->_datas['region']['name_pe'];
            $nameRuSC = $this->_datas['ru_servicename'];
            $nameSC = $this->_datas['servicename'];

            $title = [
              ['Ремонт '.$cModelRm.' '.$cBrand.' в '.$vCity],
              ['|'],
              ['сервис', 'сервисный центр'],
              [$nameRuSC],
            ];
            $title = sc::_createTree($title, $feed);

            $h1 = 'Ремонт '.$cModelRm.' '.$cBrand;/* .'  ('.$cBrandRu.')' */
            $hService = 'Услуги по ремонту '.$cModelRm.' '.$cBrand;

            $description = [
              ['Ремонт '.$cModelRm.' '.$cBrandRu.' ('.$cBrand.') в '],
              ['лаборатории','техцентре','сервисе','сервисном центре'],
              [' c бесплатной'],
              ['диагностикой,','полной диагностикой,','полным тестированием,'],
              ['гарантией, оригинальными'],
              ['комплектующими','запасными частями','запчастями'],
              ['и низкой стоимостью в '.$vCity],
            ];
            $description = sc::_createTree($description, $feed);
            
                
            $plain = [
            //   ['Если ваш '.$cModel.' перестал работать так, как вам нужно,'],
            //   ['не затягивайте', 'не тяните'],
            //   ['с обращением в сервисный центр.', 'с посещением сервисного центра.'],
              
              
              
            //   //['Как говорят'],
            //   //['специалисты', 'мастера', 'инженеры'],
            //   //['по электронике, главная причина'],
            //   //['поломки', 'неисправности'],
            //   //['находится по ту сторону'],
            ];

            // if (in_array($cModel, ['ноутбук', 'моноблок']))
            //   $plain[] = ['монитора.'];
            // else if (in_array($cModel, ['телефон', 'планшет']))
            //   $plain[] = ['дисплея.'];
            // else
            //   $plain[] = ['корпуса.'];

            $plain = array_merge($plain, [
              ['Что бы ни привело к'],
              ['неисправности,', 'поломке'],
              ['профессиональный ремонт вернет ваш '.$cBrandRu],
              ['в прежнее функциональное состояние.', 'в полностью функциональное состояние.'],
              ['Специалисты нашего центра знают, как найти подход к любой модели!']
            ]);
            $plain = sc::_createTree($plain, $feed);

            srand();
            $this->_datas['addresis'] = $this->_getAddresis($params['setka_id'], $this->_datas['marka']['id']);

            $this->_ret['title'] = $title;
            $this->_ret['h1'] = $h1;
            $this->_ret['hService'] = $hService;
            $this->_ret['description'] = $description;
            $this->_ret['plain'] = $plain;

            $this->_ret['params'] = $params;

            $this->_sdek();
            $body = $this->_body($file_name, basename(__FILE__, '.php'));
           
            return array('body' => $body);
        }
        else if (isset($params['model_id'])) {

            $file_name = 'model';

            $dbh = pdo::getPdo();
            $stmt = $dbh->prepare("SELECT id, name, name_ru FROM models2 WHERE id = ?");
            $stmt->execute([$params['model_id']]);

            $model = $stmt->fetch(\PDO::FETCH_ASSOC);

            //$model = modelService::getForId($this->_datas['model_id']);

            srand();

            $fullName = $this->_datas['marka']['name'].' '.$model['name'];
            $remontModel = 'Ремонт '.$this->_datas['model_type']['name_re'].' '.$fullName;

            $title = [
              [$remontModel.' в '.$this->_datas['region']['name_pe'].' |'],
              ['сервис', 'сервисный центр'],
              [$this->_datas['ru_servicename']],
              //[implode(', ', rand_it::randMas(['цена','выезд'], 2, '', $feed))],
            ];
            $title = sc::_createTree($title, $feed);

            $h1 = $remontModel;
            $description = [
              [$remontModel.' в '],
              ['лаборатории','техцентре','сервисе','сервисном центре'],
              ['с бесплатной'],
              ['диагностикой','полной диагностикой,','полным тестированием,'],
              ['гарантией, оригинальными '],
              ['комплектующими','запасными частями','запчастями'],
              ['и низкой стоимостью в '.$this->_datas['region']['name_pe']],
            ];
            $description = sc::_createTree($description, $feed);

            $easyPlain = rand_it::randMas([['легко','без труда'],['быстро','своевременно']], 2, [], $feed);
            $plain = [
              ['Нужен'],
              ['срочный','быстрый','экспресс'],
              ['ремонт вашего '.$this->_datas['model_type']['name_re'].'?'],

              //['Как говорят'],
              //['специалисты', 'мастера', 'инженеры'],
              //['по электронике, главная причина'],
              //['поломки', 'неисправности'],
              //['находится по ту сторону'],

              ['Если'],
              ['у вас','вы обладатель'],
              ['– '.$fullName.', то вы обратились по адресу!'],

              ['Наш'],
              ['Сервисный центр','Сервис','Сервис центр'],
              ['– это то место, где'],
              ['мастера','специалисты'],
              $easyPlain[0],
              ['и'],
              $easyPlain[1],
              ['устраняют','исправят'],
              ['любую'],
              ['неисправность','поломку'],
              [$this->_datas['model_type']['name_re'].' '.$this->_datas['marka']['name'].'.'],

              ['Записывайтесь на обслуживание устройства, диагостику проведем бесплатно!'],
            ];
            $plain = sc::_createTree($plain, $feed);

            $this->_ret['title'] = $title;
            $this->_ret['h1'] = $h1;
            $this->_ret['description'] = $description;
            $this->_ret['plain'] = $plain;

            $this->_ret['model'] = $model;
            $this->_ret['fullName'] = $fullName;

            $this->_ret['params'] = $params;

            $this->_sdek();
            $body = $this->_body($file_name, basename(__FILE__, '.php'));
            
            return array('body' => $body);
        }
        else if (isset($params['6_service_id'])) {

          $file_name = 'service';

          $serviceName = $this->_datas['service']['names'];
          $typeRE = $this->_datas['model_type']['name_re'];
          $marka = $this->_datas['marka']['name'];
          $cityPE = $this->_datas['region']['name_pe'];
          $nameSC = $this->_datas['servicename'];
          $nameRuSC = $this->_datas['ru_servicename'];
          $cityPril = $this->_datas['region']['pril'];

          $title = [
            $serviceName,
            [$typeRE.' '.$marka.' в '.$cityPE.' | '.$nameRuSC],
          ];
          $title = sc::_createTree($title, $feed);

          $h1 = [
            $serviceName,
            [$typeRE.' '.$marka],
          ];
          $h1 = sc::_createTree($h1, $feed);

          $description = [
            $serviceName,
            [$typeRE.' '.$marka.' в '.$cityPril],
            ['техцентре','сервисе','сервисном центре'],
            [$nameSC.'.'],
          ];
          $description = sc::_createTree($description, $feed);

          srand($feed);
          if (rand(0,1)) {
            if ($this->_datas['model_type']['name'] == 'холодильник')
              $gadget = [$this->_datas['model_type']['name']];
            else
              $gadget = ['гаджет', 'аппарат'];

            $plainGadget = [
              ['Если перестал работать ваш'],
              $gadget,
              ['или заметили, что он стал хуже работать, не спешите идти в магазин за новым!']
            ];
          }
          else {
            $plainGadget = [
              ['Если перестало работать ваше устройство или заметили, что оно стало хуже работать, не спешите идти в магазин за новым!'],
            ];
          }
          $plain = array_merge(
            [
              ['Даже самый аккуратный пользователь не застрахован от сбоев в работе '.$typeRE.'.'],
            ],
            $plainGadget,
            [
              ['Обращайтесь в наш Сервисный центр и поручите '.helpers6::skl(tools::get_rand($serviceName, $feed), 'v').' нашим'],
              ['специалистам.','мастерам.','инженерам.'],
              ['Мы знаем устройство '.$marka.' как свои пять пальцев и исправим любую'],
              ['неисправность!','неполадку!','поломку!'],
            ]
          );
          $plain = sc::_createTree($plain, $feed);

          if (!isset($this->_ret['title'])) $this->_ret['title'] = $title;
          if (!isset($this->_ret['h1'])) $this->_ret['h1'] = $h1;
          if (!isset($this->_ret['description'])) $this->_ret['description'] = $description;
          if (!isset($this->_ret['plain'])) $this->_ret['plain'] = $plain;

          $this->_ret['params'] = $params;
          $this->prepareSeo();

          $this->_sdek();
          $body = $this->_body($file_name, basename(__FILE__, '.php'));
         
          return array('body' => $body);
        }
        else if (isset($params['6_defect_id'])) {
          $file_name = 'defect';

          $title = [
            [$this->_datas['defect']['name'].' '.$this->_datas['marka']['name'].', '.'почему и что делать |'],
            ['сервис','сервисный центр'],
            [$this->_datas['ru_servicename']],
          ];
          $title = self::_createTree($title, $feed);

          $h1 = $this->_datas['defect']['name'].' '.$this->_datas['marka']['name'];

          $description = [
            ['Сервисный центр','Сервис'],
            [$this->_datas['model_type']['name_rm'].' '.$this->_datas['servicename'].'. Ремонт типовых неисправностей: '.$this->_datas['defect']['name']],
          ];
          $description = self::_createTree($description, $feed);

          $plain = 'plain';

          if (!isset($this->_ret['title'])) $this->_ret['title'] = $title;
          if (!isset($this->_ret['h1'])) $this->_ret['h1'] = $h1;
          if (!isset($this->_ret['description'])) $this->_ret['description'] = $description;
          if (!isset($this->_ret['plain'])) $this->_ret['plain'] = $plain;

          $this->_ret['params'] = $params;
          $this->prepareSeo();
          $this->_sdek();
          $body = $this->_body($file_name, basename(__FILE__, '.php'));
        
          return array('body' => $body);
        }
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
                $this->_datas['zoom'] = 10;
            }
        }
        return;
        
        $this->_datas['sdek'] = false;
        if ($this->_datas['partner']['email'] == 'litovchenko@list.ru')
        {
            $this->_datas['phone'] = '78002005089';
            $this->_datas['partner']['exclude'] = 1;  
            $this->_datas['partner']['time']  = 'Пн-Вс, с 10:00 до 20:00';
            $this->_datas['sdek'] = true; 
        } 
    }
}
;
